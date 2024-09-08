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

        AcoesPost($postagem, $acao, $conexao, 0, 0);
    } catch (Exception $e) {
        header('Location:../asset/index.php?MSG=ERROR:' . $e->getMessage());
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : "";
    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
    $postagem = new Postagem($id);
    $id_post_1 = isset($_GET['id1']) ? $_GET['id1'] : 0;
    $id_post_2 = isset($_GET['id2']) ? $_GET['id2'] : 0;

    AcoesPost($postagem, $acao, $conexao, $id_post_1, $id_post_2);

}
