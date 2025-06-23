<?php
namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\MateriModel;
use App\Models\TugasModel;
use App\Models\PengumpulanTugasModel;
use App\Models\SiswaModel;
use App\Models\MapelModel;
use App\Models\KelasModel;
use App\Models\UserModel;

class MateriTugas extends BaseController
{
    protected $materiModel;
    protected $tugasModel;
    protected $pengumpulanTugasModel;
    protected $siswaModel;
    protected $mapelModel;
    protected $kelasModel;
    protected $userModel;

    public function __construct()
    {
        $this->materiModel = new MateriModel();
        $this->tugasModel = new TugasModel();
        $this->pengumpulanTugasModel = new PengumpulanTugasModel();
        $this->siswaModel = new SiswaModel();
        $this->mapelModel = new MapelModel();
        $this->kelasModel = new KelasModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $siswa_id = session('user_id');
        $user = $this->userModel->find($siswa_id);
        $siswa = $this->siswaModel->where('user_id', $siswa_id)->first();
        
        if (!$siswa) {
            return redirect()->to('/siswa/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        // Ambil materi untuk kelas siswa
        $materi = $this->materiModel->select('materi.*, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('mapel', 'mapel.id = materi.mapel_id')
            ->join('guru', 'guru.id = materi.guru_id')
            ->where('materi.kelas_id', $siswa['kelas_id'])
            ->orderBy('materi.id', 'DESC')
            ->findAll();

        // Ambil tugas untuk kelas siswa
        $tugas = $this->tugasModel->select('tugas.*, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('mapel', 'mapel.id = tugas.mapel_id')
            ->join('guru', 'guru.id = tugas.guru_id')
            ->where('tugas.kelas_id', $siswa['kelas_id'])
            ->orderBy('tugas.deadline', 'ASC')
            ->findAll();

        return view('siswa/materi_tugas/index', [
            'title' => 'E-Learning',
            'user' => $user,
            'materi' => $materi,
            'tugas' => $tugas,
            'siswa' => $siswa
        ]);
    }

    public function materi()
    {
        $siswa_id = session('user_id');
        $user = $this->userModel->find($siswa_id);
        $siswa = $this->siswaModel->where('user_id', $siswa_id)->first();
        
        if (!$siswa) {
            return redirect()->to('/siswa/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        $materi = $this->materiModel->select('materi.*, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('mapel', 'mapel.id = materi.mapel_id')
            ->join('guru', 'guru.id = materi.guru_id')
            ->where('materi.kelas_id', $siswa['kelas_id'])
            ->orderBy('materi.id', 'DESC')
            ->findAll();

        return view('siswa/materi_tugas/materi', [
            'title' => 'Materi Pembelajaran',
            'user' => $user,
            'materi' => $materi,
            'siswa' => $siswa
        ]);
    }

    public function tugas()
    {
        $siswa_id = session('user_id');
        $user = $this->userModel->find($siswa_id);
        $siswa = $this->siswaModel->where('user_id', $siswa_id)->first();
        
        if (!$siswa) {
            return redirect()->to('/siswa/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        $tugas = $this->tugasModel->select('tugas.*, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('mapel', 'mapel.id = tugas.mapel_id')
            ->join('guru', 'guru.id = tugas.guru_id')
            ->where('tugas.kelas_id', $siswa['kelas_id'])
            ->orderBy('tugas.deadline', 'ASC')
            ->findAll();

        // Ambil status pengumpulan tugas untuk setiap tugas
        foreach ($tugas as &$t) {
            $pengumpulan = $this->pengumpulanTugasModel->where('tugas_id', $t['id'])
                ->where('siswa_id', $siswa['id'])
                ->first();
            $t['status_pengumpulan'] = $pengumpulan ? $pengumpulan['status'] : 'Belum dikumpulkan';
            $t['nilai'] = $pengumpulan ? $pengumpulan['nilai'] : null;
            $t['catatan'] = $pengumpulan ? $pengumpulan['catatan'] : null;
        }

        return view('siswa/materi_tugas/tugas', [
            'title' => 'Tugas',
            'user' => $user,
            'tugas' => $tugas,
            'siswa' => $siswa
        ]);
    }

    public function detailTugas($tugas_id)
    {
        $siswa_id = session('user_id');
        $user = $this->userModel->find($siswa_id);
        $siswa = $this->siswaModel->where('user_id', $siswa_id)->first();
        
        if (!$siswa) {
            return redirect()->to('/siswa/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        $tugas = $this->tugasModel->select('tugas.*, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('mapel', 'mapel.id = tugas.mapel_id')
            ->join('guru', 'guru.id = tugas.guru_id')
            ->where('tugas.id', $tugas_id)
            ->where('tugas.kelas_id', $siswa['kelas_id'])
            ->first();

        if (!$tugas) {
            return redirect()->to('/siswa/materitugas/tugas')->with('error', 'Tugas tidak ditemukan');
        }

        // Cek apakah sudah mengumpulkan tugas
        $pengumpulan = $this->pengumpulanTugasModel->where('tugas_id', $tugas_id)
            ->where('siswa_id', $siswa['id'])
            ->first();

        return view('siswa/materi_tugas/detail_tugas', [
            'title' => 'Detail Tugas',
            'user' => $user,
            'tugas' => $tugas,
            'siswa' => $siswa,
            'pengumpulan' => $pengumpulan
        ]);
    }

    public function uploadTugas($tugas_id)
    {
        $siswa_id = session('user_id');
        $user = $this->userModel->find($siswa_id);
        $siswa = $this->siswaModel->where('user_id', $siswa_id)->first();
        
        if (!$siswa) {
            return redirect()->to('/siswa/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        $tugas = $this->tugasModel->where('id', $tugas_id)
            ->where('kelas_id', $siswa['kelas_id'])
            ->first();

        if (!$tugas) {
            return redirect()->to('/siswa/materitugas/tugas')->with('error', 'Tugas tidak ditemukan');
        }

        // Cek deadline
        if (date('Y-m-d H:i:s') > $tugas['deadline']) {
            return redirect()->to('/siswa/materitugas/tugas')->with('error', 'Deadline tugas sudah lewat');
        }

        if ($this->request->getMethod() === 'post') {
            $file = $this->request->getFile('file_tugas');
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Validasi ukuran file (max 10MB)
                if ($file->getSize() > 10 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file maksimal 10MB');
                }

                // Validasi tipe file
                $allowedTypes = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'zip', 'rar'];
                if (!in_array($file->getExtension(), $allowedTypes)) {
                    return redirect()->back()->with('error', 'Tipe file tidak diizinkan');
                }

                $newName = $file->getRandomName();
                $file->move('public/uploads/tugas_siswa', $newName);

                // Cek apakah sudah ada pengumpulan sebelumnya
                $existingPengumpulan = $this->pengumpulanTugasModel->where('tugas_id', $tugas_id)
                    ->where('siswa_id', $siswa['id'])
                    ->first();

                if ($existingPengumpulan) {
                    // Update pengumpulan yang ada
                    $this->pengumpulanTugasModel->update($existingPengumpulan['id'], [
                        'file_tugas' => $newName,
                        'status' => 'Dikumpulkan',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                } else {
                    // Buat pengumpulan baru
                    $this->pengumpulanTugasModel->insert([
                        'tugas_id' => $tugas_id,
                        'siswa_id' => $siswa['id'],
                        'file_tugas' => $newName,
                        'status' => 'Dikumpulkan',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }

                return redirect()->to('/siswa/materitugas/tugas')->with('success', 'Tugas berhasil dikumpulkan');
            } else {
                return redirect()->back()->with('error', 'File tidak valid');
            }
        }

        return view('siswa/materi_tugas/upload_tugas', [
            'title' => 'Upload Tugas',
            'user' => $user,
            'tugas' => $tugas,
            'siswa' => $siswa
        ]);
    }

    public function downloadMateri($materi_id)
    {
        $siswa_id = session('user_id');
        $siswa = $this->siswaModel->where('user_id', $siswa_id)->first();
        
        if (!$siswa) {
            return redirect()->to('/siswa/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        $materi = $this->materiModel->where('id', $materi_id)
            ->where('kelas_id', $siswa['kelas_id'])
            ->first();

        if (!$materi || !$materi['file']) {
            return redirect()->back()->with('error', 'File materi tidak ditemukan');
        }

        $filePath = 'public/uploads/materi/' . $materi['file'];
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File materi tidak ditemukan');
        }

        return $this->response->download($filePath, $materi['judul'] . '.' . pathinfo($materi['file'], PATHINFO_EXTENSION));
    }

    public function downloadTugas($tugas_id)
    {
        $tugas = $this->tugasModel->find($tugas_id);
        
        if (!$tugas || !$tugas['file']) {
            return redirect()->back()->with('error', 'File tugas tidak ditemukan');
        }

        $filePath = 'public/uploads/tugas/' . $tugas['file'];
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tugas tidak ditemukan');
        }

        return $this->response->download($filePath, 'Tugas_' . $tugas['id'] . '.' . pathinfo($tugas['file'], PATHINFO_EXTENSION));
    }
} 