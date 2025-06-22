<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class MateriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'guru_id'    => 1,
                'mapel_id'   => 1,
                'kelas_id'   => 1,
                'judul'      => 'Materi Matematika',
                'deskripsi'  => 'Deskripsi materi matematika',
                'file'       => 'materi_matematika.pdf',
            ],
            [
                'guru_id'    => 1,
                'mapel_id'   => 2,
                'kelas_id'   => 1,
                'judul'      => 'Materi Bahasa Indonesia',
                'deskripsi'  => 'Deskripsi materi bahasa indonesia',
                'file'       => 'materi_bahasa_indonesia.pdf',
            ],
        ];
        $this->db->table('materi')->insertBatch($data);
    }
} 