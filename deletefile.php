<?php 
		
	require_once './core/init.php';
	
	$user = new User();	

	if($user->isLoggedIn()){
		if(Input::exists('get')){
			$fileName = Input::get('fileName');
			$folderName = $user->data()['id'];
			if($fileName != ''){
				$file = new File($folderName, $fileName);
				if($file->delete()){
					$where = array("tmpName", "=", $fileName);
					try {
						$user->deleteFile($where);
						Session::flash('file_delete', 'File successfully deleted.');
						Redirect::to('index.php');
					} catch (Exception $e) {
						Session::flash('file_delete', $e);
						Redirect::to('index.php');
					}
				}else{
					Session::flash('file_delete', 'Error while deleting file.');
					Redirect::to('index.php');
				}
			}
		}
	}

 ?>