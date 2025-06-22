<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePertemuanTable extends Migration
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
            'kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pertemuan');
    }

    public function down()
    {
        $this->forge->dropTable('pertemuan');
    }
} 