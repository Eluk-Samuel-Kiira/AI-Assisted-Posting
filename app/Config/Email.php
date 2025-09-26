<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail;
    public string $fromName;
    public string $protocol = 'smtp';
    public string $SMTPHost;
    public string $SMTPUser;
    public string $SMTPPass;
    public int $SMTPPort;
    public string $SMTPCrypto;
    public int $SMTPTimeout = 30;
    public string $mailType = 'html';
    public string $charset = 'UTF-8';

    public function __construct()
    {
        parent::__construct();
        
        // Load from environment variables
        $this->fromEmail = env('email.default.fromEmail', 'admin@lafabsolution.com');
        $this->fromName = env('email.default.fromName', 'AI Assisted Posting');
        $this->SMTPHost = env('email.SMTPHost', 'mail.lafabsolution.com');
        $this->SMTPUser = env('email.SMTPUser', 'admin@lafabsolution.com');
        $this->SMTPPass = env('email.SMTPPass', '');
        $this->SMTPPort = env('email.SMTPPort', 465);
        $this->SMTPCrypto = env('email.SMTPCrypto', 'ssl'); // Default to ssl for port 465
    }
}