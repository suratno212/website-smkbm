<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\JurusanModel;
use App\Models\GuruModel;
use App\Models\WaliKelasModel;

class Kelas extends BaseController
{
    protected $kelasModel;
    protected $jurusanModel;
    protected $guruModel;
    protected $waliKelasModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->jurusanModel = new JurusanModel();
        $this->guruModel = new GuruModel();
        $this->waliKelasModel = new WaliKelasModel();
    }

    public function index()
    {
        $filter_jurusan = $this->request->getGet('kd_jurusan');

        $builder = $this->kelasModel->getKelasWithJurusan();

        if ($filter_jurusan) {
            $builder->where('kelas.kd_jurusan', $filter_jurusan);
        }

        $data = [
            'title' => 'Data Kelas',
            'kelas' => $builder,
            'jurusan' => $this->jurusanModel->findAll(),
            'filter_jurusan' => $filter_jurusan
        ];

        return view('admin/kelas/index', $data);
    }

    public function create()
    {
        $wali_kelas = $this->waliKelasModel->select('guru.nik_nip, guru.nama')
            ->join('guru', 'guru.nik_nip = wali_kelas.nik_nip')
            ->groupBy('guru.nik_nip')
            ->findAll();
        $data = [
            'title' => 'Tambah Kelas',
            'jurusan' => $this->jurusanModel->findAll(),
            'wali_kelas' => $wali_kelas,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/kelas/create', $data);
    }

    public function store()
    {
        // Validation rules
        $rules = [
            'kd_kelas' => 'required|is_unique[kelas.kd_kelas]',
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'kd_jurusan' => 'required',
            'kuota' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $kelasData = [
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'tingkat' => $this->request->getPost('tingkat'),
            'kd_jurusan' => $this->request->getPost('kd_jurusan'),
            'kuota' => $this->request->getPost('kuota')
        ];

        $this->kelasModel->insert($kelasData);

        return redirect()->to('admin/kelas')->with('success', 'Data kelas berhasil ditambahkan');
    }

    public function edit($kdKelas)
    {
        $data = [
            'title' => 'Edit Kelas',
            'kelas' => $this->kelasModel->find($kdKelas),
            'jurusan' => $this->jurusanModel->findAll(),
            'guru' => $this->guruModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/kelas/edit', $data);
    }

    public function update($kdKelas)
    {
        // Validation rules
        $rules = [
            'kd_kelas' => "required|is_unique[kelas.kd_kelas,kd_kelas,$kdKelas]",
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'kd_jurusan' => 'required',
            'kuota' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kelasModel->update($kdKelas, [
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'tingkat' => $this->request->getPost('tingkat'),
            'kd_jurusan' => $this->request->getPost('kd_jurusan'),
            'kuota' => $this->request->getPost('kuota')
        ]);

        return redirect()->to('admin/kelas')->with('success', 'Data kelas berhasil diperbarui');
    }

    public function delete($kdKelas)
    {
        $this->kelasModel->delete($kdKelas);
        return redirect()->to('admin/kelas')->with('success', 'Data kelas berhasil dihapus');
    }

    public function bulkDelete()
    {
        $kdKelass = $this->request->getPost('ids');
        if ($kdKelass && is_array($kdKelass)) {
            $this->kelasModel->whereIn('kd_kelas', $kdKelass)->delete();
        }
        return redirect()->to('admin/kelas')->with('success', 'Data kelas berhasil dihapus');
    }
}
