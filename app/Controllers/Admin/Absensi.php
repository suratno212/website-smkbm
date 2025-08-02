<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\GuruModel;

class Absensi extends BaseController
{
    protected $absensiModel;
    protected $siswaModel;
    protected $kelasModel;
    protected $guruModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        $filters = [
            'tanggal' => $this->request->getGet('tanggal'),
            'kd_kelas' => $this->request->getGet('kd_kelas'),
            'nis' => $this->request->getGet('nis')
        ];

        $data = [
            'title' => 'Data Absensi',
            'absensi' => $this->absensiModel->getAbsensiWithRelations($filters),
            'kelas' => $this->kelasModel->findAll(),
            'filters' => $filters
        ];

        return view('admin/absensi/index', $data);
    }

    public function input()
    {
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');
        $kd_kelas = $this->request->getGet('kd_kelas');

        $data = [
            'title' => 'Input Absensi',
            'tanggal' => $tanggal,
            'kelas' => $this->kelasModel->findAll(),
            'selected_kelas' => $kd_kelas
        ];

        if ($kd_kelas) {
            $data['siswa'] = $this->siswaModel->where('kd_kelas', $kd_kelas)->findAll();
            $data['absensi'] = $this->absensiModel->getAbsensiByTanggalKelas($tanggal, $kd_kelas);
        }

        return view('admin/absensi/input', $data);
    }

    public function store()
    {
        $tanggal = $this->request->getPost('tanggal');
        $kd_kelas = $this->request->getPost('kd_kelas');
        $nik_nip = session()->get('nik_nip') ?? '198501012010012001'; // Default guru

        // Get all students in the class
        $siswa_list = $this->siswaModel->where('kd_kelas', $kd_kelas)->findAll();

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

        return redirect()->to("admin/absensi/input?kd_kelas=$kd_kelas&tanggal=$tanggal")->with('success', $message);
    }

    public function rekap()
    {
        $kd_kelas = $this->request->getGet('kd_kelas');
        $bulan = $this->request->getGet('bulan') ?? date('m');

        $data = [
            'title' => 'Rekap Absensi',
            'kelas' => $this->kelasModel->findAll(),
            'selected_kelas' => $kd_kelas,
            'selected_bulan' => $bulan
        ];

        if ($kd_kelas) {
            $data['rekap'] = $this->absensiModel->getRekapAbsensi($kd_kelas, $bulan);
        }

        return view('admin/absensi/rekap', $data);
    }

    public function rekapGuru()
    {
        $guruModel = $this->guruModel;
        $guru = $guruModel->findAll();
        $filter_guru = $this->request->getGet('guru_id');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $rekap = [];
        $absensiGuruModel = new \App\Models\AbsensiGuruModel();
        if ($tanggal_mulai && $tanggal_akhir) {
            if ($filter_guru && $filter_guru !== 'all') {
                // Rekap satu guru
                $rekap = $absensiGuruModel
                    ->where('nik_nip', $filter_guru)
                    ->where('tanggal >=', $tanggal_mulai)
                    ->where('tanggal <=', $tanggal_akhir)
                    ->findAll();
            } else {
                // Rekap semua guru
                foreach ($guru as $g) {
                    $absensi = $absensiGuruModel
                        ->where('nik_nip', $g['nik_nip'])
                        ->where('tanggal >=', $tanggal_mulai)
                        ->where('tanggal <=', $tanggal_akhir)
                        ->findAll();
                    $rekap[$g['nik_nip']] = [
                        'guru' => $g,
                        'absensi' => $absensi
                    ];
                }
            }
        }
        $data = [
            'title' => 'Rekap Absensi Guru',
            'guru' => $guru,
            'filter_guru' => $filter_guru,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'rekap' => $rekap
        ];
        return view('admin/absensi/rekap_guru', $data);
    }

    public function cetakRekapGuru()
    {
        $guruModel = $this->guruModel;
        $guru = $guruModel->findAll();
        $filter_guru = $this->request->getGet('guru_id');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $rekap = [];
        $absensiGuruModel = new \App\Models\AbsensiGuruModel();
        if ($tanggal_mulai && $tanggal_akhir) {
            if ($filter_guru && $filter_guru !== 'all') {
                // Rekap satu guru
                $rekap = $absensiGuruModel
                    ->where('nik_nip', $filter_guru)
                    ->where('tanggal >=', $tanggal_mulai)
                    ->where('tanggal <=', $tanggal_akhir)
                    ->findAll();
            } else {
                // Rekap semua guru
                foreach ($guru as $g) {
                    $absensi = $absensiGuruModel
                        ->where('nik_nip', $g['nik_nip'])
                        ->where('tanggal >=', $tanggal_mulai)
                        ->where('tanggal <=', $tanggal_akhir)
                        ->findAll();
                    $rekap[$g['nik_nip']] = [
                        'guru' => $g,
                        'absensi' => $absensi
                    ];
                }
            }
        }
        $data = [
            'title' => 'Cetak Rekap Absensi Guru',
            'guru' => $guru,
            'filter_guru' => $filter_guru,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'rekap' => $rekap,
            'is_cetak' => true
        ];
        return view('admin/absensi/rekap_guru', $data);
    }

    public function rekapSiswa()
    {
        $kelasModel = $this->kelasModel;
        $kelas = $kelasModel->findAll();
        $filter_kelas = $this->request->getGet('kelas_id');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $rekap = [];
        $absensiModel = $this->absensiModel;
        $siswaModel = $this->siswaModel;
        if ($filter_kelas && $filter_kelas !== 'all' && $tanggal_mulai && $tanggal_akhir) {
            $siswaList = $siswaModel->where('kd_kelas', $filter_kelas)->findAll();
            foreach ($siswaList as $siswa) {
                $hadir = $absensiModel->where('nis', $siswa['nis'])->where('tanggal >=', $tanggal_mulai)->where('tanggal <=', $tanggal_akhir)->where('status', 'Hadir')->countAllResults();
                $sakit = $absensiModel->where('nis', $siswa['nis'])->where('tanggal >=', $tanggal_mulai)->where('tanggal <=', $tanggal_akhir)->where('status', 'Sakit')->countAllResults();
                $izin = $absensiModel->where('nis', $siswa['nis'])->where('tanggal >=', $tanggal_mulai)->where('tanggal <=', $tanggal_akhir)->where('status', 'Izin')->countAllResults();
                $alpha = $absensiModel->where('nis', $siswa['nis'])->where('tanggal >=', $tanggal_mulai)->where('tanggal <=', $tanggal_akhir)->where('status', 'Alpha')->countAllResults();
                $rekap[] = [
                    'nis' => $siswa['nis'],
                    'nama' => $siswa['nama'],
                    'kelas' => $siswa['kd_kelas'],
                    'hadir' => $hadir,
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'alpha' => $alpha
                ];
            }
        } else if ($filter_kelas === 'all' && $tanggal_mulai && $tanggal_akhir) {
            $siswaList = $siswaModel->findAll();
            foreach ($siswaList as $siswa) {
                $hadir = $absensiModel->where('nis', $siswa['nis'])->where('tanggal >=', $tanggal_mulai)->where('tanggal <=', $tanggal_akhir)->where('status', 'Hadir')->countAllResults();
                $sakit = $absensiModel->where('nis', $siswa['nis'])->where('tanggal >=', $tanggal_mulai)->where('tanggal <=', $tanggal_akhir)->where('status', 'Sakit')->countAllResults();
                $izin = $absensiModel->where('nis', $siswa['nis'])->where('tanggal >=', $tanggal_mulai)->where('tanggal <=', $tanggal_akhir)->where('status', 'Izin')->countAllResults();
                $alpha = $absensiModel->where('nis', $siswa['nis'])->where('tanggal >=', $tanggal_mulai)->where('tanggal <=', $tanggal_akhir)->where('status', 'Alpha')->countAllResults();
                $rekap[] = [
                    'nis' => $siswa['nis'],
                    'nama' => $siswa['nama'],
                    'kelas' => $siswa['kd_kelas'],
                    'hadir' => $hadir,
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'alpha' => $alpha
                ];
            }
        }
        $data = [
            'title' => 'Rekap Absensi Siswa',
            'kelas' => $kelas,
            'filter_kelas' => $filter_kelas,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'rekap' => $rekap
        ];
        return view('admin/absensi/rekap_siswa', $data);
    }
}
