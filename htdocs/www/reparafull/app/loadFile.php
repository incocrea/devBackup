<?php
	
	$fileKey = array_keys($_FILES)[0];
	$loadType = explode ("-",$fileKey)[0];
	$itemFolder =  explode ("-",$fileKey)[1];

	$destination_path = "/home/opdbw2fq1quk/public_html/app/files/";
	// $destination_path = "/xampp/htdocs/www/reparafull/app/files/";
	
	if($loadType == "Doc")
	{
		$dir_path =  $destination_path.$itemFolder."-doc/";
		$target_path =  $dir_path."Documento.jpg";
	}
	if($loadType == "Sop1")
	{
		$dir_path =  $destination_path.$itemFolder."-sop1/";
		$target_path =  $dir_path."Certificado 1.jpg";
	}
	if($loadType == "Sop2")
	{
		$dir_path =  $destination_path.$itemFolder."-sop2/";
		$target_path =  $dir_path."Certificado 2.jpg";
	}
	if($loadType == "Sop3")
	{
		$dir_path =  $destination_path.$itemFolder."-sop3/";
		$target_path =  $dir_path."Certificado 3.jpg";
	}

	$hasDir = file_exists($dir_path);
	if($hasDir != true){mkdir($dir_path, 0777, true);}
	else{$files = glob($dir_path."*"); foreach($files as $file){ if(is_file($file))unlink($file);}}
	if(@move_uploaded_file($_FILES[$fileKey]['tmp_name'][0], $target_path)){$result = 1;}else{$result = 0;}
	// RETURN TO JS
	echo '<script language="javascript" type="text/javascript">window.top.window.loadFinish("'.$result.'");</script> ';
?>