<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // A. Muatan Nasional
            ['nama_mapel' => 'Pendidikan Agama dan Budi Pekerti', 'kelompok' => 'A'],
            ['nama_mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'kelompok' => 'A'],
            ['nama_mapel' => 'Bahasa Indonesia', 'kelompok' => 'A'],
            ['nama_mapel' => 'Matematika', 'kelompok' => 'A'],
            ['nama_mapel' => 'Sejarah Indonesia', 'kelompok' => 'A'],
            ['nama_mapel' => 'Bahasa Inggris dan Bahasa Asing Lainnya', 'kelompok' => 'A'],
            // B. Muatan Kewilayahan
            ['nama_mapel' => 'Seni Budaya', 'kelompok' => 'B'],
            ['nama_mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'kelompok' => 'B'],
            // C1. Dasar Bidang Keahlian
            ['nama_mapel' => 'Simulasi dan Komunikasi Digital', 'kelompok' => 'C1'],
            ['nama_mapel' => 'Fisika', 'kelompok' => 'C1'],
            ['nama_mapel' => 'Kimia', 'kelompok' => 'C1'],
            // C2. Dasar Program Keahlian TKJ
            ['nama_mapel' => 'Sistem Komputer', 'kelompok' => 'C2'],
            ['nama_mapel' => 'Komputer dan Jaringan Dasar', 'kelompok' => 'C2'],
            ['nama_mapel' => 'Pemrograman Dasar', 'kelompok' => 'C2'],
            ['nama_mapel' => 'Dasar Desain Grafis', 'kelompok' => 'C2'],
            // C2. Dasar Program Keahlian TBSM
            ['nama_mapel' => 'Gambar Teknik Otomotif', 'kelompok' => 'C2'],
            ['nama_mapel' => 'Teknologi Dasar Otomotif', 'kelompok' => 'C2'],
            ['nama_mapel' => 'Pekerjaan Dasar Teknik Otomotif', 'kelompok' => 'C2'],
            // C3. Kompetensi Keahlian TKJ
            ['nama_mapel' => 'Teknologi Jaringan Berbasis Luas (WAN)', 'kelompok' => 'C3'],
            ['nama_mapel' => 'Administrasi Infrastruktur Jaringan', 'kelompok' => 'C3'],
            ['nama_mapel' => 'Administrasi Sistem Jaringan', 'kelompok' => 'C3'],
            ['nama_mapel' => 'Teknologi Layanan Jaringan', 'kelompok' => 'C3'],
            ['nama_mapel' => 'Produk Kreatif dan Kewirausahaan', 'kelompok' => 'C3'],
            // C3. Kompetensi Keahlian TBSM
            ['nama_mapel' => 'Pemeliharaan Mesin Sepeda Motor', 'kelompok' => 'C3'],
            ['nama_mapel' => 'Pemeliharaan Sasis Sepeda Motor', 'kelompok' => 'C3'],
            ['nama_mapel' => 'Pemeliharaan Kelistrikan Sepeda Motor', 'kelompok' => 'C3'],
            ['nama_mapel' => 'Pengelolaan Bengkel Sepeda Motor', 'kelompok' => 'C3'],
        ];
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('mapel')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
        $this->db->table('mapel')->insertBatch($data);
    }
} 