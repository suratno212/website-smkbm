<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PengaturanModel;

class Pengaturan extends BaseController
{
    protected $userModel;
    protected $pengaturanModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->pengaturanModel = new PengaturanModel();
    }

    public function index()
    {
        // Cek apakah user sudah login dan rolenya admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $data = [
            'title' => 'Pengaturan Umum',
            'user' => $this->userModel->find(session()->get('user_id')),
            'pengaturan' => $this->getPengaturanUmum()
        ];

        return view('admin/pengaturan/index', $data);
    }

    public function profil()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $data = [
            'title' => 'Profil Admin',
            'user' => $this->userModel->find(session()->get('user_id'))
        ];

        return view('admin/pengaturan/profil', $data);
    }

    public function updateProfil()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $user_id = session()->get('user_id');
        $user = $this->userModel->find($user_id);

        $rules = [
            'username' => 'required|min_length[3]',
            'email' => 'required|valid_email'
        ];

        // Jika password diisi, tambahkan validasi
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
            $rules['confirm_password'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'role' => $user['role']
        ];

        // Update password jika diisi
        if ($this->request->getPost('password')) {
            $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Handle upload foto
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Validasi ukuran dan tipe file
            $maxSize = 2 * 1024 * 1024; // 2MB
            $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png'];
            if ($foto->getSize() > $maxSize) {
                return redirect()->back()->withInput()->with('errors', ['Ukuran foto maksimal 2MB']);
            }
            if (!in_array($foto->getMimeType(), $allowedTypes)) {
                return redirect()->back()->withInput()->with('errors', ['Format foto harus JPG atau PNG']);
            }
            // Nama file sesuai username
            $username = $this->request->getPost('username');
            $ext = $foto->getClientExtension();
            $newName = $username . '.' . $ext;
            // Hapus foto lama jika ada dan nama berbeda
            if ($user['foto'] && $user['foto'] !== $newName && file_exists(ROOTPATH . 'public/uploads/profile/' . $user['foto'])) {
                unlink(ROOTPATH . 'public/uploads/profile/' . $user['foto']);
            }
            if (!$foto->move(ROOTPATH . 'public/uploads/profile', $newName, true)) {
                return redirect()->back()->withInput()->with('errors', ['Gagal mengupload foto.']);
            }
            $updateData['foto'] = $newName;
        } else if ($foto && $foto->getError() == 4) {
            // Tidak ada file yang diupload
            // Bisa tambahkan notifikasi jika ingin user tahu
            // return redirect()->back()->withInput()->with('errors', ['Tidak ada file foto yang diupload.']);
        }

        $result = $this->userModel->update($user_id, $updateData);

        // Ambil data user terbaru dan update session foto jika update berhasil
        if ($result) {
            $userBaru = $this->userModel->find($user_id);
            session()->set('foto', $userBaru['foto']);
            return redirect()->to('admin/pengaturan/profil')->with('message', 'Profil berhasil diperbarui');
        } else {
            // Debug: tampilkan isi updateData
            $debug = print_r($updateData, true);
            return redirect()->back()->withInput()->with('errors', ['Gagal update database. Data: ' . $debug]);
        }
    }

    public function pengaturanUmum()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $data = [
            'title' => 'Pengaturan Umum',
            'user' => $this->userModel->find(session()->get('user_id')),
            'pengaturan' => $this->getPengaturanUmum()
        ];

        return view('admin/pengaturan/umum', $data);
    }

    public function updatePengaturanUmum()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $pengaturan = [
            'nama_sekolah' => $this->request->getPost('nama_sekolah'),
            'alamat_sekolah' => $this->request->getPost('alamat_sekolah'),
            'telepon_sekolah' => $this->request->getPost('telepon_sekolah'),
            'email_sekolah' => $this->request->getPost('email_sekolah'),
            'website_sekolah' => $this->request->getPost('website_sekolah'),
            'kepala_sekolah' => $this->request->getPost('kepala_sekolah'),
            'nip_kepala_sekolah' => $this->request->getPost('nip_kepala_sekolah'),
            'tahun_akademik_aktif' => $this->request->getPost('tahun_akademik_aktif'),
            'semester_aktif' => $this->request->getPost('semester_aktif'),
            'logo_sekolah' => $this->request->getPost('logo_sekolah'),
            'favicon_sekolah' => $this->request->getPost('favicon_sekolah')
        ];

        // Handle upload logo
        $logo = $this->request->getFile('logo_file');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $newName = $logo->getRandomName();
            $logo->move(ROOTPATH . 'public/uploads/logo', $newName);
            $pengaturan['logo_sekolah'] = $newName;
        }

        // Handle upload favicon
        $favicon = $this->request->getFile('favicon_file');
        if ($favicon && $favicon->isValid() && !$favicon->hasMoved()) {
            $newName = $favicon->getRandomName();
            $favicon->move(ROOTPATH . 'public/uploads/favicon', $newName);
            $pengaturan['favicon_sekolah'] = $newName;
        }

        $this->updatePengaturan($pengaturan);

        return redirect()->to('admin/pengaturan/umum')->with('message', 'Pengaturan umum berhasil diperbarui');
    }

    public function backup()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $data = [
            'title' => 'Backup Database',
            'user' => $this->userModel->find(session()->get('user_id'))
        ];

        return view('admin/pengaturan/backup', $data);
    }

    public function createBackup()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $backupPath = ROOTPATH . 'backups/';
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0777, true);
        }

        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = $backupPath . $filename;

        // Get database configuration
        $db = \Config\Database::connect();
        $hostname = $db->hostname;
        $username = $db->username;
        $password = $db->password;
        $database = $db->database;

        // Create backup command
        $command = "mysqldump -h $hostname -u $username";
        if ($password) {
            $command .= " -p$password";
        }
        $command .= " $database > $filepath";

        // Execute backup
        exec($command, $output, $return_var);

        if ($return_var === 0) {
            return redirect()->to('admin/pengaturan/backup')->with('message', 'Backup database berhasil dibuat: ' . $filename);
        } else {
            return redirect()->to('admin/pengaturan/backup')->with('error', 'Gagal membuat backup database');
        }
    }

    public function downloadBackup($filename)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $filepath = ROOTPATH . 'backups/' . $filename;
        
        if (file_exists($filepath)) {
            return $this->response->download($filepath, $filename);
        } else {
            return redirect()->to('admin/pengaturan/backup')->with('error', 'File backup tidak ditemukan');
        }
    }

    public function deleteBackup($filename)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $filepath = ROOTPATH . 'backups/' . $filename;
        
        if (file_exists($filepath)) {
            unlink($filepath);
            return redirect()->to('admin/pengaturan/backup')->with('message', 'File backup berhasil dihapus');
        } else {
            return redirect()->to('admin/pengaturan/backup')->with('error', 'File backup tidak ditemukan');
        }
    }

    public function logs()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $logPath = WRITEPATH . 'logs/';
        $logs = [];

        if (is_dir($logPath)) {
            $files = scandir($logPath);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'log') {
                    $logs[] = [
                        'filename' => $file,
                        'size' => filesize($logPath . $file),
                        'modified' => date('Y-m-d H:i:s', filemtime($logPath . $file))
                    ];
                }
            }
        }

        $data = [
            'title' => 'Log Sistem',
            'user' => $this->userModel->find(session()->get('user_id')),
            'logs' => $logs
        ];

        return view('admin/pengaturan/logs', $data);
    }

    public function viewLog($filename)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $logPath = WRITEPATH . 'logs/' . $filename;
        
        if (file_exists($logPath)) {
            $content = file_get_contents($logPath);
            $data = [
                'title' => 'View Log: ' . $filename,
                'user' => $this->userModel->find(session()->get('user_id')),
                'filename' => $filename,
                'content' => $content
            ];
            return view('admin/pengaturan/view_log', $data);
        } else {
            return redirect()->to('admin/pengaturan/logs')->with('error', 'File log tidak ditemukan');
        }
    }

    public function clearLog($filename)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $logPath = WRITEPATH . 'logs/' . $filename;
        
        if (file_exists($logPath)) {
            file_put_contents($logPath, '');
            return redirect()->to('admin/pengaturan/logs')->with('message', 'Log berhasil dibersihkan');
        } else {
            return redirect()->to('admin/pengaturan/logs')->with('error', 'File log tidak ditemukan');
        }
    }

    private function getPengaturanUmum()
    {
        // Get settings from database
        $settings = $this->pengaturanModel->getAllSettings();
        
        // Return default settings if empty
        if (empty($settings)) {
            $settings = [
                'nama_sekolah' => 'SMK Bhakti Mulya BNS',
                'alamat_sekolah' => 'Jl. Contoh No. 123, Jakarta',
                'telepon_sekolah' => '(021) 1234567',
                'email_sekolah' => 'info@smkbm.sch.id',
                'website_sekolah' => 'https://smkbm.sch.id',
                'kepala_sekolah' => 'Drs. Kepala Sekolah',
                'nip_kepala_sekolah' => '196001011990031001',
                'tahun_akademik_aktif' => '2024/2025',
                'semester_aktif' => 'Ganjil',
                'logo_sekolah' => '',
                'favicon_sekolah' => ''
            ];
        }

        return $settings;
    }

    private function updatePengaturan($pengaturan)
    {
        // Update settings in database
        foreach ($pengaturan as $key => $value) {
            $this->pengaturanModel->setSetting($key, $value);
        }
        
        return true;
    }
}
