<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PertemuanSeeder extends Seeder
{
    public function run()
    {
        $kelas = $this->db->table('kelas')->get()->getResultArray();
        $mapel = $this->db->table('mapel')->get()->getResultArray();
        $data = [];
        $i = 1;
        foreach ($kelas as $k) {
            foreach ($mapel as $m) {
                $data[] = [
                    'kelas_id' => $k['id'],
                    'mapel_id' => $m['id'],
                    'nama_pertemuan' => 'Pertemuan '.$i,
                    'tanggal' => date('Y-m-d', strtotime("2024-06-".str_pad($i,2,'0',STR_PAD_LEFT))),
                    'topik' => 'Topik ke-'.$i,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $i++;
                if ($i > 5) break; // hanya 5 pertemuan dummy per kelas-mapel
            }
        }
        $this->db->table('pertemuan')->insertBatch($data);
    }
} 