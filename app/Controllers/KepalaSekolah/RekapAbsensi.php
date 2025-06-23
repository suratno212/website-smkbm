<?php
namespace App\Controllers\KepalaSekolah;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\AbsensiModel;

class RekapAbsensi extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();
        $kelasModel = new KelasModel();
        $absensiModel = new AbsensiModel();

        $kelas = $kelasModel->findAll();
        $filter_kelas = $this->request->getGet('kelas_id');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $dataAbsensi = [];

        if ($filter_kelas && $tanggal_mulai && $tanggal_akhir) {
            $siswaList = $siswaModel->where('kelas_id', $filter_kelas)->findAll();
            foreach ($siswaList as $siswa) {
                $absensi = $absensiModel->where('siswa_id', $siswa['id'])
                    ->where('tanggal >=', $tanggal_mulai)
                    ->where('tanggal <=', $tanggal_akhir)
                    ->findAll();
                $dataAbsensi[] = [
                    'nama' => $siswa['nama'],
                    'kelas' => $kelasModel->find($siswa['kelas_id'])['nama_kelas'] ?? '-',
                    'hadir' => count(array_filter($absensi, fn($a) => $a['status'] == 'Hadir')),
                    'izin' => count(array_filter($absensi, fn($a) => $a['status'] == 'Izin')),
                    'sakit' => count(array_filter($absensi, fn($a) => $a['status'] == 'Sakit')),
                    'alpha' => count(array_filter($absensi, fn($a) => $a['status'] == 'Alpha')),
                ];
            }
        }

        return view('kepalasekolah/rekap_absensi', [
            'title' => 'Rekap Absensi',
            'user' => session('user'),
            'dataAbsensi' => $dataAbsensi,
            'kelas' => $kelas,
            'filter_kelas' => $filter_kelas,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir
        ]);
    }
} 