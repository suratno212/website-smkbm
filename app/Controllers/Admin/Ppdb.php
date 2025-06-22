<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PpdbModel;
use App\Models\JurusanModel;

class Ppdb extends BaseController
{
    protected $ppdbModel;
    protected $jurusanModel;

    public function __construct()
    {
        $this->ppdbModel = new PpdbModel();
        $this->jurusanModel = new JurusanModel();
    }

    public function index()
    {
        // Ambil parameter filter
        $filters = [
            'nama' => $this->request->getGet('nama'),
            'no_pendaftaran' => $this->request->getGet('no_pendaftaran'),
            'status' => $this->request->getGet('status'),
            'jurusan' => $this->request->getGet('jurusan')
        ];

        $data = [
            'title' => 'Data PPDB',
            'user' => [
                'username' => session()->get('username'),
                'role' => session()->get('role')
            ],
            'ppdb' => $this->ppdbModel->getPpdbWithFilter($filters),
            'jurusan' => $this->jurusanModel->findAll(),
            'filters' => $filters,
            'statistik' => $this->ppdbModel->getStatistik()
        ];
        
        return view('admin/ppdb/index', $data);
    }

    public function show($id)
    {
        $data = [
            'title' => 'Detail Pendaftar PPDB',
            'user' => [
                'username' => session()->get('username'),
                'role' => session()->get('role')
            ],
            'pendaftar' => $this->ppdbModel->find($id)
        ];
        
        return view('admin/ppdb/show', $data);
    }

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status_pendaftaran');
        $catatan = $this->request->getPost('catatan');

        $this->ppdbModel->update($id, [
            'status_pendaftaran' => $status,
            'catatan' => $catatan
        ]);

        return redirect()->to(base_url('admin/ppdb'))->with('success', 'Status pendaftaran berhasil diperbarui');
    }

    public function terima($id)
    {
        $this->ppdbModel->update($id, [
            'status_pendaftaran' => 'Diterima',
            'catatan' => 'Pendaftar diterima sebagai siswa baru'
        ]);

        return redirect()->to(base_url('admin/ppdb'))->with('success', 'Pendaftar berhasil diterima');
    }

    public function tolak($id)
    {
        $catatan = $this->request->getPost('catatan') ?? 'Pendaftar tidak memenuhi persyaratan';

        $this->ppdbModel->update($id, [
            'status_pendaftaran' => 'Ditolak',
            'catatan' => $catatan
        ]);

        return redirect()->to(base_url('admin/ppdb'))->with('success', 'Pendaftar ditolak');
    }

    public function bersyarat($id)
    {
        $catatan = $this->request->getPost('catatan') ?? 'Pendaftar diterima dengan syarat tertentu';

        $this->ppdbModel->update($id, [
            'status_pendaftaran' => 'Diterima Bersyarat',
            'catatan' => $catatan
        ]);

        return redirect()->to(base_url('admin/ppdb'))->with('success', 'Pendaftar diterima dengan syarat');
    }

    public function delete($id)
    {
        $this->ppdbModel->delete($id);
        return redirect()->to(base_url('admin/ppdb'))->with('success', 'Data pendaftar berhasil dihapus');
    }
}
