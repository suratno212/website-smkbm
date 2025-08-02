<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVideoUrlToMateri extends Migration
{
    public function up()
    {
        $this->forge->addColumn('materi', [
            'video_url' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'file'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('materi', 'video_url');
    }
}
