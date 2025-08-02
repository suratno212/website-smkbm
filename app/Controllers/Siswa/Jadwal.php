<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\SiswaModel;
use App\Models\TahunAkademikModel;

class Jadwal extends BaseController
{
    protected $jadwalModel;
    protected $siswaModel;
    protected $tahunAkademikModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->siswaModel = new SiswaModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
    }

    public function index()
    {
        $nis = session()->get('nis');
        $siswa = $this->siswaModel->find($nis);

        if (!$siswa) {
            return redirect()->to('auth/logout')->with('error', 'Data siswa tidak ditemukan');
        }

        // Get current academic year
        $tahunAkademik = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $tahunAkademikId = $tahunAkademik ? $tahunAkademik['id'] : 1;

        // Get schedule for student's class
        $jadwal = $this->jadwalModel->select('jadwal.*, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('mapel', 'mapel.kd_mapel = jadwal.kd_mapel')
            ->join('guru', 'guru.nik_nip = jadwal.nik_nip')
            ->where('jadwal.kd_kelas', $siswa['kd_kelas'])
            ->where('jadwal.tahun_akademik_id', $tahunAkademikId)
            ->orderBy('jadwal.hari, jadwal.jam_mulai', 'ASC')
            ->findAll();

        // Group schedule by day
        $jadwal_harian = [];
        $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        foreach ($hari_list as $hari) {
            $jadwal_harian[$hari] = [];
        }

        foreach ($jadwal as $j) {
            $jadwal_harian[$j['hari']][] = $j;
        }

        $data = [
            'title' => 'Jadwal Pelajaran',
            'siswa' => $siswa,
            'jadwal_harian' => $jadwal_harian,
            'tahun_akademik' => $tahunAkademik
        ];

        return view('siswa/jadwal/index', $data);
    }

    public function hariIni()
    {
        $nis = session()->get('nis');
        $siswa = $this->siswaModel->find($nis);

        if (!$siswa) {
            return redirect()->to('auth/logout')->with('error', 'Data siswa tidak ditemukan');
        }

        // Get current academic year
        $tahunAkademik = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $tahunAkademikId = $tahunAkademik ? $tahunAkademik['id'] : 1;

        // Get today's schedule
        $hari = $this->getHariIndonesia(date('N'));
        $jadwal_hari_ini = $this->jadwalModel->select('jadwal.*, mapel.nama_mapel, guru.nama as nama_guru')
            ->join('mapel', 'mapel.kd_mapel = jadwal.kd_mapel')
            ->join('guru', 'guru.nik_nip = jadwal.nik_nip')
            ->where('jadwal.kd_kelas', $siswa['kd_kelas'])
            ->where('jadwal.hari', $hari)
            ->where('jadwal.tahun_akademik_id', $tahunAkademikId)
            ->orderBy('jadwal.jam_mulai', 'ASC')
            ->findAll();

        $data = [
            'title' => 'Jadwal Hari Ini',
            'siswa' => $siswa,
            'jadwal_hari_ini' => $jadwal_hari_ini,
            'hari' => $hari,
            'tahun_akademik' => $tahunAkademik
        ];

        return view('siswa/jadwal/hari_ini', $data);
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