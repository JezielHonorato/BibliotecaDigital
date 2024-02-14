<?php
  session_start();
  include('conexao.php');

  $titulo     = isset($_POST['titulo'])     ? ucwords(mb_strtolower($_POST['titulo']))     : false;
  $novo_autor = isset($_POST['novo_autor']) ? ucwords(mb_strtolower($_POST['novo_autor'])) : false;
  $novo_pais  = isset($_POST['novo_pais'])  ? ucwords(mb_strtolower($_POST['novo_pais']))  : false;
  $autor      = isset($_POST['autor']) && is_numeric($_POST['autor']) ? $_POST['autor'] : 1;
  $pais       = isset($_POST['pais'])  && is_numeric($_POST['pais'])  ? $_POST['pais']  : 1;
  $user       = isset($_SESSION['usuario']) ? $_SESSION['usuario'][0] : false;
  $nivel      = isset($_SESSION['usuario']) ? $_SESSION['usuario'][1] : false;
  $file       = isset($_FILES['file'])     ? $_FILES['file']     : false;
  $id_livro   = isset($_POST['id'])        ? $_POST['id']        : false;
  $data       = isset($_POST['data'])      ? $_POST['data']      : false;
  $categoria  = isset($_POST['categoria']) ? $_POST['categoria'] : false;
  $excluir    = isset($_POST['excluir'])   ? $_POST['excluir']   : false;
  $id         = isset($_GET['id'])         ? $_GET['id']         : false;
  $transaction = false;

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

  if (isset($_POST['submit_cadastrar'])) {
    $file['error'] ? die('Falha ao enviar o arquivo') : '';
    if($novo_autor || $novo_pais){
      $sql_consulta_pais_autor = $conexao->query("SELECT 'Autor' AS tipo WHERE NOT EXISTS (SELECT 1 FROM tbautor WHERE autor = '$novo_autor') UNION SELECT 'Pais' AS tipo WHERE NOT EXISTS (SELECT 1 FROM tbpais WHERE pais = '$novo_pais');") or die($conexao->error);
      $linhas_consulta = $sql_consulta_pais_autor->num_rows;
      if ($linhas_consulta == 0) {
        echo "<script>alert('o Autor e/ou Pais ja esta cadastrado no sistema!');</script>";
      } else {
        $transaction = "START TRANSACTION; ";
        while ($consultas = $sql_consulta_pais_autor->fetch_assoc()) {
          if ($consultas['tipo'] == 'Autor') {
            $transaction .= "INSERT INTO tbautor (autor) VALUES ('$novo_autor'); SET @idNovoAutor = LAST_INSERT_ID(); ";
            echo "autor foi  ";
          } elseif ($consultas['tipo'] == 'Pais') {
            $transaction .= "INSERT INTO tbpais (pais) VALUES ('$novo_pais'); SET @idNovoPais = LAST_INSERT_ID(); ";
            echo "pais foi";
      } } }
    } else {
      $consulta = $conexao->query("SELECT idLivro FROM tblivro WHERE titulo = '$titulo' AND idAutor = $autor");
      $resultado_consulta = $consulta->num_rows;
      if ($resultado_consulta >= 1) { 
        echo "<script>alert('Um livro com um mesmo Título e Autor já existe cadastrado no sistema!');</script>";
    } }
    $finalizado = move_uploaded_file($file['tmp_name'], "assets/$id_livro.pdf");
    if ($finalizado) {
      if($transaction){
        $transaction .= "INSERT INTO tblivro (titulo, data, idAutor, idPais, idCategoria, usuario) VALUES('$titulo', $data, COALESCE(@idNovoAutor, $autor), COALESCE(@idNovoPais, $pais), $categoria, '$user'); COMMIT;";
      } else {
        $transaction = "INSERT INTO tblivro (titulo, data, idAutor, idPais, idCategoria, usuario) VALUES('$titulo', $data, COALESCE(@idNovoAutor, $autor), COALESCE(@idNovoPais, $pais), $categoria, '$user');";
      } 
      echo $transaction;
      $conexao->query("$transaction") or die($conexao->error);
      header('Location: livros.php');
    } 
  } elseif (isset($_POST['submit_excluir'])) {
    if ($excluir == editar('titulo')){
      $conexao->query("DELETE FROM tblivro WHERE idLivro = $id_livro") or die($conexao->error);
      unlink("./assets/$id_livro.php");
      echo "<script>alert('Livro Excluido com sucesso com sucesso!');</script>";
      header('Location: livros.php');
    } else {
      echo "<script>alert('Digite o Nome do Livro Corretamente!');</script>";
    }
  } elseif (isset($_POST['submit_editar'])) {
    $conexao->query("UPDATE tblivro SET titulo = '$titulo', data = $data, idAutor = $autor, idPais = $pais, idCategoria = $categoria WHERE idLivro = $id_livro") or die($conexao->error);
    header('Location: livros.php');
    echo "<script>alert('Livro Editado com sucesso!');</>";
  }

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
        <label for='titulo'>Titulo:</label>
        <input type='text' id='titulo' name='titulo' placeholder='Titulo da obra' value="<?= editar('titulo') ?>">
      </div>
      <div>
        <label for='data'>Ano de Publicação:</label>
        <input type='number' id='data' name='data'  placeholder='ano de lançamento da obra' value="<?= editar('data') ?>">
      </div>
    </fieldset>
    <fieldset>
      <label for='ano'>Autor:</label>
      <select class='select-campos' id='autor' name='autor' required>
        <?php if ($id) {
          echo "<option selected value='". editar('idAutor') ."'>". editar('autor') ."</option>";
        } else {
          echo "<option>Selecione o autor da obra</option>";
        } while ($autor_db = $sql_autor->fetch_assoc()) {
          echo "<option value='". $autor_db['idAutor'] . "'>". $autor_db['autor'] ."</option>";
        } ?>
      </select>
      <?php if ($nivel > 1) { ?>
        <input type='text' id='autor_input' name='novo_autor' placeholder='Escreva o nome do autor, caso ele ainda NÂO esteja cadastrado' class='display-none'>
        <button class='novo-autor-pais' id='autor_button' onclick="cadastrarNovo('autor')">Adicionar um novo autor</button>
      <?php } ?>
    </fieldset>
    <fieldset>
      <label for='pais'>Pais:</label>
      <select class='select-campos' id='pais' name='pais' required>
      <?php if ($id) {
          echo "<option selected value='". editar('idPais') ."'>". editar('pais') ."</option>";
        } else {
          echo '<option>Selecione o pais da obra</option>';
        } while ($pais_db = $sql_pais->fetch_assoc()) {
          echo "<option value='". $pais_db['idPais'] . "'>" . $pais_db['pais'] ."</option>";
        } ?>
      </select>
      <?php if ($nivel > 1) { ?>
        <input type='text' id='pais_input' name='novo_pais' placeholder='Escreva o pais da obra, caso ele ainda NÂO esteja cadastrado' class='display-none'>
        <button class='novo-autor-pais' id='pais_button' onclick="cadastrarNovo('pais')">Adicionar um novo Pais</button>
      <?php } ?>
    </fieldset>
    <fieldset>
      <label for='categoria'>Categoria:</label>
      <select class='select-campos' id='categoria' name='categoria' required>
        <?php if ($id) {
          echo "<option selected value='". editar('idCategoria') ."'>". editar('categoria') ."</option>";
        } else {
          echo'<option>Selecione o tipo da obra</option>';
        } while ($categoria_db = $sql_categoria->fetch_assoc()) {
          echo "<option value='". $categoria_db['idCategoria'] . "'>" . $categoria_db['categoria'] ."</option>";
        } ?>
      </select>
    </fieldset>
    <fieldset>
      <?php if (!$id) { ?>
        <label for='file'>Selecione o arquivo:</label>
          <label for='file' class='cadastro-label-file' id='cadastro_label_file' ondrop='soltarArquivo(event)' ondragover='arrastarArquivo(event)'>Selecione o arquivo</label>
          <input class='display-none' type='file' name='file' id='file' onchange='mostrarArquivoInput(event)' accept='application/pdf' required>
        </fieldset>
        <fieldset>
          <button class='botao-submit' type='submit' name='submit_cadastrar'>Cadastrar</button>
      <?php } else { ?>
          <button class='botao-submit' type='submit' name='submit_editar'>Editar</button>
        </fieldset>
        <fieldset>
          <?= "<input type='text' class='align-center' placeholder='Digite \"". editar('titulo') ."\" para confirmar a exclusão desta obra' name='excluir' id='excluir'>" ?>
          <button class='botao-submit color-alert' type='submit' name='submit_excluir'>Excluir</button>
      <?php } ?>
    </fieldset>
  </form>
</main>

<?php } include('footer.php') ; ?>

</body>
</html>