<?php

namespace App\Models;

use CodeIgniter\Model;

class MateriModel extends Model
{
    protected $table = 'materi';
    protected $primaryKey = 'kd_materi';
    protected $allowedFields = [
        'kd_materi',
        'nik_nip',
        'kd_mapel',
        'kd_kelas',
        'judul',
        'deskripsi',
        'file',
        'video_url',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
