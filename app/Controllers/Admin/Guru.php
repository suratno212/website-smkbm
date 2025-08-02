<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\MapelModel;
use App\Models\UserModel;
use App\Models\AgamaModel;

class Guru extends BaseController
{
    protected $guruModel;
    protected $mapelModel;
    protected $userModel;
    protected $agamaModel;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
        $this->mapelModel = new MapelModel();
        $this->userModel = new UserModel();
        $this->agamaModel = new AgamaModel();
    }

    public function index()
    {
        $filters = [
            'nik_nip' => $this->request->getGet('nik_nip'),
            'nama' => $this->request->getGet('nama'),
            'kd_mapel' => $this->request->getGet('kd_mapel')
        ];

        $data = [
            'title' => 'Data Guru',
            'guru' => $this->guruModel->getGuruWithMapel($filters),
            'mapel' => $this->mapelModel->findAll(),
            'filters' => $filters
        ];

        return view('admin/guru/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Guru',
            'mapel' => $this->mapelModel->findAll(),
            'agama' => $this->agamaModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/guru/create', $data);
    }

    public function store()
    {
        // Validation rules
        $rules = [
            'nik_nip' => 'required|is_unique[guru.nik_nip]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'nama' => 'required',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'agama_id' => 'required|numeric',
            'tanggal_lahir' => 'required|valid_date',
            'kd_mapel' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Create user account
        $userData = [
            'username' => $this->request->getPost('nik_nip'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('nik_nip'), PASSWORD_DEFAULT),
            'role' => 'guru'
        ];

        $this->userModel->insert($userData);
        $userId = $this->userModel->insertID();

        // Create guru data
        $guruData = [
            'user_id' => $userId,
            'nik_nip' => $this->request->getPost('nik_nip'),
            'nama' => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'agama_id' => $this->request->getPost('agama_id'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'kd_mapel' => $this->request->getPost('kd_mapel'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp')
        ];

        $this->guruModel->insert($guruData);

        return redirect()->to('admin/guru')->with('success', 'Data guru berhasil ditambahkan');
    }

    public function edit($nikNip)
    {
        $data = [
            'title' => 'Edit Guru',
            'guru' => $this->guruModel->getGuruWithRelations($nikNip),
            'mapel' => $this->mapelModel->findAll(),
            'agama' => $this->agamaModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/guru/edit', $data);
    }

    public function update($nikNip)
    {
        // Validation rules
        $rules = [
            'nik_nip' => "required|is_unique[guru.nik_nip,nik_nip,$nikNip]",
            'email' => 'required|valid_email',
            'nama' => 'required',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'agama_id' => 'required|numeric',
            'tanggal_lahir' => 'required|valid_date',
            'kd_mapel' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get current guru data to get user_id
        $currentGuru = $this->guruModel->find($nikNip);
        
        // Update user email
        if ($currentGuru) {
            $userData = [
                'email' => $this->request->getPost('email')
            ];
            $this->userModel->update($currentGuru['user_id'], $userData);
        }

        $guruData = [
            'nik_nip' => $this->request->getPost('nik_nip'),
            'nama' => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'agama_id' => $this->request->getPost('agama_id'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'kd_mapel' => $this->request->getPost('kd_mapel'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp')
        ];

        $this->guruModel->update($nikNip, $guruData);

        return redirect()->to('admin/guru')->with('success', 'Data guru berhasil diperbarui');
    }

    public function delete($nikNip)
    {
        $guru = $this->guruModel->find($nikNip);
        if ($guru) {
            // Delete user account
            $this->userModel->delete($guru['user_id']);
            // Delete guru
            $this->guruModel->delete($nikNip);
        }

        return redirect()->to('admin/guru')->with('success', 'Data guru berhasil dihapus');
    }
} 