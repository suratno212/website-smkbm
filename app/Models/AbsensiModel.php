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
    protected $allowedFields    = ['nis', 'tanggal', 'status', 'keterangan', 'nik_nip'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'nis' => 'required',
        'tanggal' => 'required|valid_date',
        'status' => 'required|in_list[H,S,I,A]',
        'keterangan' => 'permit_empty',
        'nik_nip' => 'required'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getAbsensiWithRelations($filters = [])
    {
        $builder = $this->db->table('absensi')
            ->select('absensi.*, siswa.nama as nama_siswa, siswa.kd_kelas, kelas.nama_kelas, guru.nama as nama_guru')
            ->join('siswa', 'siswa.nis = absensi.nis')
            ->join('kelas', 'kelas.kd_kelas = siswa.kd_kelas')
            ->join('guru', 'guru.nik_nip = absensi.nik_nip', 'left');

        if (!empty($filters['tanggal'])) {
            $builder->where('absensi.tanggal', $filters['tanggal']);
        }
        if (!empty($filters['kd_kelas'])) {
            $builder->where('siswa.kd_kelas', $filters['kd_kelas']);
        }
        if (!empty($filters['nis'])) {
            $builder->where('absensi.nis', $filters['nis']);
        }

        return $builder->get()->getResultArray();
    }

    public function getAbsensiByTanggalKelas($tanggal, $kdKelas)
    {
        $builder = $this->db->table('absensi')
            ->select('absensi.*, siswa.nama as nama_siswa')
            ->join('siswa', 'siswa.nis = absensi.nis')
            ->where('absensi.tanggal', $tanggal)
            ->where('siswa.kd_kelas', $kdKelas);

        return $builder->get()->getResultArray();
    }

    public function getRekapAbsensi($kdKelas, $bulan)
    {
        $builder = $this->db->table('absensi')
            ->select('absensi.nis, siswa.nama, 
                     COUNT(CASE WHEN absensi.status = "H" THEN 1 END) as hadir,
                     COUNT(CASE WHEN absensi.status = "S" THEN 1 END) as sakit,
                     COUNT(CASE WHEN absensi.status = "I" THEN 1 END) as izin,
                     COUNT(CASE WHEN absensi.status = "A" THEN 1 END) as alpha')
            ->join('siswa', 'siswa.nis = absensi.nis')
            ->where('siswa.kd_kelas', $kdKelas)
            ->where('MONTH(absensi.tanggal)', $bulan)
            ->groupBy('absensi.nis, siswa.nama');

        return $builder->get()->getResultArray();
    }
} 