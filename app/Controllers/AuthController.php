<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\RoleModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginSubmit()
    {
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password_hash'])) {
            $roleModel = new RoleModel();
            $role = $roleModel->find($user['role_id']);

            session()->set([
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'role'       => $role ? $role['name'] : 'Customer',
                'isLoggedIn' => true,
            ]);

            return redirect()->to('/dashboard');
        }

        return redirect()->back()->with('error', 'Invalid username or password');
    }

    public function signup()
    {
        $roleModel = new RoleModel();
        $data['roles'] = $roleModel->findAll();
        return view('auth/signup', $data);
    }

    public function signupSubmit()
    {
        $userModel = new UserModel();

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'role_id'  => 'required|is_not_unique[roles.id]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username'      => $this->request->getPost('username'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role_id'       => $this->request->getPost('role_id'),
        ];

        $userModel->insert($data);

        return redirect()->to('/login')->with('success', 'Registration successful. Please log in.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
