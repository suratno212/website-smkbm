<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWaliKelasIdToKelas extends Migration
{
    public function up()
    {
        // Kolom wali_kelas_id sudah ada, tidak perlu ditambah lagi
        // $this->forge->addColumn('kelas', [
        //     'wali_kelas_id' => [
        //         'type' => 'VARCHAR',
        //         'constraint' => '25',
        //         'null' => true,
        //         'after' => 'kd_jurusan',
        //     ],
        // ]);
        // $this->forge->addForeignKey('wali_kelas_id', 'guru', 'nik_nip', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        // Kolom wali_kelas_id tidak ada di tabel kelas, jadi tidak perlu drop foreign key
        // $this->forge->dropForeignKey('kelas', 'kelas_wali_kelas_id_foreign');
        // $this->forge->dropColumn('kelas', 'wali_kelas_id');
    }
} 