<?php

namespace App\Controllers;

use App\Models\PengumumanModel;

class Home extends BaseController
{
    protected $pengumumanModel;

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'SMK Bhakti Mulya BNS Lampung - Beranda',
            'menu' => [
                ['url' => '#berita', 'text' => 'Berita'],
                ['url' => '#jurusan', 'text' => 'Jurusan'],
                ['url' => '#galeri', 'text' => 'Galeri'],
                ['url' => '#pegawai', 'text' => 'Pegawai'],
                ['url' => '#ppdb', 'text' => 'PPDB']
            ],
            'navbar' => view('navbar', [
                'menu' => [
                    ['url' => '#berita', 'text' => 'Berita'],
                    ['url' => '#jurusan', 'text' => 'Jurusan'],
                    ['url' => '#galeri', 'text' => 'Galeri'],
                    ['url' => '#pegawai', 'text' => 'Pegawai'],
                    ['url' => '#ppdb', 'text' => 'PPDB']
                ]
            ]),
            'pengumuman' => $this->pengumumanModel->getActiveAnnouncements()
        ];
        
        return view('home', $data);
    }

    public function pengumuman()
    {
        $data = [
            'title' => 'Pengumuman - SMK Bhakti Mulya BNS',
            'pengumuman' => $this->pengumumanModel->getActiveAnnouncements()
        ];
        return view('pages/pengumuman', $data);
    }

    public function jadwalUjian()
    {
        $data = [
            'title' => 'Jadwal Ujian - SMK Bhakti Mulya BNS',
            'pengumuman' => $this->pengumumanModel->getExamSchedules()
        ];
        return view('pages/jadwal_ujian', $data);
    }

    public function downloadPengumuman($id)
    {
        $pengumuman = $this->pengumumanModel->find($id);
        if (!$pengumuman || !$pengumuman['file']) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        $filePath = ROOTPATH . 'public/uploads/pengumuman/' . $pengumuman['file'];
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        return $this->response->download($filePath, $pengumuman['file']);
    }
}
