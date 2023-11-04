<?php
    session_start();
    include ("conexao.php");

    $sql_code_categoria = "SELECT * FROM tbcategoria ORDER BY categoria ASC";
    $sql_query_categoria = $conexao->query($sql_code_categoria) or die($conexao->error);

    $sql_code_pais = "SELECT * FROM tbpais ORDER BY pais ASC";
    $sql_query_pais = $conexao->query($sql_code_pais) or die($conexao->error);

?>

<?php include("header.php"); ?>
<div class="Conteudo">
    <div class="Busca">
        <div class="Campo">
            <label for="pesquisar">Pesquisar:</label>
            <div class="CampoInput">
                <label for="pesquisar" class="Simbolo Menor">search</label>
                <input type="search" class="Pesquisar" id="pesquisar" name="pesquisar" autocomplete="off" onchange="PesquisarLivro()">
            </div>
        </div>

        <div class="Campo">
            <label for="categoria">Categoria:</label>
            <div class="CampoInput">
                <label class="Simbolo">expand_more</label>
                <select class="Select" id="categoria" name="categoria" onchange="PesquisarLivro()">
                    <option></option>
                    <?php while($categoria = $sql_query_categoria->fetch_assoc()){
                        echo "<option value='" . $categoria['idcategoria'] . "'>" . $categoria['categoria'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="Campo">
            <label for="nacionalidade">Pais:</label>
            <div class="CampoInput">
                <label for="nacionalidade" class="Simbolo">expand_more</label>
                <select class="Select" id="nacionalidade" name="nacionalidade" onchange="PesquisarLivro()">
                    <?php while($pais = $sql_query_pais->fetch_assoc()){
                        echo "<option value='" . $pais['idpais'] . "'>" . $pais['pais'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="Campo">
            <div class="ValorRange">
                <a>Periodo:</a> <a class="RangeValor" id="range_valor"> <input type="number" onchange="MudarPeriodoI()" id="range_menor_valor" class="RangeMenorValor"></input> <span class="RangeSepararValor">-</span> <input type="number" onchange="MudarPeriodoI()"  id="range_maior_valor" class="RangeMaiorValor"></input></a>
            </div>
            <div class="CampoInput CampoR">
                <div class="Progresso" id="progresso"></div>
                <span class="LinhaDupla">
                    <input type="range" min="0" max="2023" value="0" id="range_menor" name="range_menor" class="Periodo" onchange="MudarPeriodo()" onclick="PesquisarLivro()">
                    <input type="range" min="0" max="2023" value="2023" id="range_maior" name="range_maior" class="Periodo" onchange="MudarPeriodo()" onclick="PesquisarLivro()">
                </span>
            </div>
        </div>
    </div>

    
    <div class="Lista">
        <div class="Livro" >
            <div class="Indice"> <h1><span class="Simbolo"> download</span></h1></div>
            <div class="Titulo"> <h1>Titulo</h1> <span onclick="OrdenarT()" id="ordenar_titulo" class="Simbolo Menor2">swap_vert</span></div>
            <div class="Autor"> <h1>Autor</h1> <span onclick="OrdenarA()" id="ordenar_autor" class="Simbolo Menor2">swap_vert</span></div>
            <div class="Data"> <h1>Data</h1> <span onclick="OrdenarD()" id="ordenar_data" class="Simbolo Menor2">swap_vert</span></div>
            <?php if(isset($_SESSION['usuario'])){ ?>
                <div class="Editar"> <span class='Simbolo'>edit</span></div>
            <?php } ?>
        </div>
        <div class="Lista" id='resultado' onload="PesquisarLivro()"></div>
    </div>

</div>

<?php include("footer.php"); ?>

</body>
</html>