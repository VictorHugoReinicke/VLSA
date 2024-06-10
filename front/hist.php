<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> <!-- Adicionando a biblioteca SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <link rel="stylesheet" href="./css/hist.css">
    <title>Histórico</title>
    <script>
        function excluirRegistro(url) {
            Swal.fire({ // Utilizando o SweetAlert para a confirmação
                title: 'Tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = url; // Redirecionando para a URL de exclusão
                }
            });
        }
    </script>
    <style>
        .escondido {
            display: none;
        }
    </style>
</head>

<body>

    <?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
    }

    include "navbar.php";
    include "./apresenta.php";
    require_once("../classes/Postagem.class.php");
    ?>

    <div class="container-fluid" style="margin: 0 auto;">
        <div class="row mx-auto justify-content-center">
            <section class="col-12 col-sm-12">
                <div class="col-8 form-container mt-4" style="background-color: white;transform: translateY(-50%);transform: translateX(20%);">
                    <div class="col-10 mx-auto">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <form action="" method="get">
                                    <div class="input-group mb-3">
                                        <div class="input-group-text" id="btnGroupAddon">
                                            <button class="btn btn-icon" type="submit"><i class="bi bi-search"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="pesquisa" id="pesquisa" placeholder="Pesquisar" aria-label="Pesquisar" aria-describedby="btnGroupAddon">
                                    </div>
                                </form>
                            </div>
                            <?php
                            $colunas = 3;
                            $html = "";
                            $contador = 0;
                            foreach ($lista as $postagem) {
                                $imagem = $postagem->getImgPost();
                                if ($imagem) {
                                    $html .= "<div class='col-4'  id='item-" . $postagem->getIdPost() . "'>
                                        <div class='card'>
                                            <img src='../postagem/" . $postagem->getImgPost() . "' alt=''>
                                            <div class='card-footer d-flex justify-content-between align-items-center'>
                                                <div>
                                                    <h5 class='card-title mt-3'>" . $postagem->getNomePost() . "</h5>
                                                    <a href='../postagem/post.php?acao=view&id=" . $postagem->getIdPost() . "' class='card-link'>Clique para ver a análise</a>
                                                </div>
                                                <div class='dropdown'>
                                                    <button class='btn btn-outline-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                        <i class='bi bi-three-dots-vertical'></i>
                                                    </button>
                                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                        <a class='dropdown-item' href='javascript:excluirRegistro(\"../postagem/backPost.php?acao=excluir&id=" . $postagem->getIdPost() . "\")'>Excluir</a>
                                                        <a class='dropdown-item' href='./index.php?id=" . $postagem->getIdPost() . "'>Alterar Postagem</a>
                                                        <a class='dropdown-item' onclick='mostrarElementos(" . $postagem->getIdPost() . ")'>Comparar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                                    $contador++;
                                    if ($contador % $colunas === 0) {
                                        echo "<div class='row mt-4'>{$html}</div>";
                                        $html = "";
                                    }
                                }
                                elseif($postagem ->getIdUsu())
                                echo "<h2>Ainda não temos nada por aqui!</h2>";
                            }
                            if ($contador > 0) {
                                echo "<div class='row mt-4'>{$html}</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div id='elementosComparacao' class='escondido'>
                    <button id='btnCancelar' onclick='cancelarComparacao()'>Cancelar</button>
                    <button id='btnComparar' onclick='compararItens()'>Comparar</button>
                </div>
            </section>
        </div>
    </div>
</body>
<script src="./js/comparar.js"></script>

</html>