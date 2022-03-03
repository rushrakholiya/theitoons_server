<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TaskRequest extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'task_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id'        => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'task_title'     => [
                'type'       => 'TEXT',
            ],
            'task_status'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'task_comment_count'  => [
                'type'       => 'BIGINT',
                'constraint' => 20,
            ],
            'task_date datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('task_id', true);
        $this->forge->createTable('task_requests');
    }

    public function down()
    {
        $this->forge->dropTable('task_requests');
    }
}
