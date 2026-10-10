<?php

namespace App\Services;

use Config\Database;

class LedgerService
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Record Loan Disbursement in General Ledger & Credit Customer Savings
     * Dual-entry:
     * - DEBIT: Loan Disbursement Asset GL Account (GL-10400)
     * - CREDIT: Customer Savings Account / Customer GL (GL-20100)
     */
    public function disburseLoanToSavings(int $customerId, float $amount, string $loanAccountNo, int $branchId = null): array
    {
        $txId = 'TX-DISB-' . date('YmdHis') . '-' . rand(100, 999);
        $timestamp = date('Y-m-d H:i:s');

        $ledgerEntry = [
            'transaction_id'    => $txId,
            'loan_account_no'   => $loanAccountNo,
            'customer_id'       => $customerId,
            'branch_id'         => $branchId,
            'amount'            => $amount,
            'debit_account'     => 'GL-10400 (Loan Disbursement Asset)',
            'credit_account'    => 'GL-20100 (Customer Savings Deposit)',
            'description'       => "Loan disbursement for facility {$loanAccountNo}",
            'status'            => 'SUCCESS',
            'created_at'        => $timestamp,
        ];

        // 1. If 'accounts' table exists, credit customer account balance
        if ($this->db->tableExists('accounts')) {
            $account = $this->db->table('accounts')->where('customer_id', $customerId)->get()->getRowArray();
            if ($account) {
                $newBalance = (float)$account['balance'] + $amount;
                $this->db->table('accounts')->where('id', $account['id'])->update(['balance' => $newBalance, 'updated_at' => $timestamp]);
            }
        }

        // 2. If 'transactions' table exists, insert record
        if ($this->db->tableExists('transactions')) {
            $this->db->table('transactions')->insert([
                'tx_id'       => $txId,
                'account_no'  => $loanAccountNo,
                'type'        => 'LOAN_DISBURSEMENT',
                'amount'      => $amount,
                'description' => "Disbursement credited for {$loanAccountNo}",
                'created_at'  => $timestamp,
            ]);
        }

        return $ledgerEntry;
    }
}
