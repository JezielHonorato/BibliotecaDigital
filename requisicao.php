<?php

if (isset($_POST['sair'])) {
  session_start();
  session_destroy();
  header("Location: index.php");
}
?>
