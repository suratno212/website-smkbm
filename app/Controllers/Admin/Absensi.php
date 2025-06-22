<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use App\Models\AbsensiModel;

class Absensi extends BaseController
{
    public function rekapSiswa()
    {
        $kelasModel = new KelasModel();
        $absensiModel = new AbsensiModel();
        $siswaModel = new SiswaModel();
        $kelas = $kelasModel->findAll();
        $filter_kelas = $this->request->getGet('kelas_id');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $rekap = [];
        if ($filter_kelas && $tanggal_mulai && $tanggal_akhir) {
            $siswa = $siswaModel->where('kelas_id', $filter_kelas)->findAll();
            foreach ($siswa as $s) {
                $absensi = $absensiModel->where('siswa_id', $s['id'])
                    ->where('tanggal >=', $tanggal_mulai)
                    ->where('tanggal <=', $tanggal_akhir)
                    ->findAll();
                $rekap[] = [
                    'nama' => $s['nama'],
                    'nisn' => $s['nisn'],
                    'hadir' => count(array_filter($absensi, fn($a) => $a['status'] == 'Hadir')),
                    'sakit' => count(array_filter($absensi, fn($a) => $a['status'] == 'Sakit')),
                    'izin' => count(array_filter($absensi, fn($a) => $a['status'] == 'Izin')),
                    'alpha' => count(array_filter($absensi, fn($a) => $a['status'] == 'Alpha')),
                ];
            }
        }
        return view('admin/absensi/rekap_siswa', [
            'title' => 'Rekap Absensi Siswa',
            'kelas' => $kelas,
            'rekap' => $rekap,
            'filter_kelas' => $filter_kelas,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir
        ]);
    }

    public function cetakRekapSiswa()
    {
        $kelasModel = new KelasModel();
        $absensiModel = new AbsensiModel();
        $siswaModel = new SiswaModel();
        $kelas = $kelasModel->findAll();
        $filter_kelas = $this->request->getGet('kelas_id');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $rekap = [];
        if ($filter_kelas && $tanggal_mulai && $tanggal_akhir) {
            $siswa = $siswaModel->where('kelas_id', $filter_kelas)->findAll();
            foreach ($siswa as $s) {
                $absensi = $absensiModel->where('siswa_id', $s['id'])
                    ->where('tanggal >=', $tanggal_mulai)
                    ->where('tanggal <=', $tanggal_akhir)
                    ->findAll();
                $rekap[] = [
                    'nama' => $s['nama'],
                    'nisn' => $s['nisn'],
                    'hadir' => count(array_filter($absensi, fn($a) => $a['status'] == 'Hadir')),
                    'sakit' => count(array_filter($absensi, fn($a) => $a['status'] == 'Sakit')),
                    'izin' => count(array_filter($absensi, fn($a) => $a['status'] == 'Izin')),
                    'alpha' => count(array_filter($absensi, fn($a) => $a['status'] == 'Alpha')),
                ];
            }
        }
        return view('admin/absensi/cetak_rekap_siswa', [
            'title' => 'Cetak Rekap Absensi Siswa',
            'kelas' => $kelas,
            'rekap' => $rekap,
            'filter_kelas' => $filter_kelas,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir
        ]);
    }

    public function rekapGuru()
    {
        $guruModel = new \App\Models\GuruModel();
        $absensiGuruModel = new \App\Models\AbsensiGuruModel();
        $guru = $guruModel->findAll();
        $filter_guru = $this->request->getGet('guru_id');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $rekap = [];
        if ($filter_guru && $tanggal_mulai && $tanggal_akhir) {
            $absensi = $absensiGuruModel->where('guru_id', $filter_guru)
                ->where('tanggal >=', $tanggal_mulai)
                ->where('tanggal <=', $tanggal_akhir)
                ->orderBy('tanggal', 'ASC')
                ->findAll();
            foreach ($absensi as $a) {
                $rekap[] = [
                    'tanggal' => $a['tanggal'],
                    'status' => $a['status'],
                    'keterangan' => $a['keterangan'] ?? ''
                ];
            }
        }
        return view('admin/absensi/rekap_guru', [
            'title' => 'Rekap Absensi Guru',
            'guru' => $guru,
            'rekap' => $rekap,
            'filter_guru' => $filter_guru,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir
        ]);
    }

    public function cetakRekapGuru()
    {
        $guruModel = new \App\Models\GuruModel();
        $absensiGuruModel = new \App\Models\AbsensiGuruModel();
        $guru = $guruModel->findAll();
        $filter_guru = $this->request->getGet('guru_id');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $rekap = [];
        if ($filter_guru && $tanggal_mulai && $tanggal_akhir) {
            $absensi = $absensiGuruModel->where('guru_id', $filter_guru)
                ->where('tanggal >=', $tanggal_mulai)
                ->where('tanggal <=', $tanggal_akhir)
                ->orderBy('tanggal', 'ASC')
                ->findAll();
            foreach ($absensi as $a) {
                $rekap[] = [
                    'tanggal' => $a['tanggal'],
                    'status' => $a['status'],
                    'keterangan' => $a['keterangan'] ?? ''
                ];
            }
        }
        return view('admin/absensi/cetak_rekap_guru', [
            'title' => 'Cetak Rekap Absensi Guru',
            'guru' => $guru,
            'rekap' => $rekap,
            'filter_guru' => $filter_guru,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir
        ]);
    }
} 