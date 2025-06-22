<?php
namespace App\Models;

use CodeIgniter\Model;

class PengumpulanTugasModel extends Model
{
    protected $table = 'pengumpulan_tugas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tugas_id', 'siswa_id', 'file_tugas', 'status', 'nilai', 'catatan', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Ambil pengumpulan tugas beserta data siswa
    public function getByTugasId($tugas_id)
    {
        return $this->select('pengumpulan_tugas.*, siswa.nama as nama_siswa, siswa.nisn')
            ->join('siswa', 'siswa.id = pengumpulan_tugas.siswa_id')
            ->where('pengumpulan_tugas.tugas_id', $tugas_id)
            ->findAll();
    }
} 