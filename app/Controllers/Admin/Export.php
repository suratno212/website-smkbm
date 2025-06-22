<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ExportLibrary;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\JadwalModel;
use App\Models\AbsensiModel;
use App\Models\NilaiModel;
use App\Models\UserModel;

class Export extends BaseController
{
    protected $exportLibrary;
    protected $siswaModel;
    protected $guruModel;
    protected $jadwalModel;
    protected $absensiModel;
    protected $nilaiModel;
    protected $userModel;

    public function __construct()
    {
        $this->exportLibrary = new ExportLibrary();
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
        $this->jadwalModel = new JadwalModel();
        $this->absensiModel = new AbsensiModel();
        $this->nilaiModel = new NilaiModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Cek apakah user sudah login dan rolenya admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $data = [
            'title' => 'Export Data',
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        
        return view('admin/export/index', $data);
    }

    // Export Data Siswa
    public function siswa($format = 'excel')
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $data = $this->siswaModel->select('
            siswa.nisn,
            siswa.nama,
            siswa.tanggal_lahir,
            kelas.nama_kelas,
            jurusan.nama_jurusan,
            siswa.alamat,
            siswa.no_hp
        ')
        ->join('kelas', 'kelas.id = siswa.kelas_id')
        ->join('jurusan', 'jurusan.id = siswa.jurusan_id')
        ->findAll();

        $filename = 'data_siswa_' . date('Y-m-d_H-i-s');
        
        if ($format === 'pdf') {
            $filename .= '.pdf';
            return $this->exportLibrary->exportPDF($data, [
                'NISN',
                'Nama',
                'Tanggal Lahir',
                'Kelas',
                'Jurusan',
                'Alamat',
                'No. HP'
            ], 'DATA SISWA SMK BHAKTI MULYA BNS', $filename, [
                'subtitle' => 'Tahun Ajaran ' . date('Y') . '/' . (date('Y') + 1)
            ]);
        } else {
            $filename .= '.xlsx';
            return $this->exportLibrary->exportSiswa($data, $filename);
        }
    }

    // Export Data Guru
    public function guru($format = 'excel')
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $data = $this->guruModel->select('
            guru.nama,
            guru.tanggal_lahir,
            mapel.nama_mapel,
            guru.alamat,
            guru.no_hp
        ')
        ->join('mapel', 'mapel.id = guru.mapel_id')
        ->findAll();

        $filename = 'data_guru_' . date('Y-m-d_H-i-s');
        
        if ($format === 'pdf') {
            $filename .= '.pdf';
            return $this->exportLibrary->exportPDF($data, [
                'Nama',
                'Tanggal Lahir',
                'Mata Pelajaran',
                'Alamat',
                'No. HP'
            ], 'DATA GURU SMK BHAKTI MULYA BNS', $filename, [
                'subtitle' => 'Tahun Ajaran ' . date('Y') . '/' . (date('Y') + 1)
            ]);
        } else {
            $filename .= '.xlsx';
            return $this->exportLibrary->exportGuru($data, $filename);
        }
    }

    // Export Jadwal Pelajaran
    public function jadwal($format = 'excel')
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $data = $this->jadwalModel->select('
            jadwal.hari,
            CONCAT(jadwal.jam_mulai, " - ", jadwal.jam_selesai) as jam,
            kelas.nama_kelas,
            mapel.nama_mapel,
            guru.nama as nama_guru
        ')
        ->join('kelas', 'kelas.id = jadwal.kelas_id')
        ->join('mapel', 'mapel.id = jadwal.mapel_id')
        ->join('guru', 'guru.id = jadwal.guru_id')
        ->orderBy('jadwal.hari', 'ASC')
        ->orderBy('jadwal.jam_mulai', 'ASC')
        ->findAll();

        $filename = 'jadwal_pelajaran_' . date('Y-m-d_H-i-s');
        
        if ($format === 'pdf') {
            $filename .= '.pdf';
            return $this->exportLibrary->exportPDF($data, [
                'Hari',
                'Jam',
                'Kelas',
                'Mata Pelajaran',
                'Guru'
            ], 'JADWAL PELAJARAN SMK BHAKTI MULYA BNS', $filename, [
                'subtitle' => 'Tahun Ajaran ' . date('Y') . '/' . (date('Y') + 1)
            ]);
        } else {
            $filename .= '.xlsx';
            return $this->exportLibrary->exportJadwal($data, $filename);
        }
    }

    // Export Absensi
    public function absensi($format = 'excel', $tanggal = null)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $tanggal = $tanggal ?: date('Y-m-d');
        
        $data = $this->absensiModel->select('
            siswa.nisn,
            siswa.nama,
            kelas.nama_kelas,
            absensi.tanggal,
            absensi.status
        ')
        ->join('siswa', 'siswa.id = absensi.siswa_id')
        ->join('kelas', 'kelas.id = siswa.kelas_id')
        ->where('absensi.tanggal', $tanggal)
        ->findAll();

        $filename = 'rekap_absensi_' . $tanggal . '_' . date('H-i-s');
        
        if ($format === 'pdf') {
            $filename .= '.pdf';
            return $this->exportLibrary->exportPDF($data, [
                'NISN',
                'Nama',
                'Kelas',
                'Tanggal',
                'Status'
            ], 'REKAP ABSENSI SISWA SMK BHAKTI MULYA BNS', $filename, [
                'subtitle' => 'Tahun Ajaran ' . date('Y') . '/' . (date('Y') + 1)
            ]);
        } else {
            $filename .= '.xlsx';
            return $this->exportLibrary->exportAbsensi($data, $filename);
        }
    }

    // Export Nilai
    public function nilai($format = 'excel', $kelas_id = null)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        $query = $this->nilaiModel->select('
            siswa.nisn,
            siswa.nama,
            kelas.nama_kelas,
            mapel.nama_mapel,
            nilai.uts,
            nilai.uas,
            nilai.tugas,
            nilai.akhir
        ')
        ->join('siswa', 'siswa.id = nilai.siswa_id')
        ->join('kelas', 'kelas.id = siswa.kelas_id')
        ->join('mapel', 'mapel.id = nilai.mapel_id');

        if ($kelas_id) {
            $query->where('siswa.kelas_id', $kelas_id);
        }

        $data = $query->findAll();

        $filename = 'data_nilai_' . ($kelas_id ? 'kelas_' . $kelas_id . '_' : '') . date('Y-m-d_H-i-s');
        
        if ($format === 'pdf') {
            $filename .= '.pdf';
            return $this->exportLibrary->exportPDF($data, [
                'NISN',
                'Nama',
                'Kelas',
                'Mata Pelajaran',
                'UTS',
                'UAS',
                'Tugas',
                'Akhir'
            ], 'DATA NILAI SISWA SMK BHAKTI MULYA BNS', $filename, [
                'subtitle' => 'Tahun Ajaran ' . date('Y') . '/' . (date('Y') + 1)
            ]);
        } else {
            $filename .= '.xlsx';
            return $this->exportLibrary->exportNilai($data, $filename);
        }
    }

    // Export Semua Data
    public function all($format = 'excel')
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('auth'));
        }

        // Create ZIP file with all exports
        $zip = new \ZipArchive();
        $zipName = 'export_semua_data_' . date('Y-m-d_H-i-s') . '.zip';
        $zipPath = WRITEPATH . 'uploads/' . $zipName;

        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            // Export Siswa
            $siswaData = $this->siswaModel->select('
                siswa.nisn,
                siswa.nama,
                siswa.tanggal_lahir,
                kelas.nama_kelas,
                jurusan.nama_jurusan,
                siswa.alamat,
                siswa.no_hp
            ')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->join('jurusan', 'jurusan.id = siswa.jurusan_id')
            ->findAll();

            $siswaFile = WRITEPATH . 'uploads/data_siswa.xlsx';
            $this->exportLibrary->exportSiswa($siswaData, $siswaFile);
            $zip->addFile($siswaFile, 'data_siswa.xlsx');

            // Export Guru
            $guruData = $this->guruModel->select('
                guru.nama,
                guru.tanggal_lahir,
                mapel.nama_mapel,
                guru.alamat,
                guru.no_hp
            ')
            ->join('mapel', 'mapel.id = guru.mapel_id')
            ->findAll();

            $guruFile = WRITEPATH . 'uploads/data_guru.xlsx';
            $this->exportLibrary->exportGuru($guruData, $guruFile);
            $zip->addFile($guruFile, 'data_guru.xlsx');

            // Export Jadwal
            $jadwalData = $this->jadwalModel->select('
                jadwal.hari,
                CONCAT(jadwal.jam_mulai, " - ", jadwal.jam_selesai) as jam,
                kelas.nama_kelas,
                mapel.nama_mapel,
                guru.nama as nama_guru
            ')
            ->join('kelas', 'kelas.id = jadwal.kelas_id')
            ->join('mapel', 'mapel.id = jadwal.mapel_id')
            ->join('guru', 'guru.id = jadwal.guru_id')
            ->orderBy('jadwal.hari', 'ASC')
            ->orderBy('jadwal.jam_mulai', 'ASC')
            ->findAll();

            $jadwalFile = WRITEPATH . 'uploads/jadwal_pelajaran.xlsx';
            $this->exportLibrary->exportJadwal($jadwalData, $jadwalFile);
            $zip->addFile($jadwalFile, 'jadwal_pelajaran.xlsx');

            $zip->close();

            // Download ZIP file
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipName . '"');
            header('Content-Length: ' . filesize($zipPath));
            readfile($zipPath);

            // Clean up temporary files
            unlink($zipPath);
            unlink($siswaFile);
            unlink($guruFile);
            unlink($jadwalFile);

            exit;
        }

        return redirect()->back()->with('error', 'Gagal membuat file ZIP');
    }
} 