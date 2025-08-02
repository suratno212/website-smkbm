<?php

namespace App\Models;

use CodeIgniter\Model;

class CalonSiswaModel extends Model
{
    protected $table            = 'calon_siswa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'user_id',
        'nama',
        'email',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'asal_sekolah',
        'jurusan_pilihan',
        'status_pendaftaran',
        'status_tes',
        'nilai_tes'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'user_id' => 'required|integer',
        'nama' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|is_unique[calon_siswa.email,id,{id}]',
        'tanggal_lahir' => 'required|valid_date',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'alamat' => 'required|min_length[10]',
        'no_hp' => 'required|min_length[10]|max_length[15]',
        'asal_sekolah' => 'required|min_length[3]',
        'jurusan_pilihan' => 'required|in_list[RPL,TKJ,TBSM,MM,AKL]',
        'status_pendaftaran' => 'required|in_list[terdaftar,diterima,ditolak]',
        'status_tes' => 'required|in_list[belum_tes,sedang_tes,sudah_tes]'
    ];

    protected $validationMessages   = [
        'nama' => [
            'required' => 'Nama harus diisi',
            'min_length' => 'Nama minimal 3 karakter',
            'max_length' => 'Nama maksimal 100 karakter'
        ],
        'email' => [
            'required' => 'Email harus diisi',
            'valid_email' => 'Format email tidak valid',
            'is_unique' => 'Email sudah terdaftar'
        ],
        'tanggal_lahir' => [
            'required' => 'Tanggal lahir harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
        ],
        'jenis_kelamin' => [
            'required' => 'Jenis kelamin harus dipilih',
            'in_list' => 'Jenis kelamin tidak valid'
        ],
        'alamat' => [
            'required' => 'Alamat harus diisi',
            'min_length' => 'Alamat minimal 10 karakter'
        ],
        'no_hp' => [
            'required' => 'Nomor HP harus diisi',
            'min_length' => 'Nomor HP minimal 10 digit',
            'max_length' => 'Nomor HP maksimal 15 digit'
        ],
        'asal_sekolah' => [
            'required' => 'Asal sekolah harus diisi',
            'min_length' => 'Asal sekolah minimal 3 karakter'
        ],
        'jurusan_pilihan' => [
            'required' => 'Jurusan pilihan harus dipilih',
            'in_list' => 'Jurusan pilihan tidak valid'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get calon siswa by user ID
     */
    public function getByUserId($userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    /**
     * Get calon siswa with user data
     */
    public function getWithUser($id = null)
    {
        $builder = $this->db->table('calon_siswa cs')
                           ->select('cs.*, u.username, u.role')
                           ->join('users u', 'u.id = cs.user_id');

        if ($id) {
            return $builder->where('cs.id', $id)->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Update status tes
     */
    public function updateStatusTes($id, $status, $nilai = null)
    {
        $data = ['status_tes' => $status];
        if ($nilai !== null) {
            $data['nilai_tes'] = $nilai;
        }
        
        return $this->update($id, $data);
    }

    /**
     * Get calon siswa by status
     */
    public function getByStatus($status)
    {
        return $this->where('status_pendaftaran', $status)->findAll();
    }

    /**
     * Get calon siswa by jurusan
     */
    public function getByJurusan($jurusan)
    {
        return $this->where('jurusan_pilihan', $jurusan)->findAll();
    }
} 