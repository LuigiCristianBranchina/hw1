<?php

    // Avvia la sessione
    session_start();
    // Verifica se l'utente è loggato
    if(!isset($_SESSION['username']))
    {
        // Vai alla login
        header("Location: login.php");
        exit;
    }
    $conn=mysqli_connect("localhost", "root", "", "luigi_branchina_hw1");
    $utente=$_SESSION['username'];
    mysqli_query($conn, "set character set utf8");
    $query="SELECT id FROM utente WHERE utente.username='$utente'";
    $res=mysqli_query($conn, $query);
    if($row=mysqli_fetch_assoc($res)){
        $id=$row["id"];
    }
    $query="SELECT nome FROM playlist WHERE creatore='$id'";
    $res=mysqli_query($conn, $query);
    $nomi=array();
    while($row=mysqli_fetch_assoc($res)){
        $nomi[]=$row["nome"];
    }
    mysqli_free_result($res);
    mysqli_close($conn);
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="icon" type="image/jpg" href="./images/favicon.jpg" sizes="32x32" />
        <title>Homework 1</title>
        <link href="https://fonts.googleapis.com/css?family=Lato|PT+Sans" rel="stylesheet">
        <link rel='stylesheet' href='./style.css'>
        <script src='./search.js' defer="true"></script>
        <meta charset="utf-8">
    </head>
    <body>
        <header id="titolo">
            <div id="testotitolo">Homework 1 - Uso delle REST API</div>
            <div id="benvenuto">
                    <div>Benvenuto <?php echo $_SESSION["username"]; ?>!</div>
            </div>
        </header>
        <article id="container1">
            <section id="menu">
                <a href="index.php">Home</a>
                <a href="search.php">Ricerca</a>
                <a href="logout.php">Logout</a>
            </section>
            <section id="contenuto">
                <div id="div_ricerca">
                    <h1>Ricerca i video da aggiungere alla tua Playlist tramite la API di YouTube.</h1>
                    <div id="form_ricerca">
                        <form name="ricerca" id="ricerca" method="post" action="search.php">
                            <div class="div-label">
                                <label class="label">Titolo video : &nbsp;<input type="text" id="titolo_video" name="titolo_vid" placeholder="    Inserisci il titolo del video da cercare"></label>
                            </div>
                            <div class="div-label">
                                <label class="label">Nome della playlist nella quale inserire il video : &nbsp;
                                    <SELECT name="nome_play" id="nome_playlist">
                                        <?php
                                            foreach($nomi as $n){
                                                echo "<option value='$n'>$n</option>";
                                            }
                                        ?>
                                    </SELECT>
                                </label>
                            </div>
                            <div class="button-invia div-label">
                                <label><input type="submit" name="sumbit" id="tasto_submit" value="Ricerca Video"></label>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="head-risultati">Massimo 15 risultati.</div>
                <div id="container-risultati">
                   
                </div>             
            </section>
        </article>
    </body>
</html>