<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Email;
use App\Models\UserModel;  

class AuthController extends BaseController
{
    protected $userModel;
    protected $email;

    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->email = \Config\Services::email();
    }

    public function register()
    {
        return view('auth/register');
    }

    
    public function registerNewUser()
    {
        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[30]|is_unique[users.username]',
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'company' => 'permit_empty|max_length[100]',
            'terms' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'company' => $this->request->getPost('company') ?? null,
            'status' => 'inactive', // Will be activated after email verification
            'created_at' => date('Y-m-d H:i:s')
        ];

        $userModel = new UserModel();
        
        try {
            // Create user
            $userId = $userModel->insert($userData);
            
            if ($userId) {
                // Send magic link for email verification/activation
                if ($this->sendMagicLink($userId, $userData['email'], true)) {
                    return redirect()->back()->with(
                        'success', 
                        'Account created successfully! We\'ve sent a magic link to your email to activate your account.'
                    );
                } else {
                    // If email fails, delete the user and show error
                    $userModel->delete($userId);
                    return redirect()->back()->withInput()->with(
                        'error', 
                        'Account created but failed to send activation email. Please try again.'
                    );
                }
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to create account. Please try again.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Registration error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An error occurred during registration. Please try again.');
        }
    }
    
    
    private function sendMagicLink($userId, $userEmail, $isRegistration = false)
    {
        try {
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            $userModel = new UserModel();
            $userModel->update($userId, [
                'magic_link_token' => $token,
                'token_expires' => $expires
            ]);
            
            $magicLink = site_url("auth/verify/{$token}");
            
            // Create a fresh email instance each time
            $email = \Config\Services::email();
            
            // Simple configuration - try both common setups
            $config = [
                'protocol' => 'smtp',
                'SMTPHost' => 'mail.lafabsolution.com',
                'SMTPUser' => 'admin@lafabsolution.com',
                'SMTPPass' => 'Ghaf@fgRtK2y',
                'SMTPPort' => 465,
                'SMTPCrypto' => 'ssl',
                'SMTPTimeout' => 30,
                'mailType' => 'html',
                'charset' => 'UTF-8'
            ];
            
            $email->initialize($config);
            
            if ($isRegistration) {
                $email->setSubject('Activate Your Account - LaFab AI Posting');
                $message = $this->getActivationEmailTemplate($magicLink);
            } else {
                $email->setSubject('Your Magic Login Link - LaFab AI Posting');
                $message = $this->getLoginEmailTemplate($magicLink);
            }
            
            $email->setTo($userEmail);
            $email->setFrom('admin@lafabsolution.com', 'AI Assisted Posting');
            $email->setMessage($message);
            
            if ($email->send()) {
                log_message('info', 'Magic link email sent successfully to: ' . $userEmail);
                return true;
            } else {
                log_message('error', 'Email sending failed for: ' . $userEmail);
                return false;
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Email exception: ' . $e->getMessage());
            return false;
        }
    }


    private function getActivationEmailTemplate($magicLink)
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
                .button { display: inline-block; background: #3498db; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; }
                .footer { text-align: center; margin-top: 20px; color: #7f8c8d; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Activate Your Account</h2>
                    <p>LaFab AI Powered Job Posting</p>
                </div>
                <div class='content'>
                    <p>Welcome to LaFab AI Posting!</p>
                    <p>Thank you for registering. To activate your account and start automating your job postings, please click the button below:</p>
                    <p style='text-align: center;'><a href='{$magicLink}' class='button'>Activate Account</a></p>
                    <p>This activation link will expire in 1 hour for security reasons.</p>
                    <p>If you didn't create an account, please ignore this email.</p>
                </div>
                <div class='footer'>
                    <p>&copy; 2023 LaFab Solution Company Limited. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }


    public function registerSuccess()
    {
        $session = session();

        // Check if user is already logged in
        if ($session->has('logged_in') && $session->get('logged_in') === true) {
            return redirect()->to('/dashboard');
        }
        return view('auth/register_success');
    }
    
    // private function sendMagicLink($userId, $userEmail)
    // {
    //     try {
    //         $token = bin2hex(random_bytes(32));
    //         $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
    //         $userModel = new UserModel();
    //         $userModel->update($userId, [
    //             'magic_link_token' => $token,
    //             'token_expires' => $expires
    //         ]);
            
    //         $magicLink = site_url("auth/verify/{$token}");
            
    //         // Use the pre-configured email service
    //         $email = \Config\Services::email();
            
    //         $email->setTo($userEmail);
    //         $email->setSubject('Your Magic Login Link - LaFab AI Posting');
    //         $email->setMessage($this->getMagicLinkEmailTemplate($magicLink));
            
    //         if ($email->send()) {
    //             log_message('info', 'Magic link email sent successfully to: ' . $userEmail);
    //             return true;
    //         } else {
    //             log_message('error', 'Email sending failed for: ' . $userEmail);
    //             return false;
    //         }
            
    //     } catch (\Exception $e) {
    //         log_message('error', 'Email exception: ' . $e->getMessage());
    //         return false;
    //     }
    // }
        
    public function verify($token)
    {
        $user = $this->userModel->isTokenValid($token);
        
        if (!$user) {
            return redirect()->to('/auth/invalid-token')->with('error', 'Invalid or expired magic link.');
        }
        
        // Verify user email
        $this->userModel->verifyMagicLink($token);
        
        // Set user session or redirect to login
        session()->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'logged_in' => true
        ]);
        
        return redirect()->to('/dashboard')->with('success', 'Email verified successfully!');
    }
    
    public function invalidToken()
    {
        return view('auth/invalid_token');
    }

    public function login()
    {
        $session = session();

        // Check if user is already logged in
        if ($session->has('logged_in') && $session->get('logged_in') === true) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }
    
    public function loginLogic()
    {
        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', 'Please provide a valid email address');
        }

        $email = $this->request->getPost('email');
        
        // Check if user exists
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            // Optionally, you could create a new user here instead of showing error
            return redirect()->back()->withInput()->with('error', 'No account found with this email. Please register first.');
        }

        // Send magic link
        if ($this->sendMagicLink($user['id'], $user['email'])) {
            return redirect()->back()->with('success', 'Magic link sent to your email! Check your inbox and spam folder.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to send magic link. Please try again.');
        }
    }
    
    public function loginSuccess()
    {
        return view('auth/login_success');
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
    
    private function getLoginEmailTemplate($magicLink)
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
                .button { display: inline-block; background: #3498db; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; }
                .footer { text-align: center; margin-top: 20px; color: #7f8c8d; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Your Magic Login Link</h2>
                    <p>LaFab AI Powered Job Posting</p>
                </div>
                <div class='content'>
                    <p>Hello,</p>
                    <p>Click the button below to securely login to your LaFab AI Posting account:</p>
                    <p style='text-align: center;'><a href='{$magicLink}' class='button'>Login to Account</a></p>
                    <p>This magic link will expire in 1 hour for security reasons.</p>
                    <p>If you didn't request this login link, please ignore this email.</p>
                </div>
                <div class='footer'>
                    <p>&copy; 2023 LaFab Solution Company Limited. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
}
