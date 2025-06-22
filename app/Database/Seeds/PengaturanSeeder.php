<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'key' => 'nama_sekolah',
                'value' => 'SMK Bhakti Mulya BNS',
                'description' => 'Nama lengkap sekolah'
            ],
            [
                'key' => 'alamat_sekolah',
                'value' => 'Jl. Contoh No. 123, Jakarta',
                'description' => 'Alamat lengkap sekolah'
            ],
            [
                'key' => 'telepon_sekolah',
                'value' => '(021) 1234567',
                'description' => 'Nomor telepon sekolah'
            ],
            [
                'key' => 'email_sekolah',
                'value' => 'info@smkbm.sch.id',
                'description' => 'Email resmi sekolah'
            ],
            [
                'key' => 'website_sekolah',
                'value' => 'https://smkbm.sch.id',
                'description' => 'Website resmi sekolah'
            ],
            [
                'key' => 'kepala_sekolah',
                'value' => 'Drs. Kepala Sekolah',
                'description' => 'Nama kepala sekolah'
            ],
            [
                'key' => 'nip_kepala_sekolah',
                'value' => '196001011990031001',
                'description' => 'NIP kepala sekolah'
            ],
            [
                'key' => 'tahun_akademik_aktif',
                'value' => '2024/2025',
                'description' => 'Tahun akademik yang sedang aktif'
            ],
            [
                'key' => 'semester_aktif',
                'value' => 'Ganjil',
                'description' => 'Semester yang sedang aktif'
            ],
            [
                'key' => 'logo_sekolah',
                'value' => '',
                'description' => 'Logo sekolah'
            ],
            [
                'key' => 'favicon_sekolah',
                'value' => '',
                'description' => 'Favicon sekolah'
            ],
            [
                'key' => 'timezone',
                'value' => 'Asia/Jakarta',
                'description' => 'Timezone sistem'
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'description' => 'Mode maintenance (0=off, 1=on)'
            ],
            [
                'key' => 'max_upload_size',
                'value' => '2048',
                'description' => 'Maksimal ukuran upload file (KB)'
            ],
            [
                'key' => 'allowed_file_types',
                'value' => 'jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
                'description' => 'Tipe file yang diizinkan untuk upload'
            ]
        ];

        $this->db->table('pengaturan')->insertBatch($data);
    }
}
