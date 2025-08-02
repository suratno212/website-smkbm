<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePretestTable extends Migration
{
    public function up()
    {
        // Drop table if exists to avoid conflicts
        $this->forge->dropTable('pretest_soal', true);
        $this->forge->dropTable('pretest', true);

        $this->forge->addField([
            'kd_pretest' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
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
        $this->forge->addKey('kd_pretest', true); // PRIMARY KEY
        $this->forge->createTable('pretest');

        // Tabel pretest_soal
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kd_pretest' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
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
        $this->forge->addForeignKey('kd_pretest', 'pretest', 'kd_pretest', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pretest_soal');
    }

    public function down()
    {
        $this->forge->dropTable('pretest_soal');
        $this->forge->dropTable('pretest');
    }
} 