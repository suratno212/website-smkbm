<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\MateriModel;
use App\Models\TugasModel;
use App\Models\PengumpulanTugasModel;
use App\Models\SiswaModel;
use DateTime;

class MateriTugas extends BaseController
{
    protected $materiModel;
    protected $tugasModel;
    protected $pengumpulanTugasModel;
    protected $siswaModel;

    public function __construct()
    {
        $this->materiModel = new MateriModel();
        $this->tugasModel = new TugasModel();
        $this->pengumpulanTugasModel = new PengumpulanTugasModel();
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        log_message('debug', 'SESSION: ' . json_encode(session()->get()));
        $nis = session()->get('nis');
        $siswa = $this->siswaModel->find($nis);

        if (!$siswa) {
            return redirect()->to('auth/logout')->with('error', 'Data siswa tidak ditemukan');
        }

        // Debug: Check if kd_kelas exists
        if (!isset($siswa['kd_kelas']) || empty($siswa['kd_kelas'])) {
            return redirect()->to('auth/logout')->with('error', 'Data kelas siswa tidak ditemukan. Silakan hubungi admin.');
        }

        // Get materials for student's class
        $materi = $this->materiModel->select('materi.*, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('mapel', 'mapel.kd_mapel = materi.kd_mapel')
            ->join('guru', 'guru.nik_nip = materi.nik_nip')
            ->where('materi.kd_kelas', $siswa['kd_kelas'])
            ->orderBy('materi.created_at', 'DESC')
            ->findAll();

        // Get assignments for student's class
        $tugas = $this->tugasModel->select('tugas.*, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('mapel', 'mapel.kd_mapel = tugas.kd_mapel')
            ->join('guru', 'guru.nik_nip = tugas.nik_nip')
            ->where('tugas.kd_kelas', $siswa['kd_kelas'])
            ->orderBy('tugas.deadline', 'ASC')
            ->findAll();

        // Get submission status for each assignment
        foreach ($tugas as &$t) {
            $pengumpulan = $this->pengumpulanTugasModel->where([
                'kd_tugas' => $t['kd_tugas'],
                'nis' => $nis
            ])->first();

            $t['pengumpulan'] = $pengumpulan;
            $t['status_pengumpulan'] = $pengumpulan ? $pengumpulan['status'] : 'belum_dikumpulkan';
            $t['nilai'] = $pengumpulan ? $pengumpulan['nilai'] : null;
            $t['catatan'] = $pengumpulan ? $pengumpulan['catatan'] : null;
            $t['terlambat'] = $pengumpulan && strtotime($pengumpulan['created_at']) > strtotime($t['deadline']);
        }

        $data = [
            'title' => 'Materi & Tugas',
            'siswa' => $siswa,
            'materi' => $materi,
            'tugas' => $tugas
        ];

        return view('siswa/materi_tugas/index', $data);
    }

    public function materi()
    {
        $nis = session()->get('nis');
        $siswa = $this->siswaModel->find($nis);

        if (!$siswa) {
            return redirect()->to('auth/logout')->with('error', 'Data siswa tidak ditemukan');
        }

        // Debug: Check if kd_kelas exists
        if (!isset($siswa['kd_kelas']) || empty($siswa['kd_kelas'])) {
            return redirect()->to('auth/logout')->with('error', 'Data kelas siswa tidak ditemukan. Silakan hubungi admin.');
        }

        // Get materials for student's class
        $materi = $this->materiModel->select('materi.*, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('mapel', 'mapel.kd_mapel = materi.kd_mapel')
            ->join('guru', 'guru.nik_nip = materi.nik_nip')
            ->where('materi.kd_kelas', $siswa['kd_kelas'])
            ->orderBy('materi.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Materi Pembelajaran',
            'siswa' => $siswa,
            'materi' => $materi
        ];

        return view('siswa/materi_tugas/materi', $data);
    }

    public function downloadMateri($kd_materi)
    {
        $materi = $this->materiModel->where('kd_materi', $kd_materi)->first();

        if (!$materi) {
            return redirect()->back()->with('error', 'Materi tidak ditemukan');
        }

        if (!$materi['file']) {
            return redirect()->back()->with('error', 'File materi tidak tersedia');
        }

        $filePath = ROOTPATH . 'public/uploads/materi/' . $materi['file'];

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        return $this->response->download($filePath, $materi['judul'] . '.' . pathinfo($materi['file'], PATHINFO_EXTENSION));
    }

    public function tugas()
    {
        $nis = session()->get('nis');
        $siswa = $this->siswaModel->find($nis);

        if (!$siswa) {
            return redirect()->to('auth/logout')->with('error', 'Data siswa tidak ditemukan');
        }

        // Debug: Check if kd_kelas exists
        if (!isset($siswa['kd_kelas']) || empty($siswa['kd_kelas'])) {
            return redirect()->to('auth/logout')->with('error', 'Data kelas siswa tidak ditemukan. Silakan hubungi admin.');
        }

        // Get assignments for student's class
        $tugas = $this->tugasModel->select('tugas.*, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('mapel', 'mapel.kd_mapel = tugas.kd_mapel')
            ->join('guru', 'guru.nik_nip = tugas.nik_nip')
            ->where('tugas.kd_kelas', $siswa['kd_kelas'])
            ->orderBy('tugas.deadline', 'ASC')
            ->findAll();

        // Get submission status for each assignment
        foreach ($tugas as &$t) {
            $pengumpulan = $this->pengumpulanTugasModel->where([
                'kd_tugas' => $t['kd_tugas'],
                'nis' => $nis
            ])->first();

            $t['pengumpulan'] = $pengumpulan;
            $t['status_pengumpulan'] = $pengumpulan ? $pengumpulan['status'] : 'belum_dikumpulkan';
            $t['nilai'] = $pengumpulan ? $pengumpulan['nilai'] : null;
            $t['catatan'] = $pengumpulan ? $pengumpulan['catatan'] : null;
            $t['terlambat'] = $pengumpulan && strtotime($pengumpulan['created_at']) > strtotime($t['deadline']);
        }

        $data = [
            'title' => 'Tugas',
            'siswa' => $siswa,
            'tugas' => $tugas
        ];

        return view('siswa/materi_tugas/tugas', $data);
    }

    public function submitTugas()
    {
        $nis = session()->get('nis');
        $kd_tugas = $this->request->getPost('kd_tugas');

        // Validation rules
        $rules = [
            'kd_tugas' => 'required',
            'file_tugas' => 'uploaded[file_tugas]|max_size[file_tugas,10240]|ext_in[file_tugas,pdf,doc,docx,zip,rar]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Check if already submitted
        $existing = $this->pengumpulanTugasModel->where([
            'kd_tugas' => $kd_tugas,
            'nis' => $nis
        ])->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Tugas sudah dikumpulkan');
        }

        $file = $this->request->getFile('file_tugas');
        $fileName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/tugas', $fileName);

        // Generate kd_pengumpulan
        $kd_pengumpulan = $this->generateKdPengumpulan($kd_tugas, $nis);

        $pengumpulanData = [
            'kd_pengumpulan' => $kd_pengumpulan,
            'kd_tugas' => $kd_tugas,
            'nis' => $nis,
            'file_tugas' => $fileName,
            'status' => 'dikumpulkan',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->pengumpulanTugasModel->insert($pengumpulanData);

        return redirect()->to('siswa/materitugas/tugas')->with('success', 'Tugas berhasil dikumpulkan');
    }

    public function updateTugas($id)
    {
        $nis = session()->get('nis');
        $pengumpulan = $this->pengumpulanTugasModel->find($id);

        if (!$pengumpulan || $pengumpulan['nis'] != $nis) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Validation rules
        $rules = [
            'file_tugas' => 'uploaded[file_tugas]|max_size[file_tugas,10240]|ext_in[file_tugas,pdf,doc,docx,zip,rar]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Delete old file
        if (file_exists(ROOTPATH . 'public/uploads/tugas/' . $pengumpulan['file_tugas'])) {
            unlink(ROOTPATH . 'public/uploads/tugas/' . $pengumpulan['file_tugas']);
        }

        $file = $this->request->getFile('file_tugas');
        $fileName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/tugas', $fileName);

        $this->pengumpulanTugasModel->update($id, [
            'file_tugas' => $fileName,
            'status' => 'Diperbarui'
        ]);

        return redirect()->to('siswa/materi-tugas/tugas')->with('success', 'Tugas berhasil diperbarui');
    }

    public function detailTugas($kd_tugas)
    {
        $nis = session()->get('nis');
        $siswa = $this->siswaModel->find($nis);

        if (!$siswa) {
            return redirect()->to('auth/logout')->with('error', 'Data siswa tidak ditemukan');
        }

        // Debug: Check if kd_kelas exists
        if (!isset($siswa['kd_kelas']) || empty($siswa['kd_kelas'])) {
            return redirect()->to('auth/logout')->with('error', 'Data kelas siswa tidak ditemukan. Silakan hubungi admin.');
        }

        // Get assignment details
        $tugas = $this->tugasModel->select('tugas.*, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('mapel', 'mapel.kd_mapel = tugas.kd_mapel')
            ->join('guru', 'guru.nik_nip = tugas.nik_nip')
            ->where('tugas.kd_tugas', $kd_tugas)
            ->where('tugas.kd_kelas', $siswa['kd_kelas'])
            ->first();

        if (!$tugas) {
            return redirect()->to('siswa/materi-tugas/tugas')->with('error', 'Tugas tidak ditemukan');
        }

        // Get submission status
        $pengumpulan = $this->pengumpulanTugasModel->where([
            'kd_tugas' => $kd_tugas,
            'nis' => $nis
        ])->first();

        $data = [
            'title' => 'Detail Tugas',
            'siswa' => $siswa,
            'tugas' => $tugas,
            'pengumpulan' => $pengumpulan
        ];

        return view('siswa/materi_tugas/upload_tugas', $data);
    }

    public function downloadTugas($kd_tugas)
    {
        $tugas = $this->tugasModel->where('kd_tugas', $kd_tugas)->first();

        if (!$tugas) {
            return redirect()->back()->with('error', 'Tugas tidak ditemukan');
        }

        if (!$tugas['file']) {
            return redirect()->back()->with('error', 'File tugas tidak tersedia');
        }

        $filePath = ROOTPATH . 'public/uploads/tugas/' . $tugas['file'];

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        return $this->response->download($filePath, $tugas['judul'] . '.' . pathinfo($tugas['file'], PATHINFO_EXTENSION));
    }

    public function uploadTugas($kd_tugas)
    {
        $nis = session()->get('nis');
        $siswa = $this->siswaModel->find($nis);

        if (!$siswa) {
            return redirect()->to('auth/logout')->with('error', 'Data siswa tidak ditemukan');
        }

        // Debug: Check if kd_kelas exists
        if (!isset($siswa['kd_kelas']) || empty($siswa['kd_kelas'])) {
            return redirect()->to('auth/logout')->with('error', 'Data kelas siswa tidak ditemukan. Silakan hubungi admin.');
        }

        // Get assignment details
        $tugas = $this->tugasModel->select('tugas.*, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('mapel', 'mapel.kd_mapel = tugas.kd_mapel')
            ->join('guru', 'guru.nik_nip = tugas.nik_nip')
            ->where('tugas.kd_tugas', $kd_tugas)
            ->where('tugas.kd_kelas', $siswa['kd_kelas'])
            ->first();

        if (!$tugas) {
            return redirect()->to('siswa/materitugas/tugas')->with('error', 'Tugas tidak ditemukan');
        }

        // Check if already submitted
        $pengumpulan = $this->pengumpulanTugasModel->where([
            'kd_tugas' => $kd_tugas,
            'nis' => $nis
        ])->first();

        if ($pengumpulan) {
            return redirect()->to('siswa/materitugas/detailTugas/' . $kd_tugas)->with('error', 'Tugas sudah dikumpulkan');
        }

        // Check if deadline has passed
        $deadline = new DateTime($tugas['deadline']);
        $now = new DateTime();
        if ($deadline < $now) {
            return redirect()->to('siswa/materitugas/detailTugas/' . $kd_tugas)->with('error', 'Deadline tugas sudah lewat');
        }

        // Handle POST request (form submission)
        if ($this->request->getMethod() === 'post') {
            // Debug: Log the request
            log_message('info', '=== UPLOAD TUGAS POST REQUEST ===');
            log_message('info', 'kd_tugas: ' . $kd_tugas);
            log_message('info', 'nis: ' . $nis);
            log_message('info', 'POST data: ' . json_encode($this->request->getPost()));
            log_message('info', 'Files count: ' . count($this->request->getFiles()));
            log_message('info', 'Request method: ' . $this->request->getMethod());
            log_message('info', 'Request URI: ' . $this->request->getUri());

            foreach ($this->request->getFiles() as $key => $file) {
                log_message('info', "File $key: " . json_encode($file));
            }

            // Validation rules
            $rules = [
                'file_tugas' => 'uploaded[file_tugas]|max_size[file_tugas,10240]|ext_in[file_tugas,pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar]'
            ];

            if (!$this->validate($rules)) {
                log_message('error', 'Validation failed: ' . json_encode($this->validator->getErrors()));
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $file = $this->request->getFile('file_tugas');
            $catatan = $this->request->getPost('catatan');

            // Debug: Log file info
            log_message('info', 'File info: ' . json_encode([
                'name' => $file->getName(),
                'size' => $file->getSize(),
                'type' => $file->getClientMimeType(),
                'extension' => $file->getExtension()
            ]));

            // Generate unique filename
            $fileName = $file->getRandomName();
            log_message('info', 'Generated filename: ' . $fileName);

            // Move file to uploads directory
            if ($file->move(ROOTPATH . 'public/uploads/tugas', $fileName)) {
                // Generate kd_pengumpulan
                $kd_pengumpulan = $this->generateKdPengumpulan($kd_tugas, $nis);

                $pengumpulanData = [
                    'kd_pengumpulan' => $kd_pengumpulan,
                    'kd_tugas' => $kd_tugas,
                    'nis' => $nis,
                    'file_tugas' => $fileName,
                    'catatan' => $catatan,
                    'status' => 'dikumpulkan',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                try {
                    log_message('info', 'Inserting pengumpulan data: ' . json_encode($pengumpulanData));
                    $this->pengumpulanTugasModel->insert($pengumpulanData);
                    log_message('info', 'Pengumpulan tugas berhasil disimpan');
                    return redirect()->to('siswa/materitugas/tugas')->with('success', 'Tugas berhasil dikumpulkan');
                } catch (\Exception $e) {
                    // Log error
                    log_message('error', 'Error inserting pengumpulan tugas: ' . $e->getMessage());
                    log_message('error', 'Error trace: ' . $e->getTraceAsString());
                    return redirect()->back()->with('error', 'Gagal menyimpan tugas. Silakan coba lagi.');
                }
            } else {
                return redirect()->back()->with('error', 'Gagal mengupload file. Silakan coba lagi.');
            }
        }

        $data = [
            'title' => 'Upload Tugas',
            'siswa' => $siswa,
            'tugas' => $tugas
        ];

        return view('siswa/materi_tugas/upload_tugas', $data);
    }

    private function generateKdPengumpulan($kd_tugas, $nis)
    {
        // Format: PGM + 3 digit urutan
        $lastPengumpulan = $this->pengumpulanTugasModel
            ->select('kd_pengumpulan')
            ->like('kd_pengumpulan', 'PGM', 'after')
            ->orderBy('kd_pengumpulan', 'DESC')
            ->first();

        if ($lastPengumpulan) {
            $lastNumber = intval(substr($lastPengumpulan['kd_pengumpulan'], 3));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'PGM' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
