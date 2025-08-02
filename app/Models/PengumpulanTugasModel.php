<?php

namespace App\Models;

use CodeIgniter\Model;

class PengumpulanTugasModel extends Model
{
    protected $table = 'pengumpulan_tugas';
    protected $primaryKey = 'kd_pengumpulan';
    protected $allowedFields = [
        'kd_pengumpulan',
        'kd_tugas',
        'nis',
        'file_tugas',
        'status',
        'nilai',
        'catatan',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Ambil pengumpulan tugas beserta data siswa
    public function getByKdTugas($kd_tugas)
    {
        return $this->select('pengumpulan_tugas.*, siswa.nama as nama_siswa, siswa.nis')
            ->join('siswa', 'siswa.nis = pengumpulan_tugas.nis')
            ->where('pengumpulan_tugas.kd_tugas', $kd_tugas)
            ->findAll();
    }
}
