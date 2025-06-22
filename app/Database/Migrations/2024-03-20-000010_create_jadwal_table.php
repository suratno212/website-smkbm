<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'mapel_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'guru_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tahun_akademik_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'hari' => [
                'type'       => 'ENUM',
                'constraint' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
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
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('mapel_id', 'mapel', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('guru_id', 'guru', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tahun_akademik_id', 'tahun_akademik', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jadwal');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal');
    }
} 