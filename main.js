x = -1

function MudarCor(){
    a = -1;
    x = x*a
    if(x>=0){
        document.documentElement.style.setProperty('--Cfun', '#FFFFFF');
        document.documentElement.style.setProperty('--Cnav', '#49F265');
        document.documentElement.style.setProperty('--Ctxt', '#000000');
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
    var InputMenor = document.getElementById('range_menor_valor');
    var InputMaior = document.getElementById('range_maior_valor');
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

    InputMenor.value = RangeMenor
    InputMaior.value = RangeMaior
}
function MudarPeriodoI(){
    var RangeValor = document.getElementById('range_valor');
    var InputMenorValor = document.getElementById('range_menor_valor').value;
    var InputMaiorValor = document.getElementById('range_maior_valor').value;
    var RangeMenor = document.getElementById('range_menor');
    var RangeMaior = document.getElementById('range_maior');
    var RangeMenorV = parseInt(document.getElementById('range_menor').value);
    var RangeMaiorV = parseInt(document.getElementById('range_maior').value);
    var Progresso = document.getElementById('progresso');

    if(RangeMenor > RangeMaior){
        RangeExtra = RangeMenor
        RangeMenor = RangeMaior
        RangeMaior = RangeExtra
    }
    RangeMenorV = InputMenorValor 
    RangeMaiorV = InputMaiorValor

    var Pmaior = (RangeMaiorV/2023)*100
    var Pmenor = (RangeMenorV/2023)*100

    RangeMenor.value = InputMenorValor 
    RangeMaior.value = InputMaiorValor
    RangeValor.style.display = "flex"
    Progresso.style.cssText ="background: linear-gradient(to right, var(--Cnav)" + Pmenor + "% " + Pmenor + "%, var(--Cati) " + Pmenor + "% " + Pmaior + "%, var(--Cnav) " + Pmaior + "%);"
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


