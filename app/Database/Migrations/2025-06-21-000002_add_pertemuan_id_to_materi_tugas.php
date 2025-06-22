<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPertemuanIdToMateriTugas extends Migration
{
    public function up()
    {
        // Tambah ke materi
        $this->forge->addColumn('materi', [
            'pertemuan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'kelas_id',
            ],
        ]);
        $this->db->query('ALTER TABLE materi ADD CONSTRAINT fk_materi_pertemuan FOREIGN KEY (pertemuan_id) REFERENCES pertemuan(id) ON DELETE SET NULL ON UPDATE CASCADE');
        // Tambah ke tugas
        $this->forge->addColumn('tugas', [
            'pertemuan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'kelas_id',
            ],
        ]);
        $this->db->query('ALTER TABLE tugas ADD CONSTRAINT fk_tugas_pertemuan FOREIGN KEY (pertemuan_id) REFERENCES pertemuan(id) ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('materi', 'fk_materi_pertemuan');
        $this->forge->dropColumn('materi', 'pertemuan_id');
        $this->forge->dropForeignKey('tugas', 'fk_tugas_pertemuan');
        $this->forge->dropColumn('tugas', 'pertemuan_id');
    }
} 