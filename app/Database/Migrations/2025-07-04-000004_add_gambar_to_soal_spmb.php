<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGambarToSoalSpmb extends Migration
{
    public function up()
    {
        $this->forge->addColumn('soal_spmb', [
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'soal'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('soal_spmb', 'gambar');
    }
} 
 
 
 
 
 