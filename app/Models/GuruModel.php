<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table            = 'guru';
    protected $primaryKey       = 'nik_nip';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['user_id', 'nik_nip', 'nama', 'jenis_kelamin', 'agama_id', 'tempat_lahir', 'tanggal_lahir', 'kd_mapel', 'alamat', 'no_hp'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getGuruWithMapel($filters = [])
    {
        $builder = $this->db->table('guru')
            ->select('guru.*, mapel.nama_mapel, users.username, users.email, agama.nama_agama')
            ->join('mapel', 'mapel.kd_mapel = guru.kd_mapel')
            ->join('users', 'users.id = guru.user_id', 'left')
            ->join('agama', 'agama.id = guru.agama_id', 'left');

        if (!empty($filters['kd_mapel'])) {
            $builder->where('guru.kd_mapel', $filters['kd_mapel']);
        }

        return $builder->get()->getResultArray();
    }

    public function getGuruWithRelations($nikNip)
    {
        $builder = $this->db->table('guru')
            ->select('guru.*, mapel.nama_mapel, users.username, users.email, agama.nama_agama')
            ->join('mapel', 'mapel.kd_mapel = guru.kd_mapel')
            ->join('users', 'users.id = guru.user_id', 'left')
            ->join('agama', 'agama.id = guru.agama_id', 'left')
            ->where('guru.nik_nip', $nikNip);

        return $builder->get()->getRowArray();
    }

    // Validation
    protected $validationRules      = [
        'nik_nip' => 'required|is_unique[guru.nik_nip]',
        'nama' => 'required',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'agama_id' => 'required|numeric',
        'tanggal_lahir' => 'required|valid_date',
        'kd_mapel' => 'required',
        'alamat' => 'required',
        'no_hp' => 'required|numeric'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
} 