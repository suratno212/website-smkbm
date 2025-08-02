<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key check
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        // Hapus semua data guru sebelum insert baru
        $this->db->table('guru')->truncate();
        $this->db->query("ALTER TABLE guru AUTO_INCREMENT = 1");
        // Aktifkan kembali foreign key check
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            [ 'user_id' => 3, 'nik_nip' => '198001010001', 'nama' => 'Solatun Khoiriyah, S.Pd', 'email' => 'solatunkhoiriyah@gmail.com', 'jenis_kelamin' => 'P', 'agama_id' => 1, 'tanggal_lahir' => '1980-01-01', 'kd_mapel' => 'MTK', 'alamat' => 'Alamat 1', 'no_hp' => '0811111111', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 4, 'nik_nip' => '198101010002', 'nama' => 'Melia Damayanti , S.Pd', 'email' => 'meliadamayanti@gmail.com', 'jenis_kelamin' => 'P', 'agama_id' => 1, 'tanggal_lahir' => '1981-01-01', 'kd_mapel' => 'BIN', 'alamat' => 'Alamat 2', 'no_hp' => '0811111112', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 5, 'nik_nip' => '198201010003', 'nama' => 'Peppi Sutriyani, S.Sos', 'email' => 'peppisutriyani@gmail.com', 'jenis_kelamin' => 'P', 'agama_id' => 1, 'tanggal_lahir' => '1982-01-01', 'kd_mapel' => 'PPKN', 'alamat' => 'Alamat 3', 'no_hp' => '0811111113', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 6, 'nik_nip' => '198301010004', 'nama' => 'Sugianto, S.Pd', 'email' => 'sugianto@gmail.com', 'jenis_kelamin' => 'L', 'agama_id' => 1, 'tanggal_lahir' => '1983-01-01', 'kd_mapel' => 'FIS', 'alamat' => 'Alamat 4', 'no_hp' => '0811111114', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 7, 'nik_nip' => '198401010005', 'nama' => 'Rizky Amalia, S.E', 'email' => 'rizkyamalia@gmail.com', 'jenis_kelamin' => 'P', 'agama_id' => 1, 'tanggal_lahir' => '1984-01-01', 'kd_mapel' => 'PKK', 'alamat' => 'Alamat 5', 'no_hp' => '0811111115', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 8, 'nik_nip' => '198501010006', 'nama' => 'Munawar, S.Pd', 'email' => 'munawar@gmail.com', 'jenis_kelamin' => 'L', 'agama_id' => 1, 'tanggal_lahir' => '1985-01-01', 'kd_mapel' => 'PABP', 'alamat' => 'Alamat 6', 'no_hp' => '0811111116', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 9, 'nik_nip' => '198601010007', 'nama' => 'Septi Dwiyani, S.Pd', 'email' => 'septidwiyani@gmail.com', 'jenis_kelamin' => 'P', 'agama_id' => 1, 'tanggal_lahir' => '1986-01-01', 'kd_mapel' => 'MTK', 'alamat' => 'Alamat 7', 'no_hp' => '0811111117', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 10, 'nik_nip' => '198701010008', 'nama' => 'Siti Munawaroh, S.Pd', 'email' => 'sitimunawaroh@gmail.com', 'jenis_kelamin' => 'P', 'agama_id' => 1, 'tanggal_lahir' => '1987-01-01', 'kd_mapel' => 'BIG', 'alamat' => 'Alamat 8', 'no_hp' => '0811111118', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 11, 'nik_nip' => '198801010009', 'nama' => 'Widi Saputra, S.Pd', 'email' => 'widisaputra@gmail.com', 'jenis_kelamin' => 'L', 'agama_id' => 1, 'tanggal_lahir' => '1988-01-01', 'kd_mapel' => 'KJD', 'alamat' => 'Alamat 9', 'no_hp' => '0811111119', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 12, 'nik_nip' => '198901010010', 'nama' => 'Melisa Sulmi, S.Pd', 'email' => 'melisassulmi@gmail.com', 'jenis_kelamin' => 'P', 'agama_id' => 1, 'tanggal_lahir' => '1989-01-01', 'kd_mapel' => 'SBD', 'alamat' => 'Alamat 10', 'no_hp' => '0811111120', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 13, 'nik_nip' => '199001010011', 'nama' => 'Kartini , S.Pd', 'email' => 'kartini@gmail.com', 'jenis_kelamin' => 'P', 'agama_id' => 1, 'tanggal_lahir' => '1990-01-01', 'kd_mapel' => 'SEJ', 'alamat' => 'Alamat 11', 'no_hp' => '0811111121', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 14, 'nik_nip' => '199101010012', 'nama' => 'Dewi Sartika, S.Pd', 'email' => 'dewisartika@gmail.com', 'jenis_kelamin' => 'P', 'agama_id' => 1, 'tanggal_lahir' => '1991-01-01', 'kd_mapel' => 'PPKN', 'alamat' => 'Alamat 12', 'no_hp' => '0811111122', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 15, 'nik_nip' => '199201010013', 'nama' => 'Safitri, S.Kom', 'email' => 'safitri@gmail.com', 'jenis_kelamin' => 'P', 'agama_id' => 1, 'tanggal_lahir' => '1992-01-01', 'kd_mapel' => 'KJD', 'alamat' => 'Alamat 13', 'no_hp' => '0811111123', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 16, 'nik_nip' => '199301010014', 'nama' => 'Joni Haryono, S.T', 'email' => 'joniharyono@gmail.com', 'jenis_kelamin' => 'L', 'agama_id' => 1, 'tanggal_lahir' => '1993-01-01', 'kd_mapel' => 'KJD', 'alamat' => 'Alamat 14', 'no_hp' => '0811111124', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 17, 'nik_nip' => '199401010015', 'nama' => 'Jamaludin, S.Pd', 'email' => 'jamaludin@gmail.com', 'jenis_kelamin' => 'L', 'agama_id' => 1, 'tanggal_lahir' => '1994-01-01', 'kd_mapel' => 'MTK', 'alamat' => 'Alamat 15', 'no_hp' => '0811111125', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 18, 'nik_nip' => '199501010016', 'nama' => 'Rofik Ridho Kurnia,  S.Pd', 'email' => 'rofikridho@gmail.com', 'jenis_kelamin' => 'L', 'agama_id' => 1, 'tanggal_lahir' => '1995-01-01', 'kd_mapel' => 'PABP', 'alamat' => 'Alamat 16', 'no_hp' => '0811111126', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 19, 'nik_nip' => '199601010017', 'nama' => 'Sudirman, S.Pd', 'email' => 'sudirman@gmail.com', 'jenis_kelamin' => 'L', 'agama_id' => 1, 'tanggal_lahir' => '1996-01-01', 'kd_mapel' => 'SEJ', 'alamat' => 'Alamat 17', 'no_hp' => '0811111127', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 20, 'nik_nip' => '199701010018', 'nama' => '⁠Rizki Pungut Saputra , S.Pd', 'email' => 'rizkipungut@gmail.com', 'jenis_kelamin' => 'L', 'agama_id' => 1, 'tanggal_lahir' => '1997-01-01', 'kd_mapel' => 'BIN', 'alamat' => 'Alamat 18', 'no_hp' => '0811111128', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 21, 'nik_nip' => '199801010019', 'nama' => 'Komarudin, S.Ag', 'email' => 'komarudin@gmail.com', 'jenis_kelamin' => 'L', 'agama_id' => 1, 'tanggal_lahir' => '1998-01-01', 'kd_mapel' => 'PABP', 'alamat' => 'Alamat 19', 'no_hp' => '0811111129', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
            [ 'user_id' => 22, 'nik_nip' => '199901010020', 'nama' => 'Eko Alan Budi Kusuma, S.Kom', 'email' => 'ekoalanbudi@gmail.com', 'jenis_kelamin' => 'L', 'agama_id' => 1, 'tanggal_lahir' => '1999-01-01', 'kd_mapel' => 'KJD', 'alamat' => 'Alamat 20', 'no_hp' => '0811111130', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ],
        ];

        $this->db->table('guru')->insertBatch($data);
    }
} 