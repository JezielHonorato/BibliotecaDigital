<?php
  session_start();

  require_once("objeto.php");
  !isset($_COOKIE['tema']) ? setcookie('tema', 'day', time() + 24 * 60 * 60) : '';

  $user  = isset($_SESSION['usuario']) ? $_SESSION['usuario'][0] : false;
  $nivel = isset($_SESSION['usuario']) ? $_SESSION['usuario'][1] : false;

?>

<!DOCTYPE html>
<html lang='pt-br'>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Biblioteca Digital</title>
  <link rel='shortcut icon' href='./image/logo.ico' />
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200' />
  <script src='main.js' defer></script>
</head>

<body class="<?= $_COOKIE['tema'] ?? 'day'?>">
  <div id='inicio'></div>
  <header>
    <a href='./index.php' class='logo-header'> <img src='./image/logo.png' alt='Logo pequena, 3 Livros amarelos empilhados'></a>
    <nav>
      <a href='./index.php'>Home</a>
      <a href='./livros.php'>Livros</a>
      <?php if ($user) {
        echo "<a href='./cadastrar.php'>Cadastrar</a>";
      } ?>
      <a href='./login.php'>Login</a>
    </nav>
    <a href='./livros.php'><i>search</i></a>
  </header>