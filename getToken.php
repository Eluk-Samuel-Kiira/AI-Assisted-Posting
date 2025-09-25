<?php

require __DIR__ . '/vendor/autoload.php';

use Google\Client as Google_Client;
use Google\Service\Gmail as Google_Service_Gmail;

$client = new Google_Client();
$client->setAuthConfig(__DIR__ . '/writable/credentials.json'); // Your credentials
$client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob'); // For manual copy-paste
$client->addScope(Google_Service_Gmail::GMAIL_READONLY);
$client->setAccessType('offline');
$client->setPrompt('consent');

$authUrl = $client->createAuthUrl();
echo "Open this link in your browser:\n$authUrl\n\n";
echo "Enter the verification code: ";

$handle = fopen("php://stdin", "r");
$code = trim(fgets($handle));

$accessToken = $client->fetchAccessTokenWithAuthCode($code);
file_put_contents(__DIR__ . '/writable/token.json', json_encode($accessToken));

echo "Token saved to writable/token.json\n";
