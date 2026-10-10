<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoanApplicationsTable extends Migration
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
            'application_no' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'unique'     => true,
            ],
            'customer_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'loan_product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'branch_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_by_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            // Loan Financial Parameters
            'amount_requested' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'tenure_months' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
            'proposed_interest_rate' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'purpose' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'monthly_income' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            // Collateral Details
            'collateral_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'collateral_value' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            'collateral_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // Guarantor Details
            'guarantor_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => true,
            ],
            'guarantor_nic' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'guarantor_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'guarantor_relationship' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'guarantor_address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // Uploaded Documents
            'kyc_doc_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'income_doc_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            // Application Status & Notes
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Pending Review', 'Approved', 'Rejected', 'Disbursed'],
                'default'    => 'Pending Review',
            ],
            'remarks' => [
                'type' => 'TEXT',
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
        $this->forge->addForeignKey('customer_id', 'customers', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('loan_product_id', 'loan_products', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('branch_id', 'branches', 'id', 'SET NULL', 'RESTRICT');
        $this->forge->addForeignKey('created_by_user_id', 'users', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('loan_applications');
    }

    public function down()
    {
        $this->forge->dropTable('loan_applications');
    }
}
