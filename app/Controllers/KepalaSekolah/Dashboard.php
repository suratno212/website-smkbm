<?php
namespace App\Controllers\KepalaSekolah;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\JurusanModel;
use App\Models\SpmbModel;

class Dashboard extends BaseController
{
    protected $siswaModel;
    protected $guruModel;
    protected $kelasModel;
    protected $jurusanModel;
    protected $spmbModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
        $this->kelasModel = new KelasModel();
        $this->jurusanModel = new JurusanModel();
        $this->spmbModel = new SpmbModel();
    }

    public function index()
    {
        // Grafik: jumlah siswa per jurusan
        $siswaPerJurusan = $this->siswaModel
            ->select('jurusan.nama_jurusan, COUNT(siswa.nis) as total')
            ->join('jurusan', 'jurusan.kd_jurusan = siswa.kd_jurusan')
            ->groupBy('jurusan.kd_jurusan, jurusan.nama_jurusan')
            ->findAll();
        // Grafik: jumlah siswa per kelas
        $siswaPerKelas = $this->siswaModel
            ->select('kelas.nama_kelas, COUNT(siswa.nis) as total')
            ->join('kelas', 'kelas.kd_kelas = siswa.kd_kelas')
            ->groupBy('kelas.kd_kelas, kelas.nama_kelas')
            ->findAll();
        // Grafik: pendaftar SPMB per jurusan
        $spmbPerJurusan = $this->spmbModel
            ->select('jurusan_pilihan, COUNT(*) as total')
            ->groupBy('jurusan_pilihan')
            ->findAll();
        // Grafik: status pendaftaran SPMB
        $spmbStatus = $this->spmbModel
            ->select('status_pendaftaran, COUNT(*) as total')
            ->groupBy('status_pendaftaran')
            ->findAll();
        $data = [
            'title' => 'Dashboard Kepala Sekolah',
            'total_siswa' => $this->siswaModel->countAll(),
            'total_guru' => $this->guruModel->countAll(),
            'total_kelas' => $this->kelasModel->countAll(),
            'total_jurusan' => $this->jurusanModel->countAll(),
            'siswa_per_jurusan' => $siswaPerJurusan,
            'siswa_per_kelas' => $siswaPerKelas,
            'spmb_per_jurusan' => $spmbPerJurusan,
            'spmb_status' => $spmbStatus,
        ];
        return view('kepalasekolah/dashboard', $data);
    }
} 