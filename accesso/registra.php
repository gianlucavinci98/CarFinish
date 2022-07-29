<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>logPHP</title>
</head>
<body>

<?php
	$hostname="localhost";
    $username="carfinish";
    $password="";
	
	$connessione = mysql_connect("localhost","carfinish","");
	$db=mysql_select_db("my_carfinish", $connessione );
	
	if(isset($_POST['regUser']))
	{
		$user = $_POST["regUser"];
		$passw = $_POST["regPassw"];
		$codice = $_POST["codice"];
		  
		$p = "SELECT * FROM clienti WHERE codC ='". $codice . "'";
		$query1=mysql_query($p);
		$num = mysql_num_rows ($query1);
		$ris = mysql_fetch_array($query1);
		$utente = $ris["user"];
		
		if ($num == 0)
	    {
			header("Location: NegReg.html");
		}
		else
	    {
			if ($utente == NULL)
			{
				$p1 = "UPDATE clienti SET user='".$user."', passw='".$passw."' WHERE codC='".$codice."'";
				$query2=mysql_query($p1);
				header("Location: ../index.html");
			}
			else
			{
				header("Location: NegReg.html");
			}
		}
	}
	mysql_close($connessione);
?>

</body>
</html>