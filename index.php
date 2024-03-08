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
elseif(!file_exists("usu.json"))
{
  header("Location: login.php");
}
 include "navbar.php";

?>
<body>

  <div class="container-fluid align-items-center">
    <div class="row justify-content-center ">
      <section class="col-12 col-sm-8 mt-5 align-items-center">
        <form class="form-container" action="link_acao.php" method="post">
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
          <input type="text" name="idusu" id="idusus" value="<?= $_SESSION['user'] ?>" hidden>
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