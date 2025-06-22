<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\PengumumanModel;
use App\Models\UserModel;

class Pengumuman extends BaseController
{
    protected $pengumumanModel;
    protected $userModel;

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Pengumuman',
            'pengumuman' => $this->pengumumanModel->getActiveAnnouncements(),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('siswa/pengumuman/index', $data);
    }

    public function jadwalUjian()
    {
        $data = [
            'title' => 'Jadwal Ujian',
            'pengumuman' => $this->pengumumanModel->getExamSchedules(),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('siswa/pengumuman/jadwal_ujian', $data);
    }

    public function download($id)
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