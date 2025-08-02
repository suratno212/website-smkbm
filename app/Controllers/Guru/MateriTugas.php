<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\MateriModel;
use App\Models\TugasModel;
use App\Models\PengumpulanTugasModel;
use App\Models\SiswaModel;
use App\Models\JadwalModel;
use App\Models\GuruModel;

class MateriTugas extends BaseController
{
    protected $materiModel;
    protected $tugasModel;
    protected $pengumpulanTugasModel;
    protected $siswaModel;
    protected $jadwalModel;
    protected $guruModel;
    protected $kelasModel;
    protected $mapelModel;

    public function __construct()
    {
        $this->materiModel = new MateriModel();
        $this->tugasModel = new TugasModel();
        $this->pengumpulanTugasModel = new PengumpulanTugasModel();
        $this->siswaModel = new SiswaModel();
        $this->jadwalModel = new JadwalModel();
        $this->guruModel = new GuruModel();
        $this->kelasModel = new \App\Models\KelasModel();
        $this->mapelModel = new \App\Models\MapelModel();
    }

    public function index()
    {
        $nik_nip = session()->get('nik_nip');
        $guru = $this->guruModel->find($nik_nip);

        // Get classes taught by this guru
        $kelas_diampu = $this->jadwalModel->select('DISTINCT(kelas.kd_kelas), kelas.nama_kelas')
            ->join('kelas', 'kelas.kd_kelas = jadwal.kd_kelas')
            ->where('jadwal.nik_nip', $nik_nip)
            ->findAll();

        // Get latest 5 materi for this guru
        $materi = $this->materiModel
            ->select('materi.*, mapel.nama_mapel, kelas.nama_kelas')
            ->join('mapel', 'mapel.kd_mapel = materi.kd_mapel', 'left')
            ->join('kelas', 'kelas.kd_kelas = materi.kd_kelas', 'left')
            ->where('materi.nik_nip', $nik_nip)
            ->orderBy('materi.created_at', 'DESC')
            ->findAll(5);

        // Get latest 5 tugas for this guru
        $tugas = $this->tugasModel
            ->select('tugas.*, mapel.nama_mapel, kelas.nama_kelas')
            ->join('mapel', 'mapel.kd_mapel = tugas.kd_mapel', 'left')
            ->join('kelas', 'kelas.kd_kelas = tugas.kd_kelas', 'left')
            ->where('tugas.nik_nip', $nik_nip)
            ->orderBy('tugas.created_at', 'DESC')
            ->findAll(5);

        // For the dashboard, $kelas is all classes taught by this guru
        $kelas = $kelas_diampu;

        $data = [
            'title' => 'Materi & Tugas',
            'guru' => $guru,
            'kelas_diampu' => $kelas_diampu,
            'materi' => $materi ?? [],
            'tugas' => $tugas ?? [],
            'kelas' => $kelas ?? []
        ];

        return view('guru/materi_tugas/index', $data);
    }

    public function materi()
    {
        $nik_nip = session()->get('nik_nip');
        $kd_kelas = $this->request->getGet('kd_kelas');

        $builder = $this->materiModel->select('materi.*, mapel.nama_mapel, kelas.nama_kelas')
            ->join('mapel', 'mapel.kd_mapel = materi.kd_mapel')
            ->join('kelas', 'kelas.kd_kelas = materi.kd_kelas')
            ->where('materi.nik_nip', $nik_nip);

        if ($kd_kelas) {
            $builder->where('materi.kd_kelas', $kd_kelas);
        }

        $data = [
            'title' => 'Data Materi',
            'materi' => $builder->findAll(),
            'selected_kelas' => $kd_kelas
        ];

        return view('guru/materi_tugas/materi', $data);
    }

    public function materiCreate()
    {
        $nik_nip = session()->get('nik_nip');

        // Get classes taught by this guru using direct database connection
        $db = \Config\Database::connect();

        // Test query for classes
        $kelas_query = $db->query("
            SELECT DISTINCT k.kd_kelas, k.nama_kelas 
            FROM jadwal j 
            JOIN kelas k ON k.kd_kelas = j.kd_kelas 
            WHERE j.nik_nip = ?
        ", [$nik_nip]);
        $kelas_diampu = $kelas_query->getResultArray();

        // Test query for subjects
        $mapel_query = $db->query("
            SELECT DISTINCT m.kd_mapel, m.nama_mapel 
            FROM jadwal j 
            JOIN mapel m ON m.kd_mapel = j.kd_mapel 
            WHERE j.nik_nip = ?
        ", [$nik_nip]);
        $mapel_diampu = $mapel_query->getResultArray();



        $data = [
            'title' => 'Tambah Materi',
            'kelas_diampu' => $kelas_diampu,
            'mapel_diampu' => $mapel_diampu,
            'validation' => \Config\Services::validation()
        ];

        return view('guru/materi_tugas/materi_create', $data);
    }

    private function generateKdMateri($kd_kelas, $kd_mapel)
    {
        // Extract jenjang and kelas from kd_kelas
        // Example: X-TKJ-1 -> SMK10, XI-TKJ-1 -> SMK11, XII-TKJ-1 -> SMK12
        $jenjang_kelas = '';
        if (strpos($kd_kelas, 'X-') === 0) {
            $jenjang_kelas = 'SMK10'; // Kelas X
        } elseif (strpos($kd_kelas, 'XI-') === 0) {
            $jenjang_kelas = 'SMK11'; // Kelas XI
        } elseif (strpos($kd_kelas, 'XII-') === 0) {
            $jenjang_kelas = 'SMK12'; // Kelas XII
        } else {
            $jenjang_kelas = 'SMK'; // Default
        }

        // Get count of materi for this specific kelas and mapel
        $count = $this->materiModel->where('kd_kelas', $kd_kelas)
            ->where('kd_mapel', $kd_mapel)
            ->countAllResults();

        // Generate kd_materi format: JENJANG-MAPEL-XX (e.g., SMK10-MTK-01)
        $kd_materi = $jenjang_kelas . '-' . $kd_mapel . '-' . str_pad($count + 1, 2, '0', STR_PAD_LEFT);

        // Check if kd_materi already exists (in case of concurrent insertions)
        while ($this->materiModel->where('kd_materi', $kd_materi)->first()) {
            $count++;
            $kd_materi = $jenjang_kelas . '-' . $kd_mapel . '-' . str_pad($count + 1, 2, '0', STR_PAD_LEFT);
        }

        return $kd_materi;
    }

    private function generateKdTugas($kd_kelas, $kd_mapel)
    {
        // Extract jenjang and kelas from kd_kelas
        // Example: X-TKJ-1 -> SMK10, XI-TKJ-1 -> SMK11, XII-TKJ-1 -> SMK12
        $jenjang_kelas = '';
        if (strpos($kd_kelas, 'X-') === 0) {
            $jenjang_kelas = 'SMK10'; // Kelas X
        } elseif (strpos($kd_kelas, 'XI-') === 0) {
            $jenjang_kelas = 'SMK11'; // Kelas XI
        } elseif (strpos($kd_kelas, 'XII-') === 0) {
            $jenjang_kelas = 'SMK12'; // Kelas XII
        } else {
            $jenjang_kelas = 'SMK'; // Default
        }

        // Get count of tugas for this specific kelas and mapel
        $count = $this->tugasModel->where('kd_kelas', $kd_kelas)
            ->where('kd_mapel', $kd_mapel)
            ->countAllResults();

        // Generate kd_tugas format: JENJANG-MAPEL-XX (e.g., SMK10-MTK-01)
        $kd_tugas = $jenjang_kelas . '-' . $kd_mapel . '-' . str_pad($count + 1, 2, '0', STR_PAD_LEFT);

        // Check if kd_tugas already exists (in case of concurrent insertions)
        while ($this->tugasModel->where('kd_tugas', $kd_tugas)->first()) {
            $count++;
            $kd_tugas = $jenjang_kelas . '-' . $kd_mapel . '-' . str_pad($count + 1, 2, '0', STR_PAD_LEFT);
        }

        return $kd_tugas;
    }

    public function materiStore()
    {
        // Validation rules
        $rules = [
            'kd_kelas' => 'required',
            'kd_mapel' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'file' => 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf,doc,docx,ppt,pptx]',
            'video_url' => 'permit_empty|valid_url'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/materi', $fileName);

        // Generate kd_materi automatically
        $kd_kelas = $this->request->getPost('kd_kelas');
        $kd_mapel = $this->request->getPost('kd_mapel');
        $kd_materi = $this->generateKdMateri($kd_kelas, $kd_mapel);

        $materiData = [
            'kd_materi' => $kd_materi,
            'nik_nip' => session()->get('nik_nip'),
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'kd_mapel' => $this->request->getPost('kd_mapel'),
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file' => $fileName,
            'video_url' => $this->request->getPost('video_url')
        ];

        $this->materiModel->insert($materiData);

        return redirect()->to(base_url('guru/materitugas/materi'))->with('success', 'Materi berhasil ditambahkan dengan kode: ' . $kd_materi);
    }

    public function materiDelete($id)
    {
        $materi = $this->materiModel->find($id);
        if ($materi && $materi['nik_nip'] == session()->get('nik_nip')) {
            // Delete file
            if (file_exists(ROOTPATH . 'public/uploads/materi/' . $materi['file'])) {
                unlink(ROOTPATH . 'public/uploads/materi/' . $materi['file']);
            }
            $this->materiModel->delete($id);
        }

        return redirect()->to('guru/materitugas/materi')->with('success', 'Materi berhasil dihapus');
    }

    public function deleteMateri($kd_materi)
    {
        $nik_nip = session()->get('nik_nip');

        // Check if materi exists and belongs to this guru
        $materi = $this->materiModel->where('kd_materi', $kd_materi)
            ->where('nik_nip', $nik_nip)
            ->first();

        if (!$materi) {
            return redirect()->to('guru/materitugas/materi')->with('error', 'Materi tidak ditemukan');
        }

        // Delete file if exists
        if ($materi['file'] && file_exists(ROOTPATH . 'public/uploads/materi/' . $materi['file'])) {
            unlink(ROOTPATH . 'public/uploads/materi/' . $materi['file']);
        }

        // Delete from database
        $this->materiModel->where('kd_materi', $kd_materi)->delete();

        return redirect()->to('guru/materitugas/materi')->with('success', 'Materi berhasil dihapus');
    }

    public function download($kd_materi)
    {
        $nik_nip = session()->get('nik_nip');

        // Check if materi exists and belongs to this guru
        $materi = $this->materiModel->where('kd_materi', $kd_materi)
            ->where('nik_nip', $nik_nip)
            ->first();

        if (!$materi) {
            return redirect()->to('guru/materitugas/materi')->with('error', 'Materi tidak ditemukan');
        }

        if (!$materi['file']) {
            return redirect()->to('guru/materitugas/materi')->with('error', 'File tidak ditemukan');
        }

        $filePath = ROOTPATH . 'public/uploads/materi/' . $materi['file'];

        if (!file_exists($filePath)) {
            return redirect()->to('guru/materitugas/materi')->with('error', 'File tidak ditemukan di server');
        }

        return $this->response->download($filePath, $materi['file']);
    }

    public function editMateri($kd_materi)
    {
        $nik_nip = session()->get('nik_nip');

        // Get the materi to edit
        $materi = $this->materiModel->where('kd_materi', $kd_materi)
            ->where('nik_nip', $nik_nip)
            ->first();

        if (!$materi) {
            return redirect()->to('guru/materitugas/materi')->with('error', 'Materi tidak ditemukan');
        }

        // Get classes taught by this guru
        $db = \Config\Database::connect();
        $kelas_query = $db->query("
            SELECT DISTINCT k.kd_kelas, k.nama_kelas 
            FROM jadwal j 
            JOIN kelas k ON k.kd_kelas = j.kd_kelas 
            WHERE j.nik_nip = ?
        ", [$nik_nip]);
        $kelas_diampu = $kelas_query->getResultArray();

        // Get subjects taught by this guru
        $mapel_query = $db->query("
            SELECT DISTINCT m.kd_mapel, m.nama_mapel 
            FROM jadwal j 
            JOIN mapel m ON m.kd_mapel = j.kd_mapel 
            WHERE j.nik_nip = ?
        ", [$nik_nip]);
        $mapel_diampu = $mapel_query->getResultArray();

        $data = [
            'title' => 'Edit Materi',
            'materi' => $materi,
            'kelas_diampu' => $kelas_diampu,
            'mapel_diampu' => $mapel_diampu,
            'validation' => \Config\Services::validation()
        ];

        return view('guru/materi_tugas/materi_edit', $data);
    }

    public function updateMateri($kd_materi)
    {
        $nik_nip = session()->get('nik_nip');

        // Check if materi exists and belongs to this guru
        $materi = $this->materiModel->where('kd_materi', $kd_materi)
            ->where('nik_nip', $nik_nip)
            ->first();

        if (!$materi) {
            return redirect()->to('guru/materitugas/materi')->with('error', 'Materi tidak ditemukan');
        }

        // Validation rules
        $rules = [
            'kd_kelas' => 'required',
            'kd_mapel' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'file' => 'permit_empty|max_size[file,10240]|ext_in[file,pdf,doc,docx,ppt,pptx]',
            'video_url' => 'permit_empty|valid_url'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload if new file is provided
        $fileName = $materi['file']; // Keep existing file by default
        $file = $this->request->getFile('file');
        if ($file->isValid() && !$file->hasMoved()) {
            // Delete old file if exists
            if ($materi['file'] && file_exists(ROOTPATH . 'public/uploads/materi/' . $materi['file'])) {
                unlink(ROOTPATH . 'public/uploads/materi/' . $materi['file']);
            }
            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/materi', $fileName);
        }

        $materiData = [
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'kd_mapel' => $this->request->getPost('kd_mapel'),
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file' => $fileName,
            'video_url' => $this->request->getPost('video_url')
        ];

        $this->materiModel->where('kd_materi', $kd_materi)->set($materiData)->update();

        return redirect()->to('guru/materitugas/materi')->with('success', 'Materi berhasil diperbarui');
    }

    public function tugas()
    {
        $nik_nip = session()->get('nik_nip');
        $kd_kelas = $this->request->getGet('kd_kelas');

        $builder = $this->tugasModel->select('tugas.*, mapel.nama_mapel, kelas.nama_kelas')
            ->join('mapel', 'mapel.kd_mapel = tugas.kd_mapel')
            ->join('kelas', 'kelas.kd_kelas = tugas.kd_kelas')
            ->where('tugas.nik_nip', $nik_nip);

        if ($kd_kelas) {
            $builder->where('tugas.kd_kelas', $kd_kelas);
        }

        $data = [
            'title' => 'Data Tugas',
            'tugas' => $builder->findAll(),
            'selected_kelas' => $kd_kelas
        ];

        return view('guru/materi_tugas/tugas', $data);
    }

    public function tugasCreate()
    {
        $nik_nip = session()->get('nik_nip');

        // Get classes taught by this guru using direct database connection
        $db = \Config\Database::connect();

        // Test query for classes
        $kelas_query = $db->query("
            SELECT DISTINCT k.kd_kelas, k.nama_kelas 
            FROM jadwal j 
            JOIN kelas k ON k.kd_kelas = j.kd_kelas 
            WHERE j.nik_nip = ?
        ", [$nik_nip]);
        $kelas_diampu = $kelas_query->getResultArray();

        // Test query for subjects
        $mapel_query = $db->query("
            SELECT DISTINCT m.kd_mapel, m.nama_mapel 
            FROM jadwal j 
            JOIN mapel m ON m.kd_mapel = j.kd_mapel 
            WHERE j.nik_nip = ?
        ", [$nik_nip]);
        $mapel_diampu = $mapel_query->getResultArray();

        $data = [
            'title' => 'Tambah Tugas',
            'kelas_diampu' => $kelas_diampu,
            'mapel_diampu' => $mapel_diampu,
            'validation' => \Config\Services::validation()
        ];

        return view('guru/materi_tugas/tugas_create', $data);
    }

    public function tugasStore()
    {
        // Validation rules
        $rules = [
            'kd_kelas' => 'required',
            'kd_mapel' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'deadline' => 'required|valid_date',
            'file' => 'permit_empty|max_size[file,10240]|ext_in[file,pdf,doc,docx]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload if provided
        $fileName = null;
        $file = $this->request->getFile('file');
        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/tugas', $fileName);
        }

        // Generate kd_tugas automatically
        $kd_kelas = $this->request->getPost('kd_kelas');
        $kd_mapel = $this->request->getPost('kd_mapel');
        $kd_tugas = $this->generateKdTugas($kd_kelas, $kd_mapel);

        $tugasData = [
            'kd_tugas' => $kd_tugas,
            'nik_nip' => session()->get('nik_nip'),
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'kd_mapel' => $this->request->getPost('kd_mapel'),
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'deadline' => $this->request->getPost('deadline'),
            'file' => $fileName
        ];

        $this->tugasModel->insert($tugasData);

        return redirect()->to('guru/materitugas/tugas')->with('success', 'Tugas berhasil ditambahkan dengan kode: ' . $kd_tugas);
    }

    public function tugasDelete($id)
    {
        $tugas = $this->tugasModel->find($id);
        if ($tugas && $tugas['nik_nip'] == session()->get('nik_nip')) {
            $this->tugasModel->delete($id);
        }

        return redirect()->to('guru/materitugas/tugas')->with('success', 'Tugas berhasil dihapus');
    }

    public function deleteTugas($kd_tugas)
    {
        $nik_nip = session()->get('nik_nip');

        // Check if tugas exists and belongs to this guru
        $tugas = $this->tugasModel->where('kd_tugas', $kd_tugas)
            ->where('nik_nip', $nik_nip)
            ->first();

        if (!$tugas) {
            return redirect()->to('guru/materitugas/tugas')->with('error', 'Tugas tidak ditemukan');
        }

        // Delete file if exists
        if ($tugas['file'] && file_exists(ROOTPATH . 'public/uploads/tugas/' . $tugas['file'])) {
            unlink(ROOTPATH . 'public/uploads/tugas/' . $tugas['file']);
        }

        // Delete from database
        $this->tugasModel->where('kd_tugas', $kd_tugas)->delete();

        return redirect()->to('guru/materitugas/tugas')->with('success', 'Tugas berhasil dihapus');
    }

    public function editTugas($kd_tugas)
    {
        $nik_nip = session()->get('nik_nip');

        // Get the tugas to edit
        $tugas = $this->tugasModel->where('kd_tugas', $kd_tugas)
            ->where('nik_nip', $nik_nip)
            ->first();

        if (!$tugas) {
            return redirect()->to('guru/materitugas/tugas')->with('error', 'Tugas tidak ditemukan');
        }

        // Get classes taught by this guru
        $db = \Config\Database::connect();
        $kelas_query = $db->query("
            SELECT DISTINCT k.kd_kelas, k.nama_kelas 
            FROM jadwal j 
            JOIN kelas k ON k.kd_kelas = j.kd_kelas 
            WHERE j.nik_nip = ?
        ", [$nik_nip]);
        $kelas_diampu = $kelas_query->getResultArray();

        // Get subjects taught by this guru
        $mapel_query = $db->query("
            SELECT DISTINCT m.kd_mapel, m.nama_mapel 
            FROM jadwal j 
            JOIN mapel m ON m.kd_mapel = j.kd_mapel 
            WHERE j.nik_nip = ?
        ", [$nik_nip]);
        $mapel_diampu = $mapel_query->getResultArray();

        $data = [
            'title' => 'Edit Tugas',
            'tugas' => $tugas,
            'kelas_diampu' => $kelas_diampu,
            'mapel_diampu' => $mapel_diampu,
            'validation' => \Config\Services::validation()
        ];

        return view('guru/materi_tugas/tugas_edit', $data);
    }

    public function updateTugas($kd_tugas)
    {
        $nik_nip = session()->get('nik_nip');

        // Check if tugas exists and belongs to this guru
        $tugas = $this->tugasModel->where('kd_tugas', $kd_tugas)
            ->where('nik_nip', $nik_nip)
            ->first();

        if (!$tugas) {
            return redirect()->to('guru/materitugas/tugas')->with('error', 'Tugas tidak ditemukan');
        }

        // Validation rules
        $rules = [
            'kd_kelas' => 'required',
            'kd_mapel' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'deadline' => 'required|valid_date',
            'file' => 'permit_empty|max_size[file,10240]|ext_in[file,pdf,doc,docx]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload if new file is provided
        $fileName = $tugas['file']; // Keep existing file by default
        $file = $this->request->getFile('file');
        if ($file->isValid() && !$file->hasMoved()) {
            // Delete old file if exists
            if ($tugas['file'] && file_exists(ROOTPATH . 'public/uploads/tugas/' . $tugas['file'])) {
                unlink(ROOTPATH . 'public/uploads/tugas/' . $tugas['file']);
            }
            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/tugas', $fileName);
        }

        $tugasData = [
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'kd_mapel' => $this->request->getPost('kd_mapel'),
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'deadline' => $this->request->getPost('deadline'),
            'file' => $fileName
        ];

        $this->tugasModel->where('kd_tugas', $kd_tugas)->set($tugasData)->update();

        return redirect()->to('guru/materitugas/tugas')->with('success', 'Tugas berhasil diperbarui');
    }

    public function downloadTugas($kd_tugas)
    {
        $nik_nip = session()->get('nik_nip');

        // Check if tugas exists and belongs to this guru
        $tugas = $this->tugasModel->where('kd_tugas', $kd_tugas)
            ->where('nik_nip', $nik_nip)
            ->first();

        if (!$tugas) {
            return redirect()->to('guru/materitugas/tugas')->with('error', 'Tugas tidak ditemukan');
        }

        if (!$tugas['file']) {
            return redirect()->to('guru/materitugas/tugas')->with('error', 'File tidak ditemukan');
        }

        $filePath = ROOTPATH . 'public/uploads/tugas/' . $tugas['file'];

        if (!file_exists($filePath)) {
            return redirect()->to('guru/materitugas/tugas')->with('error', 'File tidak ditemukan di server');
        }

        return $this->response->download($filePath, $tugas['file']);
    }

    public function detailPengumpulan($kd_tugas)
    {
        $nik_nip = session()->get('nik_nip');

        // Check if tugas exists and belongs to this guru
        $tugas = $this->tugasModel->where('kd_tugas', $kd_tugas)
            ->where('nik_nip', $nik_nip)
            ->first();

        if (!$tugas) {
            return redirect()->to('guru/materitugas/tugas')->with('error', 'Tugas tidak ditemukan');
        }

        // Get pengumpulan for this tugas
        $pengumpulan = $this->pengumpulanTugasModel->select('pengumpulan_tugas.*, siswa.nama as nama_siswa, siswa.nis')
            ->join('siswa', 'siswa.nis = pengumpulan_tugas.nis')
            ->where('pengumpulan_tugas.kd_tugas', $kd_tugas)
            ->findAll();

        $data = [
            'title' => 'Detail Pengumpulan Tugas',
            'tugas' => $tugas,
            'pengumpulan' => $pengumpulan
        ];

        return view('guru/materi_tugas/detail_pengumpulan', $data);
    }

    public function pengumpulan()
    {
        $nik_nip = session()->get('nik_nip');
        $kd_tugas = $this->request->getGet('kd_tugas');
        $kd_kelas = $this->request->getGet('kd_kelas');
        $kd_mapel = $this->request->getGet('kd_mapel');
        $status = $this->request->getGet('status');

        $builder = $this->pengumpulanTugasModel->select('pengumpulan_tugas.*, siswa.nama as nama_siswa, tugas.judul as judul_tugas, kelas.nama_kelas, mapel.nama_mapel')
            ->join('siswa', 'siswa.nis = pengumpulan_tugas.nis')
            ->join('tugas', 'tugas.kd_tugas = pengumpulan_tugas.kd_tugas')
            ->join('kelas', 'kelas.kd_kelas = tugas.kd_kelas')
            ->join('mapel', 'mapel.kd_mapel = tugas.kd_mapel')
            ->where('tugas.nik_nip', $nik_nip);

        if ($kd_tugas) {
            $builder->where('pengumpulan_tugas.kd_tugas', $kd_tugas);
        }

        if ($kd_kelas) {
            $builder->where('tugas.kd_kelas', $kd_kelas);
        }

        if ($kd_mapel) {
            $builder->where('tugas.kd_mapel', $kd_mapel);
        }

        if ($status) {
            $builder->where('pengumpulan_tugas.status', $status);
        }

        // Ambil data untuk dropdown
        $tugas_list = $this->tugasModel->where('nik_nip', $nik_nip)->findAll();
        $kelas_list = $this->kelasModel->where('wali_kelas_nik_nip', $nik_nip)->findAll();
        $mapel_list = $this->mapelModel->findAll();

        // Hitung statistik
        $total_tugas = $this->tugasModel->where('nik_nip', $nik_nip)->countAllResults();

        // Gunakan query builder terpisah untuk menghindari konflik alias
        $db = \Config\Database::connect();

        $dikumpulkan = $db->table('pengumpulan_tugas')
            ->select('COUNT(*) as total')
            ->join('tugas', 'tugas.kd_tugas = pengumpulan_tugas.kd_tugas')
            ->where('tugas.nik_nip', $nik_nip)
            ->where('pengumpulan_tugas.status', 'dikumpulkan')
            ->get()
            ->getRow()
            ->total ?? 0;

        $belum_dikumpulkan = $db->table('pengumpulan_tugas')
            ->select('COUNT(*) as total')
            ->join('tugas', 'tugas.kd_tugas = pengumpulan_tugas.kd_tugas')
            ->where('tugas.nik_nip', $nik_nip)
            ->where('pengumpulan_tugas.status', 'belum_dikumpulkan')
            ->get()
            ->getRow()
            ->total ?? 0;

        $terlambat = $db->table('pengumpulan_tugas')
            ->select('COUNT(*) as total')
            ->join('tugas', 'tugas.kd_tugas = pengumpulan_tugas.kd_tugas')
            ->where('tugas.nik_nip', $nik_nip)
            ->where('pengumpulan_tugas.status', 'terlambat')
            ->get()
            ->getRow()
            ->total ?? 0;

        $data = [
            'title' => 'Pengumpulan Tugas',
            'pengumpulan' => $builder->findAll(),
            'tugas_list' => $tugas_list,
            'kelas_list' => $kelas_list,
            'mapel_list' => $mapel_list,
            'selected_tugas' => $kd_tugas,
            'selected_kelas' => $kd_kelas,
            'selected_mapel' => $kd_mapel,
            'selected_status' => $status,
            'total_tugas' => $total_tugas,
            'dikumpulkan' => $dikumpulkan,
            'belum_dikumpulkan' => $belum_dikumpulkan,
            'terlambat' => $terlambat
        ];

        return view('guru/materi_tugas/pengumpulan', $data);
    }

    public function nilaiTugas($id)
    {
        $nilai = $this->request->getPost('nilai');
        $komentar = $this->request->getPost('komentar');

        $this->pengumpulanTugasModel->update($id, [
            'nilai' => $nilai,
            'komentar' => $komentar
        ]);

        return redirect()->to('guru/materi-tugas/pengumpulan')->with('success', 'Nilai tugas berhasil disimpan');
    }

    public function uploadMateri()
    {
        // Redirect ke form tambah materi dengan base_url
        return redirect()->to(base_url('guru/materitugas/materiCreate'));
    }

    public function uploadTugas()
    {
        // Redirect ke form tambah tugas
        return redirect()->to(base_url('guru/materitugas/tugasCreate'));
    }

    public function statistik()
    {
        $nik_nip = session()->get('nik_nip');
        // Statistik sederhana: jumlah materi, jumlah tugas, jumlah kelas diampu
        $total_materi = $this->materiModel->where('nik_nip', $nik_nip)->countAllResults();
        $total_tugas = $this->tugasModel->where('nik_nip', $nik_nip)->countAllResults();
        $kelas_diampu = $this->jadwalModel->select('DISTINCT(kd_kelas)')->where('nik_nip', $nik_nip)->countAllResults();
        $total_pengumpulan = $this->pengumpulanTugasModel->where('1=1')->countAllResults();
        $dikumpulkan = $this->pengumpulanTugasModel->where('status', 'dikumpulkan')->countAllResults();
        $data = [
            'title' => 'Statistik E-Learning',
            'total_materi' => $total_materi,
            'total_tugas' => $total_tugas,
            'kelas_diampu' => $kelas_diampu,
            'total_pengumpulan' => $total_pengumpulan,
            'dikumpulkan' => $dikumpulkan
        ];
        return view('guru/materi_tugas/statistik', $data);
    }
}
