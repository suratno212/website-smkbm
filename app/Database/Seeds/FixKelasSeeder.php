<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FixKelasSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah kelas dengan id 1 sudah ada
        $existing = $this->db->table('kelas')->where('id', 1)->get()->getRow();
        
        if (!$existing) {
            $this->db->table('kelas')->insert([
                'id' => 1,
                'nama_kelas' => 'X TKJ 1',
                'tingkat' => 10,
                'jurusan_id' => 2,
                'wali_kelas_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            echo "Kelas X TKJ 1 berhasil ditambahkan\n";
        } else {
            echo "Kelas dengan id 1 sudah ada\n";
        }
    }
} 