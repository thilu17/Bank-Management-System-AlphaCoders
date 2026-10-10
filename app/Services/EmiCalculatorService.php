<?php

namespace App\Services;

use App\Models\LoanModel;
use App\Models\LoanProductModel;
use App\Models\LoanRepaymentScheduleModel;

class EmiCalculatorService
{
    /**
     * Compute full Amortization Breakdown and EMI values
     */
    public static function calculateAmortization(
        float $principal,
        float $annualRate,
        int $tenureMonths,
        string $interestType = 'compound',
        ?string $startDate = null
    ): array {
        if ($tenureMonths <= 0 || $principal <= 0) {
            return [
                'emi'            => 0,
                'total_payable'  => 0,
                'total_interest' => 0,
                'schedule'       => [],
            ];
        }

        $startDate = $startDate ? new \DateTime($startDate) : new \DateTime();

        $schedule = [];
        $openingBalance = $principal;
        $totalInterestAccumulated = 0;

        if ($interestType === 'simple') {
            // Simple flat interest
            $totalInterest = $principal * ($annualRate / 100) * ($tenureMonths / 12);
            $totalPayable  = $principal + $totalInterest;
            $monthlyEmi    = round($totalPayable / $tenureMonths, 2);
            $monthlyPrincipal = round($principal / $tenureMonths, 2);
            $monthlyInterest  = round($totalInterest / $tenureMonths, 2);

            for ($m = 1; $m <= $tenureMonths; $m++) {
                $dueDate = clone $startDate;
                $dueDate->modify("+{$m} month");

                $principalComp = ($m === $tenureMonths) ? $openingBalance : $monthlyPrincipal;
                $interestComp  = $monthlyInterest;
                $currentEmi    = $principalComp + $interestComp;
                $closingBalance = max(0, round($openingBalance - $principalComp, 2));

                $schedule[] = [
                    'installment_no'      => $m,
                    'due_date'            => $dueDate->format('Y-m-d'),
                    'opening_balance'     => round($openingBalance, 2),
                    'principal_component' => round($principalComp, 2),
                    'interest_component'  => round($interestComp, 2),
                    'emi_amount'          => round($currentEmi, 2),
                    'closing_balance'     => $closingBalance,
                    'status'              => 'Unpaid',
                ];

                $totalInterestAccumulated += $interestComp;
                $openingBalance = $closingBalance;
            }

            return [
                'emi'            => $monthlyEmi,
                'total_payable'  => round($totalPayable, 2),
                'total_interest' => round($totalInterest, 2),
                'schedule'       => $schedule,
            ];
        }

        // Standard Reducing Balance (Compound EMI) Formula:
        // EMI = P * r * (1+r)^n / ((1+r)^n - 1)
        $r = ($annualRate / 12) / 100;
        if ($r > 0) {
            $emi = ($principal * $r * pow(1 + $r, $tenureMonths)) / (pow(1 + $r, $tenureMonths) - 1);
        } else {
            $emi = $principal / $tenureMonths;
        }

        $emi = round($emi, 2);

        for ($m = 1; $m <= $tenureMonths; $m++) {
            $dueDate = clone $startDate;
            $dueDate->modify("+{$m} month");

            $interestComp = round($openingBalance * $r, 2);

            if ($m === $tenureMonths) {
                // Final month exact adjustment
                $principalComp = $openingBalance;
                $currentEmi    = round($principalComp + $interestComp, 2);
                $closingBalance = 0.00;
            } else {
                $principalComp = round($emi - $interestComp, 2);
                $currentEmi    = $emi;
                $closingBalance = max(0, round($openingBalance - $principalComp, 2));
            }

            $schedule[] = [
                'installment_no'      => $m,
                'due_date'            => $dueDate->format('Y-m-d'),
                'opening_balance'     => round($openingBalance, 2),
                'principal_component' => round($principalComp, 2),
                'interest_component'  => round($interestComp, 2),
                'emi_amount'          => round($currentEmi, 2),
                'closing_balance'     => round($closingBalance, 2),
                'status'              => 'Unpaid',
            ];

            $totalInterestAccumulated += $interestComp;
            $openingBalance = $closingBalance;
        }

        $totalPayable = round($principal + $totalInterestAccumulated, 2);

        return [
            'emi'            => $emi,
            'total_payable'  => $totalPayable,
            'total_interest' => round($totalInterestAccumulated, 2),
            'schedule'       => $schedule,
        ];
    }

    /**
     * Generate and Save Amortization Schedule into Database for a given Disbursed Loan
     */
    public static function generateAndSaveSchedule(int $loanId): array
    {
        $loanModel = new LoanModel();
        $productModel = new LoanProductModel();
        $scheduleModel = new LoanRepaymentScheduleModel();

        $loan = $loanModel->find($loanId);
        if (!$loan) {
            return [];
        }

        // Delete any existing schedule for safety
        $scheduleModel->where('loan_id', $loanId)->delete();

        $product = $productModel->find($loan['loan_product_id']);
        $interestType = $product ? $product['interest_type'] : 'compound';
        $disbursedAt = $loan['disbursed_at'] ?? date('Y-m-d');

        $result = self::calculateAmortization(
            (float)$loan['principal_amount'],
            (float)$loan['interest_rate'],
            (int)$loan['tenure_months'],
            $interestType,
            $disbursedAt
        );

        $insertBatch = [];
        $now = date('Y-m-d H:i:s');

        foreach ($result['schedule'] as $item) {
            $insertBatch[] = [
                'loan_id'             => $loanId,
                'installment_no'      => $item['installment_no'],
                'due_date'            => $item['due_date'],
                'opening_balance'     => $item['opening_balance'],
                'principal_component' => $item['principal_component'],
                'interest_component'  => $item['interest_component'],
                'emi_amount'          => $item['emi_amount'],
                'closing_balance'     => $item['closing_balance'],
                'status'              => 'Unpaid',
                'created_at'          => $now,
                'updated_at'          => $now,
            ];
        }

        if (!empty($insertBatch)) {
            $scheduleModel->insertBatch($insertBatch);
        }

        return $result;
    }
}
