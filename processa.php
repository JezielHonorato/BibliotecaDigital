<?php
include ("conexao.php");
session_start();


if (isset($_GET["pesquisar"])) {
    $pesquisa = ucwords(mb_strtolower($_GET['pesquisar']));

    if (isset($_GET["ordem"])) {
        $ordem = $_GET['ordem'];

        if($ordem == 2){
            $orde = "l.titulo DESC";
        }else if($ordem == 3){
            $orde = "a.autor ASC";
        }else if($ordem == 4){
            $orde = "a.autor DESC";
        }else if($ordem == 5){
            $orde = "l.publicadodata ASC";
        }else if($ordem == 6){
            $orde = "l.publicadodata DESC";
        }else{
            $orde = "l.titulo ASC";
        }
    }
    if(!empty($_GET['categoria'])){
        $categoriav = $_GET['categoria'];
    } 
    if(!empty($_GET['nacionalidade'])){
        $nacionalidadev = $_GET['nacionalidade'];
    }
    if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
        $range_menor = $_GET['range_menor'];
        $range_maior = $_GET['range_maior'];
    } 


    if(!empty($_GET['pesquisar'])){

        if(!empty($_GET['categoria'])){

            if(!empty($_GET['nacionalidade'])){

                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.idcategoria = $categoriav AND l.idpais = $nacionalidadev AND l.publicadodata BETWEEN $range_menor AND $range_maior OR a.autor LIKE '%$pesquisa%' AND l.idcategoria = $categoriav AND l.idpais = $nacionalidadev AND l.publicadodata BETWEEN $range_menor AND $range_maior ORDER BY $orde";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.idcategoria = $categoriav AND l.idpais = $nacionalidadev OR a.autor LIKE '%$pesquisa%' AND l.idcategoria = $categoriav AND l.idpais = $nacionalidadev ORDER BY $orde";
                }
            }
            else{
                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.idcategoria = $categoriav AND l.publicadodata BETWEEN $range_menor AND $range_maior OR a.autor LIKE '%$pesquisa%' AND l.idcategoria = $categoriav AND l.publicadodata BETWEEN $range_menor AND $range_maior ORDER BY $orde";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.idcategoria = $categoriav OR a.autor LIKE '%$pesquisa%' AND l.idcategoria = $categoriav ORDER BY $orde";
                }
            }
        }
        else{
            if(!empty($_GET['nacionalidade'])){

                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.idpais = $nacionalidadev AND l.publicadodata BETWEEN $range_menor AND $range_maior OR a.autor LIKE '%$pesquisa%' AND l.idpais = $nacionalidadev AND l.publicadodata BETWEEN $range_menor AND $range_maior ORDER BY $orde";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.idpais = $nacionalidadev OR a.autor LIKE '%$pesquisa%' AND l.idpais = $nacionalidadev ORDER BY $orde";
                }
            }
            else{
                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' AND l.publicadodata BETWEEN $range_menor AND $range_maior OR a.autor LIKE '%$pesquisa%' AND l.publicadodata BETWEEN $range_menor AND $range_maior ORDER BY $orde";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.titulo LIKE '%$pesquisa%' OR a.autor LIKE '%$pesquisa%' ORDER BY $orde";
                }
            }
        }
    }
    else{
        if(!empty($_GET['categoria'])){

            if(!empty($_GET['nacionalidade'])){

                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.idcategoria = $categoriav AND l.idpais = $nacionalidadev AND l.publicadodata BETWEEN $range_menor AND $range_maior ORDER BY $orde";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.idcategoria = $categoriav AND l.idpais = $nacionalidadev ORDER BY $orde";
                }
            }
            else{
                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.idcategoria = $categoriav AND l.publicadodata BETWEEN $range_menor AND $range_maior ORDER BY $orde";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.idcategoria = $categoriav ORDER BY $orde";
                }
            }
        }
        else{
            if(!empty($_GET['nacionalidade'])){

                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.idpais = $nacionalidadev AND l.publicadodata BETWEEN $range_menor AND $range_maior ORDER BY $orde";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.idpais = $nacionalidadev ORDER BY $orde";
                }
            }
            else{
                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor WHERE l.publicadodata BETWEEN $range_menor AND $range_maior ORDER BY $orde";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor ORDER BY $orde";
                }
            }
        }
    }
    $sql_query_livro = $conexao->query($sql_code_livro) or die($conexao->error);    

    while ($livro = $sql_query_livro->fetch_assoc()) {
        $return = "<div class='Livro'>";
        $return.= "<a class='Indice' href='" . mb_convert_encoding($livro["arquivo"], "UTF-8") . "' download='" . mb_convert_encoding($livro["titulo"], "UTF-8") . "'><span class='Simbolo'>download</span></a>";

        $return.= "<div class='Titulo' onclick=\"window.open('" . mb_convert_encoding($livro['arquivo'], "UTF-8") . "', '_blank')\"><a>" . mb_convert_encoding($livro["titulo"], "UTF-8") . "</a></div>";

        $return.= "<div class='Autor' onclick=\"window.open('" . mb_convert_encoding($livro['arquivo'], "UTF-8") . "', '_blank')\"><a>" . mb_convert_encoding($livro["autor"], "UTF-8") . "</a></div>";

        $return.= "<div class='Data' onclick=\"window.open('" . mb_convert_encoding($livro['arquivo'], "UTF-8") . "', '_blank')\"><a>" . mb_convert_encoding($livro["publicadodata"], "UTF-8") . "</a></div>";

        if(isset($_SESSION['usuario'])){
            $return.= "<div class='Editar'><a href='editar.php?id=" . mb_convert_encoding($livro["idlivro"], "UTF-8") . "'> <span class='Simbolo'>edit</span></a></div>";
        }

        echo $return .="</div>";
    }
}
?>