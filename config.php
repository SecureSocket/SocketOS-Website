<?php
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('800569414412-0b1ubuj79qkqlaph2isj3nqqf267fnb3.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/socketos/index.php');
$google_client->addScope('email');
$google_client->addScope('profile');

// connect to local database
$con = mysqli_connect("localhost" , "root", "", "socketos");

//start session on web page
session_start();
?>