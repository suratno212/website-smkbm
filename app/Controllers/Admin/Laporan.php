<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\AbsensiModel;
use App\Models\NilaiModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\TahunAkademikModel;

class Laporan extends BaseController
{
    protected $siswaModel;
    protected $guruModel;
    protected $absensiModel;
    protected $nilaiModel;
    protected $kelasModel;
    protected $mapelModel;
    protected $tahunAkademikModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
        $this->absensiModel = new AbsensiModel();
        $this->nilaiModel = new NilaiModel();
        $this->kelasModel = new KelasModel();
        $this->mapelModel = new MapelModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan Akademik',
            'total_siswa' => $this->siswaModel->countAllResults(),
            'total_guru' => $this->guruModel->countAllResults(),
            'total_kelas' => $this->kelasModel->countAllResults(),
            'total_mapel' => $this->mapelModel->countAllResults()
        ];

        return view('admin/laporan/index', $data);
    }

    public function siswa()
    {
        $filters = [
            'kd_kelas' => $this->request->getGet('kd_kelas'),
            'kd_jurusan' => $this->request->getGet('kd_jurusan'),
            'jenis_kelamin' => $this->request->getGet('jenis_kelamin')
        ];

        $builder = $this->siswaModel->select('siswa.*, kelas.nama_kelas, jurusan.nama_jurusan')
            ->join('kelas', 'kelas.kd_kelas = siswa.kd_kelas')
            ->join('jurusan', 'jurusan.kd_jurusan = siswa.kd_jurusan');

        if ($filters['kd_kelas']) {
            $builder->where('siswa.kd_kelas', $filters['kd_kelas']);
        }

        if ($filters['kd_jurusan']) {
            $builder->where('siswa.kd_jurusan', $filters['kd_jurusan']);
        }

        if ($filters['jenis_kelamin']) {
            $builder->where('siswa.jenis_kelamin', $filters['jenis_kelamin']);
        }

        $data = [
            'title' => 'Laporan Data Siswa',
            'siswa' => $builder->findAll(),
            'kelas' => $this->kelasModel->findAll(),
            'filters' => $filters
        ];

        return view('admin/laporan/siswa', $data);
    }

    public function guru()
    {
        $filters = [
            'kd_mapel' => $this->request->getGet('kd_mapel'),
            'jenis_kelamin' => $this->request->getGet('jenis_kelamin')
        ];

        $builder = $this->guruModel->select('guru.*, mapel.nama_mapel')
            ->join('mapel', 'mapel.kd_mapel = guru.kd_mapel');

        if ($filters['kd_mapel']) {
            $builder->where('guru.kd_mapel', $filters['kd_mapel']);
        }

        if ($filters['jenis_kelamin']) {
            $builder->where('guru.jenis_kelamin', $filters['jenis_kelamin']);
        }

        $data = [
            'title' => 'Laporan Data Guru',
            'guru' => $builder->findAll(),
            'mapel' => $this->mapelModel->findAll(),
            'filters' => $filters
        ];

        return view('admin/laporan/guru', $data);
    }

    public function absensi()
    {
        $filters = [
            'kd_kelas' => $this->request->getGet('kd_kelas'),
            'tanggal_mulai' => $this->request->getGet('tanggal_mulai'),
            'tanggal_akhir' => $this->request->getGet('tanggal_akhir')
        ];

        $builder = $this->absensiModel->select('absensi.*, siswa.nama as nama_siswa, kelas.nama_kelas')
            ->join('siswa', 'siswa.nis = absensi.nis')
            ->join('kelas', 'kelas.kd_kelas = siswa.kd_kelas');

        if ($filters['kd_kelas']) {
            $builder->where('siswa.kd_kelas', $filters['kd_kelas']);
        }

        if ($filters['tanggal_mulai']) {
            $builder->where('absensi.tanggal >=', $filters['tanggal_mulai']);
        }

        if ($filters['tanggal_akhir']) {
            $builder->where('absensi.tanggal <=', $filters['tanggal_akhir']);
        }

        $data = [
            'title' => 'Laporan Absensi',
            'absensi' => $builder->findAll(),
            'kelas' => $this->kelasModel->findAll(),
            'filters' => $filters
        ];

        return view('admin/laporan/absensi', $data);
    }

    public function nilai()
    {
        $filters = [
            'kd_kelas' => $this->request->getGet('kd_kelas'),
            'kd_mapel' => $this->request->getGet('kd_mapel'),
            'semester' => $this->request->getGet('semester') ?? 'Ganjil'
        ];

        // Get current academic year
        $tahunAkademik = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $tahunAkademikId = $tahunAkademik ? $tahunAkademik['id'] : 1;

        $builder = $this->nilaiModel->select('nilai.*, siswa.nama as nama_siswa, mapel.nama_mapel, kelas.nama_kelas')
            ->join('siswa', 'siswa.nis = nilai.nis')
            ->join('mapel', 'mapel.kd_mapel = nilai.kd_mapel')
            ->join('kelas', 'kelas.kd_kelas = nilai.kd_kelas')
            ->where('nilai.tahun_akademik_id', $tahunAkademikId);

        if ($filters['kd_kelas']) {
            $builder->where('nilai.kd_kelas', $filters['kd_kelas']);
        }

        if ($filters['kd_mapel']) {
            $builder->where('nilai.kd_mapel', $filters['kd_mapel']);
        }

        $builder->where('nilai.semester', $filters['semester']);

        $data = [
            'title' => 'Laporan Nilai',
            'nilai' => $builder->findAll(),
            'kelas' => $this->kelasModel->findAll(),
            'mapel' => $this->mapelModel->findAll(),
            'filters' => $filters,
            'tahun_akademik' => $tahunAkademik
        ];

        return view('admin/laporan/nilai', $data);
    }

    public function rekapAbsensi()
    {
        $kd_kelas = $this->request->getGet('kd_kelas');
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $rekap = [];
        if ($kd_kelas) {
            $rekap = $this->absensiModel->getRekapAbsensi($kd_kelas, $bulan);
        }

        $data = [
            'title' => 'Rekap Absensi',
            'rekap' => $rekap,
            'kelas' => $this->kelasModel->findAll(),
            'selected_kelas' => $kd_kelas,
            'selected_bulan' => $bulan,
            'selected_tahun' => $tahun
        ];

        return view('admin/laporan/rekap_absensi', $data);
    }

    public function rekapNilai()
    {
        $kd_kelas = $this->request->getGet('kd_kelas');
        $semester = $this->request->getGet('semester') ?? 'Ganjil';

        // Get current academic year
        $tahunAkademik = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $tahunAkademikId = $tahunAkademik ? $tahunAkademik['id'] : 1;

        $rekap = [];
        if ($kd_kelas) {
            $rekap = $this->nilaiModel->select('nilai.*, siswa.nama as nama_siswa, mapel.nama_mapel')
                ->join('siswa', 'siswa.nis = nilai.nis')
                ->join('mapel', 'mapel.kd_mapel = nilai.kd_mapel')
                ->where('nilai.kd_kelas', $kd_kelas)
                ->where('nilai.tahun_akademik_id', $tahunAkademikId)
                ->where('nilai.semester', $semester)
                ->orderBy('siswa.nama', 'ASC')
                ->findAll();
        }

        $data = [
            'title' => 'Rekap Nilai',
            'rekap' => $rekap,
            'kelas' => $this->kelasModel->findAll(),
            'selected_kelas' => $kd_kelas,
            'selected_semester' => $semester,
            'tahun_akademik' => $tahunAkademik
        ];

        return view('admin/laporan/rekap_nilai', $data);
    }
} 