<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSoalSpmbTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_soal' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'ujian_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'soal' => [
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
        $this->forge->addKey('kd_soal', true); // PRIMARY KEY
        $this->forge->createTable('soal_spmb');
    }

    public function down()
    {
        $this->forge->dropTable('soal_spmb');
    }
} 
 
 
 
 
 