<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Car Finish - Storico</title>
    <style>@import url('https://fonts.googleapis.com/css?family=Anton|Oswald');</style>
    <link rel="stylesheet" href="../pure/pure.css">    
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
        <![endif]-->
        <!--[if gt IE 8]><!-->
            <link rel="stylesheet" href="css/layouts/side-menu.css">
        <!--<![endif]-->
</head>
<body>
<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>
	<?php
		$con = mysql_connect("localhost","carfinish","");
		$db = mysql_select_db("my_carfinish", $con);
		$a = "SELECT nomC FROM accessi, clienti WHERE utente = codC AND idK = 1";
		$aq = mysql_query($a);
		$res = mysql_fetch_array($aq);
		$nomC = $res["nomC"];
    ?>
    <div id="menu">
        <div class="pure-menu">
            <ul class="pure-menu-list">
          		<li class="pure-menu-item"><a href="../index.html" class="pure-menu-link"><?php echo(strtoupper($nomC)); ?></a></li>
          		<a class="pure-menu-heading" href="uStorico.php">Storico acquisti</a>
          		<li class="pure-menu-item"><a href="uVerifica.php" class="pure-menu-link">Disponibilit&aacute;</a></li>
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h2>Storico acquisti</h2>
        </div>       
        
        <div class="content"> 
       		<form class="pure-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<fieldset>
					<legend>Seleziona periodo</legend>
					<input type="month" name="month">
					<button type="submit" class="pure-button pure-button-primary" name="cerca">Cerca</button>
				</fieldset>
		    </form>
       		<?php
				$con = mysql_connect("localhost","carfinish","");
				$db = mysql_select_db("my_carfinish", $con);
			
				if(isset($_POST["cerca"]))
				{
					$month = $_POST["month"];	;
					$anno = substr($month,0,4);
					$mese = substr($month,5,2);
					$mydate1 = $anno."-".$mese."-01";
					$mydate2 = $anno."-".$mese."-31";
					
					$a = "SELECT utente FROM accessi WHERE idK = 1";
					$aq = mysql_query($a);
					$res = mysql_fetch_array($aq);
					$codC = $res["utente"];
					
					$q = "SELECT dataV, qtaV, costo, idA, nomA, id FROM clienti, vendite, articoli WHERE codC = idC AND idA = CodA AND idC ='".$codC."' AND dataV BETWEEN '".$mydate1."' AND '".$mydate2."' ORDER BY id";
					$p = mysql_query($q);		
			?>
						<table class="pure-table pure-table-bordered">
						<caption style="font: bold 20px 'Oswald'; color: rgb(0, 120, 231); text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);">Aqcuisti</caption>
						<thead>
							<tr align="center">
								<th>Data</th>
								<th>Quantit&agrave;</th>
								<th>Codice</th>
								<th>Articolo</th>
								<th>Totale</th>
							</tr>
						</thead>
						<?php
						$i=-1;
						$j=-1;
						while($riga = mysql_fetch_array($p))
						{
							if ($riga["id"]!=$j)
							{
								$i++;
								if ($i==3) $i=0;
							}
							switch($i)
							{
								case 0:
									echo "<tr align=\"center\" bgcolor=\"#2181FF\" style=\"color: white\"> \n";
									break;
								case 1:
									echo "<tr align=\"center\" bgcolor=\"#4141FF\" style=\"color: white\"> \n";
									break;
								case 2:
									echo "<tr align=\"center\" bgcolor=\"#4000A2\" style=\"color: white\"> \n";
									break;
							}
							$dataV = $riga["dataV"];
							$annoV = substr($dataV,2,2);
							$meseV = substr($dataV,5,2);
							$giornoV = substr($dataV,8,2);
							$dataV = $giornoV."/".$meseV."/".$annoV;
							echo "<td>" . $dataV . "</td> \n";
							echo "<td>" . $riga["qtaV"] . "</td> \n";
							echo "<td>" . $riga["idA"] . "</td> \n";
							echo "<td>" . $riga["nomA"] . "</td> \n";
							echo "<td>" . $riga["costo"] . " &euro;</td> \n";
							$j = $riga["id"];
						}
						echo("</table> <p>Ogni colore corrisponde a una diversa fornitura</p>");
				}
			?>
        </div>
        
    </div>
</div>

<script src="js/ui.js"></script>

</body>
</html>
