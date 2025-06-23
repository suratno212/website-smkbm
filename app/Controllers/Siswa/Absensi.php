<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\SiswaModel;
use App\Models\UserModel;

class Absensi extends BaseController
{
    protected $absensiModel;
    protected $siswaModel;
    protected $userModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->siswaModel = new SiswaModel();
        $this->userModel = new UserModel();
    }

    // Halaman utama absensi
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'siswa') {
            return redirect()->to(base_url('auth'));
        }
        
        $user_id = session()->get('user_id');
        $user = $this->userModel->find($user_id);
        $siswa = $this->siswaModel->where('user_id', $user_id)->first();
        
        if (!$siswa) {
            return view('siswa/absensi/index', [
                'title' => 'Absensi Siswa',
                'user' => $user,
                'siswa' => null,
                'absen_today' => null,
                'error_message' => 'Data siswa tidak ditemukan. Silakan hubungi admin.'
            ]);
        }
        
        $today = date('Y-m-d');
        $absen_today = $this->absensiModel->where('siswa_id', $siswa['id'])->where('tanggal', $today)->first();
        
        return view('siswa/absensi/index', [
            'title' => 'Absensi Siswa',
            'user' => $user,
            'siswa' => $siswa,
            'absen_today' => $absen_today,
            'error_message' => null
        ]);
    }

    // Form isi absensi
    public function form()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'siswa') {
            return redirect()->to(base_url('auth'));
        }
        $user_id = session()->get('user_id');
        $user = $this->userModel->find($user_id);
        $siswa = $this->siswaModel->where('user_id', $user_id)->first();
        if (!$siswa) {
            return view('siswa/absensi/form', [
                'title' => 'Isi Absensi',
                'user' => $user,
                'siswa' => null,
                'absen_today' => null,
                'error_message' => 'Data siswa tidak ditemukan. Silakan hubungi admin.'
            ]);
        }
        $today = date('Y-m-d');
        $absen_today = $this->absensiModel->where('siswa_id', $siswa['id'])->where('tanggal', $today)->first();
        return view('siswa/absensi/form', [
            'title' => 'Isi Absensi',
            'user' => $user,
            'siswa' => $siswa,
            'absen_today' => $absen_today,
            'error_message' => null
        ]);
    }

    // Simpan absensi
    public function simpan()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'siswa') {
            return redirect()->to(base_url('auth'));
        }
        $user_id = session()->get('user_id');
        $siswa = $this->siswaModel->where('user_id', $user_id)->first();
        $today = date('Y-m-d');
        $now = date('H:i');
        $status = $this->request->getPost('status');
        $keterangan = $this->request->getPost('keterangan');
        $absen_today = $this->absensiModel->where('siswa_id', $siswa['id'])->where('tanggal', $today)->first();
        if ($absen_today) {
            return redirect()->back()->with('error', 'Anda sudah mengisi absensi hari ini!');
        }
        // Log status Terlambat jika hadir setelah 07:00
        if ($status == 'hadir' && $now > '07:00') {
            $status = 'terlambat';
        }
        // Simpan absensi
        $this->absensiModel->insert([
            'siswa_id' => $siswa['id'],
            'tanggal' => $today,
            'status' => $status,
            'keterangan' => $keterangan
        ]);
        $absensi_id = $this->absensiModel->getInsertID();
        // Notifikasi ke wali kelas jika Terlambat/Alpha
        if ($status == 'terlambat' || $status == 'alpha') {
            // Cari wali kelas dari kelas siswa
            $kelasModel = new \App\Models\KelasModel();
            $kelas = $kelasModel->find($siswa['kelas_id']);
            if ($kelas && $kelas['wali_kelas_id']) {
                $notifikasiModel = new \App\Models\NotifikasiModel();
                $pesan = "Siswa {$siswa['nama']} melakukan absensi dengan status: " . ucfirst($status) . ".";
                $notifikasiModel->insert([
                    'user_id' => $kelas['wali_kelas_id'],
                    'siswa_id' => $siswa['id'],
                    'absensi_id' => $absensi_id,
                    'pesan' => $pesan,
                    'status' => 'belum_dibaca',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        return redirect()->to(base_url('siswa/absensi'))->with('success', 'Absensi berhasil disimpan!');
    }

    // Riwayat absensi
    public function riwayat()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'siswa') {
            return redirect()->to(base_url('auth'));
        }
        $user_id = session()->get('user_id');
        $user = $this->userModel->find($user_id);
        $siswa = $this->siswaModel->where('user_id', $user_id)->first();
        $riwayat = $this->absensiModel->where('siswa_id', $siswa['id'])->orderBy('tanggal', 'DESC')->findAll();
        return view('siswa/absensi/riwayat', [
            'title' => 'Riwayat Absensi',
            'user' => $user,
            'siswa' => $siswa,
            'riwayat' => $riwayat
        ]);
    }
} 