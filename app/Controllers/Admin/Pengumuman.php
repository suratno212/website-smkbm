<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengumumanModel;
use App\Models\UserModel;

class Pengumuman extends BaseController
{
    protected $pengumumanModel;
    protected $userModel;

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pengumuman',
            'pengumuman' => $this->pengumumanModel->findAll(),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/pengumuman/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengumuman',
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/pengumuman/create', $data);
    }

    public function store()
    {
        $rules = [
            'judul' => 'required|min_length[3]|max_length[255]',
            'jenis' => 'required|in_list[Umum,Jadwal Ujian,Kegiatan,Lainnya]',
            'status' => 'required|in_list[Aktif,Tidak Aktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file');
        $fileName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/pengumuman', $fileName);
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'jenis' => $this->request->getPost('jenis'),
            'file' => $fileName,
            'status' => $this->request->getPost('status')
        ];

        $this->pengumumanModel->insert($data);

        return redirect()->to('admin/pengumuman')->with('message', 'Pengumuman berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pengumuman',
            'pengumuman' => $this->pengumumanModel->find($id),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];

        if (!$data['pengumuman']) {
            return redirect()->to('admin/pengumuman')->with('error', 'Pengumuman tidak ditemukan');
        }

        return view('admin/pengumuman/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'judul' => 'required|min_length[3]|max_length[255]',
            'jenis' => 'required|in_list[Umum,Jadwal Ujian,Kegiatan,Lainnya]',
            'status' => 'required|in_list[Aktif,Tidak Aktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $pengumuman = $this->pengumumanModel->find($id);
        if (!$pengumuman) {
            return redirect()->to('admin/pengumuman')->with('error', 'Pengumuman tidak ditemukan');
        }

        $file = $this->request->getFile('file');
        $fileName = $pengumuman['file']; // Keep existing file if no new file uploaded

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Delete old file if exists
            if ($pengumuman['file'] && file_exists(ROOTPATH . 'public/uploads/pengumuman/' . $pengumuman['file'])) {
                unlink(ROOTPATH . 'public/uploads/pengumuman/' . $pengumuman['file']);
            }
            
            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/pengumuman', $fileName);
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'jenis' => $this->request->getPost('jenis'),
            'file' => $fileName,
            'status' => $this->request->getPost('status')
        ];

        $this->pengumumanModel->update($id, $data);

        return redirect()->to('admin/pengumuman')->with('message', 'Pengumuman berhasil diupdate');
    }

    public function delete($id)
    {
        $pengumuman = $this->pengumumanModel->find($id);
        if (!$pengumuman) {
            return redirect()->to('admin/pengumuman')->with('error', 'Pengumuman tidak ditemukan');
        }

        // Delete file if exists
        if ($pengumuman['file'] && file_exists(ROOTPATH . 'public/uploads/pengumuman/' . $pengumuman['file'])) {
            unlink(ROOTPATH . 'public/uploads/pengumuman/' . $pengumuman['file']);
        }

        $this->pengumumanModel->delete($id);

        return redirect()->to('admin/pengumuman')->with('message', 'Pengumuman berhasil dihapus');
    }

    public function download($id)
    {
        $pengumuman = $this->pengumumanModel->find($id);
        if (!$pengumuman || !$pengumuman['file']) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        $filePath = ROOTPATH . 'public/uploads/pengumuman/' . $pengumuman['file'];
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        return $this->response->download($filePath, $pengumuman['file']);
    }
} 