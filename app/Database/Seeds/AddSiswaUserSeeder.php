<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddSiswaUserSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Get siswa data
        $siswa = $db->table('siswa')->get()->getResultArray();
        
        foreach ($siswa as $s) {
            // Check if user already exists for this siswa
            $existingUser = $db->table('users')->where('username', $s['nis'])->get()->getRow();
            
            if (!$existingUser) {
                // Insert user
                $userData = [
                    'username' => $s['nis'],
                    'password' => password_hash($s['tanggal_lahir'], PASSWORD_DEFAULT),
                    'role' => 'siswa',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                $db->table('users')->insert($userData);
                $user_id = $db->insertID();
                
                // Update siswa with user_id
                $db->table('siswa')->where('nis', $s['nis'])->update(['user_id' => $user_id]);
                
                echo "User siswa '" . $s['nama'] . "' (NIS: " . $s['nis'] . ") berhasil ditambahkan!\n";
                echo "Username: " . $s['nis'] . "\n";
                echo "Password: " . $s['tanggal_lahir'] . "\n\n";
            } else {
                echo "User siswa '" . $s['nama'] . "' (NIS: " . $s['nis'] . ") sudah ada!\n";
            }
        }
    }
} 