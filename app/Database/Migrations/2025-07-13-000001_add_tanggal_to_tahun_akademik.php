<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTanggalToTahunAkademik extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tahun_akademik', [
            'tanggal_mulai' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'semester',
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'tanggal_mulai',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tahun_akademik', 'tanggal_mulai');
        $this->forge->dropColumn('tahun_akademik', 'tanggal_selesai');
    }
} 