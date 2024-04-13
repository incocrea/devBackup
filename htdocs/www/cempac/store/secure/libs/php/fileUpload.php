<?php

	$fileName =  array_keys($_FILES)[0];

	$destination_path = "/home/leoncitobravo/public_html/itsfree/irsc/campaigns/";
	// $destination_path = "../../irsc/campaigns/";

	$target_path =  $destination_path . $fileName . ".png";
	
	// var_dump($_FILES[$fileName]['tmp_name']);
	
	if(@move_uploaded_file($_FILES[$fileName]['tmp_name'], $target_path))
	{
		$result = 1;
	}
	else
	{
		$result = 0;
	}
	if($result == 1)
	{
		echo  '<script language="javascript" type="text/javascript">window.top.window.stopUpload("1");</script> ';
	}
	else
	{
		echo  '<script language="javascript" type="text/javascript">window.top.window.stopUpload("0");</script> ';
	}
?>