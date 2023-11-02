<?php
    if(!isset($_SESSION)){
        session_start();
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Biblioteca Digital</title>
    <link rel="shortcut icon" href="./image/logo.ico" />
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src='main.js' defer></script>
</head>

<body>
    <header class="Header">
        <div class="Sombra">
            <a href="./index.php"><img src="./image/logo.png" alt="Logo"></a>
        </div>
        <div class="Itens">
            <a href="./index.php">Home</a>
            <a href="./livros.php">Livros</a>
            <?php if(isset($_SESSION['usuario'])){
                echo "<a href='./inserir.php'>Inserir</a>";
            }?>
            <a href="./Login.php">Login</a>
        </div>
        <a href="./livros.php"><span class="Simbolo">search</span></a>
    </header>
</body>
</html>
