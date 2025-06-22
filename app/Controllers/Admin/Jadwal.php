<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\GuruModel;
use App\Models\TahunAkademikModel;
use App\Models\UserModel;
use App\Models\PertemuanModel;

class Jadwal extends BaseController
{
    protected $jadwalModel;
    protected $kelasModel;
    protected $mapelModel;
    protected $guruModel;
    protected $tahunAkademikModel;
    protected $userModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->kelasModel = new KelasModel();
        $this->mapelModel = new MapelModel();
        $this->guruModel = new GuruModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $user = $this->userModel->find(session()->get('user_id'));
        $data = [
            'title' => 'Jadwal Pelajaran',
            'user' => $user,
            'jadwal' => $this->jadwalModel->getJadwalWithRelations(),
            'kelas' => $this->kelasModel->findAll(),
            'mapel' => $this->mapelModel->findAll(),
            'guru' => $this->guruModel->findAll(),
            'tahun_akademik' => $this->tahunAkademikModel->findAll()
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
            'tahun_akademik' => $this->tahunAkademikModel->findAll()
        ];

        return view('admin/jadwal/create', $data);
    }

    public function store()
    {
        $rules = [
            'kelas_id' => 'required',
            'mapel_id' => 'required',
            'guru_id' => 'required',
            'tahun_akademik_id' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Cek bentrok jadwal
        $bentrok = $this->jadwalModel->where([
            'kelas_id' => $this->request->getPost('kelas_id'),
            'hari' => $this->request->getPost('hari'),
            'tahun_akademik_id' => $this->request->getPost('tahun_akademik_id')
        ])->where("(jam_mulai BETWEEN '{$this->request->getPost('jam_mulai')}' AND '{$this->request->getPost('jam_selesai')}') OR (jam_selesai BETWEEN '{$this->request->getPost('jam_mulai')}' AND '{$this->request->getPost('jam_selesai')}')")->first();

        if ($bentrok) {
            return redirect()->back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal yang sudah ada');
        }

        $this->jadwalModel->insert([
            'kelas_id' => $this->request->getPost('kelas_id'),
            'mapel_id' => $this->request->getPost('mapel_id'),
            'guru_id' => $this->request->getPost('guru_id'),
            'tahun_akademik_id' => $this->request->getPost('tahun_akademik_id'),
            'hari' => $this->request->getPost('hari'),
            'jam_mulai' => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai')
        ]);

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
            'tahun_akademik' => $this->tahunAkademikModel->findAll()
        ];

        return view('admin/jadwal/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'kelas_id' => 'required',
            'mapel_id' => 'required',
            'guru_id' => 'required',
            'tahun_akademik_id' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Cek bentrok jadwal
        $bentrok = $this->jadwalModel->where([
            'kelas_id' => $this->request->getPost('kelas_id'),
            'hari' => $this->request->getPost('hari'),
            'tahun_akademik_id' => $this->request->getPost('tahun_akademik_id'),
            'id !=' => $id
        ])->where("(jam_mulai BETWEEN '{$this->request->getPost('jam_mulai')}' AND '{$this->request->getPost('jam_selesai')}') OR (jam_selesai BETWEEN '{$this->request->getPost('jam_mulai')}' AND '{$this->request->getPost('jam_selesai')}')")->first();

        if ($bentrok) {
            return redirect()->back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal yang sudah ada');
        }

        $this->jadwalModel->update($id, [
            'kelas_id' => $this->request->getPost('kelas_id'),
            'mapel_id' => $this->request->getPost('mapel_id'),
            'guru_id' => $this->request->getPost('guru_id'),
            'tahun_akademik_id' => $this->request->getPost('tahun_akademik_id'),
            'hari' => $this->request->getPost('hari'),
            'jam_mulai' => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai')
        ]);

        return redirect()->to('admin/jadwal')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->jadwalModel->delete($id);
        return redirect()->to('admin/jadwal')->with('success', 'Jadwal berhasil dihapus');
    }

    public function cetak()
    {
        $kelas_id = $this->request->getGet('kelas_id');
        $jadwalModel = new \App\Models\JadwalModel();
        $kelasModel = new \App\Models\KelasModel();
        $kelas = $kelasModel->find($kelas_id);
        $jadwal = [];
        if ($kelas_id) {
            $jadwal = $jadwalModel->select('jadwal.*, mapel.nama_mapel, guru.nama as nama_guru, tahun_akademik.tahun, tahun_akademik.semester, kelas.nama_kelas')
                ->join('mapel', 'mapel.id = jadwal.mapel_id')
                ->join('guru', 'guru.id = jadwal.guru_id')
                ->join('tahun_akademik', 'tahun_akademik.id = jadwal.tahun_akademik_id')
                ->join('kelas', 'kelas.id = jadwal.kelas_id')
                ->where('jadwal.kelas_id', $kelas_id)
                ->orderBy('jadwal.hari, jadwal.jam_mulai', 'ASC')
                ->findAll();
        }
        return view('admin/jadwal/cetak_jadwal', [
            'title' => 'Cetak Jadwal Pelajaran',
            'kelas' => $kelas,
            'jadwal' => $jadwal
        ]);
    }

    public function generatePertemuanOtomatis()
    {
        $kelas_id = $this->request->getPost('kelas_id');
        $mapel_id = $this->request->getPost('mapel_id');
        $hari = $this->request->getPost('hari');
        $tanggal_mulai = $this->request->getPost('tanggal_mulai');
        $jumlah = (int)$this->request->getPost('jumlah');
        $pertemuanModel = new PertemuanModel();

        $hari_map = [
            'Minggu' => 0, 'Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6
        ];
        $target_dow = $hari_map[$hari];
        $start_dow = date('w', strtotime($tanggal_mulai));
        $selisih = ($target_dow - $start_dow + 7) % 7;
        $tanggal = date('Y-m-d', strtotime("$tanggal_mulai +$selisih day"));

        for ($i=1; $i<=$jumlah; $i++) {
            $pertemuanModel->insert([
                'kelas_id' => $kelas_id,
                'mapel_id' => $mapel_id,
                'nama_pertemuan' => 'Pertemuan ke-'.$i,
                'tanggal' => $tanggal,
                'topik' => '',
            ]);
            $tanggal = date('Y-m-d', strtotime("$tanggal +7 day"));
        }
        return redirect()->to('admin/jadwal')->with('success', 'Pertemuan berhasil digenerate otomatis');
    }
} 