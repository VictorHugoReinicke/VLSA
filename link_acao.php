<?php
include "json_util.php";
define("DESTINO", "link.php");
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
        salvar();
        links();
        break;
    case 'Alterar':
        alterar();
        break;
    case 'excluir':
        excluir();
        break;
}

function tela2array()
{
    $novo = array(
        'id' => isset($_POST['id']) ? $_POST['id'] : date("YmdHis"),
        'nome' => isset($_POST['nome']) ? $_POST['nome'] : "",
        'link' => isset($_POST['link']) ? $_POST['link'] : "",
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

    return $json_dados;
}

function links()
{

    $teste = shell_exec("C:\BecrowdCrawler-master\acessoinsta.py");


}


?>