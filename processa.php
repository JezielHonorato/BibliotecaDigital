<?php
session_start();
require_once ('objeto.php');

foreach ($conn->pesquisarLivros($parametros = $_GET) as $livro) {
  $html  ="<tr>";
  $html .="<td><a href='assets/{$livro['idLivro']}.pdf' download='{$livro['titulo']}'><i> download</i></a></td>";
  $html .="<td onclick=\"window.open('assets/{$livro['idLivro']}.pdf', '_blank')\">{$livro['titulo']}</a></td>";
  $html .="<td onclick=\"window.open('assets/{$livro['idLivro']}.pdf', '_blank')\">{$livro['autor']}</a></td>";
  $html .="<td onclick=\"window.open('assets/{$livro['idLivro']}.pdf', '_blank')\">{$livro['data']}</a></td>";
  if(isset($_SESSION['usuario'])){
    $html .= "<td><a href='cadastrar.php?id={$livro['idLivro']}'><i>edit</i></a></td>";
  };
  $html .= "</tr>";
  echo $html;
}
?>