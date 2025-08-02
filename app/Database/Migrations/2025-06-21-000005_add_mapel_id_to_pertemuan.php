<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMapelIdToPertemuan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pertemuan', [
            'kd_mapel' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'kd_kelas',
            ],
        ]);
        $this->db->query('ALTER TABLE pertemuan ADD CONSTRAINT fk_pertemuan_mapel FOREIGN KEY (kd_mapel) REFERENCES mapel(kd_mapel) ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('pertemuan', 'fk_pertemuan_mapel');
        $this->forge->dropColumn('pertemuan', 'kd_mapel');
    }
} 