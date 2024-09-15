<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <link rel="stylesheet" href="./css/link.css">
  <link rel="stylesheet" href="./css/foot.css">
  <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
  <title>Inserir Link</title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: ../../asset/login.php");
}
include "navbar.php";
include "footer.php";
include_once "../postagem/backPost.php";

?>

<body>

  <div class="container-fluid align-items-center ">
    <div class="row justify-content-center align-items-center " style="height: 80vh;">
      <section class="col-12 col-sm-8  ">
        <form class="form-container" action="../postagem/backPost.php" method="post" id="indexForm">
          <h4 class="text-center mt-3">INSERIR LINK</h4>
          <div class="row justify-content-center mt-5 ">
            <div class="col-5">
              <label for="user" class="form-label">Nome de Usuário / Email do Instagram </label>
              <input type="text" class="form-control" id="user" name="user" placeholder="" value="<?php if (isset($post)) echo $post->getEmail() ?>">
            </div>
            <div class="col-5">
              <label for="pass" class="form-label">Senha da sua Conta no Instagram</label>
              <input type="password" class="form-control" id="pass" name="pass" placeholder="" value="<?php if (isset($post)) echo $post->getSenha() ?>">
              <label for="mostrar" class="bi bi-eye-slash" id="eye-slash"></label>
              <input type="checkbox" name="mostrar" id="mostrar" class="d-none" onclick="mostrarp()">
              <label for="mostrar" class="bi bi-eye" id="eye"></label>
            </div>
          </div>

          <div class="row justify-content-center mt-4 ">
            <div class="col-5">
              <label for="nome" class="form-label">Nomear postagem </label>
              <input type="text" class="form-control" id="nome" name="nome" placeholder="" value="<?php if (isset($post)) echo $post->getNomePost() ?>">
            </div>


            <div class="col-5">
              <label for="link" class="form-label">Link da postagem </label>
              <input type="text" class="form-control" id="link" name="link" placeholder="" value="<?php if (isset($post)) echo $post->getLink() ?>">
            </div>
          </div>
          <input type="text" name="idusu" id="idusu" value="<?= $_SESSION['user'] ?>" hidden value="<?php if (isset($post)) echo $post->getIdUsu() ?>">
          <input type="text" name="idpost" id="idpost" value="<?php if (isset($post)) echo $post->getIdPost(); ?>" hidden readonly>
          <div class="row mt-3">
            <div class="d-grid gap-2 col-6 mx-auto pb-4 mt-3">
              <button type="submit" class="btn btn-outline-primary" onclick="makeRequest()" name="acao" id="acao" value="<?php if (isset($post)) echo "Alterar";
                                                                                                                          else echo "Salvar"; ?>">Analisar</button>
            </div>
          </div>

          <div id="loader" style="display: none;">
            <div class="d-flex justify-content-center">
              <div class="row">
                <h6><strong>Carregando </strong></h6>
              </div>
            </div>
            <div class="d-flex justify-content-center" style="display: none;">
              <div class="row">
                <div class="spinner-border" role="status">
                  <span class="sr-only"></span>
                </div>
              </div>

            </div>
          </div>

        </form>
      </section>
    </div>
  </div>
  </div>
  <script src="./js/validationcad.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Carregar jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.19/dist/sweetalert2.all.min.js"></script>
  <script src="./js/jquery.validate.min.js"></script>
  <script src="./js/additional-methods.js"></script>
  <script src="./js/localization/messages_pt_BR.js"></script>
  <script src="./js/indexvalid.js"></script>
  <script>
    function makeRequest() {
      if (VoidForm()) {
        
        fetch('../postagem/session_data.json?nocache=' + new Date().getTime())
          .then(response => {
            if (response.status === 200) {
              response.json().then(data => {
                successField = data.flag;
                switch (successField) {
                  case 'success':
                    console.log(successField);
                    updateLoaderMessage("Carregando: Análise feita");

                    setTimeout(() => {
                      console.log("Recarregando a página...");
                      stopLoader();
                      location.reload();
                    }, 5000);
                    break;

                  case 'Acessando o perfil':
                    console.log(successField);
                    updateLoaderMessage("Carregando: Acessando perfil");
                    showLoader();
                    setTimeout(makeRequest, 1000);
                    break;

                  case 'Postagem encontrada':
                    console.log(successField);
                    updateLoaderMessage("Carregando: Postagem encontrada");
                    showLoader();
                    setTimeout(makeRequest, 1000);
                    break;

                  default:
                    console.log(successField);
                    updateLoaderMessage("Carregando");
                    showLoader();
                    setTimeout(makeRequest, 1000);
                    break;
                }
              });
            } else {
              updateLoaderMessage("Erro ao obter resposta do servidor");
              setTimeout(makeRequest, 1000);
            }
          })
          .catch(error => {
            updateLoaderMessage("Carregando: Erro ao ler o arquivo");
            console.error('Erro ao ler o arquivo:', error);
          });
      }

      function updatePage(data) {
        const myComponent = document.getElementById('loader');
        myComponent.dataset.value = data.someProperty;
      }

      function showLoader() {
        document.getElementById('loader').style.display = 'block';
        desabilitarBtt();
      }

      function stopLoader() {
        document.getElementById('loader').style.display = 'none';
      }

      function updateLoaderMessage(message) {
        const loaderDiv = document.getElementById('loader');
        loaderDiv.innerHTML = `
    <div class="d-flex justify-content-center">
      <div class="row">
        <h6><strong>${message}</strong></h6>
      </div>
    </div>
    <div class="d-flex justify-content-center">
      <div class="row">
        <div class="spinner-border" role="status">
          <span class="sr-only"></span>
        </div>
      </div>
    </div>
  `;
      }
    }

    function desabilitarBtt() {
      const user = document.getElementById('user');
      const pass = document.getElementById('pass');
      const nome = document.getElementById('nome');
      const link = document.getElementById('link');
      const bt1 = document.getElementById('acao');
      if (bt1) {
        bt1.disabled = true;
        user.disabled = true;
        pass.disabled = true;
        nome.disabled = true;
        link.disabled = true;
      }
    }

    function VoidForm() {
      const user = document.getElementById('user');
      const pass = document.getElementById('pass');
      const nome = document.getElementById('nome');
      const link = document.getElementById('link');

      if (!user.value.trim())
        return false;
      else if (!pass.value.trim())
        return false;
      else if (!nome.value.trim())
        return false;
      else if (!link.value.trim())
        return false;

      else
        return true;

    }
  </script>
</body>

</html>