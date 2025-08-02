<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiGuruModel extends Model
{
    protected $table = 'absensi_guru';
    protected $primaryKey = 'kd_absensi_guru';
    protected $allowedFields = [
        'kd_absensi_guru',
        'nik_nip',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;

    protected $beforeInsert = ['generateKodeAbsensiGuru'];

    protected function generateKodeAbsensiGuru(array $data)
    {
        if (empty($data['data']['kd_absensi_guru'])) {
            $data['data']['kd_absensi_guru'] = 'AGU' . time();
        }
        return $data;
    }
}
