<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Car Finish - Clienti</title>
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
          		<li class="pure-menu-item"><a href="hFornitori.php" class="pure-menu-link">Fornitori</a></li>
          		<a class="pure-menu-heading" href="hClienti.php">Clienti</a>          		
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h2>Info clienti</h2>
        </div>       
        <div class="content">
        
             <form class="pure-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<fieldset>
					<legend>Scegli cliente</legend>
					<select class="pure-u-md-1 pure-u-sm-1" name="cl">
						<option value="TUTTI">TUTTI</option>
						<?php								
							$con = mysql_connect("localhost","carfinish","");
							$db = mysql_select_db("my_carfinish", $con);
							$q = "SELECT nomC FROM clienti WHERE nomC != \"NULL\" ORDER BY nomC";
							$ris = mysql_query($q);
							while($riga = mysql_fetch_array($ris))
							{
								echo ("<option value=\"".$riga["nomC"]."\">".$riga["nomC"]."</option>");
							}
						?>
					</select>
					<button type="submit" class="pure-button pure-button-primary" name="cerca">Cerca</button>
				</fieldset>
		    </form>
            
            <?php
				function tutti()
				{
					?>
						<form class="pure-form" action="aggDeb.php" method="post">
						<fieldset>
							<legend>Somma pagamento</legend>
							<div align="center" class="pure-g">
								<select class="pure-u-md-1 pure-u-sm-1" name="cli">
									<?php								
										$z = "SELECT nomC FROM clienti WHERE nomC != \"NULL\" ORDER BY nomC";
										$res = mysql_query($z);
										while($riga = mysql_fetch_array($res))
										{
											echo ("<option value=\"".$riga["nomC"]."\">".$riga["nomC"]."</option>");
										}
									?>
								</select>&emsp;
								<input class="pure-u-md-1-3 pure-u-sm-1" type="text" name="somma" placeholder="&euro;" size="10em">&emsp;
								<button type="submit" class="pure-button pure-button-primary" name="agg">Aggiorna</button>
							</div>
						</fieldset>
						</form>
					<?php
					$q = "SELECT * FROM clienti WHERE nomC != \"NULL\" ORDER BY nomC"; 
					$ris = mysql_query($q);
					?>

					<table class="pure-table pure-table-bordered">
					<caption style="font: bold 20px 'Oswald'; color: rgb(0, 120, 231); text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);">Rubrica</caption> 
					<thead>
						<tr align="center">
							<th>Intestazione</th>
							<th>Citt&agrave;</th>
							<th>Indirizzo</th>
							<th>Telefono</th>
							<th>Conto</th>
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
						echo "<td>" . $riga["nomC"] . "</td> \n";
						echo "<td>" . $riga["citta"] . "</td> \n";
						echo "<td>" . $riga["indirizzo"] . "</td> \n";
						echo "<td>" . $riga["telC"] . "</td> \n";
						echo "<td>" . $riga["conto"] . "  &euro;</td> \n";
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
					$cl = $_POST["cl"];
					if ($cl != "TUTTI")
					{
						$q = "SELECT conto, SUM(qtaV) as totAR, AVG(costo) as mediaSP FROM clienti, vendite WHERE codC = idC AND nomC = '".$cl."'";
						$query = mysql_query($q);
						?>
						
						<table class="pure-table pure-table-bordered">
						<?php
						echo "<caption style=\"font: bold 20px 'Oswald'; color: rgb(0, 120, 231); text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);\">".$cl."</caption>"; 
						?>
						<thead>
							<tr align="center">
								<th>Debito</th>
								<th>Totale articoli</th>
								<th>Spesa media</th>
							</tr>
						</thead>
						<?php
							$riga = mysql_fetch_array($query);
							$mediaSP = round($riga["mediaSP"],2);
							
							echo "<tr align=\"center\"> \n";
							echo "<td>" . $riga["conto"] . " &euro;</td> \n";
							echo "<td>" . $riga["totAR"] . "</td> \n";
							echo "<td>" . $mediaSP . " &euro;</td> \n";
							echo "</tr> \n";
							echo "</table>";
						
						$q = "SELECT dataV, qtaV, costo, idA, nomA, id FROM clienti, vendite, articoli WHERE codC = idC AND idA = CodA AND nomC ='".$cl."' ORDER BY id";
						$p = mysql_query($q);
						?>
						<table class="pure-table pure-table-bordered">
						<caption style="font: bold 20px 'Oswald'; color: rgb(0, 120, 231); text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);">Elenco vendite</caption>
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
					elseif ($cl == "TUTTI")
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
