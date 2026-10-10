<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoanProductsTable extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'interest_rate' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'interest_type' => [
                'type'       => 'ENUM',
                'constraint' => ['simple', 'compound'],
                'default'    => 'compound',
            ],
            'min_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => '10000.00',
            ],
            'max_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => '5000000.00',
            ],
            'min_tenure_months' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 6,
            ],
            'max_tenure_months' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 60,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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
        $this->forge->createTable('loan_products');
    }

    public function down()
    {
        $this->forge->dropTable('loan_products');
    }
}
