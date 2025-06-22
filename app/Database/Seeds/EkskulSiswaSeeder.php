<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EkskulSiswaSeeder extends Seeder
{
    public function run()
    {
        // Ambil tahun akademik aktif
        $tahunAkademik = $this->db->table('tahun_akademik')->where('status', 'Aktif')->get()->getRow();
        
        if (!$tahunAkademik) {
            echo "Tidak ada tahun akademik aktif\n";
            return;
        }
        
        // Ambil ekstrakurikuler yang ada
        $ekstrakurikuler = $this->db->table('ekstrakurikuler')->get()->getResultArray();
        
        if (empty($ekstrakurikuler)) {
            echo "Tidak ada data ekstrakurikuler\n";
            return;
        }
        
        // Ambil siswa yang ada
        $siswa = $this->db->table('siswa')->get()->getResultArray();
        
        if (empty($siswa)) {
            echo "Tidak ada data siswa\n";
            return;
        }
        
        // Tambah ekstrakurikuler untuk setiap siswa
        foreach ($siswa as $s) {
            // Ambil 1-2 ekstrakurikuler random untuk setiap siswa
            $randomEkskul = array_rand($ekstrakurikuler, min(2, count($ekstrakurikuler)));
            if (!is_array($randomEkskul)) {
                $randomEkskul = [$randomEkskul];
            }
            
            foreach ($randomEkskul as $index) {
                $ekskul = $ekstrakurikuler[$index];
                
                $this->db->table('ekstrakurikuler_siswa')->insert([
                    'siswa_id' => $s['id'],
                    'ekstrakurikuler_id' => $ekskul['id'],
                    'tahun_akademik_id' => $tahunAkademik->id,
                    'nilai' => rand(80, 95),
                    'keterangan' => 'Aktif mengikuti kegiatan',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        
        echo "Data ekstrakurikuler siswa berhasil ditambahkan\n";
    }
} 