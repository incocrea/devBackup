<?php
date_default_timezone_set('America/Bogota');
// require('../fpdf/mc_table.php');

class users
{

	function __construct()
	{
		$this->db = new sql_query();
	}
	function login($info)
	{
	
		$str = "SELECT * FROM users WHERE users.EMAIL = '".$info["autor"]."' AND users.PASSWD = '".md5($info["pssw"])."' AND users.TYPE = '2'";
		$query = $this->db->query($str);	

		if(count($query) > 0)
		{
			
			if($query[0]["STATUS"] == "0")
			{
				$resp["message"] = "Disabled";
				$resp["status"] = true;
				return $resp;
			}

			if($info["autor"] == "hvelez@incocrea.com")
			{
				$query[0]["logued"] = "2";
			}
			else
			{
				$query[0]["logued"] = "1";
			}
			
			
			$resp["message"] = $query[0];
			$resp["status"] = true;
			
			$info["ucode"] = $query[0]["UCODE"];
			$info["mt"] = '1';
			
			// ------------------LOGSAVE-----------------
				$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------

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
		$str = "SELECT * FROM	users WHERE users.UCODE = '$code' ";
		$query = $this->db->query($str);
		
		if($code  == "8e725bed8cb9e5f6b1079c1fa5eea939")
		{
			$query[0]["logued"] = "2";
		}
		else
		{
			$query[0]["logued"] = "1";
		}
		
		$resp["message"] = $query[0];
		$resp["status"] = true;
		return $resp;
	}
	function mailExist($info)
	{
		$str = "SELECT MAIL, CODE FROM users WHERE users.MAIL = '".$info["mail"]."' AND TYPE = '".$info["type"]."'";
		$query = $this->db->query($str);

		if(count($query) > 0)
		{

			$language = $info["lang"];
			$langFile = parse_ini_file("../../lang/lang.ini", true);
			
			$header = $langFile[$language]["recHeader"];
			$message = $langFile[$language]["recMessage"];
			$recLink = $langFile[$language]["recLink"];

			$userEmail = $info["mail"];
			$userType = $info["type"];
			$tmpkey = $query[0]["CODE"];
			
			$email_subject = $header;
			$email_from = 'recuperación@laplazuela.com';
			$email_message = 
			"<div style='text-align: center; margin: auto; width: 800px !important; background: #F0EDE8; border-radius: 15px;'>".
			"<img src='http://incocrea.com/gold/irsc/pasRecHeader-".$language.".png' style='width=100% !important;'/>".
			"<br><br>".
			"<span style='font-size:14px; '>".utf8_decode($message)."</span>".
			"<br>".
			"<span style='font-size:14px; font-weight: bold;'>"."<a href='http://incocrea.com/gold/?me=".$userEmail."&tmpkey=".$tmpkey."&lang=".$language."&type=".$userType." '>".htmlentities($recLink)."</a>"."</span>".
			"<br><br>".
			"<img src='http://incocrea.com/gold/irsc/footer-".$language.".png' style='width=100% !important;'/>".
			"</div>";
			
			$headers = "From: " . $email_from . "\r\n";
			$headers .= "Reply-To: ". $email_from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			mail ($userEmail, $email_subject, $email_message, $headers);
						
			$resp["message"] = "sent";
			$resp["status"] = true;
		}
		else
		{
			$resp["message"] = "notsent";
			$resp["status"] = false;
		}
		return $resp;
	}
	function register($info)
	{
		$str = "SELECT EMAIL FROM users WHERE users.EMAIL = '".$info["mail"]."'";
		$query = $this->db->query($str);
	
		$isreging = $info["isreging"];
		
		if(count($query) > 0 )
		{
			
			if($isreging == "1")
			{
				$resp["message"] = "exists";
				return $resp;
			}

			if(!isset($info["passChanged"]))
			{
				return $resp;
			}
			
			$NAME = str_replace("'","\\'", $info["name"]);
			$EMAIL = $info["mail"];
			$COUNTRY = str_replace("'","\\'", $info["country"]);
			$DPTO = str_replace("'","\\'", $info["dpto"]);
			$CITY = str_replace("'","\\'", $info["city"]);
			$ADDRESS = str_replace("'","\\'", $info["address"]);
			$PHONE = $info["phone"];
			$SEX = $info["sex"];
			$BDAY = $info["bday"];

			if($info["passChanged"] == "1")
			{
				$PASSWD = md5($info["pass"]);
			}
			else
			{
				$PASSWD = $info["pass"];
			}
			
			
			$str = "UPDATE users SET NAME='".$NAME."', COUNTRY='".$COUNTRY."', DPTO='".$DPTO."', CITY='".$CITY."', ADDRESS='".$ADDRESS."', PHONE='".$PHONE."',  PASSWD='".$PASSWD."', SEX = '".$SEX."', BDAY = '".$BDAY."' WHERE EMAIL='".$EMAIL."'"; 
			$query = $this->db->query($str);
			
			$resp["status"] = false;
			
		}
		else
		{
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			
			
			
			$UCODE = md5($info["mail"].$now);
			$NAME = str_replace("'","\\'", $info["name"]);
			$EMAIL = $info["mail"];
			$COUNTRY = str_replace("'","\\'", $info["country"]);
			$DPTO = str_replace("'","\\'", $info["dpto"]);
			$CITY = str_replace("'","\\'", $info["city"]);
			$ADDRESS = str_replace("'","\\'", $info["address"]);
			$PHONE = $info["phone"];
			$PASSWD = md5($info["pass"]);
			$SEX = $info["sex"];
			$BDAY = $info["bday"];
			$TYPE = '1';
			$STATUS = '1';
			$REGDATE = $now;
			
			// $resp["message"] = "hola";
			// $resp["status"] = true;
			// return $resp;
			
			$actualLang = $info["lang"];
			
			$str = "INSERT INTO users (UCODE, NAME, EMAIL, COUNTRY, DPTO, CITY, ADDRESS, PHONE, PASSWD, TYPE, STATUS, REGDATE, SEX, BDAY) VALUES ('".$UCODE."','".$NAME."','".$EMAIL."','".$COUNTRY."','".$DPTO."','".$CITY."','".$ADDRESS."','".$PHONE."','".$PASSWD."','".$TYPE."','".$STATUS."','".$REGDATE."','".$SEX."','".$BDAY."')";
			$query = $this->db->query($str);
			
			$resp["message"] = "created";
			$resp["status"] = true;
			
			$info["ucode"] = $UCODE;
			$info["mt"] = '0';
			
			// ------------------LOGSAVE-----------------
				$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
	}
	function getUdata($info)
	{
		$ucode = $info["ucode"];
		$str = "SELECT * FROM users WHERE users.UCODE = '".$ucode."'";
		$query = $this->db->query($str);	
		
		if(count($query) > 0)
		{
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
	function ppicsave($info)
	{
		
		$pic =  $info["pic"];
		$ucode = $info["ucode"];
		
		$destination_path = "../../ppics/";
		
		
		
		if($pic != "")
		{
			$hasBG = file_exists($destination_path.$ucode.'.jpg');
			if($hasBG == true){unlink($destination_path.$ucode.'.jpg');}
			
			list($type, $pic) = explode(';', $pic);
			list(, $pic)      = explode(',', $pic);
			$pic = base64_decode($pic);
			file_put_contents($destination_path.$ucode.'.jpg', $pic);
		}
	}
	function getCList($info)
	{
                
		$serie = $info["fSerie"];
		$fType = $info["fType"];
		$fCode = $info["fCode"];
		$fDetail = $info["fDetail"];
		$fState = $info["fState"];
		$expo = $info["expo"];

		if($info["index"] != ""){$index = $info["index"];}else{$index = 'SERIE';}
		
		$where = "WHERE CODE != '' ";

		if($serie != "")
		{
			$where .= "AND  SERIE LIKE '%$serie%'";
		}
		if($fType != "")
		{
			$where .= "AND  TYPE LIKE '%$fType%'";
		}
		if($fCode != "")
		{
			$where .= "AND  CODE LIKE '%$fCode%'";
		}
		if($fDetail != "")
		{
			$where .= "AND  DETAIL LIKE '%$fDetail%'";
		}
		if($fState != "")
		{
			$where .= "AND  STATUS = '$fState'";
		}
                
		$str = "SELECT *  FROM stickers $where ORDER BY $index DESC";
		$query = $this->db->query($str);
	
		if(count($query) > 0)
		{
				$resp["message"] = $query;
				$resp["status"] = true;
		}
		else
		{
				$resp["message"] = array();
				$resp["status"] = true;
		}
		
		$resp["expo"] = $expo ;
		
		
		if($expo == 1)
		{
			
			$langFile = parse_ini_file("../../lang/lang.ini", true);
			$lang = $langFile["es_co"];
			
			$eCode = utf8_decode($lang["eCode"]);
			$eTipo = utf8_decode($lang["eTipo"]);
			$eDetail = utf8_decode($lang["eDetail"]);
			$eValue = utf8_decode($lang["eValue"]);
			
			$result = $query;
				
			$csvString = $eCode.";".$eTipo.";".$eDetail.";".$eValue. "\n";
			for($i = 0; $i<count($result);$i++)
			{
				$a = $result[$i]["SERIE"]."-".$result[$i]["CODE"];
				$b= utf8_decode(urldecode($result[$i]["TYPE"]));
				$c= utf8_decode(urldecode($result[$i]["DETAIL"]));
				$d= utf8_decode(urldecode($result[$i]["AMOUNT"]));

				$csvString .= "\"$a\";\"$b\";\"$c\";\"$d\" \n";
			}

			file_put_contents("../../lsts/listado.csv", $csvString);

		}

		return $resp;
	
	}
	function usersGetXls($info)
	{
		
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		$lang = $langFile["es_co"];
		
		$name = "Nombre";
		$email = "Email";
		$city = "Ciudad";
		$phone = utf8_decode("Teléfono");
		$type = "Tipo";
		$regdate = "Fecha registro";
		$premium = "Premium";
		$vecpremium = "Vencimiento premium";
		
		$csvString = $name.";".$email.";".$city.";".$phone.";".$type.";".$regdate.";".$premium.";".$vecpremium.";". "\n";
		
		$str = "SELECT NAME, EMAIL, CITY, PHONE, TYPE, REGDATE, PREMIUM, PRENDATE  FROM users ORDER BY REGDATE DESC";
		$query = $this->db->query($str);
		
		
		$result = $query;
		
		for($i = 0; $i<count($result);$i++)
		{
			$a = utf8_decode(urldecode($result[$i]["NAME"]));
			$b = utf8_decode(urldecode($result[$i]["EMAIL"]));
			$c = utf8_decode(urldecode($result[$i]["CITY"]));
			$d = utf8_decode(urldecode($result[$i]["PHONE"]));
			$e = utf8_decode(urldecode($result[$i]["TYPE"]));
			$f = utf8_decode(urldecode($result[$i]["REGDATE"]));
			$g = utf8_decode(urldecode($result[$i]["PREMIUM"]));
			$h = utf8_decode(urldecode($result[$i]["PRENDATE"]));

			$csvString .= "\"$a\";\"$b\";\"$c\";\"$d\";\"$e\";\"$f\";\"$g\";\"$h\" \n";
		}

		file_put_contents("../../lsts/users.csv", $csvString);
		
		// $ans = $query;
		$ans = "done";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function starter($info) 
	{
		
		$ans = array();
		
		$str = "SELECT *  FROM products ORDER BY POS ASC";
		$query = $this->db->query($str);
		
		$ans["products"] = $query;
		
		$str = "SELECT *  FROM hfame ORDER BY SNAME";
		$query = $this->db->query($str);
		
		$ans["sites"] = $query;
		
		$str = "SELECT *  FROM users ORDER BY REGDATE DESC";
		$query = $this->db->query($str);
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		for($i=0;$i<count($query);$i++)
		{
			$itemEndDate = $query[$i]["PRENDATE"];
			
			if($itemEndDate < $now)
			{
				$str = "UPDATE users SET PREMIUM = '0' WHERE UCODE ='".$query[$i]["UCODE"]."'";
				$setPr = $this->db->query($str);
				$query[$i]["PREMIUM"] = "0";
			}

		}
		
	
		$ans["users"] = $query;
		
		$str = "SELECT *  FROM tns WHERE TYPE = '3' OR TYPE = '4' ORDER BY DATE DESC";
		$query = $this->db->query($str);
		
		$ans["tns"] = $query;
		
		$str = "SELECT *  FROM promos ORDER BY EDATE DESC";
		$query = $this->db->query($str);
		
		$ans["promos"] = $query;
		
		$str = "SELECT *  FROM services ORDER BY DETAIL DESC";
		$query = $this->db->query($str);
		
		$ans["services"] = $query;
		
		$str = "SELECT *  FROM cinst ";
		$query = $this->db->query($str);
		
		$ans["inst"] = $query[0]["INSTR"];
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
		
		
	}
	function savePromo($info)
	{		
		$action = $info["action"];
		$name = $info["name"];
		$detail = $info["detail"];
		$sdate = $info["sdate"];
		$edate = $info["edate"];
		$text = $info["text"];
		$pcode = $info["pcode"];
		
		if($action == "Crear")
		{
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			
			$pcode = md5($name.$now);
			
			$str = "INSERT INTO promos (PCODE, NAME, DETAIL, SDATE, EDATE, CONDS) VALUES ('".$pcode."','".$name."','".$detail."','".$sdate."','".$edate."','".$text."')";
			$query = $this->db->query($str);
			
			$ans = "created";
			
			
		}
		else if($action == "Guardar")
		{
			
			$str = "UPDATE promos SET NAME = '$name', DETAIL = '$detail', SDATE = '$sdate', EDATE = '$edate', CONDS = '$text' WHERE PCODE = '$pcode'";
			$query = $this->db->query($str);
			
			$ans = "updated";
		}

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveService($info)
	{		
		$action = $info["action"];
		$detail = $info["detail"];
		$duration = $info["duration"];
		$cost = $info["cost"];
		$give = $info["give"];
		$eScode = $info["eServiceCode"];
		
		if($action == "Crear")
		{
			$str = "INSERT INTO services (DETAIL, MINUTES, COST, GIVE) VALUES ('".$detail."','".$duration."', '".$cost."', '".$give."')";
			$query = $this->db->query($str);
			$ans = "created";
		}
		else if($action == "Guardar")
		{
			
			$str = "UPDATE services SET DETAIL = '$detail', MINUTES = '$duration', COST = '$cost', GIVE = '$give' WHERE SRCODE = '$eScode'";
			$query = $this->db->query($str);
			
			$ans = "updated";
		}

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getPList($info)
	{
		$str = "SELECT *  FROM products ORDER BY POS ASC";
		$query = $this->db->query($str);
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	
	}
	function getPromoList($info)
	{
		$str = "SELECT *  FROM promos ORDER BY EDATE DESC";
		$query = $this->db->query($str);
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	
	}
	function getServicesList($info)
	{
		$str = "SELECT *  FROM services ORDER BY DETAIL ASC";
		$query = $this->db->query($str);
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	
	}
	function getUList($info)
	{
		$str = "SELECT *  FROM users ORDER BY REGDATE DESC";
		$query = $this->db->query($str);
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	
	}
	function getSList($info)
	{
		$str = "SELECT *  FROM hfame ORDER BY SNAME";
		$query = $this->db->query($str);
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	
	}
	function activateCourse($info)
	{
		
		$users = $info["users"];
		$course = $info["course"];
		
		$str = "SELECT PNAME, PRICE, TYPE, DETAIL FROM products WHERE CODE = '".$course."'";
		$cinfo = $this->db->query($str);	
		
		$DETAIL = $cinfo[0]["PNAME"];
		$VALUE =  intval($cinfo[0]["PRICE"]);
		$PTYPE =  $cinfo[0]["TYPE"];
		$PDETAIL =  $cinfo[0]["DETAIL"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		for($i=0; $i<count($users); $i++)
		{
			$user = $users[$i];
			
			$TCODE = md5($now.$user);
			$UCODE = $user;
			$TYPE = "3";
			$STATE = "1";
			$PCODE = $course;
			
			$str = "INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE, STATE) VALUES ('".$TCODE."', '".$UCODE."','".$TYPE."' ,'".$VALUE."' ,'".$DETAIL."', '".$now."', '".$PCODE."', '".$STATE."')";
			$query = $this->db->query($str);

		}

		$ans = $cinfo;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function setPrDate($info)
	{
		
		$ucode = $info["ucode"];
		$newDate = $info["newDate"];
		$state = $info["state"];
		
		$str = "UPDATE users SET PRENDATE='".$newDate."', PREMIUM='".$state."' WHERE UCODE='".$ucode."'"; 
		$query = $this->db->query($str);
		
		$ans = "done";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getRanking($info)
	{
		
		$pcode = $info["pcode"];
		$str = "SELECT tns.UCODE, VALUE, SUM(VALUE) AS SCORE, tns.STATE, users.NAME, users.CITY FROM tns INNER JOIN users ON users.UCODE = tns.UCODE WHERE PCODE LIKE '%".$pcode."%' GROUP BY UCODE ORDER BY SCORE DESC";
		$query = $this->db->query($str);	
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getExList($info)
	{
		$str = "SELECT *  FROM tns WHERE TYPE = '3' OR TYPE = '4' ORDER BY DATE DESC";
		$query = $this->db->query($str);
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	
	}
	function setTns($info)
	{
		$pass =  $info["pass"];
		$ucode = $info["ucode"];
		$op = $info["op"];
		$tnscode = $info["tnscode"];
		
		$str = "SELECT PASSWD  FROM users WHERE UCODE = '$ucode'";
		$query = $this->db->query($str);
		
		$apss = $query[0]["PASSWD"];
		
		if(md5($pass) != $apss)
		{
			$ans = "bk";
			$resp["message"] = $ans;
			$resp["status"] = true;
			return $resp;
		}
		else
		{
			$ans = "ok";
						
		}
		
		if($op == "1")
		{
			$str = "UPDATE tns SET STATE = '4' WHERE TCODE = '$tnscode'";
			$query = $this->db->query($str);
			
			$ans = "ok";
		}
		if($op == "0")
		{
			$str = "DELETE FROM tns WHERE TCODE = '$tnscode'";
			$query = $this->db->query($str);
			
			$ans = "ok";
		}
	
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function generateSerie($info)
	{
		
		$sType = $info["sType"];
		$sDetail = $info["sDetail"];
		$sValue = $info["sValue"];
		$sQty = intval($info["sQty"]);
		$pCode = $info["pCode"];
		
		if($sType == "CR")
		{
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			
			$serie = "0";
			
			$str = "SELECT UCODE FROM users WHERE EMAIL = '$sDetail' ";
			$query = $this->db->query($str);
			
			
			if(count($query)>0)
			{
				$TCODE = md5($info["sType"].$now);

				$TYPE = "5";
				$UCODE = $query[0]["UCODE"];
				$VALUE = $sValue;
				$DETAIL = "Bono Regalo a ".$sDetail;
				$DATE = $now;
				$PCODE = "-";
				$STATE = "5";
				
				$str = "INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE, STATE) VALUES ('".$TCODE."','".$UCODE."','".$TYPE."','".$VALUE."','".$DETAIL."','".$DATE."','".$PCODE."','".$STATE."')";
				$query = $this->db->query($str);

				$resp["message"] = "";
				$resp["status"] = true;
				return $resp;
			}
			else
			{
				$resp["message"] = "NF";
				$resp["status"] = true;
				return $resp;
			}
			
			
			
		}
		else
		{
			$str = "SELECT SERIE FROM stickers GROUP BY SERIE ORDER BY SERIE DESC ";
			$scount = $this->db->query($str);
			
			if(count($scount) > 0)
			{
				$serie = $scount[0]["SERIE"]+1;
			}
			else
			{
				$serie = 1;
			}
			
			
			$list = $this->genCode(6, $sQty, $serie);
			
			for ($c = 0; $c < count($list); $c++) 
			{
				$code = $list[$c];
				
				$str = "INSERT INTO stickers (SERIE, CODE, AMOUNT, TYPE, DETAIL, PCODE) VALUES ('".$serie."', '".$code."', '".$sValue."', '".$sType."', '".$sDetail."', '".$pCode."')";
				$query = $this->db->query($str);
			}

			$resp["message"] = $serie;
			$resp["status"] = true;
			return $resp;
		}
		
	}
	function generateProduct($info)
	{
		
		$pName = $info["pName"];
		$pDetail = $info["pDetail"];
		$pType = $info["pType"];
		$pValue = $info["pValue"];
		$pQty = intval($info["pQty"]);
		$pLink = $info["pLink"];
		$pPlace = $info["pPlace"];
		$action = $info["action"];
		
		
		if($action == "c")
		{
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			
			$code = md5($pDetail.$now);
			
			$str = "INSERT INTO products (CODE, PNAME, DETAIL, TYPE, PRICE, AVAILABLE, LINK, POS) VALUES ('".$code."', '".$pName."','".$pDetail."', '".$pType."', '".$pValue."', '".$pQty."', '".$pLink."', '".$pPlace."')";
			$query = $this->db->query($str);
		}
		else
		{
			
			$eCode = $info["eCode"];
			
			$str = "UPDATE products SET PNAME = '$pName', DETAIL = '$pDetail', TYPE = '$pType', PRICE = '$pValue', AVAILABLE = '$pQty', POS = '$pPlace', LINK = '$pLink' WHERE CODE = '$eCode'";
			$query = $this->db->query($str);
			
		}

		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	}
	function generateSite($info)
	{
		
		$sName = $info["sName"];
		$sType = $info["sType"];
		$sLoc = $info["sLoc"];
		$sAddress = $info["sAddress"];
		$sPhone = $info["sPhone"];
		$sMail = $info["sMail"];
		$sDesc = $info["sDesc"];
		$sEndate = $info["sEndate"];
		$action = $info["action"];
		
		if($action == "c")
		{
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			
			$code = md5($sName.$now);
			
			$str = "INSERT INTO hfame (SCODE, SNAME, STYPE, DETAIL, ADDRESS, PHONE, EMAIL, LOCATION, ENDATE) VALUES ('".$code."', '".$sName."', '".$sType."', '".$sDesc."', '".$sAddress."', '".$sPhone."', '".$sMail."', '".$sLoc."', '$sEndate')";
			$query = $this->db->query($str);
		}
		else
		{
			
			$eCode = $info["eCode"];
			
			$str = "UPDATE hfame SET SNAME = '$sName', STYPE = '$sType', DETAIL = '$sDesc', ADDRESS = '$sAddress', PHONE = '$sPhone', EMAIL = '$sMail', LOCATION = '$sLoc', ENDATE = '$sEndate'  WHERE SCODE = '$eCode'";
			$query = $this->db->query($str);
			
		}

		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	}
	function genCode($length, $qty, $serie)
	{

		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		
		$list = array();
		
		for ($k = 0; $k < $qty; $k++) 
		{
			$randomString = '';
			for ($i = 0; $i < $length; $i++) 
			{
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			$list[$k] = $randomString;
			
		}

		return $list;

	}
	function stater($info)
	{

		$serie = $info["serie"];
		$code = $info["code"];
		$nactual = $info["nactual"];
		
		$str = "UPDATE stickers SET STATUS = $nactual WHERE SERIE = '$serie' AND CODE = '$code'";
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
	function staterPromo($info)
	{

		$code = $info["code"];
		$nactual = $info["nactual"];
		
		$str = "UPDATE promos SET ACTIVE = '0'";
		$query = $this->db->query($str);
		
		$str = "UPDATE promos SET ACTIVE = $nactual WHERE PCODE = '$code'";
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
	function instSave($info)
	{

		$text = $info["text"];
		
		$str = "UPDATE cinst SET INSTR = '$text' WHERE CODE = '1'";
		$query = $this->db->query($str);
		
		$resp["message"] = "saved";
		$resp["status"] = true;
		return $resp;
		
	}
	function staterSkill($info)
	{

		$skill = $info["skill"];
		$code = $info["code"];
		$nactual = $info["nactual"];
		
		$str = "UPDATE hfame SET $skill = $nactual WHERE SCODE = '$code'";
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
	
	// SAVE PIC
	function picsave($info)
	{
		
		$pic =  $info["pic"];
		$code = $info["code"];
		$scode = $info["scode"];
		$picType = $info["picType"];
		
		if($picType == "site")
		{
			$destination_path = "../../img/sites/".$code;
			$str = "UPDATE hfame SET SHP = '1' WHERE SCODE = '".$code."'";
			$query = $this->db->query($str);
		}
		if($picType == "product")
		{
			$destination_path = "../../img/products/".$code;
			$str = "UPDATE products SET HP = '1' WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
		}
		if($picType == "promo")
		{
			$destination_path = "../../img/prpics/".$code;
			$str = "UPDATE promos SET HP = '1' WHERE PCODE = '".$code."'";
			$query = $this->db->query($str);
		}
		if($picType == "service")
		{
			$destination_path = "../../img/spics/".$code;
			$str = "UPDATE services SET HP = '1' WHERE SRCODE = '".$code."'";
			$query = $this->db->query($str);
		}
		

		if($pic != "")
		{
			$hasBG = file_exists($destination_path.'.jpg');
			if($hasBG == true){unlink($destination_path.'.jpg');}
			
			list($type, $pic) = explode(';', $pic);
			list(, $pic)      = explode(',', $pic);
			$imageStr  = base64_decode($pic);
			
			$image = imagecreatefromstring($imageStr);
			imagejpeg($image, $destination_path.'.jpg');
		}
		
		$resp["message"] = "done";
		$resp["status"] = true; 
		return $resp;
	}
	
	
	
	// DELETER
	function regDelete($info)
	{
		$table = $info["table"];
		$code = $info["code"];
		$delType = $info["delType"];
		$ucode = $info["ucode"];
		
		if($delType == "sticker")
		{
				
				$serie = explode("-", $code)[0];
				$code = explode("-", $code)[1];
				
				$str = "DELETE FROM $table WHERE $table.CODE = '".$code ."' AND $table.SERIE = '".$serie ."'";
				$query = $this->db->query($str);
				
				$info["ucode"] = $ucode;
				$info["mt"] = '2';
				
				// ------------------LOGSAVE-----------------
					$logSave = $this->logw($info);
				// ------------------LOGSAVE-----------------
		}
		if($delType == "site")
		{
				
				$str = "DELETE FROM $table WHERE $table.SCODE = '".$code ."'";
				$query = $this->db->query($str);
				
				$info["ucode"] = $ucode;
				$info["mt"] = '2';
				
				// ------------------LOGSAVE-----------------
					$logSave = $this->logw($info);
				// ------------------LOGSAVE-----------------
		}
		if($delType == "product")
		{
				
				$str = "DELETE FROM $table WHERE $table.CODE = '".$code ."'";
				$query = $this->db->query($str);
				
				$info["ucode"] = $ucode;
				$info["mt"] = '2';
				
				// ------------------LOGSAVE-----------------
					$logSave = $this->logw($info);
				// ------------------LOGSAVE-----------------
		}
		if($delType == "user")
		{
				$str = "SELECT PHONE FROM $table WHERE $table.UCODE = '".$code ."'";
				$query = $this->db->query($str);
				$phone = $query[0]["PHONE"];
				
				
				$str = "DELETE FROM $table WHERE $table.UCODE = '".$code ."'";
				$query = $this->db->query($str);
				
				$str = "DELETE FROM movements WHERE UPHONE = '".$phone ."'";
				$query = $this->db->query($str);
				
				
				$info["ucode"] = $ucode;
				$info["mt"] = '2';
				
				$str = "DELETE FROM tns WHERE UCODE = '".$code ."'";
				$query = $this->db->query($str);
				
				
				// ------------------LOGSAVE-----------------
					$logSave = $this->logw($info);
				// ------------------LOGSAVE-----------------
		}
		if($delType == "promo")
		{
				
				$str = "DELETE FROM $table WHERE $table.PCODE = '".$code ."'";
				$query = $this->db->query($str);
				
				$info["ucode"] = $ucode;
				$info["mt"] = '2';
				
				// ------------------LOGSAVE-----------------
					$logSave = $this->logw($info);
				// ------------------LOGSAVE-----------------
		}


		$resp["message"] = "deleted";
		$resp["status"] = true;
		return $resp;
	}
	function codeCheck($info)
	{
		
		$code = $info["code"];

		$serie = explode("-", $code)[0];
		$code = explode("-", $code)[1];
		
		$str = "SELECT * FROM stickers WHERE SERIE = '".$serie ."' AND CODE = '".$code ."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$resp["founded"] = true;
			$resp["message"] = $query[0];
			$resp["status"] = true;
			return $resp;
		}
		else
		{
			$resp["founded"] = false;
		}

		$resp["message"] = "ne";
		$resp["status"] = true;
		return $resp;
	}
	function markCode($info)
	{
		
		$code = $info["code"];

		$serie = explode("-", $code)[0];
		$code = explode("-", $code)[1];
		
		$str = "SELECT * FROM stickers WHERE SERIE = '".$serie."' AND CODE = '".$code."'";
		$query = $this->db->query($str);	
		
		if($query [0]["STATUS"] == "2")
		{
			$resp["message"] = true;
		}
		else
		{
			
			$str = "UPDATE stickers SET STATUS = '2' WHERE SERIE = '".$serie."' AND CODE = '".$code."'";
			$query = $this->db->query($str);

			$resp["message"] = false;
		}

		return $resp;
	}
	function exportList($info)
	{
			
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		$lang = $langFile["es_co"];
		
		$rNameT = utf8_decode($lang["rNameT"]);
		$rLNameT = utf8_decode($lang["rLNameT"]);
		$rNitT = utf8_decode($lang["rNitT"]);
		$rDVT = utf8_decode($lang["rDVT"]);
		$rPmT = utf8_decode($lang["rPmT"]);
		$rFPT = utf8_decode($lang["rFPT"]);
		$rGrsT = utf8_decode($lang["rGrsT"]);
		$rLawT = utf8_decode($lang["rLawT"]);
		$rDateT = utf8_decode($lang["rDateT"]);
		
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
					$a = utf8_decode(urldecode($result[$i]["CNAME"]));
					$b= utf8_decode(urldecode($result[$i]["CNIT"]));
					$c= utf8_decode(urldecode($result[$i]["DV"]));
					$d= utf8_decode(urldecode($result[$i]["PIN"]));
					$e= utf8_decode(urldecode(explode(" ",$result[$i]["PINDATE"])[0]));
					$z= utf8_decode(urldecode($result[$i]["CLASTNAME"]));
					
					$qty = str_replace(".", ",", $result[$i]["QTY"]);
					
					$f= utf8_decode(urldecode($qty));
					$y = "830";
					$g= utf8_decode(urldecode(explode(" ",$result[$i]["DATE"])[0]));

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
					$a = utf8_decode(urldecode($result[$i]["CNAME"]));
					$b= utf8_decode(urldecode($result[$i]["CNIT"]));
					$c= utf8_decode(urldecode($result[$i]["DV"]));
					// $d= utf8_decode(urldecode($result[$i]["PIN"]));
					// $e= utf8_decode(urldecode($result[$i]["PINDATE"]));
					$z= utf8_decode(urldecode($result[$i]["CLASTNAME"]));
					$qty = str_replace(".", ",", $result[$i]["QTY"]);
					
					$f= utf8_decode(urldecode($qty));
					$y = "830";
					$g= utf8_decode(urldecode(explode(" ",$result[$i]["DATE"])[0]));

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
	
	
}

?>
