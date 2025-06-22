<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\RuanganModel;
use App\Models\MapelModel;
use App\Models\UserModel;
use App\Models\JurusanModel;
use App\Models\TahunAkademikModel;
use App\Models\JadwalModel;
use App\Models\PengumumanModel;
use App\Models\AbsensiModel;
use App\Models\NilaiModel;
use App\Models\KelasModel;

class Dashboard extends BaseController
{
    protected $siswaModel;
    protected $guruModel;
    protected $ruanganModel;
    protected $mapelModel;
    protected $userModel;
    protected $jurusanModel;
    protected $tahunAkademikModel;
    protected $jadwalModel;
    protected $pengumumanModel;
    protected $absensiModel;
    protected $nilaiModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
        $this->ruanganModel = new RuanganModel();
        $this->mapelModel = new MapelModel();
        $this->userModel = new UserModel();
        $this->jurusanModel = new JurusanModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
        $this->jadwalModel = new JadwalModel();
        $this->pengumumanModel = new PengumumanModel();
        $this->absensiModel = new AbsensiModel();
        $this->nilaiModel = new NilaiModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        // Cek apakah user sudah login dan rolenya admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $user = $this->userModel->find(session()->get('user_id'));
        
        // Data untuk analytics
        $analyticsData = $this->getAnalyticsData();
        
        $data = [
            'title' => 'Dashboard Admin',
            'user' => $user,
            'total_siswa' => $this->siswaModel->countAll(),
            'total_guru' => $this->guruModel->countAll(),
            'total_ruangan' => $this->ruanganModel->countAll(),
            'total_mapel' => $this->mapelModel->countAll(),
            'total_users' => $this->userModel->countAll(),
            'total_jurusan' => $this->jurusanModel->countAll(),
            'total_tahun_akademik' => $this->tahunAkademikModel->countAll(),
            'total_jadwal' => $this->jadwalModel->countAll(),
            'total_pengumuman' => $this->pengumumanModel->countAll(),
            'total_kelas' => $this->kelasModel->countAll(),
            'pengumuman_terbaru' => $this->pengumumanModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'analytics' => $analyticsData
        ];
        
        return view('admin/dashboard', $data);
    }

    private function getAnalyticsData()
    {
        // Data siswa per jurusan
        $siswaPerJurusan = $this->siswaModel->select('jurusan.nama_jurusan, COUNT(siswa.id) as total')
            ->join('jurusan', 'jurusan.id = siswa.jurusan_id')
            ->groupBy('jurusan.id, jurusan.nama_jurusan')
            ->findAll();

        // Data siswa per kelas
        $siswaPerKelas = $this->siswaModel->select('kelas.nama_kelas, COUNT(siswa.id) as total')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->groupBy('kelas.id, kelas.nama_kelas')
            ->findAll();

        // Data absensi hari ini
        $today = date('Y-m-d');
        $absensiHariIni = $this->absensiModel->select('status, COUNT(*) as total')
            ->where('tanggal', $today)
            ->groupBy('status')
            ->findAll();

        // Data nilai rata-rata per mata pelajaran
        $nilaiPerMapel = $this->nilaiModel->select('mapel.nama_mapel, AVG(nilai.akhir) as rata_rata')
            ->join('mapel', 'mapel.id = nilai.mapel_id')
            ->groupBy('mapel.id, mapel.nama_mapel')
            ->findAll();

        // Data guru per mata pelajaran
        $guruPerMapel = $this->guruModel->select('mapel.nama_mapel, COUNT(guru.id) as total')
            ->join('mapel', 'mapel.id = guru.mapel_id')
            ->groupBy('mapel.id, mapel.nama_mapel')
            ->findAll();

        // Data jadwal per hari
        $jadwalPerHari = $this->jadwalModel->select('hari, COUNT(*) as total')
            ->groupBy('hari')
            ->findAll();

        return [
            'siswa_per_jurusan' => $siswaPerJurusan,
            'siswa_per_kelas' => $siswaPerKelas,
            'absensi_hari_ini' => $absensiHariIni,
            'nilai_per_mapel' => $nilaiPerMapel,
            'guru_per_mapel' => $guruPerMapel,
            'jadwal_per_hari' => $jadwalPerHari
        ];
    }

    public function getAnalyticsDataAjax()
    {
        // Endpoint untuk AJAX request
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $analyticsData = $this->getAnalyticsData();
        return $this->response->setJSON($analyticsData);
    }
} 