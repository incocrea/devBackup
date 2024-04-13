 <?php
date_default_timezone_set('America/Bogota');
// require('../fpdf/mc_table.php');
require('../phpExcel/Classes/PHPExcel.php');

class users
{

	function __construct()
	{
		$this->db = new sql_query();
	}
	function login($info)
	{
	
		$str = "SELECT * FROM users WHERE users.EMAIL = '".$info["autor"]."' AND users.PASSWD = '".md5($info["pssw"])."'";
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
			
			$code = $query[0]["UCODE"];
			
			$str = "SELECT * FROM pros WHERE pros.UCODE = '$code' ";
			$pros = $this->db->query($str);
			$query[0]["PROS"] = $pros;
			
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
		
		$str = "SELECT * FROM pros WHERE pros.UCODE = '$code' ";
		$pros = $this->db->query($str);
		$query[0]["PROS"] = $pros;
		
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
	function getProsList($info)
	{
		
		$ucode = $info["ucode"];
		
		$str = "SELECT * FROM pros WHERE UCODE = '".$ucode."'";
		$query = $this->db->query($str);
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function mailExist($info)
	{
		$str = "SELECT users.EMAIL, users.UCODE FROM users WHERE users.EMAIL = '".$info["mail"]."'";
		$query = $this->db->query($str);

		if(count($query) > 0)
		{

			$language = $info["lang"];
			
			$langFile = parse_ini_file("../../lang/lang.ini", true);
			
			$header = $langFile[$language]["recHeader"];
			$message = $langFile[$language]["recMessage"];
			$recLink = $langFile[$language]["recLink"];

			$resp["message"] = "";
			$resp["status"] = true;
			
			$userEmail = $info["mail"];
			$tmpkey = $query[0]["UCODE"];
			
			$email_subject = $header;
			$email_from = 'info@brazilcocoa.com';
			$email_message = 
			"<div style='text-align: center; margin: auto; width: 800px !important; background: #F0EDE8; border-radius: 15px;'>".
			"<img src='http://www.brazilcocoa.com/app/irsc/mailRes/hPassRec-".$language.".png' style='width=100% !important;'/>".
			"<br><br>".
			"<span style='font-size:14px; '>".$message."</span>".
			"<br>".
			"<span style='font-size:14px; font-weight: bold;'>"."<a href='http://www.brazilcocoa.com/pssRec.php?method=pssRec&me=".$userEmail."&tmpkey=".$tmpkey."&lang=".$language."'>".$recLink."</a>"."</span>".
			"<br><br>".
			"<img src='http://www.brazilcocoa.com/app/irsc/mailRes/footer-".$language.".png' style='width=100% !important;'/>".
			"</div>";
			
			$headers = "From: " . $email_from . "\r\n";
			$headers .= "Reply-To: ". $email_from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			mail ($userEmail, htmlEntities($email_subject), utf8_decode($email_message), $headers);
		}
		else
		{
			$resp["message"] = "";
			$resp["status"] = false;
		}
		return $resp;
	}
	function register($info)
	{
		$str = "SELECT EMAIL FROM users WHERE users.EMAIL = '".$info["mail"]."'";
		$query = $this->db->query($str);
		
		$language = "es_co";
		$langFile = parse_ini_file("../../lang/lang.ini", true);
				
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
			$UTYPE = $info["btype"];

			if($info["passChanged"] == "1")
			{
				$PASSWD = md5($info["pass"]);
			}
			else
			{
				$PASSWD = $info["pass"];
			}
			
			$str = "UPDATE users SET NAME='".$NAME."', COUNTRY='".$COUNTRY."', DPTO='".$DPTO."', CITY='".$CITY."', ADDRESS='".$ADDRESS."', PHONE='".$PHONE."',  PASSWD='".$PASSWD."', SEX = '".$SEX."', BDAY = '".$BDAY."', UTYPE = '".$UTYPE."' WHERE EMAIL='".$EMAIL."'"; 
			$query = $this->db->query($str);
			
			$resp["status"] = false;
			
		}
		else
		{
			
			$str = "SELECT PHONE FROM users WHERE users.PHONE = '".$info["phone"]."'";
			$query = $this->db->query($str);
			
			if(count($query) > 0 )
			{
				$resp["message"] = "existP";
				return $resp;
			}
			
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
			$UTYPE = $info["btype"];
			$TYPE = '1';
			$STATUS = '1';
			$REGDATE = $now;
			
			
			
			// $resp["message"] = "hola";
			// $resp["status"] = true;
			// return $resp;
			
			$actualLang = $info["lang"];
			
			$str = "INSERT INTO users (UCODE, NAME, EMAIL, COUNTRY, DPTO, CITY, ADDRESS, PHONE, PASSWD, TYPE, STATUS, REGDATE, SEX, BDAY, UTYPE, PRENDATE) VALUES ('".$UCODE."','".$NAME."','".$EMAIL."','".$COUNTRY."','".$DPTO."','".$CITY."','".$ADDRESS."','".$PHONE."','".$PASSWD."','".$TYPE."','".$STATUS."','".$REGDATE."','".$SEX."','".$BDAY."','".$UTYPE."', '0000-00-00 00:00:00')";
			$query = $this->db->query($str);
			
			
			// TRANSACCION DE REGISTRO DE USUARIO ANULADA
			// $TCODE = md5($info["mail"].$now);
			// $TYPE = "1";
			// $VALUE = 0;
			// $DETAIL = $langFile[$language]["regType"];
			// $DATE = $now;
			// $PCODE = "-";
			// $STATE = "1";
			
			
			// $str = "INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE, STATE) VALUES ('".$TCODE."','".$UCODE."','".$TYPE."','".$VALUE."','".$DETAIL."','".$DATE."','".$PCODE."','".$STATE."')";
			// $query = $this->db->query($str);
			
			$skills = "[]";
			$str = "INSERT INTO pros (PRCODE, UCODE, PRNAME, SKILLS) VALUES ('".$UCODE."','".$UCODE."','".$NAME."', '".$skills."')";
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
	function connectAG($info)
	{
		$umail = $info["umail"];
		$bcdata = $info["bcdata"];
		$str = "SELECT UCODE FROM users WHERE EMAIL = '".$umail."'";
		$query = $this->exdb($str);
		
		if(count($query) > 0){$ans = $query[0]["UCODE"];}
		else
		{

			$UCODE = md5($bcdata["UCODE"].$bcdata["NAME"]);
			$NAME = $bcdata["NAME"];
			$EMAIL = $bcdata["EMAIL"];
			$COUNTRY = $bcdata["COUNTRY"];
			$DPTO = $bcdata["DPTO"];
			$CITY = $bcdata["CITY"];
			$ADDRESS = $bcdata["ADDRESS"];
			$PHONE = $bcdata["PHONE"];
			$PASSWD = md5($bcdata["EMAIL"]);
			$actualLang = "es_co";
			$STATUS = "1";
			$SEX = $bcdata["SEX"];
			$BDAY = $bcdata["BDAY"];
			
			$imain = "";
			$cl = "";
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			$REGDATE = $now;
			
			$str = "INSERT INTO users (UCODE, NAME, EMAIL, COUNTRY, DPTO, CITY, ADDRESS, PHONE, PASSWD, STATUS, COMMENDPOINTS, FULLP, REGDATE, SEX, BDAY, REGIP, REGOR) VALUES ('".$UCODE."','".$NAME."','".$EMAIL."','".$COUNTRY."','".$DPTO."','".$CITY."','".$ADDRESS."','".$PHONE."','".$PASSWD."','".$STATUS."','100', '1', '".$REGDATE."', '".$SEX."', '".$BDAY."', '".$imain."', '".$cl."')";
			$query = $this->exdb($str);
			
			$str = "INSERT INTO mdaemon (UCODE) VALUES ('".$UCODE."')";
			$query = $this->exdb($str);

			$ans = $UCODE;
		}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	// EXTERNAL DB IMPORT/EXPORT QUERY
	function exdb($str)
	{
		// COPY THIS QUERY FROM Database.php
		$host = "localhost";
		$db = "itsfree";
		$user = "adminCultivarte";
		$pssw = "harolito2";
		$edb = new PDO('mysql:host='.$host.';dbname='.$db.'', $user, $pssw);
		$param = [$str,$edb];
		$resp = $this->db->query($param);
		return $resp;
	}
	// EXTERNAL DB IMPORT/EXPORT QUERY
	function getStoreData($info)
	{
		$code = $info["code"];
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$str = "SELECT * FROM users WHERE UCODE = '".$code."'";
		$query = $this->db->query($str);	
		$ans["user"] = $query[0];
		$ans["saloons"] = $query;
		
		$str = "SELECT * FROM pros WHERE UCODE = '".$code."'";
		$query = $this->db->query($str);	
		$ans["pros"] = $query;
		
		$str = "SELECT * FROM services";
		$query = $this->db->query($str);	
		$ans["services"] = $query;
		
		$str = "SELECT * FROM pros WHERE UCODE = '".$code."'";
		$query = $this->db->query($str);
		$ans["allpros"] = $query;
		
		$resp["message"] = $ans;
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
	function codeCheck($info)
	{
		$CODE = $info["code"];
		$SERIE = $info["serie"];

		
		if($info["isser"] == "0")
		{
			$str = "SELECT * FROM stickers WHERE CODE = '".$CODE."'";
			$query = $this->db->query($str);	
		}
		else
		{
			$str = "SELECT * FROM stickers WHERE CODE = '".$CODE."' AND SERIE = '".$SERIE."'";
			$query = $this->db->query($str);	
		}
		
		if(count($query) > 0)
		{
			$ans = $query[0];
		}
		else
		{
			$ans = "nf";
		}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
		
	}
	function buyItem($info)
	{
		
		$language = "es_co";
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$UCODE = $info["UCODE"];
		$CODE = $info["CODE"];
		$USEB = $info["USEB"];
		
		$str = "SELECT PNAME, PRICE, TYPE, DETAIL FROM products WHERE CODE = '".$CODE."'";
		$query = $this->db->query($str);	
		
		$DETAIL = $query[0]["PNAME"];
		$VALUE =  intval($query[0]["PRICE"]);
		$PTYPE =  $query[0]["TYPE"];
		$PDETAIL =  $query[0]["DETAIL"];
		
		$TYPE = "0";
		$DATE = $now;
		
		$str = "SELECT TYPE, VALUE FROM tns WHERE UCODE = '".$UCODE."'";
		$query = $this->db->query($str);	
		
		$pos = 0;
		$neg = 0;
		
		$posB = 0;
		$negB = 0;
		
		for($i=0; $i<count($query);$i++)
		{
			$type = $query[$i]["TYPE"];
			$value = intval($query[$i]["VALUE"]);
			
			if($type == "0" or $type == "3")
			{
				$neg = $neg+$value;
			}
			if($type == "1")
			{
				$pos = $pos+$value;
			}
			if($type == "5")
			{
				$posB = $posB+$value;
			}
			if($type == "6")
			{
				$negB = $negB+$value;
			}
		}
		$cash = $pos - $neg;
		$cashB = $posB - $negB;
		if($cashB < 0){$cashB = 0;}
		
		if($USEB == "true")
		{
			if($cashB <= $VALUE)
			{
				$VALUE = $VALUE - $cashB;
				
				$BUSED = $cashB;
			}
			else
			{
				$BUSED = $VALUE;
				
				$VALUE = 0;
				
			}
			
			if($cash < $VALUE)
			{
				$resp["message"] = "nomony";
			}
			else
			{
				$TCODE = md5($now.$UCODE);
				$STATEB = "6";
				$TYPEB = "6";
				$CODEB = "-";
				
				$sDetail = "Consumo de bono de regalo";
				
				$str = "INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE, STATE) VALUES ('".$TCODE."', '".$UCODE."','".$TYPEB."' ,'".$BUSED."' ,'".$sDetail."', '".$now."', '".$CODEB."', '".$STATEB."')";
				$query = $this->db->query($str);
			}

		}

		if($cash < $VALUE)
		{
			$resp["message"] = "nomony";
		}
		else
		{
			$TCODE = md5($UCODE.$now);
			$STATE = "1";
			
			if($PTYPE == "p" or $PTYPE == "s")
			{
				$CODE = $this->genCode(6, 1, "x")[0];
				$STATE = "0";
				
				$serie = "x";
				$sType = "CO";
				$sDetail = $DETAIL;
				
				$str = "INSERT INTO stickers (SERIE, CODE, AMOUNT, TYPE, DETAIL) VALUES ('".$serie."', '".$CODE."', '".$VALUE."', '".$sType."', '".$sDetail."')";
				$query = $this->db->query($str);
				
				$CODE = "0-".$CODE;
				
			}
			else if($PTYPE == "c")
			{
				
			}

			$str = "INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE, STATE) VALUES ('".$TCODE."', '".$UCODE."','".$TYPE."' ,'".$VALUE."' ,'".$DETAIL."', '".$now."', '".$CODE."', '".$STATE."')";
			$query = $this->db->query($str);

			$resp["message"] = "sold";
		}
		
		// $resp["message"] = $cash;
		
		$resp["status"] = true;
		return $resp;
	}
	function addPro($info)
	{
		
		$name = $info["name"];
		$ucode = $info["ucode"];
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$prcode = md5($name.$ucode);
		
		$str = "SELECT PRCODE FROM pros WHERE PRCODE = '".$prcode."'";
		$query = $this->db->query($str);
		
		if(count($query)>0)
		{
			$ans = "exists";
		}
		else
		{
			$str = "INSERT INTO pros (PRCODE, PRNAME, UCODE, SKILLS) VALUES ('".$prcode."','".$name."','".$ucode."','[]')";
			$query = $this->db->query($str);
			$ans = "done";
		}
	
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getUserScores($info)
	{
		
		$ucode = $info["ucode"];
		
		$str = "SELECT DATE, SCODE, SNAME, SUM(VALUE) AS income FROM tns WHERE TYPE = '1' AND UCODE = '".$ucode."' GROUP BY SCODE ORDER BY DATE DESC ";
		$query = $this->db->query($str);	
		
		$incomes = $query;
		
		$str = "SELECT DATE, SCODE, SNAME, SUM(VALUE) AS outcome FROM tns WHERE TYPE = '0' AND UCODE = '".$ucode." 'GROUP BY SCODE ORDER BY DATE DESC ";
		$query = $this->db->query($str);	
		
		$outcomes = $query;
		
		$str = "SELECT DATE, SCODE, SNAME, SUM(VALUE) AS ransom FROM tns WHERE TYPE = '9' AND UCODE = '".$ucode." 'GROUP BY SCODE ORDER BY DATE DESC ";
		$query = $this->db->query($str);	
		
		$ransom = $query;
		
		$ans["ins"] = $incomes;
		$ans["outs"] = $outcomes;
		$ans["ransom"] = $ransom;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getCdata($info)
	{
		$phone = $info["phone"];
		$ucode = $info["ucode"];
		
		$ans = array();
		
		$str = "SELECT NAME,EMAIL  FROM users WHERE PHONE = '".$phone."'";
		$query = $this->db->query($str);
		$ans["udata"]  = $query;

		$str = "SELECT * FROM services ORDER BY DETAIL ASC";
		$query = $this->db->query($str);
		$ans["services"]  = $query;
		
		$str = "SELECT * FROM pros WHERE UCODE = '".$ucode."' ORDER BY PRNAME ASC";
		$query = $this->db->query($str);
		$ans["pros"]  = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveSale($info)
	{
		
		$DATE = $info["DATE"];
		$STCODE = $info["STCODE"];
		$STNAME = $info["STNAME"];
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$SAVETYPE = $info["SAVETYPE"];
		
		if($SAVETYPE == "1")
		{
			$UNAME = $info["UNAME"];
			$UPHONE = $info["UPHONE"];
			$UMAIL = $info["UMAIL"];
			$SECODE = $info["SECODE"];
			$SENAME = $info["SENAME"];
			$SEVALUE = $info["SEVALUE"];
			$SESCORE = $info["SESCORE"];
			$PROCODE = $info["PROCODE"];
			$PRONAME = $info["PRONAME"];
			$COMISION = $info["COMISION"];
			$OBS = $info["OBS"];
			$CODE = md5($DATE.$UPHONE);
			$BONIF = $info["BONIF"];
			
			$str = "SELECT PHONE, UCODE FROM users WHERE PHONE = '".$UPHONE."'";
			$query = $this->db->query($str);
			
			
			if(count($query) > 0)
			{
				
				$str = "INSERT INTO movements (CODE, UNAME, UPHONE, UMAIL, SECODE, SENAME, SEVALUE, PROCODE, PRONAME, STCODE, COMISION, DATE, OBS,MTYPE, BONIF) VALUES ('".$CODE."', '".$UNAME."', '".$UPHONE."', '".$UMAIL."', '".$SECODE."', '".$SENAME."', '".$SEVALUE."', '".$PROCODE."','".$PRONAME."','".$STCODE."','".$COMISION."','".$DATE."','".$OBS."','".$SAVETYPE."', '".$BONIF."')";
				$savemov = $this->db->query($str);
				
				$CUCODE = $query[0]["UCODE"];
				
				$ans = "old user";
			}
			else
			{
				$NUCODE = md5($DATE.$UPHONE.$DATE);
				$PASSWD = md5($UPHONE);
				$COUNTRY = $info["COUNTRY"];
				$DPTO = $info["DPTO"];
				$CITY = $info["CITY"];
				$ADDRESS = "";
				$TYPE = '0';
				$STATUS = '1';
				$UTYPE = "C";
				$PRENDATE = "0000-00-00 00:00:00";

				$str = "INSERT INTO users (UCODE, NAME, EMAIL, COUNTRY, DPTO, CITY, ADDRESS, PHONE, PASSWD, TYPE, STATUS, REGDATE, UTYPE, PRENDATE) VALUES ('".$NUCODE."', '".$UNAME."', '".$UMAIL."', '".$COUNTRY."', '".$DPTO."', '".$CITY."', '".$ADDRESS."', '".$UPHONE."','".$PASSWD."','".$TYPE."','".$STATUS."','".$now."','".$UTYPE."','".$PRENDATE."')";
				$query = $this->db->query($str);
				
				$CUCODE = $NUCODE;

				$str = "INSERT INTO movements (CODE, UNAME, UPHONE, UMAIL, SECODE, SENAME, SEVALUE, PROCODE, PRONAME, STCODE, COMISION, DATE, OBS, MTYPE) VALUES ('".$CODE."', '".$UNAME."', '".$UPHONE."', '".$UMAIL."', '".$SECODE."', '".$SENAME."', '".$SEVALUE."', '".$PROCODE."','".$PRONAME."','".$STCODE."','".$COMISION."','".$DATE."','".$OBS."','".$SAVETYPE."')";
				$savemov = $this->db->query($str);
				
				$ans = "new user";
			}
			
			$TCODE = md5($DATE.$UPHONE);
			$TTYPE = "1";
			$VALUE = $SESCORE;
			$DETAIL = "Brazil Coins recibidos de: ".$STNAME;
			$PCODE = "";
			$STATE = "0";
				
			$str = "INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE, STATE, SCODE, SNAME) VALUES ('".$TCODE."', '".$CUCODE."', '".$TTYPE."', '".$VALUE."', '".$DETAIL."', '".$now."', '".$PCODE."', '".$STATE."','".$STCODE."','".$STNAME."')";
			$query = $this->db->query($str);
			
		}
		if($SAVETYPE == "2")
		{
			
			$CODE = md5($DATE.$STCODE);
			$PDETAIL = $info["PDETAIL"];
			$PVALUE = $info["PVALUE"];
			$PQTY = $info["PQTY"];
			$BONIF = $info["BONIF"];
			
			$str = "INSERT INTO movements (CODE, STCODE, PDETAIL, PVALUE, DATE, PQTY, MTYPE, BONIF) VALUES ('".$CODE."','".$STCODE."','".$PDETAIL."','".$PVALUE."','".$DATE."','".$PQTY."','".$SAVETYPE."', '".$BONIF."')";
			$savemov = $this->db->query($str);
			
			$ans = "new product";
		
			
		}
		if($SAVETYPE == "3")
		{
			
			$CODE = md5($DATE.$STCODE);
			$SPENDETAIL = $info["SPENDETAIL"];
			$SPENDVALUE = $info["SPENDVALUE"];
			
			$str = "INSERT INTO movements (CODE, STCODE, SPENDETAIL, SPENDVALUE, DATE, MTYPE) VALUES ('".$CODE."','".$STCODE."','".$SPENDETAIL."','".$SPENDVALUE."','".$DATE."','".$SAVETYPE."' )";
			$savemov = $this->db->query($str);
			
			$ans = "new spend";
		
			
		}
		if($SAVETYPE == "4")
		{
			$UNAME = $info["UNAME"];
			$UPHONE = $info["UPHONE"];
			$UMAIL = $info["UMAIL"];
			$SECODE = $info["SECODE"];
			$SENAME = $info["SENAME"];
			$OBS = $info["OBS"];
			$CODE = md5($DATE.$UPHONE);
			$CDESC = $info["CDESC"];
			
			$str = "SELECT PHONE, UCODE FROM users WHERE PHONE = '".$UPHONE."'";
			$query = $this->db->query($str);
			
			
			if(count($query) > 0)
			{
				$ans = "old user";
			}
			else
			{
				$NUCODE = md5($DATE.$UPHONE.$DATE);
				$PASSWD = md5($UPHONE);
				$COUNTRY = $info["COUNTRY"];
				$DPTO = $info["DPTO"];
				$CITY = $info["CITY"];
				$ADDRESS = "";
				$TYPE = '0';
				$STATUS = '1';
				$UTYPE = "C";
				$PRENDATE = "0000-00-00 00:00:00";

				$str = "INSERT INTO users (UCODE, NAME, EMAIL, COUNTRY, DPTO, CITY, ADDRESS, PHONE, PASSWD, TYPE, STATUS, REGDATE, UTYPE, PRENDATE) VALUES ('".$NUCODE."', '".$UNAME."', '".$UMAIL."', '".$COUNTRY."', '".$DPTO."', '".$CITY."', '".$ADDRESS."', '".$UPHONE."','".$PASSWD."','".$TYPE."','".$STATUS."','".$now."','".$UTYPE."','".$PRENDATE."')";
				$query = $this->db->query($str);
				

				$ans = "new user";
			}
			
			$str = "INSERT INTO movements (CODE, UNAME, UPHONE, UMAIL, STCODE, SECODE, SENAME, DATE, MTYPE, OBS, CDESC) VALUES ('".$CODE."','".$UNAME."','".$UPHONE."','".$UMAIL."','".$STCODE."','".$SECODE."','".$SENAME."','".$DATE."','".$SAVETYPE."','".$OBS."','".$CDESC."' )";
			$savemov = $this->db->query($str);
			
		}

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getControList($info)
	{
		$fscCell = $info["fscCell"];
		$fscservice = $info["fscservice"];
		$finidate = $info["finidate"];
		$fenddate = $info["fenddate"];
		$actualSaveType = $info["actualSaveType"];
		$stcode = $info["stcode"];
		$expo = $info["expo"];

		$where = "WHERE MTYPE = '".$actualSaveType."' AND STCODE = '".$stcode."'";

		if($fscCell != ""){$where .= "AND UPHONE LIKE '%$fscCell%'";}
		if($fscservice != ""){$where .= "AND SENAME LIKE '%$fscservice%'";}
		if($finidate != ""){$where .= "AND DATE >= '$finidate'";} 
		if($fenddate != ""){$where .= "AND DATE <= '$fenddate'";} 
		$str = "SELECT *  FROM movements $where ORDER BY DATE DESC";
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
			
			// SHEET CONFIG
		
			$myExcel = new PHPexcel();
			$myExcel->getProperties()->setCreator("Quoting Tool")
							 ->setLastModifiedBy("Quoting Tool")
							 ->setTitle("PHPExcel Document")
							 ->setSubject("PHPExcel Document")
							 ->setDescription("Document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");
			
			$allborders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
			
			$borderR = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
			
			$borderT = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
			
			$borderB = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
			
			$grayBg = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'DCE0E8')));
			
			$yellowBg = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '009899')));
			
			$alignCenter = array('alignment' => array('horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
			 
			$alignRight = array('alignment' => array('horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
			
			$alignLeft = array('alignment' => array('horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
			
			$sheet = $myExcel->getActiveSheet();
			$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
			
			$sheet->getPageMargins()->setTop(0.1);
			$sheet->getPageMargins()->setRight(0.3);
			$sheet->getPageMargins()->setLeft(0.3);
			$sheet->getPageMargins()->setBottom(0.3);
			
			// SHEET CONFIG END -------------------------
			
			$finidate = explode(" ", $finidate)[0];
			$fenddate = explode(" ", $fenddate)[0];
			
			if($finidate == ""){$finidate = "Inicio total";}
			if($fenddate == ""){$fenddate = "Final total";}
			
			
			
			if($actualSaveType == "1")
			{
				$myExcel->getActiveSheet()->setTitle("Control Venta servicios");
				
				// HEADER TITLE

				$c = 2;
				
				$sheet->getStyle("A$c:I$c")->applyFromArray($grayBg);
				$sheet->getStyle("A$c:I$c")->applyFromArray($allborders);
				$sheet->getStyle("A$c:I$c")->getFont()->setBold(true);
				$sheet->getStyle("A$c:I$c")->applyFromArray($alignCenter);
				$sheet->setCellValue("A$c", "FECHA");
				$sheet->setCellValue("B$c", "SERVICIO");
				$sheet->setCellValue("C$c", "CLIENTE");
				$sheet->setCellValue("D$c", "ESTILISTA");
				$sheet->setCellValue("E$c", "VALOR SERVICIO");
				$sheet->setCellValue("F$c", "% GANANCIA");
				$sheet->setCellValue("G$c", "VALOR GANANCIA");
				$sheet->setCellValue("H$c", "NOTAS");
				$sheet->setCellValue("I$c", "BONIFICACION");
				// $sheet->setCellValue("H$c", "PRODUCTOS");
				// $sheet->setCellValue("I$c", "VALOR PRODUCTOS");
			

				$c++;
				
				$totalServs = 0;
				$totalGan = 0;
				
				
				
				for($i = 0; $i<count($query);$i++)
				{
					$item = $query[$i];

					$sheet->setCellValue("A$c",  $item["DATE"]);
					$sheet->setCellValue("B$c",  $item["SENAME"]);
					$sheet->setCellValue("C$c",  $item["UNAME"]);
					$sheet->setCellValue("D$c",  $item["PRONAME"]);
					$sheet->setCellValue("E$c",  $item["SEVALUE"]);
					$sheet->setCellValue("F$c",  $item["COMISION"]);
					$profit = (intval($item["SEVALUE"])*intval($item["COMISION"]))/100;
					$sheet->setCellValue("G$c",  $profit);
					$sheet->setCellValue("H$c",  $item["OBS"]);
					
					
					if($item["BONIF"] == "1")
					{$bonif = "Bonificación";}
					else
					{$bonif = "";}
					
					$sheet->setCellValue("I$c",  $bonif);
					
					$sheet->getStyle("E$c")->getNumberFormat()->setFormatCode('#,##0');
					$sheet->getStyle("G$c")->getNumberFormat()->setFormatCode('#,##0');
					$sheet->getStyle("I$c")->getNumberFormat()->setFormatCode('#,##0');
					
					$sheet->getStyle("A$c:I$c")->applyFromArray($allborders);
					
					if($item["BONIF"] == "0")
					{
						$totalServs = $totalServs+intval($item["SEVALUE"]);
						$totalGan = $totalGan+intval($profit);
					}
					
					$c++;
				}
			

				$sheet->setCellValue("D$c",  "TOTALES");
				$sheet->setCellValue("E$c",  $totalServs);
				$sheet->setCellValue("G$c",  $totalGan);
				// $sheet->setCellValue("I$c",  $totalProds);
				$sheet->getStyle("A$c:G$c")->getFont()->setBold(true);
				$sheet->getStyle("E$c:G$c")->getNumberFormat()->setFormatCode('#,##0');


				// FILE EXPORT ------------------

				
				$sheet->setCellValue('A1', 'VENTAS DE SERVICIOS DESDE '.$finidate.' HASTA '.$fenddate);
				$sheet->getStyle("A1")->getFont()->setBold(true);
				$sheet->getStyle("A1")->getFont()->setSize(14);
				$sheet->getStyle("A1")->applyFromArray($alignCenter);
				$sheet->mergeCells('A1:H1');
				
				$fname  = "Control servicios desde ".$finidate. " hasta ".$fenddate;
				$fname = htmlEntities(utf8_decode($fname));
				$path = "../../control/".$fname.".xls";
				
				$hasFile = file_exists($path);
				if($hasFile == true){unlink($path);}
				
				$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
				$objWriter->save($path );
				$resp["fname"] = $fname;
			}
			
			if($actualSaveType == "2")
			{
				// $sheet2 = $myExcel->createSheet(); //Setting index when creating
				// $myExcel->setActiveSheetIndex(1);

				$myExcel->getActiveSheet()->setTitle("Control Venta Productos");

				// HEADER TITLE

				$c = 2;
				
				$sheet->getStyle("A$c:F$c")->applyFromArray($grayBg);
				$sheet->getStyle("A$c:F$c")->applyFromArray($allborders);
				$sheet->getStyle("A$c:F$c")->getFont()->setBold(true);
				$sheet->getStyle("A$c:F$c")->applyFromArray($alignCenter);
				$sheet->setCellValue("A$c", "FECHA");
				$sheet->setCellValue("B$c", "PRODUCTO");
				$sheet->setCellValue("C$c", "CANTIDAD");
				$sheet->setCellValue("D$c", "VALOR");
				$sheet->setCellValue("E$c", "SUBOTAL");
				$sheet->setCellValue("F$c", "BONIFICACION");
				
				$totalProds = 0;
				
				$c++;
				
				for($i = 0; $i<count($query);$i++)
				{
					$item = $query[$i];

					$sheet->setCellValue("A$c",  $item["DATE"]);
					$sheet->setCellValue("B$c",  $item["PDETAIL"]);
					$sheet->setCellValue("C$c",  $item["PQTY"]);
					$sheet->setCellValue("D$c",  $item["PVALUE"]);
					
					$subtotal = intval($item["PVALUE"])*intval($item["PQTY"]);
					 
					$sheet->setCellValue("E$c",  $subtotal);
					
					if($item["BONIF"] == "1")
					{$bonif = "Bonificación";}
					else
					{$bonif = "";}
				
					$sheet->setCellValue("F$c",  $bonif);

					$sheet->getStyle("C$c")->getNumberFormat()->setFormatCode('#,##0');
					$sheet->getStyle("D$c")->getNumberFormat()->setFormatCode('#,##0');
					$sheet->getStyle("E$c")->getNumberFormat()->setFormatCode('#,##0');
					
					$sheet->getStyle("A$c:F$c")->applyFromArray($allborders);
					
					
					$totalProds = $totalProds+$subtotal;
					
					$c++;
				}
				
				$sheet->setCellValue("C$c", "TOTAL");
				
				$sheet->setCellValue("E$c",  $totalProds);
				$sheet->getStyle("A$c:E$c")->getFont()->setBold(true);
				$sheet->getStyle("A$c:E$c")->getNumberFormat()->setFormatCode('#,##0');

				// FILE EXPORT ------------------

			
				$sheet->setCellValue('A1', 'VENTAS DE PRODUCTOS DESDE '.$finidate.' HASTA '.$fenddate);
				$sheet->getStyle("A1")->getFont()->setBold(true);
				$sheet->getStyle("A1")->getFont()->setSize(14);
				$sheet->getStyle("A1")->applyFromArray($alignCenter);
				$sheet->mergeCells('A1:D1');
				
				$fname  = "Control productos desde ".$finidate. " hasta ".$fenddate;
				$fname = htmlEntities(utf8_decode($fname));
				$path = "../../control/".$fname.".xls";
				
				$hasFile = file_exists($path);
				if($hasFile == true){unlink($path);}
				
				$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
				$objWriter->save($path );
				$resp["fname"] = $fname;
			
			}
			
			if($actualSaveType == "3")
			{
				// $sheet2 = $myExcel->createSheet(); //Setting index when creating
				// $myExcel->setActiveSheetIndex(1);

				$myExcel->getActiveSheet()->setTitle("Control Gastos de Caja");

				// HEADER TITLE

				$c = 2;
				
				$sheet->getStyle("A$c:C$c")->applyFromArray($grayBg);
				$sheet->getStyle("A$c:C$c")->applyFromArray($allborders);
				$sheet->getStyle("A$c:C$c")->getFont()->setBold(true);
				$sheet->getStyle("A$c:C$c")->applyFromArray($alignCenter);
				$sheet->setCellValue("A$c", "FECHA");
				$sheet->setCellValue("B$c", "CONCEPTO");
				$sheet->setCellValue("C$c", "VALOR");
				
				
				$totalSpend = 0;
				
				$c++;
				
				for($i = 0; $i<count($query);$i++)
				{
					$item = $query[$i];

					$sheet->setCellValue("A$c",  $item["DATE"]);
					$sheet->setCellValue("B$c",  $item["SPENDETAIL"]);
					$sheet->setCellValue("C$c",  $item["SPENDVALUE"]);
					$sheet->getStyle("B$c")->getNumberFormat()->setFormatCode('#,##0');
					$sheet->getStyle("C$c")->getNumberFormat()->setFormatCode('#,##0');
					$sheet->getStyle("A$c:C$c")->applyFromArray($allborders);

					$totalSpend = $totalSpend+intval($item["SPENDVALUE"]);
					
					$c++;
				}
				
				$sheet->setCellValue("B$c", "TOTAL");
				
				$sheet->setCellValue("C$c",  $totalSpend);
				$sheet->getStyle("A$c:C$c")->getFont()->setBold(true);
				$sheet->getStyle("A$c:C$c")->getNumberFormat()->setFormatCode('#,##0');

				// FILE EXPORT ------------------

			
				$sheet->setCellValue('A1', 'GASTOS DE CAJA DESDE '.$finidate.' HASTA '.$fenddate);
				$sheet->getStyle("A1")->getFont()->setBold(true);
				$sheet->getStyle("A1")->getFont()->setSize(14);
				$sheet->getStyle("A1")->applyFromArray($alignCenter);
				$sheet->mergeCells('A1:C1');
				
				$fname  = "Control gastos desde ".$finidate. " hasta ".$fenddate;
				$fname = htmlEntities(utf8_decode($fname));
				$path = "../../control/".$fname.".xls";
				
				$hasFile = file_exists($path);
				if($hasFile == true){unlink($path);}
				
				$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
				$objWriter->save($path );
				$resp["fname"] = $fname;
			
			}

			

		}

		return $resp;
	
	}
	function delPro($info)
	{
		
		$prcode = $info["prcode"];
		$ucode = $info["ucode"];
		
		$str = "DELETE FROM pros WHERE UCODE = '".$ucode."' AND PRCODE = '".$prcode."'";
		$query = $this->db->query($str);
		
		$ans = "done";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveSkills($info)
	{
		
		$prcode = $info["prcode"];
		$prskills = $info["prskills"];
		$ucode = $info["ucode"];
		
		$str = "UPDATE pros SET SKILLS='$prskills' WHERE PRCODE='".$prcode."' AND UCODE = '$ucode'"; 
		$query = $this->db->query($str);
		
		
		$ans = "done";
		
		$resp["mesage"] = $ans;
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
	function ppicsave($info)
	{
		
		$pic =  $info["pic"];
		$ucode = $info["ucode"];
		
		$destination_path = "../../ppics/".$ucode;

		if($pic != "")
		{
			$hasBG = file_exists($destination_path.'.jpg');
			if($hasBG == true){unlink($destination_path.'.jpg');}
			
			list($type, $pic) = explode(';', $pic);
			list(, $pic)      = explode(',', $pic);
			$imageStr  = base64_decode($pic);
			
			$image = imagecreatefromstring($imageStr);
			imagejpeg($image, $destination_path.'.jpg');
			
			$str = "UPDATE users SET HP='1' WHERE UCODE='".$ucode."'"; 
			$query = $this->db->query($str);
			
			$ans = "done";
			
			$resp["message"] = $ans;
			$resp["status"] = true;
			return $resp;
			
		}
	}
	function ppicsaveF($info)
	{
		
		$pic =  $info["pic"];
		$ucode = $info["ucode"];
		
		$destination_path = "../../mysite/img/frontPics/".$ucode;
		
		if($pic != "")
		{
			$hasBG = file_exists($destination_path.'.jpg');
			if($hasBG == true){unlink($destination_path.'.jpg');}
			
			list($type, $pic) = explode(';', $pic);
			list(, $pic)      = explode(',', $pic);
			$imageStr  = base64_decode($pic);
			
			$image = imagecreatefromstring($imageStr);
			imagejpeg($image, $destination_path.'.jpg');
			
			$str = "UPDATE users SET HPF='1' WHERE UCODE='".$ucode."'"; 
			$query = $this->db->query($str);
			
			$ans = "done";
			
			$resp["message"] = $ans;
			$resp["status"] = true;
			return $resp;
		}
	}
	function saveAbout($info)
	{
		
		$ucode = $info["ucode"];
		$about = $info["about"];
		
		$str = "UPDATE users SET ABOUT ='".$about."' WHERE UCODE ='".$ucode."'"; 
		$query = $this->db->query($str);
		$ans = "done";
		
		$resp["message"] = $ans;
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
	function getPList($info)
	{
		$ucode = $info["ucode"];
		$utype = $info["utype"];
		
		$str = "SELECT *  FROM products ORDER BY POS ASC";
		$query = $this->db->query($str);
		$products = $query;

		$str = "SELECT * FROM tns WHERE UCODE = '".$ucode."' ORDER BY DATE DESC";
		$query = $this->db->query($str);
		$trans = $query;
		
		$str = "SELECT * FROM cinst ";
		$query = $this->db->query($str);
		$insts = $query[0]["INSTR"];
		
		$str = "SELECT * FROM services ";
		$query = $this->db->query($str);
		$servs = $query;
		
		$str = "SELECT * FROM promos WHERE ACTIVE = '1'";
		$query = $this->db->query($str);
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		if(count($query) > 0)
		{
			$promo = $query;
			$pcode = $promo[0]["PCODE"];
			
			$str = "SELECT SUM(VALUE) AS SCORE FROM tns WHERE UCODE = '".$ucode."' AND PCODE LIKE '%".$pcode."%'";
			$query = $this->db->query($str);
			
			$promoScore = $query;
		}
		else
		{
			$promo = $query;
			$promoScore = 0;
		}
		
		$str = "SELECT * FROM users WHERE UTYPE = 'E' AND PREMIUM = '1' AND PRENDATE > '".$now."' AND SERVTIME != ''";
		$query = $this->db->query($str);
		$saloons = $query;
		
		$str = "SELECT * FROM pros ";
		$query = $this->db->query($str);
		$allpros = $query;
		
		$str = "SELECT * FROM pros WHERE UCODE = '".$ucode."'";
		$query = $this->db->query($str);
		$mypros = $query;
		
		// GET MY DATES
		if($utype == "E")
		{
			$str = "SELECT * FROM dates WHERE DSALOON = '".$ucode."' ORDER BY DDATE ASC";

		}
		else
		{
			$str = "SELECT * FROM dates WHERE CUCODE = '".$ucode."' ORDER BY DDATE ASC";
		}
		$query = $this->db->query($str);	
		$datesList = $query;
		
		// GET MY CLIENTS
		if($utype == "E")
		{
			$ucode = $info["ucode"];
		
			$str = "SELECT tns.UCODE, SUM(VALUE) AS income, users.NAME, users.EMAIL, users.PHONE FROM tns LEFT JOIN users ON tns.UCODE = users.UCODE WHERE tns.TYPE = '1' AND SCODE = '".$ucode."' AND tns.UCODE != '".$ucode."' GROUP BY UCODE ORDER BY DATE DESC ";
			$query = $this->db->query($str);	
			
			$incomes = $query;
			
			$str = "SELECT tns.UCODE, SUM(VALUE) AS outcome, users.NAME, users.EMAIL, users.PHONE FROM tns LEFT JOIN users ON tns.UCODE = users.UCODE WHERE tns.TYPE = '0' AND SCODE = '".$ucode."' AND tns.UCODE != '".$ucode."' GROUP BY UCODE ORDER BY DATE DESC ";
			$query = $this->db->query($str);	
			
			$outcomes = $query;
			
			$myclients = [];
			$myclients["ins"] = $incomes;
			$myclients["outs"] = $outcomes;
		}
		else
		{
			$myclients = [];
		}
		
		
		$ans = []; 
		$ans["products"] = $products;
		$ans["trans"] = $trans;
		$ans["insts"] = $insts;
		$ans["promo"] = $promo;
		$ans["promoScore"] = $promoScore;
		$ans["servs"] = $servs;
		$ans["saloons"] = $saloons;
		$ans["allpros"] = $allpros;
		$ans["mypros"] = $mypros;
		$ans["datesList"] = $datesList;
		$ans["myclients"] = $myclients;
		
		
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	
	}
	function insertPcode($info)
	{
		
		$ucode = $info["ucode"];
		$pcode = $info["pcode"];
		$code = $info["code"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		
		$str = "SELECT * FROM stickers WHERE CODE = '".$code."' AND PCODE = '".$pcode."'";
		$query = $this->db->query($str);	
		
		if(count($query) > 0)
		{
			$item = $query[0];
			
			if($item["STATUS"] == "2")
			{
				$ans = "used";
			}
			else
			{
				$str = "SELECT ACTIVE FROM promos WHERE PCODE = '".$pcode."'";
				$query = $this->db->query($str);	
				
				$pstate = $query[0]["ACTIVE"];
				
				if($pstate == "0")
				{
					$ans = "na";
				}
				else
				{
					$amount = intval($item["AMOUNT"]);
				
					$str = "UPDATE stickers SET STATUS = '2' WHERE CODE = '".$code."'"; 
					$query = $this->db->query($str);	
					
					
					$TCODE = md5($info["ucode"].$now);
					$UCODE = $ucode;
					$TYPE = "8";
					$VALUE = $amount;
					$DETAIL = $item["DETAIL"];
					$DATE = $now;
					$PCODE = $code."-".$pcode;

					$STATE = "2";
					
					$str = "INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE, STATE) VALUES ('".$TCODE."','".$UCODE."','".$TYPE."','".$VALUE."','".$DETAIL."','".$DATE."','".$PCODE."','".$STATE."')";
					$query = $this->db->query($str);
					
					
					$ans = "marked";
				}
	
			}
			
			
			
		}
		else
		{
			$str = "SELECT ACTIVE FROM promos WHERE PCODE = '".$pcode."'";
			$query = $this->db->query($str);	
			
			$pstate = $query[0]["ACTIVE"];
			
			if($pstate == "0")
			{
				$ans = "na";
			}
			else
			{
			
				$ans = "nf";
			}
		}
		
		
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveServTime($info)
	{
		
		$ucode = $info["ucode"];
		$servtime = $info["servtime"];
		
		$str = "UPDATE users SET SERVTIME='".$servtime."' WHERE UCODE='".$ucode."'"; 
		$query = $this->db->query($str);
		
		$ans = "done";
		
		$resp["mesage"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function createDate($info)
	{
		$city = $info["city"];
		$saloon = $info["saloon"];
		$saloonName = $info["saloonName"];
		$prof = $info["prof"];
		$profName = $info["profName"];
		$treat = $info["treat"];
		$treatName = $info["treatName"];
		$date = $info["date"];
		$ucode = $info["ucode"];
		$uname = $info["uname"];
		$saveDateState = $info["saveDateState"];
		$editDateCode = $info["editDateCode"];
		$payway = $info["payway"];
		$skillCost = $info["skillCost"];
		$cuphone = $info["cuphone"];

		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$dcode = md5($ucode.$now);
		
		// SAVE CHECK SERVTIME
		$str = "SELECT SERVTIME FROM users WHERE UCODE = '".$saloon."'";
		$query = $this->db->query($str);	
		
		$servtime = $query[0]["SERVTIME"];
		
		if($servtime != "")
		{
			$iniday = explode("-", $servtime)[0];
			$endday = explode("-", $servtime)[1];
			
			$unixTimestamp = strtotime($date);
			$dayOfWeek = date("l", $unixTimestamp);
			$nday = date('N', strtotime($dayOfWeek));
			
			if($nday > $endday)
			{
				$pass = "NoServD";
				$ans = $pass;
		
				$resp["message"] = $ans;
				$resp["status"] = true;
				return $resp;
			}
			else
			{
				
				$initime1 = explode("-", $servtime)[2];
				$endtime1 = explode("-", $servtime)[3];
				$hdate = explode(" ", $date)[1];
				$hour = intval(explode(":", $hdate)[0]);
				
				if(count(explode("-", $servtime)) > 4)
				{
					$initime2 = explode("-", $servtime)[4];
					$endtime2 = explode("-", $servtime)[5];
					
					if($hour > $endtime1 and $hour < $initime2)
					{
						$pass = "NoServH3";
						$ans = $pass;
		
						$resp["message"] = $ans;
						$resp["status"] = true;
						return $resp;
					}
					
					
					if($hour > $endtime2)
					{
						$pass = "NoServH1";
						$ans = $pass;
		
						$resp["message"] = $ans;
						$resp["status"] = true;
						return $resp;
					}
					
					if($hour < $initime1)
					{
						$pass = "NoServH2";
						$ans = $pass;
		
						$resp["message"] = $ans;
						$resp["status"] = true;
						return $resp;
					}
					
					
					// SAVE CHECK PROF
					$dayToCheck = explode(" ", $date)[0];
					$dayToCheck = str_replace('/','-',$dayToCheck);
					$str = "SELECT DDATE, EDATE FROM dates WHERE DSALOON = '".$saloon."' AND DPROF = '".$prof."' AND DSTATE != '2' AND  DDATE LIKE '%".$dayToCheck."%'";
					$query = $this->db->query($str);	

					// $resp["message"] = $query;
					// $resp["status"] = true;
					// return $resp;
					
					if(count($query)>0)
					{
						for($i=0; $i< count($query); $i++)
						{
							$item = $query[$i];
							$sdate = strtotime($item["DDATE"]);
							$edate = strtotime($item["EDATE"]);
							$compDate = strtotime($date);
							
							if($compDate >= $sdate)
							{
								if($compDate <= $edate)
								{
									
									if($saveDateState == "1")
									{
										$pass = "cool";
									}
									else
									{
										$pass = "NoProf";
									}
									
									break;
								}
								else
								{
									$pass = "cool";
								}
							}
							else
							{
								$pass = "cool";
							}
						}
					}
					else
					{
						$pass = "cool";
					}
					// SAVE CHECK PROF
					
				}
				else
				{
					
					if($hour > $endtime1)
					{
						$pass = "NoServH1";
						$ans = $pass;
		
						$resp["message"] = $ans;
						$resp["status"] = true;
						return $resp;
					}
					else if($hour < $initime1)
					{
						$pass = "NoServH2";
						$ans = $pass;
		
						$resp["message"] = $ans;
						$resp["status"] = true;
						return $resp;
					}
					else
					{
						
						// SAVE CHECK PROF
						
						$dayToCheck = explode(" ", $date)[0];
						$dayToCheck = str_replace('/','-',$dayToCheck);
						$str = "SELECT DDATE, EDATE FROM dates WHERE DSALOON = '".$saloon."' AND DPROF = '".$prof."' AND DSTATE != '2' AND  DDATE LIKE '%".$dayToCheck."%'";
						$query = $this->db->query($str);	
						
						if(count($query)>0)
						{
							for($i=0; $i< count($query); $i++)
							{
								$item = $query[$i];
								$sdate = strtotime($item["DDATE"]);
								$edate = strtotime($item["EDATE"]);
								$compDate = strtotime($date);
								
								if($compDate >= $sdate)
								{
									if($compDate <= $edate)
									{
										if($saveDateState == "1")
										{
											$pass = "cool";
										}
										else
										{
											$pass = "NoProf";
											
											// ISSUE ON REVIEW
											// $asn = [];
											// $ans["sdate"] = $item["DDATE"];
											// $ans["edate"] = $item["EDATE"];
											// $ans["compDate"] = $date;
											// $pass = $ans;
										}
										break;
									}
									else
									{
										$pass = "cool";
									}
								}
								else
								{
									$pass = "cool";
								}
							}
						}
						else
						{
							$pass = "cool";
						}
						// SAVE CHECK PROF
					}
				}
			}
		}
		else
		{
			$pass = "cool";
		}
		
		$pass = $pass;
		
		// CHECK FOR EXCHANGE AMOUNT
		if($payway == "1")
		{
			$str = "SELECT TYPE, VALUE FROM tns WHERE UCODE = '".$ucode."' AND SCODE = '".$saloon."'";
			$query = $this->db->query($str);	
			
			$pos = 0;
			$neg = 0;
			
			for($i=0; $i<count($query);$i++)
			{
				$type = $query[$i]["TYPE"];
				$value = intval($query[$i]["VALUE"]);
				
				if($type == "0")
				{
					$neg = $neg+$value;
				}
				if($type == "1")
				{
					$pos = $pos+$value;
				}
			}
			
			$cash = $pos - $neg;

			
			if($skillCost > $cash)
			{
				
				$pass = "NoMoney";
				
				$ans = $pass;
				$resp["message"] = $ans;
				$resp["status"] = true;
				return $resp;
			}

		}

		// SAVE IF ALL COOL
		if($pass == "cool")
		{
			
			$str = "SELECT MINUTES FROM services WHERE SRCODE = '".$treat."'";
			$query = $this->db->query($str);	
			$duration = intval($query[0]["MINUTES"]);
			
			$sdate = new DateTime($date);
			$edate = $sdate->add(new DateInterval('PT' . $duration . 'M'));
			$edate = $edate->format('Y-m-d H:i:s');
			
			if($saveDateState == "1")
			{
				$str = "UPDATE dates SET DDATE='".$date."', DPROF ='".$prof."', DTREAT ='".$treat."', DPROFNAME ='".$profName."', DTREATNAME ='".$treatName."'  WHERE DCODE='".$editDateCode."'"; 
				
				$pass = "updated";
			}
			else
			{
				$str = "INSERT INTO dates (DCODE, DCITY, DSALOON, DSALOONAME, DPROF, DPROFNAME, DTREAT, DTREATNAME, DDATE, CUCODE, CUNAME, EDATE, PAYWAY, CUPHONE) VALUES ('".$dcode."', '".$city."', '".$saloon."', '".$saloonName."', '".$prof."', '".$profName."', '".$treat."', '".$treatName."', '".$date."', '".$ucode."', '".$uname."', '".$edate."', '".$payway."','".$cuphone."')";
				
				$pass = "cool";
			}
			
			$query = $this->db->query($str);
			
			$language = "es_co";
			$langFile = parse_ini_file("../../lang/lang.ini", true);
			
			$treatName = explode(" - ", $treatName)[0];
			
			if($payway == "1")
			{
				// TRANSACTION FOR USER
				$TCODE = md5($info["ucode"].$now);
				$TYPE = "0";
				$UCODE = $ucode;
				$VALUE = $skillCost;
				$DETAIL = $langFile[$language]["treatChanged"].$treatName;
				$DATE = $now;
				$PCODE = "";
				$SCODE = $prof;
				$SNAME = $profName;
				
				$str = "INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE, SCODE, SNAME) VALUES ('".$TCODE."','".$UCODE."','".$TYPE."','".$VALUE."','".$DETAIL."','".$DATE."','".$PCODE."','".$SCODE."', '".$SNAME."')";
				$query = $this->db->query($str);
				
				// TRANSACTION FOR ESTYLIST
				$TCODE = md5($prof.$now);
				$TYPE = "2";
				$UCODE = $saloon;
				$VALUE = $skillCost;
				$DETAIL = $langFile[$language]["treatChanged"].$treatName." por ".$uname;
				$DATE = $now;
				$PCODE = "";
				$SCODE = $saloon;
				$SNAME = $profName;
				
				$str = "INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE, SCODE, SNAME) VALUES ('".$TCODE."','".$UCODE."','".$TYPE."','".$VALUE."','".$DETAIL."','".$DATE."','".$PCODE."','".$SCODE."', '".$SNAME."')";
				$query = $this->db->query($str);
			}
			
		}
		
		$ans = $pass;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getDatesList($info)
	{
		
		$ucode = $info["ucode"];
		$utype = $info["utype"];
		
		if($utype == "E")
		{
			$str = "SELECT * FROM dates WHERE DSALOON = '".$ucode."' ORDER BY DDATE ASC";
		}
		else
		{
			$str = "SELECT * FROM dates WHERE CUCODE = '".$ucode."' ORDER BY DDATE ASC";
		}
		
		$query = $this->db->query($str);	
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function setDateState($info)
	{
		
		$state = $info["state"];
		$dcode = $info["dcode"];
		
		$str = "UPDATE dates SET DSTATE='$state' WHERE DCODE='".$dcode."'"; 
		$query = $this->db->query($str);
		
		$ans = "done";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function sendCoins($info)
	{
		$UCODE = $info["ucode"];
		$amount = intval($info["amount"]);
		$destiny = $info["destiny"];
		$lang = $info["lang"];
		$originMail = $info["originMail"];
		$sname = $info["sname"];

		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$language = $lang;
		$langFile = parse_ini_file("../../lang/lang.ini", true);

		$str = "SELECT EMAIL, UCODE, NAME FROM users WHERE PHONE = '".$info["destiny"]."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$DCODE = $query[0]["UCODE"];
			$DMAIL = $query[0]["EMAIL"];
			$DNAME = $query[0]["NAME"];
			
			$ans = "EM";
			
			$TCODE = md5($info["ucode"].$now);

			$TYPE = "0";
			$VALUE = $amount;
			$DETAIL = $langFile[$language]["coinsSent"].$DNAME;
			$DATE = $now;
			$PCODE = "";
			$SCODE = $UCODE;
			$SNAME = $sname;
			
			$str = "INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE, SCODE, SNAME) VALUES ('".$TCODE."','".$UCODE."','".$TYPE."','".$VALUE."','".$DETAIL."','".$DATE."','".$PCODE."','".$SCODE."', '".$SNAME."')";
			$query = $this->db->query($str);
			
			$TCODE = md5($info["originMail"].$now);
			$UCODE = $DCODE;
			$TYPE = "1";
			$VALUE = $amount;
			$DETAIL = $langFile[$language]["coinsReceibed"].$SNAME;
			$DATE = $now;
			$PCODE = "";
			
			
			$str = "INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE, SCODE, SNAME) VALUES ('".$TCODE."','".$UCODE."','".$TYPE."','".$VALUE."','".$DETAIL."','".$DATE."','".$PCODE."','".$SCODE."', '".$SNAME."')";
			$query = $this->db->query($str);

		}
		else
		{
			$ans = "NEM";
		}

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
		
	}
	function exchangeRequest($info)
	{
		$UCODE = $info["ucode"];
		$amount = intval($info["amount"]);
		$pass = $info["pass"];
		$lang = $info["lang"];
		$originMail = $info["originMail"];
		
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$language = $lang;
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		
		
		$str = "SELECT TYPE, VALUE FROM tns WHERE UCODE = '".$UCODE."'";
		$query = $this->db->query($str);	
		
		$pos = 0;
		$neg = 0;
		
		for($i=0; $i<count($query);$i++)
		{
			$type = $query[$i]["TYPE"];
			$value = intval($query[$i]["VALUE"]);
			
			if($type == "0" or $type == "3")
			{
				$neg = $neg+$value;
			}
			if($type == "1")
			{
				$pos = $pos+$value;
			}
		}
		
		$cash = $pos - $neg;
		
		if($amount > $cash)
		{
			$ans = "NOTE";
		}
		else
		{
			
			$str = "SELECT * FROM users WHERE UCODE = '".$UCODE."'";
			$query = $this->db->query($str);
			
			$udata = $query[0];
			
			if($udata["PASSWD"] != md5($pass))
			{
				$ans = "WP";
				$resp["message"] = $ans;
				return $resp;
			}

			$ans = "EM";
			
			$TCODE = md5($info["ucode"].$now);

			$TYPE = "3";
			$VALUE = $amount;
			$DETAIL = $langFile[$language]["transrequest"];
			$DATE = $now;
			$PCODE = $langFile[$language]["transrequest"]." de ".$udata["NAME"]." con email: ".$udata["EMAIL"]." y teléfono: ".$udata["PHONE"];
			$STATE = "3";
			
			$str = "INSERT INTO tns (TCODE, UCODE, TYPE, VALUE, DETAIL, DATE, PCODE, STATE) VALUES ('".$TCODE."','".$UCODE."','".$TYPE."','".$VALUE."','".$DETAIL."','".$DATE."','".$PCODE."','".$STATE."')";
			$query = $this->db->query($str);
			
			

		}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
		
	}
	function insertCode($info)
	{
		$ucode = $info["ucode"];
		$code = $info["code"];
		$SERIE = $info["serie"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$language = "es_co";
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		
		if($info["isser"] == "0")
		{
			$str = "SELECT * FROM stickers WHERE CODE = '".$code."'";
			$query = $this->db->query($str);	
		}
		else
		{
			$str = "SELECT * FROM stickers WHERE CODE = '".$code."' AND SERIE = '".$SERIE."'";
			$query = $this->db->query($str);	
		}

		if(count($query)>0)
		{
			$sticker = $query[0];
			
			if($sticker["STATUS"] == "1")
			{
				if(($sticker["TYPE"][0].$sticker["TYPE"][1]) == "PR")
				{
					$time = explode("-", $sticker["TYPE"])[1];
					$UCODE = $ucode;
					$DATE = $now;
					
					$str = "SELECT PRENDATE FROM users WHERE UCODE = '".$UCODE."'";	
					
					$actualPrend = $this->db->query($str)[0]["PRENDATE"];	

					if($now > $actualPrend)
					{
						$newDate = Date("Y-m-d H:i:s", strtotime("$now +".$time." Month"));
					}
					else
					{
						$newDate = Date("Y-m-d H:i:s", strtotime("$actualPrend +".$time." Month"));
					}
					
					if($info["isser"] == "0")
					{
						$PCODE = $code;
					}
					else
					{
						
						$PCODE = $SERIE."-".$code;
					}
					
					$str = "UPDATE users SET PRENDATE ='$newDate', PREMIUM = '1' WHERE UCODE = '$UCODE'"; 
					$query = $this->db->query($str);
					
					$str = "UPDATE stickers SET STATUS ='2' WHERE CODE = '$PCODE'"; 
					$query = $this->db->query($str);
					
					$ans = "GOOD";
					// $ans = $newDate;
					
				}
				else{}
			}
			else
			{
				$ans = "USED";
			}
		}
		else
		{
			$ans = "NF";
		}

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	
	}
	function contactSend($info)
	{
		$name = $info["name"];
		$mail = $info["mail"];
		$message = $info["message"];
		$scode = $info["scode"];
		
		$str = "SELECT EMAIL FROM hfame WHERE SCODE = '".$scode."' ";
		$query = $this->db->query($str);
		
		$recipient = $query[0]["EMAIL"];
			
		$email_subject ="Mensaje desde Brazil Cocoa ";
		$email_from = $mail;
		$email_message = 
		"<div style='text-align: center; margin: auto; width: 800px !important; background: #F0EDE8; border-radius: 15px;'>".
		$name."te envía el siguiente mensaje desde el sitio Web de Brazil Cocoa: <br><br>".
		utf8_decode($message).
		"<br><br></div>";

		$headers = "From: " . $mail . "\r\n";
		$headers .= "Reply-To: ". $mail . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		// UNLOCK TO SEND
		// mail ($recipient, utf8_decode($email_subject), utf8_decode($email_message), $headers);
		
		$resp["message"] = $recipient;
		$resp["status"] = true;
		return $resp;
		
		
	}
	function contactSendMS($info)
	{
		$name = $info["name"];
		$mail = $info["mail"];
		$umail = $info["umail"];
		$message = $info["message"];
		$scode = $info["scode"];
		
		$str = "SELECT EMAIL FROM hfame WHERE SCODE = '".$scode."' ";
		$query = $this->db->query($str);
		
		$recipient = $umail;
			
		$email_subject ="Mensaje desde tu sitio Web";
		$email_from = $mail;
		$email_message = 
		"<div style='text-align: center; margin: auto; width: 800px !important; background: #F0EDE8; border-radius: 15px;'>".
		$name." te envía el siguiente mensaje desde tu sitio Web de Brazil Cocoa: <br><br>".
		utf8_decode($message).
		"<br><br></div>";

		$headers = "From: " . $mail . "\r\n";
		$headers .= "Reply-To: ". $mail . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		// UNLOCK TO SEND
		mail ($recipient, utf8_decode($email_subject), utf8_decode($email_message), $headers);
		
		$resp["message"] = $recipient;
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
}

?>
