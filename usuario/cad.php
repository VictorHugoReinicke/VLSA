<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.19/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/cad.css">

    <?php
    include_once "./back.php";

    ?>

    <title>CADASTRO</title>
</head>

<body>
    <div class="header fixed-top py-2"></div>
    <div class="container-fluid align-items-center">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <section class="col-12 col-sm-10">
                <form class="form-container" id="cadForm" action="back.php" method="post" enctype="multipart/form-data">
                    <h4 class="text-center mt-3">CADASTRO</h4>
                    <div class="row justify-content-center mt-4">
                        <div class="col-5">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control inputs required" id="nome" name="nome" placeholder="" value="<?php if (isset($user)) echo $user->getNome() ?>">
                        </div>
                        <div class="col-5">
                            <label for="usuario" class="form-label">Nome de Usuário</label>
                            <input type="text" class="form-control inputs required" id="usuario" name="usuario" placeholder="" value="<?php if (isset($user)) echo $user->getUsuario() ?>">
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-5">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control inputs required" id="cpf" name="cpf" onkeypress="$(this).mask('000.000.000-00')" placeholder="" value="<?php if (isset($user)) echo $user->getCpf() ?>">
                        </div>
                        <div class="col-5">
                            <label for="rg" class="form-label">RG</label>
                            <input type="text" class="form-control inputs required" id="rg" name="rg" onkeypress="$(this).mask('0.000.000')" placeholder="" value="<?php if (isset($user)) echo $user->getRg() ?>">
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-5">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control input-email inputs required" id="email" name="email" placeholder="" value="<?php if (isset($user)) echo $user->getEmail() ?>">
                        </div>
                        <div class="col-5">
                            <input type="hidden" class="form-control input-email inputs required" id="email1" name="email1" placeholder="">
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-5">
                            <label for="senhaCAD" class="form-label">Senha</label>
                            <input type="password" class="form-control inputs required" id="senhaCAD" name="senha" placeholder="" value="<?php if (isset($user)) echo $user->getSenha() ?>">
                            <label for="mostrar2" class="bi bi-eye-slash" id="eye-slash"></label>
                            <input type="checkbox" name="mostrar2" id="mostrar2" class="d-none" onclick="mostrars()">
                            <label for="mostrar2" class="bi bi-eye" id="eye"></label>
                        </div>
                        <div class="col-5">
                            <label for="confirmasenhaCAD" class="form-label">Confirmar Senha</label>
                            <input type="password" class="form-control inputs required" id="confirmasenhaCAD" name="confirmasenha" placeholder="">
                            <label for="mostrar" class="bi bi-eye-slash" id="eye-slash"></label>
                            <input type="checkbox" name="mostrar" id="mostrar" class="d-none" onclick="mostrarC()">
                            <label for="mostrar" class="bi bi-eye" id="eye"></label>
                        </div>
                        <div class="col-5">
                            <input type="file" class="form-control inputs required" id="addFoto" name="addFoto" placeholder="" hidden accept="image/*">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="d-grid gap-2 col-4 mx-auto pb-4 mt-3">
                            <input type="submit" class="btn btn-outline-primary" name="acao" id="acao" value="<?php if (isset($user)) echo "Salvar";
                                                                                                                else echo "Criar Conta"; ?>">
                        </div>
                    </div>
                    <div class="row justify-content-center" id="link">
                        <div class="col-4">
                            <p class="text-center">Já tem uma conta? <a href="login.php">Entrar</a></p>
                        </div>
                    </div>
                    <?php
                    if ($id != 0) {
                        echo "<input type='text' name='foto' id='foto' value='" .  $user->getImagem() . "' hidden>";
                    }
                    ?>
                    <input type="text" class="form-control inputs required" id="idUsuarios" name="idUsuarios" placeholder="" hidden value="<?= isset($user) ? $user->getId() : 0 ?>">
                </form>
            </section>
        </div>
    </div>
    <div class="footer fixed-bottom py-2"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Carregar jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.19/dist/sweetalert2.all.min.js"></script>
    <script src="../usuario/js/jQuery-Mask/dist/jquery.mask.min.js"></script>
    <script src="../usuario/js/validationcad.js"></script>
    <script src="../usuario/js/jquery.validate.min.js"></script>
    <script src="../usuario/js/additional-methods.js"></script>
    <script src="../usuario/js/localization/messages_pt_BR.js"></script>
    <script src="../usuario/js/cadvalid.js"></script>
    <?= include "./backjs.php" ?>

</body>

</html>