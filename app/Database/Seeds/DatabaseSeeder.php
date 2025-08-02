<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Urutan seeder penting, sesuaikan jika ada dependensi antar tabel
        $this->call('UserSeeder');
        $this->call('AgamaSeeder');
        $this->call('JurusanSeeder');
        $this->call('KelasSeeder');
        $this->call('MapelSeeder');
        $this->call('GuruSeeder');
        $this->call('SiswaSeeder');
        $this->call('MateriSeeder');
        $this->call('MateriTugasSeeder');
        $this->call('NilaiSeeder');
        $this->call('JadwalSeeder');
        $this->call('PengumpulanTugasSeeder');
        $this->call('AbsensiSeeder');
        $this->call('EkskulSiswaSeeder');
        $this->call('CalonSiswaSeeder');
        $this->call('WaliKelasSeeder');
        $this->call('TugasSeeder');
        $this->call('EkstrakurikulerSeeder');
        $this->call('PengaturanSeeder');
        $this->call('RuanganSeeder');
        $this->call('TahunAkademikSeeder');
        $this->call('PengumumanSeeder');
        // Tambahkan seeder lain jika diperlukan
    }
} 