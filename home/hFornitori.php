<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Car Finish - Fornitori</title>
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

    <div id="menu">
        <div class="pure-menu">
            <ul class="pure-menu-list">
                <li class="pure-menu-item"><a href="../index.html" class="pure-menu-link">LOGIN</a></li>
                <li class="pure-menu-item"><a href="home.php" class="pure-menu-link">Nuovi Dati</a></li>
                <li class="pure-menu-item"><a href="hOperazioni.php" class="pure-menu-link">Operazioni</a></li>	
          		<li class="pure-menu-item"><a href="hArticoli.php" class="pure-menu-link">Articoli</a></li>
          		<a class="pure-menu-heading" href="hFornitori.php">Fornitori</a>
          		<li class="pure-menu-item"><a href="hClienti.php" class="pure-menu-link">Clienti</a></li>
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h2>Info fornitori</h2>
        </div>       
        <div class="content">
        
            <form class="pure-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<fieldset>
					<legend>Scegli fornitore</legend>
					<select class="pure-u-md-1 pure-u-sm-1" name="forn">
						<option value="TUTTI">TUTTI</option>
						<?php								
							$con = mysql_connect("localhost","carfinish","");
							$db = mysql_select_db("my_carfinish", $con);
							$q = "SELECT nomF FROM fornitori ORDER BY nomF";
							$ris = mysql_query($q);
							while($riga = mysql_fetch_array($ris))
							{
								echo ("<option value=\"".$riga["nomF"]."\">".$riga["nomF"]."</option>");
							}
						?>
					</select>
					<button type="submit" class="pure-button pure-button-primary" name="cerca">Cerca</button>
				</fieldset>
		    </form>
            <?php
				function tutti()
				{
					$q = "SELECT * FROM fornitori ORDER BY nomF"; 
					$ris = mysql_query($q);
					?>

					<table class="pure-table pure-table-bordered">
					<caption style="font: bold 20px 'Oswald'; color: rgb(0, 120, 231); text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);">Rubrica</caption> 
					<thead>
						<tr align="center">
							<th>Nome</th>
							<th>Sede</th>
							<th>Debito</th>
							<th>Telefono</th>
						</tr>
					</thead>
					<?php

					$i=0;
					while($riga = mysql_fetch_array($ris))
					{
						if($i%2==0)
						{
							echo "<tr align=\"center\"> \n";
						}
						else
						{
							echo "<tr class=\"pure-table-odd\" align=\"center\"> \n";
						}
						echo "<td>" . $riga["nomF"] . "</td> \n";
						echo "<td>" . $riga["sede"] . "</td> \n";
						echo "<td>" . $riga["debito"] . " &euro;</td> \n";
						echo "<td>" . $riga["telF"] . "</td> \n";
						echo "</tr> \n";
						$i=$i+1;
					}
					echo("</table>");
				}
			?>
            
            <?php
				if(!isset($_POST["cerca"])) tutti();
				if(isset($_POST["cerca"]))
				{
					$forn = $_POST["forn"];
					if ($forn != "TUTTI")
					{
						$q = "SELECT debito, SUM(qtaF) as totAR, AVG(som) as mediaSP FROM fornitori, forniture WHERE codF = fornitore AND nomF = '".$forn."'";
						$q1 = "SELECT COUNT(ticF) as conti FROM fornitori, forniture WHERE codF = fornitore AND nomF = '".$forn."' and somP = 0.0";
						$query = mysql_query($q);
						$query1 = mysql_query($q1);
						$ris1 = mysql_fetch_array($query1);
						$conti = $ris1["conti"];
						
						?>
						
						<table class="pure-table pure-table-bordered">
						<?php
						echo "<caption style=\"font: bold 20px 'Oswald'; color: rgb(0, 120, 231); text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);\">".$forn."</caption>"; 
						?>
						<thead>
							<tr align="center">
								<th>Debito</th>
								<th>Conti non pagati</th>
								<th>Totale articoli</th>
								<th>Spesa media</th>
							</tr>
						</thead>
						<?php
							$riga = mysql_fetch_array($query);
							$mediaSP = round($riga["mediaSP"],2);
							
							echo "<tr align=\"center\"> \n";
							echo "<td>" . $riga["debito"] . " &euro;</td> \n";
							echo "<td>" . $conti . "</td> \n";
							echo "<td>" . $riga["totAR"] . "</td> \n";
							echo "<td>" . $mediaSP . " &euro;</td> \n";
							echo "</tr> \n";
							echo "</table>";
						
						$q = "SELECT dataF, qtaF, metodoP, som, somP, articolo, nomA, num FROM fornitori, forniture, articoli WHERE codF = fornitore AND articolo = CodA AND nomF ='".$forn."' AND som != \"NULL\" ORDER BY num";
						$q1 = "SELECT dataF, metodoP, somP FROM fornitori, forniture WHERE codF = fornitore AND nomF ='".$forn."' AND metodoP != \"NULL\" ORDER BY dataF";
						$p = mysql_query($q);
						$p1 = mysql_query($q1);
						?>
						<table class="pure-table pure-table-bordered">
						<caption style="font: bold 20px 'Oswald'; color: rgb(0, 120, 231); text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);">Elenco forniture</caption>
						<thead>
							<tr align="center">
								<th>Data</th>
								<th>Quantit&agrave;</th>
								<th>Codice</th>
								<th>Articolo</th>
								<th>Totale</th>
								<th>Somma pagata</th>
								<th>Metodo</th>
							</tr>
						</thead>
						<?php
						$i=-1;
						$j=-1;
						while($riga = mysql_fetch_array($p))
						{
							if ($riga["num"]!=$j)
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

							echo "<td>" . $riga["dataF"] . "</td> \n";
							echo "<td>" . $riga["qtaF"] . "</td> \n";
							echo "<td>" . $riga["articolo"] . "</td> \n";
							echo "<td>" . $riga["nomA"] . "</td> \n";
							echo "<td>" . $riga["som"] . " &euro;</td> \n";
							echo "<td>" . $riga["somP"] . " &euro;</td> \n";
							echo "<td>" . $riga["metodoP"] . "</td> \n";
							echo "</tr> \n";
							$j = $riga["num"];
						}
						echo("</table> <p>Ogni colore corrisponde a una diversa fornitura</p>");

						?>
						<table class="pure-table pure-table-bordered">
						<caption style="font: bold 20px 'Oswald'; color: rgb(0, 120, 231); text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);">Elenco pagamenti</caption>
						<thead>
							<tr align="center">
								<th>Data</th>
								<th>Somma pagata</th>
								<th>Metodo</th>
							</tr>
						</thead>
						<?php
						$i=0;
						while($riga1 = mysql_fetch_array($p1))
						{
							if($i%2==0)
							{
								echo "<tr align=\"center\"> \n";
							}
							else
							{
								echo "<tr class=\"pure-table-odd\" align=\"center\"> \n";
							}
							echo "<td>" . $riga1["dataF"] . "</td> \n";
							echo "<td>" . $riga1["somP"] . " &euro;</td> \n";
							echo "<td>" . $riga1["metodoP"] . "</td> \n";
							$i++;
						}
						echo("</table>");
					}
					elseif ($forn == "TUTTI")
					{
						tutti();
					}
				}
			?>
                    
        </div>
    </div>
</div>

<script src="js/ui.js"></script>

</body>
</html>
