<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\RoleModel;

class AuthApi extends BaseController
{
    public function login()
    {
        $userModel = new UserModel();
        
        // For API, get JSON input
        $json = $this->request->getJSON();
        if (!$json || !isset($json->username) || !isset($json->password)) {
            return $this->response->setJSON(['error' => 'Missing username or password'])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $user = $userModel->where('username', $json->username)->first();

        if ($user && password_verify($json->password, $user['password_hash'])) {
            $roleModel = new RoleModel();
            $role = $roleModel->find($user['role_id']);

            // For simplicity, we are setting session. In a real stateless API, return a JWT token.
            session()->set([
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'role'       => $role ? $role['name'] : 'Customer',
                'isLoggedIn' => true,
            ]);

            return $this->response->setJSON([
                'message' => 'Login successful',
                'user'    => [
                    'id'       => $user['id'],
                    'username' => $user['username'],
                    'role'     => $role ? $role['name'] : 'Customer',
                ]
            ]);
        }

        return $this->response->setJSON(['error' => 'Invalid username or password'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
    }

    public function signup()
    {
        $userModel = new UserModel();
        $roleModel = new RoleModel();

        $json = $this->request->getJSON(true); // get as array

        if (!$json) {
            return $this->response->setJSON(['error' => 'Invalid JSON input'])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Temporary set $_POST for validation to work easily
        $this->request->setGlobal('post', $json);

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['errors' => $this->validator->getErrors()])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $customerRole = $roleModel->where('name', 'Customer')->first();

        $data = [
            'username' => $json['username'],
            'password' => $json['password'],
            'role_id'  => $customerRole['id'],
        ];

        $userModel->insert($data);

        return $this->response->setJSON(['message' => 'Registration successful'])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }
}
