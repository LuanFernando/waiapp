<?php

include_once('config.env.php');
include_once('connection.php');

$messageResult = "";
$databaseCreated = false;

/** NOTE: Verifica se o database existe caso contrario cria o mesmo */
$queryConsultDatabase = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$database}' ";
$resultConsultDatabase = mysqli_query($conn, $queryConsultDatabase);

if($resultConsultDatabase->num_rows > 0){
    $messageResult .= "O banco de dados '{$database}' já existe.<br>";
    $databaseCreated = true; // banco de dados já existe.

    /** banco de dados já existe e a opção no config '$databaseCreatedConfig' está como FALSE , notifica o usuário */
    if($databaseCreated == true && $databaseCreatedConfig == false){
        echo "Verifique a váriavel $databaseCreatedConfig no arquivo config.env.php , a mesma precisa estar como TRUE para dar seguimento nas migrations.<br> ";
        die();
    }
}
else
{
    $messageResult .= "O banco de dados '{$database}' não foi criado ainda!<br>";

    // Faz a tentativa de criar o database.
    $queryCreateDatabase = "CREATE DATABASE $database";
    $resultCreateDatabase = mysqli_query($conn, $queryCreateDatabase);

    if($resultCreateDatabase){
        $messageResult .= "O banco de dados '{$database}' sendo criado.<br>";
        $messageResult .= "O banco de dados '{$database}' foi criado com sucesso.<br>";
        $databaseCreated = true; // banco de dados criado.
        
        /** banco de dados já existe e a opção no config '$databaseCreatedConfig' está como FALSE , notifica o usuário */
        if($databaseCreated == true && $databaseCreatedConfig == false){
            echo $messageResult."Verifique a váriavel $databaseCreatedConfig no arquivo config.env.php , a mesma precisa estar como TRUE para dar seguimento nas migrations.<br> ";
            die();
        }

    }else{
        $messageResult .= "O banco de dados '{$database}' não foi criado, motivo: ".mysqli_error($conn)."<br>";
        $databaseCreated = false; // banco de dados não criado.
    }
}


// Só verificará e criará as tabelas se o banco de dados já existir.
if($databaseCreated == true){

    /** NOTE: Verifica se a tabela existe no banco de dados e cria caso não exista.*/ 
    
    /** Lista de tabelas a serem verificadas */
    $tablesQuery = array(
        'user' => 'CREATE TABLE user (id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,email VARCHAR(255) NOT NULL,password VARCHAR(255) NOT NULL,
                token VARCHAR(255) NOT NULL,student VARCHAR(1), created DATETIME,updated DATETIME,
                deleted DATETIME)',
        'training' => 'CREATE TABLE training (id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,content VARCHAR(3000) NOT NULL,
                sets_repetitions VARCHAR(255) NOT NULL,img_example VARCHAR(255) NOT NULL,
                category VARCHAR(255) NOT NULL)',
        'related_exercises' => 'CREATE TABLE related_exercises (id INT AUTO_INCREMENT PRIMARY KEY,
                parent_id INT NOT NULL,child_id INT NOT NULL)',
        'settings' => 'CREATE TABLE settings(id INT AUTO_INCREMENT PRIMARY KEY,
                company_name VARCHAR(255) NOT NULL, company_address VARCHAR(255) NOT NULL,
                company_email VARCHAR(255) NOT NULL, cgc VARCHAR(50) NOT NULL )',
        'chat_message' => 'CREATE TABLE chat_message(id INT AUTO_INCREMENT PRIMARY KEY,
                origin_id INT NOT NULL, destiny_id INT NOT NULL, message VARCHAR(4000) NOT NULL ,
                reaction INT, created DATETIME, updated DATETIME, deleted DATETIME)'
    );
    
    
    /** Percorre o array consultando se existe as tabelas e criando as que não existe */ 
    foreach ($tablesQuery as $key => $value) 
    {
        $queryConsult = "SHOW TABLES LIKE '{$key}' ";
        $result = mysqli_query($conn,$queryConsult);
    
        if(mysqli_num_rows($result) == 0){
    
            // A tabela não existe, então cria a tabela
            $createTableQuery = $tablesQuery[$key];
            $createResult = mysqli_query($conn, $createTableQuery);
    
            if($createResult){
                $messageResult .= "Tabela '{$key}' criada com sucesso.<br>";
    
                // Cria o primeiro usuário da base de dados
                if($key == 'user'){
    
                    $token = uniqid(); // gera um token unico
                    $created = date('Y-m-d H:i:s'); // data e hora atual
                    $hashed_password = password_hash($passwordUser, PASSWORD_DEFAULT); // Gera um hash seguro da senha
                    
                    $stmt =  $conn->prepare("INSERT INTO user (name, email, password, token, created) VALUES(? , ? , ? , ?, ?)");
                    // "sssss" => especifica os tipos de dados dos parâmentros que  estão sendo vinculados.
                    $stmt->bind_param("sssss",$firstUser, $firstEmail, $hashed_password, $token, $created);

                    if($stmt->execute()){
                        $messageResult .= "Usuário Admin criado com sucesso na tabela '{$key}'.<br>User: <strong>{$firstUser}</strong> Password: <strong>{$passwordUser}</strong>";
                    }else{
                        $messageResult .= "Erro ao criar primeiro usuário na tabela '{$key}'.<br>";
                    }
    
                }
            }
            else{
                $messageResult .= "Erro ao criar a tabela '{$key}' ".mysqli_error($conn). "<br>";
            }
        }
        else{
            $messageResult .= "A tabela '{$key}' já existe.<br>";
        }
    }

}

// Exibe todas as informações da migrations
echo $messageResult;