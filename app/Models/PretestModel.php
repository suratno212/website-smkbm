<?php
namespace App\Models;

use CodeIgniter\Model;

class PretestModel extends Model
{
    protected $table = 'pretest';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kd_pertemuan', 'judul', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
} 