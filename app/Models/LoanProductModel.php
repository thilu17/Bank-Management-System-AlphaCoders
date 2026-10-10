<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanProductModel extends Model
{
    protected $table            = 'loan_products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'code',
        'description',
        'interest_rate',
        'interest_type',
        'min_amount',
        'max_amount',
        'min_tenure_months',
        'max_tenure_months',
        'is_active',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'name'              => 'required|min_length[3]|max_length[100]',
        'code'              => 'required|min_length[2]|max_length[20]',
        'interest_rate'     => 'required|numeric|greater_than[0]|less_than_equal_to[100]',
        'interest_type'     => 'required|in_list[simple,compound]',
        'min_amount'        => 'required|numeric|greater_than[0]',
        'max_amount'        => 'required|numeric|greater_than[0]',
        'min_tenure_months' => 'required|integer|greater_than[0]',
        'max_tenure_months' => 'required|integer|greater_than[0]',
    ];

    /**
     * Get only active products
     */
    public function getActiveProducts()
    {
        return $this->where('is_active', 1)->findAll();
    }
}
