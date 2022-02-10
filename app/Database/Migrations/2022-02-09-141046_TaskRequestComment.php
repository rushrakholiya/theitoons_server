<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TaskRequestComment extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'comment_id'         => [
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
            'task_id'        => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'comment_author' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'comment_author_email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ], 
            'comment_title'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],           
            'comment_content'=> [
                'type'       => 'LONGTEXT',
            ],
            'comment_type'   => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'comment_status' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'comment_date datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('comment_id', true);
        $this->forge->createTable('task_request_comments');
    }

    public function down()
    {
         $this->forge->dropTable('task_request_comments');
    }
}
