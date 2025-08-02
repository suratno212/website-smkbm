<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'siswa';
    protected $primaryKey       = 'nis';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields = ['user_id', 'nis', 'nama', 'tanggal_lahir', 'jenis_kelamin', 'agama_id', 'kd_kelas', 'kd_jurusan', 'alamat', 'no_hp'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getSiswaWithRelations($filters = [])
    {
        $builder = $this->db->table('siswa')
            ->select('siswa.*, kelas.nama_kelas, jurusan.nama_jurusan, agama.nama_agama, users.username, users.email')
            ->join('kelas', 'kelas.kd_kelas = siswa.kd_kelas')
            ->join('jurusan', 'jurusan.kd_jurusan = siswa.kd_jurusan')
            ->join('agama', 'agama.id = siswa.agama_id', 'left')
            ->join('users', 'users.id = siswa.user_id', 'left');

        // Apply filters
        if (!empty($filters['nis'])) {
            $builder->like('siswa.nis', $filters['nis']);
        }
        if (!empty($filters['nama'])) {
            $builder->like('siswa.nama', $filters['nama']);
        }
        if (!empty($filters['kd_kelas'])) {
            $builder->where('siswa.kd_kelas', $filters['kd_kelas']);
        }
        if (!empty($filters['kd_jurusan'])) {
            $builder->where('siswa.kd_jurusan', $filters['kd_jurusan']);
        }

        return $builder->get()->getResultArray();
    }

    // Validation
    protected $validationRules      = [
        'nis' => 'required|is_unique[siswa.nis]',
        'nama' => 'required',
        'tanggal_lahir' => 'required|valid_date',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'agama_id' => 'required|numeric',
        'kd_kelas' => 'required',
        'kd_jurusan' => 'required',
        'alamat' => 'required',
        'no_hp' => 'required|numeric'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
} 