<?php

namespace App\Controllers;

class Navbar extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'SMK Bhakti Mulya BNS Lampung',
            'menu' => [
                'home' => [
                    'url' => '#home',
                    'text' => 'Home'
                ],
                'profil' => [
                    'url' => '#profil',
                    'text' => 'Profil'
                ],
                'berita' => [
                    'url' => '#berita',
                    'text' => 'Berita'
                ],
                'jurusan' => [
                    'url' => '#jurusan',
                    'text' => 'Jurusan'
                ],
                'galeri' => [
                    'url' => '#galeri',
                    'text' => 'Galeri'
                ],
                'pegawai' => [
                    'url' => '#pegawai',
                    'text' => 'Data Pegawai'
                ]
            ]
        ];

        return view('navbar', $data);
    }
} 