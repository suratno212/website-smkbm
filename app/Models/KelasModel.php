<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_kelas', 'tingkat', 'jurusan_id', 'wali_kelas_id', 'kuota'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getKelasWithRelations()
    {
        return $this->select('kelas.*, jurusan.nama_jurusan, guru.nama as nama_wali_kelas')
                    ->join('jurusan', 'jurusan.id = kelas.jurusan_id', 'left')
                    ->join('guru', 'guru.id = kelas.wali_kelas_id', 'left')
                    ->findAll();
    }
} 