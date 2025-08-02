<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GuruJadwalDummySeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        // Cari user guru pertama
        $user = $db->table('users')->where('role', 'guru')->get()->getRowArray();
        if (!$user) {
            // Tambah user guru dummy
            $db->table('users')->insert([
                'username' => 'gurudummy',
                'password' => password_hash('1980-01-01', PASSWORD_DEFAULT),
                'role' => 'guru',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $user_id = $db->insertID();
        } else {
            $user_id = $user['id'];
        }
        // Cari guru dengan user_id ini
        $guru = $db->table('guru')->where('user_id', $user_id)->get()->getRowArray();
        if (!$guru) {
            // Tambah guru dummy
            $db->table('guru')->insert([
                'user_id' => $user_id,
                'nama' => 'Guru Dummy',
                'tanggal_lahir' => '1980-01-01',
                'kd_mapel' => 1,
                'alamat' => 'Alamat Dummy',
                'no_hp' => '08123456789',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $guru_id = $db->insertID();
        } else {
            $guru_id = $guru['nik_nip'];
        }
        // Cari kelas, mapel, tahun_akademik
        $kelas = $db->table('kelas')->get()->getRowArray();
        $mapel = $db->table('mapel')->get()->getRowArray();
        $tahun = $db->table('tahun_akademik')->get()->getRowArray();
        if ($kelas && $mapel && $tahun) {
            // Cek jadwal
            $jadwal = $db->table('jadwal')->where([
                'kd_kelas' => $kelas['kd_kelas'],
                'kd_mapel' => $mapel['kd_mapel'],
                'guru_id' => $guru_id,
                'kd_tahun_akademik' => $tahun['kd_tahun_akademik'],
            ])->get()->getRowArray();
            if (!$jadwal) {
                $db->table('jadwal')->insert([
                    'kd_kelas' => $kelas['kd_kelas'],
                    'kd_mapel' => $mapel['kd_mapel'],
                    'guru_id' => $guru_id,
                    'kd_tahun_akademik' => $tahun['kd_tahun_akademik'],
                    'hari' => 'Senin',
                    'jam_mulai' => '07:00:00',
                    'jam_selesai' => '08:00:00',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
} 