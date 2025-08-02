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
        $kelas = $this->kelasModel->where('wali_kelas_nik_nip', $guru_id)->findAll();
        return view('guru/raport/index', [
            'title' => 'e-Raport - Pilih Kelas',
            'kelas' => $kelas
        ]);
    }

    public function siswa($kd_kelas)
    {
        $siswa = $this->siswaModel->where('kd_kelas', $kd_kelas)->findAll();
        return view('guru/raport/siswa', [
            'title' => 'e-Raport - Pilih Siswa',
            'siswa' => $siswa,
            'kelas' => $this->kelasModel->find($kd_kelas)
        ]);
    }

    public function detail($nis)
    {
        $siswa = $this->siswaModel->find($nis);
        $kelas = $this->kelasModel->find($siswa['kd_kelas']);
        $nilai = $this->nilaiModel->where('nis', $nis)->findAll();
        $mapel = $this->mapelModel->findAll();
        $absensi = $this->absensiModel->where('nis', $nis)->findAll();
        $ekskul = $this->ekskulSiswaModel
            ->select('ekstrakurikuler_siswa.*, ekstrakurikuler.nama_ekstrakurikuler')
            ->join('ekstrakurikuler', 'ekstrakurikuler.id = ekstrakurikuler_siswa.ekstrakurikuler_id')
            ->where('nis', $nis)
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

    public function preview($nis)
    {
        $siswa = $this->siswaModel->find($nis);
        // Ambil semester aktif
        $tahunAkademikModel = new \App\Models\TahunAkademikModel();
        $tahunAkademikAktif = $tahunAkademikModel->where('status', 'Aktif')->first();
        $semester = $tahunAkademikAktif ? $tahunAkademikAktif['semester'] : 'Ganjil';
        // Ambil kelas beserta nama jurusan
        $kelas = $this->kelasModel
            ->select('kelas.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.kd_jurusan = kelas.kd_jurusan', 'left')
            ->find($siswa['kd_kelas']);
        $nilai = $this->nilaiModel->where('nis', $nis)->where('semester', $semester)->findAll();
        $mapel = $this->mapelModel->findAll();
        $absensi = $this->absensiModel->where('nis', $nis)->findAll();
        $ekskul = $this->ekskulSiswaModel
            ->select('ekstrakurikuler_siswa.*, ekstrakurikuler.nama_ekstrakurikuler')
            ->join('ekstrakurikuler', 'ekstrakurikuler.id = ekstrakurikuler_siswa.ekstrakurikuler_id')
            ->where('nis', $nis)
            ->findAll();
        $wali_kelas = $this->guruModel->find($kelas['wali_kelas_nik_nip']);
        // Ranking siswa dalam kelas (berdasarkan semester aktif)
        $ranking = 0;
        $ranks = $this->nilaiModel->getRankingKelas($kelas['kd_kelas'], $semester);
        foreach ($ranks as $i => $r) {
            if ($r['nis'] == $nis) {
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

        return view('guru/raport/pdf', [
            'siswa' => $siswa,
            'kelas' => $kelas,
            'nilai' => $nilai,
            'mapel' => $mapel,
            'absensi' => $absensi,
            'ekskul' => $ekskul,
            'wali_kelas' => $wali_kelas,
            'ranking' => $ranking,
            'catatan' => $catatan,
            'semester' => $semester,
            'tahunAkademik' => $tahunAkademikAktif
        ]);
    }

    public function cetak($nis)
    {
        $siswa = $this->siswaModel->find($nis);
        // Ambil semester aktif
        $tahunAkademikModel = new \App\Models\TahunAkademikModel();
        $tahunAkademikAktif = $tahunAkademikModel->where('status', 'Aktif')->first();
        $semester = $tahunAkademikAktif ? $tahunAkademikAktif['semester'] : 'Ganjil';
        // Ambil kelas beserta nama jurusan
        $kelas = $this->kelasModel
            ->select('kelas.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.kd_jurusan = kelas.kd_jurusan', 'left')
            ->find($siswa['kd_kelas']);
        $nilai = $this->nilaiModel->where('nis', $nis)->where('semester', $semester)->findAll();
        $mapel = $this->mapelModel->findAll();
        $absensi = $this->absensiModel->where('nis', $nis)->findAll();
        $ekskul = $this->ekskulSiswaModel
            ->select('ekstrakurikuler_siswa.*, ekstrakurikuler.nama_ekstrakurikuler')
            ->join('ekstrakurikuler', 'ekstrakurikuler.id = ekstrakurikuler_siswa.ekstrakurikuler_id')
            ->where('nis', $nis)
            ->findAll();
        $wali_kelas = $this->guruModel->find($kelas['wali_kelas_nik_nip']);
        // Ranking siswa dalam kelas (berdasarkan semester aktif)
        $ranking = 0;
        $ranks = $this->nilaiModel->getRankingKelas($kelas['kd_kelas'], $semester);
        foreach ($ranks as $i => $r) {
            if ($r['nis'] == $nis) {
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
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('e-raport-' . $siswa['nama'] . '.pdf');
    }

    public function generatePDF($nis)
    {
        $siswa = $this->siswaModel->find($nis);
        $tahunAkademikModel = new \App\Models\TahunAkademikModel();
        $tahunAkademikAktif = $tahunAkademikModel->where('status', 'Aktif')->first();
        $semester = $tahunAkademikAktif ? $tahunAkademikAktif['semester'] : 'Ganjil';
        $kelas = $this->kelasModel
            ->select('kelas.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.kd_jurusan = kelas.kd_jurusan', 'left')
            ->find($siswa['kd_kelas']);
        $nilai = $this->nilaiModel->where('nis', $nis)->where('semester', $semester)->findAll();
        $mapel = $this->mapelModel->findAll();
        $absensi = $this->absensiModel->where('nis', $nis)->findAll();
        $ekskul = $this->ekskulSiswaModel
            ->select('ekstrakurikuler_siswa.*, ekstrakurikuler.nama_ekstrakurikuler')
            ->join('ekstrakurikuler', 'ekstrakurikuler.id = ekstrakurikuler_siswa.ekstrakurikuler_id')
            ->where('nis', $nis)
            ->findAll();
        $wali_kelas = $this->guruModel->find($kelas['wali_kelas_nik_nip']);
        $ranking = 0;
        $ranks = $this->nilaiModel->getRankingKelas($kelas['kd_kelas'], $semester);
        foreach ($ranks as $i => $r) {
            if ($r['nis'] == $nis) {
                $ranking = $i + 1;
                break;
            }
        }
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
            'semester' => $semester,
            'tahunAkademik' => $tahunAkademikAktif
        ]);
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        // Output PDF ke browser tanpa auto download
        $dompdf->stream('e-raport-' . $siswa['nama'] . '-' . $semester . '.pdf', ['Attachment' => false]);
    }
}
