<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'role',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'email');
    }
} 