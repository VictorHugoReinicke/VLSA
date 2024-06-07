<?php
require_once("../classes/Postagem.class.php");
require_once("../classes/Database.class.php");

$conexao = Database::getInstance();

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
    } catch (Exception $e) {
        header('Location:index.php?MSG=ERROR:' . $e->getMessage());
    }

    $resultado = "";
    if ($acao == 'Salvar') {
        $resultado = $postagem->incluir($conexao);
    } elseif ($acao == "Alterar") {
        $resultado = $postagem->alterar($conexao);
        if ($resultado)
            header('location:../usuario/hist.php');
        exit;
    }
    if ($resultado) {
        echo "Inserção bem sucedida";
        header("location:python.php?resultado=$resultado");
    } else {
        echo "Erro ao inserir dados!";
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : "";
    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
    $postagem = new Postagem($id);
    if ($acao == "excluir" && $id > 0) {
        $postagem->excluir($conexao);
        header('location:../usuario/hist.php');
    }
}
