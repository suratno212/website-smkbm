<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNisnToSpmb extends Migration
{
    public function up()
    {
        $this->forge->addColumn('spmb', [
            'nisn' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => true,
                'after' => 'no_pendaftaran'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('spmb', 'nisn');
    }
}