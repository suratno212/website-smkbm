<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('auth'));
        }

        // Jika ada argument role, cek role spesifik
        if (!empty($arguments)) {
            $requiredRole = $arguments[0];
            $userRole = session()->get('role');
            
            if ($userRole !== $requiredRole) {
                return redirect()->to(base_url('auth'))->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
} 