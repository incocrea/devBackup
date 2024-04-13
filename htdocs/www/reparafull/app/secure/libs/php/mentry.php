<?php
ini_set('MAX_EXECUTION_TIME', 3600);
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("cryptojs-aes.php");

class entryPoint{
	private $params;
	private $key = "bc01ns2017";
	function __construct($info)
	{
		if(isset($_POST["info"]))
		{
			// UNCOMMENT FOR ENCRYPT
			// $this->params = cryptoJsAesDecrypt($this->key, $_POST["info"]);
			
			// UNCOMMENT FOR DEVELOPMENT
			$this->params = json_decode($_POST["info"], true);
		}
		else
		{
			// UNCOMMENT FOR ENCRYPT
			// $this->params = cryptoJsAesDecrypt($this->key, file_get_contents("php://input"));
			
			$this->params = json_decode(file_get_contents("php://input"), true);
		}
	}
	function start()
	{
		require_once "dataBase.php";
		require_once $this->params["class"].".php";

		$class = $this->params["class"];
		$instancia = new $class(); 
		$method = $this->params["method"];

		try
		{
			$exec = $instancia->$method($this->params["data"]);
			$resp = array(	"data"=>$exec, "exception"=>"");
			
			// UNCOMMENT FOR ENCRYPT
			// return cryptoJsAesEncrypt($this->key, $resp);
			
			// UNCOMMENT FOR DEVELOPMENT
			return json_encode($resp);	
		}
		catch(Exception $e)
		{
			$resp = array(	"data"=>$exec,"exception"=>$e->getMessage());
			// UNCOMMENT THIS FOR DEPLOY
			// return cryptoJsAesEncrypt($this->key, $resp);
			return json_encode($resp);	
		}
	}
}
$entry = new entryPoint($_POST);
echo $entry->start();
?>