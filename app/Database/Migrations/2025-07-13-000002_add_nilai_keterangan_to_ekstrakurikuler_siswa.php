<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNilaiKeteranganToEkstrakurikulerSiswa extends Migration
{
    public function up()
    {
        $fields = [
            'nilai' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'tahun_ajaran',
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'nilai',
            ],
        ];
        $this->forge->addColumn('ekstrakurikuler_siswa', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('ekstrakurikuler_siswa', 'nilai');
        $this->forge->dropColumn('ekstrakurikuler_siswa', 'keterangan');
    }
} 