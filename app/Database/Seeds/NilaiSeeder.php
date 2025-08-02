<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NilaiSeeder extends Seeder
{
    public function run()
    {
        // Ambil data siswa
        $siswaList = $this->db->table('siswa')->get()->getResultArray();
        // Ambil data mapel
        $mapelList = $this->db->table('mapel')->get()->getResultArray();
        // Ambil tahun akademik aktif semester ganjil
        $tahunAkademik = $this->db->table('tahun_akademik')->where('semester', 'Ganjil')->where('status', 'Aktif')->get()->getRowArray();
        if (!$tahunAkademik) {
            echo "Tidak ada tahun akademik ganjil yang aktif.\n";
            return;
        }
        $kd_tahun_akademik = $tahunAkademik['kd_tahun_akademik'];
        $semester = $tahunAkademik['semester'];
        $now = date('Y-m-d H:i:s');
        $data = [];
        foreach ($siswaList as $siswa) {
            foreach ($mapelList as $mapel) {
                $nilai_tugas = rand(70, 90);
                $nilai_uts = rand(70, 90);
                $nilai_uas = rand(70, 90);
                $nilai_akhir = round(($nilai_tugas + $nilai_uts + $nilai_uas) / 3, 2);
                $data[] = [
                    'nis' => $siswa['nis'],
                    'kd_mapel' => $mapel['kd_mapel'],
                    'kd_kelas' => $siswa['kd_kelas'],
                    'kd_jurusan' => $siswa['kd_jurusan'],
                    'kd_tahun_akademik' => $kd_tahun_akademik,
                    'semester' => $semester,
                    'nilai_tugas' => $nilai_tugas,
                    'nilai_uts' => $nilai_uts,
                    'nilai_uas' => $nilai_uas,
                    'nilai_akhir' => $nilai_akhir,
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }
        }
        // Kosongkan tabel nilai untuk semester ganjil tahun aktif
        $this->db->table('nilai')->where('kd_tahun_akademik', $kd_tahun_akademik)->where('semester', $semester)->delete();
        $this->db->table('nilai')->insertBatch($data);
        echo "Seeder nilai untuk semua siswa dan mapel semester ganjil berhasil dijalankan!\n";
    }
} 