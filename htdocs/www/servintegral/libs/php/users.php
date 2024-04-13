<?php
date_default_timezone_set('America/Bogota');
// require('../fpdf/fpdf.php');
require('../fpdf/mc_table.php');
require('../phpExcel/Classes/PHPExcel.php');

class users{

	function __construct()
	{
		$this->db = new sql_query();
		session_start();
	}
	function login($info)
	{
	
		$str = "SELECT * FROM users WHERE users.MAIL = '".$info["autor"]."' AND users.PASSWD = '".md5($info["pssw"])."' AND users.TYPE = '".$info["type"]."'";
		$query = $this->db->query($str);	

		if(count($query) > 0)
		{
			
			if($query[0]["STATUS"] == "0")
			{
					$resp["message"] = "Disabled";
					$resp["status"] = true;
					return $resp;
			}
			$resp["message"] = $query[0];
			$resp["status"] = true;
                        
			$info["autor"] = $resp["message"]["RESPNAME"];
			
			// SAVELOG
			$this->chlog($info);
		}
		else
		{
			$resp["message"] = "";
			$resp["status"] = false; 
		}

		return $resp;
	}
	function chlog($info)
	{
			$OPCODE = md5($info["date"]); 
			$AUTOR = $info["autor"]; 
			$DATE = $info["date"]; 
			$TYPE = $info["type"]; 
			$TARGET = $info["target"]; 
			$OPTYPE = $info["optype"];    
			$STATUS = "1";
			$str = "INSERT INTO log (OPCODE, AUTOR, DATE, TYPE, TARGET, OPTYPE, STATUS) VALUES ('".$OPCODE."', '".$AUTOR."', '".$DATE."', '".$TYPE."', '".$TARGET."', '".$OPTYPE."', '".$STATUS."')";
			$query = $this->db->query($str);
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
	function getClientList($info)
	{
		
                $name = $info["f-clientName"];
                $nit = $info["f-clientNit"];
                $email = $info["f-clientEmail"];
                $type = 'C';
                
                $where = "WHERE  TYPE = '$type' AND STATUS != 'null' ";

		if($name != "")
		{
			$where .= "AND  CNAME LIKE '%$name%'";
		}
		if($nit != "")
		{
			$where .= "AND  NIT = '$nit'";
		}
		if($email != "")
		{
			$where .= "AND  MAIL = '$email'";
		}
                
                $str = "SELECT *  FROM users $where ORDER BY CNAME ASC";
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

		return $resp;
	
	}
	function getSucuList($info)
	{
                $parent = $info["f-sucuParent"];
                $code = $info["f-sucuCode"];
                $name = $info["f-sucuName"];
                
                $where = "WHERE  STATUS = 1 ";

		if($parent != "")
		{
			$where .= "AND  PARENTCODE = '$parent'";
		}
		if($name != "")
		{
			$where .= "AND  NAME LIKE '%$name%'";
		}
		if($code != "")
		{
			$where .= "AND  CODE = '$code'";
		}
                
                $str = "SELECT *  FROM sucus $where ORDER BY PARENTNAME ASC";
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

		return $resp;
	
	}
	function getParentSucus($info)
	{
			$user = $info["ucode"];
			
			$str = "SELECT CODE, CNAME FROM users WHERE TYPE = 'C' AND STATUS = '1' ORDER BY CNAME ASC";
			$query = $this->db->query($str);
			
			if(count($query) > 0){$parents = $query;}
			else{$parents = array();}
			
			$str = "SELECT PARENTCODE, CODE, NAME, CITY, DEPTO FROM sucus WHERE STATUS = '1' ORDER BY CODE ASC";
			$query = $this->db->query($str);
			
			if(count($query) > 0){$sucus = $query;}
			else{$sucus = array();}
			
			$str = "SELECT CODE, CCODE, SUCUNAME, PARENTCODE, LOCATION FROM orders ORDER BY CCODE DESC";
			$query = $this->db->query($str);
			
			if(count($query) > 0){$orders = $query;}
			else{$orders = array();}
			
			$str = "SELECT * FROM others WHERE LEGAUTOR = '".$user."' ORDER BY LEGDATE ASC";
			$query = $this->db->query($str);
			
			if(count($query) > 0){$legs = $query;}
			else{$legs = array();}
			
			$list = array();
			$list["parents"] = $parents;
			$list["sucus"] = $sucus;
			$list["orders"] = $orders;
			$list["legs"] = $legs;
			
			$resp["message"] = $list;
			$resp["status"] = true;
			return $resp;
	}
	function getMaquiList($info)
	{
                $parent = $info["f-maquiParent"];
                $sucu = $info["f-maquiSucu"];
                $plate = $info["f-maquiPlate"];

                $where = "WHERE  STATUS = 1 ";

		if($parent != "")
		{
			$where .= "AND  PARENTCODE = '$parent'";
		}
		if($sucu != "")
		{
			$where .= "AND  SUCUCODE = '$sucu'";
		}
		if($plate != "")
		{
			$where .= "AND PLATE LIKE '%$plate%'";
		}
                
                $str = "SELECT * FROM maquis $where ORDER BY PARENTNAME ASC";
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

		return $resp;
	
	}
	function getTechiList($info)
	{
		
		$id = $info["f-techiId"];
		$cat = $info["f-techiCat"];
		$name = $info["f-techiName"];
		$location = $info["f-techiLocation"];
		$type = $info["f-techiCat"];
		
		$where = "WHERE  TYPE = '$type' AND STATUS = 1 ";

		if($id != "")
		{
			$where .= "AND  NIT =  '$id'";
		}
		if($location != "")
		{
			$where .= "AND LOCATION LIKE '%$location%'";
		}
		if($name != "")
		{
			$where .= "AND  RESPNAME LIKE '%$name%'";
		}
                
                $str = "SELECT *  FROM users $where ORDER BY RESPNAME ASC";
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

		return $resp;
	
	}
	function getActTypeList()
	{
                $str = "SELECT *  FROM actypes ORDER BY TYPE ASC";
                $query = $this->db->query($str);
                
                $resp["message"] = $query;
                $resp["status"] = true;
                return $resp;
	}
	function getActiList($info)
	{
		
                $actype = $info["f-actiType"];
                $code = $info["f-actiCode"];
                $desc = $info["f-actiDesc"];
                $type = 'C';
                
                $where = "WHERE STATUS = 1 ";

		if($actype != "")
		{
			$where .= "AND  ACTYPE = '$actype'";
		}
		if($code != "")
		{
			$where .= "AND  CODE = '$code'";
		}
		if($desc != "")
		{
			$where .= "AND  DESCRIPTION LIKE  '%$desc%'";
		}
                
                $str = "SELECT * FROM actis $where ORDER BY ACTYPE ASC";
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

		return $resp;
	
	}
	function getoActiList($info)
	{
                
		if(isset($info["value"])){$value = $info["value"];}
		else{$value = "";}
		
		
		$where = "WHERE STATUS = 1 ";

		if($value != "")
		{
			$where .= "AND  DESCRIPTION LIKE '%$value%'";
		}
                
		$str = "SELECT CODE, DESCRIPTION, COST, DURATION FROM actis $where ORDER BY CODE";
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
		
		return $resp;
	}
	function getInveList($info)
	{
                $code = $info["f-inveCode"];
                $desc = $info["f-inveDesc"];
                
                $where = "WHERE  STATUS = 1 ";

		if($code != "")
		{
			$where .= "AND  CODE = '$code'";
		}
		if($desc != "")
		{
			$where .= "AND  DESCRIPTION LIKE '%$desc%'";
		}
                
                $str = "SELECT * FROM inve $where ORDER BY DESCRIPTION ASC";
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

		return $resp;
	
	}
	function getOrdeList($info)
	{
		$parent = $info["f-orderParent"];
		$sucu = $info["f-orderSucu"];
		$num = intval($info["f-orderNum"]);
		$state = $info["f-orderState"];
		$author = $info["f-orderAuthor"];
		$location = $info["f-orderLocation"];
		$type = 'O';
		$techcode = $info["techcode"];
		$ucode = $info["ucode"];
		$places = $info["places"];
		
		$askType = $info["askType"];
		
		if($askType == "A")
		{
			$where = "WHERE  STATUS = 1 ";
		}
		else if($askType == "CO")
		{
			$where = "WHERE  STATUS = 1 AND AUTORCODE = '".$ucode."' ";
		}
		else if($askType == "JZ")
		{
			// $places = ["per", "mani","valle"];
			
			$start = "(";
			$inner = "";
			$end = ")";
			
			for($i=0; $i<count($places); $i++)
			{
				$loc = $places[$i];
				
				$inner.= "LOCATION LIKE '%".$loc."%'";
				
				if($i < (count($places)-1))
				{
					$inner.=" OR ";
				}
			}
			$cities = $start.$inner.$end;
			$where = "WHERE ".$cities." AND STATUS = 1 ";
		}
		if($parent != "")
		{
			$where .= "AND  PARENTCODE =  '$parent'";
		}
		if($sucu != "")
		{
			$where .= "AND  SUCUCODE = '$sucu'";
		}
		if($num != "")
		{
			$where .= "AND  CCODE = '$num'";
		}
		if($location != "")
		{
			$where .= "AND  LOCATION LIKE '%$location%'";
		}
		if($author != "")
		{
			$where .= "AND  AUTOR LIKE '%$author%'";
		}
		if($state != "")
		{
			$where .= "AND  STATE = '$state'";
		}
		if($techcode != "")
		{
			$where .= "AND  TECHCODE = '$techcode'";
		}
                
		$str = "SELECT * FROM orders $where ORDER BY DATE DESC LIMIT 60";
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

		return $resp;
	
	}
	function getLogList($info)
	{

		$responsable = $info["f-logResp"];
		$iniDate = $info["f-logInidate"];
		$enDate = $info["f-logEndate"];
		$type = $info["f-logType"];
		$target = $info["f-logTarget"];
		$move = $info["f-logMove"];

		$where = "WHERE  STATUS = 1 ";

		if($responsable != "")
		{
			$where .= "AND  AUTOR LIKE  '%$responsable%'";
		}
		if($iniDate != "")
		{
			$where .= "AND  DATE >= '$iniDate'";
		}
		if($enDate != "")
		{
			$where .= "AND  DATE <= '$enDate'";
		}
		if($type != "")
		{
			$where .= "AND  TYPE = '$type'";
		}
		if($target != "")
		{
			$where .= "AND  TARGET LIKE '$target'";
		}
		if($move != "")
		{
			$where .= "AND  OPTYPE = '$move'";
		}
                
		$str = "SELECT *  FROM log $where ORDER BY DATE DESC LIMIT 50";
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

		return $resp;
	
	}
	function clientSave($info)
	{
		$otype = $info["otype"];
                $utype = $info["utype"];
                
                $CNAME = $info["a-clientName"];
                $RESPNAME = $info["a-clientManager"];
                $NIT = $info["a-clientNit"];
                $PHONE = $info["a-clientPhone"];
                $ADDRESS = $info["a-clientAddress"];
                $MAIL = $info["a-clientEmail"];
                $LOCATION = $info["a-clientLocation"];
                $STATUS = "1";
                $CNATURE = $info["a-clientNature"];

                if($otype == "c")
                {
                        $REGDATE = $info["date"];
                        $PASSWD = md5($NIT);
                         
                        $str = "SELECT users.MAIL FROM users WHERE users.MAIL = '$MAIL' AND users.TYPE = '$utype'";
                        $query = $this->db->query($str);
                        
                        if(count($query) > 0 )
                        {
                                $resp["message"] = "exist";
                                $resp["status"] = false;
                                
                                return $resp;
                        }
                        else
                        {
                                
                                $CODE = md5($MAIL.$utype);
                                
                                $str = "INSERT INTO users (CODE, RESPNAME, MAIL, PHONE, NIT, ADDRESS, LOCATION, PASSWD, STATUS, REGDATE, CNAME, TYPE, CNATURE) VALUES ('".$CODE."', '".$RESPNAME."', '".$MAIL."', '".$PHONE."', '".$NIT."', '".$ADDRESS."', '".$LOCATION."', '".$PASSWD."', '".$STATUS."', '".$REGDATE."', '".$CNAME."', '".$utype."', '".$CNATURE."')";
                                $query = $this->db->query($str);

                                $this->chlog($info);

                                $resp["message"] = "create";
                                $resp["status"] = true;

                                return $resp;
                        }
                }
                else
                {
                        $CCODE = $info["ccode"];
                        
                        $str = "UPDATE users SET RESPNAME='".$RESPNAME."', MAIL='".$MAIL."', ADDRESS='".$ADDRESS."', NIT='".$NIT."', PHONE='".$PHONE."', CNAME = '".$CNAME."', LOCATION = '".$LOCATION."', CNATURE = '".$CNATURE."' WHERE CODE='".$CCODE."' AND TYPE = '$utype'"; 
			$query = $this->db->query($str);
                        
                        $str = "UPDATE sucus SET PARENTNAME='".$CNAME."' WHERE PARENTCODE='".$CCODE."'"; 
			$query = $this->db->query($str);
                        
                        $str = "UPDATE maquis SET PARENTNAME='".$CNAME."' WHERE PARENTCODE='".$CCODE."'"; 
			$query = $this->db->query($str);
                        
                        $str = "UPDATE orders SET PARENTNAME='".$CNAME."' WHERE PARENTCODE='".$CCODE."'"; 
			$query = $this->db->query($str);
                        
                        $str = "UPDATE oreports SET PARENTNAME='".$CNAME."' WHERE PARENTCODE='".$CCODE."'"; 
			$query = $this->db->query($str);
                        
                       $this->chlog($info);
                        
                        $resp["message"] = "edite";
                        $resp["status"] = true;

                        return $resp;
                }
	}
	function sucuSave($info)
	{
		$otype = $info["otype"];

                $PARENTCODE = $info["a-sucuParent"];
                $PARENTNAME = $info["a-sucuParentName"];
                $CODE = $info["a-sucuCode"];
                $NAME = $info["a-sucuName"];
                $ADDRESS = $info["a-sucuAddress"];
                $PHONE = $info["a-sucuPhone"];
                $COUNTRY = $info["a-sucuCountry"];
                $DEPTO = $info["a-sucuDepto"];
                $CITY = $info["a-sucuCity"];

                if($otype == "c")
                {
                         
                        
                        $str = "SELECT sucus.CODE FROM sucus WHERE sucus.CODE = '$CODE'";
                        $query = $this->db->query($str);
                        
                        if(count($query) > 0 )
                        {
                                $resp["message"] = "exist";
                                $resp["status"] = false;
                                
                                return $resp;
                        }
                        else
                        {

                                $str = "INSERT INTO sucus (PARENTCODE, PARENTNAME, CODE, NAME, ADDRESS, PHONE, COUNTRY, DEPTO, CITY, STATUS) VALUES ('".$PARENTCODE."', '".$PARENTNAME."', '".$CODE."', '".$NAME."', '".$ADDRESS."', '".$PHONE."', '".$COUNTRY."', '".$DEPTO."', '".$CITY."', '1')";
                                $query = $this->db->query($str);

                                $this->chlog($info);

                                $locaPlate = substr(md5($CODE), 0, -26)."-Locativas";
                                
                                $str = "INSERT INTO maquis (CODE, PARENTCODE, PARENTNAME, SUCUCODE, SUCUNAME, PLATE, NAME, MODEL, SERIAL, VOLT, CURRENT, POWER, PHASES, DETAIL, STATUS) VALUES ('".$locaPlate."', '".$PARENTCODE."', '".$PARENTNAME."', '".$CODE."', '".$NAME."', '".$locaPlate."', 'Locativas', '-', '-', '-', '-', '-', '-', '-', '1')";
                                $query = $this->db->query($str);
                                

                                
                                $resp["message"] = "create";
                                $resp["status"] = true;

                                return $resp;
                        }
                }
                else
                {
                        $str = "UPDATE sucus SET PARENTCODE='".$PARENTCODE."', PARENTNAME='".$PARENTNAME."', NAME='".$NAME."', ADDRESS='".$ADDRESS."', PHONE='".$PHONE."', COUNTRY = '".$COUNTRY."', DEPTO = '".$DEPTO."', CITY = '".$CITY."' WHERE CODE='".$CODE."'"; 
			$query = $this->db->query($str);
                        
                        $str = "UPDATE maquis SET SUCUNAME='".$NAME."' WHERE SUCUCODE='".$CODE."'"; 
			$query = $this->db->query($str);
                        
                        $str = "UPDATE orders SET SUCUNAME='".$NAME."' WHERE SUCUCODE='".$CODE."'"; 
			$query = $this->db->query($str);
                        
                        $str = "UPDATE oreports SET SUCUNAME='".$NAME."' WHERE SUCUCODE='".$CODE."'"; 
			$query = $this->db->query($str);
                        
                       $this->chlog($info);
                        
                        $resp["message"] = "edite";
                        $resp["status"] = true;

                        return $resp;
                }
	}
	function maquiSave($info)
	{
		$otype = $info["otype"];

                $CODE = md5($info["a-maquiPlate"]);
                $PARENTCODE = $info["a-maquiParent"];
                $PARENTNAME = $info["a-maquiParentName"];
                $SUCUCODE = $info["a-maquiSucu"];
                $SUCUNAME = $info["a-maquiSucuName"];
                $PLATE = $info["a-maquiPlate"];
                $NAME = $info["a-maquiName"];
                $MODEL = $info["a-maquiModel"];
                $SERIAL = $info["a-maquiSerial"];
                $VOLT = $info["a-maquiVolt"];
                $CURRENT = $info["a-maquiCurrent"];
                $POWER = $info["a-maquiPower"];
                $PHASES = $info["a-maquiPhase"];
                $DETAIL = $info["a-maquiDetails"];
                $STATUS = '1';

                if($otype == "c")
                {
                        
                        
                        $str = "SELECT maquis.PLATE FROM maquis WHERE maquis.PLATE = '$PLATE'";
                        $query = $this->db->query($str);
                        
                        if(count($query) > 0 )
                        {
                                $resp["message"] = "exist";
                                $resp["status"] = false;
                                
                                return $resp;
                        }
                        else
                        {

                                $str = "INSERT INTO maquis (CODE, PARENTCODE, PARENTNAME, SUCUCODE, SUCUNAME, PLATE, NAME, MODEL, SERIAL, VOLT, CURRENT, POWER, PHASES, DETAIL, STATUS) VALUES ('".$CODE."', '".$PARENTCODE."', '".$PARENTNAME."', '".$SUCUCODE."', '".$SUCUNAME."', '".$PLATE."', '".$NAME."', '".$MODEL."', '".$SERIAL."', '".$VOLT."', '".$CURRENT."', '".$POWER."', '".$PHASES."', '".$DETAIL."', '1')";
                                $query = $this->db->query($str);

                                $this->chlog($info);

                                $resp["message"] = "create";
                                $resp["status"] = true;

                                return $resp;
                        }
                }
                else
                {
                        
                        // GET ATUAL MAQUICODE UPDATE ALL PLATE IN OTHER TABLES WHERE CODE
                        
                        $str = "UPDATE maquis SET PARENTCODE='".$PARENTCODE."', PARENTNAME='".$PARENTNAME."', SUCUCODE='".$SUCUCODE."', SUCUNAME='".$SUCUNAME."', NAME = '".$NAME."', MODEL='".$MODEL."', SERIAL = '".$SERIAL."', VOLT = '".$VOLT."', CURRENT = '".$CURRENT."', POWER = '".$POWER."', PHASES = '".$PHASES."', DETAIL = '".$DETAIL."' WHERE PLATE='".$PLATE."'"; 
			$query = $this->db->query($str);
                        
                       $this->chlog($info);
                        
                        $resp["message"] = "edite";
                        $resp["status"] = true;

                        return $resp;
                }
	}
	function setFileLink($info)
	{
		
		$code = $info["ocode"];
		$name = htmlentities($info["fileLink"]);
		
		$str = "UPDATE orders SET FILELINK ='".$name."', STATE = '7' WHERE CODE='".$code."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
	}
	function techiSave($info)
	{
		$otype = $info["otype"];
		$utype = $info["a-techiCat"];
		$CNAME = $info["a-techiName"];
		$RESPNAME = $info["a-techiName"];
		$NIT = $info["a-techiId"];
		$PHONE = $info["a-techiPhone"];
		$ADDRESS = $info["a-techiAddress"];
		$MAIL = $info["a-techiEmail"];
		$LOCATION = $info["a-techiCity"];
		$CATEGORY = $info["a-techiCat"];
		$MASTERY = $info["a-techiMastery"];
		$DETAILS = $info["a-techiDetails"];
                
                
		$STATUS = "1";

		if($otype == "c")
		{
			$REGDATE = $info["date"];
			$PASSWD = md5($NIT);
			 
			$str = "SELECT users.MAIL FROM users WHERE users.MAIL = '$MAIL' AND users.TYPE = '$utype'";
			$query = $this->db->query($str);
			
			if(count($query) > 0 )
			{
					$resp["message"] = "exist";
					$resp["status"] = false;
					
					return $resp;
			}
			else
			{
					
					$CODE = md5($MAIL.$utype);
					
					$str = "INSERT INTO users (CODE, RESPNAME, MAIL, PHONE, NIT, ADDRESS, LOCATION, PASSWD, STATUS, REGDATE, CNAME, TYPE, CATEGORY, MASTERY, DETAILS) VALUES ('".$CODE."', '".$RESPNAME."', '".$MAIL."', '".$PHONE."', '".$NIT."', '".$ADDRESS."', '".$LOCATION."', '".$PASSWD."', '".$STATUS."', '".$REGDATE."', '".$CNAME."', '".$utype."', '".$CATEGORY."', '".$MASTERY."', '".$DETAILS."')";
					$query = $this->db->query($str);

					$this->chlog($info);

					$resp["message"] = "create";
					$resp["status"] = true;

					return $resp;
			}
		}
		else
		{
				$code = $info["techiCode"];
				
				$str = "UPDATE users SET RESPNAME='".$RESPNAME."', MAIL='".$MAIL."', ADDRESS='".$ADDRESS."', NIT='".$NIT."', PHONE='".$PHONE."', CNAME = '".$CNAME."', LOCATION = '".$LOCATION."', CATEGORY = '".$CATEGORY."', MASTERY = '".$MASTERY."', DETAILS = '".$DETAILS."' WHERE CODE ='".$code."' AND TYPE = '$utype'"; 
	$query = $this->db->query($str);
				
				$str = "UPDATE oreports SET TECHNAME='".$RESPNAME."' WHERE TECHCODE='".$code."'"; 
	$query = $this->db->query($str);
				
				$str = "UPDATE oactis SET TECHNAME='".$RESPNAME."' WHERE TECHCODE='".$code."'"; 
	$query = $this->db->query($str);
				
	$query = $this->db->query($str);

			   $this->chlog($info);
				
				$resp["message"] = "edite";
				$resp["status"] = true;

				return $resp;
		}
	}
	function actiSave($info)
	{
		$otype = $info["otype"];
                $utype = $info["utype"];
                
                
                $ACTYPE = $info["a-actiType"];
                $DESCRIPTION = $info["a-actiDesc"];
                $DURATION = $info["a-actiTime"];
                $COST = $info["a-actiValue"];
                $STATUS = "1";

                if($otype == "c")
                {
                        $str = "SELECT CODE FROM actis WHERE ACTYPE = '".$ACTYPE."' ORDER BY CODE ASC";
                        $query = $this->db->query($str);
                        
                        if(count($query) > 0)
                        {
                                $list = $query;
                                
								usort($list, function($a, $b)
								{
									return strnatcmp($a['CODE'],$b['CODE']); //Case sensitive
									//return strnatcasecmp($a['manager'],$b['manager']); //Case insensitive
								});
								
                                $CODE = $ACTYPE."-".(explode("-", $list[count($list)-1]["CODE"])[1]+1);
                                
                        }
                        else
                        {
                                $list = array();
                                $CODE = $ACTYPE."-1";
                        }
                        
                                
                        $str = "INSERT INTO actis (CODE, ACTYPE, DESCRIPTION, DURATION, COST, STATUS) VALUES ('".$CODE."', '".$ACTYPE."', '".$DESCRIPTION."', '".$DURATION."', '".$COST."', '".$STATUS."')";
                        $query = $this->db->query($str);

                        $this->chlog($info);

                        $resp["message"] = "create";
                        $resp["status"] = true;

                        return $resp;
                }
                else
                {
                        $ACODE = $info["acode"];
                        
                        $str = "UPDATE actis SET ACTYPE='".$ACTYPE."', DESCRIPTION='".$DESCRIPTION."', DURATION='".$DURATION."', COST='".$COST."' WHERE CODE ='".$ACODE."'"; 
			$query = $this->db->query($str);
                        
                        $str = "UPDATE oactis SET ADESC='".$DESCRIPTION."' WHERE ACODE ='".$ACODE."'"; 
			$query = $this->db->query($str);
                        
                       $this->chlog($info);
                        
                        $resp["message"] = "edite";
                        $resp["status"] = true;

                        return $resp;
                }
	}
	function inveSave($info)
	{
		$otype = $info["otype"];
                $utype = $info["utype"];
                
                 
                
                $CODE = $info["a-inveCode"];
                $DESCRIPTION = $info["a-inveDesc"];
                $COST = $info["a-inveCost"];
                $MARGIN = $info["a-inveMargin"];
                $AMOUNT = $info["a-inveAmount"];
                $STATUS = "1";

                if($otype == "c")
                {
                        $str = "SELECT CODE FROM inve WHERE CODE = '".$CODE."' ORDER BY CODE ASC";
                        $query = $this->db->query($str);
                        
                        if(count($query) > 0 )
                        {
                                $resp["message"] = "exist";
                                $resp["status"] = false;
                                
                                return $resp;
                        }
                        else
                        {
                                
                                $str = "INSERT INTO inve (CODE, DESCRIPTION, COST, MARGIN, AMOUNT, STATUS) VALUES ('".$CODE."', '".$DESCRIPTION."', '".$COST."', '".$MARGIN."', '".$AMOUNT."', '".$STATUS."')";
                                $query = $this->db->query($str);

                                $this->chlog($info);

                                $resp["message"] = "create";
                                $resp["status"] = true;

                                return $resp;
                                
                        }
                }
                else
                {
                        
                        $str = "UPDATE inve SET DESCRIPTION='".$DESCRIPTION."', COST='".$COST."', MARGIN='".$MARGIN."', AMOUNT = '".$AMOUNT."' WHERE CODE ='".$CODE."'"; 
			$query = $this->db->query($str);
                        
                       $this->chlog($info);
                        
                        $resp["message"] = "edite";
                        $resp["status"] = true;

                        return $resp;
                }
	}
	function saveActType($info)
	{
			$desc = $info["newAct"];
			
			$str = "INSERT INTO actypes (TYPE) VALUES ('".$info["newAct"]."')";
			$query = $this->db->query($str);
			
			$resp["message"] = "done";
			$resp["status"] = true;
			return $resp;

	}
	function orderSave($info)
	{
		$otype = $info["otype"];
                
		$CODE = md5($info["a-orderParent"].$info["date"]);
		$DATE = $info["date"];
		$AUTOR = $info["autor"];
		$AUTORCODE = $info["autorCode"];
		$PARENTCODE = $info["a-orderParent"];
		$PARENTNAME = $info["a-orderParentName"];
		$SUCUCODE = $info["a-orderSucu"];
		$SUCUNAME = $info["a-orderSucuName"];
		$MAQUIS = $info["a-orderMaquis"];
		$STARTIME = $info["a-orderPriority"];
		$ENDTIME = $info["a-orderPriority2"];
		$DETAIL = $info["a-orderDesc"];
		$ICODE = $info["a-orderOrderClient"];
		$CONTACT = $info["a-orderContact"];
		$STATUS = "1";
		$USERTYPE = $info["userType"];
		$LOCATION = $info["location"];
		

		if($otype == "c")
		{
				// CHECK CLIENT TICKET COMBO
				
				$str = "SELECT CODE FROM orders WHERE PARENTCODE = '".$PARENTCODE."' AND ICODE = '".$ICODE."'";
				$query = $this->db->query($str);
				
				if(count($query) > 0)
				{
					$resp["message"] = "ticket";
					$resp["status"] = true;
					return $resp;
				}
				
				
				$str = "SELECT CCODE FROM orders WHERE PARENTCODE = '".$PARENTCODE."' ORDER BY CCODE ASC";
				$query = $this->db->query($str);
				 
				if(count($query) > 0)
				{
						$counter = intval($query[(count($query))-1]["CCODE"])+1;
				}
				else
				{
						$counter = 1;
				}
				
				
				if($USERTYPE == "JZ")
				{
					$JZCODE = $AUTORCODE;
					$STATE = "6";
				}
				else
				{
					$JZCODE = "";
					$STATE = "1";
				}
				
				
				
				$str = "INSERT INTO orders (CODE, DATE, PARENTCODE, PARENTNAME, SUCUCODE, SUCUNAME, MAQUIS, STATE, STATUS, STARTIME, ENDTIME, OBSERVATIONS, PENDINGS, RECOMENDATIONS, AUTOR, AUTORCODE, DETAIL, CCODE, ICODE, JZCODE, LOCATION, CONTACT) VALUES ('".$CODE."', '".$DATE."', '".$PARENTCODE."', '".$PARENTNAME."', '".$SUCUCODE."', '".$SUCUNAME."', '".$MAQUIS."', '".$STATE."', '".$STATUS."', '".$STARTIME."', '".$ENDTIME."', '', '', '', '".$AUTOR."', '".$AUTORCODE."', '".$DETAIL."', '".$counter."', '".$ICODE."', '".$JZCODE."' , '".$LOCATION."', '".$CONTACT."')";
				$query = $this->db->query($str);

				$this->chlog($info);
				
				mkdir('../../irsc/pics/'.$CODE, 0777, true);
				mkdir('../../irsc/pics/'.$CODE.'/ini', 0777, true);
				mkdir('../../irsc/pics/'.$CODE.'/end', 0777, true);
				mkdir('../../irsc/pics/'.$CODE.'/order', 0777, true);
				
				$resp["message"] = "create";
				$resp["status"] = true;

				return $resp;
		}
		else
		{
				$STATE = $info["ostate"];
				$CODE = $info["ocode"];
				
				$str = "UPDATE orders SET  MAQUIS='".$MAQUIS."', STATE='".$STATE."', DETAIL = '".$DETAIL."', ICODE = '".$ICODE."', STARTIME = '".$STARTIME."', ENDTIME = '".$ENDTIME."', LOCATION = '".$LOCATION."', CONTACT = '".$CONTACT."' WHERE CODE='".$CODE."'"; 
	$query = $this->db->query($str);
				
			   $this->chlog($info);
				
				$resp["message"] = "edite";
				$resp["status"] = true;

				return $resp;
		}
	}
	function delActType($info)
	{
			$code = $info["actCode"];
			
			$str = "DELETE FROM actypes WHERE TYPE = '".$code."'";
			$query = $this->db->query($str);
			
			$resp["message"] = "done";
			$resp["status"] = true;
			return $resp;

	}
	function regDelete($info)
	{
		$table = $info["table"];
		$delType = $info["delType"];
		
		if($delType == "client")
		{
				
			$str = "SELECT CODE FROM $table WHERE $table.MAIL = '".$info["mail"]."' AND $table.TYPE = '".$info["type"]."'";
			$query = $this->db->query($str);
			
			$parentCode = $query[0]["CODE"];
			
			$str = "DELETE FROM $table WHERE $table.MAIL = '".$info["mail"]."' AND $table.TYPE = '".$info["type"]."'";
			$query = $this->db->query($str);
			
			$this->chlog($info);
			
			$str = "DELETE FROM sucus WHERE PARENTCODE = '".$parentCode ."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM maquis WHERE PARENTCODE = '".$parentCode ."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM orders WHERE PARENTCODE = '".$parentCode ."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM oreports WHERE PARENTCODE = '".$parentCode."'";
			$query = $this->db->query($str);
			
			
			// $str = "DELETE FROM oactis WHERE PARENTCODE = '".$parentCode ."'";
			// $query = $this->db->query($str);
				
		}
		if($delType == "sucu")
		{
			$str = "DELETE FROM $table WHERE $table.CODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$this->chlog($info);
			
			$str = "DELETE FROM maquis WHERE SUCUCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
				
		}
		if($delType == "maqui")
		{
			$str = "DELETE FROM $table WHERE $table.PLATE = '".$info["plate"]."'";
			$query = $this->db->query($str);
			$this->chlog($info);
		}
		if($delType == "techi")
		{
			$str = "DELETE FROM users WHERE MAIL = '".$info["mail"]."' AND TYPE = '".$info["type"]."'";
			$query = $this->db->query($str);
			$this->chlog($info);
		}
		if($delType == "actis")
		{
			$str = "DELETE FROM actis WHERE CODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			$this->chlog($info);
		}
		if($delType == "inve")
		{
			$str = "DELETE FROM $table WHERE $table.CODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$this->chlog($info);
		
		}
		 if($delType == "order")
		{
			$str = "DELETE FROM $table WHERE $table.CODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM oactis WHERE OCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM oparts WHERE OCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM oreports WHERE OCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM others WHERE OCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			
			$path = '../../irsc/pics/'.$info["code"]."/" ;
	
			$this->delDir($path);
			// DELETE ALSO ACTIS, INVEN AND FOLDER
			
			$this->chlog($info);
		
		}
		if($delType == "oacti")
		{
			$str = "DELETE FROM $table WHERE $table.CODE = '".$info["code"]."'";
			$query = $this->db->query($str);
		}
		if($delType == "opart")
		{
			$str = "DELETE FROM $table WHERE $table.CODE = '".$info["code"]."'";
			$query = $this->db->query($str);
		}
		if($delType == "oother")
		{
			$str = "DELETE FROM $table WHERE $table.CODE = '".$info["code"]."'";
			$query = $this->db->query($str);
		}
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
                
        }
	function changePass($info)
	{
                $mail = $info["mail"];
                $type = $info["type"];
                $newPass = md5($info["newPass"]);
                
                $str = "UPDATE users SET users.PASSWD='".$newPass."' WHERE users.MAIL='".$mail."' AND TYPE = '$type'"; 
		$query = $this->db->query($str);
                
                $this->chlog($info);
                
                $resp["message"] = "done";
                $resp["status"] = true;
                return $resp;
        }
	function getSucuParents()
	{
                $str = "SELECT CODE, CNAME FROM users WHERE users.TYPE = 'C' AND STATUS = '1'";
                $query = $this->db->query($str);
                
                if(count($query) > 0)
		{
                        $resp["message"] = $query;
                        $resp["status"] = true;
                        return $resp;
                }
                else
                {
                        $resp["message"] = array();
                        $resp["status"] = true;
                        return $resp;
                }
        }
	function addInvQty($info)
	{
                $code = $info["code"];
                $qty = $info["qty"];
                
                $str = "SELECT AMOUNT FROM inve WHERE CODE = '".$code."' ";
                $query = $this->db->query($str);
                
                $actualAmount = $query[0]["AMOUNT"];
                
                $newAmount = $actualAmount + $qty;
                
                $str = "UPDATE inve SET AMOUNT = '".$newAmount."' WHERE CODE = '".$code."' ";
                $query = $this->db->query($str);
                
                $resp["message"] = "done";
                $resp["status"] = true;
                return $resp;
               
        }
	function getMaquiListSelect($info)
	{
                $code = $info["code"];
                
                $str = "SELECT CODE, PLATE, NAME FROM maquis WHERE SUCUCODE = '".$code."' ORDER BY NAME ASC";
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
                
                return $resp;
        }
	function getMaquiListInfo($info)
	{
                $code = $info["code"];
                
                $str = "SELECT * FROM maquis WHERE CODE = '".$code."'";
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
                
                return $resp;
        }
	function saveoAct($info)
	{
                $OCODE = $info["ocode"];
                $CODE = md5($info["actiCode"].$info["date"]);
                $ACODE = $info["actiCode"];
                $ADESC = $info["actiDesc"];
                $ACOST = $info["actiCost"];
                $UNIPRICE = $info["actUniVal"];
                $UNIVALUE = $info["actQty"];
                $ADURATION = $info["actiDuration"];
                $DATE = $info["date"];
                $MAQUI = $info["maqui"];
                $MAQUINAME = $info["maquiName"];
                $MAQUICODE = $info["maquiCode"];
                $TECHNAME = $info["tech"];
                $TECHCODE = $info["techcode"];
                $OCCODE = $info["occode"];
                
                $str = "INSERT INTO oactis (OCODE, CODE, ACODE, ADESC, ACOST, ADURATION, DATE, MAQUI, MAQUINAME, MAQUICODE, TECHNAME, TECHCODE, OCCODE, UNIPRICE, UNIVALUE) VALUES ('".$OCODE."', '".$CODE."', '".$ACODE."', '".$ADESC."', '".$ACOST."', '".$ADURATION."','".$DATE."', '".$MAQUI."', '".$MAQUINAME."', '".$MAQUICODE."', '".$TECHNAME."', '".$TECHCODE."', '".$OCCODE."','".$UNIPRICE."', '".$UNIVALUE."')";
                $query = $this->db->query($str);
                
                $resp["message"] = "done";
                $resp["status"] = true;
                return $resp;

        }
	function getOActs($info)
	{
			
			$ocode = $info["ocode"];
			
			$str = "SELECT * FROM oactis WHERE OCODE = '".$ocode."'";
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
			
			return $resp;
	}
	function getOothers($info)
	{
			
			$ocode = $info["ocode"];
			
			$str = "SELECT * FROM others WHERE OCODE = '".$ocode."'";
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
			
			return $resp;
	}
	function saveoPart($info)
	{
			$CODE = md5($info["pcode"].$info["date"]);
			$OCODE = $info["ocode"];
			$PDESC = $info["pdesc"];
			$PCODE = $info["pcode"];
			$PCOST = $info["pcost"];
			$PAMOUNT = $info["pamount"];
			$PDOC = $info["pdoc"];

			$str = "INSERT INTO oparts (CODE, OCODE, PDESC, PCODE, PCOST, PAMOUNT, PDOC) VALUES ('".$CODE."', '".$OCODE."', '".$PDESC."', '".$PCODE."', '".$PCOST."', '".$PAMOUNT."','".$PDOC."')";
			$query = $this->db->query($str);
			
			$resp["message"] = "done";
			$resp["status"] = true;
			return $resp;

	}
	function saveoOther($info)
	{
			$CODE = md5($info["ocode"].$info["date"]);
			$OTYPE = $info["otype"];
			$OCODE = $info["ocode"];
			$ODESC = $info["odesc"];
			$COST = $info["ocost"];
			$AMOUNT = $info["oamount"];
			$DOC = $info["odoc"];

			$str = "INSERT INTO others (CODE, OCODE, ODESC, COST, AMOUNT, DOC, OTYPE) VALUES ('".$CODE."', '".$OCODE."', '".$ODESC."', '".$COST."', '".$AMOUNT."', '".$DOC."', '".$OTYPE."')";
			$query = $this->db->query($str);
			
			$resp["message"] = "done";
			$resp["status"] = true;
			return $resp;

	}
	function saveoOtherLeg($info)
	{
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			
			$UCODE = $info["ucode"];
			
			$CODE = md5($info["legItemOrder"].$now);
			$OCODE = $info["legItemOrder"];
			$ODESC = $info["legItemConcept"];
			$COST = $info["legItemPayment"];
			$AMOUNT = "1";
			$DOC = $info["legItemNumber"];
			$OTYPE = $info["legItemConcept"];

			$LEGCODE = $info["legCode"];
			$LEGPARENT = $info["legItemParentName"];
			$LEGPARENTCODE = $info["legItemParent"];
			$LEGORDER = $info["legItemOrderNumber"];
			$LEGDATE = $info["legItemDate"];
			$LEGCNAME = $info["legItemCname"];
			$LEGCID = $info["legItemId"];
			$LEGBASE = $info["legItemBase"];
			$LEGTAX = $info["legItemTax"];
			$LEGTOTAL = $info["legItemTotal"];
			$LEGRETFONT = $info["legItemRetFont"];
			$LEGRETICA = $info["legItemRetICA"];
			$LEGAUTORNAME = $info["uname"];
			$LEGONUM = $info["uname"];
			

			$str = "INSERT INTO others (CODE, OCODE, ODESC, COST, AMOUNT, DOC, OTYPE, LEGCODE, LEGAUTOR, LEGPARENTCODE, LEGPARENT, LEGORDER, LEGDATE, LEGCNAME, LEGCID, LEGBASE, LEGTAX, LEGTOTAL, LEGRETFONT, LEGRETICA, LEGAUTORNAME) VALUES ('".$CODE."', '".$OCODE."', '".$ODESC."', '".$COST."', '".$AMOUNT."', '".$DOC."', '".$OTYPE."', '".$LEGCODE."', '".$UCODE."', '".$LEGPARENTCODE."', '".$LEGPARENT."', '".$LEGORDER."', '".$LEGDATE."', '".$LEGCNAME."', '".$LEGCID."', '".$LEGBASE."', '".$LEGTAX."', '".$LEGTOTAL."', '".$LEGRETFONT."', '".$LEGRETICA."', '".$LEGAUTORNAME."')";
			$query = $this->db->query($str);
			
			
			
			$str = "SELECT * FROM others WHERE LEGAUTOR = '".$UCODE."' AND LEGCODE = '".$LEGCODE."'";
			$query = $this->db->query($str);	
			
			$resp["message"] = $query;
			$resp["status"] = true;
			return $resp;

	}
	function getLeg($info)
	{
		
		$code = $info["code"];
		$autor = $info["autor"];
		
		
		$str = "SELECT * FROM others WHERE LEGCODE = '".$code."' AND LEGAUTOR = '".$autor."' ORDER BY CONS ASC";
		$query = $this->db->query($str);	
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getUserLegs($info)
	{
		
		$ans = [];
		
		$str = "SELECT TYPE, CODE, CNAME FROM users WHERE TYPE = 'CO' OR TYPE = 'JZ' OR TYPE = 'A'ORDER BY TYPE";
		$query = $this->db->query($str);	
		
		$ans["users"] = $query;
		
		$str = "SELECT LEGCODE, LEGAUTOR, LEGSTATE FROM others WHERE LEGCODE != '' GROUP BY LEGCODE, LEGAUTOR ORDER BY LEGCODE ASC";
		$query = $this->db->query($str);	
		
		$ans["legs"] = $query;

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function refreshLegCodes($info)
	{
		
		$ucode = $info["ucode"];
		
		$str = "SELECT LEGCODE FROM others WHERE LEGCODE != '' AND LEGAUTOR = '".$ucode ."' GROUP BY LEGCODE ORDER BY LEGCODE ASC";
		$query = $this->db->query($str);	
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function restoreLeg($info)
	{
		
		$code = $info["legCode"];
		$autor = $info["legAutor"];
		
		
		$str = "UPDATE others SET LEGSTATE = '0' WHERE LEGCODE = '".$code."' AND LEGAUTOR = '".$autor."'";
		$query = $this->db->query($str);
		
		$str = "SELECT * FROM others WHERE LEGCODE = '".$code."' AND LEGAUTOR = '".$autor."'";
		$query = $this->db->query($str);	
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function updateoDets($info)
	{
			$ocode = $info["ocode"];
			$obs = $info["obs"];
			// $rec = $info["rec"];
			// $pen = $info["pen"];
			
			
			$str = "UPDATE orders SET OBSERVATIONS = '".$obs."'  WHERE CODE = '".$ocode."' ";
			$query = $this->db->query($str);
			
			$resp["message"] = "done";
			$resp["status"] = true;
			return $resp;

	}
	function updateActCost($info)
	{
			$actCode = $info["actCode"];
			$newCost = $info["newCost"];
			
			$str = "UPDATE oactis SET ACOST = '".$newCost."' WHERE CODE = '".$actCode."' ";
			$query = $this->db->query($str);
			
			$resp["message"] = "done";
			$resp["status"] = true;
			return $resp;
			
	}
	function updatePartCost($info)
	{
			$partCode = $info["partCode"];
			$newCost = $info["newCost"];
			
			$str = "UPDATE oparts SET PCOST = '".$newCost."' WHERE CODE = '".$partCode."' ";
			$query = $this->db->query($str);
			
			$resp["message"] = "done";
			$resp["status"] = true;
			return $resp;
			
	}
	function updateOtherCost($info)
	{
                $otherCode = $info["otherCode"];
                $newCost = $info["newCost"];
                
                $str = "UPDATE others SET COST = '".$newCost."' WHERE CODE = '".$otherCode."' ";
                $query = $this->db->query($str);
                
                $resp["message"] = "done";
                $resp["status"] = true;
                return $resp;
                
        }
	function getoPartList($info)
	{


		if(isset($info["value"])){$value = $info["value"];}
		else{$value = "";}
		
		$where = "WHERE STATUS = 1 ";

		if($value != "")
		{
			$where .= "AND  DESCRIPTION LIKE '%$value%'";
		}
                
                
		$str = "SELECT * FROM inve $where ORDER  BY CODE";
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

		return $resp;
	
	}
	function getOParts($info)
	{
                
                $ocode = $info["ocode"];
                
                $str = "SELECT * FROM oparts WHERE OCODE = '".$ocode."'";
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
                
                return $resp;
        }
	function getoDetails($info)
	{
                $ocode = $info["ocode"];
                
                $str = "SELECT OBSERVATIONS, RECOMENDATIONS, PENDINGS FROM orders WHERE CODE = '".$ocode."'";
                $query = $this->db->query($str);
                
                if(count($query) > 0)
                {
                        
                        $ans = array();
                        $ans["obs"] = $query[0]["OBSERVATIONS"];
                        $ans["rec"] = $query[0]["RECOMENDATIONS"];
                        $ans["pen"] = $query[0]["PENDINGS"];
                        
                        
                        
                        $resp["message"] = $ans;
                        $resp["status"] = true;
                }
                else
                {
                        $resp["message"] = array();
                        $resp["status"] = true;
                }
                
                return $resp;
        }
	function getOpics($info)
	{
                $ocode = $info["ocode"];
                
                $directorioIni = '../../irsc/pics/'.$ocode."/ini/" ;
                
                $oPics = array();

                $dirFiles = array();
                if ($handle = opendir($directorioIni)) {
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
                
                $oPics["ini"] = $dirFiles;
                
                $directorioEnd = '../../irsc/pics/'.$ocode."/end/";
                
                $dirFiles = array();
                if ($handle = opendir($directorioEnd)) {
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
                
                $oPics["end"] = $dirFiles;
				
				$directorioOrder = '../../irsc/pics/'.$ocode."/order/" ;
                
                $dirFiles = array();
                if ($handle = opendir($directorioOrder)) {
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
                
                $oPics["order"] = $dirFiles;
                
                $resp["message"] = $oPics;
                $resp["status"] = true;
                return $resp;
        }
	function orderFullGet($info)
	{
		$ocode = $info["ocode"];
		$opack = array();
		
		$str = "SELECT * FROM orders WHERE CODE = '".$ocode."'";
		$query = $this->db->query($str);
		$oData = $query[0];

		$dpkc = array();
		$dpkc["code"] = $oData["SUCUCODE"];
		$maquPlist = $this-> getMaquiListSelect($dpkc)["message"];
		
		$actPlist = $this->getoActiList(null)["message"];
		
		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		$oActs = $this-> getOActs($dpkc)["message"];
		
		$partPlist = $this->getoPartList(null)["message"];

		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		$oParts = $this-> getOParts($dpkc)["message"];
		
		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		$oOthers = $this-> getOothers($dpkc)["message"];

		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		$oPics = $this-> getOpics($dpkc)["message"];

		
		$opack["oData"] = $oData;
		$opack["actPlist"] = $actPlist;
		$opack["maquPlist"] = $maquPlist;
		$opack["oActs"] = $oActs;
		$opack["partPlist"] = $partPlist;
		$opack["oParts"] = $oParts;
		$opack["oOthers"] = $oOthers;
		$opack["oPics"] = $oPics;
		
		$resp["message"] = $opack;
		$resp["status"] = true;
				
		return $resp;
	}
	function getTechiListO($info)
	{
		$str = "SELECT CODE, RESPNAME, CATEGORY, TYPE, LOCATION, MASTERY, DETAILS  FROM users WHERE TYPE = 'T' OR TYPE = 'JZ' OR TYPE = 'CO' AND STATUS = '1' ORDER BY TYPE ASC";
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

		return $resp;
	}
	function setTechO($info)
	{
		$ocode = $info["ocode"];
		$name = $info["name"];
		$code = $info["code"];
		$resptype = $info["resptype"];
		
		if($resptype == "T")
		{
			$str = "UPDATE orders SET TECHCODE = '".$code."', TECHNAME = '".$name."', STATE = '2', RESPTYPE = '$resptype'  WHERE CODE ='".$ocode."'";
		}
		else if($resptype == "JZ")
		{
			$str = "UPDATE orders SET JZCODE = '".$code."',  TECHNAME = '".$name."', STATE = '6', RESPTYPE = '$resptype'  WHERE CODE ='".$ocode."'";
		}
		else if($resptype == "CO")
		{
			$str = "UPDATE orders SET AUTORCODE = '".$code."',  TECHNAME = '".$name."', STATE = '1', RESPTYPE = '$resptype'  WHERE CODE ='".$ocode."'";
		}
		
		
		$query = $this->db->query($str);

		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
        }
	function updateStarTime($info)
	{
                $ocode = $info["ocode"];
                $date = $info["date"];
                
                $str = "UPDATE orders SET STARTIME = '".$date."' WHERE CODE ='".$ocode."'";
                $query = $this->db->query($str);

                $resp["message"] = "done";
                $resp["status"] = true;
                return $resp;
        }
	function reportCreate($info)
	{
		$ocode = $info["ocode"];
		$date = $info["odate"];
		$diff = $info["diff"];
		$str = "SELECT *  FROM orders WHERE CODE = '".$ocode."'";
		$query = $this->db->query($str);
		$partial = $info["partial"];
		
		$odata = $query[0];
		
		$str = "SELECT *  FROM oactis WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		$actList = $query;
		
		$str = "SELECT *  FROM oparts WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		$partList = $query;
		
		$str = "SELECT *  FROM others WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		$otherList = $query;
		
		$icode = $odata["ICODE"];
		
		$number = $odata["CCODE"];
		if(strlen($number) == 1){$number = "000".$number;}
		else if(strlen($number) == 2){$number = "00".$number;}
		else if(strlen($number) == 3){$number = "0".$number;}
		else{$number = $number;}
		
		if($icode != null and $icode != "")
		{
				$number = $number."-".$icode;
		}
		$cname = utf8_decode($odata["PARENTNAME"]);
		if($odata["SUCUNAME"] == "-")
		{
				$sucuname = $odata["SUCUCODE"];
		}
		else
		{
				$sucuname = $odata["SUCUNAME"];
		}
		$techname = utf8_decode($odata["TECHNAME"]);
		$requestdate = $odata["DATE"];
		$atendedate = $odata["STARTIME"];
		// $reported = $diff . " Minutos";
		$reported =  $odata["CONTACT"];
		$detail = utf8_decode($odata["DETAIL"]);
		$obs = utf8_decode($odata["OBSERVATIONS"]);
		$rec = utf8_decode($odata["RECOMENDATIONS"]);
		$pen = utf8_decode($odata["PENDINGS"]);
		
		
		// FILE START
		$pdf = new PDF_MC_Table();
		
		$pdf->AddPage('P', 'Letter');
		$pdf->Image('../../irsc/forder.jpg',0,0,218,0,'','');
		$pdf->SetFont('Arial','B', 12);
		$pdf->SetFillColor(102,102,102);
		
		// HEADER START-----------
		
		
		$cname = substr($cname,0,30);
		$techname = substr($techname,0,28);
		$sucuname = substr(utf8_decode($sucuname),0,30);
		$reported = substr(utf8_decode($reported),0,28);
		
		// H LINE 1
		$pdf->Ln(4);
		$pdf->Cell(180,5,'',0,0,'C',false);
		$pdf->Cell(14,5,$number,0,0,'R',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->Ln(11);
		$pdf->Cell(10,5,'',0,0,'C',false);
		$pdf->Cell(53,5,$cname,0,0,'L',false);
		$pdf->Cell(28,5,'',0,0,'C',false);
		$pdf->Cell(43,5,$techname,0,0,'L',false);
		$pdf->Cell(35,5,'',0,0,'C',false);
		$pdf->Cell(35,5,$requestdate,0,0,'L',false);
		$pdf->Ln(7);

		// H LINE 2
		$pdf->Cell(13,5,'',0,0,'C',false);
		$pdf->Cell(48,5,$sucuname,0,0,'L',false);
		$pdf->Cell(33,5,'',0,0,'C',false);
		$pdf->Cell(15,5,$reported,0,0,'L',false);
		$pdf->Cell(60,5,'',0,0,'C',false);
		$pdf->Cell(35,5,$atendedate,0,0,'L',false);
		$pdf->Ln(7);
		
		// H LINE 2
		$pdf->Cell(13,5,'',0,0,'C',false);
		
		if(strlen($detail) < 130)
		{
				$pdf->Cell(48,5,$detail,0,0,'L',false);
				$pdf->Ln(6);
		}
		else
		{
				$line1 = str_split($detail, 130)[0];
				$line2 = str_split($detail, 130)[1];
				
				$pdf->Cell(183,5,$line1,0,0,'L',false);
				$pdf->Ln(6);
				$pdf->Cell(196,5,$line2,0,0,'L',false);
		}
		
		// HEADER END -----------

		$pdf->Ln(8);
		$pdf->SetDrawColor(39,46,54);
		$pdf->SetLineWidth(.2);
		
		// CONTENT ACTIVITIES---------

		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(50,6,'Actividades',0,0,'L',false);
		$location = utf8_decode($odata["LOCATION"]);
		$pdf->Cell(145,6,'Ciudad/Municipio: '.$location,0,1,'R',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->SetTextColor(255);

		// HEADERS
		$w = array(25, 45, 125);
		$header = array('Placa', 'Nombre', 'Actividad');
		
		for($i=0;$i<count($header);$i++)
		{
			$pdf->Cell($w[$i],5,utf8_decode($header[$i]),1,0,'L',true);
		}
		
		$pdf->Ln(5);
		$pdf->SetWidths($w);
		
		
		$pdf->SetFillColor(230,230,230);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		$fill = false;
		
		// actData
		foreach($actList as $row)
		{
			$align = array("L", "L", "L");
			
			$maqui = utf8_decode($row['MAQUI']);
			$maquiname = utf8_decode($row['MAQUINAME']);
			$adesc = utf8_decode($row['ADESC']);
			
			$pdf->Row(array($maqui, $maquiname, $adesc), 1, $align);
				
			$fill = !$fill;
		}
		
		// lineClose
		$pdf->Cell(array_sum($w),0,'','T');
		
		$pdf->Ln(1);
		
		// CONTENT ACTIVITIES END---------
		
		// CONTENT PARTS---------
		
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(50,6,'Repuestos',0,1,'L',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->SetTextColor(255);
		$pdf->SetFillColor(102,102,102);
		
		
		// HEADERS
		$w = array(25, 150, 20);
		$header = array('Código', 'Descripción', 'Cantidad');
		
		for($i=0;$i<count($header);$i++)
		{
			$pdf->Cell($w[$i],5,utf8_decode($header[$i]),1,0,'L',true);
		}

		$pdf->Ln(5);
		$pdf->SetWidths($w);
		
		$pdf->SetFillColor(230,230,230);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		$fill = false;
		
		// partData
		foreach($partList as $row)
		{
				
			$align = array("L", "L", "L");
		
			$pcode = utf8_decode($row['PCODE']);
			$pdesc = utf8_decode($row['PDESC']);
			$pamount = utf8_decode($row['PAMOUNT']);
			
			$pdf->Row(array($pcode, $pdesc, $pamount), 1, $align);
			
			
			$fill = !$fill;
		}
		
		// lineClose
		$pdf->Cell(array_sum($w),0,'','T');
		
		$pdf->Ln(1);
		
		// TRANSPORT CONTENT
		
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(50,6,'Otros conceptos',0,1,'L',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->SetTextColor(255);
		$pdf->SetFillColor(102,102,102);
		$w = array(195);
		$header = array('Descripción');
		
		$pdf->Ln(1);
		
		// Header
		for($i=0;$i<count($header);$i++)
		{
				$pdf->Cell($w[$i],5,utf8_decode($header[$i]),1,0,'L',true);
		}
		$pdf->Ln(5);
		
		$pdf->SetFillColor(230,230,230);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		$fill = false;
		
		 // otherData
		foreach($otherList as $row)
		{
			$pdf->Cell($w[0],5,utf8_decode($row['ODESC']),'LR',0,'L',$fill);
			$pdf->Ln(5);
			$fill = !$fill;
		}
		
		// lineClose
		$pdf->Cell(array_sum($w),0,'','T');
		
		$pdf->SetFont('Arial','', 7);
		
		// OBS FILLER
		$pdf->SetY(-82);
		
		$w = array(195);
		$pdf->SetWidths($w);
		$align = array("L");
		$pdf->Row(array($obs), 1, $align);

		// ADITIONAL IMAGE PAGES
		
		$infoAdd = " Orden: ".$number." - ".$cname;
		
		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		$oPics = $this-> getOpics($dpkc)["message"];
		
		$pdf->SetFont('Arial','B', 11);
		$pdf->AddPage('P', 'Letter');
		$pdf->Ln(2);
		$pdf->Cell(50,5,"Foto Inicial ".$infoAdd,0,0,'L',false);
		
		$imgPath1 = '../../irsc/pics/'.$ocode."/ini/".$oPics["ini"][0];
		$pdf->Image($imgPath1,0,20,216,110);
		
		$pdf->Ln(125);
		
		$pdf->Cell(50,5,"Foto Final ".$infoAdd,0,0,'L',false);
		
		$imgPath2 = '../../irsc/pics/'.$ocode."/end/".$oPics["end"][0];
		$pdf->Image($imgPath2,0,145,216,110);
		
		$pdf->AddPage('P', 'Letter');
		$pdf->Ln(2);
		$pdf->Cell(50,5,"Foto orden de Trabajo ".$infoAdd,0,0,'L',false);
		
		$imgPath3 = '../../irsc/pics/'.$ocode."/order/".$oPics["order"][0];
		$pdf->Image($imgPath3,0,20,216,250);

		
		
		// createFile
		$pdf->Output('../../reports/'.$ocode.'.pdf','F');

		if($partial != "1")
		{
				$str = "UPDATE orders SET STATE = '3', CLOSEDATE = '".$date."' WHERE CODE ='".$ocode."'";
				$query = $this->db->query($str);
		}

		$str = "SELECT CODE FROM oreports WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
				$str = "UPDATE oreports SET DATE = '".$date."', TECHCODE = '".$odata['TECHCODE']."', TECHNAME = '".$odata['TECHNAME']."', OCCODE = '".$odata["CCODE"]."' WHERE OCODE ='".$ocode."'";
				$query = $this->db->query($str);
		}
		else
		{
				$now = new DateTime();
				$now = $now->format('Y-m-d H:i:s');
			   
			   $code = md5($ocode.$now);
				
				$str = "INSERT INTO oreports (CODE, OCODE, DATE, PARENTNAME, PARENTCODE, SUCUCODE, SUCUNAME, TECHCODE, TECHNAME, OCCODE, STATUS, TYPE) VALUES ('".$code."', '".$ocode."', '".$date."', '".$odata['PARENTNAME']."', '".$odata['PARENTCODE']."', '".$odata['SUCUCODE']."', '".$odata['SUCUNAME']."', '".$odata['TECHCODE']."', '".$odata['TECHNAME']."', '".$odata["CCODE"]."', '1', '0')";
				$query = $this->db->query($str);
		}
		

		$resp["message"] = "done";
		$resp["status"] = true;
		
		return $resp;
                
        }
	function reportCreateTotalized($info)
	{
		$ocode = $info["ocode"];
		$date = $info["odate"];
		$diff = $info["diff"];
		$str = "SELECT *  FROM orders WHERE CODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		$odata = $query[0];
		
		$str = "SELECT *  FROM oactis WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		$actList = $query;
		
		$str = "SELECT *  FROM oparts WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		$partList = $query;
		
		$str = "SELECT *  FROM others WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		$otherList = $query;
		
		$icode = $odata["ICODE"];
		
		$number = $odata["CCODE"];
		if(strlen($number) == 1){$number = "000".$number;}
		else if(strlen($number) == 2){$number = "00".$number;}
		else if(strlen($number) == 3){$number = "0".$number;}
		else{$number = $number;}
		
		if($icode != null and $icode != "")
		{
				$number = $number."-".$icode;
		}
		
		
		$cname = $odata["PARENTNAME"];
		
		if($odata["SUCUNAME"] == "-")
		{
			$sucuname = $odata["SUCUCODE"];
		}
		else
		{
			$sucuname = $odata["SUCUNAME"];
		}
		$techname = $odata["TECHNAME"];
		$requestdate = $odata["DATE"];
		$atendedate = $odata["STARTIME"];
		// $reported = $diff . " Minutos";
		$reported =  $odata["CONTACT"];
		$detail = utf8_decode($odata["DETAIL"]);
		$obs = utf8_decode($odata["OBSERVATIONS"]);
		$rec = utf8_decode($odata["RECOMENDATIONS"]);
		$pen = utf8_decode($odata["PENDINGS"]);
		
		// FILE START
		$pdf = new PDF_MC_Table();
		
		$pdf->AddPage('P', 'Letter');
		$pdf->Image('../../irsc/forderTotalized.jpg',0,0,218,0,'','');
		$pdf->SetFont('Arial','B', 12);
		$pdf->SetFillColor(102,102,102);
		$pdf->SetAutoPageBreak(false);
		
		// HEADER START-----------
		// $cname = "lalala";
		$cname = substr(utf8_decode($cname),0,30);
		$techname = substr(utf8_decode($techname),0,28);
		$sucuname = substr(utf8_decode($sucuname),0,30);
		$reported = substr(utf8_decode($reported),0,28);
		
		// H LINE 1
		$pdf->Ln(4);
		$pdf->Cell(180,5,'',0,0,'C',false);
		$pdf->Cell(14,5,$number,0,0,'R',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->Ln(11);
		$pdf->Cell(10,5,'',0,0,'C',false);
		$pdf->Cell(53,5,$cname,0,0,'L',false);
		$pdf->Cell(28,5,'',0,0,'C',false);
		$pdf->Cell(43,5,$techname,0,0,'L',false);
		$pdf->Cell(35,5,'',0,0,'C',false);
		$pdf->Cell(35,5,$requestdate,0,0,'L',false);
		$pdf->Ln(7);

		// H LINE 2
		$pdf->Cell(13,5,'',0,0,'C',false);
		$pdf->Cell(48,5,$sucuname,0,0,'L',false);
		$pdf->Cell(33,5,'',0,0,'C',false);
		$pdf->Cell(15,5,$reported,0,0,'L',false);
		$pdf->Cell(60,5,'',0,0,'C',false);
		$pdf->Cell(35,5,$atendedate,0,0,'L',false);
		$pdf->Ln(7);
		
		// H LINE 2
		$pdf->Cell(13,5,'',0,0,'C',false);
		
		if(strlen($detail) < 130)
		{
			$pdf->Cell(48,5,$detail,0,0,'L',false);
			$pdf->Ln(6);
		}
		else
		{
			$line1 = str_split($detail, 130)[0];
			$line2 = str_split($detail, 130)[1];
			
			$pdf->Cell(183,5,$line1,0,0,'L',false);
			$pdf->Ln(6);
			$pdf->Cell(196,5,$line2,0,0,'L',false);
		}
		
		// HEADER END -----------

		$pdf->Ln(8);
		$pdf->SetDrawColor(39,46,54);
		$pdf->SetLineWidth(.2);
		
		// CONTENT ACTIVITIES---------

		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(50,6,'Actividades',0,0,'L',false);
		$location = utf8_decode($odata["LOCATION"]);
		$pdf->Cell(145,6,'Ciudad/Municipio: '.$location,0,1,'R',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->SetTextColor(255);
		
		
		
		$w = array(25, 19, 102, 13, 18, 18);
		$header = array('Placa', 'Nombre', 'Actividad', 'Cant', 'Valor un', 'Subtotal');
	   
		// Header
		for($i=0;$i<count($header);$i++)
		{
			$pdf->Cell($w[$i],5,utf8_decode($header[$i]),1,0,'L',true);
		}
		$pdf->Ln(5);
		
		$pdf->SetFillColor(230,230,230);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		$fill = false;
		$pdf->SetWidths($w);
		
		$tActis = 0;
		// actData
		foreach($actList as $row)
		{
			$align = array("L", "L", "L", "C", "R", "R");
			
			$maqui = utf8_decode($row['MAQUI']);
			$maquiname = utf8_decode($row['MAQUINAME']);
			$adesc = utf8_decode($row['ADESC']);
			$qty = $row['UNIVALUE'];
			$univalT = '$'.number_format($row['UNIPRICE']);
			$unival = $row['UNIPRICE'];
			$subtotal = '$'.number_format($qty*$unival);
			
			$pdf->Row(array($maqui, $maquiname, $adesc,$qty, $univalT, $subtotal), 1, $align);

			$fill = !$fill;
			$tActis += ($qty*$unival);
		}
		
		// lineClose
		$pdf->Cell(array_sum($w),0,'','T');
		
		$pdf->Ln(1);
		
		// CONTENT ACTIVITIES END---------
		
		// CONTENT PARTS---------
		
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(165,6,'Repuestos',0,0,'L',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->Cell(12,6,'Total',1,0,'C',false);
		$pdf->Cell(18,6,'$'.number_format($tActis),1,0,'R',false);
		$pdf->Ln(6);
		$pdf->SetTextColor(255);
		$pdf->SetFillColor(102,102,102);
		$w = array(20, 127, 18, 12, 18);
		$header = array('Código', 'Descripción', 'Valor Un.', 'Cant', 'Valor');
		
		$pdf->Ln(1);
		
		// Header
		for($i=0;$i<count($header);$i++)
		{
				$pdf->Cell($w[$i],5,utf8_decode($header[$i]),1,0,'L',true);
		}
		$pdf->Ln(5);
		
		$pdf->SetFillColor(230,230,230);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		$fill = false;
		
		$tRepus = 0;
		// partData
		foreach($partList as $row)
		{
				$pdf->Cell($w[0],5,$row['PCODE'],'LR',0,'L',$fill);
				$pdf->Cell($w[1],5,utf8_decode($row['PDESC']),'LR',0,'L',$fill);
				$pdf->Cell($w[2],5,'$'.number_format($row['PCOST']),'LR',0,'R',$fill);
				$pdf->Cell($w[3],5,$row['PAMOUNT'],'LR',0,'C',$fill);
				$pdf->Cell($w[4],5,'$'.number_format($row['PAMOUNT']*$row['PCOST']),'LR',0,'R',$fill);
				$pdf->Ln(5);
				$fill = !$fill;
				
				$tRepus += ($row['PAMOUNT']*$row['PCOST']);
		}
		
		// lineClose
		$pdf->Cell(array_sum($w),0,'','T');
		
		$pdf->Ln(1);
		
		// TRANSPORT CONTENT
		
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(165,6,'Otros conceptos',0,0,'L',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->Cell(12,6,'Total',1,0,'C',false);
		$pdf->Cell(18,6,'$'.number_format($tRepus),1,0,'R',false);
		$pdf->Ln(6);
		$pdf->SetTextColor(255);
		$pdf->SetFillColor(102,102,102);
		$w = array(147, 18, 12, 18);
		$header = array('Descripción', 'Valor Un.', 'Cant', 'Valor');
		
		$pdf->Ln(1);
		
		// Header
		for($i=0;$i<count($header);$i++)
		{
				$pdf->Cell($w[$i],5,utf8_decode($header[$i]),1,0,'L',true);
		}
		$pdf->Ln(5);
		
		$pdf->SetFillColor(230,230,230);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		$fill = false;
		
		$tOthers = 0;
		
		 // otherData
		foreach($otherList as $row)
		{
				$pdf->Cell($w[0],5,utf8_decode($row['ODESC']),'LR',0,'L',$fill);
				$pdf->Cell($w[1],5,'$'.number_format($row['COST']),'LR',0,'L',$fill);
				$pdf->Cell($w[2],5,$row['AMOUNT'],'LR',0,'C',$fill);
				$pdf->Cell($w[3],5,'$'.number_format($row['COST']*$row['AMOUNT']),'LR',0,'R',$fill);
				$pdf->Ln(5);
				$fill = !$fill;
				
				$tOthers += ($row['COST']*$row['AMOUNT']);
		}
		
		// lineClose
		$pdf->Cell(array_sum($w),0,'','T');
		$pdf->SetFont('Arial','B', 8);
		$pdf->Ln(1);
		$pdf->Cell(165,6,'',0,0,'L',false);
		$pdf->Cell(12,6,'Total',1,0,'C',false);
		$pdf->Cell(18,6,'$'.number_format($tOthers),1,0,'R',false);
		
		$pdf->SetFont('Arial','', 7);
		
		// OBS FILLER
		$pdf->SetY(-62);
		
		$w = array(195);
		$pdf->SetWidths($w);
		$align = array("L");
		$pdf->Row(array($obs), 1, $align);
		
		
		// ADITIONAL IMAGE PAGES
		
		$infoAdd = " Orden: ".$number." - ".$cname;
		
		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		$oPics = $this-> getOpics($dpkc)["message"];
		
		$pdf->SetFont('Arial','B', 11);
		$pdf->AddPage('P', 'Letter');
		$pdf->Ln(2);
		$pdf->Cell(50,5,"Foto Inicial ".$infoAdd,0,0,'L',false);
		
		$imgPath1 = '../../irsc/pics/'.$ocode."/ini/".$oPics["ini"][0];
		$pdf->Image($imgPath1,0,20,216,110);
		
		$pdf->Ln(125);
		
		$pdf->Cell(50,5,"Foto Final ".$infoAdd,0,0,'L',false);
		
		$imgPath2 = '../../irsc/pics/'.$ocode."/end/".$oPics["end"][0];
		$pdf->Image($imgPath2,0,145,216,110);
		
		$pdf->AddPage('P', 'Letter');
		$pdf->Ln(2);
		$pdf->Cell(50,5,"Foto orden de Trabajo ".$infoAdd,0,0,'L',false);
		
		$imgPath3 = '../../irsc/pics/'.$ocode."/order/".$oPics["order"][0];
		$pdf->Image($imgPath3,0,20,216,250);
		
		
		// createFile
		$pdf->Output('../../reports/'.$ocode.'-T.pdf','F');

		// DOWNLOAD INVENTORY
		$dpkc = array();
		$dpkc["items"] = $partList;
		$this-> discountInv($dpkc);

		
		$str = "UPDATE orders SET STATE = '4' WHERE CODE ='".$ocode."'";
		$query = $this->db->query($str);
		
		$str = "UPDATE oreports SET TYPE = '1' WHERE OCODE ='".$ocode."'";
		$query = $this->db->query($str);
		

		$resp["message"] = "done";
		$resp["status"] = true;
		
		return $resp;
                
        }
	function getMaquiStory($info)
	{
                $code = $info["code"];
                
                $str = "SELECT *  FROM oactis WHERE MAQUICODE = '".$code."' ORDER BY DATE DESC";
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
                
                return $resp;
                
        }
	function getRepList($info)
	{
                
                $parent = $info["f-repParent"];
                $sucu = $info["f-repSucu"];
                $number = $info["f-repNumber"];
                $iniDate = $info["f-repInidate"];
                $enDate = $info["f-repEndate"];
                $tech = $info["f_repTech"];
 
                $where = "WHERE STATUS = 1 ";

		if($parent != "")
		{
			$where .= "AND  PARENTCODE =  '$parent'";
		}
		if($iniDate != "")
		{
			$where .= "AND  DATE >= '$iniDate'";
		}
		if($enDate != "")
		{
			$where .= "AND  DATE <= '$enDate'";
		}
                if($sucu != "")
		{
			$where .= "AND  SUCUCODE = '$sucu'";
		}
                if($number != "")
		{
			$where .= "AND  OCCODE LIKE '%$number%'";
		}
                if($tech != "")
		{
			$where .= "AND  TECHCODE = '$tech'";
		}

                
                $str = "SELECT *  FROM oreports $where ORDER BY DATE DESC LIMIT 20";
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

		return $resp;
	
	}
	function getRecList($info)
	{
                $number = $info["f-recNumber"];
                $parent = $info["f-recParent"];
                $onum = $info["f-repOnum"];
                $iniDate = $info["f-recInidate"];
                $enDate = $info["f-recEndate"];
 
                $where = "WHERE STATUS = 1 ";

		if($number != "")
		{
			$where .= "AND NUM LIKE '%$number%'";
		}
                if($parent != "")
		{
			$where .= "AND  PARENTCODE =  '$parent'";
		}
		if($onum != "")
		{
			$where .= "AND  ORDERS LIKE '%$onum%'";
		}
                if($iniDate != "")
		{
			$where .= "AND  DATE >= '$iniDate'";
		}
		if($enDate != "")
		{
			$where .= "AND  DATE <= '$enDate'";
		}
                
                
                
                $str = "SELECT *  FROM receipts $where ORDER BY NUM DESC LIMIT 50";
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

		return $resp;
	
	}
	function getOtotals($info)
	{
			
			$oList = $info["picks"];
			$retCheck = $info["retCheck"];
			$ansList = array();
			$ansTotaled = array();
			$actisTotal = 0;
			$repuTotal = 0;
			$otherTotal = 0;
			$ivaTotal = 0;
			$rete4 = 0;
			$rete25 = 0;
			
			$baseServicios = 133000;
			$baseInsumos = 895000;
			
			for($i=0; $i<count($oList); $i++)
			{
					$reg = array();
					
					$str = "SELECT CCODE FROM orders WHERE CODE = '".$oList[$i]."'";
					$query = $this->db->query($str);

					$number = $query[0]["CCODE"];
					if(strlen($number) == 1){$number = "000".$number;}
					else if(strlen($number) == 2){$number = "00".$number;}
					else if(strlen($number) == 3){$number = "0".$number;}
					else{$number = $number;}
					
					$str = "SELECT SUM(ACOST) AS aTotal FROM oactis WHERE OCODE = '".$oList[$i]."'";
					$query = $this->db->query($str);
					
					// TOTAL ACTS
					if($query[0]["aTotal"] == null){$reg["tActis"] = 0;}else{$reg["tActis"] = $query[0]["aTotal"];}

					$str = "SELECT SUM(PCOST * PAMOUNT) AS rTotal FROM oparts  WHERE OCODE = '".$oList[$i]."'";
					$query = $this->db->query($str);
					
					// TOTAL REPS
					if($query[0]["rTotal"] == null){$reg["tReps"] = 0;}else{$reg["tReps"] = $query[0]["rTotal"];}
					
					$str = "SELECT SUM(COST * AMOUNT) AS osubTotal FROM others  WHERE OCODE = '".$oList[$i]."'";
					$query = $this->db->query($str);
					
					// TOTAL OTHERS
					if($query[0]["osubTotal"] == null){$reg["tOthers"] = 0;}else{$reg["tOthers"] = $query[0]["osubTotal"];}
					
					// NO OTHER COUNTS ---------------------
					$reg["tOthers"] = 0;
					// NO OTHER COUNTS ---------------------
					
					$reg["osubTotal"] = $reg["tActis"]+$reg["tReps"]+$reg["tOthers"];
					
					// IVA
					$reg["oTax"] = $reg["osubTotal"]*19/100;
					
					// SUBTOTAL
					$reg["oWithTax"] = $reg["osubTotal"]*1.19; 
					
					// RET 4
					$reg["oRet4"] = ($reg["tActis"]*4/100)+($reg["tOthers"]*4/100); 
					
					// RET 25
					$reg["oRet25"] = $reg["tReps"]*2.5/100; 
					
					// TOTAL
					$reg["oTotal"] = $reg["osubTotal"] + $reg["oTax"] - $reg["oRet4"] - $reg["oRet25"];
					
					$reg["oNumber"] = $number;                        

					$ansList[] = $reg;
					
					$actisTotal += $reg["tActis"];
					$repuTotal += $reg["tReps"];
					$otherTotal += $reg["tOthers"];
					$ivaTotal += $reg["oTax"];
					$rete4 += $reg["oRet4"];
					$rete25 += $reg["oRet25"];
					
					$str = "UPDATE orders SET TOTALCOST = '".$reg["osubTotal"]."' WHERE CODE ='".$oList[$i]."'";
					$query = $this->db->query($str);
					
			}
			
			$ansTotaled["actis"] = $actisTotal;
			$ansTotaled["repu"] = $repuTotal;
			$ansTotaled["othe"] = $otherTotal;
			$ansTotaled["iva"] = $ivaTotal;
			$ansTotaled["rete4"] = $rete4;
			$ansTotaled["rete25"] = $rete25;
			
			 // if($ansTotaled["actis"] < $baseServicios or $retCheck == "0")
			// ACTIVAR SI PIDEN CAMBIO PARA INCLUIR OTROS EN BASE DE RETENCION
			if(($ansTotaled["actis"]+$ansTotaled["othe"]) < $baseServicios or $retCheck == "0")
			{
					for($i=0; $i<count($ansList); $i++)
					{
							$ansList[$i]["oRet4"] = 0; 
							
							$ansList[$i]["oTotal"] = $ansList[$i]["osubTotal"] + $ansList[$i]["oTax"] - $ansList[$i]["oRet4"] - $ansList[$i]["oRet25"];
					}
					$ansTotaled["rete4"] = 0;
			}
			
			if($ansTotaled["repu"] < $baseInsumos or $retCheck == "0")
			{
					for($i=0; $i<count($ansList); $i++)
					{
							$ansList[$i]["oRet25"] = 0; 
							$ansList[$i]["oTotal"] = $ansList[$i]["osubTotal"] + $ansList[$i]["oTax"] - $ansList[$i]["oRet4"] - $ansList[$i]["oRet25"];
					}
					$ansTotaled["rete25"] = 0;
			}
			
			$ansTotaled["fullTotal"] = $ansTotaled["actis"] + $ansTotaled["repu"] + $ansTotaled["othe"] + $ansTotaled["iva"] - $ansTotaled["rete4"] - $ansTotaled["rete25"];
			
			$ansTotals = array();
			$ansTotals["detailed"] = $ansList;
			$ansTotals["totaled"] = $ansTotaled;

			$resp["message"] = $ansTotals;
			$resp["status"] = true;
			return $resp;
			
	}
	function generateRecepit($info, $nullnum = null, $nullres = null)
	{
			$picks = $info["picks"];
			$date = explode(" ", $info["date"])[0];
			$diedate = explode(" ", $info["diedate"])[0];
			$retCheck = $info["retCheck"];
			
			$dpkc = array();
			$dpkc["picks"] = $picks;
			$dpkc["retCheck"] = $info["retCheck"];
			$recTotals = $this-> getOtotals($dpkc)["message"];

			$fullist = array();
			
			$str = "SELECT * FROM resolution WHERE ACTIVE = '1'";
			$query = $this->db->query($str);
			
			$resdata = $query[0];
			
			if($nullnum != null)
			{
					$fNum = $nullnum;
					$nuller = "nuller";
			}
			else
			{
					$fNum = $resdata["ACTUAL"];
					$nuller = null;
					
					if($fNum > $resdata["END"])
					{
							$resp["message"] =  "fullres";
							$resp["status"] = true;
							return $resp;
					}
			}

			if(strlen($fNum) == 1){$fNum = "000".$fNum;}
			else if(strlen($fNum) == 2){$fNum = "00".$fNum;}
			else if(strlen($fNum) == 3){$fNum = "0".$fNum;}
			else{$fNum = $fNum;}
			
			$pathNum = $fNum;
			
			$orders = "";
			

			// GET ORDERS DATA
			for($i = 0; $i<count($picks); $i++)
			{
				$ocode = $picks[$i];

				$str = "SELECT CCODE, PARENTCODE, SUCUCODE, ICODE FROM orders WHERE CODE = '".$ocode."'";
				$query = $this->db->query($str);

				$number = $query[0]["CCODE"];
				$parentCode = $query[0]["PARENTCODE"];
				$sucuCode = $query[0]["SUCUCODE"];
				$icode = $query[0]["ICODE"];
				
				
				$number = $query[0]["CCODE"];
				if(strlen($number) == 1){$number = "000".$number;}
				else if(strlen($number) == 2){$number = "00".$number;}
				else if(strlen($number) == 3){$number = "0".$number;}
				else{$number = $number;}
				
				if($icode != null and $icode != "")
				{
						$number = $number."-".$icode;
				}
				
				$str = "SELECT ADESC, ACOST, UNIPRICE, UNIVALUE FROM oactis WHERE OCODE = '".$ocode."'";
				$query = $this->db->query($str);
				
				$actList = $query;
				
				for($x=0; $x<count($actList);$x++)
				{
						$line = array();
						
						$order = $number;
						$desc = $actList[$x]["ADESC"]." - ".$sucuCode;
						$amount = $actList[$x]["UNIVALUE"];
						$cost = $actList[$x]["UNIPRICE"];
						$subtotal = $amount * $cost;
						
						$line["ORDER"] = $order;
						$line["DESC"] = $desc;
						$line["AMOUNT"] = $amount;
						$line["COST"] = $cost;
						$line["SUBTOTAL"] = $subtotal;
						
						$fullist[] = $line;
				}


				 // -----NEW PART ADDER----
				$str = "SELECT PDESC, PCOST, PAMOUNT FROM oparts WHERE OCODE = '".$ocode."'";
				$query = $this->db->query($str);
				
				$partList = $query;
				
				$pCostResume = 0;
				
				for($x=0; $x<count($partList);$x++)
				{
						$line = array();
						
						$order = $number;
						$amount = $partList[$x]["PAMOUNT"];
						$cost = $partList[$x]["PCOST"];
						$subtotal = $amount * $cost;

						$pCostResume = $pCostResume+$subtotal;
						
						
				}
				
				$line = array();
				
				$line["ORDER"] = $order;
				$line["DESC"] = "Resumen de repuestos";
				$line["AMOUNT"] = 1;
				$line["COST"] = $pCostResume;
				$line["SUBTOTAL"] = $pCostResume;
				
				$fullist[] = $line;

				
				// -----NEW OTHERS ADDER----
				
				
				$str = "SELECT ODESC, COST, AMOUNT FROM others WHERE OCODE = '".$ocode."'";
				$query = $this->db->query($str);
				
				$otherList = $query;
				$otherList = [];
				
				for($x=0; $x<count($otherList);$x++)
				{
						$line = array();
						
						$order = $number;
						$desc = $otherList[$x]["ODESC"]." - ".$sucuCode;
						$amount = $otherList[$x]["AMOUNT"];
						$cost = $otherList[$x]["COST"];
						$subtotal = $amount * $cost;
						
						$line["ORDER"] = $order;
						$line["DESC"] = $desc;
						$line["AMOUNT"] = $amount;
						$line["COST"] = $cost;
						$line["SUBTOTAL"] = $subtotal;
						
						$fullist[] = $line;
				}
				
				if($i == (count($picks)-1))
				{
					$orders .= $number;
				}
				else
				{
					$orders .= $number.", ";
				}
			}
			
			$str = "SELECT CODE, CNAME, ADDRESS, PHONE, NIT, LOCATION, MAIL FROM users WHERE CODE = '".$parentCode."'";
			$query = $this->db->query($str);
			
			$cData = $query[0];

			// FILE START
			$pdf = new PDF_MC_Table();
			// COLWIDTHS
			$w = array(25, 116, 15, 20, 20);
			$rowCount = count($fullist);
			$pages = intval($rowCount/30);
			$pages = $pages + 1;
			
			$headerData = array();
			$headerData["fNum"] = $fNum;
			$headerData["date"] = $date;
			$headerData["diedate"] = $diedate;
			$headerData["ccode"] = $cData["CODE"];
			$headerData["cname"] = substr(utf8_decode($cData["CNAME"]),0,30);
			$headerData["caddress"] = $cData["ADDRESS"];
			$headerData["caddress"] = substr(utf8_decode($cData["ADDRESS"]),0,30);
			
			$headerData["cphone"] = $cData["PHONE"];
			$headerData["cnit"] = $cData["NIT"];
			$headerData["location"] = $cData["LOCATION"];
			$headerData["mail"] = $cData["MAIL"];
			$headerData["resdata"] = $resdata;
			$headerData["rectotals"] = $recTotals["totaled"];
			$headerData["pagenum"] = 1;
			$headerData["w"] = $w;
			$headerData["pages"] = $pages;
			
			if($rowCount > 30 )
			{
					$this->addFormatedPage($pdf, $headerData, "0", $nuller);
			}
			else
			{
					$this->addFormatedPage($pdf, $headerData, "1", $nuller);
			}

			$fill = false;
			$fillCount = 0;
			$pageCount = 1;
			
			$pdf->SetWidths($w);
			// recData
			foreach($fullist as $row)
			{
					// $pdf->Cell($w[0],6,$row['ORDER'],'LR',0,'L',$fill);
					// $pdf->Cell($w[1],6,utf8_decode($row['DESC']),'LR',0,'L',$fill);
					// $pdf->Cell($w[2],6,$row['AMOUNT'],'LR',0,'C',$fill);
					// $pdf->Cell($w[3],6,('$'.number_format($row['COST'])),'LR',0,'R',$fill);
					// $pdf->Cell($w[4],6,('$'.number_format($row['SUBTOTAL'])),'LR',0,'R',$fill);

					$fillCount++;

					if($fillCount == 28 and $fillCount != $rowCount)
					{
							// $pdf->Ln(6);
							$headerData["pagenum"]++;
							$pdf->Cell(array_sum($w),0,'','T');
							
							$pageCount++;
							
							if($pageCount == $pages)
							{
								$this->addFormatedPage($pdf, $headerData, "1", $nuller);
							}
							else
							{
								$this->addFormatedPage($pdf, $headerData, "0", $nuller);
							}
							
							$fillCount = 0;
					}
					else
					{
							// $pdf->Ln(6);
					}
					
					$align = array("L", "L", "C", "R", "R");
			
					$order = utf8_decode($row['ORDER']);
					$detail = utf8_decode($row['DESC']);
					$qty = utf8_decode($row['AMOUNT']);
					$unicost = '$'.number_format($row['COST']);
					$subtotal = '$'.number_format($qty*$row['COST']);
					
					$pdf->Row(array($order, $detail, $qty, $unicost, $subtotal), 1, $align);

					$fill = !$fill;
			}
			
			// lineClose
			$pdf->Cell(array_sum($w),0,'','T');

			
			// $pdf->Cell($w[0],6, $pages ,'LR',0,'L',$fill);
			
			$dirname = $headerData["ccode"]; 
			$filename = "../../receipts/".$headerData["ccode"];  

			if (!file_exists($filename)){ mkdir("../../receipts/".$headerData["ccode"], 0777);} 
			
			
			// createFile
			$pdf->Output('../../receipts/'.$headerData["ccode"].'/'.$resdata['RESOLUTION'].'-'.$fNum.'.pdf','F');
			
			$path = 'receipts/'.$headerData["ccode"].'/'.$resdata['RESOLUTION'].'-'.$pathNum.'.pdf';
			
			if($nullnum != null)
			{
				// SET STATE 1 TO REDATE
				$str = "UPDATE receipts SET STATE = '0', DATE = '".$date ."', DIEDATE = '".$date."' WHERE NUM ='".$nullnum."' AND RESOLUTION = '".$nullres."'";
				$query = $this->db->query($str);
				
				
				for($i = 0; $i<count($picks); $i++)
				{
						// COMMENT TO REDATE
						$str = "UPDATE orders SET STATE = '2' WHERE CODE ='".$picks[$i]."'";
						$query = $this->db->query($str);
				}
			}
			else
			{
					
				$str = "INSERT INTO receipts (RESOLUTION, NUM, PARENTNAME, PARENTCODE, ORDERS, STATE, STATUS, DATE, DIEDATE, TOTAL, RETCHECK) VALUES ('".$resdata['RESOLUTION']."', '".$fNum."','".$headerData["cname"]."','".$headerData["ccode"]."','".$orders."','1', '1', '".$date."', '".$diedate."', '".$recTotals["totaled"]["fullTotal"]."', '".$retCheck."')";
				$query = $this->db->query($str);
				
				$fNum++;
				if(strlen($fNum) == 1){$fNum = "000".$fNum;}
				else if(strlen($fNum) == 2){$fNum = "00".$fNum;}
				else if(strlen($fNum) == 3){$fNum = "0".$fNum;}
				else{$fNum = $fNum;}
				
				$str = "UPDATE resolution SET ACTUAL = '".$fNum."' WHERE ACTIVE ='1'";
				$query = $this->db->query($str);
				
				for($i = 0; $i<count($picks); $i++)
				{
					$str = "UPDATE orders SET STATE = '5' WHERE CODE ='".$picks[$i]."'";
					$query = $this->db->query($str);
				}
					
			}
			
			$resp["message"] =  $path;
			$resp["status"] = true;
			return $resp;
	}
	function nullifyReceipt($info)
	{
			$nullnum = $info["nullnum"];
			$nullres = $info["nullres"];
			$parent = $info["parent"];
			$retCheck = $info["retCheck"];
			
			$picks = array();
			
			for($i = 0; $i<count($info["picks"]); $i++)
			{
				$str = "SELECT CODE FROM orders WHERE CCODE = '".intval($info["picks"][$i])."' AND PARENTCODE = '".$parent."'";
				$query = $this->db->query($str);
				
				$picks[] = $query[0]["CODE"];
			}
			

			$dpkc = array();
			$dpkc["picks"] = $picks;
			$dpkc["date"] = $info["date"];
			$dpkc["diedate"] = $info["diedate"];
			$dpkc["retCheck"] = $info["retCheck"];

			$this-> generateRecepit($dpkc, $nullnum, $nullres);
			
			$resp["message"] =  $info;
			$resp["status"] = true;
			
			return $resp;
	}
	function redateReceipt($info)
	{
			$nullnum = $info["nullnum"];
			$nullres = $info["nullres"];
			$parent = $info["parent"];
			$retCheck = $info["retCheck"];
			
			$picks = array();
			
			for($i = 0; $i<count($info["picks"]); $i++)
			{
					$str = "SELECT CODE FROM orders WHERE CCODE = '".intval($info["picks"][$i])."' AND PARENTCODE = '".$parent."'";
					$query = $this->db->query($str);
					
					$picks[] = $query[0]["CODE"];
			}
			

			$dpkc = array();
			$dpkc["picks"] = $picks;
			$dpkc["date"] = "2016-09-12";
			$dpkc["diedate"] = "2016-09-20";
			$dpkc["retCheck"] = $info["retCheck"];

			$this-> generateRecepit($dpkc, $nullnum, $nullres);
			
			$resp["message"] =  $info;
			$resp["status"] = true;
			
			return $resp;
	}
	function addFormatedPage($pdf, $headerData, $type, $nuller = null)
	{
			// SET BOTH TO "" TO REDATE
			if($nuller == null){$nuller = "";}else{$nuller = "null";}
			
			$pdf->AddPage('P', 'Letter');
			$w = $headerData["w"];
			if($type == "1")
			{
					$pdf->Image('../../irsc/freceipt'.$nuller.'.jpg',0,0,218,0,'','');
			}
			else
			{
					$pdf->Image('../../irsc/freceiptBlank'.$nuller.'.jpg',0,0,218,0,'','');
			}
			
			$pdf->SetFont('Arial','B', 14);
			$pdf->SetFillColor(102,102,102);
			$pdf->SetAutoPageBreak(false);
			$pdf->SetX(0);
			
			// H LINE 1
			$pdf->Cell(186,5,'',0,0,'C',false);
			$pdf->Cell(14,5,$headerData["fNum"],0,0,'R',false);
			$pdf->SetFont('Arial','B', 8);
		   
			$pdf->Ln(11);
			
			$pdf->Cell(144,5,'',0,0,'C',false);
			$pdf->Cell(16,5,$headerData["date"],0,0,'L',false);
			$pdf->Cell(19,5,'',0,0,'L',false);
			$pdf->Cell(16,5,$headerData["diedate"],0,0,'L',false);
			
			$pdf->Ln(6);

			$pdf->Cell(10,5,'',0,0,'C',false);
			$pdf->Cell(53,5,utf8_decode($headerData["cname"]),0,0,'L',false);
			$pdf->Cell(16,5,'',0,0,'C',false);
			$pdf->Cell(55,5,utf8_decode($headerData["caddress"]),0,0,'L',false);
			$pdf->Cell(16,5,'',0,0,'C',false);
			$pdf->Cell(45,5,$headerData["cphone"],0,0,'L',false);
			
			$pdf->Ln(7);
			
			$pdf->Cell(10,5,'',0,0,'C',false);
			$pdf->Cell(53,5,$headerData["cnit"],0,0,'L',false);
			$pdf->Cell(16,5,'',0,0,'C',false);
			$pdf->Cell(55,5,utf8_decode($headerData["location"]),0,0,'L',false);
			$pdf->Cell(16,5,'',0,0,'C',false);
			$pdf->Cell(45,5,$headerData["mail"],0,0,'L',false);
			
			$pdf->SetFillColor(102,102,102);
			$pdf->SetTextColor(255);
			$pdf->SetFont('Arial','B', 8);
			$header = array('Orden', 'Detalle', 'Cantidad', 'Valor', 'Subtotal');
			$pdf->Ln(2);
			$pdf->SetY(43);
			// Header
			for($i=0;$i<count($header);$i++)
			{
					$pdf->Cell($w[$i],5,utf8_decode($header[$i]),1,0,'L',true);
			}
			$pdf->SetFont('Arial','', 8);
			$pdf->Ln(5);
			$pdf->SetTextColor(0);
			if($type == "1")
			{
					
					$rectotals = $headerData["rectotals"];
					
					$pdf->SetY(-49);
					$pdf->Cell(171,5,"",0,0,'L',false);
					$pdf->Cell(25,5,'$'.number_format($rectotals["actis"]),0,0,'R',false);
					$pdf->Ln();
					$pdf->Cell(171,6,"",0,0,'L',false);
					$pdf->Cell(25,6,'$'.number_format($rectotals["repu"]),0,0,'R',false);
					$pdf->Ln();
					$pdf->Cell(171,5.5,"",0,0,'L',false);
					$pdf->Cell(25,5.5,'$'.number_format($rectotals["othe"]),0,0,'R',false);
					$pdf->Cell(25,5.5,'$'.number_format($rectotals["othe"]),0,0,'R',false);
					$pdf->Ln();
					$pdf->Cell(171,6,"",0,0,'L',false);
					$pdf->Cell(25,6,'$'.number_format($rectotals["iva"]),0,0,'R',false);
					$pdf->Ln();
					$pdf->Cell(171,6,"",0,0,'L',false);
					$pdf->Cell(25,6,'$'.number_format($rectotals["rete4"]),0,0,'R',false);
					$pdf->Ln();
					$pdf->Cell(171,5.5,"",0,0,'L',false);
					$pdf->Cell(25,5.5,'$'.number_format($rectotals["rete25"]),0,0,'R',false);
					$pdf->Ln();
					$pdf->Cell(171,6,"",0,0,'L',false);
					$pdf->Cell(25,6,'$'.number_format($rectotals["fullTotal"]),0,0,'R',false);
			}
			
			$pdf->SetY(-9);
			
			$pdf->SetFont('Arial','B', 6);
			
			$pdf->Cell(57,5,"",0,0,'L',false);
			$pdf->Cell(17,5,$headerData["resdata"]["RESOLUTION"],0,0,'C',false);
			$pdf->Cell(5,5,"",0,0,'L',false);
			$pdf->Cell(14,5,$headerData["resdata"]["DATE"],0,0,'C',false);
			$pdf->Cell(20,5,"",0,0,'L',false);
			$pdf->Cell(10,5,$headerData["resdata"]["START"],0,0,'C',false);
			$pdf->Cell(10,5,"",0,0,'L',false);
			$pdf->Cell(10,5,$headerData["resdata"]["END"],0,0,'C',false);
			$pdf->Cell(37,5,"",0,0,'L',false);
			$pdf->SetFont('Arial','', 8);
			$pdf->Cell(12,5,utf8_decode("Página ".$headerData["pagenum"]." de ".$headerData["pages"]),0,0,'C',false);

			$pdf->SetFont('Arial','', 8);
			$pdf->SetY(43);

			$pdf->Ln();
			$pdf->SetFillColor(230,230,230);
			
			
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
			$email_from = 'admin@servintegral.com';
			$email_message = 
			"<div style='text-align: center; margin: auto; width: 800px !important; background: #F0EDE8; border-radius: 15px;'>".
			"<img src='http://incocrea.com/servintegral/irsc/pasRecHeader-".$language.".png' style='width=100% !important;'/>".
			"<br><br>".
			"<span style='font-size:14px; '>".$message."</span>".
			"<br>".
			"<span style='font-size:14px; font-weight: bold;'>"."<a href='http://incocrea.com/servintegral/?me=".$userEmail."&tmpkey=".$tmpkey."&lang=".$language."&type=".$userType." '>".htmlentities($recLink)."</a>"."</span>".
			"<br><br>".
			"<img src='http://incocrea.com/servintegral/irsc/footer-".$language.".png' style='width=100% !important;'/>".
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
	function setRecoPass($info)
	{
                $str = "UPDATE users SET PASSWD = '".md5($info["newPass"])."' WHERE CODE = '".$info["code"]."'";
                $query = $this->db->query($str);
                
                $resp["message"] =  "done";
                $resp["status"] = true;
                return $resp;
        }
	function tagContact($info)
	{

		$sucode = $info["email"];
		$spcname = htmlentities($info["name"]);
		$content = $info["message"];
		$header = "Mensaje desde WorlTek";
		
		$email_subject = $header;
		$email_from = $sucode;
		$email_message = "Mensaje WorlTek de: ".$spcname."<br><br><span style='font-size:14px; '>".$content."</span>";
		
		$headers = "From: " . $email_from . "\r\n";
		$headers .= "Reply-To: ". $email_from . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail ("info@servintegral.com", $email_subject, $email_message, $headers);

		$resp["message"] = "done";
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
	function setResolution($info)
	{
                $resolution = $info["a-resoNumber"];
                $date = $info["a-resoDate"];
                $start = $info["a-resoIninum"];
                $end = $info["a-resoEndnum"];
                $actual = $info["a-resoActualnum"];
                
                $str = "SELECT RESOLUTION FROM resolution WHERE RESOLUTION = '".$resolution."'";
		$query = $this->db->query($str);
                
                if(count($query) > 0 )
                {
                        $resp["message"] = "exist";
                        $resp["status"] = false;
                }
                else
                {
                        $str = "UPDATE resolution SET ACTIVE = '0'";
                        $query = $this->db->query($str);

                        $str = "INSERT INTO resolution (RESOLUTION, DATE, START, END, ACTIVE, ACTUAL) VALUES ('".$resolution."','".$date."','".$start."','".$end."', '1', '".$actual."')";
                        $query = $this->db->query($str);
                        
                        $resp["message"] = "done";
                        $resp["status"] = false;
                        
                        
                }
                
                return $resp;
                
        }
	function getResoList($info)
	{
                $str = "SELECT * FROM resolution ORDER BY ACTIVE DESC";
		$query = $this->db->query($str);

		if(count($query) > 0)
		{
                        $resp["message"] = $query;
			$resp["status"] = false;
                }
                else
		{
			$resp["message"] = array();
			$resp["status"] = false;
		}
		return $resp;
        }
	function changeClientState($info)
	{
		$code = $info["code"];
		$actual = $info["actual"];
		
		if($actual == "1")
		{
				$state = "0";
		}
		else
		{
				$state = "1";
		}
		
		$str = "UPDATE users SET STATUS = '".$state."' WHERE CODE ='".$code."'";
		$query = $this->db->query($str);
		
		$str = "UPDATE sucus SET STATUS = '".$state."' WHERE PARENTCODE ='".$code."'";
		$query = $this->db->query($str);
		
		$str = "UPDATE maquis SET STATUS = '".$state."' WHERE PARENTCODE ='".$code."'";
		$query = $this->db->query($str);
		
		$str = "UPDATE orders SET STATUS = '".$state."' WHERE PARENTCODE ='".$code."'";
		$query = $this->db->query($str);
		
		$str = "UPDATE oreports SET STATUS = '".$state."' WHERE PARENTCODE ='".$code."'";
		$query = $this->db->query($str);
		
		$str = "UPDATE orders SET STATUS = '".$state."' WHERE PARENTCODE ='".$code."'";
		$query = $this->db->query($str);
		
		$resp["message"] = "changed";
		$resp["status"] = false;
		
		return $resp;
                
        }
	function discountInv($info)
	{
                $items = $info["items"];
                
                for($i=0; $i<count($items); $i++)
                {
                        $code = $items[$i]["PCODE"];
                        $amount = $items[$i]["PAMOUNT"];
                        
                        $str = "UPDATE inve SET AMOUNT = AMOUNT - '".intval($amount)."' WHERE CODE ='".$code."'";
                        $query = $this->db->query($str);
                        
                }
                
        }
	// REPORTERY BLOCK START -------------------------
        
	function getReport($info)
	{
                
                $repoType = $info["repoType"];
                $repoParent = $info["repoParent"];
                $repoSucu = $info["repoSucu"];
                $repoMaqui = $info["repoMaqui"];
                $repoIniDate = $info["repoIniDate"];
                $repoEndDate= $info["repoEndDate"];
                $repoParentName= $info["repoParentName"];
                $repoSucuName = $info["repoSucuName"];
                $repoOrderNum = $info["repoOrderNum"];
                $repoRepu = $info["repoRepu"];
                $repoOtype = $info["repoOtype"];
                $repoTech = $info["repoTech"];
                $repoActi = $info["repoActi"];
                $repoState = $info["repoState"];
                
                if($repoType == "maquiStoryR")
                {
                        $where = "WHERE  OCODE != 'null' ";

                        if($repoMaqui != ""){$where .= "AND MAQUICODE =  '$repoMaqui' ";} 
                        if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
                        if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 
                        
                        $str = "SELECT * FROM oactis $where ORDER BY DATE DESC";
                        $query = $this->db->query($str);
                        
                        $result = $query;
                }
                if($repoType == "ordersR")
                {
                        $where = "WHERE  STATUS = '1' ";
                        
                        if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
                        if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
                        if($repoOrderNum != ""){$where .= "AND CCODE LIKE  '%$repoOrderNum%' ";} 
                        if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
                        if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 

                        $str = "SELECT * FROM orders $where ORDER BY DATE DESC";
                        $query = $this->db->query($str);
                        
                        $result = $query;
                }
                if($repoType == "ordersRIM")
                {
                        $where = "WHERE  STATUS = '1' ";
                        
                        if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
                        if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
                        if($repoOrderNum != ""){$where .= "AND CCODE LIKE  '%$repoOrderNum%' ";} 
                        if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
                        if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 

                        $str = "SELECT * FROM orders $where ORDER BY DATE DESC";
                        $query = $this->db->query($str);
                        
                        for($i=0; $i<count($query); $i++)
                        {
                                $dpkc = array();
                                $dpkc["ocode"] = $query[$i]["CODE"];
                                $oPics = $this-> getOpics($dpkc)["message"];
                                
                                $query[$i]["PICS"] = $oPics;
                                
                        }
                        
                        $result = $query;
                }
                if($repoType == "actisPclient")
                {
                        $where = "WHERE  STATUS = '1' ";
                        
                        if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
                        if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
                        if($repoOrderNum != ""){$where .= "AND CCODE LIKE  '%$repoOrderNum%' ";} 
                        if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
                        if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 

                        $str = "SELECT CODE, CCODE, PARENTNAME, SUCUNAME, ICODE FROM orders $where ORDER BY DATE DESC";
                        $query = $this->db->query($str);
                        
                        $oList = $query;
                        $mainList = array();
                        
                        for($i=0; $i<count($oList); $i++)
                        {
                                $str = "SELECT * FROM oactis WHERE OCODE = '".$oList[$i]["CODE"]."' ORDER BY DATE DESC";
                                $query = $this->db->query($str);
                                
                                $aList = $query;
                                
                                for($j=0; $j<count($aList); $j++)
                                {
                                        $aList[$j]["PARENTNAME"] = $oList[$i]["PARENTNAME"];
                                        $aList[$j]["SUCUNAME"] = $oList[$i]["SUCUNAME"];
                                        $aList[$j]["ICODE"] = $oList[$i]["ICODE"];
                                        $mainList[] = $aList[$j];
                                }
                        }
                        
                        $result = $mainList;
                }
                if($repoType == "actisPacti")
                {
                        $where = "WHERE  STATUS = '1' ";
                        
                        if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
                        if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
                        if($repoOrderNum != ""){$where .= "AND CCODE LIKE  '%$repoOrderNum%' ";} 
                        if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
                        if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 

                        $str = "SELECT CODE, CCODE, PARENTNAME, SUCUNAME, ICODE FROM orders $where ORDER BY DATE DESC";
                        $query = $this->db->query($str);
                        
                        $oList = $query;
                        $mainList = array();
                        
                        for($i=0; $i<count($oList); $i++)
                        {
                                $where = "WHERE  OCODE = '".$oList[$i]["CODE"]."' ";
                                
                                if($repoActi != ""){$where .= "AND ACODE =  '$repoActi'";} 

                                $str = "SELECT * FROM oactis $where ORDER BY DATE DESC";
                                $query = $this->db->query($str);
                                
                                $aList = $query;
                                
                                for($j=0; $j<count($aList); $j++)
                                {
                                        $aList[$j]["PARENTNAME"] = $oList[$i]["PARENTNAME"];
                                        $aList[$j]["SUCUNAME"] = $oList[$i]["SUCUNAME"];
                                        $aList[$j]["ICODE"] = $oList[$i]["ICODE"];
                                        $mainList[] = $aList[$j];
                                }
                        }
                        
                        $result = $mainList;
                }
                if($repoType == "repusPclient")
                {
                        $where = "WHERE  STATUS = '1' ";
                        
                        if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
                        if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
                        if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
                        if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 

                        $str = "SELECT CODE, CCODE, PARENTNAME, SUCUNAME, TECHNAME,  ICODE FROM orders $where ORDER BY DATE DESC";
                        $query = $this->db->query($str);
                        
                        $oList = $query;
                        $mainList = array();
                        
                        for($i=0; $i<count($oList); $i++)
                        {
                                
                                $where = "WHERE OCODE = '".$oList[$i]["CODE"]."' ";

                                if($repoRepu != ""){$where .= "AND PCODE =  '$repoRepu'";} 

                                $str = "SELECT * FROM oparts $where ";
                                $query = $this->db->query($str);
                                
                                $pList = $query;
                                
                                for($j=0; $j<count($pList); $j++)
                                {
                                        $pList[$j]["PARENTNAME"] = $oList[$i]["PARENTNAME"];
                                        $pList[$j]["SUCUNAME"] = $oList[$i]["SUCUNAME"];
                                        $pList[$j]["ICODE"] = $oList[$i]["ICODE"];
                                        $pList[$j]["OCCODE"] = $oList[$i]["CCODE"];
                                        $pList[$j]["TECHNAME"] = $oList[$i]["TECHNAME"];
                                        $mainList[] = $pList[$j];
                                }
                        }
                        
                        $result = $mainList;
                }
                if($repoType == "othersPclient")
                {
                        $where = "WHERE  STATUS = '1' ";
                        
                        if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
                        if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
                        if($repoOrderNum != ""){$where .= "AND CCODE LIKE  '%$repoOrderNum%' ";} 
                        if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
                        if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 

                        $str = "SELECT CODE, CCODE, PARENTNAME, SUCUNAME, TECHNAME,  ICODE FROM orders $where ORDER BY DATE DESC";
                        $query = $this->db->query($str);
                        
                        $oList = $query;
                        $mainList = array();
                        
                        for($i=0; $i<count($oList); $i++)
                        {
                                $str = "SELECT * FROM others WHERE OCODE = '".$oList[$i]["CODE"]."'";
                                $query = $this->db->query($str);
                                
                                $pList = $query;
                                
                                for($j=0; $j<count($pList); $j++)
                                {
                                        $pList[$j]["PARENTNAME"] = $oList[$i]["PARENTNAME"];
                                        $pList[$j]["SUCUNAME"] = $oList[$i]["SUCUNAME"];
                                        $pList[$j]["ICODE"] = $oList[$i]["ICODE"];
                                        $pList[$j]["OCCODE"] = $oList[$i]["CCODE"];
                                        $pList[$j]["TECHNAME"] = $oList[$i]["TECHNAME"];
                                        $mainList[] = $pList[$j];
                                }
                        }
                        
                        $result = $mainList;
                }
                if($repoType == "othersPtype")
                {
                        $where = "WHERE  STATUS = '1' ";
                        
                        if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
                        if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
                        if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
                        if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 

                        $str = "SELECT CODE, CCODE, PARENTNAME, SUCUNAME, TECHNAME,  ICODE FROM orders $where ORDER BY DATE DESC";
                        $query = $this->db->query($str);
                        
                        $oList = $query;
                        $mainList = array();
                        
                        for($i=0; $i<count($oList); $i++)
                        {
                                $where = "WHERE  OCODE = '".$oList[$i]["CODE"]."' ";
                                
                                if($repoOtype != ""){$where .= "AND OTYPE = '$repoOtype' ";} 
                                
                                $str = "SELECT * FROM others $where";
                                $query = $this->db->query($str);
                                
                                $pList = $query;
                                
                                for($j=0; $j<count($pList); $j++)
                                {
                                        $pList[$j]["PARENTNAME"] = $oList[$i]["PARENTNAME"];
                                        $pList[$j]["SUCUNAME"] = $oList[$i]["SUCUNAME"];
                                        $pList[$j]["ICODE"] = $oList[$i]["ICODE"];
                                        $pList[$j]["OCCODE"] = $oList[$i]["CCODE"];
                                        $pList[$j]["TECHNAME"] = $oList[$i]["TECHNAME"];
                                        $mainList[] = $pList[$j];
                                }
                        }
                        
                        $result = $mainList;
                }
                if($repoType == "pendAndrec")
                {
                        $where = "WHERE  STATUS = '1' ";
                        
                        if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
                        if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
                        if($repoOrderNum != ""){$where .= "AND CCODE LIKE  '%$repoOrderNum%' ";} 
                        if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
                        if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 

                        $str = "SELECT * FROM orders $where ORDER BY DATE DESC";
                        $query = $this->db->query($str);
                        
                        $result = $query;
                }
                if($repoType == "repusCosts")
                {
                        $where = "WHERE  STATUS = '1' AND STATE = '5' ";
                        
                        if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
                        if($repoState != ""){$where .= "AND STATE =  '$repoState' ";} 
                        if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
                        if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 

                        $str = "SELECT CODE, CCODE, PARENTNAME, SUCUNAME, TECHNAME,  ICODE FROM orders $where ORDER BY DATE DESC";
                        $query = $this->db->query($str);
                        
                        $oList = $query;
                        $mainList = array();
                        
                        for($i=0; $i<count($oList); $i++)
                        {
                                
                                $where = "WHERE OCODE = '".$oList[$i]["CODE"]."' ";

                                if($repoRepu != ""){$where .= "AND PCODE =  '$repoRepu'";} 

                                $str = "SELECT * FROM oparts $where ";
                                $query = $this->db->query($str);
                                
                                $pList = $query;
                                
                                for($j=0; $j<count($pList); $j++)
                                {
                                        
                                        $realCost = "";
                                        
                                        if($pList[$j]["PCODE"] != "NI")
                                        {
                                                $str = "SELECT COST FROM inve WHERE CODE = '".$pList[$j]["PCODE"]."'";
                                                $query = $this->db->query($str);
                                                $realCost = $query[0]["COST"];
                                        }
                                        else
                                        {
                                                continue;
                                        }
                                        
                                        $pList[$j]["PARENTNAME"] = $oList[$i]["PARENTNAME"];
                                        $pList[$j]["SUCUNAME"] = $oList[$i]["SUCUNAME"];
                                        $pList[$j]["ICODE"] = $oList[$i]["ICODE"];
                                        $pList[$j]["OCCODE"] = $oList[$i]["CCODE"];
                                        $pList[$j]["TECHNAME"] = $oList[$i]["TECHNAME"];
                                        $pList[$j]["REALCOST"] = $realCost;
                                        $mainList[] = $pList[$j];
                                }
                        }
                        
                        $result = $mainList;
                }
                 if($repoType == "orderTimesByTech")
                {
                        $where = "WHERE  STATUS = '1' ";
                        
                        if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
                        if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
                        if($repoTech != ""){$where .= "AND TECHCODE = '$repoTech' ";} 
                        if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
                        if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 

                        $str = "SELECT * FROM orders $where ORDER BY DATE DESC";
                        $query = $this->db->query($str);
                        
                        $result = $query;
                }
                if($repoType == "orderTimesByActi")
                {
                        $where = "WHERE  STATUS = '1' ";
                        
                        if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
                        if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
                        if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
                        if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 

                        $str = "SELECT CODE, CCODE, PARENTNAME, SUCUNAME, ICODE FROM orders $where ORDER BY DATE DESC";
                        $query = $this->db->query($str);
                        
                        $oList = $query;
                        $mainList = array();
                        
                        for($i=0; $i<count($oList); $i++)
                        {
                                
                                $where = "WHERE  OCODE = '".$oList[$i]["CODE"]."' ";
                                
                                if($repoActi != ""){$where .= "AND ACODE =  '$repoActi'";} 
                                
                                
                                $str = "SELECT * FROM oactis $where ORDER BY DATE DESC";
                                $query = $this->db->query($str);
                                
                                
                                
                                $aList = $query;
                                
                                for($j=0; $j<count($aList); $j++)
                                {
                                        $aList[$j]["PARENTNAME"] = $oList[$i]["PARENTNAME"];
                                        $aList[$j]["SUCUNAME"] = $oList[$i]["SUCUNAME"];
                                        $aList[$j]["ICODE"] = $oList[$i]["ICODE"];
                                        $mainList[] = $aList[$j];
                                }
                        }
                        
                        $result = $mainList;
                }

                $resp["message"] = $result ;
                $resp["status"] = true;
                return $resp;
        }
	function getRePath($info)
	{
                $ocode = $info["ocode"];
                $str = "SELECT TYPE FROM oreports WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
                
                if(count($query) > 0){$type = $query[0]["TYPE"];}else{$type = "none";}
                
                $resp["message"] = $type;
                $resp["status"] = true;
                return $resp;
        }
	function getMaquiListReport($info)
	{
               $str = "SELECT CODE, DESCRIPTION FROM inve ORDER BY CODE ASC";
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

		return $resp; 
        }

	// REPORTERY BLOCK START -------------------------

	function exportCVS($info)
	{
		$type = $info["rtype"];
		$lang = $info["lang"];
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		$lang = $langFile[$lang];
		
		if($type == "rt")
		{
			
			$code = $info["code"];
			
			$str = "SELECT * FROM orders WHERE CODE = '".$code."'";
			$query = $this->db->query($str);	
			// CHAR REPLACES
			$cname = str_replace("'","\\'", $query[0]["PARENTNAME"]);
			$cname = str_replace("ñ","n", $cname);
			$cname = str_replace("á","a", $cname);
			$cname = str_replace("é","e", $cname);
			$cname = str_replace("í","i", $cname);
			$cname = str_replace("ó","o", $cname);
			$cname = str_replace("ú","u", $cname);
			$cname = str_replace("Ñ","N", $cname);
			$cname = str_replace("Á","A", $cname);
			$cname = str_replace("É","E", $cname);
			$cname = str_replace("Í","I", $cname);
			$cname = str_replace("Ó","O", $cname);
			$cname = str_replace("Ú","U", $cname);
			// CHAR REPLACES
			
			$onumber = $query[0]["CCODE"];
			
			// ACTIVITIES SECTION
			
			$str = "SELECT * FROM oactis WHERE OCODE = '".$code."'";
			$actisList = $this->db->query($str);	

			$interline = "\n";
			
			$header1 = utf8_decode("Cliente: ").$cname;
			
			$header2 = utf8_decode("Detalle de Orden: ").$onumber;
			
			
			
			$csvString = $header1.";".$header2;
			
			$csvString .= $interline;
			$csvString .= $interline;
			
			$section1 = "Actividades";
			$csvString .= $section1.";".$interline;
			$csvString .= $interline;
			
			$acti = utf8_decode("Item");
			$actiDesc = utf8_decode("Detalle");
			$actiAct = utf8_decode("Actividad");
			$actiUnival= utf8_decode("Valor Unidad");
			$actiQty = utf8_decode("Cantidad");
			$actiSubtotal= utf8_decode("Subtotal");
			
			$csvString .= $acti.";".$actiDesc.";".$actiAct.";".$actiUnival.";".$actiQty.";".$actiSubtotal;
			
			$csvString .= $interline;
			
			for($i = 0; $i<count($actisList);$i++)
			{
				$item = $actisList[$i];
				
				$a = utf8_decode($item["MAQUI"]);
				$b = utf8_decode($item["MAQUINAME"]);
				$c = utf8_decode($item["ADESC"]);
				$d = utf8_decode($item["UNIPRICE"]);
				$e = utf8_decode($item["UNIVALUE"]);
				$f = utf8_decode($item["UNIVALUE"]*$item["UNIPRICE"]);

				$csvString .= "\"$a\";\"$b\";\"$c\";\"$d\";\"$e\";\"$f\"\n";
			}

			// PARTS SECTION
			
			$str = "SELECT * FROM oparts WHERE OCODE = '".$code."'";
			$partsList = $this->db->query($str);	
			
			$csvString .= $interline;
			$section2 = "Repuestos";
			$csvString .= $section2.";".$interline;
			$csvString .= $interline;
			
			$part = utf8_decode("Item");
			$partDesc = utf8_decode("Detalle");
			$partSpace = utf8_decode("");
			$partUnival= utf8_decode("Valor Unidad");
			$partQty = utf8_decode("Cantidad");
			$partSubtotal= utf8_decode("Subtotal");
			
			$csvString .= $part.";".$partDesc.";".$partSpace.";".$partUnival.";".$partQty.";".$partSubtotal;
			
			$csvString .= $interline;
			
	
			for($i = 0; $i<count($partsList);$i++)
			{
				$item = $partsList[$i];
				
				$a = utf8_decode($item["PCODE"]);
				$b = utf8_decode($item["PDESC"]);
				$z = utf8_decode("");
				$c = utf8_decode($item["PCOST"]);
				$d = utf8_decode($item["PAMOUNT"]);
				$e = utf8_decode($item["PAMOUNT"]*$item["PCOST"]);

				$csvString .= "\"$a\";\"$b\";\"$z\";\"$c\";\"$d\";\"$e\"\n";
			}
			
			// OTHERS SECTION
			
			$str = "SELECT * FROM others WHERE OCODE = '".$code."'";
			$otherList = $this->db->query($str);	
			
			$csvString .= $interline;
			$section3 = "Otros Costos";
			$csvString .= $section3.";".$interline;
			$csvString .= $interline;
			
			$other = utf8_decode("Tipo de costo");
			$otherDesc = utf8_decode("Detalle");
			$otherDoc = utf8_decode("Documento/Factura");
			$otherUnival= utf8_decode("Valor Unidad");
			$otherQty = utf8_decode("Cantidad");
			$otherSubtotal= utf8_decode("Subtotal");
			
			$csvString .= $other.";".$otherDesc.";".$otherDoc.";".$otherUnival.";".$otherQty.";".$otherSubtotal;
			
			$csvString .= $interline;
			
	
			for($i = 0; $i<count($otherList);$i++)
			{
				$item = $otherList[$i];
				
				$a = utf8_decode($item["OTYPE"]);
				$b = utf8_decode($item["ODESC"]);
				$c = utf8_decode($item["COST"]);
				$d = utf8_decode($item["DOC"]);
				$e = utf8_decode($item["AMOUNT"]);
				$f = utf8_decode($item["AMOUNT"]*$item["COST"]);

				$csvString .= "\"$a\";\"$b\";\"$c\";\"$d\";\"$e\";\"$f\"\n";
			}

			$fname  = $cname."-".$onumber;
			$fname = htmlEntities(utf8_decode($fname));
			$path = "../../reports/".$fname.".csv";
			
			$hasFile = file_exists($path);
			if($hasFile == true){unlink($path);}
			file_put_contents($path, $csvString);
		}
		if($type == "leg")
		{

			$code = $info["legCode"];
			$ucode = $info["ucode"];
			$uname = $info["uname"];
			$uid = $info["uid"];
			$closeVal = $info["closeVal"];
			
			$str = "SELECT * FROM others WHERE LEGCODE = '".$code."' AND LEGAUTOR = '".$ucode."'";
			$legList = $this->db->query($str);	
			
			// SHEET CONFIG

			$myExcel = new PHPexcel();
			$myExcel->getProperties()->setCreator("Incocrea")
							 ->setLastModifiedBy("Incocrea")
							 ->setTitle("PHPExcel Document")
							 ->setSubject("PHPExcel Document")
							 ->setDescription("Document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");
			
			$allborders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
			$borderR = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
			
			$borderT = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
			
			$grayBg = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '#FFFFFF')));
			
			 $alignCenter = array('alignment' => array('horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
			 
			 $alignRight = array('alignment' => array('horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
			
			$sheet = $myExcel->getActiveSheet();
			$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
			
			$sheet->getPageMargins()->setTop(0.1);
			$sheet->getPageMargins()->setRight(0.3);
			$sheet->getPageMargins()->setLeft(0.3);
			$sheet->getPageMargins()->setBottom(0.3);
			
			// HEADER START
			
			$sheet->setCellValue('A3', 'FORMATO PARA LEGALIZACION DE ANTICIPOS WORLDTEK');
			$sheet->getStyle("A3")->getFont()->setBold(true);
			$sheet->mergeCells('A3:M3');
			
			$uname = $uname;
			$legDate = $info["legMainDate"]; 
			$concept = $info["legMainConcept"];
			$uid = $uid;
			$legValue = floatval($info["legValue"]);
			$costCenter = $info["legCenter"];
			
			$f = 5;
			$t = 7;
			
			$sheet->getStyle("A$f:A$t")->getFont()->setBold(true);
			$sheet->setCellValue('A5', 'Beneficiario');
			$sheet->setCellValue('A6', 'Fecha');
			$sheet->setCellValue('A7', 'Concepto');
			
			$sheet->getStyle("A$f:A$t")->getFont()->setBold(true);
			$sheet->setCellValue('B5', $uname);
			$sheet->setCellValue('B6', $legDate);
			$sheet->setCellValue('B7', $concept );
			
			$sheet->mergeCells('B5:D5');
			$sheet->mergeCells('B6:D6');
			$sheet->mergeCells('B7:D7');
			
			$sheet->getStyle("A$f:A$t")->applyFromArray($borderR);
			$sheet->getStyle("A$f:A$t")->getFont()->setSize(10);
			$sheet->getStyle("B$f:B$t")->getFont()->setSize(10);
			
			$sheet->getStyle("B$f:B$t")->applyFromArray($alignRight);
			
			$sheet->getStyle("F$f:F$t")->getFont()->setBold(true);
			$sheet->setCellValue('F5', 'Identificación');
			$sheet->setCellValue('F6', 'Valor Anticipo');
			$sheet->setCellValue('F7', 'Centro de Costo');
			
			$sheet->getStyle("F$f:F$t")->getFont()->setBold(true);
			$sheet->setCellValue('G5', $uid);
			$sheet->setCellValue('G6', $legValue);
			$sheet->getStyle("G6")->getNumberFormat()->setFormatCode('#,##0');
			
			$sheet->setCellValue("K5", "Legalización: ".$code);
				$sheet->getStyle("K5")->getFont()->setSize(10);
			
			$sheet->setCellValue('G7', $costCenter);
			
			$sheet->getStyle("G$f:G$t")->applyFromArray($alignRight);
			
			$sheet->mergeCells('G5:I5');
			$sheet->mergeCells('G6:I6');
			$sheet->mergeCells('G7:I7');
			
			$sheet->getStyle("G$f:G$t")->applyFromArray($borderR);
			$sheet->getStyle("F$f:F$t")->getFont()->setSize(10);
			$sheet->getStyle("G$f:G$t")->getFont()->setSize(10);
			
			// TITLES
			
			$c = 9;
			$sheet->getStyle("A$c:M$c")->getFont()->setBold(true);
			
			$legClient = "Cliente";
			$legOrder = "Orden";
			$legDate = "Fecha";
			$legId = "Identificación";
			$legCname = "Razón social";
			$legNum = "Número";
			$legConcept = "Concepto";
			$legBase = "Base";
			$legIVA = "IVA";
			$legTotal = "Total";
			$legRtefte = "Retefuente";
			$legRteICA = "ReteICA";
			$legTotalPay = "Total Pagado";
			
			$sheet->setCellValue("A$c", $legClient);
			$sheet->setCellValue("B$c", $legOrder);
			$sheet->setCellValue("C$c", $legDate );
			$sheet->setCellValue("D$c", $legId);
			$sheet->setCellValue("E$c", $legCname);
			$sheet->setCellValue("F$c", $legNum);
			$sheet->setCellValue("G$c", $legConcept);
			$sheet->setCellValue("H$c", $legBase);
			$sheet->setCellValue("I$c", $legIVA);
			$sheet->setCellValue("J$c", $legTotal);
			$sheet->setCellValue("K$c", $legRtefte);
			$sheet->setCellValue("L$c", $legRteICA);
			$sheet->setCellValue("M$c", $legTotalPay);
			
			$sheet->getStyle("A$c:M$c")->applyFromArray($allborders);
			$sheet->getStyle("A$c:M$c")->getFont()->setSize(10);
			
			// TABLE START
			
			$c = 10;
			
			$subBase = 0;
			$subIVA = 0;
			$subTotal = 0;
			$subRtft = 0;
			$subRtica = 0;
			$subPay = 0;
			
			for($i = 0; $i<count($legList);$i++)
			{
				$item = $legList[$i];
				$sheet->setCellValue("A$c", $item["LEGPARENT"]);
				$sheet->setCellValue("B$c", $item["LEGORDER"]);
				$sheet->setCellValue("C$c", $item["LEGDATE"]);
				$sheet->setCellValue("D$c", $item["LEGCID"]);
				$sheet->setCellValue("E$c", $item["LEGCNAME"]);
				$sheet->setCellValue("F$c", $item["LEGORDER"]);
				$sheet->setCellValue("G$c", $item["OTYPE"]);
				$sheet->setCellValue("H$c", $item["LEGBASE"]);
				$sheet->setCellValue("I$c", $item["LEGTAX"]);
				$sheet->setCellValue("J$c", $item["LEGTOTAL"]);
				$sheet->setCellValue("K$c", $item["LEGRETFONT"]);
				$sheet->setCellValue("L$c", $item["LEGRETICA"]);
				$sheet->setCellValue("M$c", $item["LEGTOTAL"]);

				$sheet->getStyle("A$c:M$c")->applyFromArray($allborders);
				$sheet->getStyle("A$c:M$c")->getFont()->setSize(9);
				$sheet->getStyle("H$c:M$c")->getNumberFormat()->setFormatCode('#,##0');
				
				$subBase += floatval ($item["LEGBASE"]);
				$subIVA += floatval ($item["LEGTAX"]);
				$subTotal += floatval ($item["LEGTOTAL"]);
				$subRtft += floatval ($item["LEGRETFONT"]);
				$subRtica += floatval ($item["LEGRETICA"]);
				$subPay += floatval ($item["LEGTOTAL"]);
				
				$c++;
			}
			
			// TOTALS LINE
		
			$sheet->setCellValue("H$c", $subBase);
			$sheet->setCellValue("I$c", $subBase);
			$sheet->setCellValue("J$c", $subTotal);
			$sheet->setCellValue("K$c", $subRtft);
			$sheet->setCellValue("L$c", $subRtica);
			$sheet->setCellValue("M$c", $subPay);
			
			$sheet->getStyle("H$c:M$c")->getFont()->setSize(9);
			$sheet->getStyle("H$c:M$c")->applyFromArray($allborders);
			$sheet->getStyle("H$c:M$c")->applyFromArray($grayBg);
			$sheet->getStyle("H$c:M$c")->getNumberFormat()->setFormatCode('#,##0');
			
			// TOTALS BOX
			
			$c++;
			$c++;
			
			$sheet->setCellValue("K$c", "Valor Anticipo");
			$sheet->setCellValue("M$c", $legValue);
			$sheet->getStyle("K$c:M$c")->getFont()->setSize(9);
			$sheet->getStyle("K$c:M$c")->applyFromArray($allborders);
			$sheet->mergeCells("K$c:L$c");
			$sheet->getStyle("M$c")->getNumberFormat()->setFormatCode('#,##0');
			$c++;
			$sheet->setCellValue("K$c", "Gastos legalizados");
			$sheet->setCellValue("M$c", $subPay);
			$sheet->getStyle("K$c:M$c")->getFont()->setSize(9);
			$sheet->getStyle("K$c:M$c")->applyFromArray($allborders);
			$sheet->mergeCells("K$c:L$c");
			$sheet->getStyle("M$c")->getNumberFormat()->setFormatCode('#,##0');
			$c++;
			$sheet->setCellValue("K$c", "Saldo Legalización");
			$sheet->setCellValue("M$c", $legValue-$subPay);
			$sheet->getStyle("K$c:M$c")->getFont()->setSize(9);
			$sheet->getStyle("K$c:M$c")->applyFromArray($allborders);
			$sheet->mergeCells("K$c:L$c");
			$sheet->getStyle("M$c")->getNumberFormat()->setFormatCode('#,##0');
			
			$c++;
			$c++;
			$c++;
			
			// FOOTER
			
			$sheet->setCellValue("A$c",  $uname);
			$sheet->getStyle("A$c:M$c")->getFont()->setSize(9);
			
			$c++;
			
			$sheet->setCellValue("A$c", "Elaborado");
			$sheet->getStyle("A$c:C$c")->applyFromArray($borderT);
			$sheet->mergeCells("A$c:C$c");
			
			$sheet->setCellValue("F$c", "Revisado");
			$sheet->getStyle("F$c:H$c")->applyFromArray($borderT);
			$sheet->mergeCells("F$c:G$c");
			
			$sheet->setCellValue("K$c", "Contabilizado");
			$sheet->getStyle("K$c:M$c")->applyFromArray($borderT);
			$sheet->mergeCells("K$c:M$c");
			
			$sheet->getStyle("A$c:M$c")->getFont()->setSize(9);
			
			$fname  = "Leg - ".$code;
			$fname = htmlEntities(utf8_decode($fname));
			$path = "../../legs/".$fname.".xls";
			
			$hasFile = file_exists($path);
			if($hasFile == true){unlink($path);}
			
			$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
			$objWriter->save($path );
			
			if($closeVal == "1")
			{
				$str = "UPDATE others SET LEGSTATE='1' WHERE LEGCODE = '".$code."' AND LEGAUTOR = '".$ucode."'";
				$query = $this->db->query($str);
			}
		}
		
		
		$fname = htmlEntities(utf8_decode($fname));
		$resp["message"] = $fname;
		$resp["status"] = true;
		return $resp;
	}
}

?>
