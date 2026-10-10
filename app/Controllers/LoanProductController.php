<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoanProductModel;

class LoanProductController extends BaseController
{
    protected LoanProductModel $loanProductModel;

    public function __construct()
    {
        $this->loanProductModel = new LoanProductModel();
    }

    public function index()
    {
        $data = [
            'username' => session()->get('username'),
            'role'     => session()->get('role'),
            'products' => $this->loanProductModel->orderBy('id', 'DESC')->findAll(),
        ];

        return view('loan_products/index', $data);
    }

    public function create()
    {
        $code = strtoupper(trim((string)$this->request->getPost('code')));

        // Check unique code
        $existing = $this->loanProductModel->where('code', $code)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('errors', ['code' => "Product code '{$code}' already exists."]);
        }

        $minAmount = (float)$this->request->getPost('min_amount');
        $maxAmount = (float)$this->request->getPost('max_amount');
        if ($maxAmount < $minAmount) {
            return redirect()->back()->withInput()->with('errors', ['max_amount' => 'Max loan amount must be greater than or equal to Min loan amount.']);
        }

        $minTenure = (int)$this->request->getPost('min_tenure_months');
        $maxTenure = (int)$this->request->getPost('max_tenure_months');
        if ($maxTenure < $minTenure) {
            return redirect()->back()->withInput()->with('errors', ['max_tenure_months' => 'Max tenure must be greater than or equal to Min tenure.']);
        }

        $data = [
            'name'              => trim((string)$this->request->getPost('name')),
            'code'              => $code,
            'description'       => trim((string)$this->request->getPost('description')),
            'interest_rate'     => (float)$this->request->getPost('interest_rate'),
            'interest_type'     => $this->request->getPost('interest_type'),
            'min_amount'        => $minAmount,
            'max_amount'        => $maxAmount,
            'min_tenure_months' => $minTenure,
            'max_tenure_months' => $maxTenure,
            'is_active'         => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if (! $this->loanProductModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->loanProductModel->errors());
        }

        return redirect()->to('/loans/products')->with('success', 'Loan Product created successfully!');
    }

    public function update($id = null)
    {
        $product = $this->loanProductModel->find($id);
        if (! $product) {
            return redirect()->to('/loans/products')->with('error', 'Loan product not found.');
        }

        $code = strtoupper(trim((string)$this->request->getPost('code')));

        // Check if code changed and is already taken by another product
        $existingCode = $this->loanProductModel->where('code', $code)->where('id !=', $id)->first();
        if ($existingCode) {
            return redirect()->back()->withInput()->with('errors', ['code' => "Product code '{$code}' is already used by another product."]);
        }

        $minAmount = (float)$this->request->getPost('min_amount');
        $maxAmount = (float)$this->request->getPost('max_amount');
        if ($maxAmount < $minAmount) {
            return redirect()->back()->withInput()->with('errors', ['max_amount' => 'Max loan amount must be greater than or equal to Min loan amount.']);
        }

        $minTenure = (int)$this->request->getPost('min_tenure_months');
        $maxTenure = (int)$this->request->getPost('max_tenure_months');
        if ($maxTenure < $minTenure) {
            return redirect()->back()->withInput()->with('errors', ['max_tenure_months' => 'Max tenure must be greater than or equal to Min tenure.']);
        }

        $data = [
            'name'              => trim((string)$this->request->getPost('name')),
            'code'              => $code,
            'description'       => trim((string)$this->request->getPost('description')),
            'interest_rate'     => (float)$this->request->getPost('interest_rate'),
            'interest_type'     => $this->request->getPost('interest_type'),
            'min_amount'        => $minAmount,
            'max_amount'        => $maxAmount,
            'min_tenure_months' => $minTenure,
            'max_tenure_months' => $maxTenure,
            'is_active'         => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if (! $this->loanProductModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->loanProductModel->errors());
        }

        return redirect()->to('/loans/products')->with('success', 'Loan Product updated successfully!');
    }

    public function toggle($id = null)
    {
        $product = $this->loanProductModel->find($id);
        if (! $product) {
            return redirect()->to('/loans/products')->with('error', 'Loan product not found.');
        }

        $newStatus = $product['is_active'] ? 0 : 1;
        $this->loanProductModel->update($id, ['is_active' => $newStatus]);

        $statusText = $newStatus ? 'activated' : 'deactivated';
        return redirect()->to('/loans/products')->with('success', "Loan Product '{$product['name']}' has been {$statusText}.");
    }

    public function delete($id = null)
    {
        $product = $this->loanProductModel->find($id);
        if (! $product) {
            return redirect()->to('/loans/products')->with('error', 'Loan product not found.');
        }

        $this->loanProductModel->delete($id);

        return redirect()->to('/loans/products')->with('success', "Loan Product '{$product['name']}' has been deleted successfully.");
    }
}
