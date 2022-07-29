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
	
	$cod = strtoupper($_POST["cod"]);
	$cl = ($_POST["cl"]);
	$qta = ($_POST["qta"]);
	$sco = ($_POST["sco"]);
	$id = ($_POST["id"]);
	
	$qu = "SELECT * FROM clienti WHERE nomC = '".$cl."'";
	$query = mysql_query($qu);
	$ris = mysql_fetch_array($query);
	$icl = $ris["codC"];
	
	$data = date("Y-m-d");
	echo($data);
	
	$q = "SELECT preVe FROM articoli WHERE codA = '".$cod."'";
	$query = mysql_query($q);
	$ris = mysql_fetch_array($query);
	$preVe = $ris["preVe"];
	
	$tot = $preVe * $qta;
	
	if (isset($_POST["sco"]))
	{
		$perc = $tot * $sco / 100;
		$tot = $tot - $perc;
	}
	
	$q = "INSERT INTO vendite (dataV, qtaV, idA, idC, id, costo) VALUES ('$data', '".$qta."', '".$cod."', '".$icl."', '".$id."', '".$tot."')";
	mysql_query($q);
	
	$q1 = "UPDATE clienti SET conto = conto + '$tot' WHERE codC = '".$icl."'";
	mysql_query($q1);
	$q2 = "UPDATE articoli SET scorta = scorta - '$qta' WHERE codA = '".$cod."'";
	mysql_query($q2);
	
	header("Location: hOperazioni.php");
	
?>
</body>
</html>