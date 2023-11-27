<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/perfil.css">
  <title>Página de Perfil</title>
</head>

<body>

  <?php

  session_start();
  if (!isset($_SESSION["user"])) {
    header("Location: login.php");
  }

  include "usuario_tela.php";
  ?>

  <div class="header" id="header">
    <div class="logo_header">
      <img class="img_logo" src="img/vlsa logo.png" alt="Logo VLSA">
    </div>
    <div class="navigation_header">
      <a href="link.php">Inserir Link</a>
      <a href="hist.php">Histórico</a>
      <a class="active" href="perfil.php">Perfil</a>
    </div>
  </div>


  <div class="container-fluid">
    <div class="row justify-content-center">
      <section class="col-12 col-sm-8">
        <form class="form-container mt-5" action="analise.php" method="post">
          <h4 class="text-center mt-3 mb-5">DADOS PESSOAIS</h4>
         
            <?= desenhar_tabela_usuario() ?>
     
      

        </form>
        
       

</section>
  </div>
  </div>

</body>

</html>