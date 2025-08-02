<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NilaiModel;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\TahunAkademikModel;

class Nilai extends BaseController
{
    protected $nilaiModel;
    protected $siswaModel;
    protected $kelasModel;
    protected $mapelModel;
    protected $tahunAkademikModel;

    public function __construct()
    {
        $this->nilaiModel = new NilaiModel();
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
        $this->mapelModel = new MapelModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
    }

    public function index()
    {
        $filters = [
            'kd_kelas' => $this->request->getGet('kd_kelas'),
            'kd_mapel' => $this->request->getGet('kd_mapel'),
            'semester' => $this->request->getGet('semester') ?? 'Ganjil'
        ];

        // Get current academic year
        $tahunAkademik = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $tahunAkademikId = $tahunAkademik ? $tahunAkademik['id'] : 1;

        $builder = $this->nilaiModel->select('nilai.*, siswa.nama as nama_siswa, mapel.nama_mapel, kelas.nama_kelas')
            ->join('siswa', 'siswa.nis = nilai.nis')
            ->join('mapel', 'mapel.kd_mapel = nilai.kd_mapel')
            ->join('kelas', 'kelas.kd_kelas = nilai.kd_kelas')
            ->where('nilai.tahun_akademik_id', $tahunAkademikId);

        if ($filters['kd_kelas']) {
            $builder->where('nilai.kd_kelas', $filters['kd_kelas']);
        }

        if ($filters['kd_mapel']) {
            $builder->where('nilai.kd_mapel', $filters['kd_mapel']);
        }

        $builder->where('nilai.semester', $filters['semester']);

        $data = [
            'title' => 'Data Nilai',
            'nilai' => $builder->findAll(),
            'kelas' => $this->kelasModel->findAll(),
            'mapel' => $this->mapelModel->findAll(),
            'filters' => $filters,
            'tahun_akademik' => $tahunAkademik
        ];

        return view('admin/nilai/index', $data);
    }

    public function input()
    {
        $kd_kelas = $this->request->getGet('kd_kelas');
        $kd_mapel = $this->request->getGet('kd_mapel');
        $semester = $this->request->getGet('semester') ?? 'Ganjil';

        // Get current academic year
        $tahunAkademik = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $tahunAkademikId = $tahunAkademik ? $tahunAkademik['id'] : 1;

        $siswa_list = [];
        if ($kd_kelas && $kd_mapel) {
            $siswa_list = $this->siswaModel->select('nis, nama')
                ->where('kd_kelas', $kd_kelas)
                ->findAll();

            // Get existing grades
            foreach ($siswa_list as &$siswa) {
                $nilai = $this->nilaiModel->where([
                    'nis' => $siswa['nis'],
                    'kd_kelas' => $kd_kelas,
                    'kd_mapel' => $kd_mapel,
                    'tahun_akademik_id' => $tahunAkademikId,
                    'semester' => $semester
                ])->first();

                $siswa['nilai'] = $nilai;
            }
        }

        $data = [
            'title' => 'Input Nilai',
            'siswa_list' => $siswa_list,
            'kelas' => $this->kelasModel->findAll(),
            'mapel' => $this->mapelModel->findAll(),
            'selected_kelas' => $kd_kelas,
            'selected_mapel' => $kd_mapel,
            'selected_semester' => $semester,
            'tahun_akademik' => $tahunAkademik
        ];

        return view('admin/nilai/input', $data);
    }

    public function store()
    {
        $kd_kelas = $this->request->getPost('kd_kelas');
        $kd_mapel = $this->request->getPost('kd_mapel');
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
        return redirect()->to("admin/nilai/input?kd_kelas=$kd_kelas&kd_mapel=$kd_mapel&semester=$semester")->with('success', $message);
    }

    public function rekap()
    {
        $kd_kelas = $this->request->getGet('kd_kelas');
        $semester = $this->request->getGet('semester') ?? 'Ganjil';

        // Get current academic year
        $tahunAkademik = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $tahunAkademikId = $tahunAkademik ? $tahunAkademik['id'] : 1;

        $rekap_nilai = [];
        if ($kd_kelas) {
            $rekap_nilai = $this->nilaiModel->select('nilai.*, siswa.nama as nama_siswa, mapel.nama_mapel')
                ->join('siswa', 'siswa.nis = nilai.nis')
                ->join('mapel', 'mapel.kd_mapel = nilai.kd_mapel')
                ->where('nilai.kd_kelas', $kd_kelas)
                ->where('nilai.tahun_akademik_id', $tahunAkademikId)
                ->where('nilai.semester', $semester)
                ->orderBy('siswa.nama', 'ASC')
                ->findAll();
        }

        $data = [
            'title' => 'Rekap Nilai',
            'rekap_nilai' => $rekap_nilai,
            'kelas' => $this->kelasModel->findAll(),
            'selected_kelas' => $kd_kelas,
            'selected_semester' => $semester,
            'tahun_akademik' => $tahunAkademik
        ];

        return view('admin/nilai/rekap', $data);
    }
} 