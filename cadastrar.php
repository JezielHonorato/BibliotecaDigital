<?php

require_once("header.php");

$titulo    = isset($_POST['titulo'])    ? $_POST['titulo']    : false;
$file      = isset($_FILES['file'])     ? $_FILES['file']     : false;
$autor     = isset($_POST['autor'])     ? $_POST['autor']     : false;
$pais      = isset($_POST['pais'])      ? $_POST['pais']      : false;
$data      = isset($_POST['data'])      ? $_POST['data']      : false;
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false;
$excluir   = isset($_POST['excluir'])   ? $_POST['excluir']   : false;
$id        = isset($_GET['id'])         ? $_GET['id']         : false;


if (isset($_POST['submit_cadastrar'])) {
  if($file['error']){
    echo "<script>alert('Falha ao enviar o arquivo');</script>";
  } else {
    $livro = $conn->cadastrarLivro($titulo, $data, $autor, $pais, $categoria, $user);
    if($livro) {
      if(move_uploaded_file($file['tmp_name'], "./assets/". $livro .".pdf")){
        header('Location: livros.php');
      }
    }
  } 
} elseif (isset($_POST['submit_excluir'])) {
  if ($conn->excluirLivro($id, $excluir)){
    header('Location: livros.php');
  } else {
    echo "<script>alert('ERRO');</script>";
  }
} elseif (isset($_POST['submit_editar'])) {
  if ($conn->editarLivro($titulo, $data, $autor, $pais, $categoria, $id)){
    header('Location: livros.php');
  }
}

if ($user) {
?>

<main>
<form method='post' enctype='multipart/form-data' class='livros-cadastro' autocomplete='off'>
  <?php if ($id) { ?>
    <input type='hidden' id='id' name='id' value="<?= $id ?>">
    <h1 class='index-title'>Preencha os campos abaixo para Editar o Livro</h1>
  <?php } else {?>
    <h1 class='index-title'>Preencha os campos abaixo para adicionar novas obras ao catálogo</h1>
  <?php } ?>
  
  <fieldset class='cadastro-titulo-data'>
    <div>
      <label for='titulo'>Titulo:</label>
      <input type='text' id='titulo' name='titulo' placeholder='Titulo da obra' value="<?= $conn->selecionarLivro($id, 'titulo') ?>">
    </div>
    <div>
      <label for='data'>Ano de Publicação:</label>
      <input type='number' id='data' name='data'  placeholder='ano de lançamento da obra' value="<?= $conn->selecionarLivro($id, 'data') ?>">
    </div>
  </fieldset>
  <fieldset>
    <label for='autor'>Autor:</label>
    <select class='select-campos' id='autor' name='autor' required>
      <?php if ($id) {
        echo "<option selected value='". $conn->selecionarLivro($id, 'idAutor') ."'>". $conn->selecionarLivro($id, 'autor') ."</option>";
      } else {
        echo "<option>Selecione o autor da obra</option>";
      } foreach ($conn->selecionarTodos('autor') as $value) {
        echo "<option value='". $value['idAutor'] ."'>". $value['autor'] ."</option>";
      } ?>
    </select>
    <?php if ($nivel > 1) { ?>
      <input type='text' id='autor_input' name='autor' placeholder='Escreva o nome do autor, caso ele ainda NÂO esteja cadastrado' class='display-none' disabled>
      <button class='novo-autor-pais' id='autor_button' onclick="cadastrarNovo('autor')">Adicionar um novo autor</button>
    <?php } ?>
  </fieldset>
  <fieldset>
    <label for='pais'>Pais:</label>
    <select class='select-campos' id='pais' name='pais' required>
    <?php if ($id) {
        echo "<option selected value='". $conn->selecionarLivro($id, 'idPais') ."'>". $conn->selecionarLivro($id, 'pais') ."</option>";
      } else {
        echo '<option>Selecione o pais da obra</option>';
      } foreach ($conn->selecionarTodos('pais') as $value) {
        echo "<option value='". $value['idPais'] ."'>". $value['pais'] ."</option>";
      } ?>
    </select>
    <?php if ($nivel > 1) { ?>
      <input type='text' id='pais_input' name='pais' placeholder='Escreva o pais da obra, caso ele ainda NÂO esteja cadastrado' class='display-none' disabled>
      <button class='novo-autor-pais' id='pais_button' onclick="cadastrarNovo('pais')">Adicionar um novo Pais</button>
    <?php } ?>
  </fieldset>
  <fieldset>
    <label for='categoria'>Categoria:</label>
    <select class='select-campos' id='categoria' name='categoria' required>
      <?php if ($id) {
        echo "<option selected value='". $conn->selecionarLivro($id, 'idCategoria') ."'>". $conn->selecionarLivro($id, 'categoria') ."</option>";
      } else {
        echo'<option>Selecione o tipo da obra</option>';
      } foreach ($conn->selecionarTodos('categoria') as $value) {
        echo "<option value='". $value['idCategoria'] ."'>". $value['categoria'] ."</option>";
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
        <?= "<input type='text' class='align-center' placeholder='Digite \"". $conn->selecionarLivro($id, 'titulo') ."\" para confirmar a exclusão desta obra' name='excluir' id='excluir'>" ?>
        <button class='botao-submit color-alert' type='submit' name='submit_excluir'>Excluir</button>
    <?php } ?>
  </fieldset>
</form>
</main>

<?php } require_once "footer.php"; ?>

</body>
</html>