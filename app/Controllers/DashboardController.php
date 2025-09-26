<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Dashboard - LaFab AI Posting',
            'user' => [
                'name' => session()->get('full_name'),
                'email' => session()->get('email'),
                'company' => session()->get('company')
            ]
        ];

        return view('dashboard/index', $data);
    }
}
