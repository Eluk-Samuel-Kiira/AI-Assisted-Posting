<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'admin@lafabsolution.com';
    public string $fromName   = 'AI Assisted Posting';
    public string $recipients = '';

    public string $userAgent = 'CodeIgniter';
    public string $protocol = 'smtp';
    public string $mailPath = '/usr/sbin/sendmail';

    // SMTP Configuration
    public string $SMTPHost = 'mail.lafabsolution.com';
    public string $SMTPUser = 'admin@lafabsolution.com';
    public string $SMTPPass = 'Ghaf@fgRtK2y';
    public int $SMTPPort = 465;
    public int $SMTPTimeout = 10; // Increased timeout
    public bool $SMTPKeepAlive = false;
    
    // Change this line - use 'ssl' for port 465
    public string $SMTPCrypto = 'ssl';

    // Mail settings
    public bool $wordWrap = true;
    public int $wrapChars = 76;
    public string $mailType = 'html';
    public string $charset = 'UTF-8';
    public bool $validate = false;
    public int $priority = 3;
    public string $CRLF = "\r\n";
    public string $newline = "\r\n";
    public bool $BCCBatchMode = false;
    public int $BCCBatchSize = 200;
    public bool $DSN = false;
}