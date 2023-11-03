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

<?php include("header.php"); ?>

    <div class="Conteudo">

        <div class="Introducao">
            <img src="./image/logoM.png" alt="Logo">
            <div class="Texto">
                <h1>Bem-Vindo à Biblioteca Digital: Acesse Livros em Domínio Público de Forma simples e legal!</h1>
                <br>
                <p>Seja muito bem-vindo ao à bibliteca digital, um espaço dedicado à leitura, aqui você pode ler e baixar diversos livros em Domínio Público de forma legal. Este site foi criado com muita dedicação, ele representa um portal para o conhecimento e o prazer da leitura, sem infringir direitos autorais, espero que aproveitem.</p>
            </div>
        </div>
        <div class="Temas">
            
        </div>
    </div>

    <?php include("footer.php"); ?>
    
</body>
</html>