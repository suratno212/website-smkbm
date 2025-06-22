<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AgamaModel;

class Agama extends BaseController
{
    protected $agamaModel;

    public function __construct()
    {
        $this->agamaModel = new AgamaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Agama',
            'agama' => $this->agamaModel->findAll(),
        ];
        return view('admin/master/agama/index', $data);
    }

    public function create()
    {
        return view('admin/master/agama/create', ['title' => 'Tambah Agama']);
    }

    public function store()
    {
        $namaAgama = $this->request->getPost('nama_agama');
        
        // Validasi sederhana
        if (empty($namaAgama)) {
            return redirect()->back()->withInput()->with('errors', ['nama_agama' => 'Nama agama tidak boleh kosong']);
        }
        
        // Cek apakah nama agama sudah ada
        $existingAgama = $this->agamaModel->where('nama_agama', $namaAgama)->first();
        
        if ($existingAgama) {
            return redirect()->back()->withInput()->with('errors', ['nama_agama' => 'Nama agama sudah ada']);
        }
        
        $result = $this->agamaModel->insert([
            'nama_agama' => $namaAgama,
        ]);
        
        if ($result) {
            return redirect()->to(base_url('admin/master/agama'))->with('success', 'Data agama berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('errors', ['nama_agama' => 'Gagal menambahkan data agama']);
        }
    }

    public function edit($id)
    {
        $agama = $this->agamaModel->find($id);
        if (!$agama) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data agama tidak ditemukan');
        }
        return view('admin/master/agama/edit', [
            'title' => 'Edit Agama',
            'agama' => $agama
        ]);
    }

    public function update($id)
    {
        // Ambil data yang akan diupdate
        $namaAgama = $this->request->getPost('nama_agama');
        
        // Validasi sederhana
        if (empty($namaAgama)) {
            return redirect()->back()->withInput()->with('errors', ['nama_agama' => 'Nama agama tidak boleh kosong']);
        }
        
        // Cek apakah nama agama sudah ada (kecuali yang sedang diedit)
        $existingAgama = $this->agamaModel->where('nama_agama', $namaAgama)
                                         ->where('id !=', $id)
                                         ->first();
        
        if ($existingAgama) {
            return redirect()->back()->withInput()->with('errors', ['nama_agama' => 'Nama agama sudah ada']);
        }
        
        // Update data
        $data = [
            'nama_agama' => $namaAgama,
        ];
        
        $result = $this->agamaModel->update($id, $data);
        
        if ($result) {
            return redirect()->to(base_url('admin/master/agama'))->with('success', 'Data agama berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('errors', ['nama_agama' => 'Gagal memperbarui data agama']);
        }
    }

    public function delete($id)
    {
        $this->agamaModel->delete($id);
        return redirect()->to(base_url('admin/master/agama'))->with('success', 'Data agama berhasil dihapus');
    }
} 