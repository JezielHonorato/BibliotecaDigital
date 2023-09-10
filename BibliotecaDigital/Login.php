<?php
    session_start();
    include ("conexao.php");
    if(isset($_SESSION['usuario'])){
        $usuario = $_SESSION['usuario'][0];
        $nivel = $_SESSION['usuario'][1];
    }

    if(isset($_POST['usuario']) || isset($_POST['senha'])){
        $usuario = $conexao->real_escape_string($_POST['usuario']);
        $senha = $conexao->real_escape_string($_POST['senha']);

        $sql_code_usuario = "SELECT * FROM tbusuarios WHERE usuario = '$usuario' AND senha = '$senha'";
        $sql_query_usuario = $conexao->query($sql_code_usuario) or die("ERRO:" . $conexao->error);

        $quantidade = $sql_query_usuario->num_rows;
        if($quantidade == 1){
            $user = $sql_query_usuario->fetch_assoc();
            session_start();
            $_SESSION['usuario'] = array($user['usuario'], $user['nivel']);
            header("Location: Index.php");
        }else{
            echo "Falha ao conectar! Usuario ou senha incorretas.";
    }
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
            <a href="./Inserir.php">Inserir</a>
            <a href="./Login.php">Login</a>
        </ul>
        <form action="Index.php" method="get" class="Pesquisa">
            <span onclick="window.location.href='./Livros.php'" class="Simbolo">search</span>
        </form>
    </header>


    <?php if($nivel == 1){ ?>
        <div class="Login">
            <button onclick="window.location.href='./Sair.php'" class="BotaoInserir">Sair</button>
        </div>
    <?php }else{ ?>
        <div class="Login">
            <h1 class="h1Login">Login</h1>
            <form action="" method="post" class="" id="form">
                <label for="usuario">Usuario:</label>
                <input id="usuario" class="InserirInput Preencher" name="usuario" type="text" required>
                <br>
                <label for="senha">Senha:</label>
                <input id="senha" class="InserirInput Preencher" name="senha" type="password" required>

                <button type="submit" class="BotaoInserir">Login</button>
            </form>
        </div>
    <?php }?>
</body>
</html>
