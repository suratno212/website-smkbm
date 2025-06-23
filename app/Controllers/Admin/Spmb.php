<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\SpmbModel;
use App\Models\JurusanModel;
use App\Models\UserModel;
use App\Models\SiswaModel;
use App\Models\KelasModel;
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
    public function jadikanSiswa($id)
    {
        log_message('debug', 'JadikanSiswa dipanggil untuk ID: ' . $id);
        $spmb = $this->spmbModel->find($id);
        log_message('debug', 'Cek SPMB: ' . json_encode($spmb));
        if (!$spmb || $spmb['status_pendaftaran'] != 'Diterima') {
            log_message('debug', 'SPMB tidak ditemukan atau status bukan Diterima');
            return redirect()->to(base_url('admin/spmb'))->with('error', 'Hanya pendaftar yang sudah diterima yang bisa dijadikan siswa.');
        }
        $userModel = new UserModel();
        $siswaModel = new SiswaModel();
        $kelasModel = new KelasModel();
        $existingUser = $userModel->where('username', $spmb['no_pendaftaran'])->first();
        log_message('debug', 'Cek existing user: ' . json_encode($existingUser));
        if ($existingUser) {
            log_message('debug', 'User sudah ada');
            return redirect()->to(base_url('admin/spmb'))->with('error', 'User sudah ada.');
        }
        $userId = $userModel->insert([
            'username' => $spmb['no_pendaftaran'],
            'password' => password_hash(date('Y-m-d', strtotime($spmb['tanggal_lahir'])), PASSWORD_DEFAULT),
            'email' => $spmb['email'],
            'role' => 'siswa',
        ], true);
        $jurusan = $this->jurusanModel->where('nama_jurusan', $spmb['jurusan_pilihan'])->first();
        log_message('debug', 'Cek jurusan: ' . json_encode($jurusan));
        if (!$jurusan) {
            log_message('debug', 'Jurusan tidak ditemukan');
            return redirect()->to(base_url('admin/spmb'))->with('error', 'Jurusan tidak ditemukan. Pastikan data jurusan sudah benar.');
        }
        $kelas = $kelasModel->where('jurusan_id', $jurusan['id'])->orderBy('id', 'ASC')->first();
        log_message('debug', 'Cek kelas: ' . json_encode($kelas));
        if (!$kelas) {
            log_message('debug', 'Kelas tidak ditemukan');
            return redirect()->to(base_url('admin/spmb'))->with('error', 'Tidak ada kelas untuk jurusan ini, silakan buat kelas terlebih dahulu.');
        }
        $siswaModel->insert([
            'user_id' => $userId,
            'nisn' => $spmb['nisn'],
            'nama' => $spmb['nama_lengkap'],
            'tanggal_lahir' => $spmb['tanggal_lahir'],
            'kelas_id' => $kelas['id'],
            'jurusan_id' => $jurusan['id'],
            'alamat' => $spmb['alamat'],
            'no_hp' => $spmb['no_hp'],
        ]);
        log_message('debug', 'Insert siswa berhasil');
        $this->spmbModel->update($id, ['status_pendaftaran' => 'Sudah Jadi Siswa']);
        log_message('debug', 'JadikanSiswa selesai untuk ID: ' . $id);
        return redirect()->to(base_url('admin/spmb'))->with('success', 'Pendaftar berhasil dijadikan siswa.');
    }
} 