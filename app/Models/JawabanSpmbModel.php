<?php

namespace App\Models;

use CodeIgniter\Model;

class JawabanSpmbModel extends Model
{
    protected $table = 'jawaban_spmb';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'ujian_id', 'soal_id', 'jawaban_peserta', 'benar_salah', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
} 
 
 
 
 
 