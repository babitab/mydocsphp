<?php 

	require_once './core/init.php';

	if(Input::exists()){
		$validate = new Validate();
		$validate->validate($_POST,array(
			'firstName'=>array('label'=>'First Name', 'required'=>true, 'minlength'=>3, 'maxlength'=>20),
			'lastName'=>array('label'=>'Last Name', 'maxlength'=>20),
			'email'=>array('label'=>'Email','unique'=>'users', 'required'=>true),
			'password'=>array('label'=>'Password', 'required'=>true, 'minlength'=>6),
			'repassword'=>array('label'=>'Re-Password', 'required'=>true, 'match'=>'password')
			)
		);
		if($validate->isValid()){
			$user = new User();
			$userData = array(
				'firstName'=> Input::get('firstName'),
				'lastName'=> Input::get('lastName'),
				'email'=> Input::get('email'),
				'password'=> md5(Input::get('password'))
				);
			try {
				$user->create($userData);
				Session::flash('registration_success', 'Welcome ' . Input::get('firstName') .Input::get('lastName'). '! Your account has been registered. You may now log in.');
        Redirect::to('login.php');
			} catch (Exception $e) {
				echo $e;
			}
		}else{
			echo "<ul>";
			$errors = $validate->errors();
			foreach ($errors as $error) {
				echo "<li>$error</li>";
			}
			echo "</ul>";
		}
	}
 ?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sign Up</title>
 	<link rel="stylesheet" href="./css/bootstrap.min.css">
 	<link rel="stylesheet" href="./css/style.css">
</head>
<body>
 	<div class="wrapper">
 		<div class="menu-bar">
			<nav class="navbar navbar-inverse nabar-fixed-top" role="navigation"> 
				<div class="container">
					<div class="navbar-header"> 
						<a class="navbar-brand" href="#"><span class="material-icons">work</span> MyDocs</a> 
					</div> 
				</div>
			</nav>
		</div>
	 	<div class="signup-container">
	 		<h3>Sign up</h3>
	 		<form action="" method="POST">
	 			<div class="row">
	 				<div class="col-sm-6">
	 					<div class="form-group">
	 						<input type="text" name="firstName" id="firstName" class="form-control" required
	 						value="<?php if(Input::exists()) echo Input::get('firstName'); ?>"/>
		 					<label for="firstName">First Name*</label>
	 					</div>
		 			</div>
		 			<div class="col-sm-6">
		 				<div class="form-group">
			 				<input type="text" name="lastName" id="lastName" class="form-control"  autocomplete="false"
			 				value="<?php if(Input::exists()) echo Input::get('lastName'); ?>"/>
			 				<label for="lastName">Last Name</label>
			 			</div>
		 			</div>
	 			</div>
	 			<div class="row">
	 				<div class="col-sm-12">
						<div class="form-group">
			 				<input type="email" name="email" id="email" class="form-control" required autocomplete="false"
			 				value="<?php if(Input::exists()) echo Input::get('email'); ?>"/>
			 				<label for="email">Email*</label>
			 			</div>
					</div>	
	 			</div>
	 			<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
			 				<input type="password" name="password" id="password" class="form-control" required/>
			 				<label for="password">Password*</label>
			 			</div>
			 		</div>	
					<div class="col-sm-6">
						<div class="form-group">
			 				<input type="password" name="repassword" id="repassword" class="form-control" required/>
			 				<label for="repassword">Re-Password*</label>
			 			</div>
					</div>
				</div>	
	 			<div  id="submit">
	 				<button type="submit">Submit</button>
	 			</div>
	 		</form>
	 		<div class="other-options">
		 			<a href="login.php">Already have an account ?</a>
		 	</div>
	 	</div>
 	</div>
 	<script src="./javascript/jquery.min.js"></script>
 	<script src="./javascript/main.js"></script>
 </body>
</html>