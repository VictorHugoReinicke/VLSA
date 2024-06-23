<?php

require_once(__DIR__ . '/../classes/Postagem.class.php'); //  Postagem class
require_once(__DIR__ . '/../classes/Database.class.php'); // Database class

$conexao = Database::getInstance();
include(__DIR__ . '/../funcoesControll.php');

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

if ($id > 0) // verificará se o id é maior que 0, caso a verificação estiver correta, irá:
{
    $post = Postagem::Dados($id); //atribuirá esse novo objeto à um array, com a função de listar
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['idpost']) ? $_POST['idpost'] : 0;
    $nomePost = isset($_POST['nome']) ? $_POST['nome'] : "";
    $usuario = isset($_POST['user']) ? $_POST['user'] : "";
    $senha = isset($_POST['pass']) ? $_POST['pass'] : "";
    $link = isset($_POST['link']) ? $_POST['link'] : "";
    $idusu = isset($_POST['idusu']) ? $_POST['idusu'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;
    if ($acao != "adcAcc") {
        if (strpos($link, '?next=%2F') === false) {
            $link .= '?next=%2F';
        }
        try {
            $postagem = new Postagem(
                $id,
                $nomePost,
                $link,
                $idusu,
                $usuario,
                $senha
            );
        } catch (Exception $e) {
            header('Location:../asset/index.php?MSG=ERROR:' . $e->getMessage());
        }
        AcoesPost($postagem, $acao, $conexao);
    } else {
        try {
            $postagem = new Postagem(
                $id,
                $nomePost,
                $link,
                $idusu,
                $usuario,
                $senha
            );
        } catch (Exception $e) {
            header('Location:../asset/index.php?MSG=ERROR:' . $e->getMessage());
        }
        AcoesPost($postagem, $acao, $conexao);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : "";
    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
    $postagem = new Postagem($id);
    if ($acao == "excluir" && $id > 0) {
        $postagem->excluir($conexao);
        header('location:../asset/hist.php');
    }

    if ($acao == "comparacao") {
        $id_post_1 = isset($_GET['id1']) ? $_GET['id1'] : 0;
        $id_post_2 = isset($_GET['id2']) ? $_GET['id2'] : 0;
        $filePath = '../postagem/id_comparacao.json';
        $jsonData = file_get_contents($filePath);
        if ($jsonData) {
            $sessionData = json_decode($jsonData, true);
        } else {
            echo "Erro ao ler o arquivo JSON: $filePath";
            exit;
        }

        $sessionData['id1'] = $id_post_1;
        $sessionData['id2'] = $id_post_2;
        $updatedJsonData = json_encode($sessionData, JSON_PRETTY_PRINT);

        if (file_put_contents($filePath, $updatedJsonData)) {
            echo "JSON atualizado com sucesso.\n";
        } else {
            echo "Erro ao escrever no arquivo JSON: $filePath";
            exit;
        }

        $outputDash = shell_exec('streamlit run ../postagem/scripts/comparacao.py');

        if ($outputDash === false) {
            echo "Erro no script";
            exit;
        }

        echo $outputDash;
    }
}
