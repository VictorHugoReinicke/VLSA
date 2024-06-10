<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="./css/login.css">

    <title>LOGIN</title>
</head>


<body>
    <div class="header fixed-top py-2"></div>

    <div class="container-fluid align-items-center">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">

            <section class="col-12 colsm-6 col-md-6  ">
                <form class="form-container" action="../usuario/back.php" method="post" id="loginForm">
                    <h2 class="text-center pt-3">LOGIN</h2>
                    <div class="row justify-content-center pt-3">
                        <div class="col-8">
                            <label for="usuario" class="form-label">Nome de Usuário</label>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <input type="text" class="form-control" name="usuario" id="usuario" placeholder="">
                        </div>
                    </div>

                    <div class="row justify-content-center pt-4">
                        <div class="col-8">
                            <label for="senha" class="form-label">Password</label>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-8">
                            <input type="password" id="senha" class="form-control" aria-describedby="passwordHelpBlock" name="senha">
                        </div>
                    </div>
                    <div class="row justify-content-end me-5 pe-4 pt-3" id="link">
                        <div class="col-4">
                            <a href="">
                                <p>Esqueceu a Senha? </p>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-grid gap-2 col-4 mx-auto pb-4 mt-3">
                            <button type="submit" class="btn btn-outline-primary" name="acao" id="acao" value="login" onclick="validacao()">Entrar</button>
                        </div>
                    </div>


                    <div class="row justify-content-center mt-3" id="link">
                        <div class="col-5">
                            <p class="text-center">Não possui login? <a class="" href="cad.php">
                                    Cadastre-se
                                </a></p>
                        </div>
                    </div>
                </form>
            </section>

        </div>

    </div>

    <div class="footer fixed-bottom py-2"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Carregar jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.19/dist/sweetalert2.all.min.js"></script>
    <script src="./js/validationcad.js"></script>
    <script src="./js/jquery.validate.min.js"></script>
    <script src="./js/additional-methods.js"></script>
    <script src="../js/localization/messages_pt_BR.js"></script>
    <script src="./js/loginvalid.js"></script>
    <?=
    include "../usuario/backjs.php"
    ?>
</body>

</html>