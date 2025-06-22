<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kelas_id', 'mapel_id', 'guru_id', 'tahun_akademik_id', 'hari', 'jam_mulai', 'jam_selesai'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getJadwalWithRelations()
    {
        return $this->select('jadwal.*, kelas.nama_kelas, mapel.nama_mapel, guru.nama as nama_guru, tahun_akademik.tahun, tahun_akademik.semester')
            ->join('kelas', 'kelas.id = jadwal.kelas_id')
            ->join('mapel', 'mapel.id = jadwal.mapel_id')
            ->join('guru', 'guru.id = jadwal.guru_id')
            ->join('tahun_akademik', 'tahun_akademik.id = jadwal.tahun_akademik_id')
            ->findAll();
    }
} 