<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNisToSpmb extends Migration
{
    public function up()
    {
        $fields = [
            'nis' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,
                'null'       => true,
                'after'      => 'email', // letakkan setelah email jika ingin
            ],
        ];
        $this->forge->addColumn('spmb', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('spmb', 'nis');
    }
} 