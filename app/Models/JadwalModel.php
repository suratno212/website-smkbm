<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table            = 'jadwal';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields = ['kd_kelas', 'kd_mapel', 'nik_nip', 'tahun_akademik_id', 'hari', 'jam_mulai', 'jam_selesai'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getJadwalWithRelations($filters = [])
    {
        $builder = $this->db->table('jadwal')
            ->select('jadwal.*, kelas.nama_kelas, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('kelas', 'kelas.kd_kelas = jadwal.kd_kelas')
            ->join('mapel', 'mapel.kd_mapel = jadwal.kd_mapel')
            ->join('guru', 'guru.nik_nip = jadwal.nik_nip', 'left');

        if (!empty($filters['kd_kelas'])) {
            $builder->where('jadwal.kd_kelas', $filters['kd_kelas']);
        }
        if (!empty($filters['nik_nip'])) {
            $builder->where('jadwal.nik_nip', $filters['nik_nip']);
        }

        return $builder->get()->getResultArray();
    }

    // Validation
    protected $validationRules      = [
        'kd_kelas' => 'required',
        'kd_mapel' => 'required',
        'nik_nip' => 'required',
        'tahun_akademik_id' => 'required|numeric',
        'hari' => 'required',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
} 