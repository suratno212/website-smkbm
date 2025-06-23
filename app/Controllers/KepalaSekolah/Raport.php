<?php
namespace App\Controllers\KepalaSekolah;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\NilaiModel;

class Raport extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();
        $kelasModel = new KelasModel();
        $nilaiModel = new NilaiModel();

        $kelas = $kelasModel->findAll();
        $filter_kelas = $this->request->getGet('kelas_id');
        $dataSiswa = [];

        if ($filter_kelas) {
            $siswaList = $siswaModel->where('kelas_id', $filter_kelas)->findAll();
            foreach ($siswaList as $siswa) {
                $rataRata = $nilaiModel->getRataRataSiswa($siswa['id']);
                $dataSiswa[] = [
                    'nama' => $siswa['nama'],
                    'kelas' => $kelasModel->find($siswa['kelas_id'])['nama_kelas'] ?? '-',
                    'rata_rata' => $rataRata,
                    'status' => $rataRata >= 70 ? 'Lulus' : 'Tidak Lulus',
                ];
            }
        }

        return view('kepalasekolah/raport', [
            'title' => 'Laporan e-Raport',
            'user' => session('user'),
            'dataSiswa' => $dataSiswa,
            'kelas' => $kelas,
            'filter_kelas' => $filter_kelas
        ]);
    }
} 