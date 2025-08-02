<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCalonSiswaTable extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
            ],
            'jenis_kelamin' => [
                'type'       => 'ENUM',
                'constraint' => ['L', 'P'],
            ],
            'alamat' => [
                'type'       => 'TEXT',
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'asal_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'jurusan_pilihan' => [
                'type'       => 'ENUM',
                'constraint' => ['RPL', 'TKJ', 'TBSM', 'MM', 'AKL'],
            ],
            'status_pendaftaran' => [
                'type'       => 'ENUM',
                'constraint' => ['terdaftar', 'diterima', 'ditolak'],
                'default'    => 'terdaftar',
            ],
            'status_tes' => [
                'type'       => 'ENUM',
                'constraint' => ['belum_tes', 'sedang_tes', 'sudah_tes'],
                'default'    => 'belum_tes',
            ],
            'nilai_tes' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
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
        $this->forge->addKey('user_id');
        $this->forge->addKey('email');
        
        // Add foreign key
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('calon_siswa');
    }

    public function down()
    {
        $this->forge->dropTable('calon_siswa');
    }
} 
 
 
 
 
 