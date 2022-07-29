<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Fornitura</title>
</head>
<body>
<?php
	
	$hostname="localhost";
    $username="carfinish";
    $password="";
	
    $con = mysql_connect($hostname,$username,$password);
    $db = mysql_select_db("my_carfinish", $con);
	
	$som = $_POST["somma"];
	$cli = $_POST["cli"];
	
	$q = "SELECT codC FROM clienti WHERE nomC = '".$cli."'";
	$p = mysql_query($q);
	$ris = mysql_fetch_array($p);
	$cli = $ris["codC"];
	
	$q1 = "UPDATE clienti SET conto = conto - '$som' WHERE codC = '".$cli."'";
	mysql_query($q1);
	
	mysql_close($con);
	header("Location: hClienti.php");
?>
</body>
</html>