<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToTahunAkademik extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tahun_akademik', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Aktif', 'Tidak Aktif'],
                'default'    => 'Tidak Aktif',
                'after'      => 'semester',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tahun_akademik', 'status');
    }
}
