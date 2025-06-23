<?php
namespace App\Models;
use CodeIgniter\Model;
class SpmbModel extends Model
{
    protected $table = 'spmb';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'no_pendaftaran', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'alamat', 'asal_sekolah', 'nama_ortu', 'no_hp_ortu', 'email', 'no_hp', 'jurusan_pilihan', 'nisn', 'status_pendaftaran', 'catatan', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function generateNoPendaftaran()
    {
        $year = date('Y');
        $prefix = 'SPMB' . $year;
        
        $lastNumber = $this->where('no_pendaftaran LIKE', $prefix . '%')
                          ->orderBy('no_pendaftaran', 'DESC')
                          ->first();
        
        if ($lastNumber) {
            $lastNum = (int) substr($lastNumber['no_pendaftaran'], -4);
            $newNum = $lastNum + 1;
        } else {
            $newNum = 1;
        }
        
        return $prefix . str_pad($newNum, 4, '0', STR_PAD_LEFT);
    }

    // Get SPMB dengan filter
    public function getSpmbWithFilter($filters = [])
    {
        $builder = $this->select('*');

        if (!empty($filters['nama'])) {
            $builder->like('nama_lengkap', $filters['nama']);
        }
        if (!empty($filters['no_pendaftaran'])) {
            $builder->like('no_pendaftaran', $filters['no_pendaftaran']);
        }
        if (!empty($filters['status'])) {
            $builder->where('status_pendaftaran', $filters['status']);
        }
        if (!empty($filters['jurusan'])) {
            $builder->where('jurusan_pilihan', $filters['jurusan']);
        }

        return $builder->orderBy('created_at', 'DESC')->findAll();
    }

    // Get statistik SPMB
    public function getStatistik()
    {
        $total = $this->countAll();
        $menunggu = $this->where('status_pendaftaran', 'Menunggu')->countAllResults();
        $diterima = $this->where('status_pendaftaran', 'Diterima')->countAllResults();
        $ditolak = $this->where('status_pendaftaran', 'Ditolak')->countAllResults();
        $bersyarat = $this->where('status_pendaftaran', 'Diterima Bersyarat')->countAllResults();

        return [
            'total' => $total,
            'menunggu' => $menunggu,
            'diterima' => $diterima,
            'ditolak' => $ditolak,
            'bersyarat' => $bersyarat
        ];
    }
} 