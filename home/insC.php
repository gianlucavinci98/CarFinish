<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>insC</title>
</head>
<body>

<?php
    $hostname="localhost";
    $username="carfinish";
    $password="";
	
    $con = mysql_connect($hostname,$username,$password);
    $db = mysql_select_db("my_carfinish", $con);
	
	$nome = ucfirst($_POST["nome"]);
	$citta = ucfirst($_POST["citta"]);
	$ind = ucfirst($_POST["ind"]);
	$tel = ucfirst($_POST["tel"]);
	
	$q = "INSERT INTO clienti (nomC, citta, indirizzo, telC) VALUES ('".$nome."', '".$citta."', '".$ind."', '".$tel."')";
	mysql_query($q);
	 
	header("Location: home.php");
	
	mysql_close($con);
?>

</body>
</html>