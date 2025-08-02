<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_jadwal' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'kd_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'kd_mapel' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'nik_nip' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
            ],
            'hari' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'jam_mulai' => [
                'type' => 'TIME',
            ],
            'jam_selesai' => [
                'type' => 'TIME',
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
        $this->forge->addKey('kd_jadwal', true); // PRIMARY KEY
        $this->forge->addForeignKey('kd_kelas', 'kelas', 'kd_kelas', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kd_mapel', 'mapel', 'kd_mapel', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('nik_nip', 'guru', 'nik_nip', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jadwal');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal');
    }
} 