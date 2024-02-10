<?php
  session_start();
  include('conexao.php');
  $user = isset($_SESSION['usuario']) ? $_SESSION['usuario'][0] : '';

  if (isset($_POST['usuario']) || isset($_POST['senha'])) {
    $usuario = $conexao->real_escape_string($_POST['usuario']);
    $senha   = $conexao->real_escape_string($_POST['senha']);

    $sql_login = $conexao->query("SELECT usuario, nivel FROM tbusuarios WHERE usuario = '$usuario' AND senha = '$senha'") or die('ERRO:' . $conexao->error);

    $consulta = $sql_login->num_rows;
    if ($consulta == 1) {
      $user = $sql_login->fetch_assoc();
      session_start();
      $_SESSION['usuario'] = array($user['usuario'], $user['nivel']);
      header('Location: index.php');
    } else {
      echo 'Falha ao conectar! Usuario ou senha incorretas.';
    }
  }

  $sql_usuarios = $conexao->query('SELECT usuario, nivel FROM tbusuarios ORDER BY usuario ASC') or die($conexao->error);

  if (isset($_POST['submit_criar_user'])) {
    $user_name = $_POST['user_name'];
    $user_nivel = $_POST['user_nivel'];

    $user_exist = $conexao->query("SELECT id FROM tbusuarios WHERE usuario = '$user_name'");
    $consulta2 = $user_exist->num_rows;

    if ($consulta2 >= 1) {
      echo  "<script>alert('Um usuário com o mesmo nome já existe cadastrado no sistema!');</script>";
    } else {
      $conexao->query("INSERT INTO tbusuarios (usuario, nivel, senha) VALUES('$user_name', $user_nivel, '$user_name')");
      echo  "<script>alert('Usuário cadastrado com sucesso! A senha e o nome do usuário são a mesma, mas você pode alter-lá depois.');</script>";
      header('Refresh: 0');
    }
  }

  if (isset($_POST['user_name_excluir'])) {
    $excluir_senha = $_POST['user_senha_excluir'];
    $excluir_user = $_POST['user_name_excluir'];

    $sql_confirmar = $conexao->query("SELECT id FROM tbusuarios WHERE usuario = '$user' AND senha = '$excluir_senha'") or die('ERRO:' . $conexao->error);

    $consulta3 = $sql_confirmar->num_rows;
    if ($consulta3 == 1) {
      $conexao->query("DELETE FROM tbusuarios WHERE usuario = '$excluir_user'");
      header('Refresh: 0');
    } else {
      echo "<script>alert('Senha incorreta.');</script>";
    }
  }

  if (isset($_POST['trocar_senha'])) {
    $senha_antiga = $_POST['senha_antiga'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_nova_senha = $_POST['confirmar_nova_senha'];

    $sql_confirmar_denovo = $conexao->query("SELECT id FROM tbusuarios WHERE usuario = '$user' AND senha = '$senha_antiga'") or die('ERRO:' . $conexao->error);

    $consulta4 = $sql_confirmar_denovo->num_rows;
    if ($consulta4 == 1) {
      if ($nova_senha == $confirmar_nova_senha) {
        $conexao->query("UPDATE tbusuarios SET senha = '$nova_senha' WHERE usuario = '$user'");
        echo "<script>alert('Senha alterada com sucesso!');</script>";
      } else {
        echo "<script>alert('As senhas não batem.');</script>";
      }
    } else {
      echo "<script>alert('Senha incorreta.');</script>";
    }
  }
?>

<?php include('header.php'); ?>

<main>
  <?php if (isset($_SESSION['usuario'])) {  ?>
    <?php if ($_SESSION['usuario'][1] > 1) {  ?>

      <h1 class='index-title'>Lista de usuários</h1>

      <form method='post' class='Invisivel' id='criar_usuario' autocomplete='off'>
        <div class='CriarApagar'>
          <input type='text' placeholder='Digite o nome do novo usuário' name='user_name' id='user_name' class='UsuarioNome' required>
          <input type='number' required placeholder='Classe do usuário' name='user_nivel' id='user_nivel' class='UsuarioNivel'>
        </div>
        <button class='CriarUser UsuarioNome' type='submit' id='submit_criar_user' name='submit_criar_user' onclick='criarUsuario()'>Criar/Apagar usuário</button>
      </form>

      <form method='post' class='Invisivel' id='apagar_usuario' autocomplete='off'>
        <div class='CriarApagar'>
          <input type='text' placeholder='Digite o nome do usuário' name='user_name_excluir' class='UsuarioNome' required>
          <div class='InputSenha'>
            <input type='password' name='user_senha_excluir' id='input_senha_5' placeholder='Digite a sua senha'>
            <i id='span_5' onclick='mostrarSenha(5)'>visibility_off</i> </div>
        </div>
        <button class='ApagarUser' type='submit'>Excluir</button>
      </form>

      <div class='Lista' id='lista'>
        <div class='Usuario'>
          <div class='UsuarioNome'>
            <h1>usuários</h1>
          </div>
          <div class='UsuarioNivel'>
            <h1>Classe</h1>
          </div>
        </div>
        <?php while ($lista_usuario = $sql_usuarios->fetch_assoc()) {
          echo "<div class='Usuario'>";
          echo "<div class='UsuarioNome'><a>". $lista_usuario['usuario'] ."</a></div>";
          echo "<div class='UsuarioNivel'><a>". $lista_usuario['nivel'] ."</a></div>";
          echo "</div>";
        } ?>
      </div>

      <div class='CriarApagar' id='criar_apagar'>
        <div><button class='CriarUser UsuarioNome' onclick='criarUsuario()'>Criar um novo usuário</button></div>
        <div><button class='UsuarioNivel ApagarUser' onclick='apagarUsuario()'>Apagar usuário</button></div>
      </div>
    <?php } ?>

    <form action='Login.php' method='post' class='TrocarSenha'>
      <h1 class='index-title'>Alterar a senha</h1>
      <div class='InputSenha'>
        <input type='password' name='senha_antiga' id='input_senha_1' placeholder='Digite a sua senha atual'>
        <i id='span_1' onclick='mostrarSenha(1)'>visibility_off</i> </div>
      <div class='InputSenha'>
        <input type='password' name='nova_senha' id='input_senha_2' placeholder='Digite a nova senha'>
        <i id='span_2' onclick='mostrarSenha(2)'>visibility_off</i> </div>
      <div class='InputSenha'>
        <input type='password' name='confirmar_nova_senha' id='input_senha_3' placeholder='Confirme a senha'>
        <i id='span_3' onclick='mostrarSenha(3)'>visibility_off</i> </div>
      <button class='CriarUser' type='submit' name='trocar_senha'>Alterar a senha</button>
    </form>

    <div>
      <button onclick="window.location.href='./sair.php'" class='BotaoInserir'>Sair</button>
    </div>

  <?php } else { ?>
    <form method='post' class='login'>
      <h1 class='index-title'>Login</h1>
      <label for='usuario'>Usuario:</label>
      <input class='input-login' id='usuario' name='usuario' type='text' required>

      <label for='senha'>Senha:</label>
      <div class='input-senha'>
        <input type='password' name='senha' id='input_senha_4'>
        <i id='span_4' onclick='mostrarSenha(4)'>visibility_off</i> </div>
      <button type='submit' class='botao-submit'>Login</button>
    </form>
  <?php } ?>

</main>

<?php include('footer.php'); ?>

</body>
</html>