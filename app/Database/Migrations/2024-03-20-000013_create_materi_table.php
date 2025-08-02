<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMateriTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_materi' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'nik_nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '25',
            ],
            'kd_mapel' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'kd_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'file' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
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
        $this->forge->addKey('kd_materi', true); // PRIMARY KEY
        $this->forge->addKey(['nik_nip', 'kd_mapel', 'kd_kelas', 'judul'], true);
        $this->forge->addForeignKey('nik_nip', 'guru', 'nik_nip', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kd_mapel', 'mapel', 'kd_mapel', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kd_kelas', 'kelas', 'kd_kelas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('materi');
    }

    public function down()
    {
        $this->forge->dropTable('materi');
    }
} 