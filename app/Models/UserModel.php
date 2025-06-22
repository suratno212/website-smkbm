<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'email', 'role', 'foto'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]',
        'email' => 'required|valid_email',
        'password' => 'permit_empty|min_length[6]',
        'role' => 'required|in_list[admin,guru,siswa]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username harus diisi',
            'min_length' => 'Username minimal 3 karakter',
            'is_unique' => 'Username sudah digunakan'
        ],
        'email' => [
            'required' => 'Email harus diisi',
            'valid_email' => 'Email tidak valid',
            'is_unique' => 'Email sudah digunakan'
        ],
        'password' => [
            'required' => 'Password harus diisi',
            'min_length' => 'Password minimal 6 karakter'
        ],
        'role' => [
            'required' => 'Role harus diisi',
            'in_list' => 'Role tidak valid'
        ]
    ];

    // Method untuk membuat password hash
    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // Method untuk verifikasi password
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
} 