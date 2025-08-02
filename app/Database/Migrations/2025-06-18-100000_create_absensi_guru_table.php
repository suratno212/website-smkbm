<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAbsensiGuruTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_absensi_guru' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'nik_nip' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Hadir', 'Izin', 'Sakit', 'Alpha'],
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
        $this->forge->addKey('kd_absensi_guru', true); // PRIMARY KEY
        $this->forge->addForeignKey('nik_nip', 'guru', 'nik_nip', 'CASCADE', 'CASCADE');
        $this->forge->createTable('absensi_guru');
    }

    public function down()
    {
        $this->forge->dropTable('absensi_guru');
    }
} 