<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGuruTable extends Migration
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
            'nip_nuptk' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama' => [
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
            'agama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'mapel_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'no_hp' => [
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('mapel_id', 'mapel', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('guru');
    }

    public function down()
    {
        $this->forge->dropTable('guru');
    }
} 