<?php
namespace App\Controllers\KepalaSekolah;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $user_id = session()->get('user_id');
        $user = $this->userModel->find($user_id);
        return view('kepalasekolah/profile/index', [
            'title' => 'Profil Kepala Sekolah',
            'user' => $user,
        ]);
    }

    public function update()
    {
        $user_id = session()->get('user_id');
        $user = $this->userModel->find($user_id);
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
        ];
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }
        // Handle upload foto
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move('uploads/profile', $newName);
            // Hapus foto lama jika ada
            if (!empty($user['foto']) && file_exists('uploads/profile/' . $user['foto'])) {
                @unlink('uploads/profile/' . $user['foto']);
            }
            $data['foto'] = $newName;
        }
        $this->userModel->update($user_id, $data);
        // Update session data jika ada perubahan
        $userBaru = $this->userModel->find($user_id);
        session()->set('username', $userBaru['username']);
        session()->set('email', $userBaru['email']);
        session()->set('foto', $userBaru['foto'] ?? null);
        session()->setFlashdata('success', 'Profil berhasil diperbarui.');
        return redirect()->to(base_url('kepalasekolah/profile'));
    }
} 