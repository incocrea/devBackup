<?php

date_default_timezone_set('America/Bogota');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;




require('../fpdf/mc_table.php');
require '../phpmailer/Exception.php';
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';
require('../phpExcel/Classes/PHPExcel.php');
require('../phpqrcode/qrlib.php');


#[AllowDynamicProperties]
class users
{
	

	
	function __construct()
	{
		$this->db = new sql_query();
	}
	function fixNames($info)
	{
		
		return false;
		$dirPath = '../../courses/files/';
		
		$files = scandir($dirPath);
		
		$jpg = array();
		
		for($i=0; $i<count($files);$i++)
		{
			$file = $files[$i];
			if(strpos($file, ".jpg") !== false)
			{
				$ini = explode(".jpg", $file)[0];
				$add = " M 1.jpg";
				$newName = $ini.$add;
				rename($dirPath.$file,$dirPath.$newName);
				array_push($jpg, $newName);
			}
		}
		$ans = $jpg;
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function langGet($info)
	{
		$answer = [];
		$language = $info["lang"];
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		$answer["lang"] = $langFile[$language];

		
		$str = "SELECT CODE, NAME, IDTYPE, IDNUMBER, TYPE FROM users ORDER BY NAME ASC";
		$users = $this->db->query($str);
		$answer["users"] = $users;
		
		$str = "SELECT * FROM courses ORDER BY CODE ASC";
		$courses = $this->db->query($str);
		$answer["courses"] = $courses;
		
		$str = "SELECT * FROM bundles ORDER BY CODE ASC";
		$courses = $this->db->query($str);
		$answer["bundles"] = $courses;
		
		$str = "SELECT * FROM cats ORDER BY CODE ASC";
		$courses = $this->db->query($str);
		$answer["cats"] = $courses;
		
		
		$resp["message"] = $answer;
		$resp["status"] = true; 
		return $resp;
	}
	function login($info)
	{
		
		$PASS = md5($info["pssw"]);
		
		$str = "SELECT * FROM users WHERE users.EMAIL = '".$info["user"]."' AND users.PASSWD = '".$PASS."' AND TYPE = '".$info["type"]."'";

		$query = $this->db->query($str);	

		if(count($query) > 0)
		{
			if($query[0]["STATUS"] == "0")
			{
				$resp["message"] = "Disabled";
				$resp["status"] = true;
				return $resp;
			}

			if($info["user"] == "hvelez@incocrea.com"){$query[0]["logued"] = "2";}
			else{$query[0]["logued"] = "1";}
			
			
			// GET USER PLANS ACCORDING TO TYPE
			$now = new DateTime();
			$now = $now->format('Y-m-d');
			
			if($query[0]["TYPE"] != "2" and $query[0]["TYPE"] != "4")
			{
				$str = "SELECT UNAME, COURSES, STARTDATE, ENDATE FROM plans WHERE UCODE = '".$query[0]["CODE"]."' AND STARTDATE <= '".$now."' AND ENDATE >= '".$now."'";
			}
			else
			{
				$str = "SELECT UNAME, COURSES, STARTDATE, ENDATE FROM plans WHERE UCODE = '".$query[0]["COMPANY"]."' AND STARTDATE <= '".$now."' AND ENDATE >= '".$now."'";
			}
			$plans = $this->db->query($str);
			$resp["uplans"] = $plans;
			// GET USER PLANS ACCORDING TO TYPE
			
			
			$resp["message"] = $query[0];
			$resp["status"] = true;
			

		}
		else
		{
			$resp["message"] = "";
			$resp["status"] = false; 
		}
		
		return $resp;
	}
	function rlAud($info)
	{
		$code = $info["c"];
		
		
		$str = "SELECT * FROM users WHERE CODE = '$code'";
		
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			
			if($query[0]["STATUS"] == "0")
			{
				$resp["message"] = "Disabled";
				$resp["status"] = true;
				return $resp;
			}
			
			$mail = $query[0]["EMAIL"];
			
			if($mail == "hvelez@incocrea.com"){$query[0]["logued"] = "2";}
			else{$query[0]["logued"] = "1";}

			
			// GET USER PLANS ACCORDING TO TYPE
			$now = new DateTime();
			$now = $now->format('Y-m-d');
			
			if($query[0]["TYPE"] != "2" and $query[0]["TYPE"] != "4")
			{
				$str = "SELECT UNAME, COURSES, STARTDATE, ENDATE, USERS FROM plans WHERE UCODE = '".$query[0]["CODE"]."' AND STARTDATE <= '".$now."' AND ENDATE >= '".$now."'";
			}
			else
			{
				$str = "SELECT UNAME, COURSES, STARTDATE, ENDATE, USERS FROM plans WHERE UCODE = '".$query[0]["COMPANY"]."' AND STARTDATE <= '".$now."' AND ENDATE >= '".$now."'";
			}
			$plans = $this->db->query($str);
			$resp["uplans"] = $plans;
			// GET USER PLANS ACCORDING TO TYPE
			
			
			$resp["message"] = $query[0];
			$resp["status"] = true;
			return $resp;
		}
		else
		{
			$resp["message"] = $query;
			$resp["status"] = true;
			return $resp;
		}
	}
	function mailExist($info)
	{
		
		$str = "SELECT EMAIL, CODE FROM users WHERE EMAIL = '".$info["mail"]."'";
		$query = $this->db->query($str);

		if(count($query) > 0)
		{
			
			$smail = "info@idgwindtech.com";
			$userEmail = $info["mail"];
			$tmpkey = $query[0]["CODE"];
			$lang = $info["lang"];

			// SEND MESSAGE USERS
			$localInfo = array();
			$localInfo["type"] = "0";
			$localInfo["email"] = $userEmail;
			$localInfo["data"] = $tmpkey;
			$localInfo["lang"] = $lang;
			$send = $this-> notificate($localInfo)["message"];
			// SEND MESSAGE USERS

			$resp["message"] = $send;
			$resp["status"] = true;
		
		}
		else
		{
			$resp["message"] = "notsent";
			$resp["status"] = false;
		}
		return $resp;
	}
	function sendContact($info)
	{
		$message = $info["messageFull"];
		$userEmail = $info["email"];
		
		
		// $ans = $query;
		$lang = "EN";
		
		// SEND MESSAGE CLIENT
		$localInfo = array();
		$localInfo["type"] = "1";
		$localInfo["email"] = $userEmail;
		$localInfo["lang"] = $lang;
		$localInfo["data"] = $message;
		$send = $this-> notificate($localInfo)["message"];
		// SEND MESSAGE CLIENT
		
		$resp["message"] = $send;
		$resp["status"] = true;
		return $resp;
	}
	function notificate($info)
	{
		$type = $info["type"];
		$email = $info["email"];
		$data = $info["data"]; 
		$language = $info["lang"];
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		
		// $destiny = "incocrea@outlook.com";

		//SEND STARTER MAIL ------------
		$from = 'contact@idgwindtech.com';		
		$host = 'mail.idgwindtech.com';
		$pssw = 'Colombia1999@#';

		
		if($type == "0")
		{
			$destiny = $email;
			$headerText = $langFile[$language]["recHeader"];
			$message = $langFile[$language]["recMessage"];
			$recLink = $langFile[$language]["recLink"];
			$vrcContact = $langFile[$language]["vrcContact"];
			$subject = $vrcContact;
			$fromName = $vrcContact;
			$content = "<span style='font-size:14px; font-weight: bold;'>"."<a href='https://idgwindtech.com/app/login.html?tmpkey=".$data."'>".htmlentities($recLink)."</a>"."</span>".
			"<br><br>";
		}
		if($type == "1")
		{
			$destiny = "contact@idgwindtech.com";
			$headerText = "Contact from IDG Website";
			$message = htmlEntities($info["data"]); 
			$subject = $headerText;
			$fromName = $email;
			$content = $info["data"];			
		}
		if($type == "2")
		{
			// COURSE ASSIGNATION
			$destiny = $email;
			$headerText = $langFile[$language]["courseaAssigned"];
			$message = $info["data"]; 
			$others = $info["others"]; 
			$subject = $headerText;
			$fromName = $email;
			$content = $info["data"];			
		}
		if($type == "3")
		{
			// COURSE ASSIGNATION
			$destiny = $email;
			$headerText = $langFile[$language]["newUserSubject"];
			$message = $info["data"]; 
			$others = $info["others"]; 
			$subject = $headerText;
			$fromName = $email;
			$content = $info["data"];			
		}
		if($type == "4")
		{
			// COURSE ASSIGNATION
			$destiny = $email;
			$headerText = $langFile[$language]["newUserSubject"];
			$message = $info["data"]; 
			$others = $info["others"]; 
			$subject = $headerText;
			$fromName = $email;
			$content = $info["data"];			
		}
		
		
		if($type != "0")
		{
			$content = htmlEntities($content);
			$content = html_entity_decode($content);
		}
		
		
		
		
		$mail = new PHPMailer();
		
		//Server settings
		$mail->SMTPDebug = 2;  
		$mail->CharSet = 'UTF-8';
		$mail->Host = $host;
		$mail->Username = $from;
		$mail->Password = $pssw;
		$mail->Port = 465;  
		$mail->SMTPSecure = 'tls';   
		$mail->SMTPAuth = true;    
		$mail->From = $from;
		$mail->FromName= $fromName;
		$mail->IsHTML(true);
		$mail->Subject = $subject;
		$mail->AddReplyTo($from, 'Contacto IDG');
		$mail->AddAddress($destiny);
		
		if($type == "2" or $type == "3")
		{
			// ADD BCC MAILS
			if(count($others) > 0){for($c=0; $c<count($others);$c++){$address = $others[$c];$mail->addBCC($address);}}
		}
		
		$br = "<br><br>";
		$logo = "<div style='text-align: center;'><img style='max-width: 300px;' src='https://idgwindtech.com/app/img/logo.png'/><div>".$br;
		$header = "<div style='text-align: center;'><b>".$headerText."</b></div>".$br;

		$body = $logo.$header.$message;

		
		$mail->Body = $body; 
		// Envía el correo.
		
		// DISABLE FOR TESTING ENABLE FOR PRODUCTIVE
		$exito = $mail->Send(); 
		// DISABLE FOR TESTING ENABLE FOR PRODUCTIVE
		
		// ENABLE FOR TESTING ENABLE FOR PRODUCTIVE
		// $exito = true;
		// ENABLE FOR TESTING ENABLE FOR PRODUCTIVE
		
		if($exito){$ans = "enviado";}else{$ans = $mail->ErrorInfo;} 
		
		//SET CLIENT STATE

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function checkCert($info)
	{
		$UCODE = $info["UCODE"];
		$COURSE = $info["COURSE"];
		$LANG = $info["LANG"];
		
		$str = "SELECT * FROM trials WHERE UCODE = '".$UCODE."' AND COURSE = '".$COURSE."' ORDER BY PRESENTED DESC";
		$tries = $this->db->query($str);
		
		if(count($tries) == 0)
		{
			$resp["message"] = "fakeCert";
			$resp["status"] = true;
			return $resp;
		}
		
		
		$str = "SELECT NAME FROM users WHERE CODE = '".$UCODE."'";
		$user = $this->db->query($str)[0]["NAME"];
		
		$str = "SELECT CNAME_".$LANG." FROM courses WHERE CODE = '".$COURSE."'";
		$course = $this->db->query($str)[0]["CNAME_".$LANG];
		
		
		if(count($tries) > 0)
		{
			$lastDate = $tries[0]["PRESENTED"];
			
			
			
			$str = "SELECT CERFT_LIFE FROM courses WHERE CODE = '".$COURSE."'";
			$courseLife = $this->db->query($str)[0]["CERFT_LIFE"];
			
			$now = time();
			$your_date = strtotime($lastDate);
			$daysPassed = ($now - $your_date) / (60 * 60 * 24);
			
			
			if($courseLife < $daysPassed)
			{
				$resp["user"] = $user;
				$resp["course"] = $course;
				$resp["message"] = "expired";
				$resp["status"] = true;
				return $resp;
			}
			else
			{
				$resp["user"] = $user;
				$resp["course"] = $course;
				$resp["message"] = "active";
				$resp["status"] = true;
				return $resp;
			}
		
			
		}
		
		
	}
	function getCert($info)
	{
		$UCODE = $info["UCODE"];
		$COURSE = $info["COURSE"];
		$LANG = $info["LANG"];
		$LIMIT = $info["LIMIT"];
		
		// CHECK USER PASSED COURSE ----
		$localInfo = array();
		$localInfo["UCODE"] = $UCODE;
		$localInfo["COURSE"] = $COURSE;
		$check = $this-> isPassedCourse($localInfo)["message"];
		$passed = $check["BOOLEAN"];
		$lastDate = $check["DATE"];
		$detail = $check["DETAIL"];
		// CHECK USER PASSED COURSE ----

		
		if($passed == "0")
		{
			$resp["message"] = "failed";
			$resp["status"] = true;
			return $resp;
		}
		
		$str = "SELECT CERFT_LIFE FROM courses WHERE CODE = '".$COURSE."'";
		$courseLife = $this->db->query($str)[0]["CERFT_LIFE"];
			
		$now = time();
		$your_date = strtotime($lastDate);
		$daysPassed = ($now - $your_date) / (60 * 60 * 24);
		
		if($courseLife < $daysPassed)
		{
			$resp["message"] = "expired";
			$resp["status"] = true;
			// return $resp;
		}
		
		

		// CHECK LAST TRY RESULT AND DATE, IF OK GENERATE
		
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		$index = $langFile[$LANG];
				
		$str = "SELECT NAME FROM users WHERE CODE = '".$UCODE."'";
		$name = $this->db->query($str)[0]["NAME"];
		$name = $this->utf8_new_encode($name);
				
		$str = "SELECT CNAME_$LANG FROM courses WHERE CODE = '".$COURSE."'";
		$cname = $this->db->query($str)[0]["CNAME_".$LANG];
		
		$cname = $this->utf8_new_encode($cname);
		$cname = html_entity_decode($cname);
		
		$limit = strlen($cname);
		
		
		
		if(substr($cname,-1) == "?"){$cname = substr($cname,0,$limit-1);}
		
		// FILE START
		$pdf = new PDF_MC_Table('L', 'mm', 'Letter');
		$pdf->AddPage('L', 'Letter');
		
		$pdf->Image('../../certs/certBase_'.$LANG.'.jpg',0,0,280,0,'','');
		$pdf->SetFont('Arial','B', 12);
		$pdf->SetFillColor(102,102,102);
		
		$pdf->Ln(65);
		$pdf->SetFont('Arial','I', 14);
		$text1 = $this->utf8_new_encode($index["cert01"]);
		$pdf->SetTextColor(194,8,8);
		$pdf->Cell(260,15,$text1,0,1,'C',false);

		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','B', 22);
		$pdf->Cell(260,15,$cname,0,1,'C',false);
		
		$pdf->Ln(10);
		
		$text2 = $this->utf8_new_encode($index["cert02"]);
		$pdf->SetTextColor(194,8,8);
		$pdf->SetFont('Arial','I', 14);
		$pdf->Cell(260,15,$text2,0,1,'C',false);
		
		$pdf->SetTextColor(0,0,0);
		$pdf->Ln(0);
		$pdf->SetFont('Arial','B', 30);
		$pdf->Cell(260,15,html_entity_decode($name),0,1,'C',false);
		
		$pdf->Ln(10);
		$pdf->Ln(10);
		$pdf->Ln(10);
		$pdf->Ln(5);
		
		$now = new DateTime();
		$now = $now->format('Y-m-d');
		
		$pdf->SetFont('Arial','B', 10);
		$pdf->Cell(150,15,$now,0,1,'C',false);
		
		// SET CERTIFICATE LIFETIME LINE HERE????
		
		$host = "https://idgwindtech.com/app/courseCheck.html?";
		$ucode = $UCODE;
		$course = $COURSE;
		$lang = $LANG;
		
		
		
		// GENERATE QR TO URL
		$url = $host."user=".$ucode."&course=".$course."&lang=".$lang;
		$url = preg_match("#^https?\:\/\/#", $url) ? $url : "http://{$url}";
		
		$this->QRCODE($url);
		$pdf->Image('test.png',5,160,45,0,'','');

		// ------------------------------------------------------------
		// ------------------------------------------------------------
		// ------------------------------------------------------------

		// createFile
		$pdf->Output('../../certs/'.$UCODE.'.pdf','F');
		
		// $ans = $query;
		$ans = $UCODE;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getCoursesByCompany($info)
	{
		$COMPANY = $info["COMPANY"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d');
				
		$str = "SELECT UNAME, COURSES, STARTDATE, ENDATE FROM plans WHERE UCODE = '".$COMPANY."' AND STARTDATE <= '".$now."' AND ENDATE >= '".$now."'";
		$query = $this->db->query($str);	
		
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	}
	function getBundlesByCompany($info)
	{
		$COMPANY = $info["COMPANY"];
				
		$str = "SELECT * FROM bundles WHERE COMPANY = '".$COMPANY."'";
		$query = $this->db->query($str);	
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	}
	function setUserAllowed($info)
	{
		$COURSES = $info["COURSES"];
		$ASSIGNED = $info["ASSIGNED"];
		$ASSIGNED_LIMIT = $info["ASSIGNED_LIMIT"];
		$CODES = $info["CODE"];
		$LANG = $info["LANG"];
		
		$mainMail = array();
		$otherMails =  array();
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		
		for($i=0; $i<count($CODES);$i++)
		{
			$CD = $CODES[$i];
			
			$str = "UPDATE users SET ALLOWED = '".$COURSES."', ASSIGNED = '".$ASSIGNED."', ASSIGNED_LIMIT = '".$ASSIGNED_LIMIT."' WHERE CODE ='".$CD."'";
			$query = $this->db->query($str);
			
			if($i==0)
			{
				$str = "SELECT EMAIL FROM users WHERE CODE = '".$CD."'";
				$mainMail = $this->db->query($str)[0]["EMAIL"];
			}
			else
			{
				$str = "SELECT EMAIL FROM users WHERE CODE = '".$CD."'";
				$mail = $this->db->query($str)[0]["EMAIL"];
				array_push($otherMails, $mail);
			}
		}
		
		
		// IF COURSES ASSIGNATED SEND MAIL OR DO NOTHING
		$ccodes = json_decode($COURSES, true);
		if(count($ccodes)>0)
		{
			$block = $langFile[$LANG ]["yourCourses"]."<br><br>";
			$coursesList = "";
			
			for($i=0; $i<count($ccodes);$i++)
			{
				$ccode = $ccodes[$i];
				$str = "SELECT CNAME_".$LANG." FROM courses WHERE CODE = '".$ccode."'";
				$query = $this->db->query($str);
				if(count($query) > 0){$cname = $query[0]["CNAME_".$LANG];}
				else{$cname = "-";}
				$coursesList .= " * ".$cname."<br>";
			}
			$block .= $coursesList;
			$block .= $langFile[$LANG ]["mustFinishBefore"]."<br>";
			$coursesNlimit = $block.$ASSIGNED_LIMIT;
			
			// SEND MESSAGE USERS
			$localInfo = array();
			$localInfo["type"] = "2";
			$localInfo["email"] = $mainMail;
			$localInfo["others"] = $otherMails;
			$localInfo["data"] = $coursesNlimit;
			$localInfo["lang"] = $LANG;
			$send = $this-> notificate($localInfo)["message"];
			// SEND MESSAGE USERS
			
			$resp["message"] = $send;
			$resp["status"] = true;
			return $resp;
		}
		else
		{
			$resp["message"] = "No mail needed";
			$resp["status"] = true;
			return $resp;
		}

	}
	function setUserBundles($info)
	{
		$COURSES_BUNDLE = $info["COURSES_BUNDLE"];
		$CODES = $info["CODE"];
		$LANG = $info["LANG"];
		
		$mainMail = array();
		$otherMails =  array();
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		
		
		$allowCourses = array();
		
		for($i=0; $i<count($CODES);$i++)
		{
			
			$CD = $CODES[$i];
			
			$str = "SELECT * FROM bundles ORDER BY CODE DESC";
			$masterBundles = $this->db->query($str);
			
			$ASSIGNED = $info["ASSIGNED"];
			$ASSIGNED_LIMIT = $info["ASSIGNED_LIMIT"];
			
			
			$str = "UPDATE users SET BUNDLES = '".$COURSES_BUNDLE."', ASSIGNED = '".$ASSIGNED."', ASSIGNED_LIMIT = '".$ASSIGNED_LIMIT."' WHERE CODE ='".$CD."'";
			$query = $this->db->query($str);
			$BUNDLED = json_decode($COURSES_BUNDLE, true);
			
			
			if($i==0)
			{
				$str = "SELECT EMAIL FROM users WHERE CODE = '".$CD."'";
				$mainMail = $this->db->query($str)[0]["EMAIL"];
			}
			else
			{
				$str = "SELECT EMAIL FROM users WHERE CODE = '".$CD."'";
				$mail = $this->db->query($str)[0]["EMAIL"];
				array_push($otherMails, $mail);
			}
			
			
			for($j=0; $j<count($BUNDLED);$j++)
			{
				$bcode = $BUNDLED[$j];
				for($m=0; $m<count($masterBundles);$m++)
				{
					$mbcode = $masterBundles[$m]["CODE"];
					if($mbcode == $bcode)
					{
						$bundle = $masterBundles[$m];
						
						if($bundle["COURSES"] != null and $bundle["COURSES"] != "")
						{$courses = json_decode($bundle["COURSES"], true);}
						else
						{$courses = array();}
					
						for($c=0; $c<count($courses);$c++)
						{
							$ccode = $courses[$c];
							if(!in_array($ccode, $allowCourses)){array_push($allowCourses, $ccode);}
						}
					}
				}
			}
			
			$newAllow = json_encode($allowCourses, true);
			$str = "UPDATE users SET ALLOWED = '".$newAllow."' WHERE CODE ='".$CD."'";
			$query = $this->db->query($str);
		}
		
		// IF COURSES ASSIGNATED SEND MAIL OR DO NOTHING
		$ccodes = $allowCourses;
		if(count($ccodes)>0)
		{
			$block = $langFile[$LANG ]["yourCourses"]."<br><br>";
			$coursesList = "";
			
			for($i=0; $i<count($ccodes);$i++)
			{
				$ccode = $ccodes[$i];
				$str = "SELECT CNAME_".$LANG." FROM courses WHERE CODE = '".$ccode."'";
				$query = $this->db->query($str);
				if(count($query) > 0){$cname = $query[0]["CNAME_".$LANG];}
				else{$cname = "-";}
				$coursesList .= " * ".$cname."<br>";
			}
			$block .= $coursesList;
			$block .= "<br>".$langFile[$LANG ]["mustFinishBefore"]."<br>";
			$coursesNlimit = $block.$ASSIGNED_LIMIT;
			
			// SEND MESSAGE USERS
			$localInfo = array();
			$localInfo["type"] = "2";
			$localInfo["email"] = $mainMail;
			$localInfo["others"] = $otherMails;
			$localInfo["data"] = $coursesNlimit;
			$localInfo["lang"] = $LANG;
			$send = $this-> notificate($localInfo)["message"];
			// SEND MESSAGE USERS
			
			$resp["message"] = $send;
			$resp["status"] = true;
			return $resp;
		}
		else
		{
			$resp["message"] = "No mail needed";
			$resp["status"] = true;
			return $resp;
		}

		
		// $ans = $query;
		$ans = $allowCourses;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	// GET FROM IDG2
	function getIdgCerts($info)
	{
		$CODE = $info["uId"];
		
		// $ans = "LOL GOT THERE";
		
		// GET USER CODE BY ID
		
		$str = "SELECT CODE FROM users WHERE IDNUMBER = '$CODE'";
		$query = $this->db->query($str);
		
		if(count($query)>0)
		{
			$CODE = $query[0]["CODE"]; 
			
			$str = "SELECT COURSE, PRESENTED, SCORE FROM trials WHERE UCODE = '".$CODE."' AND SCORE >= 60 ORDER BY PRESENTED DESC";
			$query = $this->db->query($str);
			
			
			
			for($i=0; $i<count($query);$i++)
			{
				$COURSE = $query[$i]["COURSE"]; 
				$str = "SELECT CNAME_ES, CNAME_EN, CNAME_PT, CERFT_LIFE FROM courses WHERE CODE = '".$COURSE."'";
				$names = $this->db->query($str);
				$query[$i]["CNAME"] = $names[0];
				$query[$i]["UCODE"] = $CODE;
			}
			
			
			$ans = $query ;
			
			
			
			
		}
		else
		{
			$ans = array();
		}
		

		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// GET LISTS
	function listGet($info)
	{
		$type = $info["type"];
		$utype = $info["utype"];
		$ucode = $info["ucode"];
		
		
		if($type == "courses" or $type == "courses_client")
		{
			$filter = $info["filter"];
			
			$where = "WHERE  CODE != '' ";
			
			if($filter != ""){$where .= 
				"AND (CODE LIKE '%$filter%'
				OR CNAME_ES LIKE '%$filter%'
				OR CNAME_EN LIKE '%$filter%'
				OR CNAME_PT LIKE '%$filter%'
				OR DESC_ES LIKE '%$filter%'
				OR DESC_EN LIKE '%$filter%'
				OR DESC_PT LIKE '%$filter%')
				";} 
			
			$str = "SELECT * FROM courses $where ORDER BY CAT DESC, CODE DESC";
			$query = $this->db->query($str);
			$result = $query;
			
			
			if($utype == "2")
			{
				$str = "SELECT CODE FROM courses ORDER BY CODE DESC";
				$query = $this->db->query($str);
				$masterCourses = $query;
				
				$str = "SELECT ALLOWED, ASSIGNED_LIMIT FROM users WHERE CODE =  '".$ucode ."'";
				$query = $this->db->query($str);
				$udata = $query[0];
				
				if($udata["ALLOWED"] != null and $udata["ALLOWED"] != "")
				{$allowed = json_decode($udata["ALLOWED"], true);}
				else{$allowed = array();}
				
				$pending = array();
				
				for($a = 0; $a<count($allowed);$a++)
				{
					$COURSE = $allowed[$a];
					$UCODE = $ucode;
					
					// CHECK USER PASSED COURSE ----
					$localInfo = array();
					$localInfo["UCODE"] = $UCODE;
					$localInfo["COURSE"] = $COURSE;
					$check = $this-> isPassedCourse($localInfo)["message"];
					$passed = $check["BOOLEAN"];
					$lastDate = $check["DATE"];
					$detail = $check["DETAIL"];
					// CHECK USER PASSED COURSE ----
					
					if(!$passed){array_push($pending, $COURSE);}

				}
				
				$resp["progress_allowed"] = $allowed;
				$resp["progress_pending"] = $pending;
			}
			
			
		}
		
		if($type == "tests")
		{
			$filter = $info["filter"];
			
			$where = "WHERE CODE != '' ";
			
			if($filter != ""){$where .= "AND TESTNAME LIKE '%$filter%'";} 
			
			$str = "SELECT *  FROM tests $where ORDER BY TESTNAME DESC";
			$query = $this->db->query($str);
			$result = $query;
			
		}
		
		if($type == "testPicker")
		{
			$filter = $info["filter"];
			
			$where = "WHERE CODE != '' ";
			
			if($filter != ""){$where .= "AND TESTNAME LIKE '%$filter%'";} 
			
			$str = "SELECT *  FROM tests $where ORDER BY TESTNAME DESC";
			$query = $this->db->query($str);
			$result = $query;
			
		}
		
		if($type == "testPickerQ")
		{
			$filter = $info["filter"];
			
			$where = "WHERE CODE != '' ";
			
			if($filter != ""){$where .= "AND TESTNAME LIKE '%$filter%'";} 
			
			$str = "SELECT *  FROM tests $where ORDER BY TESTNAME DESC";
			$query = $this->db->query($str);
			$result = $query;
			
		}
		
		if($type == "questions")
		{
			$filter = $info["filter"];
			
			$where = "WHERE  CODE != '' ";
			
			if($filter != ""){$where .= 
				"AND (
				QUESTION_ES LIKE '%$filter%'
				OR QUESTION_EN LIKE '%$filter%'
				OR QUESTION_PT LIKE '%$filter%'
				OR TEST LIKE '%$filter%'
				)
				";} 
			
			$str = "SELECT *  FROM questions $where ORDER BY TEST ASC LIMIT 50";
			$query = $this->db->query($str);
			$result = $query;
			
		}
		
		if($type == "users")
		{
			$filter = $info["filter"];
			$status = $info["status"];
			$where = "WHERE STATUS = '$status' ";
			
			if($filter != ""){$where .= "AND (NAME LIKE '%$filter%' OR IDNUMBER LIKE '%$filter%') " ;} 
			
			if($utype == "1")
			{
				$str = "SELECT * FROM users $where AND COMPANY = '".$ucode."' ORDER BY COMPANY, TYPE DESC, NAME ASC";
			}
			else if($utype == "4")
			{
				$company = $info["company"];
				$str = "SELECT * FROM users $where AND COMPANY = '".$company."' AND TYPE != '4' ORDER BY COMPANY, NAME ASC";
			}
			else
			{
				$str = "SELECT * FROM users $where ORDER BY COMPANY, NAME ASC";
			}
			
			$query = $this->db->query($str);
			
			// FILTER THIS TRIALS ONLY COURSE PASSED STAY
			
			for($i=0; $i<count($query);$i++)
			{
				$CODE = $query[$i]["CODE"]; 
				
				$str = "SELECT COURSE FROM trials WHERE UCODE = '".$CODE."' AND SCORE >= 60 ORDER BY PRESENTED DESC";
				$trials = $this->db->query($str);

				$trueTrials = array();
				
				for($t=0; $t<count($trials);$t++)
				{
					$trl = $trials[$t];
					$COURSE = $trl["COURSE"];
					$UCODE = $CODE;
					
					// CHECK USER PASSED COURSE ----
					$localInfo = array();
					$localInfo["UCODE"] = $UCODE;
					$localInfo["COURSE"] = $COURSE;
					$check = $this-> isPassedCourse($localInfo)["message"];
					$lastDate = $check["DATE"];
					$detail = $check["DETAIL"];
					
					$passed = $check["BOOLEAN"];
					
					
					if($passed == true)
					{
						array_push($trueTrials, $trl);
					}
				}
				
				$query[$i]["TRIALS"] = $trueTrials;
			}
			
			

			$result = $query;
			
		}
		
		if($type == "plans")
		{
			$filter = $info["filter"];
			
			$where = "WHERE CODE != '' ";
			
			if($filter != ""){$where .= "AND UIDNUMBER LIKE '%$filter%' OR COURSES LIKE '%$filter%'";} 
			
			$str = "SELECT *  FROM plans $where ORDER BY UNAME ASC";
			$query = $this->db->query($str);
			$result = $query;
			
		}
		
		if($type == "bundles")
		{
			$filter = $info["filter"];
			$COMPANY = $info["COMPANY"];
			
			$where = "WHERE CODE != '' ";
			
			if($filter != ""){$where .= "AND NAME LIKE '%$filter%'";} 
			
			$str = "SELECT *  FROM bundles $where AND COMPANY = '$COMPANY' ORDER BY NAME ASC";
			$query = $this->db->query($str);
			$result = $query;
			
		}
		
		if($type == "slides")
		{
			$filter = $info["filter"];
			
			$where = "WHERE CODE != '' ";
			
			if($filter != ""){$where .= "AND COURSE = '$filter'";} 
			
			$str = "SELECT *  FROM slides $where ORDER BY LANG ASC, MODU ASC, POS ASC";
			$query = $this->db->query($str);
			$result = $query;
			
		}
		
		if($type == "answers")
		{
			$filter = $info["filter"];
			$STARTDATE = $info["STARTDATE"];
			$ENDATE = $info["ENDATE"];
			$COMPANY = $info["COMPANY"];
			$USER = strtoupper($info["USER"]);
			$lang = $info["lang"];
			
			$where = "WHERE QCODE != '' ";
			
			if($filter != ""){$where .= "AND RESULT = '$filter'";} 
			if($STARTDATE != "")
			{
				$STARTDATE .=" 00:00:00";
				$where .= "AND DATE >= '$STARTDATE'";
			} 
			if($ENDATE != "")
			{
				$ENDATE .=" 23:59:59";
				$where .= "AND DATE <= '$ENDATE'";
			} 
			
			$str = "SELECT *  FROM answers $where ORDER BY DATE DESC";
			$query = $this->db->query($str);
			
			$afterFilter = array();
			
			for($i=0; $i<count($query);$i++)
			{
				
				$qcode = $query[$i]["QCODE"];
				$ucode = $query[$i]["UCODE"];
				
				$str = "SELECT * FROM questions WHERE CODE = '$qcode' ";
				$qdata = $this->db->query($str)[0];
				
				$testCode = $qdata["TEST"];
				
				$str = "SELECT CNAME_".$lang." FROM courses WHERE CODE = '$testCode' ";
				$cname = $this->db->query($str)[0]["CNAME_".$lang];
				
				$str = "SELECT IDNUMBER, NAME, COMPANY, TYPE FROM users WHERE CODE = '$ucode' ";
				$udata = $this->db->query($str)[0];
				
				$query[$i]["DESC"] = $qdata["QUESTION_".$lang];
				$query[$i]["MODU"] = $qdata["MODU"];
				$query[$i]["COURSE"] = $testCode." - ".$cname;
				$query[$i]["UDATA"] = $udata["IDNUMBER"]." - ".$udata["NAME"];
				$query[$i]["COMPANY"] = $udata["COMPANY"];
				$query[$i]["TYPE"] = $udata["TYPE"];
				
				$fullUser = strtoupper($query[$i]["UDATA"]);
				
				if($USER != ""){if(strpos($fullUser, $USER) !== false){array_push($afterFilter, $query[$i]);}}
				else{array_push($afterFilter, $query[$i]);}
			}
			
			$afterFilter2 = array();
			
			for($i=0; $i<count($afterFilter);$i++)
			{
				$item = $afterFilter[$i];
				
				if($COMPANY != "")
				{
					if($item["TYPE"] == "2" or $item["TYPE"] == "4")
					{if($item["COMPANY"] == $COMPANY){array_push($afterFilter2, $item);}}
				}
				else
				{
					array_push($afterFilter2, $item);
				}
			}

			$result = $afterFilter2;

			
		}
		
		if($type == "docs")
		{
			$filter = $info["filter"];
			$lang = $info["lang"];
			
			$where = "WHERE CODE != '' ";
			
			if($filter != ""){$where .= "AND COURSE = '$filter'";} 
			
			$str = "SELECT * FROM docs $where ORDER BY TYPE ASC";
			$query = $this->db->query($str);
			$result = $query;
			
		}
		
		if($type == "cats")
		{
			$filter = $info["filter"];
			$lang = $info["lang"];
			
			$where = "WHERE CODE != '' ";
			
			if($filter != ""){$where .= 
				"AND (CODE LIKE '%$filter%'
				OR CATNAME_ES LIKE '%$filter%'
				OR CATNAME_EN LIKE '%$filter%'
				OR CATNAME_PT LIKE '%$filter%')
				";} 
			
			$str = "SELECT * FROM cats $where ORDER BY CATNAME_".$lang." ASC";
			$query = $this->db->query($str);
			$result = $query;
			
		}
		
		
		$ans = $result;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function listExport($info)
	{
		$type = $info["type"];
		$utype = $info["utype"];
		$ucode = $info["ucode"];
		
		
		$now = new DateTime();
		$now = $now->format('Y-m-d');
		
		$language = $info["lang"];
		$langFile = parse_ini_file("../../lang/lang.ini", true)[$language];
		
	
		if($type == "users")
		{
			$filter = $info["filter"];
			$status = $info["status"];
			$where = "WHERE STATUS = '$status' ";
			
			if($filter != ""){$where .= "AND (NAME LIKE '%$filter%' OR IDNUMBER LIKE '%$filter%') " ;} 
			
			if($utype == "1")
			{
				$str = "SELECT * FROM users $where AND COMPANY = '".$ucode."' ORDER BY COMPANY, TYPE DESC, NAME ASC";
			}
			else if($utype == "4")
			{
				$company = $info["company"];
				$str = "SELECT * FROM users $where AND COMPANY = '".$company."' AND TYPE != '4' ORDER BY COMPANY, NAME ASC";
			}
			else
			{
				$str = "SELECT * FROM users $where ORDER BY COMPANY, NAME ASC";
			}
			
			$query = $this->db->query($str);
			
			for($i=0; $i<count($query);$i++)
			{
				$CODE = $query[$i]["CODE"]; 
				$str = "SELECT COURSE, PRESENTED, SCORE FROM trials WHERE UCODE = '".$CODE."' AND SCORE >= 60 ORDER BY CODE ASC, PRESENTED DESC";
				$trials = $this->db->query($str);
				
				if(count($trials) > 0)
				{
					
					$trueTrials = array();
				
					for($t=0; $t<count($trials);$t++)
					{
						$trl = $trials[$t];
						$COURSE = $trl["COURSE"];
						$UCODE = $CODE;
						
						// CHECK USER PASSED COURSE ----
						$localInfo = array();
						$localInfo["UCODE"] = $UCODE;
						$localInfo["COURSE"] = $COURSE;
						$check = $this-> isPassedCourse($localInfo)["message"];
						$passed = $check["BOOLEAN"];
						$lastDate = $check["DATE"];
						$detail = $check["DETAIL"];
						// CHECK USER PASSED COURSE ----
						
						if($passed == true)
						{
							array_push($trueTrials, $trl);
						}
					}
					

					
					$query[$i]["TRIALS"] = $trueTrials;
					

					
					
				}
				else
				{
					$query[$i]["TRIALS"] = array();
				}
			}
			
			
			
			
			

			$result = $query;
			
		}
		
		// SHEET CONFIG
		$myExcel = new PHPexcel();
		$myExcel->getProperties()->setCreator("Quoting Tool")->setLastModifiedBy("Quoting Tool") ->setTitle("PHPExcel Document") ->setSubject("PHPExcel Document")->setDescription("Document for PHPExcel, generated using PHP classes.") ->setKeywords("office PHPExcel php")->setCategory("Test result file");
		$allborders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
		$borderR = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
		$borderT = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
		$borderB = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
		$grayBg = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'DCE0E8')));
		$yellowBg = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '009899')));
		$alignCenter = array('alignment' => array('horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$alignRight = array('alignment' => array('horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
		$alignLeft = array('alignment' => array('horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
		$percentage =  array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
		$sheet = $myExcel->getActiveSheet();
		$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		$sheet->getPageMargins()->setTop(0.1);
		$sheet->getPageMargins()->setRight(0.3);
		$sheet->getPageMargins()->setLeft(0.3);
		$sheet->getPageMargins()->setBottom(0.3);
		// SHEET CONFIG END -------------------------
		
		
		// GET ADVANCE FILTER PARAMETER TO APPLY EXPORT FILTER
		// GET ADVANCE FILTER PARAMETER TO APPLY EXPORT FILTER
		// GET ADVANCE FILTER PARAMETER TO APPLY EXPORT FILTER
		
		
		if($type == "users")
		{
			$c = 1;
			
			$completed = $info["completed"];
						
			$sheet->getStyle("A$c:J$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:J$c")->getFont()->setBold(true);
			$sheet->getStyle("A$c:J$c")->applyFromArray($alignCenter);
			$sheet->getStyle("A$c:J$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:J$c")->getAlignment()->setWrapText(true);
			
			$sheet->setCellValue("A$c", $langFile["usersTT0"]);
			$sheet->setCellValue("B$c", $langFile["usersTT1"]);
			$sheet->setCellValue("C$c", $langFile["usersTT4"]);
			$sheet->setCellValue("D$c", $langFile["usersTT7"]);
			$sheet->setCellValue("E$c", $langFile["usersTT5"]);
			$sheet->setCellValue("F$c", $langFile["usersTT8"]);
			$sheet->setCellValue("G$c", $langFile["usersTT9"]);
			$sheet->setCellValue("H$c", $langFile["usersTT11"]);
			$sheet->setCellValue("I$c", $langFile["usersTT10"]);
			$sheet->setCellValue("J$c", $langFile["usersTT12"]);
			
			$str = "SELECT CODE, CNAME_".$language." FROM courses ORDER BY CODE DESC";
			$query = $this->db->query($str);
			$masterCourses = $query;
			
			$str = "SELECT * FROM bundles ORDER BY CODE DESC";
			$query = $this->db->query($str);
			$masterBundles = $query;
			
			$c++;
			

			for($i = 0; $i<count($result);$i++)
			{
				$item = $result[$i];
				$assignedCount = 0;
				$passedCount = 0;
				
				$assignDate = $item["ASSIGNED"];
				
				
				// CHECK FOR COMPLETED 
				
				if($item["ALLOWED"] != null and $item["ALLOWED"] != "")
				{$allowed = json_decode($item["ALLOWED"], true);}
				else{$allowed = array();}

				$assigned = "";
				for($a = 0; $a<count($allowed);$a++)
				{
					$code = $allowed[$a];
					
					for($t = 0; $t<count($masterCourses);$t++)
					{
						$mcode = $masterCourses[$t]["CODE"];
						if($code == $mcode){$assigned .= "*".$masterCourses[$t]["CNAME_".$language]." - ".$assignDate."\n"; break;}
					}
					
					$assignedCount++;
				}
				
				$trials = $item["TRIALS"];
				
				// GET TRIAL CODES TO GET PENDING COURSES
				
				$limitDate = $item["ASSIGNED_LIMIT"];
				
				$passed = array();
				
				
				
				$approved = "";
				$expirations = "";
				$soon_expirations = "";
				
				for($p = 0; $p<count($trials);$p++)
				{
					$code = $trials[$p]["COURSE"];
					$appDate = $trials[$p]["PRESENTED"];
					
					// CHECK IF TAKEN ONTIME
					if($appDate <= $limitDate){$tStatus = $langFile["tStatus1"];}
					else{$tStatus = $langFile["tStatus2"];}

					// AVOID DUPLICITY
					if(!in_array($code, $passed)){array_push($passed, $code);}
					else{continue;}
										
					if (!in_array($code, $allowed)){continue;}
										
					$passedCount++;
					
					for($t = 0; $t<count($masterCourses);$t++)
					{
						$mcode = $masterCourses[$t]["CODE"];
						if($code == $mcode)
						{
							$approved .= "*".$masterCourses[$t]["CNAME_".$language]." -> ".$appDate." - ".$tStatus."\n";
							
							// GET EXPIRE DATE
							
							$str = "SELECT CERFT_LIFE FROM courses WHERE CODE = '".$code."'";
							$lifeDays = $this->db->query($str)[0]["CERFT_LIFE"];
							
							$date = new DateTime($appDate);
							$date->add(new DateInterval('P'.$lifeDays.'D')); // P1D means a period of 1 day
							$Date2 = $date->format('Y-m-d');

							$expirations .= "*".$masterCourses[$t]["CNAME_".$language]." -> ".$Date2."\n";
							
							// GET MISSING DAYS
							
							$today = strtotime(date("Y-m-d"));
							$finalDate = strtotime($Date2); 
							$diff = $today - $finalDate; 
							$daysLeft = round($diff / (60*60*24));
							
							
							// $soon_expirations .= "*".$masterCourses[$t]["CNAME_".$language]." -> ".$daysLeft."\n"; 
							
							if($daysLeft > -30)
							{
								if($daysLeft >= 0)
								{
									$soon_expirations .= "*".$masterCourses[$t]["CNAME_".$language]." -> "."Expired"."\n"; break;
								}
								else
								{
									$soon_expirations .= "*".$masterCourses[$t]["CNAME_".$language]." -> Days to expire: ".$daysLeft."\n"; break;
								}
							}
							
							
							
							
						}
					}
				}
				
				$pending = "";
				
				for($a = 0; $a<count($allowed);$a++)
				{
					$code = $allowed[$a];
					if (!in_array($code, $passed))
					{
						for($t = 0; $t<count($masterCourses);$t++)
						{
							$mcode = $masterCourses[$t]["CODE"];
							
							
							// CHECK IF TAKEN ONTIME
							if($now <= $limitDate){$tStatus = $langFile["tStatus1"];}
							else{$tStatus = $langFile["tStatus2"];}
							
							
							if($code == $mcode){$pending .= "*".$masterCourses[$t]["CNAME_".$language]." - ".$tStatus."\n"; break;}
						}
					}
					
				}
	
				
				$fullfilled = $passedCount."/".$assignedCount;
				
				if($assignedCount == 0)
				{
					$percent = 0;
				}
				else
				{
					$percent = $passedCount/$assignedCount*100;
				}
				
				
				
				if($percent > $completed){continue;}
				
				$sheet->getStyle("D$c:J$c")->getAlignment()->setWrapText(true);

				$sheet->setCellValue("A$c",  $item["NAME"]);
				$sheet->setCellValue("B$c",  $item["IDNUMBER"]);
				$sheet->setCellValue("C$c",  $item["EMAIL"]);
				$sheet->setCellValue("D$c",  $assigned);
				$sheet->setCellValue("E$c",  $approved);
				$sheet->setCellValue("F$c",  $pending);
				$sheet->setCellValue("G$c",  $fullfilled);
				$sheet->setCellValue("H$c",  $item["ASSIGNED_LIMIT"]);
				$sheet->setCellValue("I$c",  $expirations);
				$sheet->setCellValue("J$c",  $soon_expirations);
				

				
				
				// $sheet->setCellValue("H$c",  $percent);
				// $sheet->setCellValue("I$c",  $completed);
				
				
				// $sheet->getStyle("A$c:F$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:J$c")->applyFromArray($allborders);
				$sheet->getStyle("A$c:J$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:J$c")->getFont()->setSize(9);
				
				$c++;
			}
			
			
			
			
			$fname = $langFile["userReport"].$now.".xls";
			$path = "../../excel/".$fname;
			$hasFile = file_exists($path);
			if($hasFile == true){unlink($path);}
			$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
			$objWriter->save($path );
			$fname = htmlEntities(utf8_new_decode($fname));
			$resp["file"] = $fname ;
		}
		
		
		
		
		$ans = $result;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function statusChange($info)
	{
		$CODE = $info["CODE"];
		$STATUS = $info["STATUS"];
		$UTYPE = $info["UTYPE"];
		
		if($UTYPE != "0")
		{
			$CCODE = $info["CCODE"];
			$ULIMIT = $info["ULIMIT"];
		}
		
		if($STATUS == "1")
		{
			
			if($UTYPE != "0")
			{
				$str = "SELECT CODE FROM users WHERE COMPANY = '".$CCODE."' AND STATUS = '1'";
				$guys = $this->db->query($str);
				$employees = count($guys);

				if($employees >= $ULIMIT)
				{
					$resp["message"] = "qtyLimit";
					$resp["status"] = true;
					return $resp;
				}
			}

			$str = "UPDATE users SET STATUS = '".$STATUS."' WHERE CODE ='".$CODE."'";
			$query = $this->db->query($str);
		}
		else
		{
			$str = "UPDATE users SET STATUS = '".$STATUS."' WHERE CODE ='".$CODE."'";
			$query = $this->db->query($str);
		}
		
		
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// SAVE REGS
	function saveReg($info)
	{
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$MODE = $info["MODE"];
		$LANG = $info["LANG"];
		
		if($info["FORM"] == "courses")
		{
			
			$CODE = $info["CODE"];
			$COURSE_LIFE = $info["COURSE_LIFE"];
			$COURSE_PRICE = $info["COURSE_PRICE"];
			$CERFT_LIFE = $info["CERFT_LIFE"];
			$CAT = $info["CAT"];
			$PIC = $info["PIC"];
			$CNAME_ES = $info["CNAME_ES"];
			$CNAME_EN = $info["CNAME_EN"];
			$CNAME_PT = $info["CNAME_PT"];
			$DESC_ES = $info["DESC_ES"];
			$DESC_EN = $info["DESC_EN"];
			$DESC_PT = $info["DESC_PT"];
			$VIDEO_ES = $info["VIDEO_ES"];
			$VIDEO_EN = $info["VIDEO_EN"];
			$VIDEO_PT = $info["VIDEO_PT"];
			$TYPE = $info["TYPE"];
			// $FILE_ES = $info["FILE_ES"];
			// $FILE_EN = $info["FILE_EN"];
			// $FILE_PT = $info["FILE_PT"];
			
			// GET CLIENT CODE
			$str = "SELECT CODE FROM courses WHERE CODE = '".$CODE."'";
			$query = $this->db->query($str);
			
			if(count($query) > 0 and $MODE!= "edit")
			{
				$resp["message"] = "exist";
				$resp["status"] = true;
				return $resp;
			}
			
			if($MODE== "new")
			{
				$str = "INSERT INTO courses (CODE, COURSE_LIFE, COURSE_PRICE, CERFT_LIFE, CNAME_ES, CNAME_EN, CNAME_PT, DESC_ES, DESC_EN, DESC_PT, VIDEO_ES, VIDEO_EN, VIDEO_PT, CAT, TYPE) VALUES ('".$CODE."', '".$COURSE_LIFE."','".$COURSE_PRICE."','".$CERFT_LIFE."','".$CNAME_ES."', '".$CNAME_EN."','".$CNAME_PT."','".$DESC_ES."','".$DESC_EN."','".$DESC_PT."','".$VIDEO_ES."','".$VIDEO_EN."','".$VIDEO_PT."','".$CAT."','".$TYPE."')";
				$query = $this->db->query($str);
			}
			else
			{
				$str = "UPDATE courses SET 
				
				COURSE_LIFE = '".$COURSE_LIFE."',
				COURSE_PRICE = '".$COURSE_PRICE."',
				CERFT_LIFE = '".$CERFT_LIFE."',
				CNAME_ES = '".$CNAME_ES."',
				CNAME_EN = '".$CNAME_EN."',
				CNAME_PT = '".$CNAME_PT."',
				DESC_ES = '".$DESC_ES."',
				DESC_EN = '".$DESC_EN."',
				DESC_PT = '".$DESC_PT."',
				VIDEO_ES = '".$VIDEO_ES."',
				VIDEO_EN = '".$VIDEO_EN."',
				VIDEO_PT = '".$VIDEO_PT."',
				CAT = '".$CAT."',
				TYPE = '".$TYPE."'
				WHERE CODE ='".$CODE."'";
				$query = $this->db->query($str);
			}

			
			// SAVE-UPDATE FILES IF NOT BLANK
			if($PIC != "")
			{file_put_contents('../../courses/pics/'.$CODE.'.jpg', file_get_contents($PIC));}
			// if($FILE_ES != "")
			// {file_put_contents('../../courses/files/'.$CODE.'_ES.pdf', file_get_contents($FILE_ES));}
			// if($FILE_EN != "")
			// {file_put_contents('../../courses/files/'.$CODE.'_EN.pdf', file_get_contents($FILE_EN));}
			// if($FILE_PT != "")
			// {file_put_contents('../../courses/files/'.$CODE.'_PT.pdf', file_get_contents($FILE_PT));}
			
			
			$ans = "done";
		
		}
		
		if($info["FORM"] == "tests")
		{
			
			$TESTNAME = $info["TESTNAME"];
			$CODE = md5($TESTNAME.$now);

			// GET CLIENT CODE
			$str = "SELECT CODE, TESTNAME FROM tests WHERE TESTNAME = '".$TESTNAME."'";
			$query = $this->db->query($str);
			
			if(count($query) > 0)
			{
				if($MODE== "new")
				{
					$resp["message"] = "exist";
					$resp["status"] = true;
					return $resp;
				}
				
				$CODE = $info["EDITCODE"];
				
				if($query[0]["CODE"] != $CODE and $MODE == "edit")
				{
					$resp["message"] = "exist";
					$resp["status"] = true;
					return $resp;
				}
			}
			
			if($MODE== "new")
			{
				$str = "INSERT INTO tests (CODE, TESTNAME) VALUES ('".$CODE."', '".$TESTNAME."')";
				$query = $this->db->query($str);
			}
			else
			{
				$CODE = $info["EDITCODE"];
				
				$str = "UPDATE tests SET TESTNAME = '".$TESTNAME."' WHERE CODE ='".$CODE."'";
				$query = $this->db->query($str);
			}

			$ans = "done";
		
		}
		
		if($info["FORM"] == "cats")
		{
			
			$CATNAME_ES = $info["CATNAME_ES"];
			$CATNAME_EN = $info["CATNAME_EN"];
			$CATNAME_PT = $info["CATNAME_PT"];
			$CODE = md5($CATNAME_ES.$now);

			// GET CLIENT CODE
			$str = "SELECT CODE FROM cats WHERE CATNAME_ES = '".$CATNAME_ES."' OR CATNAME_EN = '".$CATNAME_EN."' OR CATNAME_PT = '".$CATNAME_PT."' ";
			$query = $this->db->query($str);
			
			if(count($query) > 0)
			{
				if($MODE== "new")
				{
					$resp["message"] = "exist";
					$resp["status"] = true;
					return $resp;
				}
				
				$CODE = $info["EDITCODE"];
				
				if($query[0]["CODE"] != $CODE and $MODE == "edit")
				{
					$resp["message"] = "exist";
					$resp["status"] = true;
					return $resp;
				}
			}
			
			if($MODE== "new")
			{
				$str = "INSERT INTO cats (CATNAME_ES, CATNAME_EN, CATNAME_PT, CODE) VALUES ('".$CATNAME_ES."', '".$CATNAME_EN."', '".$CATNAME_PT."', '".$CODE."')";
				$query = $this->db->query($str);
			}
			else
			{
				$CODE = $info["EDITCODE"];
				
				$str = "UPDATE cats SET CATNAME_ES = '".$CATNAME_ES."', CATNAME_EN = '".$CATNAME_EN."', CATNAME_PT = '".$CATNAME_PT."' WHERE CODE ='".$CODE."'";
				$query = $this->db->query($str);
			}

			$ans = "done";
		
		}
		
		if($info["FORM"] == "questions")
		{
			$CODE = md5($info["QUESTION_ES"].$now);
			$QUESTION_ES = $info["QUESTION_ES"];
			$FAKE_1_ES = $info["FAKE_1_ES"];
			$FAKE_2_ES = $info["FAKE_2_ES"];
			$FAKE_3_ES = $info["FAKE_3_ES"];
			$ANS_ES = $info["ANS_ES"];
			$QUESTION_EN = $info["QUESTION_EN"];
			$FAKE_1_EN = addslashes($info["FAKE_1_EN"]);
			$FAKE_2_EN = addslashes($info["FAKE_2_EN"]);
			$FAKE_3_EN = addslashes($info["FAKE_3_EN"]);
			$ANS_EN = addslashes($info["ANS_EN"]);
			$QUESTION_PT = $info["QUESTION_PT"];
			$FAKE_1_PT = $info["FAKE_1_PT"];
			$FAKE_2_PT = $info["FAKE_2_PT"];
			$FAKE_3_PT = $info["FAKE_3_PT"];
			$ANS_PT = $info["ANS_PT"];
			
			if($MODE== "new")
			{
				$str = "INSERT INTO questions (
				CODE,
				QUESTION_ES,
				FAKE_1_ES,
				FAKE_2_ES,
				FAKE_3_ES,
				ANS_ES,
				QUESTION_EN,
				FAKE_1_EN,
				FAKE_2_EN,
				FAKE_3_EN,
				ANS_EN,
				QUESTION_PT,
				FAKE_1_PT,
				FAKE_2_PT,
				FAKE_3_PT,
				ANS_PT
				) VALUES (
				'".$CODE."',
				'".$QUESTION_ES."',
				'".$FAKE_1_ES."',
				'".$FAKE_2_ES."',
				'".$FAKE_3_ES."',
				'".$ANS_ES."',
				'".$QUESTION_EN."',
				'".$FAKE_1_EN."',
				'".$FAKE_2_EN."',
				'".$FAKE_3_EN."',
				'".$ANS_EN."',
				'".$QUESTION_PT."',
				'".$FAKE_1_PT."',
				'".$FAKE_2_PT."',
				'".$FAKE_3_PT."',
				'".$ANS_PT."'
				)";
				$query = $this->db->query($str);
			}
			else
			{
				$CODE = $info["EDITCODE"];
				
				$str = "UPDATE questions SET 
				QUESTION_ES = '".$QUESTION_ES."',
				FAKE_1_ES = '".$FAKE_1_ES."',
				FAKE_2_ES = '".$FAKE_2_ES."',
				FAKE_3_ES = '".$FAKE_3_ES."',
				ANS_ES = '".$ANS_ES."',
				QUESTION_EN = '".$QUESTION_EN."',
				FAKE_1_EN = '".$FAKE_1_EN."',
				FAKE_2_EN = '".$FAKE_2_EN."',
				FAKE_3_EN = '".$FAKE_3_EN."',
				ANS_EN = '".$ANS_EN."',
				QUESTION_PT = '".$QUESTION_PT."',
				FAKE_1_PT = '".$FAKE_1_PT."',
				FAKE_2_PT = '".$FAKE_2_PT."',
				FAKE_3_PT = '".$FAKE_3_PT."',
				ANS_PT = '".$ANS_PT."' 
				WHERE CODE ='".$CODE."'";
				$query = $this->db->query($str);
			}

			$ans = "done";
			
			
			
			
			

			
		}
		
		if($info["FORM"] == "users")
		{
			$NAME = $info["NAME"];
			$CODE = md5($NAME.$now);
			$IDTYPE = $info["IDTYPE"];
			$IDNUMBER = $info["IDNUMBER"];
			$EMAIL = $info["EMAIL"];
			$ADDRESS = $info["ADDRESS"];
			$PHONE = $info["PHONE"];
			$TYPE = $info["TYPE"];
			$TYPE = explode("-", $TYPE)[0];
			$COMPANY = $info["COMPANY"];
			$PASSWD = md5($IDNUMBER);
			$REGDATE = $now;
			
			if(isset($info["ULIMIT"]))
			{
				
				$str = "SELECT CODE FROM users WHERE COMPANY = '".$COMPANY."' AND STATUS = '1'";
				$guys = $this->db->query($str);
				$employees = count($guys);
				
				if($employees >= $info["ULIMIT"])
				{
					$resp["message"] = "qtyLimit";
					$resp["status"] = true;
					return $resp;
				}
				
			}

			

			// GET CLIENT CODE
			$str = "SELECT CODE, EMAIL FROM users WHERE EMAIL = '".$EMAIL."' AND TYPE = '".$TYPE."'";
			$query = $this->db->query($str);
			
			if(count($query) > 0)
			{
				if($MODE== "new")
				{
					$resp["message"] = "exist";
					$resp["status"] = true;
					return $resp;
				}
				
				$CODE = $info["EDITCODE"];
				
				if($query[0]["CODE"] != $CODE and $MODE == "edit")
				{
					$resp["message"] = "exist";
					$resp["status"] = true;
					return $resp;
				}
			}
			
			if($MODE== "new")
			{
				$str = "INSERT INTO users (CODE, NAME, IDTYPE, IDNUMBER, EMAIL, ADDRESS, PHONE, TYPE, COMPANY, PASSWD, REGDATE) VALUES ('".$CODE."', '".$NAME."', '".$IDTYPE."', '".$IDNUMBER."', '".$EMAIL."', '".$ADDRESS."', '".$PHONE."', '".$TYPE."', '".$COMPANY."','".$PASSWD."','".$REGDATE."')";
				$query = $this->db->query($str);
				
				$langFile = parse_ini_file("../../lang/lang.ini", true);
				
				// CREATION INDIVIDUAL
				
				$mainMail = $EMAIL;
				$otherMails = array();
				
				$block = $langFile[$LANG ]["userCreated"]."<br><br>";
				$credentials1 = $langFile[$LANG ]["creds1"]." ";
				$credentials2 = $langFile[$LANG ]["creds2"];
				$block .= $credentials1.$EMAIL.$credentials2.$IDNUMBER;
				
				
				// SEND MESSAGE USERS
				$localInfo = array();
				$localInfo["type"] = "3";
				$localInfo["email"] = $mainMail;
				$localInfo["others"] = $otherMails;
				$localInfo["data"] = $block;
				$localInfo["lang"] = $LANG;
				$send = $this-> notificate($localInfo)["message"];
				// SEND MESSAGE USERS
				
				$resp["message"] = $send;
				$resp["status"] = true;
				return $resp;
				
			}
			else
			{
				$CODE = $info["EDITCODE"];
				
				$str = "UPDATE users SET 
				NAME = '".$NAME."',
				IDTYPE = '".$IDTYPE."',
				IDNUMBER = '".$IDNUMBER."',
				ADDRESS = '".$ADDRESS."',
				PHONE = '".$PHONE."',
				TYPE = '".$TYPE."',
				COMPANY = '".$COMPANY."'
				WHERE CODE ='".$CODE."'";
				$query = $this->db->query($str);
			}

			$ans = "done";
		
		}
		
		if($info["FORM"] == "register")
		{
			$NAME = $info["NAME"];
			$CODE = md5($NAME.$now);
			$IDTYPE = $info["IDTYPE"];
			$IDNUMBER = $info["IDNUMBER"];
			$EMAIL = $info["EMAIL"];
			$ADDRESS = $info["ADDRESS"];
			$PHONE = $info["PHONE"];
			$TYPE = $info["TYPE"];
			$TYPE = explode("-", $TYPE)[0];
			$COMPANY = "";
			$PASSWD = md5($IDNUMBER);
			$REGDATE = $now;

			// GET CLIENT CODE
			$str = "SELECT CODE, EMAIL FROM users WHERE EMAIL = '".$EMAIL."' AND TYPE = '".$TYPE."'";
			$query = $this->db->query($str);
			
			if(count($query) > 0)
			{
				if($MODE== "new")
				{
					$resp["message"] = "exist";
					$resp["status"] = true;
					return $resp;
				}
				
				$CODE = $info["EDITCODE"];
				
				if($query[0]["CODE"] != $CODE and $MODE == "edit")
				{
					$resp["message"] = "exist";
					$resp["status"] = true;
					return $resp;
				}
			}
			

			$str = "INSERT INTO users (CODE, NAME, IDTYPE, IDNUMBER, EMAIL, ADDRESS, PHONE, TYPE, COMPANY, PASSWD, REGDATE) VALUES ('".$CODE."', '".$NAME."', '".$IDTYPE."', '".$IDNUMBER."', '".$EMAIL."', '".$ADDRESS."', '".$PHONE."', '".$TYPE."', '".$COMPANY."','".$PASSWD."','".$REGDATE."')";
			$query = $this->db->query($str);


			$ans = "done";
		
		}
		
		if($info["FORM"] == "plans")
		{

			
			$UNAME = $info["UNAME"];
			// $UNAME = mb_convert_encoding($UNAME, 'UTF-8');
			$UCODE = $info["UCODE"];
			$UTYPE = $info["UTYPE"];
			$UIDNUMBER = $info["UIDNUMBER"];
			$STARTDATE = $info["STARTDATE"];
			$ENDATE = $info["ENDATE"];
			$USERS = $info["USERS"];
			$COURSES = $info["COURSES"];
			$CODE = md5($UNAME.$now);
			
			if($MODE== "new")
			{
				$str = "INSERT INTO plans (
				CODE,
				UNAME,
				UCODE,
				UTYPE,
				UIDNUMBER,
				STARTDATE,
				ENDATE,
				COURSES,
				USERS
				) VALUES (
				'".$CODE."',
				'".$UNAME."',
				'".$UCODE."',
				'".$UTYPE."',
				'".$UIDNUMBER."',
				'".$STARTDATE."',
				'".$ENDATE."',
				'".$COURSES."',
				'".$USERS."'
				)";
				$query = $this->db->query($str);
			}
			else
			{
				$CODE = $info["EDITCODE"];
				
				$str = "UPDATE plans SET 
				UNAME = '".$UNAME."',
				UCODE = '".$UCODE."',
				UTYPE = '".$UTYPE."',
				UIDNUMBER = '".$UIDNUMBER."',
				STARTDATE = '".$STARTDATE."',
				ENDATE = '".$ENDATE."',
				COURSES = '".$COURSES."',
				USERS = '".$USERS."'
				WHERE CODE ='".$CODE."'";
				$query = $this->db->query($str);
			}

			$ans = "done";
		
		}
		
		if($info["FORM"] == "bundles")
		{

			$NAME = $info["NAME"];
			$COURSES = $info["COURSES"];
			$COMPANY = $info["COMPANY"];
			$CODE = md5($NAME.$now);
			
			if($MODE== "new")
			{
				
				$str = "SELECT NAME FROM bundles WHERE NAME = '".$NAME."' AND COMPANY = '".$COMPANY."'";
				$query = $this->db->query($str);
				
				if(count($query) > 0)
				{
					$resp["message"] = "exist";
					$resp["status"] = true;
					return $resp;
				}
				
				
				$str = "INSERT INTO bundles (
				CODE,
				NAME,
				COURSES,
				COMPANY
				) VALUES (
				'".$CODE."',
				'".$NAME."',
				'".$COURSES."',
				'".$COMPANY."'
				)";
				$query = $this->db->query($str);
			}
			else
			{
				$CODE = $info["EDITCODE"];
				
				$str = "SELECT NAME FROM bundles WHERE NAME = '".$NAME."' AND COMPANY = '".$COMPANY."' AND CODE != '".$CODE."'";
				$query = $this->db->query($str);
				
				if(count($query) > 0)
				{
					$resp["message"] = "exist";
					$resp["status"] = true;
					return $resp;
				}
				
				$str = "UPDATE bundles SET 
				NAME = '".$NAME."',
				COURSES = '".$COURSES."'
				WHERE CODE ='".$CODE."'";
				$query = $this->db->query($str);
			}

			$ans = "done";
		
		}
		
		if($info["FORM"] == "slide")
		{
		
			
			$COURSE = $info["COURSE"];
			$LANG = $info["LANG"];
			$POS = $info["POS"];
			$FILE = $info["FILE"];
			$MODU = $info["MODU"];
			
			$CODE = md5($COURSE.$now);
			
			if($MODE== "new")
			{
			
				// GET CLIENT CODE
				$str = "SELECT CODE FROM slides WHERE COURSE = '".$COURSE."' AND LANG = '".$LANG."' AND POS = '".$POS."' AND MODU = '".$MODU."'";
				$query = $this->db->query($str);
				
				if(count($query) == 0)
				{
					$str = "INSERT INTO slides (
					CODE,
					COURSE,
					LANG,
					MODU,
					POS
					) VALUES (
					'".$CODE."',
					'".$COURSE."',
					'".$LANG."',
					'".$MODU."',
					'".$POS."'
					)";
					$query = $this->db->query($str);
				}
			}
			else
			{
				$CODE = $info["EDITCODE"];
				
				$str = "UPDATE slides SET 
				MODU = '".$MODU."'
				WHERE CODE ='".$CODE."'";
				$query = $this->db->query($str);
			}
			
			
			if($FILE != "")
			{file_put_contents('../../courses/files/'.$COURSE.'-'.$POS.'-'.$LANG.' M '.$MODU.'.jpg', file_get_contents($FILE));}
			
			
			



			$ans = "done";
		
		}
		
		if($info["FORM"] == "docs")
		{
		
			
			$COURSE = $info["COURSE"];
			$LANG = $info["LANG"];
			$POS = $info["POS"];
			$NAME = $info["NAME"];
			$TYPE = $info["TYPE"];
			$LINK = $info["LINK"];
			$FILE = $info["FILE"];
			$EXT = $info["EXT"];
			
			$CODE = md5($COURSE.$now);
			
			$str = "SELECT CODE FROM docs WHERE COURSE = '".$COURSE."' AND LANG = '".$LANG."' AND POS = '".$POS."'";
			$query = $this->db->query($str);
			
			if(count($query) == 0)
			{
				$str = "INSERT INTO docs (
				CODE,
				COURSE,
				NAME,
				LANG,
				TYPE,
				LINK,
				EXT,
				POS
				) VALUES (
				'".$CODE."',
				'".$COURSE."',
				'".$NAME."',
				'".$LANG."',
				'".$TYPE."',
				'".$LINK."',
				'".$EXT."',
				'".$POS."'
				)";
				$query = $this->db->query($str);
			}
			
			
			
			if($FILE != "")
			{file_put_contents('../../courses/files/ATT-'.$COURSE.'-'.$POS.'-'.$LANG.'.'.$EXT, file_get_contents($FILE));}
			
			
			



			$ans = "done";
		
		}
		

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
		
	}
	function getSlides($info)
	{
		$COURSE = $info["COURSE"];
		$UCODE = $info["UCODE"];
		$LANG = $info["LANG"];
		$MODU = $info["MODU"];
		
		
		$str = "SELECT TYPE FROM courses WHERE CODE = '".$COURSE."'";
		$ctype = $this->db->query($str)[0]["TYPE"];
		
		if($ctype == "N")
		{
			// GET MODULES COUNT
			$str = "SELECT * FROM slides WHERE COURSE = '".$COURSE."' AND LANG = '".$LANG."' ORDER BY MODU DESC, POS ASC";
			$query = $this->db->query($str);
			
			$modQty = $query[0]["MODU"];
			
			// GET APPROVED MODULES
		
			// CHECK USER PASSED COURSE ----
			$localInfo = array();
			$localInfo["UCODE"] = $UCODE;
			$localInfo["COURSE"] = $COURSE;
			$check = $this-> isPassedCourse($localInfo)["message"];
			$passed = $check["BOOLEAN"];
			$lastDate = $check["DATE"];
			$detail = $check["DETAIL"];
			// CHECK USER PASSED COURSE ----
			
			$ans = $query;
			
			
		}
		else
		{
			$modQty = 1;
			$detail = false;
			$ans = "ispring";
		}
		

		$str = "SELECT * FROM docs WHERE COURSE = '".$COURSE."' AND LANG = '".$LANG."' ORDER BY POS ASC";
		$attached = $this->db->query($str);

		
		$resp["message"] = $ans;
		$resp["modQty"] = $modQty;
		$resp["detail"] = $detail;
		$resp["attached"] = $attached;
		$resp["ctype"] = $ctype;
		$resp["status"] = true;
		return $resp;
	}
	function isPassedCourse($info)
	{
		$UCODE = $info["UCODE"];
		$COURSE = $info["COURSE"];
		$LIMIT = 60;
		
		// GET MODULE COUNT
		// QUIT LIMIT IF FAILS RECOGNITION
		$str = "SELECT MODU FROM slides WHERE COURSE = '".$COURSE."' ORDER BY MODU DESC, POS DESC";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$modQty = intval($query[0]["MODU"]);
		}
		else
		{
			$modQty = 1;
		}
		

		$lastModPresented = "";
		
		// GET APROVED DETAIL PER MODULE
		$str = "SELECT MODU, PRESENTED FROM trials WHERE COURSE = '".$COURSE."' AND UCODE = '".$UCODE."' AND SCORE >= $LIMIT ORDER BY MODU DESC, PRESENTED DESC";
		$trials = $this->db->query($str);
		
		$modTotals = array();
		for($i=0; $i<$modQty;$i++)
		{
			$modu = $i+1;
			$passed = 0;
			for($m=0; $m<count($trials);$m++)
			{
				if($trials[$m]["MODU"] == $modu)
				{
					$passed = 1;
					$lastModPresented = $trials[$m]["PRESENTED"];
					break;
				}
			}
			$modTotals[$i] = $passed;
			
		}
		// GET TRUE OR NOT APROBED
		$pass = 1;
		for($i=0; $i<count($modTotals);$i++)
		{
			$score = $modTotals[$i];
			if($score == 0){$pass = 0;break;}
		}
		
		$ans["MODQTY"] = $modQty;
		$ans["DETAIL"] = $modTotals;
		$ans["BOOLEAN"] = $pass;
		$ans["DATE"] = $lastModPresented;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function savePlain($info)
	{
		$CODE = $info["CODE"];
		$CCODE = $info["CODE"];
		$ULIMIT = $info["ULIMIT"];
		$FILE = $info["FILE"];
		$LANG = $info["LANG"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$content = file_get_contents($FILE);
		
		$allLines = explode(PHP_EOL, $content);
		
		// $allLines = utf8_encode($allLines);
		
		$users = array();
		
		for($i=1; $i<count($allLines);$i++)
		{
			$line = $allLines[$i];
			
			$user = array();
			$segments = explode(",",$line);

			$name = $segments[0];
			
			if($name == ""){continue;}
			if($name[0] == ">"){continue;}
			
			$email = $segments[1];
			
			
			$address = explode(",",$line)[2];
			$phone = explode(",",$line)[3];
			$idtype = explode(",",$line)[4];
			$idnumber = explode(",",$line)[5];
			$idnumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $idnumber);

			$user["NAME"] = $name;
			$user["CODE"] = md5($name.$now);
			$user["IDTYPE"] = $idtype;
			$user["IDNUMBER"] = $idnumber;
			$user["EMAIL"] = $email;
			$user["ADDRESS"] = $address;
			$user["PHONE"] = $phone;
			$user["TYPE"] = "2";
			$user["COMPANY"] = $CODE;
			$user["REGDATE"] = $now ;

			array_push($users, $user);
			
		}
		
		
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		
		
		for($i=0; $i<count($users);$i++)
		{
			
			$newUser = $users[$i];
			$NAME = addslashes($newUser["NAME"]);
			$CODE = md5($NAME.$now);
			$IDTYPE = $newUser["IDTYPE"];
			$IDNUMBER = $newUser["IDNUMBER"];
			$EMAIL = $newUser["EMAIL"];
			$ADDRESS = addslashes($newUser["ADDRESS"]);
			$PHONE = $newUser["PHONE"];
			$TYPE = $newUser["TYPE"];
			$COMPANY = $newUser["COMPANY"];
			$PASSWD = md5($IDNUMBER);
			$REGDATE = $now;
			$MODE = "new";
			
			
			$str = "SELECT CODE FROM users WHERE COMPANY = '".$COMPANY."' AND STATUS = '1'";
			$guys = $this->db->query($str);
			
			$employees = count($guys);
			
			if($employees >= $ULIMIT)
			{
				$resp["message"] = "qtyLimit";
				$resp["status"] = true;
				return $resp;
			}
			
			

			// GET USER CODE
			$str = "SELECT CODE, EMAIL FROM users WHERE EMAIL = '".$EMAIL."' AND TYPE = '".$TYPE."' AND COMPANY = '".$CCODE."'";
			$query = $this->db->query($str);
			
			if(count($query) > 0)
			{
				continue;
				
				$resp["message"] = "exist: ".$EMAIL;
				$resp["status"] = true;
				return $resp;
			}
			else
			{
				$str = "INSERT INTO users (CODE, NAME, IDTYPE, IDNUMBER, EMAIL, ADDRESS, PHONE, TYPE, COMPANY, PASSWD, REGDATE) VALUES ('".$CODE."', '".$NAME."', '".$IDTYPE."', '".$IDNUMBER."', '".$EMAIL."', '".$ADDRESS."', '".$PHONE."', '".$TYPE."', '".$COMPANY."','".$PASSWD."','".$REGDATE."')";
			
			
				$query = $this->db->query($str);
				
				
				// COMPOSE EMAIL FOR EACH USER
				// COMPOSE EMAIL FOR EACH USER
				// COMPOSE EMAIL FOR EACH USER
				// COMPOSE EMAIL FOR EACH USER
				
				
				
				$block = $langFile[$LANG ]["userCreated"]."<br><br>";
				$credentials1 = $langFile[$LANG ]["creds1"]." ";
				$credentials2 = $langFile[$LANG ]["creds2"];
				$block .= $credentials1.$EMAIL.$credentials2.$IDNUMBER;
				
				
				// SEND MESSAGE USERS
				$localInfo = array();
				$localInfo["type"] = "4";
				$localInfo["email"] = $EMAIL;
				$localInfo["others"] = array();
				$localInfo["data"] = $block;
				$localInfo["lang"] = $LANG;
				$send = $this-> notificate($localInfo)["message"];
				// SEND MESSAGE USERS
				
				// $resp["message"] = $send;
				// $resp["status"] = true;
				// return $resp;
			}

			

			
		}

		


		
		$resp["message"] = $users;
		$resp["status"] = true;
		return $resp;
	}
	function daemon($info)
	{
		
		// $COMPANY = $info["COMPANY"];
		$now = new DateTime();
		$now = $now->format('Y-m-d');
		
		$str = "SELECT * FROM daemon WHERE DATE = '".$now."' AND TYPE = '2'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$ans = "Done";
		}
		else
		{

			$str = "SELECT CODE, EMAIL, ALLOWED, ASSIGNED, ASSIGNED_LIMIT FROM users WHERE ALLOWED != '[]' AND ALLOWED != 'null' AND (TYPE = '2' OR TYPE = '4') AND STATUS = 1";
			$query = $this->db->query($str);
			
			$selected = array();
			
			for($i=0; $i<count($query);$i++)
			{
				$user =  $query[$i];
				$date = $user["ASSIGNED_LIMIT"];
				
				$today = strtotime(date("Y-m-d"));
				$finalDate = strtotime($date); 
				$diff = $today - $finalDate; 
				$daysLeft = round($diff / (60*60*24));
				
				$user["LEFT"] = $daysLeft;
				
				if($daysLeft >-4 and $daysLeft <=0)
				{
					array_push($selected, $user);
				}
			}
			
			
			// CHECK IF USER COMPLETED ASSIGNATION IF NOT SEND REMINDER 1 PER DAY 
			
			$queens = array();
			
			for($i=0; $i<count($selected);$i++)
			{
				$user = $selected[$i];
				$ucode = $user["CODE"];
				$userAllowed = json_decode($user["ALLOWED"], true);
				$assigned = $user["ASSIGNED"];
				$limit = $user["ASSIGNED_LIMIT"];
				
			
				for($a=0; $a<count($userAllowed);$a++)
				{
					$course = $userAllowed[$a];

					$str = "SELECT PRESENTED, SCORE FROM trials WHERE COURSE = '".$course."' AND UCODE = '".$ucode."' AND SCORE >= 60 ORDER BY PRESENTED DESC";
					$trials = $this->db->query($str);
					
					if(count($trials) > 0)
					{
						$presented = explode(' ', $trials[0]["PRESENTED"])[0];
						
						if($presented > $assigned and $presented <= $limit){}
						else
						{
							$user["MISSING"] = $course;
							array_push($queens, $user);
							break;
						}
					}
					else
					{
						$user["MISSING"] = $course;
						array_push($queens, $user);
						break;
					}
				}
				
			}
		
			
			$ans = "Execute";
			
			$str = "INSERT INTO daemon (DATE) VALUES ('".$now."')";
			$query = $this->db->query($str);
		}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getQuest($info)
	{
		$CODE = $info["CODE"];
		$UCODE = $info["UCODE"];
		$MODU = $info["MODU"];
		
		$str = "SELECT PRESENTED, SCORE FROM trials WHERE COURSE = '".$CODE."' AND UCODE = '".$UCODE."' ORDER BY PRESENTED DESC";
		$trials = $this->db->query($str);
		
		$str = "SELECT * FROM questions WHERE TEST = '".$CODE."' AND MODU = '".$MODU."'";
		$query = $this->db->query($str);
		$ans = $query;
		
		$resp["trials"] = $trials;
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	// DELETER
	function deleteItem($info)
	{
		$table = $info["table"];
		$code = $info["code"];

		if($table == "courses")
		{
			// DEL COURSE PICS
			$coursePic = "../../courses/pics/".$code.".jpg";
			$fileEs = "../../courses/files/".$code."_ES.pdf";
			$fileEn = "../../courses/files/".$code."_EN.pdf";
			$filePt = "../../courses/files/".$code."_PT.pdf";
			
			$list = [$coursePic,$fileEs,$fileEn,$filePt];

			for($i=0; $i<count($list);$i++)
			{
				$path = $list[$i];
				$exists = file_exists($path);
				if($exists == true){unlink($path);}
			}
			
			$str = "DELETE FROM courses WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
		}
		if($table == "tests")
		{
			$str = "DELETE FROM tests WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
		}
		if($table == "questions")
		{
			$str = "DELETE FROM questions WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
		}
		if($table == "users")
		{
			$str = "DELETE FROM users WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM plans WHERE UCODE = '".$code."'";
			$query = $this->db->query($str);
			
		}
		if($table == "plans")
		{
			$str = "DELETE FROM plans WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
		}
		if($table == "bundles")
		{
			$str = "DELETE FROM bundles WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
		}
		if($table == "slides")
		{
			
			$str = "SELECT COURSE, LANG, POS FROM slides WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
			$course = $query[0]["COURSE"];
			$lang = $query[0]["LANG"];
			$pos = $query[0]["POS"];
			
			
			$path = "../../courses/files/".$course."-".$pos."-".$lang.".jpg";
			$exists = file_exists($path);
			if($exists == true){unlink($path);}
			
			$str = "DELETE FROM slides WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
			
			
		}
		if($table == "docs")
		{
			
			$str = "SELECT COURSE, LANG, POS, EXT FROM docs WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
			$course = $query[0]["COURSE"];
			$lang = $query[0]["LANG"];
			$pos = $query[0]["POS"];
			$ext = $query[0]["EXT"];
			
			
			$path = "../../courses/files/ATT-".$course."-".$pos."-".$lang.".".$ext;
			$exists = file_exists($path);
			if($exists == true){unlink($path);}
			
			$str = "DELETE FROM docs WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
			
			
		}
		if($table == "cats")
		{
			
			$str = "DELETE FROM cats WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
			
			
		}
		
		// $ans = $path;
		$ans = "done";

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function setCourseTest($info)
	{
		
		$COURSE = $info["course"];
		$TEST = $info["pickedTest"];
		
		$str = "UPDATE courses SET TEST = '$TEST' WHERE CODE='".$COURSE."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
	}
	function setCourseTestQ($info)
	{
		
		$QUESTION = $info["question"];
		$TEST = $info["pickedTest"];
		$MOD = $info["pickedMod"];
		
		$str = "UPDATE questions SET TEST = '".$TEST."', MODU = '".$MOD."' WHERE CODE='".$QUESTION."'";
		$query = $this->db->query($str);
		
		$ans = $str;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveTrial($info)
	{
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$UCODE = $info["UCODE"];
		$SCORE = $info["SCORE"];
		$MODU = $info["MODU"];
		$COURSE = $info["COURSE"];
		$CODE = md5($UCODE.$now);
		$PRESENTED = $now;
		
		$ANSWERS = $info["ANSWERS"];
		
		$str = "INSERT INTO trials (
				CODE,
				UCODE,
				COURSE,
				PRESENTED,
				MODU,
				SCORE
				) VALUES (
				'".$CODE."',
				'".$UCODE."',
				'".$COURSE."',
				'".$PRESENTED."',
				'".$MODU."',
				'".$SCORE."'
				)";
				$query = $this->db->query($str);
		
		
		// SAVE ANSWERS
		for($i=0; $i<count($ANSWERS);$i++)
		{
			
			$ans = $ANSWERS[$i];
			$QCODE = $ans["QCODE"];
			$UCODE = $ans["UCODE"];
			$DATE = $ans["DATE"];
			$RESULT = $ans["RESULT"];
			$LANG = $ans["LANG"];
			
			
			$str = "INSERT INTO answers 
			(
				QCODE,
				UCODE,
				DATE,
				RESULT,
				LANG
			) VALUES (
				'".$QCODE."',
				'".$UCODE."',
				'".$DATE."',
				'".$RESULT."',
				'".$LANG."'
				
			)";
				
			$query = $this->db->query($str);

		}
		
		
		// $resp["message"] = $ANSWERS;
		// $resp["status"] = true;
		// return $resp;
		
		
		
		
		$str = "SELECT * FROM trials WHERE UCODE = '".$UCODE."' ORDER BY PRESENTED DESC";
		$query = $this->db->query($str);
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	// QRGENERATE
	function QRCODE($url) 
	{

		QRcode::png($url, 'test.png');
		
		// OLD
		
		// $apiUrl = 'http://chart.apis.google.com/chart';
		
		// $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $apiUrl);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($url));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HEADER, false);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        // $img = curl_exec($ch);
        // curl_close($ch);
        // if ($img) {
            // if ($filename) {
                // if (!preg_match("#\.png$#i", $filename)) {
                    // $filename .= ".png";
                // }
                // return file_put_contents($filename, $img);
            // } else {
                // header("Content-type: image/png");
                // print $img;
                // return true;
            // }
        // }
        // return false;
    }
	function setPass($info)
	{
		$CODE = $info["CODE"];
		$PASSWD = md5($info["PASSWD"]);
		
		$str = "UPDATE users SET PASSWD = '".$PASSWD."', PCHANGED = '1' WHERE CODE = '".$CODE."'";
		$query = $this->db->query($str);
		
		$resp["message"] = "pass set";
		$resp["status"] = true;
		return $resp;
	}
	function filterWorks($info)
	{
		$main = $info["main"];
		$sub = $info["sub"];
		$search = $info["search"];
		$loc = $info["loc"];
		$lastFilter = $info["lastFilter"];
		$ucode = $info["ucode"];
		$ftype = $info["ftype"];
		
		if($ftype != "3")
		{
			$where = "WHERE  STATE = '0' AND TYPE = '".$ftype."' ";
			if($loc != ""){$where .= "AND LOCATION LIKE '%$loc%'";}
			if($search != ""){$where .= "AND (DETAIL LIKE '%$search%' OR MNAME LIKE '%$search%' OR SNAME LIKE '%$search%') ";} 
			
			// SHOW ALL
			if(count($main) == 0)
			{
				$str = "SELECT *  FROM works $where ORDER BY CREATED DESC LIMIT 100 ";
				$ans = $this->db->query($str);
			}
			else 
			{
				// MAIN AND SUBFILTERS
				if(count($sub) > 0)
				{
					$where .= " AND (";
					$subParents = array();
					for($i=0; $i < count($sub); $i++)
					{
						$subCode = $sub[$i];
						if($i == 0){$where .= "SPARENT = '$subCode' ";}
						else{$where .= " OR SPARENT = '$subCode' ";}
						$str = "SELECT PARENT FROM cats WHERE CODE = '".$subCode."'";
						$parent = $this->db->query($str)[0]["PARENT"];
						array_push($subParents, $parent);
					}
					$where .= ") ";
					$str = "SELECT *  FROM works $where ORDER BY CREATED DESC LIMIT 100 ";
					$subsR = $this->db->query($str);
					// --------------- GOT SUBS RESULTS -------------------
					$str = "SELECT *  FROM works $where ORDER BY CREATED DESC LIMIT 100 ";
					$subsR = $this->db->query($str);
					
					// GET UNFILTERED MAIN CATS
					for($i=0; $i < count($subParents); $i++)
					{
						$mainCode = $subParents[$i];
						if(in_array($mainCode, $main))
						{
							$index = array_search($mainCode, $main, true);
							if($index !== false)
							{
								unset($main[$index]); 
								$main = array_values($main);
								$i=0 ;
							}
						}
					}
					if(count($main) > 0)
					{
						$where = "WHERE  STATE = '0' AND TYPE = '".$ftype."' ";
						if($loc != ""){$where .= "AND LOCATION LIKE '%$loc%'";}
						$where .= " AND (";
						for($i=0; $i < count($main); $i++)
						{
							$mainCode = $main[$i];
							if($i == 0){$where .= "MPARENT = '$mainCode' ";}
							else{$where .= " OR MPARENT = '$mainCode' ";}
						}
						$where .= ") ";
						$str = "SELECT *  FROM works $where ORDER BY CREATED DESC LIMIT 100 ";
						$mainsR = $this->db->query($str);
						$ans = array_merge($subsR, $mainsR);
					}
					else
					{
						$ans = $subsR;
					}
				}
				// ONLY FULL MAIN CATS FILTER
				else
				{
					$where .= " AND (";
					for($i=0; $i < count($main); $i++)
					{
						$mainCode = $main[$i];
						if($i == 0){$where .= "MPARENT = '$mainCode' ";}
						else{$where .= " OR MPARENT = '$mainCode' ";}
					}
					$where .= ") ";
					$str = "SELECT *  FROM works $where ORDER BY CREATED DESC LIMIT 100 ";
					$ans = $this->db->query($str);
				}
			}
		}
		else
		{
			$where = "WHERE  PASSED = '1' ";
			if($search != ""){$where .= "AND (NAME LIKE '%$search%' OR RESUME LIKE '%$search%') ";}
			if($loc != ""){$where .= "AND LOCATION LIKE '%$loc%'";} 
			if(count($sub) > 0)
			{
				$where .= "AND (";
				for($i=0; $i < count($sub); $i++)
				{
					$subCode = $sub[$i];
					if($i == 0){$where .= "CATS LIKE '%$subCode%' ";}
					else{$where .= " OR CATS LIKE '%$subCode%' ";}
				}
				$where .= ") ";
			}
			if(count($main) > 0)
			{
				$where .= "AND (";
				for($i=0; $i < count($main); $i++)
				{
					$mainCode = $main[$i];
					if($i == 0){$where .= "CATS LIKE '%$mainCode%' ";}
					else{$where .= " OR CATS LIKE '%$mainCode%' ";}
				}
				$where .= ") ";
			}
			
			$str = "SELECT UCODE,NAME, STATUS FROM users $where ORDER BY NAME";
			$query = $this->db->query($str);
			
			if(count($query) > 0)
			{
				for($i=0; $i<count($query); $i++)
				{
					$code = $query[$i]["UCODE"];
					
					$localInfo = array();
					$localInfo["code"] = $code;
					$rate = $this-> getTechRate($localInfo)["message"];
					
					$query[$i]["RATE"] = $rate;
				}
			
			// ORDER BY KEY -------------------------------
			foreach($query as $item)
			{
				foreach($item as $key=>$value)
				{
					if(!isset($sortArray[$key]))
					{$sortArray[$key] = array();}
					$sortArray[$key][] = $value;
				}
			}
			$orderby = "RATE";
			array_multisort($sortArray[$orderby],SORT_DESC,$query);
			// ORDER BY KEY -------------------------------
			}
			$ans = $query;
		}
		
		// UPDATE USER LAST FILTER 
		if($ucode != "")
		{
			$str = "UPDATE users SET LASTFILTER = '".$lastFilter."' WHERE UCODE ='".$ucode."'";
			$query = $this->db->query($str);
		}

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function loadWork($info)
	{
		$code= $info["code"];
		
		$ans = array();
		
		$str = "SELECT * FROM works WHERE CODE = '".$code."'";
		$query = $this->db->query($str);
		
		$ans["data"] = $query[0];
		
		$str = "SELECT * FROM offers WHERE WORKCODE = '".$code."' ORDER BY CREATED DESC";
		$query = $this->db->query($str);
		
		$ans["offers"] = $query;
		
		$str = "SELECT * FROM comments WHERE WORKCODE = '".$code."' AND STATUS = '1' ORDER BY DATE ASC";
		$query = $this->db->query($str);
		
		$ans["comments"] = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function setFileLink($info)
	{
		
		$code = $info["code"];
		$type = $info["type"];
		
		if($type == "Doc"){$str = "UPDATE users SET DOCFILE = '1' WHERE UCODE='".$code."'";}
		if($type == "Sop1"){$str = "UPDATE users SET SOPFILE1 = '1' WHERE UCODE='".$code."'";}
		if($type == "Sop2"){$str = "UPDATE users SET SOPFILE2 = '1' WHERE UCODE='".$code."'";}
		if($type == "Sop3"){$str = "UPDATE users SET SOPFILE3 = '1' WHERE UCODE='".$code."'";}
		
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
	}
	function aprobePro($info)
	{
		$ucode = $info["ucode"];
		$state = $info["state"];
		
		$str = "UPDATE users SET PASSED = '".$state."' WHERE UCODE ='".$ucode."'";
		$query = $this->db->query($str);
		
		$ans = "aprobed";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function commentSave($info)
	{
		$code = $info["code"];
		$comments = $info["comments"];
		$autor = $info["autor"];
		$autorName = $info["autorName"];
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$comCode = md5($code.$now);
		
		$str = "INSERT INTO comments (CODE, AUTOR, AUTORCODE, CONTENT, WORKCODE, DATE) VALUES ('".$comCode."', '".$autorName."', '".$autor."','".$comments."','".$code."','".$now."')";
		$query = $this->db->query($str);
		
		// GET CLIENT CODE
		$str = "SELECT * FROM works WHERE CODE = '".$code."'";
		$query = $this->db->query($str);
		$wData = $query[0];
		$ccode = $wData["AUTORCODE"];
		
		if($autor != $ccode)
		{
			// GET CLIENT MAIL
			$str = "SELECT EMAIL FROM users WHERE UCODE = '".$ccode."'";
			$query = $this->db->query($str);
			$clientMail = $query[0]["EMAIL"];
			
			// SEND MESSAGE CLIENT
			$localInfo = array();
			$localInfo["type"] = "0";
			$localInfo["email"] = $clientMail;
			$localInfo["data"] = $wData;
			$send = $this-> notificate($localInfo)["message"];
			// SEND MESSAGE CLIENT
		}
		
		$str = "SELECT *  FROM comments WHERE WORKCODE = '".$code."' ORDER BY DATE ASC";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getComments($info)
	{
		$code = $info["code"];
		
		$str = "SELECT *  FROM comments WHERE WORKCODE = '".$code."' ORDER BY DATE ASC";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getProposals($info)
	{
		$code = $info["code"];
		
		$str = "SELECT *  FROM offers WHERE WORKCODE = '".$code."' ORDER BY CREATED DESC";
		$query = $this->db->query($str);
		
		for($i=0; $i<count($query); $i++)
		{
			$item = $query[$i];
			$techCode = $item["TECHCODE"];
			$localInfo = array();
			$localInfo["code"] = $techCode;
			$rate = $this-> getTechRate($localInfo)["message"];
			
			$query[$i]["RATE"] = $rate;
			
		}
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function killOffer($info)
	{
		$code = $info["code"];
		$table = "offers";
		
		$str = "DELETE FROM $table WHERE $table.CODE = '".$code ."'";
		$query = $this->db->query($str);
		
		$ans = "deleted";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function killCat($info)
	{
		$code = $info["code"];
		$table = "cats";
		
		$str = "DELETE FROM $table WHERE $table.CODE = '".$code ."'";
		$query = $this->db->query($str);
		
		$ans = "deleted";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function pickOffer($info)
	{
		$code = $info["code"];
		$wcode = $info["wcode"];
		$tech = $info["tech"];
		$techName = $info["techName"];
		$price = $info["price"];
		$ransom = $info["ransom"];

		$table = "offers";

		$str = "UPDATE $table SET STATE = '1' WHERE $table.CODE = '".$code ."'";
		$query = $this->db->query($str);
		
		$str = "UPDATE works SET STATE = '1', TECH = '".$tech ."', TECHNAME = '".$techName ."', PRICE = '".$price ."', RPRICE = '".$price ."', RANSOM = '".$ransom ."' WHERE works.CODE = '".$wcode ."'";
		$query = $this->db->query($str);
		
		// GET CLIENT CODE
		$str = "SELECT * FROM works WHERE CODE = '".$wcode."'";
		$query = $this->db->query($str);
		$wData = $query[0];
		$ccode = $wData["AUTORCODE"];
		
		// GET CLIENT DATA
		$str = "SELECT * FROM users WHERE UCODE = '".$ccode."'";
		$query = $this->db->query($str);
		$clientData = $query[0];
		$clientData["WCODE"] = $wcode;
		$clientMail = $clientData["EMAIL"];
		
		// GET TECH DATA
		$str = "SELECT * FROM users WHERE UCODE = '".$tech."'";
		$query = $this->db->query($str);
		$techData = $query[0];
		$techData["WCODE"] = $wcode;
		$techMail =  $techData["EMAIL"];
		
		// SEND MESSAGE CLIENT
		$localInfo = array();
		$localInfo["type"] = "3";
		$localInfo["email"] = $clientMail;
		$localInfo["data"] = $techData;
		$send2 = $this-> notificate($localInfo)["message"];
		// SEND MESSAGE CLIENT
		
		// SEND MESSAGE TECH PICKED
		$localInfo = array();
		$localInfo["type"] = "2";
		$localInfo["email"] = $techMail;
		$localInfo["data"] = $clientData;
		$send1 = $this-> notificate($localInfo)["message"];
		// SEND MESSAGE TECH PICKED
		
		$ans = "selected";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getUdata($info)
	{
		$code = $info["code"];
		
		$str = "SELECT *  FROM users WHERE UCODE = '".$code."'";
		$query = $this->db->query($str);
		
		$localInfo = array();
		$localInfo["code"] = $code;
		$rate = $this-> getTechRate($localInfo)["message"];
		
		$ans = $query[0];
		$ans["RATE"] = $rate;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getUStory($info)
	{
		$code = $info["code"];
		
		$str = "SELECT AUTOR, COMMENTS, CREATED, RATE FROM works WHERE TECH = '".$code."' AND STATE = '2' ORDER BY CREATED DESC";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getTechRate($info)
	{
		$code = $info["code"];
		$str = "SELECT RATE FROM works WHERE TECH = '".$code."' AND STATE = '2' AND TYPE = '1'";
		$query = $this->db->query($str);
		
		$sum = 0;
		
		if(count($query) > 0)
		{
			$divider = count($query);
			for($i=0; $i<count($query); $i++)
			{
				$item = $query[$i];
				$sum = $sum+floatval($item["RATE"]);
			}
			
			// GIVE RATE ONLY IF MORE THAN 2 WORKS RATED
			if($divider > 2){$ans = $sum/$divider;}
			else{$ans = 0;}
			
		}
		else
		{
			$ans = 0;
		}

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveCat($info)
	{
		$type = $info["type"];
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$code = md5($type.$now);
		
		if($type == "main")
		{
			$catName = $info["catName"];
			$str = "INSERT INTO cats (CODE, DETAIL, PARENT, TYPE, STATUS) VALUES ('".$code."', '".$catName."','','0', '1')";
			$query = $this->db->query($str);
		}
		else
		{
			$catParent = $info["catParent"];
			$catName = $info["catName"];
			$str = "INSERT INTO cats (CODE, DETAIL, PARENT, TYPE, STATUS) VALUES ('".$code."', '".$catName."','".$catParent."','1', '1')";
			$query = $this->db->query($str);
		}
		$ans = $query;
		
		$resp["message"] = "Created";
		$resp["status"] = true;
		return $resp;
	}
	function getUjobs($info)
	{
		$code = $info["code"];
		
		$str = "SELECT TECH, AUTORCODE, STATE FROM works WHERE TECH = '".$code."' OR AUTORCODE = '".$code."'";
		$query = $this->db->query($str);
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	}
	function getCatWorks($info)
	{
		$code = $info["code"];
		
		$str = "SELECT CODE FROM works WHERE MPARENT = '".$code."' OR SPARENT = '".$code."'";
		$query = $this->db->query($str);
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	}
	function logw($info)
	{
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$mt = $info["mt"];
		$ucode = $info["ucode"];
		
		$str = "INSERT INTO log (DATE, MT, UCODE) VALUES ('".$now."', '".$mt."', '".$ucode."')";
		$query = $this->db->query($str);
		
		return;

	}
	function guData($info)
	{
		$code = $info["code"];
			
		$str = "SELECT *  FROM users WHERE UCODE = '".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query[0];
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function savePass($info)
	{
		$pass = md5($info["pass1"]);
		$ucode = $info["ucode"];

		$str = "UPDATE users SET PASSWD = '".$pass."' WHERE UCODE='".$ucode."' "; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = "saved";
		$resp["status"] = true;
		return $resp;
	}
	function saveProfile($info)
	{
		$ucode = $info["ucode"];
		$type = $info["type"];
		
		if($type == "1")
		{
			$name = $info["name"];
			$email = $info["email"];
			$rLocation = $info["rLocation"];
			$address = $info["address"];
			$phone = $info["phone"];
			$idtype = $info["idtype"];
			$idnumber = $info["idnumber"];
			$str = "UPDATE users SET NAME = '".$name."', EMAIL = '".$email."', ADDRESS = '".$address."', PHONE = '".$phone."', IDTYPE = '".$idtype."', IDNUMBER = '".$idnumber."',  LOCATION = '".$rLocation."'  WHERE UCODE='".$ucode."'"; 
			
		}
		else
		{
			$resume = $info["resume"];
			$cats = $info["cats"];
			$str = "UPDATE users SET RESUME = '".$resume."', CATS = '".$cats."' WHERE UCODE='".$ucode."'"; 
		}
		
		$query = $this->db->query($str);
		$ans = $query;
		
		$resp["message"] = "saved";
		$resp["status"] = true;
		return $resp;
	}
	function workSave($info)
	{
		$wLoc = $info["wLoc"];
		$wDuration = $info["wDuration"];
		$wPropTop = $info["wPropTop"];
		$wCat = $info["wCat"];
		$wCatDet = $info["wCatDet"];
		
		$wDetails = $info["wDetails"];
		$created = $info["created"];
		$autor = $info["autor"];
		$ucode = $info["ucode"];
		$mode = $info["mode"];
		$type = $info["type"];
		$rprice = $info["rprice"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		
		$wsCat = $info["wsCat"];
		$wsCatDet = $info["wsCatDet"];
		
		if($mode == "c")
		{
			$code = md5($now.$autor);
			
			$str = "INSERT INTO works (CODE, LOCATION, DURATION, PROPTOP, MPARENT, MNAME, SPARENT, SNAME, DETAIL, CREATED, AUTOR, AUTORCODE, TYPE, RPRICE) VALUES ('".$code."','".$wLoc."', '".$wDuration."', '".$wPropTop."', '".$wCat."', '".$wCatDet."', '".$wsCat."', '".$wsCatDet."', '".$wDetails."', '".$created."', '".$autor."', '".$ucode."', '".$type."', '".$rprice."')";
			
			$query = $this->db->query($str);
			
			// CREATE ACCESSPATH
			mkdir('../../../img/works/'.$code, 0777, true);
			$orig = '../../../img/works/sample.jpg';
			$dest1 = '../../../img/works/'.$code.'/1.jpg';
			$dest2 = '../../../img/works/'.$code.'/2.jpg';
			$dest3 = '../../../img/works/'.$code.'/3.jpg';
			copy($orig, $dest1);
			copy($orig, $dest2);
			copy($orig, $dest3);
			
			$ans = $code;

			$dummy1 = "hvelez@incocrea.com";
			// GET TECHS WITH SUBACTI MAILS
			$str = "SELECT EMAIL FROM users WHERE CATS LIKE '%$wsCat%' AND EMAIL LIKE '%$dummy1%'";
			$recipients = $this->db->query($str);

			for($i=0; $i<count($recipients); $i++)
			{
				$mail = $recipients[$i]["EMAIL"];
				
				// FOR TECH SEND NOTIFY
				// SEND MESSAGE CLIENT
				$localInfo = array();
				$localInfo["type"] = "5";
				$localInfo["email"] = $mail;
				$localInfo["data"] = "";
				$localInfo["catDet"] = $wsCatDet;
				$send = $this-> notificate($localInfo)["message"];
				// SEND MESSAGE CLIENT
			}
			
		}
		else
		{
			$actualCode = $info["actualCode"];
			
			$str = "UPDATE works SET LOCATION = '".$wLoc."', DURATION = '".$wDuration."', PROPTOP = '".$wPropTop."', MPARENT = '".$wCat."', MNAME = '".$wCatDet."', SPARENT = '".$wsCat."', SNAME = '".$wsCatDet."', DETAIL = '".$wDetails."', RPRICE = '".$rprice."', CREATED = '".$created."'  WHERE CODE ='".$actualCode."'";
			$query = $this->db->query($str);
			$ans = "edited";
		}

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function postulate($info)
	{
		$workCode = $info["workCode"];
		$tech = $info["tech"];
		$techName = $info["techName"];
		$detail = $info["detail"];
		$price = $info["price"];
		$ransom = $info["ransom"];
		$totalPrice = $info["totalPrice"];
		$avaDate = $info["avaDate"];
		$workTime = $info["workTime"];
		$guarantee = $info["guarantee"];
		$wLocation = $info["wLocation"];
		$pcode = md5($workCode.$tech);
		
		// CHECK BY STATE
		$str = "SELECT STATE, PROPTOP FROM works WHERE CODE = '".$workCode."'";
		$query = $this->db->query($str);
		
		if($query[0]["STATE"] != "0")
		{
			$resp["message"] = "full";
			$resp["status"] = true;
			return $resp;
		}
		
		// CHECK BY LIMIT
		
		$limit = intval($query[0]["PROPTOP"]);
		
		$str = "SELECT COUNT(CODE) FROM offers WHERE WORKCODE = '".$workCode."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$counted = intval($query[0]["COUNT(CODE)"]);

			if($counted > $limit)
			{
				$resp["message"] = "full";
				$resp["status"] = true;
				return $resp;
			}
		}
		
		// CREATE/UPDATE
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$str = "SELECT CODE FROM offers WHERE CODE = '".$pcode."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			
			$str = "UPDATE offers SET COMMENTS = '".$detail."', PRICE = '".$price."', RANSOM = '".$ransom."', AVAILABLE = '".$avaDate."', GUARANTEE = '".$guarantee."', WORKTIME = '".$workTime."', WORKLOCATION = '".$wLocation."', CREATED = '".$now."' WHERE CODE ='".$pcode."'";
			$query = $this->db->query($str);
			
			$ans = "re-created";
		}
		else
		{
			$str = "INSERT INTO offers (CODE, WORKCODE, TECHCODE, TECHNAME, COMMENTS, PRICE, RANSOM, AVAILABLE, GUARANTEE, WORKTIME, WORKLOCATION, CREATED) VALUES ('".$pcode."','".$workCode."', '".$tech."', '".$techName."', '".$detail."', '".$price."', '".$ransom."', '".$avaDate."', '".$guarantee."', '".$workTime."', '".$wLocation."', '".$now."')";
			$query = $this->db->query($str);
			
			$ans = "created";
		}
		
		// GET CLIENT CODE
		$str = "SELECT * FROM works WHERE CODE = '".$workCode."'";
		$query = $this->db->query($str);
		$wData = $query[0];
		$ccode = $wData["AUTORCODE"];
		
		// GET CLIENT MAIL
		$str = "SELECT EMAIL FROM users WHERE UCODE = '".$ccode."'";
		$query = $this->db->query($str);
		$clientMail = $query[0]["EMAIL"];
		
		// SEND MESSAGE CLIENT
		$localInfo = array();
		$localInfo["type"] = "1";
		$localInfo["email"] = $clientMail;
		$localInfo["data"] = $wData;
		$send = $this-> notificate($localInfo)["message"];
		// SEND MESSAGE CLIENT

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function postulateBuy($info)
	{
		$workCode = $info["workCode"];
		$tech = $info["tech"];
		$techName = $info["techName"];
		$price = $info["price"];
		$pcode = md5($workCode.$tech);
		$wLocation = $info["wLocation"];
		
		$detail = $info["detail"];
		
		$ransom = "0";
		$avaDate = "";
		$guarantee = "";
		$workTime = "";
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		// CHECK BY STATE
		$str = "SELECT STATE, PROPTOP FROM works WHERE CODE = '".$workCode."'";
		$query = $this->db->query($str);
		
		if($query[0]["STATE"] != "0")
		{
			$resp["message"] = "full";
			$resp["status"] = true;
			return $resp;
		}
		
		// CHECK BY LIMIT
		
		$limit = intval($query[0]["PROPTOP"]);
		
		$str = "SELECT COUNT(CODE) FROM offers WHERE WORKCODE = '".$workCode."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$counted = intval($query[0]["COUNT(CODE)"]);

			if($counted > $limit)
			{
				$resp["message"] = "full";
				$resp["status"] = true;
				return $resp;
			}
		}
		
		// CREATE/UPDATE
		
		$str = "SELECT CODE FROM offers WHERE CODE = '".$pcode."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			
			$str = "UPDATE offers SET COMMENTS = '".$detail."', PRICE = '".$price."', RANSOM = '".$ransom."', WORKLOCATION = '".$wLocation."', CREATED = '".$now."' WHERE CODE ='".$pcode."'";
			$query = $this->db->query($str);
			$ans = "re-created";
		}
		else
		{
			$str = "INSERT INTO offers (CODE, WORKCODE, TECHCODE, TECHNAME, COMMENTS, PRICE, RANSOM, AVAILABLE, GUARANTEE, WORKTIME, WORKLOCATION, CREATED) VALUES ('".$pcode."','".$workCode."', '".$tech."', '".$techName."', '".$detail."', '".$price."', '".$ransom."', '".$avaDate."', '".$guarantee."', '".$workTime."', '".$wLocation."', '".$now."')";
			$query = $this->db->query($str);
			
			$ans = "created";
		}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getMyWorks($info)
	{
		$code = $info["code"];
		$filter = $info["filter"];
		$type = $info["type"];
		
		if($filter == "0")
		{
			$str = "SELECT *  FROM works WHERE (AUTORCODE = '".$code."' OR TECH = '".$code."') AND TYPE = '".$type."' ORDER BY CREATED DESC";
		}
		if($filter == "1")
		{
			$str = "SELECT *  FROM works WHERE AUTORCODE = '".$code."' AND TYPE = '".$type."' ORDER BY CREATED DESC";
		}
		if($filter == "2")
		{
			$str = "SELECT *  FROM works WHERE TECH = '".$code."' AND TYPE = '".$type."' ORDER BY CREATED DESC";
		}
		if($filter == "3")
		{
			$str = "SELECT *  FROM works WHERE RATE = '' AND AUTORCODE = '".$code."' AND TYPE = '".$type."' ORDER BY CREATED DESC";
		}
		
		
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getExecuted($info)
	{
		$code = $info["code"];
		
		$str = "SELECT COUNT(CODE)  FROM works WHERE TECH = '".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query[0]["COUNT(CODE)"];
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	// SAVE PIC
	function picsave($info)
	{
		
		$pic =  $info["pic"];
		$code = $info["code"];
		$picType = $info["picType"];
		
		if($picType == "1")
		{
			$destination_path = "../../../img/works/".$code."/1";
		}
		if($picType == "2")
		{
			$destination_path = "../../../img/works/".$code."/2";
		}
		if($picType == "3")
		{
			$destination_path = "../../../img/works/".$code."/3";
		}

		if($pic != "")
		{
			$hasBG = file_exists($destination_path.'.jpg');
			if($hasBG == true){unlink($destination_path.'.jpg');}
			
			list($type, $pic) = explode(';', $pic);
			list(, $pic)      = explode(',', $pic);
			$imageStr  = base64_decode($pic);

			$incoming = $pic;
			$mainImage = str_replace('data:image/jpeg;base64,', '', $incoming);
			file_put_contents($destination_path.'.jpg', base64_decode($mainImage));
			
		}
		
		$resp["message"] = $picType;
		$resp["status"] = true; 
		return $resp;
	}
	function markLoaded($info)
	{
		$type = $info["type"];
		$code = $info["code"];
		
		$field = "HP$type";
		
		$str = "UPDATE works SET $field = '1' WHERE CODE ='".$code."'";
		$query = $this->db->query($str);

		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function setRate($info)
	{
		$code = $info["code"];
		$rating = $info["rating"];
		$obs = $info["obs"];
		
		$str = "UPDATE works SET RATE = '".$rating."', COMMENTS = '".$obs."', STATE = '2' WHERE CODE ='".$code."' ";
		
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function cancelWork($info)
	{
		$code = $info["code"];
		$reason = $info["reason"];
		
		$str = "UPDATE works SET STATE = '3', CANCELED = '".$reason."' WHERE CODE ='".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function rlAudPro($info)
	{
		$code = $info["c"];
		$scode = $info["scode"];
		$type = $info["type"];
		
		if($code == "xxx")
		{
			$str = "SELECT * FROM	users WHERE users.UCODE = '$code'";
		}
		else
		{
			$str = "SELECT * FROM	users WHERE users.UCODE = '$code' AND SCODE = '$scode' AND TYPE = '$type'";

		}
		
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$mail = $query[0]["EMAIL"];
			
			if($mail  == "hvelez@incocrea.com")
			{
				$query[0]["logued"] = "2";
			}
			else
			{
				$query[0]["logued"] = "1";
			}

			$str = "SELECT STYPE FROM stores WHERE SCODE = '$scode'";
			$stype = $this->db->query($str)[0]["STYPE"];

			
			$str = "SELECT * FROM orders WHERE UCODE = '$code' AND SCODE = '$scode' AND OTYPE = '$stype' ORDER BY DATE DESC";
			$orders = $this->db->query($str);

			$resp["orders"] = $orders;
			$resp["message"] = $query[0];
			$resp["status"] = true;
			return $resp;
		}
		else
		{
			$resp["message"] = $query;
			$resp["status"] = true;
			return $resp;
		}
	}
	
	
	function utf8_new_decode(string $s): string 
	{
		$s .= $s;
		$len = \strlen($s);

		for ($i = $len >> 1, $j = 0; $i < $len; ++$i, ++$j) {
			switch (true) {
				case $s[$i] < "\x80": $s[$j] = $s[$i]; break;
				case $s[$i] < "\xC0": $s[$j] = "\xC2"; $s[++$j] = $s[$i]; break;
				default: $s[$j] = "\xC3"; $s[++$j] = \chr(\ord($s[$i]) - 64); break;
			}
		}

		return substr($s, 0, $j);
	}
	
	function utf8_new_encode(string $string): string 
	{
		$s = (string) $string;
		$len = \strlen($s);

		for ($i = 0, $j = 0; $i < $len; ++$i, ++$j) {
			switch ($s[$i] & "\xF0") {
				case "\xC0":
				case "\xD0":
					$c = (\ord($s[$i] & "\x1F") << 6) | \ord($s[++$i] & "\x3F");
					$s[$j] = $c < 256 ? \chr($c) : '?';
					break;

				case "\xF0":
					++$i;
					// no break

				case "\xE0":
					$s[$j] = '?';
					$i += 2;
					break;

				default:
					$s[$j] = $s[$i];
			}
		}

		return substr($s, 0, $j);
	}
	
	
	
	function contactSend($info)
	{
		$name = $info["name"];
		$mail = $info["mail"];
		$message = $info["message"];
		
		$recipient = "hvelez@incocrea.com";
			
		$email_subject ="Mensaje desde el sitio Web de Reparafull";
		$email_from = $mail;
		$email_message = 
		"<div style='text-align: center; margin: auto; width: 800px !important; background: #F0EDE8; border-radius: 5px;'>".
		$name." te envía el siguiente mensaje desde la plataforma: <br><br>".
		utf8_new_decode($message).
		"<br><br></div>";

		$headers = "From: " . $mail . "\r\n";
		$headers .= "Reply-To: ". $mail . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		// UNLOCK TO SEND
		mail ($recipient, utf8_new_decode($email_subject), utf8_new_decode($email_message), $headers);
		
		$resp["message"] = "sent";
		$resp["status"] = true;
		return $resp;
		
		
	}
	
	// DELETE PIC
	function picDelete($info)
	{
		$code = $info["code"];
		
		$destination_path = "../../../images/product/";
		$hasBG = file_exists($destination_path.$code.'.jpg');
		if($hasBG == true){unlink($destination_path.$code.'.jpg');}
		
		$str = "UPDATE products SET HP = '0' WHERE CODE = '".$code."'";
		$query = $this->db->query($str);
		
		$resp["message"] = $hasBG;
		$resp["status"] = true; 
		return $resp;
	}
	
	// GET REPORTS
	function getReport($info)
	{
		$repoType = $info["repoType"];
		$scode = $info["scode"];
		
		
		if($repoType == "homeList")
		{
			$where = "WHERE  SCODE = '$scode' ";
			
			$str = "SELECT *  FROM stores $where";
			$query = $this->db->query($str);
			
			$result = $query;
		}
		if($repoType == "infoCompany")
		{
			$where = "WHERE  SCODE = '$scode' ";
			
			$str = "SELECT *  FROM stores $where";
			$query = $this->db->query($str);
			
			$result = $query;
		}
		if($repoType == "productsList")
		{

			$repoCode = $info["repoCode"];
			$repoDesc = $info["repoDesc"];

			$where = "WHERE  CODE != 'null' ";

			if($repoCode != ""){$where .= "AND CODE LIKE'%$repoCode%'";} 
			if($repoDesc != ""){$where .= "AND DETAIL LIKE'%$repoDesc%'";} 
			
			$limit = 1000;
			
			$str = "SELECT CODE, MCODE, EXT, DETAIL, PRICE, CAT, HP, HP2, PROMO, HF, AVAILABLE, VISIBLE, LONDESC  FROM products $where AND SCODE = '".$scode."' ORDER BY MCODE ASC, EXT ASC, DETAIL ASC LIMIT $limit";
			$query = $this->db->query($str);
			
			$result = $query;
		}
		if($repoType == "catsList")
		{
			$where = "WHERE  CODE != 'null' ";

			$str = "SELECT *  FROM cats $where AND SCODE = '".$scode."' ORDER BY DETAIL ASC";
			$query = $this->db->query($str);
			
			$result = $query;
		}
		if($repoType == "rfList")
		{
			$where = "WHERE  CODE != 'null' ";
			
			$str = "SELECT * FROM exts $where AND SCODE = '".$scode."' ORDER BY DETAIL ASC";
			$query = $this->db->query($str);
			
			$result = $query;
		}
		if($repoType == "xtore")
		{
			$ucode = $info["ucode"];
			if($ucode != "53462f5c9bf653"){return;}
			
			$where = "WHERE  SCODE != 'null' ";
			
			$str = "SELECT SCODE, DOMAIN,  SNAME, CDATE, VDATE FROM stores $where ORDER BY SCODE ASC";
			$query = $this->db->query($str);
			
			$result = $query;
		}
		if($repoType == "clientList")
		{
			$where = "WHERE  SCODE != 'null' ";
			
			$str = "SELECT * FROM users WHERE SCODE = '$scode' AND  TYPE = '0' ORDER BY NAME ASC";
			$query = $this->db->query($str);
			
			$result = $query;
		}
		if($repoType == "zonesList")
		{
			$where = "WHERE  CODE != 'null' ";

			$str = "SELECT * FROM zones $where AND SCODE = '".$scode."' ORDER BY CODE ASC";
			$query = $this->db->query($str);
			
			$result = $query;
		}
		if($repoType == "payWayList")
		{
			$where = "WHERE  CODE != 'null' ";

			$str = "SELECT * FROM payway $where AND SCODE = '".$scode."' ORDER BY CODE ASC";
			$query = $this->db->query($str);
			
			$result = $query;
		}
		if($repoType == "ordersList")
		{
			$stype = $info["stype"];
			
			$repoUname = $info["repoUname"];
			$repoLocation = $info["repoLocation"];
			$repoIniDate = $info["repoIniDate"];
			$repoEndDate = $info["repoEndDate"];
			$repoStatus = $info["repoStatus"];
			
			$where = "WHERE  OCODE != 'null' ";
			
			if($repoUname != ""){$where .= "AND UNAME LIKE'%$repoUname%'";} 
			if($repoLocation != ""){$where .= "AND OLOCATION LIKE'%$repoLocation%'";} 
			if($repoIniDate != "")
			{
				$repoIniDate.= " 00:00:00";
				$where .= "AND DATE >= '$repoIniDate'";
			}  
			if($repoEndDate != "")
			{
				$repoEndDate.= " 23:59:59";
				$where .= "AND DATE <= '$repoEndDate'";
			}  
			if($repoStatus != ""){$where .= "AND STATE = '$repoStatus'";} 

			
			$str = "SELECT * FROM orders $where AND SCODE = '".$scode."' AND OTYPE = '".$stype." 'ORDER BY DATE DESC";
			$query = $this->db->query($str);
			
			$result = $query;
			
		}

		
		$resp["message"] = $result ;
		$resp["status"] = true;
		return $resp;
	}
	
	function deletePfile($info)
	{
		
		$code = $info["code"];
		$scode = $info["scode"];
		
		$destination_path = "../../pfiles/".$scode."-";
		$file_pattern = $destination_path.$code.".*";
		array_map( "unlink", glob( $file_pattern ));
		
		$str = "UPDATE products SET HF='0' WHERE CODE = '".$code."' AND SCODE = '".$scode."'"; 
		$query = $this->db->query($str);
		
		$ans = $file_pattern;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function deletePicFile($info)
	{
		
		$code = $info["code"];
		$delType = $info["pic"];
		$scode = $info["scode"];
		
		if($delType == "1")
		{
			$destination_path = "../../../images/product/".$scode."-".$code;
			$hasBG = file_exists($destination_path.'.jpg');
			if($hasBG == true){unlink($destination_path.'.jpg');}
			
			$str = "UPDATE products SET HP='0' WHERE CODE='".$code."'"; 
		}
		if($delType == "2")
		{
			$destination_path = "../../../images/product/".$scode."-".$code;
			$hasBG = file_exists($destination_path.'-b.jpg');
			if($hasBG == true){unlink($destination_path.'-b.jpg');}
			
			$str = "UPDATE products SET HP2='0' WHERE CODE='".$code."'"; 
		}

		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function toMD5($info)
	{
		$sign = md5($info["sign"]);
		
		$resp["message"] = $sign;
		$resp["status"] = true;
		return $resp;
	}
	// EXPORT CSV
	function exportList($info)
	{
			
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		$lang = $langFile["es_co"];
		

		$rNameT = utf8_new_decode($lang["rNameT"]);
		$rLNameT = utf8_new_decode($lang["rLNameT"]);
		$rNitT = utf8_new_decode($lang["rNitT"]);
		$rDVT = utf8_new_decode($lang["rDVT"]);
		$rPmT = utf8_new_decode($lang["rPmT"]);
		$rFPT = utf8_new_decode($lang["rFPT"]);
		$rGrsT = utf8_new_decode($lang["rGrsT"]);
		$rLawT = utf8_new_decode($lang["rLawT"]);
		$rDateT = utf8_new_decode($lang["rDateT"]);
		
		$repoType = $info["repoType"];
		$repoClient = $info["repoClient"];
		$repoIniDate = $info["repoIniDate"];
		$repoEndDate= $info["repoEndDate"];
		$repoFactState = $info["repoFactState"];
		
		if($repoType == "buystoryAll")
		{
				$where = "WHERE  CODE != 'null' ";

				if($repoClient != ""){$where .= "AND CNIT LIKE'%$repoClient%'";} 
				if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
				if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 
				if($repoFactState != ""){$where .= "AND STATE =  '$repoFactState' ";} 

				$str = "SELECT * FROM budgets $where ORDER BY CNAME ASC";
				$query = $this->db->query($str);
				
				$result = $query;
				
				$csvString = "No.;".$rNameT.";".$rLNameT.";".$rNitT.";".$rDVT.";".$rPmT.";".$rFPT.";".$rGrsT.";".$rLawT.";".$rDateT. "\n";
				for($i = 0; $i<count($result);$i++)
				{
					$x = $i+1;
					$a = utf8_new_decode(urldecode($result[$i]["CNAME"]));
					$b= utf8_new_decode(urldecode($result[$i]["CNIT"]));
					$c= utf8_new_decode(urldecode($result[$i]["DV"]));
					$d= utf8_new_decode(urldecode($result[$i]["PIN"]));
					$e= utf8_new_decode(urldecode(explode(" ",$result[$i]["PINDATE"])[0]));
					$z= utf8_new_decode(urldecode($result[$i]["CLASTNAME"]));
					
					$qty = str_replace(".", ",", $result[$i]["QTY"]);
					
					$f= utf8_new_decode(urldecode($qty));
					$y = "830";
					$g= utf8_new_decode(urldecode(explode(" ",$result[$i]["DATE"])[0]));

					$csvString .= "\"$x\";\"$a\";\"$z\";\"$b\";\"$c\";\"$d\";\"$e\";\"$f\";\"$y\";\"$g\" \n";
				}

				file_put_contents("../../report/reporte.csv", $csvString);
		}
		if($repoType == "buystoryAllfree")
		{
				$where = "WHERE  CODE != 'null' ";

				if($repoClient != ""){$where .= "AND CNIT LIKE'%$repoClient%'";} 
				if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
				if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 
				if($repoFactState != ""){$where .= "AND STATE =  '$repoFactState' ";} 

				$str = "SELECT * FROM budgets $where ORDER BY CNAME ASC";
				$query = $this->db->query($str);
				
				$result = $query;
				
				$csvString = "No.;".$rNameT.";".$rLNameT.";".$rNitT.";".$rDVT.";".$rGrsT.";".$rLawT.";".$rDateT. "\n";
				for($i = 0; $i<count($result);$i++)
				{
					$x = $i+1;
					$a = utf8_new_decode(urldecode($result[$i]["CNAME"]));
					$b= utf8_new_decode(urldecode($result[$i]["CNIT"]));
					$c= utf8_new_decode(urldecode($result[$i]["DV"]));
					// $d= utf8_new_decode(urldecode($result[$i]["PIN"]));
					// $e= utf8_new_decode(urldecode($result[$i]["PINDATE"]));
					$z= utf8_new_decode(urldecode($result[$i]["CLASTNAME"]));
					$qty = str_replace(".", ",", $result[$i]["QTY"]);
					
					$f= utf8_new_decode(urldecode($qty));
					$y = "830";
					$g= utf8_new_decode(urldecode(explode(" ",$result[$i]["DATE"])[0]));

					$csvString .= "\"$x\";\"$a\";\"$z\";\"$b\";\"$c\";\"$f\";\"$y\";\"$g\" \n";
				}

				file_put_contents("../../report/reportefundicion.csv", $csvString);
		}
		if($repoType == "buystoryGroup")
		{
				$where = "WHERE  CODE != 'null' ";

				if($repoClient != ""){$where .= "AND CNIT LIKE'%$repoClient%'";} 
				if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
				if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 
				if($repoFactState != ""){$where .= "AND STATE =  '$repoFactState' ";} 
				
				$str = "SELECT SUM(QTY), budgets.* FROM budgets $where GROUP BY CNAME ORDER BY CNAME ASC";
				$query = $this->db->query($str);
				
				$result = $query;
		}
		
		
		$resp["message"] = $result ;
		$resp["status"] = true;
		return $resp;
	}

	//REPARAFULL END -------------------------
}

?>
