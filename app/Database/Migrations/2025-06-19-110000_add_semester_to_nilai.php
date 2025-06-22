<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSemesterToNilai extends Migration
{
    public function up()
    {
        $this->forge->addColumn('nilai', [
            'semester' => [
                'type'       => 'ENUM',
                'constraint' => ['Ganjil', 'Genap'],
                'default'    => 'Ganjil',
                'after'      => 'tahun_akademik_id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('nilai', 'semester');
    }
} 