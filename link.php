<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <link rel="stylesheet" href="css/link.css">
  <title>Inserir Link</title>
</head>
<?php


session_start();
if (!isset($_SESSION["user"])) {        
    header("Location: login.php");
}

?>
<body>
<div class="header" id="header">
    <section class="col-4 order-0">
    <div class="row justify-content-start">
    <div class="col-auto logo_header">
      <img class="img_logo" src="img/vlsa logo.png" alt="Logo VLSA">
    </div>
    </div>
    </section>
  <section class="col-3 order-1">
    <div class="row justify-content-center">
    <div class="col navigation_header d-flex justify-content-center">
  <a class="active" href="#">Inserir Link</a>
  <a href="hist.php">Histórico</a>
  <a href="perfil.php">Perfil</a>
</div>
    </div>
  </section>
</div>
  <div class="container-fluid">
    <div class="row justify-content-center ">
      <section class="col-12 col-sm-8">
        <form class="form-container mt-5" action="link_acao.php" method="post">
          <h4 class="text-center mt-3">INSERIR LINK</h4>
          <div class="row justify-content-center mt-4 ">
            <div class="col-8">
              <label for="nome" class="form-label">Nomear postagem </label>
              <input type="text" class="form-control" id="nome" name="nome" placeholder="">
            </div>
          </div>
          <div class="row justify-content-center mt-4 ">
            <div class="col-8">
              <label for="link" class="form-label">Link da postagem </label>
              <input type="text" class="form-control" id="link" name="link" placeholder="">
            </div>
          </div>
          <div class="row mt-3">
            <div class="d-grid gap-2 col-6 mx-auto pb-4 mt-3">
              <button type="submit" class="btn btn-outline-primary" name="acao" id="acao" value="Salvar">Analisar</button>
            </div>
          </div>
        </form>
      </section>
    </div>
  </div>
</body>

</html>