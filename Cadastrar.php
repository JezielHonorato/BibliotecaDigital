<?php
  session_start();
  include("conexao.php");

  isset($_SESSION['usuario']) ? $user = true : $user = false;
  isset($_GET['id']) ? $id = $_GET['id'] : $id = false;

  function editar($campo) {
    $id = $GLOBALS['id'];
    if ($id) {
      $sql_code_livro = "SELECT titulo, autor, idAutor, categoria, l.idCategoria, pais, l.idPais, data FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor INNER JOIN tbcategoria AS c ON c.idCategoria = l.idCategoria INNER JOIN tbpais AS p ON p.idPais = l.idPais WHERE idlivro = $id";
      $sql_query_livro = $GLOBALS['conexao']->query($sql_code_livro) or die($sql_code_livro);
      $livro = $sql_query_livro->fetch_assoc();
      return $livro["$campo"];
    } else {
      return false;
    }
  }

  include("header.php"); 

  if ($user) {
    echo "<body>";
  } else {
    echo "<body onclick=\"window.location.href='./login.php'\"> <div class='Cortina'></div>";
    echo "<div class='Erro'><span class='Simbolo Maior'>cancel</span> <span>Você precisa estar logado para acessar está página</span> <span class='Simbolo Maior'>cancel</span></div>";
  }
?>

<div class="Conteudo">
  <form method="post" enctype="multipart/form-data" action="cadastrar.php" id="inserir">
    <?php if($id) {?>
      <h1> Preencha os campos abaixo para adicionar novas obras ao catálogo<br><br></h1>
    <?php } else {?>
      <h1> Editar obra <br><br></h1>
    <?php } ?>
      
    <div class="NomeData">
      <div class="Preencher">
        <p><label class="Label">Título:</label></p>
          <input type="text" id="titulo" name="titulo" required class="InserirInput" value="<?php editar('titulo') ?>">
      </div>
      <div class="Preencher">
        <p><label class="Label" for="data">Ano de Publicação:</label></p>
        <input type="number" name="data" id="data" class="InserirInput" value="<?php editar('data') ?>">
      </div>
    </div>

    <label class="Label" for="autor">Autor:</label>
    <div class="Flex">
      <select class="InserirSelect" id="autor" name="autor" required>
        <?php if ($id) {
          echo "<option value='". editar('idAutor') ."'>". editar('autor')."</option>";
        } else {?>
          <option>Selecione o autor da obra</option>
        <?php }
        while ($autor = $sql_query_autor->fetch_assoc()) {
          echo "<option value='". $autor['idAutor'] . "'>" . $autor['autor'] ."</option>";
        } ?>
      </select>
      <button class="NovoInserir" onclick="AddAutor()">+</button>
    </div>

    <label class="Label" for="pais">Nacionalidade:</label>
    <div class="Flex">
      <select class="InserirSelect" id="pais" name="pais" required>
      <?php if ($id) {
          echo "<option value='". editar('idPais') ."'>". editar('pais') ."</option>";
        } else {?>
          <option> Escolha a nacionalidade da obra</option>
        <?php }
        while ($pais = $sql_query_pais->fetch_assoc()) {
          echo "<option value='". $pais['idPais'] . "'>" . $pais['pais'] ."</option>";
        } ?>
      </select>
      <button class="NovoInserir" onclick="AddPais()">+</button>
    </div>

    <label class="Label" for="categoria">Categoria:</label>
    <select class="InserirSelect Preencher" id="categoria" name="categoria" required>
      <?php if ($id) {
        echo "<option value='". editar('idCategoria') ."'>". editar('categoria') ."</option>";
      } else {?>
        <option>Escolha o tipo da obra</option>
      <?php }
        while ($categoria = $sql_query_categoria->fetch_assoc()) {
        echo "<option value='". $categoria['idCategoria'] . "'>" . $categoria['categoria'] ."</option>";
      } ?>
    </select>

    <?php if ($id) { ?>
      <button class="BotaoInserir" type="submit" name="submit">Editar</button>

      <form action="" method="post" class="Excluir">
          <?php echo "<input type='text' autocomplete='off' placeholder='Digite \"$excluir\" para confirmar a exclusão desta obra' name='excluir' class='ExcluirInput'>" ?>
          <button class="BotaoExcluir" type="submit">Excluir</button>
      </form> 
    <?php } else { ?>

      <label for="file" class="Label">Selecione o arquivo:</label>
      <label for="file" class="File">Selecione o arquivo</label>
      <input class="Invisivel" type="file" name="file" id="file" required accept="application/pdf">
      
    <?php if ($user) {
      echo "<button class='BotaoInserir' type='submit' name='submit'>Enviar</button>";
    }} ?>
    </form>
</div>

<form class="AddAutor" id="add_autor" method="post" action="inserir.php">
  <a Class="AddAutorTitulo">
    <h1>Adicionar um novo Autor</h1> <span class="Simbolo" onclick="FecharAutor()">close</span>
  </a>
  <div class="Preencher"> 
    <p><label class="Label" for="novo_autor">Nome do Autor:</label></p>
    <input type="text" id="novo_autor" name="novo_autor" required class="InserirInput Preencher">
  </div>

  <label class="Label" for="pais">Nacionalidade:</label>
  <div class="Flex">
    <select class="InserirSelect" id="novo_pais" name="novo_pais" required>
      <option> Escolha a nacionalidade do autor</option>
      <?php while ($pais_2 = $sql_query_pais_2->fetch_assoc()) {
        echo "<option value='" . $pais_2['idPais'] . "'>" . $pais_2['pais'] . "</option>";
      }
      ?>
    </select>
    <button class="NovoInserir" onclick="AddPais()">+</button>
  </div>
  <button class="BotaoInserir" type="submit" name="novo_submit_autor">Enviar</button>
</form>

<form class="AddPais" id="add_pais" method="post" action="inserir.php">
  <a Class="AddAutorTitulo">
    <h1>Adicionar um novo Pais</h1> <span class="Simbolo" onclick="FecharPais()">close</span>
  </a>
  <div class="Preencher">
    <p><label class="Label" for="novo_pais2r">Nome do Pais:</label></p>
    <input type="text" id="novo_pais" name="novo_pais2" required class="InserirInput Preencher">
  </div>
  <button class="BotaoInserir" type="submit" name="novo_submit_pais">Enviar</button>
</form>

<?php include("footer.php"); ?>

</body>
</html>