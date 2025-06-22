<?php
namespace App\Models;

use CodeIgniter\Model;

class MateriModel extends Model
{
    protected $table = 'materi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'guru_id', 'mapel_id', 'kelas_id', 'judul', 'deskripsi', 'file'
    ];
    protected $useTimestamps = false;
} 