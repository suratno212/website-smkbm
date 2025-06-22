<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FixGuruDummyPasswordSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $user = $db->table('users')->where('username', 'gurudummy')->get()->getRowArray();
        if ($user) {
            $db->table('users')->where('id', $user['id'])->update([
                'password' => '$2y$10$UeCzIb6HbQG813KCjZZOlueUr9LWQoPMEzDrpIv6fpqNkqGphuWKe'
            ]);
        }
    }
} 