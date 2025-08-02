<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJawabanSpmbTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_jawaban' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'ujian_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'siswa_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'jawaban' => [
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
        $this->forge->addKey('kd_jawaban', true); // PRIMARY KEY
        $this->forge->createTable('jawaban_spmb');
    }

    public function down()
    {
        $this->forge->dropTable('jawaban_spmb');
    }
} 
 
 
 
 
 