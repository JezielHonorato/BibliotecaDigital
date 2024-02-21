<?php require_once 'header.php'; ?>

<main>
  <section class='pesquisa-livros'>
    <section class='campos-pesquisa'>
      <label for='pesquisar'>Título ou Autor:</label>
      <div class='campos-input'>
        <i>search</i>
        <input type='search' class='pesquisar' id='pesquisar' name='pesquisar' onchange='pesquisarLivro()' autocomplete='off'>
      </div>
    </section>

    <section class='campos-pesquisa'>
      <label for='categoria'>Categoria:</label>
      <div class='campos-input'>
        <i>expand_more</i>
        <select class='select-campos' id='categoria' name='categoria' onchange='pesquisarLivro()'>
          <option></option>
          <?php foreach ($conn->selecionarTodos('categoria') as $value) {
            echo "<option value='". $value['idCategoria'] ."'>". $value['categoria'] ."</option>";
          } ?>
        </select>
      </div>
    </section>

    <section class='campos-pesquisa'>
      <label for='pais'>Pais:</label>
      <div class='campos-input'>
        <i>expand_more</i>
        <select class='select-campos' id='pais' name='pais' onchange='pesquisarLivro()'>
          <option></option>
          <?php foreach ($conn->selecionarTodos('pais') as $value) {
            echo "<option value='". $value['idPais'] ."'>". $value['pais'] ."</option>";
          } ?>
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
          <input type='range' min="<?= $conn->selecionarDatas()[0]['min'] ?>" max="<?= $conn->selecionarDatas()[0]['max'] ?>" value="<?= $conn->selecionarDatas()[0]['min'] ?>" id='range_menor' name='range_menor' class='Periodo' onchange='mudarPeriodo()' onclick='pesquisarLivro()'>
          <input type='range' min="<?= $conn->selecionarDatas()[0]['min'] ?>" max="<?= $conn->selecionarDatas()[0]['max'] ?>" value="<?= $conn->selecionarDatas()[0]['max'] ?>" id='range_maior' name='range_maior' class='Periodo' onchange='mudarPeriodo()' onclick='pesquisarLivro()'>
        </span>
      </section>
    </section>
    <input type='hidden' id='ordem' value='titulo ASC'>
  </section>

  <table class='tabela-livros'>
    <thead class='thead-livros'>
      <tr>
        <th><i> download</i></th>
        <th>Título <i onclick="ordenarLivros('titulo')" id='ordenar_titulo'>swap_vert</i></th>
        <th>Autor <i onclick="ordenarLivros('autor')" id='ordenar_autor'>swap_vert</i></th>
        <th>Data <i onclick="ordenarLivros('data')" id='ordenar_data'>swap_vert</i></th>
        <?php if(isset($_SESSION['usuario'])){
          echo '<th> <i>edit</i></th>';
        } ?>
      </tr>
    </thead>
    <tbody id='resultado_consulta' class='tbody-livros'>
    </tbody>
  </table>
</main>

<?php require_once "footer.php"; ?>