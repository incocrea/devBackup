<?php

$method = $_GET["method"];
$method();

function pssRec()
{
	$get_info = new sql_query();
	
	$userEmail = $_GET["me"];
	$unique = $_GET["tmpkey"];
	$actualLang = $_GET["lang"];
	
	$langFile = parse_ini_file("app/lang/lang.ini", true);
	$lang = $langFile[$actualLang];
	
	$confirm = $get_info->query("SELECT users.EMAIL FROM users WHERE users.EMAIL = '".$userEmail."' AND users.UCODE = '".$unique."'");
	
	// var_dump $langFile;
	
	if(count($confirm) > 0)
	{
		echo 	"
					
					<link href='app/libs/modal/modal.css' rel='stylesheet'/>
					<script src = 'app/libs/modal/modal.js'></script>
					<link href='app/css/main.css' rel='stylesheet'>
					<script src='app/js/jquery-1.12.0.min.js'></script>
					<div class='pssRecMain'> 
						<div>
							<img src='app/irsc/mainLogo2.png'/>
							<br>
							<input id='pass1' type='text'/>
							<br>
							<button id='sendButton' onclick='sendRec()'></button>
						</div>
					</div>
					
					<div id = 'box' class = 'modalCoverHidden'>
				
						<div id='closeBa' class='closeB' onclick='hide_pop()'></div>

						<div id = 'modalBox' class = 'modalT'>
						
							<div id = 'boxHeader' class = 'modalHeader'>
								<span id = 'boxTitle' class = 'modalTitle'></span>
							</div>
							
							<div id = 'boxContent' class = 'modalContent'></div>
							
						</div>
						
					</div>
					
					<script>
						
						actualMainColor = '#272E36';
						
						document.getElementById('pass1').placeholder = '".$lang["newPass"]."';
						document.getElementById('sendButton').innerHTML = '".$lang["send"]."';
						
						
						function sendRec()
						{
							var pass1 = document.getElementById('pass1').value;
							
							if(pass1.length < 6)
							{
								alertBox('".$lang["alert"]."', '".$lang["sys007x"]."', 300, '".$lang["accept"]."');
								return;
							}
							
							if( pass1.match(/[\<\>!#\$%^&\*,]/) )
							{
								alertBox('".$lang["alert"]."', '".$lang["sys008x"]."', 300, '".$lang["accept"]."');
								return;
							}
							
							
							
							window.location.replace('https://www.brazilcocoa.com/pssRec.php?method=setPass&lang=".$actualLang."&m=".$userEmail."&k=".$unique."&nk='+pass1+'');
						}
						
						//history.pushState({}, '', '?recover');
					</script>
					
				";
	}
	else
	{
		echo "Access Denied 404";
	}
		
}

function setPass()
{
	$get_info = new sql_query();
	$userEmail = $_GET["m"];
	$unique = $_GET["k"];
	$nk = md5($_GET["nk"]);
	
	$actualLang = $_GET["lang"];
	
	$langFile = parse_ini_file("app/lang/lang.ini", true);
	$lang = $langFile[$actualLang];
	
	$confirm = $get_info->query("SELECT users.EMAIL FROM users WHERE users.EMAIL = '".$userEmail."' AND users.UCODE = '".$unique."'");
	
	
	if(count($confirm) > 0)
	{
	
		$setnk = $get_info->query("UPDATE users SET PASSWD='".$nk."' WHERE users.EMAIL = '".$userEmail."' AND users.UCODE = '".$unique."'");
		
		echo "
	
			
			<link href='app/libs/modal/modal.css' rel='stylesheet'/>
			<script src = 'app/libs/modal/modal.js'></script>
			
			<link href='app/css/main.css' rel='stylesheet'>
			<div class='pssRecMain'> 
				<div>
					<img src='app/irsc/mainLogo2.png'/>
					<br>
					<span id='mess'>Listo, se ha establecido la nueva contraseña</span>
					<br>
					<br>
					<button id='goHome' onclick='goHome()'>Ir a Mundo Brazil Cocoa</button>
				</div>
			</div>
			
			<script>
								
				function goHome()
				{
					window.location.replace('https://www.brazilcocoa.com/app/');
				}
				
				//history.pushState({}, '', '?recover');
				
			</script>

			";
	}
	else
	{
		echo "Access Denied 404";
	}

	
	
	
}

class sql_query
{
	private $pg;
	function __construct()
	{
		try
		{
			$host = "localhost";
			$db = "bcoins";
			$user = "adminCultivarte";
			$pssw = "harolito2";

			$this->pg = new PDO('mysql:host='.$host.';dbname='.$db.'', $user, $pssw);
			
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