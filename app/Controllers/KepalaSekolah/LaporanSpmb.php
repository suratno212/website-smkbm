<?php
namespace App\Controllers\KepalaSekolah;

use App\Controllers\BaseController;
use App\Models\SpmbModel;
use App\Models\JurusanModel;

class LaporanSpmb extends BaseController
{
    public function index()
    {
        $spmbModel = new SpmbModel();
        $jurusanModel = new JurusanModel();
        $tahun = $this->request->getGet('tahun') ?? date('Y');
        $statusList = ['Diterima', 'Diterima Bersyarat', 'Ditolak', 'Menunggu'];

        // Statistik utama
        $totalPendaftar = $spmbModel->where("YEAR(created_at)", $tahun)->countAllResults();
        $statStatus = [];
        foreach ($statusList as $status) {
            $statStatus[strtolower($status)] = $spmbModel->where("YEAR(created_at)", $tahun)->where('status_pendaftaran', $status)->countAllResults();
        }

        // Statistik per jurusan
        // Ambil hanya jurusan TKJ dan TBSM
        $jurusan = $jurusanModel->whereIn('kd_jurusan', ['TKJ', 'TBSM'])->findAll();
        $statJurusan = [];
        foreach ($jurusan as $j) {
            $statJurusan[] = [
                'nama_jurusan' => $j['nama_jurusan'],
                'total' => $spmbModel->where("YEAR(created_at)", $tahun)->where('jurusan_pilihan', $j['kd_jurusan'])->countAllResults(),
            ];
        }

        // Data tabel pendaftar hanya TKJ dan TBSM
        $pendaftar = $spmbModel->where("YEAR(created_at)", $tahun)
            ->whereIn('jurusan_pilihan', ['TKJ', 'TBSM'])
            ->findAll(1000);

        return view('kepalasekolah/laporan_spmb', [
            'title' => 'Laporan SPMB',
            'user' => session('user'),
            'tahun' => $tahun,
            'totalPendaftar' => $totalPendaftar,
            'statStatus' => $statStatus,
            'statJurusan' => $statJurusan,
            'pendaftar' => $pendaftar,
            'jurusanList' => $jurusan,
        ]);
    }

    public function cetak()
    {
        $spmbModel = new \App\Models\SpmbModel();
        $jurusanModel = new \App\Models\JurusanModel();
        $tahun = $this->request->getGet('tahun') ?? date('Y');
        $statusList = ['Diterima', 'Diterima Bersyarat', 'Ditolak', 'Menunggu'];

        $totalPendaftar = $spmbModel->where("YEAR(created_at)", $tahun)->countAllResults();
        $statStatus = [];
        foreach ($statusList as $status) {
            $statStatus[strtolower($status)] = $spmbModel->where("YEAR(created_at)", $tahun)->where('status_pendaftaran', $status)->countAllResults();
        }
        // Ambil hanya jurusan TKJ dan TBSM
        $jurusan = $jurusanModel->whereIn('kd_jurusan', ['TKJ', 'TBSM'])->findAll();
        $statJurusan = [];
        foreach ($jurusan as $j) {
            $statJurusan[] = [
                'nama_jurusan' => $j['nama_jurusan'],
                'total' => $spmbModel->where("YEAR(created_at)", $tahun)->where('jurusan_pilihan', $j['kd_jurusan'])->countAllResults(),
            ];
        }
        // Data tabel pendaftar hanya TKJ dan TBSM
        $pendaftar = $spmbModel->where("YEAR(created_at)", $tahun)
            ->whereIn('jurusan_pilihan', ['TKJ', 'TBSM'])
            ->findAll(1000);
        return view('kepalasekolah/laporan_spmb_cetak', [
            'title' => 'Cetak Laporan SPMB',
            'tahun' => $tahun,
            'totalPendaftar' => $totalPendaftar,
            'statStatus' => $statStatus,
            'statJurusan' => $statJurusan,
            'pendaftar' => $pendaftar,
            'jurusanList' => $jurusan,
        ]);
    }
} 