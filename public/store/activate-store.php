<?php

include_once('../config.env.php');

// Está vazia, não declarada ou false - redireciona
if(empty($activateStore) || !isset($activateStore) || $activateStore ==  false){
    $url = "inactive-store";
    header('Location: '.$url);
    exit(); // Certifique-se de sair após o redirecionamento
}