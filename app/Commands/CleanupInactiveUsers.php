<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\UserModel;
use App\Models\CalonSiswaModel;

class CleanupInactiveUsers extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'cleanup:inactive-users';
    protected $description = 'Cleanup inactive user accounts from rejected calon siswa';

    public function run(array $params)
    {
        $userModel = new UserModel();
        $calonSiswaModel = new CalonSiswaModel();

        CLI::write('Starting cleanup of inactive user accounts...', 'yellow');

        // Find rejected calon siswa that are older than 30 days
        $inactiveUsers = $calonSiswaModel->select('calon_siswa.user_id, calon_siswa.nama, calon_siswa.email, calon_siswa.updated_at')
            ->where('calon_siswa.status_pendaftaran', 'ditolak')
            ->where('calon_siswa.updated_at <', date('Y-m-d H:i:s', strtotime('-30 days')))
            ->findAll();

        if (empty($inactiveUsers)) {
            CLI::write('No inactive users found for cleanup.', 'green');
            return;
        }

        CLI::write("Found " . count($inactiveUsers) . " inactive users to cleanup:", 'yellow');

        $deletedCount = 0;
        foreach ($inactiveUsers as $user) {
            try {
                // Delete user account
                $userModel->delete($user['user_id']);
                
                CLI::write("✓ Deleted user: {$user['nama']} ({$user['email']})", 'green');
                $deletedCount++;
                
            } catch (\Exception $e) {
                CLI::error("✗ Failed to delete user: {$user['nama']} - {$e->getMessage()}");
            }
        }

        CLI::write("Cleanup completed! Deleted {$deletedCount} inactive user accounts.", 'green');
    }
} 
 
 
 
 
 