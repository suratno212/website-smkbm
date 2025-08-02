<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTahunAkademikTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_tahun_akademik' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'tahun' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'semester' => [
                'type'       => 'ENUM',
                'constraint' => ['Ganjil', 'Genap'],
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default' => 'Aktif',
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
        $this->forge->addKey('kd_tahun_akademik', true); // PRIMARY KEY
        $this->forge->createTable('tahun_akademik');
    }

    public function down()
    {
        $this->forge->dropTable('tahun_akademik');
    }
} 