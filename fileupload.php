<?php 

	require_once './core/init.php';

	$user = new User();

	if(!$user->isLoggedIn()){
		Redirect::to('index.php');
	}else{
	 	if(Input::exists('post') and Input::exists('files')){
	 		$dataValidate = new Validate();
	 		$dataValidate->validate($_POST, array(
	 			'documentType'=>array('label'=>'Document Type', 'required'=>true),
	 			'documentDescription'=>array('label'=>'Document Description', 'required'=>true, 'maxlength'=>50)
	 			));
	 		$fileValidate = new Validate();
	 		$fileValidate->validate($_FILES, array(
	 			'documentFile'=>array(
	 				'label'=>'Document File', 
	 				'required'=>true, 
	 				'size'=> 1000000, 
	 				'extension'=> array('pdf', 'docx')
	 				)
	 			));
	 		if($dataValidate->isValid() and $fileValidate->isValid()){
	 			
	 			$userData = $user->data();
	 			$fileData = $_FILES['documentFile'];

	 			$folderName = $userData['id'];
	 			$tmp_location = $fileData['tmp_name'];
	 			$fileName = $fileData['name'];
	 			$ext = pathinfo($fileName, PATHINFO_EXTENSION);
				$new_file_name = md5($fileName).substr(md5(microtime()), 10).'.'.$ext;
	 			
	 			// create new file object	
	 			$file = new File($folderName, $new_file_name);
	 			
	 			if($file->upload($tmp_location)){
	 				$fields = array(
	 					'userId'=>$userData['id'],
	 					'type'=>Input::get('documentType'),
	 					'name'=>$fileName,
	 					'tmpName'=>$new_file_name,
	 					'description'=>Input::get('documentDescription')
	 					);
	 				try {
	 					$user->addFile($fields);
	 					echo "<script>alert('File successfully uploaded.')</script>";
	 				} catch (Exception $e) {
	 					echo $e;
	 				}
				}else{
					echo "Error while uploading file";
				}
	 		}else{
	 			echo '<ul>';
	 			$errors = array();	
	 			if(!$dataValidate->isValid()){
	 				$errors = $dataValidate->errors();
	 				foreach ($errors as $error) {
	 					echo "<li>$error</li>";
	 				}
	 			}
	 			if(!$fileValidate->isValid()){
	 				$errors = $fileValidate->errors();
	 				foreach ($errors as $error) {
	 					echo "<li>$error</li>";
	 				}
	 			}
	 			echo "</ul>";
	 		}
	 	}
	}

	$user_data = $user->data();
	
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
			<nav class="navbar navbar-inverse navbr-fixed-top" role="navigation"> 
				<div class="container">
					<div class="navbar-header"> 
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-items"> 
							<span class="material-icons md-light">menu</span> 
						</button>
						<a class="navbar-brand" href="#"> <span class="material-icons ">work</span> MyDocs</a> 
					</div> 
					<div class="pull-right collapse navbar-collapse" id="navbar-collapse-items"> 
						<ul class="nav navbar-nav"> 
							<li ><a href="."> <span class="material-icons ">home</span> Home</a></li> 
							<li class="active"><a href="fileupload.php"> <span class="material-icons ">file_upload</span> Upload</a></li> 
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
			<div class="upload-document-container">
				<h3>Upload Document </h3>
				<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" role="form">
					<div class="form-group">
						<label for="documentType" class="col-sm-5 control-label">Selected Document Type*</label>
						<div class="col-sm-7">
							<select name="documentType" id="documentType" class="form-control" required>
								<option value="SSC Certificate" selected="true">SSC Certificate</option>
								<option value="HSC Certificate">HSC Certificate</option>
								<option value="Degree Certificate">Degree Certificate</option>
								<option value="PAN Card">PAN Card</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="documentFile" class="col-sm-5 control-label">Upload Document* <br> <em>(Max. Limit is 1MB)</em></label>
						<div class="col-sm-7">
							<input type="file" name="documentFile" id="documentFile" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label for="documentDescription" class="col-sm-5 control-label">Document Description* <br> <em>(Max. 50 Characters)</em></label>
						<div class="col-sm-7">
							<input type="text" name="documentDescription" id="documentDescription" class="form-control" required>
						</div>
					</div>
					<div class="form-group upload-button" > 
						<div class="col-sm-offset-5 col-sm-7"> 
							<button type="submit" class="pull-right">Upload <span class="material-icons md-18">file_upload</span></button>
						</div> 
					</div>
					<p> <b><em>File type must be of pdf, docx.</em></b></p>
				</form>
			</div>
		</div>
		
	</div>
	<!-- include required javascript files -->
	<script src="./javascript/jquery.min.js"></script>
	<script src="./javascript/bootstrap.min.js"></script>
 	<script src="./javascript/main.js"></script>
</body>
</html>

