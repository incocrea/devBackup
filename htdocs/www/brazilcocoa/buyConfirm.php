<?php
	
	$answer = json_encode($_POST, true);
	file_put_contents('answer'.'.txt', $answer);

	$result = $_POST["response_message_pol"];
	$reference = explode("-",$_POST["reference_sale"])[0];
	$pid = explode("-",$_POST["reference_sale"])[0];
	$email_buyer = $_POST["email_buyer"];
	$nickname = $_POST["nickname_buyer"];
	$tid = $_POST["transaction_id"];
	$bvalue = $_POST["value"];
	$bdesc = $_POST["description"];
	 
	
	if(strpos($reference, 'BPR') !== false)
	{
		if($result == "APPROVED")
		{
			$db = new sql_query();

			if($pid == "BPR_1"){$duration = "1"; $ut = "1";}
			if($pid == "BPR_2"){$duration = "2"; $ut = "1";}
			if($pid == "BPR_3"){$duration = "3"; $ut = "1";}
			if($pid == "BPR_6"){$duration = "6"; $ut = "1";}
			if($pid == "BPR_12"){$duration = "12"; $ut = "1";}
			if($pid == "BPR_1000"){$duration = "1000"; $ut = "1";}
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			
			// CHECK IF MAIL EXIST, IF NOT CREATE
			
			$udata = $db->query("SELECT users.PRENDATE, users.UCODE, users.NAME FROM users WHERE users.EMAIL = '".$email_buyer."'");
			
			if(count($udata) > 0)
			{
				$actualEndDate = $udata[0]["PRENDATE"];
				$actualUcode = $udata[0]["UCODE"];
				$actualUname = $udata[0]["NAME"];
			}
			else
			{
				
				$code = md5($email_buyer.$now);
				
				$actualEndDate = $now;
				$actualUname = "Mi nombre aquí";
				$actualUcode = $code;

				$COUNTRY = "COLOMBIA";
				$DPTO = "RISARALDA";
				$CITY = "PEREIRA";
				$PASSWD = md5("12345678");
				$TYPE = "1";
				$REGDATE = $now;
				$SEX = "M";
				$BDAY = $now;
				$UTYPE = "C";
				$HP = "0";
				$PHONE = "Mi teléfono aquí";
				$ADDRESS = "Mi dirección aquí";
				$STATUS = "1";
				
				$createUser = $db->query("INSERT INTO users (UCODE, NAME, EMAIL, COUNTRY, DPTO, CITY, PASSWD, TYPE, REGDATE, SEX, BDAY, UTYPE, HP, PHONE, ADDRESS, STATUS) VALUES ('".$actualUcode."','".$actualUname."', '".$email_buyer."', '".$COUNTRY."', '".$DPTO."','".$CITY."','".$PASSWD."','".$TYPE."','".$REGDATE."','".$SEX."','".$BDAY."','".$UTYPE."','".$HP."','".$PHONE."','".$ADDRESS."','".$STATUS."')");
				
				// SEND NOTIFY
				
				$userEmail = $email_buyer;
				$email_subject = "¡Felicidades, ahora eres miembro Premium Brazil Cocoa!";
				$email_from = 'info@brazilcocoa.com';
				$email_message = "Felicitaciones, ahora podrás ingresar y disfrutar de todo el contenido que Mundo Brazil Cocoa tiene para ti, sin límites, gracias por unirte a nuestra privilegiada comunidad.<br><br>Tu nombre de usuario es:  ".$userEmail."<br><br>Tu contraseña es: 12345678<br><br>Te recomendamos cambiarla al ingresar la primera vez y actualizar tus datos de usuario.<br><br><a href='https://brazilcocoa.com/app/' target='_blank'>Haz click aquí para empezar</a>";
				
				$headers = "From: " . $email_from . "\r\n";
				$headers .= "Reply-To: ". $email_from . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				mail ($userEmail, htmlEntities($email_subject), utf8_decode($email_message), $headers);
				
			}
			
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			
			if($actualEndDate < $now)
			{
				$endDate = DateTime::createFromFormat('Y-m-d H:i:s', $now);
			}
			else
			{
				$endDate = DateTime::createFromFormat('Y-m-d H:i:s', $actualEndDate);
			}
			
			$endDate = $endDate->add(new DateInterval('P'.$duration.'M'));
			$endDate = $endDate->format('Y-m-d H:i:s');
			$actualEndDate = $db->query("UPDATE users SET users.PRENDATE = '".$endDate."', users.PREMIUM = '".$ut."' WHERE users.EMAIL = '".$email_buyer."'");
			
			$TCODE = md5($now.$email_buyer);
			$UCODE = $actualUcode;
			$PCODE = $actualUcode;
			$TYPE = "4";
			$DETAIL = "Compra Premium ".$pid." para ".$actualUname;
			$DATE = $now;
			
			$saveSale = $db->query("INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE) VALUES ('".$TCODE."','".$UCODE."', '".$TYPE."', '".$bvalue."', '".$DETAIL."','".$DATE."','".$PCODE."')");
			
		}
		else
		{
			file_put_contents('answer'.'.txt', "pago rechazado");
		}
	}
	if(strpos($reference, 'CRS_') !== false)
	{
		if($result == "APPROVED")
		{
			$db = new sql_query();
			
			$course = explode("_",$reference)[1];
			
			$udata = $db->query("SELECT users.UCODE, users.NAME FROM users WHERE users.EMAIL = '".$email_buyer."'");

			$actualUcode = $udata[0]["UCODE"];
			$actualUname = $udata[0]["NAME"];
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			
			$TCODE = md5($now.$email_buyer);
			$UCODE = $actualUcode;
			$PCODE = $course;
			$TYPE = "4";
			$DETAIL = "Compra curso ".$bdesc." para ".$actualUname;
			$DATE = $now;
			// $bvalue = "0";
			
			$saveSale = $db->query("INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE) VALUES ('".$TCODE."','".$UCODE."', '".$TYPE."', '".$bvalue."', '".$DETAIL."','".$DATE."','".$PCODE."')");
			
		}
		else
		{
			file_put_contents('answer'.'.txt', "pago rechazado");
		}
	}

class sql_query
{
	private $pg;
	function __construct()
	{
		try
		{
			$host = "localhost";
			$db = "bcoins";
			$user = "adminCultivarte";
			$pssw = "harolito2";

			$this->pg = new PDO('mysql:host='.$host.';dbname='.$db.'', $user, $pssw);
			
		}
		catch(PDOException $e)
		{
			echo  "Error!: ".$e->getMessage()."<br/>";	
		}
	}
	
	function beginTransaction()
	{
		$this->pg->beginTransaction();	
	}
	
	function commit()
	{
		$this->pg->commit();	
	}
	
	function rollBack()
	{
		$this->pg->rollBack();	
	}

	function query($string)
	{

		$resp = $this->pg->query($string);
		$error = $this->pg->errorInfo();
		if(empty($error[1]))
		{
			$resp->setFetchMode(PDO::FETCH_ASSOC);
			$querystr = array();
			
			while ($row = $resp->fetch())
			{
				$querystr[] = $row;	
			}
			return $querystr;
		}
		else
		{

			throw new Exception(implode($error," "), 1);
	
		}
	}
}


?>