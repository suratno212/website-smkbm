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

        $absensi = $this->absensiGuruModel->where('nik_nip', $guru['nik_nip'])->orderBy('tanggal', 'DESC')->findAll();

        // Statistik kehadiran bulanan
        $bulan = date('m');
        $tahun = date('Y');
        $stat = [
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alfa' => 0
        ];
        foreach ($absensi as $a) {
            if (date('m', strtotime($a['tanggal'])) == $bulan && date('Y', strtotime($a['tanggal'])) == $tahun) {
                $status = strtolower($a['status']);
                if (isset($stat[$status])) {
                    $stat[$status]++;
                }
            }
        }

        return view('guru/absensi_guru/index', [
            'title' => 'Absensi Guru',
            'guru' => $guru,
            'absensi' => $absensi,
            'stat' => $stat,
            'riwayat' => $absensi
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
        $absen_today = $this->absensiGuruModel->where('nik_nip', $guru['nik_nip'])->where('tanggal', $today)->first();

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
            'status'     => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tanggal = $this->request->getPost('tanggal');
        $status = $this->request->getPost('status');
        $absen_today = $this->absensiGuruModel->where('nik_nip', $guru['nik_nip'])->where('tanggal', $tanggal)->first();

        if (!$absen_today) {
            // Absen masuk (insert)
            $data = [
                'nik_nip'    => $guru['nik_nip'],
                'tanggal'    => $tanggal,
                'jam_masuk'  => date('H:i:s'),
                'status'     => $status,
            ];
            $this->absensiGuruModel->save($data);
            return redirect()->to('/guru/absensi-guru')->with('success', 'Absen masuk berhasil.');
        } elseif (empty($absen_today['jam_pulang'])) {
            // Absen pulang (update)
            $this->absensiGuruModel->update($absen_today['kd_absensi_guru'], [
                'jam_pulang' => date('H:i:s'),
            ]);
            return redirect()->to('/guru/absensi-guru')->with('success', 'Absen pulang berhasil.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Anda sudah melakukan absen masuk dan pulang hari ini.');
        }
    }
}
