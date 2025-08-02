<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailToGuruAndSiswa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('guru', [
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'nama',
            ],
        ]);
        $this->forge->addColumn('siswa', [
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'nama',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('guru', 'email');
        $this->forge->dropColumn('siswa', 'email');
    }
}
