<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAgamaIdToSiswaGuru extends Migration
{
    public function up()
    {
        // siswa
        $this->forge->addColumn('siswa', [
            'agama_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'jurusan_id',
            ],
        ]);
        $this->db->query('ALTER TABLE siswa ADD CONSTRAINT fk_siswa_agama FOREIGN KEY (agama_id) REFERENCES agama(id) ON UPDATE CASCADE ON DELETE SET NULL');
        // guru
        $this->forge->addColumn('guru', [
            'agama_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'jenis_kelamin',
            ],
        ]);
        $this->db->query('ALTER TABLE guru ADD CONSTRAINT fk_guru_agama FOREIGN KEY (agama_id) REFERENCES agama(id) ON UPDATE CASCADE ON DELETE SET NULL');
    }

    public function down()
    {
        $this->forge->dropForeignKey('siswa', 'fk_siswa_agama');
        $this->forge->dropColumn('siswa', 'agama_id');
        $this->forge->dropForeignKey('guru', 'fk_guru_agama');
        $this->forge->dropColumn('guru', 'agama_id');
    }
} 