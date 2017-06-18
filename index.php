<?php 

	require_once './core/init.php';

	$user = new User();
	if(!$user->isLoggedIn()){
		Redirect::to('login.php');	
	}

	if(Session::exists('password_success')){
		echo "<script>alert('".Session::flash('password_success')."')</script>";
	}

	if(Session::exists('file_delete')){
		echo "<script>alert('".Session::flash('file_delete')."')</script>";
	}

	if(Session::exists('profile_update')){
		echo "<script>alert('".Session::flash('profile_update')."')</script>";
	}	

	$user_data = $user->data();
	$user_files = $user->files();
	
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
			<nav class="navbar navbar-inverse navar-fixed-top" role="navigation"> 
				<div class="container">
					<div class="navbar-header"> 
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-items"> 
							<span class="material-icons md-light">menu</span> 
						</button>
						<a class="navbar-brand" href="#"> <span class="material-icons ">work</span> MyDocs</a> 
					</div> 
					<div class="pull-right collapse navbar-collapse" id="navbar-collapse-items"> 
						<ul class="nav navbar-nav"> 
							<li class="active"><a href="."> <span class="material-icons ">home</span> Home</a></li> 
							<li ><a href="fileupload.php"> <span class="material-icons ">file_upload</span> Upload</a></li> 
							<li class="dropdown"> 
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
									<span class="material-icons ">account_box</span> 
								 	<span><?php echo $user_data['firstName']; ?> </span> 
								 	<span class="material-icons ">arrow_drop_down</span>
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

		<div class="container">
			<div class="row">
				<?php
					if(empty($user_files)){
				?>	
				<div class="col-sm-12">
					<div class="user-documents">
						<h3>Uploaded Documents</h3>	
						<p class="no-documents">No document have been uploaded.</p>
					</div>
				</div>
				<?php
				}else{
					foreach ($user_files as $file) {
						?>
				<div class="col-sm-5">
					<div class="user-documents">
						<h3><?php echo $file["type"]; ?></h3>
						<div class="row document">
							<div class="col-sm-4 key">
								Description
							</div>
							<div class="col-sm-8 value">
								<?php echo $file["description"]; ?>		
							</div>
							<div class="col-xs-6 action download">
								<a href="./download.php?fileName=<?php echo $file["tmpName"]; ?>&actualName=<?php echo $file["name"]; ?>" ><span>Download</span> &nbsp;<span class="material-icons md-18">file_download</span></a>
							</div>
							<div class="col-xs-6 action delete">
								<a href="./deletefile.php?fileName=<?php echo $file["tmpName"]; ?>" ><span>Delete</span> &nbsp;<span class="material-icons md-18">delete</span></a>
							</div>
						</div>
					</div>
				</div>	
						<?php
					}
				}	
				?>							
			</div>
		</div>
	</div>
	<!-- include required javascript files -->
	<script src="./javascript/jquery.min.js"></script>
	<script src="./javascript/bootstrap.min.js"></script>
 	<script src="./javascript/main.js"></script>
</body>
</html>

