<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\JadwalModel;
use App\Models\SiswaModel;
use App\Models\AbsensiModel;
use App\Models\TahunAkademikModel;

class Dashboard extends BaseController
{
    protected $guruModel;
    protected $jadwalModel;
    protected $siswaModel;
    protected $absensiModel;
    protected $tahunAkademikModel;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
        $this->jadwalModel = new JadwalModel();
        $this->siswaModel = new SiswaModel();
        $this->absensiModel = new AbsensiModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
    }

    public function index()
    {
        $nik_nip = session()->get('nik_nip');
        $guru = $this->guruModel->find($nik_nip);
        if (!is_array($guru) || !isset($guru['nik_nip'])) {
            return redirect()->to('auth/logout')->with('error', 'Session atau data guru tidak valid');
        }

        // Get current academic year
        $tahunAkademik = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $tahunAkademikId = $tahunAkademik ? $tahunAkademik['kd_tahun_akademik'] : 1;

        // Get classes taught by this guru
        $kelas_diampu = $this->jadwalModel->select('DISTINCT(kelas.kd_kelas), kelas.nama_kelas')
            ->join('kelas', 'kelas.kd_kelas = jadwal.kd_kelas')
            ->where('jadwal.nik_nip', $nik_nip)
            ->where('jadwal.tahun_akademik_id', $tahunAkademikId)
            ->findAll();

        // Get today's schedule
        $hari = $this->getHariIndonesia(date('N'));
        $jadwal_hari_ini = $this->jadwalModel->select('jadwal.*, mapel.nama_mapel, kelas.nama_kelas')
            ->join('mapel', 'mapel.kd_mapel = jadwal.kd_mapel')
            ->join('kelas', 'kelas.kd_kelas = jadwal.kd_kelas')
            ->where('jadwal.nik_nip', $nik_nip)
            ->where('jadwal.hari', $hari)
            ->where('jadwal.tahun_akademik_id', $tahunAkademikId)
            ->orderBy('jadwal.jam_mulai', 'ASC')
            ->findAll();

        // Get total students taught
        $total_siswa = 0;
        foreach ($kelas_diampu as $kelas) {
            $siswa_count = $this->siswaModel->where('kd_kelas', $kelas['kd_kelas'])->countAllResults();
            $total_siswa += $siswa_count;
        }

        // Get attendance summary for current month
        $absensiGuruModel = new \App\Models\AbsensiGuruModel();
        $bulan_ini = date('m');
        $rekap_absensi = $absensiGuruModel->select('
            COUNT(CASE WHEN status = "Hadir" THEN 1 END) as hadir,
            COUNT(CASE WHEN status = "Sakit" THEN 1 END) as sakit,
            COUNT(CASE WHEN status = "Izin" THEN 1 END) as izin,
            COUNT(CASE WHEN status = "Alpha" THEN 1 END) as alpha
        ')
        ->where('nik_nip', $nik_nip)
        ->where('MONTH(tanggal)', $bulan_ini)
        ->first();

        // Cek apakah guru adalah wali kelas di tahun akademik aktif
        $waliKelasModel = new \App\Models\WaliKelasModel();
        $isWaliKelas = $waliKelasModel->where('nik_nip', $nik_nip)
            ->where('kd_tahun_akademik', $tahunAkademikId)
            ->countAllResults() > 0;

        // Ambil pengumuman aktif
        $pengumumanModel = new \App\Models\PengumumanModel();
        $pengumuman = $pengumumanModel->where('status', 'Aktif')->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'title' => 'Dashboard Guru',
            'guru' => $guru,
            'kelas_diampu' => $kelas_diampu,
            'jadwal_hari_ini' => $jadwal_hari_ini,
            'total_siswa' => $total_siswa,
            'rekap_absensi' => $rekap_absensi,
            'tahun_akademik' => $tahunAkademik,
            'isWaliKelas' => $isWaliKelas,
            'pengumuman' => $pengumuman
        ];

        return view('guru/dashboard', $data);
    }

    private function getHariIndonesia($dayNumber)
    {
        $hari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];

        return $hari[$dayNumber] ?? 'Senin';
    }
}
