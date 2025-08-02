<?php
namespace App\Models;

use CodeIgniter\Model;

class PertemuanModel extends Model
{
    protected $table = 'pertemuan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kd_kelas', 'kd_mapel', 'nama_pertemuan', 'tanggal', 'topik', 'video_youtube', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
} 