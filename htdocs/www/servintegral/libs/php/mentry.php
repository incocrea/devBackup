<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class entryPoint{
	private $params;
	function __construct($info)
	{
		if(isset($_POST["info"]))
		{
			$this->params = json_decode($_POST["info"], true);
		}
		else
		{
			$this->params = json_decode(file_get_contents("php://input"), true);
		}
	}
	function start()
	{
		require_once "dataBase.php";
		require_once $this->params["class"].".php";

		$class = $this->params["class"];
		$instance = new $class(); 
		$method = $this->params["method"];

		try
		{
			$exec = $instance->$method($this->params["data"]);
			$resp = array("data"=>$exec, "exception"=>"");
			return json_encode($resp);	
		}
		catch(Exception $e)
		{
			$resp = array("data"=>$exec,"exception"=>$e->getMessage());
			return json_encode($resp);	
		}
	}
}
$entry = new entryPoint($_POST);
echo $entry->start();
?>