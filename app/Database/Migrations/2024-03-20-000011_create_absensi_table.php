<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAbsensiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_absensi' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'nis' => [
                'type'       => 'INT',
                'constraint' => 20,
                'unsigned'   => true,
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
        $this->forge->addKey('kd_absensi', true); // PRIMARY KEY
        $this->forge->addForeignKey('nis', 'siswa', 'nis', 'CASCADE', 'CASCADE');
        $this->forge->createTable('absensi');
    }

    public function down()
    {
        $this->forge->dropTable('absensi');
    }
} 