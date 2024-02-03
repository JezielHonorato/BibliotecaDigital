<?php
  session_start();
  include("conexao.php");

  $titulo     = isset($_POST['titulo'])     ? ucwords(mb_strtolower($_POST['titulo']))     : false;
  $novo_autor = isset($_POST['novo_autor']) ? ucwords(mb_strtolower($_POST['novo_autor'])) : false;
  $novo_pais  = isset($_POST['novo_pais'])  ? ucwords(mb_strtolower($_POST['novo_pais']))  : false;
  $file       = isset($_FILES['file'])      ? $_FILES['file']     : false;
  $id_livro   = isset($_POST['id'])         ? $_POST['id']        : false;
  $data       = isset($_POST['data'])       ? $_POST['data']      : false;
  $autor      = isset($_POST['autor'])      ? $_POST['autor']     : false;
  $pais       = isset($_POST['pais'])       ? $_POST['pais']      : false;
  $categoria  = isset($_POST['categoria'])  ? $_POST['categoria'] : false;
  $excluir    = isset($_POST['excluir'])    ? $_POST['excluir']   : false;
  $id         = isset($_GET['id'])          ? $_GET['id']         : false;
  $user       = isset($_SESSION['usuario']) ? true : false;
  $usuario    = $_SESSION['usuario'][0];

  function editar($campo) {
    $id = $GLOBALS['id'];
    if ($id) {
      $sql_livro = $GLOBALS['conexao']->query("SELECT idLivro, titulo, autor, l.idAutor, categoria, l.idCategoria, pais, l.idPais, data FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor INNER JOIN tbcategoria AS c ON c.idCategoria = l.idCategoria INNER JOIN tbpais AS p ON p.idPais = l.idPais WHERE idLivro = $id");
      $livro = $sql_livro->fetch_assoc();
      return $livro["$campo"];
    } else {
      return $id;
    }
  }

  $sql_categoria = $conexao->query("SELECT idCategoria, categoria FROM tbcategoria ORDER BY categoria ASC") or die($conexao->error);
  $sql_autor     = $conexao->query("SELECT idAutor, autor FROM tbautor ORDER BY autor ASC") or die($conexao->error);
  $sql_pais      = $conexao->query("SELECT idPais, pais FROM tbpais ORDER BY pais ASC") or die($conexao->error);

  if ($file) {
    $file['error'] ? die("Falha ao enviar o arquivo") : '';
    $consulta = $conexao->query("SELECT idLivro FROM tblivro WHERE titulo = '$titulo' AND idAutor = $autor")->num_rows;

    if ($consulta >= 1) { 
      echo  "<script>alert('Um livro com um mesmo Título e Autor já existe cadastrado no sistema!');</script>";
    } else {
      $finalizado = move_uploaded_file($file["tmp_name"], "assets/$titulo.pdf");
      if ($finalizado) {
        $conexao->query("INSERT INTO tblivro (titulo, data, idAutor, idPais, idCategoria, usuario) VALUES('$titulo', $data, $autor, $pais, $categoria, '$usuario');") or die($conexao->error);
        echo "<script>alert('Livro cadastrado com sucesso!');</script>";
        header("Location: livros.php");
  } } }

  else if ($excluir) {
    if ($excluir == editar('titulo')){
      $conexao->query("DELETE FROM tblivro WHERE idLivro = $id_livro") or die($conexao->error);
      unlink("assets/$titulo.php");
      echo "<script>alert('Livro Excluido com sucesso com sucesso!');</script>";
      header('Location: livros.php');
  } else {
    echo "<script>alert('Digite o Nome do Livro Corretamente!');</script>";
  } }

  else if($titulo && $id_livro){
    $conexao->query("UPDATE tblivro SET titulo = '$titulo', data = $data, idAutor = $autor, idPais = $pais, idCategoria = $categoria WHERE idLivro = $id_livro") or die($conexao->error);
    echo "<script>alert('Livro Editado com sucesso!');</script>";
    header("Location: livros.php");
  }

  if($novo_autor){
    $consulta2 = $conexao->query("SELECT idAutor FROM tbautor WHERE autor = '$novo_autor'")->num_rows;

    if($consulta2 >= 1){
      echo "<script>alert('Um Autor com o mesmo nome já existe cadastrado no sistema!');</script>";
    }else{
      $conexao->query("INSERT INTO tbautor (autor) VALUES('$novo_autor')") or die($conexao->error);
      echo "<script>alert('Autor cadastrado com sucesso!');</script>";
      header("Refresh: 0");
    }
  }

  if($novo_pais){
    $consulta3 = $conexao->query("SELECT idPais FROM tbpais WHERE pais = '$novo_pais'")->num_rows;

    if($consulta3 >= 1){
      echo "<script>alert('Um Pais com o mesmo nome já existe cadastrado no sistema!');</script>";
    }else{
      $conexao->query("INSERT INTO tbpais (pais) VALUES('$novo_pais')") or die($conexao->error);
      echo "<script>alert('Pais cadastrado com sucesso!');</script>";
      header("Refresh: 0");
  } }

  include("header.php"); 

  if ($user) {
    echo "<body>";
  } else {
    echo "<body onclick=\"window.location.href='./login.php'\"> <div class='Cortina'></div>";
    echo "<div class='Erro'><span class='Simbolo Maior'>cancel</span> <span>Você precisa estar logado para acessar está página</span> <span class='Simbolo Maior'>cancel</span></div>";
  }
?>

<div class="Conteudo">
  <form method="post" enctype="multipart/form-data" id="inserir">
    <?php if($id) {?>
      <input type="text" hidden id="id" name="id" value="<?= editar('idLivro') ?>">
      <h1> Editar obra <br><br></h1>
    <?php } else {?>
      <h1> Preencha os campos abaixo para adicionar novas obras ao catálogo<br><br></h1>
    <?php } ?>
      
    <div class="NomeData">
      <div class="Preencher">
        <p><label class="Label">Título:</label></p>
        <input type="text" id="titulo" name="titulo" required class="InserirInput" placeholder="Titulo da Obra" value="<?= editar('titulo') ?>">
      </div>
      <div class="Preencher">
        <p><label class="Label" for="data">Ano de Publicação:</label></p>
        <input type="number" name="data" id="data" class="InserirInput" placeholder="Ano de Lançamento da Obra" value="<?= editar('data') ?>">
      </div>
    </div>

    <label class="Label" for="autor">Autor:</label>
    <div class="Flex">
      <select class="InserirSelect" id="autor" name="autor" required>
        <?php if ($id) {
          echo "<option selected value='". editar('idAutor') ."'>". editar('autor')."</option>";
        } else {?>
          <option>Selecione o autor da obra</option>
        <?php }
        while ($autor = $sql_autor->fetch_assoc()) {
          echo "<option value='". $autor['idAutor'] . "'>" . $autor['autor'] ."</option>";
        } ?>
      </select>
      <a class="NovoInserir" onclick="addAutor()">+</a>
    </div>

    <label class="Label" for="pais">Nacionalidade:</label>
    <div class="Flex">
      <select class="InserirSelect" id="pais" name="pais" required>
      <?php if ($id) {
          echo "<option selected value='". editar('idPais') ."'>". editar('pais') ."</option>";
        } else {?>
          <option> Escolha a nacionalidade da obra</option>
        <?php }
        while ($pais = $sql_pais->fetch_assoc()) {
          echo "<option value='". $pais['idPais'] . "'>" . $pais['pais'] ."</option>";
        } ?>
      </select>
      <a class="NovoInserir" onclick="addPais()">+</a>
    </div>

    <label class="Label" for="categoria">Categoria:</label>
    <select class="InserirSelect Preencher" id="categoria" name="categoria" required>
      <?php if ($id) {
        echo "<option selected value='". editar('idCategoria') ."'>". editar('categoria') ."</option>";
      } else {?>
        <option>Escolha o tipo da obra</option>
      <?php }
        while ($categoria = $sql_categoria->fetch_assoc()) {
        echo "<option value='". $categoria['idCategoria'] . "'>" . $categoria['categoria'] ."</option>";
      } ?>
    </select>

    <?php if ($id) { ?>
      <button class="BotaoInserir" type="submit" name="submit">Editar</button>

      <form action='' method="post" class="Excluir">
          <?= "<input type='text' autocomplete='off' placeholder='Digite ". editar('titulo') ." para confirmar a exclusão desta obra' name='excluir' id='excluir' class='ExcluirInput'>" ?>
          <button class="BotaoExcluir" type="submit">Excluir</button>
      </form> 
    <?php } else { ?>
      <label for="file" class="Label">Selecione o arquivo:</label>
      <label for="file" class="File">Selecione o arquivo</label>
      <input class="Invisivel" type="file" name="file" id="file" required accept="application/pdf">

      <?php if ($user) {
        echo "<button class='BotaoInserir' type='submit' name='submit'>Enviar</button>";
    } } ?>
  </form>
</div>

<form class="AddAutor" id="add_autor" method="post">
  <a class="AddAutorTitulo">
    <h1>Adicionar um novo Autor</h1> <span class="Simbolo" onclick="fecharAutor()">close</span>
  </a>
  <div class="Preencher"> 
    <p><label class="Label" for="novo_autor">Nome do Autor:</label></p>
    <input type="text" id="novo_autor" name="novo_autor" required class="InserirInput Preencher">
  </div>
  <button class="BotaoInserir" type="submit" name="novo_submit_autor">Enviar</button>
</form>

<form class="AddPais" id="add_pais" method="post">
  <a Class="AddAutorTitulo">
    <h1>Adicionar um novo Pais</h1> <span class="Simbolo" onclick="fecharPais()">close</span>
  </a>
  <div class="Preencher">
    <p><label class="Label" for="novo_paisr">Nome do Pais:</label></p>
    <input type="text" id="novo_pais" name="novo_pais" required class="InserirInput Preencher">
  </div>
  <button class="BotaoInserir" type="submit" name="novo_submit_pais">Enviar</button>
</form>

<?php include("footer.php"); ?>

</body>
</html>