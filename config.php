<?php
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('645181427842-k0hpngr4ehsh83oc5mjlfivobktn0ktk.apps.googleusercontent.com');

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