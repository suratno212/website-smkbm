<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FixGuruMunawarSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        // Update password user munawar
        $user = $db->table('users')->where('username', 'munawar')->get()->getRowArray();
        if ($user) {
            $db->table('users')->where('id', $user['id'])->update([
                'password' => '$2y$10$K0Zr0OeWrMTkv3o2bQCuG.0WVtvblqJkl4/hqlEglp2aKEC4i81KW'
            ]);
            $user_id = $user['id'];
        } else {
            // Jika belum ada, buat user baru
            $db->table('users')->insert([
                'username' => 'munawar',
                'password' => '$2y$10$K0Zr0OeWrMTkv3o2bQCuG.0WVtvblqJkl4/hqlEglp2aKEC4i81KW',
                'role' => 'guru',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $user_id = $db->insertID();
        }
        // Pastikan ada data guru
        $guru = $db->table('guru')->where('user_id', $user_id)->get()->getRowArray();
        if (!$guru) {
            $db->table('guru')->insert([
                'user_id' => $user_id,
                'nama' => 'Munawar',
                'tanggal_lahir' => '1985-03-15',
                'mapel_id' => 1,
                'alamat' => 'Alamat Munawar',
                'no_hp' => '08123456789',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $guru_id = $db->insertID();
        } else {
            $guru_id = $guru['id'];
        }
        // Pastikan ada jadwal mengajar
        $kelas = $db->table('kelas')->get()->getRowArray();
        $mapel = $db->table('mapel')->get()->getRowArray();
        $tahun = $db->table('tahun_akademik')->get()->getRowArray();
        if ($kelas && $mapel && $tahun) {
            $jadwal = $db->table('jadwal')->where([
                'kelas_id' => $kelas['id'],
                'mapel_id' => $mapel['id'],
                'guru_id' => $guru_id,
                'tahun_akademik_id' => $tahun['id'],
            ])->get()->getRowArray();
            if (!$jadwal) {
                $db->table('jadwal')->insert([
                    'kelas_id' => $kelas['id'],
                    'mapel_id' => $mapel['id'],
                    'guru_id' => $guru_id,
                    'tahun_akademik_id' => $tahun['id'],
                    'hari' => 'Senin',
                    'jam_mulai' => '07:00:00',
                    'jam_selesai' => '08:00:00',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
} 