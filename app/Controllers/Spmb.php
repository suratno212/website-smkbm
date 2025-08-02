<?php

namespace App\Controllers;

use App\Models\SpmbModel;
use App\Models\AgamaModel;
use App\Models\JurusanModel;
use App\Models\UserModel;

class Spmb extends BaseController
{
    protected $spmbModel;
    protected $agamaModel;
    protected $jurusanModel;
    public function __construct()
    {
        $this->spmbModel = new SpmbModel();
        $this->agamaModel = new AgamaModel();
        $this->jurusanModel = new JurusanModel();
    }
    public function index()
    {
        return view('spmb/index');
    }
    public function daftar()
    {
        $data['agama'] = $this->agamaModel->findAll();
        $data['jurusan'] = $this->jurusanModel->findAll();
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|valid_date',
            'agama_id' => 'required|is_natural_no_zero',
            'alamat' => 'required',
            'asal_sekolah' => 'required',
            'nama_ortu' => 'required',
            'no_hp_ortu' => 'required|numeric',
            'email' => 'required|valid_email',
            'no_hp' => 'required|numeric',
            'kd_jurusan' => 'required', // ganti dari jurusan_id
            'nis' => 'required|is_unique[spmb.nis]',
        ];
        if ($this->request->getMethod() === 'post') {
            log_message('debug', '=== SPMB FORM SUBMISSION START ===');
            log_message('debug', 'POST DATA: ' . json_encode($this->request->getPost()));
            log_message('debug', 'Request method: ' . $this->request->getMethod());
            log_message('debug', 'Request URI: ' . $this->request->getUri());

            // Check CSRF token
            $csrfToken = $this->request->getPost('csrf_test_name');
            log_message('debug', 'CSRF Token: ' . ($csrfToken ? 'Present' : 'Missing'));

            if (!$this->validate($rules)) {
                log_message('debug', 'VALIDASI GAGAL: ' . json_encode($this->validator->getErrors()));
                $data['errors'] = $this->validator->getErrors();
                log_message('debug', 'Returning form with errors');
                return view('spmb/daftar', $data);
            }

            log_message('debug', 'Validation passed successfully');
            $noPendaftaran = $this->spmbModel->generateNoPendaftaran();
            $insertData = [
                'no_pendaftaran' => $noPendaftaran,
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'tempat_lahir' => $this->request->getPost('tempat_lahir'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'agama_id' => $this->request->getPost('agama_id'),
                'alamat' => $this->request->getPost('alamat'),
                'asal_sekolah' => $this->request->getPost('asal_sekolah'),
                'nama_ortu' => $this->request->getPost('nama_ortu'),
                'no_hp_ortu' => $this->request->getPost('no_hp_ortu'),
                'email' => $this->request->getPost('email'),
                'no_hp' => $this->request->getPost('no_hp'),
                'jurusan_pilihan' => $this->request->getPost('kd_jurusan'), // ganti dari jurusan_id
                'nis' => $this->request->getPost('nis'),
                'status_pendaftaran' => 'Menunggu'
            ];
            log_message('debug', 'DATA SPMB: ' . json_encode($insertData));

            try {
                $insertResult = $this->spmbModel->insert($insertData);
                log_message('debug', 'INSERT RESULT: ' . ($insertResult ? 'Success' : 'Failed'));
                log_message('debug', 'INSERT ID: ' . $this->spmbModel->getInsertID());

                if (!$insertResult) {
                    log_message('error', 'Database insertion failed');
                    $data['errors'] = ['database' => 'Gagal menyimpan data. Silakan coba lagi.'];
                    return view('spmb/daftar', $data);
                }
            } catch (\Exception $e) {
                log_message('error', 'Database error: ' . $e->getMessage());
                $data['errors'] = ['database' => 'Terjadi kesalahan sistem. Silakan coba lagi.'];
                return view('spmb/daftar', $data);
            }
            // Buat user calon_siswa
            log_message('debug', 'Creating user account...');
            $userModel = new UserModel();
            $userData = [
                'username' => $this->request->getPost('email'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('tanggal_lahir'), PASSWORD_DEFAULT),
                'role' => 'calon_siswa',
                'nama' => $this->request->getPost('nama_lengkap')
            ];

            try {
                if (!$userModel->where('email', $userData['email'])->first()) {
                    $userInsertResult = $userModel->insert($userData);
                    log_message('debug', 'User creation result: ' . ($userInsertResult ? 'Success' : 'Failed'));
                } else {
                    log_message('debug', 'User already exists, skipping creation');
                }
            } catch (\Exception $e) {
                log_message('error', 'User creation error: ' . $e->getMessage());
            }

            session()->set('no_pendaftaran', $noPendaftaran);
            log_message('debug', 'Session set with no_pendaftaran: ' . $noPendaftaran);
            log_message('debug', 'Redirecting to success page...');
            log_message('debug', '=== SPMB FORM SUBMISSION END ===');

            return redirect()->to(base_url('spmb/sukses'));
        }
        // GET: tampilkan form
        return view('spmb/daftar', $data);
    }
    public function sukses()
    {
        $noPendaftaran = session()->get('no_pendaftaran');
        if (!$noPendaftaran) {
            return redirect()->to(base_url('spmb'));
        }
        return view('spmb/sukses', ['no_pendaftaran' => $noPendaftaran]);
    }
    public function cekStatus()
    {
        return view('spmb/cek_status');
    }
    public function cekStatusPost()
    {
        $noPendaftaran = $this->request->getPost('no_pendaftaran');
        $email = $this->request->getPost('email');
        $pendaftar = $this->spmbModel->where('no_pendaftaran', $noPendaftaran)
            ->where('email', $email)
            ->first();
        if ($pendaftar) {
            return view('spmb/status', ['pendaftar' => $pendaftar]);
        } else {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan');
        }
    }
    public function daftarForm()
    {
        $data['agama'] = $this->agamaModel->findAll();
        $data['jurusan'] = $this->jurusanModel->findAll();
        return view('spmb/daftar', $data);
    }
}
