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
    <link rel="stylesheet" href="./css/foot.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">

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
    include "footer.php";
    require_once("../classes/Postagem.class.php");
    ?>

    <div class="container-fluid" style="margin: 0 auto;">
        <div class="row justify-content-center">
            <section class="col-12 col-sm-12">
                <div class="col-8 form-container mt-4 mx-auto" style="background-color: white">
                    <div class="col-10 mx-auto">



                        <form action="" method="get">
                            <div class="row justify-content-between">
                                <div class="col-5">
                                    <div class="input-group mb-3">
                                        <div class="input-group-text" id="btnGroupAddon">
                                            <button class="btn btn-icon" type="submit"><i class="bi bi-search"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="pesquisa" id="pesquisa" placeholder="Pesquisar" aria-label="Pesquisar" aria-describedby="btnGroupAddon">
                                    </div>

                                </div>
                                <div class="col-3 ">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Organizar
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="?organizar=0"> Ordem de postagem </a></li>
                                            <li><a class="dropdown-item" href="?organizar=1"> A-Z </a></li>
                                            <li><a class="dropdown-item" href="?organizar=2">Número de comentários</a></li>
                                            <li><a class="dropdown-item" href="?organizar=3">Mais positivo</a></li>
                                            <li><a class="dropdown-item" href="?organizar=4">Mais negativo</a></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </form>

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
                                                    <h5 class='card-title mt-3' id='NomePost'>" . $postagem->getNomePost() . "</h5>
                                                    <a href='../postagem/post.php?acao=view&id=" . $postagem->getIdPost() . "' class='card-link' onclick='recarregarPag()'>Clique para ver a análise</a>
                                                </div>
                                                <div class='dropdown'>
                                                    <button class='btn btn-outline-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                        <i class='bi bi-three-dots-vertical'></i>
                                                    </button>
                                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                        <a class='dropdown-item' href='javascript:excluirRegistro(\"../postagem/backPost.php?acao=excluir&id=" . $postagem->getIdPost() . "\")'>Excluir</a>
                                                        <a class='dropdown-item' id='" . $postagem->getIdPost() . "'>Renomear</a>
                                                        <a class='dropdown-item' onclick='mostrarElementos(" . $postagem->getIdPost() . ");recarregarPag()'>Comparar</a>
                                                    </div>
                                                    <input type='text' name='idusu' id='idusu' value='" . $postagem->getIdUsu() . "' hidden>
                                                    <input type='text' name='link' id='link' value='" . $postagem->getLink() . "' hidden>
                                                    <input type='text' name='pass' id='pass' value='" . $postagem->getSenha() . "' hidden>
                                                    <input type='text' name='user' id='user' value='" . $postagem->getEmail() . "' hidden>
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
                        }

                        if ($contador > 0) {
                            echo "<div class='row mt-4'>{$html}</div>";
                        }
                        ?>
                    </div>
                </div>
        </div>
        <div id='elementosComparacao' class='escondido fixed-bottom'>
            <button id='btnCancelar' class="btn btn-light" onclick='cancelarComparacao()'>Cancelar</button>
            <button id='btnComparar' class="btn btn-light" onclick='compararItens()'>Comparar</button>
        </div>
        </section>
    </div>
    </div>
</body>
<script>
    function recarregarPag() {
        setTimeout(() => {
            console.log("Recarregando a página...");
            location.reload();
        }, 2000);
    }
</script>
<script src="./js/comparar.js"></script>
<script src="./js/alterarNome.js"></script>

</html>