<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use App\Models\NilaiModel;
use App\Models\MapelModel;
use App\Models\AbsensiModel;
use App\Models\EkstrakurikulerSiswaModel;
use App\Models\EkstrakurikulerModel;
use App\Models\GuruModel;
use Dompdf\Dompdf;

class Raport extends BaseController
{
    protected $kelasModel;
    protected $siswaModel;
    protected $nilaiModel;
    protected $mapelModel;
    protected $absensiModel;
    protected $ekskulSiswaModel;
    protected $ekskulModel;
    protected $guruModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->siswaModel = new SiswaModel();
        $this->nilaiModel = new NilaiModel();
        $this->mapelModel = new MapelModel();
        $this->absensiModel = new AbsensiModel();
        $this->ekskulSiswaModel = new EkstrakurikulerSiswaModel();
        $this->ekskulModel = new EkstrakurikulerModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        // Daftar kelas yang diampu guru ini
        $guru_id = session()->get('guru_id');
        $kelas = $this->kelasModel->where('wali_kelas_id', $guru_id)->findAll();
        return view('guru/raport/index', [
            'title' => 'e-Raport - Pilih Kelas',
            'kelas' => $kelas
        ]);
    }

    public function siswa($kelas_id)
    {
        $siswa = $this->siswaModel->where('kelas_id', $kelas_id)->findAll();
        return view('guru/raport/siswa', [
            'title' => 'e-Raport - Pilih Siswa',
            'siswa' => $siswa,
            'kelas' => $this->kelasModel->find($kelas_id)
        ]);
    }

    public function detail($siswa_id)
    {
        $siswa = $this->siswaModel->find($siswa_id);
        $kelas = $this->kelasModel->find($siswa['kelas_id']);
        $nilai = $this->nilaiModel->where('siswa_id', $siswa_id)->findAll();
        $mapel = $this->mapelModel->findAll();
        $absensi = $this->absensiModel->where('siswa_id', $siswa_id)->findAll();
        $ekskul = $this->ekskulSiswaModel
            ->select('ekstrakurikuler_siswa.*, ekstrakurikuler.nama_ekstrakurikuler')
            ->join('ekstrakurikuler', 'ekstrakurikuler.id = ekstrakurikuler_siswa.ekstrakurikuler_id')
            ->where('siswa_id', $siswa_id)
            ->findAll();
        return view('guru/raport/detail', [
            'title' => 'e-Raport Siswa',
            'siswa' => $siswa,
            'kelas' => $kelas,
            'nilai' => $nilai,
            'mapel' => $mapel,
            'absensi' => $absensi,
            'ekskul' => $ekskul
        ]);
    }

    public function cetak($siswa_id)
    {
        $siswa = $this->siswaModel->find($siswa_id);
        // Ambil semester aktif
        $tahunAkademikModel = new \App\Models\TahunAkademikModel();
        $tahunAkademikAktif = $tahunAkademikModel->where('status', 'Aktif')->first();
        $semester = $tahunAkademikAktif ? $tahunAkademikAktif['semester'] : 'Ganjil';
        // Ambil kelas beserta nama jurusan
        $kelas = $this->kelasModel
            ->select('kelas.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id', 'left')
            ->find($siswa['kelas_id']);
        $nilai = $this->nilaiModel->where('siswa_id', $siswa_id)->where('semester', $semester)->findAll();
        $mapel = $this->mapelModel->findAll();
        $absensi = $this->absensiModel->where('siswa_id', $siswa_id)->findAll();
        $ekskul = $this->ekskulSiswaModel
            ->select('ekstrakurikuler_siswa.*, ekstrakurikuler.nama_ekstrakurikuler')
            ->join('ekstrakurikuler', 'ekstrakurikuler.id = ekstrakurikuler_siswa.ekstrakurikuler_id')
            ->where('siswa_id', $siswa_id)
            ->findAll();
        $wali_kelas = $this->guruModel->find($kelas['wali_kelas_id']);
        // Ranking siswa dalam kelas (berdasarkan semester aktif)
        $ranking = 0;
        $ranks = $this->nilaiModel->getRankingKelas($kelas['id'], $semester);
        foreach ($ranks as $i => $r) {
            if ($r['id'] == $siswa_id) {
                $ranking = $i + 1;
                break;
            }
        }
        // Catatan wali kelas
        if ($ranking == 1) {
            $catatan = 'Selamat atas pencapaian luar biasa yang telah diraih. Pertahankan semangat belajar dan teruslah menjadi inspirasi bagi teman-teman di kelas. Semoga prestasimu semakin gemilang di masa depan.';
        } elseif ($ranking >= 2 && $ranking <= 10) {
            $catatan = 'Hasil belajar yang baik, terus tingkatkan semangat dan konsistensi dalam belajar. Dengan kerja keras dan disiplin, kamu bisa meraih hasil yang lebih tinggi lagi. Pertahankan prestasi ini!';
        } else {
            $catatan = 'Terus semangat dalam belajar. Jadikan semester ini sebagai motivasi untuk memperbaiki dan meningkatkan prestasi di masa mendatang.';
        }
        $html = view('guru/raport/pdf', [
            'siswa' => $siswa,
            'kelas' => $kelas,
            'nilai' => $nilai,
            'mapel' => $mapel,
            'absensi' => $absensi,
            'ekskul' => $ekskul,
            'wali_kelas' => $wali_kelas,
            'ranking' => $ranking,
            'catatan' => $catatan,
            'semester' => $semester
        ]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('e-raport-'.$siswa['nama'].'.pdf');
    }
} 