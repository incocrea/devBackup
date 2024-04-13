<?php

class sql_query
{
	private $pg;
	function __construct()
	{
		// De la ruta de archivos extraigo el nombre del directorio
		$paths = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
		array_pop($paths); // Saco el directorio php
		array_pop($paths); // Saco el directorio libs
		// Saco el directorio base que estoy buscando
		$base = array_pop($paths); // Obtengo el nombre del directorio base
		// Con el nombre determino cual es el entorno.
		// En caso del entorno de produccion usamos las creds de produccion.
		switch ($base) {
			// Entorno de produccion
			case 'itsfree':
				$host = "localhost";
				$db = "itsfree";
				$user = "adminCultivarte";
				$pssw = "harolito2";
				break;
			// Entorno de pruebas
			case 'itsfreeDev':
				$host = "localhost";
				$db = "itsfreeDev";
				$user = "algratin";
				$pssw = "4lgr4t1n";
				break;
			default:
				// $host = "localhost";
				// $db = "cempac2";
				// $user = "adminCultivarte";
				// $pssw = "harolito2";
				
				$host = "localhost";
				$db = "cempac2";
				$user = "root";
				$pssw = "";
				break;
		}
		try
		{
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