<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>insA</title>
</head>
<body>

<?php
    $hostname="localhost";
    $username="carfinish";
    $password="";
	
    $con = mysql_connect($hostname,$username,$password);
    $db = mysql_select_db("my_carfinish", $con);
	
	$cod = strtoupper($_POST["cod"]);
	$nome = ucfirst($_POST["nome"]);
	$descr = ucfirst($_POST["descr"]);
	$forn = ucfirst($_POST["forn"]);
	$pa = ucfirst($_POST["pa"]);
	$pv = ucfirst($_POST["pv"]);
	
	$qu = "SELECT * FROM fornitori WHERE nomF = '".$forn."'";
	$query = mysql_query($qu);
	$ris = mysql_fetch_array($query);
	$fo = $ris["codF"];
	
	$q = "INSERT INTO articoli (codA, nomA, descr, preAq, preVe, idF) VALUES ('".$cod."', '".$nome."', '".$descr."', '".$pa."', '".$pv."', '".$fo."')";
	mysql_query($q);
	
	header("Location: home.php");
	
	mysql_close($con);
?>

</body>
</html>