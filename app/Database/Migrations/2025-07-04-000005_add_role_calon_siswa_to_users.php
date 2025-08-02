<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleCalonSiswaToUsers extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE users MODIFY role ENUM('admin','guru','siswa','calon_siswa','kepala_sekolah')");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE users MODIFY role ENUM('admin','guru','siswa','kepala_sekolah')");
    }
} 
 
 
 
 
 