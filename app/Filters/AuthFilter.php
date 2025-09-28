<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Please login to access this page.');
            return redirect()->to('auth/login');
        }

        // Optional: Check if email is verified
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find(session()->get('user_id'));
        
        if ($user && !$user['email_verified']) {
            session()->setFlashdata('error', 'Please verify your email address.');
            return redirect()->to('/verify-email');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something after the response is sent
        return $response;
    }
}