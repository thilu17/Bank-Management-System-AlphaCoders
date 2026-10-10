<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoanRepaymentSchedulesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'loan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'installment_no' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
            'due_date' => [
                'type' => 'DATE',
            ],
            'opening_balance' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'principal_component' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'interest_component' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'emi_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'closing_balance' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Unpaid', 'Paid', 'Overdue'],
                'default'    => 'Unpaid',
            ],
            'paid_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('loan_id', 'loans', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('loan_repayment_schedules');
    }

    public function down()
    {
        $this->forge->dropTable('loan_repayment_schedules');
    }
}
