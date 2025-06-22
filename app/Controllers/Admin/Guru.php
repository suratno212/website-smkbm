<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\MapelModel;
use App\Models\UserModel;

class Guru extends BaseController
{
    protected $guruModel;
    protected $mapelModel;
    protected $userModel;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
        $this->mapelModel = new MapelModel();
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

        $filters = [
            'nip_nuptk' => $this->request->getGet('nip_nuptk'),
            'nama' => $this->request->getGet('nama'),
            'mapel_id' => $this->request->getGet('mapel_id')
        ];

        $data = [
            'title' => 'Data Guru',
            'guru' => $this->guruModel->getGuruWithRelations($filters),
            'mapel' => $this->mapelModel->findAll(),
            'filters' => $filters,
            'user' => $user
        ];

        return view('admin/guru/index', $data);
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
            'title' => 'Tambah Guru',
            'mapel' => $this->mapelModel->findAll(),
            'validation' => \Config\Services::validation(),
            'user' => $user
        ];

        return view('admin/guru/create', $data);
    }

    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'nama' => 'required',
            'nip_nuptk' => 'required|is_unique[guru.nip_nuptk]',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'tanggal_lahir' => 'required',
            'mapel_id' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Buat user baru untuk guru
        $userData = [
            'username' => $this->request->getPost('nip_nuptk'),
            'password' => password_hash($this->request->getPost('tanggal_lahir'), PASSWORD_DEFAULT),
            'role' => 'guru'
        ];

        $this->userModel->insert($userData);
        $userId = $this->userModel->getInsertID();
        if (!$userId) {
            return redirect()->back()->withInput()->with('errors', ['Gagal membuat user. Username mungkin sudah digunakan atau terjadi error pada data user.']);
        }

        // Simpan data guru
        $guruData = [
            'user_id' => $userId,
            'nama' => $this->request->getPost('nama'),
            'nip_nuptk' => $this->request->getPost('nip_nuptk'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'agama' => $this->request->getPost('agama'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'mapel_id' => $this->request->getPost('mapel_id'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp')
        ];

        $this->guruModel->insert($guruData);

        return redirect()->to('admin/guru')->with('success', 'Data guru berhasil ditambahkan');
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
            'title' => 'Edit Guru',
            'guru' => $this->guruModel->find($id),
            'mapel' => $this->mapelModel->findAll(),
            'validation' => \Config\Services::validation(),
            'user' => $user
        ];

        return view('admin/guru/edit', $data);
    }

    public function update($id)
    {
        // Cek session
        if (!session()->get('logged_in')) {
            return redirect()->to('auth');
        }

        // Validasi input
        if (!$this->validate([
            'nama' => 'required',
            'nip_nuptk' => 'required|is_unique[guru.nip_nuptk,id,' . $id . ']',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'tanggal_lahir' => 'required',
            'mapel_id' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data guru
        $guruData = [
            'nama' => $this->request->getPost('nama'),
            'nip_nuptk' => $this->request->getPost('nip_nuptk'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'agama' => $this->request->getPost('agama'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'mapel_id' => $this->request->getPost('mapel_id'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp')
        ];

        $this->guruModel->update($id, $guruData);

        // Update username di tabel users
        $guru = $this->guruModel->find($id);
        $this->userModel->update($guru['user_id'], [
            'username' => $this->request->getPost('nip_nuptk')
        ]);

        return redirect()->to('admin/guru')->with('success', 'Data guru berhasil diperbarui');
    }

    public function delete($id)
    {
        // Cek session
        if (!session()->get('logged_in')) {
            return redirect()->to('auth');
        }

        // Ambil data guru untuk mendapatkan user_id
        $guru = $this->guruModel->find($id);
        
        // Hapus data guru
        $this->guruModel->delete($id);
        
        // Hapus user terkait
        $this->userModel->delete($guru['user_id']);

        return redirect()->to('admin/guru')->with('success', 'Data guru berhasil dihapus');
    }
} 