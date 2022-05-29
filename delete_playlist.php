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

    if (isset($_GET['nome_playlist']) ) {
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
        $query="SELECT id_video FROM associato WHERE id_playlist='$SELECTedPlaylistId'";
        $res=mysqli_query($conn, $query);
        $videosid = array();
        $num_risultati=0;
        while($row=mysqli_fetch_assoc($res)){
            $videosid[]=$row["id_video"];
            $num_risultati++;
        }
        mysqli_free_result($res);

        $query="DELETE FROM associato WHERE id_playlist='$SELECTedPlaylistId'";
        $res=mysqli_query($conn, $query);
        if($res){
            for($i=0; $i<$num_risultati; $i++){
                $query="SELECT COUNT(id_video) as num FROM associato WHERE id_video='$videosid[$i]'";
                $res1=mysqli_query($conn, $query);
                if($row=mysqli_fetch_assoc($res1)){
                    $num_vid = $row["num"];
                    if($num_vid == 0){
                        $query="DELETE FROM video WHERE id='$videosid[$i]'";
                        $res2=mysqli_query($conn, $query);
                        mysqli_free_result($res2);
                    }
                }
                mysqli_free_result($res1);
            }
            $query="DELETE FROM playlist WHERE id='$SELECTedPlaylistId'";
            $res1=mysqli_query($conn, $query);
            print_r($res1);
            mysqli_free_result($res1);            
        }
        mysqli_free_result($res);
        mysqli_close($conn);
    }

?>