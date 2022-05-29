<?php

    session_start();
    if(isset($_SESSION["username"]))
    {
        // Vai alla home
        header("Location: index.php");
        exit;
    }

    // Verifica l'esistenza di dati POST
    if(isset($_POST["username"]) && isset($_POST["password"]))
    {
        $connessione=mysqli_connect("localhost", "root", "", "luigi_branchina_hw1");
		$user = mysqli_real_escape_string($connessione, $_POST["username"]);		
		$passw = mysqli_real_escape_string($connessione, $_POST["password"]);
		mysqli_query($connessione, "set character set utf8");
		$query = "SELECT username, pswd FROM utente WHERE username = '".$user."' and pswd = '".$passw."'";
        $risultato = mysqli_query($connessione, $query) or die("Errore: ".mysqli_error($connessione));
        mysqli_close($connessione);

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

    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])
    && isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["data_nascita"]))
   {
         // Connessione al database
         $conn=mysqli_connect("localhost", "root", "", "luigi_branchina_hw1");
         // Aggiungi Utente
         $username = mysqli_real_escape_string($conn, $_POST["username"]);
         $password = mysqli_real_escape_string($conn, $_POST["password"]);
         $email = mysqli_real_escape_string($conn, $_POST["email"]);
         $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
         $cognome = mysqli_real_escape_string($conn, $_POST["cognome"]);
         $datanascita = mysqli_real_escape_string($conn, $_POST["data_nascita"]);
         $risultato = mysqli_query($conn, "INSERT INTO utente(username, pswd, nome, cognome, data_nascita, email) VALUES(\"$username\", \"$password\", \"$nome\", \"$cognome\", \"$datanascita\", \"$email\")");
         // Chiudi connessione
         mysqli_close($conn);

         if($risultato)
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
        <title>Homework 1 - Registrazione.</title>
        <link rel="icon" type="image/jpg" href="./images/favicon.jpg" sizes="32x32" />
        <link href="https://fonts.googleapis.com/css?family=Lato|PT+Sans" rel="stylesheet">
        <meta charset="utf-8">
        <link rel='stylesheet' href='styleLS.css'>
        <script src='./signup.js' defer></script>
    </head>
    <body>
        <main>
            <h1 id="hi" class="hi">Registrati al sito</h1>
            <p id="errorecomp" class="hidden text">
				Compila tutti i campi.
		    </p>
            <form id="signup_form" name='signup_form' method='post' action="./signup.php">
                <div id="nomeutente">
                    <label>Nome utente <input type='text' name='username' onblur="funcUsername()"></label>
                </div>
                <div id="nome_occ" class = "hidden">
                    Il nome utente scelto non è disponibile. Inserire nuovamente un nome utente.
                </div>
                <div id="pswd">
                    <label>Password <input type='password' name='password' onblur="funcPassword()"></label>
                </div>
				<div id="confpswd">
                    <label>Conferma password <input type='password' name='confpassword' onblur="funcPassword()"></label>
                </div>
                <div id="pass_differenti" class = "hidden">
                    Le due password devono coincidere.
                </div>
				<div id="email">
                    <label>Email <input type='text' name='email' onblur="funcEmail()"></label>
                </div>
                <div id="err_email" class = "hidden">
                    Inserire una email corretta.
                </div>
				<div id="nome">
                    <label>Nome <input type='text' name='nome'></label>
                </div>
				<div id="cognome">
                    <label>Cognome <input type='text' name='cognome'></label>
                </div>
				<div id="nascita">
                    <label>Data di nascita (AAAA-MM-GG) <input type='text' name='data_nascita'></label>
                </div>
                <div>
                    <input type='submit' value="Signup"></label>
                </div>
                <div>
                    <button id="login"><a href='./login.php'>Login</a></button>
                </div>
            </form>
        </main>
    </body>
</html>