<?php
namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\AbsensiGuruModel;
use App\Models\GuruModel;

class AbsensiGuru extends BaseController
{
    protected $absensiGuruModel;
    protected $guruModel;

    public function __construct()
    {
        $this->absensiGuruModel = new AbsensiGuruModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'guru') {
            return redirect()->to(base_url('auth'));
        }

        $user_id = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $user_id)->first();
        
        if (!$guru) {
            return redirect()->to(base_url('auth'))->with('error', 'Data guru tidak ditemukan');
        }

        $absensi = $this->absensiGuruModel->where('guru_id', $guru['id'])->orderBy('tanggal', 'DESC')->findAll();
        
        return view('guru/absensi_guru/index', [
            'title' => 'Absensi Guru',
            'guru' => $guru,
            'absensi' => $absensi
        ]);
    }

    public function create()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'guru') {
            return redirect()->to(base_url('auth'));
        }

        $user_id = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $user_id)->first();
        
        if (!$guru) {
            return redirect()->to(base_url('auth'))->with('error', 'Data guru tidak ditemukan');
        }

        // Cek apakah sudah absen hari ini
        $today = date('Y-m-d');
        $absen_today = $this->absensiGuruModel->where('guru_id', $guru['id'])->where('tanggal', $today)->first();

        return view('guru/absensi_guru/create', [
            'title' => 'Input Absensi Guru',
            'guru' => $guru,
            'absen_today' => $absen_today
        ]);
    }

    public function store()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'guru') {
            return redirect()->to(base_url('auth'));
        }

        $user_id = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $user_id)->first();
        
        if (!$guru) {
            return redirect()->to(base_url('auth'))->with('error', 'Data guru tidak ditemukan');
        }

        // Validasi input
        if (!$this->validate([
            'tanggal'    => 'required',
            'jam_masuk'  => 'required',
            'status'     => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Cek apakah sudah absen di tanggal yang sama
        $tanggal = $this->request->getPost('tanggal');
        $existing_absen = $this->absensiGuruModel->where('guru_id', $guru['id'])->where('tanggal', $tanggal)->first();
        
        if ($existing_absen) {
            return redirect()->back()->withInput()->with('error', 'Anda sudah mengisi absensi untuk tanggal ' . $tanggal);
        }

        $data = [
            'guru_id'    => $guru['id'],
            'tanggal'    => $tanggal,
            'jam_masuk'  => $this->request->getPost('jam_masuk'),
            'jam_pulang' => $this->request->getPost('jam_pulang'),
            'status'     => $this->request->getPost('status'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        $this->absensiGuruModel->save($data);
        return redirect()->to('/guru/absensi-guru')->with('success', 'Absensi berhasil disimpan.');
    }
} 