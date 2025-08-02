<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MateriModel;
use App\Models\TugasModel;
use App\Models\PengumpulanTugasModel;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\MapelModel;

class MateriTugas extends BaseController
{
    protected $materiModel;
    protected $tugasModel;
    protected $pengumpulanTugasModel;
    protected $guruModel;
    protected $kelasModel;
    protected $mapelModel;

    public function __construct()
    {
        $this->materiModel = new MateriModel();
        $this->tugasModel = new TugasModel();
        $this->pengumpulanTugasModel = new PengumpulanTugasModel();
        $this->guruModel = new GuruModel();
        $this->kelasModel = new KelasModel();
        $this->mapelModel = new MapelModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Materi & Tugas',
            'materi_count' => $this->materiModel->countAllResults(),
            'tugas_count' => $this->tugasModel->countAllResults(),
            'pengumpulan_count' => $this->pengumpulanTugasModel->countAllResults()
        ];

        return view('admin/materi_tugas/index', $data);
    }

    public function materi()
    {
        $filters = [
            'kd_kelas' => $this->request->getGet('kd_kelas'),
            'kd_mapel' => $this->request->getGet('kd_mapel'),
            'nik_nip' => $this->request->getGet('nik_nip')
        ];

        $builder = $this->materiModel->select('materi.*, mapel.nama_mapel, kelas.nama_kelas, guru.nama as nama_guru')
            ->join('mapel', 'mapel.kd_mapel = materi.kd_mapel')
            ->join('kelas', 'kelas.kd_kelas = materi.kd_kelas')
            ->join('guru', 'guru.nik_nip = materi.nik_nip');

        if ($filters['kd_kelas']) {
            $builder->where('materi.kd_kelas', $filters['kd_kelas']);
        }

        if ($filters['kd_mapel']) {
            $builder->where('materi.kd_mapel', $filters['kd_mapel']);
        }

        if ($filters['nik_nip']) {
            $builder->where('materi.nik_nip', $filters['nik_nip']);
        }

        $data = [
            'title' => 'Data Materi',
            'materi' => $builder->findAll(),
            'kelas' => $this->kelasModel->findAll(),
            'mapel' => $this->mapelModel->findAll(),
            'guru' => $this->guruModel->findAll(),
            'filters' => $filters
        ];

        return view('admin/materi_tugas/materi', $data);
    }

    public function materiCreate()
    {
        $data = [
            'title' => 'Tambah Materi',
            'kelas' => $this->kelasModel->findAll(),
            'mapel' => $this->mapelModel->findAll(),
            'guru' => $this->guruModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/materi_tugas/materi_create', $data);
    }

    public function materiStore()
    {
        // Validation rules
        $rules = [
            'nik_nip' => 'required',
            'kd_kelas' => 'required',
            'kd_mapel' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'file' => 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf,doc,docx,ppt,pptx]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/materi', $fileName);

        $materiData = [
            'nik_nip' => $this->request->getPost('nik_nip'),
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'kd_mapel' => $this->request->getPost('kd_mapel'),
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file' => $fileName
        ];

        $this->materiModel->insert($materiData);

        return redirect()->to('admin/materi-tugas/materi')->with('success', 'Materi berhasil ditambahkan');
    }

    public function materiDelete($id)
    {
        $materi = $this->materiModel->find($id);
        if ($materi) {
            // Delete file
            if (file_exists(ROOTPATH . 'public/uploads/materi/' . $materi['file'])) {
                unlink(ROOTPATH . 'public/uploads/materi/' . $materi['file']);
            }
            $this->materiModel->delete($id);
        }

        return redirect()->to('admin/materi-tugas/materi')->with('success', 'Materi berhasil dihapus');
    }

    public function tugas()
    {
        $filters = [
            'kd_kelas' => $this->request->getGet('kd_kelas'),
            'kd_mapel' => $this->request->getGet('kd_mapel'),
            'nik_nip' => $this->request->getGet('nik_nip')
        ];

        $builder = $this->tugasModel->select('tugas.*, mapel.nama_mapel, kelas.nama_kelas, guru.nama as nama_guru')
            ->join('mapel', 'mapel.kd_mapel = tugas.kd_mapel')
            ->join('kelas', 'kelas.kd_kelas = tugas.kd_kelas')
            ->join('guru', 'guru.nik_nip = tugas.nik_nip');

        if ($filters['kd_kelas']) {
            $builder->where('tugas.kd_kelas', $filters['kd_kelas']);
        }

        if ($filters['kd_mapel']) {
            $builder->where('tugas.kd_mapel', $filters['kd_mapel']);
        }

        if ($filters['nik_nip']) {
            $builder->where('tugas.nik_nip', $filters['nik_nip']);
        }

        $data = [
            'title' => 'Data Tugas',
            'tugas' => $builder->findAll(),
            'kelas' => $this->kelasModel->findAll(),
            'mapel' => $this->mapelModel->findAll(),
            'guru' => $this->guruModel->findAll(),
            'filters' => $filters
        ];

        return view('admin/materi_tugas/tugas', $data);
    }

    public function tugasCreate()
    {
        $data = [
            'title' => 'Tambah Tugas',
            'kelas' => $this->kelasModel->findAll(),
            'mapel' => $this->mapelModel->findAll(),
            'guru' => $this->guruModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/materi_tugas/tugas_create', $data);
    }

    public function tugasStore()
    {
        // Validation rules
        $rules = [
            'nik_nip' => 'required',
            'kd_kelas' => 'required',
            'kd_mapel' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'deadline' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tugasData = [
            'nik_nip' => $this->request->getPost('nik_nip'),
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'kd_mapel' => $this->request->getPost('kd_mapel'),
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'deadline' => $this->request->getPost('deadline')
        ];

        $this->tugasModel->insert($tugasData);

        return redirect()->to('admin/materi-tugas/tugas')->with('success', 'Tugas berhasil ditambahkan');
    }

    public function tugasDelete($id)
    {
        $this->tugasModel->delete($id);
        return redirect()->to('admin/materi-tugas/tugas')->with('success', 'Tugas berhasil dihapus');
    }

    public function pengumpulan()
    {
        $filters = [
            'kd_tugas' => $this->request->getGet('kd_tugas'),
            'status' => $this->request->getGet('status')
        ];

        $builder = $this->pengumpulanTugasModel->select('pengumpulan_tugas.*, siswa.nama as nama_siswa, tugas.judul as judul_tugas, mapel.nama_mapel')
            ->join('siswa', 'siswa.nis = pengumpulan_tugas.nis')
            ->join('tugas', 'tugas.kd_tugas = pengumpulan_tugas.kd_tugas')
            ->join('mapel', 'mapel.kd_mapel = tugas.kd_mapel');

        if ($filters['kd_tugas']) {
            $builder->where('pengumpulan_tugas.kd_tugas', $filters['kd_tugas']);
        }

        if ($filters['status']) {
            $builder->where('pengumpulan_tugas.status', $filters['status']);
        }

        $data = [
            'title' => 'Pengumpulan Tugas',
            'pengumpulan' => $builder->findAll(),
            'tugas' => $this->tugasModel->findAll(),
            'filters' => $filters
        ];

        return view('admin/materi_tugas/pengumpulan', $data);
    }

    public function nilaiTugas($id)
    {
        $nilai = $this->request->getPost('nilai');
        $komentar = $this->request->getPost('komentar');

        $this->pengumpulanTugasModel->update($id, [
            'nilai' => $nilai,
            'komentar' => $komentar
        ]);

        return redirect()->to('admin/materi-tugas/pengumpulan')->with('success', 'Nilai tugas berhasil disimpan');
    }
}
