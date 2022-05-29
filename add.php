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
    $query="SELECT id FROM utente WHERE username='$utente'";
    $res=mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));
    if($row=mysqli_fetch_assoc($res)){
        $id=$row["id"];
    }

    if (isset($_POST['idVideo']) && isset($_POST['titolo']) && isset($_POST['descrizione']) && isset($_POST['thumbnail']) && isset($_POST['nomePlay'])) {
        $id_video = mysqli_real_escape_string($conn, $_POST['idVideo']);
        echo $id_video;
        print_r($id_video);
        $titolo = mysqli_real_escape_string($conn, $_POST['titolo']);
        $descrizione = mysqli_real_escape_string($conn, $_POST['descrizione']);
        $thumbnail = mysqli_real_escape_string($conn, $_POST['thumbnail']);
        $nomePlay = mysqli_real_escape_string($conn, $_POST['nomePlay']);

        $query = "SELECT id FROM playlist WHERE nome='$nomePlay' and creatore ='$id'";
        echo $query;
        $res=mysqli_query($conn, $query);
        print_r($res);

        while($row=mysqli_fetch_assoc($res)){
            $id_playlist=$row['id'];
        }

        echo $id_playlist;
        mysqli_free_result($res);

        $query="SELECT thumbnail FROM playlist WHERE nome='$nomePlay'";
        $res=mysqli_query($conn, $query);
        if($row=mysqli_fetch_assoc($res)){
            $url=$row["thumbnail"];
        }
        mysqli_free_result($res);

        $query = "insert into video (id, titolo, descrizione, thumbnail) values ('$id_video', '$titolo', '$descrizione', '$thumbnail')";
        $res=mysqli_query($conn, $query);
        if (mysqli_error() != null && mysqli_error() == 1062) {
                // Qua dentro mi gestisco comunque l'inserimento dei record, e quindi le query sotto.

        }
        else if(mysqli_error() != null && mysqli_error() != 1062){
            // Errore generico: Non devo fare nulla (in realtà dpvrei dovrei gestire l'errore su js in modo da non mostrarte il popup di inserimento)

        }
        else {
            //  In assenza di errore di chiave duplicata (due righe con la stessa PK) devo inserire tutti i record sotto

        }
        if (!$res) {
            mysqli_free_result($res);
        }
        if($url==" "){
            $query="update playlist set thumbnail = '$thumbnail' WHERE id = '$id_playlist'";
            $res=mysqli_query($conn, $query);
            if (!$res) {
                mysqli_free_result($res);
            }
        }
        else{
            
        }
        $query="insert into associato (id_playlist, id_video) values('$id_playlist', '$id_video')";
        $res1=mysqli_query($conn, $query);
    }

    mysqli_close($conn);
?>