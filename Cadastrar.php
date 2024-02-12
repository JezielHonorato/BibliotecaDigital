<?php
  session_start();
  include('conexao.php');

  $titulo     = isset($_POST['titulo'])     ? ucwords(mb_strtolower($_POST['titulo']))     : false;
  $novo_autor = isset($_POST['novo_autor']) ? ucwords(mb_strtolower($_POST['novo_autor'])) : false;
  $novo_pais  = isset($_POST['novo_pais'])  ? ucwords(mb_strtolower($_POST['novo_pais']))  : false;
  $user       = isset($_SESSION['usuario']) ? $_SESSION['usuario'][0] : false;
  $file       = isset($_FILES['file'])      ? $_FILES['file']         : false;
  $id_livro   = isset($_POST['id'])         ? $_POST['id']            : false;
  $data       = isset($_POST['data'])       ? $_POST['data']          : false;
  $autor      = isset($_POST['autor'])      ? $_POST['autor']         : false;
  $pais       = isset($_POST['pais'])       ? $_POST['pais']          : false;
  $categoria  = isset($_POST['categoria'])  ? $_POST['categoria']     : false;
  $excluir    = isset($_POST['excluir'])    ? $_POST['excluir']       : false;
  $id         = isset($_GET['id'])          ? $_GET['id']             : false;

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
    $file['error'] ? die('Falha ao enviar o arquivo') : '';
    $consulta = $conexao->query("SELECT idLivro FROM tblivro WHERE titulo = '$titulo' AND idAutor = $autor")->num_rows;

    if ($consulta >= 1) { 
      echo "<script>alert('Um livro com um mesmo Título e Autor já existe cadastrado no sistema!');</script>";
    } else {
      $finalizado = move_uploaded_file($file['tmp_name'], 'assets/$titulo.pdf');
      if ($finalizado) {
        $conexao->query("INSERT INTO tblivro (titulo, data, idAutor, idPais, idCategoria, usuario) VALUES('$titulo', $data, $autor, $pais, $categoria, '$user');") or die($conexao->error);
        echo "<script>alert('Livro cadastrado com sucesso!');</script>";
        header('Location: livros.php');
  } } }

  else if ($excluir) {
    if ($excluir == editar('titulo')){
      $conexao->query("DELETE FROM tblivro WHERE idLivro = $id_livro") or die($conexao->error);
      unlink('assets/$titulo.php');
      echo "<script>alert('Livro Excluido com sucesso com sucesso!');</script>";
      header('Location: livros.php');
  } else {
    echo "<script>alert('Digite o Nome do Livro Corretamente!');</script>";
  } }

  else if($titulo && $id_livro){
    $conexao->query("UPDATE tblivro SET titulo = '$titulo', data = $data, idAutor = $autor, idPais = $pais, idCategoria = $categoria WHERE idLivro = $id_livro") or die($conexao->error);
    echo "<script>alert('Livro Editado com sucesso!');</script>";
    header('Location: livros.php');
  }
/*
  if($novo_autor){
    $consulta2 = $conexao->query("SELECT idAutor FROM tbautor WHERE autor = '$novo_autor'")->num_rows;

    if($consulta2 >= 1){
      echo "<script>alert('Um Autor com o mesmo nome já existe cadastrado no sistema!');</script>";
    }else{
      $conexao->query("INSERT INTO tbautor (autor) VALUES('$novo_autor')") or die($conexao->error);
      echo "<script>alert('Autor cadastrado com sucesso!');</script>";
      header('Refresh: 0');
    }
  }

  if($novo_pais){
    $consulta3 = $conexao->query("SELECT idPais FROM tbpais WHERE pais = '$novo_pais'")->num_rows;

    if($consulta3 >= 1){
      echo "<script>alert('Um Pais com o mesmo nome já existe cadastrado no sistema!');</script>";
    }else{
      $conexao->query("INSERT INTO tbpais (pais) VALUES('$novo_pais')") or die($conexao->error);
      echo "<script>alert('Pais cadastrado com sucesso!');</script>";
      header('Refresh: 0');
  } }
*/
  include('header.php'); 

  if (!$user) {
    echo "<body onclick=\'window.location.href='./login.php'\'> </body>";
  } else {

?>

<main>
  <form method='post' enctype='multipart/form-data' class='livros-cadastro' autocomplete='off'>
    <?php if ($id) { ?>
      <input type='hidden' id='id' name='id' value="<?= editar('idLivro') ?>">
      <h1 class='index-title'>Editar o Livro</h1>
    <?php } else {?>
      <h1 class='index-title'>Preencha os campos abaixo para adicionar novas obras ao catálogo</h1>
    <?php } ?>
    
    <fieldset class='cadastro-titulo-data'>
      <div>
        <label for='pesquisar'>Titulo:</label>
        <input type='text' id='pesquisar' value="<?= editar('titulo') ?>">
      </div>
      <div>
        <label for='ano'>Ano de Publicação:</label>
        <input type='number' id='ano' value="<?= editar('data') ?>">
      </div>
    </fieldset>
    <fieldset>
      <label for='ano'>Autor:</label><br>
      <select class='select-campos' id='autor' name='autor' required>
        <?php if ($id) {
          echo "<option selected value='". editar('idAutor') ."'>". editar('autor') ."</option>";
        } else {
            echo "<option>Selecione o autor da obra</option>";
        } while ($autor_db = $sql_autor->fetch_assoc()) {
            echo "<option value='". $autor_db['idAutor'] . "'>". $autor_db['autor'] ."</option>";
        } ?>
      </select>
    </fieldset>
    <fieldset>
      <label for='pais'>Pais:</label>
      <select class='select-campos' id='pais' name='pais' required>
      <?php if ($id) {
          echo "<option selected value='". editar('idPais') ."'>". editar('pais') ."</option>";
        } else {
          echo '<option>Escolha o pais da obra</option>';
        } while ($pais_db = $sql_pais->fetch_assoc()) {
          echo "<option value='". $pais_db['idPais'] . "'>" . $pais_db['pais'] ."</option>";
        } ?>
      </select>
    </fieldset>
    <fieldset>
      <label for='categoria'>Categoria:</label>
      <select class='select-campos' id='categoria' name='categoria' required>
        <?php if ($id) {
          echo "<option selected value='". editar('idCategoria') ."'>". editar('categoria') ."</option>";
        } else {
            echo'<option>Escolha o tipo da obra</option>';
        } while ($categoria_db = $sql_categoria->fetch_assoc()) {
            echo "<option value='". $categoria_db['idCategoria'] . "'>" . $categoria_db['categoria'] ."</option>";
        } ?>
      </select>
    </fieldset>
    <fieldset>
      <?php if (!$id) { ?>
        <label for='file'>Selecione o arquivo:</label>
          <label for='file' class='cadastro-label-file' id='cadastro_label_file'>Selecione o arquivo</label>
          <input class='display-none' type='file' name='file' id='file' onchange='mostrarArquivo()' accept='application/pdf' required>
        </fieldset>
        <fieldset>
          <button class='botao-submit' type='submit' name='submit'>Cadastrar</button>
      <?php } else { ?>
          <button class='botao-submit' type='submit' name='submit'>Editar</button>
        </fieldset>
        <fieldset>
          <?= "<input type='text' class='align-center' placeholder='Digite \"". editar('titulo') ."\" para confirmar a exclusão desta obra' name='excluir' id='excluir'>" ?>
          <button class='botao-submit color-alert' type='submit'>Excluir</button>
      <?php } ?>
    </fieldset>
  </form>
</main>
<!--
<form class='AddAutor' id='add_autor' method='post'>
  <a class='AddAutorTitulo'>
    <h1>Adicionar um novo Autor</h1> <span class='Simbolo' onclick='fecharAutor()'>close</span>
  </a>
  <div class='Preencher'> 
    <p><label class='Label' for='novo_autor'>Nome do Autor:</label></p>
    <input type='text' id='novo_autor' name='novo_autor' required class='InserirInput Preencher'>
  </div>
  <button class='BotaoInserir' type='submit' name='novo_submit_autor'>Enviar</button>
</form>

<form class='AddPais' id='add_pais' method='post'>
  <a Class='AddAutorTitulo'>
    <h1>Adicionar um novo Pais</h1> <span class='Simbolo' onclick='fecharPais()'>close</span>
  </a>
  <div class='Preencher'>
    <p><label class='Label' for='novo_paisr'>Nome do Pais:</label></p>
    <input type='text' id='novo_pais' name='novo_pais' required class='InserirInput Preencher'>
  </div>
  <button class='BotaoInserir' type='submit' name='novo_submit_pais'>Enviar</button>
</form>
      -->
<?php } include('footer.php') ; ?>

</body>
</html>