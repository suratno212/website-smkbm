<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'nisn', 'nama', 'tanggal_lahir', 'jenis_kelamin', 'agama_id', 'kelas_id', 'jurusan_id', 'alamat', 'no_hp'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getSiswaWithRelations($filters = [])
    {
        $builder = $this->select('siswa.*, kelas.nama_kelas, jurusan.nama_jurusan, agama.nama_agama')
                    ->join('kelas', 'kelas.id = siswa.kelas_id')
                    ->join('jurusan', 'jurusan.id = siswa.jurusan_id')
                    ->join('agama', 'agama.id = siswa.agama_id', 'left');

        // Terapkan filter jika ada
        if (!empty($filters['nis'])) {
            $builder->like('siswa.nisn', $filters['nis']);
        }
        if (!empty($filters['nama'])) {
            $builder->like('siswa.nama', $filters['nama']);
        }
        if (!empty($filters['kelas_id'])) {
            $builder->where('siswa.kelas_id', $filters['kelas_id']);
        }
        if (!empty($filters['jurusan_id'])) {
            $builder->where('siswa.jurusan_id', $filters['jurusan_id']);
        }

        return $builder->findAll();
    }
} 