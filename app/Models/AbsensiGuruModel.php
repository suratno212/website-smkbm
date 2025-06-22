<?php
namespace App\Models;

use CodeIgniter\Model;

class AbsensiGuruModel extends Model
{
    protected $table = 'absensi_guru';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'guru_id', 'tanggal', 'jam_masuk', 'jam_pulang', 'status', 'keterangan', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
} 