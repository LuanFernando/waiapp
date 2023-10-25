<?php

/** Principais configurações do sistema */ 
$nameApp = 'NAME APP';
$messageMotivation = 'Desperte o gigante dentro de você.';
$emailSuport = 'email@email.com.br';

/** Quando o banco de dados já existir seta o valor 'TRUE', caso contrario 'FALSE' */
$databaseCreatedConfig = true; 
$host = 'localhost';
$database = 'database';
$user = 'root';
$password = 'password';

/** Primeira credencial da base de dados */ 
$firstUser ='admin';
$passwordUser = 'password@admin';
$firstEmail = 'email@email.com.br';

/** Urls uteis */ 
$urlMigration = "http://localhost:8081/migrations.php";
# página usada para primeira instalação cria a base e as tabelas no banco
$urlStartMigration = "http://localhost:8081/first_installation.php";

/** Configurações e-commerce*/
$activateStore = true; // false - não permite acessar o e-commerce , true - permite acessar o e-commercer integrado 
$inactiveMessage = "Loja online está temporariamente inativada."; 