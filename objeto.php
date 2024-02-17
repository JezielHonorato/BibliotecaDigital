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
    $arrayPossivel = ["categoria", "pais", "usuario"];
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


  public function pesquisarLivros($pesquisa, $pais, $categoria, $dataMenor, $dataMaior, $ordem) {
    $condicoes = [];
    $pesquisa  ? $condicoes[] = "(titulo LIKE :pesquisa OR autor LIKE :pesquisa)" : '';
    $categoria ? $condicoes[] = "idCategoria = :idCategoria" : '';
    $pais      ? $condicoes[] = "idPais = :idPais" : '';
    $condicoes[] = "data BETWEEN :dataMenor AND :dataMaior";

    $sql  = "SELECT idLivro, titulo, autor, data FROM tblivro AS l INNER JOIN tbautor AS a ON a.idAutor = l.idAutor";
    $sql .= " WHERE " . implode(" AND ", $condicoes);
    $sql .= " ORDER BY :ordem";
  
    $prepare = $this->conn->prepare($sql);

    $pesquisa  ? $prepare->bindParam(':pesquisa', $pesquisa, PDO::PARAM_STR) : '';
    $categoria ? $prepare->bindParam(':idCategoria', $categoria, PDO::PARAM_INT) : '';
    $pais      ? $prepare->bindParam(':idPais', $pais, PDO::PARAM_INT) : '';
    $prepare->bindParam(':dataMenor', $dataMenor, PDO::PARAM_INT);
    $prepare->bindParam(':dataMaior', $dataMaior, PDO::PARAM_INT);
    $prepare->bindParam(':ordem', $ordem, PDO::PARAM_STR);

    try {
      $prepare->execute();
      $result = $prepare->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $erro) {
      echo "Erro ao executar a consulta: " . $erro->getMessage();
      exit();
    }

    return $result;
  }

  public function cadastrarLivro($titulo, $data, $autor, $pais, $idCategoria, $user) {
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
      $pais = $this->cadastrarAutorPais("autor", $pais);
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

    return true;
  }

  private function cadastrarAutorPais($tabela, $campo) {
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

//var_dump($conn->selecionarTodos('usuario'))
?>