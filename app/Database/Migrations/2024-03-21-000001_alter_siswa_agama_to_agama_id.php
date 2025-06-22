<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterSiswaAgamaToAgamaId extends Migration
{
    public function up()
    {
        // Check if agama column exists and drop it
        if ($this->db->fieldExists('agama', 'siswa')) {
            $this->forge->dropColumn('siswa', 'agama');
        }
        
        // Add agama_id column if it doesn't exist
        if (!$this->db->fieldExists('agama_id', 'siswa')) {
            $this->forge->addColumn('siswa', [
                'agama_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'tanggal_lahir'
                ]
            ]);
        }
        
        // Add foreign key constraint if it doesn't exist
        $this->forge->addForeignKey('agama_id', 'agama', 'id', 'CASCADE', 'SET NULL');
    }

    public function down()
    {
        // Remove foreign key constraint
        $this->forge->dropForeignKey('siswa', 'siswa_agama_id_foreign');
        
        // Drop agama_id column if it exists
        if ($this->db->fieldExists('agama_id', 'siswa')) {
            $this->forge->dropColumn('siswa', 'agama_id');
        }
        
        // Add back the agama column if it doesn't exist
        if (!$this->db->fieldExists('agama', 'siswa')) {
            $this->forge->addColumn('siswa', [
                'agama' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'tanggal_lahir'
                ]
            ]);
        }
    }
} 