<?php 

session_start();

include_once('connection.php');

if($_POST['usuario'] != null && $_POST['senha'] && $_POST['action'] == 'auth')
{
    $user     = $_POST['usuario'];
    $password = $_POST['senha'];
    $action   = $_POST['action'];

    /** Consulta se o usuário e senha existe na base de dados */
    $queryConsult = "SELECT token, password, deleted FROM user WHERE name = ? ";
    $stmt = $conn->prepare($queryConsult);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        
        $row = $result->fetch_assoc();
        
        // Verifica se a senha informada é igual a do banco de dados.
        if(password_verify($password, $row['password']) && empty($row['deleted'])){

            // Salva informações na session, antes de redirecionar
            $_SESSION['token'] = $row['token'];
            $url = "/dashboard";
            header('Location: '.$url);
            exit(); // Certifique -se de sair após o redirecionamento
        }else{
            // Senha incorreta.
            $_SESSION['message'] = "401 - Não autorizado.";
            $url = "/login"; 
            header('Location: '.$url);
            exit(); // Certifique -se de sair após o redirecionamento
        }
        

    }else{
        // Usuário não encontrado.
        $_SESSION['message'] = "401 - Não autorizado.";
        $url = "/login";
        header('Location: '.$url);
        exit(); // Certifique -se de sair após o redirecionamento
    }

    $stmt->close();

}
elseif ($_GET['action'] == 'loggoff')
{
    session_unset();
    session_destroy();

    $url = "/login";
    header('Location: '.$url);
    exit(); // Certifique -se de sair após o redirecionamento
}
else
{
    session_unset();
    session_destroy();

    $url = "/login";
    header('Location: '.$url);
    exit(); // Certifique -se de sair após o redirecionamento
}

