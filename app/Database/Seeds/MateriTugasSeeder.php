<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MateriTugasSeeder extends Seeder
{
    public function run()
    {
        // Ambil data guru yang ada
        $guru = $this->db->table('guru')->get()->getRowArray();
        $mapel = $this->db->table('mapel')->get()->getRowArray();
        $kelas = $this->db->table('kelas')->get()->getRowArray();
        
        if (!$guru || !$mapel || !$kelas) {
            echo "Data guru, mapel, atau kelas tidak ditemukan. Pastikan seeder lain sudah dijalankan.\n";
            return;
        }

        // Insert materi
        $materiData = [
            [
                'guru_id' => $guru['id'],
                'mapel_id' => $mapel['id'],
                'kelas_id' => $kelas['id'],
                'judul' => 'Pengenalan Dasar Pemrograman',
                'deskripsi' => 'Materi pengenalan dasar-dasar pemrograman untuk pemula',
                'file' => 'materi_pemrograman.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'guru_id' => $guru['id'],
                'mapel_id' => $mapel['id'],
                'kelas_id' => $kelas['id'],
                'judul' => 'Struktur Data dan Algoritma',
                'deskripsi' => 'Pembahasan tentang struktur data dan algoritma dasar',
                'file' => 'struktur_data.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('materi')->insertBatch($materiData);

        // Insert tugas
        $tugasData = [
            [
                'guru_id' => $guru['id'],
                'mapel_id' => $mapel['id'],
                'kelas_id' => $kelas['id'],
                'deskripsi' => 'Tugas 1: Membuat Program Hello World',
                'deadline' => date('Y-m-d H:i:s', strtotime('+7 days')),
                'file' => 'tugas_hello_world.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'guru_id' => $guru['id'],
                'mapel_id' => $mapel['id'],
                'kelas_id' => $kelas['id'],
                'deskripsi' => 'Tugas 2: Implementasi Array dan Loop',
                'deadline' => date('Y-m-d H:i:s', strtotime('+14 days')),
                'file' => 'tugas_array_loop.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('tugas')->insertBatch($tugasData);

        echo "Seeder MateriTugasSeeder berhasil dijalankan!\n";
        echo "Ditambahkan " . count($materiData) . " materi dan " . count($tugasData) . " tugas.\n";
    }
} 