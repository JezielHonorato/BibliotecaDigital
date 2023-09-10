<?php
    session_start();
    include ("conexao.php");

    $sql_code_categoria = "SELECT * FROM tbcategoria ORDER BY categoria ASC";
    $sql_query_categoria = $conexao->query($sql_code_categoria) or die($conexao->error);

    $sql_code_pais = "SELECT * FROM tbpais ORDER BY pais ASC";
    $sql_query_pais = $conexao->query($sql_code_pais) or die($conexao->error);

    $sql_code_livro = "SELECT l.idlivro, l.titulo, a.autor, l.idautor, l.publicadodata, l.arquivo FROM tblivro AS l INNER JOIN tbautor AS a ON a.idautor = l.idautor";
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
    <script src='main.js' defer></script>
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

    <div class="Conteudo Transparente">
        <div class="Introducao">
            <div class="Imagem">
                <img src="./image/logoM.png" alt="Logo">
            </div>
            <div class="Texto">
                <h1>Bem-Vindo à Biblioteca Digital: Acesse Livros em Domínio Público de Forma simples e legal!</h1>
                <br>
                <a>Seja muito bem-vindo ao à bibliteca digital, um espaço dedicado à leitura, aqui você pode ler e baixar diversos livros em Domínio Público de forma legal. Este site foi criado com muita dedicação, ele representa um portal para o conhecimento e o prazer da leitura, sem infringir direitos autorais, espero que aproveitem.</a>
            </div>
        </div>
    </div>
    <footer class="Rodape">
        <a onclick="MudarCor()"><span class="Simbolo"> dialogs </span></a>
        <a>&copy; 2023 Biblioteca Digital. Todos os direitos reservados.</a>
        <a>.</a>
    </footer>
</body>
</html>