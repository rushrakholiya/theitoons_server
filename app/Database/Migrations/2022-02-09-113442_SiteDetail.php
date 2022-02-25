<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SiteDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'option_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'option_name'       => [
                'type'          => 'VARCHAR',
                'constraint'    => '100',
            ],
            'option_value'       => [
                'type'          => 'LONGTEXT',
            ],
        ]);
        $this->forge->addPrimaryKey('option_id', true);
        $this->forge->createTable('site_details');
    }

    public function down()
    {
        $this->forge->dropTable('site_details');
    }
}
