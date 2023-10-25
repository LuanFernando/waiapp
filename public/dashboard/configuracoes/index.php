<?php

session_start();

if(!isset($_SESSION['token']) || $_SESSION['token'] == null){
    $url = "/login";
    header('Location: '.$url);
    exit(); //Certifique-se de sair após o redirecionamento
}

require_once('../../session.php');
include_once('../../config.env.php');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nameApp; ?> :: Configurações</title>
    <link rel="stylesheet" href="../../css/style_global.css">
    <link rel="stylesheet" href="../../css/style_dashboard.css">
    <link rel="stylesheet" href="../../css/style_buttons.css">
    <link rel="stylesheet" href="../../css/style_modal_loggoff.css">
</head>
<body>
    
    <?php require('../../common-component/navbar.php'); ?>

    <div class="content">
        <!-- TODO: Fazer nesta página as configurações de banner dinamico da loja, links de midias sociais dinamico exibo no footer -->
        <!-- TODO: Controlador de minimo e máximo de produto podem ser compras por clientes (minimo 1 , maximo 10) -->
        <!-- TODO: Controlador de layout da loja , a plaforma disponibilizará 2 layout de loja (padrão e a futurista) -->
        <!-- <div class="card-resumo"></div> -->
        <!-- <div class="card-resumo"></div> -->
    </div>

</body>
</html>