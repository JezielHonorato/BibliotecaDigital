<?php
    $host = "Localhost";
    $user = "root";
    $senha = "";
    $bancodedados = "bibliotecadigital";

    $conexao = new mysqli($host,$user,$senha,$bancodedados);

    /*
    if($conexao ->connect_errno){
        echo "<div class=\"Rede\">". "ERRO". "</div>";
    } else{
        echo "<div class=\"Rede\">". "Conexão realizada com sucesso". "</div>";
    }
    */

?>
