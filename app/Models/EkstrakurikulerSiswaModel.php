<?php

namespace App\Models;

use CodeIgniter\Model;

class EkstrakurikulerSiswaModel extends Model
{
    protected $table = 'ekstrakurikuler_siswa';
    protected $primaryKey = 'kd_ekstrakurikuler_siswa';
    protected $allowedFields = [
        'kd_ekstrakurikuler_siswa', 'kd_ekstrakurikuler', 'nis', 'tahun_ajaran', 'nilai', 'keterangan', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getEkskulSiswa($nis, $tahun_ajaran)
    {
        return $this->select('ekstrakurikuler_siswa.*, ekstrakurikuler.nama_ekstrakurikuler')
            ->join('ekstrakurikuler', 'ekstrakurikuler.kd_ekstrakurikuler = ekstrakurikuler_siswa.kd_ekstrakurikuler')
            ->where('ekstrakurikuler_siswa.nis', $nis)
            ->where('ekstrakurikuler_siswa.tahun_ajaran', $tahun_ajaran)
            ->findAll();
    }
} 