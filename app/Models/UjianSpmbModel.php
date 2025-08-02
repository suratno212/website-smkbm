<?php

namespace App\Models;

use CodeIgniter\Model;

class UjianSpmbModel extends Model
{
    protected $table = 'ujian_spmb';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'peserta_id', 'waktu_mulai', 'waktu_selesai', 'skor', 'status', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
} 
 
 
 
 
 