<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MapelModel;
use App\Models\KelasModel;
use App\Models\JurusanModel;
use App\Models\TahunAkademikModel;

class Master extends BaseController
{
    protected $mapelModel;
    protected $kelasModel;
    protected $jurusanModel;

    public function __construct()
    {
        $this->mapelModel = new MapelModel();
        $this->kelasModel = new KelasModel();
        $this->jurusanModel = new JurusanModel();
    }

    // ==================== MAPEL ====================
    public function mapel()
    {
        $data = [
            'title' => 'Data Mata Pelajaran',
            'mapel' => $this->mapelModel->findAll()
        ];

        return view('admin/master/mapel/index', $data);
    }

    public function mapelCreate()
    {
        $data = [
            'title' => 'Tambah Mata Pelajaran',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/master/mapel/create', $data);
    }

    public function mapelStore()
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

        return redirect()->to('admin/master/mapel')->with('success', 'Data mata pelajaran berhasil ditambahkan');
    }

    public function mapelEdit($kdMapel)
    {
        $data = [
            'title' => 'Edit Mata Pelajaran',
            'mapel' => $this->mapelModel->find($kdMapel),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/master/mapel/edit', $data);
    }

    public function mapelUpdate($kdMapel)
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

        return redirect()->to('admin/master/mapel')->with('success', 'Data mata pelajaran berhasil diperbarui');
    }

    public function mapelDelete($kdMapel)
    {
        $this->mapelModel->delete($kdMapel);
        return redirect()->to('admin/master/mapel')->with('success', 'Data mata pelajaran berhasil dihapus');
    }

    public function mapelBulkDelete()
    {
        $kdMapels = $this->request->getPost('mapel_ids');
        if ($kdMapels && is_array($kdMapels)) {
            $this->mapelModel->whereIn('kd_mapel', $kdMapels)->delete();
        }
        return redirect()->to('admin/master/mapel')->with('success', 'Data mata pelajaran berhasil dihapus');
    }

    // ==================== KELAS ====================
    public function kelas()
    {
        $filter_jurusan = $this->request->getGet('kd_jurusan');
        $kelas = $this->kelasModel->getKelasWithJurusan($filter_jurusan ? ['kd_jurusan' => $filter_jurusan] : []);
        $data = [
            'title' => 'Data Kelas',
            'kelas' => $kelas,
            'jurusan' => $this->jurusanModel->findAll(),
            'filter_jurusan' => $filter_jurusan
        ];
        return view('admin/master/kelas/index', $data);
    }

    public function kelasCreate()
    {
        $wali_kelas = (new \App\Models\GuruModel())->findAll();
        $data = [
            'title' => 'Tambah Kelas',
            'jurusan' => $this->jurusanModel->findAll(),
            'wali_kelas' => $wali_kelas,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/master/kelas/create', $data);
    }

    public function kelasStore()
    {
        // Validation rules
        $rules = [
            'kd_kelas' => 'required|is_unique[kelas.kd_kelas]',
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'kd_jurusan' => 'required',
            'wali_kelas_nik_nip' => 'required',
            'kuota' => 'required|numeric'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $kelasData = [
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'tingkat' => $this->request->getPost('tingkat'),
            'kd_jurusan' => $this->request->getPost('kd_jurusan'),
            'wali_kelas_nik_nip' => $this->request->getPost('wali_kelas_nik_nip'),
            'kuota' => $this->request->getPost('kuota')
        ];

        $this->kelasModel->insert($kelasData);

        // Insert ke tabel wali_kelas untuk tahun akademik aktif
        $tahunAkademikModel = new \App\Models\TahunAkademikModel();
        $tahunAkademik = $tahunAkademikModel->where('status', 'Aktif')->first();
        if ($tahunAkademik) {
            $waliKelasModel = new \App\Models\WaliKelasModel();
            $waliKelasModel->insert([
                'kd_kelas' => $this->request->getPost('kd_kelas'),
                'nik_nip' => $this->request->getPost('wali_kelas_nik_nip'),
                'kd_tahun_akademik' => $tahunAkademik['kd_tahun_akademik'] ?? $tahunAkademik['id'] ?? $tahunAkademik['tahun']
            ]);
        }

        return redirect()->to('admin/master/kelas')->with('success', 'Data kelas & wali kelas berhasil ditambahkan');
    }

    public function kelasEdit($kdKelas)
    {
        $data = [
            'title' => 'Edit Kelas',
            'kelas' => $this->kelasModel->find($kdKelas),
            'jurusan' => $this->jurusanModel->findAll(),
            'guru' => (new \App\Models\GuruModel())->findAll(), // Pastikan data guru dikirim ke view
            'validation' => \Config\Services::validation()
        ];
        return view('admin/master/kelas/edit', $data);
    }

    public function kelasUpdate($kdKelas)
    {
        // Validation rules
        $rules = [
            'kd_kelas' => "required|is_unique[kelas.kd_kelas,kd_kelas,$kdKelas]",
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'kd_jurusan' => 'required',
            'wali_kelas_nik_nip' => 'required',
            'kuota' => 'required|numeric'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kelasModel->update($kdKelas, [
            'kd_kelas' => $this->request->getPost('kd_kelas'),
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'tingkat' => $this->request->getPost('tingkat'),
            'kd_jurusan' => $this->request->getPost('kd_jurusan'),
            'wali_kelas_nik_nip' => $this->request->getPost('wali_kelas_nik_nip'),
            'kuota' => $this->request->getPost('kuota')
        ]);

        return redirect()->to('admin/master/kelas')->with('success', 'Data kelas berhasil diperbarui');
    }

    public function kelasDelete($kdKelas)
    {
        $this->kelasModel->delete($kdKelas);
        return redirect()->to('admin/master/kelas')->with('success', 'Data kelas berhasil dihapus');
    }

    public function kelasBulkDelete()
    {
        $kdKelass = $this->request->getPost('ids');
        if ($kdKelass && is_array($kdKelass)) {
            $this->kelasModel->whereIn('kd_kelas', $kdKelass)->delete();
        }
        return redirect()->to('admin/master/kelas')->with('success', 'Data kelas berhasil dihapus');
    }

    public function kelasCetak()
    {
        $kelas = $this->kelasModel->getKelasWithJurusan();
        return view('admin/master/kelas/cetak', [
            'kelas' => $kelas,
            'title' => 'Cetak Data Kelas'
        ]);
    }

    // ==================== JURUSAN ====================
    public function jurusan()
    {
        $data = [
            'title' => 'Data Jurusan',
            'jurusan' => $this->jurusanModel->findAll()
        ];

        return view('admin/master/jurusan/index', $data);
    }

    public function jurusanCreate()
    {
        $data = [
            'title' => 'Tambah Jurusan',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/master/jurusan/create', $data);
    }

    public function jurusanStore()
    {
        // Validation rules
        $rules = [
            'kd_jurusan' => 'required|is_unique[jurusan.kd_jurusan]',
            'nama_jurusan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $jurusanData = [
            'kd_jurusan' => $this->request->getPost('kd_jurusan'),
            'nama_jurusan' => $this->request->getPost('nama_jurusan')
        ];

        $this->jurusanModel->insert($jurusanData);

        return redirect()->to('admin/master/jurusan')->with('success', 'Data jurusan berhasil ditambahkan');
    }

    public function jurusanEdit($kdJurusan)
    {
        $data = [
            'title' => 'Edit Jurusan',
            'jurusan' => $this->jurusanModel->find($kdJurusan),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/master/jurusan/edit', $data);
    }

    public function jurusanUpdate($kdJurusan)
    {
        // Validation rules
        $rules = [
            'kd_jurusan' => "required|is_unique[jurusan.kd_jurusan,kd_jurusan,$kdJurusan]",
            'nama_jurusan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->jurusanModel->update($kdJurusan, [
            'kd_jurusan' => $this->request->getPost('kd_jurusan'),
            'nama_jurusan' => $this->request->getPost('nama_jurusan')
        ]);

        return redirect()->to('admin/master/jurusan')->with('success', 'Data jurusan berhasil diperbarui');
    }

    public function jurusanDelete($kdJurusan)
    {
        $this->jurusanModel->delete($kdJurusan);
        return redirect()->to('admin/master/jurusan')->with('success', 'Data jurusan berhasil dihapus');
    }

    public function tahunAkademik()
    {
        $tahunAkademikModel = new \App\Models\TahunAkademikModel();
        $data = [
            'title' => 'Data Tahun Akademik',
            'tahun_akademik' => $tahunAkademikModel->findAll()
        ];
        return view('admin/master/tahun_akademik/index', $data);
    }

    public function tahunAkademikCreate()
    {
        $data = [
            'title' => 'Tambah Tahun Akademik',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/master/tahun_akademik/create', $data);
    }

    public function tahunAkademikStore()
    {
        $rules = [
            'tahun' => 'required',
            'semester' => 'required|in_list[Ganjil,Genap]',
            'status' => 'required|in_list[Aktif,Tidak Aktif]'
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $tahun = $this->request->getPost('tahun');
        $semester = $this->request->getPost('semester');
        $kode = preg_replace('/[^0-9]/', '', $tahun);
        $kode .= ($semester == 'Ganjil') ? 'GJ' : 'GN';
        $model = new TahunAkademikModel();
        $model->insert([
            'kd_tahun_akademik' => $kode,
            'tahun' => $tahun,
            'semester' => $semester,
            'status' => $this->request->getPost('status')
        ]);
        return redirect()->to('admin/master/tahun_akademik')->with('success', 'Tahun akademik berhasil ditambahkan');
    }

    public function tahunAkademikDelete($kdTahunAkademik)
    {
        $model = new TahunAkademikModel();
        $model->where('kd_tahun_akademik', $kdTahunAkademik)->delete();
        return redirect()->to('admin/master/tahun_akademik')->with('success', 'Tahun akademik berhasil dihapus');
    }

    public function tahunAkademikEdit($kdTahunAkademik)
    {
        $model = new TahunAkademikModel();
        $tahunAkademik = $model->where('kd_tahun_akademik', $kdTahunAkademik)->first();
        if (!$tahunAkademik) {
            return redirect()->to('admin/master/tahun_akademik')->with('error', 'Data tidak ditemukan');
        }
        $data = [
            'title' => 'Edit Tahun Akademik',
            'tahun_akademik' => $tahunAkademik,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/master/tahun_akademik/edit', $data);
    }

    public function tahunAkademikUpdate($kdTahunAkademik)
    {
        $rules = [
            'tahun' => 'required',
            'semester' => 'required|in_list[Ganjil,Genap]',
            'status' => 'required|in_list[Aktif,Tidak Aktif]'
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $model = new TahunAkademikModel();
        $model->where('kd_tahun_akademik', $kdTahunAkademik)->set([
            'tahun' => $this->request->getPost('tahun'),
            'semester' => $this->request->getPost('semester'),
            'status' => $this->request->getPost('status')
        ])->update();
        return redirect()->to('admin/master/tahun_akademik')->with('success', 'Tahun akademik berhasil diupdate');
    }

    public function ekstrakurikuler()
    {
        $model = new \App\Models\EkstrakurikulerModel();
        $data = [
            'title' => 'Data Ekstrakurikuler',
            'ekstrakurikuler' => $model->findAll()
        ];
        return view('admin/master/ekstrakurikuler/index', $data);
    }

    public function ekstrakurikulerCreate()
    {
        $data = [
            'title' => 'Tambah Ekstrakurikuler',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/master/ekstrakurikuler/create', $data);
    }

    public function ekstrakurikulerStore()
    {
        $rules = [
            'kd_ekstrakurikuler' => 'required',
            'nama_ekstrakurikuler' => 'required'
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $model = new \App\Models\EkstrakurikulerModel();
        $kode = $this->request->getPost('kd_ekstrakurikuler') ?: ('EK' . time());
        $model->insert([
            'kd_ekstrakurikuler' => $kode,
            'nama_ekstrakurikuler' => $this->request->getPost('nama_ekstrakurikuler')
        ]);
        return redirect()->to('admin/master/ekstrakurikuler')->with('success', 'Ekstrakurikuler berhasil ditambahkan');
    }
}
