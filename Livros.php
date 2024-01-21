<?php
    session_start();
    include ("conexao.php");

    $sql_code_categoria = "SELECT * FROM tbcategoria ORDER BY categoria ASC";
    $sql_query_categoria = $conexao->query($sql_code_categoria) or die($conexao->error);

    $sql_code_pais = "SELECT * FROM tbpais ORDER BY pais ASC";
    $sql_query_pais = $conexao->query($sql_code_pais) or die($conexao->error);

    $sql_code_minmax_data = "SELECT MIN(data) AS menor_valor, MAX(data) AS maior_valor FROM tblivro;";
    $sql_query_minmax_data = $conexao->query($sql_code_minmax_data) or die($conexao->error);

    $data = $sql_query_minmax_data->fetch_assoc();
    $menor_valor = $data["menor_valor"];
    $maior_valor = $data["maior_valor"];
?>

<?php include("header.php"); ?>
<input type="number" class="Invisivel" value="<?php echo $menor_valor ?>" id="valor_inicial">
<input type="number" class="Invisivel" value="<?php echo $maior_valor ?>" id="valor_final">

<div class="Conteudo">
    <div class="Busca">
        <div class="Campo">
            <label for="pesquisar">Pesquisar:</label>
            <div class="CampoInput">
                <label for="pesquisar" class="Simbolo Menor">search</label>
                <input type="search" class="Pesquisar" id="pesquisar" name="pesquisar" autocomplete="off" onchange="pesquisarLivro()">
            </div>
        </div>

        <div class="Campo">
            <label for="categoria">Categoria:</label>
            <div class="CampoInput">
                <label class="Simbolo">expand_more</label>
                <select class="Select" id="categoria" name="categoria" onchange="pesquisarLivro()">
                    <option></option>
                    <?php while($categoria = $sql_query_categoria->fetch_assoc()){
                        echo "<option value='" . $categoria['idcategoria'] . "'>" . $categoria['categoria'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="Campo">
            <label for="pais">Pais:</label>
            <div class="CampoInput">
                <label for="pais" class="Simbolo">expand_more</label>
                <select class="Select" id="pais" name="pais" onchange="pesquisarLivro()">
                    <?php while($pais = $sql_query_pais->fetch_assoc()){
                        echo "<option value='" . $pais['idPais'] . "'>" . $pais['pais'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="Campo">
            <div class="ValorRange">
                <a>Periodo:</a> <a class="RangeValor" id="range_valor">
                    <input type="number" id="input_menor_valor" class="InputMenorValor"></input>
                    <span class="RangeSepararValor">-</span>
                    <input type="number" id="input_maior_valor" class="InputMaiorValor"></input>
                </a>
            </div>
            <div class="CampoInput CampoR">
                <div class="Progresso" id="progresso"></div>
                <span class="LinhaDupla">                    
                    <input type="range" min="<?php echo $menor_valor ?>" max="<?php echo $maior_valor ?>" value="<?php echo $menor_valor ?>" id="range_menor" name="range_menor" class="Periodo" onchange="MudarPeriodo()" onclick="pesquisarLivro()">
                    <input type="range" min="<?php echo $menor_valor ?>" max="<?php echo $maior_valor ?>" value="<?php echo $maior_valor ?>" id="range_maior" name="range_maior" class="Periodo" onchange="MudarPeriodo()" onclick="pesquisarLivro()">
                </span>
            </div>
        </div>
        <input class="Invisivel" type="text" id="ordem" value="ORDER BY titulo ASC">
    </div>

    
    <div class="Lista">
        <div class="Livro" >
            <div class="Indice"> <h1><span class="Simbolo"> download</span></h1></div>
            <div class="Titulo"> <h1>Titulo</h1> <span onclick="Ordenar('titulo')" id="ordenar_titulo" class="Simbolo Menor2">swap_vert</span></div>
            <div class="Autor"> <h1>Autor</h1> <span onclick="Ordenar('autor')" id="ordenar_autor" class="Simbolo Menor2">swap_vert</span></div>
            <div class="Data"> <h1>Data</h1> <span onclick="Ordenar('data')" id="ordenar_data" class="Simbolo Menor2">swap_vert</span></div>
            <?php if(isset($_SESSION['usuario'])){ ?>
                <div class="Editar"> <span class='Simbolo'>edit</span></div>
            <?php } ?>
        </div>
        <div class="Lista" id='resultado' onload="pesquisarLivro()"></div>
    </div>

</div>

<?php include("footer.php"); ?>

</body>
</html>