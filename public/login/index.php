<?php

session_start();

require_once('../session.php');
include_once('../config.env.php');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nameApp; ?> :: Login</title>
    <link rel="stylesheet" href="../css/style_global.css">
    <link rel="stylesheet" href="../css/style_login.css">
</head>
<body>
    <nav class="nav">
        <h3><?php echo $nameApp; ?></h3>
        <a href="/">VOLTAR</a>
    </nav>

    <div id="message">
        <p>    
            <?php echo (isset($_SESSION['message']) ? $_SESSION['message'] : ''); ?>
        </p>
    </div>

    <section id="login">
        <form action="../auth.php" method="post">
            <input type="hidden" name="action" id="action" value="auth">
            <div class="box-login">
                <div class="box-login-inputs">
                    <label for="">Usuário:</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Informe o seu usuário...">
                </div>  
                <div class="box-login-inputs">
                    <label for="">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Informe o sua senha...">
                </div>
                <!-- <div class="row-white"></div> -->
                <button type="submit" id="btnEntrar">ENTRAR</button>
            </div>
        </form>
    </section>
</body>
</html>