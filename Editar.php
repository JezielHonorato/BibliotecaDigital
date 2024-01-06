    <?php
    session_start();
    include ("conexao.php");

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
        $sql_code_editar = "SELECT * FROM tblivro WHERE idLivro = $id";
        $sql_query_editar = $conexao->query($sql_code_editar) or die($conexao->error);
        $editar = $sql_query_editar->fetch_assoc();   

        $sql_code_categoria = "SELECT * FROM tbcategoria ORDER BY categoria ASC";
        $sql_query_categoria = $conexao->query($sql_code_categoria) or die($conexao->error);

        $editar_categoria = $editar['idCategoria'];
        $sql_code_categoria1 = "SELECT * FROM tbcategoria WHERE idCategoria LIKE $editar_categoria";
        $sql_query_categoria1 = $conexao->query($sql_code_categoria1) or die($conexao->error);

        $sql_code_pais = "SELECT * FROM tbpais ORDER BY pais ASC";
        $sql_query_pais = $conexao->query($sql_code_pais) or die($conexao->error);
        $sql_query_pais_2 = $conexao->query($sql_code_pais) or die($conexao->error);

        $editar_pais = $editar['idPais'];
        $sql_code_pais1 = "SELECT * FROM tbpais WHERE idPais LIKE $editar_pais";
        $sql_query_pais1 = $conexao->query($sql_code_pais1) or die($conexao->error);

        $sql_code_autor = "SELECT * FROM tbautor ORDER BY autor ASC";
        $sql_query_autor = $conexao->query($sql_code_autor) or die($conexao->error);

        $editar_autor = $editar['idAutor'];
        $sql_code_autor1 = "SELECT * FROM tbautor WHERE idAutor LIKE $editar_autor";
        $sql_query_autor1 = $conexao->query($sql_code_autor1) or die($conexao->error);
        
        if(isset($_POST['titulo'])){
            $titulo = ucwords(mb_strtolower($_POST['titulo']));
            $data = $_POST['data'];
            $autor = $_POST['autor'];
            $pais = $_POST['pais'];
            $categoria = $_POST['categoria'];

            $conexao->query("UPDATE tblivro SET titulo = '$titulo', data = $data, idAutor = $autor, idPais = $pais, idCategoria = $categoria WHERE idLivro = $id");
            echo  "<script>alert('Livro Editado com sucesso!');</script>";
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
        $excluir = "EXCLUIR $editar[titulo]";
        
        if(isset($_POST['excluir']) && $_POST['excluir'] == $excluir){
            $conexao->query("DELETE FROM tblivro WHERE idLivro = $id");
            $file = "assets/$titulo.php";
            unlink($file);
            echo "<script>alert('Livro Excluido com sucesso com sucesso!');</script>";
            header('Location: livros.php');
        }
    }
?>

<?php include("header.php"); ?>
        
<?php
        if(!isset($_SESSION['usuario'])){
            echo "<body onclick=\"window.location.href='./  php'\"> <div class='Cortina'></div>";
            echo  '<div class="Erro"><span class="Simbolo Maior">cancel</span> <span>Você precisa estar logado para acessar está página</span> <span class="Simbolo Maior">cancel</span></div>';
        }
        else{
            echo "<body>";
        }
?>

<div class="Conteudo">
    <form method="post" enctype="" action="" id="inserir">
        <h1>Preencha os campos abaixo para adicionar novas obras ao catálogo<br><br></h1>
        <div class="NomeData">
            <div class="Preencher">
                <p><label class="Label">Título:</label></p>
                <input type="text" id="titulo" name="titulo" required class="InserirInput" <?php echo "value='$editar[titulo]'" ?>>
            </div>
            <div class="Preencher">
                <p><label class="Label" for="data">Ano de Publicação:</label></p>
                <input type="number" name="data" id="data" class="InserirInput" <?php echo "value='$editar[publicadodata]'" ?>>
            </div>
        </div>

        <label class="Label" for="autor">Autor:</label>
        <div class="Flex">
            <select class="InserirSelect" id="autor" name="autor" required>
                <?php
                    while($autor1 = $sql_query_autor1->fetch_assoc()){
                        echo "<option value='" . $autor1['idAutor'] . "'>" . $autor1['autor'] . "</option>";
                    }
                ?><?php
                    while($autor = $sql_query_autor->fetch_assoc()){
                        echo "<option value='" . $autor['idAutor'] . "'>" . $autor['autor'] . "</option>";
                    }
                ?>
            </select>
            <button class="NovoInserir" onclick="AddAutor()">+</button>
        </div>

        <label class="Label" for="pais">Nacionalidade:</label>
        <div class="Flex">
            <select class="InserirSelect" id="pais" name="pais" required>
                <?php
                    while($pais1 = $sql_query_pais1->fetch_assoc()){
                        echo "<option value='" . $pais1['idPais'] . "'>" . $pais1['pais'] . "</option>";
                    }
                ?><?php
                    while($pais = $sql_query_pais->fetch_assoc()){
                        echo "<option value='" . $pais['idPais'] . "'>" . $pais['pais'] . "</option>";
                    }
                ?>
            </select>
        <button class="NovoInserir" onclick="AddPais()">+</button>
        </div>

        <label class="Label" for="categoria">Categoria:</label>
        <select class="InserirSelect Preencher" id="categoria" name="categoria" required>
            <?php
                while($categoria1 = $sql_query_categoria1->fetch_assoc()){
                    echo "<option value='" . $categoria1['idCategoria'] . "'>" . $categoria1['categoria'] . "</option>";
                }
            ?><?php
                while($categoria = $sql_query_categoria->fetch_assoc()){
                    echo "<option value='" . $categoria['idCategoria'] . "'>" . $categoria['categoria'] . "</option>";
                }
            ?>
        </select>

        <button class="BotaoInserir" type="submit" name="submit">Enviar</button>
    </form>

    <form action="" method="post" class="Excluir">
        <?php echo "<input type='text' autocomplete='off' placeholder='Digite \"$excluir\" para confirmar a exclusão desta obra' name='excluir' class='ExcluirInput'>" ?>
        <button class="BotaoExcluir" type="submit">Excluir</button>
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

</body>
</html>