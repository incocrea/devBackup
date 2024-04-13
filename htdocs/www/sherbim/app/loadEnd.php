<?php
	$itemFolder =  array_keys($_FILES)[0];
        
		$destination_path = "/home/leoncitobravo/public_html/sherbim/app/irsc/pics/".$itemFolder."/end/";
        
		// $destination_path = "/xampp/htdocs/www/sherbim/app/irsc/pics/".$itemFolder."/end/";
		
		// CREATE FOLDER IF NOT EXIST
		if(!file_exists($destination_path)){mkdir($destination_path, 0777);}
		
        // CLEAR FOLDER
        $files = glob($destination_path."*"); foreach($files as $file){ if(is_file($file))unlink($file); }
        // CREATE FILES
	for($i=0; $i<count($_FILES[$itemFolder]['name']); $i++) 
	{
		$target_path =  $destination_path . htmlentities(basename( $_FILES[$itemFolder]['name'][$i]));
		if(@move_uploaded_file($_FILES[$itemFolder]['tmp_name'][$i], $target_path)){$result = 1;}else{$result = 0;}
	}
        // RETURN TO JS
	if($result == 1){echo '<script language="javascript" type="text/javascript">window.top.window.loadFinish("'.$result.'");</script>';}
	else{echo '<script language="javascript" type="text/javascript">window.top.window.loadFinish("'.$result.'");</script> ';}
?>