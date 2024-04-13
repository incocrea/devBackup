<?php

class lang{
	
	private $db = null;
	
	function __construct()
	{
		$this->db = new sql_query();
		session_start();
	}
	
	function langGet($data)
	{
		$language = $data["lang"];
		$langFile = parse_ini_file("../../lang/lang.ini", true);
		
		$str = "SELECT * FROM invlists";
		$inventories = $this->db->query($str);
		
		$resp["inventories"] = $inventories;
		
		
		$resp["message"] = $langFile[$language];
		$resp["status"] = true; 
		
		return $resp;
		
	}
	
	function createInventory($info)
	{
		
		
		$createInvName = $info["createInvName"];
		$createInvDesc = $info["createInvDesc"];
		
		$str = "INSERT INTO invlists (INVCODE, INVDESC) VALUES ('".$createInvName."', '".$createInvDesc."')";
		$query = $this->db->query($str);
		
		// $ans = $query;
		
		$resp["message"] = "Done";
		$resp["status"] = true;
		return $resp;
	}
	
	function deleteInv($info)
	{
		
		$INV = $info["INV"];
		
		
		
		// DELETE PRODUCTS
		$str = "DELETE FROM products WHERE AREA = '".$INV ."' ";
		$query = $this->db->query($str);
		
		
		// DELETE MASTER
		$str = "DELETE FROM invlists WHERE INVCODE = '".$INV ."' ";
		$query = $this->db->query($str);

		
		$resp["message"] = "Done";
		$resp["status"] = true;
		return $resp;
	}
	
	function syncInventory($info)
	{
		
		$BASE = $info["BASE"];
		
		// GET ACTUAL INVENTORIES AS STRING FOR QUERY
		
		$str = "SELECT INVCODE FROM invlists WHERE INVCODE != '".$BASE."'";
		$baseInvs = $this->db->query($str);
		
		$baseStr = " AND (AREA = '";
		
		for($i=0; $i<count($baseInvs);$i++)
		{
			$code = $baseInvs[$i]["INVCODE"];
			if($i < (count($baseInvs)-1)){$baseStr .= $code."' OR AREA = '";}
			else{$baseStr .= $code."')";}
		}
		
		// GET PICKED INVENTORY PRODUCT LIST JUST NECESARY FIELDS
		
		$str = "SELECT CODE, CAT, DETAIL, FDETAIL, LONDESC, HP, PROMO FROM products WHERE AREA = '".$BASE."' ORDER BY CODE ASC";
		$baseProducts = $this->db->query($str);
		
		// UPDATE KEY FIELDS IN ALL PRODUCTS WHERE CODE IS SAME AND BELONGS TO ANY OF THE INCLUDED INVENTORIES
		
		for($i=0; $i<count($baseProducts);$i++)
		{
			
			$p = $baseProducts[$i];
			$CODE = $p["CODE"];
			$CAT = $p["CAT"];
			// $CODE = "012001";
			$DETAIL = $p["DETAIL"];
			$FDETAIL = $p["FDETAIL"];
			$LONDESC = $p["LONDESC"];
			$HP = $p["HP"];
			$PROMO = $p["PROMO"];
			
			$str = "UPDATE products SET CAT = '".$CAT."', DETAIL = '".$DETAIL."', FDETAIL = '".$FDETAIL."', LONDESC = '".$LONDESC."', HP = '".$HP."', PROMO = '".$PROMO."' WHERE CODE = '$CODE' $baseStr";
			$query = $this->db->query($str);

		}
		
		$resp["message"] = $baseStr;
		$resp["status"] = true;
		return $resp;
	}
	
	
}

?>
