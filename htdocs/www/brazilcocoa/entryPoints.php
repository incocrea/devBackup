<?php

date_default_timezone_set("America/Bogota");
$method = $_GET["method"];
include 'comm.php';

$method();

function getPropList()
{
	$table = 'props';
    $type = $_GET["type"];
	$get_info = new sql_query();
	
	$data = $get_info->query("SELECT * FROM $table WHERE RTYPE = '".$type."' ORDER BY CODE ASC");
        
        // if(count($data == 0))
        // {
                // $data = array();
        // }
        

	echo json_encode($data);
}

function saveNew()
{
	$table = 'props';
	$commBd = new sql_query();
	$getCounter = $commBd->query("SELECT $table.PROPCOUNTER FROM $table ORDER BY PROPCOUNTER ASC");

	// GET COUNTER
	if (count($getCounter) > 0)
	{
                $counter = (int)($getCounter[count($getCounter)-1]["PROPCOUNTER"])+1;
        }
	else
	{
                $counter = 1;	
        }
	
	$status = $_GET["status"];
	$op = $_GET["op"];
	$type = $_GET["type"];
	$city = $_GET["city"];
	$zone = $_GET["zone"];
	$price = $_GET["price"];
	$rooms = $_GET["rooms"];
	$mts = $_GET["mts"];
	$model = $_GET["model"];
	$mark = $_GET["mark"];
	$notes = $_GET["notes"];
	$video = $_GET["video"];
	$propCounter = $counter;
	$rtype = $_GET["rtype"];
	$pics ="";
	$cname = $_GET["cname"];
	$cphone = $_GET["cphone"];
	$cdate = $_GET["cdate"];
	$endDate = $_GET["endDate"];

	if($type == "Apartaestudio"){$prefix =  "AE";}
	else if($type == "Apartamento"){$prefix =  "AP";}
	else if($type == "Bodega"){$prefix =  "BO";}
	else if($type == "Casa"){$prefix =  "CS";}
	else if($type == "Edificio"){$prefix =  "ED";}
	else if($type == "Finca"){$prefix =  "FI";}
	else if($type == "Local"){$prefix =  "LC";}
	else if($type == "Lote"){$prefix =  "LT";}
	else if($type == "Oficina"){$prefix =  "OF";}
	else if($type == "Temperadero"){$prefix =  "TE";}
	else if($type == "Consultorio"){$prefix =  "CO";}
	else{$prefix =  "PH";}
        
	$code = $prefix.$counter;

	$addInfo = new sql_query();
	
	if($rtype == "come")
	{
		$str = "INSERT INTO $table (CODE, PROPCOUNTER, STATUS, OPERATION, TYPE, CITY, ZONE, NOTES, VIDEO, ROMS, MTS, MARK, MODEL, RTYPE, PICS, CNAME, CPHONE, DATE, ENDATE) VALUES ('".$code."','".$propCounter."','".$status."','".$op."','".$type."','".$city."','".$zone."','".$notes."','".$video."','".$rooms."','".$mts."', '".$mark."', '".$model."', '".$rtype."', '".$pics."', '".$cname."', '".$cphone."', '".$cdate."', '".$endDate."')";
	}
	else
	{
		$str = "INSERT INTO $table (CODE, PROPCOUNTER, STATUS, OPERATION, TYPE, CITY, ZONE, PRICE, NOTES, VIDEO, ROMS, MTS, MARK, MODEL, RTYPE, PICS, CNAME, CPHONE, DATE, ENDATE) VALUES ('".$code."','".$propCounter."','".$status."','".$op."','".$type."','".$city."','".$zone."','".$price."','".$notes."','".$video."','".$rooms."','".$mts."', '".$mark."', '".$model."', '".$rtype."', '".$pics."', '".$cname."', '".$cphone."', '".$cdate."', '".$endDate."')";
		
		 $str = "INSERT INTO $table (CODE, PROPCOUNTER, STATUS, OPERATION, TYPE, CITY, ZONE, RTYPE, PRICE, ROMS, MTS, NOTES, VIDEO, PICS, DATE, ENDATE, CNAME, CPHONE) VALUES ('".$code."','".$propCounter."','".$status."','".$op."','".$type."','".$city."','".$zone."','".$rtype."','".$price."','".$rooms."','".$mts."','".$notes."','".$video."','".$pics."','".$cdate."','".$endDate."','".$cname."','".$cphone."')";
		
		$str = "INSERT INTO props (CODE) VALUES ('".$code."')";
		$code = "lalal";
	}
	
	
	$save = $addInfo->query($str);
	
	mkdir('../images/'.$code, 0777, true);
	
	echo $code;
}

function saveNewP()
{
	$table = 'props';
	$commBd = new sql_query();
	$getCounter = $commBd->query("SELECT $table.PROPCOUNTER FROM $table ORDER BY PROPCOUNTER ASC");

	// GET COUNTER
	if (count($getCounter) > 0)
	{
		$counter = (int)($getCounter[count($getCounter)-1]["PROPCOUNTER"])+1;
	}
	else
	{
		$counter = 1;	
	}
	
	$status = $_GET["status"];
	$op = $_GET["op"];
	$type = $_GET["type"];
	$city = $_GET["city"];
	$zone = $_GET["zone"];
	$price = $_GET["price"];
	$rooms = $_GET["rooms"];
	$mts = $_GET["mts"];
	$model = $_GET["model"];
	$mark = $_GET["mark"];
	$notes = $_GET["notes"];
	$video = $_GET["video"];
	$propCounter = $counter;
	$rtype = $_GET["rtype"];
	$pics ="";
	$cname = $_GET["cname"];
	$cphone = $_GET["cphone"];
	$cdate = $_GET["cdate"];
	$endDate = $_GET["endDate"];

	$prefix =  "PUB";
        
	$code = $prefix.$counter;

	$addInfo = new sql_query();
	
	$save = $addInfo->query("INSERT INTO $table (CODE, PROPCOUNTER, STATUS, OPERATION, TYPE, CITY, ZONE, PRICE, NOTES, VIDEO, ROMS, MTS, MARK, MODEL, RTYPE, PICS, CNAME, CPHONE, DATE, ENDATE) VALUES ('".$code."','".$propCounter."','".$status."','".$op."','".$type."','".$city."','".$zone."','".$price."','".$notes."','".$video."','".$rooms."','".$mts."', '".$mark."', '".$model."', '".$rtype."', '".$pics."', '".$cname."', '".$cphone."', '".$cdate."', '".$endDate."')");
	

	mkdir('../images/'.$code, 0777, true);
	
	echo $code;
}

function saveOld()
{
	$table = 'props';

	$code = $_GET["code"];
	$status = $_GET["status"];
	$op = $_GET["op"];
	$type = $_GET["type"];
	$city = $_GET["city"];
	$zone = $_GET["zone"];
	$price = $_GET["price"];
	$rooms = $_GET["rooms"];
	$mts = $_GET["mts"];
	$model = $_GET["model"];
	$mark = $_GET["mark"];
	$notes = $_GET["notes"];
	$video = $_GET["video"];
	$cname = $_GET["cname"];
	$cphone = $_GET["cphone"];
	$rtype = $_GET["rtype"];
	$endDate = $_GET["endDate"];
	$addInfo = new sql_query();
	
	
	if($rtype == "come")
	{

		$str = "UPDATE props SET STATUS = '".$status."', OPERATION = '".$op."', TYPE = '".$type."', CITY = '".$city."', ZONE = '".$zone."', NOTES = '".$notes."', MTS = '".$mts."', VIDEO = '".$video."', ROMS = '".$rooms."', MODEL = '".$model."', MARK = '".$mark."', CNAME = '".$cname."', CPHONE = '".$cphone."', ENDATE = '".$endDate."' WHERE CODE = '".$code."'";
	}
	else
	{
		$str = "UPDATE props SET STATUS = '".$status."', OPERATION = '".$op."', TYPE = '".$type."', CITY = '".$city."', ZONE = '".$zone."', PRICE = '".$price."', NOTES = '".$notes."', MTS = '".$mts."', VIDEO = '".$video."', ROMS = '".$rooms."', MODEL = '".$model."', MARK = '".$mark."', CNAME = '".$cname."', CPHONE = '".$cphone."', ENDATE = '".$endDate."' WHERE CODE = '".$code."'";
		
		$str = "UPDATE props SET STATUS = '".$status."', OPERATION = '".$op."', TYPE = '".$type."', CITY = '".$city."', ZONE = '".$zone."', PRICE = '".$price."', NOTES = '".$notes."', MTS = '".$mts."', VIDEO = '".$video."', ROMS = '".$rooms."', CNAME = '".$cname."', CPHONE = '".$cphone."', ENDATE = '".$endDate."' WHERE CODE = '".$code."'";
	}
	
	
	
	$save = $addInfo->query($str);
	
	echo $code;
}

function openProp()
{
	$code =  $_GET["code"];
	$table = 'props';
	$commBd = new sql_query();
	$prop = $commBd->query("SELECT * FROM $table WHERE CODE='".$code."'");
	
	if (count($prop) > 0)
	{
		echo json_encode($prop[0]);
	}
	else
	{
		echo false;
	}
	
}

function getPropPics()
{
	$code = $_GET["code"];
	$directorio = "../images/".$code."/" ;
	$dirFiles = array();
	if ($handle = opendir($directorio)) {
	    while (false !== ($file = readdir($handle)))
	    {

			$crap   = array(".jpg", ".jpeg", ".JPG", ".JPEG", ".png", ".PNG", ".gif", ".GIF", ".bmp", ".BMP", "_", "-");    
			$newstring = str_replace($crap, " ", $file );   

			if ($file != "." && $file != ".." && $file != "index.php" && $file != "Thumbnails") 
			{
				$dirFiles[] = $file;
			}
	    }
	    closedir($handle);
	}
	sort($dirFiles);
	
	$table = 'props';
	$commBd = new sql_query();
        
        if(count($dirFiles) > 0)
        {
                $imageIcon = $dirFiles[0];
                $setIcon = $commBd->query("UPDATE $table SET $table.PICS = '".$imageIcon."' WHERE $table.CODE = '".$code."'");
        }
        else
        {
                $dirFiles = array();
        }

	echo json_encode($dirFiles);
}

function deleteImage()
{
	$code = $_GET["code"];
	$fileCode = $_GET["file"];
	
	$file = "../images/".$code."/".$fileCode;
	
	unlink($file);
        
        $directorio = "../images/".$code."/" ;
	$dirFiles = array();
	if ($handle = opendir($directorio)) {
	    while (false !== ($file = readdir($handle)))
	    {

			$crap   = array(".jpg", ".jpeg", ".JPG", ".JPEG", ".png", ".PNG", ".gif", ".GIF", ".bmp", ".BMP", "_", "-");    
			$newstring = str_replace($crap, " ", $file );   

			if ($file != "." && $file != ".." && $file != "index.php" && $file != "Thumbnails") 
			{
				$dirFiles[] = $file;
			}
	    }
	    closedir($handle);
	}
        
        $commBd = new sql_query();
        
        if(count($dirFiles) == 0)
        {
                $setIcon = $commBd->query("UPDATE props SET PICS = '' WHERE CODE = '".$code."'");
        }
        
	
	echo true;
}

function deleteProp()
{
	$list = json_decode($_GET["list"]);
        
        foreach($list as $code)
        {
                // $code = $_GET["code"];

                $table = 'props';
                $commBd = new sql_query();

                $request_del = $commBd->query("DELETE FROM $table WHERE $table.code = '".$code."'");
                
                $path = "../images/".$code."/";
                
                 Delete($path);
        } 
        echo $list;
}

function Delete($path)
{
	if (is_dir($path) === true)
	{
                $files = array_diff(scandir($path), array('.', '..'));

                foreach ($files as $file)
                {
                  Delete(realpath($path) . '/' . $file);
                }

                return rmdir($path);
	}

	else if (is_file($path) === true)
	{
                return unlink($path);
	}

	return false;
}

function getPropListFilter()
{
	$table = 'props';
	$get_info = new sql_query();
	
        $rtype = $_GET["rtype"];
	$op = $_GET["op"];
	$type = $_GET["type"];
	$city = $_GET["city"];
	$zone = $_GET["zone"];
	$model = $_GET["model"];
	$mark = $_GET["mark"];
	$price1 = intval($_GET["price1"]);
	$price2 = intval($_GET["price2"]);
	
	$where = "WHERE  RTYPE = '". $rtype."' AND STATUS = 1 ";

	if($type != "")
	{
		$where .= "AND  TYPE = '$type'";
	}
	if($op != "")
	{
		$where .= "AND  OPERATION = '$op'";
	}
	if($city != "")
	{
		$where .= "AND  CITY = '$city'";
	}
	if($zone != "")
	{
		$where .= "AND  ZONE LIKE '%$zone%'";
	}
        if($model != "")
	{
		$where .= "AND  MODEL LIKE '%$model%'";
	}
        if($mark != "")
	{
		$where .= "AND  MARK = '$mark'";
	}
	if($price1 != "")
	{
		$where .= "AND  PRICE >= '$price1'";
	}
	if($price2 != "")
	{
		$where .= "AND  PRICE <= '$price2'";
	}
	
	$now = new DateTime();
	$now = $now->format('Y-m-d H:i:s');
	
	$cuery = "UPDATE props SET STATUS = '0' WHERE ENDATE < '".$now."'";
	$data = $get_info->query($cuery);
	
	$cuery = "UPDATE props SET STATUS = '1' WHERE ENDATE > '".$now."'";
	$data = $get_info->query($cuery);
	
	$cuery = "SELECT * FROM $table $where ORDER BY CODE ASC";
	$data = $get_info->query($cuery);

	echo json_encode($data);
}

function getIniData()
{
	$table = 'props';
	$get_info = new sql_query();
	$data = array();
	
	$cuery = "SELECT * FROM cities ORDER BY CITY ASC";
	$data["cities"] = $get_info->query($cuery);
	
	$cuery = "SELECT * FROM colors";
	$data["colors"] = $get_info->query($cuery)[0];
	
	echo json_encode($data);
}

function saveZone()
{
	$get_info = new sql_query();
	$zone = $_GET["zone"];
	$data = array();
	
	$cuery = "SELECT CITY FROM cities WHERE CITY = '".$zone."'";
	$check = $get_info->query($cuery);
	
	if(count($check) > 0)
	{
		$data = "exist";
		echo json_encode($data);
	}
	else
	{
		$cuery = "INSERT INTO cities (CITY) VALUES ('".$zone."')";
		$saved = $get_info->query($cuery);
		
	
		$data = "saved";
		echo json_encode($data);
	}
}

function delZone()
{
	$get_info = new sql_query();
	$zone = $_GET["zone"];
	$data = array();
	
	$cuery = "DELETE FROM cities WHERE CITY = '".$zone."'";
	$check = $get_info->query($cuery);
	
	$data = "deleted";
	echo json_encode($data);
	
	
}

function saveColors()
{
	$get_info = new sql_query();
	$cl1 = $_GET["cl1"];
	$cl2 = $_GET["cl2"];
	$cl3 = $_GET["cl3"];
	
	
	$cuery = "UPDATE colors SET CL1 = '".$cl1."', CL2 = '".$cl2."', CL3 = '".$cl3."' WHERE CODE = '0'";
	$check = $get_info->query($cuery);
	
	$data = "colored";
	echo json_encode($check);
	
	
}


function getPropListFilterAdmin()
{
	$table = 'props';
	$get_info = new sql_query();
	
	$cat = $_GET["cat"];
	$state = $_GET["state"];
	$code = $_GET["code"];
	$date = $_GET["date"];
	
	$where = "WHERE  RTYPE = '". $cat."' ";

	if($state != "")
	{
		$where .= "AND  STATUS = '". $state."' ";
	}
	if($code != "")
	{
		$where .= "AND  CODE = '". $code."' ";
	}
	if($date != "")
	{
		$where .= "AND  DATE < '". $date."' ";
	}
	
	$now = new DateTime();
	$now = $now->format('Y-m-d H:i:s');
	
	$cuery = "UPDATE props SET STATUS = '0' WHERE ENDATE < '".$now."'";
	$data = $get_info->query($cuery);
	
	$cuery = "UPDATE props SET STATUS = '1' WHERE ENDATE > '".$now."'";
	$data = $get_info->query($cuery);
	
	$cuery = "SELECT * FROM $table $where ORDER BY CODE ASC";
	$data = $get_info->query($cuery);
        
        // var_dump($data);
	
	echo json_encode($data);
}

function sendQuestion()
{
	// QUITAR RETURN PARA ACTIVAR ENVIO
	// return;
	
	$publiHogar = 'jczmultimedia@gmail.com';
	
	$userName = $_GET["name"];
	$userEmail = $_GET["mail"];
	$userPhone = $_GET["phone"];
	$code = $_GET["code"];
	
	$email_subject = 'Consulta publiHogar de '.$userEmail;
	$email_from = $userEmail;
	$email_message = $userName." con email ".$userEmail." y telefono ".$userPhone." quiere informacion sobre el inmueble ".$code;
		
	$headers = "From: " . $email_from . "\r\n";
	$headers .= "Reply-To: ". $email_from . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
	mail ($publiHogar, $email_subject, $email_message, $headers);
	
	echo "sent";
	
}

function code_create($len) 
{
	$key = '';
	$get_info = new sql_query();
	$pattern = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
	$max = strlen($pattern)-1;
	for($i=0;$i < $len;$i++) $key .= $pattern{mt_rand(0,$max)};
	return $key;
}
function date_difference($fecha_principal, $fecha_secundaria, $obtener = 'HORAS', $redondear = false)
{
   $f0 = strtotime($fecha_principal);
   $f1 = strtotime($fecha_secundaria);

   $resultado = ($f0 - $f1);
   switch ($obtener) {
       default: break;
       case "MINUTOS"   :   $resultado = $resultado / 60;   break;
       case "HORAS"     :   $resultado = $resultado / 60 / 60;   break;
       case "DIAS"      :   $resultado = $resultado / 60 / 60 / 24;   break;
       case "SEMANAS"   :   $resultado = $resultado / 60 / 60 / 24 / 7;   break;
   }
   if($redondear) $resultado = round($resultado);
   return $resultado;
}
?>
