<?php
  session_start();
  include('conexao.php');

  $sql_pais = $conexao->query('SELECT idPais, pais FROM tbpais ORDER BY pais ASC') or die($conexao->error);
  $sql_datas = $conexao->query('SELECT MIN(data) AS menor_valor, MAX(data) AS maior_valor FROM tblivro') or die($conexao->error);
  $sql_categoria = $conexao->query('SELECT idCategoria, categoria FROM tbcategoria ORDER BY categoria ASC') or die($conexao->error);

  $data = $sql_datas->fetch_assoc();
  $menor_valor = $data['menor_valor'];
  $maior_valor = $data['maior_valor'];

  include('header.php');
?>

<main>
  <form autocomplete='off' class='pesquisa-livros'>
    <section class='campos-pesquisa'>
      <label for='pesquisar'>Título ou Autor:</label>
      <div class='campos-input'>
        <i>search</i>
        <input type='search' class='pesquisar' id='pesquisar' name='pesquisar' onchange='pesquisarLivro()'>
      </div>
    </section>

    <section class='campos-pesquisa'>
      <label for='categoria'>Categoria:</label>
      <div class='campos-input'>
        <i>expand_more</i>
        <select class='select-campos' id='categoria' name='categoria' onchange='pesquisarLivro()'>
          <option></option>
          <?php while ($categoria = $sql_categoria->fetch_assoc()) {
            echo "<option value='". $categoria['idCategoria'] ."'>". $categoria['categoria'] ."</option>";
          }
          ?>
        </select>
      </div>
    </section>

    <section class='campos-pesquisa'>
      <label for='pais'>Pais:</label>
      <div class='campos-input'>
        <i>expand_more</i>
        <select class='select-campos' id='pais' name='pais' onchange='pesquisarLivro()'>
          <?php while ($pais = $sql_pais->fetch_assoc()) {
            echo "<option value='". $pais['idPais'] ."'>". $pais['pais'] ."</option>";
          }
          ?>
        </select>
      </div>
    </section>

    <section class='campos-pesquisa'>
      <section class='range-value-input'>
        <p>Periodo:</p> <p class='valores-input' id='range_valor'> <p id='input_menor_valor' class='valor_input'></p> <p class='valor_input'>-</p> <p id='input_maior_valor' class='valor_input'></p>
        </p>
      </section>
      <section class='campos-input campo-range'>
        <div class='linha-progresso' id='linha_progresso'></div>
        <span class='range-duplo'>
          <input type='range' min='<?= $menor_valor ?>' max='<?= $maior_valor ?>' value='<?= $menor_valor ?>' id='range_menor' name='range_menor' class='Periodo' onchange='mudarPeriodo()' onclick='pesquisarLivro()'>
          <input type='range' min='<?= $menor_valor ?>' max='<?= $maior_valor ?>' value='<?= $maior_valor ?>' id='range_maior' name='range_maior' class='Periodo' onchange='mudarPeriodo()' onclick='pesquisarLivro()'>
        </span>
      </section>
    </section>
    <input type='hidden' id='ordem' value='ORDER BY titulo ASC'>
  </form>

  <table class='tabela-livros'>
    <thead>
      <tr>
        <th><i> download</i></th>
        <th>Título <i onclick="ordenar('titulo')" id='ordenar_titulo'>swap_vert</i></th>
        <th>Autor  <i onclick="ordenar('autor')"  id='ordenar_autor' >swap_vert</i></th>
        <th>Data   <i onclick="ordenar('data')"   id='ordenar_data'  >swap_vert</i></th>
        <?php if(isset($_SESSION['usuario'])){
          echo '<th> <i>edit</i></th>';
        } ?>
      </tr>
    </thead>
    <tbody id='resultado_consulta'>
    </tbody>
  </table>
</main>

<?php include('footer.php'); ?>