<?php require_once('header.php');

if (isset($_POST['login_submit'])) {
  $conn->conectarUsuario($_POST['usuario'], $_POST['senha']);
} elseif (isset($_POST['trocar_senha'])) {
  ($_POST['nova_senha'] == $_POST['confirmar_nova_senha']) ? $conn->alterarSenha($user, $_POST['senha_antiga'], $_POST['nova_senha']) : '';
} elseif (isset($_POST['botao_alterar_usuario']) && isset($_POST['user_nivel'])) {
  $conn->cadastrarUsuario($_POST['alterar_usuario_nome'], $_POST['user_nivel']);
} elseif (isset($_POST['botao_alterar_usuario']) && isset($_POST['senha_user'])) {
  $conn->apagarUsuario($_POST['alterar_usuario_nome']);
} elseif (isset($_POST['sair'])) {
  $conn->desconectarUsuario();
}
?>

<main>
  <?php if ($user) {  ?>
    <?php if ($nivel > 1) {  ?>

      <form method='post' class='display-none login' id='alterar_usuario' autocomplete='off'>
        <h1 class='index-title' id='alterar_usuario_titulo'></h1>
        <label for='usuario'>Usuario:</label>
        <input class='input-login' placeholder='Digite o nome do usuário' id='alterar_usuario_nome' name='alterar_usuario_nome' type='text' required>
        
        <div id='criar_usuario' class='display-none nivel-usuario'>
          <div>
            <input type="radio" id="estagiario" name="user_nivel" value="1">
            <label for="estagiario">Estagiario</label><sub>(Consegue criar e editar livros)</sub>
          </div>
          <div>
            <input type="radio" id="admin" name="user_nivel" value="2">
            <label for="admin">Administrador</label><sub>(consegue gerenciar usuarios)</sub>
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
          <?php foreach ($conn->selecionarTodos("usuario") as $value) {
            echo "<tr>";
            echo "<td>". $value['usuario'] ."</td>";
            echo "<td>". $value['nivel'] ."</td>";
            echo "</tr>";
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

    <form action="" method="post">
      <button type='submit' name='sair' class='botao-submit color-alert'>Sair</button>
    </form>

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
      <button type='submit' class='botao-submit' name='login_submit'>Login</button>
    </form>
  <?php } ?>

</main>

<?php include('footer.php'); ?>

</body>
</html>