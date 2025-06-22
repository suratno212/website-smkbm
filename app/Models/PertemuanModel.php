<?php
namespace App\Models;

use CodeIgniter\Model;

class PertemuanModel extends Model
{
    protected $table = 'pertemuan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kelas_id', 'mapel_id', 'nama_pertemuan', 'tanggal', 'topik', 'video_youtube', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
} 