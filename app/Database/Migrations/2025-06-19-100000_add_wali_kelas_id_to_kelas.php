<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWaliKelasIdToKelas extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kelas', [
            'wali_kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'jurusan_id',
            ],
        ]);
        $this->forge->addForeignKey('wali_kelas_id', 'guru', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('kelas', 'kelas_wali_kelas_id_foreign');
        $this->forge->dropColumn('kelas', 'wali_kelas_id');
    }
} 