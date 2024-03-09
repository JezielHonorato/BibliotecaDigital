<?php

class Conexao {
  private $conn;

  public function __construct($hostname, $name, $username, $password) {
    try {
      $this->conn = new PDO("mysql:dbname=$hostname;host=" .$name, $username, $password);
    } catch (PDOException $erro) {
      echo "Erro de conexão: " . $erro->getMessage();
      exit();
    }
  }

  public function selecionarTodos($campo) {
    $arrayPossivel = ["categoria", "pais", "usuario", "autor"];
    if(!in_array($campo, $arrayPossivel)) {
      throw new Exception("A tabela '$campo' não é válida.");
    }
    $sql = "SELECT * FROM tb$campo ORDER BY $campo ASC";
    $prepare = $this->conn->prepare($sql);
    try {
      $prepare->execute();
      $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $erro) {
      echo "Erro ao executar a consulta: " . $erro->getMessage();
      exit();
    }

    return $result; 
  }

  public function selecionarDatas() {
    $sql = "SELECT MIN(data) as min, MAX(data) as max FROM tblivro";
    $prepare = $this->conn->prepare($sql);
    try {
      $prepare->execute();
      $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $erro) {
      echo "Erro ao executar a consulta: " . $erro->getMessage();
      exit();
    }

    return $result; 
  }

  public function pesquisarLivros($parametros) {
    $condicoes = [];
    $parametros['pesquisa']  ? $condicoes[] = "(titulo LIKE :pesquisa OR autor LIKE :pesquisa)" : '';
    $parametros['categoria'] ? $condicoes[] = "idCategoria = :idCategoria" : '';
    $parametros['pais']      ? $condicoes[] = "idPais = :idPais" : '';
    $condicoes[] = "data BETWEEN :dataMenor AND :dataMaior";

    $sql  = "SELECT idLivro, titulo, autor, data FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor";
    $sql .= " WHERE " . implode(" AND ", $condicoes);
    $sql .= " ORDER BY :ordem";
  
    $prepare = $this->conn->prepare($sql);

    $prepare->bindParam(':pesquisa', $parametros['pesquisa'], PDO::PARAM_STR);
    $parametros['categoria'] ? $prepare->bindParam(':idCategoria', $parametros['categoria']) : '';
    $parametros['pais']      ? $prepare->bindParam(':idPais', $parametros['pais'], PDO::PARAM_INT) : '';
    $prepare->bindParam(':dataMenor', $parametros['range_menor'], PDO::PARAM_INT);
    $prepare->bindParam(':dataMaior', $parametros['range_maior'], PDO::PARAM_INT);
    $prepare->bindParam(':ordem', $parametros['ordem'], PDO::PARAM_STR);

    try {
      $prepare->execute();
      $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $erro) {
      echo $sql;
      echo "Erro ao executar a consulta: " . $erro->getMessage();
      exit();
    }

    return $result;
  }

  public function cadastrarLivro($titulo, $data, $autor, $pais, $idCategoria, $user) {
    $titulo = ucwords(mb_strtolower($titulo));
    if(!is_numeric($autor)) {
      $autor = $this->cadastrarAutorPais("autor", $autor);
    } else if ($this->consultarTabela("tblivro", ['titulo', 'idAutor'], [mb_strtolower($titulo), mb_strtolower($autor)])) {
      return false;
    } if (!is_numeric($pais)) {
      $pais = $this->cadastrarAutorPais("pais", $pais);
    }
    $sql = "INSERT INTO tblivro (titulo, data, idAutor, idPais, idCategoria, usuario) VALUES(:titulo, :data, :idAutor, :idPais, :idCategoria, :user);";
    $prepare = $this->conn->prepare($sql);

    $prepare->bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $prepare->bindParam(':data', $data, PDO::PARAM_INT, 4);
    $prepare->bindParam(':idAutor', $autor, PDO::PARAM_INT);
    $prepare->bindParam(':idPais', $pais, PDO::PARAM_INT);
    $prepare->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
    $prepare->bindParam(':user', $user, PDO::PARAM_STR);
    $prepare->execute();

    $livroAdicionado = $this->conn->lastInsertId();
    return $livroAdicionado;
  }

  public function selecionarLivro($id, $campo) {
    $sql ="SELECT titulo, autor, l.idAutor, categoria, l.idCategoria, pais, l.idPais, data FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor INNER JOIN tbcategoria AS c ON c.idCategoria = l.idCategoria INNER JOIN tbpais AS p ON p.idPais = l.idPais WHERE idLivro = :id";
    $prepare = $this->conn->prepare($sql);
    $prepare->bindParam(":id", $id, PDO::PARAM_INT);
    try {
      $prepare->execute();
      $livro = $prepare->fetch();
    } catch (PDOException $erro) {
      throw new Exception("Erro: " . $erro->getMessage());
    }

    return isset($livro["$campo"]) ? $livro["$campo"] : '';
  }

  public function excluirLivro($id, $titulo) {
    $sql = "DELETE FROM tblivro WHERE idLivro = :id AND titulo = :titulo";
    $prepare = $this->conn->prepare($sql);
    $prepare->bindParam(":id", $id, PDO::PARAM_INT);
    $prepare->bindParam(":titulo", $titulo, PDO::PARAM_STR);
    try {
      $prepare->execute();
      unlink("./assets/$id.php");
      return true;
    } catch (PDOException $erro) {
      echo "Erro: " . $erro->getMessage();
      exit();
      return false;
    }
  }

  public function editarLivro($titulo, $data, $autor, $pais, $idCategoria, $id) {
    $titulo = ucwords(mb_strtolower($titulo));
    if(!is_numeric($autor)) {
      $autor = $this->cadastrarAutorPais("autor", $autor);
    } if (!is_numeric($pais)) {
      $pais = $this->cadastrarAutorPais("pais", $pais);
    }

    $sql = "UPDATE tblivro SET titulo = :titulo, data = :data, idAutor = :idAutor, idPais = :idPais, idCategoria = :idCategoria WHERE idLivro = :id";
    $prepare = $this->conn->prepare($sql);

    $prepare->bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $prepare->bindParam(':data', $data, PDO::PARAM_INT, 4);
    $prepare->bindParam(':idAutor', $autor, PDO::PARAM_INT);
    $prepare->bindParam(':idPais', $pais, PDO::PARAM_INT);
    $prepare->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
    $prepare->bindParam(':id', $id, PDO::PARAM_INT);
    
    try {
      $prepare->execute();
    } catch (PDOException $erro) {
      throw new Exception("Erro: " . $erro->getMessage());
    }
    return true;
  }

  public function conectarUsuario($user, $senha) {
    $sql = $this->conn->query("SELECT usuario, nivel FROM tbusuario WHERE usuario = '$user' AND senha = '$senha'");
    $sql->execute();
    if ($sql->rowCount() == 1) {
      $user = $sql->fetch();
      session_start();
      $_SESSION['usuario'] = array($user['usuario'], $user['nivel']);
      header('Location: index.php');
    } else {
      echo 'Falha ao conectar! Usuario ou senha incorretas.';
    }
  }

  public function alterarSenha($user, $senhaAntiga, $senhaNova, $senhaNova2) {
    if($senhaNova != $senhaNova2){
      return false;
    } else if($this->consultarTabela('tbusuario', ['usuario', 'senha'], ["$user", "$senhaAntiga"])){
      $sql = "UPDATE tbusuario SET senha = :senha WHERE usuario = :user";
      $prepare = $this->conn->prepare($sql);
      $prepare->bindParam(":senha", $senhaNova, PDO::PARAM_STR);
      $prepare->bindParam(":user", $user, PDO::PARAM_STR);
      try {
        $prepare->execute();
        return true;
      } catch (PDOException $erro) {
        throw new Exception("Erro: " . $erro->getMessage());
      }
    } else{
      return false;
    }
  }

  public function desconectarUsuario() {
    session_start();
    session_destroy();
    header("Location: index.php");
  }

  private function cadastrarAutorPais($tabela, $campo) {
    if($this->consultarTabela("tb$tabela", [$tabela], [mb_strtolower($campo)])) {
      return false;
      $sql = "INSERT INTO tb$tabela ($tabela) VALUES(:campo);";
      $prepare = $this->conn->prepare($sql);
      $prepare->bindParam(":campo", $campo, PDO::PARAM_STR);
      $prepare->execute();

      $idAdicionado = $this->conn->lastInsertId();
      return $idAdicionado;
    }
  }

  private function consultarTabela($tabela, $campos, $valores) {
    $sqlConsulta = "SELECT 'existe' AS $tabela WHERE NOT EXISTS (SELECT 1 FROM $tabela WHERE";
    $i = 0;
    foreach ($campos as $item) {
      $sqlConsulta .= $i > 0 ? " AND $item = ?" : " $item = ?";
      $i++;
    }
    $sqlConsulta .= ");";
    $consulta = $this->conn->prepare($sqlConsulta);

    for ($i; $i > 0; $i--){
      $consulta->bindParam($i, $valores[$i -1], PDO::PARAM_STR);
    }
    $consulta->execute();

    return ($consulta->rowCount() == 0) ? true : false;
  }
}

$conn = new Conexao("bibliotecadigital", "localhost", "root", "");
?>