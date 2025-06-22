<?php

namespace App\Models;

use CodeIgniter\Model;

class WaliKelasModel extends Model
{
    protected $table = 'wali_kelas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kelas_id', 'guru_id', 'tahun_akademik_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getWaliKelasWithRelations()
    {
        return $this->select('wali_kelas.*, kelas.nama_kelas, guru.nama as nama_guru, tahun_akademik.tahun, tahun_akademik.semester')
            ->join('kelas', 'kelas.id = wali_kelas.kelas_id')
            ->join('guru', 'guru.id = wali_kelas.guru_id')
            ->join('tahun_akademik', 'tahun_akademik.id = wali_kelas.tahun_akademik_id')
            ->findAll();
    }
} 