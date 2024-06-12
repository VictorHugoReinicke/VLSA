<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./css/perfil.css">
  <title>Página de Perfil</title>
</head>

<body>

  <?php

  session_start();
  if (!isset($_SESSION["user"])) {
    header("Location: login.php");
  }

  include "./apresenta.php";
  include "navbar.php";
  ?>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <section class="col-12 col-sm-8">
        <div class="form-container mt-5" style='background-color:white'>
          <h4 class="text-center mt-3 mb-5">DADOS PESSOAIS</h4>
          <?php

          apresentarPerfil($listaUsuario);

          ?>
          <script src='./js/foto.js'></script>

      </section>
    </div>
  </div>

</body>

</html>