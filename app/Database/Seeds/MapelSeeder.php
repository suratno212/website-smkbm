<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key check
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        // Hapus semua data mapel sebelum insert baru
        $this->db->table('mapel')->truncate();
        $this->db->query("ALTER TABLE mapel AUTO_INCREMENT = 1");
        // Aktifkan kembali foreign key check
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            // Kelompok A (Wajib)
            ['kd_mapel' => 'PABP', 'nama_mapel' => 'Pendidikan Agama dan Budi Pekerti', 'kelompok' => 'A', 'kd_jurusan' => null],
            ['kd_mapel' => 'PPKN', 'nama_mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'kelompok' => 'A', 'kd_jurusan' => null],
            ['kd_mapel' => 'BIN', 'nama_mapel' => 'Bahasa Indonesia', 'kelompok' => 'A', 'kd_jurusan' => null],
            ['kd_mapel' => 'MTK', 'nama_mapel' => 'Matematika', 'kelompok' => 'A', 'kd_jurusan' => null],
            ['kd_mapel' => 'SEJ', 'nama_mapel' => 'Sejarah Indonesia', 'kelompok' => 'A', 'kd_jurusan' => null],
            ['kd_mapel' => 'BIG', 'nama_mapel' => 'Bahasa Inggris dan Bahasa Asing Lainnya', 'kelompok' => 'A', 'kd_jurusan' => null],
            
            // Kelompok B (Wajib)
            ['kd_mapel' => 'SBD', 'nama_mapel' => 'Seni Budaya', 'kelompok' => 'B', 'kd_jurusan' => null],
            ['kd_mapel' => 'PJOK', 'nama_mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'kelompok' => 'B', 'kd_jurusan' => null],
            
            // Kelompok C1 (Dasar Bidang Keahlian) - TKJ
            ['kd_mapel' => 'SKD', 'nama_mapel' => 'Simulasi dan Komunikasi Digital', 'kelompok' => 'C1', 'kd_jurusan' => 'TKJ'],
            ['kd_mapel' => 'FIS', 'nama_mapel' => 'Fisika', 'kelompok' => 'C1', 'kd_jurusan' => 'TKJ'],
            ['kd_mapel' => 'KIM', 'nama_mapel' => 'Kimia', 'kelompok' => 'C1', 'kd_jurusan' => 'TKJ'],
            
            // Kelompok C2 (Dasar Program Keahlian) - TKJ
            ['kd_mapel' => 'SISKOM', 'nama_mapel' => 'Sistem Komputer', 'kelompok' => 'C2', 'kd_jurusan' => 'TKJ'],
            ['kd_mapel' => 'KJD', 'nama_mapel' => 'Komputer dan Jaringan Dasar', 'kelompok' => 'C2', 'kd_jurusan' => 'TKJ'],
            ['kd_mapel' => 'PD', 'nama_mapel' => 'Pemrograman Dasar', 'kelompok' => 'C2', 'kd_jurusan' => 'TKJ'],
            ['kd_mapel' => 'DDG', 'nama_mapel' => 'Dasar Desain Grafis', 'kelompok' => 'C2', 'kd_jurusan' => 'MM'],
            
            // Kelompok C2 (Dasar Program Keahlian) - TBSM
            ['kd_mapel' => 'GTO', 'nama_mapel' => 'Gambar Teknik Otomotif', 'kelompok' => 'C2', 'kd_jurusan' => 'TBSM'],
            ['kd_mapel' => 'TDO', 'nama_mapel' => 'Teknologi Dasar Otomotif', 'kelompok' => 'C2', 'kd_jurusan' => 'TBSM'],
            ['kd_mapel' => 'PDTO', 'nama_mapel' => 'Pekerjaan Dasar Teknik Otomotif', 'kelompok' => 'C2', 'kd_jurusan' => 'TBSM'],
            
            // Kelompok C3 (Kompetensi Keahlian) - TKJ
            ['kd_mapel' => 'TJBL', 'nama_mapel' => 'Teknologi Jaringan Berbasis Luas (WAN)', 'kelompok' => 'C3', 'kd_jurusan' => 'TKJ'],
            ['kd_mapel' => 'AIJ', 'nama_mapel' => 'Administrasi Infrastruktur Jaringan', 'kelompok' => 'C3', 'kd_jurusan' => 'TKJ'],
            ['kd_mapel' => 'ASJ', 'nama_mapel' => 'Administrasi Sistem Jaringan', 'kelompok' => 'C3', 'kd_jurusan' => 'TKJ'],
            ['kd_mapel' => 'TLJ', 'nama_mapel' => 'Teknologi Layanan Jaringan', 'kelompok' => 'C3', 'kd_jurusan' => 'TKJ'],
            ['kd_mapel' => 'PKK', 'nama_mapel' => 'Produk Kreatif dan Kewirausahaan', 'kelompok' => 'C3', 'kd_jurusan' => null],
            
            // Kelompok C3 (Kompetensi Keahlian) - TBSM
            ['kd_mapel' => 'PMSM', 'nama_mapel' => 'Pemeliharaan Mesin Sepeda Motor', 'kelompok' => 'C3', 'kd_jurusan' => 'TBSM'],
            ['kd_mapel' => 'PSSM', 'nama_mapel' => 'Pemeliharaan Sasis Sepeda Motor', 'kelompok' => 'C3', 'kd_jurusan' => 'TBSM'],
            ['kd_mapel' => 'PKSM', 'nama_mapel' => 'Pemeliharaan Kelistrikan Sepeda Motor', 'kelompok' => 'C3', 'kd_jurusan' => 'TBSM'],
            ['kd_mapel' => 'PBSM', 'nama_mapel' => 'Pengelolaan Bengkel Sepeda Motor', 'kelompok' => 'C3', 'kd_jurusan' => 'TBSM']
        ];

        foreach ($data as $item) {
            $item['created_at'] = date('Y-m-d H:i:s');
            $item['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('mapel')->insert($item);
        }
    }
} 