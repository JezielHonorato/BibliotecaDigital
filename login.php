<?php
  session_start();
  include('conexao.php');
  $user = isset($_SESSION['usuario']) ? $_SESSION['usuario'][0] : '';

  if (isset($_POST['usuario']) || isset($_POST['senha'])) {
    $usuario = $conexao->real_escape_string($_POST['usuario']);
    $senha   = $conexao->real_escape_string($_POST['senha']);

    $sql_login = $conexao->query("SELECT usuario, nivel FROM tbusuarios WHERE usuario = '$usuario' AND senha = '$senha'") or die('ERRO:' . $conexao->error);

    $consulta_login = $sql_login->num_rows;
    if ($consulta_login == 1) {
      $user = $sql_login->fetch_assoc();
      session_start();
      $_SESSION['usuario'] = array($user['usuario'], $user['nivel']);
      header('Location: index.php');
    } else {
      echo 'Falha ao conectar! Usuario ou senha incorretas.';
    }
  }

  if (isset($_POST['botao_alterar_usuario'])) {
    $user_name = isset($_POST['alterar_usuario_nome']) ? $_POST['alterar_usuario_nome'] : false;
    $user_classe = isset($_POST['user_classe']) ? $_POST['user_classe'] : false;
    $confirmar_senha = isset($_POST['senha_user']) ? $_POST['senha_user'] : false;

    $sql_consulta_alterar = $conexao->query("SELECT id FROM tbusuarios WHERE usuario = '$user_name'") or die('ERRO:' . $conexao->error);
    $consulta_alterar = $sql_consulta_alterar->num_rows;
    if ($consulta_alterar == 1) {
      if ($user_classe) {
        echo "<script>alert('Um usuario com o mesmo nome ja esta cadastrado.')</script>";
      } else {
        $sql_confirmar_senha = $conexao->query("SELECT id FROM tbusuarios WHERE usuario = '$user' AND senha = '$confirmar_senha'") or die('ERRO:' . $conexao->error);
        $consulta6 = $sql_confirmar_senha->num_rows;      
        if ($consulta6 == 1) {          
          $conexao->query("DELETE FROM tbusuarios WHERE usuario = '$user_name'");
          header('Refresh: 0');
        } else {
          echo "<script>alert('Senha incorreta.');</script>";
        }
      }
    } else {
      if ($confirmar_senha) {
        echo "<script>alert('Este usuario nao existe.')</script>";
      } else {
        $conexao->query("INSERT INTO tbusuarios (usuario, nivel, senha) VALUES('$user_name', $user_classe, '$user_name')");
        echo "<script>alert('Usuário cadastrado com sucesso! A senha e o nome do usuário são a mesma, mas você pode altera-lá depois.');</script>";
        header('Refresh: 0');  
      }
    }
  }

  if (isset($_POST['trocar_senha'])) {
    $senha_antiga = $_POST['senha_antiga'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_nova_senha = $_POST['confirmar_nova_senha'];

    $sql_consulta_senha = $conexao->query("SELECT id FROM tbusuarios WHERE usuario = '$user' AND senha = '$senha_antiga'") or die('ERRO:' . $conexao->error);

    $consulta_alterar_senha = $sql_consulta_senha->num_rows;
    if ($consulta_alterar_senha == 1) {
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

  $sql_usuarios = $conexao->query('SELECT usuario, nivel FROM tbusuarios ORDER BY usuario ASC') or die($conexao->error);
?>

<?php include('header.php'); ?>

<main>
  <?php if (isset($_SESSION['usuario'])) {  ?>
    <?php if ($_SESSION['usuario'][1] > 1) {  ?>

      <form method='post' class='display-none login' id='alterar_usuario' autocomplete='off'>
        <h1 class='index-title' id='alterar_usuario_titulo'></h1>
        <label for='usuario'>Usuario:</label>
        <input class='input-login' placeholder='Digite o nome do usuário' id='alterar_usuario_nome' name='alterar_usuario_nome' type='text' required>
        
        <div id='criar_usuario' class='display-none'>
          <label for="user_classe">Classe do Usuario:</label>
          <input type='number' placeholder='Classe do usuário' name='user_classe' id='user_classe' class='UsuarioNivel'>
        </div>

        <div id='apagar_usuario' class='display-none'>
          <label for='senha'>Senha:</label>
          <div class='input-senha'>
            <input type='password' name='senha_user' id='input_senha_5'>
            <i id='span_5' onclick='mostrarSenha(5)'>visibility_off</i>
          </div>
        </div>
        <button type='submit' class='botao-submit' name='botao_alterar_usuario'>Confirmar</button>
      </form>

      <h1 class='index-title'>Lista de usuários</h1>

      <table class='tabela-usuarios' id='lista'>
        <thead>
          <tr>
            <th>Usuarios</th>
            <th>Nível de Acesso</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($lista_usuario = $sql_usuarios->fetch_assoc()) {
            echo '<tr>';
            echo '<td>'. $lista_usuario['usuario'] .'</td>';
            echo '<td>'. $lista_usuario['nivel'] .'</td>';
            echo '</tr>';
          } ?>
          <tr>
            <td class='criar-usuario' onclick="alterarUsuario('criar')">Criar um novo usuário</td>
            <td class='apagar-usuario' onclick="alterarUsuario('apagar')">Apagar Usuario</td>
          </tr>
        </tbody>
      </table>
    <?php } ?>

    <form method='post' class='alterar-senha'>
      <h1 class='index-title'>Alterar a senha</h1>
      <div class='input-senha'>
        <input type='password' name='senha_antiga' id='input_senha_1' placeholder='Digite a sua senha atual'>
        <i id='span_1' onclick='mostrarSenha(1)'>visibility_off</i>
      </div>
      <div class='input-senha'>
        <input type='password' name='nova_senha' id='input_senha_2' placeholder='Digite a nova senha'>
        <i id='span_2' onclick='mostrarSenha(2)'>visibility_off</i>
      </div>
      <div class='input-senha'>
        <input type='password' name='confirmar_nova_senha' id='input_senha_3' placeholder='Confirme a senha'>
        <i id='span_3' onclick='mostrarSenha(3)'>visibility_off</i>
      </div>
      <button class='botao-submit' type='submit' name='trocar_senha'>Alterar a senha</button>
    </form>

    <button onclick="window.location.href='./sair.php'" class='botao-submit color-alert'>Sair</button>

  <?php } else { ?>
    <form method='post' class='login'>
      <h1 class='index-title'>Login</h1>
      <label for='usuario'>Usuario:</label>
      <input class='input-login' id='usuario' name='usuario' type='text' required>

      <label for='senha'>Senha:</label>
      <div class='input-senha'>
        <input type='password' name='senha' id='input_senha_4'>
        <i id='span_4' onclick='mostrarSenha(4)'>visibility_off</i>
      </div>
      <button type='submit' class='botao-submit' name='login-submit'>Login</button>
    </form>
  <?php } ?>

</main>

<?php include('footer.php'); ?>

</body>
</html>