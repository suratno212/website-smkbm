<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EkskulSiswaSeeder extends Seeder
{
    public function run()
    {
        // Ambil tahun akademik aktif
        $tahunAkademik = $this->db->table('tahun_akademik')->where('status', 'Aktif')->get()->getRowArray();
        if (!$tahunAkademik) {
            echo "Tidak ada tahun akademik aktif\n";
            return;
        }
        $tahun = $tahunAkademik['tahun'];
        $semester = $tahunAkademik['semester'];
        // Ambil semua siswa
        $siswaList = $this->db->table('siswa')->get()->getResultArray();
        // Ambil semua ekskul
        $ekskulList = $this->db->table('ekstrakurikuler')->get()->getResultArray();
        $data = [];
        foreach ($siswaList as $siswa) {
            foreach ($ekskulList as $ekskul) {
                $data[] = [
                    'kd_ekstrakurikuler_siswa' => $siswa['nis'] . '-' . $ekskul['kd_ekstrakurikuler'] . '-' . $tahun,
                    'kd_ekstrakurikuler' => $ekskul['kd_ekstrakurikuler'],
                    'nis' => $siswa['nis'],
                    'tahun_ajaran' => $tahun,
                    'nilai' => rand(75, 100),
                    'keterangan' => 'Aktif',
                ];
            }
        }
        // Hapus data lama untuk tahun ajaran aktif
        $this->db->table('ekstrakurikuler_siswa')
            ->where('tahun_ajaran', $tahun)
            ->delete();
        // Insert batch
        if (!empty($data)) {
            $this->db->table('ekstrakurikuler_siswa')->insertBatch($data);
        }
        echo "Seeder ekstrakurikuler_siswa selesai.\n";
    }
} 