<?php
    session_start();
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
        $titulo = ucwords(mb_strtolower($_POST['titulo']));
        $data = $_POST['data'];
        $autor = $_POST['autor'];
        $pais = $_POST['pais'];
        $categoria = $_POST['categoria'];
        $usuario = $_SESSION['usuario'][0];

        if($file['error']){
            die("Falha ao enviar o arquivo");
        };

        $consulta = $conexao->query("SELECT * FROM tblivro WHERE titulo = '$titulo' AND idAutor = $autor");
        $linha = $consulta->num_rows;

        if($linha >= 1){
            echo  "<script>alert('Um livro com um mesmo Título e Autor já existe cadastrado no sistema!');</script>";
        }else{
            $finalizado = move_uploaded_file($file["tmp_name"], $pasta . $titulo .'.pdf');
            if($finalizado){
            $conexao->query("INSERT INTO tblivro (titulo, data, idAutor, idPais, idCategoria, usuario) VALUES('$titulo', $data, $autor, $pais, $categoria, '$usuario');");
            echo  "<script>alert('Livro cadastrado com sucesso!');</script>";
            }
        }

    }

    if(isset($_POST['novo_submit_autor'])){
        $novo_autor = ucwords(mb_strtolower($_POST['novo_autor']));
        $novo_pais = $_POST['novo_pais'];

        $consulta2 = $conexao->query("SELECT * FROM tbautor WHERE autor = '$novo_autor'");
        $linha2 = $consulta2->num_rows;

        if($linha2 >= 1){
            echo  "<script>alert('Um Autor com o mesmo nome já existe cadastrado no sistema!');</script>";
        }else{
            $conexao->query("INSERT INTO tbautor (autor, idPais) VALUES('$novo_autor', $novo_pais)");
            echo  "<script>alert('Autor cadastrado com sucesso!');</script>";
            header("Refresh: 0");
        }
    }

    if(isset($_POST['novo_submit_pais'])){
        $novo_pais2 = ucwords(mb_strtolower($_POST['novo_pais2']));

        $consulta3 = $conexao->query("SELECT * FROM tbpais WHERE pais = '$novo_pais2'");
        $linha3 = $consulta3->num_rows;

        if($linha3 >= 1){
            echo  "<script>alert('Um Pais com o mesmo nome já existe cadastrado no sistema!');</script>";
        }else{
            $conexao->query("INSERT INTO tbpais (pais) VALUES('$novo_pais2')");
            echo  "<script>alert('Pais cadastrado com sucesso!');</script>";
            header("Refresh: 0");
        }
    }
?>

<?php include("header.php");?> 
        
<?php
        if(!isset($_SESSION['usuario'])){
            echo "<body onclick=\"window.location.href='./login.php'\"> <div class='Cortina'></div>";
            echo  '<div class="Erro"><span class="Simbolo Maior">cancel</span> <span>Você precisa estar logado para acessar está página</span> <span class="Simbolo Maior">cancel</span></div>';
            $user = 1;
        }
        else{
            echo "<body>";
        }
?>
    <div class="Conteudo">
        <form method="post" enctype="multipart/form-data" action="inserir.php" id="inserir">
            <h1>Preencha os campos abaixo para adicionar novas obras ao catálogo<br><br></h1>
            <div class="NomeData">
                <div class="Preencher">
                    <p><label class="Label">Título:</label></p>
                    <input type="text" id="titulo" name="titulo" required class="InserirInput" autocomplete="off">
                </div>
                <div class="Preencher">
                    <p><label class="Label" for="data">Ano de Publicação:</label></p>
                    <input type="number" name="data" id="data" class="InserirInput">
                </div>
            </div>

            <label class="Label" for="autor">Autor:</label>
            <div class="Flex">
                <select class="InserirSelect" id="autor" name="autor" required>
                    <option>Selecione o autor da obra</option>
                    <?php while($autor = $sql_query_autor->fetch_assoc()){
                        echo "<option value='" . $autor['idAutor'] . "'>" . $autor['autor'] . "</option>";
                    }
                    ?>
                </select>
                <button class="NovoInserir" onclick="AddAutor()">+</button>
            </div>

            <label class="Label" for="pais">Nacionalidade:</label>
            <div class="Flex">
                <select class="InserirSelect" id="pais" name="pais" required>
                    <option> Escolha a nacionalidade da obra</option>
                    <?php while($pais = $sql_query_pais->fetch_assoc()){
                        echo "<option value='" . $pais['idPais'] . "'>" . $pais['pais'] . "</option>";
                    }
                    ?>
                </select>
                <button class="NovoInserir" onclick="AddPais()">+</button>
            </div>

            <label class="Label" for="categoria">Categoria:</label>
            <select class="InserirSelect Preencher" id="categoria" name="categoria" required>
                <option>Escolha o tipo da obra</option>
                <?php while($categoria = $sql_query_categoria->fetch_assoc()){
                    echo "<option value='" . $categoria['idCategoria'] . "'>" . $categoria['categoria'] . "</option>";
                }
                ?>
            </select>

            <label for="file" class="Label">Selecione o arquivo:</label>
            <label for="file" class="File">Selecione o arquivo</label>
            <input class="Invisivel" type="file" name="file" id="file" required accept="application/pdf" >

            <?php if($user != 1){ 
                echo "<button class='BotaoInserir' type='submit' name='submit'>Enviar</button>";
            } ?>
        </form>
    </div>
    
    <form class="AddAutor" id="add_autor" method="post" action="inserir.php">
        <a Class="AddAutorTitulo"><h1>Adicionar um novo Autor</h1> <span class="Simbolo" onclick="FecharAutor()">close</span></a>
        <div class="Preencher">
            <p><label class="Label" for="novo_autor">Nome do Autor:</label></p>
            <input type="text" id="novo_autor" name="novo_autor" required class="InserirInput Preencher">
        </div>

        <label class="Label" for="pais">Nacionalidade:</label>
        <div class="Flex">
            <select class="InserirSelect" id="novo_pais" name="novo_pais" required>
                <option> Escolha a nacionalidade do autor</option>
                <?php while($pais_2 = $sql_query_pais_2->fetch_assoc()){
                    echo "<option value='" . $pais_2['idPais'] . "'>" . $pais_2['pais'] . "</option>";
                }
                ?>
            </select>
            <button class="NovoInserir" onclick="AddPais()">+</button>
        </div>
        <button class="BotaoInserir" type="submit" name="novo_submit_autor">Enviar</button>
    </form>

    <form class="AddPais" id="add_pais" method="post" action="inserir.php">
        <a Class="AddAutorTitulo"><h1>Adicionar um novo Pais</h1> <span class="Simbolo" onclick="FecharPais()">close</span></a>
        <div class="Preencher">
            <p><label class="Label" for="novo_pais2r">Nome do Pais:</label></p>
            <input type="text" id="novo_pais" name="novo_pais2" required class="InserirInput Preencher">
        </div>
        <button class="BotaoInserir" type="submit" name="novo_submit_pais">Enviar</button>
    </form>

<?php include("footer.php"); ?>

</body>
</html>