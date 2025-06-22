<?php

namespace App\Models;

use CodeIgniter\Model;

class PengumumanModel extends Model
{
    protected $table            = 'pengumuman';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'judul', 'isi', 'jenis', 'file', 'status', 'created_at', 'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'judul' => 'required|min_length[3]|max_length[255]',
        'jenis' => 'required|in_list[Umum,Jadwal Ujian,Kegiatan,Lainnya]',
        'status' => 'required|in_list[Aktif,Tidak Aktif]'
    ];

    protected $validationMessages = [
        'judul' => [
            'required' => 'Judul pengumuman harus diisi',
            'min_length' => 'Judul minimal 3 karakter',
            'max_length' => 'Judul maksimal 255 karakter'
        ],
        'jenis' => [
            'required' => 'Jenis pengumuman harus dipilih',
            'in_list' => 'Jenis pengumuman tidak valid'
        ],
        'status' => [
            'required' => 'Status pengumuman harus dipilih',
            'in_list' => 'Status pengumuman tidak valid'
        ]
    ];

    protected $skipValidation = false;

    // Get active announcements
    public function getActiveAnnouncements()
    {
        return $this->where('status', 'Aktif')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // Get announcements by type
    public function getByType($jenis)
    {
        return $this->where('jenis', $jenis)
                    ->where('status', 'Aktif')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // Get exam schedule announcements
    public function getExamSchedules()
    {
        return $this->where('jenis', 'Jadwal Ujian')
                    ->where('status', 'Aktif')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
} 