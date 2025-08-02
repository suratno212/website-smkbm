<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterRuanganToKdRuangan extends Migration
{
    public function up()
    {
        // Set kd_ruangan sebagai primary key jika belum
        $query = $this->db->query("SHOW KEYS FROM ruangan WHERE Key_name = 'PRIMARY'");
        $primary = $query->getRow();
        if (!$primary) {
            $this->db->query('ALTER TABLE `ruangan` ADD PRIMARY KEY (`kd_ruangan`)');
        }
    }

    public function down()
    {
        // Drop primary key kd_ruangan jika ada
        $query = $this->db->query("SHOW KEYS FROM ruangan WHERE Key_name = 'PRIMARY'");
        $primary = $query->getRow();
        if ($primary && $primary->Column_name === 'kd_ruangan') {
            $this->db->query('ALTER TABLE `ruangan` DROP PRIMARY KEY');
        }
    }
} 