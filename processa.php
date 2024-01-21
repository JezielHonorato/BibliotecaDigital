<?php
include ("conexao.php");
session_start();


if (isset($_GET["pesquisar"])) {
    $pesquisa = ucwords(mb_strtolower($_GET['pesquisar']));
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
    $ordem = $_GET['ordem'];


    if(!empty($_GET['pesquisar'])){

        if(!empty($_GET['categoria'])){

            if(!empty($_GET['nacionalidade'])){

                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.titulo LIKE '%$pesquisa%' AND l.idCategoria = $categoriav AND l.idPais = $nacionalidadev AND l.data BETWEEN $range_menor AND $range_maior OR a.autor LIKE '%$pesquisa%' AND l.idCategoria = $categoriav AND l.idPais = $nacionalidadev AND l.data BETWEEN $range_menor AND $range_maior $ordem";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.titulo LIKE '%$pesquisa%' AND l.idCategoria = $categoriav AND l.idPais = $nacionalidadev OR a.autor LIKE '%$pesquisa%' AND l.idCategoria = $categoriav AND l.idPais = $nacionalidadev $ordem";
                }
            }
            else{
                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.titulo LIKE '%$pesquisa%' AND l.idCategoria = $categoriav AND l.data BETWEEN $range_menor AND $range_maior OR a.autor LIKE '%$pesquisa%' AND l.idCategoria = $categoriav AND l.data BETWEEN $range_menor AND $range_maior $ordem";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.titulo LIKE '%$pesquisa%' AND l.idCategoria = $categoriav OR a.autor LIKE '%$pesquisa%' AND l.idCategoria = $categoriav $ordem";
                }
            }
        }
        else{
            if(!empty($_GET['nacionalidade'])){

                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.titulo LIKE '%$pesquisa%' AND l.idPais = $nacionalidadev AND l.data BETWEEN $range_menor AND $range_maior OR a.autor LIKE '%$pesquisa%' AND l.idPais = $nacionalidadev AND l.data BETWEEN $range_menor AND $range_maior $ordem";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.titulo LIKE '%$pesquisa%' AND l.idPais = $nacionalidadev OR a.autor LIKE '%$pesquisa%' AND l.idPais = $nacionalidadev $ordem";
                }
            }
            else{
                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.titulo LIKE '%$pesquisa%' AND l.data BETWEEN $range_menor AND $range_maior OR a.autor LIKE '%$pesquisa%' AND l.data BETWEEN $range_menor AND $range_maior $ordem";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.titulo LIKE '%$pesquisa%' OR a.autor LIKE '%$pesquisa%' $ordem";
                }
            }
        }
    }
    else{
        if(!empty($_GET['categoria'])){

            if(!empty($_GET['nacionalidade'])){

                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.idCategoria = $categoriav AND l.idPais = $nacionalidadev AND l.data BETWEEN $range_menor AND $range_maior $ordem";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.idCategoria = $categoriav AND l.idPais = $nacionalidadev $ordem";
                }
            }
            else{
                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.idCategoria = $categoriav AND l.data BETWEEN $range_menor AND $range_maior $ordem";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.idCategoria = $categoriav $ordem";
                }
            }
        }
        else{
            if(!empty($_GET['nacionalidade'])){

                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.idPais = $nacionalidadev AND l.data BETWEEN $range_menor AND $range_maior $ordem";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.idPais = $nacionalidadev $ordem";
                }
            }
            else{
                if(!empty($_GET['range_menor']) || !empty($_GET['range_maior'])){
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor WHERE l.data BETWEEN $range_menor AND $range_maior $ordem";
                }
                else{
                    $sql_code_livro = "SELECT * FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor $ordem";
                }
            }
        }
    }
    $sql_query_livro = $conexao->query($sql_code_livro) or die($conexao->error);    

    while ($livro = $sql_query_livro->fetch_assoc()) {
        $return = "<div class='Livro'>";
        $return.= "<a class='Indice' href='assets/". $livro['titulo'] .".pdf' download='" . $livro['titulo'] . "'><span class='Simbolo'>download</span></a>";

        $return.= "<div class='Titulo' onclick=\"window.open('assets/". $livro['titulo'] .".pdf', '_blank')\"><a>". $livro['titulo'] ."</a></div>";

        $return.= "<div class='Autor' onclick=\"window.open('assets/". $livro['titulo'] .".pdf', '_blank')\"><a>" . $livro['autor'] . "</a></div>";

        $return.= "<div class='Data' onclick=\"window.open('assets/". $livro['titulo'] .".pdf', '_blank')\"><a>" . $livro['data'] . "</a></div>";

        if(isset($_SESSION['usuario'])){
            $return.= "<div class='Editar'><a href='editar.php?id=". $livro["idlivro"] ."'> <span class='Simbolo'>edit</span></a></div>";
        }

        echo $return .="</div>";
    }
}
?>