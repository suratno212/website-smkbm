<?php
namespace App\Controllers\KepalaSekolah;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\JurusanModel;

class Statistik extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();
        $guruModel = new GuruModel();
        $kelasModel = new KelasModel();
        $jurusanModel = new JurusanModel();

        $data = [
            'title' => 'Statistik Siswa & Guru',
            'total_siswa' => $siswaModel->countAll(),
            'total_guru' => $guruModel->countAll(),
            'total_kelas' => $kelasModel->countAll(),
            'total_jurusan' => $jurusanModel->countAll(),
            'user' => session('user'),
        ];
        return view('kepalasekolah/statistik', $data);
    }
} 