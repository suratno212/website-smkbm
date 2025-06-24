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
        $pendaftar = $this->spmbModel
            ->select('spmb.*, agama.nama_agama, jurusan.nama_jurusan')
            ->join('agama', 'agama.id = spmb.agama_id', 'left')
            ->join('jurusan', 'jurusan.id = spmb.jurusan_id', 'left')
            ->where('spmb.id', $id)
            ->first();
        $data = [
            'title' => 'Detail Pendaftar SPMB',
            'user' => [
                'username' => session()->get('username'),
                'role' => session()->get('role')
            ],
            'pendaftar' => $pendaftar
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
        $jurusan = $this->request->getGet('jurusan');
        $jenis_kelamin = $this->request->getGet('jenis_kelamin');
        $agama = $this->request->getGet('agama');
        $status = $this->request->getGet('status');
        $tanggal_awal = $this->request->getGet('tanggal_awal');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $sort = $this->request->getGet('sort') ?? 'created_at';
        $order = $this->request->getGet('order') === 'ASC' ? 'ASC' : 'DESC';
        $allowedSort = [
            'created_at' => 'spmb.created_at',
            'no_pendaftaran' => 'spmb.no_pendaftaran',
            'kelas' => 'spmb.kelas_id',
            'jenis_kelamin' => 'spmb.jenis_kelamin',
            'agama' => 'spmb.agama_id',
            'status' => 'spmb.status_pendaftaran'
        ];
        $sortCol = $allowedSort[$sort] ?? 'spmb.created_at';
        $builder = $this->spmbModel
            ->select('spmb.*, agama.nama_agama, jurusan.nama_jurusan')
            ->join('agama', 'agama.id = spmb.agama_id', 'left')
            ->join('jurusan', 'jurusan.id = spmb.jurusan_id', 'left');
        if ($jurusan) {
            $builder->where('spmb.jurusan_id', $jurusan);
        }
        if ($jenis_kelamin) {
            $builder->where('spmb.jenis_kelamin', $jenis_kelamin);
        }
        if ($agama) {
            $builder->where('spmb.agama_id', $agama);
        }
        if ($status) {
            $builder->where('spmb.status_pendaftaran', $status);
        }
        if ($tanggal_awal && $tanggal_akhir) {
            $builder->where('spmb.created_at >=', $tanggal_awal . ' 00:00:00');
            $builder->where('spmb.created_at <=', $tanggal_akhir . ' 23:59:59');
        }
        $builder->orderBy($sortCol, $order);
        $data = [
            'spmb' => $builder->findAll(),
            'order' => $order,
            'sort' => $sort,
            'filter' => [
                'jurusan' => $jurusan,
                'jenis_kelamin' => $jenis_kelamin,
                'agama' => $agama,
                'status' => $status,
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir,
            ],
            'jurusan_list' => $this->jurusanModel->findAll(),
            'agama_list' => (new \App\Models\AgamaModel())->findAll(),
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
        $jurusan = $this->jurusanModel->where('id', $spmb['jurusan_id'])->first();
        log_message('debug', 'Cek jurusan: ' . json_encode($jurusan));
        if (!$jurusan) {
            log_message('debug', 'Jurusan tidak ditemukan');
            return redirect()->to(base_url('admin/spmb'))->with('error', 'Jurusan tidak ditemukan. Pastikan data jurusan sudah benar.');
        }
        // Cari kelas jurusan yang belum penuh kuota
        $kelasList = $kelasModel->where('jurusan_id', $jurusan['id'])->findAll();
        $kelasTerpilih = null;
        foreach ($kelasList as $k) {
            $jumlahSiswa = $siswaModel->where('kelas_id', $k['id'])->countAllResults();
            $kuota = isset($k['kuota']) ? (int)$k['kuota'] : 25;
            if ($jumlahSiswa < $kuota) {
                $kelasTerpilih = $k;
                break;
            }
        }
        if (!$kelasTerpilih) {
            return redirect()->to(base_url('admin/spmb'))->with('error', 'Semua kelas jurusan ini sudah penuh. Silakan tambah kelas baru.');
        }
        $siswaModel->insert([
            'user_id' => $userId,
            'nisn' => $spmb['nisn'],
            'nama' => $spmb['nama_lengkap'],
            'tanggal_lahir' => $spmb['tanggal_lahir'],
            'jenis_kelamin' => $spmb['jenis_kelamin'],
            'agama_id' => $spmb['agama_id'],
            'kelas_id' => $kelasTerpilih['id'],
            'jurusan_id' => $jurusan['id'],
            'alamat' => $spmb['alamat'],
            'no_hp' => $spmb['no_hp'],
        ]);
        log_message('debug', 'Insert siswa berhasil');
        $this->spmbModel->update($id, ['status_pendaftaran' => 'Sudah Jadi Siswa']);
        log_message('debug', 'JadikanSiswa selesai untuk ID: ' . $id);
        return redirect()->to(base_url('admin/spmb'))->with('success', 'Pendaftar berhasil dijadikan siswa.');
    }
    public function mass_delete()
    {
        $ids = $this->request->getPost('ids');
        if ($ids && is_array($ids)) {
            foreach ($ids as $id) {
                $this->spmbModel->delete($id);
            }
            return redirect()->to(base_url('admin/spmb'))->with('success', 'Data terpilih berhasil dihapus.');
        }
        return redirect()->to(base_url('admin/spmb'))->with('error', 'Tidak ada data yang dipilih.');
    }
    public function mass_jadikan_siswa()
    {
        $ids = $this->request->getPost('ids');
        $userModel = new \App\Models\UserModel();
        $siswaModel = new \App\Models\SiswaModel();
        $kelasModel = new \App\Models\KelasModel();
        $errors = [];
        $success = 0;
        if ($ids && is_array($ids)) {
            foreach ($ids as $id) {
                $spmb = $this->spmbModel->find($id);
                if (!$spmb || $spmb['status_pendaftaran'] != 'Diterima') {
                    $errors[] = 'ID ' . $id . ': Hanya pendaftar yang sudah diterima yang bisa dijadikan siswa.';
                    continue;
                }
                $existingUser = $userModel->where('username', $spmb['no_pendaftaran'])->first();
                if ($existingUser) {
                    $errors[] = 'ID ' . $id . ': User sudah ada.';
                    continue;
                }
                $userId = $userModel->insert([
                    'username' => $spmb['no_pendaftaran'],
                    'password' => password_hash(date('Y-m-d', strtotime($spmb['tanggal_lahir'])), PASSWORD_DEFAULT),
                    'email' => $spmb['email'],
                    'role' => 'siswa',
                ], true);
                $jurusanId = $spmb['jurusan_id'];
                // Cari kelas jurusan yang belum penuh kuota
                $kelasList = $kelasModel->where('jurusan_id', $jurusanId)->findAll();
                $kelasTerpilih = null;
                foreach ($kelasList as $k) {
                    $jumlahSiswa = $siswaModel->where('kelas_id', $k['id'])->countAllResults();
                    $kuota = isset($k['kuota']) ? (int)$k['kuota'] : 25;
                    if ($jumlahSiswa < $kuota) {
                        $kelasTerpilih = $k;
                        break;
                    }
                }
                if (!$kelasTerpilih) {
                    $errors[] = 'ID ' . $id . ': Semua kelas jurusan ini sudah penuh.';
                    continue;
                }
                $siswaModel->insert([
                    'user_id' => $userId,
                    'nisn' => $spmb['nisn'],
                    'nama' => $spmb['nama_lengkap'],
                    'tanggal_lahir' => $spmb['tanggal_lahir'],
                    'jenis_kelamin' => $spmb['jenis_kelamin'],
                    'agama_id' => $spmb['agama_id'],
                    'kelas_id' => $kelasTerpilih['id'],
                    'jurusan_id' => $jurusanId,
                    'alamat' => $spmb['alamat'],
                    'no_hp' => $spmb['no_hp'],
                ]);
                $this->spmbModel->update($id, ['status_pendaftaran' => 'Sudah Jadi Siswa']);
                $success++;
            }
            if ($success > 0) {
                session()->setFlashdata('success', $success.' pendaftar berhasil dijadikan siswa.');
            }
            if (!empty($errors)) {
                session()->setFlashdata('error', implode('<br>', $errors));
            }
        } else {
            session()->setFlashdata('error', 'Tidak ada data yang dipilih.');
        }
        return redirect()->to(base_url('admin/spmb'));
    }
} 