<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            // Cek apakah request adalah API/AJAX
            if ($request->isAJAX() || strpos($request->getPath(), 'api/') === 0) {
                return \Config\Services::response()
                    ->setStatusCode(401)
                    ->setJSON(['status' => false, 'message' => 'Unauthorized. Harap login kembali.']);
            }
            
            return redirect()->to(site_url('login'));
        }
        
        // Pengecekan role khusus untuk admin panel SPA
        if ($arguments && in_array('admin', $arguments) && session()->get('role') !== 'admin') {
            if ($request->isAJAX() || strpos($request->getPath(), 'api/') === 0) {
                return \Config\Services::response()
                    ->setStatusCode(403)
                    ->setJSON(['status' => false, 'message' => 'Forbidden. Akses ditolak.']);
            }
            return redirect()->to(site_url('/'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}