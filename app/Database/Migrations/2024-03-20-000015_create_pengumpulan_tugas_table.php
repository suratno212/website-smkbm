<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengumpulanTugasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            // Hapus kolom id jika ada, gunakan kd_pengumpulan sebagai primary key
            'kd_pengumpulan' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'kd_tugas' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'siswa_id' => [
                'type'       => 'INT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'file_tugas' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => 'dikumpulkan',
            ],
            'nilai' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('kd_pengumpulan', true); // PRIMARY KEY
        $this->forge->addForeignKey('kd_tugas', 'tugas', 'kd_tugas', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('siswa_id', 'siswa', 'nis', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengumpulan_tugas');
    }

    public function down()
    {
        $this->forge->dropTable('pengumpulan_tugas');
    }
} 