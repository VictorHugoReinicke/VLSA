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
?>

<body>

    <div class="container-fluid" style="margin: 0 auto;">
        <div class="row mx-auto justify-content-center">
            <section class="col-12 col-sm-12">
                <div class="col-8 form-container mt-4" style="background-color: white;transform: translateY(-50%);transform: translateX(20%);">
                    <div class="col-10 mx-auto">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <div class="input-group mb-3">

                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    desenhar_tabela_link();
                    ?>
                </div>

            </section>
        </div>
    </div>
</body>

</html>