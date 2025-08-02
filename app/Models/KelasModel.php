<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table            = 'kelas';
    protected $primaryKey       = 'kd_kelas';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['kd_kelas', 'nama_kelas', 'tingkat', 'kd_jurusan', 'wali_kelas_nik_nip', 'kuota'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getKelasWithJurusan($filters = [])
    {
        $builder = $this->db->table('kelas')
            ->select('kelas.*, jurusan.nama_jurusan, guru.nama as nama_wali_kelas')
            ->join('jurusan', 'jurusan.kd_jurusan = kelas.kd_jurusan', 'left')
            ->join('guru', 'guru.nik_nip = kelas.wali_kelas_nik_nip', 'left');

        if (!empty($filters['kd_jurusan'])) {
            $builder->where('kelas.kd_jurusan', $filters['kd_jurusan']);
        }

        return $builder->get()->getResultArray();
    }

    public function getKelasWithWaliKelas()
    {
        $builder = $this->db->table('kelas')
            ->select('kelas.*, jurusan.nama_jurusan, guru.nama as nama_wali_kelas')
            ->join('jurusan', 'jurusan.kd_jurusan = kelas.kd_jurusan', 'left')
            ->join('guru', 'guru.nik_nip = kelas.wali_kelas_id', 'left');
        return $builder->get()->getResultArray();
    }

    // Validation
    protected $validationRules      = [
        'kd_kelas' => 'required|is_unique[kelas.kd_kelas]',
        'nama_kelas' => 'required',
        'tingkat' => 'required',
        'kd_jurusan' => 'required'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
} 