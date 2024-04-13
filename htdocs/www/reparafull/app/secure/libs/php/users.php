<?php

date_default_timezone_set('America/Bogota');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/Exception.php';
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';

class users
{
	//REPARAFULL START -------------------------
	
	function __construct()
	{
		$this->db = new sql_query();
	}
	function langGet($info)
	{
		$answer = [];
		
		$language = $info["lang"];
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		
		$answer["lang"] = $langFile[$language];
		
		$count = $info["count"];
		
		$str = "SELECT COUNTER FROM vcount WHERE TYPE = 'visits'";
		$query = $this->db->query($str);

		$actualCount = intval($query[0]["COUNTER"]);
		
		if($count == "1")
		{
			$newcount = $actualCount+1;
			$str = "UPDATE vcount SET COUNTER='".$newcount."' WHERE TYPE='visits'"; 
			$query = $this->db->query($str);
			
			$str = "SELECT COUNTER FROM vcount WHERE TYPE = 'visits'";
			$query = $this->db->query($str);
			$answer["visits"] = $query[0]["COUNTER"];
		}
		
		
		
		$str = "SELECT * FROM cats WHERE STATUS = '1'";
		$query = $this->db->query($str);
		
		$answer["cats"] = $query;
		
		$resp["message"] = $answer;
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
			
			// ORDER ARRAY BY KEY -------------------------------
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
			// ORDER ARRAY BY KEY -------------------------------
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
	function statusChange($info)
	{
		$code = $info["code"];
		$type = $info["type"];
		$state = $info["state"];
		
		if($type == "u")
		{
			$str = "UPDATE users SET STATUS = '".$state."'  WHERE UCODE ='".$code."'";
			$query = $this->db->query($str);
			
			$str = "UPDATE works SET STATUS = '".$state."' WHERE AUTORCODE ='".$code."'";
			$query = $this->db->query($str);
		}
		
		if($type == "w")
		{
			$str = "UPDATE works SET STATUS = '".$state."' WHERE CODE ='".$code."'";
			$query = $this->db->query($str);
		}
		
		if($type == "p")
		{
			$str = "UPDATE works SET STATUS = '".$state."' WHERE CODE ='".$code."'";
			$query = $this->db->query($str);
		}
		
		if($type == "c")
		{
			$str = "UPDATE comments SET STATUS = '".$state."' WHERE CODE ='".$code."'";
			$query = $this->db->query($str);
		}

		
		
		$ans = $query;
		
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
	function register($info)
	{
		
		// $resp["status"] = true;
		// $resp["message"] = $info;
		// return $resp;
		
		$str = "SELECT EMAIL FROM users WHERE users.EMAIL = '".$info["email"]."' AND  TYPE = '".$info["type"]."'";
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
			$ADDRESS = str_replace("'","\\'", $info["address"]);
			$PHONE = $info["phone"];
			$PASSWD = md5($info["pass"]);
			$STATUS = '1';
			$REGDATE = $now;
			$LOCATION = $info["rLocation"];
			$IDTYPE = $info["idtype"];
			$IDNUMBER = $info["idnumber"];
			$TYPE = $info["type"];

			$actualLang = $info["lang"];
			
			$str = "INSERT INTO users (UCODE, NAME, EMAIL, ADDRESS, PHONE, PASSWD, STATUS, REGDATE, IDTYPE, IDNUMBER, TYPE, LOCATION) VALUES ('".$UCODE."','".$NAME."','".$EMAIL."','".$ADDRESS."','".$PHONE."','".$PASSWD."','".$STATUS."','".$REGDATE."','".$IDTYPE."','".$IDNUMBER."','".$TYPE."','".$LOCATION."')";
			$query = $this->db->query($str);
			
			
			$resp["status"] = true;
			
			$dpkc = array();
			$dpkc["email"] = $EMAIL;
			$dpkc["type"] = "4";
			$data = array();
			$dpkc["data"] = $data;
			$ans = $this-> notificate($dpkc)["message"];
			
			$resp["message"] = $ans;

		}

		return $resp;
	}
	function login($info)
	{
		
		$str = "SELECT * FROM users WHERE users.EMAIL = '".$info["autor"]."' AND users.PASSWD = '".md5($info["pssw"])."' AND TYPE = '".$info["type"]."'";

		$query = $this->db->query($str);	

		if(count($query) > 0)
		{
			if($query[0]["STATUS"] == "0")
			{
				$resp["message"] = "Disabled";
				$resp["status"] = true;
				return $resp;
			}

			if($info["autor"] == "hvelez@incocrea.com" or $info["autor"] == "calidad@cempac.com.co")
			{$query[0]["logued"] = "2";}
			else{$query[0]["logued"] = "1";}
			
			$resp["message"] = $query[0];
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$info["ucode"] = $query[0]["UCODE"];
			$info["mt"] = '1';
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
	function rlAud($info)
	{
		$code = $info["c"];
		$type = $info["type"];
		
		$str = "SELECT * FROM	users WHERE users.UCODE = '$code' AND TYPE = '$type'";
		
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
			
			if($mail == "hvelez@incocrea.com" or $mail == 	"calidad@cempac.com.co")
			{$query[0]["logued"] = "2";}
			else
			{$query[0]["logued"] = "1";}
			
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
	function mailExist($info)
	{
		
		$str = "SELECT EMAIL, UCODE FROM users WHERE EMAIL = '".$info["mail"]."' AND TYPE = '0'";
		$query = $this->db->query($str);

		if(count($query) > 0)
		{
			
			$smail = "admin@reparafull.com";
			
			$language = $info["lang"];
			$langFile = parse_ini_file("../../lang/lang.ini", true);
			
			$header = $langFile[$language]["recHeader"];
			$message = $langFile[$language]["recMessage"];
			$recLink = $langFile[$language]["recLink"];

			$userEmail = $info["mail"];
			$tmpkey = $query[0]["UCODE"];
			
			$email_subject = $header;
			$email_from = $smail;
			$email_message = 
			"<div style='text-align: center; margin: auto; width: 800px !important; background: #F0EDE8; border-radius: 15px;'>".
			"<img src='https://reparafull.com/app/img/pasRecHeader-".$language.".png' style='width=100% !important;'/>".
			"<br><br>".
			"<span style='font-size:14px; '>".utf8_decode($message)."</span>".
			"<br>".
			"<span style='font-size:14px; font-weight: bold;'>"."<a href='https://reparafull.com/app/index.php?me=".$userEmail."&tmpkey=".$tmpkey."'>".htmlentities($recLink)."</a>"."</span>".
			"<br><br>".
			"<img src='https://reparafull.com/app/img/footer-".$language.".png' style='width=100% !important;'/>".
			"</div>";
			
			$headers = "From: " . $email_from . "\r\n";
			$headers .= "Reply-To: ". $email_from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			mail ($userEmail, htmlEntities($email_subject), utf8_decode($email_message), $headers);
						
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
	function notificate($info)
	{
		$type = $info["type"];
		$email = $info["email"];
		$data = $info["data"]; 
		
		$destiny = $email;

		//SEND STARTER MAIL ------------
		$from = 'reparafullcolombia@gmail.com';		
		$host = 'smtp.gmail.com';
		$pssw = 'Incocre@2018';
		
		
		if($type == "0")
		{
			$fromName = "Reparafull.com - Comentarios";
			$subject = "Hay un nuevo comentario en tu publicación";
			$content = "Hay un nuevo comentario en tu publicación:<br>------------------<br>".$data["DETAIL"]."<br>------------------<br>Para ver los comentarios visita tu publicación en reparafull.com<br><br><a href='https://reparafull.com/app?direct=".$data["CODE"]."'><b>Ir a la plataforma</b></a>";
		}
		if($type == "1")
		{
			$fromName = "Reparafull.com - Propuestas";
			$subject =  "Hay una nueva propuesta";
			$content = "Has recibido una nueva propuesta, <br>------------------<br>".$data["DETAIL"]."<br>------------------<br>Para revisar la propuesta visita tu publicación en reparafull.com<br><br><a href='https://reparafull.com/app?direct=".$data["CODE"]."'><b>Ir a la plataforma</b></a>";
		}
		if($type == "2")
		{
			$contactName = "Nombre: ".$data["NAME"];
			$contactMail = "Email: ".$data["EMAIL"];
			$contactAddress = "Dirección: ".$data["ADDRESS"];
			$contactPhone = "Teléfono: ".$data["PHONE"];
			
			$cData = $contactName."<br>".$contactMail."<br>".$contactAddress."<br>".$contactPhone;
			
			$fromName = "Reparafull.com - Te han seleccionado";
			$subject =  "Tu propuesta fue seleccionada";
			$content = "Se ha seleccionado tu propuesta en Reparafull<br><br>Estos son los datos de contacto:<br><br>".$cData."<br><br>Para ver los detalles visita la plataforma<br><br><a href='https://reparafull.com/app?direct=".$data["WCODE"]."'><b>Ir a la plataforma</b></a>";
		}
		if($type == "3")
		{
			$contactName = "Nombre: ".$data["NAME"];
			$contactMail = "Email: ".$data["EMAIL"];
			$contactAddress = "Dirección: ".$data["ADDRESS"];
			$contactPhone = "Teléfono: ".$data["PHONE"];
			
			$cData = $contactName."<br>".$contactMail."<br>".$contactAddress."<br>".$contactPhone;
			
			$fromName = "Reparafull.com - Has seleccionado una propuesta";
			$subject =  "Has seleccionado una propuesta";
			$content = "Ha seleccionado una propuesta para tu publicación<br><br>Estos son los datos de contacto:<br><br>".$cData."<br><br>Para ver los detalles de la publicación visita la plataforma<br><br><a href='https://reparafull.com/app?direct=".$data["WCODE"]."'><b>Ir a la plataforma</b></a>";
		}
		if($type == "4")
		{
			$fromName = "Confirmación de registro ReparaFull";
			$subject =  "Bienvenid@ a Reparafull";
			$content = "Bienvenid@<br><br>Gracias por registrate en ReparaFull!<br><br>Esperamos que encuentres lo que búscas ya sea solución a un problema o reparaciones para realizar.";
		}
		if($type == "5")
		{
			$catDet = $info["catDet"]; 
			$fromName = "ReparaFull";
			$subject =  "Se han creato trabajos en: ".$catDet;
			$content = "Hola<br><br>se han creado nuevos trabajos para expertos en:  <b>".$catDet."</b><br><br>ingresa a <a href='https://reparafull.com/app'><b>Reparafull</b></a> para revisarlos.";
		}

		$content = htmlEntities($content);
		$content = html_entity_decode($content);
		$mail = new PHPMailer();
		
		//Server settings
		$mail->SMTPDebug = 2;  
		$mail->CharSet = 'UTF-8';
		$mail->Host = $host;
		$mail->Username = $from;
		$mail->Password = $pssw;
		$mail->Port = 587;  
		$mail->SMTPSecure = 'tls';   
		$mail->SMTPAuth = true;    
		$mail->From = $from;
		$mail->FromName= $fromName;
		$mail->IsHTML(true);
		$mail->Subject = $subject;
		$mail->AddReplyTo($from, 'Contacto Reparafull.com');
		$mail->AddAddress($destiny);
		
		$br = "<br><br>";
		$logo = "<div style='text-align: center;'><img style='max-width: 300px;' src='https://reparafull.com/app/img/logo.png'/><div>".$br;
		
		$header = "<div style='text-align: center;'><b>Contacto del equipo Reparafull.com </b></div>".$br;
		
		$message = "<div style='text-align: justify;'>".$content ."</div>".$br;
		
		$body = $logo.$header.$message;

		$mail->Body = $body; 

		// Envía el correo.
		
		// DISABLE FOR TESTING ENABLE FOR PRODUCTIVE
		// $exito = $mail->Send(); 
		// DISABLE FOR TESTING ENABLE FOR PRODUCTIVE
		
		// ENABLE FOR TESTING ENABLE FOR PRODUCTIVE
		$exito = true;
		// ENABLE FOR TESTING ENABLE FOR PRODUCTIVE
		
		if($exito){$ans = "enviado";}else{$ans = $mail->ErrorInfo;} 
		
		//SET CLIENT STATE

		$resp["message"] = $content;
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
	// GET LISTS
	function listGet($info)
	{
		$type = $info["type"];
		
		if($type == "users")
		{
			$name = $info["name"];
			$id = $info["id"];
			
			$where = "WHERE  UCODE != '' ";
			
			if($name != ""){$where .= "AND NAME LIKE '%$name%'";} 
			if($id != ""){$where .= "AND IDNUMBER LIKE '%$id%'";} 
			
			$str = "SELECT *  FROM users $where ORDER BY PASSED DESC, NAME ASC";
			$query = $this->db->query($str);
			
			$ulist = $query;
			
			for($i=0; $i<count($ulist); $i++)
			{
				$item = $ulist[$i];
				$uCode = $item["UCODE"];
				$localInfo = array();
				$localInfo["code"] = $uCode;
				$rate = $this-> getTechRate($localInfo)["message"];
				$jobs = $this-> getUjobs($localInfo)["message"];
				$ulist[$i]["RATE"] = $rate;
				$ulist[$i]["JOBS"] = $jobs;
			}
			
			$result = $ulist;
			
		}
		if($type == "jobs")
		{
			$name = $info["name"];
			$mode = $info["mode"];
			$state = $info["state"];
			$location = $info["location"];
			
			$where = "WHERE TYPE = '1' ";
			
			if($name != "")
			{
				if($mode == "")
				{
					$where .= "AND (TECHNAME LIKE '%$name%' OR AUTOR LIKE '%$name%')";
				}
				if($mode == "1")
				{
					$where .= "AND AUTOR LIKE '%$name%'";
				}
				if($mode == "2")
				{
					$where .= "AND TECHNAME LIKE '%$name%'";
				}
			} 

			if($state != ""){$where .= "AND STATE = '$state'";} 
			if($location != ""){$where .= "AND LOCATION LIKE '%$location%'";} 
			
			$str = "SELECT *  FROM works $where ORDER BY CREATED DESC";
			$query = $this->db->query($str);
			$result = $query;
		}
		if($type == "parts")
		{
			$name = $info["name"];
			$mode = $info["mode"];
			$state = $info["state"];
			$location = $info["location"];
			
			$where = "WHERE TYPE = '2' ";
			
			if($name != "")
			{
				if($mode == "")
				{
					$where .= "AND (TECHNAME LIKE '%$name%' OR AUTOR LIKE '%$name%')";
				}
				if($mode == "1")
				{
					$where .= "AND AUTOR LIKE '%$name%'";
				}
				if($mode == "2")
				{
					$where .= "AND TECHNAME LIKE '%$name%'";
				}
			} 

			if($state != ""){$where .= "AND STATE = '$state'";} 
			if($location != ""){$where .= "AND LOCATION LIKE '%$location%'";} 
			
			$str = "SELECT *  FROM works $where ORDER BY CREATED DESC";
			$query = $this->db->query($str);
			$result = $query;
		}
		if($type == "comments")
		{
			$name = $info["name"];
			$key = $info["key"];
			$date = $info["date"];

			$where = "WHERE  CODE != '' ";
			
			if($name != ""){$where .= "AND AUTOR LIKE '%$name%'";} 
			if($key != ""){$where .= "AND CONTENT LIKE '%$key%'";} 
			if($date != ""){$where .= "AND DATE > '$date'";} 
			
			$str = "SELECT *  FROM comments $where ORDER BY DATE DESC";
			$query = $this->db->query($str);
			$result = $query;
		}
		if($type == "offers")
		{
			$name = $info["name"];
			$key = $info["key"];
			$date = $info["date"];
			$state = $info["state"];

			$where = "WHERE  CODE != '' ";
			
			if($name != ""){$where .= "AND TECHNAME LIKE '%$name%'";} 
			if($key != ""){$where .= "AND COMMENTS LIKE '%$key%'";} 
			if($date != ""){$where .= "AND DATE > '$date'";} 
			if($state != ""){$where .= "AND STATE = '$state'";} 
			
			$str = "SELECT *  FROM offers $where ORDER BY CREATED DESC";
			$query = $this->db->query($str);
			$result = $query;
		}
		if($type == "cats")
		{
			$str = "SELECT *  FROM cats ORDER BY TYPE ASC, DETAIL ASC";
			$query = $this->db->query($str);
			
			for($i=0; $i<count($query); $i++)
			{
				$item = $query[$i];
				$code = $item["CODE"];
				$localInfo = array();
				$localInfo["code"] = $code;
				$works = $this-> getCatWorks($localInfo)["message"];

				$query[$i]["JOBS"] = $works;
			}
			
			
			$result = $query;
		}
		
		
		$ans = $result;
		
		$resp["message"] = $ans;
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
	// DELETER
	function regDelete($info)
	{
		$table = $info["table"];
		$code = $info["code"];
		$delType = $info["delType"];
		$scode = $info["scode"];
		
		$ans = "done";
		
		if($delType == "zone")
		{
			
			$str = "DELETE FROM $table WHERE $table.CODE = '".$code ."' AND SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
				// $logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}
		if($delType == "cats")
		{
			
			$code = $info["code"];
			
			$str = "DELETE FROM $table WHERE $table.CODE = '".$code."' AND SCODE = '".$scode."'";
			$query = $this->db->query($str);
		}
		if($delType == "gpausers")
		{
			
			$code = $info["code"];
			
			$str = "SELECT SCODE FROM gpausers WHERE EMAIL = '".$code."'";
			$query = $this->db->query($str);	
			
			if($query[0]["SCODE"] != "")
			{
				$scode = $query[0]["SCODE"];
				$info = array();
				$info["table"] = "stores";
				$info["code"] = $scode;
				$info["delType"] = "stores";
				$info["scode"] = $scode;
				$this-> regDelete($info);
			}
			$str = "DELETE FROM $table WHERE $table.EMAIL = '".$code."' AND SCODE = '".$scode."'";
			$query = $this->db->query($str);
		}
		if($delType == "exts")
		{
			
			$code = $info["code"];
			
			$str = "DELETE FROM $table WHERE $table.CODE = '".$code."' AND SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
				// $logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}
		if($delType == "clientList")
		{
			
			$code = $info["code"];
			
			$str = "DELETE FROM $table WHERE UCODE = '".$code."' AND SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
				// $logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}
		if($delType == "products")
		{
			$code = $info["code"];
			$ext = $info["ext"];
			
			$str = "DELETE FROM $table WHERE $table.MCODE = '".$code."' AND EXT = '".$ext."' AND SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			$destination_path = "../../../images/product/".$scode."-";
			
			if($ext != ""){	$code = $code."-".$ext;}
			
			$hasBG = file_exists($destination_path.$code.'.jpg');
			if($hasBG == true){unlink($destination_path.$code.'.jpg');}
			
			$hasBG = file_exists($destination_path.$code.'-b.jpg');
			if($hasBG == true){unlink($destination_path.$code.'-b.jpg');}
			
			$destination_path = "../../pfiles/".$scode."-";
			$file_pattern = $destination_path.$code.".*";
			array_map( "unlink", glob( $file_pattern ));
			
			// ------------------LOGSAVE-----------------
				// $logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}
		if($delType == "stores")
		{
			$scode = $info["scode"];
			
			// DEL COMPANY PICS
			
			$sl1_path = "../../../images/slider/".$scode."-pcs1.jpg";
			$sl2_path = "../../../images/slider/".$scode."-pcs2.jpg";
			$sl3_path = "../../../images/slider/".$scode."-pcs3.jpg";
			
			$h1_path = "../../../images/home/".$scode."-pch1.jpg";
			$h2_path = "../../../images/home/".$scode."-pch2.jpg";
			$h3_path = "../../../images/home/".$scode."-pch3.jpg";
			$h4_path = "../../../images/home/".$scode."-pch4.jpg";
			
			$a1_path = "../../../images/about/".$scode."-pca1.jpg";
			$a2_path = "../../../images/about/".$scode."-pca2.jpg";
			$a3_path = "../../../images/about/".$scode."-pca3.jpg";

			$logo_path = "../../../images/logo/".$scode."-logo.jpg";
			
			$accessFile = "../../../stores/store".$scode."/index.php";

			$list = [$sl1_path,$sl2_path,$sl3_path,$h1_path, $h2_path, $h3_path, $h4_path, $a1_path, $a2_path, $a3_path, $logo_path,$accessFile];

			for($i=0; $i<count($list);$i++)
			{
				$path = $list[$i];
				$exists = file_exists($path);
				if($exists == true){unlink($path);}
			}
			
			rmdir('../../../stores/store'.$scode.'/');
			
			// DEL PRODUCTS PICS
			
			$str = "SELECT CODE FROM products WHERE SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			$list = $query;
			
			for($i=0; $i<count($list);$i++)
			{
				$path = "../../../images/product/".$scode."-".$list[$i]["CODE"].".jpg";
				$exists = file_exists($path);
				if($exists == true){unlink($path);}
			}
			
			// DEL STORE REGS
			
			$str = "DELETE FROM cats WHERE SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM exts WHERE SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM oitems WHERE SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM orders WHERE SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM payway WHERE SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM products WHERE SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM users WHERE SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM zones WHERE SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM stores WHERE SCODE = '".$scode."'";
			$query = $this->db->query($str);
			
			$ans = $sl1_path;

		}

		$resp["message"] = $ans;
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
	// PLAIN TXT LOAD
	function updateFromFile($info)
	{
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

			for($i=0; $i < count($lines); $i++)
			{
				$line = $lines[$i];
				
				if(strlen($line) > 0)
				{
					if($line[0] == "L" or strlen($line) < 100)
					{
						
						if($line[0] == "P" or $line[0] == "E"){continue;}
						
						$reg = array();
						
						if($line[0] == "L")
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
						else
						{
							if(strlen($line) < 120)
							{
								$line = trim($line);
							}
							
							if($line != "")
							{
								$code = trim($this->cutter($line, 10)[0]);
								$rest = $this->cutter($line, 10)[1];
								
								$detail = trim(explode($code,trim($rest))[0]);
								
								$reg["code"] = $code;
								$reg["detail"] = $detail;
								
								$lineas[$count1] = $reg;
								$count1++;
							}
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
						
						$space = trim($this->cutter($rest, 66)[0]);
						$rest = $this->cutter($rest, 66)[1];
						
						$cline = trim($this->cutter($rest, 6)[0]);
						$rest = $this->cutter($rest, 6)[1];
						
						
						$reg["code"] = $code;
						$reg["cline"] = $cline;

						$products[$count2] = $reg;
						$count2++;
					}

				}
				
				
			}
			
			for($i = 0; $i < count($lineas); $i++)
			{
				if($lineas[$i]["detail"][0] != "L")
				{
					$detail = str_replace("LINEA", "", $lineas[$i]["detail"]);
					$lineas[$i]["detail"] = $detail;
				}
				
			}
			
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

			$result = $lineas;

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
	
	//REPARAFULL END -------------------------
}

?>
