<?php
namespace App\Models;

use CodeIgniter\Model;

class TugasModel extends Model
{
    protected $table = 'tugas';
    protected $primaryKey = 'kd_tugas';
    protected $allowedFields = [
        'kd_tugas', 'nik_nip', 'kd_mapel', 'kd_kelas', 'judul', 'deskripsi', 'deadline', 'file', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
} 