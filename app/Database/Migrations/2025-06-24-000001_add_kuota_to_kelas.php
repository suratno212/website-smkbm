<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class AddKuotaToKelas extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kelas', [
            'kuota' => [
                'type' => 'INT',
                'constraint' => 3,
                'default' => 25,
                'after' => 'wali_kelas_id'
            ]
        ]);
    }
    public function down()
    {
        $this->forge->dropColumn('kelas', 'kuota');
    }
} 