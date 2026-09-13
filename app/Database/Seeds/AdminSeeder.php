<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Find the SUPER ADMIN role ID
        $role = $this->db->table('roles')->where('name', 'SUPER ADMIN')->get()->getRowArray();
        
        if ($role) {
            $data = [
                'username'      => 'admin',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'role_id'       => $role['id'],
                'branch_id'     => null,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];

            $this->db->table('users')->insert($data);
        }
    }
}
