<?php
namespace App\Models;

use CodeIgniter\Model;

class TugasModel extends Model
{
    protected $table = 'tugas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'guru_id', 'mapel_id', 'kelas_id', 'deskripsi', 'deadline', 'file'
    ];
    protected $useTimestamps = false;
} 