<?php
namespace App\Controllers;
use App\Models\SpmbModel;
use App\Models\AgamaModel;
use App\Models\JurusanModel;
class Spmb extends BaseController
{
    protected $spmbModel;
    protected $agamaModel;
    protected $jurusanModel;
    public function __construct()
    {
        $this->spmbModel = new SpmbModel();
        $this->agamaModel = new AgamaModel();
        $this->jurusanModel = new JurusanModel();
    }
    public function index()
    {
        return view('spmb/index');
    }
    public function daftar()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|valid_date',
            'agama_id' => 'required|is_natural_no_zero',
            'alamat' => 'required',
            'asal_sekolah' => 'required',
            'nama_ortu' => 'required',
            'no_hp_ortu' => 'required|numeric',
            'email' => 'required|valid_email',
            'no_hp' => 'required|numeric',
            'jurusan_id' => 'required|is_natural_no_zero',
            'nisn' => 'required|is_unique[spmb.nisn]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $noPendaftaran = $this->spmbModel->generateNoPendaftaran();
        $data = [
            'no_pendaftaran' => $noPendaftaran,
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'agama_id' => $this->request->getPost('agama_id'),
            'alamat' => $this->request->getPost('alamat'),
            'asal_sekolah' => $this->request->getPost('asal_sekolah'),
            'nama_ortu' => $this->request->getPost('nama_ortu'),
            'no_hp_ortu' => $this->request->getPost('no_hp_ortu'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'nisn' => $this->request->getPost('nisn'),
            'status_pendaftaran' => 'Menunggu'
        ];
        $this->spmbModel->insert($data);
        session()->set('no_pendaftaran', $noPendaftaran);
        return redirect()->to(base_url('spmb/sukses'));
    }
    public function sukses()
    {
        $noPendaftaran = session()->get('no_pendaftaran');
        if (!$noPendaftaran) {
            return redirect()->to(base_url('spmb'));
        }
        return view('spmb/sukses', ['no_pendaftaran' => $noPendaftaran]);
    }
    public function cekStatus()
    {
        return view('spmb/cek_status');
    }
    public function cekStatusPost()
    {
        $noPendaftaran = $this->request->getPost('no_pendaftaran');
        $email = $this->request->getPost('email');
        $pendaftar = $this->spmbModel->where('no_pendaftaran', $noPendaftaran)
                                    ->where('email', $email)
                                    ->first();
        if ($pendaftar) {
            return view('spmb/status', ['pendaftar' => $pendaftar]);
        } else {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan');
        }
    }
    public function daftarForm()
    {
        $data['agama'] = $this->agamaModel->findAll();
        $data['jurusan'] = $this->jurusanModel->findAll();
        return view('spmb/daftar', $data);
    }
} 