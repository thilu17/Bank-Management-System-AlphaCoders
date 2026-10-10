<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanRepaymentScheduleModel extends Model
{
    protected $table            = 'loan_repayment_schedules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'loan_id',
        'installment_no',
        'due_date',
        'opening_balance',
        'principal_component',
        'interest_component',
        'emi_amount',
        'closing_balance',
        'status',
        'paid_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get full schedule for a loan ordered by installment number
     */
    public function getScheduleForLoan(int $loanId)
    {
        return $this->where('loan_id', $loanId)
                    ->orderBy('installment_no', 'ASC')
                    ->findAll();
    }

    /**
     * Alias for getScheduleForLoan
     */
    public function getScheduleByLoan(int $loanId)
    {
        return $this->getScheduleForLoan($loanId);
    }
}
