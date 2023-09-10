<?php
    session_start();
    include ("conexao.php");

    $sql_code_categoria = "SELECT * FROM tbcategoria ORDER BY categoria ASC";
    $sql_query_categoria = $conexao->query($sql_code_categoria) or die($conexao->error);

    $sql_code_pais = "SELECT * FROM tbpais ORDER BY pais ASC";
    $sql_query_pais = $conexao->query($sql_code_pais) or die($conexao->error);


    if(!empty($_GET['pesquisar'])){
        $pesquisa = ucwords(mb_strtolower($_GET['pesquisar']));

        if(!empty($_GET['categoria'])){
            $categoriav = $_GET['categoria'];

            if(!empty($_GET['nacionalidade'])){
                $nacionalidadev = $_GET['nacionalidade'];

                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $range_menor = $_GET['range_menor'];
                    $range_maior = $_GET['range_maior'];
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.idcategoria = $categoriav AND l.idpais = $nacionalidadev AND l.publicadodata BETWEEN $range_menor AND $range_maior OR a.autor LIKE '%$pesquisa%' AND l.idcategoria = $categoriav AND l.idpais = $nacionalidadev AND l.publicadodata BETWEEN $range_menor AND $range_maior";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.idcategoria = $categoriav AND l.idpais = $nacionalidadev OR a.autor LIKE '%$pesquisa%' AND l.idcategoria = $categoriav AND l.idpais = $nacionalidadev";
                }
            }
            else{
                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $range_menor = $_GET['range_menor'];
                    $range_maior = $_GET['range_maior'];
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.idcategoria = $categoriav AND l.publicadodata BETWEEN $range_menor AND $range_maior OR a.autor LIKE '%$pesquisa%' AND l.idcategoria = $categoriav AND l.publicadodata BETWEEN $range_menor AND $range_maior";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.idcategoria = $categoriav OR a.autor LIKE '%$pesquisa%' AND l.idcategoria = $categoriav";
                }
            }
        }
        else{
            if(!empty($_GET['nacionalidade'])){
                $nacionalidadev = $_GET['nacionalidade'];

                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $range_menor = $_GET['range_menor'];
                    $range_maior = $_GET['range_maior'];
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.idpais = $nacionalidadev AND l.publicadodata BETWEEN $range_menor AND $range_maior OR a.autor LIKE '%$pesquisa%' AND l.idpais = $nacionalidadev AND l.publicadodata BETWEEN $range_menor AND $range_maior";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.idpais = $nacionalidadev OR a.autor LIKE '%$pesquisa%' AND l.idpais = $nacionalidadev";
                }
            }
            else{
                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $range_menor = $_GET['range_menor'];
                    $range_maior = $_GET['range_maior'];
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.publicadodata BETWEEN $range_menor AND $range_maior OR a.autor LIKE '%$pesquisa%' AND l.publicadodata BETWEEN $range_menor AND $range_maior";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' OR a.autor LIKE '%$pesquisa%'";
                }
            }
        }
    }
    else{
        if(!empty($_GET['categoria'])){
            $categoriav = $_GET['categoria'];

            if(!empty($_GET['nacionalidade'])){
                $nacionalidadev = $_GET['nacionalidade'];

                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $range_menor = $_GET['range_menor'];
                    $range_maior = $_GET['range_maior'];
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.idcategoria = $categoriav AND l.idpais = $nacionalidadev AND l.publicadodata BETWEEN $range_menor AND $range_maior";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.idcategoria = $categoriav AND l.idpais = $nacionalidadev";
                }
            }
            else{
                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $range_menor = $_GET['range_menor'];
                    $range_maior = $_GET['range_maior'];
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.idcategoria = $categoriav AND l.publicadodata BETWEEN $range_menor AND $range_maior";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.idcategoria = $categoriav";
                }
            }
        }
        else{
            if(!empty($_GET['nacionalidade'])){
                $nacionalidadev = $_GET['nacionalidade'];

                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $range_menor = $_GET['range_menor'];
                    $range_maior = $_GET['range_maior'];
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.idpais = $nacionalidadev AND l.publicadodata BETWEEN $range_menor AND $range_maior";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.idpais = $nacionalidadev";
                }
            }
            else{
                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $range_menor = $_GET['range_menor'];
                    $range_maior = $_GET['range_maior'];
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.publicadodata BETWEEN $range_menor AND $range_maior";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor";
                }
            }
        }
    }
    $sql_query_livro = $conexao->query($sql_code_livro) or die($conexao->error);    

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Biblioteca Digital</title>
    <link rel="shortcut icon" href="./image/logo.ico" />
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src='main.js'></script>
</head>

<body>
    <header class="Header">
        <div class="Logo">
            <img src="./image/logo.png" alt="Logo">
        </div>
        <ul class="Itens">
            <a href="./Index.php">Home</a>
            <a href="./Livros.php">Livros</a>
            <a href="./Inserir.php">Inserir</a>
            <a href="./Login.php">Login</a>
        </ul>
        <form action="Index.php" method="get" class="Pesquisa">
            <span onclick="window.location.href='./Livros.php'" class="Simbolo">search</span>
        </form>
    </header>

    
    <form action="" method="get" class="Busca">
        <div class="GrupoCampo">
            <div class="Campo">
                <label for="pesquisar" class="PesquisarLabel">Pesquisar</label>
                <label for="pesquisar" class="Simbolo Menor">search</label>
                <input type="search" class="Pesquisar" id="pesquisar" name="pesquisar">
            </div>

            <div class="Campo">
                <label for="categoria" class="PesquisarLabel">Categoria</label>
                <label class="Simbolo">expand_more</label>
                <select class="Select" id="categoria" name="categoria">
                    <option></option>
                    <?php while($categoria = $sql_query_categoria->fetch_assoc()){
                        echo "<option value='" . $categoria['idcategoria'] . "'>" . $categoria['categoria'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="Campo">
                <label for="nacionalidade" class="PesquisarLabel">Pais</label>
                <label for="nacionalidade" class="Simbolo">expand_more</label>
                <select class="Select" id="nacionalidade" name="nacionalidade">
                    <option></option>
                    <?php while($pais = $sql_query_pais->fetch_assoc()){
                        echo "<option value='" . $pais['idpais'] . "'>" . $pais['pais'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="Campo CampoR">
                <div class="ValorRange">
                    <a>Periodo:</a> <a class="RangeValor" id="range_valor"> <input type="number" onchange="MudarPeriodoI()" id="range_menor_valor" class="RangeMenorValor"></input> <span class="RangeSepararValor">-</span> <input type="number" onchange="MudarPeriodoI()"  id="range_maior_valor" class="RangeMaiorValor"></input></a>
                </div>
                <div class="Progresso" id="progresso"></div>
                <span class="LinhaDupla">
                    <input type="range" min="0" max="2023" value="1000" id="range_menor" name="range_menor" class="Periodo" onchange="MudarPeriodo()">
                    <input type="range" min="0" max="2023" value="2023" id="range_maior" name="range_maior" class="Periodo" onchange="MudarPeriodo()">
                </span>
            </div>
        </div>
        <div class="Busca2">
            <div class="Atributos">
                <span class="Simbolo">filter_list</span>
                <span id="pesquisa_atributo"></span>
                <span id="categoria_atributo"></span>
                <span id="pais_atributo"></span>
                <span id="periodo_atributo"></span>
            </div>       
            <button type="submit" name="submit" value="" class="Submit"><span class="Simbolo Menor">search</span></button>
        </div>
    </form>

    <div class="Conteudo">
        <div class="Flex">
            <div class="Indice"> <h1>#</h1></div>
            <div class="Titulo"> <h1>Titulo</h1> <span class="Simbolo Menor2">swap_vert</span></div>
            <div class="Autor"> <h1>Autor</h1> <span class="Simbolo Menor2">swap_vert</span></div>
            <div class="Data"> <h1>Data</h1> <span class="Simbolo Menor2">swap_vert</span></div>
            <div class="Opcoes"></div>
        </div>
            <?php while($livro = $sql_query_livro->fetch_assoc()){
                    echo "<div class='Flex Pointer' onclick=\"window.open('" . $livro['arquivo']. "', '_blank')\">";
                    echo "<div class='Indice'> <a>" . $livro['idlivro'] . "</a></div>";
                    echo "<div class='Titulo'><a>" . $livro['titulo'] . "</a></div>";
                    echo "<div class='Autor'><a>" . $livro['autor'] . "</a></div>";
                    echo "<div class='Data'><a>" . $livro['publicadodata'] . "</a></div>";
                    echo "</div>";
                }
            ?>
    </div>

    
    <footer class="Rodape">
        <a onclick="MudarCor()"><span class="Simbolo">dialogs</span></a>
        <a>&copy; 2023 Biblioteca Digital. Todos os direitos reservados.</a>
        <a>.</a>
    </footer>
</body>

</html>