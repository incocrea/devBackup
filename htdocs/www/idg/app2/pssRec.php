<?php
echo "hi yo";
return
$method = $_GET["method"];
$method();

function pssRec()
{
	$get_info = new sql_query();
	
	$userEmail = $_GET["me"];
	$userType = $_GET["type"];
	$unique = $_GET["tmpkey"];
	$actualLang = $_GET["lang"];
	
	$langFile = parse_ini_file("lang/lang.ini", true);
	$lang = $langFile[$actualLang];
	
	$confirm = $get_info->query("SELECT MAIL FROM users WHERE users.BMAIL = '".$userEmail."' AND CODE = '".$unique."'");
	
	if(count($confirm) > 0)
	{
		echo 	"
					
					<link href='libs/modal/modal.css' rel='stylesheet'/>
					<script src = 'libs/modal/modal.js'></script>
					<link href='css/main.css' rel='stylesheet'>
					<div class='pssRecMain'> 
						<div>
							<img src='irsc/mainLogo.png'/>
							<br>
							<input id='pass1' type='text'/>
							<br>
							<button id='sendButton' onclick='sendRec()'></button>
						</div>
					</div>
					
					<div id = 'box' class = 'modalCoverHidden'>
					<div id = 'modalBox' class = 'modal'>
						<div id = 'boxHeader' class = 'modalHeader'>
							<span id = 'boxTitle' class = 'modalTitle'>
							</span>
							</div>
							<div id = 'boxContent' class = 'modalContent'>
							</div>
						</div>
						<div id = 'buttonsDiv'></div>
					</div>
					
					<script>

						// SN
						
						language = JSON.parse(localStorage.getItem('tmpL'));
						
						document.getElementById('pass1').placeholder = '".$lang["newPass"]."';
						document.getElementById('sendButton').innerHTML = '".$lang["send"]."';
						
						
						function sendRec()
						{
							var pass1 = document.getElementById('pass1').value;
							
							if(pass1.length < 6)
							{
								alertBox('".$lang["alert"]."', '".$lang["sys007"]."', 300, '".$lang["accept"]."');
								return;
							}
							
							if( pass1.match(/[\<\>!#\$%^&\*,]/) ) 
							{
								alertBox('".$lang["alert"]."', '".$lang["sys008"]."', 300, '".$lang["accept"]."');
								return;
							}
							
							
							if(pass1 == ''){alertBox('".$lang["alert"]."','".$lang["mustNewPass"]."', 300, '".$lang["accept"]."'); return;}
							window.location.replace('http://www.sherbim.co/pssRec.php?method=setPass&lang=".$actualLang."&m=".$userEmail."&k=".$unique."&nk='+pass1+'');
						}
						
						history.pushState({}, '', '?recover');
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
	
	$langFile = parse_ini_file("lang/lang.ini", true);
	$lang = $langFile[$actualLang];
	
	$confirm = $get_info->query("SELECT MAIL FROM users WHERE MAIL = '".$userEmail."' AND CODE = '".$unique."'");
	
	if(count($confirm) > 0)
	{
	
		$setnk = $get_info->query("UPDATE users SET PASSWD='".$nk."' WHERE MAIL = '".$userEmail."' AND CODE = '".$unique."'");
		
		echo "
	
			
			<link href='libs/modal/modal.css' rel='stylesheet'/>
			<script src = 'libs/modal/modal.js'></script>
			<link href='css/main.css' rel='stylesheet'>
			<div class='pssRecMain'> 
				<div>
					<img src='irsc/mainLogo.png'/>
					<br>
					<span id='mess' style='color: #ffffff; font-weight: bold;'></span>
					<br>
					<br>
					<button id='goHome' onclick='goHome()'></button>
				</div>
			</div>
			
			<script>
				//language = JSON.parse(localStorage.getItem('tmpL'));
				
				document.getElementById('mess').innerHTML = '".$lang["succesNk"]."';
				document.getElementById('goHome').innerHTML = '".$lang["goHome"]."';
				
				function goHome()
				{
					window.location.replace('http://www.sherbim.co/app');
				}
				
				history.pushState({}, '', '?recover');
				
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
			$db = "sherbim2016";
			$user = "sherbimadmin";
			$pssw = "Harolito2015";

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