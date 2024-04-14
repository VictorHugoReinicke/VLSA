<?php
require_once("../classes/Postagem.class.php");
require_once("../classes/Database.class.php");

$conexao = Database::getInstance();

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['idpost']) ? $_POST['idpost'] : 0;
    $nomePost = isset($_POST['nome']) ? $_POST['nome'] : "";
    $usuario = isset($_POST['user']) ? $_POST['user'] : "";
    $senha = isset($_POST['pass']) ? $_POST['pass'] : "";
    $link = isset($_POST['link']) ? $_POST['link'] : "";
    $idusu = isset($_POST['idusu']) ? $_POST['idusu'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;

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
    switch ($acao) {
        case 'Salvar':
            if ($id > 0) {
                $resultado = $postagem->alterar($conexao);
            } else {
                $resultado = $postagem->incluir($conexao);
            }
            break;
        case 'excluir':
            $resultado = $postagem->excluir($conexao);
            break;
    }

    if ($resultado) {
        // Executa o script testeS.py
        $outputTesteS = shell_exec('python ../postagem/testeS.py');
        if ($outputTesteS) {
            // Executa o script dash.py após o testeS.py
            $outputDash = shell_exec('streamlit run ../postagem/dash.py');
            if ($outputDash) {
                header('Location: python.php');
            } else {
                echo "Erro ao executar o script Dash.";
            }
        } else {
            echo "Erro ao executar o script testeS.";
        }
    } else {
        echo "Erro ao inserir dados!";
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : "";

    if ($busca != "") {
        $lista = Postagem::listar($busca);
    } else {
        $lista = Postagem::listarTodos();
    }
}
?>
