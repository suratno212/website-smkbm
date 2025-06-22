<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\GuruModel;
use App\Models\PengumumanModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $guruModel;
    protected $pengumumanModel;
    protected $db;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->guruModel = new GuruModel();
        $this->pengumumanModel = new PengumumanModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Cek apakah user sudah login dan rolenya guru
        if (!session()->get('logged_in') || session()->get('role') !== 'guru') {
            return redirect()->to(base_url('auth'));
        }

        $user_id = session()->get('user_id');
        $user = $this->userModel->find($user_id);
        $guru = $this->guruModel->where('user_id', $user_id)->first();

        // Ambil nama mapel guru
        if ($guru && $guru['mapel_id']) {
            $mapel = $this->db->table('mapel')->where('id', $guru['mapel_id'])->get()->getRowArray();
            $guru['nama_mapel'] = $mapel ? $mapel['nama_mapel'] : 'N/A';
        }

        // Ambil pengumuman terbaru
        $pengumuman = $this->pengumumanModel->getActiveAnnouncements();

        // Cek apakah guru adalah wali kelas
        $kelasModel = new \App\Models\KelasModel();
        $isWaliKelas = $kelasModel->where('wali_kelas_id', $guru['id'])->countAllResults() > 0;
        $kelasDiwalikan = $kelasModel->where('wali_kelas_id', $guru['id'])->findAll();

        // Ambil notifikasi jika wali kelas
        $notifikasi = [];
        if ($isWaliKelas) {
            $notifikasiModel = new \App\Models\NotifikasiModel();
            $notifikasi = $notifikasiModel->where('user_id', $user_id)->orderBy('created_at', 'DESC')->findAll(10);
        }

        // Rekap keterlambatan siswa di kelas yang diwalikan
        $rekap_terlambat = [];
        if ($isWaliKelas && !empty($kelasDiwalikan)) {
            $absensiModel = new \App\Models\AbsensiModel();
            $siswaModel = new \App\Models\SiswaModel();
            foreach ($kelasDiwalikan as $kelas) {
                $siswaKelas = $siswaModel->where('kelas_id', $kelas['id'])->findAll();
                foreach ($siswaKelas as $siswa) {
                    $jumlahTerlambat = $absensiModel->where('siswa_id', $siswa['id'])->where('status', 'terlambat')->countAllResults();
                    if ($jumlahTerlambat > 0) {
                        $rekap_terlambat[] = [
                            'nama' => $siswa['nama'],
                            'nisn' => $siswa['nisn'],
                            'kelas' => $kelas['nama_kelas'],
                            'jumlah_terlambat' => $jumlahTerlambat
                        ];
                    }
                }
            }
            // Urutkan ranking
            usort($rekap_terlambat, function($a, $b) {
                return $b['jumlah_terlambat'] <=> $a['jumlah_terlambat'];
            });
        }

        $data = [
            'title' => 'Dashboard Guru',
            'user' => $user,
            'guru' => $guru,
            'pengumuman' => $pengumuman,
            'isWaliKelas' => $isWaliKelas,
            'kelasDiwalikan' => $kelasDiwalikan,
            'notifikasi' => $notifikasi,
            'rekap_terlambat' => $rekap_terlambat
        ];

        return view('guru/dashboard', $data);
    }
}
