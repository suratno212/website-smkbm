<?php
namespace App\Models;

use CodeIgniter\Model;

class PretestSoalModel extends Model
{
    protected $table = 'pretest_soal';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kd_pretest', 'soal', 'pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d', 'jawaban_benar', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
} 