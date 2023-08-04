<?php
    $host = "Localhost";
    $user = "root";
    $senha = "";
    $bancodedados = "bibliotecadigital";

    $conexao = new mysqli($host, $user, $senha, $bancodedados);

    /*
    if($conexao ->connect_errno){
        echo "Falha na conexão! (" . $conexao ->connect_errno . ") " . $conexao ->connect_error;
    } else{
        echo "<div class=\"Rede\">". "Conexão realizada com sucesso". "</div>";
    }
    */

?>