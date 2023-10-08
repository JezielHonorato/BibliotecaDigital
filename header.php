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
        <div class="Logo">
            <img src="./image/logo.png" alt="Logo">
        </div>
        <ul class="Itens">
            <a href="./Index.php">Home</a>
            <a href="./Livros.php">Livros</a>
            <?php if(isset($_SESSION['usuario'])){
                echo "<a href='./Inserir.php'>Inserir</a>";
            }?>
            <a href="./Login.php">Login</a>
        </ul>
        <a href="./Livros.php"class="Pesquisa"><span class="Simbolo">search</span></a>
    </header>
</body>
</html>