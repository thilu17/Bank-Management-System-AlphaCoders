<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFdProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'                 => ['type' => 'VARCHAR', 'constraint' => 100],
            'tenure_months'        => ['type' => 'INT', 'constraint' => 5],
            'interest_rate'        => ['type' => 'DECIMAL', 'constraint' => '5,2'],
            'interest_type'        => ['type' => 'ENUM', 'constraint' => ['simple', 'compound'], 'default' => 'simple'],
            'compounding_per_year' => ['type' => 'TINYINT', 'constraint' => 2, 'default' => 4],
            'min_amount'           => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'is_active'            => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
            'updated_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('fd_products');
    }

    public function down()
    {
        $this->forge->dropTable('fd_products');
    }
}