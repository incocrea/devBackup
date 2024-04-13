<?php

date_default_timezone_set('America/Bogota');
require('phpExcel/Classes/PHPExcel.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
		
		$resp["message"] = $answer;
		$resp["status"] = true; 
		return $resp;
		
	}
	function login($info)
	{
		
		$str = "SELECT * FROM ct_trusers WHERE USER_EMAIL = '".$info["email"]."' AND USER_PASS = '".md5($info["pssw"])."'";
		$query = $this->db->query($str);	
		
		$now = new DateTime();
		$now = $now->format('Y-m-d');
		
		if(count($query) > 0)
		{
			// CHECK USER STATUS
			if($query[0]["USER_STATUS"] == "0")
			{
				$resp["message"] = "Disabled";
				$resp["status"] = true;
				return $resp;
			}
			
			$ucode = $query[0]["USER_CODE"];
			$userType = $query[0]["USER_TYPE"];
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
			
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
	function logout($info)
	{
		// ------------------LOGSAVE-----------------
		$logSave = $this->logw($info);
		// ------------------LOGSAVE-----------------
		$ans = "out";
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function rlAud($info)
	{
		$code = $info["c"];
		$str = "SELECT * FROM ct_trusers WHERE USER_CODE = '$code'";
		$query = $this->db->query($str);
		
		$now = new DateTime();
		$now = $now->format('Y-m-d');
		
		if(count($query) > 0)
		{
			// CHECK USER STATUS
			if($query[0]["USER_STATUS"] == "0")
			{
				$resp["message"] = "Disabled";
				$resp["status"] = true;
				return $resp;
			}
			
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
		$iface = $info["iface"];
		$ucode = $info["ucode"];
		return;
		
		$str = "INSERT INTO wp_log (DATE, MT, UCODE, IFACE) VALUES ('".$now."', '".$mt."', '".$ucode."', '".$iface."')";
		$query = $this->db->query($str);
		return;
	}
	function saveUdata($info)
	{
		$USER_TYPE = $info["USER_TYPE"];
		$USER_NAME = str_replace("'","\\'",$info["USER_NAME"]);
		$USER_PHONE = $info["USER_PHONE"];
		$USER_EMAIL = $info["USER_EMAIL"];
		$USER_PASS = md5($info["USER_PASS"]);
		$USER_PASS2 = $info["USER_PASS2"];
		$MODE = $info["MODE"];
		
		$str = "SELECT USER_EMAIL FROM ct_trusers WHERE USER_EMAIL = '".$USER_EMAIL."'";
		$query = $this->db->query($str);

		if($info["USER_CODE"] != "")
		{
			if($MODE == "0")
			{
				if(count($query)>0)
				{
					$resp["message"] = "exists";
					return $resp;
				}
			}
			else
			{
				$USER_CODE = $info["USER_CODE"];
				if($info["CHANGEPASS"] == "1")
				{
					$str = "UPDATE ct_trusers SET 
					USER_NAME = '".$USER_NAME."',
					USER_PHONE = '".$USER_PHONE."',
					USER_PASS = '".$USER_PASS."'
					WHERE 
					USER_CODE ='".$USER_CODE."'";
					$resp["message"] = "updatedpc";
					$info["ucode"] = $USER_CODE;
				}
				else
				{
					$str = "UPDATE ct_trusers SET 
					USER_NAME = '".$USER_NAME."',
					USER_PHONE = '".$USER_PHONE."'
					WHERE 
					USER_CODE ='".$USER_CODE."'";
					$resp["message"] = "updatednpc";
				}
				
				$query = $this->db->query($str);

				// ------------------LOGSAVE-----------------
				$logSave = $this->logw($info);
				// ------------------LOGSAVE-----------------
								
				return $resp;
			}
		}
		else
		{
			
			if(count($query)>0)
			{
				$resp["message"] = "exists";
				return $resp;
			}
			
			$now = new DateTime();
			$now = $now->format('Y-m-d');
			$USER_CODE = md5($USER_EMAIL.$now);
			$USER_REGDATE = $now;
			
			$str = "INSERT INTO ct_trusers (
			USER_CODE,
			USER_TYPE,
			USER_NAME,
			USER_PHONE,
			USER_EMAIL,
			USER_PASS,
			USER_REGDATE) VALUES (
			'".$USER_CODE."',
			'".$USER_TYPE."',
			'".$USER_NAME."',
			'".$USER_PHONE."',
			'".$USER_EMAIL."',
			'".$USER_PASS."',
			'".$USER_REGDATE."'
			)";
			$query = $this->db->query($str);
	
			$resp["message"] = "created";
			$resp["status"] = true;
			$info["ucode"] = $USER_CODE;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}
		
		
		return $resp;
		
	}
	function saveBudget($info)
	{

		$BUDGET_CODE = $info["BUDGET_CODE"];
		$BUDGET_NAME = $info["BUDGET_NAME"];
		$BUDGET_USER = $info["BUDGET_USER"];


		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT BUDGET_CODE FROM ct_budgets WHERE BUDGET_NAME = '".$BUDGET_NAME."'";
		$query = $this->db->query($str);
		if(count($query) > 0)
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{

			$str = "UPDATE ct_budgets SET 
			BUDGET_NAME = '".$BUDGET_NAME."'
			WHERE 
			BUDGET_CODE ='".$BUDGET_CODE."'";

			$resp["message"] = "updated";
			
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
			
			return $resp;
			
		}
		else
		{
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			$BUDGET_CODE = md5($BUDGET_NAME.$now);
			
			$str = "INSERT INTO ct_budgets (
			BUDGET_NAME,
			BUDGET_USER,
			BUDGET_CODE) VALUES (
			'".$BUDGET_NAME."',
			'".$BUDGET_USER."',
			'".$BUDGET_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = $BUDGET_CODE;
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveQuote ($info)
	{

		$QUOTE_NAME = $info["QUOTE_NAME"];
		$QUOTE_USER = $info["QUOTE_USER"];
		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT QUOTE_CODE FROM ct_quotes WHERE QUOTE_NAME = '".$QUOTE_NAME."'";
		$query = $this->db->query($str);
		if(count($query) > 0)
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{

			$str = "UPDATE ct_quotes SET 
			QUOTE_NAME = '".$QUOTE_NAME."'
			WHERE 
			QUOTE_CODE ='".$QUOTE_CODE."'";

			$resp["message"] = "updated";
			
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
			
			return $resp;
			
		}
		else
		{
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			$QUOTE_CODE = md5($QUOTE_NAME.$now);
			
			$str = "INSERT INTO ct_quotes (
			QUOTE_NAME,
			QUOTE_USER,
			QUOTE_CODE) VALUES (
			'".$QUOTE_NAME."',
			'".$QUOTE_USER."',
			'".$QUOTE_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = $QUOTE_CODE;
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveCategory($info)
	{

		$CATEGORY_CODE = $info["CATEGORY_CODE"];
		$CATEGORY_NAME = $info["CATEGORY_NAME"];
		$CATEGORY_USER = $info["CATEGORY_USER"];


		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT CATEGORY_CODE FROM ct_categories WHERE CATEGORY_NAME = '".$CATEGORY_NAME."' AND CATEGORY_CODE != '".$CATEGORY_CODE."'";
		$query = $this->db->query($str);
		if(count($query) > 0)
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{

			$str = "UPDATE ct_categories SET 
			CATEGORY_NAME = '".$CATEGORY_NAME."'
			WHERE 
			CATEGORY_CODE ='".$CATEGORY_CODE."'";
			$query = $this->db->query($str);
			
			$str = "UPDATE ct_items SET 
			ITEM_CATEGORY_NAME = '".$CATEGORY_NAME."'
			WHERE 
			ITEM_CATEGORY ='".$CATEGORY_CODE."'";
			$query = $this->db->query($str);
			
			
			$resp["message"] = "updated";
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
			
			return $resp;
			
		}
		else
		{
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			$CATEGORY_CODE = md5($CATEGORY_NAME.$now);
			
			$str = "INSERT INTO ct_categories (
			CATEGORY_NAME,
			CATEGORY_USER,
			CATEGORY_CODE) VALUES (
			'".$CATEGORY_NAME."',
			'".$CATEGORY_USER."',
			'".$CATEGORY_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = $CATEGORY_CODE;
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveItem($info)
	{

		$ITEM_CODE = $info["ITEM_CODE"];
		$ITEM_BUDGET = $info["ITEM_BUDGET"];
		$ITEM_CATEGORY = $info["ITEM_CATEGORY"];
		$ITEM_CATEGORY_NAME = $info["ITEM_CATEGORY_NAME"];
		$ITEM_ACTIVITY = $info["ITEM_ACTIVITY"];
		$ITEM_UNIT = $info["ITEM_UNIT"];
		$ITEM_QTY = $info["ITEM_QTY"];
		$ITEM_UNIT_VALUE = $info["ITEM_UNIT_VALUE"];
		$ITEM_DETAILS = str_replace("'","\\'", $info["ITEM_DETAILS"]);
		$ITEM_DETAILS = str_replace('/', '_', $ITEM_DETAILS);
		$ITEM_PIC = $info["ITEM_PIC"];
		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT ITEM_CODE FROM ct_items WHERE ITEM_ACTIVITY = '".$ITEM_ACTIVITY."' AND ITEM_CODE != '".$ITEM_CODE."' AND ITEM_BUDGET = '".$ITEM_BUDGET."'";
		$query = $this->db->query($str);
		if(count($query) > 0)
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{
			
			if($ITEM_PIC != "" and $ITEM_PIC != "1")
			{
				$str = "UPDATE ct_items SET 
				ITEM_BUDGET = '".$ITEM_BUDGET."',
				ITEM_CATEGORY = '".$ITEM_CATEGORY."',
				ITEM_CATEGORY_NAME = '".$ITEM_CATEGORY_NAME."',
				ITEM_ACTIVITY = '".$ITEM_ACTIVITY."',
				ITEM_UNIT = '".$ITEM_UNIT."',
				ITEM_QTY = '".$ITEM_QTY."',
				ITEM_UNIT_VALUE = '".$ITEM_UNIT_VALUE."',
				ITEM_DETAILS = '".$ITEM_DETAILS."',
				ITEM_PIC = '".$ITEM_PIC."'
				WHERE 
				ITEM_CODE ='".$ITEM_CODE."'";
			}
			else
			{
				$str = "UPDATE ct_items SET 
				ITEM_BUDGET = '".$ITEM_BUDGET."',
				ITEM_CATEGORY = '".$ITEM_CATEGORY."',
				ITEM_CATEGORY_NAME = '".$ITEM_CATEGORY_NAME."',
				ITEM_ACTIVITY = '".$ITEM_ACTIVITY."',
				ITEM_UNIT = '".$ITEM_UNIT."',
				ITEM_QTY = '".$ITEM_QTY."',
				ITEM_UNIT_VALUE = '".$ITEM_UNIT_VALUE."',
				ITEM_DETAILS = '".$ITEM_DETAILS."'
				WHERE 
				ITEM_CODE ='".$ITEM_CODE."'";
			}
			
			
			
			$resp["message"] = "updated";
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
			
			return $resp;
			
		}
		else
		{
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			$ITEM_CODE = md5($ITEM_ACTIVITY.$now);
			
			$str = "INSERT INTO ct_items (
			ITEM_BUDGET,
			ITEM_CATEGORY,
			ITEM_CATEGORY_NAME,
			ITEM_ACTIVITY,
			ITEM_UNIT,
			ITEM_QTY,
			ITEM_UNIT_VALUE,
			ITEM_DETAILS,
			ITEM_PIC,
			ITEM_CODE) VALUES (
			'".$ITEM_BUDGET."',
			'".$ITEM_CATEGORY."',
			'".$ITEM_CATEGORY_NAME."',
			'".$ITEM_ACTIVITY."',
			'".$ITEM_UNIT."',
			'".$ITEM_QTY."',
			'".$ITEM_UNIT_VALUE."',
			'".$ITEM_DETAILS."',
			'".$ITEM_PIC."',
			'".$ITEM_CODE."'
			)";
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
			
			$resp["message"] = "Created";
			$resp["status"] = true;
		}

		return $resp;
		
	}
	function updateFromLine($info)
	{
		$FIELD = $info["FIELD"];
		$NEW = $info["NEW"];
		$TABLE = $info["TABLE"];
		$KEY = $info["KEY"];
		$CODE = $info["CODE"];
		
		if($FIELD == "ITEM_UNIT_VALUE")
		{
			$str = "UPDATE $TABLE SET $FIELD = '".$NEW."', ITEM_QUOTE_ITEM = '' WHERE $KEY = '$CODE'";
		}
		else
		{
			$str = "UPDATE $TABLE SET $FIELD = '".$NEW."' WHERE $KEY = '$CODE'";
		}
		
		
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getUserMasters($info)
	{
		$USER_CODE = $info["USER_CODE"];
		$USER_EMAIL = $info["USER_EMAIL"];
		
		$ans = array();
		
		$str = "SELECT BUDGET_CODE, BUDGET_NAME, BUDGET_INVITED, BUDGET_USER FROM ct_budgets WHERE 
		BUDGET_USER = '".$USER_CODE."' OR BUDGET_INVITED LIKE '%$USER_EMAIL%'";
		$budgets = $this->db->query($str);
		
		$ans["budgets"] = $budgets;
		
		$str = "SELECT CATEGORY_CODE, CATEGORY_NAME FROM ct_categories WHERE 
		CATEGORY_USER = '".$USER_CODE."' OR CATEGORY_INVITED LIKE '%$USER_EMAIL%' ORDER BY CATEGORY_NAME ASC";
		$categories = $this->db->query($str);

		$ans["categories"] = $categories;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getQuoteMasters($info)
	{
		$USER_CODE = $info["USER_CODE"];
		$USER_EMAIL = $info["USER_EMAIL"];
		
		$ans = array();
		
		$str = "SELECT QUOTE_CODE, QUOTE_NAME, QUOTE_USER FROM ct_quotes WHERE 
		QUOTE_USER = '".$USER_CODE."'";
		$quotes = $this->db->query($str);
		
		$ans["quotes"] = $quotes;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getQuoteList($info)
	{
		$QUOTE_USER = $info["QUOTE_USER"];
		
		$str = "SELECT QUOTE_CODE, QUOTE_NAME FROM ct_quotes WHERE 
		QUOTE_USER = '".$QUOTE_USER."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function addToQuote($info)
	{
		$QUOTE_CODE = $info["QUOTE_CODE"];
		$QUOTE_ORIGINAL_CODE = $info["QUOTE_ORIGINAL_CODE"];


		$str = "SELECT QUOTE_ITEM_CODE FROM ct_quote_items WHERE 
		QUOTE_CODE = '".$QUOTE_CODE."' AND QUOTE_ORIGINAL_CODE = '".$QUOTE_ORIGINAL_CODE."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$resp["message"] = "Exists";
			$resp["status"] = true;
			return $resp;
		}
				
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$QUOTE_ITEM_CODE = md5($now.$QUOTE_ORIGINAL_CODE);
		
		
		$str = "INSERT INTO ct_quote_items (QUOTE_ITEM_CODE, QUOTE_CODE, QUOTE_ORIGINAL_CODE) VALUES ('".$QUOTE_ITEM_CODE."','".$QUOTE_CODE."','".$QUOTE_ORIGINAL_CODE."')";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = "Created";
		$resp["status"] = true;
		return $resp;
	}
	function updateCosts($info)
	{
		$BUDGET_CODE = $info["BUDGET_CODE"];
		$BUDGET_ADMINISTRATION = $info["BUDGET_ADMINISTRATION"];
		$BUDGET_IMPREVIST = $info["BUDGET_IMPREVIST"];
		$BUDGET_UTILITY = $info["BUDGET_UTILITY"];
		$BUDGET_UTILITY_TAX = $info["BUDGET_UTILITY_TAX"];
		
		$str = "UPDATE ct_budgets SET 
		BUDGET_ADMINISTRATION = '".$BUDGET_ADMINISTRATION."',
		BUDGET_IMPREVIST = '".$BUDGET_IMPREVIST."',
		BUDGET_UTILITY = '".$BUDGET_UTILITY."',
		BUDGET_UTILITY_TAX = '".$BUDGET_UTILITY_TAX."'
		WHERE 
		BUDGET_CODE ='".$BUDGET_CODE."'";
		$query = $this->db->query($str);
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveInvited($info)
	{
		$BUDGET_CODE = $info["BUDGET_CODE"];
		$BUDGET_INVITED = $info["BUDGET_INVITED"];
		
		$str = "UPDATE ct_budgets SET 
		BUDGET_INVITED = '".$BUDGET_INVITED."'
		WHERE 
		BUDGET_CODE ='".$BUDGET_CODE."'";
		$query = $this->db->query($str);
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function pickPrice($info)
	{
		$NEW_PRICE = $info["NEW_PRICE"];
		$QUOTE_ITEM_CODE = $info["QUOTE_ITEM_CODE"];
		$ITEM_CODE = $info["ITEM_CODE"];
		$str = "UPDATE ct_items SET ITEM_QUOTE_ITEM = '".$QUOTE_ITEM_CODE."', ITEM_UNIT_VALUE = '".$NEW_PRICE."' WHERE ITEM_CODE ='".$ITEM_CODE."'";
		$query = $this->db->query($str);
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// SAVE CITIZEN ASSSIST
	function saveCitizenAssist($info)
	{
		$CLASS_CODE = $info["CLASS_CODE"];
		$CITIZEN_ASSIST_LIST = $info["CITIZEN_ASSIST"];
		$CLASS_DATE = $info["CLASS_DATE"];
		$CLASS_INI = $info["CLASS_INI"];
		$CLASS_END = $info["CLASS_END"];
		
		$duplicatedGuys = array();
		
		$str = "SELECT CLASS_CITIZENS FROM wp_classes WHERE CLASS_CODE = '".$CLASS_CODE."'";
		$citizens = $this->db->query($str)[0]["CLASS_CITIZENS"];
		$citizens = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($citizens));
		
		$actualCitizens = json_decode($citizens, true);
		
		for($c=0; $c<count($CITIZEN_ASSIST_LIST); $c++)
		{
			$guy = $CITIZEN_ASSIST_LIST[$c];
			$CITIZEN_IDNUM = $guy["CITIZEN_IDNUM"];
			$CITIZEN_ASSIST = $guy["CITIZEN_ASSIST"];

			if($CITIZEN_ASSIST == "1")
			{
				// MARK ASSIST
				$newState = "1";
				$str = "SELECT CLASS_HOUR, CLASS_CITIZENS FROM wp_classes WHERE 
				CLASS_DATE = '".$CLASS_DATE."'";
				$todayClasses = $this->db->query($str);
				
				// GET SIMULTANEOUS CLASSES
				$simultaneous = array();
				for($i=0; $i<count($todayClasses); $i++)
				{
					$add = 1;
					
					$class = $todayClasses[$i];
					$hours = json_decode($class["CLASS_HOUR"], true);
					$classIni = $hours["GROUP_TIME_INI"];
					$classEnd = $hours["GROUP_TIME_END"];
				
					// IF INI HOUR INSIDE RANGE
					if($CLASS_INI > $classIni and $CLASS_INI < $classEnd)
					{$add = 0;}
					// IF END HOUR INSIDE RANGE
					if($CLASS_END > $classIni and $CLASS_END < $classEnd)
					{$add = 0;}
					// IF REG INI INSIDE RANGE
					if($classIni > $CLASS_INI and $classIni < $CLASS_END)
					{$add = 0;}
					// IF REG END INSIDE RANGE
					if($classEnd > $CLASS_INI and $classEnd < $CLASS_END)
					{$add = 0;}
					if($add == 0)
					{array_push($simultaneous, $class);}
				}
				
				$mark = 1;
				
				// VERIFY CITIZEN ASSIST ON SIMULTANEOUS
				for($i=0; $i<count($simultaneous); $i++)
				{
					$class = $simultaneous[$i];
					$citizens = $class["CLASS_CITIZENS"];
					
					if($citizens != "" and $citizens != null and $citizens != "null")
					{
						
						$citizens = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($citizens));
						$citizens = json_decode($citizens, true);
					}
					else
					{
						$citizens = array();
					}
					
					for($n=0; $n<count($citizens); $n++)
					{
						$citizen = $citizens[$n];
						$idnum = $citizen["CITIZEN_IDNUM"];
						$assist = $citizen["CITIZEN_ASSIST"];
						
						if($idnum == $CITIZEN_IDNUM and $assist == "1")
						{
							$mark = 0;
							
							$busted = array();
							$busted["CLASS"] = $class;
							$busted["GUY"] = $guy;
							array_push($duplicatedGuys, $busted);
						}
					}
				}
				
				if($mark == 1)
				{
					for($n=0; $n<count($actualCitizens); $n++)
					{
						$citizen = $actualCitizens[$n];
						$idnum = $citizen["CITIZEN_IDNUM"];

						if($idnum == $CITIZEN_IDNUM)
						{$actualCitizens[$n]["CITIZEN_ASSIST"] = $newState;}
					}
				}
				
				
			}
			else
			{
				// DELETE ASSIST
				$newState = "0";

				for($n=0; $n<count($actualCitizens); $n++)
				{
					$citizen = $actualCitizens[$n];
					$idnum = $citizen["CITIZEN_IDNUM"];

					if($idnum == $CITIZEN_IDNUM)
					{$actualCitizens[$n]["CITIZEN_ASSIST"] = $newState;}
				}
			}
		}
		
		$actualCitizens = json_encode($actualCitizens);
		$str = "UPDATE wp_classes SET 
		CLASS_CITIZENS = '".$actualCitizens."'
		WHERE 
		CLASS_CODE ='".$CLASS_CODE."'";
		$query = $this->db->query($str);
		
		
		if(count($duplicatedGuys) > 0)
		{
			$resp["message"] = $duplicatedGuys;
		}
		else
		{
			$resp["message"] = "allCool";
		}
		
		$resp["status"] = true;
		return $resp;

	}
	
	// LIST REFRESHER
	function refreshTable($info)
	{
		$FILTERS = $info["FILTERS"];
		$TABLE = $info["TABLE"];
		$INDEX = $info["INDEX"];
		$ORDER = $info["ORDER"];
		$EXPORT = $info["EXPORT"];
		$ucode = $info["ucode"];
		
		$LIMIT = 2000;
		$FIELDS = " * ";

		$where = "WHERE  $INDEX != 'null' ";
		
		if($TABLE == "ct_items")
		{
			$BUDGET_LIST = $FILTERS["BUDGET_LIST"];
			
			if($BUDGET_LIST != ""){$where .= "AND ITEM_BUDGET = '$BUDGET_LIST'";}
			else
			{
				$resp["message"] = array();
				$resp["status"] = true;
				return $resp;
			}
						
			$str = "SELECT * FROM ct_budgets WHERE BUDGET_CODE = '".$BUDGET_LIST."'";
			$bData = $this->db->query($str)[0];
			$resp["bData"] = $bData;
			
			
			$FIELDS = "
			ITEM_CODE,
			ITEM_BUDGET,
			ITEM_CATEGORY,
			ITEM_CATEGORY_NAME,
			ITEM_ACTIVITY,
			ITEM_UNIT,
			ITEM_QTY,
			ITEM_UNIT_VALUE,
			ITEM_DETAILS,
			ITEM_QUOTE_ITEM,
			ITEM_PIC";
		}
		if($TABLE == "ct_quote_items")
		{
			$QUOTE_LIST = $FILTERS["QUOTE_LIST"];
			
			if($QUOTE_LIST != ""){$where .= "AND QUOTE_CODE = '$QUOTE_LIST'";}
			else
			{
				$resp["message"] = array();
				$resp["status"] = true;
				return $resp;
			}

			$FIELDS = "
			QUOTE_ITEM_CODE,
			QUOTE_CODE,
			QUOTE_ORIGINAL_CODE,
			QUOTE_UNIT_VALUE,
			QUOTE_PIC";
		}
		if($TABLE == "ct_categories")
		{
			$USER_CODE_F = $FILTERS["USER_CODE_F"];
			$USER_EMAIL_F = $FILTERS["USER_EMAIL_F"];
			
			if($USER_CODE_F != "")
			{
				$where .= " AND CATEGORY_USER = '$USER_CODE_F' ";
				$where .= " OR CATEGORY_INVITED LIKE '%$USER_EMAIL_F%' ";
			}
			
		}
		if($TABLE == "wp_log")
		{
			$LOG_DATE_INI_F = $FILTERS["LOG_DATE_INI_F"];
			$LOG_DATE_END_F = $FILTERS["LOG_DATE_END_F"];
			$LOG_IFACE = $FILTERS["LOG_IFACE"];
			$LOG_MT = $FILTERS["LOG_MT"];
			
			if($LOG_DATE_INI_F != ""){$where .= "AND DATE >= '$LOG_DATE_INI_F'";} 
			if($LOG_DATE_END_F != ""){$where .= "AND DATE <= '$LOG_DATE_END_F'";} 
			if($LOG_IFACE != ""){$where .= "AND IFACE LIKE '%$LOG_IFACE%'";}
			if($LOG_MT != ""){$where .= "AND MT LIKE '%$LOG_MT%'";}
			
			$LOG_ENTITY = $FILTERS["LOG_ENTITY"];
			
			if($LOG_ENTITY != "")
			{
				$str = "SELECT ENTITY_CODE FROM wp_entities WHERE ENTITY_NAME LIKE '%".$LOG_ENTITY."%'";
				$matchCodes = $this->db->query($str);

				if(count($matchCodes) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($matchCodes); $i++)
					{
						$matchCode = $matchCodes[$i]["ENTITY_CODE"];
						$where .= "ENTITY LIKE '%".$matchCode."%'";
						if($i != count($matchCodes) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				else
				{
					$where .= "AND ENTITY LIKE '%$LOG_ENTITY%'";
				}
				
			} 
			
			$LOG_USER = $FILTERS["LOG_USER"];
			
			if($LOG_USER != "")
			{
				
				$str = "SELECT USER_CODE FROM wp_trusers WHERE CONCAT(USER_NAME,' ',USER_LASTNAME) LIKE '%".$LOG_USER."%'";
				$matchCodes = $this->db->query($str);

				if(count($matchCodes) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($matchCodes); $i++)
					{
						$matchCode = $matchCodes[$i]["USER_CODE"];
						$where .= "UCODE LIKE '%".$matchCode."%'";
						if($i != count($matchCodes) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				else
				{
					$where .= "AND UCODE LIKE '%$LOG_USER%'";
				}
				
			}
			
			
		}
		
		
		if($EXPORT != "0"){$LIMIT = 1000000;}
		
		
		// GET LIST
		$str = "SELECT $FIELDS FROM $TABLE $where ORDER BY $ORDER LIMIT $LIMIT";
		$query = $this->db->query($str);
		
		// GET FRIEDNLY NAMES LOG
		if($TABLE == "ct_quote_items")
		{
			for($i=0; $i<count($query); $i++)
			{
				$item = $query[$i];
				
				// GET ITEM DATA
				$data = array();
				$data["table"] = "ct_items";
				$data["fields"] = " ITEM_ACTIVITY, ITEM_DETAILS, ITEM_UNIT, ITEM_QTY, ITEM_PIC ";
				$data["keyField"] = " ITEM_CODE ";
				$data["code"] = $item["QUOTE_ORIGINAL_CODE"];
				$friendlyData = $this->getFriendlyData($data)["message"];
				
				if($friendlyData != "none")
				{
					$ITEM_ACTIVITY = $friendlyData["ITEM_ACTIVITY"];
					$ITEM_DETAILS = $friendlyData["ITEM_DETAILS"];
					$ITEM_UNIT = $friendlyData["ITEM_UNIT"];
					$ITEM_QTY = $friendlyData["ITEM_QTY"];
					$ITEM_PIC = $friendlyData["ITEM_PIC"];
					
					$query[$i]["ITEM_ACTIVITY"] = $ITEM_ACTIVITY;
					$query[$i]["ITEM_DETAILS"] = $ITEM_DETAILS;
					$query[$i]["ITEM_UNIT"] = $ITEM_UNIT;
					$query[$i]["ITEM_QTY"] = $ITEM_QTY;
					$query[$i]["ITEM_PIC"] = $ITEM_PIC;
					
					if($query[$i]["ITEM_PIC"] != "" and $query[$i]["ITEM_PIC"] != "null" and $query[$i]["ITEM_PIC"] != null){$query[$i]["ITEM_PIC"] = "1";}
					
				}
				else
				{
					$query[$i]["ITEM_ACTIVITY"] = "-";
					$query[$i]["ITEM_DETAILS"] = "-";
					$query[$i]["ITEM_UNIT"] = "-";
					$query[$i]["ITEM_QTY"] = "-";
					$query[$i]["ITEM_PIC"] = "-";
				}

			}
		}
		
		$ans = $query;
		
		// GENERATE EXCEL IF EXPORT 1
		if($EXPORT != "0")
		{
			// FIX ARRAY AS NEEDED
			if($EXPORT == "classAssist")
			{
				$assistLines = array();
				for($i = 0; $i<count($query);$i++)
				{
					$queryItem = $query[$i];
					
					if($queryItem["CLASS_CITIZENS"] == "[]" or $queryItem["CLASS_CITIZENS"] == "")
					{continue;}

					// GET GROUP DATA
					$CLASS_GROUP = $queryItem["CLASS_GROUP"];
					$data = array();
					$data["table"] = "wp_groups";
					$data["fields"] = " GROUP_CONTRACT, GROUP_INSTYPE, GROUP_PREVIR, GROUP_ADDRESS, GROUP_INSTITUTE, GROUP_COORDS, GROUP_COPERATOR ";
					$data["keyField"] = " GROUP_CODE ";
					$data["code"] = $CLASS_GROUP;
					$CLASS_GROUP_DATA = $this->getFriendlyData($data)["message"];

					$GROUP_CONTRACT = $CLASS_GROUP_DATA["GROUP_CONTRACT"];
					$GROUP_INSTYPE = $CLASS_GROUP_DATA["GROUP_INSTYPE"];
					$GROUP_PREVIR = $CLASS_GROUP_DATA["GROUP_PREVIR"];
					$GROUP_ADDRESS = $CLASS_GROUP_DATA["GROUP_ADDRESS"];
					$GROUP_INSTITUTE = $CLASS_GROUP_DATA["GROUP_INSTITUTE"];
					$GROUP_COORDS = $CLASS_GROUP_DATA["GROUP_COORDS"];
					$GROUP_COPERATOR = $CLASS_GROUP_DATA["GROUP_COPERATOR"];
	
					// GET CONTRACT DATA
					$data = array();
					$data["table"] = "wp_contracts";
					$data["fields"] = " CONTRACT_NUMBER, CONTRACT_OTHER_GOALS, CONTRACT_OWNER ";
					$data["keyField"] = " CONTRACT_CODE ";
					$data["code"] = $GROUP_CONTRACT;
					$CLASS_CONTRACT_DATA = $this->getFriendlyData($data)["message"];
					

					$CONTRACT_NUMBER = $CLASS_CONTRACT_DATA["CONTRACT_NUMBER"];
					$CONTRACT_OTHER_GOALS = json_decode($CLASS_CONTRACT_DATA["CONTRACT_OTHER_GOALS"], true);
					$CONTRACT_OWNER = $CLASS_CONTRACT_DATA["CONTRACT_OWNER"];
					
					// GET CONTRACT OWNER DATA
					$data = array();
					$data["table"] = "wp_trusers";
					$data["fields"] = " USER_NAME, USER_LASTNAME ";
					$data["keyField"] = " USER_CODE ";
					$data["code"] = $CONTRACT_OWNER;
					$CLASS_CONTRATIST_DATA = $this->getFriendlyData($data)["message"];
					
					$CLASS_USERNAME = $CLASS_CONTRATIST_DATA["USER_NAME"]." ".$CLASS_CONTRATIST_DATA["USER_LASTNAME"];
					
					// GET ACTIVITY DATA
					$data = array();
					$data["table"] = "wp_activities";
					$data["fields"] = " ACTIVITY_NAME, ACTIVITY_PROJECT ";
					$data["keyField"] = " ACTIVITY_CODE ";
					$data["code"] = $queryItem["CLASS_ACTIVITY"];
					$CLASS_ACTIVITY_DATA = $this->getFriendlyData($data)["message"];
					
					$ACTIVITY_NAME = $CLASS_ACTIVITY_DATA["ACTIVITY_NAME"];
					$ACTIVITY_PROJECT = $CLASS_ACTIVITY_DATA["ACTIVITY_PROJECT"];
					
					// GET PROJECT DATA
					$data = array();
					$data["table"] = "wp_projects";
					$data["fields"] = " PROJECT_NAME, PROJECT_PROGRAM ";
					$data["keyField"] = " PROJECT_CODE ";
					$data["code"] = $ACTIVITY_PROJECT;
					$CLASS_PROJECT_DATA = $this->getFriendlyData($data)["message"];
					
					$PROJECT_NAME = $CLASS_PROJECT_DATA["PROJECT_NAME"];
					$PROJECT_PROGRAM = $CLASS_PROJECT_DATA["PROJECT_PROGRAM"];
					
					// GET PROGRAM DATA
					$data = array();
					$data["table"] = "wp_programs";
					$data["fields"] = " PROGRAM_NAME ";
					$data["keyField"] = " PROGRAM_CODE ";
					$data["code"] = $PROJECT_PROGRAM;
					$CLASS_PROGRAM_DATA = $this->getFriendlyData($data)["message"];
					
					$PROGRAM_NAME = $CLASS_PROGRAM_DATA["PROGRAM_NAME"];
					
					// GET INSTITUTE DATA
					$data = array();
					$data["table"] = "wp_institutes";
					$data["fields"] = " INSTITUTE_NAME ";
					$data["keyField"] = " INSTITUTE_CODE ";
					$data["code"] = $GROUP_INSTITUTE;
					$CLASS_INSTITUTE_DATA = $this->getFriendlyData($data)["message"];
					
					if($CLASS_INSTITUTE_DATA != "none")
					{$INSTITUTE_NAME = $CLASS_INSTITUTE_DATA["INSTITUTE_NAME"];}
					else
					{$INSTITUTE_NAME = "-";}
					
					// GET COOPERATOR DATA
					$COOPERATOR_IDNUM = explode("-", $GROUP_COPERATOR)[0];
					$data = array();
					$data["table"] = "wp_citizens";
					$data["fields"] = " CITIZEN_IDNUM, CITIZEN_NAME, CITIZEN_LASTNAME, CITIZEN_PHONE, CITIZEN_EMAIL  ";
					$data["keyField"] = " CITIZEN_IDNUM ";
					$data["code"] = $COOPERATOR_IDNUM;
					$CLASS_COOPERATOR_DATA = $this->getFriendlyData($data)["message"];
					
					$COOPERATOR_NAME = $CLASS_COOPERATOR_DATA["CITIZEN_NAME"]." ".$CLASS_COOPERATOR_DATA["CITIZEN_LASTNAME"];
					$COOPERATOR_PHONE = $CLASS_COOPERATOR_DATA["CITIZEN_PHONE"];
					$COOPERATOR_EMAIL = $CLASS_COOPERATOR_DATA["CITIZEN_EMAIL"];
					
					// GET CONTRACT GOALS, HOURS AND USERS OF LINKED CONTRACT GROUP
					$goalsData = array();
					for($g = 0; $g<count($CONTRACT_OTHER_GOALS);$g++)
					{
						$group = $CONTRACT_OTHER_GOALS[$g];
						if(array_key_exists("V4",$group))
						{if($group["V4"] == $CLASS_GROUP){$goalsData = $group;break;}}
					}
					$CLASSES_GOAL = $goalsData["V1"];
					$HOURS_GOAL = intval($goalsData["V2"])/60;
					$PEOPLE_GOAL = $goalsData["V3"];
					$CLASS_HOUR = json_decode($queryItem["CLASS_HOUR"],true);
					$CLASS_INI = $CLASS_HOUR["GROUP_TIME_INI"];
					$CLASS_END = $CLASS_HOUR["GROUP_TIME_END"];
					
					$queryItem["CLASS_CITIZENS"] = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($queryItem["CLASS_CITIZENS"] ));
					
					// GET CITIZENS ASSIST LIST
					
					if($queryItem["CLASS_CITIZENS"] != "" and $queryItem["CLASS_CITIZENS"] != null and $queryItem["CLASS_CITIZENS"] != "null")
					{
						$CLASS_CITIZENS = json_decode($queryItem["CLASS_CITIZENS"], true);
					}
					else
					{
						$CLASS_CITIZENS = array();
					}

					for($c = 0; $c<count($CLASS_CITIZENS);$c++)
					{
						$CITIZEN = $CLASS_CITIZENS[$c];
						if($CITIZEN["CITIZEN_ASSIST"] == "0"){continue;}
						$CITIZEN_IDTYPE = $CITIZEN["CITIZEN_IDTYPE"];
						$CITIZEN_IDNUM = $CITIZEN["CITIZEN_IDNUM"];
						
						
						// GET CITIZEN DATA
						$data = array();
						$data["table"] = "wp_citizens";
						$data["fields"] = " CITIZEN_IDNUM, CITIZEN_NAME, CITIZEN_LASTNAME, CITIZEN_GENDER, CITIZEN_ADDRESS, CITIZEN_PHONE, CITIZEN_EMAIL, CITIZEN_ETNIA, CITIZEN_CONDITION  ";
						$data["keyField"] = " CITIZEN_IDNUM ";
						$data["code"] = $CITIZEN_IDNUM;
						$CITIZEN_DATA = $this->getFriendlyData($data)["message"];
						if($CITIZEN_DATA == "none"){continue;}
						else
						{
							$CITIZEN_NAME = $CITIZEN_DATA["CITIZEN_NAME"]." ".$CITIZEN_DATA["CITIZEN_LASTNAME"];
							$CITIZEN_GENDER = $CITIZEN_DATA["CITIZEN_GENDER"];
							$CITIZEN_ADDRESS = $CITIZEN_DATA["CITIZEN_ADDRESS"];
							$CITIZEN_EMAIL = $CITIZEN_DATA["CITIZEN_EMAIL"];
							$CITIZEN_PHONE = $CITIZEN_DATA["CITIZEN_PHONE"];
							$CITIZEN_ETNIA = $CITIZEN_DATA["CITIZEN_ETNIA"];
							$CITIZEN_CONDITION = json_decode($CITIZEN_DATA["CITIZEN_CONDITION"], true);
						}
						
						// GET ETNIA DATA
						$data = array();
						$data["table"] = "wp_etnias";
						$data["fields"] = " ETNIA_NAME ";
						$data["keyField"] = " ETNIA_CODE ";
						$data["code"] = $CITIZEN_ETNIA;
						$ETNIA_DATA = $this->getFriendlyData($data)["message"];
						$CITIZEN_ETNIA = $ETNIA_DATA["ETNIA_NAME"];
						$CITIZEN_AGE = $CITIZEN["CITIZEN_AGE"];
						
						// GET CITIZEN FRIENDLY CONDITIONS
						$friendlyConds = "";
						for($n = 0; $n<count($CITIZEN_CONDITION);$n++)
						{
							$condCode = $CITIZEN_CONDITION[$n];
							// GET COND NAME
							$data = array();
							$data["table"] = "wp_conditions";
							$data["fields"] = " CONDITION_NAME ";
							$data["keyField"] = " CONDITION_CODE ";
							$data["code"] = $condCode;
							$CONDITION_DATA = $this->getFriendlyData($data)["message"];
							$CONDITION_NAME = $CONDITION_DATA["CONDITION_NAME"];
							if($n < count($CITIZEN_CONDITION)-1)
							{$friendlyConds .= $CONDITION_NAME;	$friendlyConds .= ", ";}
							else{$friendlyConds .= $CONDITION_NAME;}
						}
						$CITIZEN_CONDITION = $friendlyConds;
						
						$assistLine = array();
						$assistLine["CONTRACT_NUMBER"] = $CONTRACT_NUMBER;
						$assistLine["CONTRACT_OTHER_GOALS"] = count($CONTRACT_OTHER_GOALS);
						$assistLine["CLASS_USERNAME"] = $CLASS_USERNAME;
						$assistLine["PROGRAM_NAME"] = $PROGRAM_NAME;
						$assistLine["PROJECT_NAME"] = $PROJECT_NAME;
						$assistLine["ACTIVITY_NAME"] = $ACTIVITY_NAME;
						$assistLine["GROUP_INSTYPE"] = $GROUP_INSTYPE;
						$assistLine["GROUP_PREVIR"] = $GROUP_PREVIR;
						$assistLine["GROUP_ADDRESS"] = $GROUP_ADDRESS;
						$assistLine["INSTITUTE_NAME"] = $INSTITUTE_NAME;
						$assistLine["GROUP_COORDS"] = $GROUP_COORDS;
						$assistLine["COOPERATOR_IDNUM"] = $COOPERATOR_IDNUM;
						$assistLine["COOPERATOR_NAME"] = $COOPERATOR_NAME;
						$assistLine["COOPERATOR_PHONE"] = $COOPERATOR_PHONE;
						$assistLine["COOPERATOR_EMAIL"] = $COOPERATOR_EMAIL;
						$assistLine["CLASSES_GOAL"] = $CLASSES_GOAL;
						$assistLine["HOURS_GOAL"] = $HOURS_GOAL;
						$assistLine["PEOPLE_GOAL"] = $PEOPLE_GOAL;
						$assistLine["CLASS_DATE"] = explode(" ", $queryItem["CLASS_DATE"])[0];
						$assistLine["CLASS_INI"] = $CLASS_INI;
						$assistLine["CLASS_END"] = $CLASS_END;
						$assistLine["CITIZEN_IDTYPE"] = $CITIZEN_IDTYPE;
						$assistLine["CITIZEN_IDNUM"] = $CITIZEN_IDNUM;
						$assistLine["CITIZEN_NAME"] = $CITIZEN_NAME;
						$assistLine["CITIZEN_GENDER"] = $CITIZEN_GENDER;
						$assistLine["CITIZEN_AGE"] = $CITIZEN_AGE;
						$assistLine["CITIZEN_ADDRESS"] = $CITIZEN_ADDRESS;
						$assistLine["CITIZEN_EMAIL"] = $CITIZEN_EMAIL;
						$assistLine["CITIZEN_PHONE"] = $CITIZEN_PHONE;
						$assistLine["CITIZEN_ETNIA"] = $CITIZEN_ETNIA;
						$assistLine["CITIZEN_CONDITION"] = $CITIZEN_CONDITION;
						
						array_push($assistLines, $assistLine);
						
						
					}
				}
				$exported = $this->excelCreate($EXPORT, $assistLines);
				$resp["path"] = $exported;
			}
		}
		
		
		// MARK FILES WITH PIC
		if($TABLE == "ct_items")
		{
			for($i=0; $i<count($query); $i++)
			{
				$item = $query[$i];
				if($item["ITEM_PIC"] != "" and $item["ITEM_PIC"] != "null" and $item["ITEM_PIC"] != null){$query[$i]["ITEM_PIC"] = "1";}
				
				if($item["ITEM_QUOTE_ITEM"] != "" and $item["ITEM_QUOTE_ITEM"] != null and $item["ITEM_QUOTE_ITEM"] != "null")
				{
					
					// GET ITEM DATA
					$data = array();
					$data["table"] = "ct_quote_items";
					$data["fields"] = " QUOTE_UNIT_VALUE ";
					$data["keyField"] = " QUOTE_ITEM_CODE ";
					$data["code"] = $item["ITEM_QUOTE_ITEM"];
					$friendlyData = $this->getFriendlyData($data)["message"];
					if($friendlyData != "none")
					{$query[$i]["ITEM_UNIT_VALUE"] = $friendlyData["QUOTE_UNIT_VALUE"];}
					
				}
				
				$str = "SELECT QUOTE_CODE, QUOTE_ITEM_CODE, QUOTE_UNIT_VALUE FROM ct_quote_items WHERE QUOTE_ORIGINAL_CODE = '".$item["ITEM_CODE"]."'";
				$quotePrices = $this->db->query($str);

				if(count($quotePrices) > 0)
				{
					for($q=0; $q<count($quotePrices); $q++)
					{
						$quote = $quotePrices[$q];
	
						// GET ITEM DATA
						$data = array();
						$data["table"] = "ct_quotes";
						$data["fields"] = " QUOTE_NAME ";
						$data["keyField"] = " QUOTE_CODE ";
						$data["code"] = $quote["QUOTE_CODE"];
						$friendlyData = $this->getFriendlyData($data)["message"];
						if($friendlyData != "none")
						{$quotePrices[$q]["QUOTE_NAME"] = $friendlyData["QUOTE_NAME"];}
						else{$quotePrices[$q]["QUOTE_NAME"] = "-";}
					}
				}
				$query[$i]["QUOTE_PRICES"] = $quotePrices;
			}
			$ans = $query;	
		}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	// GET REG FILE
	function getRegFile($info)
	{
		$table = $info["table"];
		$fileField = $info["fileField"];
		$codeField = $info["codeField"];
		$code = $info["code"];
		
		$str = "SELECT $fileField FROM $table WHERE $codeField = '".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query[0][$fileField];
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	// CREATE EXCEL AND RETURN FILENAME
	function excelCreate($type, $array)
	{
		
		$myExcel = new PHPexcel();
		$myExcel->getProperties()->setCreator("cotizamelo")
						 ->setLastModifiedBy("cotizamelo")
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

		
		// BUILD HEADERS
		if($type == "classAssist")
		{
			$fieldsArray = array("CONTRACT_NUMBER", "CONTRACT_OTHER_GOALS", "CLASS_USERNAME", "PROGRAM_NAME", "PROJECT_NAME", "ACTIVITY_NAME", "GROUP_INSTYPE", "GROUP_PREVIR", "GROUP_ADDRESS", "INSTITUTE_NAME", "GROUP_COORDS", "COOPERATOR_IDNUM", "COOPERATOR_NAME", "COOPERATOR_PHONE", "COOPERATOR_EMAIL", "CLASSES_GOAL", "HOURS_GOAL", "PEOPLE_GOAL", "CLASS_DATE", "CLASS_INI", "CLASS_END", "CITIZEN_IDTYPE", "CITIZEN_IDNUM", "CITIZEN_NAME", "CITIZEN_GENDER", "CITIZEN_AGE", "CITIZEN_ADDRESS", "CITIZEN_EMAIL", "CITIZEN_PHONE", "CITIZEN_ETNIA", "CITIZEN_CONDITION");
		
			$c = "A";
			$f = 1;
			
			// FILL HEADERS
			for($i = 0; $i<count($fieldsArray);$i++)
			{
				$item = $fieldsArray[$i];
				$cell = strval($c.$f);
				$sheet->setCellValue($cell,  $this->getFieldTitle($item));
				$sheet->getStyle($cell)->applyFromArray($borderB);
				$sheet->getStyle($cell)->applyFromArray($alignLeft);
				$sheet->getStyle($cell)->getFont()->setSize(11);
				$sheet->getStyle($cell)->getFont()->setBold(true);
				
				$c++;
			}
			
			$f++;
			$c = "A";
			
			// FILL CONTENTS
			for($i = 0; $i<count($array);$i++)
			{
				$item = $array[$i];
				
				
				for($n = 0; $n<count($fieldsArray);$n++)
				{
					$cell = strval($c.$f);
					$field = $fieldsArray[$n];
					$sheet->setCellValue($cell, $item[$field]);
					$sheet->getStyle($cell)->applyFromArray($borderB);
					$sheet->getStyle($cell)->applyFromArray($alignLeft);
					$sheet->getStyle($cell)->getFont()->setSize(9);
					
					$c++;
				}
				
				
				$c = "A";
				$f++;
			}
			

			// CREATE FILE AND RETURN PATH
			$fname  = "Reporte asistencia";
			$fname = htmlEntities(utf8_decode($fname));
			$path = "../reports/".$fname.".xls";
			
			$hasFile = file_exists($path);
			if($hasFile == true){unlink($path);}
			
			$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
			$objWriter->save($path );
			
		}

		
		return $fname;
	}
	// GET FRIENDLY DATA
	function getFriendlyData($info)
	{
		$table = $info["table"];
		$fields = $info["fields"];
		$keyField = $info["keyField"];
		$code = $info["code"];
		
		$str = "SELECT $fields FROM $table WHERE 
		$keyField = '".$code."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{$ans = $query[0];}
		else
		{$ans = "none";}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	// ITEM DELETE
	function deleteItem($info)
	{
		$code = $info["code"];
		$table = $info["table"];
		$field = $info["field"];
		
		if($table == "ct_budgets")
		{
			$str = "DELETE FROM ct_items WHERE 
			ITEM_BUDGET = '".$code."'";
			$query = $this->db->query($str);
			
			// DELETE ALSO RELATED LISTS AND ANSWERS
			
		}
		if($table == "ct_quotes")
		{
			$str = "DELETE FROM ct_quote_items WHERE 
			QUOTE_CODE = '".$code."'";
			$query = $this->db->query($str);
			
			// DELETE ALSO RELATED LISTS AND ANSWERS
			
		}
		if($table == "ct_categories")
		{
			
			$str = "SELECT ITEM_CODE FROM ct_items WHERE ITEM_CATEGORY = '".$code."'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantItem";
				$resp["status"] = true;
				return $resp;
			}
		}
		if($table == "ct_items")
		{
			
			// CHECK IF ITEM IN BUDGETLIST
			// $str = "SELECT ITEM_CODE FROM ct_items WHERE ITEM_CATEGORY = '".$code."'";
			// $query = $this->db->query($str);
			
			// if(count($query) >0)
			// {
				// $resp["message"] = "cantItemProposals";
				// $resp["status"] = true;
				// return $resp;
			// }
		}
		if($table == "wp_citizens")
		{
			// CHECK FOR CITIZEN IN GROUPS
			$str = "SELECT GROUP_CITIZENS FROM wp_groups WHERE 
			GROUP_CITIZENS LIKE '%".$code."%'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantCitGroup";
				$resp["status"] = true;
				return $resp;
			}
			
			// CHECK FOR CITIZEN IN CLASES
			$str = "SELECT CLASS_CITIZENS FROM wp_classes WHERE 
			CLASS_CITIZENS LIKE '%".$code."%'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantCitClass";
				$resp["status"] = true;
				return $resp;
			}
			
			// CHECK FOR CITIZEN IN EVENTS
			$str = "SELECT EVENT_REQUESTER FROM wp_events WHERE 
			EVENT_REQUESTER LIKE '%".$code."%' OR EVENT_COOPERATOR LIKE '%".$code."%'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantCitEvent";
				$resp["status"] = true;
				return $resp;
			}
		}
		if($table == "wp_programs")
		{
			$str = "SELECT CONTRACT_CODE FROM wp_contracts WHERE 
			CONTRACT_PROGRAM LIKE '%".$code."%'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantP";
				$resp["status"] = true;
				return $resp;
			}
		}

		$str = "DELETE FROM $table WHERE $field ='".$code."'";
		$query = $this->db->query($str);
		
		$ans = "deleted";
		
		// ------------------LOGSAVE-----------------
		$logSave = $this->logw($info);
		// ------------------LOGSAVE-----------------
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	// CLEAR LOG
	function clearLog($info)
	{
		$entity = $info["entity"];
		
		// $str = "DELETE FROM wp_log WHERE ENTITY = '".$entity."'";
		$str = "DELETE FROM wp_log";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function mailExist($info)
	{
		$entity = $info["entity"];
		$email = $info["email"];
		$lang = $info["lang"];
		
		$str = "SELECT USER_CODE FROM wp_trusers WHERE USER_EMAIL = '".$email."' AND USER_ENTITY = '".$entity."'";
		$query = $this->db->query($str);

		if(count($query) > 0)
		{
			// IF USER NOT EMAIL SEND TO SUPPORT
			if(strpos($email, "@") === false)
			{
				$resp["message"] = "notmail";
				$resp["status"] = false;
				return $resp;
			}
			
			$language = $lang;
			
			$langFile = parse_ini_file("../lang/lang.ini", true);
			
			$subject = $langFile[$language]["recSubject"];
			$message = $langFile[$language]["recMessage"];
			$recLinkText = $langFile[$language]["recLinkText"];
			$header = $langFile[$language]["recHeader"];
			$genFooter = $langFile[$language]["genFooter"];
			
			$tmpkey = $query[0]["USER_CODE"];
			
			$host = "https://sistemadiogenes.com/";
			
			$content = $message."<br><br><span style='font-size:13px; font-weight: bold;'>"."<a href='".$host."?me=".$email."&tmpkey=".$tmpkey."'>".htmlentities($recLinkText)."</a>"."</span>";
						
			// SEND MAIL 
			$data = array();
			$data["subject"] = $subject;
			$data["email"] = $email;
			$data["content"] = $content;
			$data["header"] = $header;
			$data["footer"] = $genFooter;
			
			$send = $this->myMailer($data);
			
			$resp["message"] = $content;
			// $resp["message"] = $send;
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
		
		$str = "UPDATE wp_trusers SET USER_PASS = '".$pass."' WHERE USER_CODE = '".$code."'";
		$query = $this->db->query($str);
		
		$resp["message"] = "set";
		$resp["status"] = true;
		return $resp;
	}
	function myMailer($info)
	{
		$subject = $info["subject"];
		$email = $info["email"];
		$content = $info["content"];
		$header = "<div style='text-align: center; color: #000000;'><h2>".$info["header"]."</h2></div>";
		$footer = "<div style='text-align: center; color: #e95b35;'><h5>".$info["footer"]."</h5></div>";
		
		$content = htmlEntities($content);
		$content = html_entity_decode($content);
		$fromName = "DIOGENES";
		$from = 'sistemadiogenes@gmail.com';		
		$host = 'smtp.gmail.com';
		$pssw = 'Sisdiogenes123';
		
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
		$mail->AddAddress($email);

		// $recipients = array('leoncitobravo2008@hotmail.com', 'incocrea@outlook.com', 'contacto@inscolombia.com');
		// foreach($recipients as $demail)// {// $mail->AddCC($demail);// }
		// $mail->AddAttachment("../../ding.WAV", 'soundfile.WAV');
		
		$content = "<h3 style='text-align: center;'>".$content."</h3>";
		$body = $header."<br>".$content."<br>".$footer;
		$mail->Body = $body; 

		// EnvÃ­a el correo. 
		// DESCOMENTAR ESTO EN PRODUCTIVO
		// $exito = $mail->Send();
		
		// COMENTAR EN PRODUCTIVO
		$exito = true;
		
		if($exito){$ans = "enviado";}else{$ans = $mail->ErrorInfo;} 
		
		$ans = "enviado";
		
		// $ans = $body;

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}

}
?>
