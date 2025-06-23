<?php
namespace App\Controllers\KepalaSekolah;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\JurusanModel;

class Dashboard extends BaseController
{
    protected $siswaModel;
    protected $guruModel;
    protected $kelasModel;
    protected $jurusanModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
        $this->kelasModel = new KelasModel();
        $this->jurusanModel = new JurusanModel();
    }

    public function index()
    {
        // Grafik: jumlah siswa per jurusan
        $siswaPerJurusan = $this->siswaModel
            ->select('jurusan.nama_jurusan, COUNT(siswa.id) as total')
            ->join('jurusan', 'jurusan.id = siswa.jurusan_id')
            ->groupBy('jurusan.id, jurusan.nama_jurusan')
            ->findAll();
        // Grafik: jumlah siswa per kelas
        $siswaPerKelas = $this->siswaModel
            ->select('kelas.nama_kelas, COUNT(siswa.id) as total')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->groupBy('kelas.id, kelas.nama_kelas')
            ->findAll();
        $data = [
            'title' => 'Dashboard Kepala Sekolah',
            'total_siswa' => $this->siswaModel->countAll(),
            'total_guru' => $this->guruModel->countAll(),
            'total_kelas' => $this->kelasModel->countAll(),
            'total_jurusan' => $this->jurusanModel->countAll(),
            'siswa_per_jurusan' => $siswaPerJurusan,
            'siswa_per_kelas' => $siswaPerKelas,
        ];
        return view('kepalasekolah/dashboard', $data);
    }
} 