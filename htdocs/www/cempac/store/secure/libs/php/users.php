<?php

date_default_timezone_set('America/Bogota');
// require('../fpdf/mc_table.php');

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require '../phpmailer/Exception.php';
// require '../phpmailer/PHPMailer.php';
// require '../phpmailer/SMTP.php';

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
	function rlAudPro($info)
	{
		$code = $info["c"];
		// $scode = $info["scode"];
		// $type = $info["type"];
		
		if($code == "xxx")
		{
			$str = "SELECT * FROM	users WHERE users.UCODE = '$code'";
		}
		else
		{
			$str = "SELECT * FROM	users WHERE users.UCODE = '$code'";

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

			// $str = "SELECT STYPE FROM stores WHERE SCODE = '$scode'";
			// $stype = $this->db->query($str)[0]["STYPE"];

			
			$str = "SELECT * FROM orders WHERE UCODE = '$code' ORDER BY DATE DESC";
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
	function saveProfile($info)
	{
		
		$name = $info["name"];
		$email = $info["email"];
		$phone = $info["phone"];
		$address = $info["address"];
		$idtype = $info["idtype"];
		$idnumber = $info["idnumber"];
		$ucode = $info["ucode"];
		
		$str = "UPDATE users SET NAME = '".$name."', EMAIL = '".$email."', ADDRESS = '".$address."', PHONE = '".$phone."', IDTYPE = '".$idtype."', IDN = '".$idnumber."' WHERE UCODE='".$ucode."' "; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function mailExist($info)
	{
		$str = "SELECT EMAIL, UCODE FROM users WHERE EMAIL = '".$info["mail"]."'";
		$query = $this->db->query($str);

		if(count($query) > 0)
		{

			$language = $info["lang"];
			$langFile = parse_ini_file("../../lang/lang.ini", true);
			
			$header = $langFile[$language]["recHeader"];
			$message = $langFile[$language]["recMessage"];
			$recLink = $langFile[$language]["recLink"];

			$userEmail = $info["mail"];
			$tmpkey = $query[0]["UCODE"];
			
			$email_subject = $header;
			$email_from = 'info@cempac.co';
			//$email_from = '107.180.58.65';
			
			$email_message = 
			"<div style='text-align: center; margin: auto; width: 800px !important; background: #F0EDE8; border-radius: 15px;'>".
			"<img src='https://cempac.co/store/secure/irsc/pasRecHeader-".$language.".png' style='width=100% !important;'/>".
			"<br><br>".
			"<span style='font-size:14px; '>".utf8_decode($message)."</span>".
			"<br>".
			"<span style='font-size:14px; font-weight: bold;'>"."<a href='https://cempac.co/store/recover.html?me=".$userEmail."&tmpkey=".$tmpkey."'>".htmlentities($recLink)."</a>"."</span>".
			"<br><br>".
			"<img src='https://cempac.co/store/secure/irsc/footer-".$language.".png' style='width=100% !important;'/>".
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
	function setPass($info)
	{
		$code = $info["code"];
		$pass = md5($info["pass"]);
		
		$str = "UPDATE users SET PASSWD = '".$pass."' WHERE UCODE = '".$code."'";
		$query = $this->db->query($str);
		
		$resp["message"] = "pass set";
		$resp["status"] = true;
		return $resp;
	}
	function register($info)
	{
		$str = "SELECT EMAIL FROM users WHERE users.EMAIL = '".$info["email"]."'";
		$query = $this->db->query($str);
	
		$isreging = $info["isreging"];
		
		if(count($query) > 0 )
		{
			
			if($isreging == "1")
			{
				$resp["message"] = "exists";
				return $resp;
			}

		}
		else
		{
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');

			$UCODE = md5($info["email"].$now);
			$NAME = str_replace("'","\\'", $info["name"]);
			$EMAIL = $info["email"];
			$IDN = $info["idnumber"];
			$IDTYPE = $info["rIdtype"];
			$EMAIL = $info["email"];
			$ADDRESS = str_replace("'","\\'", $info["address"]);
			$PHONE = $info["phone"];
			$PASSWD = md5($info["pass"]);
			$STATUS = '1';
			$REGDATE = $now;

			$actualLang = $info["lang"];
			
			$str = "INSERT INTO users (UCODE, NAME, EMAIL, ADDRESS, PHONE, PASSWD, STATUS, REGDATE, IDN, IDTYPE) VALUES ('".$UCODE."','".$NAME."','".$EMAIL."','".$ADDRESS."','".$PHONE."','".$PASSWD."','".$STATUS."','".$REGDATE."', '".$IDN."', '".$IDTYPE."')";
			$query = $this->db->query($str);
			
			$resp["message"] = "created";
			$resp["status"] = true;
			
			// $info["ucode"] = $UCODE;
			// $info["mt"] = '0';
			
			// ------------------LOGSAVE-----------------
				// $logSave = $this->logw($info);
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
	// CHECK FOR NEW ORDERS
	function getNewOrders($info)
	{
		
		
		$str = "SELECT OCODE FROM orders WHERE STATE = '0' ";
		$query = $this->db->query($str);
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	}
	// SAVE PIC
	function picsave($info)
	{
		
		$pic =  $info["pic"];
		$code = $info["code"];
		
		$destination_path = "../../../images/product/";
		
		if($pic != "")
		{
			$hasBG = file_exists($destination_path.$code.'.jpg');
			if($hasBG == true){unlink($destination_path.$code.'.jpg');}
			
			list($type, $pic) = explode(';', $pic);
			list(, $pic)      = explode(',', $pic);
			$imageStr  = base64_decode($pic);
			
			$image = imagecreatefromstring($imageStr);
			imagejpeg($image, $destination_path.$code.'.jpg');

		}
		
		$str = "UPDATE products SET HP = '1' WHERE CODE = '".$code."'";
		$query = $this->db->query($str);
		
		$resp["message"] = "done";
		$resp["status"] = true; 
		return $resp;
	}
	
	function contactSend($info)
	{
		$name = $info["name"];
		$mail = $info["mail"];
		$message = $info["message"];
		
		$sname = "CEMPAC";
		// $recipient = "calidad@cempac.com.co";
		$recipient = "ventaexterna.per@cempac.com.co";
			
		$email_subject ="Mensaje desde el sitio Web de ".$sname;
		$email_from = $mail;
		$email_message = 
		"<div style='text-align: center; margin: auto; width: 800px !important; background: #F0EDE8; border-radius: 15px;'>".
		$name."te envía el siguiente mensaje desde tu sitio Web: <br><br>".
		utf8_decode($message).
		"<br><br></div>";

		$headers = "From: " . $mail . "\r\n";
		$headers .= "Reply-To: ". $mail . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		// UNLOCK TO SEND
		mail ($recipient, utf8_decode($email_subject), utf8_decode($email_message), $headers);
		
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
		
		$resp["message"] = "done";
		$resp["status"] = true; 
		return $resp;
	}
	
	// LISTERS
	function getReport($info)
	{
		$repoType = $info["repoType"];
		
		if($repoType == "productsList")
		{

			$repoCode = $info["repoCode"];
			$repoDesc = $info["repoDesc"];
			$repoHasDet = $info["repoHasDet"];
			$repoTieneDet = $info["repoTieneDet"];
			$repoHasLine = $info["repoHasLine"];
			$repoHasPic = $info["repoHasPic"];
			$repoHasOff = $info["repoHasOff"];
			$repoVisible = $info["repoVisible"];
			$repoArea = $info["repoArea"];

			$where = "WHERE  CODE != 'null' ";

			if($repoCode != ""){$where .= "AND CODE LIKE'%$repoCode%'";} 
			if($repoDesc != ""){$where .= "AND DETAIL LIKE'%$repoDesc%'";} 
			if($repoHasDet != ""){$where .= "AND FDETAIL LIKE'%$repoHasDet%'";} 
			if($repoTieneDet != "")
			{
				if($repoTieneDet == "si")
				{
					$where .= "AND FDETAIL != '' ";
				}
				else
				{
					$where .= "AND FDETAIL = '' ";
				}
			} 
			if($repoHasLine != "")
			{
				if($repoHasLine == "none")
				{
					$where .= "AND CAT = '' ";
				}
				else
				{
					$where .= "AND CAT LIKE'$repoHasLine%'";
				}
			} 
			if($repoHasPic != ""){$where .= "AND HP = '$repoHasPic' ";} 
			if($repoHasOff != ""){$where .= "AND PROMO LIKE'%$repoHasOff%'";} 
			if($repoVisible != ""){$where .= "AND VISIBLE LIKE '%$repoVisible%'";} 
			if($repoArea != ""){$where .= "AND AREA LIKE '%$repoArea%'";} 
			
			$limit = 300;
			
			$str = "SELECT CODE, DETAIL, FDETAIL, CAT, HP, PROMO, PROMOG, AVAILABLE, AREA, VISIBLE, LONDESC  FROM products $where ORDER BY DETAIL ASC LIMIT $limit";
			$query = $this->db->query($str);
			
			$result = $query;
		}
		if($repoType == "catsList")
		{
			$repoCode = $info["repoCode"];
			$repoDesc = $info["repoDesc"];
			$repoHasDet = $info["repoHasDet"];
			$repoVisible = $info["repoVisible"];
			
			$where = "WHERE  CODE != 'null' ";
			
			if($repoCode != ""){$where .= "AND CODE LIKE'%$repoCode%'";} 
			if($repoDesc != ""){$where .= "AND DETAIL LIKE'%$repoDesc%'";} 
			if($repoHasDet != ""){$where .= "AND FDETAIL LIKE'%$repoHasDet%'";}  
			if($repoVisible != ""){$where .= "AND VISIBLE LIKE '%$repoVisible%'";} 
			
			$str = "SELECT *  FROM cats $where ORDER BY CODE ASC";
			$query = $this->db->query($str);
			
			$result = $query;
			
		}
		if($repoType == "rfList")
		{
			$repoCode = $info["repoCode"];
			$repoDesc = $info["repoDesc"];
			$repoHasDet = $info["repoHasDet"];
			$repoVisible = $info["repoVisible"];
			$repoColor = $info["repoColor"];
			
			$where = "WHERE  CODE != 'null' ";
			
			if($repoCode != ""){$where .= "AND CODE LIKE'%$repoCode%'";} 
			if($repoDesc != ""){$where .= "AND DETAIL LIKE'%$repoDesc%'";} 
			if($repoHasDet != ""){$where .= "AND FDETAIL LIKE'%$repoHasDet%'";}  
			if($repoVisible != ""){$where .= "AND VISIBLE LIKE '%$repoVisible%'";} 
			if($repoColor != "")
			{
				if($repoColor == "0")
				{
					$where .= "AND COLOR = '' ";
				}
				else
				{
					$where .= "AND COLOR != '' ";
				}
				
			} 
			
			$str = "SELECT * FROM exts $where ORDER BY CODE ASC";
			$query = $this->db->query($str);
			
			$result = $query;
			
		}
		if($repoType == "clientList")
		{
			$str = "SELECT * FROM users WHERE TYPE = '0' ORDER BY NAME ASC";
			$query = $this->db->query($str);
			
			$result = $query;
			
		}
		if($repoType == "ordersList")
		{
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

			
			$str = "SELECT * FROM orders $where ORDER BY DATE DESC";
			$query = $this->db->query($str);
			
			$result = $query;
			
		}
		if($repoType == "losesList")
		{
			$repoCode = $info["repoCode"];
			$repoProduct = $info["repoProduct"];
			$repoLocation = $info["repoLocation"];
			$repoIniDate = $info["repoIniDate"];
			$repoEndDate = $info["repoEndDate"];
			
			$where = "WHERE  oitems.REQUESTED != oitems.DISPATCHED ";
			
			if($repoCode != ""){$where .= "AND CODE LIKE'%$repoCode%'";} 
			if($repoProduct != ""){$where .= "AND DETAIL LIKE'%$repoProduct%'";} 
			if($repoLocation != ""){$where .= "AND INVENTORY LIKE'%$repoLocation%'";} 
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
			

			
			$str = "SELECT * FROM oitems $where ORDER BY INVENTORY DESC, DATE DESC";
			$query = $this->db->query($str);
			
			$result = $query;
			
		}
		
		$resp["message"] = $result ;
		$resp["status"] = true;
		return $resp;
	}
	function getCats($info)
	{
		$str = "SELECT * FROM cats ORDER BY CODE ASC";
		$cats = $this->db->query($str);
		
		$resp["message"] = $cats ;
		$resp["status"] = true;
		return $resp;
	}
	function starter($info)
	{
		$loc = $info["loc"];
		$locode = $info["locode"];
		
		
		
		$str = "SELECT PL1, PL2, PL5 FROM zones WHERE CODE = '".$locode."'";
		$lists = $this->db->query($str);
		
		if(count($lists) > 0)
		{
			$list1 = $lists[0]["PL1"];
			$list2 = $lists[0]["PL2"];
			$list5 = $lists[0]["PL5"];
		}
		
		if(count($info["group"]) > 0)
		{
			$tag = $info["group"][0];
			$where = "WHERE products.CODE = '$tag' ";
			
			if(count($info["group"]) > 1)
			{
				for($i=1; $i<count($info["group"]);$i++)
				{
					$where .= " OR products.CODE = '".$info["group"][$i]."' ";
				}
			}

			$str = "SELECT * FROM products INNER JOIN prices ON prices.CODE LIKE products.MCODE $where";

		}
		else
		{
			
			if($loc == "")
			{
				// GET ALL PROMO PRODUCTS
				$str = "SELECT * FROM products WHERE VISIBLE = '1' AND PROMO != '0' ORDER BY MCODE ASC, AVAILABLE DESC, CODE ASC";
			}
			else
			{
				// GET ALL ZONE-INV PRODUCTS
								
			
				$str = "SELECT prices.".$list1.", prices.".$list2.", prices.".$list5.", CAT, products.CODE, EXT, FDETAIL, PROMO FROM products INNER JOIN prices ON prices.CODE LIKE products.MCODE WHERE VISIBLE = '1' AND AREA = '".$loc."' AND HP = '1' AND products.AVAILABLE > '0' ORDER BY products.MCODE ASC, products.CODE ASC";
				
				// $products = $this->db->query($str);
				
				// $resp["message"] = $products;
				// $resp["status"] = true;
				// return $resp;
			}
		}


		$products = $this->db->query($str);

		$str = "SELECT * FROM exts WHERE VISIBLE = '1' ORDER BY CODE ASC";
		$exts = $this->db->query($str);

		$str = "SELECT * FROM banner";
		$banner = $this->db->query($str)[0]["BTEXT"];
		
		$str = "SELECT * FROM cats WHERE VISIBLE = '1' ORDER BY DETAIL ASC, FDETAIL ASC";
		$cats = $this->db->query($str);
		
		$str = "SELECT * FROM zones WHERE VISIBLE = '1' ORDER BY NAME ASC";
		$zones = $this->db->query($str);
		
		
		
		$today = "hoy";
		$tomorrow = "mañana";
		$ett = "ET";
		
		if($loc == "")
		{
			$nextDel = "blank";
			$today = "hoy";
			$tomorrow = "mañana";
			$ett = "ET";
		}
		else
		{
			// GET NEXT DELIVER DATE FOR LOCATION
			
			$code = $locode;
		
			$today = new DateTime();
			$today = $today->format('Y-m-d');
			
			$str = "SELECT * FROM ddates WHERE ZCODE = '".$code."' AND DATE > '".$today."' ORDER BY DATE ASC";
			$query = $this->db->query($str);
			
			if(count($query) > 0)
			{
				$nextDel = $query[0]["DATE"];
				
				if(count($query) > 1)
				{
					$nextnextDel = $query[1]["DATE"];
					
					$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));
					if($nextDel == $tomorrow)
					{
						$nextDel = $nextnextDel;
						$et = "0";
					}
					
					$str = "SELECT * FROM unable WHERE DATE > '".$today."' ORDER BY DATE ASC";
					$query = $this->db->query($str);
					
					$unlist = $query;
					// $nextUnable = $unlist[0]["DATE"];
					
					$unlistReady = [];

					
					for($i=0; $i<count($unlist); $i++)
					{
						$item = $unlist[$i]["DATE"];
						$unlistReady[$i] = $item;
					}

					$tomoBase = $tomorrow." 00:00:00";
					$tomoDate = new DateTime($tomoBase);
					$tomoDate->modify('+1 day');
					$pasTomorrow = $tomoDate->format('Y-m-d');
					
					$manana = strtotime($tomorrow);
					$manaday = date("l", $manana);
					
					
					if(in_array($tomorrow, $unlistReady))
					{$see = "yes";}
					else{$see = "no";}
					
					if($see == "yes" and $nextDel == $pasTomorrow)
					{
						$nextDel = $nextnextDel;
						$et = "1";
					}
					
					$ndday = strtotime($nextDel);
					$nddayday = date("l", $ndday);
					
					if(($manaday == "Saturday" or $manaday == "Sunday") and $nddayday == "Monday")
					{
						$nextDel = $nextnextDel;
						$et = "2";
					}

				}
			}
			else
			{
				$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));
				$nextDel = "setNextDay";
			}

		}
		
		// GET FORBBIDEN LIST
		$str = "SELECT * FROM unable ORDER BY DATE ASC";
		$forbidden = $this->db->query($str);
		$list = $forbidden;
		$forbidden = [];
		for($i=0; $i<count($list);$i++)
		{
			$date = $list[$i]["DATE"];
			array_push($forbidden, $date);
		}
		
		$et = "none";
		
		$data = array();
		$data["banner"] = $banner;
		$data["products"] = $products;
		$data["cats"] = $cats;
		$data["zones"] = $zones;
		
		$data["exts"] = $exts;
		$data["nextDel"] = $nextDel;
		$data["forbidden"] = $forbidden;
		$data["today"] = $today;
		$data["tomorrow"] = $tomorrow;
		$data["enterTest"] = $et;
		
		
		$resp["message"] = $data ;
		$resp["status"] = true;
		return $resp;
	}
	function getBanner($info)
	{
		
		$str = "SELECT *  FROM banner";
		$query = $this->db->query($str)[0]["BTEXT"];
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getLongs($info)
	{
		
		$loc = $info["location"];
		
		$strLong = "SELECT CODE, LONDESC FROM products WHERE HP = '1' AND VISIBLE = '1' AND AREA = '".$loc."' GROUP BY CODE ORDER BY CODE ASC";
		$longDescs = $this->db->query($strLong);
		
		
		$ans = $longDescs;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function zStarter($info)
	{
		$str = "SHOW COLUMNS FROM prices";
		$headers = $this->db->query($str);
		
		$str = "SELECT * FROM zones ORDER BY NAME ASC";
		$zones = $this->db->query($str);
		
		$data = array();

		$data["zones"] = $zones;
		$data["headers"] = $headers;
		
		$resp["message"] = $data ;
		$resp["status"] = true;
		return $resp;
	}
	function getUnableList($info)
	{
		$str = "SELECT * FROM unable ORDER BY DATE ASC";
		$query = $this->db->query($str);
		
		$resp["message"] = $query ;
		$resp["status"] = true;
		return $resp;
	}
	function getDdates($info)
	{
		$code = $info["code"];
		
		$today= new DateTime();
		$today = $today->format('Y-m-d');
		
		$str = "SELECT * FROM ddates WHERE ZCODE = '".$code."' AND DATE >= '".$today."' ORDER BY DATE ASC";
		$query = $this->db->query($str);
		
		$resp["message"] = $query ;
		$resp["status"] = true;
		return $resp;
	}
	
	// ORDERGET
	function orderGet($info)
	{

		$UADDRESS = $info["dAddress"];
		$UPHONE = $info["dPhone"];
		$OLOCATION = $info["locDesc"];
		$UCODE = $info["ucode"];
		$UNAME = $info["uname"];
		$UMAIL = $info["umail"];
		$ORDERED = $info["total"];
		$DISPATCHED = $info["total"];
		$WPCK = $info["wpck"];
		$UIDTYPE = $info["uIdType"];
		$UIDNUM = $info["uIdNum"];
		
		$inventory = $info["inventory"];
		$items = $info["items"];
		
		$nowCode = new DateTime();
		$nowCode = $nowCode->format('Y-m-d H:i:s');
		
		// CHECK IF FISRT ORDER AND AMOUNT
		
		$str = "SELECT UMAIL FROM orders WHERE 
		UMAIL = '".$UMAIL."'";
		$query = $this->db->query($str);
		
		if(count($query) == 0)
		{
			$MINFIRST = intval($info["MINFIRST"]);
			
			if($ORDERED < $MINFIRST)
			{
				$resp["message"] = "notMinFirst";
				$resp["status"] = true;
				return $resp;
			}
			
		}
		
		
		
		
		
		$OCODE = md5($nowCode.$UMAIL);
		
		$str = "INSERT INTO orders (OCODE, UCODE, UNAME, UADDRESS, UPHONE, OLOCATION, ORDERED, DISPATCHED, UMAIL, DATE, WPCK, UIDTYPE, UIDNUM) VALUES ('".$OCODE."','".$UCODE."','".$UNAME."','".$UADDRESS."','".$UPHONE."','".$OLOCATION."','".$ORDERED."','".$DISPATCHED."','".$UMAIL."','".$nowCode."', '".$WPCK."', '".$UIDTYPE."', '".$UIDNUM."')";
		
		$query = $this->db->query($str);
		
		$list = $items;
		
		for($i=0; $i<count($list);$i++)
		{
			$item = $list[$i];
			
			$CODE = $item["CODE"];
			$DETAIL = $item["DESC"];
			$REQUESTED = $item["QTY"];
			$DISPATCHED = $item["QTY"];
			$PLIST = $item["PLIST"];
			$PRICE = $item["PRICE"];
			$INVENTORY = $item["INVENTORY"];

			$str = "INSERT INTO oitems (OCODE, CODE, DETAIL, REQUESTED, DISPATCHED, PLIST, PRICE, INVENTORY, DATE) VALUES ('".$OCODE."','".$CODE."','".$DETAIL."','".$REQUESTED."','".$DISPATCHED."','".$PLIST."','".$PRICE."','".$INVENTORY."','".$nowCode."')";
			$query = $this->db->query($str);

		}
		
		$resp["message"] = $list;
		$resp["status"] = true;
		return $resp;
		
	}
	
	// SAVERS
	function saveZone($info)
	{
		$action = $info["action"];
		$name = $info["name"];
		$inv = $info["inv"];
		$l1 = $info["l1"];
		$l2 = $info["l2"];
		$l5 = $info["l5"];
		// $l3 = $info["l3"];
		// $l4 = $info["l4"];
		$topD = $info["topD"];
		$topDT = $info["topT"];
		$top = $info["top"];
		$start = $info["start"];
		$end = $info["end"];
		$MINFIRST = $info["MINFIRST"];
		
		if($start != "")
		{
			$drange = $start."<->".$end;
		}
		else
		{
			$drange = "";
		}
		
		
		if($action == "c")
		{
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			$code = md5($now);

			$str = "INSERT INTO zones (CODE, NAME, PL1, PL2, PL5, DRANGE, BTOP, DTOP, AREA, DTOPT, MINFIRST) VALUES ('".$code."','".$name."','".$l1."','".$l2."','".$l5."', '".$drange."','".$top."','".$topD."','".$inv."','".$topDT."','".$MINFIRST."')";
			$query = $this->db->query($str);

		}
		else
		{
			$code = $info["ecode"];
			
			$str = "UPDATE zones SET NAME = '".$name."', PL1 = '".$l1."', PL2 = '".$l2."', PL5 = '".$l5."', DRANGE = '".$drange."', BTOP = '".$top."', DTOP = '".$topD."',  AREA = '".$inv."', DTOPT = '".$topDT."', MINFIRST = '".$MINFIRST."' WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
		}
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
		
	}
	function saveUnable($info)
	{
		$date = $info["date"];
		
		$str = "SELECT * FROM unable WHERE DATE = '".$date."'ORDER BY DATE ASC";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$resp["message"] = "exist";
			$resp["status"] = true;
			return $resp;
		}
		
		
		$str = "INSERT INTO unable (DATE) VALUES ('".$date."')";
		$query = $this->db->query($str);
		
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
		
	}
	function saveBanner($info)
	{
		$btext = $info["btext"];
		
		$str = "UPDATE banner SET BTEXT = '".$btext."'";
		$query = $this->db->query($str);
		
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
		
	}
	function addDeliverDate($info)
	{
		$code = $info["code"];
		$date = $info["date"];
		
		// CHECK IF EXIST
		
		$str = "SELECT * FROM ddates WHERE DATE = '".$date."' AND ZCODE = '".$code."' ORDER BY DATE ASC";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$resp["message"] = "exist";
			$resp["status"] = true;
			return $resp;
		}
		
		// CHECK IF IS BANNED DATE
		
		$str = "SELECT DATE FROM unable WHERE DATE = '".$date."'";
		$query = $this->db->query($str);	
		
		if(count($query) > 0)
		{
			$resp["message"] = "banned";
			$resp["status"] = true;
			return $resp;
		}

		$str = "INSERT INTO ddates (ZCODE, DATE) VALUES ('".$code."', '".$date."')";
		$query = $this->db->query($str);
		
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
		
	}
	
	// SWITCH VISIBLE STATE
	function staterVisible($info)
	{
		$code = $info["code"];
		$table = $info["table"];
		$nactual = $info["nactual"];
		
		if($table == "products")
		{
			$area = $info["area"];
			
			$str = "UPDATE $table SET VISIBLE = $nactual WHERE AREA = '$area' AND CODE = '$code'";
		}
		if($table == "cats")
		{
			$str = "UPDATE $table SET VISIBLE = $nactual WHERE CODE = '$code'";
		}
		if($table == "exts")
		{
			$str = "UPDATE $table SET VISIBLE = $nactual WHERE CODE = '$code'";
		}
		if($table == "zones")
		{
			$str = "UPDATE $table SET VISIBLE = $nactual WHERE CODE = '$code'";
		}
		
		
		
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
	
	// SWITCH PROMO STATE
	function staterPromo($info)
	{

		$area = $info["area"];
		$code = $info["code"];
		$nactual = $info["nactual"];
		
		if($nactual == "0")
		{
			$str = "UPDATE products SET PROMOG = $nactual WHERE CODE = '$code'";
			$query = $this->db->query($str);
		}
		
		$str = "UPDATE products SET PROMO = $nactual WHERE AREA = '$area' AND CODE = '$code'";
		$query = $this->db->query($str);

		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
	
	// SWITCH PROMO STATE GLOBAL
	function staterPromoG($info)
	{

		$area = $info["area"];
		$code = $info["code"];
		$nactual = $info["nactual"];
		
		$str = "UPDATE products SET PROMOG = $nactual WHERE CODE = '$code'";
		$query = $this->db->query($str);
		
		$str = "UPDATE products SET PROMO = $nactual WHERE CODE = '$code'";
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
	
	// SET NEW DETAIL PRODUCT
	function setNewDet($info)
	{

		$code = $info["code"];
		$input = $info["input"];
		
		$str = "UPDATE products SET FDETAIL = '$input' WHERE CODE = '$code'";
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
	
	// SET NEW LONG DETAIL PRODUCT
	function setNewLongDet($info)
	{

		$code = $info["code"];
		$input = $info["input"];
		
		$str = "UPDATE products SET LONDESC = '$input' WHERE CODE = '$code'";
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
	
	// SET NEW DETAIL LINE
	function setNewDetCat($info)
	{

		$code = $info["code"];
		$input = $info["input"];
		
		$str = "UPDATE cats SET FDETAIL = '$input' WHERE CODE = '$code'";
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
	
	// SET NEW DETAIL EXT
	function setNewDetExt($info)
	{

		$code = $info["code"];
		$input = $info["input"];
		
		$str = "UPDATE exts SET FDETAIL = '$input' WHERE CODE = '$code'";
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
		
	// SET NEW CAT
	function setNewCat($info)
	{

		$code = $info["code"];
		$input = $info["input"];
		
		$str = "UPDATE products SET CAT = '$input' WHERE CODE = '$code'";
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
	
	// SET ORDER STATE
	function setOstate($info)
	{

		$code = $info["code"];
		$input = $info["input"];
		
		$str = "UPDATE orders SET STATE = '$input' WHERE OCODE = '$code'";
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
	
	// SET DISPATCHED
	function setDispatched($info)
	{

		$orderCode = $info["orderCode"];
		$itemCode = $info["itemCode"];
		$qty = $info["qty"];
		$total = $info["total"];
		
		$str = "UPDATE orders SET DISPATCHED = '$total' WHERE OCODE = '$orderCode'";
		$query = $this->db->query($str);
		
		$str = "UPDATE oitems SET DISPATCHED = '$qty' WHERE OCODE = '$orderCode' AND CODE = '".$itemCode."'";
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
	
	// GET ORDER ITEMS
	function getOitems($info)
	{

		$code = $info["code"];
		
		$str = "SELECT * FROM oitems WHERE OCODE = '$code'";
		$query = $this->db->query($str);
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
		
	}
	
	// SET COLOR
	function setColor($info)
	{

		$code = $info["code"];
		$color = $info["color"];
		
		$str = "UPDATE exts SET COLOR = '$color' WHERE CODE = '$code'";
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = true;
		return $resp;
		
	}
	
	// DELETER
	function regDelete($info)
	{
		$table = $info["table"];
		$code = $info["code"];
		$delType = $info["delType"];
		
		if($delType == "zone")
		{
			
			$str = "DELETE FROM $table WHERE $table.CODE = '".$code ."' ";
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
				// $logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}
		if($delType == "clientList")
		{
			
			$str = "DELETE FROM $table WHERE UCODE = '".$code ."' ";
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
				// $logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}
		if($delType == "unable")
		{
			$str = "DELETE FROM $table WHERE $table.DATE = '".$code ."' ";
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
				// $logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}
		if($delType == "ddates")
		{
			
			$date = $info["date"];
			
			$str = "DELETE FROM $table WHERE $table.DATE = '".$date."' AND $table.ZCODE = '".$code ."'";
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
				// $logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}


		$resp["message"] = "deleted";
		$resp["status"] = true;
		return $resp;
	}
	
	// EXPORT CSV
	function exportReport($info)
	{
		
		$repoType = $info["repoType"];		
				
		if($repoType == "users")
		{
				
			$str = "SELECT * FROM users WHERE TYPE = '0' ORDER BY NAME ASC";
			$query = $this->db->query($str);
			
			$result = $query;
			
			$csvString = "# Id; Nombre completo; Dirección; Teléfono; E-mail; \n";
			
			for($i = 0; $i<count($result);$i++)
			{
				
				$f= utf8_decode(urldecode($result[$i]["IDN"]));
				$b= utf8_decode(urldecode($result[$i]["NAME"]));
				$c= utf8_decode(urldecode($result[$i]["ADDRESS"]));
				$e= utf8_decode(urldecode($result[$i]["PHONE"]));
				$a = utf8_decode(urldecode($result[$i]["EMAIL"]));
				
				// Numero de cedula- nombres completos-direccion con la ciudad a parte-telefono-correo electronico

				$csvString .= "\"$f\";\"$b\";\"$c\";\"$e\";\"$a\" \n";
			}

			file_put_contents("../../report/reporte.csv", $csvString);
		}
		
		
		$resp["message"] = $result ;
		$resp["status"] = true;
		return $resp;
	}
	
	// PLAIN TXT LOAD
	function updateFromFile($info)
	{
		
		// $etime = ini_get('max_execution_time');
		// $resp["message"] = $etime;
		// $resp["status"] = true; 
		// return $resp;
		
		$filename =  $info["filename"];

		$filePath = "../../tmpLoad/".$filename.".txt";
		
		$data = file_get_contents($filePath);
		$data = mb_convert_encoding($data, 'UTF-8');
		file_put_contents($filePath, $data);
		
		$file = file_get_contents($filePath);
		$lines = $this->multiexplode(array("\n", "+-"),$file);
		
		$str = "SELECT CODE, AREA FROM products";
		$pcodes = $this->db->query($str);	

		$iniName = $this->cutter($filename, 3)[0];
		
		if(strlen($filename) > 4)
		{
			$iniName2 = $this->cutter($filename, 5)[0];
		}
		else
		{
			$iniName2 = $iniName;
		}
		
		if($iniName == "INV")
		{
			$pick = array();
			$count = 0;
		
			for($i=0; $i < count($lines); $i++)
			{
				$line = $lines[$i];
				
				if(strlen($line) > 0 and strlen($line) > 125)
				{
					if($line[0] == "0")
					{
						
						// $resp["message"] = $line;
						// $resp["status"] = true; 
						// return $resp;
						
						$code = trim($this->cutter($line, 10)[0]);
						$rest = $this->cutter($line, 10)[1];
						
						$mcode = explode("-", $code)[0];
						
						if(count(explode("-", $code)) > 1)
						{
							$ext = $this->cutter($code, 7)[1];
						}
						else
						{
							$ext = "";
						}
						
						$detail = trim($this->cutter($rest, 49)[0]);
						$rest = $this->cutter($rest, 50)[1];
						
						$qty = trim($this->cutter($rest, 15)[0]);
						$rest = $this->cutter($rest, 14)[1];
						
						$unit = trim($this->cutter($rest, 12)[0]);
						$rest = $this->cutter($rest, 12)[1];
						
						$asigned = trim($this->cutter($rest, 8)[0]);
						$rest = $this->cutter($rest, 8)[1];
						
						$ocop = trim($this->cutter($rest, 8)[0]);
						$rest = $this->cutter($rest, 8)[1];
						
						$requer = trim($this->cutter($rest, 8)[0]);
						$rest = $this->cutter($rest, 8)[1];
						
						$engaged = trim($this->cutter($rest, 8)[0]);
						$rest = $this->cutter($rest, 8)[1];
						
						$available = trim($this->cutter($rest, 8)[0]);
						$rest = $this->cutter($rest, 8)[1];
						
						$area = $filename;
						
						$reg = array();
						$reg["CODE"] = $code;
						$reg["MCODE"] = explode("-", $code)[0];
						$reg["DETAIL"] = $detail;
						$reg["QTY"] = $qty;
						$reg["UNIT"] = $unit;
						$reg["ASIGNED"] = $asigned;
						$reg["OCOP"] = $ocop;
						$reg["REQUER"] = $requer;
						$reg["ENGAGED"] = $engaged;
						$reg["AVAILABLE"] = $available;
						

						$str = "INSERT INTO products 
						
						(CODE,
						MCODE,
						EXT,
						DETAIL,
						QTY,
						UNIT,
						ASIGNED,
						OCOP,
						REQUER,
						ENGAGED,
						AVAILABLE,
						AREA)
						
						VALUES 
						
						('".$code."',
						'".$mcode."',
						'".$ext."',
						'".$detail."',
						'".$qty."',
						'".$unit."',
						'".$asigned."',
						'".$ocop."',
						'".$requer."',
						'".$engaged."',
						'".$available."',
						'".$area."'
						) 
						ON DUPLICATE KEY UPDATE
						
						MCODE = '".$mcode."', 
						EXT = '".$ext."', 
						DETAIL = '".$detail."', 
						QTY = '".$qty."', 
						UNIT = '".$unit."', 
						ASIGNED = '".$asigned."', 
						OCOP = '".$ocop."', 
						REQUER = '".$requer."', 
						ENGAGED = '".$engaged."', 
						AVAILABLE = '".$available."'

						";
						
						$query = $this->db->query($str);

						$pick[$count] = $reg;
						
						$count++;
					}
				}

			}
			
			$result = $pick;
		}
		
		if($filename == "CATS")
		{
			$lineas = array();
			$products = array();

			$count1 = 0;
			$count2 = 0;
			$countR = 0;

			for($i=0; $i < count($lines); $i++)
			{
				$line = $lines[$i];
				
				if(strlen($line) > 0)
				{
					if($line[0] == "C")
					{

						if($line[0] == "P" or $line[0] == "E"){continue;}
						
						$reg = array();
						
						if($line[0] == "C")
						{
							
							$title = trim($this->cutter($line, 11)[0]);
							$rest = $this->cutter($line, 11)[1];
							
							$code = trim($this->cutter($rest, 6)[0]);
							$rest = $this->cutter($rest, 6)[1];
							
							$detail = trim(explode(":",trim(explode($code,trim($rest))[0]))[0]);
							
							$reg["code"] = $code;
							$reg["detail"] = $detail;
							
							$lineas[$count1] = $reg;
							$count1++;
						}

					}
					elseif($line[0] == "0")
					{
						
						$reg = array();
						
						$product = $line;
				
						$code = trim($this->cutter($product, 11)[0]);
						$rest = $this->cutter($line, 11)[1];
						
						$detail = trim($this->cutter($rest, 41)[0]);
						$rest = $this->cutter($rest, 41)[1];
						
						$ref = trim($this->cutter($rest, 16)[0]);
						$rest = $this->cutter($rest, 16)[1];
						
						$unit = trim($this->cutter($rest, 11)[0]);
						$rest = $this->cutter($rest, 11)[1];
						
						$space = trim($this->cutter($rest, 78)[0]);
						$rest = $this->cutter($rest, 78)[1];
						
						$cline = trim($this->cutter($rest, 4)[0]);
						$rest = $this->cutter($rest, 4)[1];

						$reg["code"] = $code;
						$reg["cline"] = $cline;

						if($count2 < 300)
						{
							$products[$count2] = $reg;
							$count2++;
						}
						else
						{
							$productsR[$countR] = $reg;
							$countR++;
						}
						
						
					}
				
				}

			}
	
			for($i = 0; $i < count($lineas); $i++)
			{
				$detail = str_replace("CATEGORI", "", $lineas[$i]["detail"]);
				$lineas[$i]["detail"] = $detail;
			}
			
			// $tmpans = [$lineas, $products];
			// $resp["message"] = $tmpans;
			// $resp["status"] = true; 
			// return $resp;
			
			for($i = 0; $i < count($lineas); $i++)
			{
				$linea = $lineas[$i];
				
				$code = $linea["code"];
				$detail = $linea["detail"];
				
				$len = strlen($code);
				
				$field = "CODE";

				$str = "INSERT INTO cats 
					
					($field,
					DETAIL
					)
					
					VALUES 
					
					('".$code."',
					'".$detail."'
					) 
					ON DUPLICATE KEY UPDATE
					
					DETAIL = '".$detail."'
					";

				$query = $this->db->query($str);
				
			}
			
			for($i = 0; $i < count($products); $i++)
			{
				$product = $products[$i];
				$code = $product["code"];
				$cline = $product["cline"];
				
				$str = "UPDATE products SET CAT = '$cline'  WHERE CODE LIKE '%$code%'";
				$query = $this->db->query($str);
			}
			
			$productsR = array_chunk($productsR,300);
			$result = $productsR;

		}

		if($filename == "RFLIST")
		{
			$pick = array();
			$count = 0;
			
			for($i=0; $i < count($lines); $i++)
			{
				$line = $lines[$i];
				
				if(strlen($line) > 12 and $line[0] != "|" and $line[0] != "-")
				{
					$code = trim($this->cutter($line, 12)[0]);
					$rest = $this->cutter($line, 12)[1];
					
					$detail = trim($rest);

					$reg = array();
					$reg["CODE"] = $code;
					$reg["DETAIL"] = $detail;

					$str = "INSERT INTO exts 
					
					(CODE,
					DETAIL
					)

					VALUES 
					
					('".$code."',
					'".$detail."'
					) 
					
					ON DUPLICATE KEY UPDATE
					DETAIL = '".$detail."' 

					";
					
					$query = $this->db->query($str);

					$pick[$count] = $reg;
					
					$count++;
				}
			}
			
			$result = $pick;
		}
		
		if($iniName2 == "PLIST")
		{
			$lists = array();
			$products = array();

			$count1 = 0;
			$count2 = 0;
			
			// GET HEADS AND ITEMS
			for($i=0; $i < count($lines); $i++)
			{
				$line = $lines[$i];

				if(strlen($line) > 1)
				{
					if(($line[0].$line[1]) != "|0")
					{
						if($line[0] == "|")
						{
							if(!strpos($line, 'PAGINA') !== false)
							{
								if(!strpos($line, 'PAQ') !== false)
								{
									if(!strpos($line, 'RES') !== false)
									{
										if(!strpos($line, 'CAJ') !== false)
										{
											if($line[0].$line[1].$line[2].$line[3] == "|   ")
											$lists[$count1] = $line;
											$count1 = $count1+1;
										}
									}
								}
							}
						}
					}
					else
					{
						$products[$count2] = $line;
						$count2 ++;
					}
				}
			}
			
			$titLine = reset($lists);
			$headers = explode("|", $titLine);
			$hPicks = array();
			$count = 0;
			
			// SPLIT HEADERS IN ARRAY
			for($i=0; $i < count($headers); $i++)
			{
				$pos = trim($headers[$i]);
				if($pos != "")
				{
					$hPicks[$count] = $pos;
					$count++;
				}
			}
			$headers = $hPicks;

			// SPLIT PRODUCTS IN ARRAY
			$splitedP = array();
			$count = 0;
			for($i=0; $i < count($products); $i++)
			{
				$product = array_map('trim', explode('|', $products[$i]));
				$cline = $product[1];
				$cline = trim($this->cutter($cline, 10)[0]);
				$product[1] = $cline;
				$product = array_slice($product, 1, -1);
				$splitedP[$count] = $product;
				$count++;
			}

			$products = $splitedP;
			
			$str = "SHOW COLUMNS FROM prices";
			$tHeaders = $this->db->query($str);
			$actualFields = array();
			
			// CHECK IF HEADERS EXIST OR CREATE
			for($i=0; $i < count($tHeaders); $i++)
			{
				$tHeader = $tHeaders[$i]["Field"];
				array_push($actualFields, $tHeader);
			}
			for($i=0; $i < count($headers); $i++)
			{
				$field = $headers[$i];
				if(!in_array($field, $actualFields))
				{
					$str = "ALTER TABLE prices ADD $field VARCHAR(20) AFTER CODE";
					$query = $this->db->query($str);
				}
			}
			
			// CONSTRUCT QUERY
			$str1 = "INSERT INTO prices";
			
			$fields = " (CODE,";
			
			// SET FIELDS
			for($i=0; $i < count($headers); $i++)
			{
				$field = $headers[$i];
				$fields.= $field;
				
				if($i != count($headers)-1)
				{
					$fields.=",";
				}
				else if($i == count($headers)-1)
				{
					$fields.=") VALUES";
				}
			}

			$str1 .= $fields;
			
			$tst = array();
			
			for($i=0; $i < count($products); $i++)
			{
				$product = $products[$i];
				$str = $str1;
				$code = "'".$product[0]."'";
				// VALUES
				$vList = array();
				
				$values = " ($code,";
				
				for($j=1; $j < count($headers)+1; $j++)
				{
					$value = "'".$product[$j]."'";
					array_push($vList, $value);
					$values.= $value;
					
					if($j != count($headers))
					{
						$values.=",";
					}
					else if($j == count($headers))
					{
						$values.=") ";
					}
				}
				
				$str .= $values ."ON DUPLICATE KEY UPDATE ";
				
				$fList = $headers;

				$comp = array();
				$comp[0] = $fList;
				$comp[1] = $vList;

				for($n=0; $n < count($fList); $n++)
				{
					$add = $fList[$n]." = ".$vList[$n];
					
					if($n != count($fList)-1)
					{
						$add.=", ";
					}

					$str .= $add ;
				}
				
				array_push($tst, $str);
				
				$query = $this->db->query($str);
			}

			
			$reg["THDRS"] = $tst;
			$reg["HEADERS"] = $headers;
			$reg["PRODUCTS"] = $products;


			$result = $reg;

		}
		
		$resp["message"] = $result;
		$resp["status"] = true; 
		return $resp;
		
	}
	function updateFromFileCatRest($info)
	{
		
		$rest = $info["rest"];
		
		$list = $rest[0];
		
		for($i = 0; $i < count($list); $i++)
		{
			$product = $list[$i];
			$code = $product["code"];
			$cline = $product["cline"];
			
			$str = "UPDATE products SET CAT = '$cline'  WHERE CODE LIKE '%$code%'";
			$query = $this->db->query($str);
		}
		
		$resp["message"] = $rest;
		$resp["status"] = true; 
		return $resp;
	}
	function multiexplode($delimiters,$string) 
	{

		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return  $launch;
	}
	function cutter($string, $pos) 
	{
		list($beg, $end) = preg_split('/(?<=.{'.$pos.'})/', $string, 2);
		$res = array();
		$res[0] = $beg;
		$res[1] = $end;
		
		return  $res;
	}
	// PLAIN TXT LOAD
	
	
	
}

?>
