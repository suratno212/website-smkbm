<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTahunAkademikIdToJadwal extends Migration
{
    public function up()
    {
        $this->forge->addColumn('jadwal', [
            'tahun_akademik_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'nik_nip',
            ],
        ]);
        $this->forge->addForeignKey('tahun_akademik_id', 'tahun_akademik', 'kd_tahun_akademik', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('jadwal', 'jadwal_tahun_akademik_id_foreign');
        $this->forge->dropColumn('jadwal', 'tahun_akademik_id');
    }
} 