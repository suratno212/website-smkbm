<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class TugasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'guru_id'    => 1,
                'mapel_id'   => 1,
                'kelas_id'   => 1,
                'judul'      => 'Tugas Matematika',
                'deskripsi'  => 'Deskripsi tugas matematika',
                'deadline'   => '2024-03-25 23:59:59',
            ],
            [
                'guru_id'    => 1,
                'mapel_id'   => 2,
                'kelas_id'   => 1,
                'judul'      => 'Tugas Bahasa Indonesia',
                'deskripsi'  => 'Deskripsi tugas bahasa indonesia',
                'deadline'   => '2024-03-26 23:59:59',
            ],
        ];
        $this->db->table('tugas')->insertBatch($data);
    }
} 