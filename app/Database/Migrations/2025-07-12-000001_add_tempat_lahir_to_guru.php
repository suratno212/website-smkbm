<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTempatLahirToGuru extends Migration
{
    public function up()
    {
        $this->forge->addColumn('guru', [
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'jenis_kelamin',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('guru', 'tempat_lahir');
    }
} 