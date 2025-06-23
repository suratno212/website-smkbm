<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Session\Session;

class Auth extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Debug: Log current session
        log_message('debug', 'Auth index called. Session: ' . json_encode(session()->get()));
        
        // Jika sudah login, redirect ke dashboard sesuai role
        if ($this->session->get('logged_in')) {
            $role = $this->session->get('role');
            log_message('debug', 'User already logged in with role: ' . $role);
            
            switch ($role) {
                case 'admin':
                    return redirect()->to(base_url('admin/dashboard'));
                case 'guru':
                    return redirect()->to(base_url('guru/dashboard'));
                case 'siswa':
                    return redirect()->to(base_url('siswa/dashboard'));
                case 'kepala_sekolah':
                    return redirect()->to(base_url('kepalasekolah'));
                default:
                    log_message('error', 'Invalid role in session: ' . $role);
                    $this->session->destroy();
                    return redirect()->to(base_url('auth'))->with('error', 'Role tidak valid');
            }
        }
        
        // Tampilkan halaman login
        return view('auth/login');
    }

    public function login()
    {
        // Validasi input
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Username dan password harus diisi');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('username', $username)->first();

        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Set session
                $sessionData = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'foto' => $user['foto'] ?? null,
                    'logged_in' => true
                ];
                $this->session->set($sessionData);

                // Tambahan: set guru_id jika role guru
                if ($user['role'] === 'guru') {
                    $guru = (new \App\Models\GuruModel())->where('user_id', $user['id'])->first();
                    if ($guru) {
                        $this->session->set('guru_id', $guru['id']);
                    }
                }

                // Debug: Log session data
                log_message('info', 'User logged in: ' . json_encode($sessionData));

                // Redirect ke dashboard sesuai role
                switch ($user['role']) {
                    case 'admin':
                        return redirect()->to(base_url('admin/dashboard'));
                    case 'guru':
                        return redirect()->to(base_url('guru/dashboard'));
                    case 'siswa':
                        return redirect()->to(base_url('siswa/dashboard'));
                    case 'kepala_sekolah':
                        return redirect()->to(base_url('kepalasekolah'));
                    default:
                        $this->session->destroy();
                        return redirect()->to(base_url('auth'))->with('error', 'Role tidak valid');
                }
            }
        }

        // Jika login gagal
        return redirect()->back()->withInput()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('auth'));
    }
} 