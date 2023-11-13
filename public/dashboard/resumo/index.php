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
    <title><?php echo $nameApp; ?> :: Resumo</title>
    <link rel="stylesheet" href="../../css/style_global.css">
    <link rel="stylesheet" href="../../css/style_dashboard.css">
    <link rel="stylesheet" href="../../css/style_modals.css">
    <link rel="stylesheet" href="../../css/style_buttons.css">
    <link rel="stylesheet" href="../../css/style_modal_loggoff.css">
    <link rel="stylesheet" href="../../css/style_modal_loading.css">
    <link rel="stylesheet" href="../../css/style_modal_delete_user.css">
    <link rel="stylesheet" href="../../css/style_chat.css">
    <link rel="stylesheet" href="../../css/style_mensalidade.css">
    <link rel="stylesheet" href="../../css/style_modal_gerar_mensalidade.css">
</head>
<body>
    
    <?php require('../../common-component/navbar.php'); ?>
    <?php require('../../common-component/generic-modal-media.php'); ?>
    <?php require('../../common-component/large-generic-modal.php'); ?>

    <div class="content">
    
    <!-- Users resumo -->
    <div class="card-resumo">
        <div class="card-resumo-part1">
            <h3>Usuários</h3>
            <label for="" class="label-subtitle">* cadastrados hoje</label>
            <h1 id="qnt-usuario"><strong>0</strong></h1>
        </div>
        <div class="card-resumo-part2">
            <a href="#" class="btn-card-resumo" id="btn-modal-users-resumo">Ver mais</a>
        </div>
    </div>

    <?php
        include_once('screen_resumo.php');
    ?>

    <!-- End Users -->

    <div class="card-resumo">
        <div class="card-resumo-part1">
            <h3>Á Receber</h3>
            <label for="" class="label-subtitle">* hoje</label>
            <h1><strong>R$ 00,00</strong></h1>
        </div>
        <div class="card-resumo-part2">
            <a href="#" class="btn-card-resumo">Ver mais</a>
        </div>
    </div>

    <div class="card-resumo">
        <div class="card-resumo-part1">
            <h3>Á Pagar</h3>
            <label for="" class="label-subtitle">* hoje</label>
            <h1><strong>R$ 00,00</strong></h1>
        </div>
        <div class="card-resumo-part2">
            <a href="#" class="btn-card-resumo">Ver mais</a>
        </div>
    </div>

    <div class="card-resumo">
        <div class="card-resumo-part1">
            <h3>Loja</h3>
            <label for="" class="label-subtitle">* hoje</label>
            <h1><strong>R$ 00,00</strong></h1>
        </div>
        <div class="card-resumo-part2">
            <a href="#" class="btn-card-resumo">Ver mais</a>
        </div>
    </div>


    </div>

    <!-- JS -->
    <script src="../../js/jquery.min.js?v=1.1"></script>
    <script src="../../js/generic-modal.js?v=1.1"></script>
    <script src="../../js/modals_dashboard.js?v=1.1"></script>
    <script src="../../js/loading.js?v=1.1"></script>
    <script src="../../js/resumo.js?v=1.1"></script>
</body>
</html>