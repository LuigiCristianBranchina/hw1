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

    if (isset($_GET['id_video']) && isset($_GET['nome_playlist']) ) {
        $keyword = $_GET['id_video'];
        $nome_playlist = $_GET['nome_playlist'];
        mysqli_query($conn, "set character set utf8");
        $query="SELECT id FROM utente WHERE username='$utente'";
        $res=mysqli_query($conn, $query);
        if($row=mysqli_fetch_assoc($res)){
            $userId=$row["id"];
        }
        mysqli_free_result($res);
        $query="SELECT id FROM playlist WHERE nome='$nome_playlist' AND creatore='$userId'";
        $res=mysqli_query($conn, $query);
        if($row=mysqli_fetch_assoc($res)){
            $SELECTedPlaylistId=$row["id"];
        }
        mysqli_free_result($res);
        $query="DELETE FROM associato WHERE id_video='$keyword' AND id_playlist='$SELECTedPlaylistId'";
        $res=mysqli_query($conn, $query);
        print_r($res);
        if($res){
            $query="SELECT COUNT(id_playlist) AS num_play FROM associato WHERE id_playlist='$SELECTedPlaylistId'";
            $res1=mysqli_query($conn, $query);
            if($row=mysqli_fetch_assoc($res1)){
                $num_play=$row["num_play"];
                if($num_play == 0){
                    $query="DELETE FROM playlist WHERE id='$SELECTedPlaylistId'";
                    $res2=mysqli_query($conn, $query);
                    mysqli_free_result($res2);
                }
            }
            mysqli_free_result($res1);
            $query="SELECT COUNT(id_video) as num FROM associato WHERE id_video='$keyword'";
            $res1=mysqli_query($conn, $query);
            if($row=mysqli_fetch_assoc($res1)){
                $num_video=$row["num"];
                print("Ciao a tutti\n");
                print_r($num_video);
                if($num_video == 0){
                    $query="DELETE FROM video WHERE id='$keyword'";
                    $res2=mysqli_query($conn, $query);
                    mysqli_free_result($res2);
                }
            }
            mysqli_free_result($res1);            
        }
        mysqli_free_result($res);
        mysqli_close($conn);
    }

?>