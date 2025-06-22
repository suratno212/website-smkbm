<?php

namespace App\Models;

use CodeIgniter\Model;

class MapelModel extends Model
{
    protected $table = 'mapel';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_mapel'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
} 