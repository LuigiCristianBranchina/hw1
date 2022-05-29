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
    $res=mysqli_query($conn, $query);
    if($row=mysqli_fetch_assoc($res)){
        $id=$row["id"];
    }

    if (isset($_GET['nome'])) {
        $nomePlay = mysqli_real_escape_string($conn, $_GET['nome']);
        $query="insert into playlist (creatore, nome) values ('$id', '$nomePlay')";
        $res=mysqli_query($conn, $query);
        mysqli_free_result($res); 
       
            echo $nomePlay;        
    }

    mysqli_close($conn);
?>