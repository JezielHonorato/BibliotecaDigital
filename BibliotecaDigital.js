var Livro = /** @class */ (function () {
    function Livro(id, titulo, autor, ano) {
        this.id = id;
        this.titulo = titulo;
        this.autor = autor;
        this.favorito = false;
        this.ano = ano;
    }
    return Livro;
}());
var ressurreicao = new Livro(1, "Ressurreição", "Machado de Assis", 1872);
var a_mao_e_a_luva = new Livro(2, "A mão e a Luva", "Machado de Assis", 1874);
var helena = new Livro(3, "Helena", "Machado de Assis", 1876);
var iaia_garcia = new Livro(4, "Iaia Garcia", "Machado de Assis", 1878);
var memorias_postumas_de_bras_cubas = new Livro(5, "Memorias Postumas de Bras Cubas", "Machado de Assis", 1881);
var casa_velha = new Livro(6, "Casa Velha", "Machado de Assis", 1885);
var quincas_borba = new Livro(7, "Quincas Borba", "Machado de Assis", 1891);
var dom_casmurro = new Livro(8, "Dom Casmurro", "Machado de Assis", 1899);
var esau_e_jaco = new Livro(9, "Esau e jaco", "Machado de Assis", 1904);
var memorial_de_aires = new Livro(10, "Memorial de aires", "Machado de Assis", 1908);
var Favoritos = /** @class */ (function () {
    function Favoritos(lista) {
        this.lista = lista;
    }
    return Favoritos;
}());
var favoritos = new Favoritos([]);
function Favoritar(x) {
    var fav = document.getElementById('favoritar');
    if (x.favorito == false) {
        x.favorito = true;
        fav.style.backgroundColor = 'var(--marcado';
        favoritos.lista.push(x);
    }
    else if (x.favorito == true) {
        x.favorito = false;
        fav.style.backgroundColor = 'var(--navback)';
        var n = favoritos.lista.indexOf(x);
        favoritos.lista.slice(n, 1);
    }
    console.log(x);
}
/*function Leragora() {
    let livroonline = document.getElementById('livroonline');
    let tab = document.getElementById('tab');
    let capa = document.getElementById('capa');


    if(livroonline?.style.display == 'none') {
        livroonline.style.display = 'block';
        tab.style.display = 'none';
        capa.style.display = 'none';

    }
    else{
        livroonline.style.display = 'none';
        tab.style.display = 'block';
        capa.style.display = 'block';
    }
}
*/ 
