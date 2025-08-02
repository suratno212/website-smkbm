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
            'kd_mapel' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'comment'    => 'Kode mata pelajaran',
            ],
            'kd_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'comment'    => 'Kode kelas',
            ],
            'kd_jurusan' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'comment'    => 'Kode jurusan',
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
            'kd_ruangan' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'comment'    => 'Kode ruangan',
            ],
            'nik_nip' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
                'comment'    => 'NIK/NIP guru pengawas',
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
        $this->forge->addForeignKey('kd_mapel', 'mapel', 'kd_mapel', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kd_kelas', 'kelas', 'kd_kelas', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kd_jurusan', 'jurusan', 'kd_jurusan', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('kd_ruangan', 'ruangan', 'kd_ruangan', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('nik_nip', 'guru', 'nik_nip', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jadwal_ujian');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal_ujian');
    }
}
