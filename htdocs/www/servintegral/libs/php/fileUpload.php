<?php

	$itemFolder =  array_keys($_FILES)[0];
	for($i=0; $i<count($_FILES[$itemFolder]['name']); $i++) 
	{
		// $destination_path = "/home/publihogar2015/public_html/wp-content/plugins/inmobiliaria/images/".$itemFolder."/";
		$destination_path = "/xampp/htdocs/www/publihogar/wp-content/plugins/inmobiliaria/images/".$itemFolder."/";

		$target_path =  $destination_path . basename( $_FILES[$itemFolder]['name'][$i]);
		
		if(@move_uploaded_file($_FILES[$itemFolder]['tmp_name'][$i], $target_path))
		{
			$result = 1;
			
		}
		else
		{
			$result = 0;
			
		}
//$result = $_FILES[$itemFolder]['name'][$i];

	}
	
	if($result == 1)
	{
		echo  '<script language="javascript" type="text/javascript">window.top.window.stopUpload("'.$result.'");</script>';
	}
	else
	{
		echo  '<script language="javascript" type="text/javascript">window.top.window.stopUpload("'.$result.'");</script> ';
	}
?>