<?php
    session_start();
    include ("conexao.php");

    if(isset($_POST['usuario']) || isset($_POST['senha'])){
        $usuario = $conexao->real_escape_string($_POST['usuario']);
        $senha = $conexao->real_escape_string($_POST['senha']);

        $sql_code_login = "SELECT * FROM tbusuarios WHERE usuario = '$usuario' AND senha = '$senha'";
        $sql_query_login = $conexao->query($sql_code_login) or die("ERRO:" . $conexao->error);

        $quantidade = $sql_query_login->num_rows;
        if($quantidade == 1){
            $user = $sql_query_login->fetch_assoc();
            session_start();
            $_SESSION['usuario'] = array($user['usuario'], $user['nivel']);
            header("Location: index.php");
        }else{
            echo "Falha ao conectar! Usuario ou senha incorretas.";
    }
    }

    $sql_code_usuario = "SELECT * FROM tbusuarios ORDER BY usuario ASC";
    $sql_query_usuario = $conexao->query($sql_code_usuario) or die($conexao->error);

    if(isset($_POST['submit_criar_user'])){
        $user_name= $_POST['user_name'];
        $user_nivel = $_POST['user_nivel'];

        $user_exist = $conexao->query("SELECT * FROM tbusuarios WHERE usuario = '$user_name'");
        $user_exist_linha = $user_exist->num_rows;

        if($user_exist_linha >= 1){
            echo  "<script>alert('Um usuário com o mesmo nome já existe cadastrado no sistema!');</script>";
        }else{
            $conexao->query("INSERT INTO tbusuarios (usuario, nivel, senha) VALUES('$user_name', $user_nivel, '$user_name')");
            echo  "<script>alert('Usuário cadastrado com sucesso! A senha e o nome do usuário são a mesma, mas você pode alter-lá depois.');</script>";
            header("Refresh: 0");
        }
    }

    if(isset($_POST['user_name_excluir'])){
        $excluir_senha = $_POST['user_senha_excluir'];
        $excluir_user = $_POST['user_name_excluir']; 
        $excluir_user_admin =  $_SESSION['usuario'][0];

        $sql_code_confirm = "SELECT * FROM tbusuarios WHERE usuario = '$excluir_user_admin' AND senha = '$excluir_senha'";
        $sql_query_confirm = $conexao->query($sql_code_confirm) or die("ERRO:" . $conexao->error);

        $confirmado = $sql_query_confirm->num_rows;
        if($confirmado == 1){
            $conexao->query("DELETE FROM tbusuarios WHERE usuario = '$excluir_user'");
            header("Refresh: 0");
        }else{
            echo "<script>alert('Senha incorreta.');</script>";
        }
    }
?>

<?php include("header.php"); ?>

    <div class="Conteudo">
        <?php if(isset($_SESSION['usuario'])){  ?>
            <?php if($_SESSION['usuario'][1] > 1){  ?>

                <h1 class="h1Login" id="usuario">Lista de usuários</h1>

                <form method="post" action="login.php" class="Invisivel" id="criar_usuario">
                    <div class="CriarApagar">
                        <input type="text" required placeholder="Digite o nome do novo usuário" name="user_name" id="user_name" class="UsuarioNome" autocomplete="off">
                        <input type="number" placeholder="Classe do usuário" name="user_nivel" id="user_nivel" class="UsuarioNivel">
                    </div>
                    <button class="CriarUser UsuarioNome" type="submit" id="submit_criar_user" name="submit_criar_user" onclick="CriarUsuario()">Criar um novo usuário</button>
                </form>

                <form action="login.php" method="post" class="Invisivel" id="apagar_usuario">
                    <div class="CriarApagar">
                        <input type='text' autocomplete='off' required placeholder='Digite o nome do usuário que deseja excluir' name='user_name_excluir' class="UsuarioNome">
                        <input type='password' required placeholder='Digite a sua senha' name='user_senha_excluir' class="UsuarioNivel">
                    </div>
                    <button class="ApagarUser" type="submit">Excluir</button>
                </form> 

                <div class="Lista" id="lista">
                    <div class="Usuario" >
                        <div class="UsuarioNome"> <h1>usuários</h1></div>
                        <div class="UsuarioNivel"> <h1>Classe</h1></div>
                    </div>
                    <?php while($lista_usuario = $sql_query_usuario->fetch_assoc()){
                        echo "<div class='Usuario'>";
                        echo "<div class='UsuarioNome'><a>" . $lista_usuario['usuario'] . "</a></div>";
                        echo "<div class='UsuarioNivel'><a>" . $lista_usuario['nivel'] . "</a></div>";
                        echo "</div>";
                    }?>
                </div>

                <div class="CriarApagar" id="criar_apagar">
                    <div>
                        <button class="CriarUser UsuarioNome" onclick="CriarUsuario()">Criar um novo usuário</button>
                    </div>

                    <div>
                        <button class="UsuarioNivel ApagarUser" onclick="ApagarUsuario()">Apagar usuário</button>
                    </div> 
                </div>

            <?php } ?>

            <div class="Login">
                <button onclick="window.location.href='./sair.php'" class="BotaoInserir">Sair</button>
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
        
    </div>

<?php include("footer.php"); ?>

</body>
</html>
