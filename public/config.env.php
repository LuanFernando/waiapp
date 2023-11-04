<?php

/** Principais configurações do sistema */ 
$nameApp = 'WAI APP';
$messageMotivation = 'Desperte o gigante dentro de você.';
$emailSuport = 'email@email.com.br';

/** Quando o banco de dados já existir seta o valor 'TRUE', caso contrario 'FALSE' */
$databaseCreatedConfig = true; 
$host = 'localhost';
$database = 'waiapp';
$user = 'root';
$password = '123456';

/** Primeira credencial da base de dados */ 
$firstUser ='admin';
$passwordUser = 'waiapp@admin';
$firstEmail = 'admin@admin.com.br';

/** Urls uteis */ 
$urlMigration = "http://local.wai:8081/migrations.php";
# página usada para primeira instalação cria a base e as tabelas no banco
$urlStartMigration = "http://local.wai:8081/first_installation.php";

/** Configurações e-commerce*/
$activateStore = true; // false - não permite acessar o e-commerce , true - permite acessar o e-commercer integrado 
$inactiveMessage = "Loja online está temporariamente inativada."; 