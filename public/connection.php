<?php

include('config.env.php');

$conn = null;

/**
 * Verifica se o valor de $databaseCreatedConfig == TRUE o database já foi criado entrão usa um conexão diferente.
 * Se for FALSE usa uma conexão especifica para criar o DATABASE
 * */ 
if($databaseCreatedConfig == TRUE){

    $conn = mysqli_connect($host,$user,$password,$database) or die(mysqli_error);
    
    if($conn->connect_error){
        die('A conexão falhou! '.$conn->connect_error);
    }

}else{
   
    $conn =  new mysqli($host, $user, $password, '');

    if($conn->connect_error){
        die("A conexão falhou ". $conn->connect_error);
    }   
}
