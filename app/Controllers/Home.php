<?php

namespace App\Controllers;
use Google\Client as Google_Client;
use Google\Service\Gmail as Google_Service_Gmail;

class Home extends BaseController
{

    public function index(): string
    {
        
        $data = [
            'title' => 'LinkedIn Mail Processor',
            'description' => 'Process promotional emails from LinkedIn and store them in database',
            'stats' => [
                'processed_emails' => 1254,
                'active_campaigns' => 23,
                'database_entries' => 4567
            ]
        ];
        return view('welcome_message', $data);
    }



    private function getClient()
    {
        $client = new Google_Client();
        $client->setAuthConfig(WRITEPATH . 'credentials.json');
        $client->addScope(Google_Service_Gmail::GMAIL_READONLY);
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setRedirectUri(site_url('oauth2callback')); // must match Google console redirect

        return $client;
    }


    public function processEmail()
    {
        $client = $this->getClient();
        $tokenPath = WRITEPATH . 'token.json';

        // Check if code is returned from Google
        $code = $this->request->getGet('code');
        if ($code) {
            // Log the code for debugging
            log_message('info', 'Google OAuth code received: ' . $code);

            // Exchange code for access token
            $accessToken = $client->fetchAccessTokenWithAuthCode($code);
            file_put_contents($tokenPath, json_encode($accessToken));
            return redirect()->to('/'); // redirect to reload
        }

        // Load saved token if exists
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If no token or expired, redirect to Google auth
        if (!$client->getAccessToken() || $client->isAccessTokenExpired()) {
            $authUrl = $client->createAuthUrl();

            // Log the redirect URL too
            log_message('info', 'Redirecting to Google Auth URL: ' . $authUrl);

            return redirect()->to($authUrl);
        }

        // Gmail service
        $service = new Google_Service_Gmail($client);
        $messagesResponse = $service->users_messages->listUsersMessages('me', ['maxResults' => 10]);
        $messages = $messagesResponse->getMessages();

        if (empty($messages)) {
            return "No Messages Found.";
        }

        $output = "<h2>Latest Gmail Messages</h2><ul>";
        foreach ($messages as $message) {
            $msg = $service->users_messages->get('me', $message->getId());
            $headers = $msg->getPayload()->getHeaders();

            $subject = '';
            $from = '';
            foreach ($headers as $header) {
                if ($header->getName() === 'Subject') $subject = $header->getValue();
                if ($header->getName() === 'From') $from = $header->getValue();
            }

            $output .= "<li><strong>From:</strong> $from <br><strong>Subject:</strong> $subject</li><hr>";
        }
        $output .= "</ul>";

        return $output;
    }




    
    
    public function dashboard()
    {
        // Dashboard for viewing processed data
        $data = [
            'title' => 'Dashboard - LinkedIn Processor',
            'recent_emails' => [] // Will be populated from database
        ];
        
        return view('dashboard', $data);
    }
}
