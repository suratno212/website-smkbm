<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\CalonSiswaModel;
use App\Models\UserModel;

class TestCalonSiswa extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'test:calon-siswa';
    protected $description = 'Test data calon siswa';

    public function run(array $params)
    {
        $calonSiswaModel = new CalonSiswaModel();
        $userModel = new UserModel();

        CLI::write('=== TEST DATA CALON SISWA ===', 'yellow');

        // Test 1: Cek data calon siswa
        CLI::write('1. Data Calon Siswa:', 'green');
        $totalCalonSiswa = $calonSiswaModel->countAllResults();
        CLI::write("   Total calon siswa: {$totalCalonSiswa}");

        if ($totalCalonSiswa > 0) {
            $calonSiswa = $calonSiswaModel->findAll();
            foreach ($calonSiswa as $cs) {
                CLI::write("   - {$cs['nama']} ({$cs['email']}) - Status: {$cs['status_pendaftaran']}");
            }
        }

        // Test 2: Cek user dengan role calon_siswa
        CLI::write('2. User dengan Role Calon Siswa:', 'green');
        $users = $userModel->where('role', 'calon_siswa')->findAll();
        CLI::write("   Total user calon_siswa: " . count($users));

        foreach ($users as $user) {
            CLI::write("   - {$user['username']} (role: {$user['role']})");
        }

        // Test 3: Cek status pendaftaran
        CLI::write('3. Status Pendaftaran:', 'green');
        $statusCounts = $calonSiswaModel->select('status_pendaftaran, COUNT(*) as total')
            ->groupBy('status_pendaftaran')
            ->findAll();

        foreach ($statusCounts as $status) {
            CLI::write("   - {$status['status_pendaftaran']}: {$status['total']}");
        }

        // Test 4: Cek data dengan join
        CLI::write('4. Data dengan Join User:', 'green');
        $dataWithUser = $calonSiswaModel->getWithUser();
        CLI::write("   Total data dengan user: " . count($dataWithUser));

        CLI::write('=== TEST SELESAI ===', 'yellow');
    }
} 
 
 
 
 
 