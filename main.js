function CriaRequest() {
    try{
        request = new XMLHttpRequest();
    }catch (IEAtual){

        try{
            request = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(IEAntigo){

            try{
                request = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(falha){
                request = false;
            }
        }
    }

    if (!request)
        alert("Seu Navegador não suporta Ajax!");
    else
        return request;
}

document.getElementById("resultado").onload = PesquisarLivro()
var Ordem = 1

function PesquisarLivro(){

    var Pesquisar = document.getElementById("pesquisar").value;
    var Categoria = document.getElementById("categoria").value;
    var Nacionalidade = document.getElementById("nacionalidade").value;
    var RangeMenor = document.getElementById("range_menor").value;
    var RangeMaior = document.getElementById("range_maior").value;

    var result = document.getElementById("resultado");
    var xmlreq = CriaRequest();

    // Iniciar uma requisição

    xmlreq.open("GET", "processa.php?pesquisar=" + Pesquisar + "&categoria=" + Categoria + "&nacionalidade=" + Nacionalidade + "&range_menor=" + RangeMenor + "&range_maior=" + RangeMaior + "&ordem=" + Ordem, true );

    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){

        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {

            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };

    xmlreq.send(null);
}


function OrdenarT(){
    //Ordenar por Titulo
    var OrdenarTitulo = document.getElementById("ordenar_titulo"); 
    var OrdenarAutor = document.getElementById("ordenar_autor");
    var OrdenarData = document.getElementById("ordenar_data");

    if(OrdenarTitulo.innerHTML == "swap_vert"){
        OrdenarTitulo.innerHTML = "expand_more";
        OrdenarAutor.innerHTML = "swap_vert";
        OrdenarData.innerHTML = "swap_vert";
        Ordem = 1;
    }else if(OrdenarTitulo.innerHTML == "expand_more"){
        OrdenarTitulo.innerHTML = "expand_less";
        OrdenarAutor.innerHTML = "swap_vert";
        OrdenarData.innerHTML = "swap_vert";
        Ordem = 2;
    }else if(OrdenarTitulo.innerHTML == "expand_less"){
        OrdenarTitulo.innerHTML = "expand_more";
        OrdenarAutor.innerHTML = "swap_vert";
        OrdenarData.innerHTML = "swap_vert";
        Ordem = 1;
    }
    PesquisarLivro();

}function OrdenarA(){
    //Ordenar por Autor
    var OrdenarTitulo = document.getElementById("ordenar_titulo");
    var OrdenarAutor = document.getElementById("ordenar_autor");
    var OrdenarData = document.getElementById("ordenar_data");

    if(OrdenarAutor.innerHTML == "swap_vert"){
        OrdenarTitulo.innerHTML = "swap_vert";
        OrdenarAutor.innerHTML = "expand_more";
        OrdenarData.innerHTML = "swap_vert";
        Ordem = 3;
    }else if(OrdenarAutor.innerHTML == "expand_more"){
        OrdenarTitulo.innerHTML = "swap_vert";
        OrdenarAutor.innerHTML = "expand_less";
        OrdenarData.innerHTML = "swap_vert";
        Ordem = 4;
    }else if(OrdenarAutor.innerHTML == "expand_less"){
        OrdenarTitulo.innerHTML = "swap_vert";
        OrdenarAutor.innerHTML = "expand_more";
        OrdenarData.innerHTML = "swap_vert";
        Ordem = 3;
    }
    PesquisarLivro();

}function OrdenarD(){
    //Ordenar por Data
    var OrdenarTitulo = document.getElementById("ordenar_titulo");
    var OrdenarAutor = document.getElementById("ordenar_autor");
    var OrdenarData = document.getElementById("ordenar_data");

    if(OrdenarData.innerHTML == "swap_vert"){
        OrdenarTitulo.innerHTML = "swap_vert";
        OrdenarAutor.innerHTML = "swap_vert";
        OrdenarData.innerHTML = "expand_more";
        Ordem = 5;
    }else if(OrdenarData.innerHTML == "expand_more"){
        OrdenarTitulo.innerHTML = "swap_vert";
        OrdenarAutor.innerHTML = "swap_vert";
        OrdenarData.innerHTML = "expand_less";
        Ordem = 6;
    }else if(OrdenarData.innerHTML == "expand_less"){
        OrdenarTitulo.innerHTML = "swap_vert";
        OrdenarAutor.innerHTML = "swap_vert";
        OrdenarData.innerHTML = "expand_more";
        Ordem = 5;
    }
    PesquisarLivro();

}

var cor = true
function MudarCor(){
    if (cor) {
        document.documentElement.style.setProperty('--CorPrimaria', '#0B1622');
        document.documentElement.style.setProperty('--CorSecundaria', '#151F2E');
        document.documentElement.style.setProperty('--CorTexto', '#9BADBD');
        document.documentElement.style.setProperty('--CorHover', '#FFFFFF');
        document.documentElement.style.setProperty('--CorTerciaria', '#3DB4F2');
        cor = false;
    } else {
        document.documentElement.style.setProperty('--CorPrimaria', '#F1F3F7');
        document.documentElement.style.setProperty('--CorSecundaria', '#FFFFFF');
        document.documentElement.style.setProperty('--CorTexto', '#105503');
        document.documentElement.style.setProperty('--CorHover', '#4caf50');
        document.documentElement.style.setProperty('--CorTerciaria', '#3DB4F2');
        cor = true;
    }
};





function MudarPeriodo(){
    var RangeValor = document.getElementById('range_valor');
    var InputMenor = document.getElementById('input_menor_valor');
    var InputMaior = document.getElementById('input_maior_valor');
    var RangeMenor = parseInt(document.getElementById('range_menor').value);
    var RangeMaior = parseInt(document.getElementById('range_maior').value);
    var Progresso = document.getElementById('progresso');
    var ValorInicial = document.getElementById('valor_inicial').value;
    var ValorFinal = document.getElementById('valor_final').value;

    if(RangeMenor > RangeMaior){
        // Para o RangeMaior ser sempre o maior
        RangeExtra = RangeMenor
        RangeMenor = RangeMaior
        RangeMaior = RangeExtra
    }

    // Transformar em porcentagem
    var Total = ValorFinal - ValorInicial
    var Pmaior = ((RangeMaior - ValorInicial)/Total)*100
    var Pmenor = ((RangeMenor - ValorInicial)/Total)*100

    RangeValor.style.display = "flex"
    Progresso.style.cssText ="background: linear-gradient(to right, var(--CorSecundaria)" + Pmenor + "% " + Pmenor + "%, var(--CorTerciaria) " + Pmenor + "% " + Pmaior + "%, var(--CorSecundaria) " + Pmaior + "%);"

    InputMenor.value = RangeMenor
    InputMaior.value = RangeMaior
    
}function MudarPeriodoI(){
    var RangeValor = document.getElementById('range_valor');
    var InputMenorValor = document.getElementById('input_menor_valor').value;
    var InputMaiorValor = document.getElementById('input_maior_valor').value;
    var RangeMenor = document.getElementById('range_menor');
    var RangeMaior = document.getElementById('range_maior');
    var RangeMenorV = parseInt(document.getElementById('range_menor').value);
    var RangeMaiorV = parseInt(document.getElementById('range_maior').value);
    var Progresso = document.getElementById('progresso');
    var ValorInicial = document.getElementById('valor_inicial').value;
    var ValorFinal = document.getElementById('valor_final').value;

    if(RangeMenor > RangeMaior){
        RangeExtra = RangeMenor
        RangeMenor = RangeMaior
        RangeMaior = RangeExtra
    }
    
    RangeMenorV = InputMenorValor 
    RangeMaiorV = InputMaiorValor

    // Transformar em porcentagem
    var Total = ValorFinal - ValorInicial
    var Pmaior = ((RangeMaior - ValorInicial)/Total)*100
    var Pmenor = ((RangeMenor - ValorInicial)/Total)*100

    RangeMenor.value = InputMenorValor 
    RangeMaior.value = InputMaiorValor
    RangeValor.style.display = "flex"
    Progresso.style.cssText ="background: linear-gradient(to right, var(--Cheader)" + Pmenor + "% " + Pmenor + "%, var(--Cativo) " + Pmenor + "% " + Pmaior + "%, var(--Cheader) " + Pmaior + "%);"
}



function AddPais(){
    var NovoPais = document.getElementById('add_pais');
    var Padrao = document.getElementById('inserir');
    NovoPais.style.display = "block"
    Padrao.style.display = "none"
}function AddAutor(){
    var NovoAutor = document.getElementById('add_autor');
    var Padrao = document.getElementById('inserir');
    NovoAutor.style.display = "block"
    Padrao.style.display = "none"
}function FecharAutor(){
    var NovoAutor = document.getElementById('add_autor');
    var Padrao = document.getElementById('inserir');
    NovoAutor.style.display = "none"
    Padrao.style.display = "block"
}function FecharPais(){
    var NovoAutor = document.getElementById('add_autor');
    var NovoPais = document.getElementById('add_pais');
    var Padrao = document.getElementById('inserir');

    if(NovoAutor.style.display == "block"){
        NovoPais.style.display = "none"
    }
    else{
        NovoPais.style.display = "none"
        Padrao.style.display = "block"
    }
}

function Editar(){
    var NovoAutor = document.getElementById('add_autor');
    var NovoPais = document.getElementById('add_pais');
    var Padrao = document.getElementById('inserir');

    if(NovoAutor.style.display == "block"){
        NovoPais.style.display = "none"
    }
    else{
        NovoPais.style.display = "none"
        Padrao.style.display = "block"
    }
}

function CriarUsuario(){
    var Usuario = document.getElementById('usuario');
    var CriarUsuario = document.getElementById('criar_usuario');
    var Lista = document.getElementById('lista');
    var CriarApagar = document.getElementById('criar_apagar');

    Usuario.innerHTML = "Criar um novo Usuario"
    CriarUsuario.style.display = "grid"
    Lista.style.display = "none"
    CriarApagar.style.display = "none"
}
function ApagarUsuario(){
    var Usuario = document.getElementById('usuario');
    var ApagarUsuario = document.getElementById('apagar_usuario');
    var Lista = document.getElementById('lista');
    var CriarApagar = document.getElementById('criar_apagar');

    Usuario.innerHTML = "Apagar um Usuario"
    ApagarUsuario.style.display = "grid"
    Lista.style.display = "none"
    CriarApagar.style.display = "none"
}


function MostrarSenha(x){
    InputSenha = document.getElementById('input_senha_' + x)
    Span = document.getElementById('span_' + x)

    if(Span.innerHTML == 'visibility_off'){
        InputSenha.type = 'text'
        Span.innerHTML = 'visibility'
    }
    else{
        Span.innerHTML = 'visibility_off'
        InputSenha.type = 'password'
    }
}
