<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\NilaiModel;
use App\Models\SiswaModel;
use App\Models\MapelModel;
use App\Models\KelasModel;
use App\Models\GuruModel;
use App\Models\JadwalModel;
use App\Models\TahunAkademikModel;

class Nilai extends BaseController
{
    protected $nilaiModel;
    protected $siswaModel;
    protected $mapelModel;
    protected $kelasModel;
    protected $guruModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->nilaiModel = new NilaiModel();
        $this->siswaModel = new SiswaModel();
        $this->mapelModel = new MapelModel();
        $this->kelasModel = new KelasModel();
        $this->guruModel = new GuruModel();
        $this->jadwalModel = new JadwalModel();
    }

    public function index()
    {
        $guruId = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $guruId)->first();
        if (!$guru) {
            return redirect()->to(base_url('guru/dashboard'))->with('error', 'Data guru tidak ditemukan. Pastikan data guru sudah terdaftar dan user_id sesuai.');
        }
        $kelasList = $this->jadwalModel
            ->select('kelas.*, jurusan.nama_jurusan')
            ->join('kelas', 'kelas.id = jadwal.kelas_id')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->where('jadwal.guru_id', $guru['id'])
            ->groupBy('kelas.id')
            ->findAll();
        $data = [
            'title' => 'Kelola Nilai',
            'guru' => $guru,
            'kelasList' => $kelasList,
            'mapelList' => $this->mapelModel->findAll(),
            'user' => session()->get('user')
        ];
        return view('guru/nilai/index', $data);
    }

    public function input()
    {
        $kelasId = $this->request->getGet('kelas_id');
        $mapelId = $this->request->getGet('mapel_id');
        $semester = $this->request->getGet('semester') ?? 'Ganjil';

        if (!$kelasId || !$mapelId) {
            return redirect()->to('guru/nilai')->with('error', 'Pilih kelas dan mata pelajaran terlebih dahulu');
        }

        $guruId = session()->get('user_id');
        
        // Get students in the selected class
        $siswaList = $this->siswaModel->select('siswa.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->where('siswa.kelas_id', $kelasId)
            ->findAll();

        // Ambil tahun akademik aktif
        $tahunAkademikModel = new TahunAkademikModel();
        $tahunAkademikAktif = $tahunAkademikModel->where('status', 'Aktif')->first();
        $tahun_akademik_id = $tahunAkademikAktif ? $tahunAkademikAktif['id'] : null;

        // DEBUG: log ke file jika tahun_akademik_id null atau tidak
        if (!$tahun_akademik_id) {
            log_message('error', 'DEBUG NILAI: tahun_akademik_id NULL di input nilai!');
        } else {
            log_message('info', 'DEBUG NILAI: tahun_akademik_id=' . $tahun_akademik_id . ' di input nilai!');
        }

        // Get existing grades
        $nilaiList = $this->nilaiModel->where([
            'mapel_id' => $mapelId,
            'semester' => $semester,
            'tahun_akademik_id' => $tahun_akademik_id
        ])->findAll();

        // Create a map of existing grades
        $nilaiMap = [];
        foreach ($nilaiList as $nilai) {
            $nilaiMap[$nilai['siswa_id']] = $nilai;
        }

        $data = [
            'title' => 'Input Nilai',
            'kelasId' => $kelasId,
            'mapelId' => $mapelId,
            'semester' => $semester,
            'siswaList' => $siswaList,
            'nilaiMap' => $nilaiMap,
            'mapel' => $this->mapelModel->find($mapelId),
            'kelas' => $this->kelasModel->find($kelasId),
            'user' => session()->get('user'),
            'tahun_akademik_id' => $tahun_akademik_id
        ];

        return view('guru/nilai/input', $data);
    }

    public function store()
    {
        $kelasId = $this->request->getPost('kelas_id');
        $mapelId = $this->request->getPost('mapel_id');
        $semester = $this->request->getPost('semester') ?? 'Ganjil';
        $tahunAkademikId = $this->request->getPost('tahun_akademik_id');
        $siswaIds = $this->request->getPost('siswa_id');
        $utsScores = $this->request->getPost('uts');
        $uasScores = $this->request->getPost('uas');
        $tugasScores = $this->request->getPost('tugas');

        // DEBUG: log nilai tahun_akademik_id dari POST
        if (!$tahunAkademikId) {
            log_message('error', 'POST NILAI: tahun_akademik_id NULL di store!');
            return redirect()->to("guru/nilai/input?kelas_id={$kelasId}&mapel_id={$mapelId}&semester={$semester}")->with('error', 'Gagal menyimpan nilai: Tahun akademik aktif tidak ditemukan. Silakan reload halaman dan pastikan tahun akademik aktif sudah diatur.');
        } else {
            log_message('info', 'POST NILAI: tahun_akademik_id=' . $tahunAkademikId . ' di store!');
        }

        $successCount = 0;
        $errorCount = 0;

        foreach ($siswaIds as $index => $siswaId) {
            if ($siswaId) {
                $uts = $utsScores[$index] ?? 0;
                $uas = $uasScores[$index] ?? 0;
                $tugas = $tugasScores[$index] ?? 0;

                // Calculate final score (30% UTS + 40% UAS + 30% Tugas)
                $akhir = ($uts * 0.3) + ($uas * 0.4) + ($tugas * 0.3);

                $data = [
                    'siswa_id' => $siswaId,
                    'mapel_id' => $mapelId,
                    'tahun_akademik_id' => $tahunAkademikId,
                    'semester' => $semester,
                    'uts' => $uts,
                    'uas' => $uas,
                    'tugas' => $tugas,
                    'akhir' => round($akhir, 2)
                ];

                // Check if grade already exists
                $existingNilai = $this->nilaiModel->where([
                    'siswa_id' => $siswaId,
                    'mapel_id' => $mapelId,
                    'semester' => $semester,
                    'tahun_akademik_id' => $tahunAkademikId
                ])->first();

                if ($existingNilai) {
                    // Update existing grade
                    $data['id'] = $existingNilai['id'];
                    if ($this->nilaiModel->save($data)) {
                        $successCount++;
                    } else {
                        $errorCount++;
                    }
                } else {
                    // Insert new grade
                    if ($this->nilaiModel->insert($data)) {
                        $successCount++;
                    } else {
                        $errorCount++;
                    }
                }
            }
        }

        if ($successCount > 0) {
            $message = "Berhasil menyimpan nilai untuk {$successCount} siswa";
            if ($errorCount > 0) {
                $message .= " (Gagal: {$errorCount} siswa)";
            }
            return redirect()->to("guru/nilai/input?kelas_id={$kelasId}&mapel_id={$mapelId}&semester={$semester}")->with('success', $message);
        } else {
            return redirect()->to("guru/nilai/input?kelas_id={$kelasId}&mapel_id={$mapelId}&semester={$semester}")->with('error', 'Gagal menyimpan nilai');
        }
    }

    public function rekap()
    {
        $kelasId = $this->request->getGet('kelas_id');
        $semester = $this->request->getGet('semester');

        if (!$kelasId) {
            return redirect()->to('guru/nilai')->with('error', 'Pilih kelas terlebih dahulu');
        }

        // Ambil tahun akademik aktif
        $tahunAkademikModel = new \App\Models\TahunAkademikModel();
        $tahunAkademikAktif = $tahunAkademikModel->where('status', 'Aktif')->first();
        $tahun_akademik_id = $tahunAkademikAktif ? $tahunAkademikAktif['id'] : null;
        if (!$tahun_akademik_id) {
            return redirect()->to('guru/nilai')->with('error', 'Tahun akademik aktif belum diatur. Silakan hubungi admin.');
        }
        if (!$semester) {
            $semester = $tahunAkademikAktif['semester'];
        }

        $guruId = session()->get('user_id');
        
        // Get class info
        $kelas = $this->kelasModel->select('kelas.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->find($kelasId);

        // Get students with their grades
        $siswaList = $this->siswaModel->select('siswa.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->where('siswa.kelas_id', $kelasId)
            ->findAll();

        // Get all subjects
        $mapelList = $this->mapelModel->findAll();

        // Get grades for all students and subjects
        $nilaiData = [];
        foreach ($siswaList as $siswa) {
            $nilaiData[$siswa['id']] = [];
            foreach ($mapelList as $mapel) {
                $nilai = $this->nilaiModel->where([
                    'siswa_id' => $siswa['id'],
                    'mapel_id' => $mapel['id'],
                    'semester' => $semester,
                    'tahun_akademik_id' => $tahun_akademik_id
                ])->first();
                
                $nilaiData[$siswa['id']][$mapel['id']] = $nilai ?: null;
            }
        }

        $data = [
            'title' => 'Rekap Nilai',
            'kelas' => $kelas,
            'semester' => $semester,
            'siswaList' => $siswaList,
            'mapelList' => $mapelList,
            'nilaiData' => $nilaiData,
            'user' => session()->get('user')
        ];

        return view('guru/nilai/rekap', $data);
    }

    public function cetak()
    {
        $kelasId = $this->request->getGet('kelas_id');
        $semester = $this->request->getGet('semester') ?? 'Ganjil';

        if (!$kelasId) {
            return redirect()->to('guru/nilai')->with('error', 'Pilih kelas terlebih dahulu');
        }

        // Ambil tahun akademik aktif
        $tahunAkademikModel = new \App\Models\TahunAkademikModel();
        $tahunAkademikAktif = $tahunAkademikModel->where('status', 'Aktif')->first();
        $tahun_akademik_id = $tahunAkademikAktif ? $tahunAkademikAktif['id'] : null;
        if (!$tahun_akademik_id) {
            return redirect()->to('guru/nilai')->with('error', 'Tahun akademik aktif belum diatur. Silakan hubungi admin.');
        }

        // Get class info
        $kelas = $this->kelasModel->select('kelas.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->find($kelasId);

        // Get students with their grades
        $siswaList = $this->siswaModel->select('siswa.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->where('siswa.kelas_id', $kelasId)
            ->findAll();

        // Get all subjects
        $mapelList = $this->mapelModel->findAll();

        // Get grades for all students and subjects
        $nilaiData = [];
        foreach ($siswaList as $siswa) {
            $nilaiData[$siswa['id']] = [];
            foreach ($mapelList as $mapel) {
                $nilai = $this->nilaiModel->where([
                    'siswa_id' => $siswa['id'],
                    'mapel_id' => $mapel['id'],
                    'semester' => $semester,
                    'tahun_akademik_id' => $tahun_akademik_id
                ])->first();
                
                $nilaiData[$siswa['id']][$mapel['id']] = $nilai ?: null;
            }
        }

        $data = [
            'title' => 'Cetak Nilai',
            'kelas' => $kelas,
            'semester' => $semester,
            'siswaList' => $siswaList,
            'mapelList' => $mapelList,
            'nilaiData' => $nilaiData,
            'user' => session()->get('user')
        ];

        return view('guru/nilai/cetak', $data);
    }
} 