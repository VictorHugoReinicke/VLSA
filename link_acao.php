<?php
include "json_util.php";
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
    case 'Alterar':
        alterar();
        break;
    case 'excluir':
        excluir();
        break;
}

function linksarray()
{
    $novo = array(
        'id' => isset($_POST['id']) ? $_POST['id'] : date("YmdHis"),
        'nome' => isset($_POST['nome']) ? $_POST['nome'] : "",
        'link' => isset($_POST['link']) ? $_POST['link'] : "",
        'idusu' => isset($_POST['idusu']) ? $_POST['idusu'] : "",
    );

    if ($novo['id'] == "0") {
        $novo['id'] = date("YmdHis");
    }

    return $novo;
}

function array2json($array_dados, $json_dados)
{
    $json_dados->id = $array_dados['id'];
    $json_dados->nome = $array_dados['nome'];
    $json_dados->link = $array_dados['link'];
    $json_dados->idusu = $array_dados['idusu'];

    return $json_dados;
}

