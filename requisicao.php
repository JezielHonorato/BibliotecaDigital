<?php

if (isset($_POST['sair'])) {
  echo "<script>alert('Foi SAir');</script>";
} elseif (isset($_POST['entrar'])) {
  echo "<script>alert('Foi entrar');</script>";
}
?>

<form action="requisicao.php" method="post"  name='sair'>
  <button type='submit' class='botao-submit color-alert'>Sair</button>
</form>

<form action="requisicao.php" method="post" name='entrar'>
  <button type='submit' class='botao-submit color-alert'>entrar</button>
</form>