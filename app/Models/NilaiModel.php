<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table            = 'nilai';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'siswa_id',
        'mapel_id',
        'tahun_akademik_id',
        'semester',
        'uts',
        'uas',
        'tugas',
        'akhir'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'siswa_id' => 'required|integer',
        'mapel_id' => 'required|integer',
        'semester' => 'required|in_list[Ganjil,Genap]',
        'uts'      => 'permit_empty|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        'uas'      => 'permit_empty|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        'tugas'    => 'permit_empty|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        'akhir'    => 'permit_empty|numeric|greater_than_equal_to[0]|less_than_equal_to[100]'
    ];

    protected $validationMessages = [
        'siswa_id' => [
            'required' => 'ID Siswa harus diisi',
            'integer'  => 'ID Siswa harus berupa angka'
        ],
        'mapel_id' => [
            'required' => 'ID Mata Pelajaran harus diisi',
            'integer'  => 'ID Mata Pelajaran harus berupa angka'
        ],
        'semester' => [
            'required' => 'Semester harus diisi',
            'in_list'  => 'Semester harus Ganjil atau Genap'
        ],
        'uts' => [
            'numeric' => 'Nilai UTS harus berupa angka',
            'greater_than_equal_to' => 'Nilai UTS minimal 0',
            'less_than_equal_to' => 'Nilai UTS maksimal 100'
        ],
        'uas' => [
            'numeric' => 'Nilai UAS harus berupa angka',
            'greater_than_equal_to' => 'Nilai UAS minimal 0',
            'less_than_equal_to' => 'Nilai UAS maksimal 100'
        ],
        'tugas' => [
            'numeric' => 'Nilai Tugas harus berupa angka',
            'greater_than_equal_to' => 'Nilai Tugas minimal 0',
            'less_than_equal_to' => 'Nilai Tugas maksimal 100'
        ],
        'akhir' => [
            'numeric' => 'Nilai Akhir harus berupa angka',
            'greater_than_equal_to' => 'Nilai Akhir minimal 0',
            'less_than_equal_to' => 'Nilai Akhir maksimal 100'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['calculateFinalScore'];
    protected $beforeUpdate = ['calculateFinalScore'];

    /**
     * Calculate final score before insert/update
     */
    protected function calculateFinalScore(array $data)
    {
        if (isset($data['data']['uts']) && isset($data['data']['uas']) && isset($data['data']['tugas'])) {
            $uts = floatval($data['data']['uts'] ?? 0);
            $uas = floatval($data['data']['uas'] ?? 0);
            $tugas = floatval($data['data']['tugas'] ?? 0);
            
            // Calculate final score (30% UTS + 40% UAS + 30% Tugas)
            $akhir = ($uts * 0.3) + ($uas * 0.4) + ($tugas * 0.3);
            
            $data['data']['akhir'] = round($akhir, 2);
        }
        
        return $data;
    }

    /**
     * Get nilai by siswa and mapel
     */
    public function getNilaiBySiswaMapel($siswaId, $mapelId, $semester = 1)
    {
        return $this->where([
            'siswa_id' => $siswaId,
            'mapel_id' => $mapelId,
            'semester' => $semester
        ])->first();
    }

    /**
     * Get nilai by kelas and mapel
     */
    public function getNilaiByKelasMapel($kelasId, $mapelId, $semester = 1)
    {
        return $this->select('nilai.*, siswa.nama as nama_siswa, siswa.nisn')
            ->join('siswa', 'siswa.id = nilai.siswa_id')
            ->where('siswa.kelas_id', $kelasId)
            ->where('nilai.mapel_id', $mapelId)
            ->where('nilai.semester', $semester)
            ->findAll();
    }

    /**
     * Get nilai by kelas
     */
    public function getNilaiByKelas($kelasId, $semester = 1)
    {
        return $this->select('nilai.*, siswa.nama as nama_siswa, siswa.nisn, mapel.nama_mapel')
            ->join('siswa', 'siswa.id = nilai.siswa_id')
            ->join('mapel', 'mapel.id = nilai.mapel_id')
            ->where('siswa.kelas_id', $kelasId)
            ->where('nilai.semester', $semester)
            ->findAll();
    }

    /**
     * Get rata-rata nilai siswa
     */
    public function getRataRataSiswa($siswaId, $semester = 1)
    {
        $result = $this->select('AVG(akhir) as rata_rata, COUNT(*) as total_mapel')
            ->where('siswa_id', $siswaId)
            ->where('semester', $semester)
            ->where('akhir >', 0)
            ->first();
            
        return $result ? floatval($result['rata_rata']) : 0;
    }

    /**
     * Get rata-rata kelas
     */
    public function getRataRataKelas($kelasId, $semester = 1)
    {
        $result = $this->select('AVG(nilai.akhir) as rata_rata')
            ->join('siswa', 'siswa.id = nilai.siswa_id')
            ->where('siswa.kelas_id', $kelasId)
            ->where('nilai.semester', $semester)
            ->where('nilai.akhir >', 0)
            ->first();
            
        return $result ? floatval($result['rata_rata']) : 0;
    }

    /**
     * Get ranking siswa dalam kelas
     */
    public function getRankingKelas($kelasId, $semester = 1)
    {
        return $this->select('siswa.id, siswa.nama, siswa.nisn, AVG(nilai.akhir) as rata_rata')
            ->join('siswa', 'siswa.id = nilai.siswa_id')
            ->where('siswa.kelas_id', $kelasId)
            ->where('nilai.semester', $semester)
            ->where('nilai.akhir >', 0)
            ->groupBy('siswa.id, siswa.nama, siswa.nisn')
            ->orderBy('rata_rata', 'DESC')
            ->findAll();
    }

    /**
     * Get statistik nilai
     */
    public function getStatistikNilai($kelasId, $semester = 1)
    {
        $result = $this->select('
            COUNT(DISTINCT nilai.siswa_id) as total_siswa,
            COUNT(nilai.id) as total_nilai,
            AVG(nilai.akhir) as rata_rata,
            MAX(nilai.akhir) as nilai_tertinggi,
            MIN(nilai.akhir) as nilai_terendah,
            COUNT(CASE WHEN nilai.akhir >= 70 THEN 1 END) as siswa_lulus,
            COUNT(CASE WHEN nilai.akhir < 70 THEN 1 END) as siswa_tidak_lulus
        ')
        ->join('siswa', 'siswa.id = nilai.siswa_id')
        ->where('siswa.kelas_id', $kelasId)
        ->where('nilai.semester', $semester)
        ->where('nilai.akhir >', 0)
        ->first();
        
        return $result;
    }
} 