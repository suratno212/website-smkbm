<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\AbsensiModel;
use App\Models\TahunAkademikModel;
use App\Models\UserModel;
use App\Models\JurusanModel;
use App\Models\JadwalModel;
use App\Models\CalonSiswaModel;

class Dashboard extends BaseController
{
    protected $siswaModel;
    protected $guruModel;
    protected $kelasModel;
    protected $mapelModel;
    protected $absensiModel;
    protected $tahunAkademikModel;
    protected $userModel;
    protected $jurusanModel;
    protected $jadwalModel;
    protected $calonSiswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
        $this->kelasModel = new KelasModel();
        $this->mapelModel = new MapelModel();
        $this->absensiModel = new AbsensiModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
        $this->userModel = new UserModel();
        $this->jurusanModel = new JurusanModel();
        $this->jadwalModel = new JadwalModel();
        $this->calonSiswaModel = new CalonSiswaModel();
    }

    public function index()
    {
        // Get current academic year
        $tahunAkademik = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $tahunAkademikId = $tahunAkademik ? $tahunAkademik['kd_tahun_akademik'] : null;

        // Get statistics
        $total_siswa = $this->siswaModel->countAllResults();
        $total_guru = $this->guruModel->countAllResults();
        $total_kelas = $this->kelasModel->countAllResults();
        $total_mapel = $this->mapelModel->countAllResults();

        // Get attendance summary for today
        $hari_ini = date('Y-m-d');
        $rekap_absensi_hari_ini = $this->absensiModel->select('
            COUNT(CASE WHEN status = "H" THEN 1 END) as hadir,
            COUNT(CASE WHEN status = "S" THEN 1 END) as sakit,
            COUNT(CASE WHEN status = "I" THEN 1 END) as izin,
            COUNT(CASE WHEN status = "A" THEN 1 END) as alpha
        ')
        ->where('tanggal', $hari_ini)
        ->first();

        // Get students by class
        $siswa_per_kelas = $this->siswaModel->select('kelas.nama_kelas, COUNT(siswa.nis) as jumlah_siswa')
            ->join('kelas', 'kelas.kd_kelas = siswa.kd_kelas')
            ->groupBy('siswa.kd_kelas')
            ->orderBy('kelas.nama_kelas', 'ASC')
            ->findAll();

        // Get students by major
        $siswa_per_jurusan = $this->siswaModel->select('jurusan.nama_jurusan, COUNT(siswa.nis) as jumlah_siswa')
            ->join('jurusan', 'jurusan.kd_jurusan = siswa.kd_jurusan')
            ->groupBy('siswa.kd_jurusan')
            ->orderBy('jurusan.nama_jurusan', 'ASC')
            ->findAll();

        // Get recent attendance
        $absensi_terbaru = $this->absensiModel->select('absensi.*, siswa.nama as nama_siswa, kelas.nama_kelas')
            ->join('siswa', 'siswa.nis = absensi.nis')
            ->join('kelas', 'kelas.kd_kelas = siswa.kd_kelas')
            ->orderBy('absensi.created_at', 'DESC')
            ->limit(10)
            ->findAll();

        $total_users = $this->userModel->countAllResults();
        $total_jurusan = $this->jurusanModel->countAllResults();
        $total_tahun_akademik = $this->tahunAkademikModel->countAllResults();
        $total_jadwal = $this->jadwalModel->countAllResults();
        $total_calon_siswa = $this->calonSiswaModel->countAllResults();
        $calon_siswa_terdaftar = $this->calonSiswaModel->where('status_pendaftaran', 'terdaftar')->countAllResults();
        $calon_siswa_diterima = $this->calonSiswaModel->where('status_pendaftaran', 'diterima')->countAllResults();
        $calon_siswa_ditolak = $this->calonSiswaModel->where('status_pendaftaran', 'ditolak')->countAllResults();

        $data = [
            'title' => 'Dashboard Admin',
            'total_siswa' => $total_siswa,
            'total_guru' => $total_guru,
            'total_kelas' => $total_kelas,
            'total_mapel' => $total_mapel,
            'rekap_absensi_hari_ini' => $rekap_absensi_hari_ini,
            'siswa_per_kelas' => $siswa_per_kelas,
            'siswa_per_jurusan' => $siswa_per_jurusan,
            'absensi_terbaru' => $absensi_terbaru,
            'tahun_akademik' => $tahunAkademik,
            'total_users' => $total_users,
            'total_jurusan' => $total_jurusan,
            'total_tahun_akademik' => $total_tahun_akademik,
            'total_jadwal' => $total_jadwal,
            'total_calon_siswa' => $total_calon_siswa,
            'calon_siswa_terdaftar' => $calon_siswa_terdaftar,
            'calon_siswa_diterima' => $calon_siswa_diterima,
            'calon_siswa_ditolak' => $calon_siswa_ditolak
        ];

        return view('admin/dashboard', $data);
    }
} 