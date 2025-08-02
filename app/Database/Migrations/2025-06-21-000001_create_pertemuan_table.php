<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePertemuanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_pertemuan' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'kd_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'nama_pertemuan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'topik' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
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
        $this->forge->addKey('kd_pertemuan', true); // PRIMARY KEY
        $this->forge->addForeignKey('kd_kelas', 'kelas', 'kd_kelas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pertemuan');
    }

    public function down()
    {
        $this->forge->dropTable('pertemuan');
    }
} 