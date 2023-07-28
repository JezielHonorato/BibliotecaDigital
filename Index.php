<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Biblioteca Digital</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src='main.js' defer></script>
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
        <form action="teste.php" merhod="post">
            <div class="GrupoCampo">
                <div class="Campo">
                    <span class="Lupa Menor">search</span>
                    <input type="text" class="Pesquisar" id="pesquisar" name="pesquisar">
                </div>

                <div class="Campo">
                    <span class="Expandir">expand_more</span>
                    <select class="Select" id="genero" name="genero" name="genero">
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
                    <div class="Linha">
                        <div class="Progresso" id="progresso"></div>
                        <span class="LinhaDupla">
                            <input type="range" min="0" max="2023" value="1000" id="range_menor" class="Periodo" onchange="MudarPeriodo()">
                            <input type="range" min="0" max="2023" value="2000" id="range_maior" class="Periodo" onchange="MudarPeriodo()">
                        </span>
                    </div>
                </div>
                <input type="submit" name="submit" value="" class="Invisivel">
            </div>
        </form>
    </div>

    <div class="Conteudo">
        <div class="Livro">
            <div class="Indice"> <h1>#</h1></div>
            <div class="Titulo"> <h1>Titulo</h1> <span class="Ordenar Menor2">swap_vert</span></div>
            <div class="Autor"> <h1>Autor</h1> <span class="Ordenar Menor2">swap_vert</span></div>
            <div class="Data"> <h1>Data</h1> <span class="Ordenar Menor2">swap_vert</span></div>
            <div class="Opcoes"></div>
        </div>

    </div>

    
    <footer class="Rodape">
        <a onclick="MudarCor()"><span class="Cor"> dialogs </span></a>
        <a>&copy; 2023 Biblioteca Digital. Todos os direitos reservados.</a>
    </footer>
</body>
</html>
