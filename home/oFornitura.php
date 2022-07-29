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
	
	$data = date("d/m/y");
	
	if(isset($_POST["new"]))
	{
		$codA = strtoupper($_POST["codA"]);
		$qtaF = ($_POST["qtaF"]);
		$num = ($_POST["num"]);

		$qu = "SELECT idF FROM articoli WHERE codA = '".$codA."'";
		$query = mysql_query($qu);
		$ris = mysql_fetch_array($query);
		$idF = $ris["idF"];

		$q = "SELECT preAq FROM articoli WHERE codA = '".$codA."'";
		$query = mysql_query($q);
		$ris = mysql_fetch_array($query);
		$preAq = $ris["preAq"];

		$tot = $preAq * $qtaF;
		$som = 0;

		if(!isset($_POST["pag"]))
		{
			$q = "INSERT INTO forniture (dataF, qtaF, som, articolo, fornitore, num) VALUES ('".$data."', '".$qtaF."', '".$tot."', '".$codA."', '".$idF."', '".$num."')";
			mysql_query($q);
		}
		else
		{
			$met = ($_POST["met"]);
			$som = ($_POST["som"]);

			if($som =="FORNITURA PAGATA")
			{
				$som = $tot;
			}

			$q = "INSERT INTO forniture (dataF, qtaF, metodoP, som, somP, articolo, fornitore, num) VALUES ('".$data."', '".$qtaF."', '".$met."', '".$tot."', '".$som."', '".$codA."', '".$idF."', '".$num."')";
			mysql_query($q);
		}

		$tot = $tot - $som;

		$q1 = "UPDATE fornitori SET debito = debito + '$tot' WHERE codF = '".$idF."'";
		mysql_query($q1);

		$q2 = "UPDATE articoli SET scorta = scorta + '$qtaF' WHERE codA = '".$codA."'";
		mysql_query($q2);
	}
	else
	{
		$met = ($_POST["met"]);
		$pf = ($_POST["pf"]);
		$som = ($_POST["som"]);
		
		$qu = "SELECT codF FROM fornitori WHERE nomF = '".$pf."'";
		$query = mysql_query($qu);
		$ris = mysql_fetch_array($query);
		$codF = $ris["codF"];

		$q = "INSERT INTO forniture (dataF, metodoP, somP, fornitore) VALUES ('".$data."', '".$met."', '".$som."', '".$codF."')";
		mysql_query($q);
		
		$q1 = "UPDATE fornitori SET debito = debito - '$som' WHERE codF = '".$codF."'";
		mysql_query($q1);
	}
	
	header("Location: hOperazioni.php");
	
?>
</body>
</html>