<?php
namespace App\Controllers\KepalaSekolah;

use App\Controllers\BaseController;

class RekapNilai extends BaseController
{
    public function index()
    {
        return view('kepalasekolah/rekap_nilai', [
            'title' => 'Rekap Nilai Siswa',
        ]);
    }
} 