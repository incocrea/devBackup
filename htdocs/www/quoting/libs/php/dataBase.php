<?php

class sql_query
{
	private $pg;
	function __construct()
	{
		try
		{
			$host = "localhost";
			$db = "quoting";
			// $db = "sherbim2016";
			// $user = "sherbimadmin";
			// $pssw = "Harolito2015";
			$user = "root";
			$pssw = "";

			$this->pg = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pssw, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
			// $this->pg = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pssw,'charset=utf8');
			
		}
		catch(PDOException $e)
		{
			echo  "Error!: ".$e->getMessage()."<br/>";	
		}
	}
	
	function beginTransaction()
	{
		$this->pg->beginTransaction();	
	}
	
	function commit()
	{
		$this->pg->commit();	
	}
	
	function rollBack()
	{
		$this->pg->rollBack();	
	}

	function query($string)
	{
		$resp = $this->pg->query($string);
		$error = $this->pg->errorInfo();
		if(empty($error[1]))
		{
			$resp->setFetchMode(PDO::FETCH_ASSOC);
			$querystr = array();
			
			while ($row = $resp->fetch())
			{
				$querystr[] = $row;	
			}
			return $querystr;
		}
		else
		{

			throw new Exception(implode($error," "), 1);
	
		}
	}
}

?>