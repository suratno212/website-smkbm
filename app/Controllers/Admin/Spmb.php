<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\SpmbModel;
use App\Models\JurusanModel;
use App\Models\UserModel;
class Spmb extends BaseController
{
    protected $spmbModel;
    protected $jurusanModel;
    public function __construct()
    {
        $this->spmbModel = new SpmbModel();
        $this->jurusanModel = new JurusanModel();
    }
    public function index()
    {
        $filters = [
            'nama' => $this->request->getGet('nama'),
            'no_pendaftaran' => $this->request->getGet('no_pendaftaran'),
            'status' => $this->request->getGet('status'),
            'jurusan' => $this->request->getGet('jurusan')
        ];
        $userModel = new UserModel();
        $user = $userModel->find(session()->get('user_id'));
        $data = [
            'title' => 'Data SPMB',
            'user' => $user,
            'spmb' => $this->spmbModel->getSpmbWithFilter($filters),
            'jurusan' => $this->jurusanModel->findAll(),
            'filters' => $filters,
            'statistik' => $this->spmbModel->getStatistik()
        ];
        return view('admin/spmb/index', $data);
    }
    public function show($id)
    {
        $data = [
            'title' => 'Detail Pendaftar SPMB',
            'user' => [
                'username' => session()->get('username'),
                'role' => session()->get('role')
            ],
            'pendaftar' => $this->spmbModel->find($id)
        ];
        return view('admin/spmb/show', $data);
    }
    public function updateStatus($id)
    {
        $status = $this->request->getPost('status_pendaftaran');
        $catatan = $this->request->getPost('catatan');
        $this->spmbModel->update($id, [
            'status_pendaftaran' => $status,
            'catatan' => $catatan
        ]);
        return redirect()->to(base_url('admin/spmb'))->with('success', 'Status pendaftaran berhasil diperbarui');
    }
    public function terima($id)
    {
        $this->spmbModel->update($id, [
            'status_pendaftaran' => 'Diterima',
            'catatan' => 'Pendaftar diterima sebagai siswa baru'
        ]);
        return redirect()->to(base_url('admin/spmb'))->with('success', 'Pendaftar berhasil diterima');
    }
    public function tolak($id)
    {
        $catatan = $this->request->getPost('catatan') ?? 'Pendaftar tidak memenuhi persyaratan';
        $this->spmbModel->update($id, [
            'status_pendaftaran' => 'Ditolak',
            'catatan' => $catatan
        ]);
        return redirect()->to(base_url('admin/spmb'))->with('success', 'Pendaftar ditolak');
    }
    public function bersyarat($id)
    {
        $catatan = $this->request->getPost('catatan') ?? 'Pendaftar diterima dengan syarat tertentu';
        $this->spmbModel->update($id, [
            'status_pendaftaran' => 'Diterima Bersyarat',
            'catatan' => $catatan
        ]);
        return redirect()->to(base_url('admin/spmb'))->with('success', 'Pendaftar diterima dengan syarat');
    }
    public function delete($id)
    {
        $this->spmbModel->delete($id);
        return redirect()->to(base_url('admin/spmb'))->with('success', 'Data pendaftar berhasil dihapus');
    }
    public function print()
    {
        $data = [
            'spmb' => $this->spmbModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('admin/spmb/print', $data);
    }
} 