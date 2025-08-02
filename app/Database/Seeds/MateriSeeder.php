<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class MateriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nik_nip'    => '198001010001', // Disesuaikan dengan GuruSeeder
                'kd_mapel'   => 'MTK',
                'kd_kelas'   => 'X-TKJ-1',
                'judul'      => 'Materi Matematika',
                'deskripsi'  => 'Deskripsi materi matematika',
                'file'       => 'materi_matematika.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nik_nip'    => '198001010001', // Disesuaikan dengan GuruSeeder
                'kd_mapel'   => 'BIN',
                'kd_kelas'   => 'X-TKJ-1',
                'judul'      => 'Materi Bahasa Indonesia',
                'deskripsi'  => 'Deskripsi materi bahasa indonesia',
                'file'       => 'materi_bahasa_indonesia.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];
        $this->db->table('materi')->insertBatch($data);
    }
} 