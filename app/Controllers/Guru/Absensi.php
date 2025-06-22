<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\JadwalModel;
use App\Models\GuruModel;
use App\Models\UserModel;

class Absensi extends BaseController
{
    protected $absensiModel;
    protected $siswaModel;
    protected $kelasModel;
    protected $mapelModel;
    protected $jadwalModel;
    protected $guruModel;
    protected $userModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
        $this->mapelModel = new MapelModel();
        $this->jadwalModel = new JadwalModel();
        $this->guruModel = new GuruModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Cek session
        if (!session()->get('logged_in') || session()->get('role') !== 'guru') {
            return redirect()->to(base_url('auth'));
        }

        $user_id = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $user_id)->first();
        
        if (!$guru) {
            return redirect()->to(base_url('guru/dashboard'))->with('error', 'Data guru tidak ditemukan. Pastikan data guru sudah terdaftar dan user_id sesuai.');
        }

        // Ambil kelas yang diampu oleh guru ini
        $kelas_diampu = $this->jadwalModel->select('DISTINCT(kelas.id), kelas.nama_kelas')
            ->join('kelas', 'kelas.id = jadwal.kelas_id')
            ->where('jadwal.guru_id', $guru['id'])
            ->findAll();

        // Ambil mapel yang diajar oleh guru ini
        $mapel_diajar = $this->mapelModel->where('id', $guru['mapel_id'])->first();

        $data = [
            'title' => 'Absensi Siswa',
            'guru' => $guru,
            'kelas_diampu' => $kelas_diampu,
            'mapel_diajar' => $mapel_diajar,
            'user' => $this->userModel->find($user_id)
        ];

        return view('guru/absensi/index', $data);
    }

    public function input()
    {
        // Cek session
        if (!session()->get('logged_in') || session()->get('role') !== 'guru') {
            return redirect()->to(base_url('auth'));
        }

        $user_id = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $user_id)->first();
        
        if (!$guru) {
            return redirect()->to(base_url('guru/dashboard'))->with('error', 'Data guru tidak ditemukan. Pastikan data guru sudah terdaftar dan user_id sesuai.');
        }

        $kelas_id = $this->request->getGet('kelas_id');
        $tanggal = $this->request->getGet('tanggal') ?: date('Y-m-d');

        // Ambil kelas yang diampu oleh guru ini
        $kelas_diampu = $this->jadwalModel->select('DISTINCT(kelas.id), kelas.nama_kelas')
            ->join('kelas', 'kelas.id = jadwal.kelas_id')
            ->where('jadwal.guru_id', $guru['id'])
            ->findAll();

        // Ambil mapel yang diajar oleh guru ini
        $mapel_diajar = $this->mapelModel->where('id', $guru['mapel_id'])->first();

        // Jika kelas dipilih, ambil data siswa
        $siswa_list = [];
        if ($kelas_id) {
            // Pastikan field nisn diambil (bukan nis)
            $siswa_list = $this->siswaModel->select('id, nisn, nama')->where('kelas_id', $kelas_id)->findAll();
            
            // Ambil data absensi yang sudah ada
            foreach ($siswa_list as &$siswa) {
                $absensi = $this->absensiModel->where([
                    'siswa_id' => $siswa['id'],
                    'tanggal' => $tanggal
                ])->first();
                
                $siswa['absensi_status'] = $absensi ? $absensi['status'] : '';
                $siswa['absensi_id'] = $absensi ? $absensi['id'] : null;
            }
        }

        $data = [
            'title' => 'Input Absensi',
            'guru' => $guru,
            'kelas_diampu' => $kelas_diampu,
            'mapel_diajar' => $mapel_diajar,
            'siswa_list' => $siswa_list,
            'selected_kelas' => $kelas_id,
            'selected_tanggal' => $tanggal,
            'user' => $this->userModel->find($user_id)
        ];

        return view('guru/absensi/input', $data);
    }

    public function store()
    {
        // Cek session
        if (!session()->get('logged_in') || session()->get('role') !== 'guru') {
            return redirect()->to(base_url('auth'));
        }

        $user_id = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $user_id)->first();
        
        if (!$guru) {
            return redirect()->to(base_url('auth'))->with('error', 'Data guru tidak ditemukan');
        }

        $siswa_ids = $this->request->getPost('siswa_id');
        $statuses = $this->request->getPost('status');
        $tanggal = $this->request->getPost('tanggal');
        $kelas_id = $this->request->getPost('kelas_id');

        if (!$siswa_ids || !$statuses || !$tanggal) {
            return redirect()->back()->with('error', 'Data tidak lengkap');
        }

        $success_count = 0;
        $error_count = 0;

        foreach ($siswa_ids as $index => $siswa_id) {
            $status = $statuses[$index] ?? 'Hadir';
            
            // Cek apakah absensi sudah ada
            $existing_absensi = $this->absensiModel->where([
                'siswa_id' => $siswa_id,
                'tanggal' => $tanggal
            ])->first();

            $absensi_data = [
                'siswa_id' => $siswa_id,
                'tanggal' => $tanggal,
                'status' => $status
            ];

            if ($existing_absensi) {
                // Update absensi yang sudah ada
                if ($this->absensiModel->update($existing_absensi['id'], $absensi_data)) {
                    $success_count++;
                } else {
                    $error_count++;
                }
            } else {
                // Insert absensi baru
                if ($this->absensiModel->insert($absensi_data)) {
                    $success_count++;
                } else {
                    $error_count++;
                }
            }
        }

        if ($success_count > 0) {
            $message = "Berhasil menyimpan absensi untuk $success_count siswa";
            if ($error_count > 0) {
                $message .= " ($error_count gagal)";
            }
            return redirect()->to("guru/absensi/input?kelas_id=$kelas_id&tanggal=$tanggal")->with('success', $message);
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan absensi');
        }
    }

    public function rekap()
    {
        // Cek session
        if (!session()->get('logged_in') || session()->get('role') !== 'guru') {
            return redirect()->to(base_url('auth'));
        }

        $user_id = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $user_id)->first();
        
        if (!$guru) {
            return redirect()->to(base_url('guru/dashboard'))->with('error', 'Data guru tidak ditemukan. Pastikan data guru sudah terdaftar dan user_id sesuai.');
        }

        $kelas_id = $this->request->getGet('kelas_id');
        $bulan = $this->request->getGet('bulan') ?: date('Y-m');

        // Ambil kelas yang diampu oleh guru ini
        $kelas_diampu = $this->jadwalModel->select('DISTINCT(kelas.id), kelas.nama_kelas')
            ->join('kelas', 'kelas.id = jadwal.kelas_id')
            ->where('jadwal.guru_id', $guru['id'])
            ->findAll();

        // Jika kelas dipilih, ambil rekap absensi
        $rekap_absensi = [];
        if ($kelas_id) {
            $siswa_list = $this->siswaModel->select('id, nisn, nama')->where('kelas_id', $kelas_id)->findAll();
            
            foreach ($siswa_list as $siswa) {
                // Hitung statistik absensi per bulan
                $hadir = $this->absensiModel->where([
                    'siswa_id' => $siswa['id'],
                    'status' => 'Hadir'
                ])->like('tanggal', $bulan)->countAllResults();
                
                $sakit = $this->absensiModel->where([
                    'siswa_id' => $siswa['id'],
                    'status' => 'Sakit'
                ])->like('tanggal', $bulan)->countAllResults();
                
                $izin = $this->absensiModel->where([
                    'siswa_id' => $siswa['id'],
                    'status' => 'Izin'
                ])->like('tanggal', $bulan)->countAllResults();
                
                $alpha = $this->absensiModel->where([
                    'siswa_id' => $siswa['id'],
                    'status' => 'Alpha'
                ])->like('tanggal', $bulan)->countAllResults();
                
                $total = $hadir + $sakit + $izin + $alpha;
                $persentase = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;
                
                $rekap_absensi[] = [
                    'siswa' => $siswa,
                    'hadir' => $hadir,
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'alpha' => $alpha,
                    'total' => $total,
                    'persentase' => $persentase
                ];
            }
        }

        $data = [
            'title' => 'Rekap Absensi',
            'guru' => $guru,
            'kelas_diampu' => $kelas_diampu,
            'rekap_absensi' => $rekap_absensi,
            'selected_kelas' => $kelas_id,
            'selected_bulan' => $bulan,
            'user' => $this->userModel->find($user_id)
        ];

        return view('guru/absensi/rekap', $data);
    }
} 