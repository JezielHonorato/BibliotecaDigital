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

document.getElementById("resultado").onload = pesquisarLivro()
var Ordem = 1

function pesquisarLivro(){

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



function mudarPeriodo() { //Função para o Range duplo
    let rangeMenorV = parseInt(document.getElementById('range_menor').value);
    let rangeMaiorV = parseInt(document.getElementById('range_maior').value);

    if (rangeMenorV > rangeMaiorV) {
    [rangeMenorV, rangeMaiorV] = [rangeMaiorV, rangeMenorV];
    }

    document.getElementById('range_menor').value = rangeMenorV;
    document.getElementById('range_maior').value = rangeMaiorV;

    const inputRangeMenor = document.getElementById('range_menor');
    const inputRangeMaior = document.getElementById('range_maior');

    const total = inputRangeMaior.max - inputRangeMenor.min;
    const pMaior = ((rangeMaiorV - inputRangeMenor.min) / total) * 100;
    const pMenor = ((rangeMenorV - inputRangeMenor.min) / total) * 100;

    document.getElementById('progresso').style.cssText = `background: linear-gradient(to right, var(--CorPrimaria) ${pMenor}% ${pMenor}%, var(--CorTerciaria) ${pMenor}% ${pMaior}%, var(--CorPrimaria) ${pMaior}%);`;

    pesquisarLivro();
}
document.getElementById('range_menor').addEventListener('input', mudarPeriodo);
document.getElementById('range_maior').addEventListener('input', mudarPeriodo);
document.getElementById('input_menor_valor').addEventListener('click', mudarPeriodo);
document.getElementById('input_maior_valor').addEventListener('click', mudarPeriodo);

function Ordenar(id) { //Função para os simbolos de Ordenar
    const elementos = ['ordenar_titulo', 'ordenar_autor', 'ordenar_data'];
    const elementoClicado = document.getElementById(`ordenar_${id}`);
    const ordenar = document.getElementById('ordem')
    let ordem = '';
    for (item of elementos){
        const elemento = document.getElementById(item);
        elemento.innerHTML = (elemento === elementoClicado) ? proximoTexto(elemento.innerHTML) : 'swap_vert';
        ordem = elemento.innerHTML == 'expand_more' ? `ORDER BY ${id} ASC` : elemento.innerHTML == 'expand_less' ? `ORDER BY ${id} DESC` : ordem;
    }
    ordenar.value = ordem;
    pesquisarLivro();
}function proximoTexto(textoAtual) {
    return textoAtual === 'swap_vert' ? 'expand_more' : textoAtual === 'expand_more' ? 'expand_less' : 'expand_more';
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
