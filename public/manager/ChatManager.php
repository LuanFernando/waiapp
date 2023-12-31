<?php

/**
 * Endpoint ChatManager.php
 * Created in 2023-10-22 by Luan Fernando
 * HTTP : GET / POST / DELETE / UPDATE
 * */ 

include_once('../connection.php');

if($_SERVER['REQUEST_METHOD'] === 'GET'){

    if($_GET['action'] == 'messages'){
        session_start();
        $message = "";
        $idDestino = $_GET['id']; // destino
        $idOrigem  = $_SESSION['idUser']; //usuario 
        $resumo    = $_GET['resumo'];
        $srcDesLike = '../img/nao-gosto.png';
        $srcLike = '../img/gostar.png';
        
        try {
            // Preparar a declaração SQL
            $stmt = $conn->prepare("SELECT id, message, origin_id , destiny_id, reaction, created , deleted FROM (
                SELECT 
                    cm.id, 
                    cm.message, 
                    cm.reaction , 
                    cm.destiny_id,
                    cm.origin_id,
                    DATE_FORMAT(cm.created, '%d/%m/%Y') As created,
                    DATE_FORMAT(cm.deleted, '%d/%m/%Y') As deleted 
                    FROM chat_message cm
                    WHERE (cm.origin_id = ? AND cm.destiny_id = ?)
                    UNION ALL 
                    SELECT 
                    cm.id, 
                    cm.message, 
                    cm.reaction , 
                    cm.destiny_id,
                    cm.origin_id,
                    DATE_FORMAT(cm.created, '%d/%m/%Y') As created,
                    DATE_FORMAT(cm.deleted, '%d/%m/%Y') As deleted 
                    FROM chat_message cm
                    WHERE (cm.origin_id = ? AND cm.destiny_id = ?)
            ) AS derivedTable
            GROUP BY derivedTable.id, derivedTable.message, 
            derivedTable.origin_id , derivedTable.destiny_id, 
            derivedTable.reaction, derivedTable.created , derivedTable.deleted 
            ORDER BY derivedTable.id ASC ");
    
            // Vincular os parâmetros
            $stmt->bind_param("iiii", $idOrigem, $idDestino, $idDestino, $idOrigem);

            // Executar a consulta
            $stmt->execute();
        
        } catch (\Exception $e) {
            echo $e;
        }

        // Obter resultados
        $result = $stmt->get_result();

        while($linha = $result->fetch_assoc()){

            if($linha['reaction'] != null ){

                if($resumo == 1){
                    $srcDesLike = '../../img/nao-gosto.png';
                    $srcLike = '../../img/gostar.png';
                }

                if($linha['reaction'] == 2 ){
                    if($idOrigem == $linha['origin_id']){
                        $message .= "<div class='position-message-origem'>
                                        <div class='label-img-origem'>
                                            <img src='{$srcDesLike}' style='width:32px;'>
                                        </div>
                                    </div>";
                    }else{
                        $message .= "
                                    <div class='position-message-destino'>
                                        <div class='label-img-destino'>
                                            <img src='{$srcDesLike}' style='width:32px;'>
                                        </div>
                                    </div>";
                    }
                }else{
                    if($idOrigem == $linha['origin_id']){
                        $message .= "<div class='position-message-origem'>
                                        <div class='label-img-origem'>
                                            <img src='{$srcLike}' style='width:32px;'>
                                        </div>
                                    </div>";
                    }else{
                        $message .= "
                                    <div class='position-message-destino'>
                                        <div class='label-img-destino'>
                                            <img src='{$srcLike}' style='width:32px;'>
                                        </div>
                                    </div>";
                    }
                }
            }
            else{
                if($idOrigem == $linha['origin_id']){
                    $message .= "<div class='position-message-origem'>
                                    <div class='label-message-origem'>
                                        <label>{$linha['created']}</label>
                                        <label>{$linha['message']}</label>
                                    </div>
                                </div>";
                }else{
                    $message .= "
                                <div class='position-message-destino'>
                                    <div class='label-message-destino'>
                                        <label>{$linha['created']}</label>
                                        <label>{$linha['message']}</label>
                                    </div>
                                </div>";
                }
            }
        }

        $response = ['message' => $message];
        echo json_encode($response);
        return;
    }
}
else if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Obtem o corpo da solicitação JSON
    $dataJson = json_decode(file_get_contents("php://input"), true);

    // Verifica se o JSON foi recebido com sucesso
    if($dataJson === false){
        http_response_code(400);//Método erro
        $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => ''];
        echo json_encode($response); 
        return;
    }


    if($dataJson['action'] == 'newMessage'){
        
        session_start();

        $message   = $dataJson['message'];
        $idDestino = $dataJson['idDestino'];
        $idOrigem  = $_SESSION['idUser'];
        $createdUpdatedDate  = date('Y-m-d H:i:s');

        if(empty($message) || empty($idDestino) || empty($idOrigem)){
            $response = ['warning' => 1, 'error' => 0, 'success' => 0, 'message' => 'Não foi possivel enviar a mensagem para o usuário, atualize a página e tente novamente!'];
            echo json_encode($response);
            return;
        }

        $stmt = $conn->prepare("INSERT INTO chat_message (origin_id, destiny_id, message, created, updated) VALUES (? ,? ,? ,? ,?) ");
        $stmt->bind_param("iisss", $idOrigem ,$idDestino ,$message, $createdUpdatedDate, $createdUpdatedDate);

        if($stmt->execute()){
            http_response_code(200); //success
            $response = ['warning' => 0, 'error' => 0, 'success' => 1, 'message' => ""];
            echo json_encode($response);
            return;
        }else{
            http_response_code(400); // error
            $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => 'Não foi possivel enviar a mensagem para o usuário, algo deu errado!'];
            echo json_encode($response);
            return;
        }
    } else if($dataJson['action'] == 'newMessageLike'){
        
            session_start();
    
            $idDestino = $dataJson['idDestino'];
            $idOrigem  = $_SESSION['idUser'];
            $createdUpdatedDate  = date('Y-m-d H:i:s');
            $reaction = 1; //like
            $message = 'like';
    
            if(empty($idDestino) || empty($idOrigem)){
                $response = ['warning' => 1, 'error' => 0, 'success' => 0, 'message' => 'Não foi possivel enviar a mensagem para o usuário, atualize a página e tente novamente!'];
                echo json_encode($response);
                return;
            }
    
            $stmt = $conn->prepare("INSERT INTO chat_message (origin_id, destiny_id, reaction, created, updated,message) VALUES (? ,? ,? ,? ,?,?) ");
            $stmt->bind_param("iiisss", $idOrigem ,$idDestino ,$reaction, $createdUpdatedDate, $createdUpdatedDate,$message);
    
            if($stmt->execute()){
                http_response_code(200); //success
                $response = ['warning' => 0, 'error' => 0, 'success' => 1, 'message' => ""];
                echo json_encode($response);
                return;
            }else{
                http_response_code(400); // error
                $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => 'Não foi possivel enviar a mensagem para o usuário, algo deu errado!'];
                echo json_encode($response);
                return;
            }
        
    } else if($dataJson['action'] == 'newMessageDesLike'){
        
        session_start();

        $idDestino = $dataJson['idDestino'];
        $idOrigem  = $_SESSION['idUser'];
        $createdUpdatedDate  = date('Y-m-d H:i:s');
        $reaction = 2; //deslike
        $message = 'deslike';

        if(empty($idDestino) || empty($idOrigem)){
            $response = ['warning' => 1, 'error' => 0, 'success' => 0, 'message' => 'Não foi possivel enviar a mensagem para o usuário, atualize a página e tente novamente!'];
            echo json_encode($response);
            return;
        }

        $stmt = $conn->prepare("INSERT INTO chat_message (origin_id, destiny_id, reaction, created, updated,message) VALUES (? ,? ,? ,? ,?, ?) ");
        $stmt->bind_param("iiisss", $idOrigem ,$idDestino ,$reaction, $createdUpdatedDate, $createdUpdatedDate,$message);

        if($stmt->execute()){
            http_response_code(200); //success
            $response = ['warning' => 0, 'error' => 0, 'success' => 1, 'message' => ""];
            echo json_encode($response);
            return;
        }else{
            http_response_code(400); // error
            $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => 'Não foi possivel enviar a mensagem para o usuário, algo deu errado!'];
            echo json_encode($response);
            return;
        }
    
}
}