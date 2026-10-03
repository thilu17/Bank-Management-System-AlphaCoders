<?php

namespace App\Models;

use CodeIgniter\Model;

class FdProductModel extends Model
{
    protected $table         = 'fd_products';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'name', 'tenure_months', 'interest_rate', 'interest_type',
        'compounding_per_year', 'min_amount', 'is_active',
    ];

    protected $validationRules = [
        'name'          => 'required|min_length[3]|max_length[100]',
        'tenure_months' => 'required|integer|greater_than[0]',
        'interest_rate' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        'interest_type' => 'required|in_list[simple,compound]',
        'min_amount'    => 'required|decimal|greater_than[0]',
    ];
}