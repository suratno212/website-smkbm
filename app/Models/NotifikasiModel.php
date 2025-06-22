<?php

namespace App\Models;

use CodeIgniter\Model;

class NotifikasiModel extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'siswa_id', 'absensi_id', 'pesan', 'status', 'created_at'];
    public $timestamps = false;
} 