<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Hapus semua data users sebelum insert baru
        $this->db->table('users')->truncate();
        $this->db->query("ALTER TABLE users AUTO_INCREMENT = 1");
        $now = date('Y-m-d H:i:s');
        
        // Data admin
        $data = [
            [
                'username'    => 'admin',
                'password'    => password_hash('admin123', PASSWORD_DEFAULT),
                'role'        => 'admin',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            // Data guru (username = nama, password = tanggal lahir)
            [
                'username'    => 'Ahmad Supriadi',
                'password'    => password_hash('1980-01-01', PASSWORD_DEFAULT),
                'role'        => 'guru',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'username'    => 'Siti Nurhaliza',
                'password'    => password_hash('1985-02-15', PASSWORD_DEFAULT),
                'role'        => 'guru',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'username'    => 'Budi Santoso',
                'password'    => password_hash('1988-03-20', PASSWORD_DEFAULT),
                'role'        => 'guru',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'username'    => 'Rina Marlina',
                'password'    => password_hash('1990-04-10', PASSWORD_DEFAULT),
                'role'        => 'guru',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'username'    => 'Joko Widodo',
                'password'    => password_hash('1987-06-15', PASSWORD_DEFAULT),
                'role'        => 'guru',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'username'    => 'Sri Wahyuni',
                'password'    => password_hash('1992-08-25', PASSWORD_DEFAULT),
                'role'        => 'guru',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            // Data siswa (username = NIS, password = tanggal lahir)
            [
                'username'    => '2024001',
                'password'    => password_hash('2006-03-15', PASSWORD_DEFAULT),
                'role'        => 'siswa',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'username'    => '2024002',
                'password'    => password_hash('2006-05-20', PASSWORD_DEFAULT),
                'role'        => 'siswa',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'username'    => '2024003',
                'password'    => password_hash('2006-07-10', PASSWORD_DEFAULT),
                'role'        => 'siswa',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'username'    => '2024004',
                'password'    => password_hash('2006-09-25', PASSWORD_DEFAULT),
                'role'        => 'siswa',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'username'    => '2024005',
                'password'    => password_hash('2006-11-30', PASSWORD_DEFAULT),
                'role'        => 'siswa',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'username'    => '2024006',
                'password'    => password_hash('2006-12-05', PASSWORD_DEFAULT),
                'role'        => 'siswa',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            // Data siswa baru
            [
                'username'    => '2024007',
                'password'    => password_hash('2006-08-12', PASSWORD_DEFAULT),
                'role'        => 'siswa',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'username'    => '2024008',
                'password'    => password_hash('2006-10-22', PASSWORD_DEFAULT),
                'role'        => 'siswa',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
} 