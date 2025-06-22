<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ResetGuruSeeder extends Seeder
{
    public function run()
    {
        // Hapus data guru yang ada
        $this->db->table('guru')->where('id >', 0)->delete();
        
        // Reset auto increment
        $this->db->query("ALTER TABLE guru AUTO_INCREMENT = 1");
        
        // Data guru
        $data = [
            [
                'user_id' => 2,
                'nip_nuptk' => '198001012010011001',
                'nama' => 'Ahmad Supriadi',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1980-01-01',
                'agama' => 'Islam',
                'mapel_id' => 1, // Matematika
                'alamat' => 'Jl. Ahmad No. 1, Jakarta',
                'no_hp' => '081234567890'
            ],
            [
                'user_id' => 3,
                'nip_nuptk' => '198502152010012002',
                'nama' => 'Siti Nurhaliza',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-02-15',
                'agama' => 'Islam',
                'mapel_id' => 2, // Bahasa Indonesia
                'alamat' => 'Jl. Siti No. 2, Bandung',
                'no_hp' => '081234567891'
            ],
            [
                'user_id' => 4,
                'nip_nuptk' => '198803201010013003',
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1988-03-20',
                'agama' => 'Islam',
                'mapel_id' => 3, // Bahasa Inggris
                'alamat' => 'Jl. Budi No. 3, Surabaya',
                'no_hp' => '081234567892'
            ],
            [
                'user_id' => 5,
                'nip_nuptk' => '199004101010014004',
                'nama' => 'Rina Marlina',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '1990-04-10',
                'agama' => 'Islam',
                'mapel_id' => 4, // Fisika
                'alamat' => 'Jl. Rina No. 4, Semarang',
                'no_hp' => '081234567893'
            ],
            [
                'user_id' => 6,
                'nip_nuptk' => '198706151010015005',
                'nama' => 'Joko Widodo',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Solo',
                'tanggal_lahir' => '1987-06-15',
                'agama' => 'Islam',
                'mapel_id' => 5, // Kimia
                'alamat' => 'Jl. Joko No. 5, Solo',
                'no_hp' => '081234567894'
            ],
            [
                'user_id' => 7,
                'nip_nuptk' => '199208251010016006',
                'nama' => 'Sri Wahyuni',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '1992-08-25',
                'agama' => 'Islam',
                'mapel_id' => 6, // Biologi
                'alamat' => 'Jl. Sri No. 6, Yogyakarta',
                'no_hp' => '081234567895'
            ]
        ];

        $this->db->table('guru')->insertBatch($data);
    }
} 