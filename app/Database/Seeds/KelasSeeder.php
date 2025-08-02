<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        $this->db->table('kelas')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
        $data = [
            [
                'kd_kelas' => 'X-TKJ-1',
                'nama_kelas' => 'X TKJ 1',
                'tingkat' => 'X',
                'kd_jurusan' => 'TKJ', // TKJ
                'wali_kelas_nik_nip' => '198501012010012001',
                'kuota' => 36,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kd_kelas' => 'X-TKJ-2',
                'nama_kelas' => 'X TKJ 2',
                'tingkat' => 'X',
                'kd_jurusan' => 'TKJ', // TKJ
                'wali_kelas_nik_nip' => '198501012010012002',
                'kuota' => 36,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kd_kelas' => 'X-RPL-1',
                'nama_kelas' => 'X RPL 1',
                'tingkat' => 'X',
                'kd_jurusan' => 'RPL', // RPL
                'wali_kelas_nik_nip' => '198501012010012003',
                'kuota' => 36,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kd_kelas' => 'X-MM-1',
                'nama_kelas' => 'X MM 1',
                'tingkat' => 'X',
                'kd_jurusan' => 'MM', // MM
                'wali_kelas_nik_nip' => '198501012010012004',
                'kuota' => 36,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kd_kelas' => 'XI-TKJ-1',
                'nama_kelas' => 'XI TKJ 1',
                'tingkat' => 'XI',
                'kd_jurusan' => 'TKJ', // TKJ
                'wali_kelas_nik_nip' => '198501012010012005',
                'kuota' => 36,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kd_kelas' => 'XI-RPL-1',
                'nama_kelas' => 'XI RPL 1',
                'tingkat' => 'XI',
                'kd_jurusan' => 'RPL', // RPL
                'wali_kelas_nik_nip' => '198501012010012006',
                'kuota' => 36,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('kelas')->insertBatch($data);

        // Update wali kelas untuk kelas yang sudah ada
        $this->db->table('kelas')->where('kd_kelas', 'X-TKJ-1')->update(['wali_kelas_nik_nip' => '198501012010012001']);
        $this->db->table('kelas')->where('kd_kelas', 'X-TKJ-2')->update(['wali_kelas_nik_nip' => '198501012010012002']);
        $this->db->table('kelas')->where('kd_kelas', 'X-RPL-1')->update(['wali_kelas_nik_nip' => '198501012010012003']);
        $this->db->table('kelas')->where('kd_kelas', 'X-MM-1')->update(['wali_kelas_nik_nip' => '198501012010012004']);
        $this->db->table('kelas')->where('kd_kelas', 'XI-TKJ-1')->update(['wali_kelas_nik_nip' => '198501012010012005']);
        $this->db->table('kelas')->where('kd_kelas', 'XI-RPL-1')->update(['wali_kelas_nik_nip' => '198501012010012006']);
    }
} 