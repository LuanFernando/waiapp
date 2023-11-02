<?php

/**
 * Endpoint UserManager.php
 * Created in 2023-10-14 by Luan Fernando
 * HTTP : GET / POST / DELETE / UPDATE
 * */ 

include_once('../connection.php');

if($_SERVER['REQUEST_METHOD'] === 'GET'){

    if($_GET['action'] == 'listUsers'){
        $tableUsers = "";
        $query  = "
        SELECT id, name, email, student, 
        DATE_FORMAT(created, '%d/%m/%Y') As created, 
        DATE_FORMAT(updated, '%d/%m/%Y') As updated,
        DATE_FORMAT(deleted, '%d/%m/%Y') As deleted 
        FROM user";
        $result = $conn->query($query);

        while($linha = $result->fetch_assoc()){

            $student = ($linha['student'] == 'S' ? 'Sim' : 'Não');
            $linkDesabilitado = ( $linha['deleted'] != '' && $linha['deleted'] != null  ? 'link-desabilitado' : '');
            $linkDesabilitaMensalidade = ($student == 'Sim' ? '' : 'link-desabilitado');

            session_start();
            $cssUserLogado  = '';
            $iconUserLogado = '';
            $idUserLogado   = $_SESSION['idUser'];

            if($idUserLogado == $linha['id']){
                $cssUserLogado = "style='background: #e65c0085;color:#fff;'";
                $iconUserLogado = "<img src='../img/user.png' style='width:16px;'>";
            }

            $tableUsers .= "<tr>";
            $tableUsers .= "<td {$cssUserLogado} > <div style='
            display: flex;gap: 8px;align-content: center;flex-direction: row;align-items: center;justify-content: center;'>$iconUserLogado {$linha['id']}</div></td>";
            $tableUsers .= "<td>{$linha['name']}</td>";
            $tableUsers .= "<td>{$student}</td>";
            $tableUsers .= "<td>{$linha['created']}</td>";
            $tableUsers .= "<td>{$linha['updated']}</td>";
            $tableUsers .= "<td>{$linha['deleted']}</td>";
            $tableUsers .= "<td class='td-actions'>";
                $tableUsers .= "<a href='#' data-id='{$linha['id']}' onclick='mensalidadeUser({$linha['id']})' class='btn-mensalidade-user {$linkDesabilitaMensalidade}'>Mensalidade</a>";
                $tableUsers .= "<a href='#' data-id='{$linha['id']}' onclick='chat({$linha['id']})' class='btn-ver-user {$linkDesabilitado}'>Chat</a>";
                $tableUsers .= "<a href='#' data-id='{$linha['id']}' onclick='editUser({$linha['id']})' class='btn-editar-user'>Editar</a>";
                $tableUsers .= "<a href='#' data-id='{$linha['id']}' onclick='confirmDeleteUser({$linha['id']})' class='btn-deletar-user {$linkDesabilitado}'>Deletar</a>";
            $tableUsers .= "</td>";
            $tableUsers .= "</tr>";
        }

        if($tableUsers == ""){
            $tableUsers .= "Nenhum registro encontrado.";
        }

        $response = ['listUsers' => $tableUsers];
        echo json_encode($response);

    } else if($_GET['action'] == 'listUsersCurrent'){
        $tableUsers = "";
        $query  = "
        SELECT id, name, email, student, 
        DATE_FORMAT(created, '%d/%m/%Y') As created, 
        DATE_FORMAT(updated, '%d/%m/%Y') As updated,
        DATE_FORMAT(deleted, '%d/%m/%Y') As deleted 
        FROM user 
        WHERE CURDATE() = DATE(created)";
        $result = $conn->query($query);

        while($linha = $result->fetch_assoc()){

            $student = ($linha['student'] == 'S' ? 'Sim' : 'Não');
            $linkDesabilitado = ( $linha['deleted'] != '' && $linha['deleted'] != null  ? 'link-desabilitado' : '');
            $linkDesabilitaMensalidade = ($student == 'Sim' ? '' : 'link-desabilitado');

            session_start();
            $cssUserLogado  = '';
            $idUserLogado   = $_SESSION['idUser'];
            $iconUserLogado = '';

            if($idUserLogado == $linha['id']){
                $cssUserLogado = "style='background: #e65c0085;color:#fff;'";
                $iconUserLogado = "<img src='../img/user.png' style='width:16px;'>";
            }

            $tableUsers .= "<tr>";
            $tableUsers .= "<td $cssUserLogado > <div style='
            display: flex;gap: 8px;align-content: center;flex-direction: row;align-items: center;justify-content: center;'>$iconUserLogado {$linha['id']} </div></td>";
            $tableUsers .= "<td>{$linha['name']}</td>";
            $tableUsers .= "<td>{$student}</td>";
            $tableUsers .= "<td>{$linha['created']}</td>";
            $tableUsers .= "<td>{$linha['updated']}</td>";
            $tableUsers .= "<td>{$linha['deleted']}</td>";
            $tableUsers .= "<td class='td-actions'>";
                $tableUsers .= "<a href='#' data-id='{$linha['id']}' onclick='mensalidadeUser({$linha['id']})' class='btn-mensalidade-user-m {$linkDesabilitaMensalidade}'>Mensalidade</a>";
                $tableUsers .= "<a href='#' data-id='{$linha['id']}' onclick='chat({$linha['id']})' class='btn-ver-user-m {$linkDesabilitado}'>Chat</a>";
                // $tableUsers .= "<a href='#' data-id='{$linha['id']}' onclick='editUser({$linha['id']})' class='btn-editar-user'>Editar</a>";
                $tableUsers .= "<a href='#' data-id='{$linha['id']}' onclick='confirmDeleteUser({$linha['id']})' class='btn-deletar-user-m {$linkDesabilitado}'>Deletar</a>";
            $tableUsers .= "</td>";
            $tableUsers .= "</tr>";
        }

        if($tableUsers == ""){
            $tableUsers .= "Nenhum registro encontrado.";
        }

        $response = ['listUsers' => $tableUsers];
        echo json_encode($response);
    } else if($_GET['action'] == 'quantResumoUsuario') {
        $query = "SELECT COUNT(Id) AS totalUsers FROM user WHERE CURDATE() = DATE(created)";
        $result  = $conn->query($query);
        $totalUsers = $result->fetch_assoc();
    
        $response = ['totalUsers' =>  $totalUsers['totalUsers']];
        echo json_encode($response);
    } else  if($_GET['action'] == 'delete'){

        $deleted = date('Y-m-d H:i:s'); // data e hora atual
        $id = $_GET['id'];
        
        if($id > 0 && $id != null){

            // o delete apenas atualizar o campo deleted
            $stmt =  $conn->prepare("UPDATE user SET deleted = ? WHERE id = ?");
            // "s" => especifica os tipos de dados dos parâmentros que  estão sendo vinculados.
            $stmt->bind_param("si", $deleted, $id);

            if($stmt->execute()){
                http_response_code(200); //success
                $response = ['warning' => 0, 'error' => 0, 'success' => 1, 'message' => "Usuário deletado com sucesso."];
                echo json_encode($response);
            }else{
                http_response_code(400); // error
                $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => 'Não foi possivel deletar o usuário, algo deu errado!'];
                echo json_encode($response);
            }

        } else {
            $response = ['success' => 0, 'warning' => 0,'error' => 1, 'message' => 'O ID do usuário é invalido!'];
            echo json_encode($response);
        }
    } else if($_GET['action'] == 'editUser'){
        $id = $_GET['id'];

        if($id > 0 && $id != ''){

            $queryConsult = "SELECT name, email, student , password FROM user WHERE id = ? ";
            $stmt = $conn->prepare($queryConsult);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $response = [
                    'warning' => 0, 
                    'error' => 0, 
                    'success' => 1, 
                    'message' => null,
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'student' => ($row['student'] != null ? $row['student'] : 'N')
                ];
                echo json_encode($response);
            } else{
                $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => 'Não foi possivel identificar o ID do usuário!'];
                echo json_encode($response);
            }

        }else{
            $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => 'Não foi possivel identificar o ID do usuário!'];
            echo json_encode($response);
        }

    }else{
        $query = "SELECT COUNT(Id) AS totalUsers FROM user";
        $result  = $conn->query($query);
        $totalUsers = $result->fetch_assoc();
    
        $response = ['totalUsers' =>  $totalUsers['totalUsers']];
        echo json_encode($response);
    }

} else if($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtem o corpo da solicitação JSON
    $dataJson = json_decode(file_get_contents("php://input"), true);

    // Verifica se o JSON foi recebido com sucesso
    if($dataJson === false){
        http_response_code(400);//Método erro
        $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => ''];
        echo json_encode($response); 
    }

    if($dataJson['action'] == 'newUser'){

        $name     = $dataJson['name']; 
        $email    = $dataJson['email'];
        $student  = $dataJson['student'];
        $password = $dataJson['password'];

        if(empty($name) || empty($email) || empty($student) || empty($password) ){
            $response = ['warning' => 1, 'error' => 0, 'success' => 0, 'message' => 'Não foi possivel criar o usuário, verifique o formulário!'];
            echo json_encode($response);
        }else{

            $token = uniqid(); // gera um token unico
            $created = date('Y-m-d H:i:s'); // data e hora atual
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Gera um hash seguro da senha
            
            $stmt =  $conn->prepare("INSERT INTO user (name, email, password, token, created, student) VALUES(? , ? , ? , ?, ?, ?)");
            // "sssss" => especifica os tipos de dados dos parâmentros que  estão sendo vinculados.
            $stmt->bind_param("ssssss",$name, $email, $hashed_password, $token, $created, $student);

            if($stmt->execute()){
                http_response_code(200); //success
                $response = ['warning' => 0, 'error' => 0, 'success' => 1, 'message' => "Usuário {$name} criado com sucesso."];
                echo json_encode($response);
            }else{
                http_response_code(400); // error
                $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => 'Não foi possivel criar o usuário, algo deu errado!'];
                echo json_encode($response);
            }
        }

    } else if($dataJson['action'] == 'editUser') {
        
        $updated  = date('Y-m-d H:i:s'); // data e hora atual
        $id       = $dataJson['id'];
        $name     = $dataJson['name']; 
        $email    = $dataJson['email'];
        $student  = $dataJson['student'];
        $password = $dataJson['password'];

        if(empty($name) || empty($email) || empty($student) || empty($password) ){
            $response = ['warning' => 1, 'error' => 0, 'success' => 0, 'message' => 'Não foi possivel atualizar o usuário, verifique o formulário!'];
            echo json_encode($response);
        }else{

            $token = uniqid(); // gera um token unico
            $created = date('Y-m-d H:i:s'); // data e hora atual
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Gera um hash seguro da senha
            
            if($id > 0 && $id != null){
    
                // o delete apenas atualizar o campo deleted
                $stmt =  $conn->prepare("UPDATE user SET name = ? , email = ? , password = ? , student = ? , updated = ? WHERE id = ?");
                // "s" => especifica os tipos de dados dos parâmentros que  estão sendo vinculados.
                $stmt->bind_param("sssssi", $name, $email, $hashed_password, $student, $updated, $id);
    
                if($stmt->execute()){
                    http_response_code(200); //success
                    $response = ['warning' => 0, 'error' => 0, 'success' => 1, 'message' => "Usuário atualizado com sucesso."];
                    echo json_encode($response);
                }else{
                    http_response_code(400); // error
                    $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => 'Não foi possivel atualizar o usuário, algo deu errado!'];
                    echo json_encode($response);
                }
    
            } else {
                $response = ['success' => 0, 'warning' => 0,'error' => 1, 'message' => 'O ID do usuário é invalido!'];
                echo json_encode($response);
            }
                
        }

    }else{
        // Lógica para lidar com solicitação POST
        $data = json_decode(file_get_contents("php://input"), true);
        $response = ['message' => 'Solicitação POST para endpoint', 'data' => $data ];
        echo json_encode($response);
    }

} else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {

}else {
    http_response_code(405);//Método não permitido
    $response = ['message' => 'Método não permitido'];
    echo json_encode($response);
}