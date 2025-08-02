<?php

namespace App\Models;

use CodeIgniter\Model;

class SoalSpmbModel extends Model
{
    protected $table = 'soal_spmb';
    protected $primaryKey = 'kd_soal';
    protected $allowedFields = [
        'pertanyaan', 'gambar', 'pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d', 'jawaban_benar', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
} 
 
 
 
 
 