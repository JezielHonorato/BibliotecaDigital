<?php
    $host = "Localhost";
    $user = "root";
    $senha = "";
    $bancodedados = "bibliotecadigital";

    $conexao = new mysqli($host, $user, $senha, $bancodedados);

    /*
    if($conexao->connect_errno){
        echo  "<script>alert('Falha na conexão! $conexao ->connect_errno $conexao->connect_error');</script>";
    } else{
        echo  "<script>alert('Conexão realizada com sucesso');</script>";
    }
    */

?>