<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengaturanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_pengaturan' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'nama_pengaturan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nilai' => [
                'type' => 'TEXT',
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
        $this->forge->addKey('kd_pengaturan', true); // PRIMARY KEY
        $this->forge->createTable('pengaturan');
    }

    public function down()
    {
        $this->forge->dropTable('pengaturan');
    }
} 