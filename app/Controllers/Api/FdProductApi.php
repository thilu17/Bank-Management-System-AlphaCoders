<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FdProductModel;
use CodeIgniter\API\ResponseTrait;

class FdProductApi extends BaseController
{
    use ResponseTrait;

    private FdProductModel $products;

    public function __construct()
    {
        $this->products = new FdProductModel();
    }

    public function index()
    {
        return $this->respond($this->products->findAll());
    }

    public function create()
    {
        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        if (! $this->products->insert($data)) {
            return $this->failValidationErrors($this->products->errors());
        }

        return $this->respondCreated($this->products->find($this->products->getInsertID()));
    }

    public function update($id = null)
    {
        if (! $this->products->find($id)) {
            return $this->failNotFound('FD product not found.');
        }

        $data = $this->request->getJSON(true) ?? $this->request->getRawInput();

        if (! $this->products->update($id, $data)) {
            return $this->failValidationErrors($this->products->errors());
        }

        return $this->respond($this->products->find($id));
    }

    public function toggle($id = null)
    {
        $product = $this->products->find($id);
        if (! $product) {
            return $this->failNotFound('FD product not found.');
        }

        $this->products->update($id, ['is_active' => $product['is_active'] ? 0 : 1]);

        return $this->respond($this->products->find($id));
    }
}