<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <link rel="stylesheet" href="css/cad.css">
    <?php
    include "usuario_acao.php";
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $dados = array();
    if ($id != 0)
        $dados = carregar($id);
    ?>
    <title>CADASTRO</title>
</head>

<body>
    <div class="header fixed-top py-2"></div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <section class="col-12 col-sm-10">
                <form class="form-container mt-5" id="cadForm" action="usuario_acao.php" method="POST" enctype="multipart/form-data">
                    <h4 class="text-center mt-3">CADASTRO</h4>
                    <div class="row justify-content-center mt-4 ">
                        <div class="col-5">

                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control inputs required" id="nome" name="nome" placeholder="" value="<?php if ($id != 0)
                                                                                                                                    echo $dados['Nome']; ?>">

                        </div>
                        <div class="col-5">
                            <label for="usuario" class="form-label">Nome de Usuário</label>
                            <input type="text" class="form-control inputs required" id="usuario" name="usuario" placeholder="" value="<?php if ($id != 0)
                                                                                                                                            echo $dados['Nome_usuario']; ?>">

                        </div>
                    </div>
                    <div class="row justify-content-center mt-3 ">
                        <div class="col-5">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control inputs required" id="cpf" name="cpf" placeholder="" value="<?php if ($id != 0)
                                                                                                                                    echo $dados['CPF']; ?>">

                        </div>
                        <div class="col-5">
                            <label for="rg" class="form-label">RG</label>
                            <input type="text" class="form-control inputs required" id="rg" name="rg" placeholder="" value="<?php if ($id != 0)
                                                                                                                                echo $dados['RG']; ?>">

                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-5">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control input-email inputs required" id="email" name="email" placeholder="" value="<?php if ($id != 0)
                                                                                                                                                    echo $dados['Email']; ?>">

                        </div>
                        <div class="col-5">
                            
                            <input type="hidden" class="form-control input-email inputs required" id="email1" name="email1" placeholder="">

                        </div>
                    </div>
                    <div class="row justify-content-center mt-4 ">
                        <div class="col-5">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control inputs required" id="senha" name="senha" placeholder="" value="<?php if ($id != 0)
                                                                                                                                            echo $dados['Senha']; ?>">

                        </div>
                        <div class="col-5">
                            <label for="confirmasenha" class="form-label">Confirmar Senha</label>
                            <input type="password" class="form-control inputs required" id="confirmasenha" name="confirmasenha" placeholder="">

                        </div>

                        <div class="col-5">
                            <input type="file" class="form-control inputs required" id="addFoto" name="addFoto" placeholder="" hidden accept="image/*">

                        </div>


                    </div>
                    <div class="row mt-3">
                        <div class="d-grid gap-2 col-4 mx-auto pb-4 mt-3">
                            <input type="submit" class="btn btn-outline-primary" name="acao" id="acao" value="<?php if ($id == 0)
                                                                                                                    echo "Criar Conta";
                                                                                                                else
                                                                                                                    echo "Alterar";
                                                                                                                ?>">

                        </div>
                    </div>
                    <div class="row justify-content-center" id="link">
                        <div class="col-4">
                            <p class="text-center">Já tem uma conta? <a href="login.php">Entrar</a></p>
                        </div>
                    </div>
                    <?php
                    if ($id != 0) {
                        echo "<input type='text' name='foto' id='foto' value='$dados[Imagem]' hidden>";
                    }

                    ?>
                    <input type="text" class="form-control inputs required" id="idUsuarios" name="idUsuarios" placeholder="" hidden value="<?= $id ?>">
                </form>
            </section>
        </div>
    </div>
</body>


<script src="validationcad.js"></script>

</html>