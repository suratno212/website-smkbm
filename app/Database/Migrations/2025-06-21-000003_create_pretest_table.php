<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePretestTable extends Migration
{
    public function up()
    {
        // Tabel pretest
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pertemuan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->addForeignKey('pertemuan_id', 'pertemuan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pretest');

        // Tabel pretest_soal
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pretest_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'soal' => [
                'type' => 'TEXT',
            ],
            'pilihan_a' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'pilihan_b' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'pilihan_c' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'pilihan_d' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'jawaban_benar' => [
                'type' => 'CHAR',
                'constraint' => 1,
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
        $this->forge->addForeignKey('pretest_id', 'pretest', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pretest_soal');
    }

    public function down()
    {
        $this->forge->dropTable('pretest_soal');
        $this->forge->dropTable('pretest');
    }
} 