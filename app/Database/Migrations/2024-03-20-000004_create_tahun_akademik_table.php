<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTahunAkademikTable extends Migration
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
            'tahun' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'semester' => [
                'type'       => 'ENUM',
                'constraint' => ['Ganjil', 'Genap'],
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
        $this->forge->createTable('tahun_akademik');
    }

    public function down()
    {
        $this->forge->dropTable('tahun_akademik');
    }
} 