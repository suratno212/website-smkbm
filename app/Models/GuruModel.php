<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table            = 'guru';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'nip_nuptk', 'nama', 'jenis_kelamin', 'agama', 'tanggal_lahir', 'mapel_id', 'alamat', 'no_hp'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getGuruWithRelations($filters = [])
    {
        $builder = $this->db->table('guru');
        $builder->select('guru.*, mapel.nama_mapel');
        $builder->join('mapel', 'mapel.id = guru.mapel_id');

        // Apply filters
        if (!empty($filters['nip_nuptk'])) {
            $builder->like('guru.nip_nuptk', $filters['nip_nuptk']);
        }
        if (!empty($filters['nama'])) {
            $builder->like('guru.nama', $filters['nama']);
        }
        if (!empty($filters['mapel_id'])) {
            $builder->where('guru.mapel_id', $filters['mapel_id']);
        }

        return $builder->get()->getResultArray();
    }
} 