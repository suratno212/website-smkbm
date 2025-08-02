<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SoalSpmbModel;
use App\Models\UjianSpmbModel;
use App\Models\JawabanSpmbModel;
use App\Models\CalonSiswaModel;

class SpmbTes extends BaseController
{
    protected $soalModel;
    protected $ujianModel;
    protected $jawabanModel;
    public function __construct()
    {
        $this->soalModel = new SoalSpmbModel();
        $this->ujianModel = new UjianSpmbModel();
        $this->jawabanModel = new JawabanSpmbModel();
    }

    // Halaman mulai tes
    public function mulai()
    {
        $userId = session()->get('user_id');
        $ujian = $this->ujianModel->where('peserta_id', $userId)->orderBy('id', 'desc')->first();
        $nilaiMinimal = 75;
        if ($ujian && $ujian['status'] == 'selesai' && $ujian['skor'] >= $nilaiMinimal) {
            return redirect()->to('spmbtes/hasil')->with('error', 'Anda sudah lulus dan tidak bisa mengulang tes.');
        }
        if ($ujian && $ujian['status'] == 'selesai') {
            return redirect()->to('spmbtes/hasil');
        }
        return view('spmb/tes/mulai', ['title' => 'Mulai Tes SPMB']);
    }

    // Proses mulai tes (buat data ujian, redirect ke soal)
    public function mulaiTes()
    {
        $userId = session()->get('user_id');
        $ujian = $this->ujianModel->where('peserta_id', $userId)->orderBy('id', 'desc')->first();
        $nilaiMinimal = 75;
        if ($ujian && $ujian['status'] == 'selesai' && $ujian['skor'] >= $nilaiMinimal) {
            return redirect()->to('spmbtes/hasil')->with('error', 'Anda sudah lulus dan tidak bisa mengulang tes.');
        }
        // Cek jika sudah ada ujian aktif
        $ujianAktif = $this->ujianModel->where('peserta_id', $userId)->where('status', 'belum')->first();
        if (!$ujianAktif) {
            $ujianId = $this->ujianModel->insert([
                'peserta_id' => $userId,
                'waktu_mulai' => date('Y-m-d H:i:s'),
                'status' => 'belum'
            ], true);
        } else {
            $ujianId = $ujianAktif['id'];
        }
        return redirect()->to('spmbtes/soal/' . $ujianId);
    }

    // Tampilkan soal dan form jawaban
    public function soal($ujianId)
    {
        $ujian = $this->ujianModel->find($ujianId);
        if (!$ujian) return redirect()->to('spmbtes/mulai');
        $soal = $this->soalModel->limit(30)->findAll(); // Ambil hanya 30 soal
        // Ambil jawaban yang sudah ada
        $jawaban = $this->jawabanModel->where('ujian_id', $ujianId)->findAll();
        $jawabanMap = [];
        foreach ($jawaban as $j) {
            $jawabanMap[$j['soal_id']] = $j['jawaban_peserta'];
        }
        return view('spmb/tes/soal', [
            'title' => 'Tes SPMB',
            'soal' => $soal,
            'ujian' => $ujian,
            'jawaban' => $jawabanMap
        ]);
    }

    // Proses submit jawaban
    public function submitJawaban($ujianId)
    {
        $soal = $this->soalModel->limit(30)->findAll();
        $skor = 0;
        foreach ($soal as $s) {
            $jawab = $this->request->getPost('jawaban_' . $s['id']);
            $benar = ($jawab && strtolower($jawab) == strtolower($s['jawaban_benar'])) ? 'benar' : 'salah';
            if ($benar == 'benar') $skor++;
            // Simpan/update jawaban
            $data = [
                'ujian_id' => $ujianId,
                'soal_id' => $s['id'],
                'jawaban_peserta' => $jawab,
                'benar_salah' => $benar
            ];
            $cek = $this->jawabanModel->where('ujian_id', $ujianId)->where('soal_id', $s['id'])->first();
            if ($cek) {
                $this->jawabanModel->update($cek['id'], $data);
            } else {
                $this->jawabanModel->insert($data);
            }
        }
        // Hitung skor akhir (1 soal = 100/30)
        $totalSoal = count($soal);
        $skorAkhir = $totalSoal > 0 ? round($skor * (100 / $totalSoal), 2) : 0;
        // Update skor dan status ujian
        $this->ujianModel->update($ujianId, [
            'skor' => $skorAkhir,
            'waktu_selesai' => date('Y-m-d H:i:s'),
            'status' => 'selesai'
        ]);
        // Update status_tes dan nilai_tes calon siswa dengan transaksi dan pengecekan
        $ujian = $this->ujianModel->find($ujianId);
        if ($ujian) {
            $calonSiswaModel = new CalonSiswaModel();
            $calonSiswa = $calonSiswaModel->where('user_id', $ujian['peserta_id'])->first();
            log_message('debug', 'Update calon_siswa: user_id=' . $ujian['peserta_id'] . ', calon_siswa_id=' . ($calonSiswa['id'] ?? 'NULL') . ', skor=' . $skorAkhir);
            if ($calonSiswa) {
                $db = \Config\Database::connect();
                $db->transStart();
                $calonSiswaModel->skipValidation(true)->update($calonSiswa['id'], [
                    'status_tes' => 'sudah_tes',
                    'nilai_tes' => $skorAkhir
                ]);
                $db->transComplete();
                log_message('debug', 'Update calon_siswa result: ' . json_encode($calonSiswaModel->errors()));
                if ($db->transStatus() === false) {
                    log_message('error', 'Gagal update status_tes calon siswa: user_id=' . $ujian['peserta_id'] . ' id=' . $calonSiswa['id']);
                    return redirect()->to('spmbtes/hasil')->with('error', 'Gagal update status tes. Silakan hubungi admin.');
                }
            } else {
                log_message('error', 'Data calon siswa tidak ditemukan untuk user_id=' . $ujian['peserta_id']);
            }
        }
        return redirect()->to('spmbtes/hasil');
    }

    // Halaman hasil tes
    public function hasil()
    {
        $userId = session()->get('user_id');
        $ujian = $this->ujianModel->where('peserta_id', $userId)->orderBy('id', 'desc')->first();
        if (!$ujian) return redirect()->to('spmbtes/mulai');
        $nilaiMinimal = 75;
        $lulus = $ujian['skor'] >= $nilaiMinimal;
        return view('spmb/tes/hasil', [
            'title' => 'Hasil Tes SPMB',
            'ujian' => $ujian,
            'nilai_minimal' => $nilaiMinimal,
            'lulus' => $lulus
        ]);
    }
} 