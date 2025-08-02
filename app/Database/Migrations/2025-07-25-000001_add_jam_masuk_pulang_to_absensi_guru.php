<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJamMasukPulangToAbsensiGuru extends Migration
{
    public function up()
    {
        $fields = [
            'jam_masuk' => [
                'type' => 'TIME',
                'null' => true,
                'after' => 'tanggal',
            ],
            'jam_pulang' => [
                'type' => 'TIME',
                'null' => true,
                'after' => 'jam_masuk',
            ],
        ];
        $this->forge->addColumn('absensi_guru', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('absensi_guru', 'jam_masuk');
        $this->forge->dropColumn('absensi_guru', 'jam_pulang');
    }
}
