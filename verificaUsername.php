<?php
	if(isset($_GET["usern"]))
      {
		$connessione=mysqli_connect("localhost", "root", "", "luigi_branchina_hw1");
        $chiave = mysqli_real_escape_string($connessione, $_GET["usern"]);		
		mysqli_query($connessione, "set character set utf8");
        $risultato=mysqli_query($connessione, "SELECT * FROM utente WHERE username = '".$chiave."'") or die("Errore: ".mysqli_error($conn));
		$risp = array();
		while($riga = mysqli_fetch_assoc($risultato)){
			$risp[]=$riga;
		}
		mysqli_free_result($risultato);
		mysqli_close($connessione);
		echo json_encode($risp);	
      }
?>