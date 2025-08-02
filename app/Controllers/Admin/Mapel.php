<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MapelModel;

class Mapel extends BaseController
{
    protected $mapelModel;

    public function __construct()
    {
        $this->mapelModel = new MapelModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Mata Pelajaran',
            'mapel' => $this->mapelModel->findAll()
        ];

        return view('admin/mapel/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Mata Pelajaran',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/mapel/create', $data);
    }

    public function store()
    {
        // Validation rules
        $rules = [
            'kd_mapel' => 'required|is_unique[mapel.kd_mapel]',
            'nama_mapel' => 'required',
            'kelompok' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $mapelData = [
            'kd_mapel' => $this->request->getPost('kd_mapel'),
            'nama_mapel' => $this->request->getPost('nama_mapel'),
            'kelompok' => $this->request->getPost('kelompok')
        ];

        $this->mapelModel->insert($mapelData);

        return redirect()->to('admin/mapel')->with('success', 'Data mata pelajaran berhasil ditambahkan');
    }

    public function edit($kdMapel)
    {
        $data = [
            'title' => 'Edit Mata Pelajaran',
            'mapel' => $this->mapelModel->find($kdMapel),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/mapel/edit', $data);
    }

    public function update($kdMapel)
    {
        // Validation rules
        $rules = [
            'kd_mapel' => "required|is_unique[mapel.kd_mapel,kd_mapel,$kdMapel]",
            'nama_mapel' => 'required',
            'kelompok' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->mapelModel->update($kdMapel, [
            'kd_mapel' => $this->request->getPost('kd_mapel'),
            'nama_mapel' => $this->request->getPost('nama_mapel'),
            'kelompok' => $this->request->getPost('kelompok')
        ]);

        return redirect()->to('admin/mapel')->with('success', 'Data mata pelajaran berhasil diperbarui');
    }

    public function delete($kdMapel)
    {
        $this->mapelModel->delete($kdMapel);
        return redirect()->to('admin/mapel')->with('success', 'Data mata pelajaran berhasil dihapus');
    }

    public function bulkDelete()
    {
        $kdMapels = $this->request->getPost('mapel_ids');
        if ($kdMapels && is_array($kdMapels)) {
            $this->mapelModel->whereIn('kd_mapel', $kdMapels)->delete();
        }
        return redirect()->to('admin/mapel')->with('success', 'Data mata pelajaran berhasil dihapus');
    }
} 