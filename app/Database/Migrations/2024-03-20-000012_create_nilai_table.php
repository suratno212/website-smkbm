<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNilaiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nis' => [
                'type'       => 'INT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'kd_mapel' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'kd_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'kd_jurusan' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'kd_tahun_akademik' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'semester' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'nilai_tugas' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'nilai_uts' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'nilai_uas' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'nilai_akhir' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
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
        $this->forge->addKey(['nis', 'kd_mapel', 'kd_kelas', 'kd_jurusan', 'kd_tahun_akademik'], true);
        $this->forge->addForeignKey('nis', 'siswa', 'nis', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kd_mapel', 'mapel', 'kd_mapel', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kd_kelas', 'kelas', 'kd_kelas', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kd_jurusan', 'jurusan', 'kd_jurusan', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kd_tahun_akademik', 'tahun_akademik', 'kd_tahun_akademik', 'CASCADE', 'CASCADE');
        $this->forge->createTable('nilai');
    }

    public function down()
    {
        $this->forge->dropTable('nilai');
    }
} 