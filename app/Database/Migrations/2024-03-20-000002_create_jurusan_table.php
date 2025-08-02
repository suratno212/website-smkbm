<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJurusanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_jurusan' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'nama_jurusan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->addKey('kd_jurusan', true); // PRIMARY KEY
        $this->forge->createTable('jurusan');
    }

    public function down()
    {
        $this->forge->dropTable('jurusan');
    }
} 