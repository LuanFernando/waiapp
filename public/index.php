<?php

// require_once('session.php');
include_once('config.env.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nameApp; ?></title>
    <link rel="stylesheet" href="./css/style_global.css">
    <link rel="stylesheet" href="./css/style_index.css">
</head>
<body>
    <section id="treinos">
        <a href="/treinos" class="btn-link" id="btn-treinos" title="Treinos">TREINOS</a>
    </section>

    <section id="login">
        <a href="/login" class="btn-link" id="btn-login" title="Login">LOGIN</a>
    </section>

    <section id="message-motivation" title="WAI APP Desperte o gigante dentro de você.">
        <h1><?php echo $nameApp; ?></h1>
        <h3><?php echo $messageMotivation; ?></h3> 
        <!-- <h3>onde a motivação é o combustível e o sucesso é a meta!</h3> -->
    </section>
    
</body>
</html>