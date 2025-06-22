<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenamePpdbToSpmb extends Migration
{
    public function up()
    {
        $this->db->query('RENAME TABLE ppdb TO spmb');
    }

    public function down()
    {
        $this->db->query('RENAME TABLE spmb TO ppdb');
    }
} 