<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key check
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        // Hapus semua data users sebelum insert baru
        $this->db->table('users')->truncate();
        $this->db->query('ALTER TABLE users AUTO_INCREMENT = 1');
        // Aktifkan kembali foreign key check
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
        $now = date('Y-m-d H:i:s');
        
        // Data admin
        $data = [
            [
                'username'    => 'admin',
                'nama'       => 'Administrator',
                'email'      => 'admin@smkbm.sch.id',
                'password'    => password_hash('admin123', PASSWORD_DEFAULT),
                'role'        => 'admin',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'username'    => 'kepalasekolah@gmail.com',
                'nama'       => 'Kepala Sekolah',
                'email'      => 'kepalasekolah@gmail.com',
                'password'    => password_hash('1970-01-01', PASSWORD_DEFAULT),
                'role'        => 'kepala_sekolah',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [ 'username' => 'solatunkhoiriyah@gmail.com', 'nama' => 'Solatun Khoiriyah, S.Pd', 'email' => 'solatunkhoiriyah@gmail.com', 'password' => password_hash('1980-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'meliadamayanti@gmail.com', 'nama' => 'Melia Damayanti , S.Pd', 'email' => 'meliadamayanti@gmail.com', 'password' => password_hash('1981-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'peppisutriyani@gmail.com', 'nama' => 'Peppi Sutriyani, S.Sos', 'email' => 'peppisutriyani@gmail.com', 'password' => password_hash('1982-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'sugianto@gmail.com', 'nama' => 'Sugianto, S.Pd', 'email' => 'sugianto@gmail.com', 'password' => password_hash('1983-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'rizkyamalia@gmail.com', 'nama' => 'Rizky Amalia, S.E', 'email' => 'rizkyamalia@gmail.com', 'password' => password_hash('1984-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'munawar@gmail.com', 'nama' => 'Munawar, S.Pd', 'email' => 'munawar@gmail.com', 'password' => password_hash('1985-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'septidwiyani@gmail.com', 'nama' => 'Septi Dwiyani, S.Pd', 'email' => 'septidwiyani@gmail.com', 'password' => password_hash('1986-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'sitimunawaroh@gmail.com', 'nama' => 'Siti Munawaroh, S.Pd', 'email' => 'sitimunawaroh@gmail.com', 'password' => password_hash('1987-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'widisaputra@gmail.com', 'nama' => 'Widi Saputra, S.Pd', 'email' => 'widisaputra@gmail.com', 'password' => password_hash('1988-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'melisassulmi@gmail.com', 'nama' => 'Melisa Sulmi, S.Pd', 'email' => 'melisassulmi@gmail.com', 'password' => password_hash('1989-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'kartini@gmail.com', 'nama' => 'Kartini , S.Pd', 'email' => 'kartini@gmail.com', 'password' => password_hash('1990-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'dewisartika@gmail.com', 'nama' => 'Dewi Sartika, S.Pd', 'email' => 'dewisartika@gmail.com', 'password' => password_hash('1991-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'safitri@gmail.com', 'nama' => 'Safitri, S.Kom', 'email' => 'safitri@gmail.com', 'password' => password_hash('1992-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'joniharyono@gmail.com', 'nama' => 'Joni Haryono, S.T', 'email' => 'joniharyono@gmail.com', 'password' => password_hash('1993-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'jamaludin@gmail.com', 'nama' => 'Jamaludin, S.Pd', 'email' => 'jamaludin@gmail.com', 'password' => password_hash('1994-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'rofikridho@gmail.com', 'nama' => 'Rofik Ridho Kurnia,  S.Pd', 'email' => 'rofikridho@gmail.com', 'password' => password_hash('1995-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'sudirman@gmail.com', 'nama' => 'Sudirman, S.Pd', 'email' => 'sudirman@gmail.com', 'password' => password_hash('1996-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'rizkipungut@gmail.com', 'nama' => '⁠Rizki Pungut Saputra , S.Pd', 'email' => 'rizkipungut@gmail.com', 'password' => password_hash('1997-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'komarudin@gmail.com', 'nama' => 'Komarudin, S.Ag', 'email' => 'komarudin@gmail.com', 'password' => password_hash('1998-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => 'ekoalanbudi@gmail.com', 'nama' => 'Eko Alan Budi Kusuma, S.Kom', 'email' => 'ekoalanbudi@gmail.com', 'password' => password_hash('1999-01-01', PASSWORD_DEFAULT), 'role' => 'guru', 'created_at' => $now, 'updated_at' => $now ],
            // Data siswa (username = NIS, password = tanggal lahir)
            [ 'username' => '2024001', 'nama' => 'Siswa 1', 'email' => 'siswa1@smkbm.sch.id', 'password' => password_hash('2006-03-15', PASSWORD_DEFAULT), 'role' => 'siswa', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => '2024002', 'nama' => 'Siswa 2', 'email' => 'siswa2@smkbm.sch.id', 'password' => password_hash('2006-05-20', PASSWORD_DEFAULT), 'role' => 'siswa', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => '2024003', 'nama' => 'Siswa 3', 'email' => 'siswa3@smkbm.sch.id', 'password' => password_hash('2006-07-10', PASSWORD_DEFAULT), 'role' => 'siswa', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => '2024004', 'nama' => 'Siswa 4', 'email' => 'siswa4@smkbm.sch.id', 'password' => password_hash('2006-09-25', PASSWORD_DEFAULT), 'role' => 'siswa', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => '2024005', 'nama' => 'Siswa 5', 'email' => 'siswa5@smkbm.sch.id', 'password' => password_hash('2006-11-30', PASSWORD_DEFAULT), 'role' => 'siswa', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => '2024006', 'nama' => 'Siswa 6', 'email' => 'siswa6@smkbm.sch.id', 'password' => password_hash('2006-12-05', PASSWORD_DEFAULT), 'role' => 'siswa', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => '2024007', 'nama' => 'Siswa 7', 'email' => 'siswa7@smkbm.sch.id', 'password' => password_hash('2006-08-12', PASSWORD_DEFAULT), 'role' => 'siswa', 'created_at' => $now, 'updated_at' => $now ],
            [ 'username' => '2024008', 'nama' => 'Siswa 8', 'email' => 'siswa8@smkbm.sch.id', 'password' => password_hash('2006-10-22', PASSWORD_DEFAULT), 'role' => 'siswa', 'created_at' => $now, 'updated_at' => $now ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
} 