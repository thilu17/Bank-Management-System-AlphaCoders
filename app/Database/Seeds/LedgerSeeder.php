<?php

namespace App\Database\Seeds;

use App\Services\LedgerService;
use CodeIgniter\Database\Seeder;

class LedgerSeeder extends Seeder
{
    public function run()
    {
        if ($this->db->table('roles')->countAllResults() === 0) {
            $this->call('RoleSeeder');
        }

        if ($this->db->table('users')->where('username', 'admin')->countAllResults() === 0) {
            $this->call('AdminSeeder');
        }

        $this->call('CustomerSeeder');

        $branch = $this->db->table('branches')->where('code', 'CMB')->get()->getRowArray();
        if (! $branch) {
            $this->db->table('branches')->insert([
                'name'     => 'Colombo Main',
                'code'     => 'CMB',
                'location' => 'Galle Road, Colombo 03',
            ]);
            $branchId = (int) $this->db->insertID();
        } else {
            $branchId = (int) $branch['id'];
        }

        $ledger = new LedgerService();
        $ledger->ensureCoreChart();

        $savingsGl = $ledger->glByCode('GL-20100');
        $currentGl = $ledger->glByCode('GL-20200');

        $opening = [
            'C001' => [['type' => 'SAVINGS', 'no' => 'SA-100001', 'amount' => 250000.00, 'gl' => $savingsGl]],
            'C002' => [
                ['type' => 'SAVINGS', 'no' => 'SA-100002', 'amount' => 180000.00, 'gl' => $savingsGl],
                ['type' => 'CURRENT', 'no' => 'CA-200001', 'amount' => 40000.00, 'gl' => $currentGl],
            ],
            'C003' => [['type' => 'SAVINGS', 'no' => 'SA-100003', 'amount' => 95000.00, 'gl' => $savingsGl]],
        ];

        $lines = [];
        $cashTotal = 0.0;
        $now = date('Y-m-d H:i:s');

        foreach ($opening as $customerCode => $accounts) {
            $customer = $this->db->table('customers')->where('customer_id', $customerCode)->get()->getRowArray();
            if (! $customer) {
                continue;
            }

            foreach ($accounts as $spec) {
                $existing = $this->db->table('accounts')->where('account_no', $spec['no'])->get()->getRowArray();
                if (! $existing) {
                    $this->db->table('accounts')->insert([
                        'account_no'    => $spec['no'],
                        'customer_id'   => $customer['id'],
                        'branch_id'     => $branchId,
                        'gl_account_id' => (int) $spec['gl']['id'],
                        'account_type'  => $spec['type'],
                        'currency'      => 'LKR',
                        'balance'       => '0.00',
                        'status'        => 'Active',
                        'created_at'    => $now,
                        'updated_at'    => $now,
                    ]);
                    $accountId = (int) $this->db->insertID();
                } else {
                    $accountId = (int) $existing['id'];
                }

                $cashTotal += $spec['amount'];
                $lines[] = [
                    'gl_code'    => $spec['gl']['code'],
                    'account_id' => $accountId,
                    'debit'      => 0,
                    'credit'     => $spec['amount'],
                    'narration'  => 'Opening balance ' . $spec['no'],
                ];
            }
        }

        $alreadyOpened = $this->db->table('journal_entries')->where('reference_type', 'OPENING')->countAllResults();
        if ($alreadyOpened > 0 || $lines === []) {
            return;
        }

        $admin = $this->db->table('users')->where('username', 'admin')->get()->getRowArray();
        array_unshift($lines, [
            'gl_code'   => 'GL-10100',
            'debit'     => round($cashTotal, 2),
            'credit'    => 0,
            'narration' => 'Cash funding for opening deposits',
        ]);

        $ledger->postEntry([
            'entry_no'       => 'JE-OPENING-0001',
            'reference_type' => 'OPENING',
            'reference_no'   => 'OPENING',
            'description'    => 'Opening balances for customer deposit accounts',
            'branch_id'      => $branchId,
            'created_by'     => $admin['id'] ?? null,
        ], $lines);
    }
}
