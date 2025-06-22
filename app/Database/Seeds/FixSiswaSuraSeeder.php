<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FixSiswaSuraSeeder extends Seeder
{
    public function run()
    {
        // Cari user dengan username 'sura'
        $user = $this->db->table('users')->where('username', 'sura')->get()->getRowArray();
        
        if (!$user) {
            echo "User 'sura' tidak ditemukan di tabel users\n";
            return;
        }
        
        // Cek apakah sudah ada data siswa untuk user ini
        $existingSiswa = $this->db->table('siswa')->where('user_id', $user['id'])->get()->getRowArray();
        
        if ($existingSiswa) {
            echo "Data siswa untuk user 'sura' sudah ada\n";
            return;
        }
        
        // Ambil jurusan pertama sebagai default
        $jurusan = $this->db->table('jurusan')->get()->getRowArray();
        if (!$jurusan) {
            echo "Tidak ada data jurusan. Membuat jurusan default...\n";
            $this->db->table('jurusan')->insert([
                'nama_jurusan' => 'Teknik Komputer dan Jaringan'
            ]);
            $jurusan = $this->db->table('jurusan')->get()->getRowArray();
        }
        
        // Ambil kelas pertama sebagai default
        $kelas = $this->db->table('kelas')->get()->getRowArray();
        if (!$kelas) {
            echo "Tidak ada data kelas. Membuat kelas default...\n";
            $this->db->table('kelas')->insert([
                'nama_kelas' => 'X TKJ 1',
                'tingkat' => 'X',
                'jurusan_id' => $jurusan['id'],
                'wali_kelas_id' => null
            ]);
            $kelas = $this->db->table('kelas')->get()->getRowArray();
        }
        
        // Ambil id agama Islam
        $agama = $this->db->table('agama')->where('nama_agama', 'Islam')->get()->getRowArray();
        $agama_id = $agama ? $agama['id'] : null;
        
        // Insert data siswa
        $siswaData = [
            'user_id' => $user['id'],
            'nisn' => '2024001',
            'nama' => 'Sura Siswa',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2006-01-15',
            'agama_id' => $agama_id,
            'kelas_id' => $kelas['id'],
            'jurusan_id' => $jurusan['id'],
            'alamat' => 'Jl. Contoh No. 123',
            'no_hp' => '081234567890',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->table('siswa')->insert($siswaData);
        
        echo "Data siswa untuk user 'sura' berhasil ditambahkan\n";
        echo "NISN: 2024001\n";
        echo "Nama: Sura Siswa\n";
        echo "Kelas: " . $kelas['nama_kelas'] . "\n";
        echo "Jurusan: " . $jurusan['nama_jurusan'] . "\n";
    }
} 