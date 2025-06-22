<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NilaiSiswaSeeder extends Seeder
{
    public function run()
    {
        // Ambil tahun akademik aktif
        $tahunAkademik = $this->db->table('tahun_akademik')->where('status', 'Aktif')->get()->getRow();
        
        if (!$tahunAkademik) {
            echo "Tidak ada tahun akademik aktif\n";
            return;
        }
        
        // Ambil siswa yang ada
        $siswa = $this->db->table('siswa')->get()->getResultArray();
        
        if (empty($siswa)) {
            echo "Tidak ada data siswa\n";
            return;
        }
        
        // Ambil mata pelajaran yang ada
        $mapel = $this->db->table('mapel')->get()->getResultArray();
        
        if (empty($mapel)) {
            echo "Tidak ada data mata pelajaran\n";
            return;
        }
        
        // Hapus data nilai yang sudah ada untuk menghindari duplikasi
        $this->db->table('nilai')->where('tahun_akademik_id', $tahunAkademik->id)->delete();
        
        // Tambah nilai untuk setiap siswa
        foreach ($siswa as $s) {
            foreach ($mapel as $m) {
                // Generate nilai random yang realistis
                $uts = rand(70, 95);
                $uas = rand(70, 95);
                $tugas = rand(80, 100);
                $akhir = round(($uts * 0.3) + ($uas * 0.4) + ($tugas * 0.3));
                
                $this->db->table('nilai')->insert([
                    'siswa_id' => $s['id'],
                    'mapel_id' => $m['id'],
                    'tahun_akademik_id' => $tahunAkademik->id,
                    'semester' => $tahunAkademik->semester,
                    'uts' => $uts,
                    'uas' => $uas,
                    'tugas' => $tugas,
                    'akhir' => $akhir,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        
        echo "Data nilai siswa berhasil ditambahkan\n";
    }
} 