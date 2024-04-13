<?php
date_default_timezone_set('America/Bogota');
require('../fpdf/fpdf.php');
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
                        
			$str = "UPDATE users SET FORCEOUT = '0' WHERE MAIL ='".$info["autor"]."'";
$query = $this->db->query($str);			
						
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
	function checkForceOut($info)
	{
		$email = $info["email"];
		$str = "SELECT FORCEOUT FROM users WHERE MAIL = '".$email."'";
		$query = $this->db->query($str)[0]["FORCEOUT"];
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
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
	function setLimits($info)
	{
		$email = $info["email"];
		$banned = $info["banned"];
		
		$str = "UPDATE users SET BANNED = '".$banned."', FORCEOUT = '1' WHERE MAIL ='".$email."'";
		$query = $this->db->query($str);
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getOrderLimits($info)
	{

		$str = "SELECT ONUM, CLIENT  FROM orders ORDER BY DATE DESC LIMIT 10";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function deleteFile($info)
	{
		$type = $info["type"];
		$code = $info["code"];

		// $destination_path = "/home/jmmdy48n8trq/public_html/".$type."/";
		$destination_path = "/xampp/htdocs/www/quoting/".$type."/";
		$dir_path =  $destination_path.$code."/";
		// CLEAR FOLDER
		$files = glob($dir_path."*"); foreach($files as $file){ if(is_file($file))unlink($file); }
		
		if($type == "trfiles")
		{$table = "training"; $field = "FILE"; $key = "CODE";}
		if($type == "ppefiles")
		{$table = "training"; $field = "FILE"; $key = "CODE";}
		if($type == "files")
		{$table = "orders"; $field = "FILELINK"; $key = "CODE";}
		if($type == "filesD")
		{$table = "days"; $field = "FILELINK"; $key = "DCODE";}
		if($type == "filesR")
		{$table = "requests"; $field = "FILELINK"; $key = "CODE";}
		if($type == "filesT")
		{$table = "dayItems"; $field = "FILE"; $key = "ICODE";}
	
		
		$str = "UPDATE $table SET $field = '' WHERE $key ='".$code."'";
		$query = $this->db->query($str);

		$ans = $info;
		
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
	function getTechiList($info)
	{
		
		$cat = $info["f-techiCat"];
		$name = $info["f-techiName"];
		$location = $info["f-techiLocation"];
		$type = $info["f-techiCat"];
		
		$where = "WHERE  STATUS = 1 ";

	
		if($location != "")
		{
			$where .= "AND uPos LIKE '%$location%'";
		}
		if($name != "")
		{
			$where .= "AND  RESPNAME LIKE '%$name%'";
		}
		if($type != "")
		{
			$where .= "AND  TYPE = '$type'";
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
	function getReqList($info)
	{
		$type = $info["f-reqType"];
		$windfarm = $info["f-reqWindfarm"];
		$distict = $info["f-reqDistrict"];
		$provided = $info["f-reqProvided"];
		$inidate = $info["f-reqInidate"];
		$endate = $info["f-reqEndate"];
		
		$mode = $info["mode"];
		
		$reqNum = $info["f-reqNum"];

		$where = "WHERE  CODE != '0' ";
		// $where = "WHERE  REQPARENT = '' ";

		if($type != ""){$where .= "AND TYPE LIKE '%$type%'";}
		if($windfarm != ""){$where .= "AND WINDFARM LIKE '%$windfarm%'";}
		if($provided != ""){$where .= "AND RESULT = '$provided'";}
		if($distict != ""){$where .= "AND  DETAIL LIKE '%$distict%'";}
		if($reqNum != ""){$where .= "AND  RNUM LIKE '%$reqNum%'";}
		if($inidate != ""){$where .= "AND DATE >=  '$inidate' ";} 
		if($endate != ""){$where .= "AND DATE <=  '$endate' ";} 

		
		if($mode == "ex")
		{
			$str = "SELECT * FROM requests $where ORDER BY RNUM DESC LIMIT 10000";
		}
		else
		{
			$str = "SELECT * FROM requests $where ORDER BY RNUM DESC LIMIT 400";
		}
	
		
		
		
		$query = $this->db->query($str);
	
		$resp["message"] = $query;
		$resp["status"] = true;
		
		if($mode == "ex")
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
			
			// HEADER TITLE
			
			$sheet->setCellValue('A1', 'Requests report');
			$sheet->getStyle("A1")->getFont()->setBold(true);
			$sheet->mergeCells('A1:N1');
			
			
			$c = 3;
			
			$sheet->getStyle("A$c:Y$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:Y$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:Y$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Date");
			$sheet->setCellValue("B$c", "Requester");
			$sheet->setCellValue("C$c", "District");
			$sheet->setCellValue("D$c", "Description");
			$sheet->setCellValue("E$c", "# Techs");
			$sheet->setCellValue("F$c", "Provided");
			$sheet->setCellValue("G$c", "Time (Operational Hours)");
			$sheet->setCellValue("H$c", "Request type");
			$sheet->setCellValue("I$c", "Comments");
			$sheet->setCellValue("J$c", "Windfarm");
			$sheet->setCellValue("K$c", "Type of work");
			$sheet->setCellValue("L$c", "Author");
			$sheet->setCellValue("M$c", "Code");
			$sheet->setCellValue("N$c", "Type of request");
			
			$sheet->setCellValue("O$c", "Platform");
			$sheet->setCellValue("P$c", "Address");
			$sheet->setCellValue("Q$c", "PM");
			$sheet->setCellValue("R$c", "Support required");
			$sheet->setCellValue("S$c", "Component");
			$sheet->setCellValue("T$c", "Brand");
			$sheet->setCellValue("U$c", "Serial number");
			$sheet->setCellValue("V$c", "Turbine state");
			$sheet->setCellValue("W$c", "Tooling");
			$sheet->setCellValue("X$c", "Parts");
			$sheet->setCellValue("Y$c", "Failure description");
			
			// $sheet->mergeCells("M$c:N$c");
			
			$c++;

			for($i = 0; $i<count($query);$i++)
			{
				$item = $query[$i];

				$sheet->setCellValue("A$c",  $item["DATE"]);
				$sheet->setCellValue("B$c",  $item["REQUESTER"]);
				$sheet->setCellValue("C$c",  $item["DISTRICT"]);
				$sheet->setCellValue("D$c",  $item["DETAIL"]);
				$sheet->setCellValue("E$c",  $item["TECHS"]);
				$sheet->setCellValue("F$c",  $item["RESULT"]);
				$sheet->setCellValue("G$c",  $item["FRAMEDAYS"]);
				$sheet->setCellValue("H$c",  $item["TYPE"]);
				$sheet->setCellValue("I$c",  $item["COMMENTS"]);
				$sheet->setCellValue("J$c",  $item["WINDFARM"]);
				$sheet->setCellValue("K$c",  $item["DETAIL"]);
				$sheet->setCellValue("L$c",  $item["AUTOR"]);
				
				$sheet->setCellValue("M$c",  $item["RNUM"]);
				
				if($item["REQPARENT"] != "")
				{
					$sheet->setCellValue("N$c",  "Add for request: ".$item["REQPARENT"]);
				}
				else
				{
					$sheet->setCellValue("N$c",  "Initial request");
				}
				
				
				$sheet->setCellValue("O$c",  $item["REQPLAT"]);
				$sheet->setCellValue("P$c",  $item["REQADDRESS"]);
				$sheet->setCellValue("Q$c",  $item["REQPM"]);
				$sheet->setCellValue("R$c",  $item["REQSUREQUIRED"]);
				$sheet->setCellValue("S$c",  $item["REQCOMP"]);
				$sheet->setCellValue("T$c",  $item["REQBRAND"]);
				$sheet->setCellValue("U$c",  $item["REQSN"]);
				$sheet->setCellValue("V$c",  $item["REQTSTATE"]);
				$sheet->setCellValue("W$c",  $item["REQTOOL"]);
				$sheet->setCellValue("X$c",  $item["REQPART"]);
				$sheet->setCellValue("Y$c",  $item["REQSUPDESC"]);

				$sheet->getStyle("A$c:Y$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:Y$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:Y$c")->getFont()->setSize(9);

				$c++;
			}
			
			$fname  = "Requests report";
			$fname = htmlEntities(utf8_decode($fname));
			$path = "../../files/requests/".$fname.".xls";
			
			$hasFile = file_exists($path);
			if($hasFile == true){unlink($path);}
			
			$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
			$objWriter->save($path );
			
			$resp["path"] = $fname;
		
		}
	

		return $resp;
	
	}
	function getReqUPList($info)
	{
		$type = $info["f-reqUPType"];
		$windfarm = $info["f-reqUPWindfarm"];
		$speciality = $info["f-reqUPspeciality"];
		$required = $info["f-reqUrequired"];
		$reqNum = $info["f-reqUPNum"];
		$inidate = $info["f-reqUPInidate"];
		$endate = $info["f-reqUPEndate"];
		
		$mode = $info["mode"];
		
		$where = "WHERE  REQSOURCE = 'sup' ";

		if($type != ""){$where .= "AND TYPE LIKE '%$type%'";}
		if($windfarm != ""){$where .= "AND WINDFARM LIKE '%$windfarm%'";}
		if($speciality != ""){$where .= "AND DETAIL = '$speciality'";}
		if($required != ""){$where .= "AND  REQSUREQUIRED LIKE '%$required%'";}
		if($reqNum != ""){$where .= "AND  RNUM LIKE '%$reqNum%'";}
		if($inidate != ""){$where .= "AND DATE >=  '$inidate' ";} 
		if($endate != ""){$where .= "AND DATE <=  '$endate' ";} 

		$str = "SELECT * FROM requests $where ORDER BY DATE DESC LIMIT 300";
		$query = $this->db->query($str);
	
		$resp["message"] = $query;
		$resp["status"] = true;
		
		if($mode == "ex")
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
			
			// HEADER TITLE
			
			$sheet->setCellValue('A1', 'Support Requests report');
			$sheet->getStyle("A1")->getFont()->setBold(true);
			$sheet->mergeCells('A1:N1');
			
			
			$c = 3;
			
			$sheet->getStyle("A$c:Y$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:Y$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:Y$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Date");
			$sheet->setCellValue("B$c", "Requester");
			$sheet->setCellValue("C$c", "District");
			$sheet->setCellValue("D$c", "Description");
			$sheet->setCellValue("E$c", "# Techs");
			$sheet->setCellValue("F$c", "Provided");
			$sheet->setCellValue("G$c", "Time (Operational Hours)");
			$sheet->setCellValue("H$c", "Request type");
			$sheet->setCellValue("I$c", "Comments");
			$sheet->setCellValue("J$c", "Windfarm");
			$sheet->setCellValue("K$c", "Type of work");
			$sheet->setCellValue("L$c", "Author");
			$sheet->setCellValue("M$c", "Code");
			$sheet->setCellValue("N$c", "Type of request");
			$sheet->setCellValue("O$c", "Platform");
			$sheet->setCellValue("P$c", "Address");
			$sheet->setCellValue("Q$c", "PM");
			$sheet->setCellValue("R$c", "Support required");
			$sheet->setCellValue("S$c", "Component");
			$sheet->setCellValue("T$c", "Brand");
			$sheet->setCellValue("U$c", "Serial number");
			$sheet->setCellValue("V$c", "Turbine state");
			$sheet->setCellValue("W$c", "Tooling");
			$sheet->setCellValue("X$c", "Parts");
			$sheet->setCellValue("Y$c", "Failure description");
			
			
			// $sheet->mergeCells("M$c:N$c");
			
			$c++;

			for($i = 0; $i<count($query);$i++)
			{
				$item = $query[$i];

				$sheet->setCellValue("A$c",  $item["DATE"]);
				$sheet->setCellValue("B$c",  $item["REQUESTER"]);
				$sheet->setCellValue("C$c",  $item["DISTRICT"]);
				$sheet->setCellValue("D$c",  $item["DETAIL"]);
				$sheet->setCellValue("E$c",  $item["TECHS"]);
				$sheet->setCellValue("F$c",  $item["RESULT"]);
				$sheet->setCellValue("G$c",  $item["FRAMEDAYS"]);
				$sheet->setCellValue("H$c",  $item["TYPE"]);
				$sheet->setCellValue("I$c",  $item["COMMENTS"]);
				$sheet->setCellValue("J$c",  $item["WINDFARM"]);
				$sheet->setCellValue("K$c",  $item["DETAIL"]);
				$sheet->setCellValue("L$c",  $item["AUTOR"]);
				$sheet->setCellValue("M$c",  $item["RNUM"]);
				if($item["REQPARENT"] != "")
				{$sheet->setCellValue("N$c",  "Add for request: ".$item["REQPARENT"]);}
				else
				{$sheet->setCellValue("N$c",  "Initial request");}
				$sheet->setCellValue("O$c",  $item["REQPLAT"]);
				$sheet->setCellValue("P$c",  $item["REQADDRESS"]);
				$sheet->setCellValue("Q$c",  $item["REQPM"]);
				$sheet->setCellValue("R$c",  $item["REQSUREQUIRED"]);
				$sheet->setCellValue("S$c",  $item["REQCOMP"]);
				$sheet->setCellValue("T$c",  $item["REQBRAND"]);
				$sheet->setCellValue("U$c",  $item["REQSN"]);
				$sheet->setCellValue("V$c",  $item["REQTSTATE"]);
				$sheet->setCellValue("W$c",  $item["REQTOOL"]);
				$sheet->setCellValue("X$c",  $item["REQPART"]);
				$sheet->setCellValue("Y$c",  $item["REQSUPDESC"]);
				

				$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);

				$c++;
			}
			
			$fname  = "Support Requests report";
			$fname = htmlEntities(utf8_decode($fname));
			$path = "../../files/requests/".$fname.".xls";
			
			$hasFile = file_exists($path);
			if($hasFile == true){unlink($path);}
			
			$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
			$objWriter->save($path );
			
			$resp["path"] = $fname;
		
		}
	

		return $resp;
	
	}
	function reqAdsGet($info)
	{
		$parent = $info["code"];
		
		$str = "SELECT *  FROM requests WHERE 
		REQPARENT = '".$parent."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getUschcedule($info)
	{
		$code = $info["code"];
		
		$str = "SELECT *  FROM schedule WHERE UCODE = '".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getWeekSchedule($info)
	{
		$startDate = $info["range"][0];
		$endDate = $info["range"][6];
		
		$str = "SELECT *  FROM schedule WHERE DATE >= '".$startDate."' AND DATE <= '".$endDate."' AND TYPE != '' ORDER BY TNAME ASC";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getWeekScheduleF($info)
	{
		$startDate = $info["range"][0];
		$endDate = $info["range"][6];
		$position = $info["position"];
		$name = $info["name"];

		$where = "WHERE  DATE >= '".$startDate."' AND DATE <= '".$endDate."' AND TYPE != ''";
		
		if($position != "")
		{
			$where .= "AND POSITION LIKE '%$position%'";
		}
		else if($name != "")
		{
			$where .= "AND TNAME LIKE '%$name%'";
		}
		
		$str = "SELECT *  FROM schedule $where ORDER BY TNAME ASC";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getSchList($info)
	{
		
		$type = $info["f-schTechiCat"];
		$name = $info["f-schTechiName"];
		$email = $info["f-schTechmail"];

		$where = "WHERE  STATUS = 1 ";
		
		if($type != "")
		{
			$where .= "AND  TYPE = '$type'";
		}
		if($name != "")
		{
			$where .= "AND  RESPNAME LIKE '%$name%'";
		}
		if($email != "")
		{
			$where .= "AND uPos LIKE '%$email%'";
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
		
		// $resp = "lolo";
		
		return $resp;
	
	}
	function saveSch($info)
	{
		$code = $info["code"];
		$range = $info["range"];
		$schType = $info["schType"];
		$schObs = $info["schObs"];
		$schName = $info["schName"];
		$schPos = $info["schPos"];
		
		for($i=0; $i<count($range); $i++)
		{
			$item = $range[$i];
			$schcode = md5($item.$i);
			$str = "INSERT INTO schedule (SCHCODE, UCODE, DATE, TYPE, DETAIL, TNAME, POSITION) VALUES ('".$schcode."', '".$code."', '".$item."', '".$schType."', '".$schObs."', '".$schName."', '".$schPos."') ON DUPLICATE KEY UPDATE TYPE = '".$schType."', DETAIL = '".$schObs."', TNAME = '".$schName."', POSITION = '".$schPos."'";
			$query = $this->db->query($str);
		}

		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getUprofile($info)
	{
		$code = $info["code"];
		
		$str = "SELECT *  FROM users WHERE CODE = '".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query[0];
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getUgid($info)
	{
		$code = $info["code"];
		
		$str = "SELECT uGID FROM users WHERE CODE = '".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getOrdeList($info)
	{
		$client = $info["f-orderParent"];
		$farm = $info["f-orderWindFarm"];
		$status = intval($info["f-orderStatus"]);
		$turbine = $info["f-orderTurbine"];
		$wkdetail = $info["f-orderDetail"];
		$type = $info["f-orderType"];
		$askType = $info["askType"];
		
		$ucode = $info["ucode"];
		$where = "WHERE  STATUS != 'null' ";
		
		if($client != "")
		{
			$where .= "AND  DISTRICT LIKE  '%$client%'";
		}
		if($farm != "")
		{
			$where .= "AND  WINDFARM LIKE '%$farm%'";
		}
		if($status != "")
		{
			$where .= "AND  STATUS = '$status'";
		}
		if($turbine != "")
		{
			$where .= "AND  ONUM LIKE '%$turbine%'";
		}
		if($wkdetail != "")
		{
			$where .= "AND  WKDETAIL LIKE '%$wkdetail%'";
		}
		if($type != "")
		{
			if($type == "2")
			{
				$where .= "AND  TYPE != '1' AND TYPE != '0' ";
			}
			else
			{
				$where .= "AND  TYPE = '$type'";
			}
		}

		$str = "SELECT * FROM orders $where ORDER BY DATE DESC LIMIT 150";
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
		
		$str = "SELECT CODE, TEMPLATENAME FROM orders WHERE TYPE = '0' ORDER BY TEMPLATENAME ASC";
		$templates = $this->db->query($str);
		$resp["templates"] = $templates;
		
		return $resp;
	
	}
	function getPodList($info)
	{
		$quote = $info["f-quoteParent"];
		$farm = $info["f-podWindfarm"];
		$so = $info["f-podSO"];
		$turbine = $info["f-pdistrict"];
		$wo = $info["f-podWO"];
		$askType = $info["askType"];
		
		$ucode = $info["ucode"];
		$where = "WHERE  PCODE != 'null' ";

		
		if($quote != "")
		{
			$where .= "AND  QCODE LIKE  '%$quote%'";
		}
		if($farm != "")
		{
			$where .= "AND  WFARM LIKE  '%$farm%'";
		}
		if($turbine != "")
		{
			$where .= "AND  TURBINE LIKE  '%$turbine%'";
		}
		if($so != "")
		{
			if($so == "2")
			{
				$where .= "AND  CLOSD !=  ''";
			}
			else
			{
				$where .= "AND  CLOSD =  ''";
			}
		}
		if($wo != "")
		{
			$where .= "AND TOW LIKE  '%$wo%'";
		}


		$str = "SELECT * FROM projects $where ORDER BY QCODE DESC LIMIT 150";
		$query = $this->db->query($str);
	
	
		$str = "SELECT ONUM, CLIENT FROM orders WHERE STATUS != '1' ORDER BY ONUM DESC";
		$qlist = $this->db->query($str);
	
		if(count($query) > 0)
		{
				$resp["message"] = $query;
				$resp["qlist"] = $qlist;
				$resp["status"] = true;
		}
		else
		{
				$resp["message"] = array();
				$resp["qlist"] = $qlist;
				$resp["status"] = true;
		}

		return $resp;
	
	}
	function getQdata($info)
	{
		$code = $info["code"];
		
		// ACTION
		
		$str = "SELECT *  FROM orders WHERE ONUM = '".$code."'";
		$query = $this->db->query($str);
		
		
		$ans = $query[0];
		$resp["message"] = $ans;
		$resp["status"] = true;
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
		
		$str = "UPDATE orders SET FILELINK ='".$name."' WHERE CODE='".$code."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
	}
	function setFileLinkT($info)
	{
		
		$code = $info["dcode"];
		$name = htmlentities($info["fileLink"]);
		
		$str = "UPDATE dayItems SET FILE ='".$name."' WHERE ICODE = '".$code."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
	}
	function setFileLinkD($info)
	{
		
		$code = $info["ocode"];
		$name = htmlentities($info["fileLink"]);
		
		$str = "UPDATE days SET FILELINK ='".$name."' WHERE DCODE='".$code."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
	}
	function setFileLinkTr($info)
	{
		
		$code = $info["ocode"];
		$name = htmlentities($info["fileLink"]);
		
		$str = "UPDATE training SET FILE ='".$name."' WHERE CODE='".$code."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
	}
	function setFileLinkReq($info)
	{
		
		$code = $info["ocode"];
		$name = htmlentities($info["fileLink"]);
		
		$str = "UPDATE requests SET FILELINK ='".$name."' WHERE CODE='".$code."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;
	}
	function techiSave($info)
	{
		$otype = $info["otype"];
		$utype = $info["utype"];
		$CNAME = $info["a-techiName"];
		$RESPNAME = $info["a-techiName"];
		$MAIL = $info["a-techiEmail"];
		$CATEGORY = $info["a-techiCat"];
		
		$uGID = $info["uGID"];
		$uPos = $info["uPos"];
		$emContact = $info["emContact"];
		$uPhone = $info["uPhone"];
		$uTruck = $info["uTruck"];
		$uPlate = $info["uPlate"];
		$uModel = $info["uModel"];
		$uHdate = $info["uHdate"];
		$uGTI = $info["uGTI"];
		$AUTHOR = $info["AUTHOR"];
		

		$STATUS = "1";

		if($otype == "c")
		{
			$REGDATE = $info["date"];
			$PASSWD = md5($MAIL);
			 
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
				
				$str = "INSERT INTO users (CODE, RESPNAME, MAIL, PASSWD, STATUS, REGDATE, CNAME, TYPE, CATEGORY, uGID, uPos, emContact, uPhone,  uTruck, uPlate, uModel, uHdate, uGTI, AUTHOR) VALUES ('".$CODE."', '".$RESPNAME."', '".$MAIL."', '".$PASSWD."', '".$STATUS."', '".$REGDATE."', '".$CNAME."', '".$utype."', '".$CATEGORY."', '".$uGID."', '".$uPos."', '".$emContact."', '".$uPhone."', '".$uTruck."', '".$uPlate."', '".$uModel."', '".$uHdate."', '".$uGTI."', '".$AUTHOR."')";
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
			
			$str = "UPDATE users SET RESPNAME='".$RESPNAME."', CNAME = '".$CNAME."', TYPE = '".$CATEGORY."', CATEGORY = '".$CATEGORY."', uGID = '".$uGID."', uPos = '".$uPos."', emContact = '".$emContact."', uPhone = '".$uPhone."', uTruck = '".$uTruck."', uPlate = '".$uPlate."', uModel = '".$uModel."', uHdate = '".$uHdate."', uGTI = '".$uGTI."' WHERE CODE ='".$code."'"; 
			$query = $this->db->query($str);
			
			$this->chlog($info);
			$resp["message"] = "edite";
			$resp["status"] = true;
			return $resp;
		}
	}
	function setReqState($info)
	{
		$code = $info["code"];
		$state = $info["state"];
		
		$str = "UPDATE requests SET REQSTATE = '".$state."' WHERE CODE ='".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function reqSave($info)
	{
		$otype = $info["otype"];
		$utype = $info["utype"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$code = md5($now.$utype);
		$date = $info["a-reqDate"];
		$requester = $info["a-reqAutor"];
		$district = $info["a-reqDistrict"];
		$detail = $info["a-reqDetail"];
		$techs = $info["a-reqTechs"];
		$result = $info["a-reqProvided"];
		$framedays = $info["a-reqDays"];
		$autor = $info["a-reqAutor2"];
		$type = $info["a-reqType"];
		$comments = $info["a-reqComments"];
		$windfarm = $info["a-reqWindfarm"];
		
		$reqstate = $info["a-reqState"];
		$reqType = $info["reqType"];
		
		$AREA = $info["area"];
		$COUNTRY = $info["country"];
		
		$reqSource = "log";
		
		// $TPLAT = $info["tPlat"];
		// $TSERIE = $info["tserie"];
		
		if($otype == "c")
		{
				
			$str = "INSERT INTO requests (CODE, DATE, REQUESTER, DISTRICT, DETAIL, TECHS, RESULT, FRAMEDAYS, COMMENTS, WINDFARM, AUTOR, TYPE, REQSTATE, AREA, COUNTRY, REQSOURCE, REQTYPE) VALUES ('".$code."', '".$date."', '".$requester."', '".$district."', '".$detail."', '".$techs."', '".$result."', '".$framedays."', '".$comments."', '".$windfarm."', '".$autor."', '".$type."', '".$reqstate."', '".$AREA."', '".$COUNTRY."', '".$reqSource."', '".$reqType."')";
			$query = $this->db->query($str);

			$this->chlog($info);
			$resp["message"] = "created";
			$resp["status"] = true;
			return $resp;
		}
		else
		{
			$code = $info["reqCode"];
			
			$str = "UPDATE requests SET DATE='".$date."', REQUESTER='".$requester."', DISTRICT='".$district."', DETAIL='".$detail."', TECHS='".$techs."', RESULT='".$result."', FRAMEDAYS='".$framedays."', COMMENTS='".$comments."', WINDFARM = '".$windfarm."' , AUTOR = '".$autor."', TYPE = '".$type."', REQSTATE = '".$reqstate."', AREA = '".$AREA."', COUNTRY = '".$COUNTRY."'  WHERE CODE ='".$code."'"; 
			$query = $this->db->query($str);
			
			$this->chlog($info);
			$resp["message"] = "edited";
			$resp["status"] = true;
			return $resp;
		}
	}
	function reqUPSave($info)
	{
		$otype = $info["otype"];
		$utype = $info["utype"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$code = md5($now.$utype);
		$DATE = $info["a-reqUPDate"];
		$REQUESTER = $info["a-reqUPAutor"];
		$DISTRICT = $info["a-reqUpDistrict"];
		$DETAIL = $info["a-reqUPProvided"];
		$COMMENTS = $info["a-reqUComments"];
		$WINDFARM = $info["a-reqUPWindfarm"];
		$AUTOR = $info["autor"];
		$TYPE = $info["a-reqUPTypeProp"];
		$AREA = $info["area"];
		$COUNTRY = $info["country"];
		$TPLAT = $info["tPlat"];
		$TSERIE = $info["tserie"];
		$REQSOURCE = "sup";
		$REQTYPE = $info["reqType"];
		$REQADDRESS = $info["a-reqUPAddress"];
		$REQTNUM = $info["a-reqUPturbNum"];
		$REQCNUM = $info["a-reqUPcaseNum"];
		$REQPM = $info["a-reqUPpm"];
		$REQSUPDESC = $info["a-reqUDesc"];
		$REQSUREQUIRED = $info["a-reqUrequired"];
		$REQPLAT = $info["a-reqUplat"];
		$REQTH = $info["a-reqUtowH"];
		$REQCOMP = $info["a-reqUComponent"];
		$REQBRAND = $info["a-reqUbrand"];
		$REQSN = $info["a-reqUSN"];
		$REQTSTATE = $info["a-reqUtState"];
		$REQTOOL = $info["a-reqUtool"];
		$REQPART = $info["a-reqUpart"];

		if($otype == "c")
		{
			
			$REQSTATE = "Pending";
			
			$str = "INSERT INTO requests 
			(CODE,
			DATE,
			REQUESTER,
			DISTRICT,
			DETAIL,
			COMMENTS,
			WINDFARM,
			AUTOR,
			TYPE,
			REQSTATE,
			AREA,
			COUNTRY,
			TPLAT,
			TSERIE,
			REQSOURCE,
			REQTYPE,
			REQADDRESS,
			REQTNUM,
			REQCNUM,
			REQPM,
			REQSUPDESC,
			REQSUREQUIRED,
			REQPLAT,
			REQTH,
			REQCOMP,
			REQBRAND,
			REQSN,
			REQTSTATE,
			REQTOOL,
			REQPART) 
			 VALUES (
			'".$code."',
			'".$DATE."',
			'".$REQUESTER."',
			'".$DISTRICT."',
			'".$DETAIL."',
			'".$COMMENTS."',
			'".$WINDFARM."',
			'".$AUTOR."',
			'".$TYPE."',
			'".$REQSTATE."',
			'".$AREA."',
			'".$COUNTRY."',
			'".$TPLAT."',
			'".$TSERIE."',
			'".$REQSOURCE."',
			'".$REQTYPE."',
			'".$REQADDRESS."',
			'".$REQTNUM."',
			'".$REQCNUM."',
			'".$REQPM."',
			'".$REQSUPDESC."',
			'".$REQSUREQUIRED."',
			'".$REQPLAT."',
			'".$REQTH."',
			'".$REQCOMP."',
			'".$REQBRAND."',
			'".$REQSN."',
			'".$REQTSTATE."',
			'".$REQTOOL."',
			'".$REQPART."')";
			
			$query = $this->db->query($str);
			
			$str = "SELECT RNUM FROM requests WHERE 
			CODE = '".$code."'";
			$query = $this->db->query($str);
			$rnum = $query[0]["RNUM"];

			$this->chlog($info);
			
			if($DETAIL == "Composite_Siemens_Design")
			{$destiny = "robert.brown@siemensgamesa.com";}
			else if($DETAIL == "Composite_Gamesa_Design")
			{$destiny = "juan.m.alvarez@siemensgamesa.com";}
			else if($DETAIL == "Mechanical")
			{$destiny = "norberto.fabre@siemensgamesa.com";}
			else if($DETAIL == "Electrical")
			{$destiny = "andrew.hrlevich@siemensgamesa.com";}
			else if($DETAIL == "Drones")
			{$destiny = "oscar.arcila@siemensgamesa.com";}
			else if($DETAIL == "Planning USA")
			{$destiny = "christa.arroyo@siemensgamesa.com";}
			else if($DETAIL == "Planning Canada")
			{$destiny = "rossano.zampieri@siemensgamesa.com";}
			else
			{$destiny = "cristhian.saenz@siemensgamesa.com";}
			
			
			$data = array();
			$data["origin"] = "administrator@opspecialistsgroup.com";
			$data["name"] = "";
			$data["message"] = "A new request for your speciality has been created in the control tool, the code is: ".$rnum;
			$data["quote"] = $rnum;
			$data["recipient"] = $destiny;
			$data["etype"] = "supReq";

			$this->tagContactOrder($data);
			
			$resp["message"] = "created";
			$resp["status"] = true;
			return $resp;
		}
		else
		{
			$code = $info["reqCode"];
			
			$str = "UPDATE requests SET 
			DETAIL='".$DETAIL."',
			REQUESTER='".$REQUESTER."',
			DATE='".$DATE."',
			AREA='".$AREA."',
			COUNTRY='".$COUNTRY."',
			DISTRICT='".$DISTRICT."',
			WINDFARM = '".$WINDFARM."',
			TYPE = '".$TYPE."',
			REQADDRESS = '".$REQADDRESS."',
			REQTNUM = '".$REQTNUM."',
			REQCNUM = '".$REQCNUM."',
			REQPM = '".$REQPM."',
			REQSUREQUIRED = '".$REQSUREQUIRED."',
			TPLAT = '".$TPLAT."',
			TSERIE = '".$TSERIE."',
			REQPLAT = '".$REQPLAT."',
			REQTH = '".$REQTH."',
			REQCOMP = '".$REQCOMP."',
			REQBRAND = '".$REQBRAND."',
			REQSN = '".$REQSN."',
			REQTSTATE = '".$REQTSTATE."',
			REQTOOL = '".$REQTOOL."',
			REQPART = '".$REQPART."',
			REQSUPDESC = '".$REQSUPDESC."',
			COMMENTS='".$COMMENTS."'
			WHERE CODE ='".$code."'"; 
			$query = $this->db->query($str);
			
			$this->chlog($info);
			$resp["message"] = "edited";
			$resp["status"] = true;
			return $resp;
		}
	}
	function reqAddSave($info)
	{
		$otype = $info["otype"];
		$utype = $info["utype"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$code = md5($now.$utype);
		$DATE = $info["DATE"];
		$REQUESTER = $info["REQUESTER"];
		$DISTRICT = $info["DISTRICT"];
		$DETAIL = $info["DETAIL"];
		$COMMENTS = $info["COMMENTS"];
		$WINDFARM = $info["WINDFARM"];
		$AUTOR = $info["AUTOR"];
		$TYPE = $info["TYPE"];
		$AREA = $info["AREA"];
		$COUNTRY = $info["COUNTRY"];
		$TPLAT = $info["TPLAT"];
		$TSERIE = $info["TSERIE"];
		$REQSOURCE = "log";
		$REQTYPE = $info["REQTYPE"];
		$REQADDRESS = $info["REQADDRESS"];
		$REQTNUM = $info["REQTNUM"];
		$REQCNUM = $info["REQCNUM"];
		$REQPM = $info["REQPM"];
		$REQSUPDESC = $info["REQSUPDESC"];
		$REQSUREQUIRED = $info["REQSUREQUIRED"];
		$REQPLAT = $info["REQPLAT"];
		$REQTH = $info["REQTH"];
		$REQCOMP = $info["REQCOMP"];
		$REQBRAND = $info["REQBRAND"];
		$REQSN = $info["REQSN"];
		$REQTSTATE = $info["REQTSTATE"];
		$REQTOOL = $info["REQTOOL"];
		$REQPART = $info["REQPART"];
		$TECHS = $info["TECHS"];
		$RESULT = $info["RESULT"];
		$FRAMEDAYS = $info["FRAMEDAYS"];
		$REQSTATE = $info["REQSTATE"];
		$REQPARENT = $info["REQPARENT"];
		

		if($otype == "c")
		{
			
			$REQSTATE = "Pending";
			
			$str = "INSERT INTO requests 
			(CODE,
			DATE,
			REQUESTER,
			DISTRICT,
			DETAIL,
			COMMENTS,
			WINDFARM,
			AUTOR,
			TYPE,
			AREA,
			COUNTRY,
			TPLAT,
			TSERIE,
			REQSOURCE,
			REQTYPE,
			REQADDRESS,
			REQTNUM,
			REQCNUM,
			REQPM,
			REQSUPDESC,
			REQSUREQUIRED,
			REQPLAT,
			REQTH,
			REQCOMP,
			REQBRAND,
			REQSN,
			REQTSTATE,
			REQTOOL,
			REQPART,
			TECHS,
			RESULT,
			FRAMEDAYS,
			REQSTATE,
			REQPARENT
			) 
			 VALUES (
			'".$code."',
			'".$DATE."',
			'".$REQUESTER."',
			'".$DISTRICT."',
			'".$DETAIL."',
			'".$COMMENTS."',
			'".$WINDFARM."',
			'".$AUTOR."',
			'".$TYPE."',
			'".$AREA."',
			'".$COUNTRY."',
			'".$TPLAT."',
			'".$TSERIE."',
			'".$REQSOURCE."',
			'".$REQTYPE."',
			'".$REQADDRESS."',
			'".$REQTNUM."',
			'".$REQCNUM."',
			'".$REQPM."',
			'".$REQSUPDESC."',
			'".$REQSUREQUIRED."',
			'".$REQPLAT."',
			'".$REQTH."',
			'".$REQCOMP."',
			'".$REQBRAND."',
			'".$REQSN."',
			'".$REQTSTATE."',
			'".$REQTOOL."',
			'".$REQPART."',
			'".$TECHS."',
			'".$RESULT."',
			'".$FRAMEDAYS."',
			'".$REQSTATE."',
			'".$REQPARENT."'
			)";
			
			$query = $this->db->query($str);

			$this->chlog($info);
			$resp["message"] = "created";
			$resp["status"] = true;
			return $resp;
		}
		else
		{
			// UPDATE IF EDIT REQUIRED
			// UPDATE IF EDIT REQUIRED
			// UPDATE IF EDIT REQUIRED
			// UPDATE IF EDIT REQUIRED
			// UPDATE IF EDIT REQUIRED
			
			$code = $info["reqCode"];
			
			$str = "UPDATE requests SET 
			DETAIL='".$DETAIL."',
			REQUESTER='".$REQUESTER."',
			DATE='".$DATE."',
			AREA='".$AREA."',
			COUNTRY='".$COUNTRY."',
			DISTRICT='".$DISTRICT."',
			WINDFARM = '".$WINDFARM."',
			TYPE = '".$TYPE."',
			REQADDRESS = '".$REQADDRESS."',
			REQTNUM = '".$REQTNUM."',
			REQCNUM = '".$REQCNUM."',
			REQPM = '".$REQPM."',
			REQSUREQUIRED = '".$REQSUREQUIRED."',
			TPLAT = '".$TPLAT."',
			TSERIE = '".$TSERIE."',
			REQPLAT = '".$REQPLAT."',
			REQTH = '".$REQTH."',
			REQCOMP = '".$REQCOMP."',
			REQBRAND = '".$REQBRAND."',
			REQSN = '".$REQSN."',
			REQTSTATE = '".$REQTSTATE."',
			REQTOOL = '".$REQTOOL."',
			REQPART = '".$REQPART."',
			REQSUPDESC = '".$REQSUPDESC."',
			COMMENTS='".$COMMENTS."'
			WHERE CODE ='".$code."'"; 
			$query = $this->db->query($str);
			
			$this->chlog($info);
			$resp["message"] = "edited";
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
		
		$CODE = md5($info["a-orderParent"].$info["date"]);
		$DATE = $info["date"];
		$AUTHOR = $info["autor"];
		$AUTHORCODE = $info["autorCode"];
		$USERTYPE = $info["userType"];
		
		$CLIENT = str_replace("'","\\'", $info["a-orderParent"]);
		$WINDFARM = str_replace("'","\\'", $info["a-orderWindFarm"]);
		$ADDRESS = $info["a-orderAddress"];
		$CONTACT1 = $info["a-orderContact1"];
		$PHONE1 = $info["a-orderPhone1"];
		$CONTACT2 = $info["a-orderContact2"];
		$PHONE2 = $info["a-orderPhone2"];
		$DISTRICT = $info["a-orderDistrict"];
		$TURBINE = "";
		$WKDETAIL = $info["a-orderDetail"];
		$PLATFORM = $info["a-platform"];
		$STATUS = "1";
		$PTYPE = $info["a-ptype"];
		$TEMPLATENAME = $info["tempName"];
		
		$DEPARTMENT = $info["a-Department"];
		$PROPTYPE = $info["a-reqTypeProp"];
		
		$WFTYPE = $info["a-orderWindFarmType"];
		
		$AREA = $info["area"];
		$COUNTRY = $info["country"];
		
		$TPLAT = $info["tPlat"];
		$TSERIE = $info["tserie"];
		
		
		
		if($otype == "c")
		{
			$str = "INSERT INTO orders (CODE, DATE, CLIENT, WINDFARM, ADDRESS, CONTACT1, PHONE1, CONTACT2, PHONE2, DISTRICT, TURBINE, WKDETAIL, STATUS, AUTHOR, AUTHORCODE, PLATFORM, TYPE, TEMPLATENAME,DEPARTMENT, PROPTYPE, WFTYPE, AREA, COUNTRY, TPLAT, TSERIE) VALUES ('".$CODE."', '".$DATE."', '".$CLIENT."', '".$WINDFARM."', '".$ADDRESS."', '".$CONTACT1."', '".$PHONE1."', '".$CONTACT2."', '".$PHONE2."', '".$DISTRICT."', '".$TURBINE."', '".$WKDETAIL."', '".$STATUS."', '".$AUTHOR."', '".$AUTHORCODE."', '".$PLATFORM."', '".$PTYPE."', '".$TEMPLATENAME."', '".$DEPARTMENT."', '".$PROPTYPE."', '".$WFTYPE."', '".$AREA."', '".$COUNTRY."', '".$TPLAT."', '".$TSERIE."')";
			
			// SAVE HEADERS AND CREATE FOLDER
			$query = $this->db->query($str);
			$this->chlog($info);
			mkdir('../../files/'.$CODE, 0777, true);
			
			// CHECK IF ITS STANDARD CLONE
			if($PTYPE == "1"){$resp["message"] = "created";}
			else
			{
				$data = array();
				$data["newcode"] = $CODE;
				$data["cloneType"] = "1";
				$data["CODE"] = $PTYPE;
				$cloneItems = $this->quoteClone($data);
				$resp["message"] = $cloneItems["message"];
			}
			
			$resp["status"] = true;
			return $resp;
		}
		else
		{
				$CODE = $info["ocode"];
				
				$str = "UPDATE orders SET  CLIENT='".$CLIENT."', WINDFARM='".$WINDFARM."', ADDRESS = '".$ADDRESS."', CONTACT1 = '".$CONTACT1."', PHONE1 = '".$PHONE1."', CONTACT2 = '".$CONTACT2."', PHONE2 = '".$PHONE2."', DISTRICT = '".$DISTRICT."', TURBINE = '".$TURBINE."', WKDETAIL = '".$WKDETAIL."', PLATFORM = '".$PLATFORM."', DEPARTMENT = '".$DEPARTMENT."', PROPTYPE = '".$PROPTYPE."', WFTYPE = '".$WFTYPE."', AREA = '".$AREA."', COUNTRY = '".$COUNTRY."', TPLAT = '".$TPLAT."', TSERIE = '".$TSERIE."' WHERE CODE='".$CODE."'"; 
	$query = $this->db->query($str);
				
			   $this->chlog($info);
				
				$resp["message"] = "edite";
				$resp["status"] = true;

				return $resp;
		}
	}
	function setAsTemplate($info)
	{
		$code = $info["code"];
		$name = $info["name"];
		
		$str = "UPDATE orders SET TYPE = '0', TEMPLATENAME = '".$name."' WHERE CODE ='".$code."'";
		$query = $this->db->query($str);
		
		$ans = "Done";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function podSave($info)
	{
		$otype = $info["otype"];
                
		$PCODE = md5($info["a-quoteParent"].$info["date"]);
		$DATE = $info["date"];
		$AUTHOR = $info["autor"];
		$AUTHORCODE = $info["autorCode"];
		$USERTYPE = $info["userType"];
		
		$QCODE = $info["a-quoteParent"];
		$WFARM = $info["a-podWF"];
		$TURBINE = $info["a-podDistrict"];
		$SO = $info["a-podSO"];
		$WO = $info["a-podWO"];
		$CO = $info["a-podCO"];
		$PO = $info["a-podPO"];
		$G4 = $info["a-podG4"];
		$INIDATE = $info["a-podInidate"];
		$JOB = $info["a-podType"];
		$DETAIL = $info["a-podDetail"];
		$PLATFORM = $info["a-podPlatform"];
		$TOW = $info["a-podTow"];
		
		$DEPARTMENT = $info["p-Department"];
		$PROPTYPE = $info["p-reqTypeProp"];
		
		$WFTYPE = $info["a-projectWindFarmType"];
		
		$STATUS = "1";
		
		$AREA = $info["area"];
		$COUNTRY = $info["country"];
		
		$TPLAT = $info["tPlat"];
		$TSERIE = $info["tserie"];
		
		if($otype == "c")
		{
			
			$str = "SELECT QCODE FROM projects WHERE QCODE = '".$QCODE."'";
			$query = $this->db->query($str);
			
			if(count($query) > 0)
			{
				$resp["message"] = "exist";
				$resp["status"] = true;
				return $resp;
			}
			
			$str = "INSERT INTO projects (PCODE, QCODE, WFARM, TURBINE, SO, WO, CO, PO, G4, INIDATE, JOB, DETAIL, PLATFORM, TOW,DEPARTMENT,PROPTYPE, WFTYPE, AREA, COUNTRY, TPLAT, TSERIE) VALUES ('".$PCODE."', '".$QCODE."', '".$WFARM."', '".$TURBINE."', '".$SO."', '".$WO."', '".$CO."', '".$PO."', '".$G4."', '".$INIDATE."', '".$JOB."', '".$DETAIL."', '".$PLATFORM."' , '".$TOW."', '".$DEPARTMENT."', '".$PROPTYPE."', '".$WFTYPE."', '".$AREA."', '".$COUNTRY."', '".$TPLAT."', '".$TSERIE."')";
			$query = $this->db->query($str);

			$this->chlog($info);
			
			$resp["message"] = "created";
			$resp["status"] = true;
			return $resp;
		}
		else
		{
				$PCODE = $info["pcode"];
				
				$str = "UPDATE projects SET  WFARM = '".$WFARM."', TURBINE='".$TURBINE."', SO = '".$SO."', WO = '".$WO."', CO = '".$CO."', PO = '".$PO."', G4 = '".$G4."', INIDATE = '".$INIDATE."', JOB = '".$JOB."', DETAIL = '".$DETAIL."', PLATFORM = '".$PLATFORM."', TOW = '".$TOW."', DEPARTMENT = '".$DEPARTMENT."', PROPTYPE = '".$PROPTYPE."', WFTYPE = '".$WFTYPE."', AREA = '".$AREA."', COUNTRY = '".$COUNTRY."', TPLAT = '".$TPLAT."', TSERIE = '".$TSERIE."' WHERE PCODE='".$PCODE."'"; 
	$query = $this->db->query($str);
				
			   $this->chlog($info);
				
				$resp["message"] = "edite";
				$resp["status"] = true;

				return $resp;
		}
	}
	function quoteClone($info)
	{
		
		$cloneType = $info["cloneType"];
		$OLDCODE = $info["CODE"];
		
		if($cloneType == "0")
		{
			$AUTHOR = $info["autor"];
			$AUTHORCODE = $info["autorCode"];
			$CODE = md5($info["a-orderParent"].$info["date"]);
			$DATE = $info["date"];
			$oldFilelink = $info["FILELINK"];

			// CLONE QUOTE
			$str = "INSERT INTO orders (CODE, CLIENT, DATE, WINDFARM, ADDRESS, CONTACT1, PHONE1, CONTACT2, PHONE2, DISTRICT, TURBINE, WKDETAIL, HF, STATUS, FILELINK, AUTHOR, AUTHORCODE, SERVORDER, WORKORDER, COSTORDER, PURCHASEORDER, STLABOR, STPARTS, STTOOLS, STACCESS, STDOCS, STOTHERS, LABST, TEMPLATENAME) SELECT '".$CODE."', CLIENT, '".$DATE."', WINDFARM, ADDRESS, CONTACT1, PHONE1, CONTACT2, PHONE2, DISTRICT, TURBINE, WKDETAIL, HF, '1', FILELINK, '".$AUTHOR."', '".$AUTHORCODE."', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', TEMPLATENAME  FROM orders WHERE CODE = '".$OLDCODE."'";
			$query = $this->db->query($str);

			// CREATE DIR
			mkdir('../../files/'.$CODE, 0777, true);
			
			// CLONE FILE IF EXIST
			if($oldFilelink != "")
			{
				$oldfile = '../../files/'.$OLDCODE."/".$oldFilelink;
				$newfile = '../../files/'.$CODE."/".$oldFilelink;
				copy($oldfile, $newfile);
			}
			
			$this->chlog($info);
		}
		else
		{
			$CODE = $info["newcode"];
		}
		
		$now = new DateTime();
		$now = $now->format('H:i:s');
		
		// CLONE TURBINES
		$str = "SELECT * FROM turbines WHERE OCODE = '".$OLDCODE."'";
		$turbines = $this->db->query($str);
		
		for($i=0; $i<count($turbines); $i++)
		{
			$item = $turbines[$i];
			$subcode = md5($item["TCODE"].$now);
			$str = "INSERT INTO turbines (TCODE, OCODE, TNAME, HOURS, SNA, SNB, SNC, WBS) VALUES ('".$subcode."','".$CODE."','".$item["TNAME"]."','".$item["HOURS"]."','".$item["SNA"]."','".$item["SNB"]."','".$item["SNC"]."','".$item["WBS"]."')";
			$query = $this->db->query($str);
		}
		
		// CLONE LABORS
		$str = "SELECT * FROM oactis WHERE OCODE = '".$OLDCODE."'";
		$labors = $this->db->query($str);
		
		for($i=0; $i<count($labors); $i++)
		{
			$item = $labors[$i];
			$subcode = md5($item["CODE"].$now);
			$str = "INSERT INTO oactis (CODE, OCODE, RESPTYPE, TIME, UNITCOST, RESPNAME, CNAME, MIMO, MIMOQ) VALUES ('".$subcode."','".$CODE."','".$item["RESPTYPE"]."','".$item["TIME"]."','".$item["UNITCOST"]."','".$item["RESPNAME"]."','".$item["CNAME"]."','".$item["MIMO"]."','".$item["MIMOQ"]."')";
			$query = $this->db->query($str);
		}

		// CLONE PARTS
		$str = "SELECT * FROM oparts WHERE OCODE = '".$OLDCODE."'";
		$parts = $this->db->query($str);
		
		for($i=0; $i<count($parts); $i++)
		{
			$item = $parts[$i];
			$subcode = md5($item["CODE"].$now);
			$str = "INSERT INTO oparts (CODE, OCODE, PNUMBER, PDESC, PCOST, PVENDOR, PQTY) VALUES ('".$subcode."','".$CODE."','".$item["PNUMBER"]."','".$item["PDESC"]."','".$item["PCOST"]."','".$item["PVENDOR"]."','".$item["PQTY"]."')";
			$query = $this->db->query($str);
		}
		
		// CLONE TOOLS
		$str = "SELECT * FROM others WHERE OCODE = '".$OLDCODE."'";
		$tools = $this->db->query($str);
		
		for($i=0; $i<count($tools); $i++)
		{
			$item = $tools[$i];
			$subcode = md5($item["CODE"].$now);
			$str = "INSERT INTO others (CODE, OCODE, TNUMBER, TDETAIL, TCOST, TVENDOR, TMODE, TSHIPPING, TQTY, TUNIT) VALUES ('".$subcode."','".$CODE."','".$item["TNUMBER"]."','".$item["TDETAIL"]."','".$item["TCOST"]."','".$item["TVENDOR"]."','".$item["TMODE"]."','".$item["TSHIPPING"]."','".$item["TQTY"]."','".$item["TUNIT"]."')";
			$query = $this->db->query($str);
		}
		
		// CLONE ACCESS
		$str = "SELECT * FROM oaccess WHERE OCODE = '".$OLDCODE."'";
		$access = $this->db->query($str);
		
		for($i=0; $i<count($access); $i++)
		{
			$item = $access[$i];
			$subcode = md5($item["CODE"].$now);
			$str = "INSERT INTO oaccess (CODE, OCODE, AMETHOD, AUNIT, ACOST, AMIMO, AQTY) VALUES ('".$subcode."','".$CODE."','".$item["AMETHOD"]."','".$item["AUNIT"]."','".$item["ACOST"]."','".$item["AMIMO"]."','".$item["AQTY"]."')";
			$query = $this->db->query($str);
		}
		
		
		$resp["message"] = "createdFull ".$CODE;
		$resp["status"] = true;
		return $resp;
	}
	function quoteApprove($info)
	{
		
		$serviceOrder = $info["serviceOrder"];
		$workOrder = $info["workOrder"];
		$costOrder = $info["costOrder"];
		$purchaseOrder = $info["purchaseOrder"];
		$code = $info["ocode"];
		
		$str = "UPDATE orders SET SERVORDER='".$serviceOrder."', WORKORDER ='".$workOrder."', COSTORDER ='".$costOrder."', PURCHASEORDER ='".$purchaseOrder."', STATUS = '2' WHERE CODE='".$code."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
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
		 if($delType == "order")
		{
			$str = "SELECT ONUM FROM $table WHERE CODE = '".$info["code"]."'";
			$onum = $this->db->query($str)[0]["ONUM"];
			
			$str = "DELETE FROM $table WHERE $table.CODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM oactis WHERE OCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM oparts WHERE OCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
						
			$str = "DELETE FROM others WHERE OCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM oaccess WHERE OCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM projects WHERE QCODE = '".$onum."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM days WHERE QCODE = '".$onum."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM dayItems WHERE QCODE = '".$onum."'";
			$query = $this->db->query($str);

			$dir_path = '../../files/'.$info["code"]."/" ;
			
			 $files = glob($dir_path."*"); foreach($files as $file){ if(is_file($file))unlink($file); }
	
			$this->delDir($dir_path);
			// DELETE ALSO ACTIS, INVEN AND FOLDER
			
			$this->chlog($info);
		
		}
		if($delType == "training")
		{

			$str = "DELETE FROM $table WHERE $table.CODE = '".$info["code"]."'";
			$query = $this->db->query($str);

			$dir_path = '../../trfiles/'.$info["code"]."/" ;
			
			 $files = glob($dir_path."*"); foreach($files as $file){ if(is_file($file))unlink($file); }
	
			$this->delDir($dir_path);
			// DELETE ALSO ACTIS, INVEN AND FOLDER
			
			$this->chlog($info);
		
		}
		if($delType == "oacti")
		{
			$str = "DELETE FROM $table WHERE $table.CODE = '".$info["code"]."' AND OCODE = '".$info["ocode"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM dayItems WHERE ACODE = '".$info["code"]."'";
			$query = $this->db->query($str);
		}
		if($delType == "opart")
		{
			$str = "DELETE FROM $table WHERE $table.CODE = '".$info["code"]."' AND OCODE = '".$info["ocode"]."'";
			$query = $this->db->query($str);
		}
		if($delType == "oother")
		{
			$str = "DELETE FROM $table WHERE $table.CODE = '".$info["code"]."' AND OCODE = '".$info["ocode"]."'";
			$query = $this->db->query($str);
		}
		if($delType == "oaccess")
		{
			$str = "DELETE FROM $table WHERE $table.CODE = '".$info["code"]."' AND OCODE = '".$info["ocode"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM dayItems WHERE ACODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
		}
		if($delType == "projects")
		{
			$str = "DELETE FROM $table WHERE $table.QCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM days WHERE QCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM dayItems WHERE QCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
		}
		if($delType == "days")
		{
			$str = "DELETE FROM $table WHERE $table.DCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM dayItems WHERE DCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$dir_path = '../../filesD/'.$info["code"]."/" ;
			
			$files = glob($dir_path."*"); foreach($files as $file){ if(is_file($file))unlink($file); }
			$this->delDir($dir_path);
			
		}
		if($delType == "reqsTable")
		{
			$str = "DELETE FROM $table WHERE CODE = '".$info["code"]."'";
			$query = $this->db->query($str);
		
		}
		if($delType == "reqsUPTable")
		{
			$str = "DELETE FROM requests WHERE CODE = '".$info["code"]."'";
			$query = $this->db->query($str);
		
		}
		if($delType == "subRequestTable")
		{
			$str = "DELETE FROM requests WHERE CODE = '".$info["code"]."'";
			$query = $this->db->query($str);
		
		}
		if($delType == "turbines")
		{
			$str = "DELETE FROM $table WHERE TCODE = '".$info["code"]."'";
			$query = $this->db->query($str);
			
			$str = "DELETE FROM dayItems WHERE ACODE = '".$info["code"]."'";
			$query = $this->db->query($str);
		
		}
		if($delType == "sessions")
		{
			$str = "DELETE FROM $table WHERE CODE = '".$info["code"]."'";
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
	function saveoTurb($info)
	{
		$OCODE = $info["ocode"];
		$TCODE = md5($OCODE.$info["date"]);
		$TNAME = $info["turbName"];
		$HOURS = $info["turbHours"];
		$WO = $info["turbWO"];
		$SO = $info["turbSO"];
		$CO = $info["turbCO"];
		$WBS = $info["turbWBS"];
		$WHSF = $info["turbwhsf"];
		$COMMENT = $info["turbComm"];
		$IDDATE = $info["turbIdDate"];
		$PRIORITY = $info["turbPriority"];
		$REQSTART = $info["turbReqStartDate"];

		
		$SNA = $info["turbAsn"];
		
		$TAPS = $info["turbAplanedSh"];
		$TAPT = $info["turbAprepTime"];
		$TAIT = $info["turbAinstTime"];

		$SNB = $info["turbBsn"];
		
		$TBPS = $info["turbBplanedSh"];
		$TBPT = $info["turbBprepTime"];
		$TBIT = $info["turbBinstTime"];

		$SNC = $info["turbCsn"];
		
		$TCPS = $info["turbCplanedSh"];
		$TCPT = $info["turbCprepTime"];
		$TCIT = $info["turbCinstTime"];
		
		$MODE = $info["mode"];

		$str = "INSERT INTO turbines (
		OCODE,
		TCODE,
		TNAME,
		HOURS,
		SNA,
		SNB,
		SNC,
		WO,
		SO,
		CO,
		WBS,
		WHSF,
		COMMENT,
		IDDATE,
		PRIORITY,
		REQSTART,
		TAPS,
		TAPT,
		TAIT,
		TBPS,
		TBPT,
		TBIT,
		TCPS,
		TCPT,
		TCIT) VALUES (
		'".$OCODE."',
		'".$TCODE."',
		'".$TNAME."',
		'".$HOURS."',
		'".$SNA."',
		'".$SNB."',
		'".$SNC."',
		'".$WO."',
		'".$SO."',
		'".$CO."',
		'".$WBS."',
		'".$WHSF."',
		'".$COMMENT."',
		'".$IDDATE."',
		'".$PRIORITY."',
		'".$REQSTART."',
		'".$TAPS."',
		'".$TAPT."',
		'".$TAIT."',
		'".$TBPS."',
		'".$TBPT."',
		'".$TBIT."',
		'".$TCPS."',
		'".$TCPT."',
		'".$TCIT."')";
		
		$query = $this->db->query($str);
		
		$info["type"] = "turbine";
		$info["tcode"] = $TCODE;
		$updateProject = $this-> projectItemAdder($info)["message"];
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;

	}
	function saveoAct($info)
	{
		$OCODE = $info["ocode"];
		$CODE = md5($OCODE.$info["date"]);
		$RESPTYPE = $info["actiResponsible"];
		$TIME = $info["actiTime"];
		$UNITCOST = $info["actiPriceUnit"];
		$RESPNAME = $info["actiName"];
		$CNAME = $info["actiCompany"];
		$MIMO = $info["actiMiMo"];
		$MIMOQ = $info["actiMiMoQ"];
		$ADESC = $info["actiDesc"];
		$AUCODE = $info["actiUcode"];
		
		$str = "INSERT INTO oactis (
		OCODE,
		CODE,
		RESPTYPE, TIME, UNITCOST, RESPNAME, CNAME, MIMO, MIMOQ, ADESC, UCODE) VALUES ('".$OCODE."', '".$CODE."', '".$RESPTYPE."', '".$TIME."', '".$UNITCOST."', '".$RESPNAME."', '".$CNAME."','".$MIMO."','".$MIMOQ."', '".$ADESC."', '".$AUCODE."')";
		$query = $this->db->query($str);
		
		$info["type"] = "labor";
		$info["lcode"] = $CODE;
		$updateProject = $this-> projectItemAdder($info)["message"];
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;

	}
	function projectItemAdder($info)
	{
		$str = "SELECT ONUM FROM orders WHERE CODE = '".$info["ocode"]."'";
		$onum = $this->db->query($str)[0]["ONUM"];
		
		$str = "SELECT QCODE FROM projects WHERE QCODE = '".$onum."'";
		$qnum = $this->db->query($str);

		if(count($qnum) > 0)
		{
			$qnum = $qnum[0]["QCODE"];
			$type = $info["type"];
			
			$str = "SELECT DCODE FROM days WHERE QCODE = '".$qnum."'";
			$days = $this->db->query($str);
			
			$now = new DateTime();
			$now = $now->format('Y-m-d H:i:s');
			
			for($i=0; $i<count($days); $i++)
			{
				$DCODE = $days[$i]["DCODE"];
				$ICODE = md5($now."-".$i);
				$QCODE = $qnum;
				
				// ---------------------ADD NEW TURBINES -----------------------
				
				if($type == "turbine")
				{
					$TYPE = "T";
					$NAME = $info["turbName"];
					$QUOTE = $info["turbHours"];
					$ACODE = $info["tcode"];
					$WO = $info["turbWO"];
					$SO = $info["turbSO"];
					$CO = $info["turbCO"];
					$UNIT = "Turbine";

					$str = "INSERT INTO dayItems (ICODE, DCODE, QCODE, TYPE, NAME, RESPONSIBLE, QUOTE, ACODE, WO, SO, CO) VALUES ('".$ICODE."', '".$DCODE."', '".$QCODE."', '".$TYPE."', '".$NAME."', '".$UNIT."', '".$QUOTE."', '".$ACODE."', '".$WO."', '".$SO."', '".$CO."')";
			$query = $this->db->query($str);
				}
				// ---------------------ADD NEW LABORS -----------------------
				if($type == "labor")
				{
					$TYPE = "L";
					$RESPONSIBLE = str_replace("'","\\'", $info["actiResponsible"]);
					$RESPNAME = str_replace("'","\\'", $info["actiName"]);
					$QUOTE = $info["actiTime"];
					$EXECUTED = 0;
					$MIMO = 0;
					$ACODE = $info["lcode"];
					$UCODE = $info["actiUcode"];
					
					$str = "INSERT INTO dayItems (ICODE, DCODE, QCODE, TYPE, RESPONSIBLE, NAME, QUOTE, EXECUTED, MIMO, ACODE, UCODE) VALUES ('".$ICODE."', '".$DCODE."', '".$QCODE."', '".$TYPE."', '".$RESPONSIBLE."', '".$RESPNAME."', '".$QUOTE."', '".$EXECUTED."', '".$MIMO."', '".$ACODE."', '".$UCODE."')";
					$query = $this->db->query($str);
				}
				// ---------------------ADD NEW ACCESS -----------------------
				if($type == "access")
				{
					$TYPE = "A";
					$UNIT = $info["accUnit"];
					$AM = $info["accMethod"];
					$QUOTE = $info["accQty"];
					$ACODE = $info["acode"];
					
					
					$str = "INSERT INTO dayItems (ICODE, DCODE, QCODE, TYPE, NAME, RESPONSIBLE, QUOTE, ACODE) VALUES ('".$ICODE."', '".$DCODE."', '".$QCODE."', '".$TYPE."', '".$AM."', '".$UNIT."', '".$QUOTE."', '".$ACODE."')";
					$query = $this->db->query($str);
				}
			}
		}
		else{$days = array();}

		$resp["message"] = $days;
		$resp["status"] = true;
		return $resp;
	}
	function updateOturb($info)
	{
		
		$TNAME = $info["TNAME"];
		$HOURS = $info["HOURS"];
		$SNA = $info["SNA"];
		$SNB = $info["SNB"];
		$SNC = $info["SNC"];
		$TCODE = $info["TCODE"];
		$OCODE = $info["OCODE"];
		$WO = $info["WO"];
		$SO = $info["SO"];
		$CO = $info["CO"];
		$WBS = $info["WBS"];
		
		$WHSF = $info["WHSF"];
		$COMMENT = $info["COMMENT"];
		$IDDATE = $info["IDDATE"];
		$PRIORITY = $info["PRIORITY"];

		$str = "UPDATE  turbines SET TNAME='".$TNAME."', HOURS ='".$HOURS."', SNA ='".$SNA."', SNB ='".$SNB."', SNC ='".$SNC."', WO ='".$WO."', SO ='".$SO."', CO ='".$CO."', WBS ='".$WBS."', WHSF ='".$WHSF."', COMMENT ='".$COMMENT."', IDDATE ='".$IDDATE."', PRIORITY ='".$PRIORITY."' WHERE TCODE='".$TCODE."'"; 
		$query = $this->db->query($str);

		
		$str = "UPDATE dayItems SET NAME ='".$TNAME."', QUOTE ='".$HOURS."', WO ='".$WO."', SO ='".$SO."', CO ='".$CO."', WBS ='".$WBS."' WHERE ACODE = '".$TCODE."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function updateOacti($info)
	{
		
		$RESPTYPE = $info["RESPTYPE"];
		$TIME = $info["TIME"];
		$UNITCOST = $info["UNITCOST"];
		$RESPNAME = $info["RESPNAME"];
		$CNAME = $info["CNAME"];
		$MIMO = $info["MIMO"];
		$MIMOQ = $info["MIMOQ"];
		$ACTUAL = $info["ACTUAL"];
		$ADESC = $info["ADESC"];
		$CODE = $info["CODE"];
		$UCODE = $info["UCODE"];
		// $OCODE = $info["CODE"];
		
		$str = "UPDATE oactis SET RESPTYPE='".$RESPTYPE."', TIME ='".$TIME."', UNITCOST ='".$UNITCOST."', RESPNAME ='".$RESPNAME."', CNAME ='".$CNAME."', MIMO ='".$MIMO."', MIMOQ ='".$MIMOQ."', ACTUAL ='".$ACTUAL."', ADESC = '".$ADESC."', UCODE = '".$UCODE."' WHERE CODE='".$CODE."'"; 
		$query = $this->db->query($str);

		
		$str = "UPDATE dayItems SET NAME ='".$RESPNAME."', QUOTE ='".$TIME."' WHERE ACODE = '".$CODE."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function updateDay($info)
	{
		
		$DCODE = $info["DCODE"];
		$QCODE = $info["QCODE"];
		$DATE = $info["DATE"];
		$WEATHER = $info["WEATHER"];
		$POD = $info["POD"];
		$WO = $info["WO"];
		$SO = $info["SO"];
		$WBS = $info["WBS"];
		
		$str = "UPDATE days SET DATE='".$DATE."', WEATHER ='".$WEATHER."', POD ='".$POD."', WO ='".$WO."', SO ='".$SO."', WBS ='".$WBS."' WHERE DCODE='".$DCODE."'"; 
		$query = $this->db->query($str);
		
		$ans = $info;
		
		$qcode = $QCODE;
		$dpkc = array();
		$dpkc["qcode"] = $qcode;
		$progress = $this-> getProgress($dpkc)["message"];
		
		$resp["message"] = $ans;
		$resp["progress"] = $progress;
		$resp["status"] = true;
		return $resp;
	}
	function updateDayItem($info)
	{
		
		$ICODE = $info["ICODE"];
		$DCODE = $info["DCODE"];
		$QCODE = $info["QCODE"];
		$TYPE = $info["TYPE"];
		$RESPONSIBLE = $info["RESPONSIBLE"];
		$NAME = $info["NAME"];
		$QUOTE = $info["QUOTE"];
		$EXECUTED = $info["EXECUTED"];
		$DETAILS = $info["DETAILS"];
		$MIMO = $info["MIMO"];
		$LABOR = $info["LABOR"];
		$STANDBY = $info["STANDBY"];
		$NC = $info["NC"];
		$MIMOD = $info["MIMOD"];
		$LABORD = $info["LABORD"];
		$STANDBYD = $info["STANDBYD"];
		$NCD = $info["NCD"];
		$OUS = $info["OUS"];
		$OUSD = $info["OUSD"];
		$CO = $info["CO"];
		$SO = $info["SO"];
		$WBS = $info["WBS"];
		$INIDATE = $info["INIDATE"];
		$ENDATE = $info["ENDATE"];
		$TURBSTATE = $info["TURBSTATE"];
		$FDATE = $info["FDATE"];
		
		
		$str = "UPDATE dayItems SET RESPONSIBLE ='".$RESPONSIBLE."', NAME ='".$NAME."', QUOTE ='".$QUOTE."', EXECUTED ='".$EXECUTED."', DETAILS ='".$DETAILS."', MIMO ='".$MIMO."', LABOR ='".$LABOR."', STANDBY ='".$STANDBY."', NC ='".$NC."', MIMOD ='".$MIMOD."', LABORD ='".$LABORD."', STANDBYD ='".$STANDBYD."', NCD ='".$NCD."', OUS ='".$OUS."', OUSD ='".$OUSD."', CO ='".$CO."', SO ='".$SO."', WBS ='".$WBS."', INIDATE ='".$INIDATE."', ENDATE ='".$ENDATE."', TURBSTATE ='".$TURBSTATE."', FDATE ='".$FDATE."' WHERE ICODE='".$ICODE."'"; 
		$query = $this->db->query($str);
		
		$qcode = $QCODE;
		$dpkc = array();
		$dpkc["qcode"] = $qcode;
		$progress = $this-> getProgress($dpkc)["message"];

		$ans = $info;
		
		if($info["UCODE"] != "")
		{

				
			if($INIDATE != "" and $ENDATE != "")
			{
				
				$UCODE = $info["UCODE"];
				$str = "SELECT DATE FROM days WHERE DCODE = '".$DCODE."'";
				$DATE = $this->db->query($str)[0]["DATE"];
				
				$str = "SELECT CODE FROM sessions WHERE UCODE = '".$UCODE."' AND DATE = '".$DATE."'";
				$query = $this->db->query($str);
				// CHECK IF DAY UCODE SESSION EXIST IF EXIST UPDATE, ELSE INSERT
				
				$HOURS = floatval($ENDATE) - floatval($INIDATE);
				
				if(count($query) > 0)
				{
					
					$str = "UPDATE sessions SET CO = '".$CO."', SO = '".$SO."', WBS = '".$WBS."', INIDATE = '".$INIDATE."', ENDATE = '".$ENDATE."', HOURS = '".$HOURS."' WHERE UCODE ='".$UCODE."'AND DATE = '".$DATE."'";
					$query = $this->db->query($str);
					
				}
				else
				{
					
					$CODE = md5($UCODE.$DATE);
					$TECH = $UCODE;
					$TYPE = "PRJ";
					
					$str = "INSERT INTO sessions (CODE,DATE,TECH,TYPE,CO,SO,INIDATE,ENDATE,HOURS,WBS,UCODE) VALUES ('".$CODE."','".$DATE."','".$TECH."','".$TYPE."','".$CO."','".$SO."','".$INIDATE."','".$ENDATE."','".$HOURS."','".$WBS."','".$UCODE."')";
					$query = $this->db->query($str);

				}
				
			}

			$ans = "update";
		}
		else
		{
			$ans = "ignore";
		}
		
		$resp["message"] = $ans;
		$resp["progress"] = $progress;
		$resp["status"] = true;
		return $resp;
	}
	function updateOpart($info)
	{
		
		$PNUMBER = $info["PNUMBER"];
		$PDESC = $info["PDESC"];
		$PCOST = $info["PCOST"];
		$PVENDOR = $info["PVENDOR"];
		$PSHIPPING = $info["PSHIPPING"];
		$PQTY = $info["PQTY"];
		$ACTUAL = $info["ACTUAL"];
		$CODE = $info["CODE"];
		
		$str = "UPDATE oparts SET PNUMBER='".$PNUMBER."', PDESC ='".$PDESC."', PCOST ='".$PCOST."', PVENDOR ='".$PVENDOR."', PQTY ='".$PQTY."', ACTUAL ='".$ACTUAL."', PSHIPPING = '".$PSHIPPING."' WHERE CODE='".$CODE."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function updateOtool($info)
	{
		
		$TNUMBER = $info["TNUMBER"];
		$TDETAIL = $info["TDETAIL"];
		$TCOST = $info["TCOST"];
		$TVENDOR = $info["TVENDOR"];
		$TMODE = $info["TMODE"];
		$TUNIT = $info["TUNIT"];
		$TSHIPPING = $info["TSHIPPING"];
		$TQTY = $info["TQTY"];
		$ACTUAL = $info["ACTUAL"];
		$CODE = $info["CODE"];
		
		$str = "UPDATE others SET TNUMBER='".$TNUMBER."', TDETAIL ='".$TDETAIL."', TCOST ='".$TCOST."', TVENDOR ='".$TVENDOR."', TMODE ='".$TMODE."', TSHIPPING ='".$TSHIPPING."', TQTY ='".$TQTY."', ACTUAL ='".$ACTUAL."', TUNIT ='".$TUNIT."' WHERE CODE='".$CODE."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function updateOaccess($info)
	{
		
		$AMETHOD = $info["AMETHOD"];
		$AUNIT = $info["AUNIT"];
		$ACOST = $info["ACOST"];
		$AMIMO = $info["AMIMO"];
		$AMIMOQ = $info["AMIMOQ"];
		$AQTY = $info["AQTY"];
		$ACTUAL = $info["ACTUAL"];
		$CODE = $info["CODE"];
		$AVDR = $info["AVDR"];
		
		$str = "UPDATE oaccess SET AMETHOD='".$AMETHOD."', AUNIT ='".$AUNIT."', ACOST ='".$ACOST."', AMIMO ='".$AMIMO."' , AMIMOQ ='".$AMIMOQ."', AQTY ='".$AQTY."', ACTUAL ='".$ACTUAL."', AVDR ='".$AVDR."' WHERE CODE='".$CODE."'"; 
		$query = $this->db->query($str);
		
		$str = "UPDATE dayItems SET NAME ='".$AMETHOD."', QUOTE ='".$AQTY."' WHERE ACODE = '".$CODE."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function updateSt($info)
	{
		
		$STLABOR = $info["stLabors"];
		$STPARTS = $info["stParts"];
		$STTOOLS = $info["stTools"];
		$STACCESS = $info["stAccess"];
		$STDOCS = $info["stDocs"];
		// $STOTHERS = $info["stOthers"];
		$CODE = $info["ocode"];
		
		
		$str = "UPDATE orders SET STLABOR='".$STLABOR."', STPARTS ='".$STPARTS."', STTOOLS ='".$STTOOLS."', STACCESS ='".$STACCESS."', STDOCS ='".$STDOCS."' WHERE CODE='".$CODE."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function lockOrder($info)
	{

		$CODE = $info["code"];
		$STATUS = $info["status"];

		$str = "UPDATE orders SET STATUS ='".$STATUS."' WHERE CODE='".$CODE."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function lockProject($info)
	{

		$PCODE = $info["code"];
		$STATUS = $info["status"];
		$CLOSED = $info["cdate"];
		$DETAILS = $info["cdetails"];
		$CSTATE = $info["cstate"];
		
		$str = "UPDATE projects SET LOCKED = '".$STATUS."', CLOSD = '".$CLOSED."' , CLDETAIL = '".$DETAILS."', CSTATE = '".$CSTATE."' WHERE PCODE ='".$PCODE."'";
		$query = $this->db->query($str);
		$ans = $query;
		
		$str = "UPDATE days SET LOCKED = '".$STATUS."' WHERE PCODE ='".$PCODE."'";
		$query = $this->db->query($str);
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function lockDay($info)
	{

		$DCODE = $info["code"];
		$STATUS = $info["status"];
		
		$str = "UPDATE days SET LOCKED = '".$STATUS."' WHERE DCODE ='".$DCODE."'";
		$query = $this->db->query($str);
		$ans = $query;
		
		$str = "UPDATE dayItems SET LOCKED = '".$STATUS."' WHERE DCODE ='".$DCODE."'";
		$query = $this->db->query($str);
		$ans = $query;
		
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getComments($info)
	{
		
		$code = $info["code"];
		
		$str = "SELECT COMMENTS FROM orders WHERE CODE = '".$code."'";
		$query = $this->db->query($str);	;
		
		$resp["message"] = $query[0];
		$resp["status"] = true;
		return $resp;
	}
	function lockOrderNow($info)
	{

		$CODE = $info["code"];
		$STATUS = $info["status"];
		$COMMENTS = $info["comments"];
		$CDATE = $info["cdate"];

		$str = "UPDATE orders SET STATUS ='".$STATUS."', COMMENTS = '".$COMMENTS."', CDATE = '".$CDATE."' WHERE CODE='".$CODE."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function updateStLab($info)
	{
		$LABST = $info["oStandBy"];
		$CODE = $info["ocode"];
		
		$str = "UPDATE orders SET LABST='".$LABST."' WHERE CODE='".$CODE."'"; 
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getOStandby($info)
	{
		$ocode = $info["ocode"];
		
		$str = "SELECT ONUM FROM orders WHERE CODE = '".$ocode."'";
		$qnum = $this->db->query($str);
		$qnum = $qnum[0]["ONUM"];
		
		$str = "SELECT SUM(STANDBY) AS STB FROM dayItems WHERE QCODE = '".$qnum."'";
		$stb = $this->db->query($str);
		
		$resp["message"] = $stb;
		$resp["status"] = true;
		return $resp;
	}
	function getWeekResume($info)
	{
		$date = $info["date"];
		$range = $info["range"];
		$pnum = $info["pnum"];
		
		$ans = array();
		
		$str = "SELECT DCODE, DATE FROM days WHERE DATE = '".$date."' AND QCODE = '".$pnum."'";
		$mainDcode = $this->db->query($str)[0]["DCODE"];
		$mainDdate = $this->db->query($str)[0]["DATE"];
		
		$dcodes = array();
		
		for($i=0; $i<7; $i++)
		{
			$day = $range[$i];
			
			$str = "SELECT DCODE FROM days WHERE DATE = '".$day."' AND QCODE = '".$pnum."'";
			$query = $this->db->query($str);
			
			if(count($query) > 0){$dcode = $query[0]["DCODE"];}
			else{$dcode = "";}
			
			array_push($dcodes, $dcode);
		}
		
		$ditems = array();
		
		for($i=0; $i<7; $i++)
		{
			$dcode = $dcodes[$i];
			
			$str = "SELECT ACODE, MIMO, LABOR, STANDBY, NC, OUS  FROM dayItems WHERE DCODE = '".$dcode."'";
			$query = $this->db->query($str);
			
			if(count($query) > 0){$items = $query;}
			else{$items = array();}
			
			array_push($ditems, $items);
		}
		
		$ans["items"] = $ditems;

		$dpkc = array();
		$dpkc["dcode"] = $mainDcode;
		$dpkc["ddate"] = $mainDdate;
		$dpkc["type"] = "L";
		$dpkc["qcode"] = $pnum;
		$blist = $this-> getDayItems($dpkc)["message"];
		
		$ans["blist"] = $blist;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getOTurbs($info)
	{
		$ocode = $info["ocode"];

		$str = "SELECT * FROM turbines WHERE OCODE = '".$ocode."' ORDER BY TNAME ASC, WBS ASC";
		$turbs = $this->db->query($str);

		$resp["message"] = $turbs;
		$resp["status"] = true;
		return $resp;
	}
	function getOActs($info)
	{
			
		$ocode = $info["ocode"];
		
		$str = "SELECT ONUM FROM orders WHERE CODE = '".$ocode."'";
		$qnum = $this->db->query($str);
		$qnum = $qnum[0]["ONUM"];
		
		$str = "SELECT * FROM oactis WHERE OCODE = '".$ocode."' ORDER BY RESPTYPE ASC, RESPNAME ASC";
		$actis = $this->db->query($str);
		
		for($i=0; $i<count($actis); $i++)
		{
			$item = $actis[$i];
			$acode = $item["CODE"];

			$str = "SELECT SUM(LABOR) AS TE FROM dayItems WHERE ACODE = '".$acode."'";
			$te = $this->db->query($str);
			
			$actis[$i]["TE"] = $te[0]["TE"];

		}
		
		$resp["message"] = $actis;
		$resp["status"] = true;
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
	function getOaccess($info)
	{
			
		$ocode = $info["ocode"];
		
		$str = "SELECT ONUM FROM orders WHERE CODE = '".$ocode."'";
		$qnum = $this->db->query($str);
		$qnum = $qnum[0]["ONUM"];
		
		$str = "SELECT * FROM oaccess WHERE OCODE = '".$ocode."'";
		$access = $this->db->query($str);
		
		for($i=0; $i<count($access); $i++)
		{
			$item = $access[$i];
			$acode = $item["CODE"];

			$str = "SELECT SUM(LABOR) AS TE FROM dayItems WHERE ACODE = '".$acode."'";
			$te = $this->db->query($str);
			
			$access[$i]["TE"] = $te[0]["TE"];

		}
		
		$resp["message"] = $access;
		$resp["status"] = true;
		return $resp;
	}
	function saveoPart($info)
	{
		$CODE = md5($info["ocode"].$info["date"]);
		$OCODE = $info["ocode"];
		$PNUMBER = $info["partNumber"];
		$PDESC = $info["partDetail"];
		$PCOST = $info["partCost"];
		$PVENDOR = $info["partVendor"];
		$PSHIPPING = $info["partShipping"];
		$PQTY = $info["partQty"];

		$str = "INSERT INTO oparts (CODE, OCODE, PNUMBER, PDESC, PCOST, PVENDOR, PSHIPPING, PQTY) VALUES ('".$CODE."', '".$OCODE."', '".$PNUMBER."', '".$PDESC."', '".$PCOST."', '".$PVENDOR."', '".$PSHIPPING."','".$PQTY."')";
		$query = $this->db->query($str);
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;

	}
	function saveoOther($info)
	{
		$CODE = md5($info["ocode"].$info["date"]);
		$OCODE = $info["ocode"];
		$TNUMBER = $info["toolNumber"];
		$TDETAIL = $info["toolDetail"];
		$TCOST = $info["toolCost"];
		$TVENDOR = $info["toolVendor"];
		$TMODE = $info["toolMode"];
		$TUNIT = $info["toolUnit"];
		$TSHIPPING = $info["toolShipping"];
		$TQTY = $info["toolQty"];

		$str = "INSERT INTO others (CODE, OCODE, TNUMBER, TDETAIL, TCOST, TVENDOR, TMODE, TSHIPPING, TQTY, TUNIT) VALUES ('".$CODE."', '".$OCODE."', '".$TNUMBER."', '".$TDETAIL."', '".$TCOST."', '".$TVENDOR."', '".$TMODE."','".$TSHIPPING."','".$TQTY."','".$TUNIT."')";
		$query = $this->db->query($str);
		
		$resp["message"] = "done";
		$resp["status"] = true;
		return $resp;

	}
	function saveoAccess($info)
	{
		$CODE = md5($info["ocode"].$info["date"]);
		$OCODE = $info["ocode"];
		$AMETHOD = $info["accMethod"];
		$AUNIT = $info["accUnit"];
		$ACOST = $info["accCost"];
		$AMIMO = $info["accMimo"];
		$AMIMOQ = $info["accMimoQ"];
		$AQTY = $info["accQty"];
		$AVDR = $info["accVendor"];
		
		
		$str = "INSERT INTO oaccess (CODE, OCODE, AMETHOD, AUNIT, ACOST, AMIMO, AMIMOQ, AQTY, AVDR) VALUES ('".$CODE."', '".$OCODE."', '".$AMETHOD."', '".$AUNIT."', '".$ACOST."', '".$AMIMO."', '".$AMIMOQ."', '".$AQTY."','".$AVDR."')";
		$query = $this->db->query($str);
		
		$info["type"] = "access";
		$info["acode"] = $CODE;
		$updateProject = $this-> projectItemAdder($info)["message"];
		
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
		
		
		$str = "SELECT * FROM others WHERE LEGCODE = '".$code."' AND LEGAUTOR = '".$autor."' ORDER BY LEGDATE ASC";
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
	function orderFullGet($info)
	{
		$ocode = $info["ocode"];
		$opack = array();
		
		$str = "SELECT * FROM orders WHERE CODE = '".$ocode."'";
		$query = $this->db->query($str);
		$oData = $query[0];
		
		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		$oTurbs = $this-> getOTurbs($dpkc)["message"];
		
		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		$oActs = $this-> getOActs($dpkc)["message"];

		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		$oParts = $this-> getOParts($dpkc)["message"];
		
		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		$oOthers = $this-> getOothers($dpkc)["message"];
		
		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		$oAccess = $this-> getOaccess($dpkc)["message"];
		
		$dpkc = array();
		$dpkc["ocode"] = $ocode;
		$oStandBy = $this-> getOStandby($dpkc)["message"];

		$opack["oData"] = $oData;
		$opack["oTurbs"] = $oTurbs;
		$opack["oActs"] = $oActs;
		$opack["oParts"] = $oParts;
		$opack["oOthers"] = $oOthers;
		$opack["oAccess"] = $oAccess;
		$opack["oStandBy"] = $oStandBy;
		
		$resp["message"] = $opack;
		$resp["status"] = true;
				
		return $resp;
	}
	function addDay($info)
	{

		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$DCODE = md5($now);
		$PCODE = $info["pcode"];
		$QCODE = $info["qcode"];
		$DATE = $info["dayDate"];
		$WEATHER = $info["dayWeather"];
		$POD = $info["dayPlan"];
		$WO = $info["dayWO"];
		$SO = $info["daySO"];
		$WBS = $info["dayWBS"];
		
		$str = "INSERT INTO days (DCODE, PCODE, QCODE, DATE, WEATHER, POD, WO, SO, WBS) VALUES ('".$DCODE."','".$PCODE."','".$QCODE."','".$DATE."','".$WEATHER."','".$POD."','".$WO."','".$SO."','".$WBS."')";
		$query = $this->db->query($str);
		
		$str = "SELECT CODE FROM orders WHERE ONUM = '".$QCODE."'";
		$pcode = $this->db->query($str);
		$pcode = $pcode[0]["CODE"];
		
		// LABORS
		
		$str = "SELECT RESPTYPE, TIME, RESPNAME, MIMOQ, CODE, UCODE  FROM oactis WHERE OCODE = '".$pcode."'";
		$labors = $this->db->query($str);
		
		for($i=0; $i<count($labors); $i++)
		{
			$item = $labors[$i];
			
			$ICODE = md5($now."_".$i);
			$TYPE = "L";
			$RESPONSIBLE = str_replace("'","\\'", $item["RESPTYPE"]);
			$RESPNAME = str_replace("'","\\'", $item["RESPNAME"]);
			$QUOTE = $item["TIME"];
			$EXECUTED = 0;
			$MIMO = 0;
			$ACODE = $item["CODE"];
			$UCODE = $item["UCODE"];
			
			$str = "INSERT INTO dayItems (ICODE, DCODE, QCODE, TYPE, RESPONSIBLE, NAME, QUOTE, EXECUTED, MIMO, ACODE, UCODE) VALUES ('".$ICODE."', '".$DCODE."', '".$QCODE."', '".$TYPE."', '".$RESPONSIBLE."', '".$RESPNAME."', '".$QUOTE."', '".$EXECUTED."', '".$MIMO."', '".$ACODE."', '".$UCODE."')";
			$query = $this->db->query($str);
				
				
		}
		
		// ACCESS
		
		$str = "SELECT AMETHOD, AUNIT, AQTY, CODE FROM oaccess WHERE OCODE = '".$pcode."'";
		$access = $this->db->query($str);
		
		for($i=0; $i<count($access); $i++)
		{
			$item = $access[$i];
			
			$ICODE = md5($now."*".$i);
			$TYPE = "A";
			$UNIT = $item["AUNIT"];
			$AM = $item["AMETHOD"];
			$QUOTE = $item["AQTY"];
			$ACODE = $item["CODE"];
			
			
			$str = "INSERT INTO dayItems (ICODE, DCODE, QCODE, TYPE, NAME, RESPONSIBLE, QUOTE, ACODE) VALUES ('".$ICODE."', '".$DCODE."', '".$QCODE."', '".$TYPE."', '".$AM."', '".$UNIT."', '".$QUOTE."', '".$ACODE."')";
			$query = $this->db->query($str);
		}
		
		// TURBINES
		
		$str = "SELECT TCODE, TNAME, HOURS, WO, SO, CO, WHSF, COMMENT, IDDATE, PRIORITY, TAPS, TAPT, TAIT, TBPS, TBPT, TBIT, TCPS, TCPT, TCIT  FROM turbines WHERE OCODE = '".$pcode."'";
		$turbines = $this->db->query($str);
		
		for($i=0; $i<count($turbines); $i++)
		{
			$item = $turbines[$i];
			
			$ICODE = md5($now."-".$i);
			$TYPE = "T";
			$NAME = $item["TNAME"];
			$QUOTE = $item["HOURS"];
			$ACODE = $item["TCODE"];
			$WO = $item["WO"];
			$SO = $item["SO"];
			$CO = $item["CO"];
			
			$WHSF = $item["WHSF"];
			$COMMENT = $item["COMMENT"];
			$IDDATE = $item["IDDATE"];
			$PRIORITY = $item["PRIORITY"];
			
			$QTAPS = $item["TAPS"];
			$QTAPT = $item["TAPT"];
			$QTAIT = $item["TAIT"];
			 
			$QTBPS = $item["TBPS"];
			$QTBPT = $item["TBPT"];
			$QTBIT = $item["TBIT"];
			 
			$QTCPS = $item["TCPS"];
			$QTCPT = $item["TCPT"];
			$QTCIT = $item["TCIT"];
			
			
			$UNIT = "Turbine";

			$str = "INSERT INTO dayItems (ICODE, DCODE, QCODE, TYPE, NAME, RESPONSIBLE, QUOTE, ACODE, WO, SO, CO, WHSF, COMMENT, IDDATE, PRIORITY, QTAPS, QTAPT, QTAIT, QTBPS, QTBPT, QTBIT, QTCPS, QTCPT, QTCIT) VALUES ('".$ICODE."', '".$DCODE."', '".$QCODE."', '".$TYPE."', '".$NAME."', '".$UNIT."', '".$QUOTE."', '".$ACODE."', '".$WO."', '".$SO."', '".$CO."', '".$WHSF."', '".$COMMENT."', '".$IDDATE."', '".$PRIORITY."', '".$QTAPS."', '".$QTAPT."', '".$QTAIT."', '".$QTBPS."', '".$QTBPT."', '".$QTBIT."', '".$QTCPS."', '".$QTCPT."', '".$QTCIT."')";
			$query = $this->db->query($str);
		}
		
		$ans = $turbines;
		
		mkdir('../../filesD/'.$DCODE, 0777, true);
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function addTraining($info)
	{

		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$CODE = md5($now.$info["UCODE"]);
		$UCODE = $info["UCODE"];
		$CNAME = $info["CNAME"];
		$PROVIDER = $info["PROVIDER"];
		$TRTYPE = $info["TRTYPE"];
		$INIDATE = $info["INIDATE"];
		$ENDATE = $info["ENDATE"];
		$COMMENTS = $info["COMMENTS"];
		$FILE = "";
		$MTYPE = "TR";
		
		$str = "INSERT INTO training (CODE, UCODE, CNAME, PROVIDER, TRTYPE, INIDATE, ENDATE, COMMENTS, FILE, MTYPE) VALUES ('".$CODE."','".$UCODE."','".$CNAME."','".$PROVIDER."','".$TRTYPE."','".$INIDATE."','".$ENDATE."','".$COMMENTS."','".$FILE."','".$MTYPE."')";
		$query = $this->db->query($str);

		$ans = "done";
		
		mkdir('../../trfiles/'.$CODE, 0777, true);
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function addPPE($info)
	{

		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$CODE = md5($now.$info["UCODE"]);
		$UCODE = $info["UCODE"];
		$TOEQUI = $info["TOEQUI"];
		$EQSERIAL = $info["EQSERIAL"];
		$EQSKU = $info["EQSKU"];
		$EQMDATE = $info["EQMDATE"];
		$EQDDATE = $info["EQDDATE"];
		$EQENDATE = $info["EQENDATE"];
		$EQBRAND = $info["EQBRAND"];
		$EQMODEL = $info["EQMODEL"];
		$EQSTATE = $info["EQSTATE"];
		$COMMENTS = $info["EQCOMMENTS"];
		$FILE = "";
		$MTYPE = "PPE";

		
		$str = "INSERT INTO training (CODE, UCODE, TOEQUI, EQSERIAL, EQSKU, EQMDATE, EQDDATE, EQENDATE, EQBRAND, EQMODEL, EQSTATE, COMMENTS, FILE, MTYPE) VALUES ('".$CODE."','".$UCODE."','".$TOEQUI."','".$EQSERIAL."','".$EQSKU."','".$EQMDATE."','".$EQDDATE."','".$EQENDATE."','".$EQBRAND."','".$EQMODEL."','".$EQSTATE."','".$COMMENTS."','".$FILE."','".$MTYPE."')";
		$query = $this->db->query($str);

		$ans = "done";
		
		mkdir('../../trfiles/'.$CODE, 0777, true);
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function updateBlades($info)
	{
		$icode = $info["icode"];
		$field = $info["field"];
		$newval = $info["newval"];
		
		$str = "UPDATE dayItems SET $field = '".$newval."' WHERE ICODE ='".$icode."'";
		$query = $this->db->query($str);
		
				
		$ans = "saved";
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getDayItems($info)
	{
		$dcode = $info["dcode"];
		$type = $info["type"];
		$qcode = $info["qcode"];
		$ldate = $info["ddate"];
				
		$str = "SELECT * FROM dayItems WHERE DCODE = '".$dcode."' AND TYPE = '".$type."' GROUP BY NAME";
		$query = $this->db->query($str);
		$list1 = $query;
		
		// FILL DATES FOR DAY ITEMS
		
		$str = "SELECT ICODE, DCODE, DATE FROM dayItems WHERE QCODE = '".$qcode."' AND TYPE = '".$type."'";
		$tmpList = $this->db->query($str);
		
		for($i=0; $i<count($tmpList); $i++)
		{
			$tmpItem = $tmpList[$i];
			if($tmpItem["DATE"] == null)
			{
				$idcode = $tmpItem["DCODE"];
				
				$str = "SELECT DATE FROM days WHERE DCODE = '".$idcode."'";
				$date = $this->db->query($str)[0]["DATE"];
				
				$str = "UPDATE dayItems SET DATE = '".$date."' WHERE DCODE = '".$idcode."'";
				$updatedate = $this->db->query($str);
			}
			
		}
		
		
		// FILL DATES FOR DAY ITEMS
		
		if($type == "T")
		{
			$str = "SELECT QCODE, TYPE, NAME, LOCKED, SUM(LABOR) AS TE, SUM(TAPS) AS TETAPS, SUM(TAPT) AS TETAPT, SUM(TAIT) AS TETAIT, SUM(TBPS) AS TETBPS, SUM(TBPT) AS TETBPT, SUM(TBIT) AS TETBIT, SUM(TCPS) AS TETCPS, SUM(TCPT) AS TETCPT, SUM(TCIT) AS TETCIT FROM dayItems WHERE QCODE = '".$qcode."' AND TYPE = '".$type."' AND DATE <= '".$ldate."' GROUP BY NAME";
		}
		else
		{
			$str = "SELECT QCODE, TYPE, NAME, LOCKED, SUM(LABOR) AS TE FROM dayItems WHERE QCODE = '".$qcode."' AND TYPE = '".$type."' AND DATE <= '".$ldate."' GROUP BY NAME";
		}
		

		
		$list2 = $this->db->query($str);
		
		for($i=0; $i<count($list1); $i++)
		{
			$item1 = $list1[$i];
			
			for($j=0; $j<count($list2); $j++)
			{
				$item2 = $list2[$j];
				
				if($item1["QCODE"] == $item2["QCODE"] and $item1["NAME"] == $item2["NAME"])
				{
					$list1[$i]["TE"] = $item2["TE"];
					
					if($item1["TYPE"] == "T")
					{
						$list1[$i]["TETAPS"] = $item2["TETAPS"];
						$list1[$i]["TETAPT"] = $item2["TETAPT"];
						$list1[$i]["TETAIT"] = $item2["TETAIT"];
						
						$list1[$i]["TETBPS"] = $item2["TETBPS"];
						$list1[$i]["TETBPT"] = $item2["TETBPT"];
						$list1[$i]["TETBIT"] = $item2["TETBIT"];
						
						$list1[$i]["TETCPS"] = $item2["TETCPS"];
						$list1[$i]["TETCPT"] = $item2["TETCPT"];
						$list1[$i]["TETCIT"] = $item2["TETCIT"];
					}
					
				}
			}
		}
		
		
		$ans = $list1;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function updateSBnew($info)
	{
		$code = $info["code"];
		$reasons = $info["reasons"];
		
		$str = "UPDATE dayItems SET 
		STDARRAY = '".$reasons."'
		WHERE 
		ICODE ='".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function refreshSessions($info)
	{
		$date = $info["date"];
		$tech = $info["tech"];
		
		
		$str = "SELECT *  FROM sessions WHERE DATE = '".$date."' AND TECH = '".$tech."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function addSession($info)
	{
		$DATE = $info["DATE"];
		$TECH = $info["TECH"];
		$TYPE = $info["TYPE"];
		$CO = $info["CO"];
		$SO = $info["SO"];
		$INIDATE = $info["INIDATE"];
		$ENDATE = $info["ENDATE"];
		$HOURS = $info["HOURS"];
		$WBS = $info["WBS"];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$CODE = md5($info["INIDATE"]."-".$now);
		
		
		$str = "INSERT INTO sessions(CODE, DATE, TECH, TYPE, CO, SO, INIDATE, ENDATE, HOURS, WBS) VALUES ('".$CODE."', '".$DATE."', '".$TECH."', '".$TYPE."', '".$CO."', '".$SO."', '".$INIDATE."', '".$ENDATE."', '".$HOURS."', '".$WBS."')";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function podFullGet($info)
	{
		$pcode = $info["pcode"];
		$ppack = array();
		
		$str = "SELECT * FROM projects WHERE PCODE = '".$pcode."'";
		$query = $this->db->query($str);
		$pData = $query[0];
		
		$dpkc = array();
		$dpkc["pcode"] = $pcode;
		$pDays = $this-> getPdays($dpkc)["message"];
		
		$qcode = $pData["QCODE"];
		$dpkc = array();
		$dpkc["qcode"] = $qcode;
		$progress = $this-> getProgress($dpkc)["message"];

		$dpkc = array();
		$dpkc["qcode"] = $pData["QCODE"];
		$pTotals = $this-> getPtotals($dpkc)["message"];

		$ppack["pTotals"] = $pTotals;
		$ppack["pData"] = $pData;
		$ppack["pDays"] = $pDays;
		$ppack["progress"] = $progress;

		
		$resp["message"] = $ppack;
		$resp["status"] = true;
				
		return $resp;
	}
	function getTrainings($info)
	{
		$ucode = $info["ucode"];
		
		$str = "SELECT *  FROM training WHERE UCODE = '".$ucode."' AND MTYPE = 'TR' ORDER BY ENDATE ASC";
		$query = $this->db->query($str);
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getPPE($info)
	{
		$ucode = $info["ucode"];
		
		$str = "SELECT *  FROM training WHERE UCODE = '".$ucode."' AND MTYPE != 'TR' ORDER BY ENDATE ASC";
		$query = $this->db->query($str);
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getPdays($info)
	{
		$pcode = $info["pcode"];
		
		$str = "SELECT *  FROM days WHERE PCODE = '".$pcode."' ORDER BY DATE ASC";
		$query = $this->db->query($str);
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getProgress($info)
	{
		$qcode = $info["qcode"];
		$quoteL = 0;
		$doneL = 0;
		$quoteA = 0;
		$doneA = 0;
		
		$str = "SELECT *  FROM days WHERE QCODE = '".$qcode."' ORDER BY DATE ASC";
		$pDays = $this->db->query($str);
		
		if(count($pDays)> 0)
		{
			$str = "SELECT QUOTE, SUM(LABOR) AS TE FROM dayItems WHERE QCODE = '".$qcode."' AND TYPE = 'L' GROUP BY NAME";
			$dataL = $this->db->query($str);
			
			for($i=0; $i<count($dataL); $i++)
			{
				$item = $dataL[$i];
				$quoteL = $quoteL+intval($item["QUOTE"]);
				$doneL = $doneL+intval($item["TE"]);
			}
			
			$str = "SELECT QUOTE, SUM(LABOR) AS TE FROM dayItems WHERE QCODE = '".$qcode."' AND TYPE = 'A' GROUP BY NAME";
			$dataA = $this->db->query($str);
			
			for($i=0; $i<count($dataA); $i++)
			{
				$item = $dataA[$i];
				$quoteA = $quoteA+intval($item["QUOTE"]);
				$doneA = $doneA+intval($item["TE"]);
			}
			
			$totalQ = $quoteL+$quoteA;
			$totalE = $doneL+$doneA;
			
			if($totalE > 0 and $totalQ > 0)
			{
				$percent = ($totalE/$totalQ)*100;
			}
			else
			{
				$percent = 0;
			}
			
			$ans = intval($percent);
		}
		else
		{
			$ans = 0;
		}
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function saveObs($info)
	{
		$otype = $info["otype"];
		$dcode = $info["dcode"];
		$obs = $info["obs"];
		
		if($otype == "L")
		{
			$field = "OBS";
		}
		else if($otype == "T")
		{
			$field = "TOBS";
		}
		else
		{
			$field = "AMOBS";
		}
		
		$str = "UPDATE days SET $field = '".$obs."' WHERE DCODE ='".$dcode."'";
		
		$query = $this->db->query($str);
		$ans = $query;
		
		$resp["message"] = $ans;
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
		$reported =  utf8_decode($odata["CONTACT"]);
		$detail = utf8_decode($odata["DETAIL"]);
		$obs = utf8_decode($odata["OBSERVATIONS"]);
		$rec = utf8_decode($odata["RECOMENDATIONS"]);
		$pen = utf8_decode($odata["PENDINGS"]);
		
		
		// FILE START
		$pdf = new FPDF();
		
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
		$w = array(25, 45, 125);
		$header = array('Placa', 'Nombre', 'Actividad');
		$pdf->Ln(2);
	   
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
		
		// actData
		foreach($actList as $row)
		{
				$pdf->Cell($w[0],5,$row['MAQUI'],'LR',0,'L',$fill);
				$pdf->Cell($w[1],5,utf8_decode($row['MAQUINAME']),'LR',0,'L',$fill);
				// $pdf->Cell($w[2],5,'$'.number_format($row[2]),'LR',0,'R',$fill);
				
				$desc = strtolower(substr(utf8_decode($row['ADESC']),0,92));
				
				$pdf->Cell($w[2],5,$desc,'LR',0,'L',$fill);
				$pdf->Ln(5);
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
		$w = array(25, 150, 20);
		$header = array('Código', 'Descripción', 'Cantidad');
		
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
		
		// partData
		foreach($partList as $row)
		{
				$pdf->Cell($w[0],5,$row['PCODE'],'LR',0,'L',$fill);
				$pdf->Cell($w[1],5,utf8_decode($row['PDESC']),'LR',0,'L',$fill);
				// $pdf->Cell($w[2],5,'$'.number_format($row[2]),'LR',0,'R',$fill);
				$pdf->Cell($w[2],5,$row['PAMOUNT'],'LR',0,'L',$fill);
				$pdf->Ln(5);
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
		

		// OBS FILLER
		$pdf->SetY(-74);
		if(strlen($obs) < 139)
		{
				$pdf->Cell(48,5,$obs,0,0,'L',false);
				$pdf->Ln(6);
		}
		else
		{
			$line1 = str_split($obs, 138)[0];
			$line2 = str_split($obs, 138)[1];
			
			$pdf->Cell(183,5,$line1,0,0,'L',false);
			$pdf->Ln(4);
			$pdf->Cell(196,5,$line2,0,0,'L',false);
			
			if(strlen($obs) > 276)
			{
				$line3 = str_split($obs, 138)[2];
				$pdf->Ln(4);
				$pdf->Cell(196,5,$line3,0,0,'L',false);
				
				if(strlen($obs) > 414)
				{
					$line4 = str_split($obs, 138)[3];
					$pdf->Ln(4);
					$pdf->Cell(196,5,$line4,0,0,'L',false);
					
					if(strlen($obs) > 552)
					{
						$line5 = str_split($obs, 138)[4];
						$pdf->Ln(4);
						$pdf->Cell(196,5,$line5,0,0,'L',false);
						
						if(strlen($obs) > 690)
						{
							$line6 = str_split($obs, 138)[5];
							$pdf->Ln(4);
							$pdf->Cell(196,5,$line6,0,0,'L',false);
							
							if(strlen($obs) > 829)
							{
								$line7 = str_split($obs, 138)[6];
								$pdf->Ln(4);
								$pdf->Cell(196,5,$line7,0,0,'L',false);
								
								if(strlen($obs) > 968)
								{
									$line8 = str_split($obs, 138)[7];
									$pdf->Ln(4);
									$pdf->Cell(196,5,$line8,0,0,'L',false);
									
									if(strlen($obs) > 1106)
									{
										$line9 = str_split($obs, 138)[8];
										$pdf->Ln(4);
										$pdf->Cell(196,5,$line9,0,0,'L',false);
										
										if(strlen($obs) > 1244)
										{
											$line10 = str_split($obs, 138)[9];
											$pdf->Ln(4);
											$pdf->Cell(196,5,$line10,0,0,'L',false);
											
											if(strlen($obs) > 1382)
											{
												$line11 = str_split($obs, 138)[10];
												$pdf->Ln(4);
												$pdf->Cell(196,5,$line11,0,0,'L',false);
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		// REC FILLER
		$pdf->SetY(-56);
		if(strlen($rec) < 147)
		{
				$pdf->Cell(48,5,$rec,0,0,'L',false);
				$pdf->Ln(6);
		}
		else
		{
				$line1 = str_split($rec, 146)[0];
				$line2 = str_split($rec, 146)[1];
				
				$pdf->Cell(183,5,$line1,0,0,'L',false);
				$pdf->Ln(4);
				$pdf->Cell(196,5,$line2,0,0,'L',false);
				
				if(strlen($rec) > 296)
				{
						$line3 = str_split($rec, 146)[2];
						$pdf->Ln(4);
						$pdf->Cell(196,5,$line3,0,0,'L',false);
				}

		}
		
		// PEN FILLER
		$pdf->SetY(-39);
		 if(strlen($pen) < 147)
		{
				$pdf->Cell(48,5,$pen,0,0,'L',false);
				$pdf->Ln(6);
		}
		else
		{
				$line1 = str_split($pen, 146)[0];
				$line2 = str_split($pen, 146)[1];
			  
				$pdf->Cell(183,5,$line1,0,0,'L',false);
				$pdf->Ln(4);
				$pdf->Cell(196,5,$line2,0,0,'L',false);
				
				
				if(strlen($pen) > 296)
				{
						$line3 = str_split($pen, 146)[2];
						$pdf->Ln(4);
						$pdf->Cell(196,5,$line3,0,0,'L',false);
				}
				
				
		}
	
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
		
		// CHAR REPLACES
		// $cname = str_replace("'","\\'", $odata["PARENTNAME"]);
		// $cname = str_replace("ñ","n", $cname);
		// $cname = str_replace("á","a", $cname);
		// $cname = str_replace("é","e", $cname);
		// $cname = str_replace("í","i", $cname);
		// $cname = str_replace("ó","o", $cname);
		// $cname = str_replace("ú","u", $cname);
		// $cname = str_replace("Ñ","N", $cname);
		// $cname = str_replace("Á","A", $cname);
		// $cname = str_replace("É","E", $cname);
		// $cname = str_replace("Í","I", $cname);
		// $cname = str_replace("Ó","O", $cname);
		// $cname = str_replace("Ú","U", $cname);
		// CHAR REPLACES
		
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
		$reported =  utf8_decode($odata["CONTACT"]);
		$detail = utf8_decode($odata["DETAIL"]);
		$obs = utf8_decode($odata["OBSERVATIONS"]);
		$rec = utf8_decode($odata["RECOMENDATIONS"]);
		$pen = utf8_decode($odata["PENDINGS"]);
		
		// FILE START
		$pdf = new FPDF();
		
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
		$w = array(25, 42, 80, 18, 12, 18);
		$header = array('Placa', 'Nombre', 'Actividad', 'Valor un', 'Cant', 'Subtotal');
		$pdf->Ln(2);
	   
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
		
		$tActis = 0;
		// actData
		foreach($actList as $row)
		{
			$qty = $row['UNIVALUE'];
			$unival = $row['UNIPRICE'];
			$pdf->Cell($w[0],5,$row['MAQUI'],'LR',0,'L',$fill);
			$pdf->Cell($w[1],5,substr(utf8_decode($row['MAQUINAME']),0,25),'LR',0,'L',$fill);
			// $pdf->Cell($w[2],5,'$'.number_format($row[2]),'LR',0,'R',$fill);
			$pdf->Cell($w[2],5,strtolower(substr(utf8_decode($row['ADESC']), 0, 58)),'LR',0,'L',$fill);
			$pdf->Cell($w[3],5,'$'.number_format($unival),'LR',0,'C',$fill);
			$pdf->Cell($w[4],5,$qty,'LR',0,'C',$fill);
			$pdf->Cell($w[5],5,'$'.number_format($qty*$unival),'LR',0,'R',$fill);
			
			
			$pdf->Ln(5);
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
		
		$pdf->SetFont('Arial','', 8);
		
		// OBS FILLER
		$pdf->SetY(-56.3);
		if(strlen($obs) < 139)
		{
				$pdf->Cell(48,5,$obs,0,0,'L',false);
				$pdf->Ln(6);
		}
		else
		{
			$line1 = str_split($obs, 138)[0];
			$line2 = str_split($obs, 138)[1];
			
			$pdf->Cell(183,5,$line1,0,0,'L',false);
			$pdf->Ln(4);
			$pdf->Cell(196,5,$line2,0,0,'L',false);
			
			if(strlen($obs) > 276)
			{
				$line3 = str_split($obs, 138)[2];
				$pdf->Ln(4);
				$pdf->Cell(196,5,$line3,0,0,'L',false);
				
				if(strlen($obs) > 414)
				{
					$line4 = str_split($obs, 138)[3];
					$pdf->Ln(4);
					$pdf->Cell(196,5,$line4,0,0,'L',false);
					
					if(strlen($obs) > 552)
					{
						$line5 = str_split($obs, 138)[4];
						$pdf->Ln(4);
						$pdf->Cell(196,5,$line5,0,0,'L',false);
						
						if(strlen($obs) > 690)
						{
							$line6 = str_split($obs, 138)[5];
							$pdf->Ln(4);
							$pdf->Cell(196,5,$line6,0,0,'L',false);
							
							if(strlen($obs) > 829)
							{
								$line7 = str_split($obs, 138)[6];
								$pdf->Ln(4);
								$pdf->Cell(196,5,$line7,0,0,'L',false);
								
								if(strlen($obs) > 968)
								{
									$line8 = str_split($obs, 138)[7];
									$pdf->Ln(4);
									$pdf->Cell(196,5,$line8,0,0,'L',false);
									
									if(strlen($obs) > 1106)
									{
										$line9 = str_split($obs, 138)[8];
										$pdf->Ln(4);
										$pdf->Cell(196,5,$line9,0,0,'L',false);
										
										if(strlen($obs) > 1244)
										{
											$line10 = str_split($obs, 138)[9];
											$pdf->Ln(4);
											$pdf->Cell(196,5,$line10,0,0,'L',false);
											
											if(strlen($obs) > 1382)
											{
												$line11 = str_split($obs, 138)[10];
												$pdf->Ln(4);
												$pdf->Cell(196,5,$line11,0,0,'L',false);
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}


		// REC FILLER
		$pdf->SetY(-38.3);
		if(strlen($rec) < 147)
		{
				$pdf->Cell(48,5,$rec,0,0,'L',false);
				$pdf->Ln(6);
		}
		else
		{
				$line1 = str_split($rec, 146)[0];
				$line2 = str_split($rec, 146)[1];
				
				$pdf->Cell(183,5,$line1,0,0,'L',false);
				$pdf->Ln(4);
				$pdf->Cell(196,5,$line2,0,0,'L',false);
				
				if(strlen($rec) > 296)
				{
						$line3 = str_split($rec, 146)[2];
						$pdf->Ln(4);
						$pdf->Cell(196,5,$line3,0,0,'L',false);
				}

		}
		
		// PEN FILLER
		$pdf->SetY(-21);
		 if(strlen($pen) < 147)
		{
				$pdf->Cell(48,5,$pen,0,0,'L',false);
				$pdf->Ln(6);
		}
		else
		{
				$line1 = str_split($pen, 146)[0];
				$line2 = str_split($pen, 146)[1];
			  
				$pdf->Cell(183,5,$line1,0,0,'L',false);
				$pdf->Ln(4);
				$pdf->Cell(196,5,$line2,0,0,'L',false);
				
				
				if(strlen($pen) > 296)
				{
						$line3 = str_split($pen, 146)[2];
						$pdf->Ln(4);
						$pdf->Cell(196,5,$line3,0,0,'L',false);
				}
				
				
		}
		
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
                
                
                
                $str = "SELECT *  FROM receipts $where ORDER BY NUM DESC LIMIT 150";
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
				
				$str = "SELECT ADESC, ACOST FROM oactis WHERE OCODE = '".$ocode."'";
				$query = $this->db->query($str);
				
				$actList = $query;
				
				for($x=0; $x<count($actList);$x++)
				{
						$line = array();
						
						$order = $number;
						$desc = $actList[$x]["ADESC"]." - ".$sucuCode;
						$amount = 1;
						$cost = $actList[$x]["ACOST"];
						$subtotal = $amount * $cost;
						
						$line["ORDER"] = $order;
						$line["DESC"] = $desc;
						$line["AMOUNT"] = $amount;
						$line["COST"] = $cost;
						$line["SUBTOTAL"] = $subtotal;
						
						$fullist[] = $line;
				}

				// -----ORIGINAL PART ADDER----
				// $str = "SELECT PDESC, PCOST, PAMOUNT FROM oparts WHERE OCODE = '".$ocode."'";
				// $query = $this->db->query($str);
				
				// $partList = $query;
				
				// for($x=0; $x<count($partList);$x++)
				// {
						// $line = array();
						
						// $order = $number;
						// $desc = $partList[$x]["PDESC"]." - ".$sucuCode;
						// $amount = $partList[$x]["PAMOUNT"];
						// $cost = $partList[$x]["PCOST"];
						// $subtotal = $amount * $cost;
						
						// $line["ORDER"] = $order;
						// $line["DESC"] = $desc;
						// $line["AMOUNT"] = $amount;
						// $line["COST"] = $cost;
						// $line["SUBTOTAL"] = $subtotal;
						
						// $fullist[] = $line;
				// }
				// -----ORIGINAL PART ADDER----
				
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

				
				// -----NEW PART ADDER----
				
				
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
			$pdf = new FPDF();
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
			
			// recData
			foreach($fullist as $row)
			{
					$pdf->Cell($w[0],6,$row['ORDER'],'LR',0,'L',$fill);
					$pdf->Cell($w[1],6,utf8_decode($row['DESC']),'LR',0,'L',$fill);
					$pdf->Cell($w[2],6,$row['AMOUNT'],'LR',0,'C',$fill);
					$pdf->Cell($w[3],6,('$'.number_format($row['COST'])),'LR',0,'R',$fill);
					$pdf->Cell($w[4],6,('$'.number_format($row['SUBTOTAL'])),'LR',0,'R',$fill);

					$fillCount++;

					if($fillCount == 30 and $fillCount != $rowCount)
					{
							$pdf->Ln(6);
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
							$pdf->Ln(6);
					}
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
							$str = "UPDATE orders SET STATE = '4' WHERE CODE ='".$picks[$i]."'";
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
			$email_from = 'administrator@opspecialistsgroup.com';
			$email_message = 
			"<div style='text-align: center; margin: auto; width: 800px !important; background: #F0EDE8; border-radius: 15px;'>".
			"<img src='https://opspecialistsgroup.com/irsc/pasRecHeader-".$language.".png' style='width=100% !important;'/>".
			"<br><br>".
			"<span style='font-size:14px; '>".$message."</span>".
			"<br>".
			"<span style='font-size:14px; font-weight: bold;'>"."<a href='https://opspecialistsgroup.com/?me=".$userEmail."&tmpkey=".$tmpkey."&lang=".$language."&type=".$userType." '>".htmlentities($recLink)."</a>"."</span>".
			"<br><br>".
			"<img src='https://opspecialistsgroup.com/irsc/footer-".$language.".png' style='width=100% !important;'/>".
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
		$header = "Message from Operational Specialist and Blade Group";
		
		$email_subject = $header;
		$email_from = $sucode;
		$email_message = "Message from: ".$spcname."<br><br><span style='font-size:14px; '>".$content."</span>";
		
		$headers = "From: " . $email_from . "\r\n";
		$headers .= "Reply-To: ". $email_from . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		mail ("cristhian.saenz@siemensgamesa.com", $email_subject, $email_message, $headers);

		$resp["message"] = "done";
		$resp["status"] = true;
		
		return $resp;
	}
	function tagContactOrder($info)
	{
		$origin = $info["origin"];
		$spcname = htmlentities($info["name"]);
		$content = $info["message"];
		$quote = $info["quote"];
		$recipient = $info["recipient"];
		$etype = $info["etype"];
		
		$email_from = $origin;
		
		if($etype == "day")
		{
			$dcode = $info["dcode"];
			
			$header = "Excel day report: ".$quote;
			

			$dpkc = array();
			$dpkc["type"] = $etype;
			$dpkc["mode"] = "";
			$dpkc["dcode"] = $dcode;
			$createdPath = $this-> exportXLS($dpkc)["message"];
			
			$link = "https://opspecialistsgroup.com/excel/".$createdPath;
			
			$resp["message"] = $createdPath;
			$resp["status"] = true;
			return $resp;
			
			$email_message = "<span style='font-size:14px; '>Excel day report from: ".$spcname.", to download the file, click on the next link:</span> <br><br>".
			"<a href='".$link."'>Download report</a><br><br><span style='font-size:14px; font-weight: bold; '>Comments:</span><br>".
			"<br><span style='font-size:14px; '>".$content."</span>";
	
		}
		else if($etype == "project")
		{
			$qcode = $info["quote"];
			$link = "";
			$header = "Excel project report: ".$quote;
			
			
			$dpkc = array();
			$dpkc["type"] = $etype;
			$dpkc["mode"] = "";
			$dpkc["qcode"] = $qcode;
			$createdPath = $this-> exportXLS($dpkc)["message"];
			
			$resp["message"] = $createdPath;
			$resp["status"] = true;
			return $resp;
			
			$link = "https://opspecialistsgroup.com/excel/".$createdPath;
			$email_message = "<span style='font-size:14px; '>Excel project report from: ".$spcname.", to download the file click on the next link</span>: <br><br>".
			"<a href='".$link."'>Download report</a><br><br><span style='font-size:14px; font-weight: bold; '>Comments:</span><br>".
			"<br><span style='font-size:14px; '>".$content."</span>";
			
		}
		else if($etype == "reqSup")
		{
			$qcode = $info["quote"];
			$link = "";
			$header = "Excel project report: ".$quote;
			
			
			$dpkc = array();
			$dpkc["type"] = $etype;
			$dpkc["mode"] = "";
			$dpkc["qcode"] = $qcode;
			$createdPath = $this-> exportXLS($dpkc)["message"];
			
			$resp["message"] = $createdPath;
			$resp["status"] = true;
			return $resp;
			
			
		}
		else if($etype == "pnotif")
		{
			$qcode = $info["quote"];
			
			$header = "Notification about project report: ".$quote;
			$email_message = "Message from: ".$spcname." about Project report: ".$quote."<br><br><span style='font-size:14px; '>".$content."</span>";
			
			$createdPath = "notif project";
		}
		else if($etype == "trnotif")
		{
			$qcode = $info["quote"];
			
			$header = "Notification about training: ".$quote;
			$email_message = "Message from: ".$spcname." about training: ".$quote."<br><br><span style='font-size:14px; '>".$content."</span>";
			
			$createdPath = "notif training";
		}
		else if($etype == "ppenotif")
		{
			$qcode = $info["quote"];
			
			$header = "Notification about PPE and Tools: ".$quote;
			$email_message = "Message from: ".$spcname." about training: ".$quote."<br><br><span style='font-size:14px; '>".$content."</span>";
			
			$createdPath = "notif ppe";
		}
		else if($etype == "supReq")
		{
			$qcode = $info["quote"];

			$header = "Notification about request: ".$quote;
			$email_message = "<span style='font-size:14px; '>".$content."</span>";
			
			$createdPath = "supReq";
		}
		else
		{
			$header = "Notification about quote: ".$quote;
			$email_message = "Message from: ".$spcname." about Quote: ".$quote."<br><br><span style='font-size:14px; '>".$content."</span>";
			
			$createdPath = "regular";
		}

		$email_subject = $header;
		$headers = "From: " . $origin . "\r\n";
		$headers .= "Reply-To: ". $origin . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		// UNCOMMENT TO TEST
		mail ($recipient, $email_subject, $email_message, $headers);

		$resp["message"] = $createdPath;
		$resp["status"] = true;
		return $resp;
	}
	function getContactList($info)
	{
		
		$str = "SELECT RESPNAME, MAIL, TYPE FROM users ORDER BY TYPE ASC";
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
	function getUserList($info)
	{
		$type = $info["type"];
		
		$str = "SELECT RESPNAME, CODE FROM users WHERE uPos = '".$type."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	// REPORTERY BLOCK START -------------------------
        
	function getReport($info)
	{
		$repoType = $info["repoType"];
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
		
		
		if($repoType == "power")
		{
			
			$repoClient = $info["repoClient"];
			$repoWindFarm = $info["repoWindFarm"];
			$repoStatus = $info["repoStatus"];
			$repoPlatform = $info["repoPlatform"];
			$repoJob = $info["repoJob"];
			$repoOrderNum = $info["repoOrderNum"];
			$repoCategory = $info["repoCategory"];
			$repoDetails = $info["repoDetails"];
			$repoIniDate = $info["repoIniDate"];
			$repoEndDate = $info["repoEndDate"];
			$repoCstate = $info["repoCstate"];
			
			$where = "WHERE  PCODE != 'null' ";

			if($repoWindFarm != ""){$where .= "AND WFARM LIKE '%$repoWindFarm%'";} 
			if($repoOrderNum != ""){$where .= "AND QCODE LIKE '%$repoOrderNum%'";} 
			if($repoCategory != ""){$where .= "AND G4 LIKE '%$repoCategory%'";} 
			if($repoJob != ""){$where .= "AND JOB LIKE '%$repoJob%'";} 
			if($repoDetails != ""){$where .= "AND DETAIL LIKE '%$repoDetails%'";} 
			if($repoPlatform != ""){$where .= "AND PLATFORM = '$repoPlatform'";} 
			if($repoStatus != "")
			{
				if($repoStatus == "0")
				{
					$where .= "AND CLOSD =  ''";
				}
				if($repoStatus == "1")
				{
					$where .= "AND CLOSD !=  ''";
				}
			} 
			if($repoCstate != ""){$where .= "AND CSTATE = '$repoCstate'";} 
			if($repoIniDate != ""){$where .= "AND INIDATE >=  '$repoIniDate' ";} 
			if($repoEndDate != ""){$where .= "AND INIDATE <=  '$repoEndDate' ";} 
			
			$str = "SELECT * FROM projects $where ORDER BY INIDATE DESC";
			$projects = $this->db->query($str);
			$cFiltered = array();
			
			for($i=0; $i<count($projects); $i++)
			{
				$item = $projects[$i];
				$dpkc = array();
				$dpkc["code"] = $item["QCODE"];
				$dpkc["pcode"] = $item["PCODE"];
				$odataP = $this-> oGetP($dpkc)["message"];
				$client = $odataP["CLIENT"];
				
						
				// GET PROGRAMED MOB, LABOR
				$mobP = $odataP["MOBP"];
				$mobE = $odataP["MOBE"];
				$laborP = $odataP["LABORP"];
				$laborE = $odataP["LABORE"];
				$standByE = $odataP["STANDBYE"];
				$ncE = $odataP["NCE"];
				$osE = $odataP["OSE"];
				$district = $odataP["DISTRICT"];
				
				$projects[$i]["CLIENT"] = $client;
				$projects[$i]["MOBP"] = $mobP;
				$projects[$i]["LABORP"] = $laborP;
				$projects[$i]["MOBE"] = $mobE;
				$projects[$i]["LABORE"] = $laborE;
				$projects[$i]["STANDBYE"] = $standByE;
				$projects[$i]["NCE"] = $ncE;
				$projects[$i]["OSE"] = $osE;
				$projects[$i]["DISTRICT"] = $district;
				
				
				

				if($repoClient != "")
				{
					if (strpos(strtoupper($client), strtoupper($repoClient)) === FALSE){}
					else{array_push($cFiltered, $projects[$i]);}
				}
			}
			if($repoClient != ""){$projects = $cFiltered;}

			$result = $projects;

			// HEADER TITLE
			
			if($repoIniDate != ""){$inidate = $repoIniDate;}
			else{$inidate = "Open";}
			
			if($repoEndDate != ""){$enddate = $repoEndDate;}
			else{$enddate = "Open";}
			
			$dateRange = "from: " .$inidate. " to ". $enddate;
			
			
			$sheet->setCellValue('A1', 'General projects report ' . $dateRange);
			$sheet->getStyle("A1")->getFont()->setBold(true);
			$sheet->mergeCells('A1:N1');

			// TITLES LINE 1
			
			$c = 3;
			
			$sheet->getStyle("A$c:W$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:W$c")->getFont()->setBold(true);
			$sheet->getStyle("A$c:W$c")->applyFromArray($alignCenter);
			$sheet->getStyle("A$c:W$c")->applyFromArray($grayBg);
			
			
			// ----------NEW REPORT
			
			// "Labor"
			// "Company"
			// "Date"
			// "Name"
			// “GID”
			// “Specialty”
			
			// "Quote labor"
			// "Executed labor"
			// "Result labor"
			// "Quote Mob"
			// "Executed Mob"
			// "Result Mob"
			// "Standby"
			// "No Conformity"
			// "Out of scope"
			// "Category"
			// "Platform"
			// "Initial date"
			// "District"
			// "Wind Farm"
			// "Job Type"
			
			// Number of turbines visited --las del project
			// Number of hours spent at each turbine. --Total todos los dias todas las tubirnas
			
			// ----------
			
			
			$sheet->setCellValue("H$c", "Quote labor");
			$sheet->setCellValue("B$c", "Client");
			
			$sheet->setCellValue("A$c", "Quote num");
			
			$sheet->setCellValue("C$c", "Wind Farm");
			$sheet->setCellValue("D$c", "Category");
			$sheet->setCellValue("E$c", "Platform");
			$sheet->setCellValue("F$c", "Job type");
			$sheet->setCellValue("G$c", "Project details");
			
			$sheet->setCellValue("I$c", "Executed labor");
			$sheet->setCellValue("J$c", "Result labor");
			$sheet->setCellValue("K$c", "Quote Mob");
			$sheet->setCellValue("L$c", "Executed Mob");
			$sheet->setCellValue("M$c", "Result Mob");
			$sheet->setCellValue("N$c", "Standby");
			$sheet->setCellValue("O$c", "No Conformity");
			$sheet->setCellValue("P$c", "Out of scope");
			$sheet->setCellValue("Q$c", "Service Order");
			$sheet->setCellValue("R$c", "Cost Order");
			$sheet->setCellValue("S$c", "District");
			$sheet->setCellValue("T$c", "Initial date");
			
			
			
			
			
			$c++;
			
			$totalLabP = 0;
			$totalLabE = 0;
			$totalMobP = 0;
			$totalMobE = 0;
			$totalStandby = 0;
			$totalNc = 0;
			$totalOsc = 0;
			
			for($i = 0; $i<count($projects);$i++)
			{
				$item = $projects[$i];
				
				
				$lbP = floatval($item["LABORP"]);
				$lbE = floatval($item["LABORE"]);
				
				if($lbP <= 0)
				{
					$resultLabor = 0;
				}
				else
				{	
					$resultLabor = $lbE/$lbP;
				}
				
				$mobP = floatval($item["MOBP"]);
				$mobE = floatval($item["MOBE"]);
				
				if($mobP <= 0)
				{
					$resultMob = 0;
				}
				else
				{	
					$resultMob = $mobE/$mobP;
				}


				$sheet->setCellValue("A$c",  $item["QCODE"]);
				$sheet->setCellValue("B$c",  $item["CLIENT"]);
				$sheet->setCellValue("C$c",  $item["WFARM"]);
				$sheet->setCellValue("D$c",  $item["G4"]);
				$sheet->setCellValue("E$c",  $item["PLATFORM"]);
				$sheet->setCellValue("F$c",  $item["JOB"]);
				$sheet->setCellValue("G$c",  $item["DETAIL"]);
				$sheet->setCellValue("H$c",  $item["LABORP"]);
				$sheet->setCellValue("I$c",  $item["LABORE"]);
				// $sheet->setCellValue("J$c",  $resultLabor);
				$sheet->setCellValue("J$c",  floatval($item["LABORE"])-floatval($item["LABORP"]));
				$sheet->setCellValue("K$c",  $item["MOBP"]);
				$sheet->setCellValue("L$c",  $item["MOBE"]);
				// $sheet->setCellValue("M$c",  $resultMob);
				$sheet->setCellValue("M$c",  floatval($item["MOBE"])-floatval($item["MOBP"]));
				$sheet->setCellValue("N$c",  $item["STANDBYE"]);
				$sheet->setCellValue("O$c",  $item["NCE"]);
				$sheet->setCellValue("P$c",  $item["OSE"]);
				$sheet->setCellValue("Q$c",  $item["SO"]);
				$sheet->setCellValue("R$c",  $item["CO"]);
				$sheet->setCellValue("S$c",  $item["DISTRICT"]);
				$sheet->setCellValue("T$c",  $item["INIDATE"]);
				$sheet->setCellValue("U$c",  $item["CLOSD"]);
				$sheet->setCellValue("V$c",  $item["CLDETAIL"]);
				$sheet->setCellValue("W$c",  $item["CSTATE"]);
				
				$sheet->getStyle("A$c:W$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:W$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:W$c")->getFont()->setSize(9);
				
				$sheet->getStyle("A$c")->applyFromArray($alignCenter);
				$sheet->getStyle("O$c:W$c")->applyFromArray($alignCenter);
				$sheet->getStyle("Y$c")->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));
				
				$totalLabP += floatval($item["LABORP"]);
				$totalLabE += floatval($item["LABORE"]);
				$totalMobP += floatval($item["MOBP"]);
				$totalMobE += floatval($item["MOBE"]);
				$totalStandby += floatval($item["STANDBYE"]);
				$totalNc += floatval($item["NCE"]);
				$totalOsc += floatval($item["OSE"]);

				$c++;
			}
			
			$sheet->getStyle("A$c:W$c")->getFont()->setSize(10);
			$sheet->getStyle("O$c:W$c")->applyFromArray($alignCenter);
			$sheet->getStyle("A$c:W$c")->applyFromArray($grayBg);
			$sheet->getStyle("O$c:W$c")->getNumberFormat()->setFormatCode('#,##0');

			$sheet->setCellValue("H$c",  $totalLabP);
			$sheet->setCellValue("I$c",  $totalLabE);
			$sheet->setCellValue("K$c",  $totalMobP);
			$sheet->setCellValue("L$c",  $totalMobE);
			$sheet->setCellValue("N$c",  $totalStandby);
			$sheet->setCellValue("O$c",  $totalNc);
			$sheet->setCellValue("P$c",  $totalOsc);

			
			
			// ------------------FILE CREATE-------------------
			$fname = "Power VI ".$now.".xls";
		}
		
		if($repoType == "generalP")
		{
			
			$repoClient = $info["repoClient"];
			$repoWindFarm = $info["repoWindFarm"];
			$repoStatus = $info["repoStatus"];
			$repoPlatform = $info["repoPlatform"];
			$repoJob = $info["repoJob"];
			$repoOrderNum = $info["repoOrderNum"];
			$repoCategory = $info["repoCategory"];
			$repoDetails = $info["repoDetails"];
			$repoIniDate = $info["repoIniDate"];
			$repoEndDate = $info["repoEndDate"];
			$repoCstate = $info["repoCstate"];
			
			$where = "WHERE  PCODE != 'null' ";

			if($repoWindFarm != ""){$where .= "AND WFARM LIKE '%$repoWindFarm%'";} 
			if($repoOrderNum != ""){$where .= "AND QCODE LIKE '%$repoOrderNum%'";} 
			if($repoCategory != ""){$where .= "AND G4 LIKE '%$repoCategory%'";} 
			if($repoJob != ""){$where .= "AND JOB LIKE '%$repoJob%'";} 
			if($repoDetails != ""){$where .= "AND DETAIL LIKE '%$repoDetails%'";} 
			if($repoPlatform != ""){$where .= "AND PLATFORM = '$repoPlatform'";} 
			if($repoStatus != "")
			{
				if($repoStatus == "0")
				{
					$where .= "AND CLOSD =  ''";
				}
				if($repoStatus == "1")
				{
					$where .= "AND CLOSD !=  ''";
				}
			} 
			if($repoCstate != ""){$where .= "AND CSTATE = '$repoCstate'";} 
			if($repoIniDate != ""){$where .= "AND INIDATE >=  '$repoIniDate' ";} 
			if($repoEndDate != ""){$where .= "AND INIDATE <=  '$repoEndDate' ";} 
			
			$str = "SELECT * FROM projects $where ORDER BY INIDATE DESC";
			$projects = $this->db->query($str);
			$cFiltered = array();
			
			for($i=0; $i<count($projects); $i++)
			{
				$item = $projects[$i];
				$dpkc = array();
				$dpkc["code"] = $item["QCODE"];
				$dpkc["pcode"] = $item["PCODE"];
				$odataP = $this-> oGetP($dpkc)["message"];
				$client = $odataP["CLIENT"];
				
						
				// GET PROGRAMED MOB, LABOR
				$mobP = $odataP["MOBP"];
				$mobE = $odataP["MOBE"];
				$laborP = $odataP["LABORP"];
				$laborE = $odataP["LABORE"];
				$standByE = $odataP["STANDBYE"];
				$ncE = $odataP["NCE"];
				$osE = $odataP["OSE"];
				$district = $odataP["DISTRICT"];
				
				$projects[$i]["CLIENT"] = $client;
				$projects[$i]["MOBP"] = $mobP;
				$projects[$i]["LABORP"] = $laborP;
				$projects[$i]["MOBE"] = $mobE;
				$projects[$i]["LABORE"] = $laborE;
				$projects[$i]["STANDBYE"] = $standByE;
				$projects[$i]["NCE"] = $ncE;
				$projects[$i]["OSE"] = $osE;
				$projects[$i]["DISTRICT"] = $district;
				
				
				

				if($repoClient != "")
				{
					if (strpos(strtoupper($client), strtoupper($repoClient)) === FALSE){}
					else{array_push($cFiltered, $projects[$i]);}
				}
			}
			if($repoClient != ""){$projects = $cFiltered;}

			$result = $projects;

			// HEADER TITLE
			
			if($repoIniDate != ""){$inidate = $repoIniDate;}
			else{$inidate = "Open";}
			
			if($repoEndDate != ""){$enddate = $repoEndDate;}
			else{$enddate = "Open";}
			
			$dateRange = "from: " .$inidate. " to ". $enddate;
			
			
			$sheet->setCellValue('A1', 'General projects report ' . $dateRange);
			$sheet->getStyle("A1")->getFont()->setBold(true);
			$sheet->mergeCells('A1:N1');

			// TITLES LINE 1
			
			$c = 3;
			
			$sheet->getStyle("A$c:W$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:W$c")->getFont()->setBold(true);
			$sheet->getStyle("A$c:W$c")->applyFromArray($alignCenter);
			$sheet->getStyle("A$c:W$c")->applyFromArray($grayBg);
			
			$sheet->setCellValue("A$c", "Quote num");
			$sheet->setCellValue("B$c", "Client");
			$sheet->setCellValue("C$c", "Wind Farm");
			$sheet->setCellValue("D$c", "Category");
			$sheet->setCellValue("E$c", "Platform");
			$sheet->setCellValue("F$c", "Job type");
			$sheet->setCellValue("G$c", "Project details");
			$sheet->setCellValue("H$c", "Quote labor");
			$sheet->setCellValue("I$c", "Executed labor");
			$sheet->setCellValue("J$c", "Result labor");
			$sheet->setCellValue("K$c", "Quote Mob");
			$sheet->setCellValue("L$c", "Executed Mob");
			$sheet->setCellValue("M$c", "Result Mob");
			$sheet->setCellValue("N$c", "Standby");
			$sheet->setCellValue("O$c", "No Conformity");
			$sheet->setCellValue("P$c", "Out of scope");
			$sheet->setCellValue("Q$c", "Service Order");
			$sheet->setCellValue("R$c", "Cost Order");
			$sheet->setCellValue("S$c", "District");
			$sheet->setCellValue("T$c", "Initial date");
			$sheet->setCellValue("U$c", "Close date");
			$sheet->setCellValue("V$c", "Close details");
			$sheet->setCellValue("W$c", "Close status");

			$c++;
			
			$totalLabP = 0;
			$totalLabE = 0;
			$totalMobP = 0;
			$totalMobE = 0;
			$totalStandby = 0;
			$totalNc = 0;
			$totalOsc = 0;
			
			for($i = 0; $i<count($projects);$i++)
			{
				$item = $projects[$i];
				
				
				$lbP = floatval($item["LABORP"]);
				$lbE = floatval($item["LABORE"]);
				
				if($lbP <= 0)
				{
					$resultLabor = 0;
				}
				else
				{	
					$resultLabor = $lbE/$lbP;
				}
				
				$mobP = floatval($item["MOBP"]);
				$mobE = floatval($item["MOBE"]);
				
				if($mobP <= 0)
				{
					$resultMob = 0;
				}
				else
				{	
					$resultMob = $mobE/$mobP;
				}


				$sheet->setCellValue("A$c",  $item["QCODE"]);
				$sheet->setCellValue("B$c",  $item["CLIENT"]);
				$sheet->setCellValue("C$c",  $item["WFARM"]);
				$sheet->setCellValue("D$c",  $item["G4"]);
				$sheet->setCellValue("E$c",  $item["PLATFORM"]);
				$sheet->setCellValue("F$c",  $item["JOB"]);
				$sheet->setCellValue("G$c",  $item["DETAIL"]);
				$sheet->setCellValue("H$c",  $item["LABORP"]);
				$sheet->setCellValue("I$c",  $item["LABORE"]);
				// $sheet->setCellValue("J$c",  $resultLabor);
				$sheet->setCellValue("J$c",  floatval($item["LABORE"])-floatval($item["LABORP"]));
				$sheet->setCellValue("K$c",  $item["MOBP"]);
				$sheet->setCellValue("L$c",  $item["MOBE"]);
				// $sheet->setCellValue("M$c",  $resultMob);
				$sheet->setCellValue("M$c",  floatval($item["MOBE"])-floatval($item["MOBP"]));
				$sheet->setCellValue("N$c",  $item["STANDBYE"]);
				$sheet->setCellValue("O$c",  $item["NCE"]);
				$sheet->setCellValue("P$c",  $item["OSE"]);
				$sheet->setCellValue("Q$c",  $item["SO"]);
				$sheet->setCellValue("R$c",  $item["CO"]);
				$sheet->setCellValue("S$c",  $item["DISTRICT"]);
				$sheet->setCellValue("T$c",  $item["INIDATE"]);
				$sheet->setCellValue("U$c",  $item["CLOSD"]);
				$sheet->setCellValue("V$c",  $item["CLDETAIL"]);
				$sheet->setCellValue("W$c",  $item["CSTATE"]);
				
				$sheet->getStyle("A$c:W$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:W$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:W$c")->getFont()->setSize(9);
				
				$sheet->getStyle("A$c")->applyFromArray($alignCenter);
				$sheet->getStyle("O$c:W$c")->applyFromArray($alignCenter);
				$sheet->getStyle("Y$c")->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));
				
				$totalLabP += floatval($item["LABORP"]);
				$totalLabE += floatval($item["LABORE"]);
				$totalMobP += floatval($item["MOBP"]);
				$totalMobE += floatval($item["MOBE"]);
				$totalStandby += floatval($item["STANDBYE"]);
				$totalNc += floatval($item["NCE"]);
				$totalOsc += floatval($item["OSE"]);

				$c++;
			}
			
			$sheet->getStyle("A$c:W$c")->getFont()->setSize(10);
			$sheet->getStyle("O$c:W$c")->applyFromArray($alignCenter);
			$sheet->getStyle("A$c:W$c")->applyFromArray($grayBg);
			$sheet->getStyle("O$c:W$c")->getNumberFormat()->setFormatCode('#,##0');

			$sheet->setCellValue("H$c",  $totalLabP);
			$sheet->setCellValue("I$c",  $totalLabE);
			$sheet->setCellValue("K$c",  $totalMobP);
			$sheet->setCellValue("L$c",  $totalMobE);
			$sheet->setCellValue("N$c",  $totalStandby);
			$sheet->setCellValue("O$c",  $totalNc);
			$sheet->setCellValue("P$c",  $totalOsc);

			
			
			// ------------------FILE CREATE-------------------
			$fname = "General report ".$now.".xls";
		}
		
		if($repoType == "generalPA")
		{
			
			$repoClient = $info["repoClient"];
			$repoWindFarm = $info["repoWindFarm"];
			$repoStatus = $info["repoStatus"];
			$repoPlatform = $info["repoPlatform"];
			$repoJob = $info["repoJob"];
			$repoOrderNum = $info["repoOrderNum"];
			$repoCategory = $info["repoCategory"];
			$repoDetails = $info["repoDetails"];
			$repoIniDate = $info["repoIniDate"];
			$repoEndDate = $info["repoEndDate"];
			$repoCstate = $info["repoCstate"];
			
			$where = "WHERE  PCODE != 'null' ";

			if($repoWindFarm != ""){$where .= "AND WFARM LIKE '%$repoWindFarm%'";} 
			if($repoOrderNum != ""){$where .= "AND QCODE LIKE '%$repoOrderNum%'";} 
			if($repoCategory != ""){$where .= "AND G4 LIKE '%$repoCategory%'";} 
			if($repoJob != ""){$where .= "AND JOB LIKE '%$repoJob%'";} 
			if($repoDetails != ""){$where .= "AND DETAIL LIKE '%$repoDetails%'";} 
			if($repoPlatform != ""){$where .= "AND PLATFORM = '$repoPlatform'";} 
			if($repoStatus != "")
			{
				if($repoStatus == "0")
				{
					$where .= "AND CLOSD =  ''";
				}
				if($repoStatus == "1")
				{
					$where .= "AND CLOSD !=  ''";
				}
			} 
			if($repoCstate != ""){$where .= "AND CSTATE = '$repoCstate'";} 
			if($repoIniDate != ""){$where .= "AND INIDATE >=  '$repoIniDate' ";} 
			if($repoEndDate != ""){$where .= "AND INIDATE <=  '$repoEndDate' ";} 
			
			$str = "SELECT * FROM projects $where ORDER BY INIDATE DESC";
			$projects = $this->db->query($str);
			$cFiltered = array();
			
			for($i=0; $i<count($projects); $i++)
			{
				$item = $projects[$i];
				$dpkc = array();
				$dpkc["code"] = $item["QCODE"];
				$dpkc["pcode"] = $item["PCODE"];
				$odataP = $this-> oGetP($dpkc)["message"];
				$client = $odataP["CLIENT"];
				
						
				// GET PROGRAMED MOB, LABOR
				
				$laborP = $odataP["LABORP"];
				$laborE = $odataP["LABORE"];
				$mobP = $odataP["MOBP"];
				$mobE = $odataP["MOBE"];
				
				$standByE = $odataP["STANDBYE"];
				$ncE = $odataP["NCE"];
				$osE = $odataP["OSE"];
				$district = $odataP["DISTRICT"];
				
				
				$laborE_S = $odataP["LABORE_S"];
				$laborE_C = $odataP["LABORE_C"];
				
				
				$mobE_S = $odataP["MOBE_S"];
				$mobE_C = $odataP["MOBE_C"];

				$standByE_S = $odataP["STANDBYE_S"];
				$standByE_C = $odataP["STANDBYE_C"];
				
				$ncE_S = $odataP["NCE_S"];
				$ncE_C = $odataP["NCE_C"];

				$osE_S = $odataP["OSE_S"];
				$osE_C = $odataP["OSE_C"];
				
				
				
				
				$projects[$i]["CLIENT"] = $client;
				$projects[$i]["MOBP"] = $mobP;
				$projects[$i]["LABORP"] = $laborP;
				$projects[$i]["MOBE"] = $mobE;
				$projects[$i]["LABORE"] = $laborE;
				$projects[$i]["STANDBYE"] = $standByE;
				$projects[$i]["NCE"] = $ncE;
				$projects[$i]["OSE"] = $osE;
				$projects[$i]["DISTRICT"] = $district;
				$projects[$i]["LABORE_S"] = $laborE_S;
				$projects[$i]["LABORE_C"] = $laborE_C;
				$projects[$i]["MOBE_S"] = $mobE_S;
				$projects[$i]["MOBE_C"] = $mobE_C;
				$projects[$i]["STANDBYE_S"] = $standByE_S;
				$projects[$i]["STANDBYE_C"] = $standByE_C;
				$projects[$i]["NCE_S"] = $ncE_S;
				$projects[$i]["NCE_C"] = $ncE_C;
				$projects[$i]["OSE_S"] = $osE_S;
				$projects[$i]["OSE_C"] = $osE_C;
				
				
				
				

				if($repoClient != "")
				{
					if (strpos(strtoupper($client), strtoupper($repoClient)) === FALSE){}
					else{array_push($cFiltered, $projects[$i]);}
				}
			}
			if($repoClient != ""){$projects = $cFiltered;}

			$result = $projects;

			// HEADER TITLE
			
			if($repoIniDate != ""){$inidate = $repoIniDate;}
			else{$inidate = "Open";}
			
			if($repoEndDate != ""){$enddate = $repoEndDate;}
			else{$enddate = "Open";}
			
			$dateRange = "from: " .$inidate. " to ". $enddate;
			
			
			$sheet->setCellValue('A1', 'General Aftermarket report ' . $dateRange);
			$sheet->getStyle("A1")->getFont()->setBold(true);
			$sheet->mergeCells('A1:N1');

			// TITLES LINE 1
			
			$c = 3;
			
			$sheet->getStyle("A$c:AJ$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:AJ$c")->getFont()->setBold(true);
			$sheet->getStyle("A$c:AJ$c")->applyFromArray($alignCenter);
			$sheet->getStyle("A$c:AJ$c")->applyFromArray($grayBg);


			
			$sheet->setCellValue("A$c", "Quote num");
			$sheet->setCellValue("B$c", "Client");
			$sheet->setCellValue("C$c", "Wind Farm");
			$sheet->setCellValue("D$c", "Category");
			$sheet->setCellValue("E$c", "Job type");
			$sheet->setCellValue("F$c", "Type of work");
			$sheet->setCellValue("G$c", "Platform");
			$sheet->setCellValue("H$c", "Serie");
			$sheet->setCellValue("I$c", "Model");
			$sheet->setCellValue("J$c", "Project details");
			$sheet->setCellValue("K$c", "Quote labor");
			$sheet->setCellValue("L$c", "Executed labor");
			$sheet->setCellValue("M$c", "Labor SGRE+Contractor");
			$sheet->setCellValue("N$c", "Labor SGRE");
			$sheet->setCellValue("O$c", "Labor Contractor");
			$sheet->setCellValue("P$c", "Quote Mob");
			$sheet->setCellValue("Q$c", "Executed Mob");
			$sheet->setCellValue("R$c", "Mob SGRE+Contractor");
			$sheet->setCellValue("S$c", "Mob SGRE");
			$sheet->setCellValue("T$c", "Mob Contractor");
			$sheet->setCellValue("U$c", "Standby SGRE+Contractor");
			$sheet->setCellValue("V$c", "Standby SGRE");
			$sheet->setCellValue("W$c", "Standby Contractor");
			$sheet->setCellValue("X$c", "No Conformity SGRE+Contractor");
			$sheet->setCellValue("Y$c", "No Conformity SGRE");
			$sheet->setCellValue("Z$c", "No Conformity Contractor");
			$sheet->setCellValue("AA$c", "Out of scope SGRE+Contractor");
			$sheet->setCellValue("AB$c", "Out of scope SGRE");
			$sheet->setCellValue("AC$c", "Out of scope Contractor");
			
			
			$sheet->setCellValue("AD$c", "Service Order");
			$sheet->setCellValue("AE$c", "Cost Order");
			$sheet->setCellValue("AF$c", "District");
			$sheet->setCellValue("AG$c", "Initial date");
			$sheet->setCellValue("AH$c", "Close date");
			$sheet->setCellValue("AI$c", "Close details");
			$sheet->setCellValue("AJ$c", "Close status");
			

			$c++;
			
			$totalLabP = 0;
			$totalLabE = 0;
			$totalMobP = 0;
			$totalMobE = 0;
			$totalStandby = 0;
			$totalNc = 0;
			$totalOsc = 0;
			
			for($i = 0; $i<count($projects);$i++)
			{
				$item = $projects[$i];
				
				
				$lbP = floatval($item["LABORP"]);
				$lbE = floatval($item["LABORE"]);
				
				if($lbP <= 0)
				{
					$resultLabor = 0;
				}
				else
				{	
					$resultLabor = $lbE/$lbP;
				}
				
				$mobP = floatval($item["MOBP"]);
				$mobE = floatval($item["MOBE"]);
				
				if($mobP <= 0)
				{
					$resultMob = 0;
				}
				else
				{	
					$resultMob = $mobE/$mobP;
				}


				$sheet->setCellValue("A$c",  $item["QCODE"]);
				$sheet->setCellValue("B$c",  $item["CLIENT"]);
				$sheet->setCellValue("C$c",  $item["WFARM"]);
				$sheet->setCellValue("D$c",  $item["G4"]);
				$sheet->setCellValue("E$c",  $item["JOB"]);
				$sheet->setCellValue("F$c",  $item["TOW"]);
				$sheet->setCellValue("G$c",  $item["TPLAT"]);
				$sheet->setCellValue("H$c",  $item["TSERIE"]);
				$sheet->setCellValue("I$c",  $item["PLATFORM"]);
				$sheet->setCellValue("J$c",  $item["DETAIL"]);
				$sheet->setCellValue("K$c",  $item["LABORP"]);
				$sheet->setCellValue("L$c",  floatval($item["LABORE"])-floatval($item["LABORP"]));
				$sheet->setCellValue("M$c",  $item["LABORE"]);
				$sheet->setCellValue("N$c",  $item["LABORE_S"]);
				$sheet->setCellValue("O$c",  $item["LABORE_C"]);
				$sheet->setCellValue("P$c",  $item["MOBP"]);
				$sheet->setCellValue("Q$c",  $item["MOBE"]);
				$sheet->setCellValue("R$c",  floatval($item["MOBE"])-floatval($item["MOBP"]));
				$sheet->setCellValue("S$c",  $item["MOBE_S"]);
				$sheet->setCellValue("T$c",  $item["MOBE_C"]);
				$sheet->setCellValue("U$c",  $item["STANDBYE"]);
				$sheet->setCellValue("V$c",  $item["STANDBYE_S"]);
				$sheet->setCellValue("W$c",  $item["STANDBYE_C"]);
				$sheet->setCellValue("X$c",  $item["NCE"]);
				$sheet->setCellValue("Y$c",  $item["NCE_S"]);
				$sheet->setCellValue("Z$c",  $item["NCE_C"]);
				$sheet->setCellValue("AA$c",  $item["OSE"]);
				$sheet->setCellValue("AB$c",  $item["OSE_S"]);
				$sheet->setCellValue("AC$c",  $item["OSE_C"]);
				$sheet->setCellValue("AD$c",  $item["SO"]);
				$sheet->setCellValue("AE$c",  $item["CO"]);
				$sheet->setCellValue("AF$c",  $item["DISTRICT"]);
				$sheet->setCellValue("AG$c",  $item["INIDATE"]);
				$sheet->setCellValue("AH$c",  $item["CLOSD"]);
				$sheet->setCellValue("AI$c",  $item["CLDETAIL"]);
				$sheet->setCellValue("AJ$c",  $item["CSTATE"]);
				
				
				
				$sheet->getStyle("A$c:AJ$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:AJ$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:AJ$c")->getFont()->setSize(9);
				
				$sheet->getStyle("A$c")->applyFromArray($alignCenter);
				$sheet->getStyle("O$c:AJ$c")->applyFromArray($alignCenter);
				// $sheet->getStyle("AC$c")->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));
				
				$totalLabP += floatval($item["LABORP"]);
				$totalLabE += floatval($item["LABORE"]);
				$totalMobP += floatval($item["MOBP"]);
				$totalMobE += floatval($item["MOBE"]);
				$totalStandby += floatval($item["STANDBYE"]);
				$totalNc += floatval($item["NCE"]);
				$totalOsc += floatval($item["OSE"]);

				$c++;
			}
			
			
			
			$sheet->getStyle("A$c:Z$c")->getFont()->setSize(10);
			$sheet->getStyle("O$c:Z$c")->applyFromArray($alignCenter);
			$sheet->getStyle("A$c:Z$c")->applyFromArray($grayBg);
			$sheet->getStyle("O$c:Z$c")->getNumberFormat()->setFormatCode('#,##0');


			$sheet->setCellValue("H$c",  $totalLabP);
			$sheet->setCellValue("I$c",  $totalLabE);
			$sheet->setCellValue("K$c",  $totalMobP);
			$sheet->setCellValue("L$c",  $totalMobE);
			$sheet->setCellValue("N$c",  $totalStandby);
			$sheet->setCellValue("O$c",  $totalNc);
			$sheet->setCellValue("P$c",  $totalOsc);

			
			
			// ------------------FILE CREATE-------------------
			$fname = "General Aftermarket ".$now.".xls";
		}
		
		if($repoType == "accessUse")
		{
			$repoWindFarm = $info["repoWindFarm"];
			$repoAccess = $info["repoAccess"];
			$repoIniDate = $info["repoIniDate"];
			$repoEndDate = $info["repoEndDate"];
			
			$where = "WHERE  TYPE = 'A' AND LABOR != '0'";

			if($repoAccess != ""){$where .= "AND NAME LIKE '%$repoAccess%'";} 
			if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
			if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 
			
			$str = "SELECT dayItems.*, days.DATE, days.AMOBS FROM dayItems LEFT JOIN days ON dayItems.DCODE = days.DCODE $where ORDER BY QCODE DESC";
			$auses = $this->db->query($str);
			$cFiltered = array();
			
			// $resp["message"] = $auses;
			// $resp["status"] = true;
			// return $resp;
			
			for($i=0; $i<count($auses); $i++)
			{
				$item = $auses[$i];
				$dpkc = array();
				$dpkc["dcode"] = $item["DCODE"];
				$dpkc["qcode"] = $item["QCODE"];
				$dAccData = $this-> dAccessData($dpkc)["message"];
				
				$windfarm = $dAccData["WFARM"];
				$auses[$i]["WFARM"] = $windfarm;

				if($repoWindFarm != "")
				{
					if (strpos(strtoupper($windfarm), strtoupper($repoWindFarm)) === FALSE){}
					else{array_push($cFiltered, $auses[$i]); continue;}
				}
			}
			if($repoWindFarm != ""){$auses = $cFiltered;}

			$result = $auses;

			// HEADER TITLE
			
			if($repoIniDate != ""){$inidate = $repoIniDate;}
			else{$inidate = "Open";}
			
			if($repoEndDate != ""){$enddate = $repoEndDate;}
			else{$enddate = "Open";}
			
			$dateRange = "from: " .$inidate. " to ". $enddate;
			
			
			$sheet->setCellValue('A1', 'Added Cost use report ' . $dateRange);
			$sheet->getStyle("A1")->getFont()->setBold(true);
			$sheet->mergeCells('A1:N1');

			// TITLES LINE 1
			
			$c = 3;
			
			$sheet->getStyle("A$c:G$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:G$c")->getFont()->setBold(true);
			$sheet->getStyle("A$c:G$c")->applyFromArray($alignCenter);
			$sheet->getStyle("A$c:G$c")->applyFromArray($grayBg);
			
			$sheet->setCellValue("A$c", "Windfarm");
			$sheet->setCellValue("B$c", "Date");
			$sheet->setCellValue("C$c", "Added Cost type");
			$sheet->setCellValue("D$c", "Comments");
			$sheet->setCellValue("E$c", "Cost order");
			$sheet->setCellValue("F$c", "Service order");
			$sheet->setCellValue("G$c", "Quote");


			$c++;
			
			$totalLabP = 0;
			
			for($i = 0; $i<count($auses);$i++)
			{
				$item = $auses[$i];


				$sheet->setCellValue("A$c",  $item["WFARM"]);
				$sheet->setCellValue("B$c",  $item["DATE"]);
				$sheet->setCellValue("C$c",  $item["NAME"]);
				$sheet->setCellValue("D$c",  $item["AMOBS"]);
				$sheet->setCellValue("E$c",  $item["CO"]);
				$sheet->setCellValue("F$c",  $item["SO"]);
				$sheet->setCellValue("G$c",  $item["QCODE"]);

				$sheet->getStyle("A$c:G$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:G$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:G$c")->getFont()->setSize(9);
				
				$c++;
			}
			
			
			// ------------------FILE CREATE-------------------
			$fname = "Added Cost use report ".$now.".xls";
		}
		
		if($repoType == "techBench")
		{
			$repoTechName = $info["repoTechName"];
			$repoIniDate = $info["repoIniDate"];
			$repoEndDate = $info["repoEndDate"];
			
			$where = "WHERE  SCHCODE != '' ";

			if($repoTechName != ""){$where .= "AND TNAME LIKE '%$repoTechName%'";} 
			if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
			if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate' ";} 
			
			$str = "SELECT DATE, DETAIL, POSITION, TNAME, TYPE FROM schedule $where ORDER BY TNAME ASC";
			$auses = $this->db->query($str);

			// HEADER TITLE
			
			if($repoIniDate != ""){$inidate = $repoIniDate;}
			else{$inidate = "Open";}
			
			if($repoEndDate != ""){$enddate = $repoEndDate;}
			else{$enddate = "Open";}
			
			$dateRange = "from: " .$inidate. " to ". $enddate;
			
			
			$sheet->setCellValue('A1', 'Specialist Schedule by User' . $dateRange);
			$sheet->getStyle("A1")->getFont()->setBold(true);
			$sheet->mergeCells('A1:N1');

			// TITLES LINE 1
			
			$c = 3;
			
			$sheet->getStyle("A$c:E$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:E$c")->getFont()->setBold(true);
			$sheet->getStyle("A$c:E$c")->applyFromArray($alignCenter);
			$sheet->getStyle("A$c:E$c")->applyFromArray($grayBg);
			
			$sheet->setCellValue("A$c", "Date");
			$sheet->setCellValue("B$c", "User");
			$sheet->setCellValue("C$c", "Position");
			$sheet->setCellValue("D$c", "Comments");
			$sheet->setCellValue("E$c", "Type");


			$c++;
			
			$totalLabP = 0;
			
			for($i = 0; $i<count($auses);$i++)
			{
				$item = $auses[$i];


				$sheet->setCellValue("A$c",  $item["TNAME"]);
				$sheet->setCellValue("B$c",  $item["DATE"]);
				$sheet->setCellValue("C$c",  $item["POSITION"]);
				$sheet->setCellValue("D$c",  $item["DETAIL"]);
				$sheet->setCellValue("E$c",  $item["TYPE"]);

				$sheet->getStyle("A$c:E$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:E$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:E$c")->getFont()->setSize(9);
				
				$c++;
			}
			
			
			// ------------------FILE CREATE-------------------
			$fname = "Specialist Schedule by user report ".$now.".xls";
		}
		
		if($repoType == "techHours")
		{
			$repoTechName = $info["repoTechName"];
			$repoIniDate = $info["repoIniDate"];
			$repoEndDate = $info["repoEndDate"];
			
			$where = "WHERE  dayItems.TYPE = 'L' ";

			if($repoTechName != ""){$where .= "AND dayItems.NAME LIKE '%$repoTechName%'";} 
			if($repoIniDate != ""){$where .= "AND days.DATE >=  '$repoIniDate' ";} 
			if($repoEndDate != ""){$where .= "AND days.DATE <=  '$repoEndDate' ";} 
			
			$str = "SELECT dayItems.NAME, dayItems.QCODE, dayItems.ACODE, dayItems.RESPONSIBLE, sum(dayItems.MIMO) AS MIMO, sum(dayItems.LABOR) AS LABOR, sum(dayItems.STANDBY) AS STANDBY, sum(dayItems.NC) AS NC, sum(dayItems.OUS) AS OUS FROM dayItems LEFT JOIN days ON dayItems.DCODE = days.DCODE $where GROUP BY dayItems.QCODE  ORDER BY dayItems.NAME DESC";
			$auses = $this->db->query($str);

			// HEADER TITLE
			
			if($repoIniDate != ""){$inidate = $repoIniDate;}
			else{$inidate = "Open";}
			
			if($repoEndDate != ""){$enddate = $repoEndDate;}
			else{$enddate = "Open";}
			
			$dateRange = "from: " .$inidate. " to ". $enddate;
			
			
			$sheet->setCellValue('A1', 'Project Hours by User/Company report ' . $dateRange);
			$sheet->getStyle("A1")->getFont()->setBold(true);
			$sheet->mergeCells('A1:N1');

			// TITLES LINE 1
			
			$c = 3;
			
			$sheet->getStyle("A$c:J$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:J$c")->getFont()->setBold(true);
			$sheet->getStyle("A$c:J$c")->applyFromArray($alignCenter);
			$sheet->getStyle("A$c:J$c")->applyFromArray($grayBg);
			
			$sheet->setCellValue("A$c", "User");
			$sheet->setCellValue("B$c", "Labor");
			$sheet->setCellValue("C$c", "Mob in/out");
			$sheet->setCellValue("D$c", "Standby");
			$sheet->setCellValue("E$c", "NC");
			$sheet->setCellValue("F$c", "Out of scope");
			$sheet->setCellValue("G$c", "Quote");
			$sheet->setCellValue("H$c", "Responsible");
			$sheet->setCellValue("I$c", "Company");
			$sheet->setCellValue("J$c", "Windfarm");
			


			$c++;
			
			$totalLabP = 0;
			
			for($i = 0; $i<count($auses);$i++)
			{
				$item = $auses[$i];


				$sheet->setCellValue("A$c",  $item["NAME"]);
				$sheet->setCellValue("B$c",  $item["LABOR"]);
				$sheet->setCellValue("C$c",  $item["MIMO"]);
				$sheet->setCellValue("D$c",  $item["STANDBY"]);
				$sheet->setCellValue("E$c",  $item["NC"]);
				$sheet->setCellValue("F$c",  $item["OUS"]);
				$sheet->setCellValue("G$c",  $item["QCODE"]);
				$sheet->setCellValue("H$c",  $item["RESPONSIBLE"]);
				
				$dpkc = array();
				$dpkc["quote"] = $item["QCODE"];
				$quoteData = $this-> getQuoteData($dpkc)["message"][0];
				
				$windfarm  = $quoteData["WFARM"];
				$sheet->setCellValue("J$c",  $windfarm);
				
				$dpkc = array();
				$dpkc["acode"] = $item["ACODE"];
				$laborData = $this-> getLaborData($dpkc)["message"][0];
				
				$cname  = $laborData["CNAME"];
				$sheet->setCellValue("I$c",  $cname);
				

				$sheet->getStyle("A$c:J$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:J$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:J$c")->getFont()->setSize(9);
				
				$c++;
			}
			
			
			// ------------------FILE CREATE-------------------
			$fname = "Project Hours by user report ".$now.".xls";
		}
		
		if($repoType == "labHours")
		{
			$repoTechName = $info["repoTechName"];
			$repoIniDate = $info["repoIniDate"];
			$repoEndDate = $info["repoEndDate"];
			
			$where = "WHERE  sessions.CODE != '' ";

			if($repoTechName != ""){$where .= "AND users.CNAME LIKE '%$repoTechName%'";} 
			if($repoIniDate != ""){$where .= "AND sessions.DATE >=  '$repoIniDate' ";} 
			if($repoEndDate != ""){$where .= "AND sessions.DATE <=  '$repoEndDate' ";} 
			
			$str = "SELECT users.CNAME, sessions.WBS, sessions.HOURS, sessions.DATE, sessions.CO, sessions.SO, sessions.TYPE, users.uPos, users.uGID, users.uGTI FROM sessions LEFT JOIN users ON sessions.TECH = users.CODE $where  ORDER BY users.CNAME ASC, sessions.DATE ASC";
			$sessions = $this->db->query($str);
			
			// $resp["message"] = $sessions;
			// $resp["status"] = true;
			// return $resp;

			// HEADER TITLE
			
			if($repoIniDate != ""){$inidate = $repoIniDate;}
			else{$inidate = "Open";}
			
			if($repoEndDate != ""){$enddate = $repoEndDate;}
			else{$enddate = "Open";}
			
			$dateRange = "from: " .$inidate. " to ". $enddate;
			
			
			$sheet->setCellValue('A1', 'Specialist Schedule Labor Hours by user report ' . $dateRange);
			$sheet->getStyle("A1")->getFont()->setBold(true);
			$sheet->mergeCells('A1:N1');

			// TITLES LINE 1
			
			$c = 3;
			
			$sheet->getStyle("A$c:J$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:J$c")->getFont()->setBold(true);
			$sheet->getStyle("A$c:J$c")->applyFromArray($alignCenter);
			$sheet->getStyle("A$c:J$c")->applyFromArray($grayBg);
			
			$sheet->setCellValue("A$c", "User");
			$sheet->setCellValue("B$c", "Position");
			$sheet->setCellValue("C$c", "GID");
			$sheet->setCellValue("D$c", "Gammesa tech Id");
			$sheet->setCellValue("E$c", "WBS");
			$sheet->setCellValue("F$c", "Hours");
			$sheet->setCellValue("G$c", "Date");
			$sheet->setCellValue("H$c", "Cost order");
			$sheet->setCellValue("I$c", "Service order");
			$sheet->setCellValue("J$c", "Session type");
			

			$c++;
			
			$totalLabP = 0;
			
			for($i = 0; $i<count($sessions);$i++)
			{
				$item = $sessions[$i];

	
				$sheet->setCellValue("A$c",  $item["CNAME"]);
				$sheet->setCellValue("B$c",  $item["uPos"]);
				$sheet->setCellValue("C$c",  $item["uGID"]);
				$sheet->setCellValue("D$c",  $item["uGTI"]);
				$sheet->setCellValue("E$c",  $item["WBS"]);
				$sheet->setCellValue("F$c",  $item["HOURS"]);
				$sheet->setCellValue("G$c",  $item["DATE"]);
				$sheet->setCellValue("H$c",  $item["CO"]);
				$sheet->setCellValue("I$c",  $item["SO"]);
				
				if($item["TYPE"] == "NPR"){$type = "NON PRODUCTIVE";}
				if($item["TYPE"] == "OTH"){$type = "OTHER";}
				if($item["TYPE"] == "PRJ"){$type = "PROJECT";}
				if($item["TYPE"] == "PTO"){$type = "PTO";}
				if($item["TYPE"] == "R&R"){$type = "R&R";}
				if($item["TYPE"] == "TRN"){$type = "TRAINING";}
				if($item["TYPE"] == "HOL"){$type = "HOLIDAY";}
				if($item["TYPE"] == "TVL"){$type = "TRAVEL DAY";}
				
				
				
				$sheet->setCellValue("J$c", $type);

				// $dpkc = array();
				// $dpkc["quote"] = $item["QCODE"];
				// $quoteData = $this-> getQuoteData($dpkc)["message"][0];
				
				// $windfarm  = $quoteData["WFARM"];
				// $sheet->setCellValue("H$c",  $windfarm);
				
				$sheet->getStyle("D$c:J$c")->applyFromArray($alignCenter);
				$sheet->getStyle("A$c:J$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:C$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:J$c")->getFont()->setSize(9);
				
				$c++;
			}


			// ------------------FILE CREATE-------------------
			$fname = "Specialist Schedule Labor Hours by user report ".$now.".xls";
		}
		
		if($repoType == "projectHours")
		{
			$repoProject = $info["repoProject"];
			$repoIniDate = $info["repoIniDate"];
			$repoEndDate = $info["repoEndDate"];
			$repoWindFarm = $info["repoWindFarm"];
			
			if($repoProject != ""){$where = "WHERE  QCODE = '".$repoProject."' ";}
			else{$where = "WHERE  QCODE != '' ";}
	
			if($repoIniDate != ""){$where .= "AND DATE >=  '$repoIniDate' ";} 
			if($repoEndDate != ""){$where .= "AND DATE <=  '$repoEndDate'";} 
			if($repoWindFarm != ""){$wfarm = $repoWindFarm;}
			else{$wfarm = "";}
			
			$str = "SELECT *  FROM days $where ORDER BY QCODE DESC, DATE ASC";
			$days = $this->db->query($str);
			
			// $resp["message"] = $days;
			// $resp["status"] = true;
			// return $resp;
			
			$c = 1;
			
			// HEADER TITLE
				
			if($repoProject != "")
			{	
				$dpkc = array();
				$dpkc["qcode"] = $repoProject;
				$progress = $this-> getProgress($dpkc)["message"];
				
				$sheet->setCellValue("A$c", "Project report for quote: ".$repoProject." - Completed: ".$progress."%");
				$sheet->mergeCells("A$c:H$c");
			
				$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
				$sheet->getStyle("I$c:N$c")->getFont()->setSize(9);
				$sheet->setCellValue("I$c", "Turbines");
				$sheet->setCellValue("J$c", "Mob In/Out");
				$sheet->setCellValue("K$c", "Labor");
				$sheet->setCellValue("L$c", "Standby");
				$sheet->setCellValue("M$c", "NC");
				$sheet->setCellValue("N$c", "Out of scope");
				$sheet->getStyle("I$c:N$c")->applyFromArray($grayBg);
				
				$c = 2;
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
				$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
				
				$sheet->mergeCells("G$c:H$c");
				$sheet->setCellValue("G$c", "Project Totals");
				$sheet->getStyle("I$c:N$c")->applyFromArray($borderB);

				// GET PQDATA
				$str = "SELECT *  FROM projects WHERE QCODE = '".$repoProject."'";
				$qdata = $this->db->query($str)[0];
				
				$subH = "Project state: ";
				
				if($qdata["CLOSD"] != ""){$subH.= "Closed on ".$qdata["CLOSD"];}
				else{$subH.= "Open";}
				
				$sheet->setCellValue("A2", $subH);
				
				$dpkc = array();
				$dpkc["qcode"] = $repoProject;
				$pTotals = $this-> getPtotals($dpkc)["message"];
				
				$total0 = $pTotals["total0"];
				$total1 = $pTotals["total1"];
				$total2 = $pTotals["total2"];
				$total3 = $pTotals["total3"];
				$total4 = $pTotals["total4"];
				$total5 = $pTotals["total5"];
				
				$sheet->getStyle("I2:N2")->applyFromArray($alignLeft);
				$sheet->setCellValue("I2",  $total0);
				$sheet->setCellValue("J2",  $total1);
				$sheet->setCellValue("K2",  $total2);
				$sheet->setCellValue("L2",  $total3);
				$sheet->setCellValue("M2",  $total4);
				$sheet->setCellValue("N2",  $total5);
			}
			else
			{
				
				if($repoIniDate == ""){$repoIniDate = "Open";}
				if($repoEndDate == ""){$repoEndDate = "Open";}
				
				$sheet->setCellValue("A$c", "Hours by project report from: ".$repoIniDate." - to: ".$repoEndDate);
				
			}
			
			
			// HEADER TITLE END -----------------------------
			
			$allDayItemsL = array();
			
			for($d = 0; $d<count($days);$d++)
			{
				$day = $days[$d];

				$dcode = $day["DCODE"];
				$str = "SELECT *  FROM days WHERE DCODE = '".$dcode."'";
				$dData = $this->db->query($str)[0];
				
				$dpkc = array();
				$dpkc["dcode"] = $dcode;
				$dpkc["ddate"] = $dData["DATE"];
				$dpkc["type"] = 'L';
				$dpkc["qcode"] = $dData["QCODE"];
				$dItemsL = $this-> getDayItems($dpkc)["message"];
				
				// ADD DATA TO EACH DAY
				
				for($di = 0; $di<count($dItemsL);$di++)
				{
					$dItemsL[$di]["DATE"] = $day["DATE"];
					$dItemsL[$di]["DOBS"] = $day["OBS"];
				}
				// ADD TO MAIN ARRAY
				$allDayItemsL = array_merge($allDayItemsL, $dItemsL);
			}
			
			$c = 4;
			
			$sheet->getStyle("A$c:W$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:W$c")->getFont()->setBold(true);
			$sheet->getStyle("A$c:W$c")->applyFromArray($alignCenter);
			$sheet->getStyle("A$c:W$c")->applyFromArray($grayBg);
			
			$sheet->setCellValue("A$c", "Responsible");
			$sheet->setCellValue("B$c", "Name");
			$sheet->setCellValue("C$c", "Company");
			$sheet->setCellValue("D$c", "Quote");
			$sheet->setCellValue("E$c", "Executed");
			$sheet->setCellValue("F$c", "Mob In/out");
			$sheet->setCellValue("G$c", "Details");
			$sheet->setCellValue("H$c", "Labor");
			$sheet->setCellValue("I$c", "Details");
			$sheet->setCellValue("J$c", "Stand by");
			$sheet->setCellValue("K$c", "Details");
			$sheet->setCellValue("L$c", "No Conformity");
			$sheet->setCellValue("M$c", "Details");
			$sheet->setCellValue("N$c", "Out of scope");
			$sheet->setCellValue("O$c", "Details");
			$sheet->setCellValue("P$c", "Date");
			$sheet->setCellValue("Q$c", "Service Order");
			$sheet->setCellValue("R$c", "Cost Order");
			$sheet->setCellValue("S$c", "Project");
			$sheet->setCellValue("T$c", "Windfarm");
			$sheet->setCellValue("U$c", "District");
			$sheet->setCellValue("V$c", "Category");
			$sheet->setCellValue("W$c", "Day Comments");
			$sheet->setCellValue("X$c", "GID");
			
			$c++;
			
			
			if($wfarm != "")
			{
				$picked = array();
				
				// GET DAYITEM WFARM ANS PUSH IF RIGHT 
				for($i = 0; $i<count($allDayItemsL);$i++)
				{
					$item = $allDayItemsL[$i];
					
					$dpkc = array();
					$dpkc["quote"] = $item["QCODE"];
					$windfarm = $this-> getQuoteWindfarm($dpkc)["message"][0]["WFARM"];
					
					if($windfarm == $wfarm){array_push($picked, $item);}
				}
				$allDayItemsL = $picked;
				
			}
			
			
			for($i = 0; $i<count($allDayItemsL);$i++)
			{
				$sheet->getStyle("A$c:V$c")->getFont()->setSize(9);
				$item = $allDayItemsL[$i];

				$sheet->setCellValue("A$c", $item["RESPONSIBLE"]);
				$sheet->setCellValue("B$c", $item["NAME"]);
				
				
				$dpkc = array();
				$dpkc["acode"] = $item["ACODE"];
				$laborData = $this-> getLaborData($dpkc)["message"][0];
				
				$cname  = $laborData["CNAME"];
				$sheet->setCellValue("C$c",  $cname);
				
				
				$sheet->setCellValue("D$c", $item["QUOTE"]);
				$sheet->setCellValue("E$c", $item["EXECUTED"]);
				$sheet->setCellValue("F$c", $item["MIMO"]);
				$sheet->setCellValue("G$c", $item["MIMOD"]);
				$sheet->setCellValue("H$c", $item["LABOR"]);
				$sheet->setCellValue("I$c", $item["LABORD"]);
				

				
				// $sheet->setCellValue("J$c", $item["STANDBY"]);
				// $sheet->setCellValue("K$c", $item["STANDBYD"]);
				
				// GET SB ITEMS
				// GET SB ITEMS
				// GET SB ITEMS
				
				
				
				if($item["STDARRAY"] != "")
				{
					$sbItems = json_decode($item["STDARRAY"], true);
					$add = 0;
					
					
					$tmpStbQty = 0;
					
					for($s = 0; $s<count($sbItems);$s++)
					{
						$reason = $sbItems[$s];
						$reasonDetail = $reason["REASON"];
						$reasonQty = $reason["VAL"];
						$tmpStbQty = $tmpStbQty+$reasonQty;
						
						if(floatval($reasonQty) > 0)
						{
							$pos = $c+$add;
							$sheet->setCellValue("K$pos",  $reasonDetail);
							$sheet->setCellValue("J$pos",  $reasonQty);
							
							$sheet->getStyle("A$pos:V$pos")->applyFromArray($borderB);
							$sheet->getStyle("A$pos:V$pos")->applyFromArray($alignLeft);
							$sheet->getStyle("A$pos:V$pos")->getFont()->setSize(9);
							$add++;
						}
					}
					if($tmpStbQty == 0)
					{
						$add = 1;
					}
				}
				else
				{
					$add = 1;
					$oldStb = $item["STANDBY"];
					$sheet->setCellValue("J$c",  $oldStb);
				}
				
				
				// GET SB ITEMS
				// GET SB ITEMS
				// GET SB ITEMS
				
				
				

				$sheet->setCellValue("L$c", $item["NC"]);
				$sheet->setCellValue("M$c", $item["NCD"]);
				$sheet->setCellValue("N$c", $item["OUS"]);
				$sheet->setCellValue("O$c", $item["OUSD"]);
				$sheet->setCellValue("P$c", $item["DATE"]);
				$sheet->setCellValue("Q$c", $item["SO"]);
				$sheet->setCellValue("R$c", $item["CO"]);
				$sheet->setCellValue("S$c", $item["QCODE"]);
				
				$dpkc = array();
				$dpkc["quote"] = $item["QCODE"];
				
				$windfarm = $this-> getQuoteWindfarm($dpkc)["message"];
				
				if(count($windfarm) > 0)
				{$windfarm = $windfarm[0]["WFARM"];}
				else
				{$windfarm = "-";}
				
				
				$dpkc = array();
				$dpkc["quote"] = $item["QCODE"];
				
				if(count($this->getProjectCatDist($dpkc)["message"]) > 0)
				{
					$district = $this-> getProjectCatDist($dpkc)["message"][0]["TURBINE"];
					$category = $this-> getProjectCatDist($dpkc)["message"][0]["G4"];
				}
				else
				{
					$district = "-";
					$category = "-";
				}
				
				
				
				
				$sheet->setCellValue("T$c", $windfarm);
				$sheet->setCellValue("U$c", $district);
				$sheet->setCellValue("V$c", $category);
				
				// GET TECH GID
				$dpkc = array();
				$dpkc["code"] = $item["UCODE"];
				
				$uGID = $this-> getUgid($dpkc)["message"];
				
				if(count($uGID) > 0)
				{
					$GID = $uGID[0]["uGID"];
				}
				else
				{
					$GID = "-";
				}
				
				
				
				
				
				$sheet->setCellValue("X$c", $GID);
				
				
				
				
				
				
				
				
				
				
				
				$obs = str_replace("<br>", "\n",$item["DOBS"]);
				
				
				// $fname  = str_replace('/', '_', $odata["CLIENT"])." - Quote Number ".$odata["ONUM"];
				
				$sheet->setCellValue("V$c", $obs);
				

				$c= $c+$add;
			}
				// ------------------FILE CREATE-------------------
			$fname = "Hours by project report ".$repoProject.".xls";
		}
		
		if($repoType == "generalPtype")
		{
			
			$repoClient = $info["repoClient"];
			$repoWindFarm = $info["repoWindFarm"];
			$repoStatus = $info["repoStatus"];
			$repoPlatform = $info["repoPlatform"];
			$repoJob = $info["repoJob"];
			$repoOrderNum = $info["repoOrderNum"];
			$repoCategory = $info["repoCategory"];
			$repoDetails = $info["repoDetails"];
			$repoIniDate = $info["repoIniDate"];
			$repoEndDate = $info["repoEndDate"];
			
			$where = "WHERE  PCODE != 'null' ";

			if($repoWindFarm != ""){$where .= "AND WFARM LIKE '%$repoWindFarm%'";} 
			if($repoOrderNum != ""){$where .= "AND QCODE LIKE '%$repoOrderNum%'";} 
			if($repoCategory != ""){$where .= "AND G4 LIKE '%$repoCategory%'";} 
			if($repoJob != ""){$where .= "AND JOB LIKE '%$repoJob%'";} 
			if($repoDetails != ""){$where .= "AND DETAIL LIKE '%$repoDetails%'";} 
			if($repoPlatform != ""){$where .= "AND PLATFORM = '$repoPlatform'";} 
			if($repoStatus != "")
			{
				if($repoStatus == "0")
				{
					$where .= "AND CLOSD =  ''";
				}
				if($repoStatus == "1")
				{
					$where .= "AND CLOSD !=  ''";
				}
			} 
			
			if($repoIniDate != ""){$where .= "AND INIDATE >=  '$repoIniDate' ";} 
			if($repoEndDate != ""){$where .= "AND INIDATE <=  '$repoEndDate' ";} 
			
			$str = "SELECT * FROM projects $where ORDER BY INIDATE DESC";
			$projects = $this->db->query($str);
			$cFiltered = array();
			
			for($i=0; $i<count($projects); $i++)
			{
				$item = $projects[$i];
				$dpkc = array();
				$dpkc["code"] = $item["QCODE"];
				$dpkc["pcode"] = $item["PCODE"];
				$odataP = $this-> oGetP($dpkc)["message"];
				$client = $odataP["CLIENT"];
				
				// GET PROGRAMED MOB, LABOR
				$mobP = $odataP["MOBP"];
				$mobE = $odataP["MOBE"];
				$laborP = $odataP["LABORP"];
				$laborE = $odataP["LABORE"];
				$standByE = $odataP["STANDBYE"];
				$ncE = $odataP["NCE"];
				$osE = $odataP["OSE"];
				$district = $odataP["DISTRICT"];
				
				$projects[$i]["CLIENT"] = $client;
				$projects[$i]["MOBP"] = $mobP;
				$projects[$i]["LABORP"] = $laborP;
				$projects[$i]["MOBE"] = $mobE;
				$projects[$i]["LABORE"] = $laborE;
				$projects[$i]["STANDBYE"] = $standByE;
				$projects[$i]["NCE"] = $ncE;
				$projects[$i]["OSE"] = $osE;
				$projects[$i]["DISTRICT"] = $district;

				if($repoClient != "")
				{
					if (strpos(strtoupper($client), strtoupper($repoClient)) === FALSE){}
					else{array_push($cFiltered, $projects[$i]);}
				}
			}
			if($repoClient != ""){$projects = $cFiltered;}

			$result = $projects;

			// HEADER TITLE
			
			if($repoIniDate != ""){$inidate = $repoIniDate;}
			else{$inidate = "Open";}
			
			if($repoEndDate != ""){$enddate = $repoEndDate;}
			else{$enddate = "Open";}
			
			$dateRange = "from: " .$inidate. " to ". $enddate;
			
			
			$sheet->setCellValue('A1', 'Standard & Specialty repairs jobs' . $dateRange);
			$sheet->getStyle("A1")->getFont()->setBold(true);
			$sheet->mergeCells('A1:N1');

			// TITLES LINE 1
			
			$c = 3;
			
			$sheet->getStyle("A$c:V$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:V$c")->getFont()->setBold(true);
			$sheet->getStyle("A$c:V$c")->applyFromArray($alignCenter);
			$sheet->getStyle("A$c:V$c")->applyFromArray($grayBg);
			
			$sheet->setCellValue("A$c", "Date from");
			$sheet->setCellValue("B$c", "Date to");
			$sheet->setCellValue("C$c", "Status");
			$sheet->setCellValue("D$c", "Quote num");
			$sheet->setCellValue("E$c", "Client");
			$sheet->setCellValue("F$c", "Windfarm");
			$sheet->setCellValue("G$c", "Job type");
			$sheet->setCellValue("H$c", "Quote type"); //standard/special
			$sheet->setCellValue("I$c", "Hours worked"); //ask
			$sheet->setCellValue("J$c", "Hours budget"); //ask
			$sheet->setCellValue("K$c", "Project details");
			$sheet->setCellValue("L$c", "Turbine quantity");
			$sheet->setCellValue("M$c", "Service Order");
			$sheet->setCellValue("N$c", "Cost Order");
			
			$c++;
			
			// $totalLabP = 0;
			// $totalLabE = 0;
			// $totalMobP = 0;
			// $totalMobE = 0;
			// $totalStandby = 0;
			// $totalNc = 0;
			// $totalOsc = 0;
			
			for($i = 0; $i<count($projects);$i++)
			{
				$item = $projects[$i];
				
				
				$lbP = floatval($item["LABORP"]);
				$lbE = floatval($item["LABORE"]);
				
				if($lbP <= 0){$resultLabor = 0;}
				else{$resultLabor = $lbE/$lbP;}
				
				$mobP = floatval($item["MOBP"]);
				$mobE = floatval($item["MOBE"]);
				
				if($mobP <= 0){$resultMob = 0;}
				else{$resultMob = $mobE/$mobP;}

				
				$sheet->setCellValue("A$c",  $item["INIDATE"]);
				$sheet->setCellValue("B$c",  $item["CLOSD"]);

				if($item["CLOSD"] != ""){$status = "Closed";}
				else{$status = "Open";}
				$sheet->setCellValue("C$c",  $status);

				$sheet->setCellValue("D$c",  $item["QCODE"]);
				$sheet->setCellValue("E$c",  $item["CLIENT"]);
				$sheet->setCellValue("F$c",  $item["WFARM"]);
				$sheet->setCellValue("G$c",  $item["JOB"]);
				
				$dpkc = array();
				$dpkc["quote"] = $item["QCODE"];
				$otype = $this-> getQuoteType($dpkc)["message"][0]["TYPE"];
				if($otype == "0"){$type = "Template";}
				else if($otype == "1"){$type = "Specialty repair";}
				else{$type = "Created from template";}
				
				$sheet->setCellValue("H$c",  $type);
				
				$sheet->setCellValue("I$c",  $item["LABORP"]);
				$sheet->setCellValue("J$c",  $item["LABORE"]);
				
				
				$sheet->setCellValue("K$c",  $item["DETAIL"]);
				
				$dpkc = array();
				$dpkc["quote"] = $item["QCODE"];
				$turbinesQty = count($this-> getQuoteTurbines($dpkc)["message"]);

				$sheet->setCellValue("L$c",  $turbinesQty);
				$sheet->setCellValue("M$c",  $item["SO"]);
				$sheet->setCellValue("N$c",  $item["CO"]);

				$sheet->getStyle("A$c:V$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:V$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:V$c")->getFont()->setSize(9);
				
				$sheet->getStyle("A$c")->applyFromArray($alignCenter);
				$sheet->getStyle("O$c:V$c")->applyFromArray($alignCenter);
				$sheet->getStyle("Y$c")->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));
				
				// $totalLabP += floatval($item["LABORP"]);
				// $totalLabE += floatval($item["LABORE"]);
				// $totalMobP += floatval($item["MOBP"]);
				// $totalMobE += floatval($item["MOBE"]);
				// $totalStandby += floatval($item["STANDBYE"]);
				// $totalNc += floatval($item["NCE"]);
				// $totalOsc += floatval($item["OSE"]);

				$c++;
			}
			
			// $sheet->getStyle("A$c:V$c")->getFont()->setSize(10);
			// $sheet->getStyle("O$c:V$c")->applyFromArray($alignCenter);
			// $sheet->getStyle("A$c:V$c")->applyFromArray($grayBg);
			// $sheet->getStyle("O$c:V$c")->getNumberFormat()->setFormatCode('#,##0');

			// $sheet->setCellValue("H$c",  $totalLabP);
			// $sheet->setCellValue("I$c",  $totalLabE);
			// $sheet->setCellValue("K$c",  $totalMobP);
			// $sheet->setCellValue("L$c",  $totalMobE);
			// $sheet->setCellValue("N$c",  $totalStandby);
			// $sheet->setCellValue("O$c",  $totalNc);
			// $sheet->setCellValue("P$c",  $totalOsc);

			
			
			// ------------------FILE CREATE-------------------
			$fname = "Standard - Specialty repairs jobs".$now.".xls";
		}
		
		
		$path = "../../excel/".$fname;
		$hasFile = file_exists($path);
		if($hasFile == true){unlink($path);}
		$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
		$objWriter->save($path );
		$fname = htmlEntities(utf8_decode($fname));


		$resp["message"] = $fname;
		$resp["status"] = true;
		return $resp;
	}
	function getQnums($info)
	{
		$str = "SELECT QCODE FROM projects ORDER BY QCODE DESC";
		$query = $this->db->query($str);

		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getQuoteData($info)
	{
		$quote = $info["quote"];
		
		
		$str = "SELECT * FROM projects WHERE QCODE = '".$quote."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getLaborData($info)
	{
		$code = $info["acode"];
		
		
		$str = "SELECT * FROM oactis WHERE CODE = '".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getQuoteWindfarm($info)
	{
		$quote = $info["quote"];
		
		
		$str = "SELECT WFARM FROM projects WHERE QCODE = '".$quote."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getProjectCatDist($info)
	{
		$quote = $info["quote"];
		
		
		$str = "SELECT TURBINE, G4  FROM projects WHERE QCODE = '".$quote."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getQuoteType($info)
	{
		$quote = $info["quote"];

		$str = "SELECT TYPE FROM orders WHERE ONUM = '".$quote."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function getQuoteTurbines($info)
	{
		$quote = $info["quote"];
		
		$str = "SELECT CODE FROM orders WHERE ONUM = '".$quote."'";
		$code = $this->db->query($str)[0]["CODE"];
		
		$str = "SELECT TNAME FROM turbines WHERE OCODE = '".$code."'";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function oGetP($info)
	{
		$code = $info["code"];
		$pcode = $info["pcode"];
		
		$ans = array();
		
		$str = "SELECT CODE, CLIENT, DISTRICT FROM orders WHERE ONUM = '".$code."'";
		$query = $this->db->query($str);
		$ocode = $query[0]["CODE"];
		$client = $query[0]["CLIENT"];
		$district = $query[0]["DISTRICT"];
		$ans["CLIENT"] = $client;
		$ans["DISTRICT"] = $district;
		
		// $str = "SELECT AQTY FROM oaccess WHERE OCODE = '".$ocode."'";
		// $query = $this->db->query($str);
		// $mobTotal = 0;
		// for($i=0; $i<count($query); $i++)
		// {
			// $item = $query[$i];
			// $add = floatval($item["AQTY"]);
			// $mobTotal += $add;
		// }
		// $ans["AMTP"] = $mobTotal;
		
		$str = "SELECT TIME, MIMOQ FROM oactis WHERE OCODE = '".$ocode."'";
		$query = $this->db->query($str);
		$laborTotal = 0;
		$mobTotal = 0;
		for($i=0; $i<count($query); $i++)
		{
			$item = $query[$i];
			$add = floatval($item["TIME"]);
			$laborTotal += $add;
			$add = floatval($item["MIMOQ"]);
			$mobTotal += $add;
		}
		$ans["LABORP"] = $laborTotal;
		$ans["MOBP"] = $mobTotal;
		
		
		// GET EXCECUTED MOB, LABOR, STANDBY, NC, OSC

		$str = "SELECT MIMO,LABOR,STANDBY,NC,OUS,STDARRAY,RESPONSIBLE FROM dayItems WHERE QCODE = '".$code."'";
		$query = $this->db->query($str);
		$mobTotalE = 0;
		$laborTotalE = 0;
		$standByTotalE = 0;
		$ncTotalE = 0;
		$osE = 0;
		
		
		$laborTotalE_S = 0;
		$laborTotalE_C = 0;
		
		$mobTotalE_S = 0;
		$mobTotalE_C = 0;
		
		$standByTotalE_S = 0;
		$standByTotalE_C = 0;
		
		$ncTotalE_S = 0;
		$ncTotalE_C = 0;
		
		$osE_S = 0;
		$osE_C = 0;
		
		for($i=0; $i<count($query); $i++)
		{
			$dayitem = $query[$i];
			
			if($dayitem["MIMO"] == ""){$dayitem["MIMO"] = 0;}
			if($dayitem["LABOR"] == ""){$dayitem["LABOR"] = 0;}


			// NEW STANDBY
			
			
			// TURN THIS IN THE NEW CLACULATION FOR STANDBY
			if($dayitem["STANDBY"] == ""){$dayitem["STANDBY"] = 0;}
			
			if(isset($dayitem["STDARRAY"]))
			{
				if($dayitem["STDARRAY"] != "")
				{
					$addS = 0;
					
					$sbItems = json_decode($dayitem["STDARRAY"], true);
					
					for($s = 0; $s<count($sbItems);$s++)
					{
						$reason = $sbItems[$s];
						$reasonQty = floatval($reason["VAL"]);
						$addS = $addS+$reasonQty;
					}

				}
				else
				{
					$addS = floatval($dayitem["STANDBY"]);
				}
			}
			else
			{
				$addS = floatval($dayitem["STANDBY"]);
			}
			
			
			if($dayitem["NC"] == ""){$dayitem["NC"] = 0;}
			if($dayitem["OUS"] == ""){$dayitem["OUS"] = 0;}
			
			
			$add = floatval($dayitem["MIMO"]);
			$mobTotalE += $add;
			
			$add = floatval($dayitem["LABOR"]);
			$laborTotalE += $add;
			
			$standByTotalE += $addS;
			
			$add = floatval($dayitem["NC"]);
			$ncTotalE += $add;
			
			$add = floatval($dayitem["OUS"]);
			$osE += $add;

			if($dayitem["RESPONSIBLE"] != "Contractor")
			{
				$laborTotalE_S += floatval($dayitem["LABOR"]);
				$mobTotalE_S += floatval($dayitem["MIMO"]);
				$standByTotalE_S += $addS;
				$ncTotalE_S += floatval($dayitem["NC"]);
				$osE_S += floatval($dayitem["OUS"]);
				
			}
			else
			{
				$laborTotalE_C += floatval($dayitem["LABOR"]);
				$mobTotalE_C += floatval($dayitem["MIMO"]);
				$standByTotalE_C += $addS;
				$ncTotalE_C += floatval($dayitem["NC"]);
				$osE_C += floatval($dayitem["OUS"]);
			}

		}
		
		
		
		$ans["MOBE"] = $laborTotalE;
		$ans["LABORE"] = $laborTotalE;
		$ans["STANDBYE"] = $standByTotalE;
		$ans["NCE"] = $ncTotalE;
		$ans["OSE"] = $osE;
		
		
		$ans["LABORE_S"] = $laborTotalE_S;
		$ans["LABORE_C"] = $laborTotalE_C;
		$ans["MOBE_S"] = $mobTotalE_S;
		$ans["MOBE_C"] = $mobTotalE_C;
		$ans["STANDBYE_S"] = $standByTotalE_S;
		$ans["STANDBYE_C"] = $standByTotalE_C;
		
		$ans["NCE_S"] = $ncTotalE_S;
		$ans["NCE_C"] = $ncTotalE_C;
		
		$ans["OSE_S"] = $osE_S;
		$ans["OSE_C"] = $osE_C;
		
		// GET EXCECUTED MOB, LABOR, STANDBY, NC, OSC

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function geTechList($info)
	{
		$str = "SELECT CODE, RESPNAME, TYPE FROM users WHERE TYPE != 'A' ORDER BY TYPE ASC";
		$query = $this->db->query($str);
		
		$ans = $query;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	function dAccessData($info)
	{
		$dcode = $info["dcode"];
		$qcode = $info["qcode"];
		
		$ans = array();

		$str = "SELECT WFARM  FROM projects WHERE QCODE = '".$qcode."'";
		$query = $this->db->query($str);
		if(count($query) > 0)
		{
			$ans["WFARM"] = $query[0]["WFARM"];
		}
		else
		{
			$ans["WFARM"] = "";
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
	function getPtotals($info)
	{
		$qcode = $info["qcode"];
		$ans = array();
		$str = "SELECT * FROM days WHERE QCODE = '".$qcode."' ORDER BY DATE ASC";
		$days = $this->db->query($str);
		
		$total0 = 0;
		$total1 = 0;
		$total2 = 0;
		$total3 = 0;
		$total4 = 0;
		$total5 = 0;
		
		$dcode = null;
		

		
		for($d = 0; $d<count($days);$d++)
		{
			$day = $days[$d];

			$dcode = $day["DCODE"];
			$str = "SELECT *  FROM days WHERE DCODE = '".$dcode."'";
			$dData = $this->db->query($str)[0];
			
			$dpkc = array();
			$dpkc["dcode"] = $dcode;
			$dpkc["ddate"] = $dData["DATE"];
			$dpkc["type"] = 'L';
			$dpkc["qcode"] = $dData["QCODE"];
			$dItemsL = $this-> getDayItems($dpkc)["message"];

			// TABLE TECHS 
			
			$t1 = 0;
			$t2 = 0;
			$t3 = 0;
			$t4 = 0;
			$t5 = 0;
			
			for($i = 0; $i<count($dItemsL);$i++)
			{
				$item = $dItemsL[$i];
				
				if($item["STDARRAY"] != null and $item["STDARRAY"] != "" and $item["STDARRAY"] != "null")
				{
					$sbItems = json_decode($item["STDARRAY"], true);
					$add = 0;
					$tmpStbQty = 0;
					
					for($s = 0; $s<count($sbItems);$s++)
					{
						$reason = $sbItems[$s];
						$reasonDetail = $reason["REASON"];
						$reasonQty = $reason["VAL"];
						$tmpStbQty = $tmpStbQty+$reasonQty;
					}
				}
				else
				{
					$oldStb = $item["STANDBY"];
					$tmpStbQty = floatval($oldStb);
				}

				$t1 = $t1+floatval($item["MIMO"]);
				$t2 = $t2+floatval($item["LABOR"]);
				$t3 = $t3+$tmpStbQty;
				$t4 = $t4+floatval($item["NC"]);
				$t5 = $t5+floatval($item["OUS"]);
			}
			
			$total1 = $total1+$t1;
			$total2 = $total2+$t2;
			$total3 = $total3+$t3;
			$total4 = $total4+$t4;
			$total5 = $total5+$t5;
			
		}
		
		if($dcode != null)
		{
			$dpkc = array();
			$dpkc["dcode"] = $dcode;
			$dpkc["ddate"] = $dData["DATE"];
			$dpkc["type"] = 'T';
			$dpkc["qcode"] = $dData["QCODE"];
			$dItemsT = $this-> getDayItems($dpkc)["message"];
		}
		else
		{
			$dItemsT = array();
		}

		$ans["total0"]  = count($dItemsT);
		$ans["total1"]  = $total1;
		$ans["total2"]  = $total2;
		$ans["total3"]  = $total3;
		$ans["total4"]  = $total4;
		$ans["total5"]  = $total5;

		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
	function downZip($info)
	{
		$ucode = $info["ucode"];
		$mode = $info["mode"];
		
		if($mode == "tr")
		{
			$str = "SELECT CODE, FILE FROM training WHERE UCODE = '".$ucode."' AND FILE != '' AND MTYPE = 'TR' ORDER BY ENDATE ASC";
			$trainings = $this->db->query($str);
			
			$str = "SELECT CNAME FROM users WHERE CODE = '".$ucode."'";
			$udata = $this->db->query($str)[0];
			
			$paths = array();
			
			$folder = "../../trfiles/trfiles ".$udata["CNAME"];
			
			$filename = "trfiles ".$udata["CNAME"];
			
			$hasFile = file_exists($folder);
			if($hasFile == true)
			{
				$files = glob($folder."/*"); foreach($files as $file){ if(is_file($file))unlink($file); }

				rmdir($folder);
				mkdir($folder, 0777, true);
			}
			else
			{
				mkdir($folder, 0777, true);
			}

			for($i = 0; $i<count($trainings);$i++)
			{
				$item = $trainings[$i];
				$origin = "../../trfiles/".$item["CODE"]."/".$item["FILE"];
				$destiny = "../../trfiles/"."trfiles ".$udata["CNAME"]."/".$item["FILE"];
				
				$hasFile = file_exists($folder);
				if($hasFile == true)
				{	
					copy($origin, $destiny);
				}
			}
			
			// DELETE ZIP IF EXIST
			$hasFile = file_exists($folder.'.zip');
			if($hasFile == true){unlink($folder.'.zip');}
			
			// Get real path for our folder
			$rootPath = realpath($folder);

			// Initialize archive object
			$zip = new ZipArchive();
			$zip->open($folder.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

			// Create recursive directory iterator
			/** @var SplFileInfo[] $files */
			$files = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($rootPath),
				RecursiveIteratorIterator::LEAVES_ONLY
			);

			foreach ($files as $name => $file)
			{
				// Skip directories (they would be added automatically)
				if (!$file->isDir())
				{
					// Get real and relative path for current file
					$filePath = $file->getRealPath();
					$relativePath = substr($filePath, strlen($rootPath) + 1);

					// Add current file to archive
					$zip->addFile($filePath, $relativePath);
				}
			}

			// Zip archive will be created only after closing object
			$zip->close();

		}
		if($mode == "pp")
		{
			$str = "SELECT CODE, FILE FROM training WHERE UCODE = '".$ucode."' AND FILE != '' AND MTYPE = 'PPE' ORDER BY ENDATE ASC";
			$trainings = $this->db->query($str);
			
			$str = "SELECT CNAME FROM users WHERE CODE = '".$ucode."'";
			$udata = $this->db->query($str)[0];
			
			$paths = array();
			
			$folder = "../../trfiles/PPEfiles ".$udata["CNAME"];
			
			$filename = "PPEfiles ".$udata["CNAME"];
			
			$hasFile = file_exists($folder);
			if($hasFile == true)
			{
				$files = glob($folder."/*"); foreach($files as $file){ if(is_file($file))unlink($file); }

				rmdir($folder);
				mkdir($folder, 0777, true);
			}
			else
			{
				mkdir($folder, 0777, true);
			}

			for($i = 0; $i<count($trainings);$i++)
			{
				$item = $trainings[$i];
				$origin = "../../trfiles/".$item["CODE"]."/".$item["FILE"];
				$destiny = "../../trfiles/"."PPEfiles ".$udata["CNAME"]."/".$item["FILE"];
				
				$hasFile = file_exists($folder);
				if($hasFile == true)
				{	
					copy($origin, $destiny);
				}
			}
			
			// DELETE ZIP IF EXIST
			
			$hasFile = file_exists($folder.'.zip');
			if($hasFile == true){unlink($folder.'.zip');}
			
			// Get real path for our folder
			$rootPath = realpath($folder);

			// Initialize archive object
			$zip = new ZipArchive();
			$zip->open($folder.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

			// Create recursive directory iterator
			/** @var SplFileInfo[] $files */
			$files = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($rootPath),
				RecursiveIteratorIterator::LEAVES_ONLY
			);

			foreach ($files as $name => $file)
			{
				// Skip directories (they would be added automatically)
				if (!$file->isDir())
				{
					// Get real and relative path for current file
					$filePath = $file->getRealPath();
					$relativePath = substr($filePath, strlen($rootPath) + 1);

					// Add current file to archive
					$zip->addFile($filePath, $relativePath);
				}
			}

			// Zip archive will be created only after closing object
			$zip->close();

		}
		
		
		// $ans = $query;
		
		$resp["message"] = $filename.".zip";
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
		
		$clearBg = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '778899')));
		
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
		
		if($type == "order")
		{

			$code = $info["ocode"];
			$uname = $info["uname"];
			
			$str = "SELECT * FROM orders WHERE CODE = '".$code."'";
			$order = $this->db->query($str);	
			
			$odata = $order[0];

			// HEADER TITLE
			
			$sheet->setCellValue('A1', 'Quote Data Resume'." - ".$odata["ONUM"]);
			$sheet->getStyle("A1")->getFont()->setBold(true);
			$sheet->mergeCells('A1:N1');

			// TITLES LINE 1
			
			$c = 3;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Client");
			$sheet->setCellValue("D$c", "Wind Farm");
			$sheet->setCellValue("G$c", "Address");
			$sheet->setCellValue("J$c", "Contact");
			$sheet->setCellValue("M$c", "Contact Phone");
			
			$sheet->mergeCells("A$c:C$c");
			$sheet->mergeCells("D$c:F$c");
			$sheet->mergeCells("G$c:I$c");
			$sheet->mergeCells("J$c:L$c");
			$sheet->mergeCells("M$c:N$c");
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
			
			$sheet->setCellValue("A$c", $odata["CLIENT"]);
			$sheet->setCellValue("D$c", $odata["WINDFARM"]);
			$sheet->setCellValue("G$c", $odata["ADDRESS"]);
			$sheet->setCellValue("J$c", $odata["CONTACT1"]);
			$sheet->setCellValue("M$c", $odata["PHONE1"]);
			
			$sheet->mergeCells("A$c:C$c");
			$sheet->mergeCells("D$c:F$c");
			$sheet->mergeCells("G$c:I$c");
			$sheet->mergeCells("J$c:L$c");
			$sheet->mergeCells("M$c:N$c");
			
			// TITLES LINE 2
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Internal Contact");
			$sheet->setCellValue("D$c", "Internal Phone");
			$sheet->setCellValue("G$c", "District");
			$sheet->setCellValue("J$c", "Turbine");
			$sheet->setCellValue("M$c", "Quote Status");
			
			$sheet->mergeCells("A$c:C$c");
			$sheet->mergeCells("D$c:F$c");
			$sheet->mergeCells("G$c:I$c");
			$sheet->mergeCells("J$c:L$c");
			$sheet->mergeCells("M$c:N$c");
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
			
			$status = "";
			
			$sheet->setCellValue("A$c", $odata["CONTACT2"]);
			$sheet->setCellValue("D$c", $odata["PHONE2"]);
			$sheet->setCellValue("G$c", $odata["DISTRICT"]);
			$sheet->setCellValue("J$c", $odata["TURBINE"]);
			if($odata["STATUS"] == "1"){$status = "New";}
			if($odata["STATUS"] == "2"){$status = "Approved";}
			if($odata["STATUS"] == "3"){$status = "Closed";}
			
			$sheet->setCellValue("M$c", $status);
			
			$sheet->mergeCells("A$c:C$c");
			$sheet->mergeCells("D$c:F$c");
			$sheet->mergeCells("G$c:I$c");
			$sheet->mergeCells("J$c:L$c");
			$sheet->mergeCells("M$c:N$c");
			
			// TITLES LINE 3
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Work Detail");
			$sheet->setCellValue("D$c", "Work Order");
			$sheet->setCellValue("G$c", "Service Order");
			$sheet->setCellValue("J$c", "Cost Order");
			$sheet->setCellValue("M$c", "Purchase Order");
			
			$sheet->mergeCells("A$c:C$c");
			$sheet->mergeCells("D$c:F$c");
			$sheet->mergeCells("G$c:I$c");
			$sheet->mergeCells("J$c:L$c");
			$sheet->mergeCells("M$c:N$c");
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
			
			$sheet->setCellValue("A$c", $odata["WKDETAIL"]);
			$sheet->setCellValue("D$c", $odata["WORKORDER"]);
			$sheet->setCellValue("G$c", $odata["SERVORDER"]);
			$sheet->setCellValue("J$c", $odata["COSTORDER"]);
			$sheet->setCellValue("M$c", $odata["PURCHASEORDER"]);
			
			$sheet->mergeCells("A$c:C$c");
			$sheet->mergeCells("D$c:F$c");
			$sheet->mergeCells("G$c:I$c");
			$sheet->mergeCells("J$c:L$c");
			$sheet->mergeCells("M$c:N$c");
			
			// HEADER LABORS
			
			$c++;
			$c++;
			
			$sheet->setCellValue("A$c", 'Labors');
			$sheet->getStyle("A$c")->getFont()->setBold(true);
			$sheet->mergeCells("A$c:N$c");
			
			$c++;
			$c++;
			
			// TABLE LABORS HEADERS
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Responsible");
			$sheet->setCellValue("C$c", "Price/Unit");
			$sheet->setCellValue("D$c", "Name");
			$sheet->setCellValue("F$c", "Company");
			$sheet->setCellValue("H$c", "Mob In/Out");
			$sheet->setCellValue("J$c", "Mob In/Out Qty");
			$sheet->setCellValue("K$c", "Description");
			$sheet->setCellValue("M$c", "Time/Hours");
			$sheet->setCellValue("N$c", "Subtotal");
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("D$c:E$c");
			$sheet->mergeCells("F$c:G$c");
			$sheet->mergeCells("H$c:I$c");
			$sheet->mergeCells("K$c:L$c");
			
			
			// TABLE LABORS 
			
			$c++;
			
			
			$dpkc = array();
			$dpkc["ocode"] = $code;
			$labors = $this-> getOActs($dpkc)["message"];
		
			$laborsCost = 0;
			$laborsTime = 0;
			
			for($i = 0; $i<count($labors);$i++)
			{
				$item = $labors[$i];

				$sheet->setCellValue("A$c",  $item["RESPTYPE"]);
				$sheet->setCellValue("C$c",  $item["UNITCOST"]);
				$sheet->setCellValue("D$c",  $item["RESPNAME"]);
				$sheet->setCellValue("F$c",  $item["CNAME"]);
				$sheet->setCellValue("H$c",  $item["MIMO"]);
				$sheet->setCellValue("J$c",  $item["MIMOQ"]);
				$sheet->setCellValue("K$c",  $item["ADESC"]);
				
				if($mode == "1")
				{
					$sheet->setCellValue("M$c",  $item["TIME"]);
					$subCost = (floatval($item["UNITCOST"])*floatval($item["TIME"]))+(floatval($item["MIMO"])*floatval($item["MIMOQ"]));
					$laborsTime += floatval ($item["TIME"]);
				}
				else
				{
					$sheet->setCellValue("M$c",  $item["TE"]);
					$subCost = (floatval($item["UNITCOST"])*floatval($item["TE"]))+(floatval($item["MIMO"])*floatval($item["MIMOQ"]));
					$laborsTime += floatval ($item["TE"]);
				}

				$sheet->setCellValue("N$c",  $subCost);

				$sheet->mergeCells("A$c:B$c");
				$sheet->mergeCells("D$c:E$c");
				$sheet->mergeCells("F$c:G$c");
				$sheet->mergeCells("H$c:I$c");
				$sheet->mergeCells("K$c:L$c");
				
				$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
				$sheet->getStyle("C$c")->getNumberFormat()->setFormatCode('#,##0.00');
				$sheet->getStyle("H$c")->getNumberFormat()->setFormatCode('#,##0.00');
				$sheet->getStyle("N$c")->getNumberFormat()->setFormatCode('#,##0.00');

				$laborsCost += $subCost;

				$c++;
			}
			
			// HEADER PARTS
			
			$c++;
			
			$sheet->setCellValue("A$c", 'Parts');
			$sheet->getStyle("A$c")->getFont()->setBold(true);
			$sheet->mergeCells("A$c:N$c");
			
			$c++;
			$c++;
			
			// TABLE PARTS HEADERS
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Part Number");
			$sheet->setCellValue("C$c", "Description");
			$sheet->setCellValue("F$c", "Cost/Unit");
			$sheet->setCellValue("H$c", "Vendor");
			$sheet->setCellValue("J$c", "Shipping");
			$sheet->setCellValue("L$c", "Quantity");
			$sheet->setCellValue("N$c", "Subtotal");
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:E$c");
			$sheet->mergeCells("F$c:G$c");
			$sheet->mergeCells("H$c:I$c");
			$sheet->mergeCells("J$c:K$c");
			$sheet->mergeCells("L$c:M$c");
			
			// TABLE PARTS 
			
			$c++;
			
			$str = "SELECT * FROM oparts WHERE OCODE = '".$code."'";
			$parts = $this->db->query($str);	
		
			$partsCost = 0;
			
			for($i = 0; $i<count($parts);$i++)
			{
				$item = $parts[$i];

				$sheet->setCellValue("A$c",  $item["PNUMBER"]);
				$sheet->setCellValue("C$c",  $item["PDESC"]);
				$sheet->setCellValue("F$c",  $item["PCOST"]);
				$sheet->setCellValue("H$c",  $item["PVENDOR"]);
				$sheet->setCellValue("J$c",  $item["PSHIPPING"]);
				
				if($mode == "1")
				{
					$sheet->setCellValue("L$c",  $item["PQTY"]);
					$subCost = (floatval($item["PCOST"])*floatval($item["PQTY"]))+floatval($item["PSHIPPING"]);
					
				}
				else
				{
					$sheet->setCellValue("L$c",  $item["ACTUAL"]);
					$subCost = (floatval($item["PCOST"])*floatval($item["ACTUAL"]))+floatval($item["PSHIPPING"]);
					
				}
				
				$sheet->setCellValue("N$c",  $subCost);

				$sheet->mergeCells("A$c:B$c");
				$sheet->mergeCells("C$c:E$c");
				$sheet->mergeCells("F$c:G$c");
				$sheet->mergeCells("H$c:I$c");
				$sheet->mergeCells("J$c:K$c");
				$sheet->mergeCells("L$c:M$c");
				
				$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
				$sheet->getStyle("F$c")->getNumberFormat()->setFormatCode('#,##0.00');
				$sheet->getStyle("N$c")->getNumberFormat()->setFormatCode('#,##0.00');
				

				$partsCost += $subCost;
				
				$c++;
			}
			
			// HEADER TOOLS
			
			$c++;
			
			$sheet->setCellValue("A$c", 'Tools');
			$sheet->getStyle("A$c")->getFont()->setBold(true);
			$sheet->mergeCells("A$c:N$c");
			
			$c++;
			$c++;
			
			// TABLE TOOLS HEADERS
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Tool Number");
			$sheet->setCellValue("C$c", "Description");
			$sheet->setCellValue("E$c", "Cost/Unit");
			$sheet->setCellValue("F$c", "Vendor");
			$sheet->setCellValue("H$c", "Mode");
			$sheet->setCellValue("I$c", "Shipping");
			$sheet->setCellValue("J$c", "Unit");
			$sheet->setCellValue("L$c", "Quantity");
			$sheet->setCellValue("N$c", "Subtotal");
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:D$c");
			$sheet->mergeCells("F$c:G$c");
			$sheet->mergeCells("J$c:K$c");
			$sheet->mergeCells("L$c:M$c");
			
			// TABLE TOOLS 
			
			$c++;
			
			$str = "SELECT * FROM others WHERE OCODE = '".$code."'";
			$tools = $this->db->query($str);	
		
			$toolsCost = 0;
			
			for($i = 0; $i<count($tools);$i++)
			{
				$item = $tools[$i];

				$sheet->setCellValue("A$c",  $item["TNUMBER"]);
				$sheet->setCellValue("C$c",  $item["TDETAIL"]);
				$sheet->setCellValue("E$c",  $item["TCOST"]);
				$sheet->setCellValue("F$c",  $item["TVENDOR"]);
				$sheet->setCellValue("H$c",  $item["TMODE"]);
				$sheet->setCellValue("I$c",  $item["TSHIPPING"]);
				$sheet->setCellValue("J$c",  $item["TUNIT"]);
				
				if($mode == "1")
				{
					$sheet->setCellValue("L$c",  $item["TQTY"]);
					$subCost = (floatval($item["TCOST"])*floatval($item["TQTY"]))+floatval($item["TSHIPPING"]);
				}
				else
				{
					$sheet->setCellValue("L$c",  $item["ACTUAL"]);
					$subCost = (floatval($item["TCOST"])*floatval($item["ACTUAL"]))+floatval($item["TSHIPPING"]);
				}
				
				
				$sheet->setCellValue("N$c",  $subCost);

				$sheet->mergeCells("A$c:B$c");
				$sheet->mergeCells("C$c:D$c");
				$sheet->mergeCells("F$c:G$c");
				$sheet->mergeCells("J$c:K$c");
				$sheet->mergeCells("L$c:M$c");
				
				$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
				$sheet->getStyle("E$c")->getNumberFormat()->setFormatCode('#,##0.00');
				$sheet->getStyle("I$c")->getNumberFormat()->setFormatCode('#,##0.00');
				$sheet->getStyle("N$c")->getNumberFormat()->setFormatCode('#,##0.00');
				$toolsCost += $subCost;
				
				$c++;
			}
			
			// HEADER ACCESS
			
			$c++;
			
			$sheet->setCellValue("A$c", 'Added Cost');
			$sheet->getStyle("A$c")->getFont()->setBold(true);
			$sheet->mergeCells("A$c:N$c");
			
			$c++;
			$c++;
			
			// TABLE ACCESS HEADERS
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Added Cost");
			$sheet->setCellValue("C$c", "Vendor");
			$sheet->setCellValue("D$c", "Unit type");
			$sheet->setCellValue("F$c", "Cost/Unit");
			$sheet->setCellValue("H$c", "Mob In/Out");
			$sheet->setCellValue("J$c", "Mob In/Out Qty");
			$sheet->setCellValue("L$c", "Quantity");
			$sheet->setCellValue("N$c", "Subtotal");
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("D$c:E$c");
			$sheet->mergeCells("F$c:G$c");
			$sheet->mergeCells("H$c:I$c");
			$sheet->mergeCells("L$c:M$c");
						
			// TABLE ACCESS 
			
			$c++;
			
			$dpkc = array();
			$dpkc["ocode"] = $code;
			$access = $this-> getOaccess($dpkc)["message"];
		
			$accessCost = 0;
			
			for($i = 0; $i<count($access);$i++)
			{
				$item = $access[$i];

				$sheet->setCellValue("A$c",  $item["AMETHOD"]);
				$sheet->setCellValue("C$c",  $item["AVDR"]);
				$sheet->setCellValue("D$c",  $item["AUNIT"]);
				$sheet->setCellValue("F$c",  $item["ACOST"]);
				$sheet->setCellValue("H$c",  $item["AMIMO"]);
				$sheet->setCellValue("J$c",  $item["AMIMOQ"]);
				
				if($mode == "1")
				{
					$sheet->setCellValue("L$c",  $item["AQTY"]);
					$subCost = (floatval($item["ACOST"])*floatval($item["AQTY"]))+(floatval($item["AMIMO"])*floatval($item["AMIMOQ"]));
				}
				else
				{
					$sheet->setCellValue("L$c",  $item["TE"]);
					$subCost = (floatval($item["ACOST"])*floatval($item["TE"]))+(floatval($item["AMIMO"])*floatval($item["AMIMOQ"]));
				}

				$sheet->setCellValue("N$c",  $subCost);

				$sheet->mergeCells("A$c:B$c");
				$sheet->mergeCells("D$c:E$c");
				$sheet->mergeCells("F$c:G$c");
				$sheet->mergeCells("H$c:I$c");
				$sheet->mergeCells("J$c:K$c");
				$sheet->mergeCells("L$c:M$c");
				
				$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
				$sheet->getStyle("E$c")->getNumberFormat()->setFormatCode('#,##0.00');
				$sheet->getStyle("I$c")->getNumberFormat()->setFormatCode('#,##0.00');
				$sheet->getStyle("N$c")->getNumberFormat()->setFormatCode('#,##0.00');
				$accessCost += $subCost;
				
				$c++;
			}
			
			// TOTALS LINE
			
			$c++;
			
			
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Labor Time");
			$sheet->setCellValue("C$c", "Labor Cost");
			$sheet->setCellValue("E$c", "Part Cost");
			$sheet->setCellValue("G$c", "Tool Cost");
			$sheet->setCellValue("I$c", "Added Cost");
			$sheet->setCellValue("K$c", "Total");
			$sheet->setCellValue("M$c", "Labor Standby");
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:D$c");
			$sheet->mergeCells("E$c:F$c");
			$sheet->mergeCells("G$c:H$c");
			$sheet->mergeCells("I$c:J$c");
			$sheet->mergeCells("K$c:L$c");
			$sheet->mergeCells("M$c:N$c");
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
			
			$sheet->setCellValue("A$c", $laborsTime." Hours");
			$sheet->setCellValue("C$c", $laborsCost);
			$sheet->setCellValue("E$c", $partsCost );
			$sheet->setCellValue("G$c", $toolsCost);
			$sheet->setCellValue("I$c", $accessCost );
			
			$total = $laborsCost+$partsCost+$toolsCost+$accessCost;
			
			$sheet->setCellValue("K$c", $total);
			$sheet->setCellValue("M$c", $odata["LABST"]." Hours");
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:D$c");
			$sheet->mergeCells("E$c:F$c");
			$sheet->mergeCells("G$c:H$c");
			$sheet->mergeCells("I$c:J$c");
			$sheet->mergeCells("K$c:L$c");
			$sheet->mergeCells("M$c:N$c");
			
			$sheet->getStyle("C$c")->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyle("E$c")->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyle("G$c")->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyle("I$c")->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyle("K$c")->getNumberFormat()->setFormatCode('#,##0.00');
			
			
			// ---------------
			
			$c++;
			$c++;
			
			// TURBS TOOLS
			
			$c++;
			
			$sheet->setCellValue("A$c", 'Turbines');
			$sheet->getStyle("A$c")->getFont()->setBold(true);
			$sheet->mergeCells("A$c:N$c");
			
			$c++;
			$c++;
			
			// TABLE TURBS HEADERS
					
			
			$sheet->getStyle("A$c:L$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:L$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:L$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Name");
			$sheet->setCellValue("B$c", "Hours");
			$sheet->setCellValue("C$c", "Wh# or Sf#");
			$sheet->setCellValue("D$c", "Identified");
			$sheet->setCellValue("E$c", "Priority");
			$sheet->setCellValue("F$c", "Comments");
			
			$sheet->setCellValue("G$c", "Blade A S/N");
			$sheet->setCellValue("H$c", "Blade B S/N");
			$sheet->setCellValue("I$c", "Blade C S/N");
			$sheet->setCellValue("J$c", "Workorder");
			$sheet->setCellValue("K$c", "Service order");
			$sheet->setCellValue("L$c", "WBS");
			
			
			
			
			// $sheet->mergeCells("A$c:C$c");
			// $sheet->mergeCells("D$c:E$c");
			// $sheet->mergeCells("F$c:G$c");
			// $sheet->mergeCells("H$c:I$c");
			// $sheet->mergeCells("J$c:K$c");
			// $sheet->mergeCells("L$c:N$c");
						
			// TABLE TURBINES 
			
			$c++;
			
			$dpkc = array();
			$dpkc["ocode"] = $code;
			$turbines = $this-> getOTurbs($dpkc)["message"];
		
			for($i = 0; $i<count($turbines);$i++)
			{
				$item = $turbines[$i];
				
				$sheet->setCellValue("A$c",  $item["TNAME"]);
				$sheet->setCellValue("B$c",  $item["HOURS"]);
				$sheet->setCellValue("C$c",  $item["WHSF"]);
				$sheet->setCellValue("D$c",  $item["IDDATE"]);
				$sheet->setCellValue("E$c",  $item["PRIORITY"]);
				$sheet->setCellValue("F$c",  $item["COMMENT"]);
				
				$sheet->setCellValue("G$c",  $item["SNA"]);
				$sheet->setCellValue("H$c",  $item["SNB"]);
				$sheet->setCellValue("I$c",  $item["SNC"]);
				$sheet->setCellValue("J$c",  $item["WO"]);
				$sheet->setCellValue("K$c",  $item["SO"]);
				$sheet->setCellValue("L$c",  $item["WBS"]);
				
				
				$sheet->getStyle("A$c:L$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:L$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:L$c")->getFont()->setSize(9);
				// $sheet->getStyle("E$c")->getNumberFormat()->setFormatCode('#,##0.00');
				// $sheet->getStyle("I$c")->getNumberFormat()->setFormatCode('#,##0.00');
				// $sheet->getStyle("N$c")->getNumberFormat()->setFormatCode('#,##0.00');
				// $accessCost += $subCost;
				
				$c++;
			}

			// FOOTER
					
			$c++;
			
			$fname  = str_replace('/', '_', $odata["CLIENT"])." - Quote Number ".$odata["ONUM"];
			$fname  = str_replace("'","\\'", $fname);
			$fname = htmlEntities(utf8_decode($fname));
			
			
			// $resp["message"] = $fname;
			// $resp["status"] = true;
			// return $resp;
			
			$fname = htmlEntities(utf8_decode($fname));
			$path = "../../files/".$code."/".$fname.".xls";
			
			$hasFile = file_exists($path);
			if($hasFile == true){unlink($path);}
			
			$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
			$objWriter->save($path );

		}
		// ----------------------------------------------------------------------
		// ----------------------------------------------------------------------
		// ----------------------------------------------------------------------
		// ----------------------------------------------------------------------
		
		if($type == "day")
		{
			$dcode = $info["dcode"];
			$str = "SELECT *  FROM days WHERE DCODE = '".$dcode."'";
			$dData = $this->db->query($str)[0];
			
			$c = 1;
			
			$dpkc = array();
			$dpkc["dcode"] = $dcode;
			$dpkc["ddate"] = $dData["DATE"];
			$dpkc["type"] = 'L';
			$dpkc["qcode"] = $dData["QCODE"];
			$dItemsL = $this-> getDayItems($dpkc)["message"];
			
			$dpkc = array();
			$dpkc["dcode"] = $dcode;
			$dpkc["ddate"] = $dData["DATE"];
			$dpkc["type"] = 'A';
			$dpkc["qcode"] = $dData["QCODE"];
			$dItemsA = $this-> getDayItems($dpkc)["message"];
			
			$dpkc = array();
			$dpkc["dcode"] = $dcode;
			$dpkc["ddate"] = $dData["DATE"];
			$dpkc["type"] = 'T';
			$dpkc["qcode"] = $dData["QCODE"];
			$dItemsT = $this-> getDayItems($dpkc)["message"];
			
			// GET PQDATA
			$str = "SELECT *  FROM projects WHERE QCODE = '".$dData["QCODE"]."'";
			$qdata = $this->db->query($str)[0];
			
			$dpkc = array();
			$dpkc["qcode"] = $dData["QCODE"];
			$progress = $this-> getProgress($dpkc)["message"];
			
			
			$sheet->setCellValue("A$c", "Daily report for quote: ".$dData["QCODE"]." - Completed: ".$progress."%");
			$sheet->mergeCells("A$c:H$c");
			
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			$sheet->getStyle("I$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("I$c:N$c")->applyFromArray($grayBg);
			$sheet->setCellValue("I$c", "Turbines");
			$sheet->setCellValue("J$c", "Mob In/Out");
			$sheet->setCellValue("K$c", "Labor");
			$sheet->setCellValue("L$c", "Standby");
			$sheet->setCellValue("M$c", "NC");
			$sheet->setCellValue("N$c", "Out of scope");
			
			
			// $c = 2;
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->mergeCells("G$c:H$c");
			$sheet->setCellValue("G$c", "Project Totals");
			$sheet->getStyle("I$c:N$c")->applyFromArray($borderB);

			// TOTALS------------------------------
			
			$qcode = $dData["QCODE"];
			$str = "SELECT *  FROM days WHERE QCODE = '".$qcode."' ORDER BY DATE ASC";
			$days = $this->db->query($str);

			
			$dpkc = array();
			$dpkc["qcode"] = $dData["QCODE"];
			$pTotals = $this-> getPtotals($dpkc)["message"];
			
			$total0 = $pTotals["total0"];
			$total1 = $pTotals["total1"];
			$total2 = $pTotals["total2"];
			$total3 = $pTotals["total3"];
			$total4 = $pTotals["total4"];
			$total5 = $pTotals["total5"];
			
			$sheet->getStyle("I2:N2")->applyFromArray($alignLeft);
			$sheet->setCellValue("I2",  $total0);
			$sheet->setCellValue("J2",  $total1);
			$sheet->setCellValue("K2",  $total2);
			$sheet->setCellValue("L2",  $total3);
			$sheet->setCellValue("M2",  $total4);
			$sheet->setCellValue("N2",  $total5);

			// TOTALS ---------------------------

			// HEADER TITLE
			
			
			$c = 2;
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->mergeCells("G$c:H$c");
			$sheet->setCellValue("G$c", "Project Totals");
			$sheet->getStyle("I$c:N$c")->applyFromArray($borderB);
			
			$c = 3;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:D$c");
			$sheet->mergeCells("E$c:F$c");
			$sheet->mergeCells("G$c:H$c");
			$sheet->mergeCells("I$c:K$c");
			$sheet->mergeCells("L$c:N$c");
			
			$sheet->setCellValue("A$c", "Quote");
			$sheet->setCellValue("C$c", "Wind Farm");
			$sheet->setCellValue("E$c", "Turbine");
			$sheet->setCellValue("G$c", "Service Order");
			$sheet->setCellValue("I$c", "Work Order");
			$sheet->setCellValue("L$c", "Cost Order");
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:D$c");
			$sheet->mergeCells("E$c:F$c");
			$sheet->mergeCells("G$c:H$c");
			$sheet->mergeCells("I$c:K$c");
			$sheet->mergeCells("L$c:N$c");
			
			$sheet->setCellValue("A$c", $qdata["QCODE"]);
			$sheet->setCellValue("C$c", $qdata["WFARM"]);
			$sheet->setCellValue("E$c", $qdata["TURBINE"]);
			$sheet->setCellValue("G$c", $qdata["SO"]);
			$sheet->setCellValue("I$c", $qdata["WO"]);
			$sheet->setCellValue("L$c", $qdata["CO"]);
			
			$c++;
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:D$c");
			$sheet->mergeCells("E$c:F$c");
			$sheet->mergeCells("G$c:H$c");
			$sheet->mergeCells("I$c:N$c");
			
			$sheet->setCellValue("A$c", "Purchase Order");
			$sheet->setCellValue("C$c", "Category");
			$sheet->setCellValue("E$c", "Start date");
			$sheet->setCellValue("G$c", "Job type");
			$sheet->setCellValue("I$c", "Description");
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->setCellValue("A$c", $qdata["PO"]);
			$sheet->setCellValue("C$c", $qdata["G4"]);
			$sheet->setCellValue("E$c", $qdata["INIDATE"]);
			$sheet->setCellValue("G$c", $qdata["JOB"]);
			$sheet->setCellValue("I$c", $qdata["DETAIL"]);
			
			$c++;
			$sheet->getStyle("A$c:N$c")->applyFromArray($yellowBg);
			$c++;

			// TITLES LINE 1
			// -------------------------------------------------
			$c = 9;
			
			$sheet->getStyle("A$c:P$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:P$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Date");
			$sheet->setCellValue("C$c", "Day status");
			$sheet->setCellValue("E$c", "Plan of day");
			$sheet->setCellValue("K$c", "Work Order");
			$sheet->setCellValue("M$c", "Service Order");
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:D$c");
			$sheet->mergeCells("E$c:J$c");
			$sheet->mergeCells("K$c:L$c");
			$sheet->mergeCells("M$c:N$c");
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
			
			$sheet->setCellValue("A$c", $dData["DATE"]);
			$sheet->setCellValue("C$c", $dData["WEATHER"]);
			$sheet->setCellValue("E$c", $dData["POD"]);
			$sheet->setCellValue("K$c", $dData["WO"]);
			$sheet->setCellValue("M$c", $dData["SO"]);
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:D$c");
			$sheet->mergeCells("E$c:J$c");
			$sheet->mergeCells("K$c:L$c");
			$sheet->mergeCells("M$c:N$c");
			
			$c++;
			$c++;
			
			// TABLE TECHS HEADERS
			
			$sheet->getStyle("A$c:P$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:P$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:P$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Responsible");
			$sheet->setCellValue("B$c", "Name");
			$sheet->setCellValue("C$c", "Quote");
			$sheet->setCellValue("D$c", "Executed");
			// $sheet->setCellValue("G$c", "Details");
			$sheet->setCellValue("E$c", "Mob In/out");
			$sheet->setCellValue("F$c", "Details");
			$sheet->setCellValue("G$c", "Labor");
			$sheet->setCellValue("H$c", "Details");
			$sheet->setCellValue("I$c", "Standby");
			$sheet->setCellValue("J$c", "Standby Details");
			$sheet->setCellValue("K$c", "NC");
			$sheet->setCellValue("L$c", "Details");
			$sheet->setCellValue("M$c", "Out of Scope");
			$sheet->setCellValue("N$c", "Details");
			
			$sheet->setCellValue("O$c", "Start Hour");
			$sheet->setCellValue("P$c", "End Hour");
			
			// $sheet->mergeCells("A$c:B$c");
			// $sheet->mergeCells("C$c:D$c");
			// $sheet->mergeCells("G$c:J$c");
						
			$c++;

			// TABLE TECHS 
			
			$t1 = 0;
			$t2 = 0;
			$t3 = 0;
			$t4 = 0;
			$t5 = 0;
			
			
			
			for($i = 0; $i<count($dItemsL);$i++)
			{
				$item = $dItemsL[$i];

				$sheet->setCellValue("A$c",  $item["RESPONSIBLE"]);
				$sheet->setCellValue("B$c",  $item["NAME"]);
				$sheet->setCellValue("C$c",  $item["QUOTE"]);
				
				
				if(isset($item["TE"]))
				{
					$sheet->setCellValue("D$c",  $item["TE"]);
				}
				else
				{
					$sheet->setCellValue("D$c",  "0");
				}
				
				
				// $sheet->setCellValue("G$c",  $item["DETAILS"]);
				$sheet->setCellValue("E$c",  $item["MIMO"]);
				$sheet->setCellValue("F$c",  $item["MIMOD"]);
				$sheet->setCellValue("G$c",  $item["LABOR"]);
				$sheet->setCellValue("H$c",  $item["LABORD"]);
				
				
				$flag = "none";
				
				// GET SB ITEMS
				// GET SB ITEMS
				// GET SB ITEMS
				if($item["STDARRAY"] != "" and  $item["STDARRAY"] != null)
				{
					$sbItems = json_decode($item["STDARRAY"], true);
					$add = 0;
					$flag = "enters stb array";
					$tmpStbQty = 0;
					
					for($s = 0; $s<count($sbItems);$s++)
					{
						$reason = $sbItems[$s];
						$reasonDetail = $reason["REASON"];
						$reasonQty = $reason["VAL"];
						$tmpStbQty = $tmpStbQty+$reasonQty;
						
						if(floatval($reasonQty) > 0)
						{
							$pos = $c+$add;
							$sheet->setCellValue("J$pos",  $reasonDetail);
							$sheet->setCellValue("I$pos",  $reasonQty);
							
							$sheet->getStyle("A$pos:P$pos")->applyFromArray($borderB);
							$sheet->getStyle("A$pos:P$pos")->applyFromArray($alignLeft);
							$sheet->getStyle("A$pos:P$pos")->getFont()->setSize(9);
							$add++;
						}
					}
					if($tmpStbQty == 0)
					{
						$add = 1;
					}
				}
				else
				{
					$add = 1;
					$sheet->setCellValue("J$c",  0);
				}
				// GET SB ITEMS
				// GET SB ITEMS
				// GET SB ITEMS


				$sheet->setCellValue("K$c",  $item["NC"]);
				$sheet->setCellValue("L$c",  $item["NCD"]);
				$sheet->setCellValue("M$c",  $item["OUS"]);
				$sheet->setCellValue("N$c",  $item["OUSD"]);
				
				$dpkc = array();
				$dpkc["dec"] = $item["INIDATE"];
				$inihour = $this-> decimalToHour($dpkc)["message"];
				
				$dpkc = array();
				$dpkc["dec"] = $item["ENDATE"];
				$endhour = $this-> decimalToHour($dpkc)["message"];

				$sheet->setCellValue("O$c",  $inihour);
				$sheet->setCellValue("P$c",  $endhour);
				
				$sheet->getStyle("A$c:P$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:P$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:P$c")->getFont()->setSize(9);
				
				$t1 = $t1+floatval($item["MIMO"]);
				$t2 = $t2+floatval($item["LABOR"]);
				$t3 = $t3+floatval($item["STANDBY"]);
				$t4 = $t4+floatval($item["NC"]);
				$t5 = $t5+floatval($item["OUS"]);

				$c = $c+$add;
			}
			
			// $c++;
			
			$sheet->getStyle("A$c:P$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:P$c")->applyFromArray($alignLeft);
			$sheet->getStyle("E$c:P$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:P$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("D$c", "Day totals");
			$sheet->setCellValue("E$c",  $t1);
			$sheet->setCellValue("G$c",  $t2);
			$sheet->setCellValue("I$c",  $t3);
			$sheet->setCellValue("K$c",  $t4);
			$sheet->setCellValue("M$c",  $t5);
			
			$c++;
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			$sheet->setCellValue("A$c", "Techs General Comments");
			$c++;
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			
			
			$dayObs = str_replace("<br>", "\n", $dData["OBS"]);
			
			
			
			$sheet->setCellValue("A$c", $dayObs);
			$sheet->getRowDimension("$c")->setRowHeight(90);
			$sheet->getStyle("A$c")->getAlignment()->setWrapText(true);
			
			$sheet->mergeCells("A$c:N$c");

			$c++;
			$c++;
			// TABLE ACCESS HEADERS
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Added Cost");
			$sheet->setCellValue("D$c", "Used");
			$sheet->setCellValue("F$c", "Unit");
			$sheet->setCellValue("I$c", "Quote");
			$sheet->setCellValue("L$c", "Executed");
			
			$sheet->mergeCells("A$c:C$c");
			$sheet->mergeCells("D$c:E$c");
			$sheet->mergeCells("F$c:H$c");
			$sheet->mergeCells("I$c:K$c");
			$sheet->mergeCells("L$c:N$c");
						
			$c++;

			// TABLE ACCESS 
			
			for($i = 0; $i<count($dItemsA);$i++)
			{
				$item = $dItemsA[$i];

				$sheet->setCellValue("A$c",  $item["NAME"]);
				$sheet->setCellValue("D$c",  $item["LABOR"]);
				$sheet->setCellValue("F$c",  $item["RESPONSIBLE"]);
				$sheet->setCellValue("I$c",  $item["QUOTE"]);
				$sheet->setCellValue("L$c",  $item["TE"]);
				

				$sheet->mergeCells("A$c:C$c");
				$sheet->mergeCells("D$c:E$c");
				$sheet->mergeCells("F$c:H$c");
				$sheet->mergeCells("I$c:K$c");
				$sheet->mergeCells("L$c:N$c");
				
				$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);

				$c++;
			}
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			$sheet->setCellValue("A$c", "Added Cost General Comments");
			$c++;
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->setCellValue("A$c", $dData["AMOBS"]);
			$sheet->getRowDimension("$c")->setRowHeight(60);
			$sheet->getStyle("A$c")->getAlignment()->setWrapText(true);
			$sheet->mergeCells("A$c:N$c");
			
			$c++;
			$c++;
			// TURBINES ADD --------
			
			// TABLE TURBINE HEADERS
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->setCellValue("A$c", "Turbine name");
			$sheet->setCellValue("B$c", "Quote");
			$sheet->setCellValue("C$c", "Executed");
			$sheet->setCellValue("D$c", "Cost order");
			$sheet->setCellValue("E$c", "Service order");
			$sheet->setCellValue("F$c", "Wh# or Sf#");
			$sheet->setCellValue("G$c", "Identified");
			$sheet->setCellValue("I$c", "Completed");
			$sheet->setCellValue("K$c", "Comments");
			$sheet->setCellValue("M$c", "Priority");
			
			
			// $sheet->mergeCells("A$c:C$c");
			// $sheet->mergeCells("D$c:F$c");
			// $sheet->mergeCells("G$c:I$c");
			// $sheet->mergeCells("J$c:K$c");
			// $sheet->mergeCells("L$c:M$c");
			
			$c++;
			
			for($i = 0; $i<count($dItemsT);$i++)
			{
				$item = $dItemsT[$i];

				$sheet->setCellValue("A$c",  $item["NAME"]);
				$sheet->setCellValue("B$c",  $item["QUOTE"]);
				$sheet->setCellValue("C$c",  $item["LABOR"]);
				$sheet->setCellValue("D$c",  $item["CO"]);
				$sheet->setCellValue("E$c",  $item["SO"]);
				$sheet->setCellValue("F$c",  $item["WHSF"]);
				$sheet->setCellValue("G$c",  $item["IDDATE"]);
				$sheet->setCellValue("I$c",  $item["FDATE"]);
				$sheet->setCellValue("K$c",  $item["COMMENT"]);
				$sheet->setCellValue("M$c",  $item["PRIORITY"]);
				
				// $sheet->mergeCells("A$c:C$c");
				// $sheet->mergeCells("D$c:F$c");
				// $sheet->mergeCells("G$c:I$c");
				// $sheet->mergeCells("J$c:K$c");
				// $sheet->mergeCells("L$c:M$c");
				

							
				$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
				$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);

				$c++;
			}
			
			
			
			// TURBINES ADD --------
			
			
			
			// ------------------FILE CREATE-------------------
			$fname = $dData["QCODE"]."-daily report ".$dData["DATE"].".xls";
			$path = "../../excel/".$fname;
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
		
		if($type == "training")
		{
			$ucode = $info["ucode"];
			
			$str = "SELECT * FROM users WHERE CODE = '".$ucode."'";
			$udata = $this->db->query($str)[0];
		
			$str = "SELECT * FROM training WHERE UCODE = '".$ucode."' AND MTYPE = 'TR' ORDER BY ENDATE ASC";
			$trainings = $this->db->query($str);		
			
			
			$c = 1;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:D$c");
			$sheet->mergeCells("E$c:F$c");
			$sheet->mergeCells("G$c:H$c");
			$sheet->mergeCells("I$c:N$c");
			
			$sheet->setCellValue("A$c", "Id number");
			$sheet->setCellValue("C$c", "Tech name");
			$sheet->setCellValue("E$c", "GID number");
			$sheet->setCellValue("G$c", "Hire date");
			$sheet->setCellValue("I$c", "Position");
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			
			$sheet->setCellValue("A$c", $udata["uGID"]);
			$sheet->setCellValue("C$c", $udata["CNAME"]);
			$sheet->setCellValue("E$c", $udata["uGTI"]);
			$sheet->setCellValue("G$c", $udata["uHdate"]);
			$sheet->setCellValue("I$c", $udata["uPos"]);
			
			// SEPARATE TYPES
			
			$STC = array();
			$ASTC = array();
			$DC = array();
			$E = array();
			$TT = array();

			for($i = 0; $i<count($trainings);$i++)
			{
				$item = $trainings[$i];
				
				if($item["TRTYPE"] == "STC"){array_push($STC, $item);}
				if($item["TRTYPE"] == "ASTC"){array_push($ASTC, $item);}
				if($item["TRTYPE"] == "DC"){array_push($DC, $item);}
				if($item["TRTYPE"] == "E"){array_push($E, $item);}
				if($item["TRTYPE"] == "TT"){array_push($TT, $item);}
			}

			// TABLE STC 
			if(count($STC) > 0)
			{
				// TABLE HEADER
				$c++;
				$c++;
				$sheet->getStyle("A$c:N$c")->applyFromArray($yellowBg);
				$sheet->getStyle("A$c:N$c")->applyFromArray($whiteTittle);
				$sheet->setCellValue("A$c", "Safety Training & Certifications");
				$c++;
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
				$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
				$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
				$sheet->mergeCells("A$c:F$c");
				$sheet->mergeCells("G$c:J$c");
				$sheet->mergeCells("K$c:N$c");
				$sheet->setCellValue("A$c", "Course Name");
				$sheet->setCellValue("G$c", "Date");
				$sheet->setCellValue("K$c", "Expire date");

				$c++;

				for($i = 0; $i<count($STC);$i++)
				{
					$item = $STC[$i];

					$sheet->setCellValue("A$c",  $item["CNAME"]);
					$sheet->setCellValue("G$c",  $item["INIDATE"]);
					$sheet->setCellValue("K$c",  $item["ENDATE"]);
					$sheet->mergeCells("A$c:F$c");
					$sheet->mergeCells("G$c:J$c");
					$sheet->mergeCells("K$c:N$c");
					$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
					$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
					$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
					$c++;
				}
			}
			
			// TABLE ASTC 
			if(count($ASTC) > 0)
			{
				// TABLE HEADER

				$sheet->getStyle("A$c:N$c")->applyFromArray($yellowBg);
				$sheet->getStyle("A$c:N$c")->applyFromArray($whiteTittle);
				$sheet->setCellValue("A$c", "Advanced Safety Training & Certifications");
				$c++;
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
				$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
				$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
				$sheet->mergeCells("A$c:F$c");
				$sheet->mergeCells("G$c:J$c");
				$sheet->mergeCells("K$c:N$c");
				$sheet->setCellValue("A$c", "Course Name");
				$sheet->setCellValue("G$c", "Date");
				$sheet->setCellValue("K$c", "Expire date");

				$c++;

				for($i = 0; $i<count($ASTC);$i++)
				{
					$item = $ASTC[$i];

					$sheet->setCellValue("A$c",  $item["CNAME"]);
					$sheet->setCellValue("G$c",  $item["INIDATE"]);
					$sheet->setCellValue("K$c",  $item["ENDATE"]);
					$sheet->mergeCells("A$c:F$c");
					$sheet->mergeCells("G$c:J$c");
					$sheet->mergeCells("K$c:N$c");
					$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
					$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
					$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
					$c++;
				}
			}
			
			// TABLE DC 
			if(count($DC) > 0)
			{
				// TABLE HEADER

				$sheet->getStyle("A$c:N$c")->applyFromArray($yellowBg);
				$sheet->getStyle("A$c:N$c")->applyFromArray($whiteTittle);
				$sheet->setCellValue("A$c", "DOT Compliance");
				$c++;
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
				$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
				$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
				$sheet->mergeCells("A$c:F$c");
				$sheet->mergeCells("G$c:J$c");
				$sheet->mergeCells("K$c:N$c");
				$sheet->setCellValue("A$c", "Course Name");
				$sheet->setCellValue("G$c", "Date");
				$sheet->setCellValue("K$c", "Expire date");

				$c++;

				for($i = 0; $i<count($DC);$i++)
				{
					$item = $DC[$i];

					$sheet->setCellValue("A$c",  $item["CNAME"]);
					$sheet->setCellValue("G$c",  $item["INIDATE"]);
					$sheet->setCellValue("K$c",  $item["ENDATE"]);
					$sheet->mergeCells("A$c:F$c");
					$sheet->mergeCells("G$c:J$c");
					$sheet->mergeCells("K$c:N$c");
					$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
					$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
					$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
					$c++;
				}
			}
			
			// TABLE E 
			if(count($E) > 0)
			{
				// TABLE HEADER

				$sheet->getStyle("A$c:N$c")->applyFromArray($yellowBg);
				$sheet->getStyle("A$c:N$c")->applyFromArray($whiteTittle);
				$sheet->setCellValue("A$c", "Environmental");
				$c++;
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
				$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
				$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
				$sheet->mergeCells("A$c:F$c");
				$sheet->mergeCells("G$c:J$c");
				$sheet->mergeCells("K$c:N$c");
				$sheet->setCellValue("A$c", "Course Name");
				$sheet->setCellValue("G$c", "Date");
				$sheet->setCellValue("K$c", "Expire date");

				$c++;

				for($i = 0; $i<count($E);$i++)
				{
					$item = $E[$i];

					$sheet->setCellValue("A$c",  $item["CNAME"]);
					$sheet->setCellValue("G$c",  $item["INIDATE"]);
					$sheet->setCellValue("K$c",  $item["ENDATE"]);
					$sheet->mergeCells("A$c:F$c");
					$sheet->mergeCells("G$c:J$c");
					$sheet->mergeCells("K$c:N$c");
					$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
					$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
					$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
					$c++;
				}
			}
			
			// TABLE TT 
			if(count($TT) > 0)
			{
				// TABLE HEADER

				$sheet->getStyle("A$c:N$c")->applyFromArray($yellowBg);
				$sheet->getStyle("A$c:N$c")->applyFromArray($whiteTittle);
				$sheet->setCellValue("A$c", "Technical Training");
				$c++;
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
				$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
				$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
				$sheet->mergeCells("A$c:F$c");
				$sheet->mergeCells("G$c:J$c");
				$sheet->mergeCells("K$c:N$c");
				$sheet->setCellValue("A$c", "Course Name");
				$sheet->setCellValue("G$c", "Date");
				$sheet->setCellValue("K$c", "Expire date");

				$c++;

				for($i = 0; $i<count($TT);$i++)
				{
					$item = $TT[$i];

					$sheet->setCellValue("A$c",  $item["CNAME"]);
					$sheet->setCellValue("G$c",  $item["INIDATE"]);
					$sheet->setCellValue("K$c",  $item["ENDATE"]);
					$sheet->mergeCells("A$c:F$c");
					$sheet->mergeCells("G$c:J$c");
					$sheet->mergeCells("K$c:N$c");
					$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
					$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
					$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
					$c++;
				}
			}

			// ------------------FILE CREATE-------------------
			$fname = $udata["CNAME"]."-trainings.xls";
			$fnameX = $udata["CNAME"]."-trainings";
			// $fname = "training report ".".xls";
			$path = "../../excel/".$fname;
			$hasFile = file_exists($path);
			if($hasFile == true){unlink($path);}
			$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
			$objWriter->save($path );
			$resp["message"] = $fnameX;
			$resp["status"] = true;
			return $resp;
		}
		
		if($type == "reqSup")
		{
			$reqCode = $info["qcode"];
			
			$str = "SELECT * FROM requests WHERE CODE = '".$reqCode."'";
			$reqData = $this->db->query($str)[0];

			$c = 1;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$c = 4;
			
			$sheet->setCellValue("A$c", "Operations Specialists Group Work/Support Request");
			
			$c++;
			$c++;
			
			$DETAIL = $reqData["DETAIL"];
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Speciality");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $DETAIL);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Direct Contact");
			$sheet->mergeCells("A$c:B$c");
			
			
			if($DETAIL == "Composite_Siemens_Design")
			{
				$destiny = "robert.brown@siemensgamesa.com";
				$dc = "Robert Brown";
			}
			else if($DETAIL == "Composite_Gamesa_Design")
			{
				$destiny = "juan.m.alvarez@siemensgamesa.com";
				$dc = "Juan Miguel Alvarez";
			}
			else if($DETAIL == "Mechanical")
			{
				$destiny = "norberto.fabre@siemensgamesa.com";
				$dc = "Norberto Fabre";
			}
			else if($DETAIL == "Electrical")
			{
				$destiny = "andrew.hrlevich@siemensgamesa.com";
				$dc = "Andrew Hrlevich";
			}
			else if($DETAIL == "Drones")
			{
				$destiny = "oscar.arcila@siemensgamesa.com";
				$dc = "Oscar Arcila";
			}
			else
			{
				$destiny = "cristhian.saenz@siemensgamesa.com";
				$dc = "C. Saenz";
			}

			
			$sheet->setCellValue("C$c", $dc);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "E-mail");	
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $destiny);	
			$sheet->mergeCells("C$c:J$c");
			
			$c++;
			$c++;
			
			$sheet->setCellValue("A$c", "General information");
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			
			$c++;
			$c++;
			

			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Date");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["DATE"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;

			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Requester");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["REQUESTER"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;

			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "District");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["DISTRICT"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Description");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["DETAIL"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "# Techs");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["TECHS"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Provided");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["RESULT"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Time (Operational Hours)");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["FRAMEDAYS"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;

			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Request type");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["TYPE"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Comments");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["COMMENTS"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Windfarm");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["WINDFARM"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Type of work");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["DETAIL"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Author");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["AUTOR"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Code");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["RNUM"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Type of request");
			$sheet->mergeCells("A$c:B$c");
			if($reqData["REQPARENT"] != "")
			{$sheet->setCellValue("C$c",  "Add for request: ".$reqData["REQPARENT"]);}
			else
			{$sheet->setCellValue("C$c",  "Initial request");}
			$sheet->mergeCells("C$c:J$c");
			
			$c++;
			$c++;
			
			$sheet->setCellValue("A$c", "Specific to the job");
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			
			$c++;
			$c++;

			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Platform");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["REQPLAT"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Address");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["REQADDRESS"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "PM");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["REQPM"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Support required");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["REQSUREQUIRED"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Component");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["REQCOMP"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Brand");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["REQBRAND"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Serial number");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["REQSN"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Turbine state");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["REQTSTATE"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Tooling");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["REQTOOL"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Parts");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["REQPART"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
			$sheet->setCellValue("A$c", "Failure description");
			$sheet->mergeCells("A$c:B$c");
			$sheet->setCellValue("C$c", $reqData["REQSUPDESC"]);
			$sheet->mergeCells("C$c:J$c");
			$c++;
			
			


			// ------------------FILE CREATE-------------------
			$fname = "work request form.xls";
			$path = "../../excel/".$fname;
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
		
		if($type == "PPE")
		{
			$ucode = $info["ucode"];
			
			$str = "SELECT * FROM users WHERE CODE = '".$ucode."'";
			$udata = $this->db->query($str)[0];
		
			$str = "SELECT * FROM training WHERE UCODE = '".$ucode."' AND MTYPE = 'PPE' ORDER BY EQENDATE ASC";
			$trainings = $this->db->query($str);		

			$c = 1;
			
			$sheet->getStyle("A$c:J$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:J$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:J$c")->applyFromArray($borderB);
			$sheet->getStyle("A$c:J$c")->getFont()->setBold(true);
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:D$c");
			$sheet->mergeCells("E$c:F$c");
			$sheet->mergeCells("G$c:H$c");
			$sheet->mergeCells("I$c:J$c");
			
			$sheet->setCellValue("A$c", "Id number");
			$sheet->setCellValue("C$c", "Tech name");
			$sheet->setCellValue("E$c", "GID number");
			$sheet->setCellValue("G$c", "Hire date");
			$sheet->setCellValue("I$c", "Position");
			
			$c++;
			
			$sheet->getStyle("A$c:J$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:J$c")->applyFromArray($grayBg);
			
			$sheet->setCellValue("A$c", $udata["uGID"]);
			$sheet->setCellValue("C$c", $udata["CNAME"]);
			$sheet->setCellValue("E$c", $udata["uGTI"]);
			$sheet->setCellValue("G$c", $udata["uHdate"]);
			$sheet->setCellValue("I$c", $udata["uPos"]);

			// TABLE PPE 
			if(count($trainings) > 0)
			{
				// TABLE HEADER
				$c++;
				$c++;
				$sheet->getStyle("A$c:J$c")->applyFromArray($yellowBg);
				$sheet->getStyle("A$c:J$c")->applyFromArray($whiteTittle);
				$sheet->setCellValue("A$c", "PPE and Tools");
				$c++;
				$sheet->getStyle("A$c:J$c")->getFont()->setSize(10);
				$sheet->getStyle("A$c:J$c")->applyFromArray($grayBg);
				$sheet->getStyle("A$c:J$c")->getFont()->setBold(true);
				// $sheet->mergeCells("A$c:F$c");
				// $sheet->mergeCells("G$c:J$c");
				// $sheet->mergeCells("K$c:N$c");
				$sheet->setCellValue("A$c", "Type");
				$sheet->setCellValue("B$c", "Serial");
				$sheet->setCellValue("C$c", "SKU");
				$sheet->setCellValue("D$c", "Manufactured");
				$sheet->setCellValue("E$c", "Delivered");
				$sheet->setCellValue("F$c", "Use until");
				$sheet->setCellValue("G$c", "Brand");
				$sheet->setCellValue("H$c", "Model");
				$sheet->setCellValue("I$c", "Condition");
				$sheet->setCellValue("J$c", "Comments");

				$c++;

				for($i = 0; $i<count($trainings);$i++)
				{
					$item = $trainings[$i];

					$sheet->setCellValue("A$c",  $item["TOEQUI"]);
					$sheet->setCellValue("B$c",  $item["EQSERIAL"]);
					$sheet->setCellValue("C$c",  $item["EQSKU"]);
					$sheet->setCellValue("D$c",  $item["EQMDATE"]);
					$sheet->setCellValue("E$c",  $item["EQDDATE"]);
					$sheet->setCellValue("F$c",  $item["EQENDATE"]);
					$sheet->setCellValue("G$c",  $item["EQBRAND"]);
					$sheet->setCellValue("H$c",  $item["EQMODEL"]);
					$sheet->setCellValue("I$c",  $item["EQSTATE"]);
					$sheet->setCellValue("J$c",  $item["COMMENTS"]);
					
					
					
					
					// $sheet->mergeCells("A$c:F$c");
					// $sheet->mergeCells("G$c:J$c");
					// $sheet->mergeCells("K$c:N$c");
					$sheet->getStyle("A$c:J$c")->applyFromArray($borderB);
					$sheet->getStyle("A$c:J$c")->applyFromArray($alignLeft);
					$sheet->getStyle("A$c:J$c")->getFont()->setSize(9);
					$c++;
				}
			}


			// ------------------FILE CREATE-------------------
			$fname = $udata["CNAME"]."-PPE.xls";
			$fnameX = $udata["CNAME"]."-PPE";
			// $fname = "training report ".".xls";
			$path = "../../excel/".$fname;
			$hasFile = file_exists($path);
			if($hasFile == true){unlink($path);}
			$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
			$objWriter->save($path );
			$resp["message"] = $fnameX;
			$resp["status"] = true;
			return $resp;
		}
		
		// ----------------------------------------------------------------------
		// ----------------------------------------------------------------------
		// ----------------------------------------------------------------------
		// ----------------------------------------------------------------------
		
		if($type == "project")
		{
			$qcode = $info["qcode"];
			$str = "SELECT *  FROM days WHERE QCODE = '".$qcode."' ORDER BY DATE ASC";
			$days = $this->db->query($str);

			$c = 1;
			
			// HEADER TITLE

			$dpkc = array();
			$dpkc["qcode"] = $qcode;
			$progress = $this-> getProgress($dpkc)["message"];
			
			$sheet->setCellValue("A$c", "Project report for quote: ".$qcode." - Completed: ".$progress."%");
			$sheet->mergeCells("A$c:H$c");
			
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			$sheet->getStyle("I$c:N$c")->getFont()->setSize(9);
			$sheet->setCellValue("I$c", "Turbines");
			$sheet->setCellValue("J$c", "Mob In/Out");
			$sheet->setCellValue("K$c", "Labor");
			$sheet->setCellValue("L$c", "Standby");
			$sheet->setCellValue("M$c", "NC");
			$sheet->setCellValue("N$c", "Out of scope");
			$sheet->getStyle("I$c:N$c")->applyFromArray($grayBg);
			
			$c = 2;
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->mergeCells("G$c:H$c");
			$sheet->setCellValue("G$c", "Project Totals");
			$sheet->getStyle("I$c:N$c")->applyFromArray($borderB);
			
			$c = 4;
			
			// GET PQDATA
			$str = "SELECT *  FROM projects WHERE QCODE = '".$qcode."'";
			$qdata = $this->db->query($str)[0];
			
			$subH = "Project state: ";
			
			if($qdata["CLOSD"] != "")
			{
				$subH.= "Closed on ".$qdata["CLOSD"];
			}
			else
			{
				$subH.= "Open";
			}
			
			$sheet->setCellValue("A2", $subH);
			
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:D$c");
			$sheet->mergeCells("E$c:F$c");
			$sheet->mergeCells("G$c:H$c");
			$sheet->mergeCells("I$c:J$c");
			$sheet->mergeCells("K$c:L$c");
			
			$sheet->setCellValue("A$c", "Proposal");
			$sheet->setCellValue("C$c", "Wind Farm");
			$sheet->setCellValue("E$c", "Turbine");
			$sheet->setCellValue("G$c", "Service Order");
			$sheet->setCellValue("I$c", "Work Order");
			$sheet->setCellValue("K$c", "Cost Order");
			$sheet->setCellValue("M$c", "Platform");
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			// $sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:D$c");
			$sheet->mergeCells("E$c:F$c");
			$sheet->mergeCells("G$c:H$c");
			$sheet->mergeCells("I$c:J$c");
			$sheet->mergeCells("K$c:L$c");
			
			$sheet->setCellValue("A$c", $qdata["QCODE"]);
			$sheet->setCellValue("C$c", $qdata["WFARM"]);
			$sheet->setCellValue("E$c", $qdata["TURBINE"]);
			$sheet->setCellValue("G$c", $qdata["SO"]);
			$sheet->setCellValue("I$c", $qdata["WO"]);
			$sheet->setCellValue("K$c", $qdata["CO"]);
			$sheet->setCellValue("M$c", $qdata["PLATFORM"]);
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
			$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
			
			$sheet->mergeCells("A$c:B$c");
			$sheet->mergeCells("C$c:D$c");
			$sheet->mergeCells("E$c:F$c");
			$sheet->mergeCells("G$c:H$c");
			$sheet->mergeCells("I$c:N$c");
			
			$sheet->setCellValue("A$c", "Purchase Order");
			$sheet->setCellValue("C$c", "Category");
			$sheet->setCellValue("E$c", "Start date");
			$sheet->setCellValue("G$c", "Job type");
			$sheet->setCellValue("I$c", "Description");
			
			$c++;
			
			$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
			// $sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
			$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
			$sheet->setCellValue("A$c", $qdata["PO"]);
			$sheet->setCellValue("C$c", $qdata["G4"]);
			$sheet->setCellValue("E$c", $qdata["INIDATE"]);
			$sheet->setCellValue("G$c", $qdata["JOB"]);
			$sheet->setCellValue("I$c", $qdata["DETAIL"]);
			
			$c++;
			$c++;
			$sheet->getStyle("A$c:N$c")->applyFromArray($yellowBg);
			$c++;
			$c++;
			
			$total1 = 0;
			$total2 = 0;
			$total3 = 0;
			$total4 = 0;
			$total5 = 0;
			
			for($d = 0; $d<count($days);$d++)
			{
				$day = $days[$d];

				$dcode = $day["DCODE"];
				$str = "SELECT *  FROM days WHERE DCODE = '".$dcode."'";
				$dData = $this->db->query($str)[0];
				
				$dpkc = array();
				$dpkc["dcode"] = $dcode;
				$dpkc["ddate"] = $dData["DATE"];
				$dpkc["type"] = 'L';
				$dpkc["qcode"] = $dData["QCODE"];
				$dItemsL = $this-> getDayItems($dpkc)["message"];
				
				$dpkc = array();
				$dpkc["dcode"] = $dcode;
				$dpkc["ddate"] = $dData["DATE"];
				$dpkc["type"] = 'A';
				$dpkc["qcode"] = $dData["QCODE"];
				$dItemsA = $this-> getDayItems($dpkc)["message"];
				
				$dpkc = array();
				$dpkc["dcode"] = $dcode;
				$dpkc["ddate"] = $dData["DATE"];
				$dpkc["type"] = 'T';
				$dpkc["qcode"] = $dData["QCODE"];
				$dItemsT = $this-> getDayItems($dpkc)["message"];

				// TITLES LINE 1
				
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
				$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
				
				$sheet->setCellValue("A$c", "Date");
				$sheet->setCellValue("C$c", "Day status");
				$sheet->setCellValue("E$c", "Plan of day");
				$sheet->setCellValue("K$c", "Work Order");
				$sheet->setCellValue("M$c", "Service Order");
				
				$sheet->mergeCells("A$c:B$c");
				$sheet->mergeCells("C$c:D$c");
				$sheet->mergeCells("E$c:J$c");
				$sheet->mergeCells("K$c:L$c");
				$sheet->mergeCells("M$c:N$c");
				
				$c++;
				
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
				$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
				
				$sheet->setCellValue("A$c", $dData["DATE"]);
				$sheet->setCellValue("C$c", $dData["WEATHER"]);
				$sheet->setCellValue("E$c", $dData["POD"]);
				$sheet->setCellValue("K$c", $dData["WO"]);
				$sheet->setCellValue("M$c", $dData["SO"]);
				
				$sheet->mergeCells("A$c:B$c");
				$sheet->mergeCells("C$c:D$c");
				$sheet->mergeCells("E$c:J$c");
				$sheet->mergeCells("K$c:L$c");
				$sheet->mergeCells("M$c:N$c");
				
				$c++;
				$c++;
				
				// TABLE TECHS HEADERS
			
				$sheet->getStyle("A$c:P$c")->getFont()->setSize(10);
				$sheet->getStyle("A$c:P$c")->applyFromArray($grayBg);
				$sheet->getStyle("A$c:P$c")->getFont()->setBold(true);
				
				$sheet->setCellValue("A$c", "Responsible");
				$sheet->setCellValue("B$c", "Name");
				$sheet->setCellValue("C$c", "Quote");
				$sheet->setCellValue("D$c", "Executed");
				// $sheet->setCellValue("G$c", "Details");
				$sheet->setCellValue("E$c", "Mob In/out");
				$sheet->setCellValue("F$c", "Details");
				$sheet->setCellValue("G$c", "Labor");
				$sheet->setCellValue("H$c", "Details");
				$sheet->setCellValue("I$c", "Standby");
				$sheet->setCellValue("J$c", "Details");
				$sheet->setCellValue("K$c", "NC");
				$sheet->setCellValue("L$c", "Details");
				$sheet->setCellValue("M$c", "Out of Scope");
				$sheet->setCellValue("N$c", "Details");
				
				$sheet->setCellValue("O$c", "Start hour");
				$sheet->setCellValue("P$c", "End hour");
				
				// $sheet->mergeCells("A$c:B$c");
				// $sheet->mergeCells("C$c:D$c");
				// $sheet->mergeCells("G$c:J$c");
							
				$c++;

				// TABLE TECHS 
				
				$t1 = 0;
				$t2 = 0;
				$t3 = 0;
				$t4 = 0;
				$t5 = 0;
				
				for($i = 0; $i<count($dItemsL);$i++)
				{
					$item = $dItemsL[$i];

					$sheet->setCellValue("A$c",  $item["RESPONSIBLE"]);
					$sheet->setCellValue("B$c",  $item["NAME"]);
					$sheet->setCellValue("C$c",  $item["QUOTE"]);
					
					if(isset($item["TE"]))
					{
						$sheet->setCellValue("D$c",  $item["TE"]);
					}
					else
					{
						$sheet->setCellValue("D$c",  "0");
					}
					
					
					
					
					// $sheet->setCellValue("G$c",  $item["DETAILS"]);
					$sheet->setCellValue("E$c",  $item["MIMO"]);
					$sheet->setCellValue("F$c",  $item["MIMOD"]);
					$sheet->setCellValue("G$c",  $item["LABOR"]);
					$sheet->setCellValue("H$c",  $item["LABORD"]);
					
					
					// GET SB ITEMS
					// GET SB ITEMS
					// GET SB ITEMS
					if($item["STDARRAY"] != "")
					{
						$sbItems = json_decode($item["STDARRAY"], true);
						$add = 0;
						
						$tmpStbQty = 0;
						
						for($s = 0; $s<count($sbItems);$s++)
						{
							$reason = $sbItems[$s];
							$reasonDetail = $reason["REASON"];
							$reasonQty = $reason["VAL"];
							$tmpStbQty = $tmpStbQty+$reasonQty;
							
							if(floatval($reasonQty) > 0)
							{
								$pos = $c+$add;
								$sheet->setCellValue("J$pos",  $reasonDetail);
								$sheet->setCellValue("I$pos",  $reasonQty);
								
								$sheet->getStyle("A$pos:P$pos")->applyFromArray($borderB);
								$sheet->getStyle("A$pos:P$pos")->applyFromArray($alignLeft);
								$sheet->getStyle("A$pos:P$pos")->getFont()->setSize(9);
								$add++;
							}
						}
						if($tmpStbQty == 0)
						{
							$add = 1;
						}
					}
					else
					{
						
						$add = 1;
						$oldStb = $item["STANDBY"];
						$sheet->setCellValue("J$c",  $oldStb);
						// $sheet->setCellValue("J$c",  0);
					}
					// GET SB ITEMS
					// GET SB ITEMS
					// GET SB ITEMS
					
					
					$sheet->setCellValue("K$c",  $item["NC"]);
					$sheet->setCellValue("L$c",  $item["NCD"]);
					$sheet->setCellValue("M$c",  $item["OUS"]);
					$sheet->setCellValue("N$c",  $item["OUSD"]);
					
					$dpkc = array();
					$dpkc["dec"] = $item["INIDATE"];
					$inihour = $this-> decimalToHour($dpkc)["message"];
					
					$dpkc = array();
					$dpkc["dec"] = $item["ENDATE"];
					$endhour = $this-> decimalToHour($dpkc)["message"];

					$sheet->setCellValue("O$c",  $inihour);
					$sheet->setCellValue("P$c",  $endhour);

					// $sheet->mergeCells("A$c:B$c");
					// $sheet->mergeCells("C$c:D$c");
					// $sheet->mergeCells("G$c:J$c");
					
					$sheet->getStyle("A$c:P$c")->applyFromArray($borderB);
					$sheet->getStyle("A$c:P$c")->applyFromArray($alignLeft);
					$sheet->getStyle("A$c:P$c")->getFont()->setSize(9);
					
					// GET PROJECT TOTALS
					$t1 = $t1+floatval($item["MIMO"]);
					$t2 = $t2+floatval($item["LABOR"]);
					if($item["STDARRAY"] != null and $item["STDARRAY"] != "")
					{
						$sbItems = json_decode($item["STDARRAY"], true);
						$tmpStbQty = 0;
						
						for($s = 0; $s<count($sbItems);$s++)
						{
							$reason = $sbItems[$s];
							$reasonDetail = $reason["REASON"];
							$reasonQty = $reason["VAL"];
							$tmpStbQty = $tmpStbQty+$reasonQty;
						}
					}
					else
					{
						$oldStb = $item["STANDBY"];
						$tmpStbQty = $oldStb;
					}
					$t3 = $t3+$tmpStbQty;
					$t4 = $t4+floatval($item["NC"]);
					$t5 = $t5+floatval($item["OUS"]);
					
					$c = $c+$add;
				}
				
				$total1 = $total1+$t1;
				$total2 = $total2+$t2;
				$total3 = $total3+$t3;
				$total4 = $total4+$t4;
				$total5 = $total5+$t5;
				
				
				$sheet->getStyle("I2:N2")->applyFromArray($alignLeft);
				$sheet->setCellValue("I2",  count($dItemsT));
				$sheet->setCellValue("J2",  $total1);
				$sheet->setCellValue("K2",  $total2);
				$sheet->setCellValue("L2",  $total3);
				$sheet->setCellValue("M2",  $total4);
				$sheet->setCellValue("N2",  $total5);
				
				
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
				$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
				$sheet->getStyle("D$c:N$c")->applyFromArray($grayBg);
				$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
				$sheet->setCellValue("D$c", "Day totals");
				$sheet->setCellValue("E$c",  $t1);
				$sheet->setCellValue("G$c",  $t2);
				$sheet->setCellValue("I$c",  $t3);
				$sheet->setCellValue("K$c",  $t4);
				$sheet->setCellValue("M$c",  $t5);
				
				$c++;
				$c++;
				
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
				$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
				$sheet->setCellValue("A$c", "Techs General Comments");
				$c++;
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
				
				$dayObs = str_replace("<br>", "\n", $dData["OBS"]);
				
				$sheet->setCellValue("A$c", $dayObs);
				$sheet->getRowDimension("$c")->setRowHeight(90);
				$sheet->getStyle("A$c")->getAlignment()->setWrapText(true);
				$sheet->mergeCells("A$c:N$c");
				
				$c++;
				$c++;
				// TABLE ACCESS HEADERS
				
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
				$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
				$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
				
				$sheet->setCellValue("A$c", "Added Cost");
				$sheet->setCellValue("D$c", "Used");
				$sheet->setCellValue("F$c", "Unit");
				$sheet->setCellValue("I$c", "Quote");
				$sheet->setCellValue("L$c", "Executed");
				
				$sheet->mergeCells("A$c:C$c");
				$sheet->mergeCells("D$c:E$c");
				$sheet->mergeCells("F$c:H$c");
				$sheet->mergeCells("I$c:K$c");
				$sheet->mergeCells("L$c:N$c");
							
				$c++;

				// TABLE ACCESS 
				
				for($i = 0; $i<count($dItemsA);$i++)
				{
					$item = $dItemsA[$i];

					$sheet->setCellValue("A$c",  $item["NAME"]);
					$sheet->setCellValue("D$c",  $item["LABOR"]);
					$sheet->setCellValue("F$c",  $item["RESPONSIBLE"]);
					$sheet->setCellValue("I$c",  $item["QUOTE"]);
					$sheet->setCellValue("L$c",  $item["TE"]);
					

					$sheet->mergeCells("A$c:C$c");
					$sheet->mergeCells("D$c:E$c");
					$sheet->mergeCells("F$c:H$c");
					$sheet->mergeCells("I$c:K$c");
					$sheet->mergeCells("L$c:N$c");
					
					$sheet->getStyle("A$c:N$c")->applyFromArray($borderB);
					$sheet->getStyle("A$c:N$c")->applyFromArray($alignLeft);
					$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);

					$c++;
				}
				
				$c++;
				
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
				$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
				$sheet->setCellValue("A$c", "Added Cost General Comments");
				$c++;
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(9);
				$sheet->setCellValue("A$c", $dData["AMOBS"]);
				$sheet->mergeCells("A$c:N$c");
				
				$c++;
				$c++;
				
				// TURBINES ADDS ----------
				
				// TABLE TURBINE HEADERS
			
				$sheet->getStyle("A$c:N$c")->getFont()->setSize(10);
				$sheet->getStyle("A$c:N$c")->applyFromArray($grayBg);
				$sheet->getStyle("A$c:N$c")->getFont()->setBold(true);
				
				$sheet->setCellValue("A$c", "Turbine name");
				$sheet->setCellValue("D$c", "Quote");
				$sheet->setCellValue("G$c", "Executed");
				$sheet->setCellValue("J$c", "Cost order");
				$sheet->setCellValue("L$c", "Service order");
				$sheet->setCellValue("M$c", "Work order");
				
				
				$sheet->mergeCells("A$c:C$c");
				$sheet->mergeCells("D$c:F$c");
				$sheet->mergeCells("G$c:I$c");
				$sheet->mergeCells("J$c:K$c");
				
				$c++;
				
				for($i = 0; $i<count($dItemsT);$i++)
				{
					$item = $dItemsT[$i];

					$sheet->setCellValue("A$c",  $item["NAME"]);
					$sheet->setCellValue("D$c",  $item["QUOTE"]);
					$sheet->setCellValue("G$c",  $item["LABOR"]);
					$sheet->setCellValue("J$c",  $item["CO"]);
					$sheet->setCellValue("L$c",  $item["SO"]);
					$sheet->setCellValue("M$c",  $item["WO"]);
					
					$sheet->mergeCells("A$c:C$c");
					$sheet->mergeCells("D$c:F$c");
					$sheet->mergeCells("G$c:I$c");
					$sheet->mergeCells("J$c:K$c");
					// $sheet->mergeCells("L$c:M$c");
					$sheet->mergeCells("L$c:M$c");
					
					$c++;
				}
				
				
				// TURBINES ADDS ----------
				
				$c++;
				
				$sheet->getStyle("A$c:N$c")->applyFromArray($yellowBg);
				$c++;
				$c++;
			}
			
			
			// ------------------FILE CREATE-------------------
			$fname = $qdata["WFARM"]."-".$dData["QCODE"]."-project.xls";
			$path = "../../excel/".$fname;
			$hasFile = file_exists($path);
			if($hasFile == true){unlink($path);}
			$objWriter = PHPExcel_IOFactory::createWriter($myExcel, 'Excel5');
			$objWriter->save($path );
			$resp["message"] = $fname;
			$resp["status"] = true;
			return $resp;
		}
		
		$fname = htmlEntities(utf8_decode($fname));
		$resp["message"] = $fname;
		$resp["status"] = true;
		return $resp;
	}
	
	function decimalToHour($info)
	{
		$dec = $info["dec"];
		
		$hour = "";
		
		if($dec == "0"){$hour = "00:00";}
				
		if($dec == "0.25"){$hour = "00:15 am";}
		if($dec == "0.50"){$hour = "00:30 am";}
		if($dec == "0.75"){$hour = "00:45 am";}
		if($dec == "1"){$hour = "01:00 am";}
		
		if($dec == "1.25"){$hour = "01:15 am";}
		if($dec == "1.50"){$hour = "01:30 am";}
		if($dec == "1.75"){$hour = "01:45 am";}
		if($dec == "2"){$hour = "2:00 am";}
		
		if($dec == "2.25"){$hour = "02:15 am";}
		if($dec == "2.50"){$hour = "02:30 am";}
		if($dec == "2.75"){$hour = "02:45 am";}
		if($dec == "3"){$hour = "3:00 am";}

		if($dec == "3.25"){$hour = "03:15 am";}
		if($dec == "3.50"){$hour = "03:30 am";}
		if($dec == "3.75"){$hour = "03:45 am";}
		if($dec == "4"){$hour = "4:00 am";}
		
		if($dec == "4.25"){$hour = "04:15 am";}
		if($dec == "4.50"){$hour = "04:30 am";}
		if($dec == "4.75"){$hour = "04:45 am";}
		if($dec == "5"){$hour = "5:00 am";}
		
		if($dec == "5.25"){$hour = "05:15 am";}
		if($dec == "5.50"){$hour = "05:30 am";}
		if($dec == "5.75"){$hour = "05:45 am";}
		if($dec == "6"){$hour = "6:00 am";}
		
		if($dec == "6.25"){$hour = "06:15 am";}
		if($dec == "6.50"){$hour = "06:30 am";}
		if($dec == "6.75"){$hour = "06:45 am";}
		if($dec == "7"){$hour = "7:00 am";}
		
	
		if($dec == "7.25"){$hour = "07:15 am";}
		if($dec == "7.50"){$hour = "07:30 am";}
		if($dec == "7.75"){$hour = "07:45 am";}
		if($dec == "8"){$hour = "8:00 am";}
		
		if($dec == "8.25"){$hour = "08:15 am";}
		if($dec == "8.50"){$hour = "08:30 am";}
		if($dec == "8.75"){$hour = "08:45 am";}
		if($dec == "9"){$hour = "9:00 am";}
		
		if($dec == "9.25"){$hour = "09:15 am";}
		if($dec == "9.50"){$hour = "09:30 am";}
		if($dec == "9.75"){$hour = "09:45 am";}
		if($dec == "10"){$hour = "10:00 am";}
		
		if($dec == "10.25"){$hour = "10:15 am";}
		if($dec == "10.50"){$hour = "10:30 am";}
		if($dec == "10.75"){$hour = "10:45 am";}
		if($dec == "11"){$hour = "11:00 am";}
		
		if($dec == "11.25"){$hour = "11:15 am";}
		if($dec == "11.50"){$hour = "11:30 am";}
		if($dec == "11.75"){$hour = "11:45 am";}
		if($dec == "12"){$hour = "12:00 m";}
		
		if($dec == "12.25"){$hour = "12:15 pm";}
		if($dec == "12.50"){$hour = "12:30 pm";}
		if($dec == "12.75"){$hour = "12:45 pm";}
		if($dec == "13"){$hour = "1:00 pm";}

		if($dec == "13.25"){$hour = "01:15 pm";}
		if($dec == "13.50"){$hour = "01:30 pm";}
		if($dec == "13.75"){$hour = "01:45 pm";}
		if($dec == "14"){$hour = "2:00 pm";}
		
		if($dec == "14.25"){$hour = "02:15 pm";}
		if($dec == "14.50"){$hour = "02:30 pm";}
		if($dec == "14.75"){$hour = "02:45 pm";}
		if($dec == "15"){$hour = "3:00 pm";}

		if($dec == "15.25"){$hour = "03:15 pm";}
		if($dec == "15.50"){$hour = "03:30 pm";}
		if($dec == "15.75"){$hour = "03:45 pm";}
		if($dec == "16"){$hour = "4:00 pm";}
		
		if($dec == "16.25"){$hour = "04:15 pm";}
		if($dec == "16.50"){$hour = "04:30 pm";}
		if($dec == "16.75"){$hour = "04:45 pm";}
		if($dec == "17"){$hour = "5:00 pm";}
		
		if($dec == "17.25"){$hour = "05:15 pm";}
		if($dec == "17.50"){$hour = "05:30 pm";}
		if($dec == "17.75"){$hour = "05:45 pm";}
		if($dec == "18"){$hour = "6:00 pm";}
		
		if($dec == "18.25"){$hour = "06:15 pm";}
		if($dec == "18.50"){$hour = "06:30 pm";}
		if($dec == "18.75"){$hour = "06:45 pm";}
		if($dec == "19"){$hour = "7:00 pm";}
		
	
		if($dec == "19.25"){$hour = "07:15 pm";}
		if($dec == "19.50"){$hour = "07:30 pm";}
		if($dec == "19.75"){$hour = "07:45 pm";}
		if($dec == "20"){$hour = "8:00 pm";}
		
		if($dec == "20.25"){$hour = "08:15 pm";}
		if($dec == "20.50"){$hour = "08:30 pm";}
		if($dec == "20.75"){$hour = "08:45 pm";}
		if($dec == "21"){$hour = "9:00 pm";}
		
		if($dec == "21.25"){$hour = "09:15 pm";}
		if($dec == "21.50"){$hour = "09:30 pm";}
		if($dec == "21.75"){$hour = "09:45 pm";}
		if($dec == "22"){$hour = "10:00 pm";}
		
		if($dec == "22.25"){$hour = "10:15 pm";}
		if($dec == "22.50"){$hour = "10:30 pm";}
		if($dec == "22.75"){$hour = "10:45 pm";}
		if($dec == "23"){$hour = "11:00 pm";}
		
		if($dec == "23.25"){$hour = "11:15 pm";}
		if($dec == "23.50"){$hour = "11:30 pm";}
		if($dec == "23.75"){$hour = "11:45 pm";}
		
		$ans = $hour;
		
		$resp["message"] = $ans;
		$resp["status"] = true;
		return $resp;
	}
	
}

?>
