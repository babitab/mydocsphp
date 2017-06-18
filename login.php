<?php 

	require_once './core/init.php';

	$user = new User();

	if($user->isLoggedIn()){
		Redirect::to('index.php');
	}

	if(Session::exists('registration_success')){
		echo "<script>alert('".Session::flash('registration_success')."')</script>";
	}

	if(Input::exists()){
		$validate = new Validate();
		$validate->validate($_POST, array(
			'email'=> array('label'=>'Email', 'required'=>true),
			'password'=> array( 'label'=>'Password', 'required'=>true)
			));

		if($validate->isValid()){
			$login = $user->login(Input::get('email'), Input::get('password'));
			if($login['success'] == true){
				Session::flash('login_success', "Login Success");
				Redirect::to('index.php');
			}else{
				$message =  $login['message'];
				echo "<script>alert('$message');</script>";
			}
		}else{
			$errors = $validate->errors(); 
			echo "<ul>";
			foreach ($errors as $error) {
				echo "<li> $error </li>";
			}
			echo "</ul>";
		}
	}

 ?>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>
 	<link rel="stylesheet" href="./css/bootstrap.min.css">
 	<link rel="stylesheet" href="./css/style.css">
</head>
<body>
 	<div class="wrapper">
 		<div class="menu-bar">
			<nav class="navbar navbar-inverse nvbar-fixed-top" role="navigation"> 
				<div class="container">
					<div class="navbar-header"> 
						<a class="navbar-brand" href="#"><span class="material-icons">work</span> MyDocs</a> 
					</div> 
				</div>
			</nav>
		</div>
	 	<div class="login-container">
	 		<h3>Login</h3>
	 		<!-- action='#' means the current page -->
	 		<form action="login.php" method="POST">
	 			<div class="input-group" >
	 				<span class="input-group-addon">
	 					<span class="material-icons md-light">email</span>	
	 				</span>
	 				<input class="form-control" type="email" name="email" id="email" placeholder="Email" required/>
	 			</div>
	 			<div class="input-group">
	 				<span class="input-group-addon">
	 					<span class="material-icons md-light">vpn_key</span>
	 				</span>
	 				<input class="form-control" type="password" name="password" id="password" placeholder="Password" required/>
	 			</div>	
	 			<div id="login">
	 				<button type="submit">Login</button>
	 			</div>
	 		</form>
	 		<div class="other-options">
	 			<a href="registration.php">Need an account ?</a>
	 		</div>
	 	</div>
 	</div>

 	<script src="./javascript/jquery.min.js"></script>
 	<script src="./javascript/main.js"></script>
</body>
</html>