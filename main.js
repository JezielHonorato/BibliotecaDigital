x = -1

function MudarCor(){
    a = -1;
    x = x*a
    if(x>=0){
        document.documentElement.style.setProperty('--Cfun', '#FFFFFF')
        document.documentElement.style.setProperty('--Cnav', '#2F9E41')
        document.documentElement.style.setProperty('--Ctxt', '#000000')
        document.documentElement.style.setProperty('--Cati', '#CD191E')
    }else{
        document.documentElement.style.setProperty('--Cfun', '#0B1622')
        document.documentElement.style.setProperty('--Cnav', '#151F2E')
        document.documentElement.style.setProperty('--Ctxt', '#9BADBD')
        document.documentElement.style.setProperty('--Cati', '#3DB4F2')
    }
}


function MudarPeriodo(){
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

    Progresso.style.cssText ="background: linear-gradient(to right, var(--Cnav)" + Pmenor + "% " + Pmenor + "%, var(--Cati) " + Pmenor + "% " + Pmaior + "%, var(--Cnav) " + Pmaior + "%);"

}
