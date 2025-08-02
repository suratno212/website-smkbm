<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\NilaiModel;
use App\Models\SiswaModel;
use App\Models\JadwalModel;
use App\Models\GuruModel;
use App\Models\TahunAkademikModel;

class Nilai extends BaseController
{
    protected $nilaiModel;
    protected $siswaModel;
    protected $jadwalModel;
    protected $guruModel;
    protected $tahunAkademikModel;

    public function __construct()
    {
        $this->nilaiModel = new NilaiModel();
        $this->siswaModel = new SiswaModel();
        $this->jadwalModel = new JadwalModel();
        $this->guruModel = new GuruModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
    }

    public function index()
    {
        $nik_nip = session()->get('nik_nip');
        $guru = $this->guruModel->find($nik_nip);

        // Get classes taught by this guru
        $kelas_diampu = $this->jadwalModel->select('DISTINCT(kelas.kd_kelas), kelas.nama_kelas')
            ->join('kelas', 'kelas.kd_kelas = jadwal.kd_kelas')
            ->where('jadwal.nik_nip', $nik_nip)
            ->findAll();

        // Get classes where this guru is wali kelas
        $kelasModel = new \App\Models\KelasModel();
        $kelas_wali = $kelasModel->where('wali_kelas_nik_nip', $nik_nip)->findAll();

        // Gabungkan kelas diampu dan kelas wali (tanpa duplikat)
        $all_kelas = $kelas_diampu;
        foreach ($kelas_wali as $kw) {
            $found = false;
            foreach ($all_kelas as $k) {
                if ($k['kd_kelas'] == $kw['kd_kelas']) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $all_kelas[] = [
                    'kd_kelas' => $kw['kd_kelas'],
                    'nama_kelas' => $kw['nama_kelas']
                ];
            }
        }

        $kd_kelas_diampu = array_column($all_kelas, 'kd_kelas');
        $kelasList = [];
        if (!empty($kd_kelas_diampu)) {
            $allKelas = $kelasModel->getKelasWithJurusan();
            foreach ($allKelas as $k) {
                if (in_array($k['kd_kelas'], $kd_kelas_diampu)) {
                    $kelasList[] = $k;
                }
            }
        }
        $mapelList = [];
        // Ambil mapel yang diajar guru
        if ($guru && isset($guru['kd_mapel'])) {
            $mapelList[] = [
                'id' => $guru['kd_mapel'],
                'nama_mapel' => $guru['kd_mapel'] // atau ambil nama mapel dari tabel mapel jika perlu
            ];
        }
        $data = [
            'title' => 'Input Nilai',
            'guru' => $guru,
            'kelas_diampu' => $kelas_diampu,
            'kelasList' => $kelasList,
            'mapelList' => $mapelList
        ];

        return view('guru/nilai/index', $data);
    }

    public function input()
    {
        $nik_nip = session()->get('nik_nip');
        $kd_kelas = $this->request->getGet('kd_kelas');
        $semester = $this->request->getGet('semester') ?? 'Ganjil';

        // Get current academic year
        $tahunAkademik = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $tahunAkademikId = $tahunAkademik ? $tahunAkademik['kd_tahun_akademik'] : 1;

        // Get students in the class
        $siswa_list = [];
        if ($kd_kelas) {
            $siswa_list = $this->siswaModel->select('nis, nama')
                ->where('kd_kelas', $kd_kelas)
                ->findAll();

            // Get existing grades
            foreach ($siswa_list as &$siswa) {
                $nilai = $this->nilaiModel->where([
                    'nis' => $siswa['nis'],
                    'kd_kelas' => $kd_kelas,
                    'kd_mapel' => $this->guruModel->find($nik_nip)['kd_mapel'],
                    'tahun_akademik_id' => $tahunAkademikId,
                    'semester' => $semester
                ])->first();

                $siswa['nilai'] = $nilai;
            }
        }

        $kelas = null;
        $mapel = null;
        if ($kd_kelas) {
            $kelasModel = new \App\Models\KelasModel();
            $kelas = $kelasModel->find($kd_kelas);
            $guru = $this->guruModel->find($nik_nip);
            if ($guru && isset($guru['kd_mapel'])) {
                $mapelModel = new \App\Models\MapelModel();
                $mapel = $mapelModel->where('kd_mapel', $guru['kd_mapel'])->first();
            }
        }
        $data = [
            'title' => 'Input Nilai',
            'siswa_list' => $siswa_list,
            'selected_kelas' => $kd_kelas,
            'selected_semester' => $semester,
            'tahun_akademik' => $tahunAkademik,
            'tahun_akademik_id' => $tahunAkademikId,
            'kelas' => $kelas,
            'mapel' => $mapel,
            'semester' => $semester
        ];

        return view('guru/nilai/input', $data);
    }

    public function store()
    {
        $nik_nip = session()->get('nik_nip');
        $kd_kelas = $this->request->getPost('kd_kelas');
        $kd_mapel = $this->guruModel->find($nik_nip)['kd_mapel'];
        $semester = $this->request->getPost('semester');
        $tahun_akademik_id = $this->request->getPost('tahun_akademik_id');

        $nis_list = $this->request->getPost('nis');
        $nilai_tugas = $this->request->getPost('nilai_tugas');
        $nilai_uts = $this->request->getPost('nilai_uts');
        $nilai_uas = $this->request->getPost('nilai_uas');

        $inserted = 0;
        $updated = 0;

        foreach ($nis_list as $index => $nis) {
            if ($nis) {
                $tugas = $nilai_tugas[$index] ?? 0;
                $uts = $nilai_uts[$index] ?? 0;
                $uas = $nilai_uas[$index] ?? 0;

                // Calculate final grade
                $akhir = ($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4);

                $nilaiData = [
                    'nis' => $nis,
                    'kd_kelas' => $kd_kelas,
                    'kd_mapel' => $kd_mapel,
                    'kd_jurusan' => $this->siswaModel->find($nis)['kd_jurusan'],
                    'tahun_akademik_id' => $tahun_akademik_id,
                    'semester' => $semester,
                    'nilai_tugas' => $tugas,
                    'nilai_uts' => $uts,
                    'nilai_uas' => $uas,
                    'nilai_akhir' => round($akhir, 2)
                ];

                // Check if grade already exists
                $existing = $this->nilaiModel->where([
                    'nis' => $nis,
                    'kd_kelas' => $kd_kelas,
                    'kd_mapel' => $kd_mapel,
                    'tahun_akademik_id' => $tahun_akademik_id,
                    'semester' => $semester
                ])->first();

                if ($existing) {
                    $this->nilaiModel->update($existing['id'], $nilaiData);
                    $updated++;
                } else {
                    $this->nilaiModel->insert($nilaiData);
                    $inserted++;
                }
            }
        }

        $message = "Berhasil menyimpan nilai: $inserted baru, $updated diperbarui";
        return redirect()->to("guru/nilai/input?kd_kelas=$kd_kelas&semester=$semester")->with('success', $message);
    }

    public function rekap()
    {
        $nik_nip = session()->get('nik_nip');
        $kd_kelas = $this->request->getGet('kd_kelas');
        $semester = $this->request->getGet('semester') ?? 'Ganjil';

        // Get current academic year
        $tahunAkademik = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $tahunAkademikId = $tahunAkademik ? $tahunAkademik['kd_tahun_akademik'] : 1;

        $rekap_nilai = [];
        if ($kd_kelas) {
            $rekap_nilai = $this->nilaiModel->select('nilai.*, siswa.nama as nama_siswa')
                ->join('siswa', 'siswa.nis = nilai.nis')
                ->where('nilai.kd_kelas', $kd_kelas)
                ->where('nilai.kd_mapel', $this->guruModel->find($nik_nip)['kd_mapel'])
                ->where('nilai.tahun_akademik_id', $tahunAkademikId)
                ->where('nilai.semester', $semester)
                ->orderBy('siswa.nama', 'ASC')
                ->findAll();
        }

        $kelas = null;
        if ($kd_kelas) {
            $kelasModel = new \App\Models\KelasModel();
            $kelas = $kelasModel->find($kd_kelas);
        }
        $siswaList = [];
        if ($kd_kelas) {
            $siswaList = $this->siswaModel->select('nis, nama')->where('kd_kelas', $kd_kelas)->findAll();
        }
        $mapelList = [];
        $guru = $this->guruModel->find($nik_nip);
        if ($guru && isset($guru['kd_mapel'])) {
            $mapelModel = new \App\Models\MapelModel();
            $mapel = $mapelModel->where('kd_mapel', $guru['kd_mapel'])->first();
            if ($mapel) {
                $mapelList[] = $mapel;
            }
        }
        $data = [
            'title' => 'Rekap Nilai',
            'rekap_nilai' => $rekap_nilai,
            'selected_kelas' => $kd_kelas,
            'selected_semester' => $semester,
            'tahun_akademik' => $tahunAkademik,
            'kelas' => $kelas,
            'semester' => $semester,
            'siswaList' => $siswaList,
            'mapelList' => $mapelList
        ];

        return view('guru/nilai/rekap', $data);
    }

    public function cetak()
    {
        $nik_nip = session()->get('nik_nip');
        $kelas_id = $this->request->getGet('kelas_id');
        $semester = $this->request->getGet('semester') ?? 'Ganjil';

        // Get current academic year
        $tahunAkademik = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $tahunAkademikId = $tahunAkademik ? $tahunAkademik['kd_tahun_akademik'] : 1;

        // Ambil data nilai siswa di kelas dan semester tersebut
        $nilai_list = $this->nilaiModel->select('nilai.*, siswa.nama as nama_siswa')
            ->join('siswa', 'siswa.nis = nilai.nis')
            ->where('nilai.kd_kelas', $kelas_id)
            ->where('nilai.kd_mapel', $this->guruModel->find($nik_nip)['kd_mapel'])
            ->where('nilai.tahun_akademik_id', $tahunAkademikId)
            ->where('nilai.semester', $semester)
            ->orderBy('siswa.nama', 'ASC')
            ->findAll();

        $kelasModel = new \App\Models\KelasModel();
        $kelas = $kelasModel->find($kelas_id);

        $mapelModel = new \App\Models\MapelModel();
        $guru = $this->guruModel->find($nik_nip);
        $mapel = $mapelModel->where('kd_mapel', $guru['kd_mapel'])->first();

        return view('guru/nilai/cetak', [
            'nilai_list' => $nilai_list,
            'kelas' => $kelas,
            'mapel' => $mapel,
            'semester' => $semester,
            'tahun_akademik' => $tahunAkademik
        ]);
    }
}
