<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMapelIdToPertemuan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pertemuan', [
            'mapel_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'kelas_id',
            ],
        ]);
        $this->db->query('ALTER TABLE pertemuan ADD CONSTRAINT fk_pertemuan_mapel FOREIGN KEY (mapel_id) REFERENCES mapel(id) ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('pertemuan', 'fk_pertemuan_mapel');
        $this->forge->dropColumn('pertemuan', 'mapel_id');
    }
} 