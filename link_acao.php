<?php
define("DESTINO", "index.php");
define("ARQUIVO_JSON", "link.json");
include "acao_util.php";

$acao = "";
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
        break;
    case 'POST':
        $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
        break;
}

switch ($acao) {
    case 'Salvar':
        linkurl();
        break;
    // case 'Alterar':
    //     alterar();
    //     break;
    case 'excluir':
        excluir();
        break;
}