<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\LoanModel;
use App\Models\LoanRepaymentScheduleModel;
use App\Services\EmiCalculatorService;
use CodeIgniter\API\ResponseTrait;

class LoanEmiApi extends BaseController
{
    use ResponseTrait;

    protected LoanModel $loanModel;
    protected LoanRepaymentScheduleModel $scheduleModel;

    public function __construct()
    {
        $this->loanModel     = new LoanModel();
        $this->scheduleModel = new LoanRepaymentScheduleModel();
    }

    /**
     * Preview EMI and Amortization Schedule without creating DB records
     * POST /api/v1/loans/preview-emi
     */
    public function previewEmi()
    {
        $input = $this->request->getJSON(true) ?? $this->request->getPost();

        $principal    = isset($input['amount']) ? (float)$input['amount'] : (isset($input['principal']) ? (float)$input['principal'] : 0);
        $annualRate   = isset($input['interest_rate']) ? (float)$input['interest_rate'] : (isset($input['rate']) ? (float)$input['rate'] : 0);
        $tenureMonths = isset($input['tenure_months']) ? (int)$input['tenure_months'] : (isset($input['tenure']) ? (int)$input['tenure'] : 0);
        $interestType = $input['interest_type'] ?? 'compound';
        $startDate    = $input['start_date'] ?? date('Y-m-d');

        if ($principal <= 0 || $annualRate <= 0 || $tenureMonths <= 0) {
            return $this->fail([
                'status'  => 400,
                'message' => 'Invalid parameters. amount, interest_rate, and tenure_months must all be positive numbers.',
            ]);
        }

        $amortization = EmiCalculatorService::calculateAmortization(
            $principal,
            $annualRate,
            $tenureMonths,
            $interestType,
            $startDate
        );

        return $this->respond([
            'status'         => 200,
            'message'        => 'Amortization schedule calculated successfully.',
            'parameters'     => [
                'principal'      => $principal,
                'interest_rate'  => $annualRate,
                'tenure_months'  => $tenureMonths,
                'interest_type'  => $interestType,
                'start_date'     => $startDate,
            ],
            'financials'     => [
                'monthly_emi'    => $amortization['emi'],
                'total_payable'  => $amortization['total_payable'],
                'total_interest' => $amortization['total_interest'],
            ],
            'schedule_count' => count($amortization['schedule']),
            'schedule'       => $amortization['schedule'],
        ]);
    }

    /**
     * Fetch Repayment Amortization Schedule for an Active Loan
     * GET /api/v1/loans/{id}/schedule
     */
    public function getSchedule($loanId = null)
    {
        $loan = $this->loanModel->getDetailedLoan((int)$loanId);
        if (!$loan) {
            return $this->failNotFound("Active loan record #{$loanId} not found.");
        }

        $schedules = $this->scheduleModel->getScheduleForLoan((int)$loanId);
        if (empty($schedules)) {
            // Auto compute and save if not previously persisted
            $result = EmiCalculatorService::generateAndSaveSchedule((int)$loanId);
            $schedules = $this->scheduleModel->getScheduleForLoan((int)$loanId);
        }

        return $this->respond([
            'status'         => 200,
            'message'        => 'Repayment schedule retrieved successfully.',
            'loan'           => [
                'id'                  => (int)$loan['id'],
                'loan_account_no'     => $loan['loan_account_no'],
                'customer_name'       => $loan['customer_name'],
                'customer_code'       => $loan['customer_code'],
                'product_name'        => $loan['product_name'],
                'principal_amount'    => (float)$loan['principal_amount'],
                'interest_rate'       => (float)$loan['interest_rate'],
                'tenure_months'       => (int)$loan['tenure_months'],
                'emi_amount'          => (float)$loan['emi_amount'],
                'total_payable'       => (float)$loan['total_payable'],
                'total_paid'          => (float)$loan['total_paid'],
                'outstanding_balance' => (float)$loan['outstanding_balance'],
                'status'              => $loan['status'],
                'disbursed_at'        => $loan['disbursed_at'],
            ],
            'schedule_count' => count($schedules),
            'schedule'       => $schedules,
        ]);
    }
}
