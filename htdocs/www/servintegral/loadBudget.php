<?php
	$itemFolder =  array_keys($_FILES)[0];
        
	$destination_path = "/home/leoncitobravo/public_html/servintegral/budgets/";
	
	 // $destination_path = "/xampp/htdocs/www/servintegral/budgets/";
        

	$dir_path =  $destination_path.$itemFolder."/";
	$hasDir = file_exists($dir_path);
	
	if($hasDir != true)
	{
		// CREATE FOLDER
		mkdir($dir_path, 0777, true);
	}
	else
	{
		 // CLEAR FOLDER
        $files = glob($dir_path."*"); foreach($files as $file){ if(is_file($file))unlink($file); }
	}

	// CREATE FILES
	$target_path =  $dir_path . htmlentities(basename( $_FILES[$itemFolder]['name'][0]));


	if(@move_uploaded_file($_FILES[$itemFolder]['tmp_name'][0], $target_path)){$result = 1;}else{$result = 0;}

	
	
	// RETURN TO JS
	echo '<script language="javascript" type="text/javascript">window.top.window.loadFinish("'.$result.'");</script> ';
?>