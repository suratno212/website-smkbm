<?php
namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\PertemuanModel;
use App\Models\KelasModel;
use App\Models\MapelModel;

class Pertemuan extends BaseController
{
    protected $pertemuanModel;
    protected $kelasModel;
    protected $mapelModel;

    public function __construct()
    {
        $this->pertemuanModel = new PertemuanModel();
        $this->kelasModel = new KelasModel();
        $this->mapelModel = new MapelModel();
    }

    public function index()
    {
        $pertemuan = $this->pertemuanModel->orderBy('tanggal', 'DESC')->findAll();
        return view('guru/pertemuan/index', [
            'title' => 'Daftar Pertemuan',
            'pertemuan' => $pertemuan
        ]);
    }

    public function create($kelas_id = null)
    {
        $kelas = $this->kelasModel->find($kelas_id);
        $mapel = $this->mapelModel->findAll();
        return view('guru/pertemuan/create', [
            'kelas' => $kelas,
            'mapel' => $mapel,
            'kelas_id' => $kelas_id
        ]);
    }

    public function store()
    {
        $data = [
            'kelas_id' => $this->request->getPost('kelas_id'),
            'mapel_id' => $this->request->getPost('mapel_id'),
            'nama_pertemuan' => $this->request->getPost('nama_pertemuan'),
            'tanggal' => $this->request->getPost('tanggal'),
            'topik' => $this->request->getPost('topik'),
        ];
        $this->pertemuanModel->insert($data);
        return redirect()->to('/guru/pertemuan')->with('success', 'Pertemuan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pertemuan = $this->pertemuanModel->find($id);
        $mapel = $this->mapelModel->findAll();
        return view('guru/pertemuan/edit', [
            'title' => 'Edit Pertemuan',
            'pertemuan' => $pertemuan,
            'mapel' => $mapel
        ]);
    }

    public function update($id)
    {
        $data = [
            'mapel_id' => $this->request->getPost('mapel_id'),
            'nama_pertemuan' => $this->request->getPost('nama_pertemuan'),
            'tanggal' => $this->request->getPost('tanggal'),
            'topik' => $this->request->getPost('topik'),
        ];
        $this->pertemuanModel->update($id, $data);
        return redirect()->to('/guru/pertemuan')->with('success', 'Pertemuan berhasil diupdate');
    }

    public function delete($id)
    {
        $this->pertemuanModel->delete($id);
        return redirect()->to('/guru/pertemuan')->with('success', 'Pertemuan berhasil dihapus');
    }

    public function generate_otomatis()
    {
        $kelas_id = $this->request->getPost('kelas_id');
        $mapel_id = $this->request->getPost('mapel_id');
        $hari = $this->request->getPost('hari');
        $tanggal_mulai = $this->request->getPost('tanggal_mulai');
        $jumlah = (int)$this->request->getPost('jumlah');

        $tanggal = $tanggal_mulai;
        $hari_map = [
            'Minggu' => 0, 'Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6
        ];
        $target_dow = $hari_map[$hari];
        // Cari tanggal mulai yang sesuai hari
        $start_dow = date('w', strtotime($tanggal_mulai));
        $selisih = ($target_dow - $start_dow + 7) % 7;
        $tanggal = date('Y-m-d', strtotime("$tanggal_mulai +$selisih day"));

        for ($i=1; $i<=$jumlah; $i++) {
            $this->pertemuanModel->insert([
                'kelas_id' => $kelas_id,
                'mapel_id' => $mapel_id,
                'nama_pertemuan' => 'Pertemuan ke-'.$i,
                'tanggal' => $tanggal,
                'topik' => '',
            ]);
            $tanggal = date('Y-m-d', strtotime("$tanggal +7 day"));
        }
        return redirect()->to('/guru/pertemuan')->with('success', 'Pertemuan berhasil digenerate otomatis');
    }
} 