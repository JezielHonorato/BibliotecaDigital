function criaRequest() {
  try {
    request = new XMLHttpRequest();
  } catch (IEAtual) {

    try {
      request = new ActiveXObject('Msxml2.XMLHTTP');
    } catch (IEAntigo) {

      try {
        request = new ActiveXObject('Microsoft.XMLHTTP');
      } catch (falha) {
        request = false;
  } } }

  return request ? request : alert('Seu Navegador não suporta Ajax!');
}

document.getElementById('resultado').onload = pesquisarLivro()

function pesquisarLivro() {
  var pesquisar  = document.getElementById('pesquisar').value;
  var categoria  = document.getElementById('categoria').value;
  var pais       = document.getElementById('pais').value;
  var rangeMenor = document.getElementById('range_menor').value;
  var rangeMaior = document.getElementById('range_maior').value;
  var ordem      = document.getElementById('ordem').value;

  var result = document.getElementById('resultado_consulta');
  var xmlreq = criaRequest();

  xmlreq.open('GET', 'processa.php?pesquisar=' + pesquisar + '&categoria=' + categoria + '&pais=' + pais + '&range_menor=' + rangeMenor + '&range_maior=' + rangeMaior + '&ordem=' + ordem, true);
  xmlreq.onreadystatechange = function () {
    (xmlreq.readyState == 4) ? (xmlreq.status == 200) ? result.innerHTML = xmlreq.responseText : result.innerHTML = 'Erro: ' + xmlreq.statusText : '';
  };

  xmlreq.send(null);
}

function mudarPeriodo() { //Função para o Range duplo
  let rangeMenorV = parseInt(document.getElementById('range_menor').value);
  let rangeMaiorV = parseInt(document.getElementById('range_maior').value);

  [rangeMenorV, rangeMaiorV] = (rangeMenorV > rangeMaiorV) ? [rangeMaiorV, rangeMenorV] : [rangeMenorV, rangeMaiorV];

  document.getElementById('input_menor_valor').innerHTML, document.getElementById('range_menor').value = rangeMenorV;
  document.getElementById('input_maior_valor').innerHTML, document.getElementById('range_maior').value = rangeMaiorV;

  const inputRange = document.getElementById('range_menor');

  const total = inputRange.max - inputRange.min;
  const pMaior = ((rangeMaiorV - inputRange.min) / total) * 100;
  const pMenor = ((rangeMenorV - inputRange.min) / total) * 100;

  document.getElementById('linha_progresso').style.cssText = `background: linear-gradient(to right, var(--cor-primaria) ${pMenor}% ${pMenor}%, var(--cor-terciaria) ${pMenor}% ${pMaior}%, var(--cor-primaria) ${pMaior}%);`;

  pesquisarLivro();
};
document.getElementById('range_menor').addEventListener('input', mudarPeriodo);
document.getElementById('range_maior').addEventListener('input', mudarPeriodo);

function ordenarLivros(id) { //Função para os simbolos de Ordenar
  const elementos = ['ordenar_titulo', 'ordenar_autor', 'ordenar_data'];
  const elementoClicado = document.getElementById(`ordenar_${id}`);
  const ordenar = document.getElementById('ordem')
  let ordem = '';
  for (item of elementos) {
    const elemento = document.getElementById(item);
    elemento.innerHTML = (elemento === elementoClicado) ? proximoTexto(elemento.innerHTML) : 'swap_vert';
    ordem = elemento.innerHTML == 'expand_more' ? `ORDER BY ${id} ASC` : elemento.innerHTML == 'expand_less' ? `ORDER BY ${id} DESC` : ordem;
  }
  ordenar.value = ordem;
  pesquisarLivro();
} function proximoTexto(textoAtual) {
  return textoAtual === 'swap_vert' ? 'expand_more' : textoAtual === 'expand_more' ? 'expand_less' : 'expand_more';
};

function mostrarSenha(x) { //Função para mostrar senha nos inputs password
  const inputSenha = document.getElementById('input_senha_' + x);
  const span = document.getElementById('span_' + x);

  inputSenha.type = span.innerHTML === 'visibility_off' ? 'text' : 'password';
  span.innerHTML = inputSenha.type === 'password' ? 'visibility_off' : 'visibility';
};

var cadastrar = true;
function cadastrarNovo(id) {
  const select = document.getElementById(id);
  const input  = document.getElementById(id + '_input');
  const button = document.getElementById(id + '_button');
  if(cadastrar){
    select.style.display = 'none';
    input.style.display = 'block';
    button.textContent = 'cancelar';
    cadastrar = false;
  } else{
    select.style.display = 'block';
    input.style.display = 'none';
    button.textContent = 'Adicionar um novo ' + id;
    cadastrar = true;
} }

function soltarArquivo(event) { //Funções para Selecionar um arquivo
  event.preventDefault(); 
  var file = event.dataTransfer.files[0];
  mostrarArquivo(file);
} function arrastarArquivo(event) {
  event.preventDefault();
} function mostrarArquivoInput(event) {
  var file = event.target.files[0];
  mostrarArquivo(file);
} function mostrarArquivo(file) {
  const labelFile = document.getElementById('cadastro_label_file');
  file ? (file.size <= 10 * 1024 * 1024) ? labelFile.textContent = file.name : alert('O arquivo deve ter no máximo 10 MB.') : labelFile.textContent = 'Selecione o Arquivo';
}

function alterarUsuario(campo) {
  const formularioAlterar = document.getElementById('alterar_usuario');
  const criarApagar = document.getElementById(`${campo}_usuario`);

  formularioAlterar.style.display = 'grid';
  criarApagar.style.display = 'grid';
  alterarUsuario = function() {
    location.reload();
} };

var cor = true
function mudarCor() {
  if (cor) {
    document.documentElement.style.setProperty('--cor-primaria', '#0B1622');
    document.documentElement.style.setProperty('--cor-secundaria', '#151F2E');
    document.documentElement.style.setProperty('--cor-texto', '#9BADBD');
    document.documentElement.style.setProperty('--cor-hover', '#FFFFFF');
    document.documentElement.style.setProperty('--cor-terciaria', '#3DB4F2');
    cor = false;
  } else {
    document.documentElement.style.setProperty('--cor-primaria', '#F1F3F7');
    document.documentElement.style.setProperty('--cor-secundaria', '#FFFFFF');
    document.documentElement.style.setProperty('--cor-texto', '#105503');
    document.documentElement.style.setProperty('--cor-hover', '#4caf50');
    document.documentElement.style.setProperty('--cor-terciaria', '#3DB4F2');
    cor = true;
} };
