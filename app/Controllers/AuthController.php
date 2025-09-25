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
        $validation = \Config\Services::validation();
        
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'full_name' => 'required|min_length[3]|max_length[255]',
            'email' => 'required|valid_email|is_unique[users.email]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Create user without password
        $userData = [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'email_verified' => 0
        ];
        
        $userId = $this->userModel->insert($userData);
        
        if ($userId) {
            // Generate and send magic link
            if ($this->sendMagicLink($userId, $userData['email'])) {
                return redirect()->to('/register/success')->with('success', 'Magic link sent to your email!');
            } else {
                // Delete user if email fails
                $this->userModel->delete($userId);
                $error = $this->email->printDebugger(['headers']);
                return redirect()->back()->withInput()->with('error', 'Failed to send magic link. Please try again. Error: ' . $error);
            }
        }
    }
    


    public function registerSuccess()
    {
        return view('auth/register_success');
    }
    
    private function sendMagicLink($userId, $userEmail)
    {
        try {
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            $this->userModel->update($userId, [
                'magic_link_token' => $token,
                'token_expires' => $expires
            ]);
            
            $magicLink = site_url("auth/verify/{$token}");
            
            // Initialize email with correct settings
            $emailConfig = [
                'protocol' => 'smtp',
                'SMTPHost' => 'mail.lafabsolution.com',
                'SMTPUser' => 'admin@lafabsolution.com',
                'SMTPPass' => 'Ghaf@fgRtK2y',
                'SMTPPort' => 465, // Match your config
                'SMTPCrypto' => 'ssl', // Match your config
                'SMTPTimeout' => 10,
                'mailType' => 'html',
                'charset' => 'UTF-8'
            ];
            
            $this->email->initialize($emailConfig);
            $this->email->setTo($userEmail);
            $this->email->setFrom('admin@lafabsolution.com', 'AI Assisted Posting');
            $this->email->setSubject('Complete Your Registration - Magic Link');
            
            $message = $this->getEmailTemplate($magicLink);
            $this->email->setMessage($message);
            
            if ($this->email->send()) {
                log_message('info', 'Magic link email sent successfully to: ' . $userEmail);
                return true;
            } else {
                $error = $this->email->printDebugger(['headers']);
                log_message('error', 'Email sending failed: ' . $error);
                return false;
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Email exception: ' . $e->getMessage());
            return false;
        }
    }
    
    public function verify($token)
    {
        $user = $this->userModel->isTokenValid($token);
        
        if (!$user) {
            return redirect()->to('/auth/invalid-token')->with('error', 'Invalid or expired magic link.');
        }
        
        // Verify user email
        $this->userModel->verifyEmail($user['id']);
        
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
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            
            $user = $this->userModel->where('email', $email)->first();
            
            if ($user) {
                if ($this->sendMagicLink($user['id'], $user['email'])) {
                    return redirect()->to('/login/success')->with('success', 'Magic link sent to your email!');
                }
            }
            
            // Always show success message for security (don't reveal if email exists)
            return redirect()->to('/login/success')->with('success', 'If an account exists, a magic link has been sent to your email.');
        }
        
        return view('auth/login');
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
    
    private function getEmailTemplate($magicLink)
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .button { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
                .footer { margin-top: 20px; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Complete Your Authentication</h2>
                <p>Click the button below to authenticate your account. This link will expire in 1 hour.</p>
                <p>
                    <a href='{$magicLink}' class='button'>Authenticate My Account</a>
                </p>
                <p>Or copy and paste this link in your browser:</p>
                <p>{$magicLink}</p>
                <div class='footer'>
                    <p>If you didn't request this, please ignore this email.</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
}
