<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengumpulanTugasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tugas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'siswa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'file_tugas' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Belum Dikumpulkan', 'Sudah Dikumpulkan', 'Terlambat'],
            ],
            'nilai' => [
                'type' => 'INT',
                'constraint' => 3,
                'null' => true,
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
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('tugas_id', 'tugas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('siswa_id', 'siswa', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengumpulan_tugas');
    }

    public function down()
    {
        $this->forge->dropTable('pengumpulan_tugas');
    }
} 