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
    if ($this->verificarSenha($user, $senha)){
      session_start();
      $_SESSION['usuario'] = $this->verificarSenha($user, $senha);
      header("Location: index.php");
    }
  }

  public function alterarSenha($user, $senha, $senhaNova) {
    if($this->verificarSenha($user, $senha)) {
      $hash = password_hash($senhaNova, PASSWORD_DEFAULT );
      $sql = "UPDATE tbusuario SET senha = :senha WHERE usuario = :user";
      $prepare = $this->conn->prepare($sql);
      $prepare->bindParam(":senha", $hash, PDO::PARAM_STR);
      $prepare->bindParam(":user", $user, PDO::PARAM_STR);
      try {
        $prepare->execute();
        return true;
      } catch (PDOException $erro) {
        throw new Exception("Erro: " . $erro->getMessage());
      }
    } else {
      return false;
    }
  }

  public function cadastrarUsuario($nome, $nivel) {
    $sql = "INSERT INTO tbusuario (usuario, nivel, senha) VALUES(:nome, :nivel, :senha)";
    $hash = password_hash($nome, PASSWORD_DEFAULT);
    $prepare = $this->conn->prepare($sql);
    $prepare->bindParam(':nome', $nome, PDO::PARAM_STR);
    $prepare->bindParam(':nivel', $nivel, PDO::PARAM_INT, 1);
    $prepare->bindParam(':senha', $hash, PDO::PARAM_STR);
    try {
      $prepare->execute();
      return true;
    } catch (PDOException $erro) {
      echo "Erro: " . $erro->getMessage();
      exit();
    }
  }

  public function apagarUsuario($nome) {
    $sql = "DELETE FROM tbusuario WHERE usuario = :usuario";
    $prepare = $this->conn->prepare($sql);
    $prepare->bindParam(":usuario", $nome, PDO::PARAM_STR);
    try {
      $prepare->execute();
      return true;
    } catch (PDOException $erro) {
      echo "Erro: " . $erro->getMessage();
      exit();
    }
  }

  public function desconectarUsuario() {
    session_start();
    session_destroy();
    header("Location: index.php");
  }

  private function cadastrarAutorPais($tabela, $campo) {
    $campo = ucwords(mb_strtolower($campo));
    if($this->consultarTabela("tb$tabela", [$tabela], [$campo])) {
      return false;
    }
    $sql = "INSERT INTO tb$tabela ($tabela) VALUES(:campo);";
    $prepare = $this->conn->prepare($sql);
    $prepare->bindParam(":campo", $campo, PDO::PARAM_STR);
    $prepare->execute();

    $idAdicionado = $this->conn->lastInsertId();
    return $idAdicionado;
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

    return ($consulta->rowCount() == 0) ? true : false; //Se existir retorna true
  }

  private function verificarSenha($user, $senha) {
    $sql = "SELECT usuario, nivel, senha FROM tbusuario WHERE usuario = :user";
    $prepare = $this->conn->prepare($sql);
    $prepare->bindParam(":user", $user, PDO::PARAM_STR);
    try {
      $prepare->execute();
      $result = $prepare->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $erro) {
      throw new Exception("Erro: " . $erro->getMessage());
    }
    return password_verify($senha, $result['senha']) ? [$result['usuario'], $result['nivel']] : false;
  }
}


$conn = new Conexao("bibliotecadigital", "localhost", "root", "");
?>