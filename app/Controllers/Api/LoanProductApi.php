<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\LoanProductModel;
use CodeIgniter\API\ResponseTrait;

class LoanProductApi extends BaseController
{
    use ResponseTrait;

    protected LoanProductModel $loanProducts;

    public function __construct()
    {
        $this->loanProducts = new LoanProductModel();
    }

    /**
     * List all loan products
     */
    public function index()
    {
        $onlyActive = $this->request->getGet('active');

        if ($onlyActive === '1' || $onlyActive === 'true') {
            $products = $this->loanProducts->getActiveProducts();
        } else {
            $products = $this->loanProducts->findAll();
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Loan products retrieved successfully',
            'data'    => $products,
        ]);
    }

    /**
     * Get details of a specific loan product
     */
    public function show($id = null)
    {
        $product = $this->loanProducts->find($id);

        if (! $product) {
            return $this->failNotFound('Loan product not found.');
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Loan product details retrieved',
            'data'    => $product,
        ]);
    }

    /**
     * Create a new loan product configuration
     */
    public function create()
    {
        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        if (! $this->loanProducts->insert($data)) {
            return $this->failValidationErrors($this->loanProducts->errors());
        }

        $newId = $this->loanProducts->getInsertID();

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Loan product created successfully',
            'data'    => $this->loanProducts->find($newId),
        ]);
    }

    /**
     * Update an existing loan product
     */
    public function update($id = null)
    {
        $existing = $this->loanProducts->find($id);
        if (! $existing) {
            return $this->failNotFound('Loan product not found.');
        }

        $data = $this->request->getJSON(true) ?? $this->request->getRawInput();

        if (! $this->loanProducts->update($id, $data)) {
            return $this->failValidationErrors($this->loanProducts->errors());
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Loan product updated successfully',
            'data'    => $this->loanProducts->find($id),
        ]);
    }

    /**
     * Toggle active/inactive status
     */
    public function toggle($id = null)
    {
        $product = $this->loanProducts->find($id);
        if (! $product) {
            return $this->failNotFound('Loan product not found.');
        }

        $newStatus = $product['is_active'] ? 0 : 1;
        $this->loanProducts->update($id, ['is_active' => $newStatus]);

        return $this->respond([
            'status'  => 200,
            'message' => 'Loan product status updated to ' . ($newStatus ? 'Active' : 'Inactive'),
            'data'    => $this->loanProducts->find($id),
        ]);
    }

    /**
     * Delete a loan product
     */
    public function delete($id = null)
    {
        $product = $this->loanProducts->find($id);
        if (! $product) {
            return $this->failNotFound('Loan product not found.');
        }

        $this->loanProducts->delete($id);

        return $this->respondDeleted([
            'status'  => 200,
            'message' => 'Loan product deleted successfully',
        ]);
    }
}
