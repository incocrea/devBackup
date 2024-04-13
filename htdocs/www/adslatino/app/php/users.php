<?php

date_default_timezone_set('America/Bogota');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require('phpExcel/Classes/PHPExcel.php');

class users
{
	function __construct()
	{
		$this->db = new sql_query();
	}
	function langGet($info)
	{
		$answer = [];
		$language = $info["lang"];
		$langFile = parse_ini_file("../lang/lang.ini", true);
		$answer["lang"] = $langFile[$language];
		$location = $info["mainLocation"];
		
		$str = "SELECT *  FROM ad_cats ORDER BY CATDESC ASC";
		$query = $this->db->query($str);
		$answer["cats"] = $query;
		
		$str = "SELECT *  FROM ad_clients WHERE LOCATION = '".$location."' ORDER BY CAT";
		$query = $this->db->query($str);
		$answer["clients"] = $query;
		
		$resp["message"] = $answer;
		$resp["status"] = true; 
		return $resp;
		
	}
	function suscribe($info)
	{
		$name = $info["name"];
		$email = $info["email"];
		$phone = $info["phone"];
		
		$str = "INSERT INTO ad_signed (NAME, EMAIL, PHONE) VALUES ('".$name."','".$email."','".$phone."') ON DUPLICATE KEY UPDATE NAME = '".$name."', PHONE = '".$phone."'";
		$query = $this->db->query($str);
		
		
		$ans = "done";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getClients($info)
	{
		$cat = $info["cat"];
		$loc = $info["loc"];
		
		$where = "WHERE  STATE != 'null' ";
		
		if($cat != ""){$where .= " AND CAT = '$cat'";} 
		if($cat != ""){$where .= " AND LOCATION = '$loc'";} 
		
		
		$str = "SELECT *  FROM ad_clients $where ORDER BY CAT ASC,INDX ASC, NAME ASC";
		$query = $this->db->query($str);
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveClient($info)
	{
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$MODE = $info["MODE"];
		
		$CAT = $info["CAT"];
		$LOCATION = $info["LOCATION"];
		$NAME = str_replace("'","\\'", $info["NAME"]);		
		$ADDRESS = str_replace("'","\\'", $info["ADDRESS"]);	
		$PHONE = $info["PHONE"];
		$EMAIL = $info["EMAIL"];
		$GMAP = $info["GMAP"];
		$VIDEO = $info["VIDEO"];
		$WEB = $info["WEB"];
		$FBLINK = $info["FBLINK"];
		$IGLINK = $info["IGLINK"];
		$INDX = $info["INDX"];
		$ENDATE = $info["ENDATE"];
		
		if($MODE == "c")
		{
			$CODE = md5($now.$EMAIL);
			
			$str = "INSERT INTO ad_clients (CODE, CAT, LOCATION, NAME, ADDRESS, PHONE, EMAIL, GMAP, VIDEO, WEB, FBLINK, IGLINK, INDX, ENDATE) VALUES ('".$CODE."', '".$CAT."', '".$LOCATION."', '".$NAME."', '".$ADDRESS."', '".$PHONE."', '".$EMAIL."', '".$GMAP."', '".$VIDEO."','".$WEB."','".$FBLINK."','".$IGLINK."','".$INDX."','".$ENDATE."')";
			$query = $this->db->query($str);
			
			mkdir('../files/'.$CODE, 0777, true);
			
			$orig = '../isrc/nopic.jpg';
			$dest1 = '../files/'.$CODE.'/1.jpg';
			$dest2 = '../files/'.$CODE.'/2.jpg';
			$dest3 = '../files/'.$CODE.'/3.jpg';
			$dest4 = '../files/'.$CODE.'/4.jpg';
			$dest5 = '../files/'.$CODE.'/5.jpg';
			
			copy($orig, $dest1);
			copy($orig, $dest2);
			copy($orig, $dest3);
			copy($orig, $dest4);
			copy($orig, $dest5);
			
		}
		else
		{
			$CODE = $info["ECODE"];
			
			$str = "UPDATE ad_clients SET CAT = '".$CAT."', LOCATION = '".$LOCATION."', NAME = '".$NAME."', ADDRESS = '".$ADDRESS."', PHONE = '".$PHONE."', EMAIL = '".$EMAIL."', GMAP = '".$GMAP."', VIDEO = '".$VIDEO."', WEB = '".$WEB."', FBLINK = '".$FBLINK."', IGLINK = '".$IGLINK."',INDX = '".$INDX."', ENDATE = '".$ENDATE."' WHERE CODE ='".$CODE."'";
			$query = $this->db->query($str);
			
		}
		
		
		
		$ans = "saved";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveDetails($info)
	{
		$code = $info["code"];		
		$details = str_replace("'","\\'", $info["details"]);		

		
		$str = "UPDATE ad_clients SET DETAIL = '".$details."' WHERE CODE ='".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveStyles($info)
	{
		$CODE = $info["CODE"];		
		$TITFONT = $info["TITFONT"];		
		$TITSIZE = $info["TITSIZE"];		
		$TITCOLOR = $info["TITCOLOR"];		
		$TITSHOWNAME = $info["TITSHOWNAME"];		
		$TITBGCOLOR = $info["TITBGCOLOR"];		
		$TITBGPIC = $info["TITBGPIC"];		
		$DESCFONT = $info["DESCFONT"];		
		$DESCSIZE = $info["DESCSIZE"];		
		$DESCCOLOR = $info["DESCCOLOR"];		
		$DESCALIGN = $info["DESCALIGN"];		
		$DESCBGCOLOR = $info["DESCBGCOLOR"];		
		$GALLERYBGCOLOR = $info["GALLERYBGCOLOR"];		
		
		
		$str = "UPDATE ad_clients SET TITFONT = '".$TITFONT."', TITSIZE = '".$TITSIZE."', TITCOLOR = '".$TITCOLOR."', TITSHOWNAME = '".$TITSHOWNAME."', TITBGCOLOR = '".$TITBGCOLOR."', TITBGPIC = '".$TITBGPIC."', DESCFONT = '".$DESCFONT."', DESCSIZE = '".$DESCSIZE."', DESCCOLOR = '".$DESCCOLOR."', DESCALIGN = '".$DESCALIGN."', DESCBGCOLOR = '".$DESCBGCOLOR."', GALLERYBGCOLOR = '".$GALLERYBGCOLOR."' WHERE CODE ='".$CODE."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getClientImages($info)
	{
		$code = $info["code"];
		
		$str = "SELECT *  FROM ad_client_images WHERE CLIENTCODE = '".$code."' ORDER BY IMGPOS ASC";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function deleteItem($info)
	{
		$code = $info["code"];
		$type = $info["type"];
		
		if($type == "client")
		{
			$str = "DELETE FROM ad_clients WHERE CODE ='".$code."'";
			$query = $this->db->query($str);
			
			$dir_path = "../files/".$code."/";
			$this->delDir($dir_path);
			
		}
		if($type == "image")
		{
			$str = "DELETE FROM ad_client_images WHERE IMGCODE ='".$code."'";
			$query = $this->db->query($str);
		}

		
		$ans = "deleted";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function delDir($path)
	{
		if (is_dir($path) === true)
		{
			$files = array_diff(scandir($path), array('.', '..'));

			foreach ($files as $file)
			{
				$this->delDir(realpath($path) . '/' . $file);
			}

			return rmdir($path);
		}

		else if (is_file($path) === true)
		{
			return unlink($path);
		}

		return false;
	}
	// SAVE PIC
	function picsave($info)
	{
		
		$pic =  $info["pic"];
		$picPos =  $info["picPos"];
		$code = $info["code"];
		$picType = $info["picType"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$piCode = md5($code.$now);
		
		$destination_path = "../files/".$code."/".$picType;
		
		if($pic != "")
		{
			// $hasBG = file_exists($destination_path.'.jpg');
			// if($hasBG == true){unlink($destination_path.'.jpg');}
			
			// list($type, $pic) = explode(';', $pic);
			// list(, $pic)      = explode(',', $pic);
			
			// $imageStr  = base64_decode($pic);

			// $incoming = $pic;
			// $mainImage = str_replace('data:image/jpeg;base64,', '', $incoming);
			// file_put_contents($destination_path.'.jpg', base64_decode($mainImage));
			
			$str = "INSERT INTO ad_client_images (IMGCODE, CLIENTCODE, IMGSTRING, IMGPOS) VALUES ('".$piCode."', '".$code."', '".$pic."', '".$picPos."')";
			$query = $this->db->query($str);
			
		}
		
		// $field = "PIC$picType";
		
		// $str = "UPDATE ad_clients SET $field = '1' WHERE CODE ='".$code."'";
		// $query = $this->db->query($str);
		
		$resp["message"] = $picType;
		$resp["status"] = true; 
		return $resp;
	}
	function login($info)
	{
		$pass = $info["pass"];
		
		if($pass == "ads"){$ans = "1";}
		else{$ans = "0";}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getClient($info)
	{
		$code = str_replace("'","\\'", $info["code"]);	

		$str = "UPDATE ad_clients SET LOADED = (LOADED+1) WHERE NAME = '".$code."'";
		$query = $this->db->query($str);

		
		$str = "SELECT *  FROM ad_clients WHERE NAME = '".$code."'";
		$query = $this->db->query($str)[0];
		
		$ccode = $query["CODE"];
		
		$str = "SELECT * FROM ad_client_images WHERE CLIENTCODE = '".$ccode."' ORDER BY IMGPOS ASC";
		$imgs = $this->db->query($str);
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["imgs"] = $imgs;
		$resp["status"] = true;
		return $resp;
	}
	
	
	// ---------------------------END ADS LAT -------------------------
	

	function rlAud($info)
	{
		$code = $info["c"];
		$str = "SELECT * FROM lr_trusers WHERE CODE = '$code'";
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
			
			// CHECK FOR NEW LIKES
			$code = $query[0]["CODE"];
			$str = "SELECT STATUS FROM lr_likes WHERE FRIENDCODE = '".$code."' AND STATUS = '0'";
			$unread = $this->db->query($str);
			if(count($unread) > 0)
			{$query[0]["unread"] = count($unread);}
			else{$query[0]["unread"] = "0";}
						
			$str = "SELECT STATUS FROM lr_friends WHERE CODE2 = '".$code."' AND STATUS = '0'";
			$unfriend = $this->db->query($str);
			if(count($unfriend) > 0)
			{$query[0]["unfriend"] = count($unfriend);}
			else{$query[0]["unfriend"] = "0";}
			
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
	function logw($info)
	{
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$mt = $info["mt"];
		$ucode = $info["code"];
		
		$str = "INSERT INTO lr_log (DATE, MT, UCODE) VALUES ('".$now."', '".$mt."', '".$ucode."')";
		$query = $this->db->query($str);
		
		return;

	}
	function register($info)
	{
		$str = "SELECT EMAIL FROM lr_trusers WHERE EMAIL = '".$info["email1"]."'";
		$query = $this->db->query($str);
	
		$mode = $info["mode"];
		
		if(count($query) > 0 )
		{
			if($mode == "0")
			{
				$resp["message"] = "exists";
				return $resp;
			}
			else
			{
				
				$CODE = $info["code"];
				$NAME = str_replace("'","\\'", $info["name"]);
				$BDAY = $info["bday"];
				$PHONE = $info["phone"];
				$GENDER = $info["gender"];
				$LOCATION = $info["loc"];
				$PASSWD = md5($info["pass1"]);
				$AVATAR = $info["avatar"];
				
				if($info["changePass"] == "1")
				{
					$str = "UPDATE lr_trusers SET NAME = '".$NAME."', BDAY = '".$BDAY."', PHONE = '".$PHONE."', GENDER = '".$GENDER."', LOCATION = '".$LOCATION."', AVATAR = '".$AVATAR."', PASS = '".$PASSWD."' WHERE CODE ='".$CODE."'";
					$resp["message"] = "updatedpc";
				}
				else
				{
					$str = "UPDATE lr_trusers SET NAME = '".$NAME."', BDAY = '".$BDAY."', PHONE = '".$PHONE."', GENDER = '".$GENDER."', LOCATION = '".$LOCATION."', AVATAR = '".$AVATAR."' WHERE CODE ='".$CODE."'";
					$resp["message"] = "updatednpc";
				}
				$query = $this->db->query($str);
				
				return $resp;
			}
		}
		else
		{
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');

			$CODE = md5($info["email1"].$now);
			$NAME = str_replace("'","\\'", $info["name"]);
			$EMAIL = $info["email1"];
			$BDAY = $info["bday"];
			$PHONE = $info["phone"];
			$GENDER = $info["gender"];
			$LOCATION = $info["loc"];
			$PASSWD = md5($info["pass1"]);
			$STATUS = '1';
			$REGDATE = $now;
			$AVATAR = $info["avatar"];
			
			$str = "INSERT INTO lr_trusers (CODE, NAME, EMAIL, BDAY, PHONE, GENDER, LOCATION, PASS, STATUS, REGDATE, AVATAR) VALUES ('".$CODE."','".$NAME."','".$EMAIL."','".$BDAY."','".$PHONE."','".$GENDER."','".$LOCATION."','".$PASSWD."','".$STATUS."','".$REGDATE."','".$AVATAR."')";
			$query = $this->db->query($str);
			
			$data = array();
			$data["ntype"] = "s01";
			$data["user"] = $CODE;
			
			$this->notifUser($data);
			
			$resp["message"] = "created";
			$resp["status"] = true;
		}
		return $resp;
		
	}
	function getFriends($info)
	{
		$code = $info["code"];
		$today = $info["today"];
		$whose = $info["whose"];
		
		$str = "SELECT CODE, CODE2, STATUS FROM lr_friends WHERE CODE = '".$code."' OR CODE2 = '".$code."' ORDER BY CHANGED DESC";
		$query = $this->db->query($str);
		
		$relations = $query;
		
		for($i=0; $i<count($relations); $i++)
		{
			$item = $relations[$i];
			$dcode1 = $item["CODE"];
			$dcode2 = $item["CODE2"];

			if($dcode1 == $code)
			{
				$str = "SELECT NAME, EMAIL, AVATAR FROM lr_trusers WHERE CODE = '".$dcode2."'";
				$udata = $this->db->query($str);
			}
			else
			{
				$str = "SELECT NAME, EMAIL, AVATAR FROM lr_trusers WHERE CODE = '".$dcode1."'";
				$udata = $this->db->query($str);
			}
			$name = $udata[0]["NAME"];
			$email = $udata[0]["EMAIL"];
			$avatar = $udata[0]["AVATAR"];
			
			$relations[$i]["NAME"] = $name;
			$relations[$i]["EMAIL"] = $email;
			$relations[$i]["AVATAR"] = $avatar;
		}
		
		if($whose == "0")
		{
			$indexCode = md5($code.$today);
			$str = "SELECT LIKED FROM  lr_loved WHERE CODE = '".$indexCode."'";
			$query = $this->db->query($str);
			if(count($query) > 0)
			{
				$resp["liked"]= $query;
			}
			else
			{
				$resp["liked"]= [];
			}
		}
		else
		{
			$resp["liked"]= [];
		}

		$resp["message"] = $relations;
		$resp["status"] = true;
		return $resp;
	}
	function addFriend($info)
	{
		$code1 = $info["code"];
		$email = $info["email"];
			
		$str = "SELECT CODE FROM lr_trusers WHERE EMAIL = '".$email."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$code2 = $query[0]["CODE"];
			
			$str = "SELECT STATUS,CODE FROM lr_friends WHERE (CODE = '".$code1."' AND CODE2 = '".$code2."') OR (CODE2 = '".$code1."' AND CODE = '".$code2."')";
			$query = $this->db->query($str);
			
			if(count($query) > 0)
			{
				$rcode = $query[0]["CODE"];
				
				if($rcode == $code1)
				{
					$resp["message"] = "autores".$query[0]["STATUS"];
				}
				else
				{
					$resp["message"] = "friendes".$query[0]["STATUS"];
				}
			}
			else
			{
				$now = new DateTime();
				$now = $now->format('Y-m-d H:i:s');
				
				$str = "INSERT INTO  lr_friends (CODE,CODE2,STATUS,SENT,CHANGED) VALUES ('".$code1."','".$code2."','0','".$now."','".$now."')";
				$query = $this->db->query($str);
				
				$resp["message"] = "sent";
			}
		}
		else
		{
			$resp["message"] = "nuser";
		}
		
		$resp["status"] = true;
		return $resp;
	}
	function addFriendDirect($info)
	{
		$code1 = $info["code1"];
		$code2 = $info["code2"];
		
		$str = "SELECT STATUS,CODE FROM lr_friends WHERE (CODE = '".$code1."' AND CODE2 = '".$code2."') OR (CODE2 = '".$code1."' AND CODE = '".$code2."')";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$rcode = $query[0]["CODE"];
			
			if($rcode == $code1)
			{
				$resp["message"] = "autores".$query[0]["STATUS"];
			}
			else
			{
				$resp["message"] = "friendes".$query[0]["STATUS"];
			}
		}
		else
		{
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			
			$str = "INSERT INTO  lr_friends (CODE,CODE2,STATUS,SENT,CHANGED) VALUES ('".$code1."','".$code2."','0','".$now."','".$now."')";
			$query = $this->db->query($str);
			
			$resp["message"] = "sent";
		}
		$ans = $query;
		
		$resp["mesage"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function setContactStatus($info)
	{
		$code1 = $info["code1"];
		$code2 = $info["code2"];
		$state = $info["state"];
		
		if($state == "1")
		{
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			$str = "UPDATE lr_friends SET STATUS = '".$state."', CHANGED = '".$now."' WHERE CODE ='".$code1."' AND CODE2 = '".$code2."'";
			$query = $this->db->query($str);
			$resp["mesage"] = "accepted";
			
			$data = array();
			$data["ntype"] = "s02";
			$data["user"] = $code1;
			$data["friend"] = $code2;
			
			$this->notifUser($data);
			
		}
		else
		{
			$str = "DELETE FROM lr_friends WHERE CODE ='".$code1."' AND CODE2 = '".$code2."'";
			$query = $this->db->query($str);
			$resp["mesage"] = "deleted";
		}
		
		$resp["status"] = true;
		return $resp;
	}
	function sendLike($info)
	{
		$AUTORCODE = $info["autorCode"];
		$FRIENDCODE = $info["friendCode"];
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$DATE =$now;
		$TYPE = $info["type"];
		$CONTENT = $info["content"];
		$ICON = $info["icon"];
		$CHECK = $info["check"];
		$today = $info["today"];
		
		if($CHECK == "1")
		{
			// GET RELATION
			$str = "SELECT CODE, CODE2, STATUS FROM lr_friends WHERE (CODE = '".$AUTORCODE."' AND CODE2 = '".$FRIENDCODE."') OR (CODE2 = '".$AUTORCODE."' AND CODE = '".$FRIENDCODE."')";
			$check = $this->db->query($str);
			
			if(count($check) > 0)
			{
				// CHECK RELATION STATE
				if($check[0]["STATUS"] == "0")
				{
					if($AUTORCODE == $check[0]["CODE"])
					{
						$resp["message"] = "sentsent";
					}
					else
					{
						$resp["message"] = "sentpending";
					}
				}
				else
				{
					$str = "INSERT INTO lr_likes (AUTORCODE, FRIENDCODE, DATE, TYPE, CONTENT, ICON) VALUES ('".$AUTORCODE."', '".$FRIENDCODE."', '".$DATE."','".$TYPE."', '".$CONTENT."', '".$ICON."')";
					$query = $this->db->query($str);
					$resp["message"] = "sent";
				}
			}
			else
			{
				$resp["message"] = "norel";
			}
		}
		else
		{
			$str = "INSERT INTO lr_likes (AUTORCODE, FRIENDCODE, DATE, TYPE, CONTENT, ICON) VALUES ('".$AUTORCODE."', '".$FRIENDCODE."', '".$DATE."','".$TYPE."', '".$CONTENT."', '".$ICON."')";
		$query = $this->db->query($str);
			$resp["message"] = "sent";
		}
		
		if($resp["message"] == "sent")
		{
			$indexCode = md5($AUTORCODE.$today);
			$str = "INSERT INTO lr_loved  (CODE, UCODE, DATE, LIKED) VALUES ('".$indexCode."', '".$AUTORCODE."', '".$today."','".$FRIENDCODE."') ON DUPLICATE KEY UPDATE CODE = '".$indexCode."'";
			$query = $this->db->query($str);
		}
		$resp["status"] = true;
		return $resp;
	}
	function getLikes ($info)
	{
		$code = $info["code"];
		$ini = $info["ini"];
		$end = $info["end"];
		$filter = $info["filter"];
		
		$str = "UPDATE lr_likes SET STATUS = '1' WHERE FRIENDCODE ='".$code."' AND STATUS = '0'";
		$query = $this->db->query($str);
		
		if($filter == "")
		{
			$str = "SELECT * FROM lr_likes WHERE AUTORCODE = '".$code."' OR FRIENDCODE = '".$code."' ORDER BY DATE DESC LIMIT $ini, $end";
		}
		if($filter == "1")
		{
			$str = "SELECT * FROM lr_likes WHERE AUTORCODE = '".$code."' ORDER BY DATE DESC LIMIT $ini, $end";
		}
		if($filter == "2")
		{
			$str = "SELECT * FROM lr_likes WHERE FRIENDCODE = '".$code."' ORDER BY DATE DESC LIMIT $ini, $end";
		}
		
		$likes = $this->db->query($str);
		
		for($i=0; $i<count($likes); $i++)
		{
			$item = $likes[$i];
			$dcode1 = $item["AUTORCODE"];
			$dcode2 = $item["FRIENDCODE"];
			
			if($dcode1 == "sy")
			{
				$autorName = "sy";
				$autorAvatar = "sy";
			}
			else
			{
				if($dcode1 == $code)
				{
					$str = "SELECT NAME, AVATAR FROM lr_trusers WHERE CODE = '".$dcode2."'";
					$udata = $this->db->query($str);
					$autorName = $udata[0]["NAME"];
					$autorAvatar = $udata[0]["AVATAR"];
				}
				else
				{
					$str = "SELECT NAME, AVATAR FROM lr_trusers WHERE CODE = '".$dcode1."'";
					$udata = $this->db->query($str);
					$autorName = $udata[0]["NAME"];
					$autorAvatar = $udata[0]["AVATAR"];
				}
			}
			
			$likes[$i]["AUTORNAME"] = $autorName;
			$likes[$i]["AUTORAVATAR"] = $autorAvatar;
	
		}
		
		$resp["message"] = $likes;
		$resp["status"] = true;
		return $resp;
	}
	function notifDaemon($info)
	{
		$code = $info["code"];
		
		$ans = array();
		
		// CHECK FOR NEW LIKES
		$str = "SELECT STATUS FROM lr_likes WHERE FRIENDCODE = '".$code."' AND STATUS = '0'";
		$unread = $this->db->query($str);
		if(count($unread) > 0)
		{$ans["unread"] = count($unread);}
		else{$ans["unread"] = "0";}
		
		// CHECK FOR NEW FRIENDS
		$str = "SELECT STATUS FROM lr_friends WHERE CODE2 = '".$code."' AND STATUS = '0'";
		$unfriend = $this->db->query($str);
		if(count($unfriend) > 0)
		{$ans["unfriend"] = count($unfriend);}
		else{$ans["unfriend"] = "0";}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
		
	}
	function notifUser($info)
	{
		$ntype = $info["ntype"];
		$user = $info["user"];
		$autor = "sy";
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		// GET FROM USERPROFILE CHANGED FROM PICKER
		$language = "es_co";
		
		$langFile = parse_ini_file("../lang/lang.ini", true);
		$lang = $langFile[$language];
		
		if($ntype == "s01")
		{
			$content = $ntype;
			$icon = "sy";
		}
		if($ntype == "s02")
		{
			$friendCode = $info["friend"];
			// GET FRIEND NAME
			$str = "SELECT NAME FROM lr_trusers WHERE CODE = '".$friendCode."'";
			$query = $this->db->query($str);
			$name = $query[0]["NAME"]."-code-".$friendCode;
			
			$content = "<b>".$name."</b>";
			$icon = "sy";
		}
		
		$AUTORCODE = $autor;
		$FRIENDCODE = $user;
		$DATE = $now;
		$TYPE = $ntype;
		$CONTENT = $content;
		$ICON = $icon;
		
		$str = "INSERT INTO lr_likes (AUTORCODE, FRIENDCODE, DATE, TYPE, CONTENT, ICON) VALUES ('".$AUTORCODE."', '".$FRIENDCODE."', '".$DATE."','".$TYPE."', '".$CONTENT."', '".$ICON."')";
		$query = $this->db->query($str);
		
		$resp["message"] = "sent";
		$resp["status"] = true;
		return $resp;
	}
	function getStats($info)
	{
		$code = $info["code"];
		$ans = array();
		
		$str = "SELECT CODE FROM lr_friends WHERE CODE = '".$code."' OR CODE2 = '".$code."'";
		$query = $this->db->query($str);
		$ans["friends"] = $query;
		
		$str = "SELECT AUTORCODE, TYPE FROM lr_likes WHERE (AUTORCODE = '".$code."' OR FRIENDCODE = '".$code."') AND AUTORCODE != 'sy' ORDER BY TYPE ASC";
		$query = $this->db->query($str);
		$ans["likes"] = $query;
		
		$str = "SELECT COUNT(AUTORCODE) as SUBTOTAL, AUTORCODE FROM lr_likes WHERE FRIENDCODE = '".$code."' AND AUTORCODE != 'sy' GROUP BY AUTORCODE ORDER BY SUBTOTAL DESC LIMIT 1";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$str = "SELECT NAME, AVATAR  FROM lr_trusers WHERE CODE = '".$query[0]["AUTORCODE"]."'";
			$data = $this->db->query($str);
			$query[0]["NAME"] = $data[0]["NAME"];
			$query[0]["AVATAR"] = $data[0]["AVATAR"];
		}
		
		$ans["fan"] = $query;
		
	
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function mailExist($info)
	{
		$email = $info["email"];
		$lang = $info["lang"];
		
		$str = "SELECT CODE FROM lr_trusers WHERE EMAIL = '".$email."'";
		$query = $this->db->query($str);

		if(count($query) > 0)
		{
			$language = $lang;
			$langFile = parse_ini_file("../lang/lang.ini", true);
			$subject = $langFile[$language]["recSubject"];
			$message = $langFile[$language]["recMessage"];
			$recLinkText = $langFile[$language]["recLinkText"];
			$header = $langFile[$language]["recHeader"];
			$genFooter = $langFile[$language]["genFooter"];
			
			$tmpkey = $query[0]["CODE"];
			
			$host = "https://likereal.org/";
			// $host = "http://192.168.0.60:9090/www/likereal/";
			
			$content = $message."<br><br><span style='font-size:13px; font-weight: bold;'>"."<a href='".$host."?me=".$email."&tmpkey=".$tmpkey."'>".htmlentities($recLinkText)."</a>"."</span>";
						
			// SEND MAIL 
			$data = array();
			$data["subject"] = $subject;
			$data["email"] = $email;
			$data["content"] = $content;
			$data["header"] = $header;
			$data["footer"] = $genFooter;
			$send = $this->myMailer($data);
			$resp["message"] = $send;
			$resp["status"] = true;
		}
		else
		{
			$resp["message"] = "notSent";
			$resp["status"] = false;
		}
		return $resp;
	}
	function setPass($info)
	{
		$code = $info["code"];
		$pass = md5($info["pass"]);
		
		$str = "UPDATE lr_trusers SET PASS = '".$pass."' WHERE CODE = '".$code."'";
		$query = $this->db->query($str);
		
		$resp["message"] = "set";
		$resp["status"] = true;
		return $resp;
	}
	function sendContact($info)
	{
		$name = $info["name"];
		$email = $info["email"];
		$message = $info["message"];
		$cmail = $info["cmail"];
		
		$phone = "";
		
		$str = "INSERT INTO ad_signed (NAME, EMAIL, PHONE) VALUES ('".$name."','".$email."','".$phone."') ON DUPLICATE KEY UPDATE NAME = '".$name."', PHONE = '".$phone."'";
		$query = $this->db->query($str);
		
		// SEND MAIL 
		$data = array();
		$data["subject"] = "Contacto desde Ads Latino de ".$name;
		$data["content"] = $name." dice: <br><br>".$message."<br><br> Email: ".$email;
		$data["header"] = "-";
		$data["footer"] = "-";
		$data["cmail"] = $cmail;
		
		$send = $this->myMailer($data);
		$resp["message"] = $send;
		$resp["status"] = true;

		return $resp;
	}
	function myMailer($info)
	{
		$subject = $info["subject"];
		$cmail = $info["cmail"];
		$content = $info["content"];
		$header = "<div style='text-align: center; color: #000000;'><h2>".$info["header"]."</h2></div>";
		$footer = "<div style='text-align: center; color: #e95b35;'><h5>".$info["footer"]."</h5></div>";
		
		
		$content = htmlEntities($content);
		$content = html_entity_decode($content);
		$fromName = "Ads Latino";
		$from = 'webadslatino@gmail.com';		
		$host = 'smtp.gmail.com';
		$pssw = 'adslatino2020';
		
		//SEND MAIL ------------
		require 'phpmailer/Exception.php';
		require 'phpmailer/PHPMailer.php';
		require 'phpmailer/SMTP.php';

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
		$mail->AddReplyTo($from, $fromName);
		$mail->AddAddress($cmail);
		$mail->AddCC("webadslatino@gmail.com");

		// $recipients = array('leoncitobravo2008@hotmail.com', 'incocrea@outlook.com', 'contacto@inscolombia.com');
		// foreach($recipients as $demail)// {// $mail->AddCC($demail);// }
		// $mail->AddAttachment("../../ding.WAV", 'soundfile.WAV');
		
		$content = "<h3 style='text-align: center;'>".$content."</h3>";
		$body = $header."<br>".$content."<br>".$footer;
		$mail->Body = $body; 

		// Envía el correo.
		$exito = $mail->Send(); 
		// $exito = true;
		if($exito){$ans = "enviado";}else{$ans = $mail->ErrorInfo;} 
		
		// $ans = $body;

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// REPORTERY BLOCK START -------------------------
	function exportXLS($info)
	{
		$lang = "es_co";
		// $langFile = parse_ini_file("../../lang/lang.ini", true);
		// $lang = $langFile[$lang];
		$type = $info["type"];
		$mode = $info["mode"];
		
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
		
		$whiteTittle = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 13,'name'  => 'Verdana' ));     
		
		$sheet->getPageMargins()->setTop(0.1);
		$sheet->getPageMargins()->setRight(0.3);
		$sheet->getPageMargins()->setLeft(0.3);
		$sheet->getPageMargins()->setBottom(0.3);
		
		// SHEET CONFIG END -------------------------
		
		
		if($type == "clist")
		{
			
			
			$str = "SELECT * FROM ad_signed";
			$list = $this->db->query($str);
				
			// $resp["message"] = $list;
			// $resp["status"] = true;
			// return $resp;
				
			$c = 1;
		
			// $sheet->mergeCells("A$c:B$c");
			
			$sheet->getStyle("A$c:C$c")->applyFromArray($borderB);
			$sheet->getStyle("A$c:C$c")->applyFromArray($alignLeft);
			$sheet->getStyle("A$c:C$c")->getFont()->setSize(9);
			
			$sheet->setCellValue("A$c", "Nombre");
			$sheet->setCellValue("B$c", "Email");
			$sheet->setCellValue("C$c", "Teléfono");

			$c++;
			
			// TABLE CLIST 
			if(count($list) > 0)
			{
				for($i = 0; $i<count($list);$i++)
				{
					$item = $list[$i];

					$sheet->setCellValue("A$c",  $item["NAME"]);
					$sheet->setCellValue("B$c",  $item["EMAIL"]);
					$sheet->setCellValue("C$c",  $item["PHONE"]);

					$sheet->getStyle("A$c:C$c")->applyFromArray($borderB);
					$sheet->getStyle("A$c:C$c")->applyFromArray($alignLeft);
					$sheet->getStyle("A$c:C$c")->getFont()->setSize(9);
					$c++;
				}
			}


			// ------------------FILE CREATE-------------------
			$fname = "Users report".".xls";
			$path = "../excel/".$fname;
			$hasFile = file_exists($path);
			if($hasFile == true){unlink($path);}
			$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
			$objWriter->save($path );
			$resp["message"] = $fname;
			$resp["status"] = true;
			return $resp;
		}
		
		// ----------------------------------------------------------------------
		// ----------------------------------------------------------------------
		// ----------------------------------------------------------------------
		// ----------------------------------------------------------------------
		
	
		$fname = htmlEntities(utf8_decode($fname));
		$resp["message"] = $fname;
		$resp["status"] = true;
		return $resp;
	}
	
}
?>
