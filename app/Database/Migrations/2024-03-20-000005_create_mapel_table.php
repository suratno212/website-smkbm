<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMapelTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_mapel' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'nama_mapel' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'kelompok' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
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
        $this->forge->addKey('kd_mapel', true); // PRIMARY KEY
        $this->forge->createTable('mapel');
    }

    public function down()
    {
        $this->forge->dropTable('mapel');
    }
} 