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
          		<li class="pure-menu-item"><a href="uStorico.php" class="pure-menu-link">Storico</a></li>
          		<a class="pure-menu-heading" href="uVerifica.php">Disponibilit&aacute;</a>          		
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h2>Verifica disponibilt&aacute; articoli</h2>
        </div>       
        <div class="content">
        	<form class="pure-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<fieldset>
					<legend>Scegli articolo</legend>
					<select class="pure-u-md-1 pure-u-sm-1" name="art">
						<option value="CONSIGLIATI">CONSIGLIATI</option>
						<?php								
							$q = "SELECT nomA FROM articoli ORDER BY nomA";
							$ris = mysql_query($q);
							while($riga = mysql_fetch_array($ris))
							{
								echo ("<option value=\"".$riga["nomA"]."\">".$riga["nomA"]."</option>");
							}
						?>
					</select>
					<button type="submit" class="pure-button pure-button-primary" name="cerca">Cerca</button>
				</fieldset>
		    </form>
            
            <?php
				function consigliati()
				{
					$a = "SELECT utente FROM accessi WHERE idK = 1";
					$aq = mysql_query($a);
					$res = mysql_fetch_array($aq);
					$codC = $res["utente"];
					$q = "SELECT DISTINCT codA, nomA, descr, preVe, scorta FROM articoli, vendite WHERE codA = idA AND idC = '".$codC."' ORDER BY codA"; 
					$ris = mysql_query($q);
					?>

					<table class="pure-table pure-table-bordered">
					<caption style="font: bold 20px 'Oswald'; color: rgb(0, 120, 231); text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);">Articoli acquistati pi&uacute; spesso</caption> 
					<thead>
						<tr align="center">
							<th>Codice</th>
							<th>Nome</th>
							<th>Descrizione</th>
							<th>Prezzo</th>
							<th>Disponibilit&aacute;</th>
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
						echo "<td>" . $riga["codA"] . "</td> \n";
						echo "<td>" . $riga["nomA"] . "</td> \n";
						echo "<td>" . $riga["descr"] . "</td> \n";
						echo "<td>" . $riga["preVe"] . "</td> \n";
						$scorta = $riga["scorta"];
						if ($scorta > 10)
						{
							echo "<td style=\"background-color: #00E100; color: white\">Disponibile</td> \n";
						}
						elseif ($scorta <= 10)
						{
							if ($scorta < 1)
							{
								echo "<td style=\"background-color: #FF3333; color: white\">Terminato</td> \n";
							}
							else
							{
								echo "<td style=\"background-color: #FFBF18; color: white\">In esaurimento</td> \n";
							}
						}
						echo "</tr> \n";
						$i=$i+1;
					}
					echo("</table>");
				}
			?>
                
            <?php
				if(!isset($_POST["cerca"])) consigliati();
				if(isset($_POST["cerca"]))
				{
					$art = $_POST["art"];
					if ($art != "CONSIGLIATI")
					{
						$q = "SELECT codA, nomA, descr, preVe, scorta FROM articoli WHERE nomA = '".$art."' ORDER BY codA"; 
						$ris = mysql_query($q);
						?>

						<table class="pure-table pure-table-bordered">
						<caption style="font: bold 20px 'Oswald'; color: rgb(0, 120, 231); text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);">
						<?php
							echo($art);
						?>
						</caption> 
						<thead>
							<tr align="center">
								<th>Codice</th>
								<th>Nome</th>
								<th>Descrizione</th>
								<th>Prezzo</th>
								<th>Disponibilit&aacute;</th>
							</tr>
						</thead>
						<?php
						while($riga = mysql_fetch_array($ris))
						{
							echo "<tr align=\"center\"> \n";
							echo "<td>" . $riga["codA"] . "</td> \n";
							echo "<td>" . $riga["nomA"] . "</td> \n";
							echo "<td>" . $riga["descr"] . "</td> \n";
							echo "<td>" . $riga["preVe"] . "</td> \n";
							$scorta = $riga["scorta"];
							if ($scorta > 10)
							{
								echo "<td style=\"background-color: #00E100; color: white\">Disponibile</td> \n";
							}
							elseif ($scorta <= 10)
							{
								if ($scorta < 1)
								{
									echo "<td style=\"background-color: #FF3333; color: white\">Terminato</td> \n";
								}
								else
								{
									echo "<td style=\"background-color: #FFBF18; color: white\">In esaurimento</td> \n";
								}
							}
							echo "</tr> \n";
						}
						echo("</table>");					
					}
					elseif ($art == "CONSIGLIATI")
					{
						consigliati();
					}
				}
			?>          
        </div>
    </div>
</div>

<script src="js/ui.js"></script>

</body>
</html>
