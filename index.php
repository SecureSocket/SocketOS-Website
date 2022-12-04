<?php
//Include Configuration File
include('config.php');
$login_button = '';
//This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
if(isset($_GET["code"]))
{
 //It will Attempt to exchange a code for an valid authentication token.
 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
 //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
 if(!isset($token['error']))
 {
  //Set the access token used for requests
  $google_client->setAccessToken($token['access_token']);
  //Store "access_token" value in $_SESSION variable for future use.
  $_SESSION['access_token'] = $token['access_token'];
  //Create Object of Google Service OAuth 2 class
  $google_service = new Google_Service_Oauth2($google_client);
  //Get user profile data from google
  $data = $google_service->userinfo->get();
  //Below you can find Get profile data and store into $_SESSION variable
  if(!empty($data['given_name']))
  {
   $_SESSION['user_first_name'] = $data['given_name'];
  }
  if(!empty($data['family_name']))
  {
   $_SESSION['user_last_name'] = $data['family_name'];
  }
  if(!empty($data['email']))
  {
   $_SESSION['user_email_address'] = $data['email'];
  }
  if(!empty($data['gender']))
  {
   $_SESSION['user_gender'] = $data['gender'];
  }
  if(!empty($data['picture']))
  {
   $_SESSION['user_image'] = $data['picture'];
  }
 }
}

//This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
if(!isset($_SESSION['access_token']))
{
 //Create a URL to obtain user authorization
 $login_button = '<a class="button" href="'.$google_client->createAuthUrl().'">Login to Download</a>';
}

// store session first name, last name, emails in database
$con = mysqli_connect("localhost" , "root", "", "socketos");
if(isset($_SESSION['user_email_address']))
{
	$fname = $_SESSION['user_first_name'];
	$email = $_SESSION['user_email_address'];
	$query="select * from users where fname='".$fname."'";
	$result=mysqli_query($con,$query);
	$duplicate=mysqli_num_rows($result);
	if($duplicate==0){
		$sql = "INSERT IGNORE INTO users (fname, email) VALUES ('$fname', '$email')";
		$result=mysqli_query($con,$sql);
	}
	else {
		$result=mysqli_query($con,$query);
	}
}

?>
<!DOCTYPE HTML>
<html>

<head>
	<title>Socket OS : By Secure Socket Group</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="shortcut icon" href="assets/images/logo.png">
	<link rel="stylesheet" href="assets/css/main.css" />
</head>

<body class="is-preload">

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- nav -->
		<nav id="nav">
			<a href="#"><span>Home</span></a>
			<a href="#contact"><span>Contact</span></a>
			<?php
				if($login_button == ''){							
					echo '<a href="logout.php"><span>Logout</span></a>';
				}
				else {
					echo '<a href="'.$google_client->createAuthUrl().'"><span>Login</span></a>';
				}
			?>
			</li>
		</nav>

		<!-- Header -->
		<header id="header" class="alt">
			<span class="logo"><img width="100px" src="assets/images/logo.png" alt="" /></span>
			<h1>Socket OS</h1>
			<p>Yet another Linux distribution for Penetration Testers</p>
		</header>

		<!-- Main -->
		<div id="main">

			<!-- Introduction -->
			<section id="intro" class="main">
				<div class="spotlight">
					<div class="content">
						<header class="major">
							<h2>What is SocketOS?</h2>
						</header>
						<p>SocketOS is just another Linux distribution for Penetration Testers.
							It comes with 200+ tools pre-installed and ready to use.
							SocketOS provides you the best out of the box Command Line Interface (CLI) along with Graphical User Interface (GUI).</p>
						<ul class="actions">
							<li>
							<?php
   								if($login_button == ''){							
									echo '<a href="download.html" class="button">Download</a>';
								}
								else {
									echo $login_button;
								}
							?>
							</li>
						</ul>
					</div>
					<span class="image"><img src="assets/images/socket.png" alt="" /></span>
				</div>
			</section>

			<!-- Features -->
			<section id="first" class="main special">
				<header class="major">
					<h2>Features</h2>
				</header>
				<ul class="features">
					<li>
						<span class="icon solid major style1 fa-feather"></span>
						<h3>Minimal</h3>
						<p>SocketOS is very minimal and lightweight.
							It can run under 1GB of memory as it only uses window managers and some lightweight
							applications.</p>
					</li>
					<li>
						<span class="icon solid major style3 fa-heart"></span>
						<h3>Flexible</h3>
						<p>SocketOS look very clean, customizable and flexible Linux based Operating System. SocketOS is compatible for low configured machine.</p>
					</li>
					<li>
						<span class="icon solid major style5 fa-cog"></span>
						<h3>Powerful</h3>
						<p>With pre-installed 200+ widely used penetration testing tools. SocketOS gives you the power to do whatever you want on your Linux Machine.</p>
					</li>
				</ul>
			</section>

			<!-- Need any help? -->
			<section id="contact" class="main special">
				<header class="major">
					<h2>Need any help?</h2>
				</header>
				<form action="contact.php" method="POST">
					<div class="field">
						<input type="text" name="name" placeholder="Enter your name" required>
					</div>
					<div class="field">
						<input type="email" name="email" placeholder="Enter your email" required>
					</div>
					<div class="field">
						<textarea name="message" placeholder="Any suggestion/feedback?" rows="6" required></textarea>
					</div>
					<div class="form-button">
						<a class="button" href="contact.php">Send Now</a>
					</div>
				</form>
			</section>

		</div>

		<!-- Footer -->
		<footer id="footer">
			<section class="pr-4">
				<h2>Secure Socket Group</h2>
				<p>Socket OS is made to stay out of the way as it helps you get things done super easily. But under its light and easy to use interface, it's a powerhouse in terms of performance. So you're free to choose ways of usage right as you need them and when you need them. Socket OS has everything you need for your daily and professional work.</p>
				<ul class="actions">
					<li><a href="https://github.com/SecureSocket/SocketOS" class="button">Contribute Now</a></li>
				</ul>
			</section>
			<section class="pl-4">
				<h2>Important Links</h2>
				<p>Links to SocketOS's github page, ISO Source, ISO Releases, New Issue, and my github page
					respectively. Make sure you hit the star on SocketOS repositories.</p>
				<ul class="icons">
					<li><a href="https://github.com/SecureSocket" target="_blank"
							class="icon brands fa-github alt"><span class="label">SocketOS</span></a></li>
					<li><a href="https://github.com/SecureSocket/SocketOS" target="_blank"
							class="icon solid fa-code alt"><span class="label">Repository</span></a></li>
					<li><a href="https://github.com/SecureSocket/releases" target="_blank"
							class="icon solid fa-folder-open alt"><span class="label">Releases</span></a></li>
					<li><a href="https://github.com/SecureSocket/SocketOS/issues/new" target="_blank"
							class="icon solid fa-bug alt"><span class="label">Issues</span></a></li>
					<li><a href="https://github.com/jineshngori" target="_blank" class="icon solid fa-user alt"><span
								class="label">Jinesh Nagori</span></a></li>
				</ul>
			</section>
		</footer>
		<p class="copyright text-center">&copy; Socket OS | <a href="" target="_blank">Secure Socket Group</a></p>
	</div>

	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/main.js"></script>
</body>

</html>