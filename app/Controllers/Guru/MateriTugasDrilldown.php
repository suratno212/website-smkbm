<?php
namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\MapelModel;
use App\Models\KelasModel;
use App\Models\PertemuanModel;
use App\Models\MateriModel;
use App\Models\TugasModel;
use App\Models\PretestModel;
use App\Models\PretestSoalModel;
use App\Models\JadwalModel;
use App\Models\SiswaModel;

class MateriTugasDrilldown extends BaseController
{
    public function mapel()
    {
        $guru_id = session('user_id');
        $jadwalModel = new JadwalModel();
        $mapel = $jadwalModel->select('mapel.id, mapel.nama_mapel')
            ->join('mapel', 'mapel.id = jadwal.mapel_id')
            ->where('jadwal.guru_id', $guru_id)
            ->groupBy('mapel.id, mapel.nama_mapel')
            ->findAll();
        return view('guru/materi_tugas_drilldown/mapel', [
            'title' => 'Pilih Mata Pelajaran',
            'mapel' => $mapel
        ]);
    }

    public function kelas($mapel_id)
    {
        $guru_id = session('user_id');
        $jadwalModel = new JadwalModel();
        $kelas = $jadwalModel->select('kelas.id, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = jadwal.kelas_id')
            ->where('jadwal.guru_id', $guru_id)
            ->where('jadwal.mapel_id', $mapel_id)
            ->groupBy('kelas.id, kelas.nama_kelas')
            ->findAll();
        return view('guru/materi_tugas_drilldown/kelas', [
            'title' => 'Pilih Kelas',
            'mapel_id' => $mapel_id,
            'kelas' => $kelas
        ]);
    }

    public function pertemuan($mapel_id, $kelas_id)
    {
        $pertemuanModel = new PertemuanModel();
        $pertemuan = $pertemuanModel->where('kelas_id', $kelas_id)->where('mapel_id', $mapel_id)->findAll();
        return view('guru/materi_tugas_drilldown/pertemuan', [
            'title' => 'Pilih Pertemuan',
            'mapel_id' => $mapel_id,
            'kelas_id' => $kelas_id,
            'pertemuan' => $pertemuan
        ]);
    }

    public function detail($mapel_id, $kelas_id, $kd_pertemuan)
    {
        $pertemuanModel = new PertemuanModel();
        $materiModel = new MateriModel();
        $tugasModel = new TugasModel();
        $pretestModel = new PretestModel();
        $pretestSoalModel = new PretestSoalModel();
        $pengumpulanTugasModel = new \App\Models\PengumpulanTugasModel();
        $siswaModel = new \App\Models\SiswaModel();

        $pertemuan = $pertemuanModel->find($kd_pertemuan);
        $materi = $materiModel->where('kd_pertemuan', $kd_pertemuan)->findAll();
        $tugas = $tugasModel->where('kd_pertemuan', $kd_pertemuan)->findAll();
        $pretest = $pretestModel->where('kd_pertemuan', $kd_pertemuan)->first();
        $pretest_soal = $pretest ? $pretestSoalModel->where('kd_pretest', $pretest['id'])->findAll() : [];

        // Ambil pengumpulan tugas siswa untuk tugas pertama (jika ada)
        $pengumpulan_tugas = [];
        if (!empty($tugas)) {
            $pengumpulan_tugas = $pengumpulanTugasModel->getByTugasId($tugas[0]['id']);
        }
        // Ambil semua siswa di kelas untuk absensi manual
        $siswa_kelas = $siswaModel->where('kelas_id', $kelas_id)->findAll();

        return view('guru/materi_tugas_drilldown/detail', [
            'title' => 'Detail Pertemuan',
            'pertemuan' => $pertemuan,
            'materi' => $materi,
            'tugas' => $tugas,
            'pretest' => $pretest,
            'pretest_soal' => $pretest_soal,
            'pengumpulan_tugas' => $pengumpulan_tugas,
            'siswa_kelas' => $siswa_kelas,
        ]);
    }

    public function updateTopik($kd_pertemuan)
    {
        $pertemuanModel = new \App\Models\PertemuanModel();
        $topik = $this->request->getPost('topik');
        $pertemuanModel->update($kd_pertemuan, ['topik' => $topik]);
        return redirect()->back()->with('success', 'Topik berhasil diupdate');
    }

    public function updateVideo($kd_pertemuan)
    {
        $pertemuanModel = new \App\Models\PertemuanModel();
        $video = $this->request->getPost('video_youtube');
        $pertemuanModel->update($kd_pertemuan, ['video_youtube' => $video]);
        return redirect()->back()->with('success', 'Link video berhasil diupdate');
    }

    public function tambahMateri($kd_pertemuan)
    {
        $materiModel = new \App\Models\MateriModel();
        $data = [
            'kd_pertemuan' => $kd_pertemuan,
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file' => $this->request->getPost('file'), // handle upload di view
        ];
        $materiModel->insert($data);
        return redirect()->back()->with('success', 'Materi berhasil ditambahkan');
    }

    public function editMateri($materi_id)
    {
        $materiModel = new \App\Models\MateriModel();
        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file' => $this->request->getPost('file'), // handle upload di view
        ];
        $materiModel->update($materi_id, $data);
        return redirect()->back()->with('success', 'Materi berhasil diupdate');
    }

    public function tambahTugas($kd_pertemuan)
    {
        $tugasModel = new \App\Models\TugasModel();
        $data = [
            'kd_pertemuan' => $kd_pertemuan,
            'deskripsi' => $this->request->getPost('deskripsi'),
            'deadline' => $this->request->getPost('deadline'),
            'file' => $this->request->getPost('file'), // handle upload di view
        ];
        $tugasModel->insert($data);
        return redirect()->back()->with('success', 'Tugas berhasil ditambahkan');
    }

    public function editTugas($kd_tugas)
    {
        $tugasModel = new TugasModel();
        $data = [
            'deskripsi' => $this->request->getPost('deskripsi'),
            'deadline' => $this->request->getPost('deadline'),
            'file' => $this->request->getPost('file'), // handle upload di view
        ];
        $tugasModel->update($kd_tugas, $data);
        return redirect()->back()->with('success', 'Tugas berhasil diupdate');
    }

    public function nilaiTugas($pengumpulan_tugas_id)
    {
        $model = new \App\Models\PengumpulanTugasModel();
        $nilai = $this->request->getPost('nilai');
        $catatan = $this->request->getPost('catatan');
        $model->update($pengumpulan_tugas_id, [
            'nilai' => $nilai,
            'catatan' => $catatan
        ]);
        return redirect()->back()->with('success', 'Nilai tugas berhasil disimpan');
    }

    public function simpanPretest($kd_pertemuan)
    {
        $pretestModel = new \App\Models\PretestModel();
        $pretestSoalModel = new \App\Models\PretestSoalModel();
        // Cek pretest sudah ada atau belum
        $pretest = $pretestModel->where('kd_pertemuan', $kd_pertemuan)->first();
        if (!$pretest) {
            $kd_pretest = $pretestModel->insert([
                'kd_pertemuan' => $kd_pertemuan,
                'judul' => 'Pretest Pertemuan',
            ], true);
        } else {
            $kd_pretest = $pretest['id'];
            $pretestSoalModel->where('kd_pretest', $kd_pretest)->delete(); // hapus soal lama
        }
        $soal = $this->request->getPost('soal');
        $pilihan_a = $this->request->getPost('pilihan_a');
        $pilihan_b = $this->request->getPost('pilihan_b');
        $pilihan_c = $this->request->getPost('pilihan_c');
        $pilihan_d = $this->request->getPost('pilihan_d');
        $jawaban_benar = $this->request->getPost('jawaban_benar');
        for ($i=1; $i<=10; $i++) {
            $pretestSoalModel->insert([
                'kd_pretest' => $kd_pretest,
                'soal' => $soal[$i],
                'pilihan_a' => $pilihan_a[$i],
                'pilihan_b' => $pilihan_b[$i],
                'pilihan_c' => $pilihan_c[$i],
                'pilihan_d' => $pilihan_d[$i],
                'jawaban_benar' => $jawaban_benar[$i],
            ]);
        }
        return redirect()->back()->with('success', 'Pretest berhasil disimpan');
    }

    public function simpanAbsensi($kd_pertemuan)
    {
        $absensiModel = new \App\Models\AbsensiModel();
        $status = $this->request->getPost('status'); // [nis => status]
        $tanggal = date('Y-m-d');
        foreach ($status as $nis => $stat) {
            $absensiModel->insert([
                'nis' => $nis,
                'tanggal' => $tanggal,
                'status' => $stat
            ]);
        }
        return redirect()->back()->with('success', 'Absensi berhasil disimpan');
    }
} 