<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>insF</title>
</head>
<body>

<?php
    $hostname="localhost";
    $username="carfinish";
    $password="";
	
    $con = mysql_connect($hostname,$username,$password);
    $db = mysql_select_db("my_carfinish", $con);
	
	$nome = ucfirst($_POST["nome"]);
	$sede = ucfirst($_POST["sede"]);
	$tel = ucfirst($_POST["tel"]);
	
	$q = "INSERT INTO fornitori (nomF, sede, telF) VALUES ('".$nome."', '".$sede."', '".$tel."')";
	mysql_query($q);
	
	header("Location: home.php");
	
	mysql_close($con);
?>

</body>
</html>