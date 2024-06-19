<?php
function Acoes($usuario, $acao, $senha, $conf_senha, $foto, $cad)
{
    $resultado = "";
    switch ($acao) {
        case 'Criar Conta':
            if ($cad === null) {
                if ($senha == $conf_senha) {
                    $resultado = $usuario->incluir();
                    if ($resultado) {
                        header('location:../front/cad.php?acao=contaC');
                    }
                }
            }
            break;

        case 'excluir':
            $resultado = $usuario->excluir();
            if ($resultado) {
                header('location:../front/cad.php?acao=loginC');
            } else {
                header('location:../front/cad.php?acao=loginE');
            }
            break;

        case 'Salvar':
            if ($senha == $conf_senha) {
                $resultado = $usuario->alterar();
                if ($resultado) {
                    header('location:../front/cad.php?acao=alterado');
                }
            }
            break;

        case 'fotos':
            if (!isset($_SESSION['user'])) {
                session_start();
            }
            $resultado = $foto->incluir($_SESSION['user']);
            if ($resultado)
                header('location:../front/perfil.php');
            break;
    }
}
function Login($user, $nome_usuario, $senha_login)
{
    foreach ($user as $u) {
        if ($u['nome_usuario'] != $nome_usuario || $u['senha'] != $senha_login) {
            session_start();
            session_destroy();
            header('location:../front/login.php?acao=loginE');
        } else {
            session_start();
            $_SESSION['user'] = $u['idUsuario'];
            $sessionData = [
                "userId" => $_SESSION["user"], "id" => '-1'
            ];
            $serializedData = json_encode($sessionData);
            $filePath = '../postagem/session_data.json';
            file_put_contents($filePath, $serializedData);
            header('location:../front/login.php?acao=loginC');
        }
    }
}

function AcoesPost($postagem, $acao, $conexao)
{
    $resultado = "";
    if ($acao == 'Salvar') {
        $resultado = $postagem->incluir($conexao);
    } elseif ($acao == "alterarNome") {
        $resultado = $postagem->alterar($conexao);
        if ($resultado)
            header('location:../front/hist.php');
        exit;
    }
    if ($resultado) {
        echo "Inserção bem sucedida";
        header("location:python.php?resultado=$resultado");
    } else {
        echo "Erro ao inserir dados!";
    }
}