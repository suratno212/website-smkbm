<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table            = 'nilai';
    protected $primaryKey       = ['nis', 'kd_mapel', 'kd_kelas', 'kd_jurusan', 'kd_tahun_akademik'];
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields = [
        'nis',
        'kd_mapel',
        'kd_kelas',
        'kd_jurusan',
        'kd_tahun_akademik',
        'semester',
        'nilai_tugas',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'nis' => 'required',
        'kd_mapel' => 'required',
        'kd_kelas' => 'required',
        'kd_jurusan' => 'required',
        'kd_tahun_akademik' => 'required|numeric',
        'semester' => 'required',
        'nilai_tugas' => 'permit_empty|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        'nilai_uts' => 'permit_empty|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        'nilai_uas' => 'permit_empty|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        'nilai_akhir' => 'permit_empty|numeric|greater_than_equal_to[0]|less_than_equal_to[100]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getNilaiWithRelations($filters = [])
    {
        $builder = $this->db->table('nilai')
            ->select('nilai.*, siswa.nama as nama_siswa, mapel.nama_mapel, kelas.nama_kelas, jurusan.nama_jurusan')
            ->join('siswa', 'siswa.nis = nilai.nis')
            ->join('mapel', 'mapel.kd_mapel = nilai.kd_mapel')
            ->join('kelas', 'kelas.kd_kelas = nilai.kd_kelas')
            ->join('jurusan', 'jurusan.kd_jurusan = nilai.kd_jurusan');

        if (!empty($filters['nis'])) {
            $builder->where('nilai.nis', $filters['nis']);
        }
        if (!empty($filters['kd_kelas'])) {
            $builder->where('nilai.kd_kelas', $filters['kd_kelas']);
        }
        if (!empty($filters['kd_mapel'])) {
            $builder->where('nilai.kd_mapel', $filters['kd_mapel']);
        }

        return $builder->get()->getResultArray();
    }

    public function getNilaiSiswa($nis, $kdKelas, $kdMapel, $kdTahunAkademik, $semester)
    {
        return $this->where([
            'nis' => $nis,
            'kd_kelas' => $kdKelas,
            'kd_mapel' => $kdMapel,
            'kd_tahun_akademik' => $kdTahunAkademik,
            'semester' => $semester
        ])->first();
    }

    public function getNilaiKelas($kdKelas, $kdMapel, $kdTahunAkademik, $semester)
    {
        $builder = $this->db->table('nilai')
            ->select('nilai.*, siswa.nama as nama_siswa')
            ->join('siswa', 'siswa.nis = nilai.nis')
            ->where('siswa.kd_kelas', $kdKelas)
            ->where('nilai.kd_mapel', $kdMapel)
            ->where('nilai.kd_tahun_akademik', $kdTahunAkademik)
            ->where('nilai.semester', $semester);

        return $builder->get()->getResultArray();
    }

    public function getRekapNilaiSiswa($nis, $kdTahunAkademik, $semester)
    {
        $builder = $this->db->table('nilai')
            ->select('nilai.*, mapel.nama_mapel, mapel.kelompok')
            ->join('mapel', 'mapel.kd_mapel = nilai.kd_mapel')
            ->where('nilai.nis', $nis)
            ->where('nilai.kd_tahun_akademik', $kdTahunAkademik)
            ->where('nilai.semester', $semester);

        return $builder->get()->getResultArray();
    }

    public function getRekapNilaiKelas($kdKelas, $kdTahunAkademik, $semester)
    {
        $builder = $this->db->table('nilai')
            ->select('nilai.*, siswa.nama as nama_siswa, mapel.nama_mapel')
            ->join('siswa', 'siswa.nis = nilai.nis')
            ->join('mapel', 'mapel.kd_mapel = nilai.kd_mapel')
            ->where('siswa.kd_kelas', $kdKelas)
            ->where('nilai.kd_tahun_akademik', $kdTahunAkademik)
            ->where('nilai.semester', $semester);

        return $builder->get()->getResultArray();
    }

    public function getRekapNilaiJurusan($kdJurusan, $kdTahunAkademik, $semester)
    {
        $builder = $this->db->table('nilai')
            ->select('nilai.*, siswa.nama as nama_siswa, mapel.nama_mapel, kelas.nama_kelas')
            ->join('siswa', 'siswa.nis = nilai.nis')
            ->join('mapel', 'mapel.kd_mapel = nilai.kd_mapel')
            ->join('kelas', 'kelas.kd_kelas = nilai.kd_kelas')
            ->where('siswa.kd_jurusan', $kdJurusan)
            ->where('nilai.kd_tahun_akademik', $kdTahunAkademik)
            ->where('nilai.semester', $semester);

        return $builder->get()->getResultArray();
    }

    /**
     * Mengembalikan array ranking siswa dalam kelas berdasarkan rata-rata nilai_akhir semester
     * @param string $kd_kelas
     * @param string $semester
     * @return array
     */
    public function getRankingKelas($kd_kelas, $semester)
    {
        // Ambil tahun akademik aktif
        $tahunAkademikAktif = model('TahunAkademikModel')->where('status', 'Aktif')->first();
        if (!$tahunAkademikAktif) return [];
        $kd_tahun_akademik = $tahunAkademikAktif['kd_tahun_akademik'];

        // Ambil semua siswa di kelas
        $siswaModel = model('SiswaModel');
        $siswaList = $siswaModel->where('kd_kelas', $kd_kelas)->findAll();
        $ranking = [];
        foreach ($siswaList as $siswa) {
            // Hitung rata-rata nilai akhir untuk semester dan tahun akademik aktif
            $nilaiList = $this->where([
                'nis' => $siswa['nis'],
                'kd_kelas' => $kd_kelas,
                'semester' => $semester,
                'kd_tahun_akademik' => $kd_tahun_akademik
            ])->findAll();
            $total = 0;
            $count = 0;
            foreach ($nilaiList as $n) {
                if (isset($n['nilai_akhir'])) {
                    $total += floatval($n['nilai_akhir']);
                    $count++;
                }
            }
            $rata_rata = $count > 0 ? round($total / $count, 2) : 0;
            $ranking[] = [
                'nis' => $siswa['nis'],
                'nama' => $siswa['nama'],
                'rata_rata' => $rata_rata
            ];
        }
        // Urutkan ranking dari rata-rata tertinggi ke terendah
        usort($ranking, function($a, $b) {
            return $b['rata_rata'] <=> $a['rata_rata'];
        });
        return $ranking;
    }

    /**
     * Menghitung rata-rata nilai_akhir untuk siswa dan semester tertentu pada tahun akademik aktif
     */
    public function getRataRataSiswa($nis, $semester)
    {
        $tahunAkademikAktif = model('TahunAkademikModel')->where('status', 'Aktif')->first();
        if (!$tahunAkademikAktif) return 0;
        $kd_tahun_akademik = $tahunAkademikAktif['kd_tahun_akademik'];
        $nilaiList = $this->where([
            'nis' => $nis,
            'semester' => $semester,
            'kd_tahun_akademik' => $kd_tahun_akademik
        ])->findAll();
        $total = 0;
        $count = 0;
        foreach ($nilaiList as $n) {
            if (isset($n['nilai_akhir'])) {
                $total += floatval($n['nilai_akhir']);
                $count++;
            }
        }
        return $count > 0 ? round($total / $count, 2) : 0;
    }

    /**
     * Mengembalikan statistik nilai untuk kelas dan semester tertentu pada tahun akademik aktif
     * @param string $kd_kelas
     * @param string $semester
     * @return array
     */
    public function getStatistikNilai($kd_kelas, $semester)
    {
        $tahunAkademikAktif = model('TahunAkademikModel')->where('status', 'Aktif')->first();
        if (!$tahunAkademikAktif) return [
            'total_siswa' => 0,
            'rata_rata' => 0,
            'distribusi_grade' => ['A'=>0,'B'=>0,'C'=>0,'D'=>0,'E'=>0]
        ];
        $kd_tahun_akademik = $tahunAkademikAktif['kd_tahun_akademik'];
        $nilaiList = $this->where([
            'kd_kelas' => $kd_kelas,
            'semester' => $semester,
            'kd_tahun_akademik' => $kd_tahun_akademik
        ])->findAll();
        $total = 0;
        $count = 0;
        $grade = ['A'=>0,'B'=>0,'C'=>0,'D'=>0,'E'=>0];
        foreach ($nilaiList as $n) {
            if (isset($n['nilai_akhir'])) {
                $na = floatval($n['nilai_akhir']);
                $total += $na;
                $count++;
                if ($na >= 90) $grade['A']++;
                elseif ($na >= 80) $grade['B']++;
                elseif ($na >= 70) $grade['C']++;
                elseif ($na >= 60) $grade['D']++;
                else $grade['E']++;
            }
        }
        return [
            'total_siswa' => $count,
            'rata_rata' => $count > 0 ? round($total/$count,2) : 0,
            'distribusi_grade' => $grade
        ];
    }
} 