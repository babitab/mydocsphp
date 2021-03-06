<?php 
	
	require_once './core/init.php';

	$user = new User();

	if(!$user->isLoggedIn()){
		Redirect::to('index.php');
	}

	$user_data = $user->data();

	if(Input::exists()){
		if(md5(Input::get('currpassword')) === $user_data['password'] ){
			$validate = new Validate();
			$validate->validate($_POST,array(
				'password'=>array('label'=>'New Password', 'required'=>true, 'minlength'=>6),
				'repassword'=>array('label'=>'Re-Password', 'required'=>true, 'match'=>'password')
				)
			);
			if($validate->isValid()){
				$updateData = array(
					'password'=> md5(Input::get('password'))
					);
				$where = array('id', '=', $user_data['id']);
				try {
					$user->update($updateData, $where);
					Session::flash('password_success', 'Password successfully changed.');
	        Redirect::to('index.php');
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
		else{
			echo "<script>alert('Current passsword don\'t match')</script>";
		}
	}

	
 ?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Home</title>
	<link rel="stylesheet" href="./css/bootstrap.min.css">
 	<link rel="stylesheet" href="./css/style.css">
</head>
<body>
	<div class="home-wrapper">

		<div class="menu-bar">
			<nav class="navbar navbar-inverse navbarfixed-top" role="navigation"> 
				<div class="container">
					<div class="navbar-header"> 
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-items"> 
							<span class="material-icons md-light">menu</span> 
						</button>
						<a class="navbar-brand" href="#"> <span class="material-icons ">work</span> MyDocs</a> 
					</div> 
					<div class="pull-right collapse navbar-collapse" id="navbar-collapse-items"> 
						<ul class="nav navbar-nav"> 
							<li ><a href="#"> <span class="material-icons">home</span> Home</a></li> 
							<li ><a href="fileupload.php"> <span class="material-icons ">file_upload</span> Upload</a></li> 	
							<li class="dropdown active"> 
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
									<span class="material-icons ">account_box</span> 
								 	<span><?php echo $user_data['firstName']; ?> </span> 
								 	<span class="material-icons">arrow_drop_down</span>
								</a> 
								<ul class="dropdown-menu pull-right"> 
									<li><a href="profile.php"> <span class="material-icons ">face</span> Update Profile</a></li> 
									<li><a href="changepass.php"> <span class="material-icons ">lock</span> Change Password</a></li> 
									<li class="divider"></li>
									<li><a href="logout.php"> <span class="material-icons ">power_settings_new</span> Logout</a></li> 
								</ul> 
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="changepass-container">
			<h3>Change Password</h3>
	 		<form action="" method="POST" class="form-horizontal" role="form">
	 			<div class="form-group">
	 				<label for="currpassword" class="col-sm-4 control-label">Current Password</label>
	 				<div class="col-sm-8">
	 					<input type="password" class="form-control" id="currpassword" name="currpassword" required placeholder="Enter your current password">
	 				</div>
	 			</div>
	 			<div class="form-group">
	 				<label for="password" class="col-sm-4 control-label">New Password</label>
	 				<div class="col-sm-8">
	 					<input type="password" class="form-control" id="password" name="password" required placeholder="Enter new password">
	 				</div>
	 			</div>
	 			<div class="form-group">
	 				<label for="repassword" class="col-sm-4 control-label">Retype Password</label>
	 				<div class="col-sm-8">
	 					<input type="password" class="form-control" id="repassword" name="repassword" required placeholder="Retype new password">
	 				</div>
	 			</div>
 				<div id="changepass">
	 				<button type="submit"> Change <i class="material-icons">done</i></button>
	 			</div> 
	 		</form>
	 	</div>
	
	</div>
		<!-- include required javascript files -->
		<script src="./javascript/jquery.min.js"></script>
		<script src="./javascript/bootstrap.min.js"></script>
	 	<script src="./javascript/main.js"></script>
</body>
</html>		