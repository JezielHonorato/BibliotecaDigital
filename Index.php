<?php/*
    include_once('rede.php');
    if(isset($_POST['submit'])){
        $genero = $_POST['genero'];
        $categoria = $_POST['categoria'];
        $nacionalidade = $_POST['nacionalidade'];
    }*/
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Biblioteca Digital</title>
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

    <div class="BuscaAvancada">
        <form action="index.php" merhod="POST">
            <div class="GrupoCampo">
                <div class="Campo">
                    <label class="Lupa Menor">search</label>
                    <input type="text" class="Pesquisar" id="pesquisar">
                </div>

                <div class="Campo">
                    <span class="Expandir">expand_more</span>
                    <select class="Select" id="genero" name="genero">
                        <option></option>
                        <option value="Misterio">Mistério</option>
                        <option value="Romance">Romance</option>
                        <option value="Fantasia">Fantasia</option>
                        <option value="Não-ficção">Não-ficção</option>
                    </select>
                </div>

                <div class="Campo">
                <span class="Expandir">expand_more</span>
                    <select class="Select" id="categoria" name="categoria">
                        <option></option>
                        <option value="Romance">Romance</option>
                        <option value="Poema">Poema</option>
                        <option value="Poesia">Poesia</option>
                        <option value="Cordel">Cordel</option>
                    </select>
                </div>

                <div class="Campo">
                    <span class="Expandir">expand_more</span>
                    <select class="Select" id="nacionalidade" name="nacionalidade">
                        <option></option>
                        <option value="Brasil">Brasil</option>
                        <option value="Alemanha">Alemanha</option>
                        <option value="Rússia">Rússia</option>
                        <option value="Estados Unidos">Estados Unidos</option>
                    </select>
                </div>

                <div class="Campo CampoR">
                    <!--<div class="AnoValue">
                        <div class="Radio">
                            <input type="radio" id="radio" class="Invisivel">
                            <label onclick="AntesDepois()" id="radio_label" for="radio">Escolha a Data</label>
                        </div>
                        <span id="ano_value"></span>
                    </div>
                    <input type="range" class="Ano" min="0" max="2023" value="" onChange="RangeData(this.value)">-->
                    <div class="Linha">
                        <div class="Progresso"></div>
                        <span class="LinhaDupla">
                            <input type="range" min="0" max="2023" value="1000" id="min" class="Periodo">
                            <input type="range" min="0" max="2023" value="2000" id="max" class="Periodo">
                        </span>
                    </div>
                    

                </div>
            </div>

            <div class="Invisivel">
                <input type="submit" value="Buscar">
            </div>
        </form>
    </div>

    <div class="Conteudo">
        <div class="livro">
            <h1>Dom Casmurro</h1>
            <a>Machado de Assis - </a>
            <a>1954</a>
        </div>
        <div class="livro">
            <h1>Dom Casmurro</h1>
            <a>Machado de Assis - </a>
            <a>1954</a>
        </div>
        <div class="livro">
            <h1>Dom Casmurro</h1>
            <a>Machado de Assis - </a>
            <a>1954</a>
        </div>
        <div class="livro">
            <h1>Dom Casmurro</h1>
            <a>Machado de Assis - </a>
            <a>1954</a>
        </div>
        <div class="livro">
            <h1>Dom Casmurro</h1>
            <a>Machado de Assis - </a>
            <a>1954</a>
        </div>
        <div class="livro">
            <h1>Dom Casmurro</h1>
            <a>Machado de Assis - </a>
            <a>1954</a>
        </div>
    </div>

    <footer class="Rodape">
        <a>&copy; 2023 Biblioteca Digital. Todos os direitos reservados.</a>
    </footer>
</body>
</html>
