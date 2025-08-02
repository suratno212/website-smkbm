<?php

namespace App\Models;

use CodeIgniter\Model;

class EkstrakurikulerModel extends Model
{
    protected $table = 'ekstrakurikuler';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kd_ekstrakurikuler', 'nama_ekstrakurikuler', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
