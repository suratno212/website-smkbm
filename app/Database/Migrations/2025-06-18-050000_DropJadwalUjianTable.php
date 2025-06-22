<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class DropJadwalUjianTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('jadwal_ujian', true);
    }
    public function down()
    {
        // No rollback
    }
} 