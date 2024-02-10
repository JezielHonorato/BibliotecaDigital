<?php
  include("conexao.php");
  session_start();

  $pesquisa    = isset($_GET["pesquisar"]) ? $_GET['pesquisar'] : '';
  $categoria   = isset($_GET['categoria']) ? $_GET['categoria'] : '';
  $pais        = isset($_GET['pais']) ? $_GET['pais'] : '';
  $range_menor = $_GET['range_menor'];
  $range_maior = $_GET['range_maior'];
  $ordem       = $_GET['ordem'];

  $condicoes = [];
  $pesquisa  ? $condicoes[] = "(titulo LIKE '%$pesquisa%' OR autor LIKE '%$pesquisa%')" : '';
  $categoria ? $condicoes[] = "idCategoria = $categoria" : '';
  $pais      ? $condicoes[] = "idPais = $pais" : '';
  $condicoes[] = "data BETWEEN $range_menor AND $range_maior";

  $sql_code_livro = "SELECT idLivro, titulo, autor, data FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor";
  $sql_code_livro .= " WHERE " . implode(" AND ", $condicoes);
  $sql_code_livro .= " $ordem";
  $sql_query_livro = $conexao->query($sql_code_livro) or die($conexao->error);

  while ($livro = $sql_query_livro->fetch_assoc()) {
    $titulo = $livro['titulo'];
    $html  ="<tr>";
    $html .="<td><a href='assets/$titulo.pdf' download='$titulo'><i> download</i></a></td>";
    $html .="<td onclick=\"window.open('assets/$titulo.pdf', '_blank')\">$titulo</a></td>";
    $html .="<td onclick=\"window.open('assets/$titulo.pdf', '_blank')\">{$livro['autor']}</a></td>";
    $html .="<td onclick=\"window.open('assets/$titulo.pdf', '_blank')\">{$livro['data']}</a></td>";;
    if(isset($_SESSION['usuario'])){
      $html .= "<td><a href='cadastrar.php?id={$livro['idLivro']}'><i>edit</i></a></td>";
    };
    $html .= "</tr>";
    echo $html;
  }
?>