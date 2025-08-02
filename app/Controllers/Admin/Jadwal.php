<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\GuruModel;
use App\Models\TahunAkademikModel;

class Jadwal extends BaseController
{
    protected $jadwalModel;
    protected $kelasModel;
    protected $mapelModel;
    protected $guruModel;
    protected $tahunAkademikModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->kelasModel = new KelasModel();
        $this->mapelModel = new MapelModel();
        $this->guruModel = new GuruModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
    }

    public function index()
    {
        $filter_kelas = $this->request->getGet('kd_kelas');
        $filters = [];
        if ($filter_kelas) {
            $filters['kd_kelas'] = $filter_kelas;
        }
        $jadwal = $this->jadwalModel->getJadwalWithRelations($filters);
        $data = [
            'title' => 'Data Jadwal',
            'jadwal' => $jadwal,
            'kelas' => $this->kelasModel->findAll(),
            'filter_kelas' => $filter_kelas,
            'mapel' => $this->mapelModel->findAll(),
            'guru' => $this->guruModel->findAll(),
            'tahun_akademik' => $this->tahunAkademikModel->findAll(),
        ];
        return view('admin/jadwal/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Jadwal',
            'kelas' => $this->kelasModel->findAll(),
            'mapel' => $this->mapelModel->findAll(),
            'guru' => $this->guruModel->findAll(),
            'tahun_akademik' => $this->tahunAkademikModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/jadwal/create', $data);
    }

    public function store()
    {
        // Validation rules
        $rules = [
            'kd_kelas' => 'required',
            'kd_mapel' => 'required',
            'nik_nip' => 'required',
            'tahun_akademik_id' => 'required|numeric',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $kd_kelas = $this->request->getPost('kd_kelas');
        $kd_mapel = $this->request->getPost('kd_mapel');
        $nik_nip = $this->request->getPost('nik_nip');
        $hari = $this->request->getPost('hari');
        $jam_mulai = $this->request->getPost('jam_mulai');

        // Check for schedule conflict
        $existingJadwal = $this->jadwalModel->where([
            'kd_kelas' => $kd_kelas,
            'hari' => $hari,
            'jam_mulai' => $jam_mulai
        ])->first();

        if ($existingJadwal) {
            return redirect()->back()->withInput()->with('error', 'Jadwal sudah ada untuk kelas, hari, dan jam tersebut');
        }

        $jadwalData = [
            'kd_kelas' => $kd_kelas,
            'kd_mapel' => $kd_mapel,
            'nik_nip' => $nik_nip,
            'tahun_akademik_id' => $this->request->getPost('tahun_akademik_id'),
            'hari' => $hari,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $this->request->getPost('jam_selesai')
        ];

        $this->jadwalModel->insert($jadwalData);

        return redirect()->to('admin/jadwal')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Jadwal',
            'jadwal' => $this->jadwalModel->find($id),
            'kelas' => $this->kelasModel->findAll(),
            'mapel' => $this->mapelModel->findAll(),
            'guru' => $this->guruModel->findAll(),
            'tahun_akademik' => $this->tahunAkademikModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/jadwal/edit', $data);
    }

    public function update($id)
    {
        // Validation rules
        $rules = [
            'kd_kelas' => 'required',
            'kd_mapel' => 'required',
            'nik_nip' => 'required',
            'tahun_akademik_id' => 'required|numeric',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $jadwalData = [
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'kd_mapel' => $this->request->getPost('kd_mapel'),
            'nik_nip' => $this->request->getPost('nik_nip'),
            'tahun_akademik_id' => $this->request->getPost('tahun_akademik_id'),
            'hari' => $this->request->getPost('hari'),
            'jam_mulai' => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai')
        ];

        $this->jadwalModel->update($id, $jadwalData);

        return redirect()->to('admin/jadwal')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->jadwalModel->delete($id);
        return redirect()->to('admin/jadwal')->with('success', 'Jadwal berhasil dihapus');
    }
}
