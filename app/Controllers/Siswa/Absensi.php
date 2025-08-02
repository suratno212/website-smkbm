<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\SiswaModel;
use App\Models\TahunAkademikModel;

class Absensi extends BaseController
{
    protected $absensiModel;
    protected $siswaModel;
    protected $tahunAkademikModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
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

        // Get current month attendance
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $absensi = $this->absensiModel->where('nis', $nis)
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        // Calculate attendance summary
        $rekap = [
            'hadir' => 0,
            'sakit' => 0,
            'izin' => 0,
            'alpha' => 0
        ];

        foreach ($absensi as $a) {
            switch ($a['status']) {
                case 'H':
                    $rekap['hadir']++;
                    break;
                case 'S':
                    $rekap['sakit']++;
                    break;
                case 'I':
                    $rekap['izin']++;
                    break;
                case 'A':
                    $rekap['alpha']++;
                    break;
            }
        }

        $total = array_sum($rekap);
        $persentase = $total > 0 ? round(($rekap['hadir'] / $total) * 100, 2) : 0;

        // Cek absensi hari ini
        $absen_today = $this->absensiModel->where('nis', $nis)
            ->where('tanggal', date('Y-m-d'))
            ->first();

        $data = [
            'title' => 'Absensi',
            'siswa' => $siswa,
            'absensi' => $absensi,
            'rekap' => $rekap,
            'total' => $total,
            'persentase' => $persentase,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'absen_today' => $absen_today
        ];

        return view('siswa/absensi/index', $data);
    }

    public function isiAbsensi()
    {
        $nis = session()->get('nis');
        $siswa = $this->siswaModel->find($nis);

        if (!$siswa) {
            return redirect()->to('auth/logout')->with('error', 'Data siswa tidak ditemukan');
        }

        $tanggal = date('Y-m-d');

        // Check if already filled attendance today
        $absensi_hari_ini = $this->absensiModel->where([
            'nis' => $nis,
            'tanggal' => $tanggal
        ])->first();

        if ($absensi_hari_ini) {
            return redirect()->to('siswa/absensi')->with('info', 'Absensi hari ini sudah diisi');
        }

        $data = [
            'title' => 'Isi Absensi',
            'siswa' => $siswa,
            'tanggal' => $tanggal
        ];

        return view('siswa/absensi/isi', $data);
    }

    public function storeAbsensi()
    {
        $nis = session()->get('nis');
        $status = $this->request->getPost('status');
        $keterangan = $this->request->getPost('keterangan');
        $tanggal = date('Y-m-d');

        // Check if already filled attendance today
        $existing = $this->absensiModel->where([
            'nis' => $nis,
            'tanggal' => $tanggal
        ])->first();

        if ($existing) {
            return redirect()->to('siswa/absensi')->with('error', 'Absensi hari ini sudah diisi');
        }

        $absensiData = [
            'nis' => $nis,
            'tanggal' => $tanggal,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        $this->absensiModel->insert($absensiData);

        return redirect()->to('siswa/absensi')->with('success', 'Absensi berhasil diisi');
    }

    public function rekap()
    {
        $nis = session()->get('nis');
        $siswa = $this->siswaModel->find($nis);

        if (!$siswa) {
            return redirect()->to('auth/logout')->with('error', 'Data siswa tidak ditemukan');
        }

        // Get attendance summary by month for current year
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $rekap_bulanan = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $absensi = $this->absensiModel->where('nis', $nis)
                ->where('MONTH(tanggal)', $bulan)
                ->where('YEAR(tanggal)', $tahun)
                ->findAll();

            $hadir = 0;
            $sakit = 0;
            $izin = 0;
            $alpha = 0;

            foreach ($absensi as $a) {
                switch ($a['status']) {
                    case 'H':
                        $hadir++;
                        break;
                    case 'S':
                        $sakit++;
                        break;
                    case 'I':
                        $izin++;
                        break;
                    case 'A':
                        $alpha++;
                        break;
                }
            }

            $total = $hadir + $sakit + $izin + $alpha;
            $persentase = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;

            $rekap_bulanan[] = [
                'bulan' => $bulan,
                'nama_bulan' => $this->getNamaBulan($bulan),
                'hadir' => $hadir,
                'sakit' => $sakit,
                'izin' => $izin,
                'alpha' => $alpha,
                'total' => $total,
                'persentase' => $persentase
            ];
        }

        $data = [
            'title' => 'Rekap Absensi',
            'siswa' => $siswa,
            'rekap_bulanan' => $rekap_bulanan,
            'tahun' => $tahun
        ];

        return view('siswa/absensi/rekap', $data);
    }

    public function form()
    {
        $nis = session()->get('nis');
        $siswa = $this->siswaModel->find($nis);

        if (!$siswa) {
            return redirect()->to('auth/logout')->with('error', 'Data siswa tidak ditemukan');
        }

        $tanggal = date('Y-m-d');

        // Check if already filled attendance today
        $absensi_hari_ini = $this->absensiModel->where([
            'nis' => $nis,
            'tanggal' => $tanggal
        ])->first();

        if ($absensi_hari_ini) {
            return redirect()->to('siswa/absensi')->with('info', 'Absensi hari ini sudah diisi');
        }

        $data = [
            'title' => 'Form Absensi',
            'siswa' => $siswa,
            'tanggal' => $tanggal
        ];

        return view('siswa/absensi/form', $data);
    }

    private function getStatusText($status)
    {
        $statusMap = [
            'H' => 'Hadir',
            'S' => 'Sakit',
            'I' => 'Izin',
            'A' => 'Alpha'
        ];

        return $statusMap[$status] ?? $status;
    }

    public function simpan()
    {
        $nis = session()->get('nis');
        $status = $this->request->getPost('status');
        $keterangan = $this->request->getPost('keterangan');
        $tanggal = date('Y-m-d');

        // Check if already filled attendance today
        $existing = $this->absensiModel->where([
            'nis' => $nis,
            'tanggal' => $tanggal
        ])->first();

        if ($existing) {
            return redirect()->to('siswa/absensi')->with('error', 'Absensi hari ini sudah diisi');
        }

        $absensiData = [
            'nis' => $nis,
            'tanggal' => $tanggal,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        $this->absensiModel->insert($absensiData);

        return redirect()->to('siswa/absensi')->with('success', 'Absensi berhasil diisi');
    }

    public function riwayat()
    {
        $nis = session()->get('nis');
        $siswa = $this->siswaModel->find($nis);

        if (!$siswa) {
            return redirect()->to('auth/logout')->with('error', 'Data siswa tidak ditemukan');
        }

        // Get attendance history
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $absensi = $this->absensiModel->where('nis', $nis)
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        // Calculate attendance summary
        $rekap = [
            'hadir' => 0,
            'sakit' => 0,
            'izin' => 0,
            'alpha' => 0
        ];

        foreach ($absensi as $a) {
            switch ($a['status']) {
                case 'H':
                    $rekap['hadir']++;
                    break;
                case 'S':
                    $rekap['sakit']++;
                    break;
                case 'I':
                    $rekap['izin']++;
                    break;
                case 'A':
                    $rekap['alpha']++;
                    break;
            }
        }

        $data = [
            'title' => 'Riwayat Absensi',
            'siswa' => $siswa,
            'absensi' => $absensi,
            'rekap' => $rekap,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];

        return view('siswa/absensi/riwayat', $data);
    }

    private function getNamaBulan($bulan)
    {
        $nama_bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return $nama_bulan[$bulan] ?? '';
    }
}
