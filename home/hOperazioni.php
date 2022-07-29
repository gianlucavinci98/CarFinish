<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Car Finish - Operazioni</title>
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
        <span id="main"></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <ul class="pure-menu-list">
                <li class="pure-menu-item"><a href="../index.html" class="pure-menu-link">LOGIN</a></li>
                <li class="pure-menu-item"><a href="home.php" class="pure-menu-link">Nuovi Dati</a></li>
                <a class="pure-menu-heading" href="hOperazioni.php">Operazioni</a>
                <li class="pure-menu-item"><a href="hArticoli.php" class="pure-menu-link">Articoli</a></li>
          		<li class="pure-menu-item"><a href="hFornitori.php" class="pure-menu-link">Fornitori</a></li>
 				<li class="pure-menu-item"><a href="hClienti.php" class="pure-menu-link">Clienti</a></li>
            </ul>
        </div>
    </div>

    <div class="main">
        <div class="header">
            <h2>Vendite e Forniture</h2>
        </div>
        
        <div class="content">	                 	 
        	 <form class="pure-form pure-form-stacked" action="oVendita.php" method="post">
    		 	<fieldset>
                   <legend>Vendita</legend> 
                        <div class="pure-g">
                            <input class="pure-u-md-1-2 pure-u-sm-1" type="text" placeholder="Articolo" style="width: 300px" name="cod"> &emsp;
                            <select style="width: 300px" class="pure-u-md-1-2 pure-u-sm-1" name="cl">
								<?php								
									$con = mysql_connect("localhost","carfinish","");
    								$db = mysql_select_db("my_carfinish", $con);
									$q = "SELECT nomC FROM clienti ORDER BY nomC";
									$ris = mysql_query($q);
									while($riga = mysql_fetch_array($ris))
									{
										if ($riga["nomC"] != NULL or $riga["nomC"] != "")
										{
											echo ("<option value=\"".$riga["nomC"]."\">".$riga["nomC"]."</option>");
										}
									}
								?>
							</select>
                        </div>
                        <div  align="center" class="pure-g">
                            <input class="pure-u-md-1-3 pure-u-sm-1" type="number" placeholder="Quantità" style="width: 197px" name="qta"> &emsp;
                            <input class="pure-u-md-1-3 pure-u-sm-1" type="number" placeholder="Sconto %" style="width: 197px" name="sco"> &emsp;
                            <?php
								$q = "SELECT MAX(id) AS id FROM vendite";
								$ris = mysql_query($q);
								$riga = mysql_fetch_array($ris);
								echo("<input class=\"pure-u-md-1-3 pure-u-sm-1\" type=\"number\" placeholder=\"ID\" style=\"width: 197px\" value=\"".$riga["id"]."\" name=\"id\">");
							?>
                            <!--Numero progressivo, ogni volta viene preso l'ultimo in elenco dal database e mostrato, se si fa riferimento a una nuova vendita si incrementa di uno. Serve per visualizzare gli acquisti raggrupati per scontrini-->
						</div> 		 
        		 		<button type="submit" class="pure-button pure-button-primary" style="margin-top: 5px">Conferma</button>
    			</fieldset>
			</form>
            
            <p>Aumentare il contatore per cambiare la fornitura</p><br>         
             
        	<form class="pure-form pure-form-stacked" action="oFornitura.php" method="post">
    		 <fieldset>
        	 	<legend>Fornitura</legend> <input name="new" type="checkbox" checked onChange="verifica()" id="new"> Nuovi articoli       
                        <div align="center" class="pure-g">
                            <input class="pure-u-md-1-3 pure-u-sm-1" type="text" placeholder="Articolo" style="width: 197px" name="codA" id="codA"> &emsp;
                            <input class="pure-u-md-1-3 pure-u-sm-1" type="number" placeholder="Quantità" style="width: 197px" name="qtaF" id="qtaF"> &emsp;
                       		<?php
								$q = "SELECT MAX(num) AS num FROM forniture";
								$ris = mysql_query($q);
								$riga = mysql_fetch_array($ris);
								echo("<input class=\"pure-u-md-1-3 pure-u-sm-1\" type=\"number\" placeholder=\"ID\" style=\"width: 197px\" value=\"".$riga["num"]."\" name=\"num\" id=\"num\">");
							?>
                        </div>
			 </fieldset>
            
            <p>Aumentare il contatore per cambiare la fornitura</p>
             
             <fieldset>
                <legend>Pagamento fornitura</legend>      
                      <div class="pure-g">
                        <div class="pure-u-1 pure-u-md-1-3">
                            <a class="button-secondary pure-button" onClick="paga(); return false;" href="javascript:;" id="pt">Paga tutto</a>
                            <input name="pag" type="checkbox" id="pag"> Paga
                        </div>
                        <div class="pure-u-sm-1 pure-u-md-1-3">
                            <select class="pure-u-md-1 pure-u-sm-1" style="width: 617px" name="met">
								<option value="Contanti" selected="selected">Contanti</option>
							    <option value="Bonifico Bancario">Bonifico bancario</option>
							    <option value="Rimessa diretta">Rimessa diretta</option>
							    <option value="RIBA">RIBA</option>
							</select>
                        </div>
    
                        <div class="pure-u-sm-1 pure-u-md-1-3">
                            <select class="pure-u-md-1 pure-u-sm-1" name="pf" style="width: 617px" id="pf" disabled>
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
                        </div>
    
                        <div class="pure-u-sm-1 pure-u-md-1-3">
                            <input  type="text" placeholder="&euro; Somma" id="som" name="som" style="width: 617px" class="pure-u-sm-1 pure-u-md-1-3">
                        </div>
                    </div>
        		 <button type="submit" class="pure-button pure-button-primary">Conferma</button>
    		 </fieldset>
			</form>    
        </div>
        
    </div>
</div>

<script>	
	function paga()
	{
		document.getElementById('som').value = "FORNITURA PAGATA";
	}
	
	function verifica()
	{
		if(document.getElementById('new').checked == false)
		{
			document.getElementById('pf').disabled = false;
			document.getElementById('pt').style.display = 'none';
			document.getElementById('pag').disabled = true;
			document.getElementById('pag').checked = true;
			document.getElementById('codA').disabled = true;
			document.getElementById('qtaF').disabled = true;
			document.getElementById('num').disabled = true;
		}
		if(document.getElementById('new').checked == true)
		{
			document.getElementById('pf').disabled = true;
			document.getElementById('pt').style.display = 'initial';
			document.getElementById('pag').disabled = false;
			document.getElementById('pag').checked = false;
			document.getElementById('codA').disabled = false;
			document.getElementById('qtaF').disabled = false;
			document.getElementById('num').disabled = false;
		}
	}
</script>

<script src="js/ui.js"></script>

</body>
</html>
