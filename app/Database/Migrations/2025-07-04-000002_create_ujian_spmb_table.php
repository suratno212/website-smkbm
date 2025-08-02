<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUjianSpmbTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_ujian' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
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
        $this->forge->addKey('kd_ujian', true); // PRIMARY KEY
        $this->forge->createTable('ujian_spmb');
    }

    public function down()
    {
        $this->forge->dropTable('ujian_spmb');
    }
} 
 
 
 
 
 