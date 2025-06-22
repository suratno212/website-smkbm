<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WaliKelasModel;
use App\Models\KelasModel;
use App\Models\GuruModel;
use App\Models\TahunAkademikModel;
use App\Models\UserModel;

class WaliKelas extends BaseController
{
    protected $waliKelasModel;
    protected $kelasModel;
    protected $guruModel;
    protected $tahunAkademikModel;
    protected $userModel;

    public function __construct()
    {
        $this->waliKelasModel = new WaliKelasModel();
        $this->kelasModel = new KelasModel();
        $this->guruModel = new GuruModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Cek session
        if (!session()->get('logged_in')) {
            return redirect()->to('auth');
        }

        // Ambil data user
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            session()->destroy();
            return redirect()->to('auth')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        $data = [
            'title' => 'Data Wali Kelas',
            'wali_kelas' => $this->waliKelasModel->getWaliKelasWithRelations(),
            'user' => $user
        ];

        return view('admin/wali_kelas/index', $data);
    }

    public function create()
    {
        // Cek session
        if (!session()->get('logged_in')) {
            return redirect()->to('auth');
        }

        // Ambil data user
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            session()->destroy();
            return redirect()->to('auth')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        $data = [
            'title' => 'Tambah Wali Kelas',
            'kelas' => $this->kelasModel->findAll(),
            'guru' => $this->guruModel->getGuruWithRelations(),
            'tahun_akademik' => $this->tahunAkademikModel->findAll(),
            'validation' => \Config\Services::validation(),
            'user' => $user
        ];

        return view('admin/wali_kelas/create', $data);
    }

    public function store()
    {
        // Cek session
        if (!session()->get('logged_in')) {
            return redirect()->to('auth');
        }

        // Validasi input
        if (!$this->validate([
            'kelas_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelas harus dipilih'
                ]
            ],
            'guru_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Guru harus dipilih'
                ]
            ],
            'tahun_akademik_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun akademik harus dipilih'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        // Cek apakah kelas sudah memiliki wali kelas di tahun akademik yang sama
        $existingWaliKelas = $this->waliKelasModel->where([
            'kelas_id' => $this->request->getPost('kelas_id'),
            'tahun_akademik_id' => $this->request->getPost('tahun_akademik_id')
        ])->first();
        
        if ($existingWaliKelas) {
            return redirect()->back()->withInput()->with('error', 'Kelas ini sudah memiliki wali kelas pada tahun akademik yang dipilih');
        }

        // Simpan data wali kelas
        $this->waliKelasModel->insert([
            'kelas_id' => $this->request->getPost('kelas_id'),
            'guru_id' => $this->request->getPost('guru_id'),
            'tahun_akademik_id' => $this->request->getPost('tahun_akademik_id')
        ]);

        session()->setFlashdata('success', 'Data wali kelas berhasil ditambahkan');
        return redirect()->to('admin/wali_kelas');
    }

    public function edit($id)
    {
        // Cek session
        if (!session()->get('logged_in')) {
            return redirect()->to('auth');
        }

        // Ambil data user
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            session()->destroy();
            return redirect()->to('auth')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        $data = [
            'title' => 'Edit Wali Kelas',
            'wali_kelas' => $this->waliKelasModel->find($id),
            'kelas' => $this->kelasModel->findAll(),
            'guru' => $this->guruModel->getGuruWithRelations(),
            'tahun_akademik' => $this->tahunAkademikModel->findAll(),
            'validation' => \Config\Services::validation(),
            'user' => $user
        ];

        return view('admin/wali_kelas/edit', $data);
    }

    public function update($id)
    {
        // Cek session
        if (!session()->get('logged_in')) {
            return redirect()->to('auth');
        }

        // Validasi input
        if (!$this->validate([
            'kelas_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelas harus dipilih'
                ]
            ],
            'guru_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Guru harus dipilih'
                ]
            ],
            'tahun_akademik_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun akademik harus dipilih'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        // Cek apakah kelas sudah memiliki wali kelas di tahun akademik yang sama (kecuali data yang sedang diedit)
        $existingWaliKelas = $this->waliKelasModel->where([
            'kelas_id' => $this->request->getPost('kelas_id'),
            'tahun_akademik_id' => $this->request->getPost('tahun_akademik_id')
        ])->where('id !=', $id)->first();
        
        if ($existingWaliKelas) {
            return redirect()->back()->withInput()->with('error', 'Kelas ini sudah memiliki wali kelas pada tahun akademik yang dipilih');
        }

        // Update data wali kelas
        $this->waliKelasModel->update($id, [
            'kelas_id' => $this->request->getPost('kelas_id'),
            'guru_id' => $this->request->getPost('guru_id'),
            'tahun_akademik_id' => $this->request->getPost('tahun_akademik_id')
        ]);

        session()->setFlashdata('success', 'Data wali kelas berhasil diperbarui');
        return redirect()->to('admin/wali_kelas');
    }

    public function delete($id)
    {
        // Cek session
        if (!session()->get('logged_in')) {
            return redirect()->to('auth');
        }

        // Hapus data wali kelas
        $this->waliKelasModel->delete($id);

        session()->setFlashdata('success', 'Data wali kelas berhasil dihapus');
        return redirect()->to('admin/wali_kelas');
    }
} 