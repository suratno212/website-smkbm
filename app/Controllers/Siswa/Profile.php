<?php
namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\SiswaModel;

class Profile extends BaseController
{
    protected $userModel;
    protected $siswaModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $user_id = session()->get('user_id');
        $user = $this->userModel->find($user_id);
        $siswa = $this->siswaModel->where('user_id', $user_id)->first();
        return view('siswa/profile/index', [
            'title' => 'Profil Siswa',
            'user' => $user,
            'siswa' => $siswa
        ]);
    }

    public function update()
    {
        $user_id = session()->get('user_id');
        $user = $this->userModel->find($user_id);
        $siswa = $this->siswaModel->where('user_id', $user_id)->first();
        $dataUser = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
        ];
        $dataSiswa = [
            'nama' => $this->request->getPost('nama'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
        ];
        // Handle foto
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $maxSize = 2 * 1024 * 1024;
            $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png'];
            if ($foto->getSize() > $maxSize) {
                return redirect()->back()->withInput()->with('errors', ['Ukuran foto maksimal 2MB']);
            }
            if (!in_array($foto->getMimeType(), $allowedTypes)) {
                return redirect()->back()->withInput()->with('errors', ['Format foto harus JPG atau PNG']);
            }
            $ext = $foto->getClientExtension();
            $newName = $user['username'] . '.' . $ext;
            if ($user['foto'] && $user['foto'] !== $newName && file_exists(ROOTPATH . 'public/uploads/profile/' . $user['foto'])) {
                unlink(ROOTPATH . 'public/uploads/profile/' . $user['foto']);
            }
            if (!$foto->move(ROOTPATH . 'public/uploads/profile', $newName, true)) {
                return redirect()->back()->withInput()->with('errors', ['Gagal mengupload foto.']);
            }
            $dataUser['foto'] = $newName;
        }
        $this->userModel->update($user_id, $dataUser);
        $this->siswaModel->update($siswa['id'], $dataSiswa);
        // Update session foto jika ada perubahan
        $userBaru = $this->userModel->find($user_id);
        session()->set('foto', $userBaru['foto']);
        return redirect()->to('siswa/profile')->with('message', 'Profil berhasil diperbarui');
    }
} 