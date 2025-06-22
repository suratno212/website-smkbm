<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run()
    {
        // Hapus data mapel yang sudah ada (tanpa truncate)
        $this->db->table('mapel')->delete();
        
        // Data mata pelajaran untuk SMK
        $mapelData = [
            ['nama_mapel' => 'Matematika'],
            ['nama_mapel' => 'Bahasa Indonesia'],
            ['nama_mapel' => 'Bahasa Inggris'],
            ['nama_mapel' => 'Pendidikan Agama'],
            ['nama_mapel' => 'PPKN'],
            ['nama_mapel' => 'Sejarah Indonesia'],
            ['nama_mapel' => 'Seni Budaya'],
            ['nama_mapel' => 'PJOK'],
            ['nama_mapel' => 'Fisika'],
            ['nama_mapel' => 'Kimia'],
            ['nama_mapel' => 'Biologi'],
            ['nama_mapel' => 'Ekonomi'],
            ['nama_mapel' => 'Geografi'],
            ['nama_mapel' => 'Sosiologi'],
            ['nama_mapel' => 'Pemrograman Dasar'],
            ['nama_mapel' => 'Komputer dan Jaringan Dasar'],
            ['nama_mapel' => 'Dasar Desain Grafis'],
            ['nama_mapel' => 'Pemodelan Perangkat Lunak'],
            ['nama_mapel' => 'Basis Data'],
            ['nama_mapel' => 'Pemrograman Web'],
            ['nama_mapel' => 'Pemrograman Berorientasi Objek'],
            ['nama_mapel' => 'Administrasi Sistem'],
            ['nama_mapel' => 'Administrasi Infrastruktur Jaringan'],
            ['nama_mapel' => 'Teknologi Layanan Jaringan'],
            ['nama_mapel' => 'Produk Kreatif dan Kewirausahaan']
        ];
        
        foreach ($mapelData as $mapel) {
            $this->db->table('mapel')->insert([
                'nama_mapel' => $mapel['nama_mapel'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        echo "Data mata pelajaran berhasil ditambahkan\n";
    }
} 