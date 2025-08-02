<?php
namespace App\Controllers\CalonSiswa;

use App\Controllers\BaseController;
use App\Models\CalonSiswaModel;
use App\Models\SpmbModel;
use App\Models\UjianSpmbModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $user = session()->get();
        $calonSiswaModel = new CalonSiswaModel();
        $spmbModel = new SpmbModel();
        $ujianModel = new UjianSpmbModel();
        
        // Ambil data calon siswa berdasarkan user_id
        $calonSiswa = $calonSiswaModel->where('user_id', $user['user_id'])->first();
        
        // Gunakan username sebagai email untuk kompatibilitas dengan sistem SPMB
        $email = $user['username']; // username adalah email
        $spmb = $spmbModel->where('email', $email)->first();
        $ujian = $ujianModel->where('peserta_id', $user['user_id'])->orderBy('id','desc')->first();
        
        return view('calonsiswa/dashboard', [
            'title' => 'Dashboard Calon Siswa',
            'user' => $user,
            'calon_siswa' => $calonSiswa,
            'spmb' => $spmb,
            'ujian' => $ujian
        ]);
    }
} 