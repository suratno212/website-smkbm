<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEkstrakurikulerSiswaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_ekstrakurikuler_siswa' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'nis' => [
                'type'       => 'INT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'kd_ekstrakurikuler' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'tahun_ajaran' => [
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
        $this->forge->addKey('kd_ekstrakurikuler_siswa', true); // PRIMARY KEY
        $this->forge->addForeignKey('nis', 'siswa', 'nis', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kd_ekstrakurikuler', 'ekstrakurikuler', 'kd_ekstrakurikuler', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ekstrakurikuler_siswa');
    }

    public function down()
    {
        $this->forge->dropTable('ekstrakurikuler_siswa');
    }
} 