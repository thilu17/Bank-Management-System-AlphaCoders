<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LoanProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name'              => 'Personal Express Loan',
                'code'              => 'PL-01',
                'description'       => 'Quick personal loan for salaried individuals and professionals.',
                'interest_rate'     => 14.50,
                'interest_type'     => 'compound', // Reducing Balance EMI
                'min_amount'        => 50000.00,
                'max_amount'        => 1500000.00,
                'min_tenure_months' => 6,
                'max_tenure_months' => 48,
                'is_active'         => 1,
            ],
            [
                'name'              => 'Home Mortgage & Housing Loan',
                'code'              => 'HL-01',
                'description'       => 'Competitive low-rate loans for purchasing, constructing, or renovating residential properties.',
                'interest_rate'     => 11.25,
                'interest_type'     => 'compound', // Reducing Balance EMI
                'min_amount'        => 500000.00,
                'max_amount'        => 25000000.00,
                'min_tenure_months' => 12,
                'max_tenure_months' => 240,
                'is_active'         => 1,
            ],
            [
                'name'              => 'Auto & Vehicle Loan',
                'code'              => 'AL-01',
                'description'       => 'Flexible financing for new and registered cars, vans, and commercial vehicles.',
                'interest_rate'     => 13.00,
                'interest_type'     => 'compound',
                'min_amount'        => 200000.00,
                'max_amount'        => 8000000.00,
                'min_tenure_months' => 12,
                'max_tenure_months' => 60,
                'is_active'         => 1,
            ],
            [
                'name'              => 'Micro Small Business Loan',
                'code'              => 'MS-01',
                'description'       => 'Working capital and equipment financing for small enterprises and traders.',
                'interest_rate'     => 15.00,
                'interest_type'     => 'simple', // Simple interest option
                'min_amount'        => 25000.00,
                'max_amount'        => 500000.00,
                'min_tenure_months' => 3,
                'max_tenure_months' => 24,
                'is_active'         => 1,
            ],
        ];

        foreach ($products as $product) {
            $existing = $this->db->table('loan_products')->where('code', $product['code'])->get()->getRowArray();
            $data = array_merge($product, ['updated_at' => date('Y-m-d H:i:s')]);

            if ($existing) {
                $this->db->table('loan_products')->where('id', $existing['id'])->update($data);
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->db->table('loan_products')->insert($data);
            }
        }
    }
}
