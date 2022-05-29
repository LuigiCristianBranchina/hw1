<?php

    session_start();
    if(isset($_SESSION["username"]))
    {
        // Vai alla home
        header("Location: index.php");
        exit;
    }

	$connessione=mysqli_connect("localhost", "root", "", "luigi_branchina_hw1");

    // Verifica l'esistenza di dati POST
    if(isset($_POST["username"]) && isset($_POST["password"]))
    {
		$user = mysqli_real_escape_string($connessione, $_POST["username"]);		
		$passw = mysqli_real_escape_string($connessione, $_POST["password"]);
		mysqli_query($connessione, "set character set utf8");
		$query = "SELECT username, pswd FROM utente WHERE username = '".$user."' and pswd = '".$passw."'";
		$risultato = mysqli_query($connessione, $query) or die("Errore: ".mysqli_error($connessione));

		if(mysqli_num_rows($risultato) > 0)
        {
            // Imposta la variabile di sessione
            $_SESSION["username"] = $_POST["username"];
            // Vai alla pagina home.php
            header("Location: index.php");
            exit;
        }
        else
        {
            // Flag di errore
            $errore = true;
        }
    }

?>

<html>
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="icon" type="image/jpg" href="./images/favicon.jpg" sizes="32x32" />
        <link href="https://fonts.googleapis.com/css?family=Lato|PT+Sans" rel="stylesheet">
        <title>Homework 1 - Login.</title>
        <link rel='stylesheet' href='styleLS.css'>
        <script src='./login.js' defer></script>
        <meta charset="utf-8">
    </head>
    <body>
        <main>
            <h1 class="hi">Bentornato</h1>
            <p class="text">Esegui l'accesso per usufruire del servizio.</p>
            <form name='nome_form' method='post'>
            <?php
                // Verifica la presenza di errori
                if(isset($errore))
                {
                    echo "<div class='errore'>";
                    echo "Credenziali non valide.";
                    echo "</div>";
                }

            ?>
                <div>
                    <label>Nome utente <input type='text' name='username'></label>
                </div>
                <div>
                    <label>Password <input type='password' name='password'></label>
                </div>
                <div>
                    <input id="invio" type='submit' value="Login">
                </div>
                <div>
                    <button id="registrazione"><a href='signup.php'>Registrati</a></button>
                </div>
            </form>
        </main>
    </body>
</html>