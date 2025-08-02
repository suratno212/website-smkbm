<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CalonSiswaModel;
use App\Models\SiswaModel;
use App\Models\UserModel;
use App\Models\JurusanModel;
use App\Models\KelasModel;
use App\Models\AgamaModel;

class CalonSiswa extends BaseController
{
    protected $calonSiswaModel;
    protected $siswaModel;
    protected $userModel;
    protected $jurusanModel;
    protected $kelasModel;
    protected $agamaModel;

    public function __construct()
    {
        $this->calonSiswaModel = new CalonSiswaModel();
        $this->siswaModel = new SiswaModel();
        $this->userModel = new UserModel();
        $this->jurusanModel = new JurusanModel();
        $this->kelasModel = new KelasModel();
        $this->agamaModel = new AgamaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Calon Siswa',
            'calon_siswa' => $this->calonSiswaModel->getWithUser()
        ];

        return view('admin/calon_siswa/index', $data);
    }

    public function detail($id)
    {
        $calonSiswa = $this->calonSiswaModel->getWithUser($id);
        
        if (!$calonSiswa) {
            return redirect()->to('admin/calon-siswa')->with('error', 'Data calon siswa tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Calon Siswa',
            'calon_siswa' => $calonSiswa,
            'jurusan' => $this->jurusanModel->findAll(),
            'kelas' => $this->kelasModel->findAll(),
            'agama' => $this->agamaModel->findAll()
        ];

        return view('admin/calon_siswa/detail', $data);
    }

    public function terima($id)
    {
        $calonSiswa = $this->calonSiswaModel->find($id);
        
        if (!$calonSiswa) {
            return redirect()->to('admin/calon-siswa')->with('error', 'Data calon siswa tidak ditemukan');
        }

        // Update status pendaftaran menjadi diterima
        $this->calonSiswaModel->update($id, [
            'status_pendaftaran' => 'diterima'
        ]);

        return redirect()->to('admin/calon-siswa')->with('success', 'Calon siswa berhasil diterima');
    }

    public function tolak($id)
    {
        $calonSiswa = $this->calonSiswaModel->find($id);
        
        if (!$calonSiswa) {
            return redirect()->to('admin/calon-siswa')->with('error', 'Data calon siswa tidak ditemukan');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Update status pendaftaran menjadi ditolak
            $this->calonSiswaModel->update($id, [
                'status_pendaftaran' => 'ditolak'
            ]);

            // Hapus user account jika ditolak
            $this->userModel->delete($calonSiswa['user_id']);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Gagal menolak calon siswa');
            }

            return redirect()->to('admin/calon-siswa')->with('success', 'Calon siswa berhasil ditolak dan user account dihapus');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function konversiKeSiswa($id)
    {
        $calonSiswa = $this->calonSiswaModel->find($id);
        
        if (!$calonSiswa) {
            return redirect()->to('admin/calon-siswa')->with('error', 'Data calon siswa tidak ditemukan');
        }

        // Validasi input
        $rules = [
            'nis' => 'required|min_length[10]|max_length[10]|is_unique[siswa.nis]',
            'kd_kelas' => 'required',
            'kd_jurusan' => 'required',
            'agama_id' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // 1. Update role user dari calon_siswa menjadi siswa
            $this->userModel->update($calonSiswa['user_id'], [
                'role' => 'siswa'
            ]);

            // 2. Buat data siswa baru
            $siswaData = [
                'user_id' => $calonSiswa['user_id'],
                'nis' => $this->request->getPost('nis'),
                'nama' => $calonSiswa['nama'],
                'tanggal_lahir' => $calonSiswa['tanggal_lahir'],
                'jenis_kelamin' => $calonSiswa['jenis_kelamin'],
                'agama_id' => $this->request->getPost('agama_id'),
                'kd_kelas' => $this->request->getPost('kd_kelas'),
                'kd_jurusan' => $this->request->getPost('kd_jurusan'),
                'alamat' => $calonSiswa['alamat'],
                'no_hp' => $calonSiswa['no_hp']
            ];

            $siswaId = $this->siswaModel->insert($siswaData);

            // 3. Update status calon siswa menjadi sudah dikonversi
            $this->calonSiswaModel->update($id, [
                'status_pendaftaran' => 'diterima'
            ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Gagal mengkonversi calon siswa menjadi siswa');
            }

            return redirect()->to('admin/calon-siswa')->with('success', 'Calon siswa berhasil dikonversi menjadi siswa aktif');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function hapus($id)
    {
        $calonSiswa = $this->calonSiswaModel->find($id);
        
        if (!$calonSiswa) {
            return redirect()->to('admin/calon-siswa')->with('error', 'Data calon siswa tidak ditemukan');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Hapus user jika tidak ada data lain yang terkait
            $this->userModel->delete($calonSiswa['user_id']);
            
            // Hapus data calon siswa
            $this->calonSiswaModel->delete($id);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Gagal menghapus data calon siswa');
            }

            return redirect()->to('admin/calon-siswa')->with('success', 'Data calon siswa berhasil dihapus');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function export()
    {
        $calonSiswa = $this->calonSiswaModel->getWithUser();
        
        $filename = 'calon_siswa_' . date('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Header CSV
        fputcsv($output, [
            'No', 'Nama', 'Email', 'Tanggal Lahir', 'Jenis Kelamin', 
            'Alamat', 'No HP', 'Asal Sekolah', 'Jurusan Pilihan', 
            'Status Pendaftaran', 'Status Tes', 'Nilai Tes'
        ]);
        
        $no = 1;
        foreach ($calonSiswa as $row) {
            fputcsv($output, [
                $no++,
                $row['nama'],
                $row['email'],
                $row['tanggal_lahir'],
                $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan',
                $row['alamat'],
                $row['no_hp'],
                $row['asal_sekolah'],
                $row['jurusan_pilihan'],
                ucfirst($row['status_pendaftaran']),
                ucfirst(str_replace('_', ' ', $row['status_tes'])),
                $row['nilai_tes'] ?? '-'
            ]);
        }
        
        fclose($output);
        exit;
    }
} 
 
 