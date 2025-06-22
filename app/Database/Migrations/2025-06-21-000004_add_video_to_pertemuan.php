<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVideoToPertemuan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pertemuan', [
            'video_youtube' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'topik',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pertemuan', 'video_youtube');
    }
} 