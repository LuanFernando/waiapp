<?php

include_once('../config.env.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nameApp; ?> :: Treinos</title>
    <link rel="stylesheet" href="../css/style_global.css">
    <link rel="stylesheet" href="../css/style_treinos.css">
</head>
<body>
    <section id="categorias">
        <div class="card-categoria ganho-massa">
            <a href="/treinos/ganho-de-massa" class="btn-link" id="btn-ganho-massa" title="GANHO DE MASSA">GANHO DE MASSA</a>
        </div>
        <div class="card-categoria perda-peso">
            <a href="/treinos/perda-de-peso" class="btn-link" id="btn-perda-peso" title="PERDA DE PESO">PERDA DE PESO</a>
        </div>
        <div class="card-categoria hipertrofia">
            <a href="/treinos/hipertrofia" class="btn-link" id="btn-hipertrofia" title="HIPERTROFIA">HIPERTROFIA</a>
        </div>
    </section>

    <section id="message-motivation" title="WAI APP Desperte o gigante dentro de você.">
        <h1><?php echo $nameApp; ?></h1>
        <a href="/" class="btn-voltar">VOLTAR</a>
        <!-- <h3>Desperte o gigante dentro de você.</h3>  -->
        <!-- <h3>onde a motivação é o combustível e o sucesso é a meta!</h3> -->
    </section>

</body>
</html>