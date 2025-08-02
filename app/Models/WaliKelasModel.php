<?php

namespace App\Models;

use CodeIgniter\Model;

class WaliKelasModel extends Model
{
    protected $table = 'wali_kelas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kd_kelas', 'nik_nip', 'kd_tahun_akademik'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getWaliKelasWithRelations()
    {
        return $this->select('wali_kelas.*, kelas.nama_kelas, guru.nama as nama_guru, tahun_akademik.tahun, tahun_akademik.semester')
            ->join('kelas', 'kelas.kd_kelas = wali_kelas.kd_kelas')
            ->join('guru', 'guru.nik_nip = wali_kelas.nik_nip')
            ->join('tahun_akademik', 'tahun_akademik.kd_tahun_akademik = wali_kelas.kd_tahun_akademik')
            ->findAll();
    }
} 