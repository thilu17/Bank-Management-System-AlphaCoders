<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        // 1. Check or create default customer user account if needed
        $customerRole = $this->db->table('roles')->where('name', 'Customer')->get()->getRowArray();
        $roleId = $customerRole ? $customerRole['id'] : 7;

        $userRecords = [
            ['username' => 'customer_kamal', 'password' => 'customer123'],
            ['username' => 'customer_nimal', 'password' => 'customer123'],
            ['username' => 'customer_sunil', 'password' => 'customer123'],
        ];

        $customers = [
            [
                'username'    => 'customer_kamal',
                'customer_id' => 'C001',
                'full_name'   => 'Kamal Perera',
                'nic'         => '198512345678',
                'dob'         => '1985-05-14',
                'phone'       => '0771234567',
                'address'     => 'No. 45, Galle Road, Colombo 03',
                'occupation'  => 'Senior Software Engineer',
                'kyc_status'  => 'Verified',
            ],
            [
                'username'    => 'customer_nimal',
                'customer_id' => 'C002',
                'full_name'   => 'Nimal Silva',
                'nic'         => '199087654321',
                'dob'         => '1990-11-20',
                'phone'       => '0719876543',
                'address'     => 'No. 12, Kandy Road, Kiribathgoda',
                'occupation'  => 'Business Owner / Retail Trader',
                'kyc_status'  => 'Verified',
            ],
            [
                'username'    => 'customer_sunil',
                'customer_id' => 'C003',
                'full_name'   => 'Sunil Shantha',
                'nic'         => '197823456789',
                'dob'         => '1978-03-08',
                'phone'       => '0763456789',
                'address'     => 'No. 88, Temple Road, Negombo',
                'occupation'  => 'Civil Contractor',
                'kyc_status'  => 'Verified',
            ],
        ];

        foreach ($customers as $c) {
            $user = $this->db->table('users')->where('username', $c['username'])->get()->getRowArray();
            if (!$user) {
                $this->db->table('users')->insert([
                    'username'      => $c['username'],
                    'password_hash' => password_hash('customer123', PASSWORD_DEFAULT),
                    'role_id'       => $roleId,
                    'created_at'    => date('Y-m-d H:i:s'),
                ]);
                $userId = $this->db->insertID();
            } else {
                $userId = $user['id'];
            }

            $existingCustomer = $this->db->table('customers')->where('customer_id', $c['customer_id'])->get()->getRowArray();
            $customerData = [
                'user_id'     => $userId,
                'customer_id' => $c['customer_id'],
                'full_name'   => $c['full_name'],
                'nic'         => $c['nic'],
                'dob'         => $c['dob'],
                'phone'       => $c['phone'],
                'address'     => $c['address'],
                'occupation'  => $c['occupation'],
                'kyc_status'  => $c['kyc_status'],
                'updated_at'  => date('Y-m-d H:i:s'),
            ];

            if ($existingCustomer) {
                $this->db->table('customers')->where('id', $existingCustomer['id'])->update($customerData);
            } else {
                $customerData['created_at'] = date('Y-m-d H:i:s');
                $this->db->table('customers')->insert($customerData);
            }
        }
    }
}
