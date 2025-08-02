<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\GuruModel;
use App\Models\SiswaModel;
use App\Models\WaliKelasModel;

class WaliKelas extends BaseController
{
    protected $kelasModel;
    protected $guruModel;
    protected $siswaModel;
    protected $waliKelasModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->guruModel = new GuruModel();
        $this->siswaModel = new SiswaModel();
        $this->waliKelasModel = new WaliKelasModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Wali Kelas',
            'wali_kelas' => $this->waliKelasModel->getWaliKelasWithRelations()
        ];

        return view('admin/wali_kelas/index', $data);
    }

    public function assign()
    {
        $kd_kelas = $this->request->getPost('kd_kelas');
        $nik_nip = $this->request->getPost('nik_nip');

        if (!$kd_kelas || !$nik_nip) {
            return redirect()->back()->with('error', 'Data tidak lengkap');
        }

        // Update wali kelas
        $this->kelasModel->update($kd_kelas, [
            'wali_kelas_id' => $nik_nip
        ]);

        return redirect()->to('admin/wali-kelas')->with('success', 'Wali kelas berhasil ditugaskan');
    }

    public function remove($kdKelas)
    {
        $this->kelasModel->update($kdKelas, [
            'wali_kelas_id' => null
        ]);

        return redirect()->to('admin/wali-kelas')->with('success', 'Wali kelas berhasil dihapus');
    }

    public function detail($kdKelas)
    {
        $kelas = $this->kelasModel->find($kdKelas);
        $wali_kelas = null;
        $siswa_list = [];

        if ($kelas) {
            if ($kelas['wali_kelas_id']) {
                $wali_kelas = $this->guruModel->find($kelas['wali_kelas_id']);
            }

            $siswa_list = $this->siswaModel->where('kd_kelas', $kdKelas)->findAll();
        }

        $data = [
            'title' => 'Detail Wali Kelas',
            'kelas' => $kelas,
            'wali_kelas' => $wali_kelas,
            'siswa_list' => $siswa_list
        ];

        return view('admin/wali_kelas/detail', $data);
    }

    public function create()
    {
        $tahunAkademikModel = new \App\Models\TahunAkademikModel();
        $data = [
            'title' => 'Tambah Wali Kelas',
            'tahun_akademik' => $tahunAkademikModel->findAll(),
            'kelas' => $this->kelasModel->findAll(),
            'guru' => $this->guruModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/wali_kelas/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'kd_kelas' => 'required',
            'nik_nip' => 'required',
            'kd_tahun_akademik' => 'required',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }
        $data = [
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'nik_nip' => $this->request->getPost('nik_nip'),
            'kd_tahun_akademik' => $this->request->getPost('kd_tahun_akademik'),
        ];
        try {
            $this->waliKelasModel->insert($data);
            return redirect()->to('/admin/wali_kelas')->with('success', 'Data wali kelas berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambah data wali kelas: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        // Hapus data wali kelas berdasarkan id
        $this->waliKelasModel->delete($id);
        return redirect()->to('/admin/wali_kelas')->with('success', 'Data wali kelas berhasil dihapus');
    }
}
