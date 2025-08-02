<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\SiswaModel;
use App\Models\JadwalModel;
use App\Models\MapelModel;
use App\Models\GuruModel;

class Absensi extends BaseController
{
    protected $absensiModel;
    protected $siswaModel;
    protected $jadwalModel;
    protected $mapelModel;
    protected $guruModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->siswaModel = new SiswaModel();
        $this->jadwalModel = new JadwalModel();
        $this->mapelModel = new MapelModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        // Get current guru
        $guru = $this->guruModel->find(session()->get('nik_nip'));

        // Get classes taught by this guru
        $kelas_diampu = $this->jadwalModel->select('DISTINCT(kelas.kd_kelas), kelas.nama_kelas')
            ->join('kelas', 'kelas.kd_kelas = jadwal.kd_kelas')
            ->where('jadwal.nik_nip', $guru['nik_nip'])
            ->findAll();

        // Get subject taught by this guru
        $mapel_diajar = $this->mapelModel->where('kd_mapel', $guru['kd_mapel'])->first();

        $data = [
            'title' => 'Absensi Siswa',
            'guru' => $guru,
            'kelas_diampu' => $kelas_diampu,
            'mapel_diajar' => $mapel_diajar
        ];

        return view('guru/absensi/index', $data);
    }

    public function input()
    {
        // Get current guru
        $guru = $this->guruModel->find(session()->get('nik_nip'));

        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');
        $kd_kelas = $this->request->getGet('kd_kelas');

        // Get classes taught by this guru
        $kelas_diampu = $this->jadwalModel->select('DISTINCT(kelas.kd_kelas), kelas.nama_kelas')
            ->join('kelas', 'kelas.kd_kelas = jadwal.kd_kelas')
            ->where('jadwal.nik_nip', $guru['nik_nip'])
            ->findAll();

        // Get subject taught by this guru
        $mapel_diajar = $this->mapelModel->where('kd_mapel', $guru['kd_mapel'])->first();

        $data = [
            'title' => 'Input Absensi',
            'guru' => $guru,
            'tanggal' => $tanggal,
            'kelas_diampu' => $kelas_diampu,
            'mapel_diajar' => $mapel_diajar,
            'selected_kelas' => $kd_kelas,
            'selected_tanggal' => $tanggal
        ];

        if ($kd_kelas) {
            $siswa_list = $this->siswaModel->select('nis, nama')->where('kd_kelas', $kd_kelas)->findAll();
            $data['siswa'] = $siswa_list;
            $data['absensi'] = $this->absensiModel->getAbsensiByTanggalKelas($tanggal, $kd_kelas);
        }

        return view('guru/absensi/input', $data);
    }

    public function store()
    {
        $tanggal = $this->request->getPost('tanggal');
        $kd_kelas = $this->request->getPost('kd_kelas');
        $nik_nip = session()->get('nik_nip');

        // Get all students in the class
        $siswa_list = $this->siswaModel->select('nis, nama')->where('kd_kelas', $kd_kelas)->findAll();

        $message = '';
        $inserted = 0;
        $updated = 0;

        foreach ($siswa_list as $siswa) {
            $nis = $siswa['nis'];
            $status = $this->request->getPost("status_$nis");
            $keterangan = $this->request->getPost("keterangan_$nis");

            if ($status) {
                // Check if attendance already exists
                $existing = $this->absensiModel->where([
                    'nis' => $nis,
                    'tanggal' => $tanggal
                ])->first();

                $absensiData = [
                    'nis' => $nis,
                    'tanggal' => $tanggal,
                    'status' => $status,
                    'keterangan' => $keterangan,
                    'nik_nip' => $nik_nip
                ];

                if ($existing) {
                    // Update existing attendance
                    $this->absensiModel->update($existing['id'], $absensiData);
                    $updated++;
                } else {
                    // Insert new attendance
                    $this->absensiModel->insert($absensiData);
                    $inserted++;
                }
            }
        }

        if ($inserted > 0 || $updated > 0) {
            $message = "Berhasil menyimpan absensi: $inserted baru, $updated diperbarui";
        } else {
            $message = "Tidak ada data absensi yang disimpan";
        }

        return redirect()->to("guru/absensi/input?kd_kelas=$kd_kelas&tanggal=$tanggal")->with('success', $message);
    }

    public function rekap()
    {
        // Get current guru
        $guru = $this->guruModel->find(session()->get('nik_nip'));

        $kd_kelas = $this->request->getGet('kd_kelas');
        $bulan = $this->request->getGet('bulan') ?? date('m');

        // Get classes taught by this guru
        $kelas_diampu = $this->jadwalModel->select('DISTINCT(kelas.kd_kelas), kelas.nama_kelas')
            ->join('kelas', 'kelas.kd_kelas = jadwal.kd_kelas')
            ->where('jadwal.nik_nip', $guru['nik_nip'])
            ->findAll();

        $data = [
            'title' => 'Rekap Absensi',
            'guru' => $guru,
            'kelas_diampu' => $kelas_diampu,
            'selected_kelas' => $kd_kelas,
            'selected_bulan' => $bulan
        ];

        if ($kd_kelas) {
            $siswa_list = $this->siswaModel->select('nis, nama')->where('kd_kelas', $kd_kelas)->findAll();
            $data['siswa'] = $siswa_list;
            $data['rekap'] = $this->absensiModel->getRekapAbsensi($kd_kelas, $bulan);
        }

        return view('guru/absensi/rekap', $data);
    }
} 