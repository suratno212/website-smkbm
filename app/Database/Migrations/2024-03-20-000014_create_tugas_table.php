<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTugasTable extends Migration
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
            'guru_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'mapel_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'deadline' => [
                'type' => 'DATETIME',
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
        $this->forge->addForeignKey('guru_id', 'guru', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('mapel_id', 'mapel', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tugas');
    }

    public function down()
    {
        $this->forge->dropTable('tugas');
    }
} 