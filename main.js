x = -1

function MudarCor(){
    a = -1;
    x = x*a
    if(x>=0){
        document.documentElement.style.setProperty('--Cfun', '#FFFFFF');
        document.documentElement.style.setProperty('--Cnav', '#2c3e50');
        document.documentElement.style.setProperty('--Ctxt', '#FFFFFF');
        document.documentElement.style.setProperty('--Chov', '#9BADBD');
        document.documentElement.style.setProperty('--Cati', '#e74c3c');
    }else{
        document.documentElement.style.setProperty('--Cfun', '#0B1622');
        document.documentElement.style.setProperty('--Cnav', '#151F2E');
        document.documentElement.style.setProperty('--Ctxt', '#9BADBD');
        document.documentElement.style.setProperty('--Cati', '#3DB4F2');
        document.documentElement.style.setProperty('--Chov', '#FFFFFF');

    }
}


function MudarPeriodo(){
    var RangeValor = document.getElementById('range_valor');
    var RangeMenorValor = document.getElementById('range_menor_valor');
    var RangeMaiorValor = document.getElementById('range_maior_valor');
    var RangeMenor = parseInt(document.getElementById('range_menor').value);
    var RangeMaior = parseInt(document.getElementById('range_maior').value);
    var Progresso = document.getElementById('progresso');

    if(RangeMenor > RangeMaior){
        RangeExtra = RangeMenor
        RangeMenor = RangeMaior
        RangeMaior = RangeExtra
    }

    var Pmaior = (RangeMaior/2023)*100
    var Pmenor = (RangeMenor/2023)*100

    RangeValor.style.display = "flex"
    Progresso.style.cssText ="background: linear-gradient(to right, var(--Cnav)" + Pmenor + "% " + Pmenor + "%, var(--Cati) " + Pmenor + "% " + Pmaior + "%, var(--Cnav) " + Pmaior + "%);"

    RangeMenorValor.innerHTML = RangeMenor
    if(RangeMenor == 0){
        RangeMenorValor.innerHTML = "A.C"
    }
    RangeMaiorValor.innerHTML = RangeMaior
}

function AddPais(){
    var NovoPais = document.getElementById('add_pais');
    var Padrao = document.getElementById('inserir');
    NovoPais.style.display = "block"
    Padrao.style.display = "none"
}
function AddAutor(){
    var NovoAutor = document.getElementById('add_autor');
    var Padrao = document.getElementById('inserir');
    NovoAutor.style.display = "block"
    Padrao.style.display = "none"
}
function FecharAutor(){
    var NovoAutor = document.getElementById('add_autor');
    var Padrao = document.getElementById('inserir');
    NovoAutor.style.display = "none"
    Padrao.style.display = "block"
}
function FecharPais(){
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

/*
Pesquisar.addEventListener("keydown", function(event){
    if(event.key === "Enter"){
        Search()
    };
})
*/
function Search(){
    var Pesquisar = document.getElementById('pesquisar');
    window.location = "Livros.php?pesquisar=" + Pesquisar.value;
}
