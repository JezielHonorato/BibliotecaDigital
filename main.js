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

document.getElementById("resultado").onload = pesquisarLivro();

function pesquisarLivro() {
  var pesquisar  = document.getElementById('pesquisar').value;
  var categoria  = document.getElementById('categoria').value;
  var pais       = document.getElementById('pais').value;
  var rangeMenor = document.getElementById('range_menor').value;
  var rangeMaior = document.getElementById('range_maior').value;
  var ordem      = document.getElementById('ordem').value;

  var result = document.getElementById('resultado_consulta');
  var xmlreq = criaRequest();

  xmlreq.open('GET', 'processa.php?pesquisa=%' + pesquisar + '%&categoria=' + categoria + '&pais=' + pais + '&range_menor=' + rangeMenor + '&range_maior=' + rangeMaior + '&ordem=' + ordem, true);
  xmlreq.onreadystatechange = function () {
    (xmlreq.readyState == 4) ? (xmlreq.status == 200) ? result.innerHTML = xmlreq.responseText : result.innerHTML = 'Erro: ' + xmlreq.statusText : '';
  };

  xmlreq.send(null);
}

document.getElementById('range_menor').addEventListener('input', mudarPeriodo);
document.getElementById('range_maior').addEventListener('input', mudarPeriodo);
function mudarPeriodo() { //Função para o Range duplo
  let rangeMenor = parseInt(document.getElementById('range_menor').value);
  let rangeMaior = parseInt(document.getElementById('range_maior').value);

  [rangeMenor, rangeMaior] = (rangeMenor > rangeMaior) ? [rangeMaior, rangeMenor] : [rangeMenor, rangeMaior];

  document.getElementById('input_menor_valor').textContent, document.getElementById('range_menor').value = rangeMenor;
  document.getElementById('input_maior_valor').textContent, document.getElementById('range_maior').value = rangeMaior;

  const inputRange = document.getElementById('range_menor');

  const total = inputRange.max - inputRange.min;
  const pMaior = ((rangeMaior - inputRange.min) / total) * 100;
  const pMenor = ((rangeMenor - inputRange.min) / total) * 100;

  document.getElementById('linha_progresso').style.cssText = `background: linear-gradient(to right, var(--cor-primaria) ${pMenor}% ${pMenor}%, var(--cor-terciaria) ${pMenor}% ${pMaior}%, var(--cor-primaria) ${pMaior}%);`;

  pesquisarLivro();
};

function ordenarLivros(id) { //Função para os simbolos de Ordenar
  const elementos = ['ordenar_titulo', 'ordenar_autor', 'ordenar_data'];
  const elementoClicado = document.getElementById(`ordenar_${id}`);
  const ordenar = document.getElementById('ordem')
  let ordem = '';
  for (item of elementos) {
    const elemento = document.getElementById(item);
    elemento.textContent = (elemento === elementoClicado) ? proximoTexto(elemento.textContent) : 'swap_vert';
    ordem = elemento.textContent == 'expand_more' ? `${id} ASC` : elemento.textContent == 'expand_less' ? `${id} DESC` : ordem;
  }
  ordenar.value = ordem;
  pesquisarLivro();
} function proximoTexto(textoAtual) {
  return textoAtual === 'swap_vert' ? 'expand_more' : textoAtual === 'expand_more' ? 'expand_less' : 'expand_more';
};

function mostrarSenha(x) { //Função para mostrar senha nos inputs password
  const inputSenha = document.getElementById('input_senha_' + x);
  const span = document.getElementById('span_' + x);

  inputSenha.type = span.textContent === 'visibility_off' ? 'text' : 'password';
  span.textContent = inputSenha.type === 'password' ? 'visibility_off' : 'visibility';
};

var cadastrar = true;
function cadastrarNovo(id) {
  const select = document.getElementById(id);
  const input  = document.getElementById(id + '_input');
  const button = document.getElementById(id + '_button');
  if(cadastrar){
    select.style.display = 'none';
    input.style.display = 'block';
    select.disabled = true;
    input.disabled = false;
    button.textContent = 'cancelar';
    cadastrar = false;
  } else{
    select.style.display = 'block';
    input.style.display = 'none';
    select.disabled = false;
    input.disabled = true;
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

function mudarCor(tema) {
  var novoTema = (tema == 'dark') ? 'day' : 'dark';
  document.cookie = "tema=" + novoTema + "; expires=" + (new Date().getTime() + (1 * 24 * 60 * 60 * 1000));
  location.reload();
}