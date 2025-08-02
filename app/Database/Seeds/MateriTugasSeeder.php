<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MateriTugasSeeder extends Seeder
{
    public function run()
    {
        // Truncate tabel tugas dan materi agar tidak duplikat
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        $this->db->table('tugas')->truncate();
        $this->db->table('materi')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil data mapel dan kelas yang sudah ada
        $mapel = $this->db->table('mapel')->where('kd_mapel', 'MTK')->get()->getRowArray();
        $kelas = $this->db->table('kelas')->where('kd_kelas', 'X-TKJ-1')->get()->getRowArray();
        $guru = $this->db->table('guru')->where('nik_nip', '198001010001')->get()->getRowArray();

        if (!$mapel || !$kelas || !$guru) {
            echo "Data mapel, kelas, atau guru tidak ditemukan\n";
            return;
        }

        // Insert materi
        $materiData = [
            [
                'nik_nip' => $guru['nik_nip'],
                'kd_mapel' => $mapel['kd_mapel'],
                'kd_kelas' => $kelas['kd_kelas'],
                'judul' => 'Materi Matematika Dasar',
                'deskripsi' => 'Pengenalan konsep matematika dasar untuk kelas X',
                'file' => 'materi_matematika_dasar.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('materi')->insertBatch($materiData);

        // Insert tugas
        $tugasData = [
            [
                'kd_tugas'   => 'TGS001',
                'nik_nip'   => $guru['nik_nip'],
                'kd_mapel'  => $mapel['kd_mapel'],
                'kd_kelas'  => $kelas['kd_kelas'],
                'judul'     => 'Tugas Matematika 1',
                'deskripsi' => 'Mengerjakan soal-soal matematika dasar',
                'deadline'  => date('Y-m-d H:i:s', strtotime('+7 days')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('tugas')->insertBatch($tugasData);

        // Ambil data mapel dan kelas untuk tugas kedua
        $mapel2 = $this->db->table('mapel')->where('kd_mapel', 'BIN')->get()->getRowArray();
        $kelas2 = $this->db->table('kelas')->where('kd_kelas', 'X-TKJ-1')->get()->getRowArray();
        $guru2 = $this->db->table('guru')->where('nik_nip', '198001010001')->get()->getRowArray();

        if ($mapel2 && $kelas2 && $guru2) {
            // Insert materi kedua
            $materiData2 = [
                [
                    'nik_nip' => $guru2['nik_nip'],
                    'kd_mapel' => $mapel2['kd_mapel'],
                    'kd_kelas' => $kelas2['kd_kelas'],
                    'judul' => 'Materi Bahasa Indonesia',
                    'deskripsi' => 'Pengenalan konsep bahasa Indonesia',
                    'file' => 'materi_bahasa_indonesia.pdf',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ];

            $this->db->table('materi')->insertBatch($materiData2);

            // Insert tugas kedua
            $tugasData2 = [
                [
                    'kd_tugas'   => 'TGS002',
                    'nik_nip'   => $guru2['nik_nip'],
                    'kd_mapel'  => $mapel2['kd_mapel'],
                    'kd_kelas'  => $kelas2['kd_kelas'],
                    'judul'     => 'Tugas Bahasa Indonesia 1',
                    'deskripsi' => 'Membuat karangan singkat',
                    'deadline'  => date('Y-m-d H:i:s', strtotime('+5 days')),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ];

            $this->db->table('tugas')->insertBatch($tugasData2);
        }
    }
} 