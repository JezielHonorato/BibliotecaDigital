<?php

$host = "Localhost";
$user = "root";
$senha = "";
$bancodedados = "bibliotecadigital";

$conexao = new mysqli($host,$user,$senha,$bancodedados);
/*
if($conexao->connect_errno){
    echo "ERRO";
}
else{
    echo "Conexão efetuada com sucesso";
}
*/