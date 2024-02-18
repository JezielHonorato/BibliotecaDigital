<?php

class Conexao {
  private $conn;

  public function __construct($hostname, $name, $username, $password) {
    try {
      $this->conn = new PDO("mysql:dbname=$hostname;host=" .$name, $username, $password);
      //echo "Sucesso! Conectado ao banco de dados $hostname como $username.\n";
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

  public function pesquisarLivros($parametros) {
    $condicoes = [];
    $parametros['pesquisa'] ? $condicoes[] = "(titulo LIKE :pesquisa OR autor LIKE :pesquisa)" : '';
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
    if(is_string($autor)) {
      $autor = $this->cadastrarAutorPais("autor", $autor);
    } else {
      $sqlConsulta = "SELECT 'existe' AS livro WHERE NOT EXISTS (SELECT 1 FROM tblivro WHERE titulo = :titulo AND idAutor = :idAutor);";
      $consulta = $this->conn->prepare($sqlConsulta);
  
      $consulta->bindParam(":titulo", $titulo, PDO::PARAM_STR);
      $consulta->bindParam(":idAutor", $titulo, PDO::PARAM_INT);
      $consulta->execute();
      
      if($consulta->rowCount() == 0) {
        return false;
      }
    } if (is_string($pais)) {
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
    if(is_string($autor)) {
      $autor = $this->cadastrarAutorPais("autor", $autor);
    } if (is_string($pais)) {
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

  private function cadastrarAutorPais($tabela, $camp) {
    $campo = ucwords(mb_strtolower($camp));
    $sqlConsulta = "SELECT 'existe' AS $tabela WHERE NOT EXISTS (SELECT 1 FROM tb$tabela WHERE $tabela = :campo);";
    $consulta = $this->conn->prepare($sqlConsulta);

    $consulta->bindParam(":campo", $campo, PDO::PARAM_STR);
    $consulta->execute();
    if($consulta->rowCount() == 0) {
      return false;
    } else {
      $sql = "INSERT INTO tb$tabela ($tabela) VALUES(:campo);";
      $prepare = $this->conn->prepare($sql);
      $prepare->bindParam(":campo", $campo, PDO::PARAM_STR);
      $prepare->execute();

      $idAdicionado = $this->conn->lastInsertId();
      return $idAdicionado;
    }
  }
}

$conn = new Conexao("bibliotecadigital", "localhost", "root", "");

//var_dump($conn->editarLivro(1, "autor"))
?>