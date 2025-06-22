<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddSiswaUserSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Cek apakah user sudah ada
        $existingUser = $db->table('users')->where('username', 'sura')->get()->getRow();
        
        if (!$existingUser) {
            // Insert user
            $userData = [
                'username' => 'sura',
                'password' => password_hash('siswa123', PASSWORD_DEFAULT),
                'role' => 'siswa',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('users')->insert($userData);
            $user_id = $db->insertID();
            
            // Insert data siswa
            $siswaData = [
                'user_id' => $user_id,
                'nisn' => '2024001',
                'nama' => 'Sura',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2006-01-15',
                'agama' => 'Islam',
                'kelas_id' => 1,
                'jurusan_id' => 1,
                'alamat' => 'Jl. Contoh No. 123',
                'no_hp' => '081234567890',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('siswa')->insert($siswaData);
            
            echo "User siswa 'sura' berhasil ditambahkan!\n";
            echo "Username: sura\n";
            echo "Password: siswa123\n";
        } else {
            echo "User siswa 'sura' sudah ada!\n";
        }
    }
} 