<?php

namespace App\Controllers;

use App\Models\PpdbModel;

class Ppdb extends BaseController
{
    protected $ppdbModel;

    public function __construct()
    {
        $this->ppdbModel = new PpdbModel();
    }

    public function index()
    {
        return view('ppdb/index');
    }

    public function daftar()
    {
        // Validasi input
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|valid_date',
            'agama' => 'required',
            'alamat' => 'required',
            'asal_sekolah' => 'required',
            'nama_ortu' => 'required',
            'no_hp_ortu' => 'required|numeric',
            'email' => 'required|valid_email',
            'no_hp' => 'required|numeric',
            'jurusan_pilihan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Generate nomor pendaftaran
        $noPendaftaran = $this->ppdbModel->generateNoPendaftaran();

        // Simpan data pendaftaran
        $data = [
            'no_pendaftaran' => $noPendaftaran,
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'agama' => $this->request->getPost('agama'),
            'alamat' => $this->request->getPost('alamat'),
            'asal_sekolah' => $this->request->getPost('asal_sekolah'),
            'nama_ortu' => $this->request->getPost('nama_ortu'),
            'no_hp_ortu' => $this->request->getPost('no_hp_ortu'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'jurusan_pilihan' => $this->request->getPost('jurusan_pilihan'),
            'status_pendaftaran' => 'Menunggu'
        ];

        $this->ppdbModel->insert($data);

        return redirect()->to(base_url('ppdb/sukses'))->with('no_pendaftaran', $noPendaftaran);
    }

    public function sukses()
    {
        $noPendaftaran = session()->getFlashdata('no_pendaftaran');
        
        if (!$noPendaftaran) {
            return redirect()->to(base_url('ppdb'));
        }

        return view('ppdb/sukses', ['no_pendaftaran' => $noPendaftaran]);
    }

    public function cekStatus()
    {
        return view('ppdb/cek_status');
    }

    public function cekStatusPost()
    {
        $noPendaftaran = $this->request->getPost('no_pendaftaran');
        $email = $this->request->getPost('email');

        $pendaftar = $this->ppdbModel->where('no_pendaftaran', $noPendaftaran)
                                    ->where('email', $email)
                                    ->first();

        if ($pendaftar) {
            return view('ppdb/status', ['pendaftar' => $pendaftar]);
        } else {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan');
        }
    }
} 