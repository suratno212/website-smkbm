<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPertemuanIdToMateriTugas extends Migration
{
    public function up()
    {
        // Tambah ke materi
        $this->forge->addColumn('materi', [
            'kd_pertemuan' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'after' => 'kd_kelas',
            ],
        ]);
        $this->db->query('ALTER TABLE materi ADD CONSTRAINT fk_materi_pertemuan FOREIGN KEY (kd_pertemuan) REFERENCES pertemuan(kd_pertemuan) ON DELETE SET NULL ON UPDATE CASCADE');
        // Tambah ke tugas
        $this->forge->addColumn('tugas', [
            'kd_pertemuan' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'after' => 'kd_kelas',
            ],
        ]);
        $this->db->query('ALTER TABLE tugas ADD CONSTRAINT fk_tugas_pertemuan FOREIGN KEY (kd_pertemuan) REFERENCES pertemuan(kd_pertemuan) ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('materi', 'fk_materi_pertemuan');
        $this->forge->dropColumn('materi', 'kd_pertemuan');
        $this->forge->dropForeignKey('tugas', 'fk_tugas_pertemuan');
        $this->forge->dropColumn('tugas', 'kd_pertemuan');
    }
} 