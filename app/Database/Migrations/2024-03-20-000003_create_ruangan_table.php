<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRuanganTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_ruangan' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'nama_ruangan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->addKey('kd_ruangan', true); // PRIMARY KEY
        $this->forge->createTable('ruangan');
    }

    public function down()
    {
        $this->forge->dropTable('ruangan');
    }
} 