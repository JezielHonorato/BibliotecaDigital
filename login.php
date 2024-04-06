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
} elseif (isset($_GET['tabela'])) {
  $conn->alterarAutorPais("a", 1, "a");
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
          <?php foreach ($conn->selecionarTodos(4) as $value) {
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

      <h1 class='index-title'>Lista de Autores</h1>

      <table class='tabela-usuarios' id='lista'>
        <thead>
          <tr>
            <th>Autores</th>
            <th class='align-center'>Ferramentas</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($conn->selecionarTodos(1) as $value) {
            echo "<tr>";  
            echo "<td>". $value['autor'] ."</td>";
            echo "<td class='ferramenta-editar'><i onclick='editarCampo(\"editar_autor_". $value['idAutor'] ."\", true)'> edit </i> | <i class='item-alert' onclick='excluirCampo(\"excluir_autor_". $value['idAutor'] ."\", true)'> delete </i></td>";
            echo "</tr>";

            echo "<tr class='editar-tabela' style='display:none' id='editar_autor_". $value['idAutor'] ."'>";
            echo "<form method='post'>";
            echo "<td> <input type='text' name='editar_autor' placeholder='Digite o novo nome para o Autor | ". $value['autor'] ."'></td>";
            echo "<td class='ferramenta-editar'> <button class='no-background' type='submit' class='align-center' name='editar_autor_submit'> <i class='item-warning'> done </i></button> | <i class='item-alert' onclick='editarCampo(\"editar_autor_". $value['idAutor'] ."\")'> close </i></td>";
            echo "</form>";
            echo "</tr>";

            echo "<tr class='editar-tabela' style='display:none' id='excluir_autor_". $value['idAutor'] ."'>";
            echo "<form method='post'>";
            echo "<td> Tem Certeza que deseja excluir o autor: ". $value['autor'] ."</td>";
            echo "<td class='ferramenta-editar'> <button class='no-background' type='submit' class='align-center' name='excluir_autor_submit'> <i class='item-warning'> delete </i></button> | <i class='item-alert' onclick='excluirCampo(\"excluir_autor_". $value['idAutor'] ."\")'> close </i></td>";
            echo "</form>";
            echo "</tr>";
          } ?>
        </tbody>
      </table>

      <h1 class='index-title'>Lista de Paises</h1>

      <table class='tabela-usuarios' id='lista'>
        <thead>
          <tr>
            <th>Paises</th>
            <th class='align-center'>Ferramentas</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($conn->selecionarTodos(3) as $value) {
            echo "<tr>";
            echo "<td>". $value['pais'] ."</td>";
            echo "<td class='ferramenta-editar'><i onclick='editarCampo(\"editar_pais_". $value['idPais'] ."\", true)'> edit </i> | <i class='item-alert' onclick='excluirCampo(\"excluir_pais_". $value['idPais'] ."\", true)'> delete </i></td>";
            echo "</tr>";

            echo "<tr class='editar-tabela' style='display:none' id='editar_pais_". $value['idPais'] ."'>";
            echo "<form method='post id='form_editar_pais'>";
            echo "<td> <input type='text' name='editar_pais' placeholder='Digite o novo nome para o pais | ". $value['pais'] ."'></td>";
            echo "<td class='ferramenta-editar'> <button class='no-background' type='submit' name='editar_pais_submit'> <i class='item-warning'> done </i></button> | <i class='item-alert' onclick='editarCampo(\"editar_pais_". $value['idPais'] ."\")'> close </i> </td>";
            echo "</form>";
            echo "</tr>";

            echo "<tr class='editar-tabela' style='display:none' id='excluir_pais_". $value['idPais'] ."'>";
            echo "<form method='post'>";
            echo "<td> Tem Certeza que deseja excluir o Paas: ". $value['pais'] ."</td>";
            echo "<td class='ferramenta-editar'> <button class='no-background' type='submit' class='align-center' name='excluir_pais_submit'> <i class='item-warning'> delete </i></button> | <i class='item-alert' onclick='excluirCampo(\"excluir_pais_". $value['idPais'] ."\")'> close </i></td>";
            echo "</form>";
            echo "</tr>";
          } ?>
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