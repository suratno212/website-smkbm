<?php
namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\NilaiModel;
use App\Models\SiswaModel;
use App\Models\MapelModel;
use App\Models\KelasModel;
use App\Models\TahunAkademikModel;
use App\Models\AbsensiModel;
use App\Models\EkstrakurikulerSiswaModel;
use App\Models\EkstrakurikulerModel;
use App\Models\GuruModel;
use Dompdf\Dompdf;

class Nilai extends BaseController
{
    protected $nilaiModel;
    protected $siswaModel;
    protected $mapelModel;
    protected $kelasModel;
    protected $tahunAkademikModel;
    protected $absensiModel;
    protected $ekskulSiswaModel;
    protected $ekskulModel;
    protected $guruModel;

    public function __construct()
    {
        $this->nilaiModel = new NilaiModel();
        $this->siswaModel = new SiswaModel();
        $this->mapelModel = new MapelModel();
        $this->kelasModel = new KelasModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
        $this->absensiModel = new AbsensiModel();
        $this->ekskulSiswaModel = new EkstrakurikulerSiswaModel();
        $this->ekskulModel = new EkstrakurikulerModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        $siswa_id = session('user_id');
        $siswa = $this->siswaModel->where('user_id', $siswa_id)->first();
        
        if (!$siswa) {
            return redirect()->to('/siswa/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        // Ambil tahun akademik aktif
        $tahunAkademikAktif = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $semester = $tahunAkademikAktif ? $tahunAkademikAktif['semester'] : 'Ganjil';

        // Ambil data kelas dan jurusan
        $kelas = $this->kelasModel->select('kelas.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->find($siswa['kelas_id']);

        // Ambil semua nilai siswa untuk semester aktif
        $nilai = $this->nilaiModel->select('nilai.*, mapel.nama_mapel')
            ->join('mapel', 'mapel.id = nilai.mapel_id')
            ->where('nilai.siswa_id', $siswa['id'])
            ->where('nilai.semester', $semester)
            ->where('nilai.tahun_akademik_id', $tahunAkademikAktif['id'])
            ->findAll();

        // Hitung rata-rata nilai
        $rataRata = $this->nilaiModel->getRataRataSiswa($siswa['id'], $semester);

        // Ambil ranking dalam kelas
        $ranking = $this->nilaiModel->getRankingKelas($siswa['kelas_id'], $semester);
        $peringkat = 0;
        foreach ($ranking as $i => $r) {
            if ($r['id'] == $siswa['id']) {
                $peringkat = $i + 1;
                break;
            }
        }

        // Statistik nilai
        $statistik = $this->nilaiModel->getStatistikNilai($siswa['kelas_id'], $semester);

        return view('siswa/nilai/index', [
            'title' => 'Nilai Akademik',
            'siswa' => $siswa,
            'kelas' => $kelas,
            'nilai' => $nilai,
            'semester' => $semester,
            'tahunAkademik' => $tahunAkademikAktif,
            'rataRata' => $rataRata,
            'peringkat' => $peringkat,
            'statistik' => $statistik
        ]);
    }

    public function detail($mapel_id)
    {
        $siswa_id = session('user_id');
        $siswa = $this->siswaModel->where('user_id', $siswa_id)->first();
        
        if (!$siswa) {
            return redirect()->to('/siswa/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        // Ambil tahun akademik aktif
        $tahunAkademikAktif = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $semester = $tahunAkademikAktif ? $tahunAkademikAktif['semester'] : 'Ganjil';

        // Ambil detail nilai mata pelajaran
        $nilai = $this->nilaiModel->select('nilai.*, mapel.nama_mapel')
            ->join('mapel', 'mapel.id = nilai.mapel_id')
            ->where('nilai.siswa_id', $siswa['id'])
            ->where('nilai.mapel_id', $mapel_id)
            ->where('nilai.semester', $semester)
            ->where('nilai.tahun_akademik_id', $tahunAkademikAktif['id'])
            ->first();

        if (!$nilai) {
            return redirect()->to('/siswa/nilai')->with('error', 'Nilai mata pelajaran tidak ditemukan');
        }

        // Ambil data kelas
        $kelas = $this->kelasModel->select('kelas.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->find($siswa['kelas_id']);

        // Ambil rata-rata kelas untuk mata pelajaran ini
        $rataRataKelas = $this->nilaiModel->select('AVG(akhir) as rata_rata')
            ->join('siswa', 'siswa.id = nilai.siswa_id')
            ->where('siswa.kelas_id', $siswa['kelas_id'])
            ->where('nilai.mapel_id', $mapel_id)
            ->where('nilai.semester', $semester)
            ->where('nilai.tahun_akademik_id', $tahunAkademikAktif['id'])
            ->where('nilai.akhir >', 0)
            ->first();

        return view('siswa/nilai/detail', [
            'title' => 'Detail Nilai',
            'siswa' => $siswa,
            'kelas' => $kelas,
            'nilai' => $nilai,
            'semester' => $semester,
            'tahunAkademik' => $tahunAkademikAktif,
            'rataRataKelas' => $rataRataKelas ? floatval($rataRataKelas['rata_rata']) : 0
        ]);
    }

    public function raport()
    {
        $siswa_id = session('user_id');
        $siswa = $this->siswaModel->where('user_id', $siswa_id)->first();
        
        if (!$siswa) {
            return redirect()->to('/siswa/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        // Ambil tahun akademik aktif
        $tahunAkademikAktif = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $semester = $tahunAkademikAktif ? $tahunAkademikAktif['semester'] : 'Ganjil';

        // Ambil data kelas dan wali kelas
        $kelas = $this->kelasModel->select('kelas.*, jurusan.nama_jurusan, guru.nama as nama_wali_kelas')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->join('guru', 'guru.id = kelas.wali_kelas_id', 'left')
            ->find($siswa['kelas_id']);

        // Ambil semua nilai
        $nilai = $this->nilaiModel->select('nilai.*, mapel.nama_mapel')
            ->join('mapel', 'mapel.id = nilai.mapel_id')
            ->where('nilai.siswa_id', $siswa['id'])
            ->where('nilai.semester', $semester)
            ->where('nilai.tahun_akademik_id', $tahunAkademikAktif['id'])
            ->findAll();

        // Ambil data absensi
        $absensi = $this->absensiModel->where('siswa_id', $siswa['id'])->findAll();

        // Hitung statistik absensi
        $totalAbsensi = count($absensi);
        $hadir = count(array_filter($absensi, function($a) { return $a['status'] == 'Hadir'; }));
        $sakit = count(array_filter($absensi, function($a) { return $a['status'] == 'Sakit'; }));
        $izin = count(array_filter($absensi, function($a) { return $a['status'] == 'Izin'; }));
        $alpha = count(array_filter($absensi, function($a) { return $a['status'] == 'Alpha'; }));

        // Ambil data ekstrakurikuler
        $ekskul = $this->ekskulSiswaModel->select('ekstrakurikuler_siswa.*, ekstrakurikuler.nama_ekstrakurikuler')
            ->join('ekstrakurikuler', 'ekstrakurikuler.id = ekstrakurikuler_siswa.ekstrakurikuler_id')
            ->where('siswa_id', $siswa['id'])
            ->where('tahun_akademik_id', $tahunAkademikAktif['id'])
            ->findAll();

        // Hitung rata-rata nilai
        $rataRata = $this->nilaiModel->getRataRataSiswa($siswa['id'], $semester);

        // Ambil ranking dalam kelas
        $ranking = $this->nilaiModel->getRankingKelas($siswa['kelas_id'], $semester);
        $peringkat = 0;
        foreach ($ranking as $i => $r) {
            if ($r['id'] == $siswa['id']) {
                $peringkat = $i + 1;
                break;
            }
        }

        return view('siswa/nilai/raport', [
            'title' => 'e-Raport',
            'siswa' => $siswa,
            'kelas' => $kelas,
            'nilai' => $nilai,
            'semester' => $semester,
            'tahunAkademik' => $tahunAkademikAktif,
            'absensi' => [
                'total' => $totalAbsensi,
                'hadir' => $hadir,
                'sakit' => $sakit,
                'izin' => $izin,
                'alpha' => $alpha
            ],
            'ekskul' => $ekskul,
            'rataRata' => $rataRata,
            'peringkat' => $peringkat
        ]);
    }

    public function cetakRaport()
    {
        $siswa_id = session('user_id');
        $siswa = $this->siswaModel->where('user_id', $siswa_id)->first();
        
        if (!$siswa) {
            return redirect()->to('/siswa/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        // Ambil tahun akademik aktif
        $tahunAkademikAktif = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $semester = $tahunAkademikAktif ? $tahunAkademikAktif['semester'] : 'Ganjil';

        // Ambil data kelas dan wali kelas
        $kelas = $this->kelasModel->select('kelas.*, jurusan.nama_jurusan, guru.nama as nama_wali_kelas')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->join('guru', 'guru.id = kelas.wali_kelas_id', 'left')
            ->find($siswa['kelas_id']);

        // Ambil data wali kelas lengkap
        $wali_kelas = null;
        if ($kelas['wali_kelas_id']) {
            $wali_kelas = $this->guruModel->find($kelas['wali_kelas_id']);
        }

        // Ambil semua nilai
        $nilai = $this->nilaiModel->select('nilai.*, mapel.nama_mapel')
            ->join('mapel', 'mapel.id = nilai.mapel_id')
            ->where('nilai.siswa_id', $siswa['id'])
            ->where('nilai.semester', $semester)
            ->where('nilai.tahun_akademik_id', $tahunAkademikAktif['id'])
            ->findAll();

        // Ambil semua mapel untuk referensi
        $mapel = $this->mapelModel->findAll();

        // Ambil data absensi
        $absensi = $this->absensiModel->where('siswa_id', $siswa['id'])->findAll();

        // Ambil data ekstrakurikuler
        $ekskul = $this->ekskulSiswaModel->select('ekstrakurikuler_siswa.*, ekstrakurikuler.nama_ekstrakurikuler')
            ->join('ekstrakurikuler', 'ekstrakurikuler.id = ekstrakurikuler_siswa.ekstrakurikuler_id')
            ->where('siswa_id', $siswa['id'])
            ->where('tahun_akademik_id', $tahunAkademikAktif['id'])
            ->findAll();

        // Hitung rata-rata nilai
        $rataRata = $this->nilaiModel->getRataRataSiswa($siswa['id'], $semester);

        // Ambil ranking dalam kelas
        $ranking = $this->nilaiModel->getRankingKelas($siswa['kelas_id'], $semester);
        $peringkat = 0;
        foreach ($ranking as $i => $r) {
            if ($r['id'] == $siswa['id']) {
                $peringkat = $i + 1;
                break;
            }
        }

        // Catatan wali kelas berdasarkan ranking
        if ($peringkat == 1) {
            $catatan = 'Selamat atas pencapaian luar biasa yang telah diraih. Pertahankan semangat belajar dan teruslah menjadi inspirasi bagi teman-teman di kelas. Semoga prestasimu semakin gemilang di masa depan.';
        } elseif ($peringkat >= 2 && $peringkat <= 10) {
            $catatan = 'Hasil belajar yang baik, terus tingkatkan semangat dan konsistensi dalam belajar. Dengan kerja keras dan disiplin, kamu bisa meraih hasil yang lebih tinggi lagi. Pertahankan prestasi ini!';
        } else {
            $catatan = 'Terus semangat dalam belajar. Jadikan semester ini sebagai motivasi untuk memperbaiki dan meningkatkan prestasi di masa mendatang.';
        }

        return view('siswa/nilai/cetak_raport', [
            'title' => 'Cetak e-Raport',
            'siswa' => $siswa,
            'kelas' => $kelas,
            'nilai' => $nilai,
            'mapel' => $mapel,
            'semester' => $semester,
            'tahunAkademik' => $tahunAkademikAktif,
            'absensi' => $absensi,
            'ekskul' => $ekskul,
            'rataRata' => $rataRata,
            'ranking' => $peringkat,
            'wali_kelas' => $wali_kelas,
            'catatan' => $catatan
        ]);
    }

    public function generatePDF()
    {
        $siswa_id = session('user_id');
        $siswa = $this->siswaModel->where('user_id', $siswa_id)->first();
        
        if (!$siswa) {
            return redirect()->to('/siswa/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        // Ambil tahun akademik aktif
        $tahunAkademikAktif = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $semester = $tahunAkademikAktif ? $tahunAkademikAktif['semester'] : 'Ganjil';

        // Ambil data kelas dan wali kelas
        $kelas = $this->kelasModel->select('kelas.*, jurusan.nama_jurusan, guru.nama as nama_wali_kelas')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->join('guru', 'guru.id = kelas.wali_kelas_id', 'left')
            ->find($siswa['kelas_id']);

        // Ambil data wali kelas lengkap
        $wali_kelas = null;
        if ($kelas['wali_kelas_id']) {
            $wali_kelas = $this->guruModel->find($kelas['wali_kelas_id']);
        }

        // Ambil semua nilai
        $nilai = $this->nilaiModel->select('nilai.*, mapel.nama_mapel')
            ->join('mapel', 'mapel.id = nilai.mapel_id')
            ->where('nilai.siswa_id', $siswa['id'])
            ->where('nilai.semester', $semester)
            ->where('nilai.tahun_akademik_id', $tahunAkademikAktif['id'])
            ->findAll();

        // Ambil semua mapel untuk referensi
        $mapel = $this->mapelModel->findAll();

        // Ambil data absensi
        $absensi = $this->absensiModel->where('siswa_id', $siswa['id'])->findAll();

        // Ambil data ekstrakurikuler
        $ekskul = $this->ekskulSiswaModel->select('ekstrakurikuler_siswa.*, ekstrakurikuler.nama_ekstrakurikuler')
            ->join('ekstrakurikuler', 'ekstrakurikuler.id = ekstrakurikuler_siswa.ekstrakurikuler_id')
            ->where('siswa_id', $siswa['id'])
            ->where('tahun_akademik_id', $tahunAkademikAktif['id'])
            ->findAll();

        // Hitung rata-rata nilai
        $rataRata = $this->nilaiModel->getRataRataSiswa($siswa['id'], $semester);

        // Ambil ranking dalam kelas
        $ranking = $this->nilaiModel->getRankingKelas($siswa['kelas_id'], $semester);
        $peringkat = 0;
        foreach ($ranking as $i => $r) {
            if ($r['id'] == $siswa['id']) {
                $peringkat = $i + 1;
                break;
            }
        }

        // Catatan wali kelas berdasarkan ranking
        if ($peringkat == 1) {
            $catatan = 'Selamat atas pencapaian luar biasa yang telah diraih. Pertahankan semangat belajar dan teruslah menjadi inspirasi bagi teman-teman di kelas. Semoga prestasimu semakin gemilang di masa depan.';
        } elseif ($peringkat >= 2 && $peringkat <= 10) {
            $catatan = 'Hasil belajar yang baik, terus tingkatkan semangat dan konsistensi dalam belajar. Dengan kerja keras dan disiplin, kamu bisa meraih hasil yang lebih tinggi lagi. Pertahankan prestasi ini!';
        } else {
            $catatan = 'Terus semangat dalam belajar. Jadikan semester ini sebagai motivasi untuk memperbaiki dan meningkatkan prestasi di masa mendatang.';
        }

        // Generate HTML untuk PDF menggunakan view cetak_raport yang sudah ada
        $html = view('siswa/nilai/cetak_raport', [
            'siswa' => $siswa,
            'kelas' => $kelas,
            'nilai' => $nilai,
            'mapel' => $mapel,
            'semester' => $semester,
            'tahunAkademik' => $tahunAkademikAktif,
            'absensi' => $absensi,
            'ekskul' => $ekskul,
            'rataRata' => $rataRata,
            'ranking' => $peringkat,
            'wali_kelas' => $wali_kelas,
            'catatan' => $catatan
        ]);

        // Generate PDF
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Output PDF
        $dompdf->stream('e-raport-' . $siswa['nama'] . '-' . $semester . '.pdf', ['Attachment' => false]);
    }

    public function statistik()
    {
        $siswa_id = session('user_id');
        $siswa = $this->siswaModel->where('user_id', $siswa_id)->first();
        
        if (!$siswa) {
            return redirect()->to('/siswa/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        // Ambil tahun akademik aktif
        $tahunAkademikAktif = $this->tahunAkademikModel->where('status', 'Aktif')->first();
        $semester = $tahunAkademikAktif ? $tahunAkademikAktif['semester'] : 'Ganjil';

        // Ambil data kelas
        $kelas = $this->kelasModel->select('kelas.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->find($siswa['kelas_id']);

        // Ambil semua nilai
        $nilai = $this->nilaiModel->select('nilai.*, mapel.nama_mapel')
            ->join('mapel', 'mapel.id = nilai.mapel_id')
            ->where('nilai.siswa_id', $siswa['id'])
            ->where('nilai.semester', $semester)
            ->where('nilai.tahun_akademik_id', $tahunAkademikAktif['id'])
            ->findAll();

        // Hitung rata-rata nilai
        $rataRata = $this->nilaiModel->getRataRataSiswa($siswa['id'], $semester);

        // Ambil ranking dalam kelas
        $ranking = $this->nilaiModel->getRankingKelas($siswa['kelas_id'], $semester);
        $peringkat = 0;
        foreach ($ranking as $i => $r) {
            if ($r['id'] == $siswa['id']) {
                $peringkat = $i + 1;
                break;
            }
        }

        // Statistik nilai
        $statistik = $this->nilaiModel->getStatistikNilai($siswa['kelas_id'], $semester);

        // Kategori nilai
        $kategoriNilai = [
            'A' => 0, // 90-100
            'B' => 0, // 80-89
            'C' => 0, // 70-79
            'D' => 0, // 60-69
            'E' => 0  // <60
        ];

        foreach ($nilai as $n) {
            if ($n['akhir'] >= 90) $kategoriNilai['A']++;
            elseif ($n['akhir'] >= 80) $kategoriNilai['B']++;
            elseif ($n['akhir'] >= 70) $kategoriNilai['C']++;
            elseif ($n['akhir'] >= 60) $kategoriNilai['D']++;
            else $kategoriNilai['E']++;
        }

        return view('siswa/nilai/statistik', [
            'title' => 'Statistik Nilai',
            'siswa' => $siswa,
            'kelas' => $kelas,
            'nilai' => $nilai,
            'semester' => $semester,
            'tahunAkademik' => $tahunAkademikAktif,
            'rataRata' => $rataRata,
            'peringkat' => $peringkat,
            'statistik' => $statistik,
            'kategoriNilai' => $kategoriNilai
        ]);
    }
} 