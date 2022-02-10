<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_name'      => [
                'type'       => 'VARCHAR',
                'constraint' => '60',
            ],
            'user_password'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'user_email'     => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'user_status'    => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'registered_date datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('user_id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
