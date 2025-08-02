<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JurusanModel;

class Jurusan extends BaseController
{
    protected $jurusanModel;

    public function __construct()
    {
        $this->jurusanModel = new JurusanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Jurusan',
            'jurusan' => $this->jurusanModel->findAll()
        ];

        return view('admin/jurusan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Jurusan',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/jurusan/create', $data);
    }

    public function store()
    {
        // Validation rules
        $rules = [
            'kd_jurusan' => 'required|is_unique[jurusan.kd_jurusan]',
            'nama_jurusan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $jurusanData = [
            'kd_jurusan' => $this->request->getPost('kd_jurusan'),
            'nama_jurusan' => $this->request->getPost('nama_jurusan')
        ];

        $this->jurusanModel->insert($jurusanData);

        return redirect()->to('admin/jurusan')->with('success', 'Data jurusan berhasil ditambahkan');
    }

    public function edit($kdJurusan)
    {
        $data = [
            'title' => 'Edit Jurusan',
            'jurusan' => $this->jurusanModel->find($kdJurusan),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/jurusan/edit', $data);
    }

    public function update($kdJurusan)
    {
        // Validation rules
        $rules = [
            'kd_jurusan' => "required|is_unique[jurusan.kd_jurusan,kd_jurusan,$kdJurusan]",
            'nama_jurusan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->jurusanModel->update($kdJurusan, [
            'kd_jurusan' => $this->request->getPost('kd_jurusan'),
            'nama_jurusan' => $this->request->getPost('nama_jurusan')
        ]);

        return redirect()->to('admin/jurusan')->with('success', 'Data jurusan berhasil diperbarui');
    }

    public function delete($kdJurusan)
    {
        $this->jurusanModel->delete($kdJurusan);
        return redirect()->to('admin/jurusan')->with('success', 'Data jurusan berhasil dihapus');
    }
} 