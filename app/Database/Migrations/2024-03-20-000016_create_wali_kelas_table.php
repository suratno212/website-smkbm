<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWaliKelasTable extends Migration
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
            'kd_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'nik_nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '25',
            ],
            'kd_tahun_akademik' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
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
        $this->forge->addForeignKey('kd_kelas', 'kelas', 'kd_kelas', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('nik_nip', 'guru', 'nik_nip', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kd_tahun_akademik', 'tahun_akademik', 'kd_tahun_akademik', 'CASCADE', 'CASCADE');
        $this->forge->createTable('wali_kelas');
    }

    public function down()
    {
        $this->forge->dropTable('wali_kelas');
    }
} 