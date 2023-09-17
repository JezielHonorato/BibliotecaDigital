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

<?php include("header.php"); ?>

    <?php if($_SESSION){ ?>
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
