<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunAkademikModel extends Model
{
    protected $table = 'tahun_akademik';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tahun', 'semester', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
} 