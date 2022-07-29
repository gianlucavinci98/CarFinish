<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<?php
  $hostname="localhost";
  $username="root";
  $password="";

  $connessione = mysql_connect($hostname,$username,$password);
  $db = mysql_select_db("carfinish", $connessione);

  if(isset($_POST['user']))
  {
	  $user = $_POST["user"];
	  $passw = $_POST["passw"];

	  $p = "SELECT * FROM clienti WHERE user ='".$user."'";
	  $query1=mysql_query($p);
	  $num = mysql_num_rows ($query1);

	  if ($num == 0)
	  {
		  header("Location: ./NegLogin.html");
	  }
	  else
	  {
		  $result = mysql_fetch_array($query1);
		  $pas=$result["passw"];

		  if ($pas == $passw)
		  {
			  $livello=$result["livello"];

			  if ($livello == 1)
			  {
				  $codC = $result["codC"];
				  $q = "UPDATE accessi SET cont = cont + 1, utente = '".$codC."' WHERE idK = 1";
				  mysql_query($q);
				  header("Location: ../home/uStorico.php");
				  mysql_close($connessione);
				  exit();
			  }
			  if ($livello == 2)
			  {
				  header("Location: ../home/home.php");
				  mysql_close($connessione);
				  exit();
			  }
		  }
		  else
		  {
			  header("Location: ./NegLogin.html");
		  }
	  }
 }
 mysql_close($connessione);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>logPHP</title>
</head>
<body>
</body>
</html>
