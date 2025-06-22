<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\JurusanModel;
use App\Models\UserModel;
use App\Models\AgamaModel;

class Siswa extends BaseController
{
    protected $siswaModel;
    protected $kelasModel;
    protected $jurusanModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
        $this->jurusanModel = new JurusanModel();
    }

    public function index()
    {
        // Ambil parameter filter
        $filters = [
            'nisn' => $this->request->getGet('nis'),
            'nama' => $this->request->getGet('nama'),
            'kelas_id' => $this->request->getGet('kelas_id'),
            'jurusan_id' => $this->request->getGet('jurusan_id')
        ];

        $userModel = new UserModel();
        $user = $userModel->find(session()->get('user_id'));
        $data = [
            'title' => 'Data Siswa',
            'user' => $user,
            'siswa' => $this->siswaModel->getSiswaWithRelations($filters),
            'kelas' => $this->kelasModel->findAll(),
            'jurusan' => $this->jurusanModel->findAll(),
            'filters' => $filters
        ];
        
        return view('admin/siswa/index', $data);
    }

    public function create()
    {
        $agamaModel = new AgamaModel();
        $data = [
            'title' => 'Tambah Siswa',
            'user' => [
                'username' => session()->get('username'),
                'role' => session()->get('role')
            ],
            'kelas' => $this->kelasModel->findAll(),
            'jurusan' => $this->jurusanModel->findAll(),
            'agama' => $agamaModel->findAll(),
        ];
        
        return view('admin/siswa/create', $data);
    }

    public function store()
    {
        // Validasi input
        $rules = [
            'nisn' => 'required|is_unique[siswa.nisn]',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'kelas_id' => 'required',
            'jurusan_id' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'agama_id' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data siswa
        $this->siswaModel->insert([
            'nisn' => $this->request->getPost('nisn'),
            'nama' => $this->request->getPost('nama'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'kelas_id' => $this->request->getPost('kelas_id'),
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp'),
            'agama_id' => $this->request->getPost('agama_id'),
        ]);

        return redirect()->to(base_url('admin/siswa'))->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $agamaModel = new AgamaModel();
        $data = [
            'title' => 'Edit Siswa',
            'user' => [
                'username' => session()->get('username'),
                'role' => session()->get('role')
            ],
            'siswa' => $this->siswaModel->find($id),
            'kelas' => $this->kelasModel->findAll(),
            'jurusan' => $this->jurusanModel->findAll(),
            'agama' => $agamaModel->findAll(),
        ];
        
        return view('admin/siswa/edit', $data);
    }

    public function update($id)
    {
        // Validasi input
        $rules = [
            'nisn' => "required|is_unique[siswa.nisn,id,$id]",
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'kelas_id' => 'required',
            'jurusan_id' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'agama_id' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data siswa
        $this->siswaModel->update($id, [
            'nisn' => $this->request->getPost('nisn'),
            'nama' => $this->request->getPost('nama'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'kelas_id' => $this->request->getPost('kelas_id'),
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp'),
            'agama_id' => $this->request->getPost('agama_id'),
        ]);

        return redirect()->to(base_url('admin/siswa'))->with('success', 'Data siswa berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->siswaModel->delete($id);
        return redirect()->to(base_url('admin/siswa'))->with('success', 'Data siswa berhasil dihapus');
    }

    public function cetak()
    {
        $filters = [
            'nisn' => $this->request->getGet('nis'),
            'nama' => $this->request->getGet('nama'),
            'kelas_id' => $this->request->getGet('kelas_id'),
            'jurusan_id' => $this->request->getGet('jurusan_id')
        ];
        $kelas = $this->kelasModel->findAll();
        $jurusan = $this->jurusanModel->findAll();
        $siswa = $this->siswaModel->getSiswaWithRelations($filters);
        return view('admin/siswa/cetak_siswa', [
            'title' => 'Cetak Data Siswa',
            'kelas' => $kelas,
            'jurusan' => $jurusan,
            'filters' => $filters,
            'siswa' => $siswa
        ]);
    }
} 
