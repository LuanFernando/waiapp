<?php 

include_once('../../config.env.php');

if(isset($activateStore) && $activateStore ==  true){
    $url = "/store";
    header('Location: '.$url);
    exit(); // Certifique-se de sair após o redirecionamento
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nameApp; ?> :: Inactive Store</title>
    <link rel="stylesheet" href="../../css/style_global.css">
    <link rel="stylesheet" href="../../css/style_store.css">
</head>
<body>
    <section id="inactive-store">
        <p><?= $inactiveMessage; ?></p>
    </section>    
</body>
</html>