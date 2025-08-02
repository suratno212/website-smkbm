<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SoalSpmbModel;

class SpmbSoal extends BaseController
{
    protected $soalModel;
    public function __construct()
    {
        $this->soalModel = new SoalSpmbModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Bank Soal SPMB',
            'soal' => $this->soalModel->findAll()
        ];
        return view('admin/spmb/soal/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Soal SPMB',
        ];
        return view('admin/spmb/soal/create', $data);
    }

    public function store()
    {
        $rules = [
            'soal' => 'required',
            'pilihan_a' => 'required',
            'pilihan_b' => 'required',
            'pilihan_c' => 'required',
            'pilihan_d' => 'required',
            'jawaban_benar' => 'required|in_list[a,b,c,d]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $gambar = null;
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $gambar = $file->getRandomName();
            $file->move('public/uploads/spmb_soal', $gambar);
        }
        $insertData = [
            'soal' => $this->request->getPost('soal'),
            'gambar' => $gambar,
            'pilihan_a' => $this->request->getPost('pilihan_a'),
            'pilihan_b' => $this->request->getPost('pilihan_b'),
            'pilihan_c' => $this->request->getPost('pilihan_c'),
            'pilihan_d' => $this->request->getPost('pilihan_d'),
            'jawaban_benar' => $this->request->getPost('jawaban_benar'),
        ];
        $this->soalModel->insert($insertData);
        return redirect()->to('admin/spmbsoal')->with('success', 'Soal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $soal = $this->soalModel->find($id);
        if (!$soal) {
            return redirect()->to('admin/spmbsoal')->with('error', 'Soal tidak ditemukan');
        }
        $data = [
            'title' => 'Edit Soal SPMB',
            'soal' => $soal
        ];
        return view('admin/spmb/soal/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'soal' => 'required',
            'pilihan_a' => 'required',
            'pilihan_b' => 'required',
            'pilihan_c' => 'required',
            'pilihan_d' => 'required',
            'jawaban_benar' => 'required|in_list[a,b,c,d]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $soal = $this->soalModel->find($id);
        $gambar = $soal['gambar'] ?? null;
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $gambar = $file->getRandomName();
            $file->move('public/uploads/spmb_soal', $gambar);
        }
        $updateData = [
            'soal' => $this->request->getPost('soal'),
            'gambar' => $gambar,
            'pilihan_a' => $this->request->getPost('pilihan_a'),
            'pilihan_b' => $this->request->getPost('pilihan_b'),
            'pilihan_c' => $this->request->getPost('pilihan_c'),
            'pilihan_d' => $this->request->getPost('pilihan_d'),
            'jawaban_benar' => $this->request->getPost('jawaban_benar'),
        ];
        $this->soalModel->update($id, $updateData);
        return redirect()->to('admin/spmbsoal')->with('success', 'Soal berhasil diupdate');
    }

    public function delete($id)
    {
        $this->soalModel->delete($id);
        return redirect()->to('admin/spmbsoal')->with('success', 'Soal berhasil dihapus');
    }
} 
 
 
 
 
 