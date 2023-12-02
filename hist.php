<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <link rel="stylesheet" href="css/hist.css">
    <title>Histórico</title>
</head>
<?php

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
} elseif (!file_exists("usu.json")) {
    header("Location: login.php");
}
include "navbar.php";
include "link_tela.php";
include "acao_util.php";
?>

<body>

    <div class="container-fluid" style="margin: 0 auto;">
        <div class="row mx-auto justify-content-center">
            <section class="col-12 col-sm-12">
                <div class="col-8 form-container mt-4" style="background-color: white;transform: translateY(-50%);transform: translateX(20%);">
                    <div class="col-10 mx-auto">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <form action="" method="post">
                                    <div class="input-group mb-3">
                                        <div class="input-group-text" id="btnGroupAddon"><button class="btn btn-icon" type="submit" name="acao" id="acao" value="Pesquisar"><i class="bi bi-search"></i></button></div>
                                        <input type="text" class="form-control" name="pesquisa" id="pesquisa" placeholder="Pesquisar" aria-label="Pesquisar" aria-describedby="btnGroupAddon">
                                    </div>
                                </form>
                            </div>
                            <?php

                            function pesquisa()
                            {
                               
                                    $pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : "";
                                    if(file_exists("link.json"))
                                    $dados = json_decode(file_get_contents('link.json'), true);
                                    if(isset($dados))
                                    foreach ($dados as $item) {
                                        $itemName = $item['nome'];
                                        $itemLink = $item['link'];
                                        if ($_SESSION['user'] == $item['idusu'])
                                            if ($pesquisa === $item['nome']) {
                                                echo "<div class='col-2'>
                                            <div class='card' style='width: 18rem;'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>{$itemName}</h5>
                                                    <a href='{$itemLink}' class='card-link'>Link</a>
                                                </div>
                                            </div>
                                        </div><div class='col-2'></div>";
                                            }
                                    }
                                
                            }
                            
                                pesquisa();

                            ?>
                        </div>
                    </div>
                    <?php
                    if (file_exists("link.json"))
                        desenhar_tabela_link();
                    ?>
                </div>

            </section>
        </div>
    </div>
</body>

</html>