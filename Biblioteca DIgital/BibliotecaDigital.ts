
class Livro {
    id: number
    titulo: string
    autor: string
    favorito: boolean
    ano: number

    constructor(id: number, titulo: string, autor: string, ano: number) {
    this.id = id;
    this.titulo = titulo;
    this.autor = autor;
    this.favorito = false
    this.ano = ano
    }
}
const ressurreicao = new Livro(1, "Ressurreição", "Machado de Assis", 1872)
const a_mao_e_a_luva = new Livro(2, "A mão e a Luva", "Machado de Assis", 1874)
const helena = new Livro(3, "Helena", "Machado de Assis", 1876)
const iaia_garcia = new Livro(4, "Iaia Garcia", "Machado de Assis", 1878)
const memorias_postumas_de_bras_cubas = new Livro(5, "Memorias Postumas de Bras Cubas", "Machado de Assis", 1881)
const casa_velha = new Livro(6, "Casa Velha", "Machado de Assis", 1885)
const quincas_borba = new Livro(7, "Quincas Borba", "Machado de Assis", 1891)
const dom_casmurro = new Livro(8, "Dom Casmurro", "Machado de Assis", 1899)
const esau_e_jaco = new Livro(9, "Esau e jaco", "Machado de Assis", 1904)
const memorial_de_aires = new Livro(10, "Memorial de aires", "Machado de Assis", 1908)

class Favoritos{
    lista: Livro[]
    constructor(lista: Livro[]){
        this.lista = lista;
    }
}

const favoritos = new Favoritos([])
function Favoritar(x: Livro){
    let fav = document.getElementById('favoritar');

    if(x.favorito == false){
        x.favorito = true
        fav.style.backgroundColor = 'var(--marcado';
        favoritos.lista.push(x)
    }
    else if(x.favorito == true){
        x.favorito = false
        fav.style.backgroundColor = 'var(--navback)';
        let n = favoritos.lista.indexOf(x)
        favoritos.lista.slice(n, 1)
    }
    console.log(x)
}

const urlParams = new URLSearchParams(window.location.search);
const dadoslivro = urlParams.get('busca');







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