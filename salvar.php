<?php

    include ("conexao.php");

    $sql_code_categoria = "SELECT * FROM tbcategoria ORDER BY categoria ASC";
    $sql_query_categoria = $conexao->query($sql_code_categoria) or die($conexao->error);

    $sql_code_pais = "SELECT * FROM tbpais ORDER BY pais ASC";
    $sql_query_pais = $conexao->query($sql_code_pais) or die($conexao->error);

    $sql_code_autor = "SELECT * FROM tbautor ORDER BY autor ASC";
    $sql_query_autor = $conexao->query($sql_code_autor) or die($conexao->error);

    if(isset($_FILES['file'])){
        var_dump($_FILES['file']);
        $file = $_FILES['file'];
        $pasta = "assets/";
        $titulo = $file['name'];
        $extensao = strtolower(pathinfo($titulo, PATHINFO_EXTENSION));
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $pais = $_POST['pais'];
        $categoria = $_POST['categoria'];


        if($extensao != "pdf"){
            die("Tipo de arquivo incompativel, utilize somente arquivos.pdf");
        };
        if($file['error']){
            die("Falha ao enviar o arquivo");
        };

        $finalizado = move_uploaded_file($file["tmp_name"], $pasta . $titulo);

        if($finalizado){
            $mysqli->query("INSERT INTO tblivros (titulo, idautor, idcategoria, idpais, data, PATH) VALUES($titulo, $autor, $pais, $categoria) OR die($mysqli->error");
            echo "<p> arquivo enviado com sucesso! Para acessa-lo, clique aqui: <a target='_blank' href='assets/$titulo'> Arquivo </a></p>";
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Adcionar</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src='main.js'></script>
</head>
<body>
    <header class="Header">
        <div class="Itens">
            <div class="Logo">
                <img src="./image/logo.png" alt="Logo">
            </div>
            <ul>
                <a href="#" class="current">Home</a>
                <a href="#">Livros</a>
                <a href="#">Sobre</a>
                <a href="#">Favoritos</a>
                <a href="#">Login</a>
            </ul>
            <div class="Pesquisa">
                <span class="Lupa">search</span>
            </div>
        </div>
    </header>

    <form method="post" enctype="multipart/form-data" action="" class="Inserir">
        <h1>Preencha os campos abaixo para adicionar novas obras ao catálogo<br><br></h1>
        <label>Título</label>
        <input type="text" class="InserirSelect" id="titulo" name="titulo">

        <label for="autor">Autor:</label>
        <select class="InserirSelect" id="autor" name="autor">
            <option>Selecione o autor da obra</option>
            <?php while($autor = $sql_query_autor->fetch_assoc()){
                echo "<option value='" . $autor['idautor'] . "'>" . $autor['autor'] . "</option>";
            }
            ?>
        </select>

        <label for="pais">Nacionalidade:</label>
        <select class="InserirSelect" id="pais" name="pais">
            <option> Escolha a nacionalidade da obra</option>
            <?php while($pais = $sql_query_pais->fetch_assoc()){
                echo "<option value='" . $pais['idpais'] . "'>" . $pais['pais'] . "</option>";
            }
            ?>
        </select>

        <label for="categoria">Categoria:</label>
        <select class="InserirSelect" id="categoria" name="categoria">
            <option>Escolha o tipo da obra</option>
            <?php while($categoria = $sql_query_categoria->fetch_assoc()){
                echo "<option value='" . $categoria['idcategoria'] . "'>" . $categoria['categoria'] . "</option>";
            }
            ?>
        </select>

        <label for="">Selecione o arquivo</label>
            <input class="File" type="file" name="file">
            <button type="submit" name="submit">Enviar</button>
    </form>

    <footer class="Rodape">
        <a onclick="MudarCor()"><span class="Cor"> dialogs </span></a>
        <a>&copy; 2023 Biblioteca Digital. Todos os direitos reservados.</a>
        <a>.</a>
    </footer>
</body>
</html>