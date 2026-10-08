<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInterestLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'fd_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'accrual_date' => ['type' => 'DATE'],
            'interest_amount' => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'total_accrued' => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['fd_id', 'accrual_date']);
        $this->forge->addForeignKey('fd_id', 'fixed_deposits', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('interest_logs');
    }

    public function down()
    {
        $this->forge->dropTable('interest_logs');
    }
}