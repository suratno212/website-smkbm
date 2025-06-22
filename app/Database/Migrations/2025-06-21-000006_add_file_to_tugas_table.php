<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFileToTugasTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tugas', [
            'file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'deadline',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tugas', 'file');
    }
} 