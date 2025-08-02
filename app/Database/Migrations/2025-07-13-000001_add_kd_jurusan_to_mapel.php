<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKdJurusanToMapel extends Migration
{
    public function up()
    {
        $fields = [
            'kd_jurusan' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
                'default' => null,
                'after' => 'kelompok',
            ],
        ];
        $this->forge->addColumn('mapel', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('mapel', 'kd_jurusan');
    }
} 