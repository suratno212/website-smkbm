<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MapelModel;
use App\Models\RuanganModel;
use App\Models\KelasModel;
use App\Models\JurusanModel;
use App\Models\TahunAkademikModel;
use App\Models\UserModel;
use App\Models\EkstrakurikulerModel;

class Master extends BaseController
{
    protected $mapelModel;
    protected $ruanganModel;
    protected $kelasModel;
    protected $jurusanModel;
    protected $tahunAkademikModel;
    protected $userModel;
    protected $ekstrakurikulerModel;

    public function __construct()
    {
        $this->mapelModel = new MapelModel();
        $this->ruanganModel = new RuanganModel();
        $this->kelasModel = new KelasModel();
        $this->jurusanModel = new JurusanModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
        $this->userModel = new UserModel();
        $this->ekstrakurikulerModel = new EkstrakurikulerModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Master',
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/master/index', $data);
    }

    // Mata Pelajaran
    public function mapel()
    {
        $data = [
            'title' => 'Data Mata Pelajaran',
            'mapel' => $this->mapelModel->findAll(),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/master/mapel/index', $data);
    }

    public function mapelCreate()
    {
        $data = [
            'title' => 'Tambah Mata Pelajaran',
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/master/mapel/create', $data);
    }

    public function mapelStore()
    {
        $rules = [
            'nama_mapel' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->mapelModel->insert([
            'nama_mapel' => $this->request->getPost('nama_mapel')
        ]);

        return redirect()->to('admin/master/mapel')->with('message', 'Data mata pelajaran berhasil ditambahkan');
    }

    public function mapelEdit($id)
    {
        $data = [
            'title' => 'Edit Mata Pelajaran',
            'mapel' => $this->mapelModel->find($id),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/master/mapel/edit', $data);
    }

    public function mapelUpdate($id)
    {
        $rules = [
            'nama_mapel' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->mapelModel->update($id, [
            'nama_mapel' => $this->request->getPost('nama_mapel')
        ]);

        return redirect()->to('admin/master/mapel')->with('message', 'Data mata pelajaran berhasil diperbarui');
    }

    public function mapelDelete($id)
    {
        $this->mapelModel->delete($id);
        return redirect()->to('admin/master/mapel')->with('message', 'Data mata pelajaran berhasil dihapus');
    }

    public function mapelMassDelete()
    {
        $ids = $this->request->getPost('mapel_ids');
        if ($ids && is_array($ids)) {
            $this->mapelModel->whereIn('id', $ids)->delete();
            return redirect()->to('admin/master/mapel')->with('message', 'Data mata pelajaran terpilih berhasil dihapus');
        }
        return redirect()->to('admin/master/mapel')->with('errors', ['Tidak ada data yang dipilih untuk dihapus']);
    }

    // Kelas (dulu Ruangan)
    public function kelas()
    {
        $filter_jurusan = $this->request->getGet('jurusan_id');
        $filter_tingkat = $this->request->getGet('tingkat');
        $builder = $this->kelasModel->select('kelas.*, jurusan.nama_jurusan, guru.nama as nama_wali_kelas')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id', 'left')
            ->join('guru', 'guru.id = kelas.wali_kelas_id', 'left');
        if ($filter_jurusan) {
            $builder->where('kelas.jurusan_id', $filter_jurusan);
        }
        if ($filter_tingkat) {
            $builder->where('kelas.tingkat', $filter_tingkat);
        }
        $data = [
            'title' => 'Data Kelas',
            'kelas' => $builder->findAll(),
            'jurusan' => $this->jurusanModel->findAll(),
            'guru' => (new \App\Models\GuruModel())->findAll(),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/master/kelas/index', $data);
    }

    public function kelasCreate()
    {
        $data = [
            'title' => 'Tambah Kelas',
            'jurusan' => $this->jurusanModel->findAll(),
            'guru' => (new \App\Models\GuruModel())->findAll(),
            'user' => $this->userModel->find(session()->get('user_id')),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/master/kelas/create', $data);
    }

    public function kelasStore()
    {
        $rules = [
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'jurusan_id' => 'required',
            'wali_kelas_id' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->kelasModel->insert([
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'tingkat' => $this->request->getPost('tingkat'),
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'wali_kelas_id' => $this->request->getPost('wali_kelas_id')
        ]);
        return redirect()->to('admin/master/kelas')->with('message', 'Data kelas berhasil ditambahkan');
    }

    public function kelasEdit($id)
    {
        $data = [
            'title' => 'Edit Kelas',
            'kelas' => $this->kelasModel->find($id),
            'jurusan' => $this->jurusanModel->findAll(),
            'guru' => (new \App\Models\GuruModel())->findAll(),
            'user' => $this->userModel->find(session()->get('user_id')),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/master/kelas/edit', $data);
    }

    public function kelasUpdate($id)
    {
        $rules = [
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'jurusan_id' => 'required',
            'wali_kelas_id' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->kelasModel->update($id, [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'tingkat' => $this->request->getPost('tingkat'),
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'wali_kelas_id' => $this->request->getPost('wali_kelas_id')
        ]);
        return redirect()->to('admin/master/kelas')->with('message', 'Data kelas berhasil diperbarui');
    }

    public function kelasDelete($id)
    {
        $this->kelasModel->delete($id);
        return redirect()->to('admin/master/kelas')->with('message', 'Data kelas berhasil dihapus');
    }

    public function kelasCetak()
    {
        $filter_jurusan = $this->request->getGet('jurusan_id');
        $filter_tingkat = $this->request->getGet('tingkat');
        $kelas = $this->kelasModel
            ->select('kelas.*, jurusan.nama_jurusan, guru.nama as nama_wali_kelas')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->join('guru', 'guru.id = kelas.wali_kelas_id')
            ->where(function($builder) use ($filter_jurusan, $filter_tingkat) {
                if ($filter_jurusan) $builder->where('kelas.jurusan_id', $filter_jurusan);
                if ($filter_tingkat) $builder->where('kelas.tingkat', $filter_tingkat);
            })
            ->findAll();
        return view('admin/master/kelas/cetak', [
            'title' => 'Cetak Data Kelas',
            'kelas' => $kelas
        ]);
    }

    // Jurusan
    public function jurusan()
    {
        $data = [
            'title' => 'Data Jurusan',
            'jurusan' => $this->jurusanModel->findAll(),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/master/jurusan/index', $data);
    }

    public function jurusanCreate()
    {
        $data = [
            'title' => 'Tambah Jurusan',
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/master/jurusan/create', $data);
    }

    public function jurusanStore()
    {
        $rules = [
            'nama_jurusan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->jurusanModel->insert([
            'nama_jurusan' => $this->request->getPost('nama_jurusan')
        ]);

        return redirect()->to('admin/master/jurusan')->with('message', 'Data jurusan berhasil ditambahkan');
    }

    public function jurusanEdit($id)
    {
        $data = [
            'title' => 'Edit Jurusan',
            'jurusan' => $this->jurusanModel->find($id),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/master/jurusan/edit', $data);
    }

    public function jurusanUpdate($id)
    {
        $rules = [
            'nama_jurusan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->jurusanModel->update($id, [
            'nama_jurusan' => $this->request->getPost('nama_jurusan')
        ]);

        return redirect()->to('admin/master/jurusan')->with('message', 'Data jurusan berhasil diperbarui');
    }

    public function jurusanDelete($id)
    {
        $this->jurusanModel->delete($id);
        return redirect()->to('admin/master/jurusan')->with('message', 'Data jurusan berhasil dihapus');
    }

    // Tahun Akademik
    public function tahunAkademik()
    {
        $data = [
            'title' => 'Data Tahun Akademik',
            'tahun_akademik' => $this->tahunAkademikModel->findAll(),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/master/tahun_akademik/index', $data);
    }

    public function tahunAkademikCreate()
    {
        $data = [
            'title' => 'Tambah Tahun Akademik',
            'user' => $this->userModel->find(session()->get('user_id'))
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

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->tahunAkademikModel->insert([
            'tahun' => $this->request->getPost('tahun'),
            'semester' => $this->request->getPost('semester'),
            'status' => $this->request->getPost('status')
        ]);

        return redirect()->to('admin/master/tahun_akademik')->with('message', 'Data tahun akademik berhasil ditambahkan');
    }

    public function tahunAkademikEdit($id)
    {
        $data = [
            'title' => 'Edit Tahun Akademik',
            'tahun_akademik' => $this->tahunAkademikModel->find($id),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/master/tahun_akademik/edit', $data);
    }

    public function tahunAkademikUpdate($id)
    {
        $rules = [
            'tahun' => 'required',
            'semester' => 'required|in_list[Ganjil,Genap]',
            'status' => 'required|in_list[Aktif,Tidak Aktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->tahunAkademikModel->update($id, [
            'tahun' => $this->request->getPost('tahun'),
            'semester' => $this->request->getPost('semester'),
            'status' => $this->request->getPost('status')
        ]);

        return redirect()->to('admin/master/tahun_akademik')->with('message', 'Data tahun akademik berhasil diperbarui');
    }

    public function tahunAkademikDelete($id)
    {
        $this->tahunAkademikModel->delete($id);
        return redirect()->to('admin/master/tahun_akademik')->with('message', 'Data tahun akademik berhasil dihapus');
    }

    public function mass_delete()
    {
        $ids = $this->request->getPost('ids');
        if ($ids && is_array($ids)) {
            $this->kelasModel->whereIn('id', $ids)->delete();
            return redirect()->to('admin/master/kelas')->with('message', 'Data kelas terpilih berhasil dihapus');
        }
        return redirect()->to('admin/master/kelas')->with('errors', ['Tidak ada data yang dipilih untuk dihapus']);
    }

    public function ekstrakurikuler()
    {
        $data = [
            'title' => 'Data Ekstrakurikuler',
            'ekstrakurikuler' => $this->ekstrakurikulerModel->findAll(),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/master/ekstrakurikuler/index', $data);
    }

    public function ekstrakurikulerCreate()
    {
        $data = [
            'title' => 'Tambah Ekstrakurikuler',
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/master/ekstrakurikuler/create', $data);
    }

    public function ekstrakurikulerStore()
    {
        $rules = [
            'nama_ekstrakurikuler' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->ekstrakurikulerModel->insert([
            'nama_ekstrakurikuler' => $this->request->getPost('nama_ekstrakurikuler')
        ]);
        return redirect()->to('admin/master/ekstrakurikuler')->with('message', 'Data ekstrakurikuler berhasil ditambahkan');
    }

    public function ekstrakurikulerEdit($id)
    {
        $data = [
            'title' => 'Edit Ekstrakurikuler',
            'ekstrakurikuler' => $this->ekstrakurikulerModel->find($id),
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('admin/master/ekstrakurikuler/edit', $data);
    }

    public function ekstrakurikulerUpdate($id)
    {
        $rules = [
            'nama_ekstrakurikuler' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->ekstrakurikulerModel->update($id, [
            'nama_ekstrakurikuler' => $this->request->getPost('nama_ekstrakurikuler')
        ]);
        return redirect()->to('admin/master/ekstrakurikuler')->with('message', 'Data ekstrakurikuler berhasil diperbarui');
    }

    public function ekstrakurikulerDelete($id)
    {
        $this->ekstrakurikulerModel->delete($id);
        return redirect()->to('admin/master/ekstrakurikuler')->with('message', 'Data ekstrakurikuler berhasil dihapus');
    }
} 