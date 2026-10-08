<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFixedDepositsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'fd_number' => ['type' => 'VARCHAR', 'constraint' => 30],
            'customer_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'principal' => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'interest_rate' => ['type' => 'DECIMAL', 'constraint' => '5,2'],
            'interest_type' => ['type' => 'ENUM', 'constraint' => ['simple', 'compound'], 'default' => 'simple'],
            'day_count' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'actual/365'],
            'compounding_per_year' => ['type' => 'TINYINT', 'constraint' => 2, 'default' => 4],
            'tenure_months' => ['type' => 'INT', 'constraint' => 5],
            'start_date' => ['type' => 'DATE'],
            'maturity_date' => ['type' => 'DATE'],
            'accrued_interest' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'status' => ['type' => 'ENUM', 'constraint' => ['active', 'matured', 'closed'], 'default' => 'active'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('fd_number');
        $this->forge->addForeignKey('customer_id', 'customers', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('fixed_deposits');
    }

    public function down()
    {
        $this->forge->dropTable('fixed_deposits');
    }
}