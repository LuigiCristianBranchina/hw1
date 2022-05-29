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
    $query="SELECT id FROM utente WHERE username='$utente'";
    $res=mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));
    if($row=mysqli_fetch_assoc($res)){
        $id=$row["id"];
    }
    $query="SELECT * FROM playlist WHERE creatore='$id'";
    $res=mysqli_query($conn, $query);
    $plays=array();
    while($row=mysqli_fetch_assoc($res)){
        $plays[]=$row;
    }
    mysqli_free_result($res);
    mysqli_close($conn);

?>

<html>
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="icon" type="image/jpg" href="./images/favicon.jpg" sizes="32x32" />
        <title>Homework 1.</title>
        <link href="https://fonts.googleapis.com/css?family=Lato|PT+Sans" rel="stylesheet">
        <link rel='stylesheet' href='style.css'>
        <script src='home.js' defer></script>
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
                    <h1>Crea la tua playlist</h1>
                    <div id="form_ricerca">
                        <form name="ricerca" id="ricerca" method="post" action="index.php">
                            <div>
                                
                                <label class="label">Titolo playlist :<input type="text" id="titolo_playlist" name="titolo_play" placeholder="     Inserisci il titolo della playlist da creare"></label>
                            </div>
                            <div>
                                <label class="label"><input type="submit" name="sumbit" id="tasto_submit_home" value="Crea Playlist"></label>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="container-play">
                    <?php
                        foreach($plays as $p){
                            if($p["thumbnail"] == " "){
                                echo "<div class="."playlist"." data-titolo=".$p["nome"].">".
                                    "<img src="."'./images/playlist.jpg'"."class="."'img_play'".">".
                                    "<h1 id=".$p["nome"].">Titolo: ".$p["nome"]."</h1>".
                                    "<button class="."button_elimina".">Elimina playlist</button>".
                                    "</div>";
                            }
                            else{
                                echo "<div class="."playlist"." data-titolo=".$p["nome"].">".
                                    "<img src=".$p["thumbnail"]." "."class="."'img_play'".">".
                                    "<h1 id=".$p["nome"].">Titolo: ".$p["nome"]."</h1>".
                                    "<button class="."button_elimina".">Elimina playlist</button>".
                                    "</div>";
                            }
                        }
                    ?>
                </div>

            </section>
        </article>
    </body>
</html>