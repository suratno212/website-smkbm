<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePpdbTable extends Migration
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
            'no_pendaftaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'jenis_kelamin' => [
                'type'       => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan'],
            ],
            'tempat_lahir' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
            ],
            'agama_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'asal_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_ortu' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'no_hp_ortu' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'jurusan_pilihan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'status_pendaftaran' => [
                'type'       => 'ENUM',
                'constraint' => ['Menunggu', 'Diterima', 'Ditolak', 'Diterima Bersyarat'],
                'default'    => 'Menunggu',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nis' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,
                'null'       => true,
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
        $this->forge->addUniqueKey('no_pendaftaran');
        $this->forge->addForeignKey('agama_id', 'agama', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('spmb');
    }

    public function down()
    {
        $this->forge->dropTable('spmb');
    }
} 