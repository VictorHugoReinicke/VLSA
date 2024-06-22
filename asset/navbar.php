<?php
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

$url = $_SERVER["REQUEST_URI"];
$ativo = "";
if (strpos($url, "hist") !== false) {
    $ativo = "Histórico";
} elseif (strpos($url, "perfil") !== false) {
    $ativo = "Perfil";
} elseif (strpos($url, "index") !== false)
    $ativo = "Link";

?>
<div class="header" id="header">
    <section class="col-2 order-0">
        <div class="row justify-content-start">
            <div class="col-auto logo_header">
                <img class="img_logo" src="./img/vlsaLogo.png" alt="Logo VLSA">
            </div>
        </div>
    </section>
    <section class="col-7 justify-content-center order-1 ms-5">
        <div class="row justify-content-center">
            <div class="col navigation_header d-flex justify-content-center">
                <a <?php if ($ativo == "Link") echo "class='active'" ?> href="index.php">Inserir Link</a>
                <a <?php if ($ativo == "Histórico") echo "class='active'" ?> href="hist.php">Histórico</a>
                <a <?php if ($ativo == "Perfil") echo "class='active'" ?> href="perfil.php">Perfil</a>
            </div>
        </div>
    </section>
</div>