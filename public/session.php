<?php

/**
 * Aqui neste arquivo deve-se ser controlado todos os recursos de cache/session da aplicação
 * */ 

$duracao_em_segundos_msg = 5; // define a duração desejada da sessão em segundos (message) (5 segundos)
$duracao_em_hora_token = 24 * 60 * 60; // define a duração desejada da sessão em horas (token) (1 dia)

$tempo_expiracao_msg = time() + $duracao_em_segundos_msg; // define o tempo atual mais a duração desejada
$tempo_expiracao_token =  time() + $duracao_em_hora_token; // define o tempo atual mais a duração desejada

if(isset($_SESSION['message']) && $_SESSION['message'] != null){
    // Configura os parâmetros de cookie da sessão
    session_set_cookie_params($duracao_em_segundos_msg);
    session_start();

    // Verifica se a sessão expirou
    if(isset($_SESSION['ultimo_acesso_msg']) && time() - $_SESSION['ultimo_acesso_msg'] > $duracao_em_segundos_msg){
        session_unset();
        session_destroy();
    }else{
        // Atualize o tempo do último acesso
        $_SESSION['ultimo_acesso_msg'] = time();
    }
}

if(isset($_SESSION['token']) && $_SESSION['token'] != null){
    // Configura os parametros de cookie da sessão
    session_set_cookie_params($duracao_em_hora_token);
    session_start();

    // Verifica se a sessão expirou para tokens
    if(isset($_SESSION['ultimo_acesso_token']) && time() - $_SESSION['ultimo_acesso_token'] > $duracao_em_hora_token){
        session_unset();
        session_destroy();

        $url = "/login";
        header('Location: '.$url);
        exit(); // Certifique-se de sair após o redirecionamento
    }else{
        // Atualiza o tempo do último acesso para tokens
        $_SESSION['ultimo_acesso_token'] = time();

        $pagina_atual = $_SERVER['REQUEST_URI'];

        if(strpos($pagina_atual, 'dashboard') !== false){
            // O usuário já se encontra na página de dashboard.
        }else{
            // Redireciona o usuário pois o mesmo já tem um token valido em cache
            $url = "/dashboard";
            header('Location: '.$url);
            exit(); // Certifique -se de sair após o redirecionamento
        }
    }
}
