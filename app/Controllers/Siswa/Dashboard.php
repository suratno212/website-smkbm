<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\JadwalModel;
use App\Models\NilaiModel;
use App\Models\AbsensiModel;
use App\Models\TahunAkademikModel;
use App\Models\TugasModel;
use App\Models\PengumpulanTugasModel;

class Dashboard extends BaseController
{
    protected $siswaModel;
    protected $jadwalModel;
    protected $nilaiModel;
    protected $absensiModel;
    protected $tahunAkademikModel;
    protected $tugasModel;
    protected $pengumpulanTugasModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->jadwalModel = new JadwalModel();
        $this->nilaiModel = new NilaiModel();
        $this->absensiModel = new AbsensiModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
        $this->tugasModel = new TugasModel();
        $this->pengumpulanTugasModel = new PengumpulanTugasModel();
    }

    public function index()
    {
        // Debug: log session data
        log_message('debug', 'SESSION DATA (SISWA DASHBOARD): ' . json_encode(session()->get()));
        $nis = session()->get('nis');
        // Get siswa data with kelas and jurusan information
        $siswa = $this->siswaModel->select('siswa.*, kelas.nama_kelas, jurusan.nama_jurusan')
            ->join('kelas', 'kelas.kd_kelas = siswa.kd_kelas', 'left')
            ->join('jurusan', 'jurusan.kd_jurusan = kelas.kd_jurusan', 'left')
            ->where('siswa.nis', $nis)
            ->first();

        if (!$siswa) {
            return redirect()->to('auth/logout')->with('error', 'Data siswa tidak ditemukan');
        }

        // Get current academic year
        $tahunAkademik = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $tahunAkademikId = $tahunAkademik ? $tahunAkademik['kd_tahun_akademik'] : null;

        // Get today's schedule
        $hari = $this->getHariIndonesia(date('N'));
        $jadwal_hari_ini = [];
        if (!empty($siswa['kd_kelas'])) {
            $jadwal_hari_ini = $this->jadwalModel->select('jadwal.*, mapel.nama_mapel, guru.nama as nama_guru')
                ->join('mapel', 'mapel.kd_mapel = jadwal.kd_mapel')
                ->join('guru', 'guru.nik_nip = jadwal.nik_nip')
                ->where('jadwal.kd_kelas', $siswa['kd_kelas'])
                ->where('jadwal.hari', $hari)
                ->where('jadwal.tahun_akademik_id', $tahunAkademikId)
                ->orderBy('jadwal.jam_mulai', 'ASC')
                ->findAll();
        }

        // Get recent grades
        $nilai_terbaru = $this->nilaiModel->select('nilai.*, mapel.nama_mapel')
            ->join('mapel', 'mapel.kd_mapel = nilai.kd_mapel')
            ->where('nilai.nis', $nis)
            ->where('nilai.tahun_akademik_id', $tahunAkademikId)
            ->orderBy('nilai.updated_at', 'DESC')
            ->limit(5)
            ->findAll();

        // Untuk grafik nilai
        $nilaiData = [];
        $rataRata = 0;
        if (!empty($nilai_terbaru)) {
            foreach ($nilai_terbaru as $n) {
                $nilaiAkhir = isset($n['nilai_akhir']) ? floatval($n['nilai_akhir']) : 0;
                $nilaiData[] = [
                    'mapel' => $n['nama_mapel'] ?? '-',
                    'nilai' => $nilaiAkhir
                ];
            }
            $rataRata = count($nilaiData) > 0 ? round(array_sum(array_column($nilaiData, 'nilai')) / count($nilaiData), 2) : 0;
        }

        // Get attendance summary for current month
        $bulan_ini = date('m');
        $rekap_absensi = $this->absensiModel->select('
            COUNT(CASE WHEN status = "H" THEN 1 END) as hadir,
            COUNT(CASE WHEN status = "S" THEN 1 END) as sakit,
            COUNT(CASE WHEN status = "I" THEN 1 END) as izin,
            COUNT(CASE WHEN status = "A" THEN 1 END) as alpha
        ')
            ->where('nis', $nis)
            ->where('MONTH(tanggal)', $bulan_ini)
            ->first();

        // Get tugas with pengumpulan status
        $tugas_list = [];
        if (!empty($siswa['kd_kelas'])) {
            $tugas_list = $this->tugasModel->select('tugas.*, mapel.nama_mapel, guru.nama as nama_guru')
                ->join('mapel', 'mapel.kd_mapel = tugas.kd_mapel')
                ->join('guru', 'guru.nik_nip = tugas.nik_nip')
                ->where('tugas.kd_kelas', $siswa['kd_kelas'])
                ->orderBy('tugas.deadline', 'ASC')
                ->limit(5)
                ->findAll();

            // Add pengumpulan status to each tugas
            foreach ($tugas_list as &$tugas) {
                $pengumpulan = $this->pengumpulanTugasModel
                    ->where('kd_tugas', $tugas['kd_tugas'])
                    ->where('nis', $nis)
                    ->first();

                $tugas['status_pengumpulan'] = $pengumpulan ? $pengumpulan['status'] : 'belum_dikumpulkan';
                $tugas['is_overdue'] = strtotime($tugas['deadline']) < time();
            }
        }

        $data = [
            'title' => 'Dashboard Siswa',
            'siswa' => $siswa,
            'jadwal_hari_ini' => $jadwal_hari_ini,
            'nilai_terbaru' => $nilai_terbaru,
            'rekap_absensi' => $rekap_absensi,
            'tahun_akademik' => $tahunAkademik,
            'user' => [
                'username' => session()->get('username'),
                'foto' => session()->get('foto')
            ],
            'rataRata' => $rataRata,
            'nilaiData' => $nilaiData,
            'tugas_list' => $tugas_list
        ];

        return view('siswa/dashboard', $data);
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
