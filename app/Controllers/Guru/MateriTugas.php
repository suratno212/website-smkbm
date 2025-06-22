<?php
namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\MateriModel;
use App\Models\TugasModel;
use App\Models\MapelModel;
use App\Models\KelasModel;
use App\Models\PertemuanModel;
use App\Models\PengumpulanTugasModel;
use App\Models\SiswaModel;

class MateriTugas extends BaseController
{
    protected $materiModel;
    protected $tugasModel;
    protected $mapelModel;
    protected $kelasModel;
    protected $pertemuanModel;
    protected $pengumpulanTugasModel;
    protected $siswaModel;

    public function __construct()
    {
        $this->materiModel = new MateriModel();
        $this->tugasModel = new TugasModel();
        $this->mapelModel = new MapelModel();
        $this->kelasModel = new KelasModel();
        $this->pertemuanModel = new PertemuanModel();
        $this->pengumpulanTugasModel = new PengumpulanTugasModel();
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $guru_id = session('user_id');
        
        // Ambil materi dengan join ke mapel dan kelas
        $materi = $this->materiModel->select('materi.*, mapel.nama_mapel, kelas.nama_kelas')
            ->join('mapel', 'mapel.id = materi.mapel_id')
            ->join('kelas', 'kelas.id = materi.kelas_id')
            ->where('materi.guru_id', $guru_id)
            ->orderBy('materi.id', 'DESC')
            ->findAll();
            
        // Ambil tugas dengan join ke mapel dan kelas
        $tugas = $this->tugasModel->select('tugas.*, mapel.nama_mapel, kelas.nama_kelas')
            ->join('mapel', 'mapel.id = tugas.mapel_id')
            ->join('kelas', 'kelas.id = tugas.kelas_id')
            ->where('tugas.guru_id', $guru_id)
            ->orderBy('tugas.deadline', 'ASC')
            ->findAll();
            
        // Ambil kelas yang diajar oleh guru ini
        $kelas = $this->kelasModel->select('kelas.*')
            ->join('jadwal', 'jadwal.kelas_id = kelas.id')
            ->where('jadwal.guru_id', $guru_id)
            ->groupBy('kelas.id')
            ->findAll();
            
        return view('guru/materi_tugas/index', [
            'title' => 'E-Learning',
            'materi' => $materi,
            'tugas' => $tugas,
            'kelas' => $kelas
        ]);
    }

    public function uploadMateri()
    {
        $mapel = $this->mapelModel->findAll();
        $kelas = $this->kelasModel->findAll();
        $kelas_id = $this->request->getGet('kelas_id') ?? $this->request->getPost('kelas_id');
        $pertemuan = $kelas_id ? $this->pertemuanModel->where('kelas_id', $kelas_id)->findAll() : [];
        if ($this->request->getMethod() === 'post') {
            $file = $this->request->getFile('file');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($file->getSize() > 10 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file maksimal 10MB');
                }
                $newName = $file->getRandomName();
                $file->move('public/uploads/materi', $newName);
                $this->materiModel->save([
                    'guru_id' => session('user_id'),
                    'mapel_id' => $this->request->getPost('mapel_id'),
                    'kelas_id' => $this->request->getPost('kelas_id'),
                    'pertemuan_id' => $this->request->getPost('pertemuan_id'),
                    'judul' => $this->request->getPost('judul'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'file' => $newName,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                return redirect()->to('/guru/materitugas')->with('success', 'Materi berhasil diupload');
            } else {
                return redirect()->back()->with('error', 'File tidak valid');
            }
        }
        return view('guru/materi_tugas/upload_materi', [
            'title' => 'Upload Materi',
            'mapel' => $mapel,
            'kelas' => $kelas,
            'pertemuan' => $pertemuan,
            'kelas_id' => $kelas_id
        ]);
    }

    public function uploadTugas()
    {
        $mapel = $this->mapelModel->findAll();
        $kelas = $this->kelasModel->findAll();
        $kelas_id = $this->request->getGet('kelas_id') ?? $this->request->getPost('kelas_id');
        $pertemuan = $kelas_id ? $this->pertemuanModel->where('kelas_id', $kelas_id)->findAll() : [];
        if ($this->request->getMethod() === 'post') {
            $data = [
                'guru_id' => session('user_id'),
                'mapel_id' => $this->request->getPost('mapel_id'),
                'kelas_id' => $this->request->getPost('kelas_id'),
                'pertemuan_id' => $this->request->getPost('pertemuan_id'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'deadline' => $this->request->getPost('deadline'),
                'bobot_nilai' => $this->request->getPost('bobot_nilai') ?: 10,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $file = $this->request->getFile('file');
            if ($file && $file->isValid() && !$file->hasMoved() && $file->getSize() > 0) {
                if ($file->getSize() > 10 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file maksimal 10MB');
                }
                $newName = $file->getRandomName();
                $file->move('public/uploads/tugas', $newName);
                $data['file'] = $newName;
            }
            $this->tugasModel->save($data);
            return redirect()->to('/guru/materitugas')->with('success', 'Tugas berhasil diupload');
        }
        return view('guru/materi_tugas/upload_tugas', [
            'title' => 'Upload Tugas',
            'mapel' => $mapel,
            'kelas' => $kelas,
            'pertemuan' => $pertemuan,
            'kelas_id' => $kelas_id
        ]);
    }

    public function deleteMateri($id)
    {
        $materi = $this->materiModel->find($id);
        if ($materi) {
            @unlink('public/uploads/materi/' . $materi['file']);
            $this->materiModel->delete($id);
        }
        return redirect()->to('/guru/materitugas')->with('success', 'Materi berhasil dihapus');
    }

    public function deleteTugas($id)
    {
        $this->tugasModel->delete($id);
        return redirect()->to('/guru/materitugas')->with('success', 'Tugas berhasil dihapus');
    }

    public function materi()
    {
        $guru_id = session('user_id');
        $materi = $this->materiModel->select('materi.*, mapel.nama_mapel, kelas.nama_kelas')
            ->join('mapel', 'mapel.id = materi.mapel_id')
            ->join('kelas', 'kelas.id = materi.kelas_id')
            ->where('materi.guru_id', $guru_id)
            ->orderBy('materi.id', 'DESC')
            ->findAll();
            
        return view('guru/materi_tugas/materi', [
            'title' => 'Daftar Materi',
            'materi' => $materi
        ]);
    }

    public function tugas()
    {
        $guru_id = session('user_id');
        $tugas = $this->tugasModel->select('tugas.*, mapel.nama_mapel, kelas.nama_kelas')
            ->join('mapel', 'mapel.id = tugas.mapel_id')
            ->join('kelas', 'kelas.id = tugas.kelas_id')
            ->where('tugas.guru_id', $guru_id)
            ->orderBy('tugas.deadline', 'ASC')
            ->findAll();
            
        return view('guru/materi_tugas/tugas', [
            'title' => 'Daftar Tugas',
            'tugas' => $tugas
        ]);
    }

    public function pengumpulan()
    {
        $guru_id = session('user_id');
        
        // Filter parameters
        $mapel_filter = $this->request->getGet('mapel_filter');
        $kelas_filter = $this->request->getGet('kelas_filter');
        $status_filter = $this->request->getGet('status_filter');
        
        // Build query for tugas
        $tugasQuery = $this->tugasModel->select('tugas.*, mapel.nama_mapel, kelas.nama_kelas')
            ->join('mapel', 'mapel.id = tugas.mapel_id')
            ->join('kelas', 'kelas.id = tugas.kelas_id')
            ->where('tugas.guru_id', $guru_id);
            
        if ($mapel_filter) {
            $tugasQuery->where('tugas.mapel_id', $mapel_filter);
        }
        if ($kelas_filter) {
            $tugasQuery->where('tugas.kelas_id', $kelas_filter);
        }
        
        $tugas_list = $tugasQuery->orderBy('tugas.deadline', 'ASC')->findAll();
        
        // Add statistics for each tugas
        foreach ($tugas_list as &$tugas) {
            $total_siswa = $this->siswaModel->where('kelas_id', $tugas['kelas_id'])->countAllResults();
            $dikumpulkan = $this->pengumpulanTugasModel->where('tugas_id', $tugas['id'])
                ->where('status', 'Dikumpulkan')
                ->countAllResults();
            $terlambat = $this->pengumpulanTugasModel->where('tugas_id', $tugas['id'])
                ->where('status', 'Terlambat')
                ->countAllResults();
                
            $tugas['total_siswa'] = $total_siswa;
            $tugas['dikumpulkan'] = $dikumpulkan;
            $tugas['terlambat'] = $terlambat;
        }
        
        // Get filter options
        $mapel_list = $this->mapelModel->findAll();
        $kelas_list = $this->kelasModel->findAll();
        
        // Calculate overall statistics
        $total_tugas = count($tugas_list);
        $dikumpulkan = array_sum(array_column($tugas_list, 'dikumpulkan'));
        $terlambat = array_sum(array_column($tugas_list, 'terlambat'));
        $total_siswa = array_sum(array_column($tugas_list, 'total_siswa'));
        $belum_dikumpulkan = $total_siswa - $dikumpulkan - $terlambat;
        
        return view('guru/materi_tugas/pengumpulan', [
            'title' => 'Review Pengumpulan Tugas',
            'tugas_list' => $tugas_list,
            'mapel_list' => $mapel_list,
            'kelas_list' => $kelas_list,
            'mapel_filter' => $mapel_filter,
            'kelas_filter' => $kelas_filter,
            'status_filter' => $status_filter,
            'total_tugas' => $total_tugas,
            'dikumpulkan' => $dikumpulkan,
            'belum_dikumpulkan' => $belum_dikumpulkan,
            'terlambat' => $terlambat
        ]);
    }

    public function detailPengumpulan($tugas_id)
    {
        $guru_id = session('user_id');
        
        // Get tugas info
        $tugas = $this->tugasModel->select('tugas.*, mapel.nama_mapel, kelas.nama_kelas')
            ->join('mapel', 'mapel.id = tugas.mapel_id')
            ->join('kelas', 'kelas.id = tugas.kelas_id')
            ->where('tugas.id', $tugas_id)
            ->where('tugas.guru_id', $guru_id)
            ->first();
            
        if (!$tugas) {
            return redirect()->to('/guru/materitugas/pengumpulan')->with('error', 'Tugas tidak ditemukan');
        }
        
        // Get all students in the class with all necessary fields
        $siswa_list = $this->siswaModel->select('siswa.*, users.username')
            ->join('users', 'users.id = siswa.user_id')
            ->where('siswa.kelas_id', $tugas['kelas_id'])
            ->findAll();
        
        // Get pengumpulan for each student
        foreach ($siswa_list as &$siswa) {
            $pengumpulan = $this->pengumpulanTugasModel->where('tugas_id', $tugas_id)
                ->where('siswa_id', $siswa['id'])
                ->first();
                
            if ($pengumpulan) {
                $siswa['pengumpulan'] = $pengumpulan;
                $siswa['status'] = $pengumpulan['status'];
                $siswa['nilai'] = $pengumpulan['nilai'];
                $siswa['catatan'] = $pengumpulan['catatan'];
            } else {
                $siswa['pengumpulan'] = null;
                $siswa['status'] = 'Belum dikumpulkan';
                $siswa['nilai'] = null;
                $siswa['catatan'] = null;
            }
        }
        
        return view('guru/materi_tugas/detail_pengumpulan', [
            'title' => 'Detail Pengumpulan Tugas',
            'tugas' => $tugas,
            'siswa_list' => $siswa_list
        ]);
    }

    public function downloadAll($tugas_id)
    {
        $guru_id = session('user_id');
        
        // Verify tugas belongs to this guru
        $tugas = $this->tugasModel->where('id', $tugas_id)
            ->where('guru_id', $guru_id)
            ->first();
            
        if (!$tugas) {
            return redirect()->back()->with('error', 'Tugas tidak ditemukan');
        }
        
        // Get all pengumpulan for this tugas
        $pengumpulan_list = $this->pengumpulanTugasModel->select('pengumpulan_tugas.*, siswa.nama as nama_siswa, siswa.nisn')
            ->join('siswa', 'siswa.id = pengumpulan_tugas.siswa_id')
            ->where('pengumpulan_tugas.tugas_id', $tugas_id)
            ->where('pengumpulan_tugas.file_tugas IS NOT NULL')
            ->findAll();
            
        if (empty($pengumpulan_list)) {
            return redirect()->back()->with('error', 'Tidak ada file yang dapat didownload');
        }
        
        // Create temp directory if not exists
        $tempDir = 'public/uploads/temp';
        if (!is_dir($tempDir)) {
            if (!mkdir($tempDir, 0777, true)) {
                return redirect()->back()->with('error', 'Gagal membuat direktori temporary');
            }
        }
        
        // Create ZIP file
        $zip = new \ZipArchive();
        $zipName = 'tugas_' . $tugas_id . '_' . date('Y-m-d_H-i-s') . '.zip';
        $zipPath = $tempDir . '/' . $zipName;
        
        // Remove existing file if exists
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
        
        if ($zip->open($zipPath, \ZipArchive::CREATE) !== TRUE) {
            return redirect()->back()->with('error', 'Gagal membuat file ZIP');
        }
        
        $addedFiles = 0;
        foreach ($pengumpulan_list as $pengumpulan) {
            $filePath = 'public/uploads/tugas_siswa/' . $pengumpulan['file_tugas'];
            if (file_exists($filePath)) {
                $fileName = $pengumpulan['nisn'] . '_' . $pengumpulan['nama_siswa'] . '_' . $pengumpulan['file_tugas'];
                // Sanitize filename
                $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);
                
                if ($zip->addFile($filePath, $fileName)) {
                    $addedFiles++;
                }
            }
        }
        
        $zip->close();
        
        if ($addedFiles == 0) {
            // Remove empty zip file
            if (file_exists($zipPath)) {
                unlink($zipPath);
            }
            return redirect()->back()->with('error', 'Tidak ada file yang berhasil ditambahkan ke ZIP');
        }
        
        // Check if file exists and is readable
        if (!file_exists($zipPath) || !is_readable($zipPath)) {
            return redirect()->back()->with('error', 'File ZIP tidak dapat diakses');
        }
        
        // Return download response
        return $this->response->download($zipPath, $zipName)->delete();
    }

    public function nilaiTugas()
    {
        $pengumpulan_id = $this->request->getPost('pengumpulan_id');
        $nilai = $this->request->getPost('nilai');
        $catatan = $this->request->getPost('catatan');
        
        $this->pengumpulanTugasModel->update($pengumpulan_id, [
            'nilai' => $nilai,
            'catatan' => $catatan,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->back()->with('success', 'Nilai berhasil disimpan');
    }

    public function download($materi_id)
    {
        $guru_id = session('user_id');
        
        $materi = $this->materiModel->where('id', $materi_id)
            ->where('guru_id', $guru_id)
            ->first();
            
        if (!$materi || !$materi['file']) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }
        
        $filePath = 'public/uploads/materi/' . $materi['file'];
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }
        
        return $this->response->download($filePath, $materi['judul'] . '.' . pathinfo($materi['file'], PATHINFO_EXTENSION));
    }

    public function editMateri($id)
    {
        $guru_id = session('user_id');
        $materi = $this->materiModel->where('id', $id)
            ->where('guru_id', $guru_id)
            ->first();
            
        if (!$materi) {
            return redirect()->to('/guru/materitugas')->with('error', 'Materi tidak ditemukan');
        }
        
        $mapel = $this->mapelModel->findAll();
        $kelas = $this->kelasModel->findAll();
        
        return view('guru/materi_tugas/edit_materi', [
            'title' => 'Edit Materi',
            'materi' => $materi,
            'mapel' => $mapel,
            'kelas' => $kelas
        ]);
    }

    public function updateMateri($id)
    {
        $guru_id = session('user_id');
        $materi = $this->materiModel->where('id', $id)
            ->where('guru_id', $guru_id)
            ->first();
            
        if (!$materi) {
            return redirect()->to('/guru/materitugas')->with('error', 'Materi tidak ditemukan');
        }
        
        $data = [
            'mapel_id' => $this->request->getPost('mapel_id'),
            'kelas_id' => $this->request->getPost('kelas_id'),
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($file->getSize() > 10 * 1024 * 1024) {
                return redirect()->back()->with('error', 'Ukuran file maksimal 10MB');
            }
            
            // Delete old file
            if ($materi['file']) {
                @unlink('public/uploads/materi/' . $materi['file']);
            }
            
            $newName = $file->getRandomName();
            $file->move('public/uploads/materi', $newName);
            $data['file'] = $newName;
        }
        
        $this->materiModel->update($id, $data);
        return redirect()->to('/guru/materitugas')->with('success', 'Materi berhasil diupdate');
    }

    public function editTugas($id)
    {
        $guru_id = session('user_id');
        $tugas = $this->tugasModel->where('id', $id)
            ->where('guru_id', $guru_id)
            ->first();
            
        if (!$tugas) {
            return redirect()->to('/guru/materitugas')->with('error', 'Tugas tidak ditemukan');
        }
        
        $mapel = $this->mapelModel->findAll();
        $kelas = $this->kelasModel->findAll();
        
        return view('guru/materi_tugas/edit_tugas', [
            'title' => 'Edit Tugas',
            'tugas' => $tugas,
            'mapel' => $mapel,
            'kelas' => $kelas
        ]);
    }

    public function updateTugas($id)
    {
        $guru_id = session('user_id');
        $tugas = $this->tugasModel->where('id', $id)
            ->where('guru_id', $guru_id)
            ->first();
            
        if (!$tugas) {
            return redirect()->to('/guru/materitugas')->with('error', 'Tugas tidak ditemukan');
        }
        
        $data = [
            'mapel_id' => $this->request->getPost('mapel_id'),
            'kelas_id' => $this->request->getPost('kelas_id'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'deadline' => $this->request->getPost('deadline'),
            'bobot_nilai' => $this->request->getPost('bobot_nilai') ?: 10,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved() && $file->getSize() > 0) {
            if ($file->getSize() > 10 * 1024 * 1024) {
                return redirect()->back()->with('error', 'Ukuran file maksimal 10MB');
            }
            
            // Delete old file
            if ($tugas['file']) {
                @unlink('public/uploads/tugas/' . $tugas['file']);
            }
            
            $newName = $file->getRandomName();
            $file->move('public/uploads/tugas', $newName);
            $data['file'] = $newName;
        }
        
        $this->tugasModel->update($id, $data);
        return redirect()->to('/guru/materitugas')->with('success', 'Tugas berhasil diupdate');
    }

    public function statistik()
    {
        $guru_id = session('user_id');
        
        // Get statistics
        $total_materi = $this->materiModel->where('guru_id', $guru_id)->countAllResults();
        $total_tugas = $this->tugasModel->where('guru_id', $guru_id)->countAllResults();
        
        // Get tugas statistics by month
        $tugas_by_month = $this->tugasModel->select('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('guru_id', $guru_id)
            ->where('YEAR(created_at)', date('Y'))
            ->groupBy('MONTH(created_at)')
            ->findAll();
            
        // Get pengumpulan statistics
        $total_pengumpulan = $this->pengumpulanTugasModel->select('pengumpulan_tugas.*, tugas.guru_id')
            ->join('tugas', 'tugas.id = pengumpulan_tugas.tugas_id')
            ->where('tugas.guru_id', $guru_id)
            ->countAllResults();
            
        $dikumpulkan = $this->pengumpulanTugasModel->select('pengumpulan_tugas.*, tugas.guru_id')
            ->join('tugas', 'tugas.id = pengumpulan_tugas.tugas_id')
            ->where('tugas.guru_id', $guru_id)
            ->where('pengumpulan_tugas.status', 'Dikumpulkan')
            ->countAllResults();
            
        return view('guru/materi_tugas/statistik', [
            'title' => 'Statistik E-Learning',
            'total_materi' => $total_materi,
            'total_tugas' => $total_tugas,
            'total_pengumpulan' => $total_pengumpulan,
            'dikumpulkan' => $dikumpulkan,
            'tugas_by_month' => $tugas_by_month
        ]);
    }
} 