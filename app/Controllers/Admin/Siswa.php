<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\JurusanModel;
use App\Models\AgamaModel;
use App\Models\UserModel;

class Siswa extends BaseController
{
    protected $siswaModel;
    protected $kelasModel;
    protected $jurusanModel;
    protected $agamaModel;
    protected $userModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
        $this->jurusanModel = new JurusanModel();
        $this->agamaModel = new AgamaModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $filters = [
            'nis' => $this->request->getGet('nis'),
            'nama' => $this->request->getGet('nama'),
            'kd_kelas' => $this->request->getGet('kd_kelas'),
            'kd_jurusan' => $this->request->getGet('kd_jurusan')
        ];

        $data = [
            'title' => 'Data Siswa',
            'siswa' => $this->siswaModel->getSiswaWithRelations($filters),
            'kelas' => $this->kelasModel->findAll(),
            'jurusan' => $this->jurusanModel->findAll(),
            'filters' => $filters
        ];

        return view('admin/siswa/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Siswa',
            'kelas' => $this->kelasModel->findAll(),
            'jurusan' => $this->jurusanModel->findAll(),
            'agama' => $this->agamaModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/siswa/create', $data);
    }

    public function store()
    {
        // Validation rules
        $rules = [
            'nis' => 'required|is_unique[siswa.nis]',
            'nama' => 'required',
            'tanggal_lahir' => 'required|valid_date',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'agama_id' => 'required|numeric',
            'kd_kelas' => 'required',
            'kd_jurusan' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Create user account
        $userData = [
            'username' => $this->request->getPost('nis'),
            'email' => $this->request->getPost('nis') . '@smkbm.sch.id',
            'password' => password_hash($this->request->getPost('nis'), PASSWORD_DEFAULT),
            'role' => 'siswa'
        ];

        $this->userModel->insert($userData);
        $userId = $this->userModel->insertID();

        // Create siswa data
        $siswaData = [
            'user_id' => $userId,
            'nis' => $this->request->getPost('nis'),
            'nama' => $this->request->getPost('nama'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'agama_id' => $this->request->getPost('agama_id'),
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'kd_jurusan' => $this->request->getPost('kd_jurusan'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp')
        ];

        $this->siswaModel->insert($siswaData);

        return redirect()->to('admin/siswa')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit($nis)
    {
        $data = [
            'title' => 'Edit Siswa',
            'siswa' => $this->siswaModel->find($nis),
            'kelas' => $this->kelasModel->findAll(),
            'jurusan' => $this->jurusanModel->findAll(),
            'agama' => $this->agamaModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/siswa/edit', $data);
    }

    public function update($nis)
    {
        // Validation rules
        $rules = [
            'nis' => "required|is_unique[siswa.nis,nis,$nis]",
            'nama' => 'required',
            'tanggal_lahir' => 'required|valid_date',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'agama_id' => 'required|numeric',
            'kd_kelas' => 'required',
            'kd_jurusan' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $siswaData = [
            'nis' => $this->request->getPost('nis'),
            'nama' => $this->request->getPost('nama'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'agama_id' => $this->request->getPost('agama_id'),
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'kd_jurusan' => $this->request->getPost('kd_jurusan'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp')
        ];

        $this->siswaModel->update($nis, $siswaData);

        // Update email di tabel users
        $siswaLama = $this->siswaModel->find($nis);
        if ($siswaLama && $this->request->getPost('email')) {
            $this->userModel->update($siswaLama['user_id'], [
                'email' => $this->request->getPost('email')
            ]);
        }

        return redirect()->to('admin/siswa')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function delete($nis)
    {
        $siswa = $this->siswaModel->find($nis);
        if ($siswa) {
            // Delete user account
            $this->userModel->delete($siswa['user_id']);
            // Delete siswa
            $this->siswaModel->delete($nis);
        }

        return redirect()->to('admin/siswa')->with('success', 'Data siswa berhasil dihapus');
    }

    public function export()
    {
        $filters = [
            'kd_kelas' => $this->request->getGet('kd_kelas'),
            'kd_jurusan' => $this->request->getGet('kd_jurusan')
        ];

        $data = [
            'title' => 'Export Data Siswa',
            'siswa' => $this->siswaModel->getSiswaWithRelations($filters)
        ];

        return view('admin/siswa/export', $data);
    }

    public function cetak()
    {
        $filters = [
            'nis' => $this->request->getGet('nis'),
            'nama' => $this->request->getGet('nama'),
            'kd_kelas' => $this->request->getGet('kd_kelas'),
            'kd_jurusan' => $this->request->getGet('kd_jurusan')
        ];

        $data = [
            'title' => 'Cetak Data Siswa',
            'siswa' => $this->siswaModel->getSiswaWithRelations($filters),
            'kelas' => $this->kelasModel->findAll(),
            'jurusan' => $this->jurusanModel->findAll(),
            'filters' => $filters
        ];

        return view('admin/siswa/cetak', $data);
    }
}
