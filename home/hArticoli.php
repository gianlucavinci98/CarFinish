<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Car Finish - Articoli</title>
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

    <div id="menu">
        <div class="pure-menu">
            <ul class="pure-menu-list">
                <li class="pure-menu-item"><a href="../index.html" class="pure-menu-link">LOGIN</a></li>
                <li class="pure-menu-item"><a href="home.php" class="pure-menu-link">Nuovi Dati</a></li>
                <li class="pure-menu-item"><a href="hOperazioni.php" class="pure-menu-link">Operazioni</a></li>
          		<a class="pure-menu-heading" href="hArticoli.php">Articoli</a>
          		<li class="pure-menu-item"><a href="hFornitori.php" class="pure-menu-link">Fornitori</a></li>
          		<li class="pure-menu-item"><a href="hClienti.php" class="pure-menu-link">Clienti</a></li>
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h2>Inventario</h2>
        </div>       
        
        <div class="content"> 
        	
           <form class="pure-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<fieldset>
					<legend>Scegli fornitore</legend>
					
					<select class="pure-u-md-1 pure-u-sm-1" name="forn">
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
						<option value="TUTTI">TUTTI</option>
					</select>

					<button type="submit" class="pure-button pure-button-primary" name="cerca">Cerca</button>
				</fieldset>
		    </form>
            
            <?php
	
				if(isset($_POST["cerca"]))
				{
					$forn = $_POST["forn"];
					if ($forn != "TUTTI")
					{
						$q = "SELECT codF FROM fornitori WHERE nomF = '".$forn."'";
						$query = mysql_query($q);
						$ris = mysql_fetch_array($query);
						$codF = $ris["codF"];
						
						$q = "SELECT * FROM articoli WHERE idF = '".$codF."' ORDER BY codA";
						$ris = mysql_query($q);
						?>
						
						<table class="pure-table pure-table-bordered">
						<?php
						echo "<caption style=\"font: bold 20px 'Oswald'; color: rgb(0, 120, 231); text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);\">".$forn."</caption>"; 
						?>
						<thead>
							<tr align="center">
								<th>Codice</th>
								<th>Nome</th>
								<th>Descrizione</th>
								<th>Acquisto</th>
								<th>Vendita</th>
								<th>Scorta</th>
							</tr>
						</thead>
						<?php
							$i=0;
							while($riga = mysql_fetch_array($ris))
							{
								if($i%2==0)
								{
									if ($riga["scorta"] <= 5)
									{
										echo "<tr align=\"center\" bgcolor=\"#FF3333\" style=\"color: white\"> \n";
									}
									else
									{
										echo "<tr align=\"center\"> \n";
									}
									echo "<td>" . $riga["codA"] . "</td> \n";
									echo "<td>" . $riga["nomA"] . "</td> \n";
									echo "<td>" . $riga["descr"] . "</td> \n";
									echo "<td>" . $riga["preAq"] . " &euro;</td> \n";
									echo "<td>" . $riga["preVe"] . " &euro;</td> \n";
									echo "<td>" . $riga["scorta"] . "</td> \n";
									echo "</tr> \n";
								}
								else
								{
									if ($riga["scorta"] <= 5)
									{
										echo "<tr align=\"center\" bgcolor=\"#FF3333\" style=\"color: white\"> \n";
									}
									else
									{
										echo "<tr class=\"pure-table-odd\" align=\"center\"> \n";
									}
									echo "<td>" . $riga["codA"] . "</td> \n";
									echo "<td>" . $riga["nomA"] . "</td> \n";
									echo "<td>" . $riga["descr"] . "</td> \n";
									echo "<td>" . $riga["preAq"] . " &euro;</td> \n";
									echo "<td>" . $riga["preVe"] . " &euro;</td> \n";
									echo "<td>" . $riga["scorta"] . "</td> \n";
									echo "</tr> \n";
								}
								$i=$i+1;
							}
						?>
						</table>
						<p>In rosso gli articoli con meno di 5 elementi in magazzino</p>
					
					<?php
					}
					elseif ($forn == "TUTTI")
					{
						$q = "SELECT * FROM articoli ORDER BY idF, codA"; 
						$ris = mysql_query($q);
						?>
						
						<table class="pure-table pure-table-bordered">
						<caption style="font: bold 20px 'Oswald'; color: rgb(0, 120, 231); text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);">Articoli in magazzino</caption> 
						<thead>
							<tr align="center">
								<th>Codice</th>
								<th>Nome</th>
								<th>Descrizione</th>
								<th>Acquisto</th>
								<th>Vendita</th>
								<th>Scorta</th>
								<th>Fornitore</th>
							</tr>
						</thead>
						<?php
						
						$i=0;
						while($riga = mysql_fetch_array($ris))
						{
							$codF = $riga["idF"];
							$p = "SELECT nomF FROM fornitori WHERE codF='".$codF."'";
							$query = mysql_query($p);
							$op = mysql_fetch_array($query);
							$forni = $op["nomF"];
							if($i%2==0)
							{
								if ($riga["scorta"] <= 5)
								{
									echo "<tr align=\"center\" bgcolor=\"#FF3333\" style=\"color: white\"> \n";
								}
								else
								{
									echo "<tr align=\"center\"> \n";
								}
								echo "<td>" . $riga["codA"] . "</td> \n";
								echo "<td>" . $riga["nomA"] . "</td> \n";
								echo "<td>" . $riga["descr"] . "</td> \n";
								echo "<td>" . $riga["preAq"] . " &euro;</td> \n";
								echo "<td>" . $riga["preVe"] . " &euro;</td> \n";
								echo "<td>" . $riga["scorta"] . "</td> \n";
								echo "<td>" . $forni . "</td> \n";
								echo "</tr> \n";
							}
							else
							{
								if ($riga["scorta"] <= 5)
								{
									echo "<tr align=\"center\" bgcolor=\"#FF3333\" style=\"color: white\"> \n";
								}
								else
								{
									echo "<tr class=\"pure-table-odd\" align=\"center\"> \n";
								}
								echo "<td>" . $riga["codA"] . "</td> \n";
								echo "<td>" . $riga["nomA"] . "</td> \n";
								echo "<td>" . $riga["descr"] . "</td> \n";
								echo "<td>" . $riga["preAq"] . " &euro;</td> \n";
								echo "<td>" . $riga["preVe"] . " &euro;</td> \n";
								echo "<td>" . $riga["scorta"] . "</td> \n";
								echo "<td>" . $forni . "</td> \n";
								echo "</tr> \n";
							}
							$i=$i+1;
						}
						echo("</table> <p>In rosso gli articoli con meno di 5 elementi in magazzino</p>");
					}
				}
	
			?>
        </div>
        
    </div>
</div>

<script src="js/ui.js"></script>

</body>
</html>
