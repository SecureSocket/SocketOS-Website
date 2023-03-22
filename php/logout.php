<?php

//logout.php

include('config.php');

//Reset OAuth access token
unset($_SESSION['access_token']);

//Destroy entire session data.
session_destroy();

//redirect page to index.php
header('location:index.php');

?>