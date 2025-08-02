<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\SiswaModel;
use App\Models\GuruModel;

class Pengguna extends BaseController
{
    protected $userModel;
    protected $siswaModel;
    protected $guruModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        $filters = [
            'role' => $this->request->getGet('role'),
            'status' => $this->request->getGet('status')
        ];

        $builder = $this->userModel->select('users.*, siswa.nama as nama_siswa, guru.nama as nama_guru')
            ->join('siswa', 'siswa.user_id = users.id', 'left')
            ->join('guru', 'guru.user_id = users.id', 'left');

        if ($filters['role']) {
            $builder->where('users.role', $filters['role']);
        }

        if ($filters['status']) {
            $builder->where('users.status', $filters['status']);
        }

        $data = [
            'title' => 'Data Pengguna',
            'users' => $builder->findAll(),
            'filters' => $filters
        ];

        return view('admin/pengguna/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/pengguna/create', $data);
    }

    public function store()
    {
        // Validation rules
        $rules = [
            'username' => 'required|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[admin,guru,siswa]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'status' => 'active'
        ];

        $this->userModel->insert($userData);

        return redirect()->to('admin/pengguna')->with('success', 'Data pengguna berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pengguna',
            'user' => $this->userModel->find($id),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/pengguna/edit', $data);
    }

    public function update($id)
    {
        // Validation rules
        $rules = [
            'username' => "required|is_unique[users.username,id,$id]",
            'email' => "required|valid_email|is_unique[users.email,id,$id]",
            'role' => 'required|in_list[admin,guru,siswa]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role')
        ];

        // Update password if provided
        $password = $this->request->getPost('password');
        if ($password) {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $userData);

        return redirect()->to('admin/pengguna')->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if ($user) {
            // Delete related data
            if ($user['role'] == 'siswa') {
                $siswa = $this->siswaModel->where('user_id', $id)->first();
                if ($siswa) {
                    $this->siswaModel->delete($siswa['nis']);
                }
            } elseif ($user['role'] == 'guru') {
                $guru = $this->guruModel->where('user_id', $id)->first();
                if ($guru) {
                    $this->guruModel->delete($guru['nik_nip']);
                }
            }

            // Delete user
            $this->userModel->delete($id);
        }

        return redirect()->to('admin/pengguna')->with('success', 'Data pengguna berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $user = $this->userModel->find($id);
        if ($user) {
            $newStatus = $user['status'] == 'active' ? 'inactive' : 'active';
            $this->userModel->update($id, ['status' => $newStatus]);
        }

        return redirect()->to('admin/pengguna')->with('success', 'Status pengguna berhasil diubah');
    }
} 