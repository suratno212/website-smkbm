<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengumumanTable extends Migration
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
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Judul pengumuman',
            ],
            'isi' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'Isi pengumuman',
            ],
            'jenis' => [
                'type'       => 'ENUM',
                'constraint' => ['Umum', 'Jadwal Ujian', 'Kegiatan', 'Lainnya'],
                'default'    => 'Umum',
                'comment'    => 'Jenis pengumuman',
            ],
            'file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'File lampiran (PDF/gambar)',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Aktif', 'Tidak Aktif'],
                'default'    => 'Aktif',
                'comment'    => 'Status pengumuman',
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
        $this->forge->createTable('pengumuman');
    }

    public function down()
    {
        $this->forge->dropTable('pengumuman');
    }
} 