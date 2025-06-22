<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table            = 'absensi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['siswa_id', 'tanggal', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'siswa_id' => 'required|integer',
        'tanggal'  => 'required|valid_date',
        'status'   => 'required|in_list[Hadir,Sakit,Izin,Alpha]'
    ];
    protected $validationMessages   = [
        'siswa_id' => [
            'required' => 'ID siswa harus diisi',
            'integer' => 'ID siswa harus berupa angka'
        ],
        'tanggal' => [
            'required' => 'Tanggal harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
        ],
        'status' => [
            'required' => 'Status harus diisi',
            'in_list' => 'Status harus Hadir, Sakit, Izin, atau Alpha'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getAbsensiWithSiswa($filters = [])
    {
        $builder = $this->db->table('absensi');
        $builder->select('absensi.*, siswa.nama as nama_siswa, siswa.nis, kelas.nama_kelas');
        $builder->join('siswa', 'siswa.id = absensi.siswa_id');
        $builder->join('kelas', 'kelas.id = siswa.kelas_id');

        // Apply filters
        if (!empty($filters['tanggal'])) {
            $builder->where('absensi.tanggal', $filters['tanggal']);
        }
        if (!empty($filters['kelas_id'])) {
            $builder->where('siswa.kelas_id', $filters['kelas_id']);
        }
        if (!empty($filters['status'])) {
            $builder->where('absensi.status', $filters['status']);
        }

        $builder->orderBy('siswa.nama', 'ASC');
        return $builder->get()->getResultArray();
    }

    public function getRekapAbsensi($kelas_id, $bulan)
    {
        $builder = $this->db->table('siswa');
        $builder->select('siswa.id, siswa.nama, siswa.nis, 
                         COUNT(CASE WHEN absensi.status = "Hadir" THEN 1 END) as hadir,
                         COUNT(CASE WHEN absensi.status = "Sakit" THEN 1 END) as sakit,
                         COUNT(CASE WHEN absensi.status = "Izin" THEN 1 END) as izin,
                         COUNT(CASE WHEN absensi.status = "Alpha" THEN 1 END) as alpha,
                         COUNT(absensi.id) as total');
        $builder->join('absensi', 'absensi.siswa_id = siswa.id', 'left');
        $builder->where('siswa.kelas_id', $kelas_id);
        $builder->like('absensi.tanggal', $bulan);
        $builder->groupBy('siswa.id, siswa.nama, siswa.nis');
        $builder->orderBy('siswa.nama', 'ASC');

        return $builder->get()->getResultArray();
    }
} 