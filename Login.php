<?php
    session_start();
    include ("conexao.php");

    if(isset($_SESSION['usuario'])){
        echo  "
        <script>
            var confirmar = confirm('Deseja sair da sessão?');
            if(confirmar == true){
                window.location.href = 'Sair.php'
            }else{
                window.location.href = 'Index.php'
            }
        </script>";
    }

    if(isset($_POST['usuario']) || isset($_POST['senha'])){
        if(strlen($_POST['usuario']) == 0){
            echo  "<script>alert('Preencha o campo usuario!');</script>"; 
        }else if(strlen($_POST['senha']) == 0){
            echo  "<script>alert('Preencha o campo senha!');</script>"; 
        }else{
            $usuario = $conexao->real_escape_string($_POST['usuario']);
            $senha = $conexao->real_escape_string($_POST['senha']);

            $sql_code_usuario = "SELECT * FROM tbusuarios WHERE usuario = '$usuario' AND senha = '$senha'";
            $sql_query_usuario = $conexao->query($sql_code_usuario) or die("ERRO:" . $conexao->error);

            $quantidade = $sql_query_usuario->num_rows;
            if($quantidade == 1){
                $user = $sql_query_usuario->fetch_assoc();
                
                if(!isset($_SESSION)){
                    session_start();
                }
                $_SESSION['usuario'] = $user ['usuario'];

                header("Location: Index.php");
            }else{
                echo "Falha ao conectar! Usuario ou senha incorretas.";
            }

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
    <script src='main.js'></script>
</head>

<body>
    <header class="Header">
        <div class="Itens">
            <div class="Logo">
                <img src="./image/logo.png" alt="Logo">
            </div>
            <ul>
                <a href="./Index.php">Home</a>
                <a href="./Livros.php">Livros</a>
                <a href="./Inserir.php">Inserir</a>
                <a href="./Login.php">Login</a>
            </ul>
            <form action="Index.php" method="get" class="Pesquisa">
                <span onclick="window.location.href='./Livros.php'" class="Lupa">search</span>
            </form>
        </div>
    </header>

    <div class="Login">
        <h1 class="h1Login">Login</h1>
        <form action="" method="post" class="">
            <label for="usuario">Usuario:</label>
            <input id="usuario" class="InserirInput Preencher" name="usuario" type="text">
            <br>
            <label for="senha">Senha:</label>
            <input id="senha" class="InserirInput Preencher" name="senha" type="password">

            <button type="submit" class="BotaoInserir">Login</button>
        </form>
    </div>

</body>
</html>
