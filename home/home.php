<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Car Finish - Home</title>
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
            	<a class="pure-menu-heading" href="home.php">Nuovi Dati</a>
                <li class="pure-menu-item"><a href="hOperazioni.php" class="pure-menu-link">Operazioni</a></li>
 				<li class="pure-menu-item"><a href="hArticoli.php" class="pure-menu-link">Articoli</a></li>
          		<li class="pure-menu-item"><a href="hFornitori.php" class="pure-menu-link">Fornitori</a></li>
 				<li class="pure-menu-item"><a href="hClienti.php" class="pure-menu-link">Clienti</a></li>
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h2>Database</h2>
        </div>
        
        <div class="content">
		   <form class="pure-form" method="post" action="insF.php">
    		 	<fieldset>
				 <legend>Nuovo fornitore</legend>
				 <div class="pure-g">
							<div class="pure-u-sm-1 pure-u-md-1-3"> <input type="text" placeholder="Nome" name="nome"></div> &emsp;
							<div class="pure-u-sm-1 pure-u-md-1-3"> <input type="text" placeholder="Sede" name="sede"></div> &emsp;
							<div class="pure-u-sm-1 pure-u-md-1-3"> <input type="tel" placeholder="Telefono" name="tel"></div>
				 </div>	 
    	 	 	</fieldset>
    	 	 	<button type="submit" class="pure-button pure-button-primary">Inserisci</button>
			</form>
            
            <br>
            
            <form class="pure-form" action="insC.php" method="post">
    		 	<fieldset>
				 <legend>Nuovo cliente</legend>
				 <div class="pure-g">
							<div class="pure-u-sm-1 pure-u-md-1-2"> <input type="text" placeholder="Nome" name="nome"></div> &emsp;
							<div class="pure-u-sm-1 pure-u-md-1-2"> <input type="text" placeholder="Città" name="citta"></div>
				 </div>
				 <div class="pure-g">
							<div class="pure-u-sm-1 pure-u-md-1-2"> <input type="text" placeholder="Indirizzo" name="ind"></div> &emsp;
							<div class="pure-u-sm-1 pure-u-md-1-2"> <input type="tel" placeholder="Telefono" name="tel"></div>
				 </div>	 
    	 	 	</fieldset>
    	 	 	<button type="submit" class="pure-button pure-button-primary">Inserisci</button>
			 </form>
             
             <br>
             
             <form class="pure-form" action="insA.php" method="post">
    		 	<fieldset>
				 <legend>Nuovo articolo</legend>
				 <div class="pure-g">
							<div class="pure-u-sm-1 pure-u-md-1-3"> <input type="text" placeholder="Codice" name="cod"></div> &emsp;
							<div class="pure-u-sm-1 pure-u-md-1-3"> <input type="text" placeholder="Nome" name="nome"></div>&emsp;
							<div class="pure-u-sm-1 pure-u-md-1-3"> <input type="text" placeholder="Descrizione" name="descr"></div>
				 </div>
				 <div class="pure-g">
							<div class="pure-u-sm-1 pure-u-md-1-3"> <input type="text" placeholder="Prezzo Acquisto" name="pa"></div> &emsp;
							<div class="pure-u-sm-1 pure-u-md-1-3"> <input type="text" placeholder="Prezzo Vendita" name="pv"></div> &emsp;
							<div class="pure-u-sm-1 pure-u-md-1-3"> <select name="forn" style="width:217px">
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
							</select> </div> 
				 </div>	 
    	 	 	</fieldset>
    	 	 	<button type="submit" class="pure-button pure-button-primary">Inserisci</button>
			 </form>
        </div>
    </div>
</div>

<script src="js/ui.js"></script>

</body>
</html>