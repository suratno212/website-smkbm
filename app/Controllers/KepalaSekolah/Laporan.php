<?php
namespace App\Controllers\KepalaSekolah;

use App\Controllers\BaseController;

class Laporan extends BaseController
{
    public function index()
    {
        return view('kepalasekolah/laporan', [
            'title' => 'Laporan Akademik',
        ]);
    }
} 