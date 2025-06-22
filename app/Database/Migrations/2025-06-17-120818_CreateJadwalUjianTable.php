<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalUjianTable extends Migration
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
            'nama_ujian' => [
                'type'       => 'ENUM',
                'constraint' => ['UTS', 'UAS', 'US', 'UN'],
                'comment'    => 'Jenis ujian',
            ],
            'mapel_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID mata pelajaran',
            ],
            'kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID kelas',
            ],
            'jurusan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID jurusan',
            ],
            'semester' => [
                'type'       => 'ENUM',
                'constraint' => ['Ganjil', 'Genap'],
                'comment'    => 'Semester',
            ],
            'tanggal' => [
                'type' => 'DATE',
                'comment' => 'Tanggal ujian',
            ],
            'jam_mulai' => [
                'type' => 'TIME',
                'comment' => 'Jam mulai ujian',
            ],
            'jam_selesai' => [
                'type' => 'TIME',
                'comment' => 'Jam selesai ujian',
            ],
            'ruang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID ruangan',
            ],
            'pengawas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID guru pengawas',
            ],
            'keterangan' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'Keterangan tambahan',
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
        $this->forge->addForeignKey('mapel_id', 'mapel', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('jurusan_id', 'jurusan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ruang_id', 'ruangan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pengawas_id', 'guru', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jadwal_ujian');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal_ujian');
    }
}
