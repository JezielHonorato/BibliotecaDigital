<?php
    // $texto = mb_strtolower($texto1);
    //echo ucwords($texto);
    include ("conexao.php");

    $sql_code_categoria = "SELECT * FROM tbcategoria ORDER BY categoria ASC";
    $sql_query_categoria = $conexao->query($sql_code_categoria) or die($conexao->error);

    $sql_code_pais = "SELECT * FROM tbpais ORDER BY pais ASC";
    $sql_query_pais = $conexao->query($sql_code_pais) or die($conexao->error);
    $sql_query_pais_2 = $conexao->query($sql_code_pais) or die($conexao->error);

    $sql_code_autor = "SELECT * FROM tbautor ORDER BY autor ASC";
    $sql_query_autor = $conexao->query($sql_code_autor) or die($conexao->error);

    if(isset($_FILES['file'])){
        $file = $_FILES['file'];
        $pasta = "assets/";
        $titulo = $_POST['titulo'];
        $data = $_POST['data'];
        $autor = $_POST['autor'];
        $pais = $_POST['pais'];
        $categoria = $_POST['categoria'];

        if($file['error']){
            die("Falha ao enviar o arquivo");
        };

        $consulta = $conexao->query("SELECT * FROM tblivro WHERE titulo = '$titulo' AND idautor = $autor");
        $linha = $consulta->num_rows;

        if($linha >= 1){
            echo  "<script>alert('Um livro com um mesmo Título e Autor já existe cadastrado no sistema!');</script>";
        }else{
            $finalizado = move_uploaded_file($file["tmp_name"], $pasta . $titulo .'.pdf');
            if($finalizado){
            $conexao->query("INSERT INTO tblivro (titulo, publicadodata, idautor, idpais, idcategoria, arquivo) VALUES('$titulo', $data, $autor, $pais, $categoria, './assets/$titulo.png')");
            echo  "<script>alert('Livro cadastrado com sucesso!');</script>";
            }
        }

    }

    if(isset($_POST['novo_submit_autor'])){
        $novo_autor = $_POST['novo_autor'];
        $novo_pais = $_POST['novo_pais'];

        $consulta2 = $conexao->query("SELECT * FROM tbautor WHERE autor = '$novo_autor'");
        $linha2 = $consulta2->num_rows;

        if($linha2 >= 1){
            echo  "<script>alert('Um Autor com o mesmo nome já existe cadastrado no sistema!');</script>";
        }else{
            $conexao->query("INSERT INTO tbautor (autor, idpais) VALUES('$novo_autor', $novo_pais)");
            echo  "<script>alert('Autor cadastrado com sucesso!');</script>";
        }
    }

    if(isset($_POST['novo_submit_pais'])){
        $novo_pais2 = $_POST['novo_pais2'];

        $consulta3 = $conexao->query("SELECT * FROM tbpais WHERE pais = '$novo_pais2'");
        $linha3 = $consulta3->num_rows;

        if($linha3 >= 1){
            echo  "<script>alert('Um Pais com o mesmo nome já existe cadastrado no sistema!');</script>";
        }else{
            $conexao->query("INSERT INTO tbpais (pais) VALUES('$novo_pais2')");
            echo  "<script>alert('Pais cadastrado com sucesso!');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Adcionar</title>
    <link rel="shortcut icon" href="./image/logo.ico" />
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
                <a href="./Index.php" class="current">Home</a>
                <a href="#">Livros</a>
                <a href="#">Sobre</a>
                <a href="./Inserir.php">Inserir</a>
                <a href="#">Login</a>
            </ul>
            <div class="Pesquisa">
                <span class="Lupa">search</span>
            </div>
        </div>
    </header>

    <form method="post" enctype="multipart/form-data" action="Inserir.php" class="Inserir" id="inserir">
        <h1>Preencha os campos abaixo para adicionar novas obras ao catálogo<br><br></h1>
        <div class="TituloData">
            <div class="AdTitulo">
                <p><label class="Label">Título:</label></p>
                <input type="text" id="titulo" name="titulo" required class="InserirInput">
            </div>
            <div class="AdTitulo">
                <p><label class="Label" for="data">Ano de Publicação:</label></p>
                <input type="number" name="data" id="data" class="InserirInput">
            </div>
        </div>

        <label class="Label" for="autor">Autor:</label>
        <div class="CampoInserir">
            <select class="InserirSelect" id="autor" name="autor" required>
                <option>Selecione o autor da obra</option>
                <?php while($autor = $sql_query_autor->fetch_assoc()){
                    echo "<option value='" . $autor['idautor'] . "'>" . $autor['autor'] . "</option>";
                }
                ?>
            </select>
            <button class="NovoInserir" onclick="AddAutor()">+</button>
        </div>

        <label class="Label" for="pais">Nacionalidade:</label>
        <div class="CampoInserir">
            <select class="InserirSelect" id="pais" name="pais" required>
                <option> Escolha a nacionalidade da obra</option>
                <?php while($pais = $sql_query_pais->fetch_assoc()){
                    echo "<option value='" . $pais['idpais'] . "'>" . $pais['pais'] . "</option>";
                }
                ?>
            </select>
        <button class="NovoInserir" onclick="AddPais()">+</button>
        </div>

        <label class="Label" for="categoria">Categoria:</label>
        <select class="InserirSelect Preencher" id="categoria" name="categoria" required>
            <option>Escolha o tipo da obra</option>
            <?php while($categoria = $sql_query_categoria->fetch_assoc()){
                echo "<option value='" . $categoria['idcategoria'] . "'>" . $categoria['categoria'] . "</option>";
            }
            ?>
        </select>

        <label for="file" class="Label">Selecione o arquivo:</label>
        <label for="file" class="File">Selecione o arquivo</label>
        <input class="Invisivel" type="file" name="file" id="file" required accept="application/pdf" >
        
        <button class="BotaoInserir" type="submit" name="submit">Enviar</button>
    </form>

    <form class="AddAutor" id="add_autor" method="post" action="Inserir.php">
        <a Class="AddAutorTitulo"><h1>Adicionar um novo Autor</h1> <span Class="Fechar" onclick="FecharAutor()">close</span></a>
        <div class="AdTitulo">
            <p><label class="Label" for="novo_autor">Nome do Autor:</label></p>
            <input type="text" id="novo_autor" name="novo_autor" required class="InserirInput Preencher">
        </div>

        <label class="Label" for="pais">Nacionalidade:</label>
        <div class="CampoInserir">
            <select class="InserirSelect" id="novo_pais" name="novo_pais" required>
                <option> Escolha a nacionalidade do autor</option>
                <?php while($pais_2 = $sql_query_pais_2->fetch_assoc()){
                    echo "<option value='" . $pais_2['idpais'] . "'>" . $pais_2['pais'] . "</option>";
                }
                ?>
            </select>
            <button class="NovoInserir" onclick="AddPais()">+</button>
        </div>
        <button class="BotaoInserir" type="submit" name="novo_submit_autor">Enviar</button>
    </form>

    <form class="AddPais" id="add_pais" method="post" action="Inserir.php">
        <a Class="AddAutorTitulo"><h1>Adicionar um novo Pais</h1> <span Class="Fechar" onclick="FecharPais()">close</span></a>
        <div class="AdTitulo">
            <p><label class="Label" for="novo_pais2r">Nome do Pais:</label></p>
            <input type="text" id="novo_pais" name="novo_pais2" required class="InserirInput Preencher">
        </div>
        <button class="BotaoInserir" type="submit" name="novo_submit_pais">Enviar</button>
    </form>

    <footer class="Rodape">
        <a onclick="MudarCor()"><span class="Cor"> dialogs </span></a>
        <a>&copy; 2023 Biblioteca Digital. Todos os direitos reservados.</a>
        <a>.</a>
    </footer>
</body>
</html>