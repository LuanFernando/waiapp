<?php

session_start();

if(!isset($_SESSION['token']) || $_SESSION['token'] == null){
    $url = "/login";
    header('Location: '.$url);
    exit(); //Certifique-se de sair após o redirecionamento
}

require_once('../session.php');
include_once('../config.env.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nameApp; ?> :: Dashboard</title>
    <link rel="stylesheet" href="../css/style_global.css">
    <link rel="stylesheet" href="../css/style_dashboard.css">
    <link rel="stylesheet" href="../css/style_buttons.css">
    <link rel="stylesheet" href="../css/style_modal_loggoff.css">
    <link rel="stylesheet" href="../css/style_crud_users.css">
    <link rel="stylesheet" href="../css/style_modal_delete_user.css">
    <link rel="stylesheet" href="../css/style_chat.css">
    <link rel="stylesheet" href="../css/style_mensalidade.css">
</head>
<body>
    
    <?php require('../common-component/navbar.php'); ?>
    <?php include_once('screen_crud_users.php'); ?>
    <?php include_once('screen_new_edit_user.php'); ?>

    <?php 
    session_start(); 
    if($_SESSION['student'] != 'S') {
    // dashboard do admin
    ?>
        <div class="content">

            <div class="card-dashboard">
                <div class="card-dashboard-part1">
                    <h3>Usuários</h3>
                    <label for="" class="label-subtitle">* cadastrados</label>
                    <h1 id="qnt-usuario"><strong>0</strong></h1>
                </div>
                <div class="card-dashboard-part2">
                    <a href="#" class="btn-card-dasboard" id="btnCrudUsers">Ver mais</a>
                </div>
            </div>

            <div class="card-dashboard">
                <div class="card-dashboard-part1">
                    <h3>Dietas</h3>
                    <label for="" class="label-subtitle">* cadastrados</label>
                    <h1><strong>0</strong></h1>
                </div>
                <div class="card-dashboard-part2">
                    <a href="#" class="btn-card-dasboard">Ver mais</a>
                </div>
            </div>

            <div class="card-dashboard">
                <div class="card-dashboard-part1">
                    <h3>Treinos</h3>
                    <label for="" class="label-subtitle">* cadastrados</label>
                    <h1><strong>0</strong></h1>
                </div>
                <div class="card-dashboard-part2">
                    <a href="#" class="btn-card-dasboard">Ver mais</a>
                </div>
            </div>

            <div class="card-dashboard">
                <div class="card-dashboard-part1">
                    <h3>Produtos</h3>
                    <label for="" class="label-subtitle">* cadastrados</label>
                    <h1><strong>0</strong></h1>
                </div>
                <div class="card-dashboard-part2">
                    <a href="#" class="btn-card-dasboard">Ver mais</a>
                </div>
            </div>

        </div>

        <!-- JS -->
        <script src="../js/dashboard.js?v=1.2"></script>
        <script src="../js/modals_dashboard.js?v=1.1"></script>

    <?php 
        } else {
    ?>
        <p>dashboard do aluno</p>
    <?php 
        }
    ?>

</body>
</html>