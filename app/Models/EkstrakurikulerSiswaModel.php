<?php

namespace App\Models;

use CodeIgniter\Model;

class EkstrakurikulerSiswaModel extends Model
{
    protected $table = 'ekstrakurikuler_siswa';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'siswa_id', 'ekstrakurikuler_id', 'tahun_akademik_id', 'nilai', 'keterangan', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
} 