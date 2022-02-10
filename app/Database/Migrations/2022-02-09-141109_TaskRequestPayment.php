<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TaskRequestPayment extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'payment_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'task_id'        => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'user_id'=> [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'payment_title'  => [
                'type'       => 'TEXT',
            ],
            'payment_status' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'payment_date datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('payment_id', true);
        $this->forge->createTable('task_request_payments');
    }

    public function down()
    {
        $this->forge->dropTable('task_request_payments');
    }
}
