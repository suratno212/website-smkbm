<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'nama_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'tingkat' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'kd_jurusan' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'wali_kelas_nik_nip' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => true,
            ],
            'kuota' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 36,
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
        $this->forge->addKey('kd_kelas', true); // PRIMARY KEY
        $this->forge->addForeignKey('kd_jurusan', 'jurusan', 'kd_jurusan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kelas');
    }

    public function down()
    {
        $this->forge->dropTable('kelas');
    }
} 