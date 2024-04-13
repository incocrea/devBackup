<?php
date_default_timezone_set('America/Bogota');
require('../fpdf/mc_table.php');
require('../phpExcel/Classes/PHPExcel.php');



class users{

	
	
	
	function __construct()
	{
		// disabled
		// return;
		$this->db = new sql_query();
		session_start();
	}
	function login($info)
	{
	
		$str = "SELECT * FROM users WHERE users.MAIL LIKE '%".$info["autor"]."%' AND users.PASSWD = '".md5($info["pssw"])."' AND users.TYPE = '".$info["type"]."'";
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
	function setFileLink($info)
	{
		
		$code = $info["ocode"];
		$name = htmlentities($info["fileLink"]);
		
		$str = "UPDATE orders SET FILELINK ='".$name."' WHERE CODE='".$code."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
	}
	function getActionsChecks($info)
	{
		$ans = [];
		
		$str = "SELECT *  FROM actions ORDER BY DETAIL ASC";
		$ans["actions"] = $this->db->query($str);
		
		$str = "SELECT *  FROM checklists ORDER BY DETAIL ASC";
		$ans["checklists"] = $this->db->query($str);

		
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveCheckList($info)
	{
		$checkName = $info["checkName"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$code = md5($checkName.$now);
		
		$children = "[]";
		
		$str = "INSERT INTO checklists (CODE, DETAIL, CHILDREN) VALUES ('".$code."', '".$checkName."', '".$children."')";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveAction($info)
	{
		$action = $info["action"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$code = md5($action.$now);
		
		$str = "INSERT INTO actions (CODE, DETAIL) VALUES ('".$code."', '".$action."')";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function deleteAction($info)
	{
		$code = $info["code"];
		
		$str = "DELETE FROM actions WHERE CODE = '".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
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
                $code = str_replace("'","\\'", $info["f-sucuCode"]); 
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
        function getParentSucus()
        {
                $str = "SELECT CODE, CNAME FROM users WHERE TYPE = 'C' AND STATUS = '1' ORDER BY CNAME ASC";
                $query = $this->db->query($str);
                
                if(count($query) > 0){$parents = $query;}
                else{$parents = array();}
                
                $str = "SELECT PARENTCODE, CODE, NAME FROM sucus WHERE STATUS = '1' ORDER BY CODE ASC";
                $query = $this->db->query($str);
                
                if(count($query) > 0){$sucus = $query;}
                else{$sucus = array();}
                
                $list = array();
                $list["parents"] = $parents;
                $list["sucus"] = $sucus;
                
                $resp["message"] = $list;
                $resp["status"] = true;
                return $resp;
        }
	function getMaquiList($info)
	{
		$parent = $info["f-maquiParent"];
		$sucu = str_replace("'","\\'", $info["f-maquiSucu"]); 
		$plate = $info["f-maquiPlate"];

		$ans = array();
		
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
		$ans["maquis"] = $query;
		
		$str = "SELECT * FROM checklists ORDER BY DETAIL ASC";
		$query = $this->db->query($str);
		$ans["checks"] = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		
		return $resp;
	
	}
        function getTechiList($info)
	{
		
                $id = $info["f-techiId"];
                $cat = $info["f-techiCat"];
                $name = $info["f-techiName"];
                $type = 'T';
                
                $where = "WHERE  TYPE = '$type' ";

		if($id != "")
		{
			$where .= "AND  NIT =  '$id'";
		}
		if($cat != "")
		{
			$where .= "AND  CATEGORY LIKE '%$cat%'";
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
                
		$value = $info["value"];
		
		$where = "WHERE STATUS = 1 ";

		if($value != "")
		{
			$where .= "AND  DESCRIPTION LIKE '%$value%'";
		}
                
                $str = "SELECT CODE, DESCRIPTION, COST, COSTMAT, DURATION FROM actis $where ORDER BY CODE";
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
		$num = floatval($info["f-orderNum"]);
		$state = $info["f-orderState"];
		$otype = $info["f-orderType"];
		$odetail = $info["f-orderDetail"];
		$type = 'O';
		$techcode = $info["techcode"];
		
		$where = "WHERE  STATUS = 1 ";

		if($parent != "")
		{
			$where .= "AND  PARENTCODE =  '$parent'";
		}
		if($sucu != "")
		{
			$where .= "AND  SUCUCODE = '".$sucu."'";
		}
		if($num != "")
		{
			$where .= "AND  CCODE = '$num'";
		}
		if($state != "")
		{
			$where .= "AND  STATE = '$state'";
		}
		if($techcode != "")
		{
			$where .= "AND  TECHCODE LIKE '%$techcode%'";
		}
		if($otype != "")
		{
			$where .= "AND  OTYPE = '$otype'";
		}
		if($odetail != "")
		{
			$where .= "AND  DETAIL LIKE '%$odetail%'";
		}
		
		
		$str = "SELECT PARENTNAME, SUCUCODE, SUCUNAME, MAQUIS, CCODE, ICODE, DATE, DETAIL, AUTOR, OTYPE, STATE, CODE, PARENTCODE, TECHCODE, DELDET, FILELINK, PRIORITY FROM orders $where ORDER BY DATE DESC LIMIT 50";
		
		$query = $this->db->query($str);
		
		// $str = "SELECT * FROM orders $where ORDER BY DATE DESC LIMIT 50";
		// $query = $this->db->query($str);
		
		$str = "SELECT CODE, PLATE FROM maquis";
		$maquis = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$resp["maquis"] = $maquis;
			$resp["message"] = $query;
			$resp["status"] = true;
		}
		else
		{
			
			$resp["maquis"] = array();
			$resp["message"] = array();
			$resp["status"] = true;
		}

		return $resp;
	
	}
	function setOstate($info)
	{
		$ocode = $info["ocode"];
		$state = $info["state"];
		
		$str = "UPDATE orders SET STATE = '".$state."' WHERE CODE ='".$ocode."'";
		$query = $this->db->query($str);
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getLogList($info)
	{

		$resp = $info["f-logResp"];
		$iniDate = $info["f-logInidate"];
		$enDate = $info["f-logEndate"];
		$type = $info["f-logType"];
		$target = $info["f-logTarget"];
		$move = $info["f-logMove"];

		$where = "WHERE  STATUS = 1 ";

		if($resp != "")
		{
			$where .= "AND  AUTOR LIKE  '%$resp%'";
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
			$ans["message"] = $query;
			$ans["status"] = true;
		}
		else
		{
			$ans["message"] = array();
			$ans["status"] = true;
		}

		return $ans;
	
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
                $CODE = str_replace("'","\\'", $info["a-sucuCode"]); 
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
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$CODE = md5($info["a-maquiPlate"].$now);
		$PARENTCODE = $info["a-maquiParent"];
		$PARENTNAME = $info["a-maquiParentName"];
		$SUCUCODE = str_replace("'","\\'", $info["a-maquiSucu"]);  
		$SUCUNAME = str_replace("'","\\'", $info["a-maquiSucuName"]);   
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
				
			$editCode = $info["editCode"];
			
			
			// GET ATUAL MAQUICODE UPDATE ALL PLATE IN OTHER TABLES WHERE CODE				
			
			$str = "UPDATE maquis SET PARENTCODE='".$PARENTCODE."', PARENTNAME='".$PARENTNAME."', SUCUCODE='".$SUCUCODE."', SUCUNAME='".$SUCUNAME."', NAME = '".$NAME."', MODEL='".$MODEL."', SERIAL = '".$SERIAL."', VOLT = '".$VOLT."', CURRENT = '".$CURRENT."', POWER = '".$POWER."', PHASES = '".$PHASES."', DETAIL = '".$DETAIL."', PLATE = '".$PLATE."' WHERE CODE='".$editCode."'"; 
$query = $this->db->query($str);
			
		   $this->chlog($info);
			
			$resp["message"] = "edite";
			$resp["status"] = true;

			return $resp;
		}
	}
	function techiSave($info)
	{
		$otype = $info["otype"];
                $utype = $info["utype"];
                $CNAME = $info["a-techiName"];
                $RESPNAME = $info["a-techiName"];
                $NIT = $info["a-techiId"];
                $PHONE = $info["a-techiPhone"];
                $ADDRESS = $info["a-techiAddress"];
                $MAIL = $info["a-techiEmail"];
                $LOCATION = "";
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
                                
                                $CODE = md5($MAIL.$REGDATE);
                                
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
                $COSTMAT = $info["a-actiValueMat"];
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
                        
                                
                        $str = "INSERT INTO actis (CODE, ACTYPE, DESCRIPTION, DURATION, COST, COSTMAT, STATUS) VALUES ('".$CODE."', '".$ACTYPE."', '".$DESCRIPTION."', '".$DURATION."', '".$COST."', '".$COSTMAT."','".$STATUS."')";
                        $query = $this->db->query($str);

                        $this->chlog($info);

                        $resp["message"] = "create";
                        $resp["status"] = true;

                        return $resp;
                }
                else
                {
                        $ACODE = $info["acode"];
                        
                        $str = "UPDATE actis SET ACTYPE='".$ACTYPE."', DESCRIPTION='".$DESCRIPTION."', DURATION='".$DURATION."', COST='".$COST."', COSTMAT='".$COSTMAT."' WHERE CODE ='".$ACODE."'"; 
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

		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
                
		$CODE = md5($info["a-orderParent"].$info["date"].$now);
		
		$DATE = $info["date"];
		$AUTOR = $info["autor"];
		$PARENTCODE = $info["a-orderParent"];
		$PARENTNAME = $info["a-orderParentName"];
		// $SUCUCODE =  str_replace("'","\\'", $info["a-orderSucu"]);
		// $SUCUNAME = str_replace("'","\\'", $info["a-orderSucuName"]);
		$SUCUCODE =  $info["a-orderSucu"];
		$SUCUNAME = $info["a-orderSucuName"];
		$MAQUIS = $info["a-orderMaquis"];
		$PRIORITY = $info["a-orderPriority"];
		$DETAIL = $info["a-orderDesc"];
		$ICODE = $info["a-orderOrderClient"];
		$OTYPE = $info["a-orderType"];
		$STATUS = "1";

		if($otype == "c")
		{
			$str = "SELECT CCODE FROM orders WHERE PARENTCODE = '".$PARENTCODE."' ORDER BY CCODE ASC";
			$query = $this->db->query($str);
			 
			if(count($query) > 0)
			{
				$counter = floatval($query[(count($query))-1]["CCODE"])+1;
			}
			else
			{
				$counter = 1;
			}

			$STATE = "1";
			
			$str = "INSERT INTO orders (CODE, DATE, PARENTCODE, PARENTNAME, SUCUCODE, SUCUNAME, MAQUIS, STATE, STATUS, PRIORITY, OBSERVATIONS, PENDINGS, RECOMENDATIONS, AUTOR, DETAIL, CCODE, ICODE, OTYPE) VALUES ('".$CODE."', '".$DATE."', '".$PARENTCODE."', '".$PARENTNAME."', '".$SUCUCODE."', '".$SUCUNAME."', '".$MAQUIS."', '".$STATE."', '".$STATUS."', '".$PRIORITY."', '', '', '', '".$AUTOR."', '".$DETAIL."', '".$counter."', '".$ICODE."', '".$OTYPE."')";
			$query = $this->db->query($str);

			$this->chlog($info);
			
			mkdir('../../irsc/pics/'.$CODE, 0777, true);
			mkdir('../../irsc/pics/'.$CODE.'/ini', 0777, true);
			mkdir('../../irsc/pics/'.$CODE.'/end', 0777, true);
			mkdir('../../irsc/pics/'.$CODE.'/order', 0777, true);

			
			if($OTYPE == "2")
			{
				$maquins = json_decode($MAQUIS, true);
				$checks = array();
				
				for($i=0; $i<count($maquins); $i++)
				{
					$item = $maquins[$i];
					
					$str = "SELECT NAME, CHECKLIST FROM maquis WHERE CODE = '".$item."'";
					$chck = $this->db->query($str)[0]["CHECKLIST"];
					$name = $this->db->query($str)[0]["NAME"];
					
					$element = array();
					$element["list"] = $chck;
					$element["name"] = $name;
					
					if($element["list"] != "")
					{array_push($checks, $element);}
				}
				
				// ADD ACTIONS TO OACTIONS BASED ON LISTS
				
				$actions = array();
				
				for($i=0; $i<count($checks); $i++)
				{
					$item = $checks[$i];
					$things = array();
					$str = "SELECT CHILDREN FROM checklists WHERE CODE = '".$item["list"]."'";
					$nactions = json_decode($this->db->query($str)[0]["CHILDREN"], true);

					for($j=0; $j<count($nactions); $j++)
					{
						$thing["ACTION"] = $nactions[$j];
						$thing["MNAME"] = $item["name"];
						array_push($things, $thing);
					}
					$actions = array_merge($actions, $things);
				}
				
				$ocode = $CODE;
				
				for($j=0; $j<count($actions); $j++)
				{
					$code = $actions[$j]["ACTION"];
					$str = "SELECT DETAIL FROM actions WHERE CODE = '".$code."'";
					$detail = $this->db->query($str)[0]["DETAIL"];
					$actions[$j]["DETAIL"] = $actions[$j]["MNAME"]." - ".$detail;
					$detail = $actions[$j]["DETAIL"];
					
					$now = new DateTime();
					$now = $now->format('Y-m-d H:i:s');
					
					$code = md5($now.$j);
					
					$str = "INSERT INTO oactions (CODE, OCODE, DETAIL) VALUES ('".$code."', '".$ocode."', '".$detail."')";
					$query = $this->db->query($str);

				}
				
				
				
				
				
				
				
				
				$resp["message"] = $actions;		
				
			}
			else
			{
				$resp["message"] = "done";
			}
			
			$resp["status"] = true;

			return $resp; 
		}
		else
		{
			$STATE = $info["ostate"];
			$CODE = $info["ocode"];
			
			$str = "UPDATE orders SET  MAQUIS='".$MAQUIS."', STATE='".$STATE."', PRIORITY='".$PRIORITY."', DETAIL = '".$DETAIL."', ICODE = '".$ICODE."', OTYPE = '".$OTYPE."' WHERE CODE='".$CODE."'"; 
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
				$str = "UPDATE  $table SET STATE = '6', DELDET = '".$info["deldet"]."' WHERE $table.CODE = '".$info["code"]."'";
				$query = $this->db->query($str);
				
				$str = "DELETE FROM oactis WHERE oactis.OCODE = '".$info["code"]."'";
				$query = $this->db->query($str);
				
				$str = "DELETE FROM oparts WHERE oparts.OCODE = '".$info["code"]."'";
				$query = $this->db->query($str);
				
				$str = "DELETE FROM oactions WHERE oactions.OCODE = '".$info["code"]."'";
				$query = $this->db->query($str);
				
				$str = "DELETE FROM sessions WHERE sessions.OCODE = '".$info["code"]."'";
				$query = $this->db->query($str);
				
				$path = '../../irsc/pics/'.$info["code"]."/" ;
		
				$this->delDir($path);
				// DELETE ALSO ACTIS, INVEN AND FOLDER
				
				// $this->chlog($info);
			
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
			if($delType == "hollydays")
			{
				$str = "DELETE FROM $table WHERE $table.HOLLYDATE = '".$info["code"]."'";
				$query = $this->db->query($str);
			}
			if($delType == "sessions")
			{
				$str = "DELETE FROM $table WHERE $table.CODE = '".$info["code"]."'";
				$query = $this->db->query($str);
			}
			if($delType == "checklists")
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
                $mode = $info["mode"];
				
				// DEVELOP
				
				// if($mode == "Ext")
				// {$code = str_replace("'","\\'", $info["code"]);}
				// else
				// {$code = $info["code"];}
				
				// PRODUCTIVE
				
				if($mode == "Ext")
				{$code = $info["code"];}
				else
				{addslashes($code = $info["code"]);}

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
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$OCODE = $info["ocode"];
		$CODE = md5($now.$info["date"]);
		$ACODE = $info["actiCode"];
		$ADESC = $info["actiDesc"];
		$ACOST = $info["actiCost"];
		$UNIPRICE = $info["actUniVal"];
		$UNICOSTMAT = $info["actUniVal2"];
		$UNIVALUE = $info["actQty"];
		$ADURATION = $info["actiDuration"];
		$DATE = $info["date"];
		$MAQUI = $info["maqui"];
		$MAQUINAME = $info["maquiName"];
		$MAQUICODE = $info["maquiCode"];
		$TECHNAME = $info["tech"];
		$TECHCODE = $info["techcode"];
		$OCCODE = $info["occode"];
		$EDMODE = $info["editingAct"];
		$EDCODE = $info["actualActCode"];
		
		
		if($EDMODE == "0")
		{
			$str = "INSERT INTO oactis (OCODE, CODE, ACODE, ADESC, ACOST, ADURATION, DATE, MAQUI, MAQUINAME, MAQUICODE, TECHNAME, TECHCODE, OCCODE, UNIPRICE, UNICOSTMAT, UNIVALUE) VALUES ('".$OCODE."', '".$CODE."', '".$ACODE."', '".$ADESC."', '".$ACOST."', '".$ADURATION."','".$DATE."', '".$MAQUI."', '".$MAQUINAME."', '".$MAQUICODE."', '".$TECHNAME."', '".$TECHCODE."', '".$OCCODE."','".$UNIPRICE."', '".$UNICOSTMAT."', '".$UNIVALUE."')";
			
			$resp["message"] = "created";
			
		}
		else
		{
						
			$str = "UPDATE oactis SET MAQUICODE = '".$MAQUICODE."', MAQUINAME = '".$MAQUINAME."', ADESC = '".$ADESC."', UNIVALUE = '".$UNIVALUE."', UNIPRICE = '".$UNIPRICE."', UNICOSTMAT = '".$UNICOSTMAT."', ADURATION = '".$ADURATION."', ACOST = '".$ACOST."' WHERE CODE ='".$EDCODE."'";
			
			$resp["message"] = "edited";
		}
	
		
		
		$query = $this->db->query($str);
		
		
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
        function updateoDets($info)
        {
                $ocode = $info["ocode"];
                $obs = $info["obs"];
                $rec = $info["rec"];
                $pen = $info["pen"];
                
                
                $str = "UPDATE orders SET OBSERVATIONS = '".$obs."', RECOMENDATIONS = '".$rec."',  PENDINGS = '".$pen."'  WHERE CODE = '".$ocode."' ";
                $query = $this->db->query($str);
                
                $resp["message"] = "done";
                $resp["status"] = true;
                return $resp;

        }
        function updateActCost($info)
        {
			$actCode = $info["actCode"];
			$newCost = $info["newCost"];
			
			$str = "UPDATE oactis SET UNIPRICE = '".$newCost."' WHERE CODE = '".$actCode."' ";
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

                $value = $info["value"];
                
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
		function getOChecks($info)
        {
                
			$ocode = $info["ocode"];
			
			$str = "SELECT * FROM oactions WHERE OCODE = '".$ocode."'";
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
        function saveOpics($info)
		{
			$order = $info["order"];
			$pics = $info["pics"];
			$field = $info["field"];
			
			$str = "UPDATE orders SET 
			$field = '".$pics."'
			WHERE 
			CODE ='".$order."'";
			$query = $this->db->query($str);
			
			
			$ans = $query;
			
			$resp["message"] = $ans;
			$resp["status"] = true;
			return $resp;
		}
		function getOpics($info)
        {
                $ocode = $info["ocode"];
                
                $directorioIni = '../../irsc/pics/'.$ocode."/ini/" ;
                
				if (file_exists($directorioIni))
				{
				
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
				}
				else
				{
					$oPics["ini"] = array();
				}
					
				$directorioEnd = '../../irsc/pics/'.$ocode."/end/";
				
				if (file_exists($directorioIni))
				{
				
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
				}
				else
				{
					$oPics["end"] = array();
				}
				
				$directorioOrder = '../../irsc/pics/'.$ocode."/order/" ;
				
				if (file_exists($directorioOrder))
				{
					$dirFiles = array();
					if ($handle = opendir($directorioOrder)) 
					{
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
				} 
				else
				{
					$oPics["order"] = array();
				}
                
                
				
                
                $resp["message"] = $oPics;
                $resp["status"] = true;
                return $resp;
        }
		function loadSessLists($info)
		{
			
			$answer = array();
			
			$str = "SELECT CODE, CCODE, PARENTNAME, SUCUNAME, STATE, TECHCODE FROM orders ORDER BY DATE DESC LIMIT 100";
			$query = $this->db->query($str);
			
			$answer["orders"] = $query;
			
			$str = "SELECT CODE, CNAME FROM users WHERE TYPE = 'T'";
			$query = $this->db->query($str);
			
			$answer["techs"] = $query;
			
			$str = "SELECT * FROM hollydays ORDER BY HOLLYDATE ASC";
			$query = $this->db->query($str);
			
			$answer["holly"] = $query;
			
			$resp["message"] = $answer;
			$resp["status"] = true;
			return $resp;
		}
		function refreshSessList($info)
		{
			
			$tech = $info["tech"];
			if($tech != "")
			{
				$str = "SELECT * FROM sessions WHERE TECHCODE = '".$tech."' ORDER BY INIDATE DESC LIMIT 100";
			}
			else
			{
				$str = "SELECT * FROM sessions ORDER BY INIDATE DESC LIMIT 100";
			}
			
			
			$query = $this->db->query($str);
			
						
			$resp["message"] = $query;
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
			$dpkc["code"] =  str_replace("'","\\'", $oData["SUCUCODE"]);
			$dpkc["mode"] =  "Int";
			$maquPlist = $this-> getMaquiListSelect($dpkc)["message"];
			
			$eval = array();
			$eval["value"] = "";
			
			$actPlist = $this->getoActiList($eval)["message"];
			
			$dpkc = array();
			$dpkc["ocode"] = $ocode;
			$oActs = $this-> getOActs($dpkc)["message"];
			
			$dpkc = array();
			$dpkc["ocode"] = $ocode;
			$oChecks = $this-> getOChecks($dpkc)["message"];
			
			$partPlist = $this->getoPartList($eval)["message"];

			$dpkc = array();
			$dpkc["ocode"] = $ocode;
			$oParts = $this-> getOParts($dpkc)["message"];
			
			$dpkc = array();
			$dpkc["ocode"] = $ocode;
			$oOthers = $this-> getOothers($dpkc)["message"];

			// $dpkc = array();
			// $dpkc["ocode"] = $ocode;
			// $oPics = $this-> getOpics($dpkc)["message"];

			
			$opack["oData"] = $oData;
			$opack["actPlist"] = $actPlist;
			$opack["maquPlist"] = $maquPlist;
			$opack["oActs"] = $oActs;
			$opack["partPlist"] = $partPlist;
			$opack["oParts"] = $oParts;
			$opack["oOthers"] = $oOthers;
			// $opack["oPics"] = $oPics;
			$opack["oChecks"] = $oChecks;
			
			$resp["message"] = $opack;
			$resp["status"] = true;
					
			return $resp;
        }
        function getTechiListO($info)
	{
                $str = "SELECT CODE, RESPNAME, CATEGORY, MASTERY, DETAILS  FROM users WHERE TYPE = 'T' AND STATUS = '1' ORDER BY RESPNAME ASC";
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
	function addSession($info)
	{
		$ocode = $info["ocode"];
		$techCode = $info["techCode"];
		$techName = $info["techName"];
		$sessionIni = $info["sessionIni"];
		$sessionEnd = $info["sessionEnd"];
		$sessionDetails = $info["sessionDetails"];
		$laborType = $info["laborType"];
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		
		// VERIFY OVERLAPPING INI
		$str = "SELECT CODE FROM sessions WHERE '".$sessionIni."' >= INIDATE AND '".$sessionIni."' < ENDATE AND TECHCODE = '".$techCode."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$resp["message"] =  "crossini";
			$resp["status"] = true;
			return $resp;
		}

		// VERIFY OVERLAPPING END
		$str = "SELECT CODE FROM sessions WHERE '".$sessionEnd."' >= INIDATE AND '".$sessionEnd."' < ENDATE AND TECHCODE = '".$techCode."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$resp["message"] =  "crossend";
			$resp["status"] = true;
			return $resp;
		}
		
		$CODE = md5($now.$ocode);
		
		$str = "INSERT INTO sessions (CODE, OCODE, TECHCODE, TECHNAME, INIDATE, ENDATE, DETAILS, LTYPE) VALUES ('".$CODE."', '".$ocode."','".$techCode."','".$techName."','".$sessionIni."','".$sessionEnd."','".$sessionDetails."','".$laborType."')";
		$query = $this->db->query($str);
		
		
		$str = "SELECT *  FROM sessions WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function addHollyday($info)
	{
		
		$day = $info["day"];
		
		$str = "INSERT INTO hollydays (HOLLYDATE) VALUES ('".$day."')";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function closeDate($info)
	{
		$dateIni = $info["dateIni"];
		$dateEnd = $info["dateEnd"];
		$tech = $info["tech"];
		
		
		
		$str = "UPDATE sessions SET  STATUS = '1' WHERE INIDATE >= '".$dateIni."' AND ENDATE < '".$dateEnd."' AND TECHCODE = '".$tech."' ";
		$query = $this->db->query($str);
		
		
		$ans = $query;
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
		
	}
	function refreshollydays($info)
	{
		$str = "SELECT * FROM hollydays ORDER BY HOLLYDATE ASC";
		$query = $this->db->query($str);
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getOsessions($info)
	{
		$code = $info["code"];
		
		$str = "SELECT *  FROM sessions WHERE OCODE = '".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function reportSessTech($info)
	{
		$tech = $info["tech"];
		$ini = $info["ini"];
		$end = $info["end"];
		
		$str = "SELECT * FROM sessions WHERE TECHCODE = '".$tech."' AND INIDATE >=  '".$ini."' AND ENDATE <= '".$end."' ";
		$query = $this->db->query($str);
		
		
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	}
	function setTechO($info)
	{
		$ocode = $info["ocode"];
		$name = $info["names"];
		$code = $info["codes"];
		
		$str = "UPDATE orders SET TECHCODE = '".$code."', TECHNAME = '".$name."', STATE = '2'  WHERE CODE ='".$ocode."'";
		$query = $this->db->query($str);

		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
	}
	function setCheckA($info)
	{
		$ccode = $info["ccode"];
		$code = $info["codes"];
		
		$str = "UPDATE checklists SET CHILDREN = '".$code."' WHERE CODE ='".$ccode."'";
		$query = $this->db->query($str);

		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
	}
	function setCheckState($info)
	{
		$ocode = $info["ocode"];
		$code = $info["code"];
		$state = $info["state"];
		
		$str = "UPDATE oactions SET STATUS = '".$state."' WHERE CODE ='".$code."' AND OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		
		$str = "SELECT *  FROM oactions WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	}
	function linkCheck($info)
	{
		$ccode = $info["ccode"];
		$checklist = $info["checklist"];
		
		$str = "UPDATE maquis SET CHECKLIST = '".$checklist."' WHERE CODE ='".$ccode."'";
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
		
		$str = "SELECT *  FROM sessions WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		$osessions = $query;
		
		$str = "SELECT * FROM oactions WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
	
		$oactions = $query;
		
		$icode = $odata["ICODE"];
		$otype = $odata["OTYPE"];
		
		if($otype == "1"){$typeO = "GENERAL";}
		if($otype == "2"){$typeO = "PREVENTIVO";}
		if($otype == "3"){$typeO = "CORRECTIVO";}
		if($otype == "4"){$typeO = "LOCATIVAS";}
		if($otype == "5"){$typeO = "OTROS";}
		
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
			$sucuname = $oData["SUCUCODE"];
		}
		else
		{
			$sucuname = $odata["SUCUNAME"];
		}
		$techname = utf8_decode($odata["TECHNAME"]);
		
		$techname = str_replace ('"', '', $techname);
		$techname = str_replace ('[', '', $techname);
		$techname = str_replace (']', '', $techname);
		$techname = str_replace (',', ', ', $techname);
		
		$requestdate = $odata["DATE"];
		$atendedate = $odata["STARTIME"];
		
		// REPORTED EXTRACT FROM SESSIONS
		
		$dpkc = array();
		$dpkc["code"] = $odata["CODE"];
		$ominutes = $this-> getOtime($dpkc)["message"];
		$oinidate = $this-> getOtime($dpkc)["inidate"];
		$reported = date('H:i', mktime(0,$ominutes))." Horas";
		
		$detail = utf8_decode($odata["DETAIL"]);
		$obs = utf8_decode($odata["OBSERVATIONS"]);
		$rec = utf8_decode($odata["RECOMENDATIONS"]);
		$pen = utf8_decode($odata["PENDINGS"]);
		
		$requested = $odata["DATE"];
		
		// FILE START
		$pdf = new PDF_MC_Table('P', 'mm', 'Letter');
		$pdf->AddPage('P', 'Letter');
		
		$pdf->Image('../../irsc/forderA.jpg',0,0,218,0,'','');
		$pdf->SetFont('Arial','B', 12);
		$pdf->SetFillColor(102,102,102);
		
		// HEADER START-----------
		
		$cname = substr($cname,0,30);
		$techname = substr($techname,0,70);
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
		// $pdf->Cell(35,5,$requestdate,0,0,'L',false);
		$pdf->Ln(7);

		// H LINE 2
		$pdf->Cell(13,5,'',0,0,'C',false);
		$pdf->Cell(48,5,$sucuname,0,0,'L',false);
		$pdf->Cell(33,5,'',0,0,'C',false);
		$pdf->Cell(15,5,$reported,0,0,'L',false);
		$pdf->Cell(60,5,'',0,0,'C',false);
		$pdf->Cell(35,5,$oinidate,0,0,'L',false);
		$pdf->Ln(7);
		
		// H LINE 2
		$pdf->Cell(13,5,'',0,0,'C',false);
		
		$detail = $detail." -> Tipo: ".$typeO." -> Solicitado: ".$requested;
		
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
		$location = "";
		$pdf->Cell(145,6,$location,0,1,'R',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->SetTextColor(255);

		// HEADERS
		$w = array(25, 45, 105, 20);
		$header = array('Placa', 'Nombre', 'Actividad', 'Cantidad');
		
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
			$align = array("L", "L", "L", "C");
			
			$maqui = utf8_decode($row['MAQUI']);
			$maquiname = utf8_decode($row['MAQUINAME']);
			$adesc = utf8_decode($row['ADESC']);
			$aqty = utf8_decode($row['UNIVALUE']);
			
			$pdf->Row(array($maqui, $maquiname, $adesc, $aqty), 1, $align);
				
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
				
			$align = array("L", "L", "C");
		
			$pcode = utf8_decode($row['PCODE']);
			$pdesc = utf8_decode($row['PDESC']);
			$pamount = utf8_decode($row['PAMOUNT']);
			
			$pdf->Row(array($pcode, $pdesc, $pamount), 1, $align);
			
			
			$fill = !$fill;
		}
		
		// lineClose
		$pdf->Cell(array_sum($w),0,'','T');
		
		$pdf->Ln(1);
		
		
		// SESSIONS ---------
		
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(50,6,'Sesiones de trabajo',0,1,'L',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->SetTextColor(255);
		$pdf->SetFillColor(102,102,102);
		
		
		// HEADERS
		$w = array(105, 30, 30, 30);
		$header = array('Técnico', 'Inicio', 'Fin', 'Duración H:M');

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
		
		// sessionsData
		foreach($osessions as $row)
		{
			$align = array("L", "C", "C", "C");
		
			$tech = utf8_decode($row['TECHNAME']);
			$start = utf8_decode($row['INIDATE']);
			$end = utf8_decode($row['ENDATE']);
			
			$datetime1 = new DateTime($row['INIDATE']);
			$datetime2 = new DateTime($row['ENDATE']);
			$interval = $datetime1->diff($datetime2);
			
			$duration = $interval->format('%h').":".$interval->format('%i');
			
			
			$pdf->Row(array($tech, $start, $end, $duration), 1, $align);
			$fill = !$fill;
		}
		
		
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
		
		if($otype == "2")
		{
			$pdf->Ln(1);
			// CHECKLIST ---------
			
			$pdf->SetTextColor(0);
			$pdf->SetFont('Arial','B', 9);
			$pdf->Cell(50,6,'Lista de chequeo',0,1,'L',false);
			$pdf->SetFont('Arial','B', 8);
			$pdf->SetTextColor(255);
			$pdf->SetFillColor(102,102,102);
			
			
			// HEADERS
			$w = array(160, 35);
			$header = array('Acción', 'Estado');

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
			
			// sessionsData
			foreach($oactions as $row)
			{
				$align = array("L", "C");
			
				$action = utf8_decode($row['DETAIL']);
				if($row['STATUS'] == "0")
				{$state = "No completado";}
				else
				{$state = "Completado";}
				
				$status = $state;
				
				$pdf->Row(array($action, $status), 1, $align);
				$fill = !$fill;
			}
		
		}
		
		$pdf->Ln(1);
		
		
		
		$pdf->SetFont('Arial','', 7);

		// OBS FILLER
		
		$pdf->Ln(5);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(50,6,'Observaciones',0,1,'L',false);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		$w = array(195);
		$pdf->SetWidths($w);
		$align = array("L");
		$pdf->Row(array($obs), 1, $align);


		// REC FILLER
		$pdf->Ln(5);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(50,6,'Recomendaciones',0,1,'L',false);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		$w = array(195);
		$pdf->SetWidths($w);
		$align = array("L");
		$pdf->Row(array($rec), 1, $align);
		
		// PEN FILLER
		$pdf->Ln(5);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(50,6,'Pendientes',0,1,'L',false);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		$w = array(195);
		$pdf->SetWidths($w);
		$align = array("L");
		$pdf->Row(array($pen), 1, $align);
		
		$pdf->Ln(5);
		
		// $pntest = $pdf->PageGroupAlias();
		
		$pdf->Cell(195,6,'Nombre Tecnico: ____________________________  Nombre Cliente: _______________________________',0,0,'R',false);
		
		
		// ADITIONAL IMAGE PAGES
		
		$infoAdd = " Orden: ".$number." - ".$cname;
		
		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		
		// $oPics = $this-> getOpics($dpkc)["message"];
		
		// GET INIPICS
		if($odata["OINIPICS"] != null and $odata["OINIPICS"] != "")
		{$inipics = json_decode($odata["OINIPICS"], true);}
		else{$inipics = array();}
		
	
		// GET ENDPICS
		if($odata["OENDPICS"] != null and $odata["OENDPICS"] != "")
		{$endpics = json_decode($odata["OENDPICS"], true);}
		else{$endpics = array();}
		
		// GET ORDPICS
		if($odata["OORDPICS"] != null and $odata["OORDPICS"] != "")
		{$ordpics = json_decode($odata["OORDPICS"], true);}
		else{$ordpics = array();}
		
		
		// ADD INI PICS
		
		if(count($inipics) > 0)
		{
			$pdf->SetFont('Arial','B', 11);
			$pdf->AddPage('P', 'Letter');
			$pdf->Ln(2);
			$pdf->Cell(50,5,"Fotos Iniciales ".$infoAdd,0,0,'L',false);
			$pdf->Ln(5);
			$halfCount = 0;
			
			$picPosH = 20; 
			$picPosV = 20; 
			
			for($i=0; $i<count($inipics); $i++)
			{
				$dataURI = $inipics[$i];
				$dataPieces = explode(',',$dataURI);
				$encodedImg = $dataPieces[1];
				$decodedImg = base64_decode($encodedImg);
				$imgPath = '../../irsc/pics/tmpImg'.$i.'.jpg';
				
				if( file_put_contents($imgPath,$decodedImg)!== false )
				{
					$pdf->Image($imgPath,$picPosV,$picPosH,70,110);

					if($halfCount == 1 or $halfCount == 3)
					{
						if($picPosH == 20){$picPosH = 145;}
						else{$picPosH = 20;}
					}
					if($picPosV == 20){$picPosV = 130;}
					else{$picPosV = 20;}

					$pdf->Ln(125);
					$halfCount++;
					
					if($halfCount == 4 and $i != count($inipics)-1)
					{
						$pdf->SetFont('Arial','B', 11);
						$pdf->AddPage('P', 'Letter');
						$pdf->Ln(2);
						$halfCount = 0;
					}
					unlink($imgPath);
				}
			}
		
		}
		
		// ADD END PICS
		
		if(count($endpics) > 0)
		{
			$pdf->SetFont('Arial','B', 11);
			$pdf->AddPage('P', 'Letter');
			$pdf->Ln(2);
			$pdf->Cell(50,5,"Fotos Finales ".$infoAdd,0,0,'L',false);
			$pdf->Ln(5);
			$halfCount = 0;
			
			$picPosH = 20; 
			$picPosV = 20; 
			
			for($i=0; $i<count($endpics); $i++)
			{
				$dataURI = $endpics[$i];
				$dataPieces = explode(',',$dataURI);
				$encodedImg = $dataPieces[1];
				$decodedImg = base64_decode($encodedImg);
				$imgPath = '../../irsc/pics/tmpImgE'.$i.'.jpg';
				
				if( file_put_contents($imgPath,$decodedImg)!== false )
				{
					$pdf->Image($imgPath,$picPosV,$picPosH,70,110);

					if($halfCount == 1 or $halfCount == 3)
					{
						if($picPosH == 20){$picPosH = 145;}
						else{$picPosH = 20;}
					}
					if($picPosV == 20){$picPosV = 130;}
					else{$picPosV = 20;}

					$pdf->Ln(125);
					$halfCount++;
					
					if($halfCount == 4 and $i != count($endpics)-1)
					{
						$pdf->SetFont('Arial','B', 11);
						$pdf->AddPage('P', 'Letter');
						$pdf->Ln(2);
						$halfCount = 0;
					}
					unlink($imgPath);
				}
			}
		
		}

		// ADD ORDER PICS
		
		if(count($ordpics) > 0)
		{
			$pdf->SetFont('Arial','B', 11);
			$pdf->AddPage('P', 'Letter');
			$pdf->Ln(2);
			$pdf->Cell(50,5,"Fotos OT: ".$infoAdd,0,0,'L',false);
			$pdf->Ln(5);
			
			
			for($i=0; $i<count($ordpics); $i++)
			{
				$dataURI = $ordpics[$i];
				$dataPieces = explode(',',$dataURI);
				$encodedImg = $dataPieces[1];
				$decodedImg = base64_decode($encodedImg);
				$imgPath = '../../irsc/pics/tmpImgO'.$i.'.jpg';
				
				if( file_put_contents($imgPath,$decodedImg)!== false )
				{
					$pdf->Image($imgPath,0,20,216,250);
					
					if($i != count($ordpics)-1)
					{
						$pdf->SetFont('Arial','B', 11);
						$pdf->AddPage('P', 'Letter');
						$pdf->Ln(2);
						$halfCount = 0;
					}
					unlink($imgPath);
				}
			}
		
		}
		

		// ------------------------------------------------------------
		// ------------------------------------------------------------
		// ------------------------------------------------------------



		// createFile
		
		$pdf->Output('../../reports/'.$ocode.'.pdf','F');



		if($partial != "1")
		{
			// CHANGE ORDER STATE AND SEND EMAIL WITH PATH IS TECH CLOSE
			
			$str = "UPDATE orders SET STATE = '3', CLOSEDATE = '".$date."' WHERE CODE ='".$ocode."'";
			// ---UNCOMMENT THIS
			$query = $this->db->query($str); 
			
			$path = '/reports/'.$ocode.'.pdf';
			
			// SEND EMAIL WITH LINK
			
			$language = "es_co";
			$langFile = parse_ini_file("../../lang/lang.ini", true);
			
			$header = "Reporte generado para la orden ".$number;
			$message = "Se genero el reporte para la orden ".$number;
			
			// GET CLIENTE EMAIL
			$clientCode = $odata["PARENTCODE"];
			$str = "SELECT MAIL FROM users WHERE CODE = '".$clientCode."'";
			$userEmail = $this->db->query($str)[0]["MAIL"];
			
			// $userEmail = "incocrea@outlook.com";
			
			$email_subject = $header;
			$email_from = 'reportes@sherbim.co';
			$email_message = 
			"<div style='text-align: center; margin: auto; width: 800px !important; background: #F0EDE8; border-radius: 15px;'>".
			"<img src='http://www.sherbim.co/app/irsc/pasRecHeader-".$language.".png' style='width=100% !important;'/>".
			"<br><br>".
			"<span style='font-size:14px; '>".$message."</span>".
			"<br>".
			"<span style='font-size:14px; font-weight: bold;'>"."<a href='http://www.sherbim.co/app".$path."'>Descargar reporte</a></span><br><br>".
			"<img src='http://www.sherbim.co/app/irsc/footer-".$language.".png' style='width=100% !important;'/>".
			"</div>";
			
			$headers = "From: " . $email_from . "\r\n";
			$headers .= "Reply-To: ". $email_from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			if(count(explode(",", $userEmail)) > 1)
			{
				mail ($userEmail, $email_subject, $email_message, $headers);
				$ans = "mail Sent";
			}
			else
			{
				if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL))
				{
					$ans = "Invalid: ".$userEmail;
				}
				else
				{
					mail ($userEmail, $email_subject, $email_message, $headers);
					$ans = "mail Sent";
				}
			}

			
			
		}
		else
		{
			$path = 'none';
			$ans = "report Created";
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
			$code = md5($ocode.$reported);
			
			$sucucode = addslashes($odata['SUCUCODE']);
			$sucuname = addslashes($odata['SUCUNAME']);
			
			$str = "INSERT INTO oreports (CODE, OCODE, DATE, PARENTNAME, PARENTCODE, SUCUCODE, SUCUNAME, TECHCODE, TECHNAME, OCCODE, STATUS, TYPE) VALUES ('".$code."', '".$ocode."', '".$date."', '".$odata['PARENTNAME']."', '".$odata['PARENTCODE']."', '".$sucucode."', '".$sucuname."', '".$odata['TECHCODE']."', '".$odata['TECHNAME']."', '".$odata["CCODE"]."', '1', '0')";
			$query = $this->db->query($str);
		}
		

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function reportCreateE($info)
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
		
		$str = "SELECT *  FROM sessions WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		$osessions = $query;
		
		$str = "SELECT * FROM oactions WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
	
		$oactions = $query;
		
		$icode = $odata["ICODE"];
		$otype = $odata["OTYPE"];
		
		
		
		if($otype == "1"){$typeO = "GENERAL";}
		if($otype == "2"){$typeO = "PREVENTIVO";}
		if($otype == "3"){$typeO = "CORRECTIVO";}
		if($otype == "4"){$typeO = "LOCATIVAS";}
		if($otype == "5"){$typeO = "OTROS";}

		
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
			$sucuname = str_replace("'","\\'", $oData["SUCUCODE"]);
		}
		else
		{
			$sucuname = $odata["SUCUNAME"];
		}
		$techname = utf8_decode($odata["TECHNAME"]);
		
		$techname = str_replace ('"', '', $techname);
		$techname = str_replace ('[', '', $techname);
		$techname = str_replace (']', '', $techname);
		$techname = str_replace (',', ', ', $techname);
		
		$requestdate = $odata["DATE"];
		$atendedate = $odata["STARTIME"];
		
		// REPORTED EXTRACT FROM SESSIONS
		
		$dpkc = array();
		$dpkc["code"] = $odata["CODE"];
		$ominutes = $this-> getOtime($dpkc)["message"];
		$oinidate = $this-> getOtime($dpkc)["inidate"];
		$reported = date('H:i', mktime(0,$ominutes))." Horas";
		$reported = "Fecha/Hora inicio: ________________  Fecha/Hora fin:________________ Tiempo servicio: _______";
		
		$detail = utf8_decode($odata["DETAIL"]);
		$obs = utf8_decode($odata["OBSERVATIONS"]);
		$rec = utf8_decode($odata["RECOMENDATIONS"]);
		$pen = utf8_decode($odata["PENDINGS"]);
		
		// FILE START
		$pdf = new PDF_MC_Table('P', 'mm', 'Letter');
		$pdf->AddPage('P', 'Letter');
		
		$pdf->Image('../../irsc/forder.jpg',0,0,218,0,'','');
		$pdf->SetFont('Arial','B', 12);
		$pdf->SetFillColor(102,102,102);
		
		// HEADER START-----------
		
		$cname = substr($cname,0,30);
		$techname = substr($techname,0,70);
		$sucuname = substr(utf8_decode($sucuname),0,30);
		$reported = substr(utf8_decode($reported),0,100);
		
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
		// $pdf->Cell(35,5,$requestdate,0,0,'L',false);
		$pdf->Ln(7);

		// H LINE 2
		$pdf->Cell(13,5,'',0,0,'C',false);
		$pdf->Cell(48,5,$sucuname,0,0,'L',false);
		$pdf->Cell(3,5,'',0,0,'C',false);
		$pdf->Cell(60,5,$reported,0,0,'L',false);
		$pdf->Cell(45,5,'',0,0,'C',false);
		$pdf->Cell(35,5," ",0,0,'L',false);
		$pdf->Ln(7);
		
		// H LINE 2
		$pdf->Cell(13,5,'',0,0,'C',false);
		
		$requested = $odata["DATE"];

		
		if($otype == "2")
		{
			
			$plate = explode('"',$odata["MAQUIS"])[1];
			
			$dpkc = array();
			$dpkc["code"] = $plate;
			$thePlate = $this-> getMaquiData($dpkc)["message"][0]["PLATE"];
			$theName = $this-> getMaquiData($dpkc)["message"][0]["NAME"];
			
			
			$detail = $detail." -> Tipo: ".$typeO."  PLACA DE EQUIPO: ".$thePlate." - NOMBRE DE EQUIPO: ".$theName;
		}
		else
		{
			$detail = $detail." -> Tipo: ".$typeO." -> Solicitado: ".$requested;
		}
		
		
		
		if(strlen($detail) < 130)
		{
			$pdf->Cell(48,5,$detail,0,0,'L',false);
			$pdf->Ln(6);
		}
		else
		{
			$line1 = str_split($detail, 130)[0];
			$pdf->Cell(183,5,$line1,0,0,'L',false);
			
			if(count(str_split($detail, 130)) > 1)
			{
				$line2 = str_split($detail, 130)[1];
				$pdf->Ln(6);
				$pdf->Cell(196,5,$line2,0,0,'L',false);
			}
		}
		
		// HEADER END -----------

		$pdf->Ln(8);
		$pdf->SetDrawColor(39,46,54);
		$pdf->SetLineWidth(.2);
		
		// CONTENT ACTIVITIES---------

		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(50,6,'Actividades',0,0,'L',false);
		$location = "";
		$pdf->Cell(145,6,$location,0,1,'R',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->SetTextColor(255);

		// HEADERS
		$w = array(25, 45, 105, 20);
		$header = array('Placa', 'Nombre', 'Actividad', 'Cantidad');
		
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
		$actList = [""];
		foreach($actList as $row)
		{
			$align = array("L", "L", "L", "C");
			
			$maqui = "";
			$maquiname = "";
			$adesc = "";
			$aqty = "";
			
			$pdf->Row(array($maqui, $maquiname, $adesc, $aqty), 1, $align);
				
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
		
		$partList = ["","","","",""];
		// partData
		foreach($partList as $row)
		{
				
			$align = array("L", "L", "C");
		
			$pcode = "";
			$pdesc = "";
			$pamount = "";
			
			$pdf->Row(array($pcode, $pdesc, $pamount), 1, $align);
			
			
			$fill = !$fill;
		}
		
		$pdf->Ln(1);

		if($otype == "2")
		{
			$pdf->Ln(1);
			// CHECKLIST ---------
			
			$pdf->SetTextColor(0);
			$pdf->SetFont('Arial','B', 9);
			$pdf->Cell(50,6,'Lista de chequeo',0,1,'L',false);
			$pdf->SetFont('Arial','B', 8);
			$pdf->SetTextColor(255);
			$pdf->SetFillColor(102,102,102);
			
			
			// HEADERS
			$w = array(180, 15);
			$header = array('Acción', 'RV');

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
			
			// sessionsData
			foreach($oactions as $row)
			{
				$align = array("L", "C");
			
				$action = utf8_decode(explode(" - ",$row['DETAIL'])[1]);
				if($row['STATUS'] == "0")
				{$state = "No completado";}
				else
				{$state = "Completado";}
				
				$status = "";
				
				$pdf->Row(array($action, $status), 1, $align);
				$fill = !$fill;
			}
			
			$obs = "\n \n \n \n \n \n \n \n \n \n \n \n \n \n \n";
		
		}
		else
		{
			$obs = "\n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n";
		}

		$pdf->Ln(1);
		$pdf->SetFont('Arial','', 7);

		// OBS FILLER

		$pdf->Ln(5);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(50,6,'Observaciones',0,1,'L',false);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		$w = array(195);
		$pdf->SetWidths($w);
		$align = array("L");
		$pdf->Row(array($obs), 1, $align);

		
		$pdf->Ln(5);
		
		// $pntest = $pdf->PageGroupAlias();
		
		$pdf->Cell(195,6,'Nombre Tecnico: ____________________________  Nombre Cliente: _______________________________',0,0,'R',false);
		
		$path = '../../reports/'.$ocode.'-V.pdf';

		// createFile
		$pdf->Output($path,'F');

		$resp["message"] = $path;
		$resp["status"] = true;
		return $resp;
	}
	
	function getMaquiData($info)
	{
		$code = $info["code"];
		
		$str = "SELECT PLATE, NAME FROM maquis WHERE CODE = '".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
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
		
		$str = "SELECT *  FROM sessions WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		
		$osessions = $query;
		
		$str = "SELECT * FROM oactions WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
	
		$oactions = $query;
		
		$icode = $odata["ICODE"];
		$otype = $odata["OTYPE"];
		
		if($otype == "1"){$typeO = "GENERAL";}
		if($otype == "2"){$typeO = "PREVENTIVO";}
		if($otype == "3"){$typeO = "CORRECTIVO";}
		if($otype == "4"){$typeO = "LOCATIVAS";}
		if($otype == "5"){$typeO = "OTROS";}
		
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
			$sucuname = str_replace("'","\\'", $oData["SUCUCODE"]);
		}
		else
		{
			$sucuname = $odata["SUCUNAME"];
		}
		$techname = utf8_decode($odata["TECHNAME"]);
		
		$techname = str_replace ('"', '', $techname);
		$techname = str_replace ('[', '', $techname);
		$techname = str_replace (']', '', $techname);
		$techname = str_replace (',', ', ', $techname);
		
		$requestdate = $odata["DATE"];
		$atendedate = $odata["STARTIME"];
		
		// REPORTED EXTRACT FROM SESSIONS
		$dpkc = array();
		$dpkc["code"] = $odata["CODE"];
		$ominutes = $this-> getOtime($dpkc)["message"];
		$oinidate = $this-> getOtime($dpkc)["inidate"];
		$reported = date('H:i', mktime(0,$ominutes))." Horas";
		
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
		
		$cname = substr($cname,0,30);
		$techname = substr($techname,0,70);
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
		// $pdf->Cell(35,5,$requestdate,0,0,'L',false);
		$pdf->Ln(7);

		// H LINE 2
		$pdf->Cell(13,5,'',0,0,'C',false);
		$pdf->Cell(48,5,$sucuname,0,0,'L',false);
		$pdf->Cell(33,5,'',0,0,'C',false);
		$pdf->Cell(15,5,$reported,0,0,'L',false);
		$pdf->Cell(60,5,'',0,0,'C',false);
		$pdf->Cell(35,5,$oinidate,0,0,'L',false);
		$pdf->Ln(7);
		
		// H LINE 2
		$pdf->Cell(13,5,'',0,0,'C',false);
		
		$requested = $odata["DATE"];
		
		$detail = $detail." -> Tipo: ".$typeO." -> Solicitado: ".$requested;
		
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
		$location = "";
		$pdf->Cell(145,6,$location,0,1,'R',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->SetTextColor(255);
		
		
		
		$w = array(25, 29, 92, 13, 18, 18);
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
			$univalT = '$'.number_format($row['UNIPRICE']+$row['UNICOSTMAT']);
			$unival = $row['UNIPRICE'];
			$unival2 = $row['UNICOSTMAT'];
			$acost = $unival+$unival2;
			$subtotal = '$'.number_format(($qty*$unival)+($qty*$unival2));
			
			$pdf->Row(array($maqui, $maquiname, $adesc,$qty, $univalT, $subtotal), 1, $align);

			$fill = !$fill;
			$tActis += ($qty*$acost);
		}
		
		// lineClose
		$pdf->Cell(array_sum($w),0,'','T');
		
		$pdf->Ln(1);
		
		
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(165,6,'Repuestos',0,0,'L',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->Cell(12,6,'Total',1,0,'C',false);
		$pdf->Cell(18,6,'$'.number_format($tActis),1,0,'R',false);
		$pdf->Ln(6);
		
		// CONTENT ACTIVITIES END---------
		
		// CONTENT PARTS---------
		
		$pdf->SetTextColor(255);
		$pdf->SetFillColor(102,102,102);
		
		$w = array(25, 121, 13,18, 18);
		$header = array('Código', 'Nombre', 'Cantidad','Valor un', 'Subtotal');
		
		$pdf->SetWidths($w);
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
			
			$align = array("L", "L", "C", "R", "R");
			
			$pcode = utf8_decode($row['PCODE']);
			$pdesc = utf8_decode($row['PDESC']);
			$pamount = utf8_decode($row['PAMOUNT']);
			$pcost = "$".number_format(utf8_decode($row['PCOST']));
			$pst = "$".number_format($row['PAMOUNT']*$row['PCOST']);
			
			$pdf->Row(array($pcode, $pdesc, $pamount,$pcost, $pst), 1, $align);
			$fill = !$fill;
			
			$tRepus += ($row['PAMOUNT']*$row['PCOST']);
		}
		
		// lineClose
		$pdf->Cell(array_sum($w),0,'','T');
		
		$pdf->Ln(1);
		
		
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(165,6,'Otros conceptos',0,0,'L',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->Cell(12,6,'Total',1,0,'C',false);
		$pdf->Cell(18,6,'$'.number_format($tRepus),1,0,'R',false);
		
		
		
		// TRANSPORT CONTENT
		
		$pdf->Ln(6);
		$pdf->SetTextColor(255);
		$pdf->SetFillColor(102,102,102);

		$pdf->SetWidths($w);
		$pdf->Ln(1);
		
		$w = array(146, 13, 18, 18);
		$header = array('Descripción', 'Cant', 'Valor Un.','Valor');
		
		$pdf->SetWidths($w);
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
			$align = array("L", "C", "R", "R");
		
			$odesc= utf8_decode($row['ODESC']);
			$oamount = utf8_decode($row['AMOUNT']);
			$ocost = "$".number_format(utf8_decode($row['COST']));
			$ost = "$".number_format($row['COST']*$row['AMOUNT']);
			
			$pdf->Row(array($odesc, $oamount, $ocost,$ost), 1, $align);

			
			$tOthers += ($row['COST']*$row['AMOUNT']);
		}
		
		// lineClose
		$pdf->Cell(array_sum($w),0,'','T');
		$pdf->SetFont('Arial','B', 8);
		$pdf->Ln(1);
		$pdf->Cell(165,6,'',0,0,'L',false);
		$pdf->Cell(12,6,'Total',1,0,'C',false);
		$pdf->Cell(18,6,'$'.number_format($tOthers),1,0,'R',false);
		
		$pdf->Ln(10);
		
		$pdf->Cell(155,6,'',0,0,'L',false);
		$pdf->SetFont('Arial','B', 8);
		$pdf->Cell(22,6,'Total Orden',1,0,'C',false);
		$pdf->Cell(18,6,'$'.number_format($tRepus+$tOthers+$tActis),1,0,'R',false);
		
		$pdf->SetFont('Arial','', 7);

		// OBS FILLER
		
		$pdf->Ln(5);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(50,6,'Observaciones',0,1,'L',false);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		$w = array(195);
		$pdf->SetWidths($w);
		$align = array("L");
		$pdf->Row(array($obs), 1, $align);


		// REC FILLER
		$pdf->Ln(5);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(50,6,'Recomendaciones',0,1,'L',false);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		$w = array(195);
		$pdf->SetWidths($w);
		$align = array("L");
		$pdf->Row(array($rec), 1, $align);
		
		// PEN FILLER
		$pdf->Ln(5);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(50,6,'Pendientes',0,1,'L',false);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		$w = array(195);
		$pdf->SetWidths($w);
		$align = array("L");
		$pdf->Row(array($pen), 1, $align);
		
		
		// ADITIONAL IMAGE PAGES
		
		$infoAdd = " Orden: ".$number." - ".$cname;
		
		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		
		// $oPics = $this-> getOpics($dpkc)["message"];
		
		// GET INIPICS
		if($odata["OINIPICS"] != null and $odata["OINIPICS"] != "")
		{$inipics = json_decode($odata["OINIPICS"], true);}
		else{$inipics = array();}
		
	
		// GET ENDPICS
		if($odata["OENDPICS"] != null and $odata["OENDPICS"] != "")
		{$endpics = json_decode($odata["OENDPICS"], true);}
		else{$endpics = array();}
		
		// GET ORDPICS
		if($odata["OORDPICS"] != null and $odata["OORDPICS"] != "")
		{$ordpics = json_decode($odata["OORDPICS"], true);}
		else{$ordpics = array();}
		
		
		// ADD INI PICS
		
		if(count($inipics) > 0)
		{
			$pdf->SetFont('Arial','B', 11);
			$pdf->AddPage('P', 'Letter');
			$pdf->Ln(2);
			$pdf->Cell(50,5,"Fotos Iniciales ".$infoAdd,0,0,'L',false);
			$pdf->Ln(5);
			$halfCount = 0;
			
			$picPosH = 20; 
			$picPosV = 20; 
			
			for($i=0; $i<count($inipics); $i++)
			{
				$dataURI = $inipics[$i];
				$dataPieces = explode(',',$dataURI);
				$encodedImg = $dataPieces[1];
				$decodedImg = base64_decode($encodedImg);
				$imgPath = '../../irsc/pics/tmpImg'.$i.'.jpg';
				
				if( file_put_contents($imgPath,$decodedImg)!== false )
				{
					$pdf->Image($imgPath,$picPosV,$picPosH,70,110);

					if($halfCount == 1 or $halfCount == 3)
					{
						if($picPosH == 20){$picPosH = 145;}
						else{$picPosH = 20;}
					}
					if($picPosV == 20){$picPosV = 130;}
					else{$picPosV = 20;}

					$pdf->Ln(125);
					$halfCount++;
					
					if($halfCount == 4 and $i != count($inipics)-1)
					{
						$pdf->SetFont('Arial','B', 11);
						$pdf->AddPage('P', 'Letter');
						$pdf->Ln(2);
						$halfCount = 0;
					}
					unlink($imgPath);
				}
			}
		
		}
		
		// ADD END PICS
		
		if(count($endpics) > 0)
		{
			$pdf->SetFont('Arial','B', 11);
			$pdf->AddPage('P', 'Letter');
			$pdf->Ln(2);
			$pdf->Cell(50,5,"Fotos Finales ".$infoAdd,0,0,'L',false);
			$pdf->Ln(5);
			$halfCount = 0;
			
			$picPosH = 20; 
			$picPosV = 20; 
			
			for($i=0; $i<count($endpics); $i++)
			{
				$dataURI = $endpics[$i];
				$dataPieces = explode(',',$dataURI);
				$encodedImg = $dataPieces[1];
				$decodedImg = base64_decode($encodedImg);
				$imgPath = '../../irsc/pics/tmpImgE'.$i.'.jpg';
				
				if( file_put_contents($imgPath,$decodedImg)!== false )
				{
					$pdf->Image($imgPath,$picPosV,$picPosH,70,110);

					if($halfCount == 1 or $halfCount == 3)
					{
						if($picPosH == 20){$picPosH = 145;}
						else{$picPosH = 20;}
					}
					if($picPosV == 20){$picPosV = 130;}
					else{$picPosV = 20;}

					$pdf->Ln(125);
					$halfCount++;
					
					if($halfCount == 4 and $i != count($endpics)-1)
					{
						$pdf->SetFont('Arial','B', 11);
						$pdf->AddPage('P', 'Letter');
						$pdf->Ln(2);
						$halfCount = 0;
					}
					unlink($imgPath);
				}
			}
		
		}

		// ADD ORDER PICS
		
		if(count($ordpics) > 0)
		{
			$pdf->SetFont('Arial','B', 11);
			$pdf->AddPage('P', 'Letter');
			$pdf->Ln(2);
			$pdf->Cell(50,5,"Fotos OT: ".$infoAdd,0,0,'L',false);
			$pdf->Ln(5);
			
			
			for($i=0; $i<count($ordpics); $i++)
			{
				$dataURI = $ordpics[$i];
				$dataPieces = explode(',',$dataURI);
				$encodedImg = $dataPieces[1];
				$decodedImg = base64_decode($encodedImg);
				$imgPath = '../../irsc/pics/tmpImgO'.$i.'.jpg';
				
				if( file_put_contents($imgPath,$decodedImg)!== false )
				{
					$pdf->Image($imgPath,0,20,216,250);
					
					if($i != count($ordpics)-1)
					{
						$pdf->SetFont('Arial','B', 11);
						$pdf->AddPage('P', 'Letter');
						$pdf->Ln(2);
						$halfCount = 0;
					}
					unlink($imgPath);
				}
			}
		
		}
		

		// ------------------------------------------------------------
		// ------------------------------------------------------------
		// ------------------------------------------------------------
		

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
                $sucu = str_replace("'","\\'", $info["f-repSucu"]);
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
                
                
                
                $str = "SELECT *  FROM receipts $where ORDER BY DATE DESC, NUM DESC LIMIT 50";
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
		
		$insumTotal = 0;
		$moveTechTotal = 0;
		$moveMaquiTotal = 0;
		
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
			
			$str = "SELECT SUM((UNIPRICE * UNIVALUE)+(UNICOSTMAT * UNIVALUE)) AS aTotal FROM oactis WHERE OCODE = '".$oList[$i]."'";
			$query = $this->db->query($str);
			
			// TOTAL ACTS
			if($query[0]["aTotal"] == null){$reg["tActis"] = 0;}else{$reg["tActis"] = $query[0]["aTotal"];}

			$str = "SELECT SUM(PCOST * PAMOUNT) AS rTotal FROM oparts  WHERE OCODE = '".$oList[$i]."'";
			$query = $this->db->query($str);
			
			// TOTAL REPS
			if($query[0]["rTotal"] == null){$reg["tReps"] = 0;}else{$reg["tReps"] = $query[0]["rTotal"];}
			
			// SUBSECCIONAR TOTALES DE OTROS POR TIPO----------------
			
			$str = "SELECT SUM(COST * AMOUNT) AS osubTotal FROM others  WHERE OCODE = '".$oList[$i]."'";
			$query = $this->db->query($str);
			
			// TOTAL OTHERS
			if($query[0]["osubTotal"] == null){$reg["tOthers"] = 0;}else{$reg["tOthers"] = $query[0]["osubTotal"];}
			
			// SUBSECCIONAR TOTALES DE OTROS POR TIPO----------------
			
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
			
			$str = "SELECT OTYPE, AMOUNT, COST  FROM others  WHERE OCODE = '".$oList[$i]."'";
			$othersList = $this->db->query($str);
			
			for($j=0; $j<count($othersList); $j++)
			{
				$item = $othersList[$j];
				
				if($item["OTYPE"] == "Insumos")
				{$insumTotal  += (floatval($item["COST"])*floatval($item["AMOUNT"]));}
				if($item["OTYPE"] == "Gastos de desplazamiento")
				{$moveTechTotal  += (floatval($item["COST"])*floatval($item["AMOUNT"]));}
				if($item["OTYPE"] == "Transporte equipos")
				{$moveMaquiTotal += (floatval($item["COST"])*floatval($item["AMOUNT"]));}
				
			}
		}
		
		
		
		
		$ansTotaled["actis"] = $actisTotal;
		$ansTotaled["repu"] = $repuTotal;
		$ansTotaled["othe"] = $otherTotal;
		$ansTotaled["iva"] = $ivaTotal;
		$ansTotaled["rete4"] = $rete4;
		$ansTotaled["rete25"] = $rete25;
		$ansTotaled["insumTotal"] = $insumTotal;
		$ansTotaled["moveTechTotal"] = $moveTechTotal;
		$ansTotaled["moveMaquiTotal"] = $moveMaquiTotal;
		
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
		
		// $ansTotaled["fullTotal"] = $ansTotaled["actis"] + $ansTotaled["repu"] + $ansTotaled["othe"] + $ansTotaled["iva"] - $ansTotaled["rete4"] - $ansTotaled["rete25"];
		$ansTotaled["fullTotal"] = $ansTotaled["actis"] + $ansTotaled["repu"] + $ansTotaled["othe"]+ $ansTotaled["iva"];
		
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
			$sucuCode = str_replace("'","\\'", $query[0]["SUCUCODE"]);
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

			// -----ORIGINAL PART ADDER----
			$str = "SELECT PDESC, PCOST, PAMOUNT FROM oparts WHERE OCODE = '".$ocode."'";
			$query = $this->db->query($str);
			
			$partList = $query;
			
			for($x=0; $x<count($partList);$x++)
			{
					$line = array();
					
					$order = $number;
					$desc = $partList[$x]["PDESC"]." - ".$sucuCode;
					$amount = $partList[$x]["PAMOUNT"];
					$cost = $partList[$x]["PCOST"];
					$subtotal = $amount * $cost;
					
					$line["ORDER"] = $order;
					$line["DESC"] = $desc;
					$line["AMOUNT"] = $amount;
					$line["COST"] = $cost;
					$line["SUBTOTAL"] = $subtotal;
					
					$fullist[] = $line;
			}
			// -----ORIGINAL PART ADDER----
			
			 // -----NEW PART ADDER----
			// $str = "SELECT PDESC, PCOST, PAMOUNT FROM oparts WHERE OCODE = '".$ocode."'";
			// $query = $this->db->query($str);
			
			// $partList = $query;
			
			// $pCostResume = 0;
			
			// for($x=0; $x<count($partList);$x++)
			// {
				// $line = array();
				
				// $order = $number;
				// $amount = $partList[$x]["PAMOUNT"];
				// $cost = $partList[$x]["PCOST"];
				// $subtotal = $amount * $cost;

				// $pCostResume = $pCostResume+$subtotal;
					
					
			// }
			
			// $line = array();
			
			// $line["ORDER"] = $order;
			// $line["DESC"] = "Resumen de repuestos";
			// $line["AMOUNT"] = 1;
			// $line["COST"] = $pCostResume;
			// $line["SUBTOTAL"] = $pCostResume;
			
			// $fullist[] = $line;

			
			// -----NEW PART ADDER----
			
			
			$str = "SELECT ODESC, COST, AMOUNT FROM others WHERE OCODE = '".$ocode."'";
			$query = $this->db->query($str);
			
			$otherList = $query;
			
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

		// ADD PAGE AND HEADERS ----------------

		// FILE START
		$pdf = new PDF_MC_Table();
		// COLWIDTHS

		$pdf->AddPage('P', 'Letter');
		
		$pdf->Image('../../irsc/freceipt'.$nuller.'.jpg',0,0,218,0,'','');
		$pdf->SetFont('Arial','B', 14);
		$pdf->SetFillColor(102,102,102);
		
		// H LINE 1
		$pdf->Cell(184,5,'',0,0,'C',false);
		$pdf->Cell(14,5,$fNum,0,0,'R',false);
		$pdf->SetFont('Arial','B', 8);
	   
		$pdf->Ln(11);
		
		$pdf->Cell(144,5,'',0,0,'C',false);
		$pdf->Cell(16,5,$date,0,0,'L',false);
		$pdf->Cell(19,5,'',0,0,'L',false);
		$pdf->Cell(16,5,$diedate,0,0,'L',false);
		
		$pdf->Ln(6);

		$pdf->Cell(10,5,'',0,0,'C',false);
		$pdf->Cell(53,5,utf8_decode($cData["CNAME"]),0,0,'L',false);
		$pdf->Cell(16,5,'',0,0,'C',false);
		
		$address = substr($cData["ADDRESS"],0,35);
		
		$pdf->Cell(55,5,utf8_decode($address),0,0,'L',false);
		$pdf->Cell(16,5,'',0,0,'C',false);
		$pdf->Cell(45,5,$cData["PHONE"],0,0,'L',false);
		
		$pdf->Ln(7);
		
		$pdf->Cell(10,5,'',0,0,'C',false);
		$pdf->Cell(53,5,$cData["NIT"],0,0,'L',false);
		$pdf->Cell(16,5,'',0,0,'C',false);
		$pdf->Cell(55,5,utf8_decode($cData["LOCATION"]),0,0,'L',false);
		$pdf->Cell(16,5,'',0,0,'C',false);
		$pdf->Cell(45,5,$cData["MAIL"],0,0,'L',false);
		
		$pdf->SetFillColor(102,102,102);
		$pdf->SetTextColor(255);
		$pdf->SetFont('Arial','B', 8);
		$w = array(30, 110, 14, 20, 20);
		$header = array('Orden', 'Detalle', 'Cantidad', 'Valor', 'Subtotal');
		
		$pdf->SetWidths($w);
		
		
		$pdf->Ln(2);
		$pdf->SetY(43);
		for($i=0;$i<count($header);$i++)
		{
			$pdf->Cell($w[$i],5,utf8_decode($header[$i]),1,0,'C',true);
		}

		$fill = false;
		
		// ADD PAGE AND HEADERS ----------------
		
		$pdf->SetFillColor(230,230,230);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','', 8);
		
		$pdf->Ln(5);
		
		// recData
		foreach($fullist as $row)
		{
			
			$align = array("C", "L", "C", "R", "R");
			
			$order = utf8_decode($row['ORDER']);
			$pdetail = utf8_decode($row['DESC']);
			$qty = $row['AMOUNT'];
			$univalp = '$'.number_format($row['COST']);
			$unival = $row['COST'];
			$subtotal = '$'.number_format(floatval($qty)*floatval($unival));
			
			$pdf->Row(array($order, $pdetail, $qty,$univalp, $subtotal), 1, $align);

			$fill = !$fill;
		}
		
		// lineClose
		$pdf->Cell(array_sum($w),0,'','T');
		
		$pdf->Ln(8);
		
		$rectotals = $recTotals["totaled"];
		
		$pdf->SetFont('Arial','B', 8);
                        
		// $pdf->SetY(-49);
		$pdf->Cell(100,5,"",0,0,'R',false);
		$pdf->Cell(60,5,"SUBTOTAL M.O.",1,0,'R',false);
		$pdf->Cell(36,5,'$'.number_format($rectotals["actis"]),1,0,'R',false);

		$pdf->Ln(5);

		$pdf->Cell(100,5,"",0,0,'R',false);
		$pdf->Cell(60,5,"SUBTOTAL MATERIALES/REPUESTOS",1,0,'R',false);
		$pdf->Cell(36,5,'$'.number_format($rectotals["repu"]),1,0,'R',false);

		$pdf->Ln(5);

		$pdf->Cell(100,5,"",0,0,'R',false);
		$pdf->Cell(60,5,"SUBTOTAL INSUMOS",1,0,'R',false);
		$pdf->Cell(36,5,'$'.number_format($rectotals["insumTotal"]),1,0,'R',false);

		$pdf->Ln(5);
		
		$pdf->Cell(100,5,"",0,0,'R',false);
		$pdf->Cell(60,5,"SUBTOTAL GASTOS DESPLAZAMIENTO",1,0,'R',false);
		$pdf->Cell(36,5,'$'.number_format($rectotals["moveTechTotal"]),1,0,'R',false);

		$pdf->Ln(5);
		
		$pdf->Cell(100,5,"",0,0,'R',false);
		$pdf->Cell(60,5,"SUBTOTAL TRANSPORTE DE EQUIPOS",1,0,'R',false);
		$pdf->Cell(36,5,'$'.number_format($rectotals["moveMaquiTotal"]),1,0,'R',false);
		
		$pdf->Ln(5);
		$pdf->Ln(5);
		
		$pdf->Cell(100,5,"",0,0,'R',false);
		$pdf->Cell(60,5,"VALOR PARCIAL",0,0,'R',false);
		$pdf->Cell(36,5,'$'.number_format($rectotals["fullTotal"]-$rectotals["iva"]),0,0,'R',false);
		
		
		$pdf->Ln(5);
		
		$pdf->Cell(100,5,"",0,0,'R',false);
		$pdf->Cell(60,5,"IVA",0,0,'R',false);
		$pdf->Cell(36,5,'$'.number_format($rectotals["iva"]),0,0,'R',false);

		$pdf->Ln(5);
		
		
		$pdf->SetFont('Arial','B', 10);
				
		$pdf->Cell(100,5,"",0,0,'R',false);
		$pdf->Cell(60,5,"VALOR TOTAL",0,0,'R',false);
		$pdf->Cell(36,5,'$'.number_format($rectotals["fullTotal"]),0,0,'R',false);
		
		$pdf->Ln(5);
		
		// $pdf->Cell(100,5,"",0,0,'R',false);
		// $pdf->Cell(60,5,"IVA",0,0,'R',false);
		// $pdf->Cell(36,5,'$'.number_format($rectotals["iva"]),0,0,'R',false);
		
		// $pdf->Ln(5);
		
		// $pdf->Cell(100,5,"",0,0,'R',false);
		// $pdf->Cell(60,5,"TOTAL",0,0,'R',false);
		// $pdf->Cell(36,5,'$'.number_format($rectotals["fullTotal"]+$rectotals["iva"]),0,0,'R',false);
		
                
		// $pdf->Cell($w[0],6, $pages ,'LR',0,'L',$fill);
		
		$dirname = $cData["CODE"]; 
		$filename = "../../receipts/".$cData["CODE"];  

		if (!file_exists($filename)){ mkdir("../../receipts/".$cData["CODE"], 0777);  } 
		
		// createFile
		$pdf->Output('../../receipts/'.$cData["CODE"].'/'.$resdata['RESOLUTION'].'-'.$fNum.'.pdf','F');
		
		$path = 'receipts/'.$cData["CODE"].'/'.$resdata['RESOLUTION'].'-'.$pathNum.'.pdf';
                
		if($nullnum != null)
		{
			// SET STATE 1 TO REDATE
			$str = "UPDATE receipts SET STATE = '0', DATE = '".$date ."', DIEDATE = '".$date."' WHERE NUM ='".$nullnum."' AND RESOLUTION = '".$nullres."'";
			$query = $this->db->query($str);
			
			
			for($i = 0; $i<count($picks); $i++)
			{
				// COMMENT TO REDATE
				$str = "UPDATE orders SET STATE = '4' WHERE CODE ='".$picks[$i]."'";
				$query = $this->db->query($str);
			}
		}
		else
		{
				
			$str = "INSERT INTO receipts (RESOLUTION, NUM, PARENTNAME, PARENTCODE, ORDERS, STATE, STATUS, DATE, DIEDATE, TOTAL, RETCHECK) VALUES ('".$resdata['RESOLUTION']."', '".$fNum."','".$cData["CNAME"]."','".$cData["CODE"]."','".$orders."','1', '1', '".$date."', '".$diedate."', '".$recTotals["totaled"]["fullTotal"]."', '".$retCheck."')";
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
                        $str = "SELECT CODE FROM orders WHERE CCODE = '".floatval($info["picks"][$i])."' AND PARENTCODE = '".$parent."'";
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
                        $str = "SELECT CODE FROM orders WHERE CCODE = '".floatval($info["picks"][$i])."' AND PARENTCODE = '".$parent."'";
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
			$email_from = 'comercial@sherbim.co';
			$email_message = 
			"<div style='text-align: center; margin: auto; width: 800px !important; background: #F0EDE8; border-radius: 15px;'>".
			"<img src='http://www.sherbim.co/app/irsc/pasRecHeader-".$language.".png' style='width=100% !important;'/>".
			"<br><br>".
			"<span style='font-size:14px; '>".$message."</span>".
			"<br>".
			"<span style='font-size:14px; font-weight: bold;'>"."<a href='http://www.sherbim.co/app/?me=".$userEmail."&tmpkey=".$tmpkey."&lang=".$language."&type=".$userType." '>".htmlentities($recLink)."</a>"."</span>".
			"<br><br>".
			"<img src='http://www.sherbim.co/app/irsc/footer-".$language.".png' style='width=100% !important;'/>".
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
		$header = "Mensaje desde Sherbim";
		
		$email_subject = $header;
		$email_from = $sucode;
		$email_message = "Mensaje Sherbim de: ".$spcname."<br><br><span style='font-size:14px; '>".$content."</span>";
		
		$headers = "From: " . $email_from . "\r\n";
		$headers .= "Reply-To: ". $email_from . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail ("comercial@sherbim.co", $email_subject, $email_message, $headers);

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
		function changeTechState($info)
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
                        
                        $str = "UPDATE inve SET AMOUNT = AMOUNT - '".floatval($amount)."' WHERE CODE ='".$code."'";
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
                        if($repoState != ""){$where .= "AND STATE =  '$repoState' ";} 
                        if($repoOrderNum != ""){$where .= "AND CCODE LIKE  '%$repoOrderNum%' ";} 
                        if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
                        if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 
						
						$where .= "AND STATE !=  '6'";
						
                        $str = "SELECT * FROM orders $where ORDER BY DATE DESC";
                        $orders = $this->db->query($str);
						
						for($i=0; $i<count($orders); $i++)
						{
							$item = $orders[$i];
							
							$dpkc = array();
							$dpkc["code"] = $item["CODE"];
							$ominutes = $this-> getOtime($dpkc)["message"];
							
							$orders[$i]["STIME"] = $ominutes;
							
						}
                        
                        $result = $orders;
						
						
						$now = new DateTime();
						$now = $now->format('Y-m-d');
						
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
						
						
						// HEADER TITLE
			
						if($repoIniDate != ""){$inidate = $repoIniDate;}
						else{$inidate = "Abierto";}
						
						if($repoEndDate != ""){$enddate = $repoEndDate;}
						else{$enddate = "Abierto";}
						
						$dateRange = "desde: " .$inidate. " hasta ". $enddate;
						
						
						$sheet->setCellValue('A1', 'Órdenes por estado ' . $dateRange);
						$sheet->getStyle("A1")->getFont()->setBold(true);
						$sheet->mergeCells('A1:N1');
						
						
						// TITLES LINE 1
			
						$c = 3;
						
						$sheet->getStyle("A$c:J$c")->getFont()->setSize(10);
						$sheet->getStyle("A$c:J$c")->getFont()->setBold(true);
						$sheet->getStyle("A$c:J$c")->applyFromArray($alignCenter);
						$sheet->getStyle("A$c:J$c")->applyFromArray($grayBg);
						
						$sheet->setCellValue("A$c", "OTT");
						$sheet->setCellValue("B$c", "CLIENTE");
						$sheet->setCellValue("C$c", "SUCURSAL");
						$sheet->setCellValue("D$c", "EQUIPOS");
						$sheet->setCellValue("E$c", "FECHA SOLICITUD");
						$sheet->setCellValue("F$c", "ESTADO");
						$sheet->setCellValue("G$c", "TÉCNICO");
						$sheet->setCellValue("H$c", "DETALLE");
						$sheet->setCellValue("I$c", "TIPO");
						$sheet->setCellValue("J$c", "OTCLIENTE");
						
						$c++;
						
						for($i = 0; $i<count($result);$i++)
						{
							$item = $result[$i];


							$sheet->setCellValue("A$c",  $item["CCODE"]);
							$sheet->setCellValue("B$c",  $item["PARENTNAME"]);
							$sheet->setCellValue("C$c",  $item["SUCUNAME"]);
							
							$maquis = json_decode($item["MAQUIS"]);
							
							$equipos = "";
							
							for($n = 0; $n<count($maquis);$n++)
							{
								$plate = $maquis[$n];
								
								$str = "SELECT PLATE, NAME FROM maquis WHERE CODE = '".$plate."'";
								$res = $this->db->query($str);
								
								if(count($res) > 0)
								{$name = "Nombre: ".$res[0]["NAME"]." Placa: ".$res[0]["PLATE"];}
								else
								{$name = "-";}
								
								if($n != count($maquis)-1){$equipos.=$name.", ";}
								else{$equipos.=$name;}
							}
							
							
							$sheet->setCellValue("D$c",  $equipos);
							$sheet->setCellValue("E$c",  $item["DATE"]);
							
							$state = "";
							
							if($item["STATE"] == "1"){$state = "Nueva";}
							if($item["STATE"] == "2"){$state = "Proceso";}
							if($item["STATE"] == "3"){$state = "Revisión";}
							if($item["STATE"] == "4"){$state = "Por facturar";}
							if($item["STATE"] == "5"){$state = "Facturada";}
							if($item["STATE"] == "6"){$state = "Anulada";}
							
							
							$sheet->setCellValue("F$c",  $state);
							$sheet->setCellValue("G$c",  $item["TECHNAME"]);
							$sheet->setCellValue("H$c",  $item["DETAIL"]);
							
							$otype = "";
							
							if($item["OTYPE"] == "1"){$otype = "General";}
							if($item["OTYPE"] == "2"){$otype = "Preventivo";}
							if($item["OTYPE"] == "3"){$otype = "Correctivo";}
							if($item["OTYPE"] == "4"){$otype = "Locativas";}
							if($item["OTYPE"] == "5"){$otype = "Otros";}
							
							$sheet->setCellValue("I$c",  $otype);
							$sheet->setCellValue("J$c",  $item["ICODE"]);

							$sheet->getStyle("A$c:J$c")->applyFromArray($borderB);
							$sheet->getStyle("A$c:J$c")->applyFromArray($alignLeft);
							$sheet->getStyle("A$c:J$c")->getFont()->setSize(9);
							
							$c++;
						}
						
						
						
						
						
						
						
						$fname = "Reporte de ordenes por estado ".$now.".xls";
						$path = "../../excel/".$fname;
						$hasFile = file_exists($path);
						if($hasFile == true){unlink($path);}
						$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
						$objWriter->save($path );
						$fname = htmlEntities(utf8_decode($fname));
						$resp["file"] = $fname ;
						
                }
                if($repoType == "ordersRIM")
                {
					$where = "WHERE  STATUS = '1' ";
					
					if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
					if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
					if($repoOrderNum != ""){$where .= "AND CCODE LIKE  '%$repoOrderNum%' ";} 
					if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
					if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 
					
					$where .= "AND STATE !=  '6'";
					
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
									if(count($query)>0)
									{
										$realCost = $query[0]["COST"];
									}
									else
									{
										continue;
									}
									
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
					$where = "WHERE  STATUS = '1' AND STATE != '6' ";
					
					if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
					if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
					if($repoTech != ""){$where .= "AND TECHNAME LIKE '%$repoTech%'";} 
					if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
					if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 

					$str = "SELECT * FROM orders $where ORDER BY DATE DESC";
					$orders = $this->db->query($str);
					
					for($i=0; $i<count($orders); $i++)
					{
						$item = $orders[$i];
						
						$dpkc = array();
						$dpkc["code"] = $item["CODE"];
						$ominutes = $this-> getOtime($dpkc)["message"];
						
						$orders[$i]["STIME"] = $ominutes;
						
					}
					
					$result = $orders;
                }
				if($repoType == "orderSessions")
                {
					$where = "WHERE  CODE != ''";
					
					// if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
					// if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
					if($repoTech != ""){$where .= "AND TECHNAME LIKE '%$repoTech%'";} 
					if($repoIniDate != ""){$where .= "AND INIDATE >=  '$repoIniDate' ";} 
					if($repoEndDate != ""){$where .= "AND ENDATE <=  '$repoEndDate' ";} 

					$str = "SELECT * FROM sessions $where ORDER BY INIDATE DESC";
					$sessions = $this->db->query($str);
					
					for($i=0; $i<count($sessions); $i++)
					{
						$item = $sessions[$i];
						
						$dpkc = array();
						$dpkc["code"] = $item["OCODE"];
						$odata = $this-> getOsessionData($dpkc)["message"];
						
						if($odata != "none")
						{
							$sessions[$i]["CCODE"] = $odata["CCODE"];
							$sessions[$i]["PARENTNAME"] = $odata["PARENTNAME"];
							$sessions[$i]["SUCUNAME"] = $odata["SUCUNAME"];
						}
						else
						{
							$sessions[$i]["CCODE"] = $item["OCODE"];
							$sessions[$i]["PARENTNAME"] = $item["OCODE"];
							$sessions[$i]["SUCUNAME"] = $item["OCODE"];
						}

					}
					
					$result = $sessions;
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
				if($repoType == "costmats")
                {
					$where = "WHERE  STATUS = '1' ";
					
					if($repoParent != ""){$where .= "AND PARENTCODE =  '$repoParent' ";} 
					if($repoSucu != ""){$where .= "AND SUCUCODE =  '$repoSucu' ";} 
					if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
					if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 
					if($repoTech != ""){$where .= "AND TECHNAME LIKE '%$repoTech%'";} 

					$str = "SELECT CODE, CCODE, PARENTNAME, SUCUNAME, ICODE, DATE, TECHNAME FROM orders $where ORDER BY DATE DESC";
					$query = $this->db->query($str);
					
					$oList = $query;
					$mainList = array();

					for($i=0; $i<count($oList); $i++)
					{
							
							// GET ACTIVITIES FOR TOTAL COSTS OF MO AND MAT
							$str = "SELECT * FROM oactis WHERE OCODE='".$oList[$i]["CODE"]."' ORDER BY DATE DESC";
							$query = $this->db->query($str);
							$aList = $query;
							
							$totalMO = 0;
							$totalMa = 0;

							for($j=0; $j<count($aList); $j++)
							{
								
								if($aList[$j]["UNIPRICE"] != "" and $aList[$j]["UNIPRICE"] != null)
								{
									$actiMoCost = $aList[$j]["UNIPRICE"];
								}
								else
								{
									$actiMoCost = 0;
								}
								
								if($aList[$j]["UNICOSTMAT"] != "" and $aList[$j]["UNICOSTMAT"] != null)
								{
									$actiMaCost = $aList[$j]["UNICOSTMAT"];
								}
								else
								{
									$actiMaCost = 0;
								}
								
								if($aList[$j]["UNIVALUE"] != "" and $aList[$j]["UNIVALUE"] != null)
								{
									$actiQty = $aList[$j]["UNIVALUE"];
								}
								else
								{
									$actiQty = 0;
								}
								
								
								
								
								
								
								
								$addMo = intval($actiMoCost*$actiQty);
								$addMa = intval($actiMaCost*$actiQty);
								
								$totalMO = $totalMO+$addMo;
								$totalMa = $totalMa+$addMa;
							}
							
							
							$techsList = array();
							
							// TECHS LIST
							if($oList[$i]["TECHNAME"] != "" and strpos($oList[$i]["TECHNAME"], "[") !== false)
							{
								$techsList = json_decode($oList[$i]["TECHNAME"], true);
							}
							else
							{
								continue;
							}
							
							
							
							// GET SESSIONS TIMES
							$str = "SELECT TECHNAME, INIDATE, ENDATE FROM sessions WHERE OCODE='".$oList[$i]["CODE"]."' ORDER BY TECHNAME ASC";
							$query = $this->db->query($str);
							$sList = $query;
							
							for($j=0; $j<count($sList); $j++)
							{
								$starT = $sList[$j]["INIDATE"];
								$endT = $sList[$j]["ENDATE"];
								$from_time = strtotime($starT); 
								$to_time = strtotime($endT); 
								$diff_minutes = round(abs($from_time - $to_time) / 60,2);
								$sList[$j]["TIMEMIN"] = $diff_minutes;
							}

							$techTimes = array();
							$oTotaTime = 0;
							
							for($j=0; $j<count($techsList); $j++)
							{
								$tName = $techsList[$j];
								
								if(!array_key_exists($tName, $techTimes))
								{
									for($n=0; $n<count($sList); $n++)
									{
										$tech = $sList[$n]["TECHNAME"];
										$time = $sList[$n]["TIMEMIN"];
										
										if(array_key_exists($tech, $techTimes))
										{
											$old = $techTimes[$tech];
											$new = $old + $time;
											$techTimes[$tech] = $new;
										}
										else
										{
											$techTimes[$tech] = $time;
										}
										$oTotaTime = $oTotaTime+$time;
									}
								}
								
								// GET TECH PERCENTAGE
								if(array_key_exists($tName, $techTimes))
								{
									$thisTechTotalTime = $techTimes[$tName];
									$thisTechPercent = ($thisTechTotalTime/$oTotaTime)*100;
								}
								else
								{
									$thisTechTotalTime = 0;
									$thisTechPercent = 0;
								}
								
								$thisTechMoValue = intval(($totalMO*$thisTechPercent)/100);
								
								
								// $oList[$i]["TECHTIMES"] = $techTimes;
								// $oList[$i]["TECHS"] = $techsList;
								// $oList[$i]["SESSIONS"] = $sList;
								// $oList[$i]["THISTECHPERCENT"] = $thisTechPercent;
								
								$oList[$i]["THISTECHMOVAL"] = $thisTechMoValue;
								$oList[$i]["THISTECHTIME"] = $thisTechTotalTime;
								$oList[$i]["OTOTALTIME"] = $oTotaTime;
								$oList[$i]["TECHLINENAME"] = $tName;
								$oList[$i]["TOTALMO"] = $totalMO;
								$oList[$i]["TOTALMA"] = $totalMa;
								
								if($j == 0)
								{
									$thisTechMaValue = $totalMa;
									$oList[$i]["THISTECHMAVAL"] = $thisTechMaValue;
								}
								else
								{
									$thisTechMaValue = 0;
									$oList[$i]["THISTECHMAVAL"] = $thisTechMaValue;
								}
								
								$mainList[] = $oList[$i];
								
							}
							
							
							
							
					}
					
					$result = $mainList;
					
					
					// $resp["message"] = $result ;
					// $resp["status"] = true;
					// return $resp;
					
					$now = new DateTime();
					$now = $now->format('Y-m-d');
					
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
					
					
					// HEADER TITLE
					
					$sheet->setCellValue('A1', 'Costos de Mano de obra y materiales por técnico por orden');
					$sheet->getStyle("A1")->getFont()->setBold(true);
					$sheet->mergeCells('A1:N1');
					
					
					// TITLES LINE 1
		
					$c = 3;
					
					$sheet->getStyle("A$c:J$c")->getFont()->setSize(10);
					$sheet->getStyle("A$c:J$c")->getFont()->setBold(true);
					$sheet->getStyle("A$c:J$c")->applyFromArray($alignCenter);
					$sheet->getStyle("A$c:J$c")->applyFromArray($grayBg);
					
					
					$sheet->setCellValue("A$c", "CLIENTE");
					$sheet->setCellValue("B$c", "SUCURSAL");
					$sheet->setCellValue("C$c", "OTT");
					$sheet->setCellValue("D$c", "FECHA SOLICITUD");
					$sheet->setCellValue("E$c", "TÉCNICO");
					$sheet->setCellValue("F$c", "COSTO MANO DE OBRA");
					$sheet->setCellValue("G$c", "COSTO MATERIALES");
					
					
					$c++;
					
					for($i = 0; $i<count($result);$i++)
					{
						$item = $result[$i];


						$sheet->setCellValue("A$c",  $item["PARENTNAME"]);
						$sheet->setCellValue("B$c",  $item["SUCUNAME"]);
						$sheet->setCellValue("C$c",  $item["CCODE"]);
						$sheet->setCellValue("D$c",  $item["DATE"]);
						$sheet->setCellValue("E$c",  $item["TECHLINENAME"]);
						$sheet->setCellValue("F$c",  $item["THISTECHMOVAL"]);
						$sheet->setCellValue("G$c",  $item["THISTECHMAVAL"]);
						


						$sheet->getStyle("A$c:G$c")->applyFromArray($borderB);
						$sheet->getStyle("A$c:G$c")->applyFromArray($alignLeft);
						$sheet->getStyle("A$c:G$c")->getFont()->setSize(9);
						
						$c++;
					}
					
					
					
					
					
					
					
					$fname = "Reporte de costo de materiales y mano de obra ".$now.".xls";
					$path = "../../excel/".$fname;
					$hasFile = file_exists($path);
					if($hasFile == true){unlink($path);}
					$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
					$objWriter->save($path );
					$fname = htmlEntities(utf8_decode($fname));
					$resp["file"] = $fname ;
					
					
					
					
					
					
					
					
					
					
					
					
					
                }

                $resp["message"] = $result ;
                $resp["status"] = true;
                return $resp;
        }
		function getOtime($info)
		{
			$code = $info["code"];
			
			$mins = 0;
			
			$str = "SELECT *  FROM sessions WHERE OCODE = '".$code."'";
			$query = $this->db->query($str);
			
			for($j=0; $j<count($query); $j++)
			{
				$sitem = $query[$j];
				$ini = new DateTime($sitem["INIDATE"]);
				$end = new DateTime($sitem["ENDATE"]);
				
				$gap = $ini->diff($end);
				
				$minutes = $gap->days * 24 * 60;
				$minutes += $gap->h * 60;
				$minutes += $gap->i;
				$mins += $minutes;
			}
			
			$ans = $mins;
			if(count($query) > 0)
			{
				$inidate = $query[0]["INIDATE"];
			}
			else
			{
				$inidate = "Sin sesiones";
			}
			
			
			$resp["message"] = $ans;
			$resp["inidate"] = $inidate;
			$resp["status"] = true;
			return $resp;
		}
		function getOsessionData($info)
		{
			$code = $info["code"];
			
			$str = "SELECT CCODE, PARENTNAME, SUCUNAME  FROM orders WHERE CODE = '".$code."'";
			$query = $this->db->query($str);
			
			if(count($query) > 0)
			{
				$ans = $query[0];
			}
			else
			{
				$ans = "none";
			}
			
			
			
			$resp["message"] = $ans;
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
		
		$cbid = $info["cbid"];
		$lang = $info["lang"];

		$langFile = parse_ini_file("../../lang/lang.ini", true);
		$lang = $langFile[$lang];
		
		$lastMove = array();
		$lastMove["G"] = $lang["lastMoveG"];
		$lastMove["T"] = $lang["lastMoveT"];
		$lastMove["A"] = $lang["lastMoveA"];
		$lastMove["R"] = $lang["lastMoveR"];
		$lastMove["X"] = $lang["lastMoveX"];
		
		
		$str = "SELECT BID, LASTOP, LASTYPE, AMOUNT FROM userTotals WHERE CBID = '".$cbid."'";
		$query = $this->db->query($str);	
		
		$extraData = $query;
		
		if(count($query) == 0)
		{
			$uList = array();
			$resp["message"] = "none";
			$resp["status"] = true;
			return $resp;
		}
		if(count($query) == 1)
		{
			$str = "SELECT RESPNAME, BMAIL, users.BID, BPHONE, BADDRESS, CNAME FROM users WHERE UCODE = '".$query[0]["BID"]."' ORDER BY RESPNAME ASC";
			$uList = $this->db->query($str);	
		}
		if(count($query) > 1)
		{
			$where = "users.BID = '".$query[0]["BID"]."'";
			
			for($i=1; $i<count($query);$i++)
			{
				$where.=" OR users.BID = '".$query[$i]["BID"]."'";
			}

			$str = "SELECT RESPNAME, BMAIL, users.BID, BPHONE, BADDRESS, CNAME FROM  users WHERE ".$where." ORDER BY RESPNAME ASC";
			$uList = $this->db->query($str);	
			
			// MERGE ULIST WITH EXTRADATA
			
			for($i = 0; $i< count($extraData); $i++)
			{
				for($j = 0; $j < count($uList); $j++)
				{
					if($uList[$j]["BID"] == $extraData[$i]["BID"])
					{
						$uList[$j]["LASTOP"] = $extraData[$i]["LASTOP"];
						$uList[$j]["AMOUNT"] = $extraData[$i]["AMOUNT"];
						$type = $extraData[$i]["LASTYPE"];
						$uList[$j]["LASTYPE"] = $lastMove[$type];
					}
				}
			}
	
		}
		
		$tName = utf8_decode($lang["repUName"]);
		$tMail = utf8_decode($lang["regUMail"]);
		$tBid = utf8_decode($lang["regBid"]);
		$tPhone = utf8_decode($lang["regUphone"]);
		$tAddress = utf8_decode($lang["regAddress"]);
		$tStore = utf8_decode($lang["repCName"]);
		$tAmount = utf8_decode($lang["actualAmount"]);
		$tLastMove = utf8_decode($lang["lastMove"]);
		$lastType = utf8_decode($lang["lastType"]);
		
		$csvString = $tName.";".$tMail.";".$tPhone.";".$tAddress.";".$tStore.";".$tAmount.";".$tLastMove.";".$lastType."\n";

		for($i = 0; $i<count($uList);$i++)
		{
			$a = utf8_decode(urldecode($uList[$i]["RESPNAME"]));
			$b = utf8_decode($uList[$i]["BMAIL"]);
			$c = utf8_decode($uList[$i]["BPHONE"]);
			$d = utf8_decode($uList[$i]["BADDRESS"]);
			$e = utf8_decode(urldecode($uList[$i]["CNAME"]));
			$f = utf8_decode(urldecode($uList[$i]["AMOUNT"]));
			$g = utf8_decode(urldecode($uList[$i]["LASTOP"]));
			$h= utf8_decode(urldecode($uList[$i]["LASTYPE"]));

			$csvString .= "\"$a\";\"$b\";\"$c\";\"$d\";\"$e\";\"$f\";\"$g\";\"$h\" \n";

		}

		file_put_contents("../cdb/".$cbid."- clients.csv", $csvString);

		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
	}


}

?>
