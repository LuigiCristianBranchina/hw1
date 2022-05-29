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
    if(isset($_GET['nome'])){
        $SELECTedPlaylist=$_GET['nome'];
    }
    $query="SELECT id FROM utente WHERE username='$utente'";
    $res=mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));
    if($row=mysqli_fetch_assoc($res)){
        $SELECTedId=$row["id"];
    }
    mysqli_free_result($res);
    $query="SELECT id FROM playlist WHERE creatore='$SELECTedId' AND nome='$SELECTedPlaylist'";
    if($res=mysqli_query($conn, $query)){
        if($row=mysqli_fetch_assoc($res)){
            $SELECTedPlaylistId=$row['id'];
        }
        mysqli_free_result($res);
        $query="SELECT * FROM associato A JOIN video V ON A.id_video=V.id WHERE id_playlist='$SELECTedPlaylistId'";
        if($res=mysqli_query($conn, $query)){
            $contenuti=array();
            while($row=mysqli_fetch_assoc($res)){
                $contenuti[]=$row;
            }
        }
        mysqli_free_result($res);
    }
    mysqli_close($conn);
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="icon" type="image/jpg" href="./images/favicon.jpg" sizes="32x32" />
        <title>Homework 1.</title>
        <link href="https://fonts.googleapis.com/css?family=Lato|PT+Sans" rel="stylesheet">
        <link rel='stylesheet' href='style.css'>
        <script src='collection.js' defer></script>
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
                <div id="div_playlist">
                    <h1>Questa è la raccolta:</h1>
                    <h1 class="selPlay"><?php echo $SELECTedPlaylist; ?></h1>
                </div>

                <div id="container-play">
                    <?php
                        foreach($contenuti as $c){
                            if($c["thumbnail"] == " "){
                                echo "<div class="."contenuto"." data-titolo=".$c["id_video"].">".
                                    "<img src="."'./images/playlist.jpg'"."class="."'img_contenuto'".">".
                                    "<h1 id=".$c["id_video"].">Titolo: ".$c["titolo"]."</h1>".
                                    "<p id="."descr_cont".$c['id_video']." class="."hidden".">".$c['descrizione']."</p>".
                                    "<button class="."button_elimina".">Elimina dalla playlist</button>".
                                    "</div>";
                            }
                            else{
                                echo "<div class="."contenuto"." data-titolo=".$c["id_video"].">".
                                    "<img src=".$c["thumbnail"]." "."class="."'img_contenuto'".">".
                                    "<h1 id=".$c["id_video"].">Titolo: ".$c["titolo"]."</h1>".
                                    "<p id="."descr_cont".$c['id_video']." class="."hidden".">".$c['descrizione']."</p>".
                                    "<button class="."button_elimina".">Elimina dalla playlist</button>".
                                    "</div>";
                            }
                        }
                    ?>
                </div>

                <div id="modal-view" class="hidden">
                </div>

            </section>
        </article>
    </body>
</html>