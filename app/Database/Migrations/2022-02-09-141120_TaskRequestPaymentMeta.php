<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TaskRequestPaymentMeta extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'meta_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'payment_id'     => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'meta_key'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'meta_value'     => [
                'type'       => 'LONGTEXT',
            ],
        ]);
        $this->forge->addPrimaryKey('meta_id', true);
        $this->forge->createTable('task_request_payment_meta');
    }

    public function down()
    {
        $this->forge->dropTable('task_request_payment_meta');
    }
}
