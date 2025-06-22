<?php

namespace App\Models;

use CodeIgniter\Model;

class AgamaModel extends Model
{
    protected $table = 'agama';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_agama'];
    protected $useTimestamps = false;
} 