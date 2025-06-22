<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find(session()->get('user_id'));
        $data = [
            'title' => 'Manajemen User',
            'user' => $user,
            'users' => $this->userModel->findAll()
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User'
        ];

        return view('admin/users/create', $data);
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[admin,guru,siswa]',
            'foto' => 'uploaded[foto]|max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $foto = $this->request->getFile('foto');
        $fotoName = $foto->getRandomName();
        $foto->move('uploads/profile', $fotoName);

        $this->userModel->insert([
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'foto' => $fotoName
        ]);

        return redirect()->to('admin/users')->with('message', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit User',
            'user' => $this->userModel->find($id)
        ];

        if (!$data['user']) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan');
        }

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan');
        }

        $rules = [
            'username' => "required|min_length[3]",
            'email' => "required|valid_email",
            'role' => 'required|in_list[admin,guru,siswa]'
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if ($this->request->getFile('foto')->isValid() && !$this->request->getFile('foto')->hasMoved()) {
            $rules['foto'] = 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($this->request->getFile('foto')->isValid()) {
            $foto = $this->request->getFile('foto');
            $fotoName = $foto->getRandomName();
            $foto->move('uploads/profile', $fotoName);

            if (isset($user['foto']) && $user['foto'] && file_exists('uploads/profile/' . $user['foto'])) {
                unlink('uploads/profile/' . $user['foto']);
            }

            $data['foto'] = $fotoName;
        }

        $result = $this->userModel->update($id, $data);
        if (!$result) {
            $debug = print_r($data, true);
            $errors = $this->userModel->errors();
            return redirect()->back()->withInput()->with('errors', ['Gagal update database. Data: ' . $debug, 'Error: ' . print_r($errors, true)]);
        }
        return redirect()->to('admin/users')->with('message', 'User berhasil diperbarui');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan');
        }

        // Hapus data siswa/guru yang terkait user_id ini
        if ($user['role'] === 'siswa') {
            $db = \Config\Database::connect();
            $db->table('siswa')->where('user_id', $id)->delete();
        } elseif ($user['role'] === 'guru') {
            $db = \Config\Database::connect();
            $db->table('guru')->where('user_id', $id)->delete();
        }

        if (isset($user['foto']) && $user['foto'] && file_exists('uploads/profile/' . $user['foto'])) {
            unlink('uploads/profile/' . $user['foto']);
        }

        $this->userModel->delete($id);

        return redirect()->to('admin/users')->with('message', 'User berhasil dihapus');
    }

    public function mass_delete()
    {
        $ids = $this->request->getPost('user_ids');
        if ($ids && is_array($ids)) {
            foreach ($ids as $id) {
                $user = $this->userModel->find($id);
                if ($user) {
                    // Hapus data siswa/guru yang terkait user_id ini
                    if ($user['role'] === 'siswa') {
                        $db = \Config\Database::connect();
                        $db->table('siswa')->where('user_id', $id)->delete();
                    } elseif ($user['role'] === 'guru') {
                        $db = \Config\Database::connect();
                        $db->table('guru')->where('user_id', $id)->delete();
                    }
                    if (isset($user['foto']) && $user['foto'] && file_exists('uploads/profile/' . $user['foto'])) {
                        unlink('uploads/profile/' . $user['foto']);
                    }
                    $this->userModel->delete($id);
                }
            }
        }
        return redirect()->to('admin/users')->with('message', 'User terpilih berhasil dihapus');
    }
} 