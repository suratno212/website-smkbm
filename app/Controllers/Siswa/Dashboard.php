<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\SiswaModel;
use App\Models\PengumumanModel;
use App\Models\KelasModel;
use App\Models\JurusanModel;
use App\Models\NilaiModel;
use App\Models\MapelModel;
use App\Models\TahunAkademikModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $siswaModel;
    protected $pengumumanModel;
    protected $kelasModel;
    protected $jurusanModel;
    protected $nilaiModel;
    protected $mapelModel;
    protected $tahunAkademikModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->siswaModel = new SiswaModel();
        $this->pengumumanModel = new PengumumanModel();
        $this->kelasModel = new KelasModel();
        $this->jurusanModel = new JurusanModel();
        $this->nilaiModel = new NilaiModel();
        $this->mapelModel = new MapelModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
    }

    public function index()
    {
        // Cek apakah user sudah login dan rolenya siswa
        if (!session()->get('logged_in') || session()->get('role') !== 'siswa') {
            return redirect()->to(base_url('auth'));
        }

        $user_id = session()->get('user_id');
        $user = $this->userModel->find($user_id);
        
        // Ambil data siswa berdasarkan user_id
        $siswa = $this->siswaModel->where('user_id', $user_id)->first();
        
        // Ambil nama kelas dan jurusan
        if ($siswa) {
            $kelas = $this->kelasModel->find($siswa['kelas_id']);
            $jurusan = $this->jurusanModel->find($siswa['jurusan_id']);
            $siswa['nama_kelas'] = $kelas ? $kelas['nama_kelas'] : 'N/A';
            $siswa['nama_jurusan'] = $jurusan ? $jurusan['nama_jurusan'] : 'N/A';
        }
        
        // Ambil pengumuman terbaru
        $pengumuman = $this->pengumumanModel->getActiveAnnouncements();

        // Ambil data nilai untuk grafik
        $nilaiData = [];
        $rataRata = 0;
        if ($siswa) {
            // Ambil tahun akademik aktif
            $tahunAkademikAktif = $this->tahunAkademikModel->where('status', 'Aktif')->first();
            $semester = $tahunAkademikAktif ? $tahunAkademikAktif['semester'] : 'Ganjil';
            
            // Ambil nilai siswa
            $nilai = $this->nilaiModel->select('nilai.*, mapel.nama_mapel')
                ->join('mapel', 'mapel.id = nilai.mapel_id')
                ->where('nilai.siswa_id', $siswa['id'])
                ->where('nilai.semester', $semester)
                ->where('nilai.tahun_akademik_id', $tahunAkademikAktif['id'])
                ->findAll();
            
            // Siapkan data untuk grafik
            foreach ($nilai as $n) {
                $nilaiData[] = [
                    'mapel' => $n['nama_mapel'],
                    'nilai' => $n['akhir']
                ];
            }
            
            // Hitung rata-rata
            if (!empty($nilai)) {
                $total = array_sum(array_column($nilai, 'akhir'));
                $rataRata = round($total / count($nilai), 2);
            }
        }

        $data = [
            'title' => 'Dashboard Siswa',
            'user' => $user,
            'siswa' => $siswa,
            'pengumuman' => $pengumuman,
            'nilaiData' => $nilaiData,
            'rataRata' => $rataRata
        ];

        return view('siswa/dashboard', $data);
    }
}
