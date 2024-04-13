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
		
		$str = "SELECT * FROM wp_entities ORDER BY ENTITY_NAME ASC";
		$entities = $this->db->query($str);
		
		$str = "SELECT * FROM wp_programs ORDER BY PROGRAM_NAME ASC";
		$programs = $this->db->query($str);
		
		$str = "SELECT * FROM wp_projects ORDER BY PROJECT_NAME ASC";
		$projects = $this->db->query($str);
		
		$str = "SELECT * FROM wp_activities ORDER BY ACTIVITY_NAME ASC";
		$activities = $this->db->query($str);
		
		$str = "SELECT * FROM wp_zones ORDER BY ZONE_NAME ASC";
		$zones = $this->db->query($str);
		
		$str = "SELECT * FROM wp_hoods ORDER BY HOOD_NAME ASC";
		$hoods = $this->db->query($str);
		
		$str = "SELECT * FROM wp_institutes ORDER BY INSTITUTE_NAME ASC";
		$institutes = $this->db->query($str);
		
		$str = "SELECT * FROM wp_conditions ORDER BY CONDITION_NAME ASC";
		$conditions = $this->db->query($str);
		
		$str = "SELECT * FROM wp_etnias ORDER BY ETNIA_NAME ASC";
		$etnias = $this->db->query($str);
		
		$str = "SELECT * FROM wp_etaries ORDER BY ETARIE_FROM ASC";
		$etaries = $this->db->query($str);
		
		// $str = "SELECT * FROM wp_citizens ORDER BY CITIZEN_NAME ASC";
		// $citizens = $this->db->query($str);
		
		
		// NEW MASTERS
		$str = "SELECT * FROM wp_master_tipoin ORDER BY TIPOIN_NAME ASC";
		$tipoin = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_migrea ORDER BY MIGREA_NAME ASC";
		$migrea = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_convac ORDER BY CONVAC_NAME ASC";
		$convac = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_tipoco ORDER BY TIPOCO_NAME ASC";
		$tipoco = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_tipovi ORDER BY TIPOVI_NAME ASC";
		$tipovi = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_eps ORDER BY EPS_NAME ASC";
		$eps = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_patoen ORDER BY PATOEN_NAME ASC";
		$patoen = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_trasdes ORDER BY TRASDES_NAME ASC";
		$trasdes = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_riskfa ORDER BY RISKFA_NAME ASC";
		$riskfa = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_prevfa ORDER BY PREVFA_NAME ASC";
		$prevfa = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_edlevel ORDER BY EDLEVEL_NAME ASC";
		$edlevel = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_courses ORDER BY COURSES_NAME ASC";
		$courses = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_ocucond ORDER BY OCUCOND_NAME ASC";
		$ocucond  = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_ingrec ORDER BY INGREC_NAME ASC";
		$ingrec  = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_tiposo ORDER BY TIPOSO_NAME ASC";
		$tiposo  = $this->db->query($str);
		
		$str = "SELECT USER_CODE, USER_NAME, USER_LASTNAME, USER_IDNUM FROM wp_trusers";
		$users  = $this->db->query($str);
		
		$str = "SELECT GROUP_CODE, GROUP_NAME, GROUP_ENTITY FROM wp_groups WHERE GROUP_CONTRACT != 'null' AND GROUP_CONTRACT != ''";
		$inigroups = $this->db->query($str);
		
		$str = "SELECT COMPONENT_CODE, COMPONENT_NAME, COMPONENT_ACTIVITIES FROM wp_master_component ORDER BY COMPONENT_NAME ASC";
		$components = $this->db->query($str);
		
		$str = "SELECT SCOMPONENT_CODE, SCOMPONENT_NAME, SCOMPONENT_COMPONENT FROM wp_master_scomponent ORDER BY SCOMPONENT_NAME ASC";
		$scomponents = $this->db->query($str);
		
		$str = "SELECT * FROM wp_master_genre ORDER BY GENRE_NAME ASC";
		$genres = $this->db->query($str);
		
		
		$answer["entities"] = $entities;
		$answer["programs"] = $programs;
		$answer["projects"] = $projects;
		$answer["activities"] = $activities;
		$answer["zones"] = $zones;
		$answer["hoods"] = $hoods;
		$answer["institutes"] = $institutes;
		$answer["conditions"] = $conditions;
		$answer["etnias"] = $etnias;
		$answer["etaries"] = $etaries;
		$answer["tipoin"] = $tipoin;
		$answer["migrea"] = $migrea;
		$answer["convac"] = $convac;
		$answer["tipoco"] = $tipoco;
		$answer["tipovi"] = $tipovi;
		$answer["eps"] = $eps;
		$answer["patoen"] = $patoen;
		$answer["trasdes"] = $trasdes;
		$answer["riskfa"] = $riskfa;
		$answer["prevfa"] = $prevfa;
		$answer["edlevel"] = $edlevel;
		$answer["courses"] = $courses;
		$answer["ocucond"] = $ocucond;
		$answer["ingrec"] = $ingrec;
		$answer["tiposo"] = $tiposo;
		$answer["users"] = $users;
		$answer["inigroups"] = $inigroups;
		$answer["components"] = $components;
		$answer["scomponents"] = $scomponents;
		$answer["genres"] = $genres;
		// $answer["citizens"] = $citizens;
		
		$resp["message"] = $answer;
		$resp["status"] = true; 
		return $resp;
		
	}
	function login($info)
	{
		
		$str = "SELECT * FROM wp_trusers WHERE USER_ENTITY = '".$info["entity"]."' AND USER_EMAIL = '".$info["email"]."' AND USER_PASS = '".md5($info["pssw"])."'";
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
			$logEntity = $query[0]["USER_ENTITY"];
			$userType = $query[0]["USER_TYPE"];
			
			// CHECK ENTITY VALIDITY
			$str = "SELECT ENTITY_VUNTIL, ENTITY_CITY FROM wp_entities WHERE 
			ENTITY_CODE = '".$logEntity."'";
			$vDate = $this->db->query($str)[0]["ENTITY_VUNTIL"];
			if($vDate < $now){$query[0]["ENTITY_ALIVE"] = "0";}
			else{$query[0]["ENTITY_ALIVE"] = "1";}
			
			
			
			// GET USER CITY
			$actualCity = $this->db->query($str)[0]["ENTITY_CITY"];
			$query[0]["USER_CITY"] = $actualCity;
			
			// GET USER TYPE AND GOALS FROM CONTRACT
			
			if($userType == "General")
			{
				$str = "SELECT CONTRACT_CODE, CONTRACT_USERTYPE, CONTRACT_ACTIVITIES, CONTRACT_PROGRAM, CONTRACT_ZONES, CONTRACT_OTHER_GOALS, CONTRACT_VISIT_GOALS, CONTRACT_EVENT_GOALS, CONTRACT_CANREM, CONTRACT_CANREM_GET FROM wp_contracts WHERE 
				CONTRACT_OWNER = '".$ucode."' AND CONTRACT_ENDATE >= '".$now."'";
				$contract = $this->db->query($str);
				
				if(count($contract) > 0)
				{
					$userType = $contract[0]["CONTRACT_USERTYPE"];
					$userContract = $contract[0]["CONTRACT_CODE"];
					$query[0]["USER_ACTIVITIES"] = $contract[0]["CONTRACT_ACTIVITIES"];
					$query[0]["USER_PROGRAMS"] = $contract[0]["CONTRACT_PROGRAM"];
					$query[0]["USER_ZONES"] = $contract[0]["CONTRACT_ZONES"];
					$query[0]["USER_GROUPS"] = $contract[0]["CONTRACT_OTHER_GOALS"];
					$query[0]["USER_EVENT_GOALS"] = $contract[0]["CONTRACT_EVENT_GOALS"];
					$query[0]["USER_VISIT_GOALS"] = $contract[0]["CONTRACT_VISIT_GOALS"];
					$query[0]["USER_CONTRACT"] = $userContract;
					$query[0]["USER_CONTRACT_CANREM"] = $contract[0]["CONTRACT_CANREM"];
					$query[0]["USER_CONTRACT_CANREM_GET"] = $contract[0]["CONTRACT_CANREM_GET"];
				}
				else
				{
					$query[0]["USER_ACTIVITIES"] = "[]";
					$query[0]["USER_PROGRAMS"] = "[]";
					$query[0]["USER_ZONES"] = "[]";
					$query[0]["USER_GROUPS"] = "[]";
					$query[0]["USER_EVENT_GOALS"] = "[]";
					$query[0]["USER_VISIT_GOALS"] = "[]";
					$query[0]["USER_CONTRACT"] = "";
					$query[0]["USER_CONTRACT_CANREM"] = "";
					$query[0]["USER_CONTRACT_CANREM_GET"] = "";
				}
			}
			else
			{
				$query[0]["USER_ACTIVITIES"] = "[]";
				$query[0]["USER_PROGRAMS"] = "[]";
				$query[0]["USER_ZONES"] = "[]";
				$query[0]["USER_GROUPS"] = "[]";
				$query[0]["USER_EVENT_GOALS"] = "[]";
				$query[0]["USER_VISIT_GOALS"] = "[]";
				$query[0]["USER_CONTRACT"] = "";
				$query[0]["USER_CONTRACT_CANREM"] = "";
				$query[0]["USER_CONTRACT_CANREM_GET"] = "";
			}
			
			$query[0]["USER_CTYPE"] = $userType;
			
			
			// CHECK DATE IF USER CALLER
			if($query[0]["USER_CALLER"] == "1")
			{
				
				$vDate = $query[0]["USER_CALLER_ENDATE"];
				
				if($vDate < $now)
				{
					$resp["message"] = "Caller";
					$resp["status"] = true;
					return $resp;
				}
			}
			
			
			$resp["message"] = $query[0];
			$resp["status"] = true;
			$info["ucode"] = $ucode;
			$info["logEntity"] = $logEntity;
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
		$str = "SELECT * FROM wp_trusers WHERE USER_CODE = '$code'";
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
			
			$mail = $query[0]["USER_EMAIL"];
			
			$ucode = $query[0]["USER_CODE"];
			$logEntity = $query[0]["USER_ENTITY"];
			$userType = $query[0]["USER_TYPE"];
			
			// CHECK ENTITY VALIDITY
			$str = "SELECT ENTITY_VUNTIL, ENTITY_CITY FROM wp_entities WHERE 
			ENTITY_CODE = '".$logEntity."'";
			$vDate = $this->db->query($str)[0]["ENTITY_VUNTIL"];
			
			if($vDate < $now){$query[0]["ENTITY_ALIVE"] = "0";}
			else{$query[0]["ENTITY_ALIVE"] = "1";}
			
			// GET USER CITY
			$actualCity = $this->db->query($str)[0]["ENTITY_CITY"];
			$query[0]["USER_CITY"] = $actualCity;
			
			// GET USER TYPE FROM CONTRACT
			
			if($userType == "General")
			{
				$str = "SELECT CONTRACT_CODE, CONTRACT_USERTYPE, CONTRACT_ACTIVITIES, CONTRACT_PROGRAM, CONTRACT_ZONES, CONTRACT_OTHER_GOALS, CONTRACT_VISIT_GOALS, CONTRACT_EVENT_GOALS, CONTRACT_CANREM, CONTRACT_CANREM_GET FROM wp_contracts WHERE 
				CONTRACT_OWNER = '".$ucode."' AND CONTRACT_ENDATE >= '".$now."'";
				$contract = $this->db->query($str);
				
				if(count($contract) > 0)
				{
					$userType = $contract[0]["CONTRACT_USERTYPE"];
					$userContract = $contract[0]["CONTRACT_CODE"];
					$query[0]["USER_ACTIVITIES"] = $contract[0]["CONTRACT_ACTIVITIES"];
					$query[0]["USER_PROGRAMS"] = $contract[0]["CONTRACT_PROGRAM"];
					$query[0]["USER_ZONES"] = $contract[0]["CONTRACT_ZONES"];
					$query[0]["USER_GROUPS"] = $contract[0]["CONTRACT_OTHER_GOALS"];
					$query[0]["USER_EVENT_GOALS"] = $contract[0]["CONTRACT_EVENT_GOALS"];
					$query[0]["USER_VISIT_GOALS"] = $contract[0]["CONTRACT_VISIT_GOALS"];
					$query[0]["USER_CONTRACT"] = $userContract;
					$query[0]["USER_CONTRACT_CANREM"] = $contract[0]["CONTRACT_CANREM"];
					$query[0]["USER_CONTRACT_CANREM_GET"] = $contract[0]["CONTRACT_CANREM_GET"];
				}
				else
				{
					$query[0]["USER_ACTIVITIES"] = "[]";
					$query[0]["USER_PROGRAMS"] = "[]";
					$query[0]["USER_ZONES"] = "[]";
					$query[0]["USER_GROUPS"] = "[]";
					$query[0]["USER_EVENT_GOALS"] = "[]";
					$query[0]["USER_VISIT_GOALS"] = "[]";
					$query[0]["USER_CONTRACT"] = "";
					$query[0]["USER_CONTRACT_CANREM"] = "";
					$query[0]["USER_CONTRACT_CANREM_GET"] = "";
				}
			}
			else
			{
				$query[0]["USER_ACTIVITIES"] = "[]";
				$query[0]["USER_PROGRAMS"] = "[]";
				$query[0]["USER_ZONES"] = "[]";
				$query[0]["USER_GROUPS"] = "[]";
				$query[0]["USER_EVENT_GOALS"] = "[]";
				$query[0]["USER_VISIT_GOALS"] = "[]";
				$query[0]["USER_CONTRACT"] = "";
				$query[0]["USER_CONTRACT_CANREM"] = "";
				$query[0]["USER_CONTRACT_CANREM_GET"] = "";
				
			}
			
			$query[0]["USER_CTYPE"] = $userType;
			
			// CHECK DATE IF USER CALLER
			if($query[0]["USER_CALLER"] == "1")
			{
				
				$vDate = $query[0]["USER_CALLER_ENDATE"];
				
				if($vDate < $now)
				{
					$resp["message"] = "Caller";
					$resp["status"] = true;
					return $resp;
				}
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
		$entity = $info["logEntity"];
		return;
		
		$str = "INSERT INTO wp_log (DATE, MT, UCODE, IFACE, ENTITY) VALUES ('".$now."', '".$mt."', '".$ucode."', '".$iface."', '".$entity."')";
		$query = $this->db->query($str);
		return;
	}
	function register($info)
	{
		
		$USER_ENTITY = $info["USER_ENTITY"];
		$USER_TYPE = $info["USER_TYPE"];
		$USER_NAME = addslashes($info["USER_NAME"]);
		$USER_LASTNAME = addslashes($info["USER_LASTNAME"]);
		$USER_IDTYPE = $info["USER_IDTYPE"];
		$USER_IDNUM = $info["USER_IDNUM"];
		$USER_BDAY = $info["USER_BDAY"];
		$USER_PHONE = $info["USER_PHONE"];
		$USER_EMAIL = $info["USER_EMAIL"];
		$USER_PASS = md5($info["USER_PASS"]);
		$USER_PASS2 = $info["USER_PASS2"];
		if($info["USER_IMFOO"] != "user"){$USER_PIC = $info["USER_PIC"];}
		
		
		$MODE = $info["MODE"];
		
		$str = "SELECT USER_EMAIL FROM wp_trusers WHERE USER_EMAIL = '".$USER_EMAIL."' AND USER_ENTITY = '".$USER_ENTITY."'";
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
				$USER_CALLER_GOAL = $info["USER_CALLER_GOAL"];
				$USER_CALLER_ENDATE = $info["USER_CALLER_ENDATE"];
				
				$str = "SELECT USER_EMAIL FROM wp_trusers WHERE USER_EMAIL = '".$USER_EMAIL."' AND USER_ENTITY = '".$USER_ENTITY."' AND USER_CODE != '".$USER_CODE."'";
				$query = $this->db->query($str);
				if(count($query)>0)
				{$resp["message"] = "exists";return $resp;}
				
				
				if($info["USER_IMFOO"] != "user")
				{
					if($info["CHANGEPASS"] == "1")
					{
						$str = "UPDATE wp_trusers SET 
						USER_PIC = '".$USER_PIC."',
						USER_ENTITY = '".$USER_ENTITY."',
						USER_EMAIL = '".$USER_EMAIL."',
						USER_TYPE = '".$USER_TYPE."',
						USER_NAME = '".$USER_NAME."',
						USER_LASTNAME = '".$USER_LASTNAME."',
						USER_IDTYPE = '".$USER_IDTYPE."',
						USER_IDNUM = '".$USER_IDNUM."',
						USER_BDAY = '".$USER_BDAY."',
						USER_PHONE = '".$USER_PHONE."',
						USER_CALLER_GOAL = '".$USER_CALLER_GOAL."',
						USER_CALLER_ENDATE = '".$USER_CALLER_ENDATE."',
						USER_PASS = '".$USER_PASS."'
						WHERE 
						USER_CODE ='".$USER_CODE."'";

						$resp["message"] = "updatedpcP";
					}
					else
					{
						$str = "UPDATE wp_trusers SET 
						USER_PIC = '".$USER_PIC."',
						USER_ENTITY = '".$USER_ENTITY."',
						USER_EMAIL = '".$USER_EMAIL."',
						USER_TYPE = '".$USER_TYPE."',
						USER_NAME = '".$USER_NAME."',
						USER_LASTNAME = '".$USER_LASTNAME."',
						USER_IDTYPE = '".$USER_IDTYPE."',
						USER_IDNUM = '".$USER_IDNUM."',
						USER_BDAY = '".$USER_BDAY."',
						USER_PHONE = '".$USER_PHONE."',
						USER_CALLER_GOAL = '".$USER_CALLER_GOAL."',
						USER_CALLER_ENDATE = '".$USER_CALLER_ENDATE."'
						WHERE 
						USER_CODE ='".$USER_CODE."'";

						$resp["message"] = "updatednpcP";
					}
					
				}
				else
				{
					if($info["CHANGEPASS"] == "1")
					{
						$str = "UPDATE wp_trusers SET 
						USER_ENTITY = '".$USER_ENTITY."',
						USER_EMAIL = '".$USER_EMAIL."',
						USER_TYPE = '".$USER_TYPE."',
						USER_NAME = '".$USER_NAME."',
						USER_LASTNAME = '".$USER_LASTNAME."',
						USER_IDTYPE = '".$USER_IDTYPE."',
						USER_IDNUM = '".$USER_IDNUM."',
						USER_BDAY = '".$USER_BDAY."',
						USER_PHONE = '".$USER_PHONE."',
						USER_CALLER_GOAL = '".$USER_CALLER_GOAL."',
						USER_CALLER_ENDATE = '".$USER_CALLER_ENDATE."',
						USER_PASS = '".$USER_PASS."'
						WHERE 
						USER_CODE ='".$USER_CODE."'";

						$resp["message"] = "updatedpc";
						
						

					}
					else
					{
						$str = "UPDATE wp_trusers SET 
						USER_ENTITY = '".$USER_ENTITY."',
						USER_EMAIL = '".$USER_EMAIL."',
						USER_TYPE = '".$USER_TYPE."',
						USER_NAME = '".$USER_NAME."',
						USER_LASTNAME = '".$USER_LASTNAME."',
						USER_IDTYPE = '".$USER_IDTYPE."',
						USER_IDNUM = '".$USER_IDNUM."',
						USER_BDAY = '".$USER_BDAY."',
						USER_PHONE = '".$USER_PHONE."',
						USER_CALLER_GOAL = '".$USER_CALLER_GOAL."',
						USER_CALLER_ENDATE = '".$USER_CALLER_ENDATE."'
						WHERE 
						USER_CODE ='".$USER_CODE."'";

						$resp["message"] = "updatednpc";
					}
				}



				$query = $this->db->query($str);
				
				// ------------------LOGSAVE-----------------
				$logSave = $this->logw($info);
				// ------------------LOGSAVE-----------------
				
				$message = "Se ha actualizado la informaciÃ³n de tu perfil de usuario.";

				// SEND MAIL 
				$data = array();
				$data["subject"] = "ActualizaciÃ³n de perfil - DIOGENES";
				$data["email"] = $info["USER_EMAIL"];
				$data["content"] = "Mensaje de administrador DIOGENES<br><br>".$message."<br><br>";
				$data["header"] = "-";
				$data["footer"] = "-";
				
				
				
				if (!filter_var($info["USER_EMAIL"], FILTER_VALIDATE_EMAIL))
				{
					$ans = "Invalid: ".$info["USER_EMAIL"];
					// $resp["message"] = $ans;
					// $resp["status"] = true;
					// return $resp;
				}
				else
				{
					$send = $this->myMailer($data, "")["message"];
					return $resp;
				}
				
				
				
				
				
				
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
			$USER_CODE = md5($USER_ENTITY.$USER_EMAIL.$now);
			$USER_REGDATE = $now;
			$USER_PIC = $info["USER_PIC"];
			
			$str = "INSERT INTO wp_trusers (
			USER_CODE,
			USER_ENTITY,
			USER_TYPE,
			USER_NAME,
			USER_LASTNAME,
			USER_IDTYPE,
			USER_IDNUM,
			USER_BDAY,
			USER_PHONE,
			USER_EMAIL,
			USER_PASS,
			USER_PIC,
			USER_REGDATE) VALUES (
			'".$USER_CODE."',
			'".$USER_ENTITY."',
			'".$USER_TYPE."',
			'".$USER_NAME."',
			'".$USER_LASTNAME."',
			'".$USER_IDTYPE."',
			'".$USER_IDNUM."',
			'".$USER_BDAY."',
			'".$USER_PHONE."',
			'".$USER_EMAIL."',
			'".$USER_PASS."',
			'".$USER_PIC."',
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
	function saveContract($info)
	{

		$CONTRACT_REQTYPE = $info["CONTRACT_REQTYPE"];
		$CONTRACT_NUMBER = $info["CONTRACT_NUMBER"];
		$CONTRACT_INIDATE = $info["CONTRACT_INIDATE"];
		$CONTRACT_ENDATE = $info["CONTRACT_ENDATE"];
		$CONTRACT_USERTYPE = $info["CONTRACT_USERTYPE"];
		$CONTRACT_PROGRAM = $info["CONTRACT_PROGRAM"];
		$CONTRACT_ACTIVITIES = $info["CONTRACT_ACTIVITIES"];
		$CONTRACT_ZONES = $info["CONTRACT_ZONES"];
		$now = new DateTime();
		$now = $now->format('Y-m-d');
		$CONTRACT_CREATED = $now;
		$CONTRACT_REQUESTER = $info["CONTRACT_REQUESTER"];
		$CONTRACT_ENTITY = $info["CONTRACT_ENTITY"];
		$MODE = $info["MODE"];

		// CHECK IF NUMBER EXISTS
		$str = "SELECT CONTRACT_NUMBER, CONTRACT_OWNER FROM wp_contracts WHERE CONTRACT_NUMBER = '".$CONTRACT_NUMBER."' AND CONTRACT_ENTITY = '".$CONTRACT_ENTITY."'";
		$query = $this->db->query($str);
		if(count($query) > 0 and $MODE == "0")
		{$resp["message"] = "exists";return $resp;}

		if($MODE == "1")
		{
			
			$CONTRACT_CODE = $info["CONTRACT_CODE"];
			$CONTRACT_CANREM = $info["CONTRACT_CANREM"];
			$CONTRACT_CANREM_GET = $info["CONTRACT_CANREM_GET"];
			
			$CONTRACT_OWNER = $query[0]["CONTRACT_OWNER"];
			

			// CHECK IF OWNNER HAVE ANOTHER ACTIVE CONTRACT IN SAME PERIOD, IF SO, CHECK DATES, IF COINCIDENCE CANT SAVE
			
			$str = "SELECT CONTRACT_INIDATE, CONTRACT_ENDATE FROM wp_contracts WHERE CONTRACT_OWNER = '".$CONTRACT_OWNER."' AND CONTRACT_CODE != '".$CONTRACT_CODE."'";
			
			
			
			
			
			$str = "SELECT CONTRACT_INIDATE, CONTRACT_ENDATE FROM wp_contracts WHERE CONTRACT_OWNER = '".$CONTRACT_OWNER."' AND CONTRACT_CODE != '".$CONTRACT_CODE."'";
			$otherContracts = $this->db->query($str);
			
			$actualInidate = $CONTRACT_INIDATE;
			$actualEnddate = $CONTRACT_ENDATE;
			
			// $resp["message"] = $otherContracts;
			// return $resp;
			
			$save = 1;
			
			for($i=0; $i<count($otherContracts); $i++)
			{
				$contract = $otherContracts[$i];
				$contractIni = $contract["CONTRACT_INIDATE"];
				$contractEnd = $contract["CONTRACT_ENDATE"];

				// IF INI HOUR INSIDE RANGE
				if($CONTRACT_INIDATE >= $contractIni and $CONTRACT_INIDATE < $contractEnd)
				{$save = 0;break;}
			
				// IF END HOUR INSIDE RANGE
				if($CONTRACT_ENDATE >= $contractIni and $CONTRACT_ENDATE < $contractEnd)
				{$save = 0;break;}
				
				// IF REG INI INSIDE RANGE
				if($contractIni >= $CONTRACT_INIDATE and $contractIni < $CONTRACT_ENDATE)
				{$save = 0;break;}
			
				// IF REG END INSIDE RANGE
				if($contractEnd >= $CONTRACT_INIDATE and $contractEnd < $CONTRACT_INIDATE)
				{$save = 0;break;}
				
			}
			
			if($save == 0)
			{
				$resp["message"] = "cross";
				return $resp;
			}
			
			
			$CONTRACT_VISIT_GOALS = $info["CONTRACT_VISIT_GOALS"];
			$CONTRACT_OTHER_GOALS = $info["CONTRACT_OTHER_GOALS"];
			$CONTRACT_EVENT_GOALS = $info["CONTRACT_EVENT_GOALS"];

			

			$str = "UPDATE wp_contracts SET 
			CONTRACT_REQTYPE = '".$CONTRACT_REQTYPE."',
			CONTRACT_NUMBER = '".$CONTRACT_NUMBER."',
			CONTRACT_INIDATE = '".$CONTRACT_INIDATE."',
			CONTRACT_ENDATE = '".$CONTRACT_ENDATE."',
			CONTRACT_USERTYPE = '".$CONTRACT_USERTYPE."',
			CONTRACT_PROGRAM = '".$CONTRACT_PROGRAM."',
			CONTRACT_ACTIVITIES = '".$CONTRACT_ACTIVITIES."',
			CONTRACT_ZONES = '".$CONTRACT_ZONES."',
			CONTRACT_VISIT_GOALS = '".$CONTRACT_VISIT_GOALS."',
			CONTRACT_CANREM = '".$CONTRACT_CANREM."',
			CONTRACT_CANREM_GET = '".$CONTRACT_CANREM_GET."',
			CONTRACT_OTHER_GOALS = '".$CONTRACT_OTHER_GOALS."',
			CONTRACT_EVENT_GOALS = '".$CONTRACT_EVENT_GOALS."'
			WHERE 
			CONTRACT_CODE ='".$CONTRACT_CODE."'";

			$resp["message"] = "updated";
			
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
			
			return $resp;
		}
		else if($MODE == "2")
		{
			
			$CONTRACT_CODE = $info["CONTRACT_CODE"];
		
			$str = "UPDATE wp_contracts SET 
			CONTRACT_REQUESTER = '".$CONTRACT_REQUESTER."',
			CONTRACT_CESION_STATE = '2'
			WHERE 
			CONTRACT_CODE ='".$CONTRACT_CODE."'";
			$query = $this->db->query($str);
			
			$resp["message"] = "cesionRequest";
			return $resp;
		}
		else
		{
			$now = new DateTime();
			$now = $now->format('Y-m-d');
			$CONTRACT_CODE = md5($CONTRACT_ENTITY.$CONTRACT_REQUESTER.$CONTRACT_NUMBER);
			
			$str = "INSERT INTO wp_contracts (
			CONTRACT_CODE,
			CONTRACT_REQTYPE,
			CONTRACT_NUMBER,
			CONTRACT_INIDATE,
			CONTRACT_ENDATE,
			CONTRACT_USERTYPE,
			CONTRACT_PROGRAM,
			CONTRACT_ACTIVITIES,
			CONTRACT_ZONES,
			CONTRACT_CREATED,
			CONTRACT_REQUESTER,
			CONTRACT_ENTITY) VALUES (
			'".$CONTRACT_CODE."',
			'".$CONTRACT_REQTYPE."',
			'".$CONTRACT_NUMBER."',
			'".$CONTRACT_INIDATE."',
			'".$CONTRACT_ENDATE."',
			'".$CONTRACT_USERTYPE."',
			'".$CONTRACT_PROGRAM."',
			'".$CONTRACT_ACTIVITIES."',
			'".$CONTRACT_ZONES."',
			'".$CONTRACT_CREATED."',
			'".$CONTRACT_REQUESTER."',
			'".$CONTRACT_ENTITY."'
			)";
			$query = $this->db->query($str);
			
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
			
			$message = "Se enviÃ³ su solicitud de contrato y esta en espera de aprobaciÃ³n.";

			// SEND MAIL 
			$data = array();
			$data["subject"] = "Solicitud de contrato enviada - DIOGENES";
			$data["email"] = $info["USER_EMAIL"];
			$data["content"] = "Mensaje de administrador DIOGENES<br><br>".$message."<br><br>";
			$data["header"] = "-";
			$data["footer"] = "-";
			
			$send = $this->myMailer($data, "")["message"];
			$resp["message"] = $send;
		}
		
		// SEND REQUEST EMAIL TO USER
		// SEND REQUEST EMAIL TO USER
		// SEND REQUEST EMAIL TO USER
		// SEND REQUEST EMAIL TO USER

		return $resp;
		
	}
	function saveProgram($info)
	{

		$PROGRAM_ENTITY = $info["PROGRAM_ENTITY"];
		$PROGRAM_NAME = $info["PROGRAM_NAME"];
		$PROGRAM_CODE = $info["PROGRAM_CODE"];
		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT PROGRAM_NAME FROM wp_programs WHERE PROGRAM_NAME = '".$PROGRAM_NAME."' AND PROGRAM_ENTITY = '".$PROGRAM_ENTITY."' AND PROGRAM_CODE != '".$PROGRAM_CODE."'";
		$query = $this->db->query($str);
		if(count($query) > 0)
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{

			$str = "SELECT PROGRAM_NAME FROM wp_projects WHERE PROGRAM_NAME = '".$PROGRAM_NAME."' AND PROGRAM_ENTITY = '".$PROGRAM_ENTITY."' AND PROGRAM_CODE != '".$PROGRAM_CODE."'";
			if(count($query) > 0)
			{$resp["message"] = "exists";return $resp;}
			
			
			$str = "UPDATE wp_programs SET 
			PROGRAM_ENTITY = '".$PROGRAM_ENTITY."',
			PROGRAM_NAME = '".$PROGRAM_NAME."'
			WHERE 
			PROGRAM_CODE ='".$PROGRAM_CODE."'";

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
			$now = $now->format('Y-m-d');
			$PROGRAM_CODE = md5($PROGRAM_ENTITY.$PROGRAM_NAME);
			
			$str = "INSERT INTO wp_programs (
			PROGRAM_ENTITY,
			PROGRAM_NAME,
			PROGRAM_CODE) VALUES (
			'".$PROGRAM_ENTITY."',
			'".$PROGRAM_NAME."',
			'".$PROGRAM_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveProject($info)
	{

		$PROJECT_ENTITY = $info["PROJECT_ENTITY"];
		$PROJECT_PROGRAM = $info["PROJECT_PROGRAM"];
		$PROJECT_NAME = $info["PROJECT_NAME"];
		$PROJECT_CODE = $info["PROJECT_CODE"];
		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT PROJECT_NAME FROM wp_projects WHERE PROJECT_NAME = '".$PROJECT_NAME."' AND PROJECT_ENTITY = '".$PROJECT_ENTITY."'";
		$query = $this->db->query($str);
		if(count($query) > 0 and $MODE == "0")
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{
			
			$str = "SELECT PROJECT_NAME FROM wp_projects WHERE PROJECT_NAME = '".$PROJECT_NAME."' AND PROJECT_ENTITY = '".$PROJECT_ENTITY."' AND PROJECT_CODE != '".$PROJECT_CODE."'";
			if(count($query) > 0)
			{$resp["message"] = "exists";return $resp;}
			
			
			$str = "UPDATE wp_projects SET 
			PROJECT_ENTITY = '".$PROJECT_ENTITY."',
			PROJECT_PROGRAM = '".$PROJECT_PROGRAM."',
			PROJECT_NAME = '".$PROJECT_NAME."'
			WHERE 
			PROJECT_CODE ='".$PROJECT_CODE."'";

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
			$now = $now->format('Y-m-d');
			$PROJECT_CODE = md5($PROJECT_ENTITY.$PROJECT_NAME.$now);
			
			$str = "INSERT INTO wp_projects (
			PROJECT_ENTITY,
			PROJECT_PROGRAM,
			PROJECT_NAME,
			PROJECT_CODE) VALUES (
			'".$PROJECT_ENTITY."',
			'".$PROJECT_PROGRAM."',
			'".$PROJECT_NAME."',
			'".$PROJECT_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveActivity($info)
	{

		$ACTIVITY_ENTITY = $info["ACTIVITY_ENTITY"];
		$ACTIVITY_PROJECT = $info["ACTIVITY_PROJECT"];
		$ACTIVITY_NAME = $info["ACTIVITY_NAME"];
		$ACTIVITY_COG = $info["ACTIVITY_COG"];
		$ACTIVITY_CODE = $info["ACTIVITY_CODE"];
		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT ACTIVITY_NAME FROM wp_activities WHERE ACTIVITY_NAME = '".$ACTIVITY_NAME."' AND ACTIVITY_ENTITY = '".$ACTIVITY_ENTITY."' AND ACTIVITY_CODE != '".$ACTIVITY_CODE."'";
		$query = $this->db->query($str);
		if(count($query) > 0)
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{

			$str = "UPDATE wp_activities SET 
			ACTIVITY_ENTITY = '".$ACTIVITY_ENTITY."',
			ACTIVITY_PROJECT = '".$ACTIVITY_PROJECT."',
			ACTIVITY_NAME = '".$ACTIVITY_NAME."',
			ACTIVITY_COG = '".$ACTIVITY_COG."'
			WHERE 
			ACTIVITY_CODE ='".$ACTIVITY_CODE."'";

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
			$now = $now->format('Y-m-d');
			$ACTIVITY_CODE = md5($ACTIVITY_ENTITY.$ACTIVITY_NAME);
			
			$str = "INSERT INTO wp_activities (
			ACTIVITY_ENTITY,
			ACTIVITY_PROJECT,
			ACTIVITY_NAME,
			ACTIVITY_COG,
			ACTIVITY_CODE) VALUES (
			'".$ACTIVITY_ENTITY."',
			'".$ACTIVITY_PROJECT."',
			'".$ACTIVITY_NAME."',
			'".$ACTIVITY_COG."',
			'".$ACTIVITY_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveEntity($info)
	{

		$ENTITY_CITY = $info["ENTITY_CITY"];
		$ENTITY_NAME = $info["ENTITY_NAME"];
		$ENTITY_VUNTIL = $info["ENTITY_VUNTIL"];
		$ENTITY_CODE = $info["ENTITY_CODE"];
		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT ENTITY_NAME FROM wp_entities WHERE ENTITY_NAME = '".$ENTITY_NAME."'";
		$query = $this->db->query($str);
		if(count($query) > 0 and $MODE == "0")
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{

			$str = "UPDATE wp_entities SET 
			ENTITY_CITY = '".$ENTITY_CITY."',
			ENTITY_NAME = '".$ENTITY_NAME."',
			ENTITY_VUNTIL = '".$ENTITY_VUNTIL."'
			WHERE 
			ENTITY_CODE ='".$ENTITY_CODE."'";

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
			$now = $now->format('Y-m-d');
			$ENTITY_CODE = md5($ENTITY_NAME.$now);
			
			$str = "INSERT INTO wp_entities (
			ENTITY_CITY,
			ENTITY_NAME,
			ENTITY_VUNTIL,
			ENTITY_CODE) VALUES (
			'".$ENTITY_CITY."',
			'".$ENTITY_NAME."',
			'".$ENTITY_VUNTIL."',
			'".$ENTITY_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveZone($info)
	{

		$ZONE_CITY = $info["ZONE_CITY"];
		$ZONE_TYPE = $info["ZONE_TYPE"];
		$ZONE_NAME = $info["ZONE_NAME"];
		$ZONE_CODE = $info["ZONE_CODE"];
		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT ZONE_NAME FROM wp_zones WHERE ZONE_NAME = '".$ZONE_NAME."' AND ZONE_CODE != '".$ZONE_CODE."'";
		$query = $this->db->query($str);
		if(count($query) > 0)
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{

			$str = "UPDATE wp_zones SET 
			ZONE_CITY = '".$ZONE_CITY."',
			ZONE_TYPE = '".$ZONE_TYPE."',
			ZONE_NAME = '".$ZONE_NAME."'
			WHERE 
			ZONE_CODE ='".$ZONE_CODE."'";

			$resp["message"] = "updated";
			
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
			
			
			// UPDATE HOODS
			
			$str = "UPDATE wp_hoods SET 
			HOOD_CITY = '".$ZONE_CITY."'
			WHERE 
			HOOD_ZONE ='".$ZONE_CODE."'";
			$query = $this->db->query($str);
			
			return $resp;
			
		}
		else
		{
			
			$now = new DateTime();
			$now = $now->format('Y-m-d');
			$ZONE_CODE = md5($ZONE_NAME.$now);
			
			$str = "INSERT INTO wp_zones (
			ZONE_CITY,
			ZONE_TYPE,
			ZONE_NAME,
			ZONE_CODE) VALUES (
			'".$ZONE_CITY."',
			'".$ZONE_TYPE."',
			'".$ZONE_NAME."',
			'".$ZONE_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveHood($info)
	{

		$HOOD_CITY = $info["HOOD_CITY"];
		$HOOD_ZONE = $info["HOOD_ZONE"];
		$HOOD_TYPE = $info["HOOD_TYPE"];
		$HOOD_NAME = $info["HOOD_NAME"];
		$HOOD_CODE = $info["HOOD_CODE"];
		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT HOOD_NAME FROM wp_hoods WHERE HOOD_NAME = '".$HOOD_NAME."' AND HOOD_CODE != '".$HOOD_CODE."' AND HOOD_ZONE = '".$HOOD_ZONE."'";
		$query = $this->db->query($str);
		if(count($query) > 0)
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{

			$str = "UPDATE wp_hoods SET 
			HOOD_CITY = '".$HOOD_CITY."',
			HOOD_ZONE = '".$HOOD_ZONE."',
			HOOD_TYPE = '".$HOOD_TYPE."',
			HOOD_NAME = '".$HOOD_NAME."'
			WHERE 
			HOOD_CODE ='".$HOOD_CODE."'";

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
			$now = $now->format('Y-m-d');
			$HOOD_CODE = md5($HOOD_NAME.$now);
			
			$str = "INSERT INTO wp_hoods (
			HOOD_CITY,
			HOOD_ZONE,
			HOOD_TYPE,
			HOOD_NAME,
			HOOD_CODE) VALUES (
			'".$HOOD_CITY."',
			'".$HOOD_ZONE."',
			'".$HOOD_TYPE."',
			'".$HOOD_NAME."',
			'".$HOOD_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveCondition($info)
	{

		$CONDITION_ENTITY = $info["CONDITION_ENTITY"];
		$CONDITION_NAME = $info["CONDITION_NAME"];
		$CONDITION_CODE = $info["CONDITION_CODE"];
		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT CONDITION_NAME FROM wp_conditions WHERE CONDITION_NAME = '".$CONDITION_NAME."' AND CONDITION_ENTITY = '".$CONDITION_ENTITY."'";
		$query = $this->db->query($str);
		if(count($query) > 0 and $MODE == "0")
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{

			$str = "UPDATE wp_conditions SET 
			CONDITION_ENTITY = '".$CONDITION_ENTITY."',
			CONDITION_NAME = '".$CONDITION_NAME."'
			WHERE 
			CONDITION_CODE ='".$CONDITION_CODE."'";

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
			$now = $now->format('Y-m-d');
			$CONDITION_CODE = md5($CONDITION_ENTITY.$CONDITION_NAME);
			
			$str = "INSERT INTO wp_conditions (
			CONDITION_ENTITY,
			CONDITION_NAME,
			CONDITION_CODE) VALUES (
			'".$CONDITION_ENTITY."',
			'".$CONDITION_NAME."',
			'".$CONDITION_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveEtnia($info)
	{

		$ETNIA_ENTITY = $info["ETNIA_ENTITY"];
		$ETNIA_NAME = $info["ETNIA_NAME"];
		$ETNIA_CODE = $info["ETNIA_CODE"];
		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT ETNIA_NAME FROM wp_etnias WHERE ETNIA_NAME = '".$ETNIA_NAME."' AND ETNIA_ENTITY = '".$ETNIA_ENTITY."'";
		$query = $this->db->query($str);
		if(count($query) > 0 and $MODE == "0")
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{

			$str = "UPDATE wp_etnias SET 
			ETNIA_ENTITY = '".$ETNIA_ENTITY."',
			ETNIA_NAME = '".$ETNIA_NAME."'
			WHERE 
			ETNIA_CODE ='".$ETNIA_CODE."'";

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
			$now = $now->format('Y-m-d');
			$ETNIA_CODE = md5($ETNIA_ENTITY.$ETNIA_NAME);
			
			$str = "INSERT INTO wp_etnias (
			ETNIA_ENTITY,
			ETNIA_NAME,
			ETNIA_CODE) VALUES (
			'".$ETNIA_ENTITY."',
			'".$ETNIA_NAME."',
			'".$ETNIA_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveCitizen($info)
	{

		$CITIZEN_NAME = addslashes($info["CITIZEN_NAME"]);
		$CITIZEN_LASTNAME = addslashes($info["CITIZEN_LASTNAME"]);
		$CITIZEN_IDTYPE = $info["CITIZEN_IDTYPE"];
		$CITIZEN_IDNUM = $info["CITIZEN_IDNUM"];
		$CITIZEN_BDAY = $info["CITIZEN_BDAY"];
		$CITIZEN_PHONE = $info["CITIZEN_PHONE"];
		$CITIZEN_EMAIL = $info["CITIZEN_EMAIL"];
		
		$CITIZEN_CITY = $info["CITIZEN_CITY"];
		$CITIZEN_ZONE = $info["CITIZEN_ZONE"];
		$CITIZEN_HOOD = $info["CITIZEN_HOOD"];
		$CITIZEN_LEVEL = $info["CITIZEN_LEVEL"];
		
		$CITIZEN_ADDRESS = $info["CITIZEN_ADDRESS"];
		$CITIZEN_GENDER = $info["CITIZEN_GENDER"];
		$CITIZEN_ETNIA = $info["CITIZEN_ETNIA"];
		$CITIZEN_CONDITION = $info["CITIZEN_CONDITION"];
		$CITIZEN_CODE = $info["CITIZEN_CODE"];
		
		$MODE = $info["MODE"];
		
		// NEW FIELDS
		
		
		$CITIZEN_ETNIA_IND = $info["CITIZEN_ETNIA_IND"];
		$CITIZEN_ORIGIN_COUNTRY = $info["CITIZEN_ORIGIN_COUNTRY"];
		$CITIZEN_DESTINY_COUNTRY = $info["CITIZEN_DESTINY_COUNTRY"];
		$CITIZEN_STAY_REASON = $info["CITIZEN_STAY_REASON"];
		$CITIZEN_MIGREXP = $info["CITIZEN_MIGREXP"];
		$CITIZEN_INDATE = $info["CITIZEN_INDATE"];
		$CITIZEN_OUTDATE = $info["CITIZEN_OUTDATE"];
		$CITIZEN_RETURN_REASON = $info["CITIZEN_RETURN_REASON"];
		$CITIZEN_SITAC = $info["CITIZEN_SITAC"];
		$CITIZEN_ACUDIENT = $info["CITIZEN_ACUDIENT"];
		$CITIZEN_BIRTH_CITY = $info["CITIZEN_BIRTH_CITY"];
		$CITIZEN_SISCORE = $info["CITIZEN_SISCORE"];
		$CITIZEN_CONVAC = $info["CITIZEN_CONVAC"];
		$CITIZEN_TIPOCO = $info["CITIZEN_TIPOCO"];
		$CITIZEN_TIPOVI = $info["CITIZEN_TIPOVI"];
		$CITIZEN_HANDICAP = $info["CITIZEN_HANDICAP"];
		$CITIZEN_ETGROUP = $info["CITIZEN_ETGROUP"];
		$CITIZEN_SECURITY = $info["CITIZEN_SECURITY"];
		$CITIZEN_EPS = $info["CITIZEN_EPS"];
		$CITIZEN_PATOEN = $info["CITIZEN_PATOEN"];
		$CITIZEN_TRASDES = $info["CITIZEN_TRASDES"];
		$CITIZEN_RISKFA = $info["CITIZEN_RISKFA"];
		$CITIZEN_PREVFA = $info["CITIZEN_PREVFA"];
		$CITIZEN_WEIGHT = $info["CITIZEN_WEIGHT"];
		$CITIZEN_HEIGHT = $info["CITIZEN_HEIGHT"];
		$CITIZEN_IMC = $info["CITIZEN_IMC"];
		$CITIZEN_IMC_RATE = $info["CITIZEN_IMC_RATE"];
		$CITIZEN_EDLEVEL = $info["CITIZEN_EDLEVEL"];
		$CITIZEN_INSTITUTE = $info["CITIZEN_INSTITUTE"];
		$CITIZEN_COURSES = $info["CITIZEN_COURSES"];
		$CITIZEN_OCUCOND = $info["CITIZEN_OCUCOND"];
		$CITIZEN_INGREC = $info["CITIZEN_INGREC"];
		
		
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		// CHECK IF ID EXISTS
		$str = "SELECT CITIZEN_IDNUM FROM wp_citizens WHERE CITIZEN_IDNUM = '".$CITIZEN_IDNUM."'";
		$query = $this->db->query($str);
		if(count($query) > 0 and $MODE == "0")
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{
			
			// CHECK IF ID EXISTS
			$str = "SELECT CITIZEN_IDNUM FROM wp_citizens WHERE CITIZEN_IDNUM = '".$CITIZEN_IDNUM."' AND CITIZEN_CODE != '".$CITIZEN_CODE."'";
			$query = $this->db->query($str);
			if(count($query) > 0)
			{$resp["message"] = "exists";return $resp;}
			
			$str = "UPDATE wp_citizens SET 
			CITIZEN_NAME = '".$CITIZEN_NAME."',
			CITIZEN_LASTNAME = '".$CITIZEN_LASTNAME."',
			CITIZEN_IDTYPE = '".$CITIZEN_IDTYPE."',
			CITIZEN_IDNUM = '".$CITIZEN_IDNUM."',
			CITIZEN_BDAY = '".$CITIZEN_BDAY."',
			CITIZEN_PHONE = '".$CITIZEN_PHONE."',
			CITIZEN_EMAIL = '".$CITIZEN_EMAIL."',
			CITIZEN_CITY = '".$CITIZEN_CITY."',
			CITIZEN_ZONE = '".$CITIZEN_ZONE."',
			CITIZEN_HOOD = '".$CITIZEN_HOOD."',
			CITIZEN_LEVEL = '".$CITIZEN_LEVEL."',
			CITIZEN_ADDRESS = '".$CITIZEN_ADDRESS."',
			CITIZEN_GENDER = '".$CITIZEN_GENDER."',
			CITIZEN_ETNIA = '".$CITIZEN_ETNIA."',
			CITIZEN_CONDITION = '".$CITIZEN_CONDITION."',
			CITIZEN_ETNIA_IND = '".$CITIZEN_ETNIA_IND."',
			CITIZEN_ORIGIN_COUNTRY = '".$CITIZEN_ORIGIN_COUNTRY."',
			CITIZEN_DESTINY_COUNTRY = '".$CITIZEN_DESTINY_COUNTRY."',
			CITIZEN_STAY_REASON = '".$CITIZEN_STAY_REASON."',
			CITIZEN_MIGREXP = '".$CITIZEN_MIGREXP."',
			CITIZEN_INDATE = '".$CITIZEN_INDATE."',
			CITIZEN_OUTDATE = '".$CITIZEN_OUTDATE."',
			CITIZEN_RETURN_REASON = '".$CITIZEN_RETURN_REASON."',
			CITIZEN_SITAC = '".$CITIZEN_SITAC."',
			CITIZEN_ACUDIENT = '".$CITIZEN_ACUDIENT."',
			CITIZEN_BIRTH_CITY = '".$CITIZEN_BIRTH_CITY."',
			CITIZEN_SISCORE = '".$CITIZEN_SISCORE."',
			CITIZEN_CONVAC = '".$CITIZEN_CONVAC."',
			CITIZEN_TIPOCO = '".$CITIZEN_TIPOCO."',
			CITIZEN_TIPOVI = '".$CITIZEN_TIPOVI."',
			CITIZEN_HANDICAP = '".$CITIZEN_HANDICAP."',
			CITIZEN_ETGROUP = '".$CITIZEN_ETGROUP."',
			CITIZEN_SECURITY = '".$CITIZEN_SECURITY."',
			CITIZEN_EPS = '".$CITIZEN_EPS."',
			CITIZEN_PATOEN = '".$CITIZEN_PATOEN."',
			CITIZEN_TRASDES = '".$CITIZEN_TRASDES."',
			CITIZEN_RISKFA = '".$CITIZEN_RISKFA."',
			CITIZEN_PREVFA = '".$CITIZEN_PREVFA."',
			CITIZEN_WEIGHT = '".$CITIZEN_WEIGHT."',
			CITIZEN_HEIGHT = '".$CITIZEN_HEIGHT."',
			CITIZEN_IMC = '".$CITIZEN_IMC."',
			CITIZEN_IMC_RATE = '".$CITIZEN_IMC_RATE."',
			CITIZEN_EDLEVEL = '".$CITIZEN_EDLEVEL."',
			CITIZEN_INSTITUTE = '".$CITIZEN_INSTITUTE."',
			CITIZEN_COURSES = '".$CITIZEN_COURSES."',
			CITIZEN_OCUCOND = '".$CITIZEN_OCUCOND."',
			CITIZEN_INGREC = '".$CITIZEN_INGREC."'
			WHERE 
			CITIZEN_CODE ='".$CITIZEN_CODE."'";

			$resp["message"] = "updated";
			
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
			
			// return $resp;
			
		}
		else
		{
			
			$CITIZEN_CODE = md5($CITIZEN_NAME.$CITIZEN_LASTNAME.$now);
			
			$str = "INSERT INTO wp_citizens (
			CITIZEN_NAME,
			CITIZEN_LASTNAME,
			CITIZEN_IDTYPE,
			CITIZEN_IDNUM,
			CITIZEN_BDAY,
			CITIZEN_PHONE,
			CITIZEN_EMAIL,
			CITIZEN_CITY,
			CITIZEN_ZONE,
			CITIZEN_HOOD,
			CITIZEN_LEVEL,
			CITIZEN_ADDRESS,
			CITIZEN_GENDER,
			CITIZEN_ETNIA,
			CITIZEN_CONDITION,
			CITIZEN_ETNIA_IND,
			CITIZEN_ORIGIN_COUNTRY,
			CITIZEN_DESTINY_COUNTRY,
			CITIZEN_STAY_REASON,
			CITIZEN_MIGREXP,
			CITIZEN_INDATE,
			CITIZEN_OUTDATE,
			CITIZEN_RETURN_REASON,
			CITIZEN_SITAC,
			CITIZEN_ACUDIENT,
			CITIZEN_BIRTH_CITY,
			CITIZEN_SISCORE,
			CITIZEN_CONVAC,
			CITIZEN_TIPOCO,
			CITIZEN_TIPOVI,
			CITIZEN_HANDICAP,
			CITIZEN_ETGROUP,
			CITIZEN_SECURITY,
			CITIZEN_EPS,
			CITIZEN_PATOEN,
			CITIZEN_TRASDES,
			CITIZEN_RISKFA,
			CITIZEN_PREVFA,
			CITIZEN_WEIGHT,
			CITIZEN_HEIGHT,
			CITIZEN_IMC,
			CITIZEN_IMC_RATE,
			CITIZEN_EDLEVEL,
			CITIZEN_INSTITUTE,
			CITIZEN_COURSES,
			CITIZEN_OCUCOND,
			CITIZEN_INGREC,
			CITIZEN_CODE) VALUES (
			'".$CITIZEN_NAME."',
			'".$CITIZEN_LASTNAME."',
			'".$CITIZEN_IDTYPE."',
			'".$CITIZEN_IDNUM."',
			'".$CITIZEN_BDAY."',
			'".$CITIZEN_PHONE."',
			'".$CITIZEN_EMAIL."',
			'".$CITIZEN_CITY."',
			'".$CITIZEN_ZONE."',
			'".$CITIZEN_HOOD."',
			'".$CITIZEN_LEVEL."',
			'".$CITIZEN_ADDRESS."',
			'".$CITIZEN_GENDER."',
			'".$CITIZEN_ETNIA."',
			'".$CITIZEN_CONDITION."',
			'".$CITIZEN_ETNIA_IND."',
			'".$CITIZEN_ORIGIN_COUNTRY."',
			'".$CITIZEN_DESTINY_COUNTRY."',
			'".$CITIZEN_STAY_REASON."',
			'".$CITIZEN_MIGREXP."',
			'".$CITIZEN_INDATE."',
			'".$CITIZEN_OUTDATE."',
			'".$CITIZEN_RETURN_REASON."',
			'".$CITIZEN_SITAC."',
			'".$CITIZEN_ACUDIENT."',
			'".$CITIZEN_BIRTH_CITY."',
			'".$CITIZEN_SISCORE."',
			'".$CITIZEN_CONVAC."',
			'".$CITIZEN_TIPOCO."',
			'".$CITIZEN_TIPOVI."',
			'".$CITIZEN_HANDICAP."',
			'".$CITIZEN_ETGROUP."',
			'".$CITIZEN_SECURITY."',
			'".$CITIZEN_EPS."',
			'".$CITIZEN_PATOEN."',
			'".$CITIZEN_TRASDES."',
			'".$CITIZEN_RISKFA."',
			'".$CITIZEN_PREVFA."',
			'".$CITIZEN_WEIGHT."',
			'".$CITIZEN_HEIGHT."',
			'".$CITIZEN_IMC."',
			'".$CITIZEN_IMC_RATE."',
			'".$CITIZEN_EDLEVEL."',
			'".$CITIZEN_INSTITUTE."',
			'".$CITIZEN_COURSES."',
			'".$CITIZEN_OCUCOND."',
			'".$CITIZEN_INGREC."',
			'".$CITIZEN_CODE."'
			)";
			$query = $this->db->query($str);

			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}
		

		// ADD TO GROUP IF FROM GROUPS
		if($info["GROUP_ADD"] == "y")
		{
			$GROUP_CODE = $info["GROUP_CODE"];
			
			// GET ACTUAL CITIZENS FROM GROUP AS ARRAY
			$str = "SELECT GROUP_CITIZENS FROM wp_groups WHERE 
			GROUP_CODE = '".$GROUP_CODE."'";
			$query = $this->db->query($str);
			
			$GROUP_CITIZENS = $query[0]["GROUP_CITIZENS"];
			
			if($GROUP_CITIZENS == null){$GROUP_CITIZENS = array();}
			else
			{$GROUP_CITIZENS = json_decode($GROUP_CITIZENS, true);}
			
			// CHECK IF ALREADY IN GROUP RETURN
			$exist = 0;
			for($i=0; $i<count($GROUP_CITIZENS); $i++)
			{
				$item = $GROUP_CITIZENS[$i];
				if($item["CITIZEN_IDNUM"] == $CITIZEN_IDNUM)
				{$resp["message"] = "ingroup"; return $resp;}
			}
			
			$newCitizen = array();			
			$newCitizen["CITIZEN_GROUP"] = $GROUP_CODE;			
			$newCitizen["CITIZEN_IDTYPE"] = $CITIZEN_IDTYPE;
			$newCitizen["CITIZEN_IDNUM"] = $CITIZEN_IDNUM;
			$newCitizen["CITIZEN_BDAY"] = $CITIZEN_BDAY;
			$newCitizen["CITIZEN_ASSIST"] = "0";
			
			// ADD TO GROUP CITIZENS
			array_push($GROUP_CITIZENS, $newCitizen);
			
			// RESAVE TO GROUP
			$GROUP_CITIZENS = json_encode($GROUP_CITIZENS, true);
			$str = "UPDATE wp_groups SET 
			GROUP_CITIZENS = '".$GROUP_CITIZENS."'
			WHERE 
			GROUP_CODE ='".$GROUP_CODE."'";
			$query = $this->db->query($str);
		
		}
		
		// ADD TO GROUP AND CLASS IF FROM CLASS
		if($info["GROUP_ADD"] == "cl")
		{
			// ADD TO CLASS IF NO EXIST
			// ADD TO CLASS IF NO EXIST
			// ADD TO CLASS IF NO EXIST
			
			$GROUP_CODE = $info["GROUP_CODE"];
			$CLASS_CODE = $info["CLASS_CODE"];
			
			// GET ACTUAL CITIZENS FROM CLASS AS ARRAY
			$str = "SELECT CLASS_CITIZENS FROM wp_classes WHERE 
			CLASS_CODE = '".$CLASS_CODE."'";
			$query = $this->db->query($str);
			
			$CLASS_CITIZENS = $query[0]["CLASS_CITIZENS"];
			$CLASS_CITIZENS = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($CLASS_CITIZENS));
			
			if($CLASS_CITIZENS == null){$CLASS_CITIZENS = array();}
			else
			{$CLASS_CITIZENS = json_decode($CLASS_CITIZENS, true);}
			
			
			// CHECK IF ALREADY IN CLASS RETURN
			for($i=0; $i<count($CLASS_CITIZENS); $i++)
			{
				$item = $CLASS_CITIZENS[$i];
				if($item["CITIZEN_IDNUM"] == $CITIZEN_IDNUM)
				{$resp["message"] = "inClass"; return $resp;}
			}
			
			$newCitizen = array();			
			$newCitizen["CITIZEN_GROUP"] = $GROUP_CODE;			
			$newCitizen["CITIZEN_IDTYPE"] = $CITIZEN_IDTYPE;
			$newCitizen["CITIZEN_IDNUM"] = $CITIZEN_IDNUM;
			$newCitizen["CITIZEN_BDAY"] = $CITIZEN_BDAY;
			$newCitizen["CITIZEN_ASSIST"] = "0";
			
			// GET AGE
			$d1 = $CITIZEN_BDAY;
			$d2 = $now;
			$diff = abs(strtotime($d1) - strtotime($d2));
			$age = floor($diff / (365*60*60*24));
			$CITIZEN_AGE = $age;
			
			$newCitizen["CITIZEN_AGE"] = $CITIZEN_AGE;
			
			// ADD TO CLASS CITIZENS
			array_push($CLASS_CITIZENS, $newCitizen);
			
			// RESAVE TO CLASS
			$CLASS_CITIZENS = json_encode($CLASS_CITIZENS, true);
			$str = "UPDATE wp_classes SET 
			CLASS_CITIZENS = '".$CLASS_CITIZENS."'
			WHERE 
			CLASS_CODE ='".$CLASS_CODE."'";
			$query = $this->db->query($str);

			// ADD TO GROUP IF NOT EXIST
			// ADD TO GROUP IF NOT EXIST
			// ADD TO GROUP IF NOT EXIST
			
			$GROUP_CODE = $info["GROUP_CODE"];

			// GET ACTUAL CITIZENS FROM GROUP AS ARRAY
			$str = "SELECT GROUP_CITIZENS FROM wp_groups WHERE 
			GROUP_CODE = '".$GROUP_CODE."'";
			$query = $this->db->query($str);
			
			$GROUP_CITIZENS = $query[0]["GROUP_CITIZENS"];
			
			if($GROUP_CITIZENS == null){$GROUP_CITIZENS = array();}
			else
			{$GROUP_CITIZENS = json_decode($GROUP_CITIZENS, true);}
			
			// CHECK IF ALREADY IN GROUP
			$exist = 0;
			for($i=0; $i<count($GROUP_CITIZENS); $i++)
			{
				$item = $GROUP_CITIZENS[$i];
				if($item["CITIZEN_IDNUM"] == $CITIZEN_IDNUM)
				{$exist = 1;}
			}
			
			// ADD TO GROUP IF NOT EXIST
			
			if($exist == 0)
			{
				$newCitizen = array();			
				$newCitizen["CITIZEN_GROUP"] = $GROUP_CODE;			
				$newCitizen["CITIZEN_IDTYPE"] = $CITIZEN_IDTYPE;
				$newCitizen["CITIZEN_IDNUM"] = $CITIZEN_IDNUM;
				$newCitizen["CITIZEN_BDAY"] = $CITIZEN_BDAY;
				$newCitizen["CITIZEN_ASSIST"] = "0";
				
				// ADD TO GROUP CITIZENS
				array_push($GROUP_CITIZENS, $newCitizen);
				
				// RESAVE TO GROUP
				$GROUP_CITIZENS = json_encode($GROUP_CITIZENS, true);
				$str = "UPDATE wp_groups SET 
				GROUP_CITIZENS = '".$GROUP_CITIZENS."'
				WHERE 
				GROUP_CODE ='".$GROUP_CODE."'";
				$query = $this->db->query($str);
			}
		
		}
		
		return $resp;
		
	}
	function saveGroup($info)
	{
	
		$GROUP_ENTITY = $info["GROUP_ENTITY"];
		$GROUP_NAME = $info["GROUP_NAME"];
		$GROUP_ACTIVITY = $info["GROUP_ACTIVITY"];
		$GROUP_HOOD = $info["GROUP_HOOD"];
		$GROUP_INSTYPE = $info["GROUP_INSTYPE"];
		$GROUP_INSTITUTE = $info["GROUP_INSTITUTE"];
		$GROUP_PREVIR = $info["GROUP_PREVIR"];
		$GROUP_ADDRESS = $info["GROUP_ADDRESS"];
		$GROUP_COORDS = $info["GROUP_COORDS"];
		$GROUP_COPERATOR = $info["GROUP_COPERATOR"];
		$GROUP_CODE = $info["GROUP_CODE"];
		$GROUP_SERVPLACE = $info["GROUP_SERVPLACE"];
		$GROUP_PROCESS = $info["GROUP_PROCESS"];
		
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s' );
		
		$GROUP_CREATED = $now;
		
		
		$MODE = $info["MODE"];
		
		// CHECK IF ID EXISTS
		$str = "SELECT GROUP_NAME FROM wp_groups WHERE GROUP_NAME = '".$GROUP_NAME."'";
		$query = $this->db->query($str);
		if(count($query) > 0 and $MODE == "0")
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{
			
			// CHECK IF ID EXISTS
			$str = "SELECT GROUP_NAME FROM wp_groups WHERE GROUP_NAME = '".$GROUP_NAME."' AND GROUP_CODE != '".$GROUP_CODE."'";
			$query = $this->db->query($str);
			if(count($query) > 0)
			{$resp["message"] = "exists";return $resp;}
			
			$str = "UPDATE wp_groups SET 
			GROUP_NAME = '".$GROUP_NAME."',
			GROUP_ACTIVITY = '".$GROUP_ACTIVITY."',
			GROUP_HOOD = '".$GROUP_HOOD."',
			GROUP_INSTYPE = '".$GROUP_INSTYPE."',
			GROUP_INSTITUTE = '".$GROUP_INSTITUTE."',
			GROUP_PREVIR = '".$GROUP_PREVIR."',
			GROUP_ADDRESS = '".$GROUP_ADDRESS."',
			GROUP_COORDS = '".$GROUP_COORDS."',
			GROUP_COPERATOR = '".$GROUP_COPERATOR."',
			GROUP_PROCESS = '".$GROUP_PROCESS."',
			GROUP_SERVPLACE = '".$GROUP_SERVPLACE."'
			WHERE 
			GROUP_CODE ='".$GROUP_CODE."'";

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
			$now = $now->format('Y-m-d');
			$GROUP_CODE = md5($GROUP_NAME.$now);
			
			$str = "INSERT INTO wp_groups (
			GROUP_ENTITY,
			GROUP_CREATED,
			GROUP_NAME,
			GROUP_ACTIVITY,
			GROUP_HOOD,
			GROUP_INSTYPE,
			GROUP_INSTITUTE,
			GROUP_PREVIR,
			GROUP_ADDRESS,
			GROUP_COORDS,
			GROUP_COPERATOR,
			GROUP_SERVPLACE,
			GROUP_PROCESS,
			GROUP_CODE) VALUES (
			'".$GROUP_ENTITY."',
			'".$GROUP_CREATED."',
			'".$GROUP_NAME."',
			'".$GROUP_ACTIVITY."',
			'".$GROUP_HOOD."',
			'".$GROUP_INSTYPE."',
			'".$GROUP_INSTITUTE."',
			'".$GROUP_PREVIR."',
			'".$GROUP_ADDRESS."',
			'".$GROUP_COORDS."',
			'".$GROUP_COPERATOR."',
			'".$GROUP_SERVPLACE."',
			'".$GROUP_PROCESS."',
			'".$GROUP_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveClass($info)
	{
		
		$CLASS_ENTITY = $info["CLASS_ENTITY"];
		$CLASS_GROUP = $info["CLASS_GROUP"];
		$CLASS_HOUR = json_encode($info["CLASS_HOUR"], true);
		$CLASS_DATE = $info["CLASS_DATE"];
		$CLASS_CODE = $info["CLASS_CODE"];
		$MODE = $info["MODE"];

		if($MODE == "1")
		{
			
			$str = "UPDATE wp_classes SET 
			CLASS_ENTITY = '".$CLASS_ENTITY."',
			CLASS_HOUR = '".$CLASS_HOUR."',
			CLASS_DATE = '".$CLASS_DATE."'
			WHERE 
			CLASS_CODE ='".$CLASS_CODE."'";

			$resp["message"] = "updated";
			
			$query = $this->db->query($str);
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
			
			return $resp;
			
		}
		else
		{
			
			$CLASS_ACTIVITY = $info["CLASS_ACTIVITY"];
			$CLASS_TUTOR = $info["CLASS_TUTOR"];
			$citizens = $info["CLASS_CITIZENS"];
			$CLASS_CITIZENS = json_encode($citizens, true);
			$CLASS_EXCUSE = $info["CLASS_EXCUSE"];
			$CLASS_TIME_INI = $info["CLASS_TIME_INI"];
			$CLASS_TIME_END = $info["CLASS_TIME_END"];
			// $CLASS_GROUP_DATA = $info["CLASS_GROUP_DATA"];
			$CLASS_GROUP_DATA = "";
			$CLASS_CONTRACT_NUMBER = $info["CLASS_CONTRACT_NUMBER"];
			
			
			// $data = array();
			// $data["table"] = "wp_contracts";
			// $data["fields"] = " CONTRACT_CODE ";
			// $data["keyField"] = " CONTRACT_NUMBER ";
			// $data["code"] = $CLASS_CONTRACT_NUMBER;
			
			// $friendlyData = $this->getFriendlyData($data)["message"];
			
			$str = "SELECT CONTRACT_OTHER_GOALS, CONTRACT_CODE FROM wp_contracts WHERE CONTRACT_NUMBER = '".$CLASS_CONTRACT_NUMBER."' AND CONTRACT_ENTITY = '".$CLASS_ENTITY."'";
			$query = $this->db->query($str);
			
			$friendlyData = $query[0];
			$CLASS_CONTRACT_CODE = $friendlyData["CONTRACT_CODE"];
			
			// GET CONTRACT VISIT GOALS FOR GROUP CHECK
			$data = array();
			$data["table"] = "wp_contracts";
			$data["fields"] = " CONTRACT_OTHER_GOALS ";
			$data["keyField"] = " CONTRACT_NUMBER ";
			$data["code"] = $CLASS_CONTRACT_NUMBER;
			
			$friendlyData = $this->getFriendlyData($data)["message"];
			$CLASS_ACTIVITY_GOALS = $friendlyData["CONTRACT_OTHER_GOALS"];
			
			if(isset($CLASS_ACTIVITY_GOALS) and $CLASS_ACTIVITY_GOALS != null and $CLASS_ACTIVITY_GOALS != "" and $CLASS_ACTIVITY_GOALS != "null")
			{
				$goals = json_decode($CLASS_ACTIVITY_GOALS, true);
				for($i=0; $i<count($goals); $i++)
				{
					if(array_key_exists("V4", $goals[$i]))
					{
						if($goals[$i]["V4"] == $CLASS_GROUP)
						{
							$tmp = $goals[$i]["V1"];
							
							if($tmp == null)
							{
								
								$CLASS_ACTIVITY_GOALS = 0;
								$CLASS_GROUP_GOAL = "0";
								$CLASS_CLASSES_GOAL = "0";
								$CLASS_TIMES_GOAL = "0";
								$CLASS_PEOPLE_GOAL = "0";
								$tmp = 0;
								
								// $resp["message"] = "lololo";
								// $resp["status"] = true;
								// return $resp;
							}

							$goalsData = $goals[$i];
							
							$CLASSES_GOAL = $goalsData["V1"];
							$HOURS_GOAL = intval($goalsData["V2"])/60;
							$PEOPLE_GOAL = $goalsData["V3"];
							
							$CLASS_GROUP_GOAL = count($goals);
							$CLASS_CLASSES_GOAL = $CLASSES_GOAL;
							$CLASS_TIMES_GOAL = $HOURS_GOAL;
							$CLASS_PEOPLE_GOAL = $PEOPLE_GOAL;
							break;
						}
					}
				}
				
				if($tmp == null)
				{
					$CLASS_ACTIVITY_GOALS = 0;
					$CLASS_GROUP_GOAL = "0";
					$CLASS_CLASSES_GOAL = "0";
					$CLASS_TIMES_GOAL = "0";
					$CLASS_PEOPLE_GOAL = "0";
				}
				else
				{
					$CLASS_ACTIVITY_GOALS = $tmp;
				}
				
				
			}
			else
			{
				$CLASS_ACTIVITY_GOALS = 0;
				$CLASS_GROUP_GOAL = "0";
				$CLASS_CLASSES_GOAL = "0";
				$CLASS_TIMES_GOAL = "0";
				$CLASS_PEOPLE_GOAL = "0";
			}
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s' );
			$CLASS_CREATED = $now;
			
			// CREATE CODE IF FROM USER
			if($CLASS_CODE == "")
			{
				$CLASS_CODE = md5($CLASS_GROUP.$CLASS_DATE.$CLASS_TIME_INI);
				$CLASS_CREATED = $CLASS_DATE." ".$CLASS_TIME_INI.":00";
				
				// CHECK IF USER CLASS HOUR IF FROM USER
				// CHECK IF USER CLASS HOUR IF FROM USER
				// CHECK IF USER CLASS HOUR IF FROM USER
				
				$str = "SELECT CLASS_HOUR FROM wp_classes WHERE 
				CLASS_TUTOR = '".$CLASS_TUTOR."' AND CLASS_DATE = '".$CLASS_DATE."'";
				$myDayClasses = $this->db->query($str);
				
				
				// GET SIMULTANEOUS CLASSES
				$CLASS_INI = $CLASS_TIME_INI;
				$CLASS_END = $CLASS_TIME_END;
				
				$simultaneous = array();
				for($i=0; $i<count($myDayClasses); $i++)
				{
					$add = 1;
					
					$class = $myDayClasses[$i];
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

				if(count($simultaneous) > 0)
				{
					$resp["message"] = "classCross";
					$resp["status"] = true;
					return $resp;
				}
				
			}

			$str = "INSERT INTO wp_classes (
			CLASS_ENTITY,
			CLASS_GROUP,
			CLASS_ACTIVITY,
			CLASS_HOUR,
			CLASS_TUTOR,
			CLASS_DATE,
			CLASS_CITIZENS,
			CLASS_EXCUSE,
			CLASS_CREATED,
			CLASS_CONTRACT_NUMBER,
			CLASS_CONTRACT_CODE,
			CLASS_ACTIVITY_GOALS,
			CLASS_GROUP_GOAL,
			CLASS_CLASSES_GOAL,
			CLASS_TIMES_GOAL,
			CLASS_PEOPLE_GOAL,
			CLASS_CODE) VALUES (
			'".$CLASS_ENTITY."',
			'".$CLASS_GROUP."',
			'".$CLASS_ACTIVITY."',
			'".$CLASS_HOUR."',
			'".$CLASS_TUTOR."',
			'".$CLASS_DATE."',
			'".$CLASS_CITIZENS."',
			'".$CLASS_EXCUSE."',
			'".$CLASS_CREATED."',
			'".$CLASS_CONTRACT_NUMBER."',
			'".$CLASS_CONTRACT_CODE."',
			'".$CLASS_ACTIVITY_GOALS."',
			'".$CLASS_GROUP_GOAL."',
			'".$CLASS_CLASSES_GOAL."',
			'".$CLASS_TIMES_GOAL."',
			'".$CLASS_PEOPLE_GOAL."',
			'".$CLASS_CODE."')  
			ON DUPLICATE KEY UPDATE CLASS_HOUR = '".$CLASS_HOUR."'";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			// $logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveVisit($info)
	{
		
		$VISIT_ENTITY = $info["VISIT_ENTITY"];
		$VISIT_CODE = $info["VISIT_CODE"];
		$VISIT_CLASS = $info["VISIT_CLASS"];
		$VISIT_DATE = $info["VISIT_DATE"];
		$VISIT_DONE = $info["VISIT_DONE"];
		$VISIT_TYPE = $info["VISIT_TYPE"];
		$VISIT_ASSISTQTY = $info["VISIT_ASSISTQTY"];
		$VISIT_NOASSISTQTY = $info["VISIT_NOASSISTQTY"];
		$VISIT_STONTIME = $info["VISIT_STONTIME"];
		$VISIT_TOOLS = $info["VISIT_TOOLS"];
		$VISIT_GOODTIME = $info["VISIT_GOODTIME"];
		$VISIT_GOODPLACE = $info["VISIT_GOODPLACE"];
		$VISIT_FORMAT = $info["VISIT_FORMAT"];
		$VISIT_PDELIVER = $info["VISIT_PDELIVER"];
		$VISIT_COHERENT = $info["VISIT_COHERENT"];
		$VISIT_EASY = $info["VISIT_EASY"];
		$VISIT_ORIENT = $info["VISIT_ORIENT"];
		$VISIT_EXPRESSION = $info["VISIT_EXPRESSION"];
		$VISIT_PRESENT = $info["VISIT_PRESENT"];
		$VISIT_VERIFIED = $info["VISIT_VERIFIED"];
		$VISIT_ACOMPLISH = $info["VISIT_ACOMPLISH"];
		$VISIT_CONTRATIST_SIGN = $info["VISIT_CONTRATIST_SIGN"];
		$VISIT_SIGNED = $info["VISIT_SIGNED"];
		$VISIT_COMMENTS = $info["VISIT_COMMENTS"];
		$VISIT_CONTRACT_CODE = $info["VISIT_CONTRACT_CODE"];
		$VISIT_CLASS_PLAN = $info["VISIT_CLASS_PLAN"];
		$VISIT_ASSIST_LIST = $info["VISIT_ASSIST_LIST"];
		$VISIT_CLASSPIC = $info["VISIT_CLASSPIC"];
		
		$VISIT_SIGNED = $info["VISIT_SIGNED"];

		
		$MODE = $info["MODE"];
		
		// CHECK IF CLASS EXISTS
		// $checkCode = md5($CLASS_GROUP.$CLASS_DATE.$CLASS_TIME_INI);
		
		
		if($MODE == "1")
		{
			
			if($VISIT_ASSIST_LIST == "")
			{
				$str = "UPDATE wp_visits SET 
				VISIT_DONE = '".$VISIT_DONE."',
				VISIT_TYPE = '".$VISIT_TYPE."',
				VISIT_ASSISTQTY = '".$VISIT_ASSISTQTY."',
				VISIT_NOASSISTQTY = '".$VISIT_NOASSISTQTY."',
				VISIT_STONTIME = '".$VISIT_STONTIME."',
				VISIT_TOOLS = '".$VISIT_TOOLS."',
				VISIT_GOODTIME = '".$VISIT_GOODTIME."',
				VISIT_GOODPLACE = '".$VISIT_GOODPLACE."',
				VISIT_FORMAT = '".$VISIT_FORMAT."',
				VISIT_PDELIVER = '".$VISIT_PDELIVER."',
				VISIT_COHERENT = '".$VISIT_COHERENT."',
				VISIT_EASY = '".$VISIT_EASY."',
				VISIT_ORIENT = '".$VISIT_ORIENT."',
				VISIT_EXPRESSION = '".$VISIT_EXPRESSION."',
				VISIT_PRESENT = '".$VISIT_PRESENT."',
				VISIT_VERIFIED = '".$VISIT_VERIFIED."',
				VISIT_ACOMPLISH = '".$VISIT_ACOMPLISH."',
				VISIT_CONTRATIST_SIGN = '".$VISIT_CONTRATIST_SIGN."',
				VISIT_SIGNED = '".$VISIT_SIGNED."',
				VISIT_COMMENTS = '".$VISIT_COMMENTS."'
				WHERE 
				VISIT_CODE ='".$VISIT_CODE."'";
			}
			else
			{
				$str = "UPDATE wp_visits SET 
				VISIT_DONE = '".$VISIT_DONE."',
				VISIT_TYPE = '".$VISIT_TYPE."',
				VISIT_ASSISTQTY = '".$VISIT_ASSISTQTY."',
				VISIT_NOASSISTQTY = '".$VISIT_NOASSISTQTY."',
				VISIT_STONTIME = '".$VISIT_STONTIME."',
				VISIT_TOOLS = '".$VISIT_TOOLS."',
				VISIT_GOODTIME = '".$VISIT_GOODTIME."',
				VISIT_GOODPLACE = '".$VISIT_GOODPLACE."',
				VISIT_FORMAT = '".$VISIT_FORMAT."',
				VISIT_PDELIVER = '".$VISIT_PDELIVER."',
				VISIT_COHERENT = '".$VISIT_COHERENT."',
				VISIT_EASY = '".$VISIT_EASY."',
				VISIT_ORIENT = '".$VISIT_ORIENT."',
				VISIT_EXPRESSION = '".$VISIT_EXPRESSION."',
				VISIT_PRESENT = '".$VISIT_PRESENT."',
				VISIT_VERIFIED = '".$VISIT_VERIFIED."',
				VISIT_ACOMPLISH = '".$VISIT_ACOMPLISH."',
				VISIT_CONTRATIST_SIGN = '".$VISIT_CONTRATIST_SIGN."',
				VISIT_SIGNED = '".$VISIT_SIGNED."',
				VISIT_COMMENTS = '".$VISIT_COMMENTS."',
				VISIT_CLASS_PLAN = '".$VISIT_CLASS_PLAN."',
				VISIT_ASSIST_LIST = '".$VISIT_ASSIST_LIST."',
				VISIT_CLASSPIC = '".$VISIT_CLASSPIC."'
				WHERE 
				VISIT_CODE ='".$VISIT_CODE."'";
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
			
			$VISIT_GROUP = $info["VISIT_GROUP"];
			$VISIT_CONTRACT = $info["VISIT_CONTRACT"];
			$VISIT_ACTIVITY = $info["VISIT_ACTIVITY"];
			$VISIT_CLASS_DATE = $info["VISIT_CLASS_DATE"];
			$VISIT_CLASS_INI_TIME = $info["VISIT_CLASS_INI_TIME"];
			$VISIT_COORD = $info["VISIT_COORD"];
			$VISIT_CLASS_COORD = $info["VISIT_CLASS_COORD"];
			$VISIT_CONTRATIST = $info["VISIT_CONTRATIST"];
			$VISIT_VISITOR = $info["VISIT_VISITOR"];
			$VISIT_HOOD = $info["VISIT_HOOD"];
			$VISIT_ZONE = $info["VISIT_ZONE"];
			$VISIT_ADDRESS = $info["VISIT_ADDRESS"];
			$VISIT_MODE = $info["VISIT_MODE"];
			$VISIT_CONTRACT_CODE = $info["VISIT_CONTRACT_CODE"];
			
			// CREATE CODE IF FROM USER
			if($VISIT_CODE == "")
			{$VISIT_CODE = md5($VISIT_CLASS.$VISIT_DATE);}
			
			$VISIT_OWNER = $info["ucode"];
			
			$data = array();
			$data["table"] = "wp_groups";
			$data["fields"] = " GROUP_NAME ";
			$data["keyField"] = " GROUP_CODE ";
			$data["code"] = $VISIT_GROUP;
			
			$friendlyData = $this->getFriendlyData($data)["message"];
			$VISIT_GROUP_NAME = $friendlyData["GROUP_NAME"];

			
			$str = "INSERT INTO wp_visits (
			VISIT_ENTITY,
			VISIT_MODE,
			VISIT_CONTRACT_CODE,
			VISIT_GROUP,
			VISIT_CONTRACT,
			VISIT_ACTIVITY,
			VISIT_CLASS_DATE,
			VISIT_CLASS_INI_TIME,
			VISIT_OWNER,
			VISIT_CLASS,
			VISIT_DATE,
			VISIT_DONE,
			VISIT_TYPE,
			VISIT_ASSISTQTY,
			VISIT_NOASSISTQTY,
			VISIT_STONTIME,
			VISIT_TOOLS,
			VISIT_GOODTIME,
			VISIT_GOODPLACE,
			VISIT_FORMAT,
			VISIT_PDELIVER,
			VISIT_COHERENT,
			VISIT_EASY,
			VISIT_ORIENT,
			VISIT_EXPRESSION,
			VISIT_PRESENT,
			VISIT_VERIFIED,
			VISIT_ACOMPLISH,
			VISIT_CONTRATIST_SIGN,
			VISIT_SIGNED,
			VISIT_COMMENTS,
			VISIT_CLASS_PLAN,
			VISIT_ASSIST_LIST,
			VISIT_CLASSPIC,
			VISIT_COORD,
			VISIT_CLASS_COORD,
			VISIT_CONTRATIST,
			VISIT_VISITOR,
			VISIT_GROUP_NAME,
			VISIT_HOOD,
			VISIT_ZONE,
			VISIT_ADDRESS,
			VISIT_CODE) VALUES (
			'".$VISIT_ENTITY."',
			'".$VISIT_MODE."',
			'".$VISIT_CONTRACT_CODE."',
			'".$VISIT_GROUP."',
			'".$VISIT_CONTRACT."',
			'".$VISIT_ACTIVITY."',
			'".$VISIT_CLASS_DATE."',
			'".$VISIT_CLASS_INI_TIME."',
			'".$VISIT_OWNER."',
			'".$VISIT_CLASS."',
			'".$VISIT_DATE."',
			'".$VISIT_DONE."',
			'".$VISIT_TYPE."',
			'".$VISIT_ASSISTQTY."',
			'".$VISIT_NOASSISTQTY."',
			'".$VISIT_STONTIME."',
			'".$VISIT_TOOLS."',
			'".$VISIT_GOODTIME."',
			'".$VISIT_GOODPLACE."',
			'".$VISIT_FORMAT."',
			'".$VISIT_COHERENT."',
			'".$VISIT_PDELIVER."',
			'".$VISIT_EASY."',
			'".$VISIT_ORIENT."',
			'".$VISIT_EXPRESSION."',
			'".$VISIT_PRESENT."',
			'".$VISIT_VERIFIED."',
			'".$VISIT_ACOMPLISH."',
			'".$VISIT_CONTRATIST_SIGN."',
			'".$VISIT_SIGNED."',
			'".$VISIT_COMMENTS."',
			'".$VISIT_CLASS_PLAN."',
			'".$VISIT_ASSIST_LIST."',
			'".$VISIT_CLASSPIC."',
			'".$VISIT_COORD."',
			'".$VISIT_CLASS_COORD."',
			'".$VISIT_CONTRATIST."',
			'".$VISIT_VISITOR."',
			'".$VISIT_GROUP_NAME."',
			'".$VISIT_HOOD."',
			'".$VISIT_ZONE."',
			'".$VISIT_ADDRESS."',
			'".$VISIT_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			// $logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function aprobeContract($info)
	{
		$CONTRACT_NUMBER = $info["CONTRACT_NUMBER"];
		$CONTRACT_INIDATE = $info["CONTRACT_INIDATE"];
		$CONTRACT_ENDATE = $info["CONTRACT_ENDATE"];
		$CONTRACT_ENTITY = $info["CONTRACT_ENTITY"];
		$CONTRACT_REQUESTER = $info["CONTRACT_REQUESTER"];
		$CONTRACT_APROVED_BY = $info["CONTRACT_APROVED_BY"];
		$CONTRACT_CODE = $info["CONTRACT_CODE"];
		$CONTRACT_CANREM = $info["CONTRACT_CANREM"];
		$CONTRACT_CANREM_GET = $info["CONTRACT_CANREM_GET"];
		
		$CONTRACT_VISIT_GOALS = $info["CONTRACT_VISIT_GOALS"];
		$CONTRACT_OTHER_GOALS = $info["CONTRACT_OTHER_GOALS"];
		$CONTRACT_EVENT_GOALS = $info["CONTRACT_EVENT_GOALS"];
		
		$str = "SELECT CONTRACT_NUMBER FROM wp_contracts WHERE CONTRACT_NUMBER = '".$CONTRACT_NUMBER."' AND CONTRACT_ENTITY = '".$CONTRACT_ENTITY."' AND CONTRACT_CODE != '".$CONTRACT_CODE."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$resp["message"] = "exist";
			$resp["status"] = true;
			return $resp;
		}
		

		$str = "UPDATE wp_contracts SET 
		CONTRACT_NUMBER = '".$CONTRACT_NUMBER."',
		CONTRACT_INIDATE = '".$CONTRACT_INIDATE."',
		CONTRACT_ENDATE = '".$CONTRACT_ENDATE."',
		CONTRACT_OWNER = '".$CONTRACT_REQUESTER."',
		CONTRACT_APROVED_BY = '".$CONTRACT_APROVED_BY."',
		CONTRACT_VISIT_GOALS = '".$CONTRACT_VISIT_GOALS."',
		CONTRACT_OTHER_GOALS = '".$CONTRACT_OTHER_GOALS."',
		CONTRACT_EVENT_GOALS = '".$CONTRACT_EVENT_GOALS."',
		CONTRACT_CESION_STATE = '0',
		CONTRACT_CANREM = '".$CONTRACT_CANREM."',
		CONTRACT_CANREM_GET = '".$CONTRACT_CANREM_GET."',
		CONTRACT_STATE = '4'
		WHERE 
		CONTRACT_CODE ='".$CONTRACT_CODE."'";

		$resp["message"] = "aprobed";
		
		$query = $this->db->query($str);
		
		$message = "Se ha aprobado su contrato ".$CONTRACT_NUMBER." en la plataforma DIOGENES.";
		// SEND MAIL 
		$data = array();
		$data["subject"] = "Se ha aprobado su contrato - DIOGENES";
		$data["email"] = $info["USER_EMAIL"];
		$data["content"] = "Mensaje de administrador DIOGENES<br><br>".$message."<br><br>";
		$data["header"] = "-";
		$data["footer"] = "-";
		
		$send = $this->myMailer($data, "")["message"];
		$resp["message"] = $send;
		
		
		// SEND APROBAL EMAIL
		// SEND APROBAL EMAIL
		// SEND APROBAL EMAIL
		
		// ------------------LOGSAVE-----------------
		$logSave = $this->logw($info);
		// ------------------LOGSAVE-----------------
		
		$resp["status"] = true;
		return $resp;
	}
	function saveAssignation($info)
	{
		$CONTRACT_CODE = $info["CONTRACT_CODE"];
		$GROUP_CODE = $info["GROUP_CODE"];
		$CONTRACT_OTHER_GOALS = $info["CONTRACT_OTHER_GOALS"];
		
		// CHECK FOR EXISTING HOURS AND COINCIDENDE, DELETE THIS GROUP CROSS TIMES
		
		// GET GROUP HOURS
		$str = "SELECT GROUP_HOURS, GROUP_CONTRACT FROM wp_groups WHERE GROUP_CODE = '".$GROUP_CODE."' AND GROUP_HOURS != 'null' AND GROUP_HOURS != '[]'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			$GROUP_CONTRACT = $CONTRACT_CODE;
			$NEWHOURS = json_decode($query[0]["GROUP_HOURS"], true);
			
			
			
						
			$deleteHours = array();
			
			for($h=0; $h<count($NEWHOURS); $h++)
			{
				$dayName = $NEWHOURS[$h]["GROUP_TIME_DAY"];
				$REMCOM_DATE_INI = $NEWHOURS[$h]["GROUP_TIME_INI"];
				$REMCOM_DATE_END = $NEWHOURS[$h]["GROUP_TIME_END"];

				// VERIFY DATE TIME CROSING WITH NEW CONTRATIST CLASES
				$data = array();
				$data["CONTRACT"] = $GROUP_CONTRACT;
				$CONTRATIST_HOURS = $this->getUserContractGroupHours($data)["message"];

				if(count($CONTRATIST_HOURS) > 0)
				{
					// FILTER DAY HOURS
					for($i=0; $i<count($CONTRATIST_HOURS); $i++)
					{
						// CHECK SAME DAY ONLY
						if($CONTRATIST_HOURS[$i]["GROUP_TIME_DAY"] == $dayName)
						{
							$GINI_TIME = $CONTRATIST_HOURS[$i]["GROUP_TIME_INI"];
							$GEND_TIME = $CONTRATIST_HOURS[$i]["GROUP_TIME_END"];
							$add = 1;
							// IF INI HOUR INSIDE RANGE
							if($REMCOM_DATE_INI >= $GINI_TIME and $REMCOM_DATE_INI < $GEND_TIME){$add = 0;}
							// IF END HOUR INSIDE RANGE
							if($REMCOM_DATE_END > $GINI_TIME and $REMCOM_DATE_END < $GEND_TIME){$add = 0;}
							// IF REG INI INSIDE RANGE
							if($GINI_TIME >= $REMCOM_DATE_INI and $GINI_TIME < $REMCOM_DATE_END){$add = 0;}
							// IF REG END INSIDE RANGE
							if($GEND_TIME > $REMCOM_DATE_INI and $GEND_TIME < $REMCOM_DATE_END){$add = 0;}
							if($add == 0 and $CONTRATIST_HOURS[$i]["GROUP_CODE"] != $GROUP_CODE)
							{array_push($deleteHours, $NEWHOURS[$h]["GROUP_TIME_CODE"]);}
						}
					}
				}

			}
			
			// IGNORE PICKED ITEMS FROM NEW HOURS THEN UPDATE GROUP HOURS
			$newHoursPicked = array();
			
			for($h=0; $h<count($NEWHOURS); $h++)
			{
				$TCODE = $NEWHOURS[$h]["GROUP_TIME_CODE"];
				if(in_array($TCODE, $deleteHours)){continue;}
				array_push($newHoursPicked, $NEWHOURS[$h]);
			}

			$NEWHOURS = json_encode($newHoursPicked, true);
			$NEWHOURS = str_replace("Mi\u00e9rcoles","Miércoles",$NEWHOURS);
			$NEWHOURS = str_replace("S\u00e1bado","Sábado",$NEWHOURS);

			$str = "UPDATE wp_groups SET GROUP_HOURS = '".$NEWHOURS."' WHERE GROUP_CODE ='".$GROUP_CODE."'";
			$query = $this->db->query($str);
			
		}
		
		
		// -------------------SAVE IF REACH
		
		$str = "UPDATE wp_contracts SET 
		CONTRACT_OTHER_GOALS = '".$CONTRACT_OTHER_GOALS."'
		WHERE 
		CONTRACT_CODE ='".$CONTRACT_CODE."'";
		$query = $this->db->query($str);
		
		$str = "UPDATE wp_groups SET 
		GROUP_CONTRACT = '".$CONTRACT_CODE."',
		GROUP_STATUS = '1' 
		WHERE 
		GROUP_CODE ='".$GROUP_CODE."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = "updated";
		$resp["status"] = true;
		return $resp;
	}
	function saveExcuse($info)
	{
		$CLASS_CODE = $info["CLASS_CODE"];
		$CLASS_EXCUSE = $info["CLASS_EXCUSE"];
		
		$str = "UPDATE wp_classes SET 
		CLASS_EXCUSE = '".$CLASS_EXCUSE."'
		WHERE 
		CLASS_CODE ='".$CLASS_CODE."'";
		$query = $this->db->query($str);
		
		$ans = "updated";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveEtarie($info)
	{

		$ETARIE_ENTITY = $info["ETARIE_ENTITY"];
		$ETARIE_NAME = $info["ETARIE_NAME"];
		$ETARIE_FROM = $info["ETARIE_FROM"];
		$ETARIE_TO = $info["ETARIE_TO"];
		$ETARIE_CODE = $info["ETARIE_CODE"];
		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT ETARIE_NAME FROM wp_etaries WHERE ETARIE_NAME = '".$ETARIE_NAME."' AND ETARIE_ENTITY = '".$ETARIE_ENTITY."'";
		$query = $this->db->query($str);
		if(count($query) > 0 and $MODE == "0")
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{
			
			// CHECK IF ID EXISTS
			$str = "SELECT ETARIE_NAME FROM wp_etaries WHERE ETARIE_NAME = '".$ETARIE_NAME."' AND ETARIE_CODE != '".$ETARIE_CODE."'";
			$query = $this->db->query($str);
			if(count($query) > 0)
			{$resp["message"] = "exists";return $resp;}
			
			
			$str = "UPDATE wp_etaries SET 
			ETARIE_ENTITY = '".$ETARIE_ENTITY."',
			ETARIE_NAME = '".$ETARIE_NAME."',
			ETARIE_FROM = '".$ETARIE_FROM."',
			ETARIE_TO = '".$ETARIE_TO."'
			WHERE 
			ETARIE_CODE ='".$ETARIE_CODE."'";

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
			$now = $now->format('Y-m-d');
			$ETARIE_CODE = md5($ETARIE_ENTITY.$ETARIE_NAME.$now);
			
			$str = "INSERT INTO wp_etaries (
			ETARIE_ENTITY,
			ETARIE_NAME,
			ETARIE_FROM,
			ETARIE_TO,
			ETARIE_CODE) VALUES (
			'".$ETARIE_ENTITY."',
			'".$ETARIE_NAME."',
			'".$ETARIE_FROM."',
			'".$ETARIE_TO."',
			'".$ETARIE_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveInstitute($info)
	{

		$INSTITUTE_CITY = $info["INSTITUTE_CITY"];
		$INSTITUTE_NAME = $info["INSTITUTE_NAME"];
		$INSTITUTE_ZONE = $info["INSTITUTE_ZONE"];
		$INSTITUTE_HOOD = $info["INSTITUTE_HOOD"];
		$INSTITUTE_ADDRESS = $info["INSTITUTE_ADDRESS"];
		$INSTITUTE_COORDS = $info["INSTITUTE_COORDS"];
		$INSTITUTE_CODE = $info["INSTITUTE_CODE"];
		$INSTITUTE_EDU = $info["INSTITUTE_EDU"];
		$MODE = $info["MODE"];
		
		// CHECK IF NAME EXISTS
		$str = "SELECT INSTITUTE_NAME FROM wp_institutes WHERE INSTITUTE_NAME = '".$INSTITUTE_NAME."' AND INSTITUTE_CITY = '".$INSTITUTE_CITY."'";
		$query = $this->db->query($str);
		if(count($query) > 0 and $MODE == "0")
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{
			
			// CHECK IF ID EXISTS
			$str = "SELECT INSTITUTE_NAME FROM wp_institutes WHERE INSTITUTE_NAME = '".$INSTITUTE_NAME."' AND INSTITUTE_CITY = '".$INSTITUTE_CITY."' AND INSTITUTE_CODE != '".$INSTITUTE_CODE."'";
			$query = $this->db->query($str);
			if(count($query) > 0)
			{$resp["message"] = "exists";return $resp;}
			
			
			$str = "UPDATE wp_institutes SET 
			INSTITUTE_CITY = '".$INSTITUTE_CITY."',
			INSTITUTE_ZONE = '".$INSTITUTE_ZONE."',
			INSTITUTE_HOOD = '".$INSTITUTE_HOOD."',
			INSTITUTE_ADDRESS = '".$INSTITUTE_ADDRESS."',
			INSTITUTE_COORDS = '".$INSTITUTE_COORDS."',
			INSTITUTE_EDU = '".$INSTITUTE_EDU."',
			INSTITUTE_NAME = '".$INSTITUTE_NAME."'
			WHERE 
			INSTITUTE_CODE ='".$INSTITUTE_CODE."'";

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
			$now = $now->format('Y-m-d');
			$INSTITUTE_CODE = md5($INSTITUTE_CITY.$INSTITUTE_NAME.$now);
			
			$str = "INSERT INTO wp_institutes (
			INSTITUTE_CITY,
			INSTITUTE_NAME,
			INSTITUTE_ZONE,
			INSTITUTE_HOOD,
			INSTITUTE_ADDRESS,
			INSTITUTE_COORDS,
			INSTITUTE_EDU,
			INSTITUTE_CODE) VALUES 
			(
			'".$INSTITUTE_CITY."',
			'".$INSTITUTE_NAME."',
			'".$INSTITUTE_ZONE."',
			'".$INSTITUTE_HOOD."',
			'".$INSTITUTE_ADDRESS."',
			'".$INSTITUTE_COORDS."',
			'".$INSTITUTE_EDU."',
			'".$INSTITUTE_CODE."'
			)";
			
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveComment($info)
	{

		$REMCOM_ENTITY = $info["REMCOM_ENTITY"];
		$REMCOM_COMMENT = $info["REMCOM_COMMENT"];
		$REMCOM_COMMENT_DATE = $info["REMCOM_COMMENT_DATE"];
		$REMCOM_SPECIAL = $info["REMCOM_SPECIAL"];
		$REMCOM_FILE = $info["REMCOM_FILE"];
		$REMCOM_LINE = $info["REMCOM_LINE"];
		$REMCOM_TYPE = $info["REMCOM_TYPE"];
		$REMCOM_REMINI = $info["REMCOM_REMINI"];
		$REMCOM_DATE = $info["REMCOM_DATE"];
		$REMCOM_REMSTATE = $info["REMCOM_REMSTATE"];
		$REMCOM_ACTIVITY = $info["REMCOM_ACTIVITY"];
		$REMCOM_NEW_ACTIVITY = $info["REMCOM_NEW_ACTIVITY"];
		$REMCOM_NEW_CONTRATIST = $info["REMCOM_NEW_CONTRATIST"];
		$REMCOM_NEW_CONTRATIST_NAME = $info["REMCOM_NEW_CONTRATIST_NAME"];
		$REMCOM_GROUP = $info["REMCOM_GROUP"];
		$REMCOM_CREATED_BY = $info["REMCOM_CREATED_BY"];

		$REMCOM_MODE = $info["REMCOM_MODE"];
		$REMCOM_CITIZEN = $info["REMCOM_CITIZEN"];
		$REMCOM_CITIZEN_NAME = $info["REMCOM_CITIZEN_NAME"];
		$REMCOM_REQUESTER = $info["REMCOM_REQUESTER"];
		$REMCOM_REQUESTER_TYPE = $info["REMCOM_REQUESTER_TYPE"];
		$REMCOM_REQUESTER_NAME = $info["REMCOM_REQUESTER_NAME"];
		$REMCOM_REM_AUTOR = $info["REMCOM_REM_AUTOR"];
		$REMCOM_REM_AUTOR_NAME = $info["REMCOM_REM_AUTOR_NAME"];
		
		$REMCOM_AUTOR = $info["REMCOM_AUTOR"];
		$REMCOM_AUTOR_NAME = $info["REMCOM_AUTOR_NAME"];
		$REMCOM_CONTRATIST = $info["REMCOM_CONTRATIST"];
		$REMCOM_CONTRATIST_NAME = $info["REMCOM_CONTRATIST_NAME"];
		$REMCOM_REM_CODE = $info["REMCOM_REM_CODE"];
		
		
		$REMCOM_COMPONENT = $info["REMCOM_COMPONENT"];
		$REMCOM_SCOMPONENT = $info["REMCOM_SCOMPONENT"];
		
		

		if($REMCOM_MODE == "remit")
		{
			// GET CONTRATIST NAME
			$str = "SELECT USER_NAME, USER_LASTNAME FROM wp_trusers WHERE USER_CODE = '".$REMCOM_NEW_CONTRATIST."'";
			$CONTRATIST = $this->db->query($str);
			$REMCOM_NEW_CONTRATIST_NAME = $CONTRATIST[0]["USER_NAME"]." ".$CONTRATIST[0]["USER_LASTNAME"];
			
			$REMCOM_AUTOR = $info["REMCOM_REM_AUTOR"];
			$REMCOM_AUTOR_NAME = $info["REMCOM_REM_AUTOR_NAME"];
			
			$REMCOM_CONTRATIST = $info["REMCOM_NEW_CONTRATIST"];
			$REMCOM_CONTRATIST_NAME = $REMCOM_NEW_CONTRATIST_NAME;
			// $REMCOM_ACTIVITY = $REMCOM_NEW_ACTIVITY;
		}
		
		if($REMCOM_MODE == "date")
		{
			$REMCOM_DATE_DATE = $info["REMCOM_DATE_DATE"];
			$REMCOM_DATE_INI = $info["REMCOM_DATE_INI"];
			$REMCOM_DATE_END = $info["REMCOM_DATE_END"];
			$REMCOM_DATE_PLACE = $info["REMCOM_DATE_PLACE"];
			$REMCOM_USER_CONTRACT = $info["REMCOM_USER_CONTRACT"];
			
			
			// VERIFY DATE TIME CROSING WITH CONTRATIST OPEN DATES
			// VERIFY DATE TIME CROSING WITH CONTRATIST OPEN DATES
			// VERIFY DATE TIME CROSING WITH CONTRATIST OPEN DATES
			
			$now = new DateTime();
			$now = $now->format('Y-m-d');
			
			$str = "SELECT DATE_DATE, DATE_DATE_INI, DATE_DATE_END  FROM wp_dates WHERE 
			DATE_CONTRATIST = '".$REMCOM_CONTRATIST."' AND DATE_DATE >= '".$now."' AND DATE_STATE = '0' ";
			$query = $this->db->query($str);
			$actualDates = $query;
			
			if(count($actualDates)>0)
			{
				for($i=0; $i<count($actualDates); $i++)
				{
					// CHECK SAME DAY ONLY
					if($actualDates[$i]["DATE_DATE"] == $REMCOM_DATE_DATE)
					{
						$GINI_TIME = $actualDates[$i]["DATE_DATE_INI"];
						$GEND_TIME = $actualDates[$i]["DATE_DATE_END"];
						$add = 1;
						// IF INI HOUR INSIDE RANGE
						if($REMCOM_DATE_INI >= $GINI_TIME and $REMCOM_DATE_INI < $GEND_TIME){$add = 0;}
						// IF END HOUR INSIDE RANGE
						if($REMCOM_DATE_END > $GINI_TIME and $REMCOM_DATE_END < $GEND_TIME){$add = 0;}
						// IF REG INI INSIDE RANGE
						if($GINI_TIME >= $REMCOM_DATE_INI and $GINI_TIME < $REMCOM_DATE_END){$add = 0;}
						// IF REG END INSIDE RANGE
						if($GEND_TIME > $REMCOM_DATE_INI and $GEND_TIME < $REMCOM_DATE_END){$add = 0;}
						if($add == 0)
						{
							$resp["message"] = "citaCross";
							$resp["status"] = true;
							return $resp;
						}
					}
				}
			}
			
			// VERIFY DATE TIME CROSING WITH CONTRATIST CLASES
			// VERIFY DATE TIME CROSING WITH CONTRATIST CLASES
			// VERIFY DATE TIME CROSING WITH CONTRATIST CLASES
			$data = array();
			$data["CONTRACT"] = $REMCOM_USER_CONTRACT;
			$CONTRATIST_HOURS = $this->getUserContractGroupHours($data)["message"];
			if(count($CONTRATIST_HOURS) > 0)
			{
				// GET DATE DAY NAME
				$date = new DateTime($REMCOM_DATE_DATE);
				$day = $date->format('Y-m-d');
				$dayName = $date->format('D');
				if($dayName == "Mon"){$dayName = "Lunes";}
				if($dayName == "Tue"){$dayName = "Martes";}
				if($dayName == "Wed"){$dayName = "Miércoles";}
				if($dayName == "Thu"){$dayName = "Jueves";}
				if($dayName == "Fri"){$dayName = "Viernes";}
				if($dayName == "Sat"){$dayName = "Sábado";}
				if($dayName == "Sun"){$dayName = "Domingo";}
				
				// FILTER DAY HOURS
				for($i=0; $i<count($CONTRATIST_HOURS); $i++)
				{
					// CHECK SAME DAY ONLY
					if($CONTRATIST_HOURS[$i]["GROUP_TIME_DAY"] == $dayName)
					{
						$GINI_TIME = $CONTRATIST_HOURS[$i]["GROUP_TIME_INI"];
						$GEND_TIME = $CONTRATIST_HOURS[$i]["GROUP_TIME_END"];
						$add = 1;
						// IF INI HOUR INSIDE RANGE
						if($REMCOM_DATE_INI >= $GINI_TIME and $REMCOM_DATE_INI < $GEND_TIME){$add = 0;}
						// IF END HOUR INSIDE RANGE
						if($REMCOM_DATE_END > $GINI_TIME and $REMCOM_DATE_END < $GEND_TIME){$add = 0;}
						// IF REG INI INSIDE RANGE
						if($GINI_TIME >= $REMCOM_DATE_INI and $GINI_TIME < $REMCOM_DATE_END){$add = 0;}
						// IF REG END INSIDE RANGE
						if($GEND_TIME > $REMCOM_DATE_INI and $GEND_TIME < $REMCOM_DATE_END){$add = 0;}
						if($add == 0)
						{
							$resp["message"] = "dateCross";
							$resp["status"] = true;
							return $resp;
						}
					}
				}

			}
			
			
		}
		
		$REMCOM_AUTOR_CONTRACT = $info["REMCOM_AUTOR_CONTRACT"];
		$data = array();
		$data["CONTRACT_CODE"] = $REMCOM_AUTOR_CONTRACT;
		if(count($this->getContractData($data)["message"]) > 0)
		{
			$CONTRACT_DATA = $this->getContractData($data)["message"][0];
			$REMCOM_ACTUAL_CNUMBER = $CONTRACT_DATA["CONTRACT_NUMBER"];
		}
		else{$REMCOM_ACTUAL_CNUMBER = "-";}
	

		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$REMCOM_CODE = md5($REMCOM_DATE.$REMCOM_CREATED_BY.$now);
		
		$str = "INSERT INTO wp_attend (
		REMCOM_CODE,
		REMCOM_REM_CODE,
		REMCOM_ENTITY,
		REMCOM_CREATED_BY,
		REMCOM_COMMENT,
		REMCOM_COMMENT_DATE,
		REMCOM_SPECIAL,
		REMCOM_CITIZEN,
		REMCOM_CITIZEN_NAME,
		REMCOM_FILE,
		REMCOM_LINE,
		REMCOM_TYPE,
		REMCOM_REMINI,
		REMCOM_DATE,
		REMCOM_REMSTATE,
		REMCOM_AUTOR,
		REMCOM_AUTOR_NAME,
		REMCOM_CONTRATIST,
		REMCOM_CONTRATIST_NAME,
		REMCOM_ACTIVITY,
		REMCOM_NEW_ACTIVITY,
		REMCOM_NEW_CONTRATIST,
		REMCOM_NEW_CONTRATIST_NAME,
		REMCOM_ACTUAL_CNUMBER,
		REMCOM_COMPONENT,
		REMCOM_SCOMPONENT,
		REMCOM_GROUP) VALUES 
		(
		'".$REMCOM_CODE."',
		'".$REMCOM_REM_CODE."',
		'".$REMCOM_ENTITY."',
		'".$REMCOM_CREATED_BY."',
		'".$REMCOM_COMMENT."',
		'".$REMCOM_COMMENT_DATE."',
		'".$REMCOM_SPECIAL."',
		'".$REMCOM_CITIZEN."',
		'".$REMCOM_CITIZEN_NAME."',
		'".$REMCOM_FILE."',
		'".$REMCOM_LINE."',
		'".$REMCOM_TYPE."',
		'".$REMCOM_REMINI."',
		'".$REMCOM_DATE."',
		'".$REMCOM_REMSTATE."',
		'".$REMCOM_AUTOR."',
		'".$REMCOM_AUTOR_NAME."',
		'".$REMCOM_CONTRATIST."',
		'".$REMCOM_CONTRATIST_NAME."',
		'".$REMCOM_ACTIVITY."',
		'".$REMCOM_NEW_ACTIVITY."',
		'".$REMCOM_NEW_CONTRATIST."',
		'".$REMCOM_NEW_CONTRATIST_NAME."',
		'".$REMCOM_ACTUAL_CNUMBER."',
		'".$REMCOM_COMPONENT."',
		'".$REMCOM_SCOMPONENT."',
		'".$REMCOM_GROUP."'
		)";
		
		$query = $this->db->query($str);
		
		if($REMCOM_MODE == "addGroup")
		{
			// GET CITIZEN DATA
			$str = "SELECT CITIZEN_BDAY, CITIZEN_IDTYPE  FROM wp_citizens WHERE 
			CITIZEN_IDNUM = '".$REMCOM_CITIZEN."'";
			$query = $this->db->query($str);

			$GUY = $query[0];
			$GUY["CITIZEN_ASSIST"] = "0";
			$GUY["CITIZEN_GROUP"] = $REMCOM_GROUP;
			$GUY["CITIZEN_IDNUM"] = $REMCOM_CITIZEN;

			// GET GROUP ACTUAL LIST
			$str = "SELECT GROUP_CITIZENS, GROUP_NAME, GROUP_CONTRACT FROM wp_groups WHERE 
			GROUP_CODE = '".$REMCOM_GROUP."'";
			$query = $this->db->query($str);
			$GROUP_CITIZENS = $query[0]["GROUP_CITIZENS"];
			$GROUP_NAME = $query[0]["GROUP_NAME"];
			$GROUP_CONTRACT = $query[0]["GROUP_CONTRACT"];
			$GROUP_CITIZENS = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($GROUP_CITIZENS));
			if($GROUP_CITIZENS == null){$GROUP_CITIZENS = array();}
			else{$GROUP_CITIZENS = json_decode($GROUP_CITIZENS, true);}
			
			// ADD TO LIST
			array_push($GROUP_CITIZENS, $GUY);
				
			// UPDATE LIST
			$GROUP_CITIZENS = json_encode($GROUP_CITIZENS);
			$str = "UPDATE wp_groups SET GROUP_CITIZENS = '".$GROUP_CITIZENS."' WHERE 			GROUP_CODE ='".$REMCOM_GROUP."'";
			$query = $this->db->query($str);
			
			// --------------MAIL
			// --------------MAIL
			// --------------MAIL
			
			// GET GROUP OWNER
			$str = "SELECT CONTRACT_OWNER FROM wp_contracts WHERE CONTRACT_CODE = '".$GROUP_CONTRACT."'";
			$query = $this->db->query($str);
			if(count($query) > 0)
			{
				$CONTRACT_OWNER = $query[0]["CONTRACT_OWNER"];
				// GET OWNER EMAIL
				$str = "SELECT USER_EMAIL FROM wp_trusers WHERE USER_CODE = '".$CONTRACT_OWNER."'";
				$query = $this->db->query($str);
				$USER_EMAIL = $query[0]["USER_EMAIL"];
			}
			else
			{
				$CONTRACT_OWNER = $query[0]["CONTRACT_OWNER"];
				$USER_EMAIL = "";
			}
			
			// GET OWNER EMAIL
			$str = "SELECT USER_EMAIL FROM wp_trusers WHERE USER_CODE = '".$CONTRACT_OWNER."'";
			$query = $this->db->query($str);
			$USER_EMAIL = $query[0]["USER_EMAIL"];
			
			// GET CITIZEN EMAIL
			$str = "SELECT CITIZEN_EMAIL FROM wp_citizens WHERE CITIZEN_IDNUM = '".$REMCOM_CITIZEN."'";
			$query = $this->db->query($str);
			$CITIZEN_EMAIL = $query[0]["CITIZEN_EMAIL"];

			$groupName = $GROUP_NAME;
			$ownerEmail = $USER_EMAIL;
			$citizenEmail = $CITIZEN_EMAIL;
			
			$message = "Se ha agregado al ciudadano: ".$REMCOM_CITIZEN_NAME.", al grupo: ".$groupName;
			$data = array();
			$data["subject"] = "Ciudadano agregado a grupo";
			$data["content"] = "Mensaje de administrador DIOGENES<br><br>".$message."<br><br>";
			$data["header"] = "-";
			$data["footer"] = "-";
			
			// SEND TO BOTH
			if($citizenEmail != null and $citizenEmail != "")
			{
				$data["email"] = $ownerEmail;
				$send = $this->myMailer($data, $citizenEmail)["message"];
				$resp["message"] = "both: ".$send." - ".$ownerEmail." -- ".$citizenEmail." - ".$message;
				return $resp;
			}
			else
			{
				// SEND TO CONTRATIST ONLY
				$data["email"] = $ownerEmail;
				$send = $this->myMailer($data, "")["message"];
				$resp["message"] = "owner: ".$send." - ".$ownerEmail." - ".$message;
				return $resp;
			}

		}
		if($REMCOM_MODE == "quitGroup")
		{
			// GET GROUP ACTUAL LIST
			$str = "SELECT GROUP_CITIZENS FROM wp_groups WHERE 
			GROUP_CODE = '".$REMCOM_GROUP."'";
			$query = $this->db->query($str);
			$GROUP_CITIZENS = $query[0]["GROUP_CITIZENS"];
			$GROUP_CITIZENS = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($GROUP_CITIZENS));
			if($GROUP_CITIZENS == null){$GROUP_CITIZENS = array();}
			else{$GROUP_CITIZENS = json_decode($GROUP_CITIZENS, true);}
			
			$NEW_CITIZENS = array();
			
			for($i=0; $i<count($GROUP_CITIZENS); $i++)
			{
				$g = $GROUP_CITIZENS[$i];
				if($g["CITIZEN_IDNUM"] == $REMCOM_CITIZEN){continue;}
				else{array_push($NEW_CITIZENS, $g);}
			}
			
			// UPDATE LIST
			$GROUP_CITIZENS = json_encode($NEW_CITIZENS);
			$str = "UPDATE wp_groups SET GROUP_CITIZENS = '".$GROUP_CITIZENS."' WHERE 			GROUP_CODE ='".$REMCOM_GROUP."'";
			$query = $this->db->query($str);
			
			// --------------MAIL
			// --------------MAIL
			// --------------MAIL
			
			// GET GROUP ACTUAL LIST
			$str = "SELECT GROUP_CONTRACT, GROUP_NAME FROM wp_groups WHERE GROUP_CODE = '".$REMCOM_GROUP."'";
			$query = $this->db->query($str);
			$GROUP_CONTRACT = $query[0]["GROUP_CONTRACT"];
			$GROUP_NAME = $query[0]["GROUP_NAME"];
			
			
			// GET GROUP OWNER
			$str = "SELECT CONTRACT_OWNER FROM wp_contracts WHERE CONTRACT_CODE = '".$GROUP_CONTRACT."'";
			$query = $this->db->query($str);
			if(count($query) > 0)
			{
				$CONTRACT_OWNER = $query[0]["CONTRACT_OWNER"];
				// GET OWNER EMAIL
				$str = "SELECT USER_EMAIL FROM wp_trusers WHERE USER_CODE = '".$CONTRACT_OWNER."'";
				$query = $this->db->query($str);
				$USER_EMAIL = $query[0]["USER_EMAIL"];
			}
			else
			{
				$CONTRACT_OWNER = $query[0]["CONTRACT_OWNER"];
				$USER_EMAIL = "";
			}
			
			
			
			
			// GET CITIZEN EMAIL
			$str = "SELECT CITIZEN_EMAIL FROM wp_citizens WHERE CITIZEN_IDNUM = '".$REMCOM_CITIZEN."'";
			$query = $this->db->query($str);
			$CITIZEN_EMAIL = $query[0]["CITIZEN_EMAIL"];

			$groupName = $GROUP_NAME;
			$ownerEmail = $USER_EMAIL;
			$citizenEmail = $CITIZEN_EMAIL;
			
			$message = "Se ha sacado al ciudadano: ".$REMCOM_CITIZEN_NAME.", del grupo: ".$groupName;
			$data = array();
			$data["subject"] = "Ciudadano agregado a grupo";
			$data["content"] = "Mensaje de administrador DIOGENES<br><br>".$message."<br><br>";
			$data["header"] = "-";
			$data["footer"] = "-";
			
			// SEND TO BOTH
			if($citizenEmail != null and $citizenEmail != "")
			{
				$data["email"] = $ownerEmail;
				$send = $this->myMailer($data, $citizenEmail)["message"];
				$resp["message"] = "both: ".$send." - ".$ownerEmail." -- ".$citizenEmail;
				return $resp;
			}
			else
			{
				// SEND TO CONTRATIST ONLY
				$data["email"] = $ownerEmail;
				$send = $this->myMailer($data, "")["message"];
				$resp["message"] = "owner: ".$send." - ".$ownerEmail;
				return $resp;
			}
			
		}
		if($REMCOM_MODE == "remit")
		{
			// CREATE REMITION
		
			$now = new DateTime();
			$now = $now->format('Y-m-d');
			$REMCOM_DATE = $now;
			
			$TABLE = "wp_remitions";
			
			$str = "INSERT INTO $TABLE (
			REM_CODE,
			REM_AUTOR,
			REM_AUTOR_NAME,
			REM_CITIZEN,
			REM_CITIZEN_NAME,
			REM_ENTITY,
			REM_DATE,
			REM_REQUESTER,
			REM_REQUESTER_TYPE,
			REM_REQUESTER_NAME,
			REM_ACTIVITY,
			REM_CONTRATIST,
			REM_CONTRATIST_NAME,
			REM_COMMENT,
			REM_LINE) VALUES (
			'".$REMCOM_CODE."',
			'".$REMCOM_REM_AUTOR."',
			'".$REMCOM_REM_AUTOR_NAME."',
			'".$REMCOM_CITIZEN."',
			'".$REMCOM_CITIZEN_NAME."',
			'".$REMCOM_ENTITY."',
			'".$REMCOM_DATE."',
			'".$REMCOM_REQUESTER."',
			'".$REMCOM_REQUESTER_TYPE."',
			'".$REMCOM_REQUESTER_NAME."',
			'".$REMCOM_NEW_ACTIVITY."',
			'".$REMCOM_NEW_CONTRATIST."',
			'".$REMCOM_NEW_CONTRATIST_NAME."',
			'".$REMCOM_COMMENT."',
			'".$REMCOM_LINE."')";
			$query = $this->db->query($str);
			
			
			$resp["message"] = "remited";
			$resp["status"] = true;
			return $resp;
			
			// SEND NOTIFICATION EMAILS
			// SEND NOTIFICATION EMAILS
			// SEND NOTIFICATION EMAILS
			// SEND NOTIFICATION EMAILS
			// SEND NOTIFICATION EMAILS
			
		}
		if($REMCOM_MODE == "date")
		{
			
			// DATE CREATE
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			$DATE_CODE = md5($REMCOM_DATE.$now);
			
			$TABLE = "wp_dates";
			
			$str = "INSERT INTO $TABLE (
			DATE_CODE,
			DATE_DATE,
			DATE_ENTITY,
			DATE_DATE_INI,
			DATE_DATE_END,
			DATE_PLACE,
			DATE_CONTRATIST,
			DATE_CONTRATIST_NAME,
			DATE_CITIZEN,
			DATE_CITIZEN_NAME,
			DATE_COMMENT,
			DATE_LINE) VALUES (
			'".$DATE_CODE."',
			'".$REMCOM_DATE_DATE."',
			'".$REMCOM_ENTITY."',
			'".$REMCOM_DATE_INI."',
			'".$REMCOM_DATE_END."',
			'".$REMCOM_DATE_PLACE."',
			'".$REMCOM_CONTRATIST."',
			'".$REMCOM_CONTRATIST_NAME."',
			'".$REMCOM_CITIZEN."',
			'".$REMCOM_CITIZEN_NAME."',
			'".$REMCOM_COMMENT."',
			'".$REMCOM_LINE."')";
			$query = $this->db->query($str);
			
			// --------------MAIL
			// --------------MAIL
			// --------------MAIL
			
			// GET CITIZEN EMAIL
			$str = "SELECT CITIZEN_EMAIL FROM wp_citizens WHERE CITIZEN_IDNUM = '".$REMCOM_CITIZEN."'";
			$query = $this->db->query($str);
			$CITIZEN_EMAIL = $query[0]["CITIZEN_EMAIL"];
			$citizenEmail = $CITIZEN_EMAIL;
			
			$dateData = "Fecha: ".$REMCOM_DATE_DATE."<br>Hora inicio: ".$REMCOM_DATE_INI."<br>Hora fin: ".$REMCOM_DATE_END."<br>Lugar: ".$REMCOM_DATE_PLACE;
			
			
			$message = "Se ha creado una cita para: ".$REMCOM_CITIZEN_NAME."<br><br>".$dateData;
			$data = array();
			$data["subject"] = "Cita creada";
			$data["content"] = "Mensaje de administrador DIOGENES<br><br>".$message."<br><br>";
			$data["header"] = "-";
			$data["footer"] = "-";
			
			// SEND TO CITIZEN
			if($citizenEmail != null and $citizenEmail != "")
			{
				$data["email"] = $citizenEmail;
				$send = $this->myMailer($data, "")["message"];
				$resp["message"] = "citizen: ".$send." - ".$citizenEmail." - ".$message;
				// return $resp;
			}
		}
		if($REMCOM_MODE == "close")
		{
			$str = "UPDATE wp_remitions SET REM_STATE = '1'	WHERE REM_CODE ='".$REMCOM_REM_CODE."'";
			$query = $this->db->query($str);
		}
		if($REMCOM_MODE == "reopen")
		{
			$str = "UPDATE wp_remitions SET REM_STATE = '0'	WHERE REM_CODE ='".$REMCOM_REM_CODE."'";
			$query = $this->db->query($str);
		}
		$resp["message"] = "Created";
		$resp["status"] = true;
		
		// ------------------LOGSAVE-----------------
		$logSave = $this->logw($info);
		// ------------------LOGSAVE-----------------
		
		return $resp;
		
	}
	
	function citizenChange($info)
	{
		$CITIZEN_IDNUM = $info["CITIZEN_IDNUM"];
		$CITIZEN_NEW_IDNUM = $info["CITIZEN_NEW_IDNUM"];
		
		$str = "UPDATE wp_attend SET REMCOM_CITIZEN = REPLACE(REMCOM_CITIZEN,'$CITIZEN_IDNUM','$CITIZEN_NEW_IDNUM')";
		$query = $this->db->query($str);
		
		$str = "UPDATE wp_citizens SET CITIZEN_IDNUM = REPLACE(CITIZEN_IDNUM,'$CITIZEN_IDNUM','$CITIZEN_NEW_IDNUM')";
		$query = $this->db->query($str);
		
		$str = "UPDATE wp_classes SET CLASS_CITIZENS = REPLACE(CLASS_CITIZENS,'$CITIZEN_IDNUM','$CITIZEN_NEW_IDNUM')";
		$query = $this->db->query($str);
		
		$str = "UPDATE wp_dates SET DATE_CITIZEN = REPLACE(DATE_CITIZEN,'$CITIZEN_IDNUM','$CITIZEN_NEW_IDNUM')";
		$query = $this->db->query($str);
		
		$str = "UPDATE wp_events SET EVENT_COOPERATOR = REPLACE(EVENT_COOPERATOR,'$CITIZEN_IDNUM','$CITIZEN_NEW_IDNUM')";
		$query = $this->db->query($str);
		
		$str = "UPDATE wp_events SET EVENT_REQUESTER = REPLACE(EVENT_REQUESTER,'$CITIZEN_IDNUM','$CITIZEN_NEW_IDNUM')";
		$query = $this->db->query($str);
		
		$str = "UPDATE wp_groups SET GROUP_COPERATOR = REPLACE(GROUP_COPERATOR,'$CITIZEN_IDNUM','$CITIZEN_NEW_IDNUM')";
		$query = $this->db->query($str);
		
		$str = "UPDATE wp_groups SET GROUP_CITIZENS = REPLACE(GROUP_CITIZENS,'$CITIZEN_IDNUM','$CITIZEN_NEW_IDNUM')";
		$query = $this->db->query($str);
		
		$str = "UPDATE wp_remitions SET REM_CITIZEN = REPLACE(REM_CITIZEN,'$CITIZEN_IDNUM','$CITIZEN_NEW_IDNUM')";
		$query = $this->db->query($str);
	
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function editDate($info)
	{

		$DATE_CODE = $info["DATE_CODE"];
		$REMCOM_CITIZEN = $info["REMCOM_CITIZEN"];
		$REMCOM_CITIZEN_NAME = $info["REMCOM_CITIZEN_NAME"];
		$REMCOM_CONTRATIST = $info["REMCOM_CONTRATIST"];
		$REMCOM_DATE_DATE = $info["REMCOM_DATE_DATE"];
		$REMCOM_DATE_INI = $info["REMCOM_DATE_INI"];
		$REMCOM_DATE_END = $info["REMCOM_DATE_END"];
		$REMCOM_DATE_PLACE = $info["REMCOM_DATE_PLACE"];
		$REMCOM_USER_CONTRACT = $info["REMCOM_USER_CONTRACT"];
		
		
		// VERIFY DATE TIME CROSING WITH CONTRATIST OPEN DATES
		// VERIFY DATE TIME CROSING WITH CONTRATIST OPEN DATES
		// VERIFY DATE TIME CROSING WITH CONTRATIST OPEN DATES
		
		$now = new DateTime();
		$now = $now->format('Y-m-d');
		
		$str = "SELECT DATE_DATE, DATE_DATE_INI, DATE_DATE_END  FROM wp_dates WHERE 
		DATE_CONTRATIST = '".$REMCOM_CONTRATIST."' AND DATE_DATE >= '".$now."' AND DATE_STATE = '0' AND DATE_CODE != '".$DATE_CODE."'";
		$query = $this->db->query($str);
		$actualDates = $query;
		
		if(count($actualDates)>0)
		{
			for($i=0; $i<count($actualDates); $i++)
			{
				// CHECK SAME DAY ONLY
				if($actualDates[$i]["DATE_DATE"] == $REMCOM_DATE_DATE)
				{
					$GINI_TIME = $actualDates[$i]["DATE_DATE_INI"];
					$GEND_TIME = $actualDates[$i]["DATE_DATE_END"];
					$add = 1;
					// IF INI HOUR INSIDE RANGE
					if($REMCOM_DATE_INI >= $GINI_TIME and $REMCOM_DATE_INI < $GEND_TIME){$add = 0;}
					// IF END HOUR INSIDE RANGE
					if($REMCOM_DATE_END > $GINI_TIME and $REMCOM_DATE_END < $GEND_TIME){$add = 0;}
					// IF REG INI INSIDE RANGE
					if($GINI_TIME >= $REMCOM_DATE_INI and $GINI_TIME < $REMCOM_DATE_END){$add = 0;}
					// IF REG END INSIDE RANGE
					if($GEND_TIME > $REMCOM_DATE_INI and $GEND_TIME < $REMCOM_DATE_END){$add = 0;}
					if($add == 0)
					{
						$resp["message"] = "citaCross";
						$resp["status"] = true;
						return $resp;
					}
				}
			}
		}
		
		// VERIFY DATE TIME CROSING WITH CONTRATIST CLASES
		// VERIFY DATE TIME CROSING WITH CONTRATIST CLASES
		// VERIFY DATE TIME CROSING WITH CONTRATIST CLASES
		$data = array();
		$data["CONTRACT"] = $REMCOM_USER_CONTRACT;
		$CONTRATIST_HOURS = $this->getUserContractGroupHours($data)["message"];
		if(count($CONTRATIST_HOURS) > 0)
		{
			// GET DATE DAY NAME
			$date = new DateTime($REMCOM_DATE_DATE);
			$day = $date->format('Y-m-d');
			$dayName = $date->format('D');
			if($dayName == "Mon"){$dayName = "Lunes";}
			if($dayName == "Tue"){$dayName = "Martes";}
			if($dayName == "Wed"){$dayName = "Miércoles";}
			if($dayName == "Thu"){$dayName = "Jueves";}
			if($dayName == "Fri"){$dayName = "Viernes";}
			if($dayName == "Sat"){$dayName = "Sábado";}
			if($dayName == "Sun"){$dayName = "Domingo";}
			
			// FILTER DAY HOURS
			for($i=0; $i<count($CONTRATIST_HOURS); $i++)
			{
				// CHECK SAME DAY ONLY
				if($CONTRATIST_HOURS[$i]["GROUP_TIME_DAY"] == $dayName)
				{
					$GINI_TIME = $CONTRATIST_HOURS[$i]["GROUP_TIME_INI"];
					$GEND_TIME = $CONTRATIST_HOURS[$i]["GROUP_TIME_END"];
					$add = 1;
					// IF INI HOUR INSIDE RANGE
					if($REMCOM_DATE_INI >= $GINI_TIME and $REMCOM_DATE_INI < $GEND_TIME){$add = 0;}
					// IF END HOUR INSIDE RANGE
					if($REMCOM_DATE_END > $GINI_TIME and $REMCOM_DATE_END < $GEND_TIME){$add = 0;}
					// IF REG INI INSIDE RANGE
					if($GINI_TIME >= $REMCOM_DATE_INI and $GINI_TIME < $REMCOM_DATE_END){$add = 0;}
					// IF REG END INSIDE RANGE
					if($GEND_TIME > $REMCOM_DATE_INI and $GEND_TIME < $REMCOM_DATE_END){$add = 0;}
					if($add == 0)
					{
						$resp["message"] = "dateCross";
						$resp["status"] = true;
						return $resp;
					}
				}
			}

		}
		
		// UPDATE HERE IF PASS
		
		$str = "UPDATE wp_dates SET 
		DATE_DATE = '".$REMCOM_DATE_DATE."',
		DATE_DATE_INI = '".$REMCOM_DATE_INI."',
		DATE_DATE_END = '".$REMCOM_DATE_END."',
		DATE_PLACE = '".$REMCOM_DATE_PLACE."'
		WHERE 
		DATE_CODE ='".$DATE_CODE."'";
		$query = $this->db->query($str);
		
		$ans = "updated";
		
		// --------------MAIL
		// --------------MAIL
		// --------------MAIL
		
		// GET CITIZEN EMAIL
		$str = "SELECT CITIZEN_EMAIL FROM wp_citizens WHERE CITIZEN_IDNUM = '".$REMCOM_CITIZEN."'";
		$query = $this->db->query($str);
		$CITIZEN_EMAIL = $query[0]["CITIZEN_EMAIL"];
		$citizenEmail = $CITIZEN_EMAIL;
		
		$dateData = "Fecha: ".$REMCOM_DATE_DATE."<br>Hora inicio: ".$REMCOM_DATE_INI."<br>Hora fin: ".$REMCOM_DATE_END."<br>Lugar: ".$REMCOM_DATE_PLACE;
		
		
		$message = "Se ha modificado la cita para: ".$REMCOM_CITIZEN_NAME."<br><br>".$dateData;
		$data = array();
		$data["subject"] = "Cita modificada";
		$data["content"] = "Mensaje de administrador DIOGENES<br><br>".$message."<br><br>";
		$data["header"] = "-";
		$data["footer"] = "-";
		
		// SEND TO CITIZEN
		if($citizenEmail != null and $citizenEmail != "")
		{
			$data["email"] = $citizenEmail;
			$send = $this->myMailer($data, "")["message"];
			$resp["message"] = "citizen: ".$send." - ".$citizenEmail." - ".$message;
			return $resp;
		}
		
		
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function dateClose($info)
	{
		$DATE_CODE = $info["DATE_CODE"];
		$DATE_CLOSE_COMMENT = $info["DATE_CLOSE_COMMENT"];
		
		
		$str = "UPDATE wp_dates SET 
		DATE_CLOSE_COMMENT = '".$DATE_CLOSE_COMMENT."',
		DATE_STATE = '1'
		WHERE 
		DATE_CODE ='".$DATE_CODE."'";
		$query = $this->db->query($str);
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function saveCommentRC($info)
	{
		$info["REMCOM_MODE"] = "remit";
		$info["REMCOM_TYPE"] = "remit";
		$info["REMCOM_REM_AUTOR"] = $info["REMCOM_CONTRATIST"];
		$info["REMCOM_REM_AUTOR_NAME"] = $info["REMCOM_CONTRATIST_NAME"];
		$info["REMCOM_NEW_ACTIVITY"] = $info["REMCOM_ACTIVITY"];
		
		$createRem = $this->saveComment($info)["message"];
		
		$info["REMCOM_MODE"] = "close";
		$info["REMCOM_TYPE"] = "close";
		$info["REMCOM_COMMENT"] = $info["REMCOM_COMMENT_CLOSE"];
		$info["REMCOM_SPECIAL"] = $info["REMCOM_SPECIAL_CLOSE"];
		$info["REMCOM_FILE"] = $info["REMCOM_FILE_CLOSE"];
		
		// CHANGE FOR DUPLIKEY
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$info["REMCOM_CREATED_BY"] = md5($now);
		$createRem = $this->saveComment($info)["message"];
		
		$resp["message"] = $createRem;
		$resp["status"] = true;
		return $resp;
	}
	
	function checkOrphan($info)
	{
		
		$REM_CODE = $info["REM_CODE"];
		
		$str = "SELECT REM_CONTRATIST, REM_ACTIVITY, REM_STATE FROM wp_remitions WHERE REM_CODE = '".$REM_CODE."'";
		$query = $this->db->query($str);
		
		$REM_CONTRATIST = $query[0]["REM_CONTRATIST"];
		$REM_ACTIVITY =  $query[0]["REM_ACTIVITY"];
		$REM_STATE =  $query[0]["REM_STATE"];
		
		$orphan = 0;
		
		$now = new DateTime();
		$now = $now->format('Y-m-d');
		
		$str = "SELECT CONTRACT_CODE, CONTRACT_ACTIVITIES, CONTRACT_CANREM, CONTRACT_CANREM_GET FROM wp_contracts WHERE CONTRACT_OWNER = '".$REM_CONTRATIST."' AND CONTRACT_ENDATE >= '".$now."'";
		$contract = $this->db->query($str);
		// CASE 1 
		if(count($contract) == 0){$orphan = 1;}
		else
		{
			// CASE 2
			$canRemGet = $contract[0]["CONTRACT_CANREM_GET"];
			if($canRemGet == "No"){$orphan = 1;}
			
			// CASE 3
			$activities = $contract[0]["CONTRACT_ACTIVITIES"];
			if(!strpos($activities, $REM_ACTIVITY) !== false){$orphan = 1;}
		}
		
		$ans = $orphan;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function getComponents($info)
	{
		
		$str = "SELECT COMPONENT_CODE, COMPONENT_NAME, COMPONENT_ACTIVITIES FROM wp_master_component ORDER BY COMPONENT_NAME ASC";
		$components = $this->db->query($str);
		
		$ans = $components;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function getSubcomps($info)
	{
		$COMPONENT_CODE = $info["COMPONENT_CODE"];
		$str = "SELECT SCOMPONENT_CODE, SCOMPONENT_NAME FROM wp_master_scomponent WHERE SCOMPONENT_COMPONENT = '".$COMPONENT_CODE."'ORDER BY SCOMPONENT_NAME ASC";
		$scomponents = $this->db->query($str);

		$ans = $scomponents;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function getUserContractGroupHours($info)
	{
		$CONTRACT = $info["CONTRACT"];
		
		$str = "SELECT GROUP_CODE, GROUP_HOURS FROM wp_groups WHERE GROUP_CONTRACT = '".$CONTRACT."'";
		$query = $this->db->query($str);
		
		$hours = array();

		if(count($query) > 0)
		{
			for($i=0; $i<count($query); $i++)
			{
				if($query[$i]["GROUP_HOURS"] != "null" and $query[$i]["GROUP_HOURS"] != null and $query[$i]["GROUP_HOURS"] != "")
				{
					$gHours = json_decode($query[$i]["GROUP_HOURS"], true);
				}
				else
				{
					$gHours = array();
				}

				for($g=0; $g<count($gHours); $g++)
				{
					$gHours[$g]["GROUP_CODE"] = $query[$i]["GROUP_CODE"];
					array_push($hours, $gHours[$g]);
				}
			}
		}

		$resp["message"] = $hours;
		$resp["status"] = true;
		return $resp;
	}
	function saveMaster($info)
	{

		$TABLE = $info["TABLE"];
		$MODE = $info["MODE"];
		$NAME_FIELD = $info["NAME_FIELD"];
		$ENTITY_FIELD = $info["ENTITY_FIELD"];
		$CODE_FIELD = $info["CODE_FIELD"];
		$NAME = $info["NAME"];
		$ENTITY = $info["ENTITY"];
		
		if($TABLE == "wp_master_edlevel"){}
		
		// CHECK IF NAME EXISTS
		$str = "SELECT $NAME_FIELD FROM $TABLE WHERE $NAME_FIELD = '".$NAME."' AND $ENTITY_FIELD = '".$ENTITY."'";
		$query = $this->db->query($str);
		if(count($query) > 0 and $MODE == "0")
		// if(count($query) > 0)
		{$resp["message"] = "exists";return $resp;}
		
		if($MODE == "1")
		{

			$CODE = $info["CODE"];
			
			$str = "UPDATE $TABLE SET 
			$ENTITY_FIELD = '".$ENTITY."',
			$NAME_FIELD = '".$NAME."'
			WHERE 
			$CODE_FIELD ='".$CODE."'";
			
			if($TABLE == "wp_master_component")
			{
				$str = "UPDATE $TABLE SET 
				$ENTITY_FIELD = '".$ENTITY."',
				COMPONENT_ACTIVITIES = '".$info["COMPONENT_ACTIVITIES"]."',
				$NAME_FIELD = '".$NAME."'
				WHERE 
				$CODE_FIELD ='".$CODE."'";
			}
			
			if($TABLE == "wp_master_scomponent")
			{
				$str = "UPDATE $TABLE SET 
				$ENTITY_FIELD = '".$ENTITY."',
				SCOMPONENT_COMPONENT = '".$info["SCOMPONENT_COMPONENT"]."',
				$NAME_FIELD = '".$NAME."'
				WHERE 
				$CODE_FIELD ='".$CODE."'";
			}
			
			$resp["message"] = "updated";
			$query = $this->db->query($str);
			return $resp;
		}
		else
		{
			$now = new DateTime();
			$now = $now->format('Y-m-d');
			$CODE = md5($ENTITY.$NAME.$now);
			
			$str = "INSERT INTO $TABLE (
			$ENTITY_FIELD,
			$NAME_FIELD,
			$CODE_FIELD) VALUES (
			'".$ENTITY."',
			'".$NAME."',
			'".$CODE."'
			)";
			
			if($TABLE == "wp_master_component")
			{
				$str = "INSERT INTO $TABLE (
				$ENTITY_FIELD,
				$NAME_FIELD,
				COMPONENT_ACTIVITIES,
				$CODE_FIELD) VALUES (
				'".$ENTITY."',
				'".$NAME."',
				'".$info["COMPONENT_ACTIVITIES"]."',
				'".$CODE."'
				)";
			}
			
			if($TABLE == "wp_master_scomponent")
			{
				$str = "INSERT INTO $TABLE (
				$ENTITY_FIELD,
				$NAME_FIELD,
				SCOMPONENT_COMPONENT,
				$CODE_FIELD) VALUES (
				'".$ENTITY."',
				'".$NAME."',
				'".$info["SCOMPONENT_COMPONENT"]."',
				'".$CODE."'
				)";
			}

			
			
			$query = $this->db->query($str);
			$resp["message"] = "Created";
			$resp["status"] = true;
		}


		
		
		
		// ------------------LOGSAVE-----------------
		$logSave = $this->logw($info);
		// ------------------LOGSAVE-----------------
		
		return $resp;
		
	}
	function saveRem($info)
	{
		
		$REM_AUTOR = $info["REM_AUTOR"];
		$REM_CITIZEN = $info["REM_CITIZEN"];
		$REM_ENTITY = $info["REM_ENTITY"];
		$REM_DATE = $info["REM_DATE"];
		$REM_REQUESTER = $info["REM_REQUESTER"];
		$REM_REQUESTER_TYPE = $info["REM_REQUESTER_TYPE"];
		$REM_ACTIVITY = $info["REM_ACTIVITY"];
		$REM_CONTRATIST = $info["REM_CONTRATIST"];
		$REM_COMMENT = $info["REM_COMMENT"];
		$REM_COMMENT_DATE = $info["REM_COMMENT_DATE"];
		
		$REM_AUTOR_NAME = $info["REM_AUTOR_NAME"];
		$REM_REQUESTER_NAME = $info["REM_REQUESTER_NAME"];
		$REM_CITIZEN_NAME = $info["REM_CITIZEN_NAME"];
		
		// GET REMLINE
		$str = "SELECT REM_LINE FROM wp_remitions WHERE REM_CITIZEN = '".$REM_CITIZEN."' ORDER BY REM_LINE DESC LIMIT 1";
		$ACTUALINE = $this->db->query($str);
		if(count($ACTUALINE) > 0){$REM_LINE = intval($ACTUALINE[0]["REM_LINE"])+1;}
		else{$REM_LINE = 1;}
		
		// GET CONTRATIST NAME
		$str = "SELECT USER_NAME, USER_LASTNAME FROM wp_trusers WHERE USER_CODE = '".$REM_CONTRATIST."'";
		$CONTRATIST = $this->db->query($str);
		$REM_CONTRATIST_NAME = $CONTRATIST[0]["USER_NAME"]." ".$CONTRATIST[0]["USER_LASTNAME"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$REM_CODE = md5($REM_AUTOR.$now);
		$TABLE = "wp_remitions";
		
		$str = "INSERT INTO $TABLE (
		REM_CODE,
		REM_AUTOR,
		REM_CITIZEN,
		REM_ENTITY,
		REM_DATE,
		REM_REQUESTER,
		REM_REQUESTER_TYPE,
		REM_ACTIVITY,
		REM_CONTRATIST,
		REM_COMMENT,
		REM_AUTOR_NAME,
		REM_REQUESTER_NAME,
		REM_CITIZEN_NAME,
		REM_CONTRATIST_NAME,
		REM_LINE) VALUES (
		'".$REM_CODE."',
		'".$REM_AUTOR."',
		'".$REM_CITIZEN."',
		'".$REM_ENTITY."',
		'".$REM_DATE."',
		'".$REM_REQUESTER."',
		'".$REM_REQUESTER_TYPE."',
		'".$REM_ACTIVITY."',
		'".$REM_CONTRATIST."',
		'".$REM_COMMENT."',
		'".$REM_AUTOR_NAME."',
		'".$REM_REQUESTER_NAME."',
		'".$REM_CITIZEN_NAME."',
		'".$REM_CONTRATIST_NAME."',
		'".$REM_LINE."')";
		$query = $this->db->query($str);
		
		
		// ------------------------------- INITIAL COMMENT ---------------
		
		$REM_SPECIAL = "No";
		$REM_FILE = "";
		$REM_TYPE = "remit";
		$REM_DATE_FULL = $now;
		$REM_REMSTATE = "0";
		$REM_NEW_ACTIVITY = "";
		$REM_NEW_CONTRATIST = "";
		$REM_NEW_CONTRATIST_NAME = "";
		$REM_GROUP = "";
		$REMCOM_REM_CODE = $REM_CODE;
		
		$str = "INSERT INTO wp_attend (
		REMCOM_CODE,
		REMCOM_ENTITY,
		REMCOM_COMMENT,
		REMCOM_COMMENT_DATE,
		REMCOM_SPECIAL,
		REMCOM_CITIZEN,
		REMCOM_CITIZEN_NAME,
		REMCOM_FILE,
		REMCOM_LINE,
		REMCOM_TYPE,
		REMCOM_REMINI,
		REMCOM_DATE,
		REMCOM_REMSTATE,
		REMCOM_AUTOR,
		REMCOM_AUTOR_NAME,
		REMCOM_CONTRATIST,
		REMCOM_CONTRATIST_NAME,
		REMCOM_ACTIVITY,
		REMCOM_NEW_ACTIVITY,
		REMCOM_NEW_CONTRATIST,
		REMCOM_NEW_CONTRATIST_NAME,
		REMCOM_REM_CODE,
		REMCOM_GROUP) VALUES 
		(
		'".$REM_CODE."',
		'".$REM_ENTITY."',
		'".$REM_COMMENT."',
		'".$REM_COMMENT_DATE."',
		'".$REM_SPECIAL."',
		'".$REM_CITIZEN."',
		'".$REM_CITIZEN_NAME."',
		'".$REM_FILE."',
		'".$REM_LINE."',
		'".$REM_TYPE."',
		'".$REM_DATE."',
		'".$REM_DATE_FULL."',
		'".$REM_REMSTATE."',
		'".$REM_AUTOR."',
		'".$REM_AUTOR_NAME."',
		'".$REM_CONTRATIST."',
		'".$REM_CONTRATIST_NAME."',
		'".$REM_ACTIVITY."',
		'".$REM_NEW_ACTIVITY."',
		'".$REM_NEW_CONTRATIST."',
		'".$REM_NEW_CONTRATIST_NAME."',
		'".$REMCOM_REM_CODE."',
		'".$REM_GROUP."'
		)";
		
		$query = $this->db->query($str);
		
		
		
		
		$resp["message"] = "Created";
		$resp["status"] = true;
		return $resp;
	}
	function checkSimulEvents($info)
	{
		$EVENT_CODE = $info["EVENT_CODE"];
		$EVENT_OWNER = $info["EVENT_OWNER"];
		$EVENT_DATE_INI = $info["EVENT_DATE_INI"].":00";
		$EVENT_DATE_END = $info["EVENT_DATE_END"].":00";
		
		$str = "SELECT EVENT_DATE_INI, EVENT_DATE_END FROM wp_events WHERE EVENT_OWNER = '".$EVENT_OWNER."' AND EVENT_CODE != '".$EVENT_CODE."'";
		$query = $this->db->query($str);
		$userEvents = $query;
		
		$CLASS_INI = str_replace('/', '-', $EVENT_DATE_INI);
		$CLASS_END = str_replace('/', '-', $EVENT_DATE_END);
		
		// GET SIMULTANEOUS CLASSES
		$simultaneous = array();
		for($i=0; $i<count($userEvents); $i++)
		{
			$add = 1;
			
			$event = $userEvents[$i];
			$classIni = $event["EVENT_DATE_INI"];
			$classEnd = $event["EVENT_DATE_END"];
		
			// IF INI HOUR INSIDE RANGE
			if($CLASS_INI >= $classIni and $CLASS_INI < $classEnd)
			{$add = 0;}
			// IF END HOUR INSIDE RANGE
			if($CLASS_END >= $classIni and $CLASS_END < $classEnd)
			{$add = 0;}
			// IF REG INI INSIDE RANGE
			if($classIni >= $CLASS_INI and $classIni < $CLASS_END)
			{$add = 0;}
			// IF REG END INSIDE RANGE
			if($classEnd >= $CLASS_INI and $classEnd < $CLASS_END)
			{$add = 0;}
			if($add == 0)
			{array_push($simultaneous, $event);}
		}
		
		if(count($simultaneous)>0){$ans = 1;}
		else{$ans = 0;}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveEvent($info)
	{

		$EVENT_CODE = $info["EVENT_CODE"];
		$EVENT_CREATED = $info["EVENT_CREATED"];
		$EVENT_ENTITY = $info["EVENT_ENTITY"];
		$EVENT_OWNER = $info["EVENT_OWNER"];
		$EVENT_DATE_INI = $info["EVENT_DATE_INI"];
		$EVENT_DATE_END = $info["EVENT_DATE_END"];
		$EVENT_HOOD = $info["EVENT_HOOD"];
		$EVENT_PREVIR = $info["EVENT_PREVIR"];
		$EVENT_ADDRESS = $info["EVENT_ADDRESS"];
		$EVENT_COORDS = $info["EVENT_COORDS"];
		$EVENT_ACTIVITIES = $info["EVENT_ACTIVITIES"];
		$EVENT_SUPPORT_TEAM = $info["EVENT_SUPPORT_TEAM"];
		$EVENT_INSTYPE = $info["EVENT_INSTYPE"];
		$EVENT_INSTITUTE = $info["EVENT_INSTITUTE"];
		$EVENT_COOPERATOR = $info["EVENT_COOPERATOR"];
		$EVENT_COOPTYPE = $info["EVENT_COOPTYPE"];
		$EVENT_NAME = $info["EVENT_NAME"];
		$EVENT_ASSIST = json_encode($info["EVENT_ASSIST"], true);
		$EVENT_TOTAL_PEOPLE = $info["EVENT_TOTAL_PEOPLE"];
		$EVENT_SHEET = $info["EVENT_SHEET"];
		$EVENT_PIC = $info["EVENT_PIC"];
		$EVENT_RESUME = $info["EVENT_RESUME"];
		$EVENT_SERVPLACE = $info["EVENT_SERVPLACE"];
		$EVENT_CONTRACT_CODE = $info["EVENT_CONTRACT_CODE"];

		
		// GET OWNER DATE CROSSED EVENTS 
		// GET OWNER DATE CROSSED EVENTS 
		
		$data = array();
		$data["EVENT_CODE"] = $EVENT_CODE;
		$data["EVENT_OWNER"] = $EVENT_OWNER;
		$data["EVENT_DATE_INI"] = $EVENT_DATE_INI;
		$data["EVENT_DATE_END"] = $EVENT_DATE_END;
		$checkSim = $this->checkSimulEvents($data);
		if($checkSim["message"] == 1)
		{$resp["message"] = "eventCross";return $resp;}
		
		$MODE = $info["MODE"];
		
		if($MODE == "1")
		{
			$str = "UPDATE wp_events SET 
			EVENT_ENTITY = '".$EVENT_ENTITY."',
			EVENT_DATE_INI = '".$EVENT_DATE_INI."',
			EVENT_DATE_END = '".$EVENT_DATE_END."',
			EVENT_HOOD = '".$EVENT_HOOD."',
			EVENT_PREVIR = '".$EVENT_PREVIR."',
			EVENT_ADDRESS = '".$EVENT_ADDRESS."',
			EVENT_COORDS = '".$EVENT_COORDS."',
			EVENT_ACTIVITIES = '".$EVENT_ACTIVITIES."',
			EVENT_SUPPORT_TEAM = '".$EVENT_SUPPORT_TEAM."',
			EVENT_INSTYPE = '".$EVENT_INSTYPE."',
			EVENT_INSTITUTE = '".$EVENT_INSTITUTE."',
			EVENT_COOPERATOR = '".$EVENT_COOPERATOR."',
			EVENT_COOPTYPE = '".$EVENT_COOPTYPE."',
			EVENT_NAME = '".$EVENT_NAME."',
			EVENT_ASSIST = '".$EVENT_ASSIST."',
			EVENT_TOTAL_PEOPLE = '".$EVENT_TOTAL_PEOPLE."',
			EVENT_SERVPLACE = '".$EVENT_SERVPLACE."',
			EVENT_RESUME = '".$EVENT_RESUME."'
			WHERE 
			EVENT_CODE ='".$EVENT_CODE."'";

			$resp["message"] = "updated";
			
			$query = $this->db->query($str);
			
			
			if($EVENT_PIC != "" and $EVENT_PIC != "1")
			{
				$str = "UPDATE wp_events SET EVENT_PIC = '".$EVENT_PIC."' WHERE EVENT_CODE ='".$EVENT_CODE."'";
				$query = $this->db->query($str);
			}
		
			if($EVENT_SHEET != "" and $EVENT_SHEET != "1")
			{
				$str = "UPDATE wp_events SET EVENT_SHEET = '".$EVENT_SHEET."' WHERE EVENT_CODE ='".$EVENT_CODE."'";
				$query = $this->db->query($str);
			}
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
			
			return $resp;
			
		}
		else
		{
			$now = new DateTime();
			$now = $now->format('Y-m-d');
			$EVENT_CODE = md5($EVENT_ENTITY.$EVENT_CREATED.$now);
			
			$str = "INSERT INTO wp_events (
			EVENT_CREATED,
			EVENT_ENTITY,
			EVENT_OWNER,
			EVENT_DATE_INI,
			EVENT_DATE_END,
			EVENT_HOOD,
			EVENT_PREVIR,
			EVENT_ADDRESS,
			EVENT_COORDS,
			EVENT_ACTIVITIES,
			EVENT_SUPPORT_TEAM,
			EVENT_INSTYPE,
			EVENT_INSTITUTE,
			EVENT_COOPERATOR,
			EVENT_COOPTYPE,
			EVENT_NAME,
			EVENT_ASSIST,
			EVENT_TOTAL_PEOPLE,
			EVENT_SHEET,
			EVENT_PIC,
			EVENT_RESUME,
			EVENT_SERVPLACE,
			EVENT_CONTRACT_CODE,
			EVENT_CODE) VALUES (
			'".$EVENT_CREATED."',
			'".$EVENT_ENTITY."',
			'".$EVENT_OWNER."',
			'".$EVENT_DATE_INI."',
			'".$EVENT_DATE_END."',
			'".$EVENT_HOOD."',
			'".$EVENT_PREVIR."',
			'".$EVENT_ADDRESS."',
			'".$EVENT_COORDS."',
			'".$EVENT_ACTIVITIES."',
			'".$EVENT_SUPPORT_TEAM."',
			'".$EVENT_INSTYPE."',
			'".$EVENT_INSTITUTE."',
			'".$EVENT_COOPERATOR."',
			'".$EVENT_COOPTYPE."',
			'".$EVENT_NAME."',
			'".$EVENT_ASSIST."',
			'".$EVENT_TOTAL_PEOPLE."',
			'".$EVENT_SHEET."',
			'".$EVENT_PIC."',
			'".$EVENT_RESUME."',
			'".$EVENT_SERVPLACE."',
			'".$EVENT_CONTRACT_CODE."',
			'".$EVENT_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveEventR($info)
	{

		// REQUEST FIELDS
		$EVENT_CODE = $info["EVENT_CODE"];
		$EVENT_CREATED = $info["EVENT_CREATED"];
		$EVENT_AUTHOR = $info["EVENT_AUTHOR"];
		$EVENT_ENTITY = $info["EVENT_ENTITY"];
		$EVENT_REQUESTER = $info["EVENT_REQUESTER"];
		$EVENT_ORIGIN = $info["EVENT_ORIGIN"];
		$EVENT_RADICATE = $info["EVENT_RADICATE"];
		$EVENT_REQUEST_DATE = $info["EVENT_REQUEST_DATE"];
		$EVENT_REQUEST_TYPE = $info["EVENT_REQUEST_TYPE"];
		$EVENT_INSTYPE = $info["EVENT_INSTYPE"];
		$EVENT_INSTITUTE = $info["EVENT_INSTITUTE"];
		$EVENT_REQUEST_ACTIVITY = $info["EVENT_REQUEST_ACTIVITY"];
		$EVENT_NAME = $info["EVENT_NAME"];
		$EVENT_EXPECTED = $info["EVENT_EXPECTED"];
		$EVENT_HOOD = $info["EVENT_HOOD"];
		$EVENT_PREVIR = $info["EVENT_PREVIR"];
		$EVENT_ADDRESS = $info["EVENT_ADDRESS"];
		$EVENT_COORDS = $info["EVENT_COORDS"];
		$EVENT_DATE_INIR = $info["EVENT_DATE_INIR"];
		$EVENT_DATE_ENDR = $info["EVENT_DATE_ENDR"];
		$EVENT_DESCRIPTION = $info["EVENT_DESCRIPTION"];
		$EVENT_NEEDS = json_encode($info["EVENT_NEEDS"], true);
		$EVENT_REQUEST_FILE = $info["EVENT_REQUEST_FILE"];
		
		// GESTION FIELDS
		$EVENT_OWNER = $info["EVENT_OWNER"];
		$EVENT_ACTIVITIES = $info["EVENT_ACTIVITIES"];
		$EVENT_SUPPORT_TEAM = $info["EVENT_SUPPORT_TEAM"];
		$EVENT_DATE_INI = $info["EVENT_DATE_INI"];
		$EVENT_DATE_END = $info["EVENT_DATE_END"];
		$EVENT_STATUS = $info["EVENT_STATUS"];
		
		$EVENT_SERVPLACE = $info["EVENT_SERVPLACE"];
		

		$MODE = $info["MODE"];
		
		if($MODE == "1")
		{
			$LOCAL_REQUEST_STATUS = $info["LOCAL_REQUEST_STATUS"];
			
			if($EVENT_STATUS == "1")
			{$EVENT_STATUS = "2";}
			
			if($LOCAL_REQUEST_STATUS == "4")
			{$EVENT_STATUS = "4";}
			
			
			// CLOSURE FIELDS
			$EVENT_COOPERATOR = $info["EVENT_COOPERATOR"];
			$EVENT_COOPTYPE = $info["EVENT_COOPTYPE"];
			$EVENT_ASSIST = json_encode($info["EVENT_ASSIST"], true);
			$EVENT_RESUME = $info["EVENT_RESUME"];
			$EVENT_SHEET = $info["EVENT_SHEET"];
			$EVENT_PIC = $info["EVENT_PIC"];
			$EVENT_TOTAL_PEOPLE = $info["EVENT_TOTAL_PEOPLE"];
			
		
			// GET NEW OWNER = CONTRACT CODE
			$EVENT_CONTRACT_CODE = $EVENT_OWNER;
			
			$str = "UPDATE wp_events SET 
			EVENT_ENTITY = '".$EVENT_ENTITY."',
			EVENT_REQUESTER = '".$EVENT_REQUESTER."',
			EVENT_ORIGIN = '".$EVENT_ORIGIN."',
			EVENT_RADICATE = '".$EVENT_RADICATE."',
			EVENT_REQUEST_DATE = '".$EVENT_REQUEST_DATE."',
			EVENT_REQUEST_TYPE = '".$EVENT_REQUEST_TYPE."',
			EVENT_INSTYPE = '".$EVENT_INSTYPE."',
			EVENT_INSTITUTE = '".$EVENT_INSTITUTE."',
			EVENT_REQUEST_ACTIVITY = '".$EVENT_REQUEST_ACTIVITY."',
			EVENT_NAME = '".$EVENT_NAME."',
			EVENT_EXPECTED = '".$EVENT_EXPECTED."',
			EVENT_HOOD = '".$EVENT_HOOD."',
			EVENT_PREVIR = '".$EVENT_PREVIR."',
			EVENT_ADDRESS = '".$EVENT_ADDRESS."',
			EVENT_COORDS = '".$EVENT_COORDS."',
			EVENT_DATE_INIR = '".$EVENT_DATE_INIR."',
			EVENT_DATE_ENDR = '".$EVENT_DATE_ENDR."',
			EVENT_DESCRIPTION = '".$EVENT_DESCRIPTION."',
			EVENT_NEEDS = '".$EVENT_NEEDS."',
			EVENT_OWNER = '".$EVENT_OWNER."',
			EVENT_ACTIVITIES = '".$EVENT_ACTIVITIES."',
			EVENT_SUPPORT_TEAM = '".$EVENT_SUPPORT_TEAM."',
			EVENT_DATE_INI = '".$EVENT_DATE_INI."',
			EVENT_DATE_END = '".$EVENT_DATE_END."',
			EVENT_STATUS = '".$EVENT_STATUS."',
			EVENT_COOPERATOR = '".$EVENT_COOPERATOR."',
			EVENT_COOPTYPE = '".$EVENT_COOPTYPE."',
			EVENT_ASSIST = '".$EVENT_ASSIST."',
			EVENT_RESUME = '".$EVENT_RESUME."',
			EVENT_SERVPLACE = '".$EVENT_SERVPLACE."',
			EVENT_CONTRACT_CODE = '".$EVENT_CONTRACT_CODE."',
			EVENT_TOTAL_PEOPLE = '".$EVENT_TOTAL_PEOPLE."'
			WHERE 
			EVENT_CODE ='".$EVENT_CODE."'";
			
			$query = $this->db->query($str);
			
			if($EVENT_PIC != "" and $EVENT_PIC != "1")
			{
				$str = "UPDATE wp_events SET EVENT_PIC = '".$EVENT_PIC."' WHERE EVENT_CODE ='".$EVENT_CODE."'";
				$query = $this->db->query($str);
			}
		
			if($EVENT_SHEET != "" and $EVENT_SHEET != "1")
			{
				$str = "UPDATE wp_events SET EVENT_SHEET = '".$EVENT_SHEET."' WHERE EVENT_CODE ='".$EVENT_CODE."'";
				$query = $this->db->query($str);
			}
			

			$resp["message"] = "updated";
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
			
			return $resp;
			
		}
		else
		{
			$now = new DateTime();
			$now = $now->format('Y-m-d');
			$EVENT_CODE = md5($EVENT_ENTITY.$EVENT_CREATED.$now);
			
			$EVENT_TYPE = "1";
			
			$str = "INSERT INTO wp_events (
			EVENT_CREATED,
			EVENT_AUTHOR,
			EVENT_TYPE,
			EVENT_ENTITY,
			EVENT_REQUESTER,
			EVENT_ORIGIN,
			EVENT_RADICATE,
			EVENT_REQUEST_DATE,
			EVENT_REQUEST_TYPE,
			EVENT_INSTYPE,
			EVENT_INSTITUTE,
			EVENT_REQUEST_ACTIVITY,
			EVENT_NAME,
			EVENT_EXPECTED,
			EVENT_HOOD,
			EVENT_PREVIR,
			EVENT_ADDRESS,
			EVENT_COORDS,
			EVENT_DATE_INIR,
			EVENT_DATE_ENDR,
			EVENT_DESCRIPTION,
			EVENT_NEEDS,
			EVENT_SERVPLACE,
			EVENT_REQUEST_FILE,
			EVENT_CODE) VALUES (
			'".$EVENT_CREATED."',
			'".$EVENT_AUTHOR."',
			'".$EVENT_TYPE."',
			'".$EVENT_ENTITY."',
			'".$EVENT_REQUESTER."',
			'".$EVENT_ORIGIN."',
			'".$EVENT_RADICATE."',
			'".$EVENT_REQUEST_DATE."',
			'".$EVENT_REQUEST_TYPE."',
			'".$EVENT_INSTYPE."',
			'".$EVENT_INSTITUTE."',
			'".$EVENT_REQUEST_ACTIVITY."',
			'".$EVENT_NAME."',
			'".$EVENT_EXPECTED."',
			'".$EVENT_HOOD."',
			'".$EVENT_PREVIR."',
			'".$EVENT_ADDRESS."',
			'".$EVENT_COORDS."',
			'".$EVENT_DATE_INIR."',
			'".$EVENT_DATE_ENDR."',
			'".$EVENT_DESCRIPTION."',
			'".$EVENT_NEEDS."',
			'".$EVENT_SERVPLACE."',
			'".$EVENT_REQUEST_FILE."',
			'".$EVENT_CODE."'
			)";
			$query = $this->db->query($str);
			
			$resp["message"] = "Created";
			$resp["status"] = true;
			
			// ------------------LOGSAVE-----------------
			$logSave = $this->logw($info);
			// ------------------LOGSAVE-----------------
		}

		return $resp;
		
	}
	function saveTrasferEvent($info)
	{
		$EVENT_REQUEST_ACTIVITY = $info["EVENT_REQUEST_ACTIVITY"];
		$EVENT_CODE = $info["EVENT_CODE"];
		
		$str = "UPDATE wp_events SET 
		EVENT_REQUEST_ACTIVITY = '".$EVENT_REQUEST_ACTIVITY."'
		WHERE 
		EVENT_CODE ='".$EVENT_CODE."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveReject($info)
	{
		$EVENT_REJECT_REASON = $info["EVENT_REJECT_REASON"];
		$EVENT_CODE = $info["EVENT_CODE"];
		$EVENT_STATUS = "3";
		
		$str = "UPDATE wp_events SET 
		EVENT_REJECT_REASON = '".$EVENT_REJECT_REASON."',
		EVENT_STATUS = '".$EVENT_STATUS."'
		WHERE 
		EVENT_CODE ='".$EVENT_CODE."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function excuseCancel($info)
	{
		$CLASS_CODE = $info["CLASS_CODE"];
		
		$str = "UPDATE wp_classes SET 
		CLASS_EXCUSE = ''
		WHERE 
		CLASS_CODE ='".$CLASS_CODE."'";
		$query = $this->db->query($str);
		
		$ans = "updated";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveGroupHours($info)
	{
		$GROUP_CODE = $info["GROUP_CODE"];
		$GROUP_HOURS = $info["GROUP_HOURS"];
		$GROUP_CONTRACT = $info["GROUP_CONTRACT"];
		$GROUP_CONTRATIST = $info["GROUP_CONTRATIST"];
		
		$NEWHOURS = json_decode($GROUP_HOURS, true);

		for($h=0; $h<count($NEWHOURS); $h++)
		{
			
			$dayName = $NEWHOURS[$h]["GROUP_TIME_DAY"];
			$REMCOM_DATE_INI = $NEWHOURS[$h]["GROUP_TIME_INI"];
			$REMCOM_DATE_END = $NEWHOURS[$h]["GROUP_TIME_END"];
			
			
			// VERIFY DATE TIME CROSING WITH CONTRATIST CLASES
			
			$data = array();
			$data["CONTRACT"] = $GROUP_CONTRACT;
			$CONTRATIST_HOURS = $this->getUserContractGroupHours($data)["message"];
			
			if(count($CONTRATIST_HOURS) > 0)
			{
				// FILTER DAY HOURS
				for($i=0; $i<count($CONTRATIST_HOURS); $i++)
				{
					// CHECK SAME DAY ONLY
					if($CONTRATIST_HOURS[$i]["GROUP_TIME_DAY"] == $dayName)
					{
						$GINI_TIME = $CONTRATIST_HOURS[$i]["GROUP_TIME_INI"];
						$GEND_TIME = $CONTRATIST_HOURS[$i]["GROUP_TIME_END"];
						$add = 1;
						// IF INI HOUR INSIDE RANGE
						if($REMCOM_DATE_INI >= $GINI_TIME and $REMCOM_DATE_INI < $GEND_TIME){$add = 0;}
						// IF END HOUR INSIDE RANGE
						if($REMCOM_DATE_END > $GINI_TIME and $REMCOM_DATE_END < $GEND_TIME){$add = 0;}
						// IF REG INI INSIDE RANGE
						if($GINI_TIME >= $REMCOM_DATE_INI and $GINI_TIME < $REMCOM_DATE_END){$add = 0;}
						// IF REG END INSIDE RANGE
						if($GEND_TIME > $REMCOM_DATE_INI and $GEND_TIME < $REMCOM_DATE_END){$add = 0;}
						if($add == 0 and $CONTRATIST_HOURS[$i]["GROUP_CODE"] != $GROUP_CODE)
						{
							$detail = "Uno de los horarios se cruza con el siguiente horario de otro grupo: ".$CONTRATIST_HOURS[$i]["GROUP_TIME_DAY"]." de ".$CONTRATIST_HOURS[$i]["GROUP_TIME_INI"]." a ".$CONTRATIST_HOURS[$i]["GROUP_TIME_END"];
							
							$resp["message"] = $detail;
							$resp["status"] = true;
							return $resp;
						}
					}
				}

			}
			
			
			// VERIFY DATE TIME CROSING WITH CONTRATIST OPEN DATES
			
			$now = new DateTime();
			$now = $now->format('Y-m-d');
			
			$str = "SELECT DATE_DATE, DATE_DATE_INI, DATE_DATE_END  FROM wp_dates WHERE 
			DATE_CONTRATIST = '".$GROUP_CONTRATIST."' AND DATE_DATE >= '".$now."' AND DATE_STATE = '0' ";
			$query = $this->db->query($str);
			$actualDates = $query;
			

			
			if(count($actualDates)>0)
			{
				for($i=0; $i<count($actualDates); $i++)
				{
					// GET ACTUALDATE DAY
					
					$date = new DateTime($actualDates[$i]["DATE_DATE"]);
					$day = $date->format('Y-m-d');
					$dateDay = $date->format('D');
					
					if($dateDay == "Mon"){$dateDay = "Lunes";}
					if($dateDay == "Tue"){$dateDay = "Martes";}
					if($dateDay == "Wed"){$dateDay = "Miércoles";}
					if($dateDay == "Thu"){$dateDay = "Jueves";}
					if($dateDay == "Fri"){$dateDay = "Viernes";}
					if($dateDay == "Sat"){$dateDay = "Sábado";}
					if($dateDay == "Sun"){$dateDay = "Domingo";}
					
					// CHECK SAME DAY ONLY
					if($dateDay == $dayName)
					{
						$GINI_TIME = $actualDates[$i]["DATE_DATE_INI"];
						$GEND_TIME = $actualDates[$i]["DATE_DATE_END"];
						$add = 1;
						// IF INI HOUR INSIDE RANGE
						if($REMCOM_DATE_INI >= $GINI_TIME and $REMCOM_DATE_INI < $GEND_TIME){$add = 0;}
						// IF END HOUR INSIDE RANGE
						if($REMCOM_DATE_END > $GINI_TIME and $REMCOM_DATE_END < $GEND_TIME){$add = 0;}
						// IF REG INI INSIDE RANGE
						if($GINI_TIME >= $REMCOM_DATE_INI and $GINI_TIME < $REMCOM_DATE_END){$add = 0;}
						// IF REG END INSIDE RANGE
						if($GEND_TIME > $REMCOM_DATE_INI and $GEND_TIME < $REMCOM_DATE_END){$add = 0;}
						if($add == 0)
						{
							
							$detail = "Uno de los horarios se cruza con el siguiente horario de una cita activa: ".$actualDates[$i]["DATE_DATE"]." de ".$actualDates[$i]["DATE_DATE_INI"]." a ".$actualDates[$i]["DATE_DATE_END"];
							
							$resp["message"] = $detail;
							$resp["status"] = true;
							return $resp;
						}
					}
					
				}
			}
			
			

		}
		

		
		// -----------------PASS NO CROSS-------------
		$str = "UPDATE wp_groups SET 
		GROUP_HOURS = '".$GROUP_HOURS."'
		WHERE 
		GROUP_CODE ='".$GROUP_CODE."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = "updated";
		$resp["status"] = true;
		return $resp;
	}
	function deleteAssign($info)
	{
		$GROUP_CODE = $info["GROUP_CODE"];
		$GROUP_CONTRACT = $info["GROUP_CONTRACT"];
		
		// GET CONTRACT_OTHER_GOALS
		
		$str = "SELECT CONTRACT_OTHER_GOALS  FROM wp_contracts WHERE 
		CONTRACT_CODE = '".$GROUP_CONTRACT."'";
		$query = $this->db->query($str);
		
		
		// DELETE IF FOUND
		$CONTRACT_OTHER_GOALS = json_decode($query[0]["CONTRACT_OTHER_GOALS"], true);
		
		for($i=0; $i<count($CONTRACT_OTHER_GOALS); $i++)
		{
			if(array_key_exists("V4", $CONTRACT_OTHER_GOALS[$i]))
			{
				if($CONTRACT_OTHER_GOALS[$i]["V4"] == $GROUP_CODE)
				{
					unset($CONTRACT_OTHER_GOALS[$i]["V4"]);
					break;
				}
				
			}
		}
		
		// UPDATE CONTRACT_OTHER_GOALS
		$CONTRACT_OTHER_GOALS = json_encode($CONTRACT_OTHER_GOALS, true);
		$str = "UPDATE wp_contracts SET 
		CONTRACT_OTHER_GOALS = '".$CONTRACT_OTHER_GOALS."'
		WHERE 
		CONTRACT_CODE ='".$GROUP_CONTRACT."'";
		$query = $this->db->query($str);
		
		// UPDATE GROUP STATUS TO 0 AND CLEAR GROUP_CONTRACT
		
		$str = "UPDATE wp_groups SET 
		GROUP_CONTRACT = null,
		GROUP_STATUS = '0' 
		WHERE 
		GROUP_CODE ='".$GROUP_CODE."'";
		$query = $this->db->query($str);
		
		
		$ans = "deleted";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function cancelCesion($info)
	{
		$table = $info["table"];
		$code = $info["code"];
		$owner = $info["CONTRACT_OWNER"];
		
		$str = "UPDATE $table SET 
		CONTRACT_REQUESTER = '".$owner."',
		CONTRACT_CESION_STATE = '1'
		WHERE 
		CONTRACT_CODE ='".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function getInstituteData($info)
	{
		$INSTITUTE_CODE = $info["INSTITUTE_CODE"];
		
		$str = "SELECT * FROM wp_institutes WHERE INSTITUTE_CODE = '".$INSTITUTE_CODE."'";
		$query = $this->db->query($str);
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function getEntityGroups($info)
	{
		$ENTITY = $info["ENTITY"];
		
		$str = "SELECT GROUP_CODE, GROUP_NAME, GROUP_CITIZENS, GROUP_CONTRACT, GROUP_ACTIVITY FROM wp_groups WHERE GROUP_ENTITY = '".$ENTITY."' AND GROUP_CONTRACT != 'null' AND GROUP_CONTRACT != ''";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$pickedG = array();
		
		for($i=0; $i<count($query); $i++)
		{
			$item = $query[$i];
			$nowTime = date('H:i');

			// GET CONTRACT DATE RANGE
			$data = array();
			$data["CONTRACT_CODE"] = $item["GROUP_CONTRACT"];
			
			if(count($this->getContractData($data)["message"]) > 0)
			{
				$CONTRACT_DATA = $this->getContractData($data)["message"][0];
				$CONTRACT_INIDATE = $CONTRACT_DATA["CONTRACT_INIDATE"];
				$CONTRACT_ENDATE = $CONTRACT_DATA["CONTRACT_ENDATE"];
			}
			else{continue;}

			$now = new DateTime();
			$now = $now->format('Y-m-d');
			
			// CHECK VIGENCY OR JUMP
			if($CONTRACT_ENDATE < $now || $CONTRACT_INIDATE > $now){continue;}
			else{array_push($pickedG, $item);}
		}
		
		$resp["message"] = $pickedG;
		$resp["status"] = true;
		return $resp;
	}
	
	// GET CLASS CODE
	function getClassCode($info)
	{
		$CLASS_GROUP = $info["CLASS_GROUP"];
		$CLASS_DATE = $info["CLASS_DATE"];
		$CLASS_TIME_INI = $info["CLASS_TIME_INI"];
		
		$str = "SELECT CLASS_CODE FROM wp_classes WHERE CLASS_GROUP = '".$CLASS_GROUP."' AND CLASS_DATE = '".$CLASS_DATE."' AND CLASS_HOUR LIKE '%".$CLASS_TIME_INI."%'";
		$query = $this->db->query($str);
		
		
		$ans = $query;
		
		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	}
	
	// GET ALL ASSIGNATED GROUPS WITH HOURS
	function getClassGroups($info)
	{

		$str = "SELECT * FROM wp_groups WHERE GROUP_CONTRACT != 'null' AND GROUP_CONTRACT != '' ORDER BY GROUP_CONTRACT ASC";
		$query = $this->db->query($str);
		
		$activeGroups = array();
		
		for($i=0; $i<count($query); $i++)
		{
			$item = $query[$i];
			$nowTime = date('H:i');
			
			// GET CONTRACT DATE RANGE
			$data = array();
			$data["CONTRACT_CODE"] = $item["GROUP_CONTRACT"];
			
			
			if(count($this->getContractData($data)["message"]) > 0)
			{
				$CONTRACT_DATA = $this->getContractData($data)["message"][0];
				$CONTRACT_INIDATE = $CONTRACT_DATA["CONTRACT_INIDATE"];
				$CONTRACT_ENDATE = $CONTRACT_DATA["CONTRACT_ENDATE"];
				$CONTRACT_NUMBER = $CONTRACT_DATA["CONTRACT_NUMBER"];
				$CONTRACT_ACTIVITIES = $CONTRACT_DATA["CONTRACT_ACTIVITIES"];
			}
			else{continue;}
			
			
			
			
			// TUTOR DE LAS CLASES DEL GRUPO
			$GROUP_TUTOR = $CONTRACT_DATA["CONTRACT_OWNER"];
			
			$now = new DateTime();
			$now = $now->format('Y-m-d');
			
			// CHECK VIGENCY OR JUMP
			$active = 1;
			if($CONTRACT_ENDATE < $now || $CONTRACT_INIDATE > $now)
			{$active = 0;}
			if($active == 0){continue;}
			
			$item["GROUP_TUTOR"] = $GROUP_TUTOR;
			$item["GROUP_CONTRACT_NUMBER"] = $CONTRACT_NUMBER;
			$item["GROUP_CONTRACT_ACTIVITIES"] = $CONTRACT_ACTIVITIES;
			
			
			// GET TUTOR NAMES
			$data = array();
			$data["table"] = "wp_trusers";
			$data["fields"] = " USER_NAME, USER_LASTNAME ";
			$data["keyField"] = " USER_CODE ";
			$data["code"] = $item["GROUP_TUTOR"];
			
			$friendlyData = $this->getFriendlyData($data)["message"];
			
			$USER_NAME = $friendlyData["USER_NAME"];
			$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
			$user = $USER_NAME." ".$USER_LASTNAME;
			
			$item["GROUP_TUTOR_NAME"] = $user;
			
			
			// GET TUTOR TYPE
			$item["GROUP_TUTOR_TYPE"] = $CONTRACT_DATA["CONTRACT_USERTYPE"];
			
			
			array_push($activeGroups, $item);
		}
		
		$ans = $activeGroups;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// GET CITIZEN DETAIL
	function getCitizenDetail($info)
	{
		$id = $info["id"];
		
		$str = "SELECT * FROM wp_citizens WHERE 
		CITIZEN_IDNUM = '".$id."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// GET EVENT SUPPORT LIST
	function getSupportContracts($info)
	{
	
		$ENTITY = $info["ENTITY"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d');
		
		$ans = array();$selected;
		
		// GET CONTRACTS FOR REGULAR EVENTS
		
		if($ENTITY != "")
		{
			$str = "SELECT CONTRACT_CODE, CONTRACT_USERTYPE, CONTRACT_EVENT_GOALS, CONTRACT_OWNER, CONTRACT_NUMBER FROM wp_contracts WHERE CONTRACT_OWNER != '' AND CONTRACT_OWNER != 'null' AND CONTRACT_ENDATE >= '".$now."' AND CONTRACT_ENTITY = '".$ENTITY."'";
		}
		else
		{
			$str = "SELECT CONTRACT_CODE, CONTRACT_USERTYPE, CONTRACT_EVENT_GOALS, CONTRACT_OWNER, CONTRACT_NUMBER FROM wp_contracts WHERE CONTRACT_OWNER != '' AND CONTRACT_OWNER != 'null' AND CONTRACT_ENDATE >= '".$now."'";
		}
		
		
		$contracts = $this->db->query($str);
		
		$selected = array();
		
		for($i=0; $i<count($contracts); $i++)
		{
			$item = $contracts[$i];
			
			if($item["CONTRACT_EVENT_GOALS"] == "" or $item["CONTRACT_EVENT_GOALS"] == "[]")
			{$eventGoals = array();}
			else{$eventGoals = json_decode($item["CONTRACT_EVENT_GOALS"], true);}
			
			for($e=0; $e<count($eventGoals); $e++)
			{
				$goal = $eventGoals[$e];
				$supportValue = intval($goal["V2"]);
				if($supportValue > 0)
				{array_push($selected, $item); break;}
			}
		}

		// GET OWNER NAME
		for($i=0; $i<count($selected); $i++)
		{
			
			$item = $selected[$i];
			
			$data = array();
			$data["table"] = "wp_trusers";
			$data["fields"] = " USER_NAME, USER_LASTNAME ";
			$data["keyField"] = " USER_CODE ";
			$data["code"] = $item["CONTRACT_OWNER"];
			
			$friendlyData = $this->getFriendlyData($data)["message"];
			
			$USER_NAME = $friendlyData["USER_NAME"];
			$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
			
			$user = $USER_NAME." ".$USER_LASTNAME;

			$selected[$i]["CONTRACT_OWNER_NAME"] = $user;
		}
		
		$ans["avaEvent"] = $selected;
		
		// GET CONTRACTS FOR REQUEST EVENTS
		
		$str = "SELECT CONTRACT_CODE, CONTRACT_USERTYPE, CONTRACT_EVENT_GOALS, CONTRACT_OWNER, CONTRACT_NUMBER FROM wp_contracts WHERE 
		CONTRACT_OWNER != '' AND CONTRACT_OWNER != 'null' AND CONTRACT_ENDATE >= '".$now."'";
		$contracts = $this->db->query($str);
		
		$selected = array();
		
		for($i=0; $i<count($contracts); $i++)
		{
			$item = $contracts[$i];
			
			if($item["CONTRACT_EVENT_GOALS"] == "" or $item["CONTRACT_EVENT_GOALS"] == "[]")
			{$eventGoals = array();}
			else{$eventGoals = json_decode($item["CONTRACT_EVENT_GOALS"], true);}
			
			for($e=0; $e<count($eventGoals); $e++)
			{
				$goal = $eventGoals[$e];
				$supportValue = intval($goal["V1"]);
				if($supportValue > 0)
				{array_push($selected, $item); break;}
			}
		}
		
		// GET OWNER NAME
		for($i=0; $i<count($selected); $i++)
		{
			
			$item = $selected[$i];
			
			$data = array();
			$data["table"] = "wp_trusers";
			$data["fields"] = " USER_NAME, USER_LASTNAME ";
			$data["keyField"] = " USER_CODE ";
			$data["code"] = $item["CONTRACT_OWNER"];
			
			$friendlyData = $this->getFriendlyData($data)["message"];
			
			$USER_NAME = $friendlyData["USER_NAME"];
			$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
			
			$user = $USER_NAME." ".$USER_LASTNAME;

			$selected[$i]["CONTRACT_OWNER_NAME"] = $user;
		}
		
		$ans["avaReq"] = $selected;

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// GET PROGRAMMED EVENTS
	function getProgrammedEvents($info)
	{
		$EVENT_REQUEST_DATE = $info["EVENT_REQUEST_DATE"];
		$EVENT_ENTITY = $info["EVENT_ENTITY"];
		
		$str = "SELECT EVENT_CODE, EVENT_NAME, EVENT_DATE_INIR, EVENT_DATE_ENDR, EVENT_OWNER, EVENT_STATUS  FROM wp_events WHERE 
		EVENT_DATE_INIR LIKE '%".$EVENT_REQUEST_DATE."%' AND EVENT_ENTITY = '".$EVENT_ENTITY."'";
		$query = $this->db->query($str);
		
		for($i=0; $i<count($query); $i++)
		{
			$item = $query[$i];
			
			// GET OWNER DATA
			$data = array();
			$data["table"] = "wp_trusers";
			$data["fields"] = " USER_NAME, USER_LASTNAME ";
			$data["keyField"] = " USER_CODE ";
			$USER_CODE = $item["EVENT_OWNER"]; 
			$data["code"] = $USER_CODE;
			$friendlyData = $this->getFriendlyData($data)["message"];
			if($friendlyData != "none")
			{
				$USER_NAME = $friendlyData["USER_NAME"];
				$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
				$user = $CITIZEN_NAME." ".$CITIZEN_LASTNAME;
				
				$query[$i]["OWNER_NAME"] = $user;
			}
			else
			{
				$query[$i]["OWNER_NAME"] = "-";
			}
		}
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function getRemActiContracts($info)
	{
		
		$now = new DateTime();
		$now = $now->format('Y-m-d');
		
		$answer = array();
		
		$str = "SELECT * FROM wp_contracts WHERE CONTRACT_ENDATE >= '".$now."' AND  CONTRACT_INIDATE <= '".$now."' AND CONTRACT_CANREM_GET = 'Si' AND CONTRACT_OWNER != ''";
		$query = $this->db->query($str);
		
		$answer["active"] = $query;
		
		$USERS = array();
		
		for($i=0; $i<count($query); $i++)
		{
			$item = $query[$i];

			// GET CONTRACT OWNER
			$data = array();
			$data["table"] = "wp_trusers";
			$data["fields"] = " USER_CODE, USER_NAME, USER_LASTNAME, USER_IDNUM ";
			$data["keyField"] = " USER_CODE ";
			$data["code"] = $item["CONTRACT_OWNER"];
			
			$friendlyData = $this->getFriendlyData($data)["message"];
			$friendlyData["USER_ACTIVITIES"] = $item["CONTRACT_ACTIVITIES"];
			$friendlyData["USER_CONTRACT"] = $item["CONTRACT_NUMBER"];
			
			array_push($USERS, $friendlyData);
			

		}
		
		$answer["contratists"] = $USERS;
		
		
		$ans = $answer;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// CLASS DEMON
	function cdm()
	{

		// CHECK LAST EXCECUTION IGNORE IF EXECUTED BY USER AT LEAST 1 TIME IN THE LAST 2 MINUTES
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$str = "SELECT LAST_EXECUTION FROM wp_daemon";
		$query = $this->db->query($str);
		$last = $query[0]["LAST_EXECUTION"];
		
		$start_date = new DateTime($last);
		$since_start = $start_date->diff(new DateTime($now));
		
		$ans = $since_start->i;
		
		
		// fix to 3 after testing
		if(intval($ans) <= 2)
		// if(intval($ans) < 0)
		{
			$ans = "Ignore";
			$resp["message"] = $ans;
			$resp["status"] = true;
			return $resp;
		}
		else
		{
			$str = "UPDATE wp_daemon SET LAST_EXECUTION = '".$now."'";
			$update = $this->db->query($str);
		}
		
		
		// GET ALL ASSIGNATED GROUPS WITH HOURS
		$str = "SELECT * FROM wp_groups WHERE 
		GROUP_CONTRACT != 'null' AND GROUP_CONTRACT != '' AND GROUP_HOURS != 'null' AND GROUP_HOURS != '[]'";
		$query = $this->db->query($str);
		
		
		
		// EXIT IF NO GROUPS
		if(count($query) == 0)
		{$resp["message"] = "no groups"; $resp["status"] = true; return $resp;}
		
		 // THIS ARE THE CLASES THAT SHOULD EXIST FOR ALL GROUPS
		$shouldBeClasses = array();
		
		$PEOPLE_DATA = array();
		
		for($i=0; $i<count($query); $i++)
		// for($i=0; $i<100; $i++)
		{
			$item = $query[$i];
			$nowTime = date('H:i');

			// GET CONTRACT DATE RANGE
			$data = array();
			$data["CONTRACT_CODE"] = $item["GROUP_CONTRACT"];
			
			
			if(count($this->getContractData($data)["message"]) > 0)
			{
				$CONTRACT_DATA = $this->getContractData($data)["message"][0];	
			}
			else
			{
				continue;
			}
			
			
			
			
			
			$CONTRACT_INIDATE = $CONTRACT_DATA["CONTRACT_INIDATE"];
			$CONTRACT_ENDATE = $CONTRACT_DATA["CONTRACT_ENDATE"];
			$CONTRACT_NUMBER = $CONTRACT_DATA["CONTRACT_NUMBER"];
			
			// TUTOR DE LAS CLASES DEL GRUPO
			$CLASS_TUTOR = $CONTRACT_DATA["CONTRACT_OWNER"];

			$now = new DateTime();
			$now = $now->format('Y-m-d');
			
			// CHECK VIGENCY OR JUMP
			$active = 1;
			if($CONTRACT_ENDATE < $now || $CONTRACT_INIDATE > $now)
			{$active = 0;}
			if($active == 0){continue;}
			
			// CHECK HOURS EXIST OR JUMP
			$GROUP_HOURS = $item["GROUP_HOURS"];
			if($GROUP_HOURS == null){$GROUP_HOURS = array();}
			else
			{$GROUP_HOURS = json_decode($GROUP_HOURS, true);}
			if(count($GROUP_HOURS) == 0){continue;}
			
			

			// GET NAME FOR GROUP CITIZENS
			$GROUP_CITIZENS = $item["GROUP_CITIZENS"];
			if($GROUP_CITIZENS == null){$GROUP_CITIZENS = array();}
			else{$GROUP_CITIZENS = json_decode($GROUP_CITIZENS, true);}
			
			$citizens = $GROUP_CITIZENS;

			// GET USER NAMES AND AGE FOR CITIZENS
			for($c=0; $c<count($citizens); $c++)
			{
				$citizen = $citizens[$c];
				
				$data = array();
				$data["table"] = "wp_citizens";
				$data["fields"] = " CITIZEN_NAME, CITIZEN_LASTNAME, CITIZEN_BDAY ";
				$data["keyField"] = " CITIZEN_IDNUM ";
				$data["code"] = $citizen["CITIZEN_IDNUM"];
				$friendlyData = $this->getFriendlyData($data)["message"];
				
				if($friendlyData != "none")
				{
					$CITIZEN_NAME = $friendlyData["CITIZEN_NAME"];
					$CITIZEN_LASTNAME = $friendlyData["CITIZEN_LASTNAME"];
					$CITIZEN_BDAY = $friendlyData["CITIZEN_BDAY"];
					$d1 = $CITIZEN_BDAY;
					$d2 = $now;
					$diff = abs(strtotime($d1) - strtotime($d2));
					$age = floor($diff / (365*60*60*24));
					$citizens[$c]["CITIZEN_AGE"] = $age;
				}
				else
				{
					$CITIZEN_NAME = "-";
					$CITIZEN_LASTNAME = "";
					$CITIZEN_BDAY = "";
					$citizens[$c]["CITIZEN_AGE"] = "0";
				}
				
				$citizenName = $CITIZEN_NAME." ".$CITIZEN_LASTNAME;
				$citizens[$c]["CITIZEN_NAME"] = $citizenName;
			}
			
			
			// GET CONTRACT DAYS
			$inidate = new DateTime($CONTRACT_INIDATE);
			$enddate = new DateTime($CONTRACT_ENDATE);
			$enddate->setTime(0,0,1);
			$period = new DatePeriod($inidate,new DateInterval('P1D'),$enddate);
			
			
			
			// GET THIS CONTRACT CLASS DATES BY HOUR
			$CONTRACT_DATES = array();
			foreach ($period as $key => $date) 
			{
				$day = $date->format('Y-m-d');
				$dayName = $date->format('D');
				
				if($dayName == "Mon"){$dayName = "Lunes";}
				if($dayName == "Tue"){$dayName = "Martes";}
				if($dayName == "Wed"){$dayName = "Miércoles";}
				if($dayName == "Thu"){$dayName = "Jueves";}
				if($dayName == "Fri"){$dayName = "Viernes";}
				if($dayName == "Sat"){$dayName = "Sábado";}
				if($dayName == "Sun"){$dayName = "Domingo";}

				$fullDate = array();
				$fullDate["CLASS_DATE"] = $day;
				$fullDate["CLASS_DAY"] = $dayName;
				
				$anchor = new DateTime($now);
				$anchor = $anchor->modify ('-10 days');
				$anchor = $anchor->format('Y-m-d');

				
				if($day <= $now and $day > $anchor){array_push($CONTRACT_DATES,$fullDate);}
				// if($day <= $now){array_push($CONTRACT_DATES,$fullDate);}
			}
			
			
			

			// GET GROUPS HOURS
			$hours = $GROUP_HOURS;

			for($n=0; $n<count($hours); $n++)
			{
				$hour = $hours[$n];
				$hday = $hour["GROUP_TIME_DAY"];
				$hTime = $hour["GROUP_TIME_INI"];
				$hTimeEnd = $hour["GROUP_TIME_END"];
				$hLastSave = $hour["GROUP_TIME_LST"];

				// GET THIS HOUR DATES
				for($d=0; $d<count($CONTRACT_DATES); $d++)
				{
					$date = $CONTRACT_DATES[$d];
					
					$date["CLASS_CODE"] = md5($item["GROUP_CODE"].$date["CLASS_DATE"].$hTime);
					$date["CLASS_ENTITY"] = $item["GROUP_ENTITY"];
					$date["CLASS_GROUP"] = $item["GROUP_CODE"];
					$date["CLASS_ACTIVITY"] = $item["GROUP_ACTIVITY"];
					$date["CLASS_HOUR"] = $hour;
					$date["CLASS_TUTOR"] = $CLASS_TUTOR;
					$date["CLASS_CITIZENS"] = $citizens;
					$date["CLASS_EXCUSE"] = '';
					// $date["CLASS_GROUP_DATA"] = json_encode($item, true);
					$date["CLASS_GROUP_DATA"] = "";
					$date["CLASS_CONTRACT_NUMBER"] = $CONTRACT_NUMBER;
					

					$date["CLASS_TIME_NOW"] = $nowTime;
					$date["CLASS_TIME_INI"] = $hTime;
					$date["CLASS_TIME_END"] = $hTimeEnd;
					$date["CLASS_TIME_LST"] = $hLastSave;

					// CHECK IF ITS A VALID HOUR TO ADD
					if($date["CLASS_DAY"] == $hday)
					{
						// CHECK IF DATE > LAST EDIT BEFORE CREATE PAST CLASSES
						if($date["CLASS_DATE"] == $now)
						{
							if($nowTime >= $hour["GROUP_TIME_INI"])
							{
								
								$this_dateTime = strtotime($date["CLASS_DATE"]." ".$hTime.":00");
								if($this_dateTime > strtotime($hLastSave))
								{array_push($shouldBeClasses,$date);}
							}
						}
						// CHECK IF DATE > LAST EDIT BEFORE CREATE PAST CLASSES
						else
						{
							
							$this_date = strtotime($date["CLASS_DATE"]);
							if($this_date > strtotime($hLastSave))
							{array_push($shouldBeClasses,$date);}
						}
						
					}
				}
			}

			
		}
		

		// EXIT IF NO SHOULDBE
		if(count($query) == 0)
		{$resp["message"] = "no shouldbe";$resp["status"] = true;return $resp;}
		
		// CHECK IF CLASES EXIST SELECT CREATE LIST
		$createList = array();
		for($i=0; $i<count($shouldBeClasses); $i++)
		{
			
			$CLASS_CODE = $shouldBeClasses[$i]["CLASS_CODE"];

			$str = "SELECT CLASS_CODE FROM wp_classes USE INDEX(CLASS_CODE_INDEX) WHERE CLASS_CODE = '".$CLASS_CODE."'";
			$query = $this->db->query($str);
			
			// SELECT IF NOT IN TABLE
			if(count($query) > 0){continue;}
			else{array_push($createList,$shouldBeClasses[$i]);}
		}
		

		
		// POSIBLE CHECK FOR COINCIDENT USER HOUR SIMULTANEOUS
		// POSIBLE CHECK FOR COINCIDENT USER HOUR SIMULTANEOUS
		// POSIBLE CHECK FOR COINCIDENT USER HOUR SIMULTANEOUS
		// POSIBLE CHECK FOR COINCIDENT USER HOUR SIMULTANEOUS
		// POSIBLE CHECK FOR COINCIDENT USER HOUR SIMULTANEOUS
		// POSIBLE CHECK FOR COINCIDENT USER HOUR SIMULTANEOUS
		// POSIBLE CHECK FOR COINCIDENT USER HOUR SIMULTANEOUS
		// POSIBLE CHECK FOR COINCIDENT USER HOUR SIMULTANEOUS
		
		// FOR ITEM IN CLASS
		
		//I = 0, ADD TO COFIRMED
		// I > 0, CHECK IF IN CONFIRMED ARRAY (USER, DAY, HOUR) COINCIDENCE
		
		
				
		// CREATE CLASESS FROM CONFIRMED LIST
		
		$save = "no news";
		
		for($i=0; $i<count($createList); $i++)
		{
			$class = $createList[$i];
			$class["MODE"] = "0";
			$save = $this->saveClass($class)["message"];
		}

		$ans = $query;
		
		$resp["message"] = $save;
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
		
		$str = "SELECT CLASS_HOUR, CLASS_CITIZENS FROM wp_classes WHERE CLASS_DATE = '".$CLASS_DATE."'";
		$todayClasses = $this->db->query($str);
		
		for($c=0; $c<count($CITIZEN_ASSIST_LIST); $c++)
		{
			$guy = $CITIZEN_ASSIST_LIST[$c];
			$CITIZEN_IDNUM = $guy["CITIZEN_IDNUM"];
			$CITIZEN_ASSIST = $guy["CITIZEN_ASSIST"];

			if($CITIZEN_ASSIST == "1")
			{
				// MARK ASSIST
				$newState = "1";
				
				
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
					if($CLASS_INI >= $classIni and $CLASS_INI < $classEnd)
					{$add = 0;}
					// IF END HOUR INSIDE RANGE
					if($CLASS_END > $classIni and $CLASS_END < $classEnd)
					{$add = 0;}
					// IF REG INI INSIDE RANGE
					if($classIni >= $CLASS_INI and $classIni < $CLASS_END)
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
						{
							$actualCitizens[$n]["CITIZEN_ASSIST"] = $newState;
							
						}
						
						$actualCitizens[$n]["CITIZEN_SAVED"] = $guy["CITIZEN_SAVED"];
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
					{
						$actualCitizens[$n]["CITIZEN_ASSIST"] = $newState;
						
					}
					
					$actualCitizens[$n]["CITIZEN_SAVED"] = $guy["CITIZEN_SAVED"];
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
	
	function stateChanger($info)
	{
		$table = $info["table"];
		$field = $info["field"];
		$key = $info["key"];
		$code = $info["code"];
		$actual = $info["actual"];
		
		if($actual == "0"){$new = "1";}
		else{$new = "0";}
		
		if($field == "USER_CALLER")
		{
			if($new == "0")
			{
				$goal = "";
				$endate = "";
			}
			else
			{
				$goal = $info["USER_CALLER_GOAL"];
				$endate = $info["USER_CALLER_ENDATE"];
			}
			
			$str = "UPDATE $table SET 
			$field = '".$new."',
			USER_CALLER_GOAL = '".$goal."',
			USER_CALLER_ENDATE = '".$endate."'
			WHERE $key ='".$code."'";
			$query = $this->db->query($str);
		}
		else
		{
			$str = "UPDATE $table SET 
			$field = '".$new."'
			WHERE 
			$key ='".$code."'";
			$query = $this->db->query($str);
		}

		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// GET ITEMS LIST FROM CODE
	function getItemList($info)
	{
		$code = $info["code"];
		$table = $info["table"];
		$field = $info["field"];
		
		if($field == "GROUP_CITIZENS")
		{
			$str = "SELECT $field FROM $table WHERE 
			GROUP_CODE = '".$code."'";
			$query = $this->db->query($str);
			
			$GROUP_CITIZENS = $query[0]["GROUP_CITIZENS"];
			
			if($GROUP_CITIZENS == null){$GROUP_CITIZENS = array();}
			else
			{
				$GROUP_CITIZENS = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($GROUP_CITIZENS));
				
				$GROUP_CITIZENS = json_decode($GROUP_CITIZENS, true);
			}
			
			$citizens = $GROUP_CITIZENS;

			// GET USER NAMES
			for($i=0; $i<count($citizens); $i++)
			{
				$item = $citizens[$i];
				
				$data = array();
				$data["table"] = "wp_citizens";
				$data["fields"] = " CITIZEN_NAME, CITIZEN_LASTNAME ";
				$data["keyField"] = " CITIZEN_IDNUM ";
				$data["code"] = $item["CITIZEN_IDNUM"];
				
				$friendlyData = $this->getFriendlyData($data)["message"];
				if($friendlyData != "none")
				{
					$USER_NAME = $friendlyData["CITIZEN_NAME"];
					$USER_LASTNAME = $friendlyData["CITIZEN_LASTNAME"];
				}
				else
				{
					// continue;
					$USER_NAME = "-";
					$USER_LASTNAME = "";
				}

				$user = $USER_NAME." ".$USER_LASTNAME;
				$citizens[$i]["CITIZEN_NAME"] = $user;
			}
			
			$ans = $citizens;
		}
		if($field == "CLASS_CITIZENS")
		{
			$str = "SELECT $field FROM $table WHERE 
			CLASS_CODE = '".$code."'";
			$query = $this->db->query($str);
			
			$CLASS_CITIZENS = $query[0]["CLASS_CITIZENS"];
			
			if($CLASS_CITIZENS != null and $CLASS_CITIZENS != "" and $CLASS_CITIZENS != "null")
			{
				$CLASS_CITIZENS = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($CLASS_CITIZENS));
				$CLASS_CITIZENS = json_decode($CLASS_CITIZENS, true);
			}
			else
			{
				$CLASS_CITIZENS = array();
			}
			
			$citizens = $CLASS_CITIZENS;
			
			if(count($citizens) > 0)
			{
				// GET USER NAMES
				for($i=0; $i<count($citizens); $i++)
				{
					$item = $citizens[$i];
					
					$data = array();
					$data["table"] = "wp_citizens";
					$data["fields"] = " CITIZEN_NAME, CITIZEN_LASTNAME ";
					$data["keyField"] = " CITIZEN_IDNUM ";
					$data["code"] = $item["CITIZEN_IDNUM"];
					
					$friendlyData = $this->getFriendlyData($data)["message"];
					
					if($friendlyData != "none")
					{
						$USER_NAME = $friendlyData["CITIZEN_NAME"];
						$USER_LASTNAME = $friendlyData["CITIZEN_LASTNAME"];
					}
					else
					{
						$USER_NAME = "-";
						$USER_LASTNAME = "";
					}
	
					$user = $USER_NAME." ".$USER_LASTNAME;
					$citizens[$i]["CITIZEN_NAME"] = $user;
				}
			}

			
			
			$ans = $citizens;
		}
		
		
		$userName = array_column($ans, 'CITIZEN_NAME');
		array_multisort($userName, SORT_ASC, $ans);
		
		
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// GET CONTRACT DATA
	function getContractData($info)
	{
		$CONTRACT_CODE = $info["CONTRACT_CODE"];
		
		$str = "SELECT * FROM wp_contracts WHERE 
		CONTRACT_CODE = '".$CONTRACT_CODE."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function syncGroup($info)
	{
		$classCode = $info["classCode"];
		$groupCode = $info["groupCode"];
		
		// GET CLASS CITIZENS
		$str = "SELECT CLASS_CITIZENS FROM wp_classes WHERE CLASS_CODE = '".$classCode."'";
		$classCitizens = $this->db->query($str)[0]["CLASS_CITIZENS"];
		if($classCitizens != null and $classCitizens != "null" and $classCitizens != "")
		{
			$classCitizens = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($classCitizens));
			$classCitizens = json_decode($classCitizens, true);
		}
		else
		{$classCitizens = array();}
		
		// GET GROUP CITIZENS
		$str = "SELECT GROUP_CITIZENS FROM wp_groups WHERE GROUP_CODE = '".$groupCode."'";
		$groupCitizens = $this->db->query($str)[0]["GROUP_CITIZENS"];
		if($groupCitizens != null and $groupCitizens != "null" and $groupCitizens != "")
		{
			$groupCitizens = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($groupCitizens));
			$groupCitizens = json_decode($groupCitizens, true);
		}
		else
		{$groupCitizens = array();}
		
		// COMPARE AND GET DIFERENCES
		$diffs = array();
		for($i=0; $i<count($groupCitizens); $i++)
		{
			$itemId = $groupCitizens[$i]["CITIZEN_IDNUM"];
			$exist = 0;
			for($c=0; $c<count($classCitizens); $c++)
			{
				$item2Id = $classCitizens[$c]["CITIZEN_IDNUM"];
				if($itemId == $item2Id)
				{$exist = 1; break;}
			}
			if($exist == 0){array_push($diffs, $groupCitizens[$i]);}
		}
		
		$now = new DateTime();
		$now = $now->format('Y-m-d');
		
		// GET USER NAMES AND AGE FOR CITIZENS
		for($c=0; $c<count($diffs); $c++)
		{
			$citizen = $diffs[$c];
			
			$data = array();
			$data["table"] = "wp_citizens";
			$data["fields"] = " CITIZEN_NAME, CITIZEN_LASTNAME, CITIZEN_BDAY ";
			$data["keyField"] = " CITIZEN_IDNUM ";
			$data["code"] = $citizen["CITIZEN_IDNUM"];
			
			$friendlyData = $this->getFriendlyData($data)["message"];
			
			// GET NAME
			$CITIZEN_NAME = $friendlyData["CITIZEN_NAME"];
			$CITIZEN_LASTNAME = $friendlyData["CITIZEN_LASTNAME"];
			$citizenName = $CITIZEN_NAME." ".$CITIZEN_LASTNAME;
			$diffs[$c]["CITIZEN_NAME"] = $citizenName;
			
			// GET AGE
			$CITIZEN_BDAY = $friendlyData["CITIZEN_BDAY"];
			$d1 = $CITIZEN_BDAY;
			$d2 = $now;
			$diff = abs(strtotime($d1) - strtotime($d2));
			$age = floor($diff / (365*60*60*24));
			$diffs[$c]["CITIZEN_AGE"] = $age;
		}
		
		// ADD DIFERENCES TO CLASS AND GET UPDATED
		
		for($c=0; $c<count($diffs); $c++)
		{
			$newItem = $diffs[$c];
			array_push($classCitizens, $newItem);
		}
		
		$updated = count($diffs);
		
		$classCitizens = json_encode($classCitizens, true);
		
		// SAVE CLASS CITIZENS
		$str = "UPDATE wp_classes SET CLASS_CITIZENS = '".$classCitizens."' WHERE CLASS_CODE ='".$classCode."'";
		$query = $this->db->query($str);
		
		$resp["message"] = $updated;
		$resp["status"] = true;
		return $resp;
	}
	
	function checkUserPass($info)
	{
		$USER_EMAIL = $info["USER_EMAIL"];
		$USER_PASS = $info["USER_PASS"];
		$USER_ENTITY = $info["USER_ENTITY"];
		
		
		$str = "SELECT USER_CODE FROM wp_trusers WHERE USER_ENTITY = '".$USER_ENTITY."' AND USER_EMAIL = '".$USER_EMAIL."' AND USER_PASS = '".md5($USER_PASS)."'";
		$query = $this->db->query($str);	
		
		if(count($query) > 0)
		{
			$ans = "Si";
		}
		else
		{
			$ans = "No";
		}
		
		
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// GET EXCUSE DATA CLEAR
	function getExcuseData($info)
	{
		$classCode = $info["classCode"];
		$mode = $info["mode"];
		
		$str = "SELECT CLASS_EXCUSE FROM wp_classes WHERE 
		CLASS_CODE = '".$classCode."'";
		$query = $this->db->query($str);
		$ans = $query[0]["CLASS_EXCUSE"];

		$tmp = "";
		
		if($ans != "" and $ans != "null" and $ans != null)
		{
			$tmp = json_decode($ans, true);
			
			if($mode == "0")
			{
				$tmp["EXCUSE_FILE"] = "";
				$tmp = json_encode($tmp, true);
				$ans = $tmp;
			}
			else
			{
				$ans = $tmp["EXCUSE_FILE"];
			}
			
			
		}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// REM HISTORY
	function getRemHistory($info)
	{
		$REMCOM_LINE = $info["REMCOM_LINE"];
		$REMCOM_CITIZEN = $info["REMCOM_CITIZEN"];
		$REMCOM_MODE = $info["REMCOM_MODE"];
		
		$FIELDS = " 
		REMCOM_CODE,
		REMCOM_LINE,
		REMCOM_ENTITY,
		REMCOM_ACTIVITY,
		REMCOM_AUTOR,
		REMCOM_AUTOR_NAME,
		REMCOM_CONTRATIST,
		REMCOM_CONTRATIST_NAME,
		REMCOM_COMMENT,
		REMCOM_SPECIAL,
		REMCOM_GROUP,
		REMCOM_NEW_CONTRATIST,
		REMCOM_NEW_CONTRATIST_NAME,
		REMCOM_NEW_ACTIVITY,
		REMCOM_CITIZEN,
		REMCOM_CITIZEN_NAME,
		REMCOM_TYPE,
		REMCOM_DATE,
		REMCOM_COMPONENT,
		REMCOM_SCOMPONENT,
		REMCOM_REMSTATE ";
		
		if($REMCOM_MODE == "line")
		{
			$str = "SELECT $FIELDS FROM wp_attend WHERE REMCOM_LINE = '".$REMCOM_LINE."' AND REMCOM_CITIZEN = '".$REMCOM_CITIZEN."' ORDER BY REMCOM_DATE DESC";
		}
		if($REMCOM_MODE == "history")
		{
			$str = "SELECT $FIELDS FROM wp_attend WHERE REMCOM_CITIZEN = '".$REMCOM_CITIZEN."' ORDER BY REMCOM_DATE DESC";
		}
		
		$query = $this->db->query($str);

		$resp["message"] = $query;
		$resp["status"] = true;
		return $resp;
	}
	
	// LIST REFRESHER
	function refreshTable($info)
	{
		$FILTERS = $info["FILTERS"];
		$TABLE = $info["TABLE"];
		$USER_ENTITY = $info["USER_ENTITY"];
		$INDEX = $info["INDEX"];
		$ORDER = $info["ORDER"];
		$UTYPE = $info["UTYPE"];
		$EXPORT = $info["EXPORT"];
		$ucode = $info["ucode"];
		$LIMIT = $info["LIMIT"];
		$FIELDS = " * ";
		
		ini_set('memory_limit', '1024M');
		
		if($TABLE == "wp_visitable")
		{
			
			$ucode = $info["ucode"];
			$today = $info["INDEX"];
			$todayDay =  explode("-", $today)[2];
			$todayMonth = explode("-", $today)[1];
			$todayYear = explode("-", $today)[0];
			
			$now = new DateTime();
			$now = $now->format('Y-m-d');
			
			// CALCULO DE VISITAS FALTANTES PARA RESUMEN -------
			// CALCULO DE VISITAS FALTANTES PARA RESUMEN -------
			// CALCULO DE VISITAS FALTANTES PARA RESUMEN -------
			// CALCULO DE VISITAS FALTANTES PARA RESUMEN -------
			
			// GET MY CONTRACT INI AND END DATE
			$str = "SELECT CONTRACT_INIDATE, CONTRACT_ENDATE, CONTRACT_VISIT_GOALS  FROM wp_contracts WHERE 
			CONTRACT_OWNER = '".$ucode."' AND CONTRACT_ENDATE >= '".$now."'";
			$myContractData = $this->db->query($str)[0];
			if(count($myContractData) == 0)
			{
				$resp["message"] = "Expired";
				$resp["status"] = true;
				return $resp;
			}
			
			// CONTRACT INI AND END MONTH WITH YEAR
			$mcInidate = $myContractData["CONTRACT_INIDATE"];
			$mcInidateMonth = explode("-", $mcInidate)[1];
			$mcInidateYear = explode("-", $mcInidate)[0];
			
			$mcEndate = $myContractData["CONTRACT_ENDATE"];
			$mcEndateMonth = explode("-", $mcEndate)[1];
			$mcEndateYear = explode("-", $mcEndate)[0];

			// MY MONTH VISIT GOALS
			$mcVisitGoals = json_decode($myContractData["CONTRACT_VISIT_GOALS"], true);

			// CHECK IF MONTH IS STARTER, OTHER OR END
			// starter, days ava from start to monend
			// other, days full month
			// end, from 1 of month to end date
			$rule = "none";
			
			// EMPIEZA ESTE MES
			if($todayMonth == $mcInidateMonth and $todayYear == $mcInidateYear)
			{
				$rule = "stm";
				// TERMINA EL MISMO MES QUE EMPIEZA
				if($todayMonth == $mcEndateMonth and $todayYear == $mcEndateYear)
				{$rule = "stmaetm";}
				
			}
			else if($todayMonth == $mcEndateMonth and $todayYear == $mcEndateYear)
			{
				// TERMINA ESTE MES PERO NO EMPIEZA ESTE MES
				$rule = "etm";
			}
			else
			{
				// NI EMPIEZA NI TERMINA ESTE MES
				$rule = "fm";
			}
			
			// GET MY ACTIVITIES VISITS GOALS > 0 FOR EACH GET CONTRACTS LIST
			$vgoals = array();
			
			for($i=0; $i<count($mcVisitGoals); $i++)
			{
				if($mcVisitGoals[$i]["V1"] > 0){array_push($vgoals, $mcVisitGoals[$i]);}
			}

			$visitsToMakeMonth = 0;

			// -----------------COGESTOR BYPASS
			// -----------------COGESTOR BYPASS
			if($UTYPE == "Cogestor")
			{
				
				// MY ZONES WITH VISIT GOAL = $vgoals;
				
				// GET MY ZONES --> HOODS
				
				// GET HOODS FROM MY ZONES
				$str = "SELECT HOOD_CODE FROM wp_hoods WHERE HOOD_ZONE != 'null' AND (";			
				for($i=0; $i<count($vgoals); $i++)
				{
					$code = $vgoals[$i]["ID"];
					if($i < count($vgoals)-1){$str .= " HOOD_ZONE = '".$code."' OR ";}
					else{$str .= " HOOD_ZONE = '".$code."')";}
				}
				
				$myHoods = $this->db->query($str);
				

				// GET GROUPS FROM THIS HOODS
				
				// GET GROUPS FROM MY HOODS
				$str = "SELECT * FROM wp_groups WHERE GROUP_HOOD != 'null' AND (";			
				for($i=0; $i<count($myHoods); $i++)
				{
					$code = $myHoods[$i]["HOOD_CODE"];
					if($i < count($myHoods)-1){$str .= " GROUP_HOOD = '".$code."' OR ";}
					else{$str .= " GROUP_HOOD = '".$code."')";}
				}
				
				$str .= " AND GROUP_CONTRACT != '' AND GROUP_CONTRACT != 'null'";
				$hoodGroups = $this->db->query($str);
				
				
				// GET VALID GROUPS CODES
				$validGroupCodes = array();
				for($i=0; $i<count($hoodGroups); $i++)
				{array_push($validGroupCodes, $hoodGroups[$i]["GROUP_CODE"]);}
				
				
				// GET ALL ACTIVE CONTRACTS DIFFERENT THAN OWN WITH GROUPS WITH MY HOOD GROUPS
				$str = "SELECT CONTRACT_CODE, CONTRACT_ACTIVITIES, CONTRACT_OTHER_GOALS FROM wp_contracts WHERE 
				CONTRACT_OWNER != '".$ucode."' AND CONTRACT_INIDATE <= '".$now."' AND CONTRACT_ENDATE >= '".$now."'AND CONTRACT_ENTITY = '".$USER_ENTITY."' AND (";
				
				for($i=0; $i<count($hoodGroups); $i++)
				{
					$code = $hoodGroups[$i]["GROUP_CODE"];
					if($i < count($hoodGroups)-1){$str .= " CONTRACT_OTHER_GOALS LIKE '%".$code."%' OR ";}
					else{$str .= " CONTRACT_OTHER_GOALS LIKE '%".$code."%')";}
				}
				
				$pickedContracts = $this->db->query($str);
				
				for($i=0; $i<count($vgoals); $i++)
				{
					$acti = $vgoals[$i]["ID"];
					$actiQty = intval($vgoals[$i]["V1"]);
					
					$countContracts = array();
					
					$validGroups = array();
					
					for($j=0; $j<count($pickedContracts); $j++)
					{

						// GET CONTRACT VALID GROUPS
						$cGroups = json_decode($pickedContracts[$j]["CONTRACT_OTHER_GOALS"], true);
						$cValidGroups = array();
						for($c=0; $c<count($cGroups); $c++)
						{
							$cGroup = $cGroups[$c];
							if(array_key_exists("V4",$cGroup))
							{
								$gCode = $cGroup["V4"];
								if (in_array($gCode, $validGroupCodes))
								{array_push($cValidGroups, $gCode);}
							}
						}
						
						// GET ZONES FOR VALID GROUPS
						for($c=0; $c<count($cValidGroups); $c++)
						{
							$gCode = $cValidGroups[$c];
							
							// GET GROUP HOOD
							$data = array();
							$data["table"] = "wp_groups";
							$data["fields"] = " GROUP_HOOD ";
							$data["keyField"] = " GROUP_CODE ";
							$data["code"] = $gCode;
							$friendlyData = $this->getFriendlyData($data)["message"];
							$GROUP_HOOD = $friendlyData["GROUP_HOOD"];
							
							// GET HOOD ZONE
							$data = array();
							$data["table"] = "wp_hoods";
							$data["fields"] = " HOOD_ZONE ";
							$data["keyField"] = " HOOD_CODE ";
							$data["code"] = $GROUP_HOOD;
							$friendlyData = $this->getFriendlyData($data)["message"];
							$HOOD_ZONE = $friendlyData["HOOD_ZONE"];
							
							if($HOOD_ZONE == $acti)
							{
								array_push($countContracts, $pickedContracts[$j]);
								break;
							}
						}
					}
					
					// MULTIPLY MONTH VISIT GOAL * PICKED CONTRACTS QTY
					$contractsQty = count($countContracts);
					$add = $contractsQty*$actiQty;
					$visitsToMakeMonth += $add;
				}
				
				
				
			}
			else
			{
				
				// GET ALL ACTIVE CONTRACTS DIFFERENT THAN OWN WITH GROUPS
				$str = "SELECT CONTRACT_CODE, CONTRACT_ACTIVITIES, CONTRACT_OTHER_GOALS FROM wp_contracts WHERE 
				CONTRACT_OWNER != '".$ucode."' AND CONTRACT_INIDATE <= '".$now."' AND CONTRACT_ENDATE >= '".$now."'AND CONTRACT_OTHER_GOALS LIKE '%V4%' AND CONTRACT_ENTITY = '".$USER_ENTITY."'";
				$contracts = $this->db->query($str);
				
				// FILTER THE ONES WITH GROUP THAT INCLUDE ACTIVITY
				
				$pickedContracts = array();
				
				for($i=0; $i<count($vgoals); $i++)
				{
					$acti = $vgoals[$i]["ID"];
					$actiQty = intval($vgoals[$i]["V1"]);
					
					$countContracts = array();
					
					// TOTALIZAR PARA TODAS LAS ACTIVIDADES Y ES IGUAL A VISITAS MES VALOR
					for($j=0; $j<count($contracts); $j++)
					{
						$cActis = $contracts[$j]["CONTRACT_ACTIVITIES"];
						if(strpos($cActis, $acti) !== false)
						{
							array_push($pickedContracts, $contracts[$j]);
							array_push($countContracts, $contracts[$j]);
						}
					}

					// MULTIPLY MONTH VISIT GOAL * PICKED CONTRACTS QTY
					$contractsQty = count($countContracts);
					$add = $contractsQty*$actiQty;
					$visitsToMakeMonth += $add;
				}
			}
			// -----------------COGESTOR BYPASS END
			// -----------------COGESTOR BYPASS END
			
			
			
			// OBTENER DIAS DISPONIBLES DEL MES SEGUN TIPO DE MES
			
			$todayDate = new DateTime($today);
			
			if($rule == "stm")
			{
				$cInidate = new DateTime($mcInidate);
				$lastDayOfThisMonth = new DateTime('last day of this month');
				$nbOfDaysRemainingThisMonth = explode(" ",$lastDayOfThisMonth->diff($cInidate)->format('%a days'))[0];
				$monthAvDays = $nbOfDaysRemainingThisMonth;
				
				$leftDaysFromToday = explode(" ",$lastDayOfThisMonth->diff($todayDate)->format('%a days'))[0];
				
			}
			else if($rule == "stmaetm")
			{
				$cInidate = new DateTime($mcInidate);
				$lastDayOfThisMonth = new DateTime($mcEndate);
				$nbOfDaysRemainingThisMonth = explode(" ",$lastDayOfThisMonth->diff($cInidate)->format('%a days'))[0];
				$monthAvDays = $nbOfDaysRemainingThisMonth;
				
				$leftDaysFromToday = explode(" ",$lastDayOfThisMonth->diff($todayDate)->format('%a days'))[0];
			}
			else if($rule == "etm")
			{
				$cEnmdate = new DateTime($mcEndate." 23:59:59");
				$firstDayOfThisMonth = new DateTime('first day of this month 00:00:00');
				$nbOfDaysRemainingThisMonth = explode(" ",$firstDayOfThisMonth->diff($cEnmdate)->format('%a days'))[0];
				$monthAvDays = $nbOfDaysRemainingThisMonth+1;

				$leftDaysFromToday = explode(" ",$cEnmdate->diff($todayDate)->format('%a days'))[0];
				
			}
			else
			{
				// NI EMPIEZA NI TERMINA ESTE MES
				$monthAvDays = date('t');
				
				$lastDayOfThisMonth = new DateTime('last day of this month');
				$leftDaysFromToday = explode(" ",$lastDayOfThisMonth->diff($todayDate)->format('%a days'))[0];
			}
			
			if($monthAvDays > 30){$monthAvDays = 30;}
			
			// CALCULAR VISITAS PARA EL MES DE ACUERDO CON EL PROPORCIONAL DE DIAS DISPONIBLES DEL MES, DECIMAL REDONDEA HACIA ARRIBA
			$visitsProportional = ($visitsToMakeMonth*$monthAvDays)/30;
			
			//### DE VISITAS REALIZADAS DEL MES ACTUAL POR ESTE USUARIO SIN IMPORTAR A QUIEN

			$firstDayOfThisMonth = new DateTime('first day of this month 00:00:00');
			$firstOfMonth = $firstDayOfThisMonth->format('Y-m-d');
			
			$lastDayOfThisMonth = new DateTime('last day of this month');
			$lastOfMonth = $lastDayOfThisMonth->format('Y-m-d')." 23:59:59";
			
			
			$str = "SELECT VISIT_OWNER, VISIT_GROUP FROM wp_visits WHERE VISIT_OWNER = '".$ucode."' AND VISIT_DATE >= '".$firstOfMonth."' AND VISIT_DATE <= '".$lastOfMonth."'";
			$myVisits = $this->db->query($str);

			$visited = count($myVisits);
			
			
			// DIAS RESTANTES DISPONIBLES DEL MES ACTUAL
			if($leftDaysFromToday > 0)
			{
				$dayVisitGoal = intval(($visitsProportional - $visited)/$leftDaysFromToday);
			}
			else
			{
				// SI ES ULTIMO DIA ES TOTAL DEL MES MENOS LAS HECHAS
				$dayVisitGoal = intval(($visitsToMakeMonth - $visited));
			}
			

			// --------------------------------------------------------------------------
			// --------------------------------------------------------------------------
			// --------------------------------------------------------------------------
			

			// LISTADO DE CLASES --------
			// LISTADO DE CLASES --------
			// LISTADO DE CLASES --------
			// LISTADO DE CLASES --------
			
			

			// -----------------COGESTOR BYPASS
			// -----------------COGESTOR BYPASS
			
			if($UTYPE != "Cogestor")
			{
				// GET GROUP HOURS FOR GROUPS WITH MY ACTIS
				$actiGroups = array();
				
				for($i=0; $i<count($pickedContracts); $i++)
				{
					$contract = $pickedContracts[$i];
					$cOtherGoals = json_decode($contract["CONTRACT_OTHER_GOALS"], true);
					
					for($j=0; $j<count($cOtherGoals); $j++)
					{
						$goal = $cOtherGoals[$j];
						
						if(array_key_exists("V4",$goal))
						{
							if (!in_array($goal["V4"], $actiGroups))
							{array_push($actiGroups, $goal["V4"]);}
						}
					}
				}
				
				if(count($actiGroups) > 0)
				{
					// GET HOURS FOR PICKED GROUPS
					$str = "SELECT * FROM wp_groups WHERE GROUP_HOURS != 'null' AND (";			
					for($i=0; $i<count($actiGroups); $i++)
					{
						$code = $actiGroups[$i];
						if($i < count($actiGroups)-1){$str .= " GROUP_CODE = '".$code."' OR ";}
						else{$str .= " GROUP_CODE = '".$code."')";}
					}
					
					// $resp["message"] = $str;
					// $resp["status"] = true;
					// return $resp;
					
					$groups = $this->db->query($str);
				}
				else
				{
					$groups = array();
				}
			}
			else
			{
				$groups = array();
				
				for($i=0; $i<count($hoodGroups); $i++)
				{
					$gr = $hoodGroups[$i];
					$grContract = $gr["GROUP_CONTRACT"];
					$grHood = $gr["GROUP_HOOD"];
					$grHours = $gr["GROUP_HOURS"];
					
					if($grHours == null or $grHours == ""){continue;}
					
					$data = array();
					$data["table"] = "wp_contracts";
					$data["fields"] = " CONTRACT_INIDATE, CONTRACT_ENDATE ";
					$data["keyField"] = " CONTRACT_CODE ";
					$data["code"] = $grContract;
					$friendlyData = $this->getFriendlyData($data)["message"];
					if($friendlyData != "none")
					{
						$CONTRACT_INIDATE = $friendlyData["CONTRACT_INIDATE"];
						$CONTRACT_ENDATE = $friendlyData["CONTRACT_ENDATE"];
					}
					else
					{
						continue;
					}
					
					
					$data = array();
					$data["table"] = "wp_hoods";
					$data["fields"] = " HOOD_ZONE ";
					$data["keyField"] = " HOOD_CODE ";
					$data["code"] = $grHood;
					$friendlyData = $this->getFriendlyData($data)["message"];
					$HOOD_ZONE = $friendlyData["HOOD_ZONE"];
					
					$gr["HOOD_ZONE"] = $HOOD_ZONE;
					
					
					if($CONTRACT_INIDATE <= $now and $CONTRACT_ENDATE >= $now)
					{array_push($groups, $gr);}

				}
			}
		

			// -----------------COGESTOR BYPASS END
			// -----------------COGESTOR BYPASS END

			// GET TODAY DAY 
			$todayDate = new DateTime($today);
			$tday = $todayDate->format('Y-m-d');
			$todayName = $todayDate->format('D');
			if($todayName == "Mon"){$todayName = "Lunes";}
			if($todayName == "Tue"){$todayName = "Martes";}
			if($todayName == "Wed"){$todayName = "Miércoles";}
			if($todayName == "Thu"){$todayName = "Jueves";}
			if($todayName == "Fri"){$todayName = "Viernes";}
			if($todayName == "Sat"){$todayName = "Sábado";}
			if($todayName == "Sun"){$todayName = "Domingo";}
			
			// GET YESTERDAY DAY 
			$yesterday =  date('Y-m-d', strtotime($today. ' - 1 days'));
			$yesterdayDate = new DateTime($yesterday);
			$yday = $yesterdayDate->format('Y-m-d');
			$yesterdayName = $yesterdayDate->format('D');
			if($yesterdayName == "Mon"){$yesterdayName = "Lunes";}
			if($yesterdayName == "Tue"){$yesterdayName = "Martes";}
			if($yesterdayName == "Wed"){$yesterdayName = "Miércoles";}
			if($yesterdayName == "Thu"){$yesterdayName = "Jueves";}
			if($yesterdayName == "Fri"){$yesterdayName = "Viernes";}
			if($yesterdayName == "Sat"){$yesterdayName = "Sábado";}
			if($yesterdayName == "Sun"){$yesterdayName = "Domingo";}
			
			// GET TODAY'S AND YESTERDAY CLASSES FOR EACH GROUP
			
			$classesListToday = array();
			$classesListYsday = array();
			
			for($i=0; $i<count($groups); $i++)
			{
				$gr = $groups[$i];
				$grHours = json_decode($gr["GROUP_HOURS"], true);

				// GET CONTRACT DATA
				$grContract = $gr["GROUP_CONTRACT"];
				$grActivity = $gr["GROUP_ACTIVITY"];
				$grName = $gr["GROUP_NAME"];
				$grCode = $gr["GROUP_CODE"];
				
				
				
				
				// -----------------COGESTOR BYPASS
				// -----------------COGESTOR BYPASS
				
				if($UTYPE != "Cogestor")
				{
					// GET MY ACTIVITY GOAL
					
					$thisActyGoal = 0;
					
					for($g=0; $g<count($vgoals); $g++)
					{
						if($vgoals[$g]["ID"] == $grActivity)
						{
							$thisActyGoal = $vgoals[$g]["V1"];
						}
					}
					
					
					// $resp["message"] = $vgoals;
					// $resp["status"] = true;
					// return $resp;
					
					// GET CONTRACT VISITED COUNT
					$str = "SELECT VISIT_CODE FROM wp_visits WHERE 
					VISIT_CONTRACT = '".$grContract."' AND VISIT_ACTIVITY = '".$grActivity."' AND VISIT_DATE >= '".$firstOfMonth."' AND VISIT_DATE <= '".$lastOfMonth."' AND VISIT_OWNER = '".$ucode."'";
					
					
					$contractVisited = count($this->db->query($str));
					// IGNORE CONTRACT IF VISITED GOAL
					if($contractVisited >= $thisActyGoal){continue;}
				}
				else
				{
					// IGNORE CONTRACT IF VISITED GOAL COGESTOR
					
					$grZone = $gr["HOOD_ZONE"];

					// GET ZONE GOAL
					for($g=0; $g<count($vgoals); $g++)
					{if($vgoals[$g]["ID"] == $grZone){$thisZoneGoal = $vgoals[$g]["V1"];}}

					// GET CONTRACT VISITED COUNT
					$str = "SELECT VISIT_CODE FROM wp_visits WHERE 
					VISIT_CONTRACT = '".$grContract."' AND VISIT_ZONE = '".$grZone."' AND VISIT_DATE >= '".$firstOfMonth."' AND VISIT_DATE <= '".$lastOfMonth."' AND VISIT_OWNER = '".$ucode."'";
					$contractVisited = count($this->db->query($str));
					// IGNORE CONTRACT IF VISITED GOAL
					if($contractVisited >= $thisZoneGoal){continue;}
					
				}
				// -----------------COGESTOR BYPASS END
				// -----------------COGESTOR BYPASS END
				
				// $resp["message"] = $contractVisited;
				// $resp["status"] = true;
				// return $resp;
				
				$data = array();
				$data["table"] = "wp_contracts";
				$data["fields"] = " CONTRACT_OWNER ";
				$data["keyField"] = " CONTRACT_CODE ";
				$data["code"] = $grContract;
				$friendlyData = $this->getFriendlyData($data)["message"];
				$CONTRACT_OWNER = $friendlyData["CONTRACT_OWNER"];
				
				$data = array();
				$data["table"] = "wp_trusers";
				$data["fields"] = " USER_NAME, USER_LASTNAME, USER_IDTYPE, USER_IDNUM, USER_PHONE, USER_EMAIL ";
				$data["keyField"] = " USER_CODE ";
				$data["code"] = $CONTRACT_OWNER;
				
				$friendlyData = $this->getFriendlyData($data)["message"];
				
				$USER_NAME = $friendlyData["USER_NAME"];
				$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
				$USER_IDTYPE = $friendlyData["USER_IDTYPE"];
				$USER_IDNUM = $friendlyData["USER_IDNUM"];
				$USER_PHONE = $friendlyData["USER_PHONE"];
				$USER_EMAIL = $friendlyData["USER_EMAIL"];
				
				$user = $USER_NAME." ".$USER_LASTNAME;
				$userId = $USER_IDTYPE." ".$USER_IDNUM;
				$phone = $USER_PHONE;
				$email = $USER_EMAIL;

				$gr["CONTRACT_REQUESTER_NAME"] = $user;
				$gr["CONTRACT_REQUESTER_ID"] = $userId;
				$gr["CONTRACT_REQUESTER_PHONE"] = $phone;
				$gr["CONTRACT_REQUESTER_EMAIL"] = $email;
				
				
				// GET COOPERATOR DATA
				$grCooperator = explode("-",$gr["GROUP_COPERATOR"])[0];
				
				$data = array();
				$data["table"] = "wp_citizens";
				$data["fields"] = " CITIZEN_NAME, CITIZEN_LASTNAME, CITIZEN_IDTYPE, CITIZEN_IDNUM, CITIZEN_PHONE, CITIZEN_EMAIL ";
				$data["keyField"] = " CITIZEN_IDNUM ";
				$data["code"] = $grCooperator;
				
				$friendlyData = $this->getFriendlyData($data)["message"];
				
				$USER_NAME = $friendlyData["CITIZEN_NAME"];
				$USER_LASTNAME = $friendlyData["CITIZEN_LASTNAME"];
				$USER_IDTYPE = $friendlyData["CITIZEN_IDTYPE"];
				$USER_IDNUM = $friendlyData["CITIZEN_IDNUM"];
				$USER_PHONE = $friendlyData["CITIZEN_PHONE"];
				$USER_EMAIL = $friendlyData["CITIZEN_EMAIL"];
				
				$user = $USER_NAME." ".$USER_LASTNAME;
				$userId = $USER_IDTYPE." ".$USER_IDNUM;
				$phone = $USER_PHONE;
				$email = $USER_EMAIL;

				$gr["COOPERATOR_NAME"] = $user;
				$gr["COOPERATOR_ID"] = $userId;
				$gr["COOPERATOR_PHONE"] = $phone;
				$gr["COOPERATOR_EMAIL"] = $email;
				
				$pass = 0;
				
				for($j=0; $j<count($grHours); $j++)
				{
					$class = $grHours[$j];
					
					if($class["GROUP_TIME_DAY"] == $todayName)
					{
						$class["GROUP_DATA"] = $gr;
						$class["CLASS_DATE"] = $tday;
						$class["GROUP_NAME"] = $grName;
						
						// CHECK IF CLASS IS VISITED
						$str = "SELECT VISIT_CODE FROM wp_visits WHERE VISIT_GROUP = '".$grCode."' AND VISIT_CLASS_DATE = '".$tday."' AND VISIT_CLASS_INI_TIME = '".$class["GROUP_TIME_INI"]."' AND VISIT_OWNER = '".$ucode."' ";
						$vstd = count($this->db->query($str));
						
						if($vstd > 0)
						{continue;}
						else
						{array_push($classesListToday, $class);}
						
					}
					if($class["GROUP_TIME_DAY"] == $yesterdayName)
					{
						$class["GROUP_DATA"] = $gr;
						$class["CLASS_DATE"] = $yday;
						
						
						// CHECK IF CLASS IS VISITED
						$str = "SELECT VISIT_CODE FROM wp_visits WHERE VISIT_GROUP = '".$grCode."' AND VISIT_CLASS_DATE = '".$yday."' AND VISIT_CLASS_INI_TIME = '".$class["GROUP_TIME_INI"]."' AND VISIT_OWNER = '".$ucode."'";
						$vstd = count($this->db->query($str));
						
						if($vstd > 0)
						{continue;}
						else
						{array_push($classesListYsday, $class);}
						
					}
					
				}
			}
			
			$iniTime = array_column($classesListToday, 'GROUP_TIME_INI');
			array_multisort($iniTime, SORT_ASC, $classesListToday);
			
			$iniTime = array_column($classesListYsday, 'GROUP_TIME_INI');
			array_multisort($iniTime, SORT_ASC, $classesListYsday);
			
			
			$classesList = array_merge($classesListToday, $classesListYsday);
			
			// FINAL FILTER
			
			// listado de clases: excluir las clases de los contratos-actividad que hayan sido visitados por mi la cantidad de veces igual a la meta bÃ¡sica/mes actual.

			// omitir para el mismo grupo visitado la cantidad de veces de la meta mensual para la actividad


			$ans = array();
			$ans["dayGoal"] = $dayVisitGoal;
			$ans["classList"] = $classesList;
			$ans["visited"] = $visited;
			$ans["visitsToMakeMonth"] = $visitsToMakeMonth;
			
			$testAns = array();
			$testAns["visits"] = $myVisits;
			$testAns["range"] = $firstOfMonth."---".$lastOfMonth;
			
			
			$ans["testfield"] = $testAns;
			
			$resp["message"] = $ans;
			$resp["status"] = true;
			return $resp;
			
			
			
		}

		
		$where = "WHERE  $INDEX != 'null' ";
		
		if($TABLE == "wp_contracts")
		{
			$USER_CTYPE_F = $FILTERS["USER_CTYPE_F"];
			$USER_CODE_F = $FILTERS["USER_CODE_F"];
			$USER_ENTITY_F = $FILTERS["USER_ENTITY_F"];
			$USER_ACTIVITIES_F = json_decode($FILTERS["USER_ACTIVITIES_F"], true);
			$CONTRACT_OWNER_F = utf8_encode($FILTERS["CONTRACT_OWNER_F"]);
			$CONTRACT_USERTYPE_F = $FILTERS["CONTRACT_USERTYPE_F"];
			$CONTRACT_ACTIVITIES_F = $FILTERS["CONTRACT_ACTIVITIES_F"];
			$CONTRACT_NUMBER_F = $FILTERS["CONTRACT_NUMBER_F"];
			
			// USER FILTERS
			if($CONTRACT_OWNER_F != "")
			{
				$str = "SELECT USER_CODE FROM wp_trusers WHERE CONCAT(TRIM(USER_NAME),' ',TRIM(USER_LASTNAME)) LIKE '%".$CONTRACT_OWNER_F."%'";
				$matchCodes = $this->db->query($str);

				if(count($matchCodes) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($matchCodes); $i++)
					{
						$matchCode = $matchCodes[$i]["USER_CODE"];
						$where .= "CONTRACT_OWNER LIKE '%".$matchCode."%' OR CONTRACT_REQUESTER LIKE '%$matchCode%'";
						
						if($i != count($matchCodes) -1)
						{
							$where .= " OR CONTRACT_REQUESTER LIKE '%$matchCode%' OR ";
						}
					}
					$where .= ") ";
				}
				else
				{
					$where .= "AND (CONTRACT_OWNER LIKE '%$CONTRACT_OWNER_F%' OR CONTRACT_REQUESTER LIKE '%$CONTRACT_OWNER_F%') ";
				}
				
			} 
			
			if($CONTRACT_USERTYPE_F != "")
			{$where .= "AND CONTRACT_USERTYPE LIKE '%$CONTRACT_USERTYPE_F%'";}
			if($CONTRACT_NUMBER_F != "")
			{$where .= "AND CONTRACT_NUMBER LIKE '%$CONTRACT_NUMBER_F%'";}
			
			if($CONTRACT_ACTIVITIES_F != "")
			{
				$str = "SELECT ACTIVITY_CODE FROM wp_activities WHERE ACTIVITY_NAME LIKE '%".$CONTRACT_ACTIVITIES_F."%'";
				$matchCodes = $this->db->query($str);

				if(count($matchCodes) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($matchCodes); $i++)
					{
						$matchCode = $matchCodes[$i]["ACTIVITY_CODE"];
						$where .= "CONTRACT_ACTIVITIES LIKE '%".$matchCode."%'";
						if($i != count($matchCodes) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				else
				{
					$where .= "AND CONTRACT_ACTIVITIES LIKE '%$CONTRACT_ACTIVITIES_F%'";
				}
				
			} 
			if($USER_CTYPE_F == "General")
			{
				$where .= " AND (CONTRACT_REQUESTER = '$USER_CODE_F' OR CONTRACT_OWNER = '$USER_CODE_F' ) ";
			}
			if($USER_CTYPE_F != "Superior")
			{
				$where .= " AND CONTRACT_ENTITY = '$USER_ENTITY_F' ";
				
				if($USER_CTYPE_F == "Coordinador")
				{
					// GET RELATED ACTIVITIES CONTRACTS
					
					$where .= " AND (";
					for($i=0; $i<count($USER_ACTIVITIES_F); $i++)
					{
						$ACT = $USER_ACTIVITIES_F[$i];

						$where .= "CONTRACT_ACTIVITIES LIKE '%".$ACT."%'";
						
						if($i != count($USER_ACTIVITIES_F) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
					
					$where .= " AND (CONTRACT_USERTYPE = 'Cogestor' OR CONTRACT_USERTYPE = 'Instructor' ) ";
	
					
					$where .= " OR CONTRACT_REQUESTER = '$USER_CODE_F' OR CONTRACT_OWNER = '$USER_CODE_F' ";

				}
				if($USER_CTYPE_F == "Director")
				{
					// GET RELATED ACTIVITIES CONTRACTS

					if(count($USER_ACTIVITIES_F) > 0)
					{
						$where .= " AND (";
						for($i=0; $i<count($USER_ACTIVITIES_F); $i++)
						{
							$ACT = $USER_ACTIVITIES_F[$i];

							$where .= "CONTRACT_ACTIVITIES LIKE '%".$ACT."%'";
							
							if($i != count($USER_ACTIVITIES_F) -1)
							{$where .= " OR ";}
						}
						$where .= ") ";
					}
					
					$where .= " AND (CONTRACT_USERTYPE = 'Cogestor' OR CONTRACT_USERTYPE = 'Instructor' OR CONTRACT_USERTYPE = 'Coordinador') ";
	
					if($CONTRACT_OWNER_F == "" and $CONTRACT_USERTYPE_F == "")
					{
						$where .= " OR CONTRACT_REQUESTER = '$USER_CODE_F' OR CONTRACT_OWNER = '$USER_CODE_F' ";
					}
					

				}
				if($USER_CTYPE_F == "Cogestor")
				{
					$where .= " AND CONTRACT_REQUESTER = '$USER_CODE_F' OR CONTRACT_OWNER = '$USER_CODE_F' ";
				}
				if($USER_CTYPE_F == "Instructor")
				{
					$where .= " AND CONTRACT_REQUESTER = '$USER_CODE_F' OR CONTRACT_OWNER = '$USER_CODE_F' ";
				}
				if($USER_CTYPE_F == "Visitador")
				{
					$where .= " AND CONTRACT_REQUESTER = '$USER_CODE_F' OR CONTRACT_OWNER = '$USER_CODE_F' ";
				}
				if($USER_CTYPE_F == "Reportes")
				{
					$where .= " AND CONTRACT_REQUESTER = '$USER_CODE_F' OR CONTRACT_OWNER = '$USER_CODE_F' ";
				}
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
		if($TABLE == "wp_trusers")
		{
			
			$FIELDS = " 
			USER_CODE,
			USER_ENTITY,
			USER_NAME,
			USER_LASTNAME,
			USER_IDTYPE,
			USER_IDNUM,
			USER_BDAY,
			USER_PHONE,
			USER_EMAIL,
			USER_PASS,
			USER_REGDATE,
			USER_STATUS,
			USER_TYPE,
			USER_CALLER,
			USER_CALLER_GOAL,
			USER_CALLER_ENDATE ";
			
			$USER_CTYPE_F = $FILTERS["USER_CTYPE_F"];
			$USER_ENTITY_F = $FILTERS["USER_ENTITY_F"];
			$USER_NAME_F = $FILTERS["USER_NAME_F"];
			$USER_LASTNAME_F = $FILTERS["USER_LASTNAME_F"];
			$USER_IDNUM_F = $FILTERS["USER_IDNUM_F"];
			
			
			if($USER_CTYPE_F != "Superior"){$where .= "AND USER_ENTITY LIKE '%$USER_ENTITY_F%'";} 
			if($USER_NAME_F != ""){$where .= "AND USER_NAME LIKE '%$USER_NAME_F%'";} 
			if($USER_LASTNAME_F != ""){$where .= "AND USER_LASTNAME LIKE '%$USER_LASTNAME_F%'";} 
			if($USER_IDNUM_F != ""){$where .= "AND USER_IDNUM LIKE '%$USER_IDNUM_F%'";} 
		}
		if($TABLE == "wp_citizens")
		{
			$CITIZEN_NAME_F = $FILTERS["CITIZEN_NAME_F"];
			$CITIZEN_LASTNAME_F = $FILTERS["CITIZEN_LASTNAME_F"];
			$CITIZEN_IDNUM_F = $FILTERS["CITIZEN_IDNUM_F"];
			$CITIZEN_ETNIA_F = $FILTERS["CITIZEN_ETNIA_F"];
			$CITIZEN_CONDITION_F = $FILTERS["CITIZEN_CONDITION_F"];
			
			
			if($CITIZEN_NAME_F != ""){$where .= "AND CITIZEN_NAME LIKE '%$CITIZEN_NAME_F%'";} 
			if($CITIZEN_LASTNAME_F != ""){$where .= "AND CITIZEN_LASTNAME LIKE '%$CITIZEN_LASTNAME_F%'";} 
			if($CITIZEN_IDNUM_F != ""){$where .= "AND CITIZEN_IDNUM LIKE '%$CITIZEN_IDNUM_F%'";} 
			
			if($CITIZEN_ETNIA_F != "")
			{
				$str = "SELECT ETNIA_CODE FROM wp_etnias WHERE ETNIA_NAME LIKE '%".$CITIZEN_ETNIA_F."%'";
				$matchCodes = $this->db->query($str);

				if(count($matchCodes) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($matchCodes); $i++)
					{
						$matchCode = $matchCodes[$i]["ETNIA_CODE"];
						$where .= "CITIZEN_ETNIA LIKE '%".$matchCode."%'";
						if($i != count($matchCodes) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				else
				{
					$where .= "AND CITIZEN_ETNIA LIKE '%$CITIZEN_ETNIA_F%'";
				}
				
			} 
			
			if($CITIZEN_CONDITION_F != "")
			{
				$str = "SELECT CONDITION_CODE FROM wp_conditions WHERE CONDITION_NAME LIKE '%".$CITIZEN_CONDITION_F."%'";
				$matchCodes = $this->db->query($str);

				if(count($matchCodes) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($matchCodes); $i++)
					{
						$matchCode = $matchCodes[$i]["CONDITION_CODE"];
						$where .= "CITIZEN_CONDITION LIKE '%".$matchCode."%'";
						if($i != count($matchCodes) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				else
				{
					$where .= "AND CITIZEN_CONDITION LIKE '%$CITIZEN_CONDITION_F%'";
				}
				
				
			} 
		}
		if($TABLE == "wp_programs")
		{
			
			$PROGRAM_ENTITY_F = $FILTERS["PROGRAM_ENTITY_F"];
			
			if($PROGRAM_ENTITY_F != "")
			{
				$str = "SELECT ENTITY_CODE FROM wp_entities WHERE ENTITY_NAME LIKE '%".$PROGRAM_ENTITY_F."%'";
				$matchCodes = $this->db->query($str);

				if(count($matchCodes) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($matchCodes); $i++)
					{
						$matchCode = $matchCodes[$i]["ENTITY_CODE"];
						$where .= "PROGRAM_ENTITY LIKE '%".$matchCode."%'";
						if($i != count($matchCodes) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				else
				{
					$where .= "AND PROGRAM_ENTITY LIKE '%$PROGRAM_ENTITY_F%'";
				}
				
			} 
			
			
			if($UTYPE != "Superior")
			{
				$PROGRAM_ENTITY_F = $FILTERS["PROGRAM_ENTITY_F"];
				$where .= "AND PROGRAM_ENTITY = '$PROGRAM_ENTITY_F'";
			}
		}
		if($TABLE == "wp_entities")
		{
			$ENTITY_CITY_F = $FILTERS["ENTITY_CITY_F"];
			
			// USER FILTERS
			
			if($ENTITY_CITY_F != "")
			{$where .= "AND ENTITY_CITY LIKE '%$ENTITY_CITY_F%'";}
		}
		if($TABLE == "wp_projects")
		{
			
			$PROJECT_NAME_F = $FILTERS["PROJECT_NAME_F"];
			$PROJECT_PROGRAM_F = $FILTERS["PROJECT_PROGRAM_F"];
			
			// USER FILTERS
			
			if($PROJECT_NAME_F != "")
			{$where .= "AND PROJECT_NAME LIKE '%$PROJECT_NAME_F%'";}
			
			if($PROJECT_PROGRAM_F != "")
			{
				$str = "SELECT PROGRAM_CODE FROM wp_programs WHERE PROGRAM_NAME LIKE '%".$PROJECT_PROGRAM_F."%'";
				$matchCodes = $this->db->query($str);

				if(count($matchCodes) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($matchCodes); $i++)
					{
						$matchCode = $matchCodes[$i]["PROGRAM_CODE"];
						$where .= "PROJECT_PROGRAM LIKE '%".$matchCode."%'";
						if($i != count($matchCodes) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				else
				{
					$where .= "AND PROJECT_PROGRAM LIKE '%$PROJECT_PROGRAM_F%'";
				}
				
			} 

			if($UTYPE != "Superior")
			{
				$PROJECT_ENTITY_F = $FILTERS["PROJECT_ENTITY_F"];
				$where .= "AND PROJECT_ENTITY = '$PROJECT_ENTITY_F'";
			}
		}
		if($TABLE == "wp_activities")
		{
			
			$ACTIVITY_NAME_F = $FILTERS["ACTIVITY_NAME_F"];
			$ACTIVITY_PROJECT_F = $FILTERS["ACTIVITY_PROJECT_F"];
			
			// USER FILTERS
			
			
			if($ACTIVITY_NAME_F != "")
			{$where .= "AND ACTIVITY_NAME LIKE '%$ACTIVITY_NAME_F%'";}
		
			if($ACTIVITY_PROJECT_F != "")
			{
				$str = "SELECT PROJECT_CODE FROM wp_projects WHERE PROJECT_NAME LIKE '%".$ACTIVITY_PROJECT_F."%'";
				$matchCodes = $this->db->query($str);

				if(count($matchCodes) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($matchCodes); $i++)
					{
						$matchCode = $matchCodes[$i]["PROJECT_CODE"];
						$where .= "ACTIVITY_PROJECT LIKE '%".$matchCode."%'";
						if($i != count($matchCodes) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				else
				{
					$where .= "AND ACTIVITY_PROJECT LIKE '%$ACTIVITY_PROJECT_F%'";
				}
				
			} 
			
			if($UTYPE != "Superior")
			{
				$ACTIVITY_ENTITY_F = $FILTERS["ACTIVITY_ENTITY_F"];
				$where .= "AND ACTIVITY_ENTITY = '$ACTIVITY_ENTITY_F'";
			}
		}
		if($TABLE == "wp_zones")
		{
			
			
			$ZONE_CITY_F = $FILTERS["ZONE_CITY_F"];
			$ZONE_TYPE_F = $FILTERS["ZONE_TYPE_F"];
			$ZONE_NAME_F = $FILTERS["ZONE_NAME_F"];
			
			
			// USER FILTERS
			if($ZONE_CITY_F != ""){$where .= "AND ZONE_CITY LIKE '%$ZONE_CITY_F%'";}
			if($ZONE_TYPE_F != ""){$where .= "AND ZONE_TYPE LIKE '%$ZONE_TYPE_F%'";}
			if($ZONE_NAME_F != ""){$where .= "AND ZONE_NAME LIKE '%$ZONE_NAME_F%'";}
		
			
			if($UTYPE != "Superior")
			{
				$ZONE_CITY_F = $FILTERS["ZONE_CITY_F"];
				$where .= "AND ZONE_CITY = '$ZONE_CITY_F'";
			}
		}
		if($TABLE == "wp_hoods")
		{
			
			$HOOD_CITY_F = $FILTERS["HOOD_CITY_F"];
			$HOOD_ZONE_F = $FILTERS["HOOD_ZONE_F"];
			$HOOD_ZONE_TYPE_F = $FILTERS["HOOD_ZONE_TYPE_F"];
			$HOOD_NAME_F = $FILTERS["HOOD_NAME_F"];
			
			
			// USER FILTERS
			if($HOOD_NAME_F != ""){$where .= "AND HOOD_NAME LIKE '%$HOOD_NAME_F%'";}
			if($HOOD_CITY_F != ""){$where .= "AND HOOD_CITY LIKE '%$HOOD_CITY_F%'";}
			
			
			if($HOOD_ZONE_F != "")
			{
				$str = "SELECT ZONE_CODE FROM wp_zones WHERE ZONE_NAME LIKE '%".$HOOD_ZONE_F."%'";
				$matchCodes = $this->db->query($str);

				if(count($matchCodes) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($matchCodes); $i++)
					{
						$matchCode = $matchCodes[$i]["ZONE_CODE"];
						$where .= "HOOD_ZONE LIKE '%".$matchCode."%'";
						if($i != count($matchCodes) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				else
				{
					$where .= "AND HOOD_ZONE LIKE '%$HOOD_ZONE_F%'";
				}
				
			} 
			
			if($HOOD_ZONE_TYPE_F != "")
			{
				$str = "SELECT ZONE_CODE FROM wp_zones WHERE ZONE_TYPE LIKE '%".$HOOD_ZONE_TYPE_F."%'";
				$matchCodes = $this->db->query($str);

				if(count($matchCodes) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($matchCodes); $i++)
					{
						$matchCode = $matchCodes[$i]["ZONE_CODE"];
						$where .= "HOOD_ZONE LIKE '%".$matchCode."%'";
						if($i != count($matchCodes) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				else
				{
					$where .= "AND HOOD_ZONE LIKE '%$HOOD_ZONE_F%'";
				}
				
			} 
			
			
			
			
			if($UTYPE != "Superior")
			{
				$HOOD_CITY_F = $FILTERS["HOOD_CITY_F"];
				$where .= "AND HOOD_CITY = '$HOOD_CITY_F'";
			}
		}
		if($TABLE == "wp_institutes")
		{
			$INSTITUTE_NAME_F = $FILTERS["INSTITUTE_NAME_F"];
			$INSTITUTE_CITY_F = $FILTERS["INSTITUTE_CITY_F"];
			
			// USER FILTERS
			if($INSTITUTE_NAME_F != ""){$where .= "AND INSTITUTE_NAME LIKE '%$INSTITUTE_NAME_F%'";}
			if($INSTITUTE_CITY_F != ""){$where .= "AND INSTITUTE_CITY LIKE '%$INSTITUTE_CITY_F%'";}
			
			if($UTYPE != "Superior")
			{
				$INSTITUTE_CITY_F = $FILTERS["INSTITUTE_CITY_F"];
				$where .= "AND INSTITUTE_CITY = '$INSTITUTE_CITY_F'";
			}
		}
		if($TABLE == "wp_etaries")
		{
			$ETARIE_ENTITY_F = $FILTERS["ETARIE_ENTITY_F"];
	
			if($ETARIE_ENTITY_F != "")
			{
				$str = "SELECT ENTITY_CODE FROM wp_entities WHERE ENTITY_NAME LIKE '%".$ETARIE_ENTITY_F."%'";
				$matchCodes = $this->db->query($str);

				if(count($matchCodes) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($matchCodes); $i++)
					{
						$matchCode = $matchCodes[$i]["ENTITY_CODE"];
						$where .= "ETARIE_ENTITY LIKE '%".$matchCode."%'";
						if($i != count($matchCodes) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				else
				{
					$where .= "AND ETARIE_ENTITY LIKE '%$ETARIE_ENTITY_F%'";
				}
				
			} 
			
		}
		if($TABLE == "wp_conditions")
		{
			
			$CONDITION_NAME_F = $FILTERS["CONDITION_NAME_F"];
			
			// USER FILTERS
			if($CONDITION_NAME_F != ""){$where .= "AND CONDITION_NAME LIKE '%$CONDITION_NAME_F%'";}
			
			if($UTYPE != "Superior")
			{
				$CONDITION_ENTITY_F = $FILTERS["CONDITION_ENTITY_F"];
				$where .= "AND CONDITION_ENTITY = '$CONDITION_ENTITY_F'";
			}
		}
		if($TABLE == "wp_etnias")
		{
			
			$ETNIA_NAME_F = $FILTERS["ETNIA_NAME_F"];
			
			// USER FILTERS
			if($ETNIA_NAME_F != ""){$where .= "AND ETNIA_NAME LIKE '%$ETNIA_NAME_F%'";}
			
			if($UTYPE != "Superior")
			{
				$ETNIA_ENTITY_F = $FILTERS["ETNIA_ENTITY_F"];
				$where .= "AND ETNIA_ENTITY = '$ETNIA_ENTITY_F'";
			}
		}
		if($TABLE == "wp_groups")
		{
			
			$GROUP_NAME_F = $FILTERS["GROUP_NAME_F"];
			$GROUP_HOOD_F = $FILTERS["GROUP_HOOD_F"];

			// USER FILTERS
			if($GROUP_NAME_F != ""){$where .= "AND GROUP_NAME LIKE '%$GROUP_NAME_F%'";} 
			if($GROUP_HOOD_F != "")
			{
				$str = "SELECT HOOD_CODE FROM wp_hoods WHERE HOOD_NAME LIKE '%".$GROUP_HOOD_F."%'";
				$matchCodes = $this->db->query($str);

				if(count($matchCodes) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($matchCodes); $i++)
					{
						$matchCode = $matchCodes[$i]["HOOD_CODE"];
						$where .= "GROUP_HOOD LIKE '%".$matchCode."%'";
						if($i != count($matchCodes) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				else
				{
					$where .= "AND GROUP_HOOD LIKE '%$GROUP_HOOD_F%'";
				}
				
			} 
			
			if($UTYPE != "Superior")
			{
				$GROUP_ENTITY_F = $FILTERS["GROUP_ENTITY_F"];
				
				$USER_CTYPE_F = $FILTERS["USER_CTYPE_F"];
				$USER_ACTIVITIES_F = json_decode($FILTERS["USER_ACTIVITIES_F"]);
				$USER_HOODS_F = json_decode($FILTERS["USER_HOODS_F"]);
				
				$where .= "AND GROUP_ENTITY = '$GROUP_ENTITY_F'";
				
				// USER TYPE FILTERS

				if($USER_CTYPE_F == "Director" || $USER_CTYPE_F == "Coordinador")
				{
			
					// GET RELATED ACTIVITIES GROUPS

					if(count($USER_ACTIVITIES_F) > 0)
					{
						$where .= " AND (";
						for($i=0; $i<count($USER_ACTIVITIES_F); $i++)
						{
							$ACT = $USER_ACTIVITIES_F[$i];

							$where .= "GROUP_ACTIVITY LIKE '%".$ACT."%'";
							
							if($i != count($USER_ACTIVITIES_F) -1)
							{$where .= " OR ";}
						}
						$where .= ") ";
					}
				}
				if($USER_CTYPE_F == "Cogestor")
				{
					
					// FILTER BY HOOD
					if(count($USER_HOODS_F) == 0)
					{
						$resp["message"] = array();
						$resp["status"] = true;
						return $resp;
					}
					else
					{
						$where .= " AND (";
						for($i=0; $i<count($USER_HOODS_F); $i++)
						{
							$HOOD = $USER_HOODS_F[$i];

							$where .= "GROUP_HOOD LIKE '%".$HOOD."%'";
							
							if($i != count($USER_HOODS_F) -1)
							{$where .= " OR ";}
						}
						$where .= ") ";
					}
					
					// $USER_GROUPS_F = json_decode($FILTERS["USER_GROUPS_F"]);
					
					// if(count($USER_GROUPS_F) > 0)
					// {
						// $where .= " OR (";
						// for($i=0; $i<count($USER_GROUPS_F); $i++)
						// {
							// $CODE = $USER_GROUPS_F[$i];

							// $where .= "GROUP_CODE LIKE '%".$CODE."%'";
							
							// if($i != count($USER_GROUPS_F) -1)
							// {$where .= " OR ";}
						// }
						// $where .= ") ";
					// }
					
					
					
				}
				if($USER_CTYPE_F == "Instructor")
				{
					// GET RELATED ACTIVITIES GROUPS
					
					$USER_CONTRACT_F = $FILTERS["USER_CONTRACT_F"];
					$where .= "AND GROUP_CONTRACT = '$USER_CONTRACT_F'";
				}
			}
		}
		if($TABLE == "wp_classes")
		{

			$FIELDS = " 
			CLASS_CODE,
			CLASS_ENTITY,
			CLASS_GROUP,
			CLASS_ACTIVITY,
			CLASS_HOUR,
			CLASS_TUTOR,
			CLASS_DATE,
			CLASS_CITIZENS,
			CLASS_EXCUSE,
			CLASS_CREATED,
			CLASS_CONTRACT_CODE,
			CLASS_GROUP_GOAL,
			CLASS_CLASSES_GOAL,
			CLASS_TIMES_GOAL,
			CLASS_PEOPLE_GOAL,
			CLASS_CONTRACT_NUMBER ";
			
			
			if($UTYPE != "Superior")
			{
				$CLASS_ENTITY_F = $FILTERS["CLASS_ENTITY_F"];
				$where .= "AND CLASS_ENTITY = '$CLASS_ENTITY_F'";
			}
			
			$CLASS_DATE_INI_F = $FILTERS["CLASS_DATE_INI_F"];
			$CLASS_DATE_END_F = $FILTERS["CLASS_DATE_END_F"];
			
			if($CLASS_DATE_INI_F != ""){$where .= "AND CLASS_DATE >= '$CLASS_DATE_INI_F'";}
			if($CLASS_DATE_END_F != ""){$where .= "AND CLASS_DATE <= '$CLASS_DATE_END_F'";}
			
			$USER_CTYPE_F = $FILTERS["USER_CTYPE_F"];
			$CLASS_ACTIVITIES_F = json_decode($FILTERS["CLASS_ACTIVITIES_F"], true);
			$CLASS_GROUPS_F = json_decode($FILTERS["CLASS_GROUPS_F"], true);
			
			// FILTRAR POR ACTIVIDADES
			if($USER_CTYPE_F == "Director" || $USER_CTYPE_F == "Coordinador")
			{
				
				$where .= " AND (";
				for($i=0; $i<count($CLASS_ACTIVITIES_F); $i++)
				{
					$ACT = $CLASS_ACTIVITIES_F[$i];
					$where .= "CLASS_ACTIVITY LIKE '%".$ACT."%'";
					if($i != count($CLASS_ACTIVITIES_F) -1)
					{$where .= " OR ";}
				}
				$where .= ") ";
			}
			
			// FILTRAR POR GRUPOS
			if($USER_CTYPE_F == "Cogestor" || $USER_CTYPE_F == "Instructor")
			{
				if(count($CLASS_GROUPS_F) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($CLASS_GROUPS_F); $i++)
					{
						$GROUP = $CLASS_GROUPS_F[$i];
						$where .= "CLASS_GROUP LIKE '%".$GROUP."%'";

						if($i != count($CLASS_GROUPS_F) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				else
				{
					$resp["message"] = array();
					$resp["status"] = true;
					return $resp;
				}
			}
			
			
			// IF NO FILTER LIMIT TO TWO MONTHS BACK FROM NOW
			// IF NO FILTER LIMIT TO TWO MONTHS BACK FROM NOW
			// IF NO FILTER LIMIT TO TWO MONTHS BACK FROM NOW
			
			if($FILTERS["CLASS_DATE_INI_F"] == "" and 
			$FILTERS["CLASS_DATE_END_F"] == "" and 
			$FILTERS["CLASS_GNAME_F"] == "" and 
			$FILTERS["CLASS_CONTRATIST_F"] == "" and 
			$FILTERS["CLASS_ACTIVITY_F"] == "" and 
			$FILTERS["CLASS_PROJECT_F"] == "")
			{
					
				$now = new DateTime();
				$now = $now->format('Y-m-d');	
				$CUT = date('Y-m-d', strtotime($now. '-2 months'));
				$where .= "AND CLASS_DATE > '$CUT'";
			}
			
			
			

		}
		
		
		if($TABLE == "wp_events" or $TABLE == "wp_events_r")
		{
			
			$FIELDS = " 
			EVENT_CODE,
			EVENT_TYPE,
			EVENT_CREATED,
			EVENT_ENTITY,
			EVENT_OWNER,
			EVENT_DATE_INI,
			EVENT_DATE_END,
			EVENT_HOOD,
			EVENT_PREVIR,
			EVENT_ADDRESS,
			EVENT_COORDS,
			EVENT_ACTIVITIES,
			EVENT_SUPPORT_TEAM,
			EVENT_INSTYPE,
			EVENT_INSTITUTE,
			EVENT_COOPTYPE,
			EVENT_NAME,
			EVENT_COOPERATOR,
			EVENT_ASSIST,
			EVENT_TOTAL_PEOPLE,
			EVENT_RESUME,
			EVENT_AUTHOR,
			EVENT_STATUS,
			EVENT_REQUESTER,
			EVENT_ORIGIN,
			EVENT_RADICATE,
			EVENT_REQUEST_DATE,
			EVENT_REQUEST_TYPE,
			EVENT_REQUEST_ACTIVITY,
			EVENT_EXPECTED,
			EVENT_NEEDS,
			EVENT_DESCRIPTION,
			EVENT_DATE_INIR,
			EVENT_DATE_ENDR,
			EVENT_REJECT_REASON,
			EVENT_SERVPLACE,
			EVENT_CONTRACT_CODE";
			

			// EVENTS REGULAR-----
			if($info["TABLE"] == "wp_events")
			{
				
				// $where .= " AND EVENT_TYPE = '0' ";
				
				$EVENT_DATE_INI_F = $FILTERS["EVENT_DATE_INI_F"];
				$EVENT_DATE_END_F = $FILTERS["EVENT_DATE_END_F"];
				$EVENT_NAME_F = $FILTERS["EVENT_NAME_F"];
				$EVENT_ACTIVITY_F = $FILTERS["EVENT_ACTIVITY_F"];
				$EVENT_SUPPORT_F = $FILTERS["EVENT_SUPPORT_F"];
				$EVENT_HOOD_F = $FILTERS["EVENT_HOOD_F"];
				
				if($EVENT_DATE_INI_F != ""){$where .= "AND EVENT_DATE_INI >= '$EVENT_DATE_INI_F' ";} 
				if($EVENT_DATE_END_F != ""){$where .= "AND EVENT_DATE_INI < '$EVENT_DATE_END_F'";} 
				
				// $resp["message"] = $where;
				// $resp["status"] = true;
				// return $resp;
				
				
				if($EVENT_NAME_F != ""){$where .= "AND EVENT_NAME LIKE '%$EVENT_NAME_F%'";} 
			
				if($EVENT_ACTIVITY_F != "")
				{
					$str = "SELECT ACTIVITY_CODE FROM wp_activities WHERE ACTIVITY_NAME LIKE '%".$EVENT_ACTIVITY_F."%'";
					$matchCodes = $this->db->query($str);

					if(count($matchCodes) > 0)
					{
						$where .= " AND (";
						for($i=0; $i<count($matchCodes); $i++)
						{
							$matchCode = $matchCodes[$i]["ACTIVITY_CODE"];
							$where .= "EVENT_ACTIVITIES LIKE '%".$matchCode."%'";
							if($i != count($matchCodes) -1)
							{$where .= " OR ";}
						}
						$where .= ") ";
					}
					else
					{
						$where .= "AND EVENT_ACTIVITIES LIKE '%$EVENT_ACTIVITY_F%'";
					}
					
				} 
				
				if($EVENT_HOOD_F != "")
				{
					$str = "SELECT HOOD_CODE FROM wp_hoods WHERE HOOD_NAME LIKE '%".$EVENT_HOOD_F."%'";
					$matchCodes = $this->db->query($str);

					if(count($matchCodes) > 0)
					{
						$where .= " AND (";
						for($i=0; $i<count($matchCodes); $i++)
						{
							$matchCode = $matchCodes[$i]["HOOD_CODE"];
							$where .= "EVENT_HOOD LIKE '%".$matchCode."%'";
							if($i != count($matchCodes) -1)
							{$where .= " OR ";}
						}
						$where .= ") ";
					}
					else
					{
						$where .= "AND EVENT_HOOD LIKE '%$EVENT_HOOD_F%'";
					}
				} 
			}
			else
			{
				
				// $where .= " AND EVENT_TYPE = '1' ";
				
				// EVENTS REQUEST-----
				$EVENT_DATE_INI_F = $FILTERS["EVENT_DATE_INI_F"];
				$EVENT_DATE_END_F = $FILTERS["EVENT_DATE_END_F"];
								
			}
			

			if($UTYPE != "Superior")
			{
				$EVENT_ENTITY_F = $FILTERS["EVENT_ENTITY_F"];
				$where .= "AND EVENT_ENTITY = '$EVENT_ENTITY_F'";
			}
			
			$USER_CONTRACT_F = $FILTERS["USER_CONTRACT_F"];
			$USER_CODE_F = $FILTERS["USER_CODE_F"];
			$USER_CTYPE_F = $FILTERS["USER_CTYPE_F"];
			$EVENT_ACTIVITIES_F = json_decode($FILTERS["EVENT_ACTIVITIES_F"], true);
			
			if($TABLE == "wp_events")
			{
				$where .= "AND EVENT_TYPE = '0'";

				
				// FILTRAR POR ACTIVIDADES
				if($USER_CTYPE_F == "Director" || $USER_CTYPE_F == "Coordinador")
				{
					
					$where .= " AND (";
					for($i=0; $i<count($EVENT_ACTIVITIES_F); $i++)
					{
						$ACT = $EVENT_ACTIVITIES_F[$i];

						$where .= "EVENT_ACTIVITIES LIKE '%".$ACT."%'";
						
						if($i != count($EVENT_ACTIVITIES_F) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				
				// FILTER BY HOOD
				if($USER_CTYPE_F == "Cogestor")
				{
					

					
					$USER_HOODS_F = json_decode($FILTERS["USER_HOODS_F"], true);
					
					if(count($USER_HOODS_F) == 0)
					{
						$resp["message"] = array();
						$resp["status"] = true;
						return $resp;
					}
					else
					{
						$where .= " AND (";
						for($i=0; $i<count($USER_HOODS_F); $i++)
						{
							$HOOD = $USER_HOODS_F[$i];

							$where .= "EVENT_HOOD LIKE '%".$HOOD."%'";
							
							if($i != count($USER_HOODS_F) -1)
							{$where .= " OR ";}
						}
						$where .= ") ";
					}
				}
				
				// FILTER BY HOOD
				if($USER_CTYPE_F == "Instructor")
				{
					$where .= "AND EVENT_OWNER = '".$USER_CODE_F."'";
				}
				
				if($USER_CONTRACT_F != "")
				{
					$where .= "OR EVENT_SUPPORT_TEAM LIKE '%".$USER_CONTRACT_F."%'";
					$where .= "OR EVENT_OWNER LIKE '%".$USER_CODE_F."%'";
				}
				
				
			}
			else
			{
				// FILTRAR POR ACTIVIDADES
				if($USER_CTYPE_F == "Director" || $USER_CTYPE_F == "Coordinador")
				{
					
					$where .= " AND (";
					for($i=0; $i<count($EVENT_ACTIVITIES_F); $i++)
					{
						$ACT = $EVENT_ACTIVITIES_F[$i];

						$where .= "EVENT_REQUEST_ACTIVITY LIKE '%".$ACT."%'";
						
						if($i != count($EVENT_ACTIVITIES_F) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
				
				// FILTER BY HOOD
				if($USER_CTYPE_F == "Cogestor")
				{
					$USER_HOODS_F = json_decode($FILTERS["USER_HOODS_F"], true);
					
					
					if(count($USER_HOODS_F) == 0)
					{
						$resp["message"] = array();
						$resp["status"] = true;
						return $resp;
					}
					else
					{
						$where .= " AND (";
						for($i=0; $i<count($USER_HOODS_F); $i++)
						{
							$HOOD = $USER_HOODS_F[$i];

							$where .= "EVENT_HOOD LIKE '%".$HOOD."%'";
							
							if($i != count($USER_HOODS_F) -1)
							{$where .= " OR ";}
						}
						$where .= ") ";
					}
					
					// GET USER ASIGNED
					// $where .= "OR EVENT_OWNER = '".$USER_CODE_F."'";
					
				}
				
				// FILTER BY HOOD
				if($USER_CTYPE_F == "Instructor")
				{
					$where .= "AND EVENT_OWNER = '".$USER_CONTRACT_F."'";
				}
				
				$where .= "AND EVENT_TYPE = '1'";
				
				// if($EVENT_DATE_INI_F == "" and $EVENT_DATE_END_F == "")
				// {
					// $where .= " OR EVENT_AUTHOR = '".$USER_CODE_F."'";
				// }
				// else
				// {
					// $where .= " AND EVENT_AUTHOR = '".$USER_CODE_F."'";
				// }
				
				$where .= " OR EVENT_AUTHOR = '".$USER_CODE_F."'";
				
				if($USER_CONTRACT_F != "")
				{
					$where .= "OR (EVENT_SUPPORT_TEAM LIKE '%".$USER_CONTRACT_F."%' AND EVENT_TYPE = '1') ";
				}
				
				// $EVENT_ACTIVITIES_F = json_decode($FILTERS["EVENT_ACTIVITIES_F"], true);
				
				
				
			}
			
			
			
			
		}
		
		if($TABLE == "wp_events_r"){$TABLE = "wp_events";}

		if($TABLE == "wp_visits")
		{
			$FIELDS = " 
			VISIT_ENTITY,
			VISIT_CODE,
			VISIT_CLASS,
			VISIT_DATE,
			VISIT_OWNER,
			VISIT_DONE,
			VISIT_TYPE,
			VISIT_ASSISTQTY,
			VISIT_NOASSISTQTY,
			VISIT_STONTIME,
			VISIT_TOOLS,
			VISIT_GOODTIME,
			VISIT_GOODPLACE,
			VISIT_FORMAT,
			VISIT_PDELIVER,
			VISIT_COHERENT,
			VISIT_EASY,
			VISIT_ORIENT,
			VISIT_EXPRESSION,
			VISIT_PRESENT,
			VISIT_VERIFIED,
			VISIT_ACOMPLISH,
			VISIT_CONTRATIST_SIGN,
			VISIT_COMMENTS,
			VISIT_GROUP,
			VISIT_CONTRACT,
			VISIT_CONTRACT_CODE,
			VISIT_ACTIVITY,
			VISIT_CLASS_DATE,
			VISIT_CLASS_INI_TIME,
			VISIT_COORD,
			VISIT_CLASS_COORD,
			VISIT_CONTRATIST,
			VISIT_VISITOR,
			VISIT_GROUP_NAME,
			VISIT_HOOD,
			VISIT_ADDRESS,
			VISIT_MODE,
			VISIT_SIGNED,
			VISIT_ZONE ";

			// VISIT_CLASS_PLAN,
			// VISIT_ASSIST_LIST,
			// VISIT_CLASSPIC,
			
			if($UTYPE != "Superior")
			{
				$VISIT_ENTITY_F = $FILTERS["VISIT_ENTITY_F"];
				$USER_CTYPE_F = $FILTERS["USER_CTYPE_F"];
				$USER_ACTIVITIES_F = json_decode($FILTERS["USER_ACTIVITIES_F"]);
				$USER_HOODS_F = json_decode($FILTERS["USER_HOODS_F"]);
				
				$where .= "AND VISIT_ENTITY = '$VISIT_ENTITY_F' ";
				
				// USER FILTERS
				// if($GROUP_NAME_F != ""){$where .= "AND GROUP_NAME LIKE '%$GROUP_NAME_F%'";} 
				
				// USER TYPE FILTERS

				if($USER_CTYPE_F == "Director" || $USER_CTYPE_F == "Coordinador")
				{
			
					// GET RELATED ACTIVITIES GROUPS

					if(count($USER_ACTIVITIES_F) > 0)
					{
						$where .= " AND (";
						for($i=0; $i<count($USER_ACTIVITIES_F); $i++)
						{
							$ACT = $USER_ACTIVITIES_F[$i];

							$where .= "VISIT_ACTIVITY LIKE '%".$ACT."%'";
							
							if($i != count($USER_ACTIVITIES_F) -1)
							{$where .= " OR ";}
						}
						$where .= ") ";
					}
				}
				if($USER_CTYPE_F == "Cogestor")
				{
					
					$USER_CONTRACT_F = $FILTERS["USER_CONTRACT_F"];
					$where .= "AND VISIT_OWNER = '$ucode'";
				}
				if($USER_CTYPE_F == "Visitador")
				{
					
					
					$USER_CONTRACT_F = $FILTERS["USER_CONTRACT_F"];
					$where .= "AND VISIT_OWNER = '$ucode'";
				}
			}
			
			$VISIT_DATE_INI_F = $FILTERS["VISIT_DATE_INI_F"];
			$VISIT_DATE_END_F = $FILTERS["VISIT_DATE_END_F"];
			$VISIT_VISITOR_F = $FILTERS["VISIT_VISITOR_F"];
			$VISIT_CONTRATIST_F = $FILTERS["VISIT_CONTRATIST_F"];
			$VISIT_TYPE_F = $FILTERS["VISIT_TYPE_F"];
			
			if($VISIT_DATE_INI_F != ""){$where .= "AND VISIT_CLASS_DATE >= '$VISIT_DATE_INI_F'";} 
			if($VISIT_DATE_END_F != ""){$where .= "AND VISIT_CLASS_DATE <= '$VISIT_DATE_END_F'";} 
			if($VISIT_VISITOR_F != ""){$where .= "AND VISIT_VISITOR LIKE '%$VISIT_VISITOR_F%'";}
			if($VISIT_CONTRATIST_F != ""){$where .= "AND VISIT_CONTRATIST LIKE '%$VISIT_CONTRATIST_F%'";}
			if($VISIT_TYPE_F != ""){$where .= "AND VISIT_TYPE LIKE '%$VISIT_TYPE_F%'";}
			
		}
		if($TABLE == "wp_remitions")
		{

			$FIELDS = " 
			REM_CODE,
			REM_ENTITY,
			REM_AUTOR,
			REM_DATE,
			REM_REQUESTER,
			REM_REQUESTER_TYPE,
			REM_REQUESTER_NAME,
			REM_ACTIVITY,
			REM_CONTRATIST,
			REM_CITIZEN,
			REM_AUTOR_NAME,
			REM_CITIZEN_NAME,
			REM_CONTRATIST_NAME,
			REM_STATE,
			REM_LINE ";

			if($UTYPE != "Superior")
			{
				$REM_ENTITY = $FILTERS["REM_ENTITY_F"];
				$where .= "AND REM_ENTITY = '$REM_ENTITY'";
			}
			
			$REM_DATE_F = $FILTERS["REM_DATE_F"];
			$REM_AUTOR_F = $FILTERS["REM_AUTOR_F"];
			$REM_CITIZEN_NAME_F = $FILTERS["REM_CITIZEN_F"];
			$REM_CONTRATIST_F = $FILTERS["REM_CONTRATIST_F"];
			$REM_STATE_F = $FILTERS["REM_STATE_F"];

			if($REM_DATE_F != ""){$where .= "AND REM_DATE = '$REM_DATE_F'";}
			if($REM_AUTOR_F != ""){$where .= "AND REM_AUTOR_NAME LIKE '%".$REM_AUTOR_F."%'";}
			if($REM_CITIZEN_NAME_F != ""){$where .= "AND REM_CITIZEN_NAME LIKE '%".$REM_CITIZEN_NAME_F."%'";}
			if($REM_CONTRATIST_F != ""){$where .= "AND REM_CONTRATIST_NAME LIKE '%".$REM_CONTRATIST_F."%'";}
			if($REM_STATE_F != "")
			{
				if($REM_STATE_F == "Abierta"){$REM_STATE_F = "0";}
				else{$REM_STATE_F = "1";}

				$where .= "AND REM_STATE = '".$REM_STATE_F."'";
			}
			
		}
		
		if($TABLE == "wp_attend")
		{

			$FIELDS = " 
			REMCOM_CODE,
			REMCOM_LINE,
			REMCOM_ENTITY,
			REMCOM_ACTIVITY,
			REMCOM_AUTOR,
			REMCOM_AUTOR_NAME,
			REMCOM_CONTRATIST,
			REMCOM_CONTRATIST_NAME,
			REMCOM_COMMENT,
			REMCOM_COMMENT_DATE,
			REMCOM_SPECIAL,
			REMCOM_GROUP,
			REMCOM_NEW_CONTRATIST,
			REMCOM_NEW_CONTRATIST_NAME,
			REMCOM_NEW_ACTIVITY,
			REMCOM_CITIZEN,
			REMCOM_CITIZEN_NAME,
			REMCOM_TYPE,
			REMCOM_DATE,
			REMCOM_COMPONENT,
			REMCOM_SCOMPONENT,
			REMCOM_REMSTATE ";

			if($UTYPE != "Superior")
			{
				$REMCOM_ENTITY = $FILTERS["REMCOM_ENTITY_F"];
				$where .= "AND REMCOM_ENTITY = '$REMCOM_ENTITY'";
			}
			
			// SET FILTERS AS MODE
			$REMCOM_MODE_F = $FILTERS["REMCOM_MODE_F"];
			$REMCOM_USER_F = $FILTERS["REMCOM_USER_F"];
			
			
			if($REMCOM_MODE_F == "Línea de atención")
			{
				$REMCOM_LINE = $FILTERS["REMCOM_LINE_F"];
				$REMCOM_CITIZEN = $FILTERS["REMCOM_CITIZEN_F"];
				if($REMCOM_LINE != ""){$where .= "AND REMCOM_LINE = '$REMCOM_LINE'";}
				if($REMCOM_CITIZEN != ""){$where .= "AND REMCOM_CITIZEN = '$REMCOM_CITIZEN'";}
			}
			if($REMCOM_MODE_F == "Mi atención")
			{
				$REMCOM_LINE = $FILTERS["REMCOM_LINE_F"];
				$REMCOM_CITIZEN = $FILTERS["REMCOM_CITIZEN_F"];
				$REMCOM_USER = $FILTERS["REMCOM_USER_F"];
				if($REMCOM_LINE != ""){$where .= "AND REMCOM_LINE = '$REMCOM_LINE'";}
				if($REMCOM_CITIZEN != ""){$where .= "AND REMCOM_CITIZEN = '$REMCOM_CITIZEN'";}
				if($REMCOM_USER != ""){$where .= "AND REMCOM_CONTRATIST = '$REMCOM_USER'";}

			}
			if($REMCOM_MODE_F == "Todo el historial" or $REMCOM_MODE_F == "")
			{
				$REMCOM_CITIZEN = $FILTERS["REMCOM_CITIZEN_F"];
				if($REMCOM_CITIZEN != ""){$where .= "AND REMCOM_CITIZEN = '$REMCOM_CITIZEN'";}
			}
			
			$REMCOM_START_DATE_F = $FILTERS["REMCOM_START_DATE_F"];
			$REMCOM_AUTOR_F = $FILTERS["REMCOM_AUTOR_F"];
			$REMCOM_CONTRATIST_F = $FILTERS["REMCOM_CONTRATIST_F"];
			$REMCOM_SPECIAL_F = $FILTERS["REMCOM_SPECIAL_F"];
			$REMCOM_TYPE_F = $FILTERS["REMCOM_TYPE_F"];
			$REMCOM_COMMENT_F = $FILTERS["REMCOM_COMMENT_F"];
			
			if($REMCOM_START_DATE_F != ""){$where .= "AND REMCOM_REMINI = '$REMCOM_START_DATE_F'";}
			if($REMCOM_AUTOR_F != ""){$where .= "AND REMCOM_AUTOR_NAME LIKE '%".$REMCOM_AUTOR_F."%'";}
			if($REMCOM_COMMENT_F != ""){$where .= "AND REMCOM_COMMENT LIKE '%".$REMCOM_COMMENT_F."%'";}
			if($REMCOM_CONTRATIST_F != ""){$where .= "AND REMCOM_CONTRATIST_NAME LIKE '%".$REMCOM_CONTRATIST_F."%'";}
			if($REMCOM_SPECIAL_F != ""){$where .= "AND REMCOM_SPECIAL = '".$REMCOM_SPECIAL_F."'";}
			if($REMCOM_TYPE_F != "")
			{
				if($REMCOM_TYPE_F == "Normal"){$type = "normalComment";}
				if($REMCOM_TYPE_F == "Agrupación"){$type = "addGroup";}
				if($REMCOM_TYPE_F == "Desagrupación"){$type = "quitGroup";}
				if($REMCOM_TYPE_F == "Atención"){$type = "remit";}
				if($REMCOM_TYPE_F == "Cita"){$type = "date";}
				if($REMCOM_TYPE_F == "Cierre"){$type = "close";}
				if($REMCOM_TYPE_F == "Re apertura"){$type = "reopen";}
				if($REMCOM_TYPE_F == "Decisión"){$type = "decition";}
				$where .= "AND REMCOM_TYPE = '".$type."'";
			}

			$REMCOM_REMSTATE_F = $FILTERS["REMCOM_STATE_F"];
						
			if($REMCOM_REMSTATE_F != "")
			{
				if($REMCOM_REMSTATE_F == "Abierta"){$REMCOM_REMSTATE = "0";}
				else{$REMCOM_REMSTATE = "1";}

				$where .= "AND REMCOM_REMSTATE = '".$REMCOM_REMSTATE."'";
			}
			
		}
		
		if($TABLE == "wp_dates")
		{
			
			$FIELDS = " 
			DATE_CODE,
			DATE_LINE,
			DATE_ENTITY,
			DATE_CONTRATIST,
			DATE_CONTRATIST_NAME,
			DATE_CITIZEN,
			DATE_CITIZEN_NAME,
			DATE_COMMENT,
			DATE_DATE,
			DATE_DATE_INI,
			DATE_DATE_END,
			DATE_STATE,
			DATE_CLOSE_COMMENT,
			DATE_PLACE ";
			
			if($UTYPE != "Superior")
			{
				$DATE_ENTITY = $FILTERS["DATE_ENTITY_F"];
				$where .= "AND DATE_ENTITY = '$DATE_ENTITY'";
			}
			
			if($UTYPE != "Principal1" and $UTYPE != "Principal2" and $UTYPE != "Principal3")
			{
				$DATE_USER_CODE = $FILTERS["DATE_USER_CODE_F"];
				$where .= "AND DATE_CONTRATIST = '$DATE_USER_CODE'";
			}
			
			$DATE_CONTRATIST_F = $FILTERS["DATE_CONTRATIST_F"];
			
			if($DATE_CONTRATIST_F != ""){$where .= "AND DATE_CONTRATIST_NAME LIKE '%".$DATE_CONTRATIST_F."%'";}
			
			$DATE_INIDATE_F = $FILTERS["DATE_INIDATE_F"];
			$DATE_ENDATE_F = $FILTERS["DATE_ENDATE_F"];
			
			if($EXPORT != "dates"){$where .= "AND DATE_STATE = '0'";}
			
			if($DATE_INIDATE_F != ""){$where .= "AND DATE_DATE >= '$DATE_INIDATE_F'";}
			if($DATE_ENDATE_F != ""){$where .= "AND DATE_DATE <= '$DATE_ENDATE_F'";}
			
		}
		
		if($EXPORT != "0"){$LIMIT = 1000000;}
		
		
		// GET LIST
		$str = "SELECT $FIELDS FROM $TABLE $where ORDER BY $ORDER LIMIT $LIMIT";
		$query = $this->db->query($str);
		
		
		if($TABLE == "wp_events")
		{
		
			// $resp["message"] = $str;
			// $resp["status"] = true;
			// return $resp;
		}

		
		
		// GET FRIEDNLY NAMES LOG
		if($TABLE == "wp_log")
		{
			for($i=0; $i<count($query); $i++)
			{
				$item = $query[$i];
				
				$data = array();
				$data["table"] = "wp_trusers";
				$data["fields"] = " USER_NAME, USER_LASTNAME ";
				$data["keyField"] = " USER_CODE ";
				$data["code"] = $item["UCODE"];
				
				$friendlyData = $this->getFriendlyData($data)["message"];
				
				if($friendlyData != "none")
				{
					$USER_NAME = $friendlyData["USER_NAME"];
					$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
					
					$user = $USER_NAME." ".$USER_LASTNAME;

					$query[$i]["USER_NAME"] = $user;
				}
				else
				{
					$query[$i]["USER_NAME"] = "-";
				}
				
				
				
				

			}
		}
		
		// GET FRIEDNLY NAMES CONTRACTS
		if($TABLE == "wp_contracts")
		{
			
			$passed = array();
			
			for($i=0; $i<count($query); $i++)
			{
				$item = $query[$i];
				
				$now = new DateTime();
				$now = $now->format('Y-m-d');
				
				$CONTRACT_ENDATE = $item["CONTRACT_ENDATE"];
				$CONTRACT_OWNER = $item["CONTRACT_OWNER"];
				
				if($CONTRACT_ENDATE >= $now)
				{$CONTRACT_STATE = "Asignado";}
				else
				{$CONTRACT_STATE = "Vencido";}
			
				if($CONTRACT_OWNER == "" or  $CONTRACT_OWNER == null)
				{$CONTRACT_STATE = "Solicitud";}
				
				$CONTRACT_ACTIVE_F = $FILTERS["CONTRACT_ACTIVE_F"];
					
				if($CONTRACT_ACTIVE_F != "")
				{
					if($CONTRACT_ACTIVE_F == "Solicitud" and $CONTRACT_STATE != "Solicitud"){continue;}
					if($CONTRACT_ACTIVE_F == "Asignado" and $CONTRACT_STATE != "Asignado")
					{continue;}
					if($CONTRACT_ACTIVE_F == "Vencido" and $CONTRACT_STATE != "Vencido"){continue;}
				}
				
				// GET REQUESTER NAME
				
				$data = array();
				$data["table"] = "wp_trusers";
				$data["fields"] = " USER_NAME, USER_LASTNAME, USER_IDTYPE, USER_IDNUM, USER_PHONE, USER_EMAIL ";
				$data["keyField"] = " USER_CODE ";
				$data["code"] = $item["CONTRACT_REQUESTER"];
				
				$friendlyData = $this->getFriendlyData($data)["message"];
				
				$USER_NAME = $friendlyData["USER_NAME"];
				$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
				$USER_IDTYPE = $friendlyData["USER_IDTYPE"];
				$USER_IDNUM = $friendlyData["USER_IDNUM"];
				$USER_PHONE = $friendlyData["USER_PHONE"];
				$USER_EMAIL = $friendlyData["USER_EMAIL"];
				
				$user = $USER_NAME." ".$USER_LASTNAME;
				$userId = $USER_IDTYPE." ".$USER_IDNUM;
				$phone = $USER_PHONE;
				$email = $USER_EMAIL;

				$query[$i]["CONTRACT_REQUESTER_NAME"] = $user;
				$query[$i]["CONTRACT_REQUESTER_ID"] = $userId;
				$query[$i]["CONTRACT_REQUESTER_PHONE"] = $phone;
				$query[$i]["CONTRACT_REQUESTER_EMAIL"] = $email;
				
				// GET OWNER NAME IF ASIGNED
				$query[$i]["CONTRACT_OWNER_NAME"] = "-";
				
				if($item["CONTRACT_OWNER"] != "" and $item["CONTRACT_OWNER"] != null)
				{
					$data = array();
					$data["table"] = "wp_trusers";
					$data["fields"] = " USER_NAME, USER_LASTNAME ";
					$data["keyField"] = " USER_CODE ";
					$data["code"] = $item["CONTRACT_OWNER"];
					
					$friendlyData = $this->getFriendlyData($data)["message"];
					if($friendlyData != "none")
					{
						$USER_NAME = $friendlyData["USER_NAME"];
						$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
						$user = $USER_NAME." ".$USER_LASTNAME;
						$query[$i]["CONTRACT_OWNER_NAME"] = $user;
					}
					else
					{
						$query[$i]["CONTRACT_OWNER_NAME"] = "Sin asignar";
					}
				}
				else
				{
					$query[$i]["CONTRACT_OWNER_NAME"] = "Sin asignar";
				}
				
				// GET APROVER NAME IF ASIGNED
				
				if($item["CONTRACT_APROVED_BY"] != "")
				{
					$data = array();
					$data["table"] = "wp_trusers";
					$data["fields"] = " USER_NAME, USER_LASTNAME ";
					$data["keyField"] = " USER_CODE ";
					$data["code"] = $item["CONTRACT_APROVED_BY"];
					
					$friendlyData = $this->getFriendlyData($data)["message"];
					
					if($friendlyData != "none")
					{
						$USER_NAME = $friendlyData["USER_NAME"];
						$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
						$user = $USER_NAME." ".$USER_LASTNAME;
					}
					else
					{
						$user = $item["CONTRACT_APROVED_BY"];
					}

					$query[$i]["CONTRACT_APROVED_BY"] = $user;
				}
				else
				{
					$query[$i]["CONTRACT_APROVED_BY"] = "Sin aprobar";
				}
				
				array_push($passed, $query[$i]);
				

			}
			
			$query = $passed;
			
			
			
			
			
			// if($CONTRACT_OWNER_F != "")
			// {
				// $filtered = array();
				// for($f=0; $f<count($query); $f++)
				// {
					// $itemField = strtolower($query[$f]["CONTRACT_OWNER_NAME"]);
					// if(strpos($itemField, strtolower($CONTRACT_OWNER_F)) !== false)
					// {array_push($filtered, $query[$f]);}
				// }
				// $query = $filtered;
			// }
			
		}
		
		// GET USER CONTRACT FOR TRUSERS
		if($TABLE == "wp_trusers")
		{
			
		}
		
		// GET FRIEDNLY NAMES LOG
		if($TABLE == "wp_classes")
		{
			
			// $resp["message"] = "lol";
			// $resp["status"] = true;
			// return $resp;
			
			
			for($i=0; $i<count($query); $i++)
			{
				$item = $query[$i];
				
				$CLASS_CODE = $item["CLASS_CODE"];
				
				// GET TUTOR NAMES
				$data = array();
				$data["table"] = "wp_trusers";
				$data["fields"] = " USER_NAME, USER_LASTNAME ";
				$data["keyField"] = " USER_CODE ";
				$data["code"] = $item["CLASS_TUTOR"];
				
				$friendlyData = $this->getFriendlyData($data)["message"];
				
				$USER_NAME = $friendlyData["USER_NAME"];
				$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
				$user = $USER_NAME." ".$USER_LASTNAME;
				$query[$i]["CLASS_TUTOR_NAME"] = $user;
				
				// GET GROUP DATA
				$data = array();
				$data["table"] = "wp_groups";
				$data["fields"] = " GROUP_NAME, GROUP_PREVIR, GROUP_HOOD, GROUP_CONTRACT, GROUP_INSTYPE ";
				$data["keyField"] = " GROUP_CODE ";
				$data["code"] = $item["CLASS_GROUP"];
				
				$friendlyData = $this->getFriendlyData($data)["message"];
				
				if($friendlyData != "none")
				{
					$GROUP_CONTRACT = $friendlyData["GROUP_CONTRACT"];
					$GROUP_NAME = $friendlyData["GROUP_NAME"];
					$GROUP_PREVIR = $friendlyData["GROUP_PREVIR"];
					$GROUP_HOOD = $friendlyData["GROUP_HOOD"];
					$GROUP_INSTYPE= $friendlyData["GROUP_INSTYPE"];
					$query[$i]["CLASS_GROUP_NAME"] = $GROUP_NAME;
					$query[$i]["CLASS_GROUP_PREVIR"] = $GROUP_PREVIR;
					$query[$i]["CLASS_GROUP_HOOD"] = $GROUP_HOOD;
					$query[$i]["CLASS_GROUP_INSTYPE"] = $GROUP_INSTYPE;
				}
				else
				{
					$GROUP_CONTRACT = "-";
					$GROUP_NAME = "-";
					$GROUP_PREVIR = "-";
					$GROUP_HOOD = "-";
					$GROUP_INSTYPE= "-";
					$query[$i]["CLASS_GROUP_NAME"] = $GROUP_NAME;
					$query[$i]["CLASS_GROUP_PREVIR"] = $GROUP_PREVIR;
					$query[$i]["CLASS_GROUP_HOOD"] = $GROUP_HOOD;
					$query[$i]["CLASS_GROUP_INSTYPE"] = $GROUP_INSTYPE;
				}
				
				
				
				// GET GROUP PROJECT
				$data = array();
				$data["table"] = "wp_activities";
				$data["fields"] = " ACTIVITY_PROJECT ";
				$data["keyField"] = " ACTIVITY_CODE ";
				$data["code"] = $item["CLASS_ACTIVITY"];

				$friendlyData = $this->getFriendlyData($data)["message"];
				
				if($friendlyData != "none")
				{
					$GROUP_PROJECT = $friendlyData["ACTIVITY_PROJECT"];
				}
				else
				{
					$GROUP_PROJECT = "-*-";
				}
				
				
				
				$query[$i]["CLASS_PROJECT"] = $GROUP_PROJECT;
				
				if($query[$i]["CLASS_EXCUSE"] != null and $query[$i]["CLASS_EXCUSE"] != "" and $query[$i]["CLASS_EXCUSE"] != "null")
				{
					if($query[$i]["CLASS_EXCUSE"] != "" and $query[$i]["CLASS_EXCUSE"] != null and $query[$i]["CLASS_EXCUSE"] != "null")
					{
						$query[$i]["CLASS_EXCUSE"] = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($query[$i]["CLASS_EXCUSE"]));
						$EXCUSE_DATA = json_decode($query[$i]["CLASS_EXCUSE"], true);
						if(isset($CLASS_EXCUSE["EXCUSE_FILE"]) and $EXCUSE_DATA["EXCUSE_FILE"] != "" and $EXCUSE_DATA["EXCUSE_FILE"] != "null" and $EXCUSE_DATA["EXCUSE_FILE"] != null)
						{$query[$i]["CLASS_EXCUSE_FILE"] = "1";}
					}
					else{$query[$i]["CLASS_EXCUSE_FILE"] = "0";}
					
					// KILL EXCUSE IF NOT FOR REPORT
					if($EXPORT == "0"){$query[$i]["CLASS_EXCUSE"] = "1";}
					
				}
				else
				{
					$query[$i]["CLASS_EXCUSE"] = "";
					$query[$i]["CLASS_EXCUSE_FILE"] = "";
				}
				
				// UPDATE MISSING CCODES
				if($query[$i]["CLASS_CONTRACT_CODE"] == null or $query[$i]["CLASS_CONTRACT_CODE"] == "null" or $query[$i]["CLASS_CONTRACT_CODE"] == "")
				{
					$str = "UPDATE wp_classes SET CLASS_CONTRACT_CODE = '".$GROUP_CONTRACT."' WHERE CLASS_CODE ='".$CLASS_CODE."'";
					$updater = $this->db->query($str);
				}
				
				
			}
			
			// USER FILTERS
			
			$CLASS_GNAME_F = $FILTERS["CLASS_GNAME_F"];
			
			if($CLASS_GNAME_F != "")
			{
				$filtered = array();
				for($i=0; $i<count($query); $i++)
				{
					$itemField = strtolower($query[$i]["CLASS_GROUP_NAME"]);
					if(strpos($itemField, strtolower($CLASS_GNAME_F)) !== false)
					{array_push($filtered, $query[$i]);}
				}
				$query = $filtered;
			}
			
			$CLASS_CONTRATIST_F = $FILTERS["CLASS_CONTRATIST_F"];
			
			if($CLASS_CONTRATIST_F != "")
			{
				$filtered = array();
				for($i=0; $i<count($query); $i++)
				{
					$itemField = strtolower($query[$i]["CLASS_TUTOR_NAME"]);
					if(strpos($itemField, strtolower($CLASS_CONTRATIST_F)) !== false)
					{array_push($filtered, $query[$i]);}
				}
				$query = $filtered;
			}
			
			$CLASS_ACTIVITY_F = $FILTERS["CLASS_ACTIVITY_F"];
			
			if($CLASS_ACTIVITY_F != "")
			{
				// GET COINCIDENT CODES
				$str = "SELECT ACTIVITY_CODE FROM wp_activities WHERE ACTIVITY_NAME LIKE '%".$CLASS_ACTIVITY_F."%'";
				$matchCodes = $this->db->query($str);

				// EXTRACT ONLY CODES
				$codes = array();
				for($i=0; $i<count($matchCodes); $i++)
				{array_push($codes, $matchCodes[$i]["ACTIVITY_CODE"]);}
				
				// PICK IN ARRAY CODES REGISTERS
				$filtered = array();
				for($i=0; $i<count($query); $i++)
				{
					$itemCode = $query[$i]["CLASS_ACTIVITY"];
					if(in_array($itemCode, $codes)){array_push($filtered, $query[$i]);}
				}
				
				$query = $filtered;
			}
			
			$CLASS_PROJECT_F = $FILTERS["CLASS_PROJECT_F"];
			
			if($CLASS_PROJECT_F != "")
			{
				// GET COINCIDENT CODES
				$str = "SELECT PROJECT_CODE FROM wp_projects WHERE PROJECT_NAME LIKE '%".$CLASS_PROJECT_F."%'";
				$matchCodes = $this->db->query($str);

				// EXTRACT ONLY CODES
				$codes = array();
				for($i=0; $i<count($matchCodes); $i++)
				{array_push($codes, $matchCodes[$i]["PROJECT_CODE"]);}
				
				// PICK IN ARRAY CODES REGISTERS
				$filtered = array();
				for($i=0; $i<count($query); $i++)
				{
					$itemCode = $query[$i]["CLASS_PROJECT"];
					if(in_array($itemCode, $codes)){array_push($filtered, $query[$i]);}
				}
				
				$query = $filtered;
			}
			
		}
		
		// GET FRIEDNLY NAMES LOG
		if($TABLE == "wp_remitions")
		{
			
			$REM_ACTIVITY_F = $FILTERS["REM_ACTIVITY_F"];
			
			if($REM_ACTIVITY_F != "")
			{

				$str = "SELECT ACTIVITY_CODE FROM wp_activities WHERE ACTIVITY_NAME LIKE '%".$REM_ACTIVITY_F."%'";
				$matchCodes = $this->db->query($str);

				$codes = array();
				for($i=0; $i<count($matchCodes); $i++)
				{array_push($codes, $matchCodes[$i]["ACTIVITY_CODE"]);}
				
				// PICK IN ARRAY CODES REGISTERS
				$filtered = array();
				for($i=0; $i<count($query); $i++)
				{
					$itemCode = $query[$i]["REM_ACTIVITY"];
					if(in_array($itemCode, $codes)){array_push($filtered, $query[$i]);}
				}
				
				$query = $filtered;
			}
			
			for($i=0; $i<count($query); $i++)
			{
				$itemCode = $query[$i]["REM_CODE"];
				$data = array();
				$data["REM_CODE"] = $itemCode;
				$orphan = $this->checkOrphan($data)["message"];
				$query[$i]["REM_ORPHAN"] = $orphan;
			}
			
			
		}
		
		// GET VISIT EXTRA DATA
		if($TABLE == "wp_visits" and count($query) > 0)
		{
			for($i=0; $i<count($query); $i++)
			{
				$item = $query[$i];
				
				$VISIT_GROUP = $item["VISIT_GROUP"];
				$VISIT_HOOD = $item["VISIT_HOOD"];
				$VISIT_ZONE  = $item["VISIT_ZONE"];
				$VISIT_ACTIVITY  = $item["VISIT_ACTIVITY"];
				
				// GET GROUP DATA
				$data = array();
				$data["table"] = "wp_groups";
				$data["fields"] = " GROUP_NAME, GROUP_CITIZENS ";
				$data["keyField"] = " GROUP_CODE ";
				$data["code"] = $VISIT_GROUP;
				$friendlyData = $this->getFriendlyData($data)["message"];
				
				if($friendlyData == "none"){continue;}
				
				$GROUP_NAME = $friendlyData["GROUP_NAME"];
				$GROUP_CITIZENS = $friendlyData["GROUP_CITIZENS"];
				$query[$i]["VISIT_GROUP_NAME"] = $GROUP_NAME;
				
				if($GROUP_CITIZENS != "" and $GROUP_CITIZENS != null and $GROUP_CITIZENS != "null")
				{
					$GROUP_CITIZENS = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($GROUP_CITIZENS));
					$GROUP_CITIZENS = json_decode($GROUP_CITIZENS, true);
					$query[$i]["VISIT_TOTAL_PEOPLE"] = count($GROUP_CITIZENS);
				}
				else
				{
					$query[$i]["VISIT_TOTAL_PEOPLE"] = 0;
				}
			
				
				// GET ZONE DATA
				$data = array();
				$data["table"] = "wp_zones";
				$data["fields"] = " ZONE_NAME ";
				$data["keyField"] = " ZONE_CODE ";
				$data["code"] = $VISIT_ZONE;
				$friendlyData = $this->getFriendlyData($data)["message"];
				
				if($friendlyData != "none")
				{
					$ZONE_NAME = $friendlyData["ZONE_NAME"];
					$query[$i]["VISIT_ZONE_NAME"] = $ZONE_NAME;
				}
				else
				{
					$query[$i]["VISIT_ZONE_NAME"] = $query[$i]["VISIT_ZONE"];
				}
				
				
				// GET HOOD DATA
				$data = array();
				$data["table"] = "wp_hoods";
				$data["fields"] = " HOOD_NAME ";
				$data["keyField"] = " HOOD_CODE ";
				$data["code"] = $VISIT_HOOD;
				$friendlyData = $this->getFriendlyData($data)["message"];
				if($friendlyData != "none")
				{
					$HOOD_NAME = $friendlyData["HOOD_NAME"];
					$query[$i]["VISIT_HOOD_NAME"] = $HOOD_NAME;
					
				}
				else
				{
					$query[$i]["VISIT_HOOD_NAME"] = $query[$i]["VISIT_HOOD"];
				}
				
				
				
				// GET ACTIVITY DATA
				$data = array();
				$data["table"] = "wp_activities";
				$data["fields"] = " ACTIVITY_NAME ";
				$data["keyField"] = " ACTIVITY_CODE ";
				$data["code"] = $VISIT_ACTIVITY;
				$friendlyData = $this->getFriendlyData($data)["message"];
				$ACTIVITY_NAME = $friendlyData["ACTIVITY_NAME"];
				$query[$i]["VISIT_ACTIVITY_NAME"] = $ACTIVITY_NAME;

			}
			
			
			
			
			// USER FILTERS
			
			$VISIT_GNAME_F = $FILTERS["VISIT_GNAME_F"];
			
			if($VISIT_GNAME_F != "")
			{
				$filtered = array();
				for($i=0; $i<count($query); $i++)
				{
					$itemField = strtolower($query[$i]["VISIT_GROUP_NAME"]);
					if(strpos($itemField, strtolower($VISIT_GNAME_F)) !== false)
					{array_push($filtered, $query[$i]);}
				}
				$query = $filtered;
			}
			
			$VISIT_HOOD_F = $FILTERS["VISIT_HOOD_F"];
			
			if($VISIT_HOOD_F != "")
			{
				$filtered = array();
				for($i=0; $i<count($query); $i++)
				{
					
					if(isset($query[$i]["VISIT_HOOD_NAME"]))
					{
						$itemField = strtolower($query[$i]["VISIT_HOOD_NAME"]);
						if(strpos($itemField, strtolower($VISIT_HOOD_F)) !== false)
						{array_push($filtered, $query[$i]);}
					}
					
					
				}
				$query = $filtered;
			}
			
			
			$VISIT_ZONE_F = $FILTERS["VISIT_ZONE_F"];
			
			if($VISIT_ZONE_F != "")
			{
				$filtered = array();
				for($i=0; $i<count($query); $i++)
				{
					
					if(isset($query[$i]["VISIT_ZONE_NAME"]))
					{
						$itemField = strtolower($query[$i]["VISIT_ZONE_NAME"]);
						if(strpos($itemField, strtolower($VISIT_ZONE_F)) !== false)
						{array_push($filtered, $query[$i]);}
					}
					
				}
				$query = $filtered;
			}
			
			$VISIT_ACTIVITY_F = $FILTERS["VISIT_ACTIVITY_F"];
			
			if($VISIT_ACTIVITY_F != "")
			{
				$filtered = array();
				for($i=0; $i<count($query); $i++)
				{
					
					if(isset($query[$i]["VISIT_ACTIVITY_NAME"]))
					{
						$itemField = strtolower($query[$i]["VISIT_ACTIVITY_NAME"]);
						if(strpos($itemField, strtolower($VISIT_ACTIVITY_F)) !== false)
						{array_push($filtered, $query[$i]);}
					}
					
					
				}
				$query = $filtered;
			}

		}
		
		// GET FRIEDNLY NAMES REQ EVENT
		if($TABLE == "wp_events")
		{
			for($i=0; $i<count($query); $i++)
			{
				$item = $query[$i];
				
				// GET AUTHOR DATA
				if($item["EVENT_AUTHOR"] != "" and $item["EVENT_AUTHOR"] != null and $item["EVENT_AUTHOR"] != "null")
				{
					// GET REQUESTER DATA
					$data = array();
					$data["table"] = "wp_trusers";
					$data["fields"] = " USER_NAME, USER_LASTNAME ";
					$data["keyField"] = " USER_CODE ";
					$USER_IDNUM = $item["EVENT_AUTHOR"]; 
					$data["code"] = $USER_IDNUM;
					$friendlyData = $this->getFriendlyData($data)["message"];
					if($friendlyData != "none")
					{
						$AUTHOR_NAME = $friendlyData["USER_NAME"];
						$AUTHOR_LASTNAME = $friendlyData["USER_LASTNAME"];
						$user = $AUTHOR_NAME." ".$AUTHOR_LASTNAME;
						
						$query[$i]["EVENT_AUTHOR_NAME"] = $user;
					}
					else
					{
						$query[$i]["EVENT_AUTHOR_NAME"] = "";
					}
					
					
				}
				else
				{
					$query[$i]["EVENT_REQUESTER_FULL"] = "";
				}
				
				// GET REQUESTER DATA
				if($item["EVENT_REQUESTER"] != "" and count(explode("-",$item["EVENT_REQUESTER"])) > 0)
				{
					// GET REQUESTER DATA
					$data = array();
					$data["table"] = "wp_citizens";
					$data["fields"] = " CITIZEN_NAME, CITIZEN_LASTNAME,  CITIZEN_PHONE, CITIZEN_EMAIL ";
					$data["keyField"] = " CITIZEN_IDNUM ";
					$CITIZEN_IDNUM = explode("-",$item["EVENT_REQUESTER"])[0]; 
					$data["code"] = $CITIZEN_IDNUM;
					$friendlyData = $this->getFriendlyData($data)["message"];
					if($friendlyData != "none")
					{
						$CITIZEN_NAME = $friendlyData["CITIZEN_NAME"];
						$CITIZEN_LASTNAME = $friendlyData["CITIZEN_LASTNAME"];
						$CITIZEN_PHONE = $friendlyData["CITIZEN_PHONE"];
						$CITIZEN_EMAIL = $friendlyData["CITIZEN_EMAIL"];
						// $user = "Id: ".$CITIZEN_IDNUM."<br>Nombre: ".$CITIZEN_NAME." ".$CITIZEN_LASTNAME."<br> Teléfono: ".$CITIZEN_PHONE."<br>Email: ".$CITIZEN_EMAIL;
						$user = $CITIZEN_NAME." ".$CITIZEN_LASTNAME;
					}
					else
					{
						$user = "-";
					}

					$query[$i]["EVENT_REQUESTER_FULL"] = $user;
				}
				else
				{
					$query[$i]["EVENT_REQUESTER_FULL"] = "";
				}
				
				// GET COOPERATOR DATA
				if($item["EVENT_COOPERATOR"] != "" and $item["EVENT_COOPERATOR"] != "null" and count(explode("-",$item["EVENT_COOPERATOR"])) > 0)
				{
					
					// GET REQUESTER DATA
					$data = array();
					$data["table"] = "wp_citizens";
					$data["fields"] = " CITIZEN_NAME, CITIZEN_LASTNAME,  CITIZEN_PHONE, CITIZEN_EMAIL ";
					$data["keyField"] = " CITIZEN_IDNUM ";
					$CITIZEN_IDNUM = explode("-",$item["EVENT_COOPERATOR"])[0]; 
					$data["code"] = $CITIZEN_IDNUM;
					$friendlyData = $this->getFriendlyData($data)["message"];
					if($friendlyData != "none")
					{
						$CITIZEN_NAME = $friendlyData["CITIZEN_NAME"];
						$CITIZEN_LASTNAME = $friendlyData["CITIZEN_LASTNAME"];
						$CITIZEN_PHONE = $friendlyData["CITIZEN_PHONE"];
						$CITIZEN_EMAIL = $friendlyData["CITIZEN_EMAIL"];
						$user = "Id: ".$CITIZEN_IDNUM."<br>Nombre: ".$CITIZEN_NAME." ".$CITIZEN_LASTNAME."<br> Teléfono: ".$CITIZEN_PHONE."<br>Email: ".$CITIZEN_EMAIL;
					}
					else
					{
						$user = "-";
					}
					$query[$i]["EVENT_COOPERATOR_FULL"] = $user;

				}
				else
				{
					$query[$i]["EVENT_COOPERATOR_FULL"] = "";
				}
				
				
				if($info["TABLE"] != "wp_events")
				{
					// GET CONTRACT DATA
					if($item["EVENT_OWNER"] != "")
					{
						// GET CONTRACT DATA
						$data = array();
						$data["table"] = "wp_contracts";
						$data["fields"] = " CONTRACT_OWNER, CONTRACT_NUMBER, CONTRACT_USERTYPE ";
						$data["keyField"] = " CONTRACT_CODE ";
						$data["code"] = $item["EVENT_OWNER"];
						$friendlyData = $this->getFriendlyData($data)["message"];
						if($friendlyData != "none")
						{
							$CONTRACT_OWNER = $friendlyData["CONTRACT_OWNER"];
							$CONTRACT_NUMBER = $friendlyData["CONTRACT_NUMBER"];
							$CONTRACT_USERTYPE = $friendlyData["CONTRACT_USERTYPE"];
							
							// GET CONTRACT NAME
							$data = array();
							$data["table"] = "wp_trusers";
							$data["fields"] = " USER_NAME, USER_LASTNAME ";
							$data["keyField"] = " USER_CODE ";
							$data["code"] = $CONTRACT_OWNER;
							$friendlyData = $this->getFriendlyData($data)["message"];
							
							$USER_NAME = $friendlyData["USER_NAME"];
							$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
							
							$user = $USER_NAME." ".$USER_LASTNAME;
							
							$cData = "Nombre: ".$user."<br> Contrato: ".$CONTRACT_NUMBER."<br> Tipo: ".$CONTRACT_USERTYPE;
							
							$query[$i]["EVENT_OWNER_FULL"] = $user;
							
						}
						else
						{
							$query[$i]["EVENT_OWNER_FULL"] = "-";
						}

						
					}
					
					else{$query[$i]["EVENT_OWNER_FULL"] = "--";}
					
					
					// CHECK IF THIS EVENT HAS EVENT PIC != NULL
					$str = "SELECT EVENT_CODE FROM wp_events WHERE EVENT_CODE = '".$query[$i]["EVENT_CODE"]."' AND EVENT_PIC != 'null' AND EVENT_PIC != ''";
					$checkPic = $this->db->query($str);
					
					if(count($checkPic) > 0){$query[$i]["EVENT_PIC"] = "1";}
					else{$query[$i]["EVENT_PIC"] = "";}
					
					
					// CHECK IF THIS EVENT_SHEET HAS EVENT_SHEET != NULL
					$str = "SELECT EVENT_CODE FROM wp_events WHERE EVENT_CODE = '".$query[$i]["EVENT_CODE"]."' AND EVENT_SHEET != 'null' AND EVENT_SHEET != ''";
					$checkSheet = $this->db->query($str);
					
					if(count($checkSheet) > 0){$query[$i]["EVENT_SHEET"] = "1";}
					else{$query[$i]["EVENT_SHEET"] = "";}
					

				}
				else
				{
					
					if($item["EVENT_OWNER"] != "")
					{
						
						// GET OWNER NAME
						$data = array();
						$data["table"] = "wp_trusers";
						$data["fields"] = " USER_IDNUM, USER_NAME, USER_LASTNAME ";
						$data["keyField"] = " USER_CODE ";
						$data["code"] = $item["EVENT_OWNER"];
						$friendlyData = $this->getFriendlyData($data)["message"];
						if($friendlyData != "none")
						{
							$USER_IDNUM = $friendlyData["USER_IDNUM"];
							$USER_NAME = $friendlyData["USER_NAME"];
							$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
						}	
						else
						{
							$USER_IDNUM = "";
							$USER_NAME = "";
							$USER_LASTNAME = "";
						}
						
						$user = $USER_NAME." ".$USER_LASTNAME;
						$query[$i]["EVENT_OWNER_FULL"] = $user;
						

						// CHECK IF THIS EVENT HAS EVENT PIC != NULL
						$str = "SELECT EVENT_CODE FROM wp_events WHERE EVENT_CODE = '".$query[$i]["EVENT_CODE"]."' AND EVENT_PIC != 'null' AND EVENT_PIC != ''";
						$checkPic = $this->db->query($str);
						
						if(count($checkPic) > 0){$query[$i]["EVENT_PIC"] = "1";}
						else{$query[$i]["EVENT_PIC"] = "";}
						
						
						// CHECK IF THIS EVENT_SHEET HAS EVENT_SHEET != NULL
						$str = "SELECT EVENT_CODE FROM wp_events WHERE EVENT_CODE = '".$query[$i]["EVENT_CODE"]."' AND EVENT_SHEET != 'null' AND EVENT_SHEET != ''";
						$checkSheet = $this->db->query($str);
						
						if(count($checkSheet) > 0){$query[$i]["EVENT_SHEET"] = "1";}
						else{$query[$i]["EVENT_SHEET"] = "";}
						
						
					}
					else
					{
						$query[$i]["EVENT_OWNER_FULL"] = "other";
					}
				}

				$EVENT_NAME_F = $FILTERS["EVENT_NAME_F"];
			
				if($EVENT_NAME_F != "")
				{
					$filtered = array();
					for($e=0; $e<count($query); $e++)
					{
						$itemField = strtolower($query[$e]["EVENT_NAME"]);
						if(strpos($itemField, strtolower($EVENT_NAME_F)) !== false)
						{array_push($filtered, $query[$e]);}
					}
					$query = $filtered;
				}
				
				$EVENT_DATE_INI_F = $FILTERS["EVENT_DATE_INI_F"];
				if($EVENT_DATE_INI_F != "")
				{
					$filtered = array();
					for($f=0; $f<count($query); $f++)
					{
						$iniDate = $query[$f]["EVENT_DATE_INI"];
						if($iniDate >= $EVENT_DATE_INI_F)
						{
							array_push($filtered, $query[$f]);
						}
					}
					$query = $filtered;
					
				}
				
				$EVENT_DATE_END_F = $FILTERS["EVENT_DATE_END_F"];
				if($EVENT_DATE_END_F != "")
				{
					$filtered = array();
					for($g=0; $g<count($query); $g++)
					{
						$iniDate = $query[$g]["EVENT_DATE_INI"];
						if($iniDate <= $EVENT_DATE_END_F)
						{
							array_push($filtered, $query[$g]);
						}
					}
					$query = $filtered;
					
				}
				
			}
			
			
			
			
			// EVENTS REGULAR-----
			
			if($info["TABLE"] == "wp_events")
			{
				
				$EVENT_OWNER_F = $FILTERS["EVENT_OWNER_F"];
					
				if($EVENT_OWNER_F != "")
				{
					$filtered = array();
					for($i=0; $i<count($query); $i++)
					{
						$itemField = strtolower($query[$i]["EVENT_OWNER_FULL"]);
						if(strpos($itemField, strtolower($EVENT_OWNER_F)) !== false)
						{array_push($filtered, $query[$i]);}
					}
					$query = $filtered;
				}

				$EVENT_SUPPORT_F = $FILTERS["EVENT_SUPPORT_F"];
				
				if($EVENT_SUPPORT_F != "")
				{
					$filtered = array();
					for($i=0; $i<count($query); $i++)
					{
						$itemField = strtolower($query[$i]["EVENT_SUPPORT_TEAM"]);
						if(strpos($itemField, strtolower($EVENT_SUPPORT_F)) !== false)
						{array_push($filtered, $query[$i]);}
					}
					$query = $filtered;
				}
			}
			else
			{
				$EVENT_RADICATE_F = $FILTERS["EVENT_RADICATE_F"];
				
				if($EVENT_RADICATE_F != "")
				{
					$filtered = array();
					for($i=0; $i<count($query); $i++)
					{
						$itemField = strtolower($query[$i]["EVENT_RADICATE"]);
						if(strpos($itemField, strtolower($EVENT_RADICATE_F)) !== false)
						{array_push($filtered, $query[$i]);}
					}
					$query = $filtered;
				}
				
				$EVENT_NAME_F = $FILTERS["EVENT_NAME_F"];
				
				if($EVENT_NAME_F != "")
				{
					$filtered = array();
					for($i=0; $i<count($query); $i++)
					{
						$itemField = strtolower($query[$i]["EVENT_NAME"]);
						if(strpos($itemField, strtolower($EVENT_NAME_F)) !== false)
						{array_push($filtered, $query[$i]);}
					}
					$query = $filtered;
				}
				
				$EVENT_OWNER_F = $FILTERS["EVENT_OWNER_F"];
					
				if($EVENT_OWNER_F != "")
				{
					$filtered = array();
					for($i=0; $i<count($query); $i++)
					{
						$itemField = strtolower($query[$i]["EVENT_OWNER_FULL"]);
						if(strpos($itemField, strtolower($EVENT_OWNER_F)) !== false)
						{array_push($filtered, $query[$i]);}
					}
					$query = $filtered;
				}
				
				$EVENT_ACTIVITY_F = $FILTERS["EVENT_ACTIVITY_F"];
				
				if($EVENT_ACTIVITY_F != "")
				{
					$str = "SELECT ACTIVITY_CODE FROM wp_activities WHERE ACTIVITY_NAME LIKE '%".$EVENT_ACTIVITY_F."%'";
					$matchCodes = $this->db->query($str);
					
					// EXTRACT ONLY CODES
					$codes = array();
					for($i=0; $i<count($matchCodes); $i++)
					{array_push($codes, $matchCodes[$i]["ACTIVITY_CODE"]);}

					$filtered = array();
					
					if(count($codes) > 0)
					{
						for($i=0; $i<count($query); $i++)
						{
							$itemField = $query[$i]["EVENT_ACTIVITIES"];
							for($c=0; $c<count($codes); $c++)
							{
								$code = $codes[$c];
								if(strpos($itemField, $code) !== false)
								{
									array_push($filtered, $query[$i]);
									break;
								}
							}
						}
					}
					$query = $filtered;
					
				} 
				
				$EVENT_SUPPORT_F = $FILTERS["EVENT_SUPPORT_F"];
				
				if($EVENT_SUPPORT_F != "")
				{
					$filtered = array();
					for($i=0; $i<count($query); $i++)
					{
						$itemField = strtolower($query[$i]["EVENT_SUPPORT_TEAM"]);
						if(strpos($itemField, strtolower($EVENT_SUPPORT_F)) !== false)
						{array_push($filtered, $query[$i]);}
					}
					$query = $filtered;
				}
				
				$EVENT_HOOD_F = $FILTERS["EVENT_HOOD_F"];
			
				if($EVENT_HOOD_F != "")
				{
					// GET COINCIDENT CODES
					$str = "SELECT HOOD_CODE FROM wp_hoods WHERE HOOD_NAME LIKE '%".$EVENT_HOOD_F."%'";
					$matchCodes = $this->db->query($str);

					// EXTRACT ONLY CODES
					$codes = array();
					for($i=0; $i<count($matchCodes); $i++)
					{array_push($codes, $matchCodes[$i]["HOOD_CODE"]);}
					
					// PICK IN ARRAY CODES REGISTERS
					$filtered = array();
					for($i=0; $i<count($query); $i++)
					{
						$itemCode = $query[$i]["EVENT_HOOD"];
						if(in_array($itemCode, $codes)){array_push($filtered, $query[$i]);}
					}
					
					$query = $filtered;
				}
			
			}
			
		}

		// GET PROGRAM AND FILTER FOR ACTIVITIES
		if($TABLE == "wp_activities")
		{
			for($i=0; $i<count($query); $i++)
			{
				$item = $query[$i];
				
				$data = array();
				$data["table"] = "wp_projects";
				$data["fields"] = " PROJECT_PROGRAM ";
				$data["keyField"] = " PROJECT_CODE ";
				$data["code"] = $item["ACTIVITY_PROJECT"];
				
				$friendlyData = $this->getFriendlyData($data)["message"];
				
				$PROGRAM_CODE = $friendlyData["PROJECT_PROGRAM"];

				$query[$i]["ACTIVITY_PROGRAM"] = $PROGRAM_CODE;
			}
			
			
			$ACTIVITY_PROGRAM_F = $FILTERS["ACTIVITY_PROGRAM_F"];
				
			if($ACTIVITY_PROGRAM_F != "")
			{
				// GET COINCIDENT CODES
				$str = "SELECT PROGRAM_CODE FROM wp_programs WHERE PROGRAM_NAME LIKE '%".$ACTIVITY_PROGRAM_F."%'";
				$matchCodes = $this->db->query($str);
				
				// EXTRACT ONLY CODES
				$codes = array();
				for($i=0; $i<count($matchCodes); $i++)
				{array_push($codes, $matchCodes[$i]["PROGRAM_CODE"]);}
				
				// PICK IN ARRAY CODES REGISTERS
				$filtered = array();
				for($i=0; $i<count($query); $i++)
				{
					$itemCode = $query[$i]["ACTIVITY_PROGRAM"];
					if(in_array($itemCode, $codes)){array_push($filtered, $query[$i]);}
				}
				$query = $filtered;
			}
		}
		
		// GET PROGRAM AND FILTER FOR ACTIVITIES
		if($TABLE == "wp_groups")
		{
			
			// GET ADITIONAL FIELDS
			for($i=0; $i<count($query); $i++)
			{
				$item = $query[$i];
				
				// GET OWNER NAMES
				if($query[$i]["GROUP_CONTRACT"] != null and $query[$i]["GROUP_CONTRACT"] != "")
				{
					$data = array();
					$data["table"] = "wp_contracts";
					$data["fields"] = " CONTRACT_OWNER ";
					$data["keyField"] = " CONTRACT_CODE ";
					$data["code"] = $item["GROUP_CONTRACT"];
					
					$friendlyData = $this->getFriendlyData($data)["message"];
					
					if($friendlyData != "none")
					{
						$CONTRACT_OWNER = $friendlyData["CONTRACT_OWNER"];
					}
					else
					{
						$CONTRACT_OWNER = "-";
					}
					
					

					$data = array();
					$data["table"] = "wp_trusers";
					$data["fields"] = " USER_NAME, USER_LASTNAME ";
					$data["keyField"] = " USER_CODE ";
					$data["code"] = $CONTRACT_OWNER;
					$friendlyData = $this->getFriendlyData($data)["message"];
					
					if($friendlyData != "none")
					{
						$USER_NAME = $friendlyData["USER_NAME"];
						$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
					
					}
					else
					{
						$USER_NAME = "-";
						$USER_LASTNAME = "-";
					
					}
					
					
					$user = $USER_NAME." ".$USER_LASTNAME;
					$query[$i]["GROUP_CONTRATIST"] = $user;
				}
				else
				{
					$query[$i]["GROUP_CONTRATIST"] = "Sin asignar";
				}
				
				
				// GET PROJECT NAME
				$data = array();
				$data["table"] = "wp_activities";
				$data["fields"] = " ACTIVITY_PROJECT ";
				$data["keyField"] = " ACTIVITY_CODE ";
				$data["code"] = $item["GROUP_ACTIVITY"];
				$friendlyData = $this->getFriendlyData($data)["message"];
				$PROJECT_CODE = $friendlyData["ACTIVITY_PROJECT"];

				$data = array();
				$data["table"] = "wp_projects";
				$data["fields"] = " PROJECT_NAME ";
				$data["keyField"] = " PROJECT_CODE ";
				$data["code"] = $PROJECT_CODE;
				$friendlyData = $this->getFriendlyData($data)["message"];
				$PROJECT_NAME = $friendlyData["PROJECT_NAME"];
				
				$query[$i]["GROUP_PROJECT"] = $PROJECT_NAME;
				$query[$i]["GROUP_PROJECT_CODE"] = $PROJECT_CODE;
				
				// GET HOOD ZONE
				$data = array();
				$data["table"] = "wp_hoods";
				$data["fields"] = " HOOD_ZONE ";
				$data["keyField"] = " HOOD_CODE ";
				$data["code"] = $item["GROUP_HOOD"];
				$friendlyData = $this->getFriendlyData($data)["message"];
				$GROUP_ZONE = $friendlyData["HOOD_ZONE"];
				
				$query[$i]["GROUP_ZONE"] = $GROUP_ZONE;
				
			}
			
			// FILTER BY ADITIONAL FIELDS
			$GROUP_PROJECT_F = $FILTERS["GROUP_PROJECT_F"];
			if($GROUP_PROJECT_F != "")
			{
				// GET COINCIDENT CODES
				$str = "SELECT PROJECT_CODE FROM wp_projects WHERE PROJECT_NAME LIKE '%".$GROUP_PROJECT_F."%'";
				$matchCodes = $this->db->query($str);

				// EXTRACT ONLY CODES
				$codes = array();
				for($i=0; $i<count($matchCodes); $i++)
				{array_push($codes, $matchCodes[$i]["PROJECT_CODE"]);}
				
				// PICK IN ARRAY CODES REGISTERS
				$filtered = array();
				for($i=0; $i<count($query); $i++)
				{
					$itemCode = $query[$i]["GROUP_PROJECT_CODE"];
					if(in_array($itemCode, $codes)){array_push($filtered, $query[$i]);}
				}
				
				$query = $filtered;
			}
			
			$GROUP_ZONE_F = $FILTERS["GROUP_ZONE_F"];
				
			if($GROUP_ZONE_F != "")
			{
				// GET COINCIDENT CODES
				$str = "SELECT ZONE_CODE FROM wp_zones WHERE ZONE_NAME LIKE '%".$GROUP_ZONE_F."%'";
				$matchCodes = $this->db->query($str);

				// EXTRACT ONLY CODES
				$codes = array();
				for($i=0; $i<count($matchCodes); $i++)
				{array_push($codes, $matchCodes[$i]["ZONE_CODE"]);}
				
				// PICK IN ARRAY CODES REGISTERS
				$filtered = array();
				for($i=0; $i<count($query); $i++)
				{
					$itemCode = $query[$i]["GROUP_ZONE"];
					if(in_array($itemCode, $codes)){array_push($filtered, $query[$i]);}
				}
				
				$query = $filtered;
			}
			
			
			$GROUP_CONTRATIST_F = $FILTERS["GROUP_CONTRATIST_F"];
				
			if($GROUP_CONTRATIST_F != "")
			{
				$filtered = array();
				for($i=0; $i<count($query); $i++)
				{
					$itemField = strtolower($query[$i]["GROUP_CONTRATIST"]);

					if(strpos($itemField, strtolower($GROUP_CONTRATIST_F)) !== false)
					{
						array_push($filtered, $query[$i]);
					}
				}
				
				$query = $filtered;
			}
			
			$GROUP_ACTIVE_F = $FILTERS["GROUP_ACTIVE_F"];
			
			if($GROUP_ACTIVE_F != "")
			{
				if($GROUP_ACTIVE_F == "Activo")
				{$GROUP_ACTIVE_F = "1";}
				else{$GROUP_ACTIVE_F = "0";}
				
				// GET ACTIVE CONTRACT ONLY OR NOT ACTIVE
				$activeG = array();
				$inactiveG = array();

				for($i=0; $i<count($query); $i++)
				{
					$GROUP_CONTRACT = $query[$i]["GROUP_CONTRACT"];
					if($GROUP_CONTRACT != "" and $GROUP_CONTRACT != null and $GROUP_CONTRACT != "null")
					{
						// GET CONTRACT DATE RANGE
						$data = array();
						$data["CONTRACT_CODE"] = $GROUP_CONTRACT;
						if(count($this->getContractData($data)["message"]) > 0)
						{
							$CONTRACT_DATA = $this->getContractData($data)["message"][0];
							$CONTRACT_INIDATE = $CONTRACT_DATA["CONTRACT_INIDATE"];
							$CONTRACT_ENDATE = $CONTRACT_DATA["CONTRACT_ENDATE"];
						}
						else{array_push($inactiveG, $query[$i]);continue;}
						
						$now = new DateTime();
						$now = $now->format('Y-m-d');
						if($CONTRACT_ENDATE < $now || $CONTRACT_INIDATE > $now)
						{array_push($inactiveG, $query[$i]);continue;}
						array_push($activeG, $query[$i]);
					}
					else{array_push($inactiveG, $query[$i]);}

				}
				
				if($GROUP_ACTIVE_F == "1"){$query = $activeG;}
				else{$query = $inactiveG;}
			} 
			
			
		}
		
		// GET PROGRAM AND FILTER FOR ACTIVITIES
		if($TABLE == "wp_remitions")
		{
			
			$filtered = array();
			
			for($i = 0; $i<count($query);$i++)
			{

				if($UTYPE != "Principal1" and $UTYPE != "Principal2" and $UTYPE != "Principal3" and $UTYPE != "Superior")
				{
					if($query[$i]["REM_AUTOR"] != $ucode and $query[$i]["REM_CONTRATIST"] != $ucode){continue;}
				}
				
				array_push($filtered, $query[$i]);
				
			}
			
			$query = $filtered;

		}  
		
		$ans = $query;
		
		// GENERATE EXCEL IF EXPORT 1
		if($EXPORT != "0")
		{
			
			if($EXPORT == "institutes")
			{
				$instiLines = array();
				
				for($i = 0; $i<count($query);$i++)
				{
					$queryItem = $query[$i];
					
					
					$INSTITUTE_CODE = $queryItem["INSTITUTE_CODE"];
					$INSTITUTE_NAME = $queryItem["INSTITUTE_NAME"];
					$INSTITUTE_CITY = $queryItem["INSTITUTE_CITY"];
					$INSTITUTE_ZONE = $queryItem["INSTITUTE_ZONE"];
					$INSTITUTE_HOOD = $queryItem["INSTITUTE_HOOD"];
					$INSTITUTE_ADDRESS = $queryItem["INSTITUTE_ADDRESS"];
					$INSTITUTE_COORDS = $queryItem["INSTITUTE_COORDS"];
					$INSTITUTE_EDU = $queryItem["INSTITUTE_EDU"];
					
					// GET INSTITUTE_ZONE NAME
					$data = array();
					$data["table"] = "wp_zones";
					$data["fields"] = " ZONE_NAME ";
					$data["keyField"] = " ZONE_CODE ";
					$data["code"] = $INSTITUTE_ZONE;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$INSTITUTE_ZONE_DESC = $REG_DATA["ZONE_NAME"];}
					else{$INSTITUTE_ZONE_DESC = "";}
					
					
					// GET INSTITUTE_HOOD NAME
					$data = array();
					$data["table"] = "wp_hoods";
					$data["fields"] = " HOOD_NAME ";
					$data["keyField"] = " HOOD_CODE ";
					$data["code"] = $INSTITUTE_HOOD;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$INSTITUTE_HOOD_DESC = $REG_DATA["HOOD_NAME"];}
					else{$INSTITUTE_HOOD_DESC = "";}
					
					
					$instiLine = array();
					$instiLine["INSTITUTE_CODE"] = $INSTITUTE_CODE;
					$instiLine["INSTITUTE_NAME"] = $INSTITUTE_NAME;
					$instiLine["INSTITUTE_CITY"] = $INSTITUTE_CITY;
					$instiLine["INSTITUTE_ZONE"] = $INSTITUTE_ZONE;
					$instiLine["INSTITUTE_ZONE_DESC"] = $INSTITUTE_ZONE_DESC;
					$instiLine["INSTITUTE_HOOD"] = $INSTITUTE_HOOD;
					$instiLine["INSTITUTE_HOOD_DESC"] = $INSTITUTE_HOOD_DESC;
					$instiLine["INSTITUTE_ADDRESS"] = $INSTITUTE_ADDRESS;
					$instiLine["INSTITUTE_COORDS"] = $INSTITUTE_COORDS;
					$instiLine["INSTITUTE_EDU"] = $INSTITUTE_EDU;
					
					
					array_push($instiLines, $instiLine);
				}
				$exported = $this->excelCreate($EXPORT, $instiLines);
				$resp["path"] = $exported;
			}
			
			if($EXPORT == "dates")
			{
				$dateLines = array();
				
				for($i = 0; $i<count($query);$i++)
				{
					$queryItem = $query[$i];
					
					
					$DATE_ENTITY = $queryItem["DATE_ENTITY"];
					
					// GET ENTITY NAME
					$data = array();
					$data["table"] = "wp_entities";
					$data["fields"] = " ENTITY_NAME ";
					$data["keyField"] = " ENTITY_CODE ";
					$data["code"] = $DATE_ENTITY;
					$ENTITY_DATA = $this->getFriendlyData($data)["message"];
					$DATE_ENTITY = $ENTITY_DATA["ENTITY_NAME"];
					
					
					$DATE_CODE = $queryItem["DATE_CODE"];
					
					$DATE_LINE = $queryItem["DATE_LINE"];
					$DATE_DATE = $queryItem["DATE_DATE"];
					$DATE_DATE_INI = $queryItem["DATE_DATE_INI"];
					$DATE_DATE_END = $queryItem["DATE_DATE_END"];
					$DATE_PLACE = $queryItem["DATE_PLACE"];
					$DATE_CONTRATIST_NAME = $queryItem["DATE_CONTRATIST_NAME"];
					$DATE_CITIZEN_NAME = $queryItem["DATE_CITIZEN_NAME"];
					$DATE_COMMENT = $queryItem["DATE_COMMENT"];
					
					$DATE_STATE = $queryItem["DATE_STATE"];
					if($DATE_STATE == "0"){$DATE_STATE = "Abierta";}
					else{$DATE_STATE = "Cerrada";}
					
					$DATE_CLOSE_COMMENT = $queryItem["DATE_CLOSE_COMMENT"];
					
					$dateLine = array();
					$dateLine["DATE_CODE"] = $DATE_CODE;
					$dateLine["DATE_ENTITY"] = $DATE_ENTITY;
					$dateLine["DATE_LINE"] = $DATE_LINE;
					$dateLine["DATE_DATE"] = $DATE_DATE;
					$dateLine["DATE_DATE_INI"] = $DATE_DATE_INI;
					$dateLine["DATE_DATE_END"] = $DATE_DATE_END;
					$dateLine["DATE_PLACE"] = $DATE_PLACE;
					$dateLine["DATE_CONTRATIST_NAME"] = $DATE_CONTRATIST_NAME;
					$dateLine["DATE_CITIZEN_NAME"] = $DATE_CITIZEN_NAME;
					$dateLine["DATE_COMMENT"] = $DATE_COMMENT;
					$dateLine["DATE_STATE"] = $DATE_STATE;
					$dateLine["DATE_CLOSE_COMMENT"] = $DATE_CLOSE_COMMENT;

					
					array_push($dateLines, $dateLine);
				}
				$exported = $this->excelCreate($EXPORT, $dateLines);
				$resp["path"] = $exported;
			}
			
			if($EXPORT == "remitions")
			{
				$remLines = array();
				
				$now = new DateTime();
				$now = $now->format('Y-m-d');
				
				for($i = 0; $i<count($query);$i++)
				{
					$queryItem = $query[$i];
					
					$REM_CODE = $queryItem["REM_CODE"];
					$REM_LINE = $queryItem["REM_LINE"];
					$REM_CITIZEN = $queryItem["REM_CITIZEN"];
					$REM_ENTITY = $queryItem["REM_ENTITY"];
					$REM_ACTIVITY = $queryItem["REM_ACTIVITY"];
					$REM_DATE = $queryItem["REM_DATE"];
					$REM_AUTOR = $queryItem["REM_AUTOR"];

					$data = array();
					$data["table"] = "wp_activities";
					$data["fields"] = " ACTIVITY_NAME, ACTIVITY_PROJECT";
					$data["keyField"] = " ACTIVITY_CODE ";
					$data["code"] = $REM_ACTIVITY;
					$ACTIVITY_DATA = $this->getFriendlyData($data)["message"];
					if($ACTIVITY_DATA != "none")
					{
						$REM_ACTIVITY = $ACTIVITY_DATA["ACTIVITY_NAME"];
						
						$ACTIVITY_PROJECT = $ACTIVITY_DATA["ACTIVITY_PROJECT"];
						// GET PROJECT DATA
						$data = array();
						$data["table"] = "wp_projects";
						$data["fields"] = " PROJECT_NAME, PROJECT_PROGRAM ";
						$data["keyField"] = " PROJECT_CODE ";
						$data["code"] = $ACTIVITY_PROJECT;
						$PROJECT_DATA = $this->getFriendlyData($data)["message"];
						if($PROJECT_DATA != "none")
						{$REM_PROJECT = $PROJECT_DATA["PROJECT_NAME"];}
						else{$REM_PROJECT = "-";}
						
						$PROJECT_PROGRAM = $PROJECT_DATA["PROJECT_PROGRAM"];
						// GET PROGRAM DATA
						$data = array();
						$data["table"] = "wp_programs";
						$data["fields"] = " PROGRAM_NAME ";
						$data["keyField"] = " PROGRAM_CODE ";
						$data["code"] = $PROJECT_PROGRAM;
						$PROGRAM_DATA = $this->getFriendlyData($data)["message"];
						if($PROGRAM_DATA != "none")
						{$REM_PROGRAM = $PROGRAM_DATA["PROGRAM_NAME"];}
						else{$REM_PROGRAM = "-";}
						
						
					}
					else
					{
						$REM_ACTIVITY = $REM_ACTIVITY;
						$REM_ACTIVITY = "-";
						$REM_PROJECT = "-";
						$REM_PROGRAM = "-";
					}

					
					
					
					// ----------------CITIZEN DATA --------------
					// ----------------CITIZEN DATA --------------
					// ----------------CITIZEN DATA --------------
					
					$data = array();
					$data["table"] = "wp_citizens";
					$data["fields"] = " CITIZEN_IDTYPE, CITIZEN_IDNUM, CITIZEN_NAME, CITIZEN_LASTNAME, CITIZEN_GENDER, CITIZEN_BDAY, CITIZEN_ADDRESS, CITIZEN_PHONE, CITIZEN_EMAIL, CITIZEN_ETNIA, CITIZEN_CONDITION, CITIZEN_HOOD, CITIZEN_ZONE, CITIZEN_LEVEL, CITIZEN_ETNIA_IND, CITIZEN_ORIGIN_COUNTRY, CITIZEN_DESTINY_COUNTRY, CITIZEN_STAY_REASON, CITIZEN_MIGREXP,  CITIZEN_INDATE, CITIZEN_OUTDATE, CITIZEN_RETURN_REASON, CITIZEN_SITAC, CITIZEN_ACUDIENT, CITIZEN_BIRTH_CITY, CITIZEN_SISCORE, CITIZEN_CONVAC, CITIZEN_TIPOCO, CITIZEN_TIPOVI, CITIZEN_HANDICAP, CITIZEN_ETGROUP, CITIZEN_SECURITY, CITIZEN_EPS, CITIZEN_PATOEN, CITIZEN_TRASDES, CITIZEN_RISKFA, CITIZEN_PREVFA, CITIZEN_WEIGHT, CITIZEN_HEIGHT, CITIZEN_IMC, CITIZEN_IMC_RATE, CITIZEN_EDLEVEL, CITIZEN_INSTITUTE, CITIZEN_COURSES, CITIZEN_OCUCOND, CITIZEN_INGREC ";
					$data["keyField"] = " CITIZEN_IDNUM ";
					$data["code"] = $REM_CITIZEN;
					$CITIZEN_DATA = $this->getFriendlyData($data)["message"];
					
					// SET CITIZEN DATA FROM NEW OR SAVED
					if($CITIZEN_DATA == "none"){continue;}
					else
					{
						$CITIZEN_BDAY = $CITIZEN_DATA["CITIZEN_BDAY"];
					
						// GET AGE
						$d1 = $CITIZEN_BDAY;
						$d2 = $REM_DATE;
						$diff = abs(strtotime($d1) - strtotime($d2));
						$age = floor($diff / (365*60*60*24));
						$CITIZEN_AGE = $age;
						
						$CITIZEN_IDTYPE = $CITIZEN_DATA["CITIZEN_IDTYPE"];
						$CITIZEN_IDNUM = $CITIZEN_DATA["CITIZEN_IDNUM"];
						$CITIZEN_NAME = $CITIZEN_DATA["CITIZEN_NAME"];
						$CITIZEN_LASTNAME = $CITIZEN_DATA["CITIZEN_LASTNAME"];
						$CITIZEN_GENDER = $CITIZEN_DATA["CITIZEN_GENDER"];
						$CITIZEN_ADDRESS = $CITIZEN_DATA["CITIZEN_ADDRESS"];
						$CITIZEN_EMAIL = $CITIZEN_DATA["CITIZEN_EMAIL"];
						$CITIZEN_PHONE = $CITIZEN_DATA["CITIZEN_PHONE"];
						$CITIZEN_ETNIA = $CITIZEN_DATA["CITIZEN_ETNIA"];
						$CITIZEN_CONDITION = json_decode($CITIZEN_DATA["CITIZEN_CONDITION"], true);
						$CITIZEN_HOOD = $CITIZEN_DATA["CITIZEN_HOOD"];
						$CITIZEN_ZONE = $CITIZEN_DATA["CITIZEN_ZONE"];
						$CITIZEN_LEVEL = $CITIZEN_DATA["CITIZEN_LEVEL"];
						// ------***------
						$CITIZEN_ETNIA_IND = $CITIZEN_DATA["CITIZEN_ETNIA_IND"];
						$CITIZEN_ORIGIN_COUNTRY = $CITIZEN_DATA["CITIZEN_ORIGIN_COUNTRY"];
						$CITIZEN_DESTINY_COUNTRY = $CITIZEN_DATA["CITIZEN_DESTINY_COUNTRY"];
						$CITIZEN_STAY_REASON = $CITIZEN_DATA["CITIZEN_STAY_REASON"];
						$CITIZEN_MIGREXP = $CITIZEN_DATA["CITIZEN_MIGREXP"];
						$CITIZEN_INDATE = $CITIZEN_DATA["CITIZEN_INDATE"];
						$CITIZEN_OUTDATE = $CITIZEN_DATA["CITIZEN_OUTDATE"];
						$CITIZEN_RETURN_REASON = $CITIZEN_DATA["CITIZEN_RETURN_REASON"];
						$CITIZEN_SITAC = $CITIZEN_DATA["CITIZEN_SITAC"];
						$CITIZEN_ACUDIENT = $CITIZEN_DATA["CITIZEN_ACUDIENT"];
						$CITIZEN_BIRTH_CITY = $CITIZEN_DATA["CITIZEN_BIRTH_CITY"];
						$CITIZEN_SISCORE = $CITIZEN_DATA["CITIZEN_SISCORE"];
						$CITIZEN_CONVAC = $CITIZEN_DATA["CITIZEN_CONVAC"];
						$CITIZEN_TIPOCO = $CITIZEN_DATA["CITIZEN_TIPOCO"];
						$CITIZEN_TIPOVI = $CITIZEN_DATA["CITIZEN_TIPOVI"];
						$CITIZEN_HANDICAP = $CITIZEN_DATA["CITIZEN_HANDICAP"];
						$CITIZEN_ETGROUP = $CITIZEN_DATA["CITIZEN_ETGROUP"];
						$CITIZEN_SECURITY = $CITIZEN_DATA["CITIZEN_SECURITY"];
						$CITIZEN_EPS = $CITIZEN_DATA["CITIZEN_EPS"];
						$CITIZEN_PATOEN = $CITIZEN_DATA["CITIZEN_PATOEN"];
						$CITIZEN_TRASDES = $CITIZEN_DATA["CITIZEN_TRASDES"];
						if($CITIZEN_DATA["CITIZEN_RISKFA"] != null and $CITIZEN_DATA["CITIZEN_RISKFA"] != "")
						{$CITIZEN_RISKFA = json_decode($CITIZEN_DATA["CITIZEN_RISKFA"], true);}
						else{$CITIZEN_RISKFA = array();}
						if($CITIZEN_DATA["CITIZEN_PREVFA"] != null and $CITIZEN_DATA["CITIZEN_PREVFA"] != "")
						{$CITIZEN_PREVFA = json_decode($CITIZEN_DATA["CITIZEN_PREVFA"], true);}
						else{$CITIZEN_PREVFA = array();}
						$CITIZEN_WEIGHT = $CITIZEN_DATA["CITIZEN_WEIGHT"];
						$CITIZEN_HEIGHT = $CITIZEN_DATA["CITIZEN_HEIGHT"];
						$CITIZEN_IMC = $CITIZEN_DATA["CITIZEN_IMC"];
						$CITIZEN_IMC_RATE = $CITIZEN_DATA["CITIZEN_IMC_RATE"];
						$CITIZEN_EDLEVEL = $CITIZEN_DATA["CITIZEN_EDLEVEL"];
						$CITIZEN_INSTITUTE = $CITIZEN_DATA["CITIZEN_INSTITUTE"];
						$CITIZEN_COURSES = $CITIZEN_DATA["CITIZEN_COURSES"];
						$CITIZEN_OCUCOND = $CITIZEN_DATA["CITIZEN_OCUCOND"];
						$CITIZEN_INGREC = $CITIZEN_DATA["CITIZEN_INGREC"];
						
					}
						
					// GET ETNIA DATA
					$data = array();
					$data["table"] = "wp_etnias";
					$data["fields"] = " ETNIA_NAME ";
					$data["keyField"] = " ETNIA_CODE ";
					$data["code"] = $CITIZEN_ETNIA;
					$ETNIA_DATA = $this->getFriendlyData($data)["message"];
					if($ETNIA_DATA != "none")
					{$CITIZEN_ETNIA = $ETNIA_DATA["ETNIA_NAME"];}
					else{$CITIZEN_ETNIA = "-";}
				
					$CITIZEN_DATA["CITIZEN_ETNIA"] = $CITIZEN_ETNIA;
					
					// GET HOOD DATA
					$data = array();
					$data["table"] = "wp_hoods";
					$data["fields"] = " HOOD_NAME ";
					$data["keyField"] = " HOOD_CODE ";
					$data["code"] = $CITIZEN_HOOD;
					$HOOD_DATA = $this->getFriendlyData($data)["message"];
					if($HOOD_DATA != "none")
					{$CITIZEN_HOOD = $HOOD_DATA["HOOD_NAME"];}
					else{$CITIZEN_HOOD = "-";}
						
					$CITIZEN_DATA["CITIZEN_HOOD"] = $CITIZEN_HOOD;
					
					// GET ZONE DATA
					$data = array();
					$data["table"] = "wp_zones";
					$data["fields"] = " ZONE_NAME ";
					$data["keyField"] = " ZONE_CODE ";
					$data["code"] = $CITIZEN_ZONE;
					$ZONE_DATA = $this->getFriendlyData($data)["message"];
					if($ZONE_DATA != "none")
					{$CITIZEN_ZONE = $ZONE_DATA["ZONE_NAME"];}
					else{$CITIZEN_ZONE = "-";}
					
					$CITIZEN_DATA["CITIZEN_ZONE"] = $CITIZEN_ZONE;
						
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
					
					$CITIZEN_DATA["CITIZEN_CONDITION"] = $CITIZEN_CONDITION;
					
					// NEW FIELDS ADD
					// NEW FIELDS ADD
					// NEW FIELDS ADD
					// NEW FIELDS ADD
						
						
					$CITIZEN_ETNIA_IND = $CITIZEN_DATA["CITIZEN_ETNIA_IND"];
					$data = array();
					$data["table"] = "wp_master_tipoin";
					$data["fields"] = " TIPOIN_NAME ";
					$data["keyField"] = " TIPOIN_CODE ";
					$data["code"] = $CITIZEN_ETNIA_IND;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$CITIZEN_ETNIA_IND = $REG_DATA["TIPOIN_NAME"];}
					else{$CITIZEN_ETNIA_IND = "-";}
					
					$CITIZEN_ORIGIN_COUNTRY = $CITIZEN_DATA["CITIZEN_ORIGIN_COUNTRY"];
					$CITIZEN_DESTINY_COUNTRY = $CITIZEN_DATA["CITIZEN_DESTINY_COUNTRY"];
					
					$CITIZEN_STAY_REASON = $CITIZEN_DATA["CITIZEN_STAY_REASON"];
					$data = array();
					$data["table"] = "wp_master_migrea";
					$data["fields"] = " MIGREA_NAME ";
					$data["keyField"] = " MIGREA_CODE ";
					$data["code"] = $CITIZEN_STAY_REASON;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$CITIZEN_STAY_REASON = $REG_DATA["MIGREA_NAME"];}
					else{$CITIZEN_STAY_REASON = "-";}
					
					$CITIZEN_MIGREXP = $CITIZEN_DATA["CITIZEN_MIGREXP"];
					$CITIZEN_INDATE = $CITIZEN_DATA["CITIZEN_INDATE"];
					$CITIZEN_OUTDATE = $CITIZEN_DATA["CITIZEN_OUTDATE"];
					$CITIZEN_RETURN_REASON = $CITIZEN_DATA["CITIZEN_RETURN_REASON"];
					$CITIZEN_SITAC = $CITIZEN_DATA["CITIZEN_SITAC"];
					$CITIZEN_ACUDIENT = $CITIZEN_DATA["CITIZEN_ACUDIENT"];
					$CITIZEN_BIRTH_CITY = $CITIZEN_DATA["CITIZEN_BIRTH_CITY"];
					$CITIZEN_SISCORE = $CITIZEN_DATA["CITIZEN_SISCORE"];
					
					$CITIZEN_CONVAC = $CITIZEN_DATA["CITIZEN_CONVAC"];
					$data = array();
					$data["table"] = "wp_master_convac";
					$data["fields"] = " CONVAC_NAME ";
					$data["keyField"] = " CONVAC_CODE ";
					$data["code"] = $CITIZEN_CONVAC;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$CITIZEN_CONVAC = $REG_DATA["CONVAC_NAME"];}
					else{$CITIZEN_CONVAC = "-";}
						
						
					$CITIZEN_TIPOCO = $CITIZEN_DATA["CITIZEN_TIPOCO"];
					$data = array();
					$data["table"] = "wp_master_tipoco";
					$data["fields"] = " TIPOCO_NAME ";
					$data["keyField"] = " TIPOCO_CODE ";
					$data["code"] = $CITIZEN_TIPOCO;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$CITIZEN_TIPOCO = $REG_DATA["TIPOCO_NAME"];}
					else{$CITIZEN_TIPOCO = "-";}
					
				
					$CITIZEN_TIPOVI = $CITIZEN_DATA["CITIZEN_TIPOVI"];
					$data = array();
					$data["table"] = "wp_master_tipovi";
					$data["fields"] = " TIPOVI_NAME ";
					$data["keyField"] = " TIPOVI_CODE ";
					$data["code"] = $CITIZEN_TIPOVI;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$CITIZEN_TIPOVI = $REG_DATA["TIPOVI_NAME"];}
					else{$CITIZEN_TIPOVI = "-";}
					
					
					$CITIZEN_HANDICAP = $CITIZEN_DATA["CITIZEN_HANDICAP"];
					$CITIZEN_ETGROUP = $CITIZEN_DATA["CITIZEN_ETGROUP"];
					$CITIZEN_SECURITY = $CITIZEN_DATA["CITIZEN_SECURITY"];
					
					
					
					$CITIZEN_EPS = $CITIZEN_DATA["CITIZEN_EPS"];
					$data = array();
					$data["table"] = "wp_master_eps";
					$data["fields"] = " EPS_NAME ";
					$data["keyField"] = " EPS_CODE ";
					$data["code"] = $CITIZEN_EPS;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$CITIZEN_EPS = $REG_DATA["EPS_NAME"];}
					else{$CITIZEN_EPS = "-";}
					
					
					$CITIZEN_PATOEN = $CITIZEN_DATA["CITIZEN_PATOEN"];
					$data = array();
					$data["table"] = "wp_master_patoen";
					$data["fields"] = " PATOEN_NAME ";
					$data["keyField"] = " PATOEN_CODE ";
					$data["code"] = $CITIZEN_PATOEN;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$CITIZEN_PATOEN = $REG_DATA["PATOEN_NAME"];}
					else{$CITIZEN_PATOEN = "-";}
						
						
					$CITIZEN_TRASDES = $CITIZEN_DATA["CITIZEN_TRASDES"];
					$data = array();
					$data["table"] = "wp_master_trasdes";
					$data["fields"] = " TRASDES_NAME ";
					$data["keyField"] = " TRASDES_CODE ";
					$data["code"] = $CITIZEN_TRASDES;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$CITIZEN_TRASDES = $REG_DATA["TRASDES_NAME"];}
					else{$CITIZEN_TRASDES = "-";}
					
					$friendlyLine = "";
					for($n = 0; $n<count($CITIZEN_RISKFA);$n++)
					{
						$itemCode = $CITIZEN_RISKFA[$n];
						$data = array();
						$data["table"] = "wp_master_riskfa";
						$data["fields"] = " RISKFA_NAME ";
						$data["keyField"] = " RISKFA_CODE ";
						$data["code"] = $itemCode;
						$REG_DATA = $this->getFriendlyData($data)["message"];
						$RISKFA_NAME = $REG_DATA["RISKFA_NAME"];
						if($n < count($CITIZEN_RISKFA)-1)
						{$friendlyLine .= $RISKFA_NAME;	$friendlyLine .= ", ";}
						else{$friendlyLine .= $RISKFA_NAME;}
					}
					$CITIZEN_RISKFA = $friendlyLine;
					
					
					$friendlyLine = "";
					for($n = 0; $n<count($CITIZEN_PREVFA);$n++)
					{
						$itemCode = $CITIZEN_PREVFA[$n];
						$data = array();
						$data["table"] = "wp_master_prevfa";
						$data["fields"] = " PREVFA_NAME ";
						$data["keyField"] = " PREVFA_CODE ";
						$data["code"] = $itemCode;
						$REG_DATA = $this->getFriendlyData($data)["message"];
						$PREVFA = $REG_DATA["PREVFA_NAME"];
						if($n < count($CITIZEN_PREVFA)-1)
						{$friendlyLine .= $PREVFA;	$friendlyLine .= ", ";}
						else{$friendlyLine .= $PREVFA;}
					}
					$CITIZEN_PREVFA = $friendlyLine;
	
					$CITIZEN_WEIGHT = $CITIZEN_DATA["CITIZEN_WEIGHT"];
					$CITIZEN_HEIGHT = $CITIZEN_DATA["CITIZEN_HEIGHT"];
					$CITIZEN_IMC = $CITIZEN_DATA["CITIZEN_IMC"];
					$CITIZEN_IMC_RATE = $CITIZEN_DATA["CITIZEN_IMC_RATE"];

					$CITIZEN_EDLEVEL = $CITIZEN_DATA["CITIZEN_EDLEVEL"];
					$data = array();
					$data["table"] = "wp_master_edlevel";
					$data["fields"] = " EDLEVEL_NAME ";
					$data["keyField"] = " EDLEVEL_CODE ";
					$data["code"] = $CITIZEN_EDLEVEL;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$CITIZEN_EDLEVEL = $REG_DATA["EDLEVEL_NAME"];}
					else{$CITIZEN_EDLEVEL = "-";}
											
					
					$CITIZEN_INSTITUTE = $CITIZEN_DATA["CITIZEN_INSTITUTE"];
					$data = array();
					$data["table"] = "wp_institutes";
					$data["fields"] = " INSTITUTE_NAME ";
					$data["keyField"] = " INSTITUTE_CODE ";
					$data["code"] = $CITIZEN_INSTITUTE;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$CITIZEN_INSTITUTE = $REG_DATA["INSTITUTE_NAME"];}
					else{$CITIZEN_INSTITUTE = "-";}
					
					
					$CITIZEN_COURSES = $CITIZEN_DATA["CITIZEN_COURSES"];
					$data = array();
					$data["table"] = "wp_master_courses";
					$data["fields"] = " COURSES_NAME ";
					$data["keyField"] = " COURSES_CODE ";
					$data["code"] = $CITIZEN_COURSES;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$CITIZEN_COURSES = $REG_DATA["COURSES_NAME"];}
					else{$CITIZEN_COURSES = "-";}
						
						
					$CITIZEN_OCUCOND = $CITIZEN_DATA["CITIZEN_OCUCOND"];
					$data = array();
					$data["table"] = "wp_master_ocucond";
					$data["fields"] = " OCUCOND_NAME ";
					$data["keyField"] = " OCUCOND_CODE ";
					$data["code"] = $CITIZEN_OCUCOND;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$CITIZEN_OCUCOND = $REG_DATA["OCUCOND_NAME"];}
					else{$CITIZEN_OCUCOND = "-";}
					
					
					$CITIZEN_INGREC = $CITIZEN_DATA["CITIZEN_INGREC"];
					$data = array();
					$data["table"] = "wp_master_ingrec";
					$data["fields"] = " INGREC_NAME ";
					$data["keyField"] = " INGREC_CODE ";
					$data["code"] = $CITIZEN_INGREC;
					$REG_DATA = $this->getFriendlyData($data)["message"];
					if($REG_DATA != "none")
					{$CITIZEN_INGREC = $REG_DATA["INGREC_NAME"];}
					else{$CITIZEN_INGREC = "-";}
					
					
					// ----------------CITIZEN DATA --------------
					// ----------------CITIZEN DATA --------------
					// ----------------CITIZEN DATA --------------
					
					
					
					// GET ALL COMMENTS OF THIS LINE-CITIZEN 
					$str = "SELECT * FROM wp_attend WHERE REMCOM_REM_CODE = '".$REM_CODE."'";
					$COMMENTS = $this->db->query($str);
					
					$filtered = array();
					for($z = 0; $z<count($COMMENTS);$z++)
					{
						if($UTYPE != "Principal1" and $UTYPE != "Principal2" and $UTYPE != "Principal3" and $UTYPE != "Superior")
						{
							if($COMMENTS[$z]["REMCOM_AUTOR"] != $ucode and $COMMENTS[$z]["REMCOM_CONTRATIST"] != $ucode){continue;}
						}
						array_push($filtered, $COMMENTS[$z]);
					}
					
					if(count($filtered) > 0)
					{
						for($c = 0; $c<count($filtered);$c++)
						{
							$REM_COMMENT = $filtered[$c];

							$REMCOM_CODE = $REM_COMMENT["REMCOM_CODE"];
							$REMCOM_AUTOR_NAME = $REM_COMMENT["REMCOM_AUTOR_NAME"];
							$REMCOM_CONTRATIST_NAME = $REM_COMMENT["REMCOM_CONTRATIST_NAME"];
							$REMCOM_ACTUAL_CNUMBER = $REM_COMMENT["REMCOM_ACTUAL_CNUMBER"];
							$REMCOM_DATE = $REM_COMMENT["REMCOM_DATE"];
							$REMCOM_COMMENT = $REM_COMMENT["REMCOM_COMMENT"];
							$REMCOM_COMMENT_DATE = $REM_COMMENT["REMCOM_COMMENT_DATE"];
							$REMCOM_TYPE = $REM_COMMENT["REMCOM_TYPE"];
							$REMCOM_SPECIAL = $REM_COMMENT["REMCOM_SPECIAL"];
							$REMCOM_GROUP = $REM_COMMENT["REMCOM_GROUP"];
							$REMCOM_NEW_ACTIVITY = $REM_COMMENT["REMCOM_NEW_ACTIVITY"];
							$REMCOM_REMSTATE = $REM_COMMENT["REMCOM_REMSTATE"];
							$REMCOM_NEW_CONTRATIST_NAME = $REM_COMMENT["REMCOM_NEW_CONTRATIST_NAME"];
							$REMCOM_COMPONENT = $REM_COMMENT["REMCOM_COMPONENT"];
							$REMCOM_SCOMPONENT = $REM_COMMENT["REMCOM_SCOMPONENT"];
							
							
							// DOES IT HAVE ATTACHMENT?
							$str = "SELECT REMCOM_CODE FROM wp_attend WHERE REMCOM_CODE = '".$REMCOM_CODE."' AND REMCOM_FILE != ''";
							$checkFile = $this->db->query($str);
							if(count($checkFile) > 0){$REMCOM_HAVE_FILE = "Si";}
							else{$REMCOM_HAVE_FILE = "No";}
							
							if($REMCOM_GROUP != "")
							{
								$data = array();
								$data["table"] = "wp_groups";
								$data["fields"] = " GROUP_NAME ";
								$data["keyField"] = " GROUP_CODE ";
								$data["code"] = $REMCOM_GROUP;
								$REG_DATA = $this->getFriendlyData($data)["message"];
								if($REG_DATA != "none")
								{$REMCOM_GROUP = $REG_DATA["GROUP_NAME"];}
								else{$REMCOM_GROUP = "-";}
								
							}
							
							if($REMCOM_NEW_ACTIVITY != "")
							{
								$data = array();
								$data["table"] = "wp_activities";
								$data["fields"] = " ACTIVITY_NAME ";
								$data["keyField"] = " ACTIVITY_CODE ";
								$data["code"] = $REMCOM_NEW_ACTIVITY;
								$REG_DATA = $this->getFriendlyData($data)["message"];
								if($REG_DATA != "none")
								{$REMCOM_NEW_ACTIVITY = $REG_DATA["ACTIVITY_NAME"];}
								else{$REMCOM_NEW_ACTIVITY = "-";}
							}
							
							if($REMCOM_COMPONENT != "")
							{
								$data = array();
								$data["table"] = "wp_master_component";
								$data["fields"] = " COMPONENT_NAME ";
								$data["keyField"] = " COMPONENT_CODE ";
								$data["code"] = $REMCOM_COMPONENT;
								$REG_DATA = $this->getFriendlyData($data)["message"];
								if($REG_DATA != "none")
								{$REMCOM_COMPONENT = $REG_DATA["COMPONENT_NAME"];}
								else{$REMCOM_COMPONENT = "-";}
							}
							
							if($REMCOM_SCOMPONENT != "")
							{
								$data = array();
								$data["table"] = "wp_master_scomponent";
								$data["fields"] = " SCOMPONENT_NAME ";
								$data["keyField"] = " SCOMPONENT_CODE ";
								$data["code"] = $REMCOM_SCOMPONENT;
								$REG_DATA = $this->getFriendlyData($data)["message"];
								if($REG_DATA != "none")
								{$REMCOM_SCOMPONENT = $REG_DATA["SCOMPONENT_NAME"];}
								else{$REMCOM_SCOMPONENT = "-";}
							}
							
							if($REMCOM_TYPE == "normalComment"){$REMCOM_TYPE = "Normal";}
							if($REMCOM_TYPE == "addGroup"){$REMCOM_TYPE = "Agrupación";}
							if($REMCOM_TYPE == "quitGroup"){$REMCOM_TYPE = "Desagrupación";}
							if($REMCOM_TYPE == "remit"){$REMCOM_TYPE = "Atención";}
							if($REMCOM_TYPE == "date"){$REMCOM_TYPE = "Cita";}
							if($REMCOM_TYPE == "close"){$REMCOM_TYPE = "Cierre";}
							if($REMCOM_TYPE == "reopen"){$REMCOM_TYPE = "Re apertura";}
							if($REMCOM_TYPE == "decition"){$REMCOM_TYPE = "Decisión";}
							if($REMCOM_REMSTATE == "0"){$REMCOM_REMSTATE = "Abierta";}
							if($REMCOM_REMSTATE == "1"){$REMCOM_REMSTATE = "Cerrada";}
							
							$remLine = array();
							$remLine["REM_LINE"] = $REM_LINE;
							$remLine["REM_DATE"] = $REM_DATE;
							$remLine["REM_ACTIVITY"] = $REM_ACTIVITY;
							$remLine["REM_PROJECT"] = $REM_PROJECT;
							$remLine["REM_PROGRAM"] = $REM_PROGRAM;
							$remLine["REMCOM_AUTOR_NAME"] = $REMCOM_AUTOR_NAME;
							$remLine["REMCOM_CONTRATIST_NAME"] = $REMCOM_CONTRATIST_NAME;
							
							// ----------------CITIZEN DATA --------------
							
							$remLine["CITIZEN_IDTYPE"] = $CITIZEN_IDTYPE;
							$remLine["CITIZEN_IDNUM"] = $CITIZEN_IDNUM;
							$remLine["CITIZEN_NAME"] = $CITIZEN_NAME;
							$remLine["CITIZEN_LASTNAME"] = $CITIZEN_LASTNAME;
							$remLine["CITIZEN_GENDER"] = $CITIZEN_GENDER;
							$remLine["CITIZEN_BDAY"] = $CITIZEN_BDAY;
							$remLine["CITIZEN_AGE"] = $CITIZEN_AGE;
							$remLine["CITIZEN_ADDRESS"] = $CITIZEN_ADDRESS;
							$remLine["CITIZEN_EMAIL"] = $CITIZEN_EMAIL;
							$remLine["CITIZEN_PHONE"] = $CITIZEN_PHONE;
							$remLine["CITIZEN_ETNIA"] = $CITIZEN_ETNIA;
							$remLine["CITIZEN_CONDITION"] = $CITIZEN_CONDITION;
							$remLine["CITIZEN_HOOD"] = $CITIZEN_HOOD;
							$remLine["CITIZEN_ZONE"] = $CITIZEN_ZONE;
							$remLine["CITIZEN_LEVEL"] = $CITIZEN_LEVEL;
							$remLine["CITIZEN_ETNIA_IND"] = $CITIZEN_ETNIA_IND;
							$remLine["CITIZEN_ORIGIN_COUNTRY"] = $CITIZEN_ORIGIN_COUNTRY;
							$remLine["CITIZEN_DESTINY_COUNTRY"] = $CITIZEN_DESTINY_COUNTRY;
							$remLine["CITIZEN_STAY_REASON"] = $CITIZEN_STAY_REASON;
							$remLine["CITIZEN_MIGREXP"] = $CITIZEN_MIGREXP;
							$remLine["CITIZEN_INDATE"] = $CITIZEN_INDATE;
							$remLine["CITIZEN_OUTDATE"] = $CITIZEN_OUTDATE;
							$remLine["CITIZEN_RETURN_REASON"] = $CITIZEN_RETURN_REASON;
							$remLine["CITIZEN_SITAC"] = $CITIZEN_SITAC;
							$remLine["CITIZEN_ACUDIENT"] = $CITIZEN_ACUDIENT;
							$remLine["CITIZEN_BIRTH_CITY"] = $CITIZEN_BIRTH_CITY;
							$remLine["CITIZEN_SISCORE"] = $CITIZEN_SISCORE;
							$remLine["CITIZEN_CONVAC"] = $CITIZEN_CONVAC;
							$remLine["CITIZEN_TIPOCO"] = $CITIZEN_TIPOCO;
							$remLine["CITIZEN_TIPOVI"] = $CITIZEN_TIPOVI;
							$remLine["CITIZEN_HANDICAP"] = $CITIZEN_HANDICAP;
							$remLine["CITIZEN_ETGROUP"] = $CITIZEN_ETGROUP;
							$remLine["CITIZEN_SECURITY"] = $CITIZEN_SECURITY;
							$remLine["CITIZEN_EPS"] = $CITIZEN_EPS;
							$remLine["CITIZEN_PATOEN"] = $CITIZEN_PATOEN;
							$remLine["CITIZEN_TRASDES"] = $CITIZEN_TRASDES;
							$remLine["CITIZEN_RISKFA"] = $CITIZEN_RISKFA;
							$remLine["CITIZEN_PREVFA"] = $CITIZEN_PREVFA;
							$remLine["CITIZEN_WEIGHT"] = $CITIZEN_WEIGHT;
							$remLine["CITIZEN_HEIGHT"] = $CITIZEN_HEIGHT;
							$remLine["CITIZEN_IMC"] = $CITIZEN_IMC;
							$remLine["CITIZEN_IMC_RATE"] = $CITIZEN_IMC_RATE;
							$remLine["CITIZEN_EDLEVEL"] = $CITIZEN_EDLEVEL;
							$remLine["CITIZEN_INSTITUTE"] = $CITIZEN_INSTITUTE;
							$remLine["CITIZEN_COURSES"] = $CITIZEN_COURSES;
							$remLine["CITIZEN_OCUCOND"] = $CITIZEN_OCUCOND;
							$remLine["CITIZEN_INGREC"] = $CITIZEN_INGREC;
							
							// ----------------CITIZEN DATA --------------
							
							$remLine["REMCOM_ACTUAL_CNUMBER"] = $REMCOM_ACTUAL_CNUMBER;
							$remLine["REMCOM_DATE"] = $REMCOM_DATE;
							$remLine["REMCOM_COMMENT"] = $REMCOM_COMMENT;
							$remLine["REMCOM_COMMENT_DATE"] = $REMCOM_COMMENT_DATE;
							$remLine["REMCOM_TYPE"] = $REMCOM_TYPE;
							$remLine["REMCOM_SPECIAL"] = $REMCOM_SPECIAL;
							$remLine["REMCOM_HAVE_FILE"] = $REMCOM_HAVE_FILE;
							$remLine["REMCOM_GROUP"] = $REMCOM_GROUP;
							$remLine["REMCOM_NEW_CONTRATIST_NAME"] = $REMCOM_NEW_CONTRATIST_NAME;
							$remLine["REMCOM_NEW_ACTIVITY"] = $REMCOM_NEW_ACTIVITY;
							$remLine["REMCOM_REMSTATE"] = $REMCOM_REMSTATE;
							
							$remLine["REMCOM_COMPONENT"] = $REMCOM_COMPONENT;
							$remLine["REMCOM_SCOMPONENT"] = $REMCOM_SCOMPONENT;
							
							
							
							
							array_push($remLines, $remLine);
						}
					}
					
					
				}
				
				$exported = $this->excelCreate($EXPORT, $remLines);
				$resp["path"] = $exported;
			}
			
			if($EXPORT == "visits")
			{
				$visitLines = array();
				
				for($i = 0; $i<count($query);$i++)
				{
					$queryItem = $query[$i];
					
					// if(!isset($queryItem[$i]["VISIT_HOOD_NAME"]))
					// {
						
					// }
					
					$VISIT_CODE = $queryItem["VISIT_CODE"];
					$VISIT_DATE = $queryItem["VISIT_DATE"];
					$VISIT_ENTITY = $queryItem["VISIT_ENTITY"];
					$VISIT_CONTRACT_CODE = $queryItem["VISIT_CONTRACT_CODE"];
					$VISIT_OWNER = $queryItem["VISIT_OWNER"];
					$VISIT_CLASS = $queryItem["VISIT_CLASS"];
					$VISITED_CONTRACT = $queryItem["VISIT_CONTRACT"];
					$VISIT_GROUP = $queryItem["VISIT_GROUP"];
					$VISIT_ACTIVITY = $queryItem["VISIT_ACTIVITY"];
					
					if(isset($queryItem["VISIT_HOOD_NAME"]))
					{
						$VISIT_HOOD_NAME = $queryItem["VISIT_HOOD_NAME"];
					}
					else
					{
						
						$VISIT_HOOD_NAME = $queryItem["VISIT_HOOD"];
						
					}
					
					if(isset($queryItem["VISIT_ZONE_NAME"]))
					{
						$VISIT_ZONE_NAME = $queryItem["VISIT_ZONE_NAME"];
					}
					else
					{
						$VISIT_ZONE_NAME = $queryItem["VISIT_ZONE"];
					}
					
					
					
					$VISIT_ADDRESS = $queryItem["VISIT_ADDRESS"];
					$VISIT_CLASS_COORD = $queryItem["VISIT_CLASS_COORD"];
					$VISIT_COORD = $queryItem["VISIT_COORD"];
					$VISIT_DONE = $queryItem["VISIT_DONE"];
					$VISIT_TYPE = $queryItem["VISIT_TYPE"];
					$VISIT_ASSISTQTY = $queryItem["VISIT_ASSISTQTY"];
					$VISIT_NOASSISTQTY = $queryItem["VISIT_NOASSISTQTY"];
					$VISIT_STONTIME = $queryItem["VISIT_STONTIME"];
					$VISIT_TOOLS = $queryItem["VISIT_TOOLS"];
					$VISIT_GOODTIME = $queryItem["VISIT_GOODTIME"];
					$VISIT_GOODPLACE = $queryItem["VISIT_GOODPLACE"];
					$VISIT_FORMAT = $queryItem["VISIT_FORMAT"];
					$VISIT_PDELIVER = $queryItem["VISIT_PDELIVER"];
					$VISIT_COHERENT = $queryItem["VISIT_COHERENT"];
					$VISIT_EASY = $queryItem["VISIT_EASY"];
					$VISIT_ORIENT = $queryItem["VISIT_ORIENT"];
					$VISIT_EXPRESSION = $queryItem["VISIT_EXPRESSION"];
					$VISIT_PRESENT = $queryItem["VISIT_PRESENT"];
					$VISIT_VERIFIED = $queryItem["VISIT_VERIFIED"];
					$VISIT_ACOMPLISH = $queryItem["VISIT_ACOMPLISH"];
					$VISIT_SIGNED = $queryItem["VISIT_SIGNED"];

					
					// GET ENTITY NAME
					$data = array();
					$data["table"] = "wp_entities";
					$data["fields"] = " ENTITY_NAME ";
					$data["keyField"] = " ENTITY_CODE ";
					$data["code"] = $VISIT_ENTITY;
					$ENTITY_DATA = $this->getFriendlyData($data)["message"];
					$VISIT_ENTITY = $ENTITY_DATA["ENTITY_NAME"];
					
					// GET/UPDATE CONTRACT
					if($VISIT_CONTRACT_CODE != "" and $VISIT_CONTRACT_CODE != "null" and $VISIT_CONTRACT_CODE != null)
					{
						$VISIT_CONTRACT = $VISIT_CONTRACT_CODE;
					}
					else
					{
						$now = new DateTime();
						$now = $now->format('Y-m-d');
						// GET CONTRACT INI AND END DATE
						$str = "SELECT CONTRACT_CODE FROM wp_contracts WHERE CONTRACT_OWNER = '".$VISIT_OWNER."' AND CONTRACT_ENDATE >= '".$now."' AND CONTRACT_INIDATE <= '".$now."'";
						$contractData = $this->db->query($str);
						if(count($contractData) > 0)
						{
							$VISIT_CONTRACT = $contractData[0]["CONTRACT_CODE"];
							$str = "UPDATE wp_visits SET VISIT_CONTRACT_CODE = '".$VISIT_CONTRACT."' WHERE VISIT_CODE ='".$VISIT_CODE."'";
							$updater = $this->db->query($str);
						}
					}
					
					// GET VISITOR CONTRACTOR DATA
					$data = array();
					$data["table"] = "wp_contracts";
					$data["fields"] = " CONTRACT_NUMBER, CONTRACT_INIDATE, CONTRACT_ENDATE, CONTRACT_USERTYPE ";
					$data["keyField"] = " CONTRACT_CODE ";
					$data["code"] = $VISIT_CONTRACT;
					$EVENT_CONTRACT_DATA = $this->getFriendlyData($data)["message"];
					if($EVENT_CONTRACT_DATA == "none"){continue;}
					$CONTRACT_NUMBER = $EVENT_CONTRACT_DATA["CONTRACT_NUMBER"];
					$CONTRACT_INIDATE = $EVENT_CONTRACT_DATA["CONTRACT_INIDATE"];
					$CONTRACT_ENDATE = $EVENT_CONTRACT_DATA["CONTRACT_ENDATE"];
					$CONTRACT_USERTYPE = $EVENT_CONTRACT_DATA["CONTRACT_USERTYPE"];
					
					// GET CONTRACT OWNER DATA
					$data = array();
					$data["table"] = "wp_trusers";
					$data["fields"] = " USER_IDTYPE, USER_IDNUM, USER_NAME, USER_LASTNAME ";
					$data["keyField"] = " USER_CODE ";
					$data["code"] = $VISIT_OWNER;
					$VISITOR_DATA = $this->getFriendlyData($data)["message"];
					if($VISITOR_DATA != "none")
					{
						$VISITOR_IDTYPE = $VISITOR_DATA["USER_IDTYPE"];
						$VISITOR_IDNUM = $VISITOR_DATA["USER_IDNUM"];
						$VISITOR_NAME = $VISITOR_DATA["USER_NAME"];
						$VISITOR_LASTNAME = $VISITOR_DATA["USER_LASTNAME"];
					}

					// GET CLASS DATA
					$data = array();
					$data["table"] = "wp_classes";
					$data["fields"] = " CLASS_CODE, CLASS_DATE, CLASS_HOUR, CLASS_CITIZENS, CLASS_EXCUSE ";
					$data["keyField"] = " CLASS_CODE ";
					$data["code"] = $VISIT_CLASS;
					$CLASS_DATA = $this->getFriendlyData($data)["message"];
					if($CLASS_DATA != "none")
					{
						$CLASS_CODE = $CLASS_DATA["CLASS_CODE"];
						$CLASS_DATE = $CLASS_DATA["CLASS_DATE"];
						$HOURS = json_decode($CLASS_DATA["CLASS_HOUR"], true);
						$CLASS_INI_HOUR = $HOURS["GROUP_TIME_INI"];
						$CLASS_END_HOUR = $HOURS["GROUP_TIME_END"];
						
						if($CLASS_DATA["CLASS_CITIZENS"] != "" and $CLASS_DATA["CLASS_CITIZENS"] != "null" and $CLASS_DATA["CLASS_CITIZENS"] != null)
						{
							$CLASS_DATA["CLASS_CITIZENS"]= preg_replace('/[ ]{2,}|[\t]/', ' ', trim($CLASS_DATA["CLASS_CITIZENS"]));
							$CLASS_CITIZENS = json_decode($CLASS_DATA["CLASS_CITIZENS"], true);
							$CITIZENS_QTY = count($CLASS_CITIZENS);
						}
						else
						{
							$CLASS_CITIZENS = array();
							$CITIZENS_QTY = 0;
						}
											
						
						if($CLASS_DATA["CLASS_EXCUSE"] != "" and $CLASS_DATA["CLASS_EXCUSE"] != "null" and $CLASS_DATA["CLASS_EXCUSE"] != null)
						{
							
							$CLASS_DATA["CLASS_EXCUSE"] = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($CLASS_DATA["CLASS_EXCUSE"]));
							$CLASS_EXCUSE = json_decode($CLASS_DATA["CLASS_EXCUSE"], true);
						}
						else{$CLASS_EXCUSE = "";}

						
						// GET ASSIST QTY AND STATUS
						$CLASS_STATUS = "Abierta";
						$CLASS_ATTENDERS = 0;
						for($z = 0; $z<count($CLASS_CITIZENS);$z++)
						{
							$cit = $CLASS_CITIZENS[$z];
							if($cit["CITIZEN_ASSIST"] == "1"){$CLASS_ATTENDERS++;}
						}
						if($CLASS_ATTENDERS > 0){$CLASS_STATUS = "Dictada";}
						
						if($CLASS_EXCUSE != "" AND $CLASS_EXCUSE != null and $CLASS_EXCUSE != "null")
						{
							$CLASS_STATUS = "No dictada";
							$EXCUSE_REASON = $CLASS_EXCUSE["EXCUSE_REASON"];
							$EXCUSE_COMMENTS = $CLASS_EXCUSE["EXCUSE_COMMENTS"];
						}
						else
						{
							$EXCUSE_REASON = "";
							$EXCUSE_COMMENTS = "";
						}
					}
					
					
					// GET VISITED CONTRACT DATA
					$data = array();
					$data["table"] = "wp_contracts";
					$data["fields"] = " CONTRACT_NUMBER, CONTRACT_INIDATE, CONTRACT_ENDATE, CONTRACT_USERTYPE, CONTRACT_OWNER ";
					$data["keyField"] = " CONTRACT_CODE ";
					$data["code"] = $VISITED_CONTRACT;
					$VEVENT_CONTRACT_DATA = $this->getFriendlyData($data)["message"];
					if($VEVENT_CONTRACT_DATA == "none"){continue;}
					$VCONTRACT_NUMBER = $VEVENT_CONTRACT_DATA["CONTRACT_NUMBER"];
					$VCONTRACT_INIDATE = $VEVENT_CONTRACT_DATA["CONTRACT_INIDATE"];
					$VCONTRACT_ENDATE = $VEVENT_CONTRACT_DATA["CONTRACT_ENDATE"];
					$VCONTRACT_USERTYPE = $VEVENT_CONTRACT_DATA["CONTRACT_USERTYPE"];
					$VCONTRACT_OWNER = $VEVENT_CONTRACT_DATA["CONTRACT_OWNER"];

					// GET VISITED CONTRACTOR DATA
					$data = array();
					$data["table"] = "wp_trusers";
					$data["fields"] = " USER_IDTYPE, USER_IDNUM, USER_NAME, USER_LASTNAME ";
					$data["keyField"] = " USER_CODE ";
					$data["code"] = $VCONTRACT_OWNER;
					$VISITED_DATA = $this->getFriendlyData($data)["message"];
					if($VISITED_DATA != "none")
					{
						$VISITED_IDTYPE = $VISITED_DATA["USER_IDTYPE"];
						$VISITED_IDNUM = $VISITED_DATA["USER_IDNUM"];
						$VISITED_NAME = $VISITED_DATA["USER_NAME"];
						$VISITED_LASTNAME = $VISITED_DATA["USER_LASTNAME"];
					}

					
					// GET GROUP DATA
					$data = array();
					$data["table"] = "wp_groups";
					$data["fields"] = " GROUP_NAME, GROUP_INSTYPE, GROUP_PREVIR, GROUP_COPERATOR  ";
					$data["keyField"] = " GROUP_CODE ";
					$data["code"] = $VISIT_GROUP;
					$VISIT_GROUP_DATA = $this->getFriendlyData($data)["message"];
					
					if($VISIT_GROUP_DATA != "none")
					{
						$GROUP_NAME = $VISIT_GROUP_DATA["GROUP_NAME"];
						$GROUP_PREVIR = $VISIT_GROUP_DATA["GROUP_PREVIR"];
						$GROUP_INSTYPE = $VISIT_GROUP_DATA["GROUP_INSTYPE"];
						$COOPERATOR = $VISIT_GROUP_DATA["GROUP_COPERATOR"];
					}
					else
					{
						$GROUP_NAME = "-";
						$GROUP_PREVIR = "-";
						$GROUP_INSTYPE = "-";
						$COOPERATOR = "";
					}

					// GET FRIENDLY NAMES FOT ACTIVITY AND PARENTS
					$activities = array();
					$projects = array();
					$programs = array();
					
					$data = array();
					$data["table"] = "wp_activities";
					$data["fields"] = " ACTIVITY_NAME, ACTIVITY_PROJECT ";
					$data["keyField"] = " ACTIVITY_CODE ";
					$data["code"] = $VISIT_ACTIVITY;
					$CLASS_ACTIVITY_DATA = $this->getFriendlyData($data)["message"];
					$ACTIVITY_NAME = $CLASS_ACTIVITY_DATA["ACTIVITY_NAME"];
					// ADD IF NOT
					if (!in_array($ACTIVITY_NAME, $activities)){array_push($activities, $ACTIVITY_NAME);}
					
					$ACTIVITY_PROJECT = $CLASS_ACTIVITY_DATA["ACTIVITY_PROJECT"];
					// GET PROJECT DATA
					$data = array();
					$data["table"] = "wp_projects";
					$data["fields"] = " PROJECT_NAME, PROJECT_PROGRAM ";
					$data["keyField"] = " PROJECT_CODE ";
					$data["code"] = $ACTIVITY_PROJECT;
					$CLASS_PROJECT_DATA = $this->getFriendlyData($data)["message"];
					$PROJECT_NAME = $CLASS_PROJECT_DATA["PROJECT_NAME"];
					// ADD IF NOT
					if (!in_array($PROJECT_NAME, $projects)){array_push($projects, $PROJECT_NAME);}
					
					$PROJECT_PROGRAM = $CLASS_PROJECT_DATA["PROJECT_PROGRAM"];
					// GET PROGRAM DATA
					$data = array();
					$data["table"] = "wp_programs";
					$data["fields"] = " PROGRAM_NAME ";
					$data["keyField"] = " PROGRAM_CODE ";
					$data["code"] = $PROJECT_PROGRAM;
					$CLASS_PROGRAM_DATA = $this->getFriendlyData($data)["message"];
					$PROGRAM_NAME = $CLASS_PROGRAM_DATA["PROGRAM_NAME"];
					// ADD IF NOT
					if (!in_array($PROGRAM_NAME, $programs)){array_push($programs, $PROGRAM_NAME);}
					
					
					$ACTIVITIES = $this->stringFromArray($activities);
					$PROJECTS = $this->stringFromArray($projects);
					$PROGRAMS = $this->stringFromArray($programs);
					
					if($COOPERATOR != "" and $COOPERATOR !=  null and $COOPERATOR !=  "null")
					{
						$COOPERATOR = explode("-",$COOPERATOR)[0];
						
						$data = array();
						$data["table"] = "wp_citizens";
						$data["fields"] = " CITIZEN_IDTYPE, CITIZEN_IDNUM, CITIZEN_NAME, CITIZEN_LASTNAME, CITIZEN_PHONE, CITIZEN_EMAIL ";
						$data["keyField"] = " CITIZEN_IDNUM ";
						$data["code"] = $COOPERATOR;
						$COOPERATOR_DATA = $this->getFriendlyData($data)["message"];
						if($COOPERATOR_DATA != "none")
						{
							$COOPERATOR_IDTYPE = $COOPERATOR_DATA["CITIZEN_IDTYPE"];
							$COOPERATOR_IDNUM = $COOPERATOR_DATA["CITIZEN_IDNUM"];
							$COOPERATOR_NAME = $COOPERATOR_DATA["CITIZEN_NAME"];
							$COOPERATOR_LASTNAME = $COOPERATOR_DATA["CITIZEN_LASTNAME"];
							$COOPERATOR_PHONE = $COOPERATOR_DATA["CITIZEN_PHONE"];
							$COOPERATOR_EMAIL = $COOPERATOR_DATA["CITIZEN_EMAIL"];
						}
					}
					else
					{
						$COOPERATOR_IDTYPE = "";
						$COOPERATOR_IDNUM = "";
						$COOPERATOR_NAME = "";
						$COOPERATOR_LASTNAME = "";
						$COOPERATOR_PHONE = "";
						$COOPERATOR_EMAIL = "";
					}

					
					$VISIT_COMMENTS = $queryItem["VISIT_COMMENTS"];
					
					$visitLine = array();
					$visitLine["VISIT_DATE"] = $VISIT_DATE;
					$visitLine["VISIT_ENTITY"] = $VISIT_ENTITY;
					$visitLine["CONTRACT_NUMBER"] = $CONTRACT_NUMBER;
					$visitLine["CONTRACT_INIDATE"] = $CONTRACT_INIDATE;
					$visitLine["CONTRACT_ENDATE"] = $CONTRACT_ENDATE;
					$visitLine["CONTRACT_USERTYPE"] = $CONTRACT_USERTYPE;
					$visitLine["VISITOR_IDTYPE"] = $VISITOR_IDTYPE;
					$visitLine["VISITOR_IDNUM"] = $VISITOR_IDNUM;
					$visitLine["VISITOR_NAME"] = $VISITOR_NAME;
					$visitLine["VISITOR_LASTNAME"] = $VISITOR_LASTNAME;
					$visitLine["CLASS_DATE"] = $CLASS_DATE;
					$visitLine["CLASS_INI_HOUR"] = $CLASS_INI_HOUR;
					$visitLine["CLASS_END_HOUR"] = $CLASS_END_HOUR;
					$visitLine["CLASS_STATUS"] = $CLASS_STATUS;
					$visitLine["CLASS_ATTENDERS"] = $CLASS_ATTENDERS;
					$visitLine["EXCUSE_REASON"] = $EXCUSE_REASON;
					$visitLine["EXCUSE_COMMENTS"] = $EXCUSE_COMMENTS;
					$visitLine["VCONTRACT_NUMBER"] = $VCONTRACT_NUMBER;
					$visitLine["VCONTRACT_INIDATE"] = $VCONTRACT_INIDATE;
					$visitLine["VCONTRACT_ENDATE"] = $VCONTRACT_ENDATE;
					$visitLine["VCONTRACT_USERTYPE"] = $VCONTRACT_USERTYPE;
					$visitLine["VISITED_IDTYPE"] = $VISITED_IDTYPE;
					$visitLine["VISITED_IDNUM"] = $VISITED_IDNUM;
					$visitLine["VISITED_NAME"] = $VISITED_NAME;
					$visitLine["VISITED_LASTNAME"] = $VISITED_LASTNAME;
					$visitLine["GROUP_NAME"] = $GROUP_NAME;
					$visitLine["ACTIVITIES"] = $ACTIVITIES;
					
					// $visitLine["ACTIVITIES"] = "lolac";
					
					$visitLine["PROJECTS"] = $PROJECTS;
					$visitLine["PROGRAMS"] = $PROGRAMS;
					$visitLine["GROUP_PREVIR"] = $GROUP_PREVIR;
					$visitLine["GROUP_INSTYPE"] = $GROUP_INSTYPE;
					$visitLine["VISIT_HOOD_NAME"] = $VISIT_HOOD_NAME;
					$visitLine["VISIT_ZONE_NAME"] = $VISIT_ZONE_NAME;
					$visitLine["VISIT_ADDRESS"] = $VISIT_ADDRESS;
					$visitLine["VISIT_CLASS_COORD"] = $VISIT_CLASS_COORD;
					$visitLine["CITIZENS_QTY"] = $CITIZENS_QTY;
					$visitLine["COOPERATOR_IDTYPE"] = $COOPERATOR_IDTYPE;
					$visitLine["COOPERATOR_IDNUM"] = $COOPERATOR_IDNUM;
					$visitLine["COOPERATOR_NAME"] = $COOPERATOR_NAME;
					$visitLine["COOPERATOR_LASTNAME"] = $COOPERATOR_LASTNAME;
					$visitLine["COOPERATOR_PHONE"] = $COOPERATOR_PHONE;
					$visitLine["COOPERATOR_EMAIL"] = $COOPERATOR_EMAIL;
					$visitLine["VISIT_COORD"] = $VISIT_COORD;
					$visitLine["VISIT_DONE"] = $VISIT_DONE;
					$visitLine["VISIT_TYPE"] = $VISIT_TYPE;
					$visitLine["VISIT_ASSISTQTY"] = $VISIT_ASSISTQTY;
					$visitLine["VISIT_NOASSISTQTY"] = $VISIT_NOASSISTQTY;
					$visitLine["VISIT_STONTIME"] = $VISIT_STONTIME;
					$visitLine["VISIT_TOOLS"] = $VISIT_TOOLS;
					$visitLine["VISIT_GOODTIME"] = $VISIT_GOODTIME;
					$visitLine["VISIT_GOODPLACE"] = $VISIT_GOODPLACE;
					$visitLine["VISIT_FORMAT"] = $VISIT_FORMAT;
					$visitLine["VISIT_PDELIVER"] = $VISIT_PDELIVER;
					$visitLine["VISIT_COHERENT"] = $VISIT_COHERENT;
					$visitLine["VISIT_EASY"] = $VISIT_EASY;
					$visitLine["VISIT_ORIENT"] = $VISIT_ORIENT;
					$visitLine["VISIT_EXPRESSION"] = $VISIT_EXPRESSION;
					$visitLine["VISIT_PRESENT"] = $VISIT_PRESENT;
					$visitLine["VISIT_VERIFIED"] = $VISIT_VERIFIED;
					$visitLine["VISIT_ACOMPLISH"] = $VISIT_ACOMPLISH;
					$visitLine["VISIT_SIGNED"] = $VISIT_SIGNED;
					
										
					$visitLine["VISIT_COMMENTS"] = $VISIT_COMMENTS;
					
					array_push($visitLines, $visitLine);
				}
				
				$exported = $this->excelCreate($EXPORT, $visitLines);
				$resp["path"] = $exported;
			}
			
			if($EXPORT == "contracts")
			{
				$contractLines = array();
				
				for($i = 0; $i<count($query);$i++)
				{
					$queryItem = $query[$i];
					
					$CONTRACT_CODE = $queryItem["CONTRACT_CODE"];
					$CONTRACT_CREATED = $queryItem["CONTRACT_CREATED"];
					$CONTRACT_ENTITY = $queryItem["CONTRACT_ENTITY"];
					$CONTRACT_REQTYPE = $queryItem["CONTRACT_REQTYPE"];
					
					$CONTRACT_NUMBER = strval($queryItem["CONTRACT_NUMBER"]);
					
					$CONTRACT_INIDATE = $queryItem["CONTRACT_INIDATE"];
					$CONTRACT_ENDATE = $queryItem["CONTRACT_ENDATE"];
					$CONTRACT_USERTYPE = $queryItem["CONTRACT_USERTYPE"];
					$CONTRACT_ACTIVITIES = $queryItem["CONTRACT_ACTIVITIES"];
					$CONTRACT_ZONES = $queryItem["CONTRACT_ZONES"];
					$CONTRACT_OWNER = $queryItem["CONTRACT_OWNER"];
					$CONTRACT_APROVED_BY = $queryItem["CONTRACT_APROVED_BY"];
					$CONTRACT_OTHER_GOALS = $queryItem["CONTRACT_OTHER_GOALS"];
					$CONTRACT_EVENT_GOALS = $queryItem["CONTRACT_EVENT_GOALS"];
					$CONTRACT_VISIT_GOALS = $queryItem["CONTRACT_VISIT_GOALS"];
					
					$CONTRACT_CANREM = $queryItem["CONTRACT_CANREM"];
					$CONTRACT_CANREM_GET = $queryItem["CONTRACT_CANREM_GET"];
					$CONTRACT_OWNER = $queryItem["CONTRACT_OWNER"];

					// GET ENTITY NAME
					$data = array();
					$data["table"] = "wp_entities";
					$data["fields"] = " ENTITY_NAME ";
					$data["keyField"] = " ENTITY_CODE ";
					$data["code"] = $CONTRACT_ENTITY;
					$ENTITY_DATA = $this->getFriendlyData($data)["message"];
					$ENTITY_NAME = $ENTITY_DATA["ENTITY_NAME"];
					
					if($CONTRACT_ACTIVITIES != "")
					{
						$CONTRACT_ACTIVITIES = json_decode($CONTRACT_ACTIVITIES,true);
					
						$activities = array();
						$projects = array();
						$programs = array();
						
						// GET FRIENDLY NAMES FOT ACTIVITIES AND PARENTS
						for($a = 0; $a<count($CONTRACT_ACTIVITIES);$a++)
						{
							$acti = $CONTRACT_ACTIVITIES[$a];
							
							// GET ACTIVITY DATA
							$data = array();
							$data["table"] = "wp_activities";
							$data["fields"] = " ACTIVITY_NAME, ACTIVITY_PROJECT ";
							$data["keyField"] = " ACTIVITY_CODE ";
							$data["code"] = $acti;
							$CLASS_ACTIVITY_DATA = $this->getFriendlyData($data)["message"];
							
							$ACTIVITY_NAME = $CLASS_ACTIVITY_DATA["ACTIVITY_NAME"];
							
							// ADD IF NOT
							if (!in_array($ACTIVITY_NAME, $activities)){array_push($activities, $ACTIVITY_NAME);}
							
							$ACTIVITY_PROJECT = $CLASS_ACTIVITY_DATA["ACTIVITY_PROJECT"];
							
							// GET PROJECT DATA
							$data = array();
							$data["table"] = "wp_projects";
							$data["fields"] = " PROJECT_NAME, PROJECT_PROGRAM ";
							$data["keyField"] = " PROJECT_CODE ";
							$data["code"] = $ACTIVITY_PROJECT;
							$CLASS_PROJECT_DATA = $this->getFriendlyData($data)["message"];
							$PROJECT_NAME = $CLASS_PROJECT_DATA["PROJECT_NAME"];
							
							// ADD IF NOT
							if (!in_array($PROJECT_NAME, $projects)){array_push($projects, $PROJECT_NAME);}
							
							$PROJECT_PROGRAM = $CLASS_PROJECT_DATA["PROJECT_PROGRAM"];
							
							// GET PROGRAM DATA
							$data = array();
							$data["table"] = "wp_programs";
							$data["fields"] = " PROGRAM_NAME ";
							$data["keyField"] = " PROGRAM_CODE ";
							$data["code"] = $PROJECT_PROGRAM;
							$CLASS_PROGRAM_DATA = $this->getFriendlyData($data)["message"];
							
							$PROGRAM_NAME = $CLASS_PROGRAM_DATA["PROGRAM_NAME"];
							
							// ADD IF NOT
							if (!in_array($PROGRAM_NAME, $programs)){array_push($programs, $PROGRAM_NAME);}
						}
							
						$ACTIVITIES = $this->stringFromArray($activities);
						$PROJECTS = $this->stringFromArray($projects);
						$PROGRAMS = $this->stringFromArray($programs);
						
					}
					else
					{
						$ACTIVITIES = "-";
						$PROJECTS = "-";
						$PROGRAMS = "-";
					}
					
					if($CONTRACT_ZONES != "" and $CONTRACT_ZONES != "[]" and $CONTRACT_ZONES != null and $CONTRACT_ZONES != "null")
					{$CONTRACT_ZONES = json_decode($CONTRACT_ZONES, true);}
					else{$CONTRACT_ZONES = array();}
					$ZONES = "";
					for($z = 0; $z<count($CONTRACT_ZONES);$z++)
					{
						$zone = $CONTRACT_ZONES[$z];
						// GET ZONE DATA
						$data = array();
						$data["table"] = "wp_zones";
						$data["fields"] = " ZONE_NAME ";
						$data["keyField"] = " ZONE_CODE ";
						$data["code"] = $zone;
						$ZONE_DATA = $this->getFriendlyData($data)["message"];
						if($ZONE_DATA != "none")
						{
							$ZONE_NAME = $ZONE_DATA["ZONE_NAME"];
							$ZONES .= $ZONE_NAME;
							if($z < count($CONTRACT_ZONES)-1){$ZONES .= ", ";}
						}
					}
					
					// GET CONTRACT OWNER DATA
					$data = array();
					$data["table"] = "wp_trusers";
					$data["fields"] = " USER_IDTYPE, USER_IDNUM, USER_NAME, USER_LASTNAME, USER_BDAY, USER_PHONE, USER_EMAIL ";
					$data["keyField"] = " USER_CODE ";
					$data["code"] = $CONTRACT_OWNER;
					$CONTRATIST_DATA = $this->getFriendlyData($data)["message"];
					if($CONTRATIST_DATA != "none")
					{
						$GROUP_USER_IDTYPE = $CONTRATIST_DATA["USER_IDTYPE"];
						$GROUP_USER_IDNUM = $CONTRATIST_DATA["USER_IDNUM"];
						$GROUP_USER_NAME = $CONTRATIST_DATA["USER_NAME"];
						$GROUP_USER_LASTNAME = $CONTRATIST_DATA["USER_LASTNAME"];
						$USER_BDAY = $CONTRATIST_DATA["USER_BDAY"];
						$USER_PHONE = $CONTRATIST_DATA["USER_PHONE"];
						$USER_EMAIL = $CONTRATIST_DATA["USER_EMAIL"];
					}
					else
					{
						$GROUP_USER_IDTYPE = "";
						$GROUP_USER_IDNUM = "";
						$GROUP_USER_NAME = "";
						$GROUP_USER_LASTNAME = "";
						$USER_BDAY = "";
						$USER_PHONE = "";
						$USER_EMAIL = "";
					}
					
					// GROUP GOALS
					if($CONTRACT_OTHER_GOALS != "" and $CONTRACT_OTHER_GOALS != null and $CONTRACT_OTHER_GOALS != "null")
					{$CONTRACT_OTHER_GOALS = json_decode($CONTRACT_OTHER_GOALS, true);}
					else{$CONTRACT_OTHER_GOALS = array();}
					$GROUP_QTY = count($CONTRACT_OTHER_GOALS);
					$CLASSGOALS = "";
					$MINUTESGOALS = "";
					$CITIZENSGOALS = "";
					for($g = 0; $g<count($CONTRACT_OTHER_GOALS); $g++)
					{
						$group = $CONTRACT_OTHER_GOALS[$g];
						$addClass = $group["V1"];
						$addMinutes = $group["V2"];
						$addCitizens = $group["V3"];

						$CLASSGOALS .= $addClass;
						$MINUTESGOALS .= $addMinutes;
						$CITIZENSGOALS .= $addCitizens;
						
						if($g < count($CONTRACT_OTHER_GOALS)-1)
						{$CLASSGOALS .= "---";$MINUTESGOALS .= "---";$CITIZENSGOALS .= "---";}
					}
					
					
					// EVENT GOALS
					if($CONTRACT_EVENT_GOALS != "" and $CONTRACT_EVENT_GOALS != null and $CONTRACT_EVENT_GOALS != "null")
					{$CONTRACT_EVENT_GOALS = json_decode($CONTRACT_EVENT_GOALS, true);}
					else{$CONTRACT_EVENT_GOALS = array();}
					$DIRECTEDGOALS = "";
					$SUPORTEDGOALS = "";
					for($g = 0; $g<count($CONTRACT_EVENT_GOALS);$g++)
					{
						$event = $CONTRACT_EVENT_GOALS[$g];
						// GET CONTRACT OWNER DATA
						$data = array();
						$data["table"] = "wp_activities";
						$data["fields"] = " ACTIVITY_NAME ";
						$data["keyField"] = " ACTIVITY_CODE ";
						$data["code"] = $event["ID"];
						$ACTIVITY_DATA = $this->getFriendlyData($data)["message"];
						if($ACTIVITY_DATA != "none")
						{$acti = $ACTIVITY_DATA["ACTIVITY_NAME"];}
						else{$acti = "No name";}
						
						$addDirected = " (".$event["V1"].") ".$acti;
						$addSupported = " (".$event["V2"].") ".$acti;

						$DIRECTEDGOALS .= $addDirected;
						$SUPORTEDGOALS .= $addSupported;
						
						if($g < count($CONTRACT_EVENT_GOALS)-1)
						{$DIRECTEDGOALS .= "---";$SUPORTEDGOALS .= "---";}
					}
					
					// VISIT GOALS
					if($CONTRACT_VISIT_GOALS != "" and $CONTRACT_VISIT_GOALS != null and $CONTRACT_VISIT_GOALS != "null")
					{$CONTRACT_VISIT_GOALS = json_decode($CONTRACT_VISIT_GOALS, true);}
					else{$CONTRACT_VISIT_GOALS = array();}
					
					$VISITEDGOALS = "";
					for($g = 0; $g<count($CONTRACT_VISIT_GOALS);$g++)
					{
						$visit = $CONTRACT_VISIT_GOALS[$g];
						
						if($CONTRACT_USERTYPE == "Cogestor")
						{
							// GET ACTIVITY DATA
							$data = array();
							$data["table"] = "wp_zones";
							$data["fields"] = " ZONE_NAME ";
							$data["keyField"] = " ZONE_CODE ";
							$data["code"] = $visit["ID"];
							
							$ACTIVITY_DATA = $this->getFriendlyData($data)["message"];
							if($ACTIVITY_DATA != "none")
							{$acti = $ACTIVITY_DATA["ZONE_NAME"];}
							else{$acti = "No name";}
						}
						else
						{
							// GET ACTIVITY DATA
							$data = array();
							$data["table"] = "wp_activities";
							$data["fields"] = " ACTIVITY_NAME ";
							$data["keyField"] = " ACTIVITY_CODE ";
							$data["code"] = $visit["ID"];
							
							$ACTIVITY_DATA = $this->getFriendlyData($data)["message"];
							if($ACTIVITY_DATA != "none")
							{$acti = $ACTIVITY_DATA["ACTIVITY_NAME"];}
							else{$acti = "No name";}
						}
						
						
						
						$addVisited = " (".$visit["V1"].") ".$acti;

						$VISITEDGOALS .= $addVisited;
						
						
						if($g < count($CONTRACT_VISIT_GOALS)-1)
						{$VISITEDGOALS .= "---";}

					}
					
					$now = new DateTime();
					$now = $now->format('Y-m-d');
					
					if($CONTRACT_ENDATE >= $now)
					{$CONTRACT_STATE = "Asignado";}
					else
					{$CONTRACT_STATE = "Vencido";}
				
					if($CONTRACT_OWNER == "" or  $CONTRACT_OWNER == null)
					{$CONTRACT_STATE = "Solicitud";}
					
					$CONTRACT_ACTIVE_F = $FILTERS["CONTRACT_ACTIVE_F"];
					
					if($CONTRACT_ACTIVE_F != "")
					{
						if($CONTRACT_ACTIVE_F == "Solicitud" and $CONTRACT_STATE != "Solicitud"){continue;}
						if($CONTRACT_ACTIVE_F == "Asignado" and $CONTRACT_STATE != "Asignado")
						{continue;}
						if($CONTRACT_ACTIVE_F == "Vencido" and $CONTRACT_STATE != "Vencido"){continue;}
					}
					
					$contractLine = array();
					$contractLine["CONTRACT_CREATED"] = $CONTRACT_CREATED;
					$contractLine["ENTITY_NAME"] = $ENTITY_NAME;
					$contractLine["CONTRACT_REQTYPE"] = $CONTRACT_REQTYPE;
					$contractLine["CONTRACT_NUMBER"] = $CONTRACT_NUMBER;
					$contractLine["CONTRACT_INIDATE"] = $CONTRACT_INIDATE;
					$contractLine["CONTRACT_ENDATE"] = $CONTRACT_ENDATE;
					$contractLine["CONTRACT_USERTYPE"] = $CONTRACT_USERTYPE;
					$contractLine["PROGRAMS"] = $PROGRAMS;
					$contractLine["PROJECTS"] = $PROJECTS;
					$contractLine["ACTIVITIES"] = $ACTIVITIES;
					$contractLine["ZONES"] = $ZONES;
					$contractLine["GROUP_USER_IDTYPE"] = $GROUP_USER_IDTYPE;
					$contractLine["GROUP_USER_IDNUM"] = $GROUP_USER_IDNUM;
					$contractLine["GROUP_USER_NAME"] = $GROUP_USER_NAME;
					$contractLine["GROUP_USER_LASTNAME"] = $GROUP_USER_LASTNAME;
					$contractLine["USER_BDAY"] = $USER_BDAY;
					$contractLine["USER_PHONE"] = $USER_PHONE;
					$contractLine["USER_EMAIL"] = $USER_EMAIL;
					$contractLine["CONTRACT_APROVED_BY"] = $CONTRACT_APROVED_BY;
					$contractLine["GROUP_QTY"] = $GROUP_QTY;
					$contractLine["CLASSGOALS"] = $CLASSGOALS;
					$contractLine["MINUTESGOALS"] = $MINUTESGOALS;
					$contractLine["CITIZENSGOALS"] = $CITIZENSGOALS;
					$contractLine["DIRECTEDGOALS"] = $DIRECTEDGOALS;
					$contractLine["SUPORTEDGOALS"] = $SUPORTEDGOALS;
					$contractLine["VISITEDGOALS"] = $VISITEDGOALS;
					$contractLine["CONTRACT_STATE"] = $CONTRACT_STATE;
					$contractLine["CONTRACT_CANREM"] = $CONTRACT_CANREM;
					$contractLine["CONTRACT_CANREM_GET"] = $CONTRACT_CANREM_GET;
						
					array_push($contractLines, $contractLine);

				}
				
				$exported = $this->excelCreate($EXPORT, $contractLines);
				$resp["path"] = $exported;
			}
			
			if($EXPORT == "groups")
			{
				$groupLines = array();
				
				for($i = 0; $i<count($query);$i++)
				{
					$queryItem = $query[$i];
					
					$GROUP_CODE= $queryItem["GROUP_CODE"];
					$GROUP_CREATED = $queryItem["GROUP_CREATED"];
					if($GROUP_CREATED == null or $GROUP_CREATED == ""){$GROUP_CREATED = "2021-03-01 00:00:00";}
					$GROUP_ENTITY = $queryItem["GROUP_ENTITY"];
					$GROUP_NAME = $queryItem["GROUP_NAME"];
					$GROUP_ACTIVITY = $queryItem["GROUP_ACTIVITY"];
					$GROUP_PREVIR = $queryItem["GROUP_PREVIR"];
					$GROUP_INSTYPE = $queryItem["GROUP_INSTYPE"];
					$GROUP_HOOD = $queryItem["GROUP_HOOD"];
					$GROUP_ADDRESS = $queryItem["GROUP_ADDRESS"];
					$GROUP_COORDS = $queryItem["GROUP_COORDS"];
					$GROUP_HOURS = $queryItem["GROUP_HOURS"];
					$GROUP_CITIZENS = $queryItem["GROUP_CITIZENS"];
					$GROUP_COPERATOR = $queryItem["GROUP_COPERATOR"];
					$GROUP_CONTRACT = $queryItem["GROUP_CONTRACT"];
					$GROUP_PROCESS = $queryItem["GROUP_PROCESS"];
					
					// GET CONTRACT DATA
					$data = array();
					$data["table"] = "wp_contracts";
					$data["fields"] = " CONTRACT_OWNER, CONTRACT_NUMBER, CONTRACT_INIDATE, CONTRACT_ENDATE, CONTRACT_USERTYPE, CONTRACT_OTHER_GOALS ";
					$data["keyField"] = " CONTRACT_CODE ";
					$data["code"] = $GROUP_CONTRACT;
					$GROUP_CONTRACT_DATA = $this->getFriendlyData($data)["message"];
					if($GROUP_CONTRACT_DATA != "none")
					{
						$CONTRACT_OWNER = $GROUP_CONTRACT_DATA["CONTRACT_OWNER"];
						$CONTRACT_NUMBER = $GROUP_CONTRACT_DATA["CONTRACT_NUMBER"];
						$CONTRACT_INIDATE = $GROUP_CONTRACT_DATA["CONTRACT_INIDATE"];
						$CONTRACT_ENDATE = $GROUP_CONTRACT_DATA["CONTRACT_ENDATE"];
						$CONTRACT_USERTYPE = $GROUP_CONTRACT_DATA["CONTRACT_USERTYPE"];
						$CONTRACT_OTHER_GOALS = $GROUP_CONTRACT_DATA["CONTRACT_OTHER_GOALS"];
						if($CONTRACT_OTHER_GOALS != "" and $CONTRACT_OTHER_GOALS != null and $CONTRACT_OTHER_GOALS != "null")
						{$CONTRACT_OTHER_GOALS = json_decode($CONTRACT_OTHER_GOALS, true);}
						else{$CONTRACT_OTHER_GOALS = array();}
						$GROUP_GOALS = count($CONTRACT_OTHER_GOALS);
						
						$myGroup = "";
						for($g = 0; $g<count($CONTRACT_OTHER_GOALS);$g++)
						{
							$group = $CONTRACT_OTHER_GOALS[$g];
							if(array_key_exists("V4",$group))
							{if($group["V4"] == $GROUP_CODE){$myGroup = $group;break;}}
						}
						if($myGroup != "")
						{
							$GROUP_CLASS_GOAL = $myGroup["V1"];
							$GROUP_MINUTES_GOAL = $myGroup["V2"];
							$GROUP_PEOPLE_GOAL = $myGroup["V3"];
						}
						else
						{
							$GROUP_CLASS_GOAL = 0;
							$GROUP_MINUTES_GOAL = 0;
							$GROUP_PEOPLE_GOAL = 0;
						}
						
						
						// GET CONTRACT OWNER DATA
						$data = array();
						$data["table"] = "wp_trusers";
						$data["fields"] = " USER_NAME, USER_LASTNAME, USER_IDTYPE, USER_IDNUM ";
						$data["keyField"] = " USER_CODE ";
						$data["code"] = $CONTRACT_OWNER;
						$GROUP_CONTRATIST_DATA = $this->getFriendlyData($data)["message"];
						if($GROUP_CONTRATIST_DATA != "none")
						{
							$GROUP_USER_IDTYPE = $GROUP_CONTRATIST_DATA["USER_IDTYPE"];
							$GROUP_USER_IDNUM = $GROUP_CONTRATIST_DATA["USER_IDNUM"];
							$GROUP_USER_NAME = $GROUP_CONTRATIST_DATA["USER_NAME"];
							$GROUP_USER_LASTNAME = $GROUP_CONTRATIST_DATA["USER_LASTNAME"];
						}
						else
						{
							$GROUP_USER_IDTYPE = "";
							$GROUP_USER_IDNUM = "";
							$GROUP_USER_NAME = "";
							$GROUP_USER_LASTNAME = "";
						}
							
					
					}
					else
					{
						$CONTRACT_NUMBER = "";
						$CONTRACT_INIDATE = "";
						$CONTRACT_ENDATE = "";
						$CONTRACT_USERTYPE = "";
						$CONTRACT_OTHER_GOALS = "";
						$GROUP_GOALS = 0;
						$GROUP_CLASS_GOAL = 0;
						$GROUP_MINUTES_GOAL = 0;
						$GROUP_PEOPLE_GOAL = 0;
						$GROUP_USER_IDTYPE = "";
						$GROUP_USER_IDNUM = "";
						$GROUP_USER_NAME = "";
						$GROUP_USER_LASTNAME = "";
					}

					
					// GET ENTITY NAME
					$data = array();
					$data["table"] = "wp_entities";
					$data["fields"] = " ENTITY_NAME ";
					$data["keyField"] = " ENTITY_CODE ";
					$data["code"] = $GROUP_ENTITY;
					$ENTITY_DATA = $this->getFriendlyData($data)["message"];
					$ENTITY_NAME = $ENTITY_DATA["ENTITY_NAME"];
					
					
					// GET FRIENDLY NAMES FOT ACTIVITY AND PARENTS
					$activities = array();
					$projects = array();
					$programs = array();
					
					$data = array();
					$data["table"] = "wp_activities";
					$data["fields"] = " ACTIVITY_NAME, ACTIVITY_PROJECT ";
					$data["keyField"] = " ACTIVITY_CODE ";
					$data["code"] = $GROUP_ACTIVITY;
					$GROUP_ACTIVITY_DATA = $this->getFriendlyData($data)["message"];
					$ACTIVITY_NAME = $GROUP_ACTIVITY_DATA["ACTIVITY_NAME"];
					// ADD IF NOT
					if (!in_array($ACTIVITY_NAME, $activities)){array_push($activities, $ACTIVITY_NAME);}
					
					$ACTIVITY_PROJECT = $GROUP_ACTIVITY_DATA["ACTIVITY_PROJECT"];
					// GET PROJECT DATA
					$data = array();
					$data["table"] = "wp_projects";
					$data["fields"] = " PROJECT_NAME, PROJECT_PROGRAM ";
					$data["keyField"] = " PROJECT_CODE ";
					$data["code"] = $ACTIVITY_PROJECT;
					$CLASS_PROJECT_DATA = $this->getFriendlyData($data)["message"];
					$PROJECT_NAME = $CLASS_PROJECT_DATA["PROJECT_NAME"];
					// ADD IF NOT
					if (!in_array($PROJECT_NAME, $projects)){array_push($projects, $PROJECT_NAME);}
					
					$PROJECT_PROGRAM = $CLASS_PROJECT_DATA["PROJECT_PROGRAM"];
					// GET PROGRAM DATA
					$data = array();
					$data["table"] = "wp_programs";
					$data["fields"] = " PROGRAM_NAME ";
					$data["keyField"] = " PROGRAM_CODE ";
					$data["code"] = $PROJECT_PROGRAM;
					$CLASS_PROGRAM_DATA = $this->getFriendlyData($data)["message"];
					$PROGRAM_NAME = $CLASS_PROGRAM_DATA["PROGRAM_NAME"];
					// ADD IF NOT
					if (!in_array($PROGRAM_NAME, $programs)){array_push($programs, $PROGRAM_NAME);}
					$ACTIVITIES = $this->stringFromArray($activities);
					$PROJECTS = $this->stringFromArray($projects);
					$PROGRAMS = $this->stringFromArray($programs);
					
					
					
					// GET FRIENDLY HOOD AND ZONE
					$data = array();
					$data["table"] = "wp_hoods";
					$data["fields"] = " HOOD_NAME, HOOD_ZONE ";
					$data["keyField"] = " HOOD_CODE ";
					$data["code"] = $GROUP_HOOD;
					$EVENT_HOOD_DATA = $this->getFriendlyData($data)["message"];
					$EVENT_HOOD = $EVENT_HOOD_DATA["HOOD_NAME"];
					
					
					$data = array();
					$data["table"] = "wp_zones";
					$data["fields"] = " ZONE_NAME";
					$data["keyField"] = " ZONE_CODE ";
					$data["code"] = $EVENT_HOOD_DATA["HOOD_ZONE"];
					$EVENT_ZONE_DATA = $this->getFriendlyData($data)["message"];
					$EVENT_ZONE = $EVENT_ZONE_DATA["ZONE_NAME"];
					
					// FRIENDLY HOURS
					if($GROUP_HOURS != "" and $GROUP_HOURS != null and $GROUP_HOURS != "null")
					{
						$GROUP_HOURS = json_decode($GROUP_HOURS, true);
						$hours = "";
						for($h = 0; $h<count($GROUP_HOURS);$h++)
						{
							$hour = $GROUP_HOURS[$h]["GROUP_TIME_DAY"].": ".$GROUP_HOURS[$h]["GROUP_TIME_INI"]." - ".$GROUP_HOURS[$h]["GROUP_TIME_END"];
							if($h<count($GROUP_HOURS)-1){$hour .=", ";}
							$hours .= $hour;
						}
						$GROUP_HOURS = $hours;
					}

					
					
					
					// GET CITIZENS 
					$GROUP_CITIZENS = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($GROUP_CITIZENS));
					if($GROUP_CITIZENS != "" and $GROUP_CITIZENS != null and $GROUP_CITIZENS != "null")
					{$GROUP_CITIZENS = json_decode($GROUP_CITIZENS, true);}
					else{$GROUP_CITIZENS = array();}
					$CITIZEN_QTY = count($GROUP_CITIZENS);
					
					
					// GET COOPERATOR DATA
					$COOPERATOR_IDNUM = explode("-", $GROUP_COPERATOR)[0];
					$data = array();
					$data["table"] = "wp_citizens";
					$data["fields"] = " CITIZEN_IDTYPE, CITIZEN_NAME, CITIZEN_LASTNAME, CITIZEN_PHONE, CITIZEN_EMAIL  ";
					$data["keyField"] = " CITIZEN_IDNUM ";
					$data["code"] = $COOPERATOR_IDNUM;
					$GROUP_COOPERATOR_DATA = $this->getFriendlyData($data)["message"];
					if($GROUP_COOPERATOR_DATA != "none")
					{
						$COOPERATOR_IDTYPE = $GROUP_COOPERATOR_DATA["CITIZEN_IDTYPE"];
						$COOPERATOR_NAME = $GROUP_COOPERATOR_DATA["CITIZEN_NAME"];
						$COOPERATOR_LASTNAME = $GROUP_COOPERATOR_DATA["CITIZEN_LASTNAME"];
						$COOPERATOR_PHONE = $GROUP_COOPERATOR_DATA["CITIZEN_PHONE"];
						$COOPERATOR_EMAIL = $GROUP_COOPERATOR_DATA["CITIZEN_EMAIL"];
					}
					else
					{
						$COOPERATOR_IDTYPE = "";
						$COOPERATOR_NAME = "";
						$COOPERATOR_LASTNAME = "";
						$COOPERATOR_PHONE = "";
						$COOPERATOR_EMAIL = "";
					}
					
					
					// GET GROUP ASSIST LIST
					$queryItem["GROUP_CITIZENS"] = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($queryItem["GROUP_CITIZENS"] ));
					if($queryItem["GROUP_CITIZENS"] != "" and $queryItem["GROUP_CITIZENS"] != null and $queryItem["GROUP_CITIZENS"] != "null")
					{$GROUP_CITIZENS = json_decode($queryItem["GROUP_CITIZENS"], true);}
					else{$GROUP_CITIZENS = array();}
					
					$now = new DateTime();
					$now = $now->format('Y-m-d');
					
					if(count($GROUP_CITIZENS) > 0)
					{
						for($c = 0; $c<count($GROUP_CITIZENS);$c++)
						{
							$CITIZEN = $GROUP_CITIZENS[$c];
							
							$CITIZEN_IDTYPE = $CITIZEN["CITIZEN_IDTYPE"];
							$CITIZEN_IDNUM = $CITIZEN["CITIZEN_IDNUM"];
							
							
							
							
							
							
							
							
							
							if(isset($CITIZEN["CITIZEN_SAVED"]))
							{$CITIZEN_SAVED = $CITIZEN["CITIZEN_SAVED"];}
							else{$CITIZEN_SAVED = "-";}
							
							// GET CITIZEN DATA
							$data = array();
							$data["table"] = "wp_citizens";
							$data["fields"] = " CITIZEN_IDNUM, CITIZEN_NAME, CITIZEN_LASTNAME, CITIZEN_GENDER, CITIZEN_ADDRESS, CITIZEN_PHONE, CITIZEN_EMAIL, CITIZEN_ETNIA, CITIZEN_CONDITION, CITIZEN_HOOD, CITIZEN_ZONE, CITIZEN_LEVEL, CITIZEN_ETNIA_IND, CITIZEN_ORIGIN_COUNTRY, CITIZEN_DESTINY_COUNTRY, CITIZEN_STAY_REASON, CITIZEN_MIGREXP,  CITIZEN_INDATE, CITIZEN_OUTDATE, CITIZEN_RETURN_REASON, CITIZEN_SITAC, CITIZEN_ACUDIENT, CITIZEN_BIRTH_CITY, CITIZEN_SISCORE, CITIZEN_CONVAC, CITIZEN_TIPOCO, CITIZEN_TIPOVI, CITIZEN_HANDICAP, CITIZEN_ETGROUP, CITIZEN_SECURITY, CITIZEN_EPS, CITIZEN_PATOEN, CITIZEN_TRASDES, CITIZEN_RISKFA, CITIZEN_PREVFA, CITIZEN_WEIGHT, CITIZEN_HEIGHT, CITIZEN_IMC, CITIZEN_IMC_RATE, CITIZEN_EDLEVEL, CITIZEN_INSTITUTE, CITIZEN_COURSES, CITIZEN_OCUCOND, CITIZEN_INGREC, CITIZEN_BDAY ";
							
							
							$data["keyField"] = " CITIZEN_IDNUM ";
							$data["code"] = $CITIZEN_IDNUM;
							$CITIZEN_DATA = $this->getFriendlyData($data)["message"];
							
							// SET CITIZEN DATA FROM NEW OR SAVED
							if($CITIZEN_DATA == "none"){continue;}
							else
							{
							
								// GET CITIZEN BDAY FROM CITIZEN DIRECTLY
								$CITIZEN_BDAY = $CITIZEN_DATA["CITIZEN_BDAY"];
								// GET AGE
								$d1 = $CITIZEN_BDAY;
								$d2 = $now;
								$diff = abs(strtotime($d1) - strtotime($d2));
								$age = floor($diff / (365*60*60*24));
								$CITIZEN_AGE = $age;
								
								$CITIZEN_NAME = $CITIZEN_DATA["CITIZEN_NAME"];
								$CITIZEN_LASTNAME = $CITIZEN_DATA["CITIZEN_LASTNAME"];
								$CITIZEN_GENDER = $CITIZEN_DATA["CITIZEN_GENDER"];
								$CITIZEN_ADDRESS = $CITIZEN_DATA["CITIZEN_ADDRESS"];
								$CITIZEN_EMAIL = $CITIZEN_DATA["CITIZEN_EMAIL"];
								$CITIZEN_PHONE = $CITIZEN_DATA["CITIZEN_PHONE"];
								$CITIZEN_ETNIA = $CITIZEN_DATA["CITIZEN_ETNIA"];
								$CITIZEN_CONDITION = json_decode($CITIZEN_DATA["CITIZEN_CONDITION"], true);
								$CITIZEN_HOOD = $CITIZEN_DATA["CITIZEN_HOOD"];
								$CITIZEN_ZONE = $CITIZEN_DATA["CITIZEN_ZONE"];
								$CITIZEN_LEVEL = $CITIZEN_DATA["CITIZEN_LEVEL"];
								// ------***------
								$CITIZEN_ETNIA_IND = $CITIZEN_DATA["CITIZEN_ETNIA_IND"];
								$CITIZEN_ORIGIN_COUNTRY = $CITIZEN_DATA["CITIZEN_ORIGIN_COUNTRY"];
								$CITIZEN_DESTINY_COUNTRY = $CITIZEN_DATA["CITIZEN_DESTINY_COUNTRY"];
								$CITIZEN_STAY_REASON = $CITIZEN_DATA["CITIZEN_STAY_REASON"];
								$CITIZEN_MIGREXP = $CITIZEN_DATA["CITIZEN_MIGREXP"];
								$CITIZEN_INDATE = $CITIZEN_DATA["CITIZEN_INDATE"];
								$CITIZEN_OUTDATE = $CITIZEN_DATA["CITIZEN_OUTDATE"];
								$CITIZEN_RETURN_REASON = $CITIZEN_DATA["CITIZEN_RETURN_REASON"];
								$CITIZEN_SITAC = $CITIZEN_DATA["CITIZEN_SITAC"];
								$CITIZEN_ACUDIENT = $CITIZEN_DATA["CITIZEN_ACUDIENT"];
								$CITIZEN_BIRTH_CITY = $CITIZEN_DATA["CITIZEN_BIRTH_CITY"];
								$CITIZEN_SISCORE = $CITIZEN_DATA["CITIZEN_SISCORE"];
								$CITIZEN_CONVAC = $CITIZEN_DATA["CITIZEN_CONVAC"];
								$CITIZEN_TIPOCO = $CITIZEN_DATA["CITIZEN_TIPOCO"];
								$CITIZEN_TIPOVI = $CITIZEN_DATA["CITIZEN_TIPOVI"];
								$CITIZEN_HANDICAP = $CITIZEN_DATA["CITIZEN_HANDICAP"];
								$CITIZEN_ETGROUP = $CITIZEN_DATA["CITIZEN_ETGROUP"];
								$CITIZEN_SECURITY = $CITIZEN_DATA["CITIZEN_SECURITY"];
								$CITIZEN_EPS = $CITIZEN_DATA["CITIZEN_EPS"];
								$CITIZEN_PATOEN = $CITIZEN_DATA["CITIZEN_PATOEN"];
								$CITIZEN_TRASDES = $CITIZEN_DATA["CITIZEN_TRASDES"];
								if($CITIZEN_DATA["CITIZEN_RISKFA"] != null and $CITIZEN_DATA["CITIZEN_RISKFA"] != "")
								{$CITIZEN_RISKFA = json_decode($CITIZEN_DATA["CITIZEN_RISKFA"], true);}
								else{$CITIZEN_RISKFA = array();}
								
								
								if($CITIZEN_DATA["CITIZEN_PREVFA"] != null and $CITIZEN_DATA["CITIZEN_PREVFA"] != "")
								{$CITIZEN_PREVFA = json_decode($CITIZEN_DATA["CITIZEN_PREVFA"], true);}
								else{$CITIZEN_PREVFA = array();}
								
								
								$CITIZEN_WEIGHT = $CITIZEN_DATA["CITIZEN_WEIGHT"];
								$CITIZEN_HEIGHT = $CITIZEN_DATA["CITIZEN_HEIGHT"];
								$CITIZEN_IMC = $CITIZEN_DATA["CITIZEN_IMC"];
								$CITIZEN_IMC_RATE = $CITIZEN_DATA["CITIZEN_IMC_RATE"];
								$CITIZEN_EDLEVEL = $CITIZEN_DATA["CITIZEN_EDLEVEL"];
								$CITIZEN_INSTITUTE = $CITIZEN_DATA["CITIZEN_INSTITUTE"];
								$CITIZEN_COURSES = $CITIZEN_DATA["CITIZEN_COURSES"];
								$CITIZEN_OCUCOND = $CITIZEN_DATA["CITIZEN_OCUCOND"];
								$CITIZEN_INGREC = $CITIZEN_DATA["CITIZEN_INGREC"];
								
							}
								
							// GET ETNIA DATA
							$data = array();
							$data["table"] = "wp_etnias";
							$data["fields"] = " ETNIA_NAME ";
							$data["keyField"] = " ETNIA_CODE ";
							$data["code"] = $CITIZEN_ETNIA;
							$ETNIA_DATA = $this->getFriendlyData($data)["message"];
							$CITIZEN_ETNIA = $ETNIA_DATA["ETNIA_NAME"];

							$CITIZEN_DATA["CITIZEN_ETNIA"] = $CITIZEN_ETNIA;
							
							// GET HOOD DATA
							$data = array();
							$data["table"] = "wp_hoods";
							$data["fields"] = " HOOD_NAME ";
							$data["keyField"] = " HOOD_CODE ";
							$data["code"] = $CITIZEN_HOOD;
							$HOOD_DATA = $this->getFriendlyData($data)["message"];
							if($HOOD_DATA != "none")
							{$CITIZEN_HOOD = $HOOD_DATA["HOOD_NAME"];}
							else{$CITIZEN_HOOD = "-";}
								
							$CITIZEN_DATA["CITIZEN_HOOD"] = $CITIZEN_HOOD;
							
							// GET ZONE DATA
							$data = array();
							$data["table"] = "wp_zones";
							$data["fields"] = " ZONE_NAME ";
							$data["keyField"] = " ZONE_CODE ";
							$data["code"] = $CITIZEN_ZONE;
							$ZONE_DATA = $this->getFriendlyData($data)["message"];
							if($ZONE_DATA != "none")
							{$CITIZEN_ZONE = $ZONE_DATA["ZONE_NAME"];}
							else{$CITIZEN_ZONE = "-";}
							
							$CITIZEN_DATA["CITIZEN_ZONE"] = $CITIZEN_ZONE;
								
								
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
							
							$CITIZEN_DATA["CITIZEN_CONDITION"] = $CITIZEN_CONDITION;
							
							// NEW FIELDS ADD
							// NEW FIELDS ADD
							// NEW FIELDS ADD
							// NEW FIELDS ADD
								
								
							$CITIZEN_ETNIA_IND = $CITIZEN_DATA["CITIZEN_ETNIA_IND"];
							$data = array();
							$data["table"] = "wp_master_tipoin";
							$data["fields"] = " TIPOIN_NAME ";
							$data["keyField"] = " TIPOIN_CODE ";
							$data["code"] = $CITIZEN_ETNIA_IND;
							$REG_DATA = $this->getFriendlyData($data)["message"];
							if($REG_DATA != "none")
							{$CITIZEN_ETNIA_IND = $REG_DATA["TIPOIN_NAME"];}
							else{$CITIZEN_ETNIA_IND = "-";}
							
							$CITIZEN_ORIGIN_COUNTRY = $CITIZEN_DATA["CITIZEN_ORIGIN_COUNTRY"];
							$CITIZEN_DESTINY_COUNTRY = $CITIZEN_DATA["CITIZEN_DESTINY_COUNTRY"];
							
							$CITIZEN_STAY_REASON = $CITIZEN_DATA["CITIZEN_STAY_REASON"];
							$data = array();
							$data["table"] = "wp_master_migrea";
							$data["fields"] = " MIGREA_NAME ";
							$data["keyField"] = " MIGREA_CODE ";
							$data["code"] = $CITIZEN_STAY_REASON;
							$REG_DATA = $this->getFriendlyData($data)["message"];
							if($REG_DATA != "none")
							{$CITIZEN_STAY_REASON = $REG_DATA["MIGREA_NAME"];}
							else{$CITIZEN_STAY_REASON = "-";}
							
							$CITIZEN_MIGREXP = $CITIZEN_DATA["CITIZEN_MIGREXP"];
							$CITIZEN_INDATE = $CITIZEN_DATA["CITIZEN_INDATE"];
							$CITIZEN_OUTDATE = $CITIZEN_DATA["CITIZEN_OUTDATE"];
							$CITIZEN_RETURN_REASON = $CITIZEN_DATA["CITIZEN_RETURN_REASON"];
							$CITIZEN_SITAC = $CITIZEN_DATA["CITIZEN_SITAC"];
							$CITIZEN_ACUDIENT = $CITIZEN_DATA["CITIZEN_ACUDIENT"];
							$CITIZEN_BIRTH_CITY = $CITIZEN_DATA["CITIZEN_BIRTH_CITY"];
							$CITIZEN_SISCORE = $CITIZEN_DATA["CITIZEN_SISCORE"];
							
							$CITIZEN_CONVAC = $CITIZEN_DATA["CITIZEN_CONVAC"];
							$data = array();
							$data["table"] = "wp_master_convac";
							$data["fields"] = " CONVAC_NAME ";
							$data["keyField"] = " CONVAC_CODE ";
							$data["code"] = $CITIZEN_CONVAC;
							$REG_DATA = $this->getFriendlyData($data)["message"];
							if($REG_DATA != "none")
							{$CITIZEN_CONVAC = $REG_DATA["CONVAC_NAME"];}
							else{$CITIZEN_CONVAC = "-";}
								
								
							$CITIZEN_TIPOCO = $CITIZEN_DATA["CITIZEN_TIPOCO"];
							$data = array();
							$data["table"] = "wp_master_tipoco";
							$data["fields"] = " TIPOCO_NAME ";
							$data["keyField"] = " TIPOCO_CODE ";
							$data["code"] = $CITIZEN_TIPOCO;
							$REG_DATA = $this->getFriendlyData($data)["message"];
							if($REG_DATA != "none")
							{$CITIZEN_TIPOCO = $REG_DATA["TIPOCO_NAME"];}
							else{$CITIZEN_TIPOCO = "-";}
							
						
							$CITIZEN_TIPOVI = $CITIZEN_DATA["CITIZEN_TIPOVI"];
							$data = array();
							$data["table"] = "wp_master_tipovi";
							$data["fields"] = " TIPOVI_NAME ";
							$data["keyField"] = " TIPOVI_CODE ";
							$data["code"] = $CITIZEN_TIPOVI;
							$REG_DATA = $this->getFriendlyData($data)["message"];
							if($REG_DATA != "none")
							{$CITIZEN_TIPOVI = $REG_DATA["TIPOVI_NAME"];}
							else{$CITIZEN_TIPOVI = "-";}
							
							
							$CITIZEN_HANDICAP = $CITIZEN_DATA["CITIZEN_HANDICAP"];
							$CITIZEN_ETGROUP = $CITIZEN_DATA["CITIZEN_ETGROUP"];
							$CITIZEN_SECURITY = $CITIZEN_DATA["CITIZEN_SECURITY"];
							
							
							
							$CITIZEN_EPS = $CITIZEN_DATA["CITIZEN_EPS"];
							$data = array();
							$data["table"] = "wp_master_eps";
							$data["fields"] = " EPS_NAME ";
							$data["keyField"] = " EPS_CODE ";
							$data["code"] = $CITIZEN_EPS;
							$REG_DATA = $this->getFriendlyData($data)["message"];
							if($REG_DATA != "none")
							{$CITIZEN_EPS = $REG_DATA["EPS_NAME"];}
							else{$CITIZEN_EPS = "-";}
							
							
							$CITIZEN_PATOEN = $CITIZEN_DATA["CITIZEN_PATOEN"];
							$data = array();
							$data["table"] = "wp_master_patoen";
							$data["fields"] = " PATOEN_NAME ";
							$data["keyField"] = " PATOEN_CODE ";
							$data["code"] = $CITIZEN_PATOEN;
							$REG_DATA = $this->getFriendlyData($data)["message"];
							if($REG_DATA != "none")
							{$CITIZEN_PATOEN = $REG_DATA["PATOEN_NAME"];}
							else{$CITIZEN_PATOEN = "-";}
								
								
							$CITIZEN_TRASDES = $CITIZEN_DATA["CITIZEN_TRASDES"];
							$data = array();
							$data["table"] = "wp_master_trasdes";
							$data["fields"] = " TRASDES_NAME ";
							$data["keyField"] = " TRASDES_CODE ";
							$data["code"] = $CITIZEN_TRASDES;
							$REG_DATA = $this->getFriendlyData($data)["message"];
							if($REG_DATA != "none")
							{$CITIZEN_TRASDES = $REG_DATA["TRASDES_NAME"];}
							else{$CITIZEN_TRASDES = "-";}
							
							$friendlyLine = "";
							for($n = 0; $n<count($CITIZEN_RISKFA);$n++)
							{
								$itemCode = $CITIZEN_RISKFA[$n];
								$data = array();
								$data["table"] = "wp_master_riskfa";
								$data["fields"] = " RISKFA_NAME ";
								$data["keyField"] = " RISKFA_CODE ";
								$data["code"] = $itemCode;
								$REG_DATA = $this->getFriendlyData($data)["message"];
								$RISKFA_NAME = $REG_DATA["RISKFA_NAME"];
								if($n < count($CITIZEN_RISKFA)-1)
								{$friendlyLine .= $RISKFA_NAME;	$friendlyLine .= ", ";}
								else{$friendlyLine .= $RISKFA_NAME;}
							}
							$CITIZEN_RISKFA = $friendlyLine;
							
							
							$friendlyLine = "";
							for($n = 0; $n<count($CITIZEN_PREVFA);$n++)
							{
								$itemCode = $CITIZEN_PREVFA[$n];
								$data = array();
								$data["table"] = "wp_master_prevfa";
								$data["fields"] = " PREVFA_NAME ";
								$data["keyField"] = " PREVFA_CODE ";
								$data["code"] = $itemCode;
								$REG_DATA = $this->getFriendlyData($data)["message"];
								$PREVFA = $REG_DATA["PREVFA_NAME"];
								if($n < count($CITIZEN_PREVFA)-1)
								{$friendlyLine .= $PREVFA;	$friendlyLine .= ", ";}
								else{$friendlyLine .= $PREVFA;}
							}
							$CITIZEN_PREVFA = $friendlyLine;
			
							$CITIZEN_WEIGHT = $CITIZEN_DATA["CITIZEN_WEIGHT"];
							$CITIZEN_HEIGHT = $CITIZEN_DATA["CITIZEN_HEIGHT"];
							$CITIZEN_IMC = $CITIZEN_DATA["CITIZEN_IMC"];
							$CITIZEN_IMC_RATE = $CITIZEN_DATA["CITIZEN_IMC_RATE"];

							$CITIZEN_EDLEVEL = $CITIZEN_DATA["CITIZEN_EDLEVEL"];
							$data = array();
							$data["table"] = "wp_master_edlevel";
							$data["fields"] = " EDLEVEL_NAME ";
							$data["keyField"] = " EDLEVEL_CODE ";
							$data["code"] = $CITIZEN_EDLEVEL;
							$REG_DATA = $this->getFriendlyData($data)["message"];
							if($REG_DATA != "none")
							{$CITIZEN_EDLEVEL = $REG_DATA["EDLEVEL_NAME"];}
							else{$CITIZEN_EDLEVEL = "-";}
													
							
							$CITIZEN_INSTITUTE = $CITIZEN_DATA["CITIZEN_INSTITUTE"];
							$data = array();
							$data["table"] = "wp_institutes";
							$data["fields"] = " INSTITUTE_NAME ";
							$data["keyField"] = " INSTITUTE_CODE ";
							$data["code"] = $CITIZEN_INSTITUTE;
							$REG_DATA = $this->getFriendlyData($data)["message"];
							if($REG_DATA != "none")
							{$CITIZEN_INSTITUTE = $REG_DATA["INSTITUTE_NAME"];}
							else{$CITIZEN_INSTITUTE = "-";}
							
							
							$CITIZEN_COURSES = $CITIZEN_DATA["CITIZEN_COURSES"];
							$data = array();
							$data["table"] = "wp_master_courses";
							$data["fields"] = " COURSES_NAME ";
							$data["keyField"] = " COURSES_CODE ";
							$data["code"] = $CITIZEN_COURSES;
							$REG_DATA = $this->getFriendlyData($data)["message"];
							if($REG_DATA != "none")
							{$CITIZEN_COURSES = $REG_DATA["COURSES_NAME"];}
							else{$CITIZEN_COURSES = "-";}
								
								
							$CITIZEN_OCUCOND = $CITIZEN_DATA["CITIZEN_OCUCOND"];
							$data = array();
							$data["table"] = "wp_master_ocucond";
							$data["fields"] = " OCUCOND_NAME ";
							$data["keyField"] = " OCUCOND_CODE ";
							$data["code"] = $CITIZEN_OCUCOND;
							$REG_DATA = $this->getFriendlyData($data)["message"];
							if($REG_DATA != "none")
							{$CITIZEN_OCUCOND = $REG_DATA["OCUCOND_NAME"];}
							else{$CITIZEN_OCUCOND = "-";}
							
							
							$CITIZEN_INGREC = $CITIZEN_DATA["CITIZEN_INGREC"];
							$data = array();
							$data["table"] = "wp_master_ingrec";
							$data["fields"] = " INGREC_NAME ";
							$data["keyField"] = " INGREC_CODE ";
							$data["code"] = $CITIZEN_INGREC;
							$REG_DATA = $this->getFriendlyData($data)["message"];
							if($REG_DATA != "none")
							{$CITIZEN_INGREC = $REG_DATA["INGREC_NAME"];}
							else{$CITIZEN_INGREC = "-";}
							
							$CITIZEN_GOAL = "" ;// TEMP
							$groupLine = array();
							$groupLine["GROUP_CREATED"] = $GROUP_CREATED;
							$groupLine["ENTITY_NAME"] = $ENTITY_NAME;
							$groupLine["GROUP_NAME"] = $GROUP_NAME;
							$groupLine["ACTIVITIES"] = $ACTIVITIES;
							$groupLine["PROJECTS"] = $PROJECTS;
							$groupLine["PROGRAMS"] = $PROGRAMS;
							$groupLine["GROUP_PREVIR"] = $GROUP_PREVIR;
							$groupLine["GROUP_INSTYPE"] = $GROUP_INSTYPE;
							$groupLine["EVENT_HOOD"] = $EVENT_HOOD;
							$groupLine["EVENT_ZONE"] = $EVENT_ZONE;
							$groupLine["GROUP_ADDRESS"] = $GROUP_ADDRESS;
							$groupLine["GROUP_COORDS"] = $GROUP_COORDS;
							$groupLine["GROUP_HOURS"] = $GROUP_HOURS;
							$groupLine["CITIZEN_QTY"] = $CITIZEN_QTY;
							$groupLine["COOPERATOR_IDTYPE"] = $COOPERATOR_IDTYPE;
							$groupLine["COOPERATOR_IDNUM"] = $COOPERATOR_IDNUM;
							$groupLine["COOPERATOR_NAME"] = $COOPERATOR_NAME;
							$groupLine["COOPERATOR_LASTNAME"] = $COOPERATOR_LASTNAME;
							$groupLine["COOPERATOR_PHONE"] = $COOPERATOR_PHONE;
							$groupLine["COOPERATOR_EMAIL"] = $COOPERATOR_EMAIL;
							$groupLine["CONTRACT_NUMBER"] = $CONTRACT_NUMBER;
							$groupLine["CONTRACT_INIDATE"] = $CONTRACT_INIDATE;
							$groupLine["CONTRACT_ENDATE"] = $CONTRACT_ENDATE;
							$groupLine["CONTRACT_USERTYPE"] = $CONTRACT_USERTYPE;
							$groupLine["GROUP_USER_IDTYPE"] = $GROUP_USER_IDTYPE;
							$groupLine["GROUP_USER_IDNUM"] = $GROUP_USER_IDNUM;
							$groupLine["GROUP_USER_NAME"] = $GROUP_USER_NAME;
							$groupLine["GROUP_USER_LASTNAME"] = $GROUP_USER_LASTNAME;
							$groupLine["GROUP_GOALS"] = $GROUP_GOALS;
							$groupLine["GROUP_CLASS_GOAL"] = $GROUP_CLASS_GOAL;
							$groupLine["GROUP_MINUTES_GOAL"] = $GROUP_MINUTES_GOAL;
							$groupLine["GROUP_PEOPLE_GOAL"] = $GROUP_PEOPLE_GOAL;
							$groupLine["CITIZEN_GOAL"] = $CITIZEN_GOAL;
							$groupLine["GROUP_PROCESS"] = $GROUP_PROCESS;
							
							// -----***---- CITIZEN DATA
							
							$groupLine["CITIZEN_IDTYPE"] = $CITIZEN_IDTYPE;
							$groupLine["CITIZEN_IDNUM"] = $CITIZEN_IDNUM;
							$groupLine["CITIZEN_NAME"] = $CITIZEN_NAME;
							$groupLine["CITIZEN_LASTNAME"] = $CITIZEN_LASTNAME;
							$groupLine["CITIZEN_GENDER"] = $CITIZEN_GENDER;
							$groupLine["CITIZEN_BDAY"] = $CITIZEN_BDAY;
							$groupLine["CITIZEN_AGE"] = $CITIZEN_AGE;
							$groupLine["CITIZEN_ADDRESS"] = $CITIZEN_ADDRESS;
							$groupLine["CITIZEN_EMAIL"] = $CITIZEN_EMAIL;
							$groupLine["CITIZEN_PHONE"] = $CITIZEN_PHONE;
							$groupLine["CITIZEN_ETNIA"] = $CITIZEN_ETNIA;
							$groupLine["CITIZEN_CONDITION"] = $CITIZEN_CONDITION;
							$groupLine["CITIZEN_HOOD"] = $CITIZEN_HOOD;
							$groupLine["CITIZEN_ZONE"] = $CITIZEN_ZONE;
							$groupLine["CITIZEN_LEVEL"] = $CITIZEN_LEVEL;
							$groupLine["CITIZEN_SAVED"] = $CITIZEN_SAVED;
							$groupLine["CITIZEN_ETNIA_IND"] = $CITIZEN_ETNIA_IND;
							$groupLine["CITIZEN_ORIGIN_COUNTRY"] = $CITIZEN_ORIGIN_COUNTRY;
							$groupLine["CITIZEN_DESTINY_COUNTRY"] = $CITIZEN_DESTINY_COUNTRY;
							$groupLine["CITIZEN_STAY_REASON"] = $CITIZEN_STAY_REASON;
							$groupLine["CITIZEN_MIGREXP"] = $CITIZEN_MIGREXP;
							$groupLine["CITIZEN_INDATE"] = $CITIZEN_INDATE;
							$groupLine["CITIZEN_OUTDATE"] = $CITIZEN_OUTDATE;
							$groupLine["CITIZEN_RETURN_REASON"] = $CITIZEN_RETURN_REASON;
							$groupLine["CITIZEN_SITAC"] = $CITIZEN_SITAC;
							$groupLine["CITIZEN_ACUDIENT"] = $CITIZEN_ACUDIENT;
							$groupLine["CITIZEN_BIRTH_CITY"] = $CITIZEN_BIRTH_CITY;
							$groupLine["CITIZEN_SISCORE"] = $CITIZEN_SISCORE;
							$groupLine["CITIZEN_CONVAC"] = $CITIZEN_CONVAC;
							$groupLine["CITIZEN_TIPOCO"] = $CITIZEN_TIPOCO;
							$groupLine["CITIZEN_TIPOVI"] = $CITIZEN_TIPOVI;
							$groupLine["CITIZEN_HANDICAP"] = $CITIZEN_HANDICAP;
							$groupLine["CITIZEN_ETGROUP"] = $CITIZEN_ETGROUP;
							$groupLine["CITIZEN_SECURITY"] = $CITIZEN_SECURITY;
							$groupLine["CITIZEN_EPS"] = $CITIZEN_EPS;
							$groupLine["CITIZEN_PATOEN"] = $CITIZEN_PATOEN;
							$groupLine["CITIZEN_TRASDES"] = $CITIZEN_TRASDES;
							$groupLine["CITIZEN_RISKFA"] = $CITIZEN_RISKFA;
							$groupLine["CITIZEN_PREVFA"] = $CITIZEN_PREVFA;
							$groupLine["CITIZEN_WEIGHT"] = $CITIZEN_WEIGHT;
							$groupLine["CITIZEN_HEIGHT"] = $CITIZEN_HEIGHT;
							$groupLine["CITIZEN_IMC"] = $CITIZEN_IMC;
							$groupLine["CITIZEN_IMC_RATE"] = $CITIZEN_IMC_RATE;
							$groupLine["CITIZEN_EDLEVEL"] = $CITIZEN_EDLEVEL;
							$groupLine["CITIZEN_INSTITUTE"] = $CITIZEN_INSTITUTE;
							$groupLine["CITIZEN_COURSES"] = $CITIZEN_COURSES;
							$groupLine["CITIZEN_OCUCOND"] = $CITIZEN_OCUCOND;
							$groupLine["CITIZEN_INGREC"] = $CITIZEN_INGREC;
							
							
							array_push($groupLines, $groupLine);
						}
					
					}
					else
					{
						$CITIZEN_GOAL = "" ;// TEMP
						$groupLine = array();
						$groupLine["GROUP_CREATED"] = $GROUP_CREATED;
						$groupLine["ENTITY_NAME"] = $ENTITY_NAME;
						$groupLine["GROUP_NAME"] = $GROUP_NAME;
						$groupLine["ACTIVITIES"] = $ACTIVITIES;
						$groupLine["PROJECTS"] = $PROJECTS;
						$groupLine["PROGRAMS"] = $PROGRAMS;
						$groupLine["GROUP_PREVIR"] = $GROUP_PREVIR;
						$groupLine["GROUP_INSTYPE"] = $GROUP_INSTYPE;
						$groupLine["EVENT_HOOD"] = $EVENT_HOOD;
						$groupLine["EVENT_ZONE"] = $EVENT_ZONE;
						$groupLine["GROUP_ADDRESS"] = $GROUP_ADDRESS;
						$groupLine["GROUP_COORDS"] = $GROUP_COORDS;
						$groupLine["GROUP_HOURS"] = $GROUP_HOURS;
						$groupLine["CITIZEN_QTY"] = $CITIZEN_QTY;
						$groupLine["COOPERATOR_IDTYPE"] = $COOPERATOR_IDTYPE;
						$groupLine["COOPERATOR_IDNUM"] = $COOPERATOR_IDNUM;
						$groupLine["COOPERATOR_NAME"] = $COOPERATOR_NAME;
						$groupLine["COOPERATOR_LASTNAME"] = $COOPERATOR_LASTNAME;
						$groupLine["COOPERATOR_PHONE"] = $COOPERATOR_PHONE;
						$groupLine["COOPERATOR_EMAIL"] = $COOPERATOR_EMAIL;
						$groupLine["CONTRACT_NUMBER"] = $CONTRACT_NUMBER;
						$groupLine["CONTRACT_INIDATE"] = $CONTRACT_INIDATE;
						$groupLine["CONTRACT_ENDATE"] = $CONTRACT_ENDATE;
						$groupLine["CONTRACT_USERTYPE"] = $CONTRACT_USERTYPE;
						$groupLine["GROUP_USER_IDTYPE"] = $GROUP_USER_IDTYPE;
						$groupLine["GROUP_USER_IDNUM"] = $GROUP_USER_IDNUM;
						$groupLine["GROUP_USER_NAME"] = $GROUP_USER_NAME;
						$groupLine["GROUP_USER_LASTNAME"] = $GROUP_USER_LASTNAME;
						$groupLine["GROUP_GOALS"] = $GROUP_GOALS;
						$groupLine["GROUP_CLASS_GOAL"] = $GROUP_CLASS_GOAL;
						$groupLine["GROUP_MINUTES_GOAL"] = $GROUP_MINUTES_GOAL;
						$groupLine["GROUP_PEOPLE_GOAL"] = $GROUP_PEOPLE_GOAL;
						$groupLine["CITIZEN_GOAL"] = $CITIZEN_GOAL;
						$groupLine["GROUP_PROCESS"] = $GROUP_PROCESS;
						
						// -----***---- CITIZEN DATA
						
						$groupLine["CITIZEN_IDTYPE"]  = "-";
						$groupLine["CITIZEN_IDNUM"]  = "-";
						$groupLine["CITIZEN_NAME"]  = "-";
						$groupLine["CITIZEN_LASTNAME"]  = "-";
						$groupLine["CITIZEN_GENDER"]  = "-";
						$groupLine["CITIZEN_BDAY"]  = "-";
						$groupLine["CITIZEN_AGE"]  = "-";
						$groupLine["CITIZEN_ADDRESS"]  = "-";
						$groupLine["CITIZEN_EMAIL"]  = "-";
						$groupLine["CITIZEN_PHONE"]  = "-";
						$groupLine["CITIZEN_ETNIA"]  = "-";
						$groupLine["CITIZEN_CONDITION"]  = "-";
						$groupLine["CITIZEN_HOOD"]  = "-";
						$groupLine["CITIZEN_ZONE"]  = "-";
						$groupLine["CITIZEN_LEVEL"]  = "-";
						$groupLine["CITIZEN_SAVED"]  = "-";
						$groupLine["CITIZEN_ETNIA_IND"]  = "-";
						$groupLine["CITIZEN_ORIGIN_COUNTRY"]  = "-";
						$groupLine["CITIZEN_DESTINY_COUNTRY"]  = "-";
						$groupLine["CITIZEN_STAY_REASON"]  = "-";
						$groupLine["CITIZEN_MIGREXP"]  = "-";
						$groupLine["CITIZEN_INDATE"]  = "-";
						$groupLine["CITIZEN_OUTDATE"]  = "-";
						$groupLine["CITIZEN_RETURN_REASON"]  = "-";
						$groupLine["CITIZEN_SITAC"]  = "-";
						$groupLine["CITIZEN_ACUDIENT"]  = "-";
						$groupLine["CITIZEN_BIRTH_CITY"]  = "-";
						$groupLine["CITIZEN_SISCORE"]  = "-";
						$groupLine["CITIZEN_CONVAC"]  = "-";
						$groupLine["CITIZEN_TIPOCO"]  = "-";
						$groupLine["CITIZEN_TIPOVI"]  = "-";
						$groupLine["CITIZEN_HANDICAP"]  = "-";
						$groupLine["CITIZEN_ETGROUP"]  = "-";
						$groupLine["CITIZEN_SECURITY"]  = "-";
						$groupLine["CITIZEN_EPS"]  = "-";
						$groupLine["CITIZEN_PATOEN"]  = "-";
						$groupLine["CITIZEN_TRASDES"]  = "-";
						$groupLine["CITIZEN_RISKFA"]  = "-";
						$groupLine["CITIZEN_PREVFA"]  = "-";
						$groupLine["CITIZEN_WEIGHT"]  = "-";
						$groupLine["CITIZEN_HEIGHT"]  = "-";
						$groupLine["CITIZEN_IMC"]  = "-";
						$groupLine["CITIZEN_IMC_RATE"]  = "-";
						$groupLine["CITIZEN_EDLEVEL"]  = "-";
						$groupLine["CITIZEN_INSTITUTE"]  = "-";
						$groupLine["CITIZEN_COURSES"]  = "-";
						$groupLine["CITIZEN_OCUCOND"]  = "-";
						$groupLine["CITIZEN_INGREC"]  = "-";
						
						
						array_push($groupLines, $groupLine);
					}
					
				}
				
				$exported = $this->excelCreate($EXPORT, $groupLines);
				$resp["path"] = $exported;
			}
			
			if($EXPORT == "events")
			{
				$eventLines = array();
				
				for($i = 0; $i<count($query);$i++)
				{
					$queryItem = $query[$i];
					
					$EVENT_CODE = $queryItem["EVENT_CODE"];
					$EVENT_CREATED = $queryItem["EVENT_CREATED"];
					$EVENT_ENTITY = $queryItem["EVENT_ENTITY"];
					$EVENT_OWNER = $queryItem["EVENT_OWNER"];
					
					// GET ENTITY NAME
					$data = array();
					$data["table"] = "wp_entities";
					$data["fields"] = " ENTITY_NAME ";
					$data["keyField"] = " ENTITY_CODE ";
					$data["code"] = $EVENT_ENTITY;
					$ENTITY_DATA = $this->getFriendlyData($data)["message"];
					$ENTITY_NAME = $ENTITY_DATA["ENTITY_NAME"];
					
					// GET EVENT TYPE, REQUESTER DATA AND EVENT STATUS
					$EVENT_AUTHOR = $queryItem["EVENT_AUTHOR"];
					if($EVENT_AUTHOR != "" and $EVENT_AUTHOR != null and $EVENT_AUTHOR != "null"){$EVENT_TYPE = "Solicitud";}
					else{$EVENT_TYPE = "Directo";}
					if($EVENT_TYPE == "Solicitud")
					{
						// GET REQUESTER DATA
						$data = array();
						$data["table"] = "wp_trusers";
						$data["fields"] = " USER_IDTYPE, USER_IDNUM,  USER_NAME, USER_LASTNAME  ";
						$data["keyField"] = " USER_CODE ";
						$data["code"] = $EVENT_AUTHOR;
						$AUTHOR_DATA = $this->getFriendlyData($data)["message"];
						
						$AUTHOR_DATA_IDTYPE = $AUTHOR_DATA["USER_IDTYPE"];
						$AUTHOR_DATA_IDNUM = $AUTHOR_DATA["USER_IDNUM"];
						$AUTHOR_DATA_NAME = $AUTHOR_DATA["USER_NAME"];
						$AUTHOR_DATA_LASTNAME = $AUTHOR_DATA["USER_LASTNAME"];
						
						$EVENT_STATUS = $queryItem["EVENT_STATUS"];
						if($EVENT_STATUS == "1"){$EVENT_STATUS = "Solicitud";}
						if($EVENT_STATUS == "2"){$EVENT_STATUS = "Asignado";}
						if($EVENT_STATUS == "3"){$EVENT_STATUS = "Rechazado";}
						if($EVENT_STATUS == "4"){$EVENT_STATUS = "Cerrado";}
						
					}   
					else
					{
						$AUTHOR_DATA_IDTYPE = "";
						$AUTHOR_DATA_IDNUM = "";
						$AUTHOR_DATA_NAME = "";
						$AUTHOR_DATA_LASTNAME = "";
						$EVENT_STATUS = "Cerrado";
					}
					
					$EVENT_NAME = $queryItem["EVENT_NAME"];
					$EVENT_ORIGIN = $queryItem["EVENT_ORIGIN"];
					$EVENT_RADICATE = $queryItem["EVENT_RADICATE"];
					$EVENT_REQUEST_DATE = $queryItem["EVENT_REQUEST_DATE"];
					$EVENT_REQUEST_TYPE = $queryItem["EVENT_REQUEST_TYPE"];
					$EVENT_DATE_INIR = $queryItem["EVENT_DATE_INIR"];
					$EVENT_DATE_ENDR = $queryItem["EVENT_DATE_ENDR"];
					$EVENT_DESCRIPTION = $queryItem["EVENT_DESCRIPTION"];
					$EVENT_INSTYPE = $queryItem["EVENT_INSTYPE"];
					
					// FRIENDLY NEED BLOCKS
					if($EVENT_TYPE == "Solicitud")
					{
						
						$EVENT_NEEDS = json_decode($queryItem["EVENT_NEEDS"], true);
						$neededLine = "";
						$gottenLine = "";
						for($n = 0; $n<count($EVENT_NEEDS);$n++)
						{
							$need = $EVENT_NEEDS[$n]["NEED_DESC"];
							$need = str_replace('Animaciu00f3n', 'Animación', $need);
							$needed = $EVENT_NEEDS[$n]["NEED_NEED"]; 
							$gotten = $EVENT_NEEDS[$n]["NEED_GOT"]; 
							$neededLine .= $need.": ".$needed." --- ";
							$gottenLine .= $need.": ".$gotten." --- ";
						}
						$EVENT_NEEDS_FRIENDLY = $neededLine;
						$EVENT_GOTTEN_FRIENDLY = $gottenLine;
						
						$EVENT_REQUESTER_ID = explode("-",$queryItem["EVENT_REQUESTER"])[0];
						
						// GET REQUESTER DATA
						$data = array();
						$data["table"] = "wp_citizens";
						$data["fields"] = " CITIZEN_IDTYPE, CITIZEN_IDNUM, CITIZEN_NAME, CITIZEN_LASTNAME,  CITIZEN_PHONE, CITIZEN_EMAIL ";
						$data["keyField"] = " CITIZEN_IDNUM ";
						$data["code"] = $EVENT_REQUESTER_ID;
						$REQUESTER_DATA = $this->getFriendlyData($data)["message"];
						$REQUESTER_IDTYPE = $REQUESTER_DATA["CITIZEN_IDTYPE"];
						$REQUESTER_IDNUM = $REQUESTER_DATA["CITIZEN_IDNUM"];
						$REQUESTER_NAME = $REQUESTER_DATA["CITIZEN_NAME"];
						$REQUESTER_LASTNAME = $REQUESTER_DATA["CITIZEN_LASTNAME"];
						$REQUESTER_PHONE = $REQUESTER_DATA["CITIZEN_PHONE"];
						$REQUESTER_EMAIL = $REQUESTER_DATA["CITIZEN_EMAIL"];

					}
					else
					{
						
						$EVENT_NEEDS_FRIENDLY = "";
						$EVENT_GOTTEN_FRIENDLY = "";
						$REQUESTER_IDTYPE = "";
						$REQUESTER_IDNUM = "";
						$REQUESTER_NAME = "";
						$REQUESTER_LASTNAME = "";
						$REQUESTER_PHONE = "";
						$REQUESTER_EMAIL = "";
					}
					
					$EVENT_PREVIR = $queryItem["EVENT_PREVIR"];
					
					// GET FRIENDLY HOOD AND ZONE
					$data = array();
					$data["table"] = "wp_hoods";
					$data["fields"] = " HOOD_NAME, HOOD_ZONE ";
					$data["keyField"] = " HOOD_CODE ";
					$data["code"] = $queryItem["EVENT_HOOD"];
					$EVENT_HOOD_DATA = $this->getFriendlyData($data)["message"];
					$EVENT_HOOD = $EVENT_HOOD_DATA["HOOD_NAME"];
					
					$data = array();
					$data["table"] = "wp_zones";
					$data["fields"] = " ZONE_NAME";
					$data["keyField"] = " ZONE_CODE ";
					$data["code"] = $EVENT_HOOD_DATA["HOOD_ZONE"];
					$EVENT_ZONE_DATA = $this->getFriendlyData($data)["message"];
					$EVENT_ZONE = $EVENT_ZONE_DATA["ZONE_NAME"];
					
					$EVENT_ADDRESS = $queryItem["EVENT_ADDRESS"];
					$EVENT_COORDS = $queryItem["EVENT_COORDS"];
					$EVENT_EXPECTED = $queryItem["EVENT_EXPECTED"];
					$EVENT_REJECT_REASON = $queryItem["EVENT_REJECT_REASON"];
					
					$EVENT_DATE_INI = $queryItem["EVENT_DATE_INI"];
					$EVENT_DATE_END = $queryItem["EVENT_DATE_END"];
					
					
					// CREATE CONTRATISTS ARRAY
					$CONTRATISTS = array();
				
					// GET DIRECTORS
					if($EVENT_OWNER != "" and $EVENT_OWNER != null and $EVENT_OWNER != "null")
					{
						// PROPIO O DE SOLICITUD ASIGNADO
						
						$CONTRATIST = array();
						
						if($queryItem["EVENT_TYPE"] == "1")
						{
							$str = "SELECT CONTRACT_OWNER FROM wp_contracts WHERE CONTRACT_CODE = '".$EVENT_OWNER."'";
							$CONTRATIST["USER"] = $this->db->query($str)[0]["CONTRACT_OWNER"];
						}
						else
						{
							$CONTRATIST["USER"] = $EVENT_OWNER;
						}
						
										
						$CONTRATIST["ROL"] = "Director";
						$CONTRATIST["ACTIVITIES"] = $queryItem["EVENT_ACTIVITIES"];
						// GET USER ACTUAL CONTRACT
						
						// GET UPDATE CONTRACT ---------------------
						$ccode = $queryItem["EVENT_CONTRACT_CODE"];
						
						if($ccode != "" and $ccode != null and $ccode != "null")
						{$CONTRATIST["CONTRACT"] = $ccode;}
						else
						{
							// GET CONTRACT AND SAVE IT TO REG
							$now = new DateTime();
							$now = $now->format('Y-m-d');
							// GET MY CONTRACT INI AND END DATE
							$str = "SELECT CONTRACT_CODE FROM wp_contracts WHERE CONTRACT_OWNER = '".$EVENT_OWNER."' AND CONTRACT_ENDATE >= '".$now."' AND CONTRACT_INIDATE <= '".$now."'";
							$contractData = $this->db->query($str);
							if(count($contractData) > 0)
							{
								$CONTRATIST["CONTRACT"] = $contractData[0]["CONTRACT_CODE"];
								$str = "UPDATE wp_events SET EVENT_CONTRACT_CODE = '".$CONTRATIST["CONTRACT"]."' WHERE EVENT_CODE ='".$EVENT_CODE."'";
								$updater = $this->db->query($str);
							}
							else{$CONTRATIST["CONTRACT"] = "";}
						}
						
						array_push($CONTRATISTS, $CONTRATIST);
					}
					else
					{
						// SOLICITUD SIN ASIGNAR
						$CONTRATIST = array();
						$CONTRATIST["USER"] = "";
						$CONTRATIST["ROL"] = "";
						$CONTRATIST["ACTIVITIES"] = "";
						$CONTRATIST["CONTRACT"] = "";
						
						array_push($CONTRATISTS, $CONTRATIST);
					}
					
					// GET SUPPORTS
							
					$EVENT_SUPPORT_TEAM = $queryItem["EVENT_SUPPORT_TEAM"];
					if($EVENT_SUPPORT_TEAM != "" and $EVENT_SUPPORT_TEAM != null and $EVENT_SUPPORT_TEAM != "null")
					{
						
						$EVENT_SUPPORT_TEAM = json_decode($EVENT_SUPPORT_TEAM, true);
						
						for($s = 0; $s<count($EVENT_SUPPORT_TEAM);$s++)
						{
							$dude = $EVENT_SUPPORT_TEAM[$s];
							
							// SOLICITUD SIN ASIGNAR
							$supportDude = array();
							
							
							// GET CONTRACT OWNER CODE
							$data = array();
							$data["table"] = "wp_contracts";
							$data["fields"] = " CONTRACT_OWNER ";
							$data["keyField"] = " CONTRACT_CODE ";
							$data["code"] = $dude["SUPPORT_CONTRACT"];
							$CDATA = $this->getFriendlyData($data)["message"];
							
							if($CDATA != "none")
							{
								$supportDude["USER"] = $CDATA["CONTRACT_OWNER"];
								$supportDude["ROL"] = "Apoyo";
								$supportDude["ACTIVITIES"] = json_encode($dude["SUPPORT_ACTIVITIES"], true);
								$supportDude["CONTRACT"] = $dude["SUPPORT_CONTRACT"];
							}
							else
							{
								$supportDude["USER"] = $dude["SUPPORT_CONTRACT"];
								$supportDude["ROL"] = "Apoyo";
								$supportDude["ACTIVITIES"] = json_encode($dude["SUPPORT_ACTIVITIES"], true);
								$supportDude["CONTRACT"] = $dude["SUPPORT_CONTRACT"];
							}
							
							
							
							array_push($CONTRATISTS, $supportDude);
						}
						
					}
					
					$COOPTYPE = $queryItem["EVENT_COOPTYPE"];
					$COOPERATOR = $queryItem["EVENT_COOPERATOR"];
					
					
					
					for($c = 0; $c<count($CONTRATISTS);$c++)
					{
						$CONTRATIST = $CONTRATISTS[$c];
						
						$USER = $CONTRATIST["USER"];
						$ROL = $CONTRATIST["ROL"];
						
						if($CONTRATIST["ACTIVITIES"] != "")
						{
							$TACTIVITIES = json_decode($CONTRATIST["ACTIVITIES"],true);
						
							$activities = array();
							$projects = array();
							$programs = array();
							
							// GET FRIENDLY NAMES FOT ACTIVITIES AND PARENTS
							for($a = 0; $a<count($TACTIVITIES);$a++)
							{
								$acti = $TACTIVITIES[$a];
								
								// GET ACTIVITY DATA
								$data = array();
								$data["table"] = "wp_activities";
								$data["fields"] = " ACTIVITY_NAME, ACTIVITY_PROJECT ";
								$data["keyField"] = " ACTIVITY_CODE ";
								$data["code"] = $acti;
								$CLASS_ACTIVITY_DATA = $this->getFriendlyData($data)["message"];
								
								$ACTIVITY_NAME = $CLASS_ACTIVITY_DATA["ACTIVITY_NAME"];
								
								// ADD IF NOT
								if (!in_array($ACTIVITY_NAME, $activities)){array_push($activities, $ACTIVITY_NAME);}
								
								$ACTIVITY_PROJECT = $CLASS_ACTIVITY_DATA["ACTIVITY_PROJECT"];
								
								// GET PROJECT DATA
								$data = array();
								$data["table"] = "wp_projects";
								$data["fields"] = " PROJECT_NAME, PROJECT_PROGRAM ";
								$data["keyField"] = " PROJECT_CODE ";
								$data["code"] = $ACTIVITY_PROJECT;
								$CLASS_PROJECT_DATA = $this->getFriendlyData($data)["message"];
								$PROJECT_NAME = $CLASS_PROJECT_DATA["PROJECT_NAME"];
								
								// ADD IF NOT
								if (!in_array($PROJECT_NAME, $projects)){array_push($projects, $PROJECT_NAME);}
								
								$PROJECT_PROGRAM = $CLASS_PROJECT_DATA["PROJECT_PROGRAM"];
								
								// GET PROGRAM DATA
								$data = array();
								$data["table"] = "wp_programs";
								$data["fields"] = " PROGRAM_NAME ";
								$data["keyField"] = " PROGRAM_CODE ";
								$data["code"] = $PROJECT_PROGRAM;
								$CLASS_PROGRAM_DATA = $this->getFriendlyData($data)["message"];
								
								$PROGRAM_NAME = $CLASS_PROGRAM_DATA["PROGRAM_NAME"];
								
								// ADD IF NOT
								if (!in_array($PROGRAM_NAME, $programs)){array_push($programs, $PROGRAM_NAME);}
							}
								
							$ACTIVITIES = $this->stringFromArray($activities);
							$PROJECTS = $this->stringFromArray($projects);
							$PROGRAMS = $this->stringFromArray($programs);
						}
						else
						{
							$ACTIVITIES = "-";
							$PROJECTS = "-";
							$PROGRAMS = "-";
						}

						// GET CONTRACT DATA
						$CONTRACT = $CONTRATIST["CONTRACT"];
						if($CONTRACT != "")
						{
							// GET CONTRACT DATA
							$data = array();
							$data["table"] = "wp_contracts";
							$data["fields"] = " CONTRACT_NUMBER, CONTRACT_INIDATE, CONTRACT_ENDATE, CONTRACT_USERTYPE, CONTRACT_EVENT_GOALS ";
							$data["keyField"] = " CONTRACT_CODE ";
							$data["code"] = $CONTRACT;
							$EVENT_CONTRACT_DATA = $this->getFriendlyData($data)["message"];
							if($EVENT_CONTRACT_DATA == "none"){continue;}
							
							$CONTRACT_NUMBER = $EVENT_CONTRACT_DATA["CONTRACT_NUMBER"];
							$CONTRACT_INIDATE = $EVENT_CONTRACT_DATA["CONTRACT_INIDATE"];
							$CONTRACT_ENDATE = $EVENT_CONTRACT_DATA["CONTRACT_ENDATE"];
							$CONTRACT_USERTYPE = $EVENT_CONTRACT_DATA["CONTRACT_USERTYPE"];
							$CONTRACT_EVENT_GOALS = $EVENT_CONTRACT_DATA["CONTRACT_EVENT_GOALS"];
							
							if($CONTRACT_EVENT_GOALS != "" and $CONTRACT_EVENT_GOALS != null and $CONTRACT_EVENT_GOALS != "null")
							{
								$CONTRACT_EVENT_GOALS = json_decode($EVENT_CONTRACT_DATA["CONTRACT_EVENT_GOALS"], true);
								$DIRECTED = 0;
								$SUPPORTED = 0;
								for($e = 0; $e<count($CONTRACT_EVENT_GOALS);$e++)
								{
									$item = $CONTRACT_EVENT_GOALS[$e];
									$DIRECTED = $DIRECTED + floatval($item["V1"]);
									$SUPPORTED = $SUPPORTED + floatval($item["V2"]);
								}
							}
							else
							{
								$DIRECTED = "";
								$SUPPORTED = "";
							}
						}
						else
						{
							$CONTRACT_NUMBER = "";
							$CONTRACT_INIDATE = "";
							$CONTRACT_ENDATE = "";
							$CONTRACT_USERTYPE = "";
							$DIRECTED = "";
							$SUPPORTED = "";
						}
						
						// GET CONTRACT OWNER DATA
						$data = array();
						$data["table"] = "wp_trusers";
						$data["fields"] = " USER_IDTYPE, USER_IDNUM, USER_NAME, USER_LASTNAME ";
						$data["keyField"] = " USER_CODE ";
						$data["code"] = $USER;
						$CONTRATIST_DATA = $this->getFriendlyData($data)["message"];
						if($CONTRATIST_DATA != "none")
						{
							$CONTRATIST_IDTYPE = $CONTRATIST_DATA["USER_IDTYPE"];
							$CONTRATIST_IDNUM = $CONTRATIST_DATA["USER_IDNUM"];
							$CONTRATIST_NAME = $CONTRATIST_DATA["USER_NAME"];
							$CONTRATIST_LASTNAME = $CONTRATIST_DATA["USER_LASTNAME"];
						}
						else
						{
							$CONTRATIST_IDTYPE = "-";
							$CONTRATIST_IDNUM = "-";
							$CONTRATIST_NAME = "-";
							$CONTRATIST_LASTNAME = "-";
						}
						
						// GET COOPERATOR DATA
						
						if($COOPERATOR != "" and $COOPERATOR !=  null and $COOPERATOR !=  "null")
						{
							$COOPERATOR = explode("-",$COOPERATOR)[0];
							
							$data = array();
							$data["table"] = "wp_citizens";
							$data["fields"] = " CITIZEN_IDTYPE, CITIZEN_IDNUM, CITIZEN_NAME, CITIZEN_LASTNAME, CITIZEN_PHONE, CITIZEN_EMAIL ";
							$data["keyField"] = " CITIZEN_IDNUM ";
							$data["code"] = $COOPERATOR;
							$COOPERATOR_DATA = $this->getFriendlyData($data)["message"];
							if($COOPERATOR_DATA != "none")
							{
								$COOPERATOR_IDTYPE = $COOPERATOR_DATA["CITIZEN_IDTYPE"];
								$COOPERATOR_IDNUM = $COOPERATOR_DATA["CITIZEN_IDNUM"];
								$COOPERATOR_NAME = $COOPERATOR_DATA["CITIZEN_NAME"];
								$COOPERATOR_LASTNAME = $COOPERATOR_DATA["CITIZEN_LASTNAME"];
								$COOPERATOR_PHONE = $COOPERATOR_DATA["CITIZEN_PHONE"];
								$COOPERATOR_EMAIL = $COOPERATOR_DATA["CITIZEN_EMAIL"];
							}
						}
						else
						{
							$COOPERATOR_IDTYPE = "";
							$COOPERATOR_IDNUM = "";
							$COOPERATOR_NAME = "";
							$COOPERATOR_LASTNAME = "";
							$COOPERATOR_PHONE = "";
							$COOPERATOR_EMAIL = "";
						}
						
						// GET EVENT ASSIST DATA
						
						$EVENT_ASSIST = $queryItem["EVENT_ASSIST"];
						if($EVENT_ASSIST != "" and $EVENT_ASSIST !=  null and $EVENT_ASSIST !=  "null")
						{
							$EVENT_ASSIST = json_decode($EVENT_ASSIST, true);
							$EVENT_ASSISTANTS = intval($EVENT_ASSIST[0]["ASSIST_VALUE"])+intval($EVENT_ASSIST[1]["ASSIST_VALUE"]);
							$ASSIST_DETAIL = "";
							for($n = 0; $n<count($EVENT_ASSIST);$n++)
							{
								$assisLine = $EVENT_ASSIST[$n];
								$desc = $assisLine["ASSIST_DESC"]; 
								$value = $assisLine["ASSIST_VALUE"]; 
								$desc = str_replace('INDu00cdGENA', 'INDIGENA', $desc);
								$ASSIST_DETAIL .= $desc.": ".$value." --- ";

							}
						}
						else
						{
							$EVENT_ASSISTANTS = 0;
							$ASSIST_DETAIL = "";
						}
						
						$EVENT_RESUME = $queryItem["EVENT_RESUME"];
						
						
						$eventLine = array();
						$eventLine["EVENT_CODE"] = $EVENT_CODE;
						$eventLine["EVENT_CREATED"] = $EVENT_CREATED;
						$eventLine["ENTITY_NAME"] = $ENTITY_NAME;
						$eventLine["AUTHOR_DATA_IDTYPE"] = $AUTHOR_DATA_IDTYPE;
						$eventLine["AUTHOR_DATA_IDNUM"] = $AUTHOR_DATA_IDNUM;
						$eventLine["AUTHOR_DATA_NAME"] = $AUTHOR_DATA_NAME;
						$eventLine["AUTHOR_DATA_LASTNAME"] = $AUTHOR_DATA_LASTNAME;
						$eventLine["EVENT_TYPE"] = $EVENT_TYPE;
						$eventLine["EVENT_STATUS"] = $EVENT_STATUS;
						$eventLine["EVENT_NAME"] = $EVENT_NAME;
						$eventLine["EVENT_ORIGIN"] = $EVENT_ORIGIN;
						$eventLine["EVENT_RADICATE"] = $EVENT_RADICATE;
						$eventLine["EVENT_REQUEST_DATE"] = $EVENT_REQUEST_DATE;
						$eventLine["EVENT_REQUEST_TYPE"] = $EVENT_REQUEST_TYPE;
						$eventLine["EVENT_DATE_INIR"] = $EVENT_DATE_INIR;
						$eventLine["EVENT_DATE_ENDR"] = $EVENT_DATE_ENDR;
						$eventLine["EVENT_DESCRIPTION"] = $EVENT_DESCRIPTION;
						$eventLine["EVENT_NEEDS_FRIENDLY"] = $EVENT_NEEDS_FRIENDLY;
						$eventLine["EVENT_INSTYPE"] = $EVENT_INSTYPE;
						$eventLine["REQUESTER_IDTYPE"] = $REQUESTER_IDTYPE;
						$eventLine["REQUESTER_IDNUM"] = $REQUESTER_IDNUM;
						$eventLine["REQUESTER_NAME"] = $REQUESTER_NAME;
						$eventLine["REQUESTER_LASTNAME"] = $REQUESTER_LASTNAME;
						$eventLine["REQUESTER_PHONE"] = $REQUESTER_PHONE;
						$eventLine["REQUESTER_EMAIL"] = $REQUESTER_EMAIL;
						$eventLine["EVENT_PREVIR"] = $EVENT_PREVIR;
						$eventLine["EVENT_HOOD"] = $EVENT_HOOD;
						$eventLine["EVENT_ZONE"] = $EVENT_ZONE;
						$eventLine["EVENT_ADDRESS"] = $EVENT_ADDRESS;
						$eventLine["EVENT_COORDS"] = $EVENT_COORDS;
						$eventLine["EVENT_EXPECTED"] = $EVENT_EXPECTED;
						$eventLine["EVENT_REJECT_REASON"] = $EVENT_REJECT_REASON;
						$eventLine["EVENT_GOTTEN_FRIENDLY"] = $EVENT_GOTTEN_FRIENDLY;
						$eventLine["EVENT_DATE_INI"] = $EVENT_DATE_INI;
						$eventLine["EVENT_DATE_END"] = $EVENT_DATE_END;
						$eventLine["ACTIVITIES"] = $ACTIVITIES;
						$eventLine["PROJECTS"] = $PROJECTS;
						$eventLine["PROGRAMS"] = $PROGRAMS;
						$eventLine["ROL"] = $ROL;
						$eventLine["CONTRACT_NUMBER"] = $CONTRACT_NUMBER;
						$eventLine["CONTRACT_INIDATE"] = $CONTRACT_INIDATE;
						$eventLine["CONTRACT_ENDATE"] = $CONTRACT_ENDATE;
						$eventLine["CONTRACT_USERTYPE"] = $CONTRACT_USERTYPE;
						$eventLine["CONTRATIST_IDTYPE"] = $CONTRATIST_IDTYPE;
						$eventLine["CONTRATIST_IDNUM"] = $CONTRATIST_IDNUM;
						$eventLine["CONTRATIST_NAME"] = $CONTRATIST_NAME;
						$eventLine["CONTRATIST_LASTNAME"] = $CONTRATIST_LASTNAME;
						$eventLine["DIRECTED"] = $DIRECTED;
						$eventLine["SUPPORTED"] = $SUPPORTED;
						$eventLine["COOPTYPE"] = $COOPTYPE;
						$eventLine["COOPERATOR_IDTYPE"] = $COOPERATOR_IDTYPE;
						$eventLine["COOPERATOR_IDNUM"] = $COOPERATOR_IDNUM;
						$eventLine["COOPERATOR_NAME"] = $COOPERATOR_NAME;
						$eventLine["COOPERATOR_LASTNAME"] = $COOPERATOR_LASTNAME;
						$eventLine["COOPERATOR_PHONE"] = $COOPERATOR_PHONE;
						$eventLine["COOPERATOR_EMAIL"] = $COOPERATOR_EMAIL;
						$eventLine["EVENT_ASSISTANTS"] = $EVENT_ASSISTANTS;
						$eventLine["ASSIST_DETAIL"] = $ASSIST_DETAIL;
						$eventLine["EVENT_RESUME"] = $EVENT_RESUME;
						
						
						
						
						
						array_push($eventLines, $eventLine);
						
					}
				}
				
				$exported = $this->excelCreate($EXPORT, $eventLines);
				$resp["path"] = $exported;
			}
			
			if($EXPORT == "classAssist")
			{
				$assistLines = array();
				
				$actualClassCode = "";
				$FIXED_ENTITY_NAME = "";
				$FIXED_GROUP_DATA = array();
				$FIXED_CONTRACT_DATA = array();
				$FIXED_CONTRATIST_DATA = array();
				
				$FULL_CITIZENS = array();
				$FULL_CITIZENS_ADDED = array();
				
				for($i = 0; $i<count($query);$i++)
				{
					$queryItem = $query[$i];
					
					$CLASS_CODE = $queryItem["CLASS_CODE"];
					
					$CLASS_CREATED = $queryItem["CLASS_CREATED"];
					$CLASS_CONTRACT_CODE = $queryItem["CLASS_CONTRACT_CODE"];
					$CLASS_GROUP_GOAL = $queryItem["CLASS_GROUP_GOAL"];
					$GROUP_NAME = $query[$i]["CLASS_GROUP_NAME"];
					$GROUP_PREVIR = $query[$i]["CLASS_GROUP_PREVIR"];
					$GROUP_INSTYPE = $query[$i]["CLASS_GROUP_INSTYPE"];
					$CLASS_GROUP = $queryItem["CLASS_GROUP"];
					
					// GET AND SAVE FIXED VALUES PER CLASS
					
					if($CLASS_CODE != $actualClassCode)
					{
						
						$actualClassCode = $CLASS_CODE;

						// GET ENTITY DATA
						$data = array();
						$data["table"] = "wp_entities";
						$data["fields"] = " ENTITY_NAME ";
						$data["keyField"] = " ENTITY_CODE ";
						$data["code"] = $query[$i]["CLASS_ENTITY"];
						$ENTITY_DATA = $this->getFriendlyData($data)["message"];
						$ENTITY_NAME = $ENTITY_DATA["ENTITY_NAME"];

						$FIXED_ENTITY_NAME = $ENTITY_NAME;
						
						// GET GROUP DATA
						$data = array();
						$data["table"] = "wp_groups";
						$data["fields"] = " GROUP_CONTRACT, GROUP_ADDRESS, GROUP_INSTITUTE, GROUP_COORDS, GROUP_COPERATOR ";
						$data["keyField"] = " GROUP_CODE ";
						$data["code"] = $CLASS_GROUP;
						$CLASS_GROUP_DATA = $this->getFriendlyData($data)["message"];
						
						if($CLASS_GROUP_DATA == "none"){continue;}
						
						
						$FIXED_GROUP_DATA = $CLASS_GROUP_DATA;
						
						// UPDATE MISSING CCODES
						if($CLASS_CONTRACT_CODE != null and $CLASS_CONTRACT_CODE != "null" and $CLASS_CONTRACT_CODE != "")
						{
							$GROUP_CONTRACT = $CLASS_CONTRACT_CODE;
						}
						else
						{
							$str = "UPDATE wp_classes SET CLASS_CONTRACT_CODE = '".$GROUP_CONTRACT."' WHERE CLASS_CODE ='".$CLASS_CODE."'";
							$updater = $this->db->query($str);
						}
		
						// GET CONTRACT DATA
						$data = array();
						$data["table"] = "wp_contracts";
						$data["fields"] = " CONTRACT_NUMBER, CONTRACT_OTHER_GOALS, CONTRACT_OWNER, CONTRACT_ENTITY, CONTRACT_INIDATE, CONTRACT_ENDATE, CONTRACT_USERTYPE ";
						$data["keyField"] = " CONTRACT_CODE ";
						if($CLASS_CONTRACT_CODE != "" and $CLASS_CONTRACT_CODE != "null" and $CLASS_CONTRACT_CODE != null)
						{$data["code"] = $CLASS_CONTRACT_CODE;}
						else
						{$data["code"] = $GROUP_CONTRACT;}
						$CLASS_CONTRACT_DATA = $this->getFriendlyData($data)["message"];
						if($CLASS_CONTRACT_DATA == "none"){continue;}
						
						$FIXED_CONTRACT_DATA = $CLASS_CONTRACT_DATA;
						
						// GET CONTRACT OWNER DATA
						$data = array();
						$data["table"] = "wp_trusers";
						$data["fields"] = " USER_NAME, USER_LASTNAME, USER_IDTYPE, USER_IDNUM ";
						$data["keyField"] = " USER_CODE ";
						$data["code"] = $CLASS_CONTRACT_DATA["CONTRACT_OWNER"];
						$CLASS_CONTRATIST_DATA = $this->getFriendlyData($data)["message"];
						
						$FIXED_CONTRATIST_DATA = $CLASS_CONTRATIST_DATA;

					}
					else
					{
						
						$ENTITY_NAME = $FIXED_ENTITY_NAME;
						$CLASS_GROUP_DATA = $FIXED_GROUP_DATA;
						$CLASS_CONTRACT_DATA = $FIXED_CONTRACT_DATA;
						$CLASS_CONTRATIST_DATA = $FIXED_CONTRATIST_DATA;
					}

					// SET GROUP DATA
					$GROUP_CONTRACT = $CLASS_GROUP_DATA["GROUP_CONTRACT"];
					$GROUP_ADDRESS = $CLASS_GROUP_DATA["GROUP_ADDRESS"];
					$GROUP_INSTITUTE = $CLASS_GROUP_DATA["GROUP_INSTITUTE"];
					$GROUP_COORDS = $CLASS_GROUP_DATA["GROUP_COORDS"];
					$GROUP_COPERATOR = $CLASS_GROUP_DATA["GROUP_COPERATOR"];
					
					// SET CONTRACT DATA
					$CONTRACT_USERTYPE = $CLASS_CONTRACT_DATA["CONTRACT_USERTYPE"];
					$CONTRACT_INIDATE = $CLASS_CONTRACT_DATA["CONTRACT_INIDATE"];
					$CONTRACT_ENDATE = $CLASS_CONTRACT_DATA["CONTRACT_ENDATE"];
					$CONTRACT_ENTITY = $CLASS_CONTRACT_DATA["CONTRACT_ENTITY"];
					$CONTRACT_NUMBER = $CLASS_CONTRACT_DATA["CONTRACT_NUMBER"];
					$CONTRACT_OTHER_GOALS = json_decode($CLASS_CONTRACT_DATA["CONTRACT_OTHER_GOALS"], true);
					$CONTRACT_OWNER = $CLASS_CONTRACT_DATA["CONTRACT_OWNER"];
					
					// SET CONTRATIST DATA
					
					if(!isset($CLASS_CONTRATIST_DATA["USER_NAME"]))
					{
						$CLASS_USER_NAME = "-";
						$CLASS_USER_LASTNAME = "-";
						$CLASS_USER_IDTYPE = "-";
						$CLASS_USER_IDNUM = "-";
						// continue;
					}
					else
					{
						$CLASS_USER_NAME = $CLASS_CONTRATIST_DATA["USER_NAME"];
						$CLASS_USER_LASTNAME = $CLASS_CONTRATIST_DATA["USER_LASTNAME"];
						$CLASS_USER_IDTYPE = $CLASS_CONTRATIST_DATA["USER_IDTYPE"];
						$CLASS_USER_IDNUM = $CLASS_CONTRATIST_DATA["USER_IDNUM"];
					}
						
					
					
					
					// GET ACTIVITY DATA
					$data = array();
					$data["table"] = "wp_activities";
					$data["fields"] = " ACTIVITY_NAME, ACTIVITY_PROJECT ";
					$data["keyField"] = " ACTIVITY_CODE ";
					$data["code"] = $queryItem["CLASS_ACTIVITY"];
					$CLASS_ACTIVITY_DATA = $this->getFriendlyData($data)["message"];
					
					if($CLASS_ACTIVITY_DATA != "none")
					{
						$ACTIVITY_NAME = $CLASS_ACTIVITY_DATA["ACTIVITY_NAME"];
						$ACTIVITY_PROJECT = $CLASS_ACTIVITY_DATA["ACTIVITY_PROJECT"];
					}
					else
					{
						// $ACTIVITY_NAME = $queryItem["CLASS_ACTIVITY"];
						$ACTIVITY_NAME = "-*-";
						$ACTIVITY_PROJECT = "-*-";
					}
					
					
					
					// GET PROJECT DATA
					$data = array();
					$data["table"] = "wp_projects";
					$data["fields"] = " PROJECT_NAME, PROJECT_PROGRAM ";
					$data["keyField"] = " PROJECT_CODE ";
					$data["code"] = $ACTIVITY_PROJECT;
					$CLASS_PROJECT_DATA = $this->getFriendlyData($data)["message"];
					
					if($CLASS_PROJECT_DATA != "none")
					{
						$PROJECT_NAME = $CLASS_PROJECT_DATA["PROJECT_NAME"];
						$PROJECT_PROGRAM = $CLASS_PROJECT_DATA["PROJECT_PROGRAM"];
					}
					else
					{
						$PROJECT_NAME = $ACTIVITY_PROJECT;
						$PROJECT_PROGRAM = "-*-";
					}
					
					
					
					// GET PROGRAM DATA
					$data = array();
					$data["table"] = "wp_programs";
					$data["fields"] = " PROGRAM_NAME ";
					$data["keyField"] = " PROGRAM_CODE ";
					$data["code"] = $PROJECT_PROGRAM;
					$CLASS_PROGRAM_DATA = $this->getFriendlyData($data)["message"];
					
					if($CLASS_PROGRAM_DATA != "none")
					{
						$PROGRAM_NAME = $CLASS_PROGRAM_DATA["PROGRAM_NAME"];
					}
					else
					{
						$PROGRAM_NAME = "-*-";
					}
					
					
					// GET COOPERATOR DATA
					$COOPERATOR_IDNUM = explode("-", $GROUP_COPERATOR)[0];
					$data = array();
					$data["table"] = "wp_citizens";
					$data["fields"] = " CITIZEN_IDTYPE, CITIZEN_IDNUM, CITIZEN_NAME, CITIZEN_LASTNAME, CITIZEN_PHONE, CITIZEN_EMAIL  ";
					$data["keyField"] = " CITIZEN_IDNUM ";
					$data["code"] = $COOPERATOR_IDNUM;
					$CLASS_COOPERATOR_DATA = $this->getFriendlyData($data)["message"];
					
					if($CLASS_COOPERATOR_DATA != "none")
					{
						$COOPERATOR_IDTYPE = $CLASS_COOPERATOR_DATA["CITIZEN_IDTYPE"];
						$COOPERATOR_NAME = $CLASS_COOPERATOR_DATA["CITIZEN_NAME"];
						$COOPERATOR_LASTNAME = $CLASS_COOPERATOR_DATA["CITIZEN_LASTNAME"];
						$COOPERATOR_PHONE = $CLASS_COOPERATOR_DATA["CITIZEN_PHONE"];
						$COOPERATOR_EMAIL = $CLASS_COOPERATOR_DATA["CITIZEN_EMAIL"];
					}
					else
					{
						$CLASS_COOPERATOR_DATA = array();
						$CLASS_COOPERATOR_DATA["CITIZEN_IDTYPE"] = "-";
						$CLASS_COOPERATOR_DATA["CITIZEN_NAME"] = "-";
						$CLASS_COOPERATOR_DATA["CITIZEN_LASTNAME"] = "-";
						$CLASS_COOPERATOR_DATA["CITIZEN_PHONE"] = "-";
						$CLASS_COOPERATOR_DATA["CITIZEN_EMAIL"] = "-";
					}

					
					$COOPERATOR_IDTYPE = $CLASS_COOPERATOR_DATA["CITIZEN_IDTYPE"];
					$COOPERATOR_NAME = $CLASS_COOPERATOR_DATA["CITIZEN_NAME"];
					$COOPERATOR_LASTNAME = $CLASS_COOPERATOR_DATA["CITIZEN_LASTNAME"];
					$COOPERATOR_PHONE = $CLASS_COOPERATOR_DATA["CITIZEN_PHONE"];
					$COOPERATOR_EMAIL = $CLASS_COOPERATOR_DATA["CITIZEN_EMAIL"];
					
					// GET CONTRACT GOALS, HOURS AND USERS OF LINKED CONTRACT GROUP
					$goalsData = array();
					$goalsData["V1"] = 0;
					$goalsData["V2"] = 0;
					$goalsData["V3"] = 0;
					
					$CLASSES_GOAL = "0";
					$HOURS_GOAL = "0";
					$PEOPLE_GOAL = "0";
					
					$found = 0;
					
					
					if(!isset($CONTRACT_OTHER_GOALS))
					{
						$CONTRACT_OTHER_GOALS = array();
					}
					
					// $resp["message"] = $ans;
					// $resp["status"] = true;
					// return $resp;
					
					
					for($g = 0; $g<count($CONTRACT_OTHER_GOALS);$g++)
					{
						$group = $CONTRACT_OTHER_GOALS[$g];
						if(array_key_exists("V4",$group))
						{
							if($group["V4"] == $CLASS_GROUP)
							{
								$goalsData = $group;
								$CLASSES_GOAL = $goalsData["V1"];
								$HOURS_GOAL = intval($goalsData["V2"])/60;
								$PEOPLE_GOAL = $goalsData["V3"];
								$found = 1;
								break;
							}
						}
					}
					if($found == 1)
					{
						// IF FOUND AND NOT SAVED, BURN
						$CLASS_GROUP_GOAL = count($CONTRACT_OTHER_GOALS);
						$CLASS_CLASSES_GOAL = $CLASSES_GOAL;
						$CLASS_TIMES_GOAL = $HOURS_GOAL;
						$CLASS_PEOPLE_GOAL = $PEOPLE_GOAL;
					}
					else
					{
						$CLASS_GROUP_GOAL = "1";
						$CLASS_CLASSES_GOAL = "2";
						$CLASS_TIMES_GOAL = "0.5";
						$CLASS_PEOPLE_GOAL = "15";
					}
					
					// UPDATE BURNED GOALS IF NOT EXIST
					// UPDATE BURNED GOALS IF NOT EXIST
					if($queryItem["CLASS_GROUP_GOAL"] == "" or $queryItem["CLASS_GROUP_GOAL"] == null or $queryItem["CLASS_GROUP_GOAL"] == "null")
					{
						$str = "UPDATE wp_classes SET 
						CLASS_GROUP_GOAL = '".$CLASS_GROUP_GOAL."',
						CLASS_CLASSES_GOAL = '".$CLASS_CLASSES_GOAL."',
						CLASS_TIMES_GOAL = '".$CLASS_TIMES_GOAL."',
						CLASS_PEOPLE_GOAL = '".$CLASS_PEOPLE_GOAL."'
						WHERE 
						CLASS_CODE ='".$CLASS_CODE."'";
						$burn = $this->db->query($str);
					}
					else
					{
						
						$CLASS_GROUP_GOAL = $queryItem["CLASS_GROUP_GOAL"];
						$CLASS_CLASSES_GOAL = $queryItem["CLASS_CLASSES_GOAL"];
						$CLASS_TIMES_GOAL = $queryItem["CLASS_TIMES_GOAL"];
						$CLASS_PEOPLE_GOAL = $queryItem["CLASS_PEOPLE_GOAL"];
						
					}
					
					
					$CLASS_HOUR = json_decode($queryItem["CLASS_HOUR"],true);
					$CLASS_INI = $CLASS_HOUR["GROUP_TIME_INI"];
					$CLASS_END = $CLASS_HOUR["GROUP_TIME_END"];
					
					// GET CITIZENS ASSIST LIST
					$queryItem["CLASS_CITIZENS"] = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($queryItem["CLASS_CITIZENS"]));
					$queryItem["CLASS_CITIZENS"] = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($queryItem["CLASS_CITIZENS"]));
					
					
					
					if($queryItem["CLASS_CITIZENS"] != "" and $queryItem["CLASS_CITIZENS"] != null and $queryItem["CLASS_CITIZENS"] != "null")
					{	
						$cits = str_replace(array("\r", "\n"), '', $queryItem["CLASS_CITIZENS"]);
					
						$CLASS_CITIZENS = json_decode($cits, true);
					}
					else{$CLASS_CITIZENS = array();}
					
					$CLASS_EXCUSE = $queryItem["CLASS_EXCUSE"];
					
					
					// GET FRIENDLY HOOD AND ZONE
					$data = array();
					$data["table"] = "wp_hoods";
					$data["fields"] = " HOOD_NAME, HOOD_ZONE ";
					$data["keyField"] = " HOOD_CODE ";
					$data["code"] = $queryItem["CLASS_GROUP_HOOD"];
					$CLASS_HOOD_DATA = $this->getFriendlyData($data)["message"];
					$CLASS_HOOD = $CLASS_HOOD_DATA["HOOD_NAME"];
					
					$data = array();
					$data["table"] = "wp_zones";
					$data["fields"] = " ZONE_NAME";
					$data["keyField"] = " ZONE_CODE ";
					$data["code"] = $CLASS_HOOD_DATA["HOOD_ZONE"];
					$CLASS_ZONE_DATA = $this->getFriendlyData($data)["message"];
					$CLASS_ZONE = $CLASS_ZONE_DATA["ZONE_NAME"];
					
					if($CLASS_EXCUSE != "" and $CLASS_EXCUSE != null and $CLASS_EXCUSE != "null")
					{
						$CLASS_EXCUSE = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($CLASS_EXCUSE));
						$CLASS_EXCUSE = json_decode($CLASS_EXCUSE, true);
						
						if(isset($CLASS_EXCUSE["EXCUSE_REASON"]) and $CLASS_EXCUSE["EXCUSE_REASON"] != "" and $CLASS_EXCUSE["EXCUSE_REASON"] != null and $CLASS_EXCUSE["EXCUSE_REASON"] != "null")
						{
							$EXCUSE_REASON = $CLASS_EXCUSE["EXCUSE_REASON"];
						}
						else
						{
							$EXCUSE_REASON = "-";
						}
						
						if(isset($CLASS_EXCUSE["EXCUSE_COMMENTS"]) and $CLASS_EXCUSE["EXCUSE_COMMENTS"] != "" and $CLASS_EXCUSE["EXCUSE_COMMENTS"] != null and $CLASS_EXCUSE["EXCUSE_COMMENTS"] != "null")
						{
							$EXCUSE_COMMENTS = $CLASS_EXCUSE["EXCUSE_COMMENTS"];
						}
						else
						{
							$EXCUSE_COMMENTS = "-";
						}
					}
					else
					{
						$EXCUSE_REASON = "";
						$EXCUSE_COMMENTS = "";
					}
					
					// GET ASSIST QTY AND STATUS
					$CLASS_STATUS = "Abierta";
					$CLASS_ATTENDERS = 0;
					for($z = 0; $z<count($CLASS_CITIZENS);$z++)
					{
						$cit = $CLASS_CITIZENS[$z];
						if($cit["CITIZEN_ASSIST"] == "1"){$CLASS_ATTENDERS++;}
					}
					if($CLASS_ATTENDERS > 0){$CLASS_STATUS = "Dictada";}
					if($CLASS_EXCUSE != "" AND $CLASS_EXCUSE != null and $CLASS_EXCUSE != "null"){$CLASS_STATUS = "No dictada";}
					
					
					
					// HERE IS WHERE IT MULTIPLIES-------------------------------
					// HERE IS WHERE IT MULTIPLIES-------------------------------
					
					$now = new DateTime();
					$now = $now->format('Y-m-d H:i:s');
					
					for($c = 0; $c<count($CLASS_CITIZENS);$c++)
					{
						$CITIZEN = $CLASS_CITIZENS[$c];
						$CITIZEN_IDTYPE = $CITIZEN["CITIZEN_IDTYPE"];
						$CITIZEN_IDNUM = $CITIZEN["CITIZEN_IDNUM"];
						$CITIZEN_BDAY = $CITIZEN["CITIZEN_BDAY"];
						$CITIZEN_AGE = $CITIZEN["CITIZEN_AGE"];
						$THISCITASSIST = $CITIZEN["CITIZEN_ASSIST"];
						
						if(isset($CITIZEN["CITIZEN_SAVED"]))
						{$CITIZEN_SAVED = $CITIZEN["CITIZEN_SAVED"];}
						else{$CITIZEN_SAVED = "-";}
						
						// ONLY INCLUDE THE ONES WHO ASSIST IF CLASS DICTATED
						if($CLASS_STATUS == "Abierta" or $CLASS_STATUS == "No dictada")
						{
							$exist = 0;
							for($a = 0; $a<count($assistLines);$a++)
							{if($assistLines[$a]["CLASS_CODE"] == $CLASS_CODE){$exist = 1;break;}}
							if($exist == 1){continue;}
							
						}
						else
						{
							if($THISCITASSIST == "0"){continue;}
						}
						
						// CHECK IF FULL CITIZEN ON TEMP ARRAY OR ADD
						$citizenFound = 0;
						for($g = 0; $g<count($FULL_CITIZENS);$g++)
						{
							$guy = $FULL_CITIZENS[$g];
							if($CITIZEN_IDNUM == $guy["CITIZEN_IDNUM"])
							{$citizenFound = 1;	$CITIZEN_DATA = $guy; break;}
						}
						
						if($citizenFound == 0)
						{
							$DATA_ORIGIN = "NEW";
							
							// GET CITIZEN DATA
							$data = array();
							$data["table"] = "wp_citizens";
							$data["fields"] = " CITIZEN_IDNUM, CITIZEN_NAME, CITIZEN_LASTNAME, CITIZEN_GENDER, CITIZEN_ADDRESS, CITIZEN_PHONE, CITIZEN_EMAIL, CITIZEN_ETNIA, CITIZEN_CONDITION, CITIZEN_HOOD, CITIZEN_ZONE, CITIZEN_LEVEL, CITIZEN_ETNIA_IND, CITIZEN_ORIGIN_COUNTRY, CITIZEN_DESTINY_COUNTRY, CITIZEN_STAY_REASON, CITIZEN_MIGREXP,  CITIZEN_INDATE, CITIZEN_OUTDATE, CITIZEN_RETURN_REASON, CITIZEN_SITAC, CITIZEN_ACUDIENT, CITIZEN_BIRTH_CITY, CITIZEN_SISCORE, CITIZEN_CONVAC, CITIZEN_TIPOCO, CITIZEN_TIPOVI, CITIZEN_HANDICAP, CITIZEN_ETGROUP, CITIZEN_SECURITY, CITIZEN_EPS, CITIZEN_PATOEN, CITIZEN_TRASDES, CITIZEN_RISKFA, CITIZEN_PREVFA, CITIZEN_WEIGHT, CITIZEN_HEIGHT, CITIZEN_IMC, CITIZEN_IMC_RATE, CITIZEN_EDLEVEL, CITIZEN_INSTITUTE, CITIZEN_COURSES, CITIZEN_OCUCOND, CITIZEN_INGREC, CITIZEN_BDAY ";
							
							
							$data["keyField"] = " CITIZEN_IDNUM ";
							$data["code"] = $CITIZEN_IDNUM;
							$CITIZEN_DATA = $this->getFriendlyData($data)["message"];
							
							// SET CITIZEN DATA FROM NEW OR SAVED
							if($CITIZEN_DATA == "none"){continue;}
							else
							{
								
								// GET CITIZEN BDAY FROM CITIZEN DIRECTLY
								$CITIZEN_BDAY = $CITIZEN_DATA["CITIZEN_BDAY"];
								// GET AGE
								$d1 = $CITIZEN_BDAY;
								$d2 = $now;
								$diff = abs(strtotime($d1) - strtotime($d2));
								$age = floor($diff / (365*60*60*24));
								$CITIZEN_AGE = $age;
								
								
								
								$CITIZEN_NAME = $CITIZEN_DATA["CITIZEN_NAME"];
								$CITIZEN_LASTNAME = $CITIZEN_DATA["CITIZEN_LASTNAME"];
								$CITIZEN_GENDER = $CITIZEN_DATA["CITIZEN_GENDER"];
								$CITIZEN_ADDRESS = $CITIZEN_DATA["CITIZEN_ADDRESS"];
								$CITIZEN_EMAIL = $CITIZEN_DATA["CITIZEN_EMAIL"];
								$CITIZEN_PHONE = $CITIZEN_DATA["CITIZEN_PHONE"];
								$CITIZEN_ETNIA = $CITIZEN_DATA["CITIZEN_ETNIA"];
								$CITIZEN_CONDITION = json_decode($CITIZEN_DATA["CITIZEN_CONDITION"], true);
								$CITIZEN_HOOD = $CITIZEN_DATA["CITIZEN_HOOD"];
								$CITIZEN_ZONE = $CITIZEN_DATA["CITIZEN_ZONE"];
								$CITIZEN_LEVEL = $CITIZEN_DATA["CITIZEN_LEVEL"];
								// ------***------
								$CITIZEN_ETNIA_IND = $CITIZEN_DATA["CITIZEN_ETNIA_IND"];
								$CITIZEN_ORIGIN_COUNTRY = $CITIZEN_DATA["CITIZEN_ORIGIN_COUNTRY"];
								$CITIZEN_DESTINY_COUNTRY = $CITIZEN_DATA["CITIZEN_DESTINY_COUNTRY"];
								$CITIZEN_STAY_REASON = $CITIZEN_DATA["CITIZEN_STAY_REASON"];
								$CITIZEN_MIGREXP = $CITIZEN_DATA["CITIZEN_MIGREXP"];
								$CITIZEN_INDATE = $CITIZEN_DATA["CITIZEN_INDATE"];
								$CITIZEN_OUTDATE = $CITIZEN_DATA["CITIZEN_OUTDATE"];
								$CITIZEN_RETURN_REASON = $CITIZEN_DATA["CITIZEN_RETURN_REASON"];
								$CITIZEN_SITAC = $CITIZEN_DATA["CITIZEN_SITAC"];
								$CITIZEN_ACUDIENT = $CITIZEN_DATA["CITIZEN_ACUDIENT"];
								$CITIZEN_BIRTH_CITY = $CITIZEN_DATA["CITIZEN_BIRTH_CITY"];
								$CITIZEN_SISCORE = $CITIZEN_DATA["CITIZEN_SISCORE"];
								$CITIZEN_CONVAC = $CITIZEN_DATA["CITIZEN_CONVAC"];
								$CITIZEN_TIPOCO = $CITIZEN_DATA["CITIZEN_TIPOCO"];
								$CITIZEN_TIPOVI = $CITIZEN_DATA["CITIZEN_TIPOVI"];
								$CITIZEN_HANDICAP = $CITIZEN_DATA["CITIZEN_HANDICAP"];
								$CITIZEN_ETGROUP = $CITIZEN_DATA["CITIZEN_ETGROUP"];
								$CITIZEN_SECURITY = $CITIZEN_DATA["CITIZEN_SECURITY"];
								$CITIZEN_EPS = $CITIZEN_DATA["CITIZEN_EPS"];
								$CITIZEN_PATOEN = $CITIZEN_DATA["CITIZEN_PATOEN"];
								$CITIZEN_TRASDES = $CITIZEN_DATA["CITIZEN_TRASDES"];
								$CITIZEN_RISKFA = json_decode($CITIZEN_DATA["CITIZEN_RISKFA"], true);
								$CITIZEN_PREVFA = json_decode($CITIZEN_DATA["CITIZEN_PREVFA"], true);
								$CITIZEN_WEIGHT = $CITIZEN_DATA["CITIZEN_WEIGHT"];
								$CITIZEN_HEIGHT = $CITIZEN_DATA["CITIZEN_HEIGHT"];
								$CITIZEN_IMC = $CITIZEN_DATA["CITIZEN_IMC"];
								$CITIZEN_IMC_RATE = $CITIZEN_DATA["CITIZEN_IMC_RATE"];
								$CITIZEN_EDLEVEL = $CITIZEN_DATA["CITIZEN_EDLEVEL"];
								$CITIZEN_INSTITUTE = $CITIZEN_DATA["CITIZEN_INSTITUTE"];
								$CITIZEN_COURSES = $CITIZEN_DATA["CITIZEN_COURSES"];
								$CITIZEN_OCUCOND = $CITIZEN_DATA["CITIZEN_OCUCOND"];
								$CITIZEN_INGREC = $CITIZEN_DATA["CITIZEN_INGREC"];
								
								if($CLASS_STATUS == "Abierta" or $CLASS_STATUS == "No dictada")
								{
									$CITIZEN_HOOD = "-";
									$CITIZEN_ZONE = "-";
									$CITIZEN_LEVEL = "-";
								}
							}
							
							// GET ETNIA DATA
							$data = array();
							$data["table"] = "wp_etnias";
							$data["fields"] = " ETNIA_NAME ";
							$data["keyField"] = " ETNIA_CODE ";
							$data["code"] = $CITIZEN_ETNIA;
							$ETNIA_DATA = $this->getFriendlyData($data)["message"];
							$CITIZEN_ETNIA = $ETNIA_DATA["ETNIA_NAME"];

							$CITIZEN_DATA["CITIZEN_ETNIA"] = $CITIZEN_ETNIA;
							
							// GET HOOD DATA
							$data = array();
							$data["table"] = "wp_hoods";
							$data["fields"] = " HOOD_NAME ";
							$data["keyField"] = " HOOD_CODE ";
							$data["code"] = $CITIZEN_HOOD;
							$HOOD_DATA = $this->getFriendlyData($data)["message"];
							if($HOOD_DATA != "none")
							{
								$CITIZEN_HOOD = $HOOD_DATA["HOOD_NAME"];
							}
							else
							{
								$CITIZEN_HOOD = "-";
							}
							
							$CITIZEN_DATA["CITIZEN_HOOD"] = $CITIZEN_HOOD;
							
							// GET ZONE DATA
							$data = array();
							$data["table"] = "wp_zones";
							$data["fields"] = " ZONE_NAME ";
							$data["keyField"] = " ZONE_CODE ";
							$data["code"] = $CITIZEN_ZONE;
							$ZONE_DATA = $this->getFriendlyData($data)["message"];
							if($ZONE_DATA != "none")
							{$CITIZEN_ZONE = $ZONE_DATA["ZONE_NAME"];}
							else{$CITIZEN_ZONE = "-";}
							
							$CITIZEN_DATA["CITIZEN_ZONE"] = $CITIZEN_ZONE;
							
							
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
							
							$CITIZEN_DATA["CITIZEN_CONDITION"] = $CITIZEN_CONDITION;
							
							
							// NEW FIELDS ADD
							// NEW FIELDS ADD
							// NEW FIELDS ADD
							// NEW FIELDS ADD
							// -------------------*------------------
							// -------------------*------------------
							// -------------------*------------------
							
							
							// $CITIZEN_ETNIA_IND = $CITIZEN_DATA["CITIZEN_ETNIA_IND"];
							// $data = array();
							// $data["table"] = "wp_master_tipoin";
							// $data["fields"] = " TIPOIN_NAME ";
							// $data["keyField"] = " TIPOIN_CODE ";
							// $data["code"] = $CITIZEN_ETNIA_IND;
							// $REG_DATA = $this->getFriendlyData($data)["message"];
							// if($REG_DATA != "none")
							// {$CITIZEN_ETNIA_IND = $REG_DATA["TIPOIN_NAME"];}
							// else{$CITIZEN_ETNIA_IND = "-";}
							
							// $CITIZEN_ORIGIN_COUNTRY = $CITIZEN_DATA["CITIZEN_ORIGIN_COUNTRY"];
							// $CITIZEN_DESTINY_COUNTRY = $CITIZEN_DATA["CITIZEN_DESTINY_COUNTRY"];
							
							// $CITIZEN_STAY_REASON = $CITIZEN_DATA["CITIZEN_STAY_REASON"];
							// $data = array();
							// $data["table"] = "wp_master_migrea";
							// $data["fields"] = " MIGREA_NAME ";
							// $data["keyField"] = " MIGREA_CODE ";
							// $data["code"] = $CITIZEN_STAY_REASON;
							// $REG_DATA = $this->getFriendlyData($data)["message"];
							// if($REG_DATA != "none")
							// {$CITIZEN_STAY_REASON = $REG_DATA["MIGREA_NAME"];}
							// else{$CITIZEN_STAY_REASON = "-";}
							
							// $CITIZEN_MIGREXP = $CITIZEN_DATA["CITIZEN_MIGREXP"];
							// $CITIZEN_INDATE = $CITIZEN_DATA["CITIZEN_INDATE"];
							// $CITIZEN_OUTDATE = $CITIZEN_DATA["CITIZEN_OUTDATE"];
							// $CITIZEN_RETURN_REASON = $CITIZEN_DATA["CITIZEN_RETURN_REASON"];
							// $CITIZEN_SITAC = $CITIZEN_DATA["CITIZEN_SITAC"];
							// $CITIZEN_ACUDIENT = $CITIZEN_DATA["CITIZEN_ACUDIENT"];
							// $CITIZEN_BIRTH_CITY = $CITIZEN_DATA["CITIZEN_BIRTH_CITY"];
							// $CITIZEN_SISCORE = $CITIZEN_DATA["CITIZEN_SISCORE"];
							
							// $CITIZEN_CONVAC = $CITIZEN_DATA["CITIZEN_CONVAC"];
							// $data = array();
							// $data["table"] = "wp_master_convac";
							// $data["fields"] = " CONVAC_NAME ";
							// $data["keyField"] = " CONVAC_CODE ";
							// $data["code"] = $CITIZEN_CONVAC;
							// $REG_DATA = $this->getFriendlyData($data)["message"];
							// if($REG_DATA != "none")
							// {$CITIZEN_CONVAC = $REG_DATA["CONVAC_NAME"];}
							// else{$CITIZEN_CONVAC = "-";}
							
							
							// $CITIZEN_TIPOCO = $CITIZEN_DATA["CITIZEN_TIPOCO"];
							// $data = array();
							// $data["table"] = "wp_master_tipoco";
							// $data["fields"] = " TIPOCO_NAME ";
							// $data["keyField"] = " TIPOCO_CODE ";
							// $data["code"] = $CITIZEN_TIPOCO;
							// $REG_DATA = $this->getFriendlyData($data)["message"];
							// if($REG_DATA != "none")
							// {$CITIZEN_TIPOCO = $REG_DATA["TIPOCO_NAME"];}
							// else{$CITIZEN_TIPOCO = "-";}
							
						
							// $CITIZEN_TIPOVI = $CITIZEN_DATA["CITIZEN_TIPOVI"];
							// $data = array();
							// $data["table"] = "wp_master_tipovi";
							// $data["fields"] = " TIPOVI_NAME ";
							// $data["keyField"] = " TIPOVI_CODE ";
							// $data["code"] = $CITIZEN_TIPOVI;
							// $REG_DATA = $this->getFriendlyData($data)["message"];
							// if($REG_DATA != "none")
							// {$CITIZEN_TIPOVI = $REG_DATA["TIPOVI_NAME"];}
							// else{$CITIZEN_TIPOVI = "-";}
							
							
							// $CITIZEN_HANDICAP = $CITIZEN_DATA["CITIZEN_HANDICAP"];
							// $CITIZEN_ETGROUP = $CITIZEN_DATA["CITIZEN_ETGROUP"];
							// $CITIZEN_SECURITY = $CITIZEN_DATA["CITIZEN_SECURITY"];
							
							// $CITIZEN_EPS = $CITIZEN_DATA["CITIZEN_EPS"];
							// $data = array();
							// $data["table"] = "wp_master_eps";
							// $data["fields"] = " EPS_NAME ";
							// $data["keyField"] = " EPS_CODE ";
							// $data["code"] = $CITIZEN_EPS;
							// $REG_DATA = $this->getFriendlyData($data)["message"];
							// if($REG_DATA != "none")
							// {$CITIZEN_EPS = $REG_DATA["EPS_NAME"];}
							// else{$CITIZEN_EPS = "-";}
							
							
							// $CITIZEN_PATOEN = $CITIZEN_DATA["CITIZEN_PATOEN"];
							// $data = array();
							// $data["table"] = "wp_master_patoen";
							// $data["fields"] = " PATOEN_NAME ";
							// $data["keyField"] = " PATOEN_CODE ";
							// $data["code"] = $CITIZEN_PATOEN;
							// $REG_DATA = $this->getFriendlyData($data)["message"];
							// if($REG_DATA != "none")
							// {$CITIZEN_PATOEN = $REG_DATA["PATOEN_NAME"];}
							// else{$CITIZEN_PATOEN = "-";}
							
							
							// $CITIZEN_TRASDES = $CITIZEN_DATA["CITIZEN_TRASDES"];
							// $data = array();
							// $data["table"] = "wp_master_trasdes";
							// $data["fields"] = " TRASDES_NAME ";
							// $data["keyField"] = " TRASDES_CODE ";
							// $data["code"] = $CITIZEN_TRASDES;
							// $REG_DATA = $this->getFriendlyData($data)["message"];
							// if($REG_DATA != "none")
							// {$CITIZEN_TRASDES = $REG_DATA["TRASDES_NAME"];}
							// else{$CITIZEN_TRASDES = "-";}
							
							// $friendlyLine = "";
							// if(is_array($CITIZEN_RISKFA))
							// {
								// for($n = 0; $n<count($CITIZEN_RISKFA);$n++)
								// {
									// $itemCode = $CITIZEN_RISKFA[$n];
									// $data = array();
									// $data["table"] = "wp_master_riskfa";
									// $data["fields"] = " RISKFA_NAME ";
									// $data["keyField"] = " RISKFA_CODE ";
									// $data["code"] = $itemCode;
									// $REG_DATA = $this->getFriendlyData($data)["message"];
									// $RISKFA_NAME = $REG_DATA["RISKFA_NAME"];
									// if($n < count($CITIZEN_RISKFA)-1)
									// {$friendlyLine .= $RISKFA_NAME;	$friendlyLine .= ", ";}
									// else{$friendlyLine .= $RISKFA_NAME;}
								// }
								// $CITIZEN_RISKFA = $friendlyLine;
							// }
							// else
							// {
								// $CITIZEN_RISKFA = "";
							// }
							
							
							// $friendlyLine = "";
							// if(is_array($CITIZEN_RISKFA))
							// {
								// for($n = 0; $n<count($CITIZEN_PREVFA);$n++)
								// {
									// $itemCode = $CITIZEN_PREVFA[$n];
									// $data = array();
									// $data["table"] = "wp_master_prevfa";
									// $data["fields"] = " PREVFA_NAME ";
									// $data["keyField"] = " PREVFA_CODE ";
									// $data["code"] = $itemCode;
									// $REG_DATA = $this->getFriendlyData($data)["message"];
									// $PREVFA = $REG_DATA["PREVFA_NAME"];
									// if($n < count($CITIZEN_PREVFA)-1)
									// {$friendlyLine .= $PREVFA;	$friendlyLine .= ", ";}
									// else{$friendlyLine .= $PREVFA;}
								// }
								// $CITIZEN_PREVFA = $friendlyLine;
							// }
							// else
							// {
								// $CITIZEN_PREVFA = "";
							// }
							
		
							// $CITIZEN_WEIGHT = $CITIZEN_DATA["CITIZEN_WEIGHT"];
							// $CITIZEN_HEIGHT = $CITIZEN_DATA["CITIZEN_HEIGHT"];
							// $CITIZEN_IMC = $CITIZEN_DATA["CITIZEN_IMC"];
							// $CITIZEN_IMC_RATE = $CITIZEN_DATA["CITIZEN_IMC_RATE"];

							// $CITIZEN_EDLEVEL = $CITIZEN_DATA["CITIZEN_EDLEVEL"];
							// $data = array();
							// $data["table"] = "wp_master_edlevel";
							// $data["fields"] = " EDLEVEL_NAME ";
							// $data["keyField"] = " EDLEVEL_CODE ";
							// $data["code"] = $CITIZEN_EDLEVEL;
							// $REG_DATA = $this->getFriendlyData($data)["message"];
							// if($REG_DATA != "none")
							// {$CITIZEN_EDLEVEL = $REG_DATA["EDLEVEL_NAME"];}
							// else{$CITIZEN_EDLEVEL = "-";}
													
							
							// $CITIZEN_INSTITUTE = $CITIZEN_DATA["CITIZEN_INSTITUTE"];
							// $data = array();
							// $data["table"] = "wp_institutes";
							// $data["fields"] = " INSTITUTE_NAME ";
							// $data["keyField"] = " INSTITUTE_CODE ";
							// $data["code"] = $CITIZEN_INSTITUTE;
							// $REG_DATA = $this->getFriendlyData($data)["message"];
							// if($REG_DATA != "none")
							// {$CITIZEN_INSTITUTE = $REG_DATA["INSTITUTE_NAME"];}
							// else{$CITIZEN_INSTITUTE = "-";}
							
							
							// $CITIZEN_COURSES = $CITIZEN_DATA["CITIZEN_COURSES"];
							// $data = array();
							// $data["table"] = "wp_master_courses";
							// $data["fields"] = " COURSES_NAME ";
							// $data["keyField"] = " COURSES_CODE ";
							// $data["code"] = $CITIZEN_COURSES;
							// $REG_DATA = $this->getFriendlyData($data)["message"];
							// if($REG_DATA != "none")
							// {$CITIZEN_COURSES = $REG_DATA["COURSES_NAME"];}
							// else{$CITIZEN_COURSES = "-";}
							
							// $CITIZEN_OCUCOND = $CITIZEN_DATA["CITIZEN_OCUCOND"];
							// $data = array();
							// $data["table"] = "wp_master_ocucond";
							// $data["fields"] = " OCUCOND_NAME ";
							// $data["keyField"] = " OCUCOND_CODE ";
							// $data["code"] = $CITIZEN_OCUCOND;
							// $REG_DATA = $this->getFriendlyData($data)["message"];
							// if($REG_DATA != "none")
							// {$CITIZEN_OCUCOND = $REG_DATA["OCUCOND_NAME"];}
							// else{$CITIZEN_OCUCOND = "-";}
							
							// $CITIZEN_INGREC = $CITIZEN_DATA["CITIZEN_INGREC"];
							// $data = array();
							// $data["table"] = "wp_master_ingrec";
							// $data["fields"] = " INGREC_NAME ";
							// $data["keyField"] = " INGREC_CODE ";
							// $data["code"] = $CITIZEN_INGREC;
							// $REG_DATA = $this->getFriendlyData($data)["message"];
							// if($REG_DATA != "none")
							// {$CITIZEN_INGREC = $REG_DATA["INGREC_NAME"];}
							// else{$CITIZEN_INGREC = "-";}
							
							
							// -------------------*------------------
							// -------------------*------------------
							// -------------------*------------------
							
							if(!in_array($CITIZEN["CITIZEN_IDNUM"], $FULL_CITIZENS_ADDED))
							{
								array_push($FULL_CITIZENS, $CITIZEN_DATA);
								array_push($FULL_CITIZENS_ADDED, $CITIZEN_DATA["CITIZEN_IDNUM"]);
							}

						}
						else
						{
							$DATA_ORIGIN = "RECYCLED";
							
							$CITIZEN_NAME = $CITIZEN_DATA["CITIZEN_NAME"];
							$CITIZEN_LASTNAME = $CITIZEN_DATA["CITIZEN_LASTNAME"];
							$CITIZEN_GENDER = $CITIZEN_DATA["CITIZEN_GENDER"];
							$CITIZEN_ADDRESS = $CITIZEN_DATA["CITIZEN_ADDRESS"];
							$CITIZEN_EMAIL = $CITIZEN_DATA["CITIZEN_EMAIL"];
							$CITIZEN_PHONE = $CITIZEN_DATA["CITIZEN_PHONE"];
							$CITIZEN_ETNIA = $CITIZEN_DATA["CITIZEN_ETNIA"];
							$CITIZEN_CONDITION = json_decode($CITIZEN_DATA["CITIZEN_CONDITION"], true);
							$CITIZEN_HOOD = $CITIZEN_DATA["CITIZEN_HOOD"];
							$CITIZEN_ZONE = $CITIZEN_DATA["CITIZEN_ZONE"];
							$CITIZEN_LEVEL = $CITIZEN_DATA["CITIZEN_LEVEL"];
							$CITIZEN_CONDITION = $CITIZEN_DATA["CITIZEN_CONDITION"];
							// ----***---
							
							
							// $CITIZEN_ETNIA_IND = $CITIZEN_DATA["CITIZEN_ETNIA_IND"];
							// $CITIZEN_ORIGIN_COUNTRY = $CITIZEN_DATA["CITIZEN_ORIGIN_COUNTRY"];
							// $CITIZEN_DESTINY_COUNTRY = $CITIZEN_DATA["CITIZEN_DESTINY_COUNTRY"];
							// $CITIZEN_STAY_REASON = $CITIZEN_DATA["CITIZEN_STAY_REASON"];
							// $CITIZEN_MIGREXP = $CITIZEN_DATA["CITIZEN_MIGREXP"];
							// $CITIZEN_INDATE = $CITIZEN_DATA["CITIZEN_INDATE"];
							// $CITIZEN_OUTDATE = $CITIZEN_DATA["CITIZEN_OUTDATE"];
							// $CITIZEN_RETURN_REASON = $CITIZEN_DATA["CITIZEN_RETURN_REASON"];
							// $CITIZEN_SITAC = $CITIZEN_DATA["CITIZEN_SITAC"];
							// $CITIZEN_ACUDIENT = $CITIZEN_DATA["CITIZEN_ACUDIENT"];
							// $CITIZEN_BIRTH_CITY = $CITIZEN_DATA["CITIZEN_BIRTH_CITY"];
							// $CITIZEN_SISCORE = $CITIZEN_DATA["CITIZEN_SISCORE"];
							// $CITIZEN_CONVAC = $CITIZEN_DATA["CITIZEN_CONVAC"];
							// $CITIZEN_TIPOCO = $CITIZEN_DATA["CITIZEN_TIPOCO"];
							// $CITIZEN_TIPOVI = $CITIZEN_DATA["CITIZEN_TIPOVI"];
							// $CITIZEN_HANDICAP = $CITIZEN_DATA["CITIZEN_HANDICAP"];
							// $CITIZEN_ETGROUP = $CITIZEN_DATA["CITIZEN_ETGROUP"];
							// $CITIZEN_SECURITY = $CITIZEN_DATA["CITIZEN_SECURITY"];
							// $CITIZEN_EPS = $CITIZEN_DATA["CITIZEN_EPS"];
							// $CITIZEN_PATOEN = $CITIZEN_DATA["CITIZEN_PATOEN"];
							// $CITIZEN_TRASDES = $CITIZEN_DATA["CITIZEN_TRASDES"];
							// $CITIZEN_RISKFA = $CITIZEN_DATA["CITIZEN_RISKFA"];
							// $CITIZEN_PREVFA = $CITIZEN_DATA["CITIZEN_PREVFA"];
							// $CITIZEN_WEIGHT = $CITIZEN_DATA["CITIZEN_WEIGHT"];
							// $CITIZEN_HEIGHT = $CITIZEN_DATA["CITIZEN_HEIGHT"];
							// $CITIZEN_IMC = $CITIZEN_DATA["CITIZEN_IMC"];
							// $CITIZEN_IMC_RATE = $CITIZEN_DATA["CITIZEN_IMC_RATE"];
							// $CITIZEN_EDLEVEL = $CITIZEN_DATA["CITIZEN_EDLEVEL"];
							// $CITIZEN_INSTITUTE = $CITIZEN_DATA["CITIZEN_INSTITUTE"];
							// $CITIZEN_COURSES = $CITIZEN_DATA["CITIZEN_COURSES"];
							// $CITIZEN_OCUCOND = $CITIZEN_DATA["CITIZEN_OCUCOND"];
							// $CITIZEN_INGREC = $CITIZEN_DATA["CITIZEN_INGREC"];


						}
						


						
						$assistLine = array();
						$assistLine["CLASS_CODE"] = $CLASS_CODE;
						$assistLine["CLASS_CREATED"] = $CLASS_CREATED;
						$assistLine["CLASS_DATE"] = explode(" ", $queryItem["CLASS_DATE"])[0];
						$assistLine["CLASS_INI"] = $CLASS_INI;
						$assistLine["CLASS_END"] = $CLASS_END;
						$assistLine["ENTITY_NAME"] = $ENTITY_NAME; // FIXED
						$assistLine["CLASS_STATUS"] = $CLASS_STATUS;
						$assistLine["CLASS_ATTENDERS"] = $CLASS_ATTENDERS;
						$assistLine["EXCUSE_REASON"] = $EXCUSE_REASON;
						$assistLine["EXCUSE_COMMENTS"] = $EXCUSE_COMMENTS;
						$assistLine["CONTRACT_NUMBER"] = $CONTRACT_NUMBER;
						$assistLine["CONTRACT_INIDATE"] = $CONTRACT_INIDATE;
						$assistLine["CONTRACT_ENDATE"] = $CONTRACT_ENDATE;
						$assistLine["CONTRACT_USERTYPE"] = $CONTRACT_USERTYPE;
						$assistLine["CLASS_USER_IDTYPE"] = $CLASS_USER_IDTYPE;
						$assistLine["CLASS_USER_IDNUM"] = $CLASS_USER_IDNUM;
						$assistLine["CLASS_USER_NAME"] = $CLASS_USER_NAME;
						$assistLine["CLASS_USER_LASTNAME"] = $CLASS_USER_LASTNAME;
						$assistLine["CONTRACT_OTHER_GOALS"] = $CLASS_GROUP_GOAL;
						$assistLine["CLASSES_GOAL"] = $CLASS_CLASSES_GOAL;
						$assistLine["HOURS_GOAL"] = $CLASS_TIMES_GOAL;
						$assistLine["PEOPLE_GOAL"] = $CLASS_PEOPLE_GOAL;
						$assistLine["CLASS_GROUP_NAME"] = $GROUP_NAME;
						$assistLine["PROGRAM_NAME"] = $PROGRAM_NAME;
						$assistLine["PROJECT_NAME"] = $PROJECT_NAME;
						$assistLine["ACTIVITY_NAME"] = $ACTIVITY_NAME; 
						$assistLine["GROUP_INSTYPE"] = $GROUP_INSTYPE; 
						$assistLine["GROUP_PREVIR"] = $GROUP_PREVIR;
						$assistLine["GROUP_ADDRESS"] = $GROUP_ADDRESS;
						$assistLine["GROUP_COORDS"] = $GROUP_COORDS;
						$assistLine["CLASS_HOOD"] = $CLASS_HOOD;
						$assistLine["CLASS_ZONE"] = $CLASS_ZONE;
						$assistLine["COOPERATOR_IDTYPE"] = $COOPERATOR_IDTYPE;
						$assistLine["COOPERATOR_IDNUM"] = $COOPERATOR_IDNUM;
						$assistLine["COOPERATOR_NAME"] = $COOPERATOR_NAME;
						$assistLine["COOPERATOR_LASTNAME"] = $COOPERATOR_LASTNAME;
						$assistLine["COOPERATOR_PHONE"] = $COOPERATOR_PHONE;
						$assistLine["COOPERATOR_EMAIL"] = $COOPERATOR_EMAIL;
						
						// RECYCLED
						
						$assistLine["CITIZEN_IDTYPE"] = $CITIZEN_IDTYPE;
						$assistLine["CITIZEN_IDNUM"] = $CITIZEN_IDNUM;
						$assistLine["CITIZEN_NAME"] = $CITIZEN_NAME;
						$assistLine["CITIZEN_LASTNAME"] = $CITIZEN_LASTNAME;
						$assistLine["CITIZEN_GENDER"] = $CITIZEN_GENDER;
						$assistLine["CITIZEN_BDAY"] = $CITIZEN_BDAY;
						$assistLine["CITIZEN_AGE"] = $CITIZEN_AGE;
						$assistLine["CITIZEN_ADDRESS"] = $CITIZEN_ADDRESS;
						$assistLine["CITIZEN_EMAIL"] = $CITIZEN_EMAIL;
						$assistLine["CITIZEN_PHONE"] = $CITIZEN_PHONE;
						$assistLine["CITIZEN_ETNIA"] = $CITIZEN_ETNIA;
						$assistLine["CITIZEN_CONDITION"] = $CITIZEN_CONDITION;
						$assistLine["CITIZEN_HOOD"] = $CITIZEN_HOOD;
						$assistLine["CITIZEN_ZONE"] = $CITIZEN_ZONE;
						$assistLine["CITIZEN_LEVEL"] = $CITIZEN_LEVEL;
						$assistLine["CITIZEN_SAVED"] = $CITIZEN_SAVED;
						
						// -----***-----
						
						// $assistLine["CITIZEN_ETNIA_IND"] = $CITIZEN_ETNIA_IND;
						// $assistLine["CITIZEN_ORIGIN_COUNTRY"] = $CITIZEN_ORIGIN_COUNTRY;
						// $assistLine["CITIZEN_DESTINY_COUNTRY"] = $CITIZEN_DESTINY_COUNTRY;
						// $assistLine["CITIZEN_STAY_REASON"] = $CITIZEN_STAY_REASON;
						// $assistLine["CITIZEN_MIGREXP"] = $CITIZEN_MIGREXP;
						// $assistLine["CITIZEN_INDATE"] = $CITIZEN_INDATE;
						// $assistLine["CITIZEN_OUTDATE"] = $CITIZEN_OUTDATE;
						// $assistLine["CITIZEN_RETURN_REASON"] = $CITIZEN_RETURN_REASON;
						// $assistLine["CITIZEN_SITAC"] = $CITIZEN_SITAC;
						// $assistLine["CITIZEN_ACUDIENT"] = $CITIZEN_ACUDIENT;
						// $assistLine["CITIZEN_BIRTH_CITY"] = $CITIZEN_BIRTH_CITY;
						// $assistLine["CITIZEN_SISCORE"] = $CITIZEN_SISCORE;
						// $assistLine["CITIZEN_CONVAC"] = $CITIZEN_CONVAC;
						// $assistLine["CITIZEN_TIPOCO"] = $CITIZEN_TIPOCO;
						// $assistLine["CITIZEN_TIPOVI"] = $CITIZEN_TIPOVI;
						// $assistLine["CITIZEN_HANDICAP"] = $CITIZEN_HANDICAP;
						// $assistLine["CITIZEN_ETGROUP"] = $CITIZEN_ETGROUP;
						// $assistLine["CITIZEN_SECURITY"] = $CITIZEN_SECURITY;
						// $assistLine["CITIZEN_EPS"] = $CITIZEN_EPS;
						// $assistLine["CITIZEN_PATOEN"] = $CITIZEN_PATOEN;
						// $assistLine["CITIZEN_TRASDES"] = $CITIZEN_TRASDES;
						// $assistLine["CITIZEN_RISKFA"] = $CITIZEN_RISKFA;
						// $assistLine["CITIZEN_PREVFA"] = $CITIZEN_PREVFA;
						// $assistLine["CITIZEN_WEIGHT"] = $CITIZEN_WEIGHT;
						// $assistLine["CITIZEN_HEIGHT"] = $CITIZEN_HEIGHT;
						// $assistLine["CITIZEN_IMC"] = $CITIZEN_IMC;
						// $assistLine["CITIZEN_IMC_RATE"] = $CITIZEN_IMC_RATE;
						// $assistLine["CITIZEN_EDLEVEL"] = $CITIZEN_EDLEVEL;
						// $assistLine["CITIZEN_INSTITUTE"] = $CITIZEN_INSTITUTE;
						// $assistLine["CITIZEN_COURSES"] = $CITIZEN_COURSES;
						// $assistLine["CITIZEN_OCUCOND"] = $CITIZEN_OCUCOND;
						// $assistLine["CITIZEN_INGREC"] = $CITIZEN_INGREC;
						


						if($CLASS_STATUS == "Abierta" or $CLASS_STATUS == "No dictada")
						{
							$assistLine["CITIZEN_IDTYPE"] = "-";
							$assistLine["CITIZEN_IDNUM"] = "-";
							$assistLine["CITIZEN_NAME"] = "-";
							$assistLine["CITIZEN_LASTNAME"] = "-";
							$assistLine["CITIZEN_GENDER"] = "-";
							$assistLine["CITIZEN_BDAY"] = "-";
							$assistLine["CITIZEN_AGE"] = "-";
							$assistLine["CITIZEN_ADDRESS"] = "-";
							$assistLine["CITIZEN_EMAIL"] = "-";
							$assistLine["CITIZEN_PHONE"] = "-";
							$assistLine["CITIZEN_ETNIA"] = "-";
							$assistLine["CITIZEN_CONDITION"] = "-";
							$assistLine["CITIZEN_LEVEL"] = "-";
							$assistLine["CITIZEN_SAVED"] = "-";
							// ----***-----
							$assistLine["CITIZEN_ETNIA_IND"] = "-";
							$assistLine["CITIZEN_ORIGIN_COUNTRY"] = "-";
							$assistLine["CITIZEN_DESTINY_COUNTRY"] = "-";
							$assistLine["CITIZEN_STAY_REASON"] = "-";
							$assistLine["CITIZEN_MIGREXP"] = "-";
							$assistLine["CITIZEN_INDATE"] = "-";
							$assistLine["CITIZEN_OUTDAT"] = "-";
							$assistLine["CITIZEN_RETURN_REASON"] = "-";
							$assistLine["CITIZEN_SITAC"] = "-";
							$assistLine["CITIZEN_ACUDIENT"] = "-";
							$assistLine["CITIZEN_BIRTH_CITY"] = "-";
							$assistLine["CITIZEN_SISCORE"] = "-";
							$assistLine["CITIZEN_CONVAC"] = "-";
							$assistLine["CITIZEN_TIPOCO"] = "-";
							$assistLine["CITIZEN_TIPOVI"] = "-";
							$assistLine["CITIZEN_HANDICAP"] = "-";
							$assistLine["CITIZEN_ETGROUP"] = "-";
							$assistLine["CITIZEN_SECURITY"] = "-";
							$assistLine["CITIZEN_EPS"] = "-";
							$assistLine["CITIZEN_PATOEN"] = "-";
							$assistLine["CITIZEN_TRASDES"] = "-";
							$assistLine["CITIZEN_RISKFA"] = "-";
							$assistLine["CITIZEN_PREVFA"] = "-";
							$assistLine["CITIZEN_WEIGHT"] = "-";
							$assistLine["CITIZEN_HEIGHT"] = "-";
							$assistLine["CITIZEN_IMC"] = "-";
							$assistLine["CITIZEN_IMC_RATE"] = "-";
							$assistLine["CITIZEN_EDLEVEL"] = "-";
							$assistLine["CITIZEN_INSTITUTE"] = "-";
							$assistLine["CITIZEN_COURSES"] = "-";
							$assistLine["CITIZEN_OCUCOND"] = "-";
							$assistLine["CITIZEN_INGREC"] = "-";
							
							
						}
						
						array_push($assistLines, $assistLine);
						
						
					}
				}
				
				$exported = $this->excelCreate($EXPORT, $assistLines);
				$resp["path"] = $exported;
			}
		}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function stringFromArray($arr)
	{
		$str = "";
		for($i = 0; $i<count($arr);$i++)
		{
			$str = $str.$arr[$i];
			if($i<(count($arr)-1)){$str = $str.", ";}
		}
		return $str;
	}
	
	// REPORT STARTER
	function reportStart($info)
	{
		$entity = $info["ENTITY"];
		$admin = $info["ADMIN"];
		
		$answer = array();
		
		
		if($admin != "Superior")
		{$str = "SELECT * FROM wp_programs WHERE PROGRAM_ENTITY = '$entity' ORDER BY PROGRAM_NAME ASC";}
		else{$str = "SELECT * FROM wp_programs ORDER BY PROGRAM_NAME ASC";}
		$programs = $this->db->query($str);
		
		
		if($admin != "Superior")
		{$str = "SELECT * FROM wp_projects WHERE PROJECT_ENTITY = '$entity' ORDER BY PROJECT_NAME ASC";}
		else{$str = "SELECT * FROM wp_projects ORDER BY PROJECT_NAME ASC";}
		$projects = $this->db->query($str);
		
		
		if($admin != "Superior")
		{$str = "SELECT * FROM wp_activities WHERE ACTIVITY_ENTITY = '$entity' ORDER BY ACTIVITY_NAME ASC";}
		else{$str = "SELECT * FROM wp_activities ORDER BY ACTIVITY_NAME ASC";}
		$activities = $this->db->query($str);
		
	
		if($admin != "Superior")
		{$str = "SELECT * FROM wp_etaries WHERE ETARIE_ENTITY = '$entity' ORDER BY ETARIE_FROM ASC";}
		else{$str = "SELECT * FROM wp_etaries ORDER BY ETARIE_FROM ASC";}
		$etaries = $this->db->query($str);
		
		
		if($admin != "Superior")
		{$str = "SELECT * FROM wp_groups WHERE GROUP_ENTITY = '$entity' ORDER BY GROUP_NAME ASC";}
		else{$str = "SELECT * FROM wp_groups ORDER BY GROUP_NAME ASC";}
		$groups = $this->db->query($str);
		
		
		$picked = "CONTRACT_CODE, CONTRACT_REQTYPE, CONTRACT_NUMBER, CONTRACT_INIDATE, CONTRACT_ENDATE, CONTRACT_USERTYPE, CONTRACT_PROGRAM, CONTRACT_ACTIVITIES, CONTRACT_ZONES, CONTRACT_CREATED, CONTRACT_STATE, CONTRACT_REQUESTER, CONTRACT_OWNER, CONTRACT_ENTITY, CONTRACT_VISIT_GOALS, CONTRACT_OTHER_GOALS, CONTRACT_EVENT_GOALS"; 
		if($admin != "Superior")
		{$str = "SELECT $picked FROM wp_contracts WHERE CONTRACT_ENTITY = '$entity' ORDER BY CONTRACT_NUMBER ASC";}
		else{$str = "SELECT $picked FROM wp_contracts ORDER BY CONTRACT_NUMBER ASC";}
		$contracts = $this->db->query($str);
		
		
		$picked = "EVENT_CODE, EVENT_TYPE, EVENT_CREATED, EVENT_ENTITY, EVENT_OWNER, EVENT_DATE_INI, EVENT_DATE_END, EVENT_HOOD, EVENT_PREVIR, EVENT_ADDRESS, EVENT_COORDS, EVENT_ACTIVITIES, EVENT_SUPPORT_TEAM, EVENT_INSTYPE, EVENT_INSTITUTE, EVENT_COOPTYPE, EVENT_NAME, EVENT_COOPERATOR, EVENT_ASSIST, EVENT_TOTAL_PEOPLE, EVENT_RESUME, EVENT_AUTHOR, EVENT_STATUS, EVENT_REQUESTER, EVENT_ORIGIN, EVENT_RADICATE, EVENT_REQUEST_DATE, EVENT_REQUEST_TYPE, EVENT_REQUEST_ACTIVITY, EVENT_EXPECTED, EVENT_NEEDS, EVENT_DESCRIPTION, EVENT_DATE_INIR, EVENT_DATE_ENDR, EVENT_REJECT_REASON, EVENT_SERVPLACE, EVENT_CONTRACT_CODE ";  
		if($admin != "Superior")
		{$str = "SELECT $picked FROM wp_events WHERE EVENT_ENTITY = '$entity' ORDER BY EVENT_NAME ASC";}
		else{$str = "SELECT $picked FROM wp_events ORDER BY EVENT_NAME ASC";}
		$events = $this->db->query($str);

		
		$picked = "VISIT_ENTITY, VISIT_CODE, VISIT_CLASS, VISIT_DATE, VISIT_OWNER, VISIT_DONE, VISIT_TYPE, VISIT_ASSISTQTY, VISIT_NOASSISTQTY, VISIT_STONTIME, VISIT_TOOLS, VISIT_GOODTIME, VISIT_GOODPLACE, VISIT_FORMAT, VISIT_PDELIVER, VISIT_COHERENT, VISIT_EASY, VISIT_ORIENT, VISIT_EXPRESSION, VISIT_PRESENT, VISIT_VERIFIED, VISIT_ACOMPLISH, VISIT_CONTRATIST_SIGN, VISIT_COMMENTS, VISIT_GROUP, VISIT_CONTRACT, VISIT_ACTIVITY, VISIT_CLASS_DATE, VISIT_CLASS_INI_TIME, VISIT_COORD, VISIT_CLASS_COORD, VISIT_CONTRATIST, VISIT_VISITOR, VISIT_GROUP_NAME, VISIT_HOOD, VISIT_ADDRESS, VISIT_MODE, VISIT_ZONE, VISIT_CONTRACT_CODE, VISIT_SIGNED";   
		if($admin != "Superior")
		{$str = "SELECT $picked FROM wp_visits WHERE VISIT_ENTITY = '$entity' ORDER BY VISIT_DATE ASC";}
		else{$str = "SELECT $picked FROM wp_visits ORDER BY VISIT_DATE ASC";}
		$visits = $this->db->query($str);
		

		$picked = "USER_CODE, USER_ENTITY, USER_IDTYPE, USER_IDNUM, USER_BDAY, USER_PHONE, USER_EMAIL, USER_PASS, USER_REGDATE, USER_STATUS, USER_TYPE, USER_CALLER, USER_CALLER_GOAL, USER_CALLER_ENDATE, CONCAT(USER_NAME,' ',USER_LASTNAME) AS USER_FULL_NAME "; 
		if($admin != "Superior")
		{$str = "SELECT $picked FROM wp_trusers WHERE USER_ENTITY = '$entity' ORDER BY USER_NAME ASC";}
		else{$str = "SELECT $picked FROM wp_trusers ORDER BY USER_NAME ASC";}
		$contratists = $this->db->query($str);
		
		// GENERAL BASES ---------------------------
		
		$str = "SELECT * FROM wp_entities ORDER BY ENTITY_NAME ASC";
		$entities = $this->db->query($str);
		
		$str = "SELECT * FROM wp_zones ORDER BY ZONE_NAME ASC";
		$zones = $this->db->query($str);
		
		$str = "SELECT * FROM wp_hoods ORDER BY HOOD_NAME ASC";
		$hoods = $this->db->query($str);
		
		$str = "SELECT * FROM wp_institutes ORDER BY INSTITUTE_NAME ASC";
		$institutes = $this->db->query($str);
		
		$str = "SELECT * FROM wp_conditions ORDER BY CONDITION_NAME ASC";
		$conditions = $this->db->query($str);
		
		$str = "SELECT * FROM wp_etnias ORDER BY ETNIA_NAME ASC";
		$etnias = $this->db->query($str);
		
		$picked = "CITIZEN_CODE, CITIZEN_IDTYPE, CITIZEN_IDNUM, CITIZEN_BDAY, CITIZEN_PHONE, CITIZEN_EMAIL, CITIZEN_ADDRESS, CITIZEN_GENDER, CITIZEN_ETNIA, CITIZEN_CONDITION, CITIZEN_CITY, CITIZEN_ZONE, CITIZEN_HOOD, CITIZEN_LEVEL, CONCAT(CITIZEN_NAME,' ',CITIZEN_LASTNAME) AS CITIZEN_FULL_NAME "; 
		$str = "SELECT $picked FROM wp_citizens ORDER BY CITIZEN_NAME ASC";
		$citizens = $this->db->query($str);
		
		
		// $picked = "CLASS_CODE, CLASS_ENTITY, CLASS_GROUP, CLASS_ACTIVITY, CLASS_HOUR, CLASS_TUTOR,  CLASS_DATE, CLASS_CITIZENS, CLASS_CONTRACT_NUMBER, CLASS_ACTIVITY_GOALS, CLASS_CONTRACT_CODE, CLASS_GROUP_GOAL, CLASS_CLASSES_GOAL, CLASS_TIMES_GOAL, CLASS_PEOPLE_GOAL";
		// $str = "SELECT $picked FROM wp_classes ORDER BY CLASS_DATE ASC";
		// $classes = $this->db->query($str);
		
		// TRAER CONTRATOS 
		
		$answer["entities"] = $entities;
		$answer["programs"] = $programs;
		$answer["projects"] = $projects;
		$answer["activities"] = $activities;
		$answer["zones"] = $zones;
		$answer["hoods"] = $hoods;
		$answer["institutes"] = $institutes;
		$answer["conditions"] = $conditions;
		$answer["etnias"] = $etnias;
		$answer["etaries"] = $etaries;
		$answer["citizens"] = $citizens;
		$answer["groups"] = $groups;
		$answer["contracts"] = $contracts;
		$answer["events"] = $events;
		$answer["visits"] = $visits;
		$answer["contratists"] = $contratists;
		
		$resp["message"] = $answer;
		$resp["status"] = true; 
		return $resp;
		
		
	}
	
	function getContractGroups($info)
	{
		$CONTRACT_CODE = $info["CONTRACT_CODE"];
		
		$str = "SELECT * FROM wp_groups WHERE 
		GROUP_CONTRACT = '".$CONTRACT_CODE."'";
		$query = $this->db->query($str);
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function getClassBlock($info)
	{
		$INIDATE = $info["INIDATE"];
		$ENDATE = $info["ENDATE"];
		
		$ENTITY = $info["ENTITY"];
		$ADMIN = $info["ADMIN"];
		
		
		
		$picked = "CLASS_CODE, CLASS_ENTITY, CLASS_GROUP, CLASS_ACTIVITY, CLASS_HOUR, CLASS_TUTOR,  CLASS_DATE, CLASS_CITIZENS, CLASS_CONTRACT_NUMBER, CLASS_ACTIVITY_GOALS, CLASS_CONTRACT_CODE, CLASS_GROUP_GOAL, CLASS_CLASSES_GOAL, CLASS_TIMES_GOAL, CLASS_PEOPLE_GOAL";
		
		$str = "SELECT $picked FROM wp_classes WHERE CLASS_DATE >= '$INIDATE' AND CLASS_DATE <= '$ENDATE' AND CLASS_ENTITY = '$ENTITY' ORDER BY CLASS_DATE ASC";
		$classes = $this->db->query($str);
		
		
		$str = "SELECT CLASS_CODE FROM wp_classes WHERE CLASS_EXCUSE != '' AND CLASS_EXCUSE != 'null' AND CLASS_DATE >= '$INIDATE' AND CLASS_DATE <= '$ENDATE' AND CLASS_ENTITY = '$ENTITY'";
		$excused = $this->db->query($str);
		
		$data = array();
		$data["classes"] = $classes;
		$data["excused"] = $excused;
		
		$resp["message"] = $data;
		$resp["status"] = true;
		return $resp;
	}
	
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
	
	function classDaemon($info)
	{
		$cdmtest = $this-> cdm()["message"];
		$resp["message"] = $cdmtest;
		$resp["status"] = true;
		return $resp;
	}
	
	function cmp($a, $b) 
	{
		return strcmp($a->name, $b->name);
	}
	
	function getFieldTitle($field)
	{
		$title = $field;
		
		// REMITIONS REPORT
		if($field == "REM_LINE"){$title = "LINEA DE REMISION";}
		else if($field == "REM_DATE"){$title = "FECHA DE INICIO";}//*
		else if($field == "REM_ACTIVITY"){$title = "ACTIVIDAD";}//*
		else if($field == "REM_PROJECT"){$title = "PROJECTO";}//*
		else if($field == "REM_PROGRAM"){$title = "PROGRAMA";}//*
		else if($field == "REMCOM_AUTOR_NAME"){$title = "QUIEN INICIA LA REMISION";}//*
		else if($field == "REMCOM_CONTRATIST_NAME"){$title = "QUIEN ATIENDE LA REMISION";}//*
		else if($field == "REMCOM_ACTUAL_CNUMBER"){$title = "CONTRATO DEL AUTOR";}//*
		else if($field == "REMCOM_DATE"){$title = "FECHA COMENTARIO";}//*
		else if($field == "REMCOM_COMMENT"){$title = "MOTIVO";}//*
		else if($field == "REMCOM_COMMENT_DATE"){$title = "FECHA MOTIVO USUARIO";}//*
		else if($field == "REMCOM_TYPE"){$title = "TIPO COMENTARIO";}//*
		else if($field == "REMCOM_SPECIAL"){$title = "ESPECIAL";}//*
		else if($field == "REMCOM_HAVE_FILE"){$title = "TIENE ADJUNTO";}//*
		else if($field == "REMCOM_GROUP"){$title = "GRUPO";}//*
		else if($field == "REMCOM_NEW_CONTRATIST_NAME"){$title = "REMITIDO A";}//*
		else if($field == "REMCOM_NEW_ACTIVITY"){$title = "NUEVA ACTIVIDAD";}//*
		else if($field == "REMCOM_REMSTATE"){$title = "ESTADO ACTIVIDAD";}//*
		else if($field == "REMCOM_COMPONENT"){$title = "COMPONENTE";}//*
		else if($field == "REMCOM_SCOMPONENT"){$title = "SUB COMPONENTE";}//*
		
		
		
		
		
		// INSTITUTES REPORT
		if($field == "INSTITUTE_CODE"){$title = "CODIGO INSTITUCION";}
		else if($field == "INSTITUTE_NAME"){$title = "NOMBRE";}//*
		else if($field == "INSTITUTE_CITY"){$title = "CIUDAD";}//*
		else if($field == "INSTITUTE_ZONE"){$title = "CODIGO COMUNA O CORREGIMIENTO";}//*
		else if($field == "INSTITUTE_ZONE_DESC"){$title = "COMUNA O CORREGIMIENTO";}//*
		else if($field == "INSTITUTE_HOOD"){$title = "CODIGO BARRIO/VEREDA";}//*
		else if($field == "INSTITUTE_HOOD_DESC"){$title = "BARRIO/VEREDA";}//*
		else if($field == "INSTITUTE_ADDRESS"){$title = "DIRECCION";}//*
		else if($field == "INSTITUTE_COORDS"){$title = "COORDENADAS";}//*
		else if($field == "INSTITUTE_EDU"){$title = "INSTITUCION EDUCATIVA";}//*
		
		// DATES REPORT
		if($field == "DATE_DATE"){$title = "FECHA CITA";}
		else if($field == "DATE_LINE"){$title = "LINEA";}//*
		else if($field == "DATE_DATE_INI"){$title = "HORA INICIO";}//*
		else if($field == "DATE_DATE_END"){$title = "HORA FIN";}//*
		else if($field == "DATE_PLACE"){$title = "LUGAR";}//*
		else if($field == "DATE_CONTRATIST_NAME"){$title = "CONTRATISTA";}//*
		else if($field == "DATE_CITIZEN_NAME"){$title = "CIUDADANO";}//*
		else if($field == "DATE_COMMENT"){$title = "COMENTARIO";}//*
		else if($field == "DATE_STATE"){$title = "ESTADO";}//*
		else if($field == "DATE_ENTITY"){$title = "ENTIDAD";}//*
		else if($field == "DATE_CLOSE_COMMENT"){$title = "COMENTARIO DE CIERRE";}//*
		
		
		// CONTRACTS REPORT
		if($field == "CONTRACT_CREATED"){$title = "FECHA REGISTRO";}
		else if($field == "CONTRACT_CREATED"){$title = "META CIUDADANOS";}//*
		else if($field == "CONTRACT_REQTYPE"){$title = "TIPO SOLICITUD";}//*
		else if($field == "CONTRACT_NUMBER"){$title = "CONTRATO";}//*
		else if($field == "CONTRACT_INIDATE"){$title = "FECHA INICIO CONTRATO";}//*
		else if($field == "CONTRACT_ENDATE"){$title = "FECHA FIN CONTRATO";}//*
		else if($field == "CONTRACT_USERTYPE"){$title = "TIPO USUARIO CONTRATO";}//*
		else if($field == "ZONES"){$title = "COMUNAS";}//*
		else if($field == "USER_BDAY"){$title = "FECHA NACIMIENTO CONTRATISTA";}//*
		else if($field == "USER_PHONE"){$title = "TELEFONO CONTRATISTA";}//*
		else if($field == "USER_EMAIL"){$title = "CORREO O USUARIO CONTRATISTA";}//*
		else if($field == "CONTRACT_APROVED_BY"){$title = "APROBADO POR";}//*
		else if($field == "GROUP_QTY"){$title = "META GRUPOS";}//*
		else if($field == "CLASSGOALS"){$title = "META CLASES";}//*
		else if($field == "MINUTESGOALS"){$title = "META MINUTOS CLASE";}//*
		else if($field == "CITIZENSGOALS"){$title = "META CIUDADANOS";}//*
		else if($field == "DIRECTEDGOALS"){$title = "META EVENTOS DIRIGIDOS";}//*
		else if($field == "SUPORTEDGOALS"){$title = "META EVENTOS APOYADOS";}//*
		else if($field == "VISITEDGOALS"){$title = "META VISITAS";}//*
		else if($field == "CONTRACT_STATE"){$title = "ESTADO CONTRATO";}//*
		else if($field == "CONTRACT_CANREM"){$title = "REMISIONA";}//*
		else if($field == "CONTRACT_CANREM_GET"){$title = "ATIENDE REMISIONES";}//*
		
		
		// GROUPS REPORT
		if($field == "GROUP_CREATED"){$title = "FECHA REGISTRO";}
		else if($field == "CITIZEN_GOAL"){$title = "META CIUDADANOS";}//*
		else if($field == "ENTITY_NAME"){$title = "ENTIDAD";}//*
		else if($field == "GROUP_NAME"){$title = "NOMBRE GRUPO";}//*
		else if($field == "GROUP_PREVIR"){$title = "PRESENCIAL/VIRTUAL";}//*
		else if($field == "GROUP_INSTYPE"){$title = "INSTITUCIONAL/COMUNITARIO";}//*
		else if($field == "GROUP_ADDRESS"){$title = "DIRECCION O NOMBRE DEL LUGAR";}//*
		else if($field == "GROUP_COORDS"){$title = "COORDENADAS";}//*
		else if($field == "GROUP_HOURS"){$title = "HORARIOS";}//*
		else if($field == "CITIZEN_QTY"){$title = "CANTIDAD CIUDADANOS";}//*
		else if($field == "GROUP_USER_IDTYPE"){$title = "TIPO DOC CONTRATISTA";}//*
		else if($field == "GROUP_USER_IDNUM"){$title = "DOC CONTRATISTA";}//*
		else if($field == "GROUP_USER_NAME"){$title = "NOMBRE CONTRATISTA";}//*
		else if($field == "GROUP_USER_LASTNAME"){$title = "APELLIDO CONTRATISTA";}//*
		else if($field == "GROUP_GOALS"){$title = "META GRUPOS";}//*
		else if($field == "GROUP_CLASS_GOAL"){$title = "META CLASES";}//*
		else if($field == "GROUP_MINUTES_GOAL"){$title = "META MINUTOS CLASES";}//*
		else if($field == "GROUP_PEOPLE_GOAL"){$title = "META CIUDADANOS";}//*
		else if($field == "GROUP_PROCESS"){$title = "PROCESO CONTINUO";}//*
		
		// VISITS REPORT
		if($field == "VISIT_DATE"){$title = "FECHA REGISTRO";}
		else if($field == "VISIT_ENTITY"){$title = "ENTIDAD";}//*
		else if($field == "CONTRACT_NUMBER"){$title = "CONTRATO VISITADOR";}//*
		else if($field == "CONTRACT_INIDATE"){$title = "FECHA INICIO CONTRATO VISITADOR";}//*
		else if($field == "CONTRACT_ENDATE"){$title = "FECHA FIN CONTRATO VISITADOR";}//*
		else if($field == "CONTRACT_USERTYPE"){$title = "TIPO USUARIO CONTRATO VISITADOR";}//*
		else if($field == "VISITOR_IDTYPE"){$title = "TIPO DOC CONTRATISTA VISITADOR";}//*
		else if($field == "VISITOR_IDNUM"){$title = "DOC CONTRATISTA VISITADOR";}//*
		else if($field == "VISITOR_NAME"){$title = "NOMBRE CONTRATISTA VISITADOR";}//*
		else if($field == "VISITOR_LASTNAME"){$title = "APELLIDO CONTRATISTA VISITADOR";}//*
		else if($field == "CLASS_DATE"){$title = "FECHA CLASE";}//*
		else if($field == "CLASS_INI_HOUR"){$title = "HORA INICIO CLASE";}//*
		else if($field == "CLASS_END_HOUR"){$title = "HORA FIN CLASE";}//*
		else if($field == "CLASS_STATUS"){$title = "ESTADO CLASE";}//*
		else if($field == "CLASS_ATTENDERS"){$title = "ASISTENTES CLASE";}//*
		else if($field == "EXCUSE_REASON"){$title = "CAUSA CANCELACION";}//*
		else if($field == "EXCUSE_COMMENTS"){$title = "COMENTARIO CANCELACION";}//*
		else if($field == "VCONTRACT_NUMBER"){$title = "CONTRATO VISITADO";}//*
		else if($field == "VCONTRACT_INIDATE"){$title = "FECHA INICIO CONTRATO VISITADO";}//*
		else if($field == "VCONTRACT_ENDATE"){$title = "FECHA FIN CONTRATO VISITADO";}//*
		else if($field == "VCONTRACT_USERTYPE"){$title = "TIPO USUARIO CONTRATO VISITADO";}//*
		else if($field == "VISITED_IDTYPE"){$title = "TIPO DOC CONTRATISTA VISITADO";}//*
		else if($field == "VISITED_IDNUM"){$title = "DOC CONTRATISTA VISITADO";}//*
		else if($field == "VISITED_NAME"){$title = "NOMBRE CONTRATISTA VISITADO";}//*
		else if($field == "VISITED_LASTNAME"){$title = "APELLIDO CONTRATISTA VISITADO";}//*
		else if($field == "GROUP_NAME"){$title = "NOMBRE GRUPO";}//*
		else if($field == "ACTIVITIES"){$title = "ACTIVIDADES";}//*
		else if($field == "PROJECTS"){$title = "PROYECTOS";}//*
		else if($field == "PROGRAMS"){$title = "PROGRAMAS";}//*
		else if($field == "GROUP_PREVIR"){$title = "PRESENCIAL/VIRTUAL";}//*
		else if($field == "GROUP_INSTYPE"){$title = "INSTITUCIONAL/COMUNITARIO";}//*
		else if($field == "VISIT_HOOD_NAME"){$title = "BARRIO";}//*
		else if($field == "VISIT_ZONE_NAME"){$title = "COMUNA";}//*
		else if($field == "VISIT_ADDRESS"){$title = "DIRECCION O NOMBRE DEL LUGAR";}//*
		else if($field == "VISIT_CLASS_COORD"){$title = "COORDENADAS CLASE";}//*
		else if($field == "CITIZENS_QTY"){$title = "CANTIDAD CIUDADANOS GRUPO";}//*
		else if($field == "COOPERATOR_IDTYPE"){$title = "TIPO DOC COOPERADOR";}//*
		else if($field == "COOPERATOR_IDNUM"){$title = "DOC COOPERADOR";}//*
		else if($field == "COOPERATOR_NAME"){$title = "NOMBRE COOPERADOR";}//*
		else if($field == "COOPERATOR_LASTNAME"){$title = "APELLIDO COOPERADOR";}//*
		else if($field == "COOPERATOR_PHONE"){$title = "TELEFONO COOPERADOR";}//*
		else if($field == "COOPERATOR_EMAIL"){$title = "CORREO COOPERADOR";}//*
		else if($field == "VISIT_COORD"){$title = "COORDENADA DE VISITA";}//*
		else if($field == "VISIT_DONE"){$title = "ACTIVIDAD REALIZADA";}//*
		else if($field == "VISIT_TYPE"){$title = "TIPO VISITA";}//*
		else if($field == "VISIT_ASSISTQTY"){$title = "NUM ASISTENTES";}//*
		else if($field == "VISIT_NOASSISTQTY"){$title = "NUM AUSENTES";}//*
		else if($field == "VISIT_STONTIME"){$title = "INICIO A TIEMPO";}//*
		else if($field == "VISIT_TOOLS"){$title = "HERRAMIENTAS O MATERIALES ADECUADOS";}//*
		else if($field == "VISIT_GOODTIME"){$title = "HORARIO ADECUADO";}
		else if($field == "VISIT_GOODPLACE"){$title = "LUGAR ADECUADO";}
		else if($field == "VISIT_FORMAT"){$title = "SESION DESCRITA EN PLAN CLASE";}//*
		else if($field == "VISIT_PDELIVER"){$title = "ENTREGA OPORTUNA PLAN CLASE";}//*
		else if($field == "VISIT_COHERENT"){$title = "COHERENCIA CLASE Y PLAN TECNICO";}//*
		else if($field == "VISIT_EASY"){$title = "ORDEN DE TAREAS FACILITAN LOS OBJETIVOS";}//*
		else if($field == "VISIT_ORIENT"){$title = "INDICACIONES PRECISAS";}//*
		else if($field == "VISIT_EXPRESSION"){$title = "EXPRESION VERBAL Y CORPORAL ADECUADAS";}//*
		else if($field == "VISIT_PRESENT"){$title = "PRESENTACION PERSONAL ADECUADA";}//*
		else if($field == "VISIT_VERIFIED"){$title = "TOMA ASISTENCIA EN CLASE";}//*
		else if($field == "VISIT_ACOMPLISH"){$title = "CALIFICACION CUMPLIMIENTO OBJETIVOS";}//*
		else if($field == "VISIT_SIGNED"){$title = "FIRMA CORRECTA";}//*
		else if($field == "VISIT_COMMENTS"){$title = "OBSERVACIONES";}//*
		
		
		// EVENTS REPORT
		if($field == "EVENT_CODE"){$title = "CÓDIGO DE EVENTO";}
		else if($field == "EVENT_CREATED"){$title = "FECHA DE REGISTRO";}//*
		else if($field == "ENTITY_NAME"){$title = "ENTIDAD";}//*
		else if($field == "AUTHOR_DATA_IDTYPE"){$title = "TIPO DOC CREADOR SOLICITUD";}//*
		else if($field == "AUTHOR_DATA_IDNUM"){$title = "DOC CREADOR SOLICITUD";}//*
		else if($field == "AUTHOR_DATA_NAME"){$title = "NOMBRE CREADOR SOLICITUD";}//*
		else if($field == "AUTHOR_DATA_LASTNAME"){$title = "APELLIDO CREADOR SOLICITUD";}//*
		else if($field == "EVENT_TYPE"){$title = "TIPO DE EVENTO";}//*
		else if($field == "EVENT_STATUS"){$title = "ESTADO EVENTO";}//*
		else if($field == "EVENT_NAME"){$title = "NOMBRE EVENTO";}//*
		else if($field == "EVENT_ORIGIN"){$title = "ORIGEN EVENTO";}//*
		else if($field == "EVENT_RADICATE"){$title = "RADICADO EVENTO";}//*
		else if($field == "EVENT_REQUEST_DATE"){$title = "FECHA SOLICITUD EVENTO";}//*
		else if($field == "EVENT_REQUEST_TYPE"){$title = "TIPO SOLICITUD EVENTO";}//*
		else if($field == "EVENT_DATE_INIR"){$title = "FECHA Y HORA INICIO EVENTO SOLICITADA";}//*
		else if($field == "EVENT_DATE_ENDR"){$title = "FECHA Y HORA FIN EVENTO SOLICITADA";}//*
		else if($field == "EVENT_DESCRIPTION"){$title = "DESCRIPCION EVENTO";}//*
		else if($field == "EVENT_NEEDS_FRIENDLY"){$title = "NECESIDADES SOLICITADAS";}//*
		else if($field == "EVENT_INSTYPE"){$title = "TIPO SOLICITANTE";}//*
		else if($field == "REQUESTER_IDTYPE"){$title = "TIPO DOC SOLICITANTE";}//*
		else if($field == "REQUESTER_IDNUM"){$title = "DOC SOLICITANTE";}//*
		else if($field == "REQUESTER_NAME"){$title = "NOMBRE SOLICITANTE";}//*
		else if($field == "REQUESTER_LASTNAME"){$title = "APELLIDO SOLICITANTE";}//*
		else if($field == "REQUESTER_PHONE"){$title = "TELÉFONO SOLICITANTE";}//*
		else if($field == "REQUESTER_EMAIL"){$title = "CORREO SOLICITANTE";}//*
		else if($field == "EVENT_PREVIR"){$title = "PRESENCIAL/VIRTUAL";}//*
		else if($field == "EVENT_HOOD"){$title = "BARRIO";}//*
		else if($field == "EVENT_ZONE"){$title = "COMUNA";}//*
		else if($field == "EVENT_ADDRESS"){$title = "DIRECCION O NOMBRE DEL LUGAR";}//*
		else if($field == "EVENT_COORDS"){$title = "COORDENADAS";}//*
		else if($field == "EVENT_EXPECTED"){$title = "ASISTENCIA ESPERADA";}//*
		else if($field == "EVENT_REJECT_REASON"){$title = "CAUSA RECHAZO";}//*
		else if($field == "EVENT_GOTTEN_FRIENDLY"){$title = "NECESIDADES GESTIONADAS";}//*
		else if($field == "EVENT_DATE_INI"){$title = "FECHA Y HORA INICIO EVENTO EJECUCION";}//*
		else if($field == "EVENT_DATE_END"){$title = "FECHA Y HORA FIN EVENTO EJECUCION";}//*
		else if($field == "ACTIVITIES"){$title = "ACTIVIDADES";}//*
		else if($field == "PROJECTS"){$title = "PROYECTOS";}//*
		else if($field == "PROGRAMS"){$title = "PROGRAMAS";}//*
		else if($field == "ROL"){$title = "ROL CONTRATISTA";}//*
		else if($field == "CONTRACT_NUMBER"){$title = "CONTRATO";}//*
		else if($field == "CONTRACT_INIDATE"){$title = "FECHA INICIO CONTRATO";}//*
		else if($field == "CONTRACT_ENDATE"){$title = "FECHA FIN CONTRATO";}//*
		else if($field == "CONTRACT_USERTYPE"){$title = "TIPO USUARIO CONTRATO";}//*
		else if($field == "CONTRATIST_IDTYPE"){$title = "TIPO DOC CONTRATISTA";}//*
		else if($field == "CONTRATIST_IDNUM"){$title = "DOC CONTRATISTA";}//*
		else if($field == "CONTRATIST_NAME"){$title = "NOMBRE CONTRATISTA";}//*
		else if($field == "CONTRATIST_LASTNAME"){$title = "APELLIDO CONTRATISTA";}//*
		else if($field == "DIRECTED"){$title = "META EVENTOS DIRIGIDOS";}//*
		else if($field == "SUPPORTED"){$title = "META EVENTOS APOYADOS";}//*
		else if($field == "COOPTYPE"){$title = "TIPO COOPERADOR";}//*
		else if($field == "COOPERATOR_IDTYPE"){$title = "TIPO DOC COOPERADOR";}//*
		else if($field == "COOPERATOR_IDNUM"){$title = "DOC COOPERADOR";}//*
		else if($field == "COOPERATOR_NAME"){$title = "NOMBRE COOPERADOR";}//*
		else if($field == "COOPERATOR_LASTNAME"){$title = "APELLIDO COOPERADOR";}//*
		else if($field == "COOPERATOR_PHONE"){$title = "TELÉFONO COOPERADOR";}//*
		else if($field == "COOPERATOR_EMAIL"){$title = "CORREO COOPERADOR";}//*
		else if($field == "EVENT_ASSISTANTS"){$title = "ASISTENCIA TOTAL";}//*
		else if($field == "ASSIST_DETAIL"){$title = "ASISTENCIA DETALLADA";}//*
		else if($field == "EVENT_RESUME"){$title = "RESUMEN EVENTO";}//*
				
		// CLASS ASSIST
		if($field == "CLASS_CODE"){$title = "CÓDIGO DE CLASE";}
		else if($field == "CLASS_CREATED"){$title = "FECHA DE REGISTRO";}//*
		else if($field == "CLASS_DATE"){$title = "FECHA CLASE";}
		else if($field == "CLASS_INI"){$title = "HORA INICIO CLASE";}
		else if($field == "CLASS_END"){$title = "HORA FINAL CLASE";}
		else if($field == "ENTITY_NAME"){$title = "ENTIDAD";}//*
		else if($field == "CLASS_STATUS"){$title = "ESTADO CLASE";}//*
		else if($field == "CLASS_ATTENDERS"){$title = "ASISTENTES";}//*
		else if($field == "EXCUSE_REASON"){$title = "CAUSA CANCELACION";}//*
		else if($field == "EXCUSE_COMMENTS"){$title = "COMENTARIO CANCELACION";}//*
		else if($field == "CONTRACT_NUMBER"){$title = "No. CONTRATO";}
		else if($field == "CONTRACT_INIDATE"){$title = "FECHA INICIO CONTRATO";}//*
		else if($field == "CONTRACT_ENDATE"){$title = "FECHA FIN CONTRATO";}//*
		else if($field == "CONTRACT_USERTYPE"){$title = "TIPO DE USUARIO";}//*
		else if($field == "CLASS_USER_IDTYPE"){$title = "TIPO DOC CONTRATISTA";}//*
		else if($field == "CLASS_USER_IDNUM"){$title = "DOC CONTRATISTA";}//*
		else if($field == "CLASS_USER_NAME"){$title = "NOMBRE CONTRATISTA";}
		else if($field == "CLASS_USER_LASTNAME"){$title = "APELLIDO CONTRATISTA";}
		else if($field == "CLASS_GROUP_NAME"){$title = "NOMBRE GRUPO";}
		else if($field == "CLASSES_GOAL"){$title = "META CLASES";}
		else if($field == "HOURS_GOAL"){$title = "META HORAS";}
		else if($field == "PEOPLE_GOAL"){$title = "META USUARIOS";}
		else if($field == "CONTRACT_OTHER_GOALS"){$title = "META GRUPOS";}
		else if($field == "PROGRAM_NAME"){$title = "PROGRAMA DEL GRUPO";}
		else if($field == "PROJECT_NAME"){$title = "PROYECTO DEL GRUPO";}
		else if($field == "ACTIVITY_NAME"){$title = "ACTIVIDAD DEL GRUPO";}
		else if($field == "GROUP_PREVIR"){$title = "TIPO DE CLASES (PRESENCIAL/VIRTUAL)";}
		else if($field == "GROUP_INSTYPE"){$title = "TIPO DE GRUPO (INSTITUCIONAL O COMUNITARIO)";}
		else if($field == "CLASS_HOOD"){$title = "BARRIO";}
		else if($field == "CLASS_ZONE"){$title = "COMUNA";}
		else if($field == "GROUP_ADDRESS"){$title = "DIRECCIÓN O NOMBRE DEL LUGAR";}
		else if($field == "INSTITUTE_NAME"){$title = "INSTITUCIÓN";}
		else if($field == "GROUP_COORDS"){$title = "COORDENADA";}
		else if($field == "COOPERATOR_IDTYPE"){$title = "TIPO DOC COOPERADOR";}
		else if($field == "COOPERATOR_IDNUM"){$title = "DOC COOPERADOR";}
		else if($field == "COOPERATOR_NAME"){$title = "NOMBRE COOPERADOR";}
		else if($field == "COOPERATOR_PHONE"){$title = "TELÉFONO COOPERADOR";}
		else if($field == "COOPERATOR_EMAIL"){$title = "CORREO COOPERADOR";}
		else if($field == "CITIZEN_IDTYPE"){$title = "TIPO DE DOCUMENTO DEL CIUDADANO";}
		else if($field == "CITIZEN_IDNUM"){$title = "DOCUMENTO DE CIUDADANO";}
		else if($field == "CITIZEN_NAME"){$title = "NOMBRE DEL CIUDADANO";}
		else if($field == "CITIZEN_LASTNAME"){$title = "APELLIDO DEL CIUDADANO";}
		else if($field == "CITIZEN_GENDER"){$title = "GENERO";}
		else if($field == "CITIZEN_BDAY"){$title = "FECHA NACIMIENTO";}
		else if($field == "CITIZEN_AGE"){$title = "EDAD CIUDADANO";}
		else if($field == "CITIZEN_ADDRESS"){$title = "DIRECCIÓN CIUDADANO";}
		else if($field == "CITIZEN_EMAIL"){$title = "CORREO CIUDADANO";}
		else if($field == "CITIZEN_PHONE"){$title = "TELÉFONO";}
		else if($field == "CITIZEN_ETNIA"){$title = "ETNIA";}
		else if($field == "CITIZEN_CONDITION"){$title = "CONDICIONES";}
		else if($field == "CITIZEN_HOOD"){$title = "BARRIO CIUDADANO";}
		else if($field == "CITIZEN_ZONE"){$title = "COMUNA CIUDADANO";}
		else if($field == "CITIZEN_LEVEL"){$title = "ESTRATO CIUDADANO";}
		else if($field == "CITIZEN_SAVED"){$title = "ASISTENCIA REGISTRADA";}
		// ---------*---------
		else if($field == "CITIZEN_ETNIA_IND"){$title = "TIPO DE INDIGENA";}
		else if($field == "CITIZEN_ORIGIN_COUNTRY"){$title = "PAIS DE ORIGEN";}
		else if($field == "CITIZEN_DESTINY_COUNTRY"){$title = "PAIS DESTINO";}
		else if($field == "CITIZEN_STAY_REASON"){$title = "RAZÓN MIGRACIÓN";}
		else if($field == "CITIZEN_MIGREXP"){$title = "EXPERIENCIA MIGRATORIA";}
		else if($field == "CITIZEN_INDATE"){$title = "FECHA INGRESO";}
		else if($field == "CITIZEN_OUTDATE"){$title = "FECHA SALIDA";}
		else if($field == "CITIZEN_RETURN_REASON"){$title = "MOTIVO RETORNO";}
		else if($field == "CITIZEN_SITAC"){$title = "REGISTRO SITAC";}
		else if($field == "CITIZEN_ACUDIENT"){$title = "ACUDIENTE";}
		else if($field == "CITIZEN_BIRTH_CITY"){$title = "CIUDAD DE NACIMIENTO";}
		else if($field == "CITIZEN_SISCORE"){$title = "PUNTAJE SISBEN";}
		else if($field == "CITIZEN_CONVAC"){$title = "CONVIVENCIA ACTUAL";}
		else if($field == "CITIZEN_TIPOCO"){$title = "CONSUMO";}
		else if($field == "CITIZEN_TIPOVI"){$title = "VIOLENCIA MANIFESTADA";}
		else if($field == "CITIZEN_HANDICAP"){$title = "INDICADOR DISCAPACIDAD";}
		else if($field == "CITIZEN_ETGROUP"){$title = "INDICADOR GRUPO ETNICO";}
		else if($field == "CITIZEN_SECURITY"){$title = "SEGURIDAD SALUD";}
		else if($field == "CITIZEN_EPS"){$title = "EPS";}
		else if($field == "CITIZEN_PATOEN"){$title = "PATOLOGIA";}
		else if($field == "CITIZEN_TRASDES"){$title = "TRASTORNOS";}
		else if($field == "CITIZEN_RISKFA"){$title = "FACTORES RIESGO";}
		else if($field == "CITIZEN_PREVFA"){$title = "FACTORES PREVENTIVOS";}
		else if($field == "CITIZEN_WEIGHT"){$title = "PESO";}
		else if($field == "CITIZEN_HEIGHT"){$title = "TALLA";}
		else if($field == "CITIZEN_IMC"){$title = "IMC";}
		else if($field == "CITIZEN_IMC_RATE"){$title = "CALIFICACIÓN IMC";}
		else if($field == "CITIZEN_EDLEVEL"){$title = "NIVEL EDUCATIVO";}
		else if($field == "CITIZEN_INSTITUTE"){$title = "INSTITUCION";}
		else if($field == "CITIZEN_COURSES"){$title = "FORMACIÓN";}
		else if($field == "CITIZEN_OCUCOND"){$title = "CONDICION OCUPACIONAL";}
		else if($field == "CITIZEN_INGREC"){$title = "INGRESO ECONÓMICO";}
		


		
		return strtoupper($title);
	}
	
	// CREATE EXCEL AND RETURN FILENAME
	function excelCreate($type, $array)
	{
		
		$myExcel = new PHPexcel();
		$myExcel->getProperties()->setCreator("Diogenes")
						 ->setLastModifiedBy("Diogenes")
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
		if($type == "remitions")
		{
			
			// SET FIELDS
			$fieldsArray = array(
			"REM_LINE",
			"REM_DATE",
			"REM_ACTIVITY",
			"REM_PROJECT",
			"REM_PROGRAM",
			"REMCOM_AUTOR_NAME",
			"REMCOM_CONTRATIST_NAME",
			"CITIZEN_IDTYPE",
			"CITIZEN_IDNUM",
			"CITIZEN_NAME",
			"CITIZEN_LASTNAME",
			"CITIZEN_GENDER",
			"CITIZEN_BDAY",
			"CITIZEN_AGE",
			"CITIZEN_ADDRESS",
			"CITIZEN_EMAIL",
			"CITIZEN_PHONE", 
			"CITIZEN_ETNIA",
			"CITIZEN_CONDITION",
			"CITIZEN_HOOD",
			"CITIZEN_ZONE",
			"CITIZEN_LEVEL",
			"CITIZEN_ETNIA_IND",
			"CITIZEN_ORIGIN_COUNTRY",
			"CITIZEN_DESTINY_COUNTRY",
			"CITIZEN_STAY_REASON",
			"CITIZEN_MIGREXP",
			"CITIZEN_INDATE",
			"CITIZEN_OUTDATE",
			"CITIZEN_RETURN_REASON",
			"CITIZEN_SITAC",
			"CITIZEN_ACUDIENT",
			"CITIZEN_BIRTH_CITY",
			"CITIZEN_SISCORE",
			"CITIZEN_CONVAC",
			"CITIZEN_TIPOCO",
			"CITIZEN_TIPOVI",
			"CITIZEN_HANDICAP",
			"CITIZEN_ETGROUP",
			"CITIZEN_SECURITY",
			"CITIZEN_EPS",
			"CITIZEN_PATOEN",
			"CITIZEN_TRASDES",
			"CITIZEN_RISKFA",
			"CITIZEN_PREVFA",
			"CITIZEN_WEIGHT",
			"CITIZEN_HEIGHT",
			"CITIZEN_IMC",
			"CITIZEN_IMC_RATE",
			"CITIZEN_EDLEVEL",
			"CITIZEN_INSTITUTE",
			"CITIZEN_COURSES",
			"CITIZEN_OCUCOND",
			"CITIZEN_INGREC",
			"REMCOM_ACTUAL_CNUMBER",
			"REMCOM_DATE",
			"REMCOM_COMMENT",
			"REMCOM_COMMENT_DATE",
			"REMCOM_TYPE",
			"REMCOM_SPECIAL",
			"REMCOM_HAVE_FILE",
			"REMCOM_GROUP",
			"REMCOM_NEW_CONTRATIST_NAME",
			"REMCOM_NEW_ACTIVITY",
			"REMCOM_COMPONENT",
			"REMCOM_SCOMPONENT",
			"REMCOM_REMSTATE"
			);
			
			// SET FILE NAME
			$fname  = "Reporte atenciones";
			$fname = htmlEntities(utf8_decode($fname));
		}
		if($type == "institutes")
		{
			
			// SET FIELDS
			$fieldsArray = array(
			"INSTITUTE_CODE",
			"INSTITUTE_NAME",
			"INSTITUTE_CITY",
			"INSTITUTE_ZONE",
			"INSTITUTE_ZONE_DESC",
			"INSTITUTE_HOOD",
			"INSTITUTE_HOOD_DESC",
			"INSTITUTE_ADDRESS",
			"INSTITUTE_COORDS",
			"INSTITUTE_EDU"
			);
			
			// SET FILE NAME
			$fname  = "Reporte lugares de servicio";
			$fname = htmlEntities(utf8_decode($fname));
		}
		if($type == "dates")
		{
			// SET FIELDS
			$fieldsArray = array(
			"DATE_ENTITY",
			"DATE_LINE",
			"DATE_DATE",
			"DATE_DATE_INI",
			"DATE_DATE_END",
			"DATE_PLACE",
			"DATE_CONTRATIST_NAME",
			"DATE_CITIZEN_NAME",
			"DATE_COMMENT",
			"DATE_STATE", 
			"DATE_CLOSE_COMMENT"
			);
			
			// SET FILE NAME
			$fname  = "Reporte citas";
			$fname = htmlEntities(utf8_decode($fname));
		}
		if($type == "contracts")
		{
			// SET FIELDS
			$fieldsArray = array(
			"CONTRACT_CREATED",
			"ENTITY_NAME",
			"CONTRACT_REQTYPE",
			"CONTRACT_NUMBER",
			"CONTRACT_INIDATE",
			"CONTRACT_ENDATE",
			"CONTRACT_USERTYPE",
			"PROGRAMS",
			"PROJECTS",
			"ACTIVITIES",
			"ZONES",
			"GROUP_USER_IDTYPE",
			"GROUP_USER_IDNUM",
			"GROUP_USER_NAME",
			"GROUP_USER_LASTNAME",
			"USER_BDAY",
			"USER_PHONE",
			"USER_EMAIL",
			"CONTRACT_APROVED_BY",
			"GROUP_QTY",
			"CLASSGOALS",
			"MINUTESGOALS",
			"CITIZENSGOALS",
			"DIRECTEDGOALS",
			"SUPORTEDGOALS",
			"VISITEDGOALS",
			"CONTRACT_STATE",
			"CONTRACT_CANREM",
			"CONTRACT_CANREM_GET");
			
			// SET FILE NAME
			$fname  = "Reporte contratos";
			$fname = htmlEntities(utf8_decode($fname));
		}
		if($type == "groups")
		{
			// SET FIELDS
			$fieldsArray = array(
			"GROUP_CREATED",
			"ENTITY_NAME",
			"GROUP_NAME",
			"ACTIVITIES",
			"PROJECTS",
			"PROGRAMS",
			"GROUP_PREVIR",
			"GROUP_INSTYPE",
			"EVENT_HOOD",
			"EVENT_ZONE",
			"GROUP_ADDRESS",
			"GROUP_COORDS",
			"GROUP_HOURS",
			"CITIZEN_QTY",
			"COOPERATOR_IDTYPE",
			"COOPERATOR_IDNUM",
			"COOPERATOR_NAME",
			"COOPERATOR_LASTNAME",
			"COOPERATOR_PHONE",
			"COOPERATOR_EMAIL",
			"CONTRACT_NUMBER",
			"CONTRACT_INIDATE",
			"CONTRACT_ENDATE",
			"CONTRACT_USERTYPE",
			"GROUP_USER_IDTYPE",
			"GROUP_USER_IDNUM",
			"GROUP_USER_NAME",
			"GROUP_USER_LASTNAME",
			"GROUP_GOALS",
			"GROUP_CLASS_GOAL",
			"GROUP_MINUTES_GOAL",
			"GROUP_PEOPLE_GOAL",
			"GROUP_PROCESS",
			"CITIZEN_IDTYPE",
			"CITIZEN_IDNUM",
			"CITIZEN_NAME",
			"CITIZEN_LASTNAME",
			"CITIZEN_GENDER",
			"CITIZEN_BDAY",
			"CITIZEN_AGE",
			"CITIZEN_ADDRESS",
			"CITIZEN_EMAIL",
			"CITIZEN_PHONE", 
			"CITIZEN_ETNIA",
			"CITIZEN_CONDITION",
			"CITIZEN_HOOD",
			"CITIZEN_ZONE",
			"CITIZEN_LEVEL",
			"CITIZEN_SAVED",
			"CITIZEN_ETNIA_IND",
			"CITIZEN_ORIGIN_COUNTRY",
			"CITIZEN_DESTINY_COUNTRY",
			"CITIZEN_STAY_REASON",
			"CITIZEN_MIGREXP",
			"CITIZEN_INDATE",
			"CITIZEN_OUTDATE",
			"CITIZEN_RETURN_REASON",
			"CITIZEN_SITAC",
			"CITIZEN_ACUDIENT",
			"CITIZEN_BIRTH_CITY",
			"CITIZEN_SISCORE",
			"CITIZEN_CONVAC",
			"CITIZEN_TIPOCO",
			"CITIZEN_TIPOVI",
			"CITIZEN_HANDICAP",
			"CITIZEN_ETGROUP",
			"CITIZEN_SECURITY",
			"CITIZEN_EPS",
			"CITIZEN_PATOEN",
			"CITIZEN_TRASDES",
			"CITIZEN_RISKFA",
			"CITIZEN_PREVFA",
			"CITIZEN_WEIGHT",
			"CITIZEN_HEIGHT",
			"CITIZEN_IMC",
			"CITIZEN_IMC_RATE",
			"CITIZEN_EDLEVEL",
			"CITIZEN_INSTITUTE",
			"CITIZEN_COURSES",
			"CITIZEN_OCUCOND",
			"CITIZEN_INGREC");
			
			// SET FILE NAME
			$fname  = "Reporte grupos";
			$fname = htmlEntities(utf8_decode($fname));
		}
		if($type == "classAssist")
		{
			// SET FIELDS
			$fieldsArray = array(
			"CLASS_CREATED",
			// "DATA_ORIGIN",
			// "FULL_GUYS",
			// "CLASS_CODE",
			// "THISCITASSIST",
			"ENTITY_NAME",
			"CLASS_DATE",
			"CLASS_INI",
			"CLASS_END",
			"CLASS_STATUS",
			"CLASS_ATTENDERS",
			"EXCUSE_REASON",
			"EXCUSE_COMMENTS",
			"CONTRACT_NUMBER",
			"CONTRACT_INIDATE",
			"CONTRACT_ENDATE",
			"CONTRACT_USERTYPE",
			"CLASS_USER_IDTYPE",
			"CLASS_USER_IDNUM",
			"CLASS_USER_NAME",
			"CLASS_USER_LASTNAME",
			"CONTRACT_OTHER_GOALS",
			"CLASSES_GOAL",
			"HOURS_GOAL",
			"PEOPLE_GOAL",
			"CLASS_GROUP_NAME",
			"ACTIVITY_NAME",
			"PROJECT_NAME",
			"PROGRAM_NAME",
			"GROUP_PREVIR",
			"GROUP_INSTYPE",
			"CLASS_HOOD",
			"CLASS_ZONE",
			"GROUP_ADDRESS",
			"GROUP_COORDS",
			"COOPERATOR_IDTYPE",
			"COOPERATOR_IDNUM",
			"COOPERATOR_NAME",
			"COOPERATOR_LASTNAME",
			"COOPERATOR_PHONE",
			"COOPERATOR_EMAIL",
			"CITIZEN_IDTYPE",
			"CITIZEN_IDNUM",
			"CITIZEN_NAME",
			"CITIZEN_LASTNAME",
			"CITIZEN_GENDER",
			"CITIZEN_BDAY",
			"CITIZEN_AGE",
			"CITIZEN_ADDRESS",
			"CITIZEN_EMAIL",
			"CITIZEN_PHONE", 
			"CITIZEN_ETNIA",
			"CITIZEN_CONDITION",
			"CITIZEN_HOOD",
			"CITIZEN_ZONE",
			"CITIZEN_LEVEL",
			"CITIZEN_SAVED");
			
			// "CITIZEN_ETNIA_IND",
			// "CITIZEN_ORIGIN_COUNTRY",
			// "CITIZEN_DESTINY_COUNTRY",
			// "CITIZEN_STAY_REASON",
			// "CITIZEN_MIGREXP",
			// "CITIZEN_INDATE",
			// "CITIZEN_OUTDATE",
			// "CITIZEN_RETURN_REASON",
			// "CITIZEN_SITAC",
			// "CITIZEN_ACUDIENT",
			// "CITIZEN_BIRTH_CITY",
			// "CITIZEN_SISCORE",
			// "CITIZEN_CONVAC",
			// "CITIZEN_TIPOCO",
			// "CITIZEN_TIPOVI",
			// "CITIZEN_HANDICAP",
			// "CITIZEN_ETGROUP",
			// "CITIZEN_SECURITY",
			// "CITIZEN_EPS",
			// "CITIZEN_PATOEN",
			// "CITIZEN_TRASDES",
			// "CITIZEN_RISKFA",
			// "CITIZEN_PREVFA",
			// "CITIZEN_WEIGHT",
			// "CITIZEN_HEIGHT",
			// "CITIZEN_IMC",
			// "CITIZEN_IMC_RATE",
			// "CITIZEN_EDLEVEL",
			// "CITIZEN_INSTITUTE",
			// "CITIZEN_COURSES",
			// "CITIZEN_OCUCOND",
			// "CITIZEN_INGREC");
			
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			
			$now = str_replace(':', '-', $now);
			
			// SET FILE NAME
			$fname  = "Reporte asistencia ".$now;
			$fname = htmlEntities(utf8_decode($fname));
		}
		if($type == "events")
		{
			// SET FIELDS
			$fieldsArray = array(
			"EVENT_CREATED",
			"ENTITY_NAME",
			"AUTHOR_DATA_IDTYPE",
			"AUTHOR_DATA_IDNUM",
			"AUTHOR_DATA_NAME",
			"AUTHOR_DATA_LASTNAME",
			"EVENT_TYPE",
			"EVENT_STATUS",
			"EVENT_NAME",
			"EVENT_ORIGIN",
			"EVENT_RADICATE",
			"EVENT_REQUEST_DATE",
			"EVENT_REQUEST_TYPE",
			"EVENT_DATE_INIR",
			"EVENT_DATE_ENDR",
			"EVENT_DESCRIPTION",
			"EVENT_NEEDS_FRIENDLY",
			"EVENT_INSTYPE",
			"REQUESTER_IDTYPE",
			"REQUESTER_IDNUM",
			"REQUESTER_NAME",
			"REQUESTER_LASTNAME",
			"REQUESTER_PHONE",
			"REQUESTER_EMAIL",
			"EVENT_PREVIR",
			"EVENT_HOOD",
			"EVENT_ZONE",
			"EVENT_ADDRESS",
			"EVENT_COORDS",
			"EVENT_EXPECTED",
			"EVENT_REJECT_REASON",
			"EVENT_GOTTEN_FRIENDLY",
			"EVENT_DATE_INI",
			"EVENT_DATE_END",
			"ROL",
			"ACTIVITIES",
			"PROJECTS",
			"PROGRAMS",
			"CONTRACT_NUMBER",
			"CONTRACT_INIDATE",
			"CONTRACT_ENDATE",
			"CONTRACT_USERTYPE",
			"CONTRATIST_IDTYPE",
			"CONTRATIST_IDNUM",
			"CONTRATIST_NAME",
			"CONTRATIST_LASTNAME",
			"DIRECTED",
			"SUPPORTED",
			"COOPTYPE",
			"COOPERATOR_IDTYPE",
			"COOPERATOR_IDNUM",
			"COOPERATOR_NAME",
			"COOPERATOR_LASTNAME",
			"COOPERATOR_PHONE",
			"COOPERATOR_EMAIL",
			"EVENT_ASSISTANTS",
			"ASSIST_DETAIL",
			"EVENT_RESUME");
			
			// SET FILE NAME
			$fname  = "Reporte eventos";
			$fname = htmlEntities(utf8_decode($fname));
		}
		if($type == "visits")
		{
			// SET FIELDS
			$fieldsArray = array(
			"VISIT_DATE",
			"VISIT_ENTITY",
			"CONTRACT_NUMBER",
			"CONTRACT_INIDATE",
			"CONTRACT_ENDATE",
			"CONTRACT_USERTYPE",
			"VISITOR_IDTYPE",
			"VISITOR_IDNUM",
			"VISITOR_NAME",
			"VISITOR_LASTNAME",
			"CLASS_DATE",
			"CLASS_INI_HOUR",
			"CLASS_END_HOUR",
			"CLASS_STATUS",
			"CLASS_ATTENDERS",
			"EXCUSE_REASON",
			"EXCUSE_COMMENTS",
			"VCONTRACT_NUMBER",
			"VCONTRACT_INIDATE",
			"VCONTRACT_ENDATE",
			"VCONTRACT_USERTYPE",
			"VISITED_IDTYPE",
			"VISITED_IDNUM",
			"VISITED_NAME",
			"VISITED_LASTNAME",
			"GROUP_NAME",
			"ACTIVITIES",
			"PROJECTS",
			"PROGRAMS",
			"GROUP_PREVIR",
			"GROUP_INSTYPE",
			"VISIT_HOOD_NAME",
			"VISIT_ZONE_NAME",
			"VISIT_ADDRESS",
			"VISIT_CLASS_COORD",
			"CITIZENS_QTY",
			"COOPERATOR_IDTYPE",
			"COOPERATOR_IDNUM",
			"COOPERATOR_NAME",
			"COOPERATOR_LASTNAME",
			"COOPERATOR_PHONE",
			"COOPERATOR_EMAIL",
			"VISIT_COORD",
			"VISIT_DONE",
			"VISIT_TYPE",
			"VISIT_ASSISTQTY",
			"VISIT_NOASSISTQTY",
			"VISIT_STONTIME",
			"VISIT_TOOLS",
			"VISIT_GOODTIME",
			"VISIT_GOODPLACE",
			"VISIT_FORMAT",
			"VISIT_PDELIVER",
			"VISIT_COHERENT",
			"VISIT_EASY",
			"VISIT_ORIENT",
			"VISIT_EXPRESSION",
			"VISIT_PRESENT",
			"VISIT_VERIFIED",
			"VISIT_ACOMPLISH",
			"VISIT_SIGNED",
			"VISIT_COMMENTS");
			
			// SET FILE NAME
			$fname  = "Reporte visitas";
			$fname = htmlEntities(utf8_decode($fname));
		}

		// GENERAL BUILDER -------------
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
		
		$maxLine = count($array);
		// $maxLine = 2800;
		
		// FILL CONTENTS
		for($i = 0; $i<$maxLine;$i++)
		{
			if(!isset($array[$i])){continue;}
			
			$item = $array[$i];
			
			// return $fieldsArray;
			
			for($n = 0; $n<count($fieldsArray);$n++)
			{
				$cell = strval($c.$f);
				$field = $fieldsArray[$n];
				
				if($field == "CONTRACT_NUMBER" or $field == "REMCOM_ACTUAL_CNUMBER")
				{
					$sheet->setCellValueExplicit($cell, $item[$field], PHPExcel_Cell_DataType::TYPE_STRING);
				}
				else
				{
					$sheet->setCellValue($cell, $item[$field]);
				}
				
				
				$sheet->getStyle($cell)->applyFromArray($borderB);
				$sheet->getStyle($cell)->applyFromArray($alignLeft);
				$sheet->getStyle($cell)->getFont()->setSize(9);
				
				
				
				$c++;
			}

			$c = "A";
			$f++;
		}
		

		// CREATE FILE
		$path = "../reports/".$fname.".xls";
		$hasFile = file_exists($path);
		if($hasFile == true){unlink($path);}
		$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
		$objWriter->save($path );
		
		// RETURN FILE NAME
		return $fname;
	}
	
	// GET CITIZEN
	function getCitizen($info)
	{
		$CITIZEN_IDNUM = $info["CITIZEN_IDNUM"];
		
		$str = "SELECT * FROM wp_citizens WHERE 
		CITIZEN_IDNUM = '".$CITIZEN_IDNUM."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{
			// CHECK ALDULT
			$CITIZEN_BDAY = $query[0]["CITIZEN_BDAY"];
			
			$today = date("Y-m-d");
			$diff = date_diff(date_create($CITIZEN_BDAY), date_create($today));
			$age = $diff->format('%y');
			
			if($age < 18)
			{
				$resp["message"] = "toYoung";
				$resp["status"] = true;
				return $resp;
			}
		}
		
		$ans = $query;

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// GET CITIZEN MAIN
	function getCitizenMain($info)
	{
		$CITIZEN_IDNUM = $info["CITIZEN_IDNUM"];
		
		$str = "SELECT * FROM wp_citizens WHERE 
		CITIZEN_IDNUM = '".$CITIZEN_IDNUM."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// GET USER ACTIVE CONTRACT
	function getUserContractData($info)
	{
		$table = $info["table"];
		$fields = $info["fields"];
		$keyField = $info["keyField"];
		$code = $info["code"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d');
		
		$str = "SELECT $fields FROM $table WHERE 
		$keyField = '".$code."' AND CONTRACT_ENDATE >= '".$now."'";
		$query = $this->db->query($str);
		
		if(count($query) > 0)
		{$ans = $query[0];}
		else
		{$ans = "none";}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	// GET ASSING CONTRACTS
	function getAssignContracts($info)
	{
		$USER_CTYPE_F = $info["USER_CTYPE_F"];
		$USER_ACTIVITIES_F = json_decode($info["USER_ACTIVITIES_F"]);
		$USER_ENTITY_F = $info["USER_ENTITY_F"];
		$TABLE = "wp_contracts";
		$INDEX = "CONTRACT_CODE";
		$ORDER = "CONTRACT_USERTYPE ASC";
		
		$now = new DateTime();
		$now = $now->format('Y-m-d');
		
		$where = "WHERE  $INDEX != 'null' ";
		
		if($USER_CTYPE_F != "Superior")
		{
			$where .= "AND CONTRACT_ENTITY = '$USER_ENTITY_F'";
			
			if($USER_CTYPE_F == "Director" or $USER_CTYPE_F == "Coordinador")
			{
				// GET RELATED ACTIVITIES CONTRACTS

				if(count($USER_ACTIVITIES_F) > 0)
				{
					$where .= " AND (";
					for($i=0; $i<count($USER_ACTIVITIES_F); $i++)
					{
						$ACT = $USER_ACTIVITIES_F[$i];
						$where .= "CONTRACT_ACTIVITIES LIKE '%".$ACT."%'";
						if($i != count($USER_ACTIVITIES_F) -1)
						{$where .= " OR ";}
					}
					$where .= ") ";
				}
			}
		}
		
		// MUST BE ASSIGNED
		$where .= "AND CONTRACT_OWNER != 'null' ";
		// MUST HAVE CLASS GOALS
		$where .= "AND CONTRACT_OTHER_GOALS != 'null' ";
		// MUST BE ACTIVE BY DATE
		$where .= "AND CONTRACT_ENDATE >= '".$now."'";

		
		$str = "SELECT * FROM $TABLE $where ORDER BY $ORDER";
		$query = $this->db->query($str);
		
		
		// GET OWNER NAME
		for($i=0; $i<count($query); $i++)
		{
			$item = $query[$i];
			
			$data = array();
			$data["table"] = "wp_trusers";
			$data["fields"] = " USER_NAME, USER_LASTNAME ";
			$data["keyField"] = " USER_CODE ";
			$data["code"] = $item["CONTRACT_REQUESTER"];
			
			$friendlyData = $this->getFriendlyData($data)["message"];
			
			$USER_NAME = $friendlyData["USER_NAME"];
			$USER_LASTNAME = $friendlyData["USER_LASTNAME"];
			
			$user = $USER_NAME." ".$USER_LASTNAME;

			$query[$i]["CONTRACT_OWNER_NAME"] = $user;

		}
		
		
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
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
		
		if($table == "wp_contracts")
		{
			$message = "Se ha rechazado su solicitud de contrato ".$info["CONTRACT_NUMBER"].", deberÃ¡ diligenciarla de nuevo.";
			
			// SEND MAIL 
			$data = array();
			$data["subject"] = "Solicitud de contrato rechazada - DIOGENES";
			$data["email"] = $info["USER_EMAIL"];
			$data["content"] = "Mensaje de administrador DIOGENES<br><br>".$message."<br><br>";
			$data["header"] = "-";
			$data["footer"] = "-";
			
			$send = $this->myMailer($data, "")["message"];
			$resp["message"] = $send;
		}
		if($table == "wp_trusers")
		{
			$str = "SELECT CONTRACT_CODE FROM wp_contracts WHERE 
			CONTRACT_OWNER LIKE '%".$code."%' OR CONTRACT_REQUESTER LIKE '%".$code."%'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantU";
				$resp["status"] = true;
				return $resp;
			}
			
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
		if($table == "wp_projects")
		{
			$str = "SELECT ACTIVITY_PROJECT FROM wp_activities WHERE 
			ACTIVITY_PROJECT LIKE '%".$code."%'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantPR";
				$resp["status"] = true;
				return $resp;
			}
		}
		if($table == "wp_activities")
		{
			$str = "SELECT CONTRACT_CODE FROM wp_contracts WHERE 
			CONTRACT_ACTIVITIES LIKE '%".$code."%'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantA";
				$resp["status"] = true;
				return $resp;
			}
		}
		if($table == "wp_entities")
		{
			$str = "SELECT CONTRACT_CODE FROM wp_contracts WHERE 
			CONTRACT_ENTITY LIKE '%".$code."%'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantE";
				$resp["status"] = true;
				return $resp;
			}
		}
		if($table == "wp_zones")
		{
			$str = "SELECT CONTRACT_CODE FROM wp_contracts WHERE 
			CONTRACT_ZONES LIKE '%".$code."%'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantE";
				$resp["status"] = true;
				return $resp;
			}
			
			$str = "SELECT HOOD_CODE FROM wp_hoods WHERE 
			HOOD_ZONE LIKE '%".$code."%'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantH";
				$resp["status"] = true;
				return $resp;
			}
		}
		if($table == "wp_hoods")
		{
			// NOT DEFINED
		}
		if($table == "wp_conditions")
		{
			// CHECK FOR CITIZEN USED
			$str = "SELECT CITIZEN_CONDITION FROM wp_citizens WHERE 
			CITIZEN_CONDITION LIKE '%".$code."%'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantCondCit";
				$resp["status"] = true;
				return $resp;
			}
		}
		if($table == "wp_etnias")
		{
			// CHECK FOR CITIZEN USED
			$str = "SELECT CITIZEN_ETNIA FROM wp_citizens WHERE 
			CITIZEN_ETNIA LIKE '%".$code."%'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantEtniaCit";
				$resp["status"] = true;
				return $resp;
			}
		}
		if($table == "wp_groups")
		{
			// NOT DEFINED
			
			$str = "SELECT CLASS_GROUP FROM wp_classes WHERE 
			CLASS_GROUP LIKE '%".$code."%' LIMIT 1";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantGC";
				$resp["status"] = true;
				return $resp;
			}
			
			
		}
		if($table == "wp_classes")
		{
			// NOT DEFINED
		}
		if($table == "wp_etaries")
		{
			// NOT DEFINED
		}
		if($table == "wp_institutes")
		{
			// CHECK IF EVENTS ARE USING INSTITUTE
			
			// $str = "SELECT CONTRACT_CODE FROM wp_contracts WHERE 
			// CONTRACT_ZONES LIKE '%".$code."%'";
			// $query = $this->db->query($str);
			
			// if(count($query) >0)
			// {
				// $resp["message"] = "cantE";
				// $resp["status"] = true;
				// return $resp;
			// }
		}
		if($table == "wp_events")
		{
			
		}
		if($table == "wp_events_r")
		{
			$table = "wp_events";
		}
		if($table == "wp_groups_citizens")
		{
			$GROUP_CODE = $info["GROUP_CODE"];
			$CITIZEN_IDNUM = $info["code"];
			
			// GET ACTUAL CITIZENS FROM GROUP AS ARRAY
			$str = "SELECT GROUP_CITIZENS FROM wp_groups WHERE 
			GROUP_CODE = '".$GROUP_CODE."'";
			$query = $this->db->query($str);
			
			$GROUP_CITIZENS = $query[0]["GROUP_CITIZENS"];
			$GROUP_CITIZENS = json_decode($GROUP_CITIZENS, true);
			
			for($i=0; $i<count($GROUP_CITIZENS); $i++)
			{
				$code = $GROUP_CITIZENS[$i]["CITIZEN_IDNUM"];
				if($code == $CITIZEN_IDNUM)
				{
					array_splice($GROUP_CITIZENS,$i,1);
					break;
				}
			}
			
			$citizens = $GROUP_CITIZENS;
			
			// GET USER NAMES
			for($i=0; $i<count($citizens); $i++)
			{
				$item = $citizens[$i];
				
				$data = array();
				$data["table"] = "wp_citizens";
				$data["fields"] = " CITIZEN_NAME, CITIZEN_LASTNAME ";
				$data["keyField"] = " CITIZEN_IDNUM ";
				$data["code"] = $item["CITIZEN_IDNUM"];
				
				$friendlyData = $this->getFriendlyData($data)["message"];
				
				if($friendlyData != "none")
				{
					$USER_NAME = $friendlyData["CITIZEN_NAME"];
					$USER_LASTNAME = $friendlyData["CITIZEN_LASTNAME"];
				}
				else
				{
					$USER_NAME = "-";
					$USER_LASTNAME = "";
				}
				
				$user = $USER_NAME." ".$USER_LASTNAME;
				$citizens[$i]["CITIZEN_NAME"] = $user;
			}
			
			$ans = $citizens;
			
			// RESAVE TO GROUP
			$GROUP_CITIZENS = json_encode($GROUP_CITIZENS, true);
			$str = "UPDATE wp_groups SET 
			GROUP_CITIZENS = '".$GROUP_CITIZENS."'
			WHERE 
			GROUP_CODE ='".$GROUP_CODE."'";
			$query = $this->db->query($str);
			
			$resp["message"] = $ans;
			$resp["status"] = true;
			return $resp;
		}
		if($table == "wp_remitions")
		{
			$str = "SELECT REM_LINE, REM_CITIZEN, REM_CONTRATIST FROM wp_remitions WHERE REM_CODE = '".$code."'";
			$query = $this->db->query($str);
			
			$REM_CONTRATIST = $query[0]["REM_CONTRATIST"];
			$REM_LINE = $query[0]["REM_LINE"];
			$REM_CITIZEN = $query[0]["REM_CITIZEN"];
			
			$str = "SELECT REMCOM_CODE FROM wp_attend WHERE REMCOM_CREATED_BY = '".$REM_CONTRATIST."' AND REMCOM_LINE = '".$REM_LINE."' AND REMCOM_CITIZEN = '".$REM_CITIZEN."'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantCom";
				$resp["status"] = true;
				return $resp;
			}
		}
		
		if($table == "wp_master_component")
		{
			$str = "SELECT SCOMPONENT_CODE FROM wp_master_scomponent WHERE SCOMPONENT_COMPONENT = '".$code."'";
			$query = $this->db->query($str);
			
			if(count($query) >0)
			{
				$resp["message"] = "cantComPON";
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
	function checkContractState($info)
	{
		$CONTRACT_NUMBER = $info["CONTRACT_NUMBER"];
		$CONTRACT_ENTITY = $info["CONTRACT_ENTITY"];
		$CONTRACT_CESION_STATE = $info["CONTRACT_CESION_STATE"];
		
		$str = "SELECT * FROM wp_contracts WHERE CONTRACT_NUMBER = '".$CONTRACT_NUMBER."' AND CONTRACT_CESION_STATE = '".$CONTRACT_CESION_STATE."' AND CONTRACT_ENTITY = '".$CONTRACT_ENTITY."'";
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
			
			$send = $this->myMailer($data, "");
			
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
	function myMailer($info, $other)
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
		
		if($other != "" and $other != null){$mail->AddAddress($other);}
		// if(isset($other)){$mail->AddAddress($other);}

		// $recipients = array('leoncitobravo2008@hotmail.com', 'deleteoutlook.com', 'contacto@inscolombia.com');
		// foreach($recipients as $demail)// {// $mail->AddCC($demail);// }
		// $mail->AddAttachment("../../ding.WAV", 'soundfile.WAV');
		
		$content = "<h3 style='text-align: center;'>".$content."</h3>";
		$body = $header."<br>".$content."<br>".$footer;
		$mail->Body = $body; 

		// EnvÃ­a el correo. 
		// DESCOMENTAR ESTO EN PRODUCTIVO
		$exito = $mail->Send();
		
		// COMENTAR EN PRODUCTIVO
		// $exito = true;
		
		if($exito){$ans = "enviado";}else{$ans = $mail->ErrorInfo;} 
		
		$ans = "enviado";
		
		// $ans = $body;

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function loadCsv($info)
	{
		$file = $info["csv"];
		
		$filePath = "temp.csv";
		$data = explode( ',', $file);
		$decoded = base64_decode($data[1]);
		file_put_contents($filePath, $decoded);
		
		$file = file_get_contents($filePath);
		$data = mb_convert_encoding($file, 'UTF-8');
		$lines = explode("\n",$data);
		
		$addTable = array();
		
		for($i=0; $i<count($lines); $i++)
		{
			$line = $lines[$i];
			if($line == ""){continue;}
			
			$reg = explode(",", $line);
			$element = array();
			$element["INSTITUTE_CODE"] = $reg[0];
			
			if($element["INSTITUTE_CODE"] == "")
			{
				$now = new DateTime();
				$now = $now->format('Y-m-d H:i:s');
				$element["INSTITUTE_CODE"] = md5($filePath.$now);
			}
			
			$element["INSTITUTE_CITY"] = $reg[1];
			$element["INSTITUTE_ZONE"] = $reg[2];
			$element["INSTITUTE_HOOD"] = $reg[3];
			$element["INSTITUTE_ADDRESS"] = $reg[4];
			
			$long = count($reg);
			if($long == 8)
			{
				$element["INSTITUTE_COORDS"] = "";
				$element["INSTITUTE_NAME"] = $reg[6];
				$element["INSTITUTE_EDU"] = explode("\r",$reg[7])[0];
			}
			else
			{
				$coord1 = $res = str_replace( array('\'','"',',',';','<','>'), '-', $reg[5]);
				$coord1 = explode("-",$coord1)[1];
				$coord2 = floatval($reg[6]);
				$coord = strval($coord1).", ".$coord2;
				$element["INSTITUTE_COORDS"] = $coord;
				$element["INSTITUTE_NAME"] = $reg[7];
				$element["INSTITUTE_EDU"] = explode("\r",$reg[8])[0];
			}
			
			array_push($addTable, $element);
			
			$INSTITUTE_CODE = $element["INSTITUTE_CODE"];
			$INSTITUTE_CITY = $element["INSTITUTE_CITY"];
			$INSTITUTE_ZONE = $element["INSTITUTE_ZONE"];
			$INSTITUTE_HOOD = $element["INSTITUTE_HOOD"];
			$INSTITUTE_ADDRESS = $element["INSTITUTE_ADDRESS"];
			$INSTITUTE_COORDS = $element["INSTITUTE_COORDS"];
			$INSTITUTE_NAME = $element["INSTITUTE_NAME"];
			$INSTITUTE_EDU = $element["INSTITUTE_EDU"];

			
			$str = "INSERT INTO wp_institutes (
			INSTITUTE_CODE,
			INSTITUTE_CITY,
			INSTITUTE_ZONE,
			INSTITUTE_HOOD,
			INSTITUTE_ADDRESS,
			INSTITUTE_COORDS,
			INSTITUTE_NAME,
			INSTITUTE_EDU
			)
			VALUES 
			(
			'".$INSTITUTE_CODE."',
			'".$INSTITUTE_CITY."',
			'".$INSTITUTE_ZONE."',
			'".$INSTITUTE_HOOD."',
			'".$INSTITUTE_ADDRESS."',
			'".$INSTITUTE_COORDS."',
			'".$INSTITUTE_NAME."',
			'".$INSTITUTE_EDU."'
			) 
			ON DUPLICATE KEY UPDATE
			INSTITUTE_CITY = '".$INSTITUTE_CITY."', 
			INSTITUTE_ZONE = '".$INSTITUTE_ZONE."', 
			INSTITUTE_HOOD = '".$INSTITUTE_HOOD."', 
			INSTITUTE_ADDRESS = '".$INSTITUTE_ADDRESS."', 
			INSTITUTE_COORDS = '".$INSTITUTE_COORDS."', 
			INSTITUTE_NAME = '".$INSTITUTE_NAME."', 
			INSTITUTE_EDU = '".$INSTITUTE_EDU."'
			";
			
			$resp["message"] = $str;
			$resp["status"] = true;
			// return $resp;
			
			$query = $this->db->query($str);
			

		}
		
		
		
		
		
		$resp["message"] = $addTable;
		$resp["status"] = true;
		return $resp;
		
	}
	
	function multiexplode($delimiters,$string) 
	{

		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return  $launch;
	}
	
}
?>
