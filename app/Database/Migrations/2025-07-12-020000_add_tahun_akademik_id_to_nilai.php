<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTahunAkademikIdToNilai extends Migration
{
    public function up()
    {
        $this->forge->addColumn('nilai', [
            'tahun_akademik_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'kd_jurusan',
            ],
        ]);
        $this->forge->addForeignKey('tahun_akademik_id', 'tahun_akademik', 'kd_tahun_akademik', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('nilai', 'nilai_tahun_akademik_id_foreign');
        $this->forge->dropColumn('nilai', 'tahun_akademik_id');
    }
} 