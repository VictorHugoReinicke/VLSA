<?php
function Acoes($usuario, $cad, $conf_senha, $acao, $foto)
{
    $resultado = "";
    switch ($acao) {
        case 'Criar Conta':
            if ($cad === null) {
                if (password_verify($conf_senha, $usuario->getSenha())) {
                    $resultado = $usuario->incluir();
                }
            }
            if (!$resultado) {
                header('location:../asset/cad.php?acao=user_name');
                return;
            }
            header('location:../asset/cad.php?acao=contaC');
            break;

        case 'excluir':
            $resultado = $usuario->excluir();
            if (!$resultado) {
                header('location:../asset/cad.php?acao=loginE');
                return;
            }
            header('location:../asset/cad.php?acao=loginC');
            break;

        case 'Salvar':
            if (password_verify($conf_senha, $usuario->getSenha())) {
                $resultado = $usuario->alterar();
                if ($resultado)
                    header('location:../asset/cad.php?acao=alterado');
            }
            break;

        case 'fotos':
            if (!isset($_SESSION['user'])) {
                session_start();
            }
            $resultado = $foto->incluir($_SESSION['user']);
            if ($resultado)
                header('location:../asset/perfil.php');
            break;

        case 'login':
            $nome_usuario = isset($_POST['usuario']) ? $_POST['usuario'] : "";
            $user = Usuario::login($nome_usuario);
            if ($user === null) {
                header('location:../asset/login.php?acao=loginI');
                return;
            }
            foreach ($user as $u) {
                password_verify($usuario->getSenha(), $u['senha']);
                if ($u['nome_usuario'] != $nome_usuario || !password_verify($usuario->getSenha(), $u['senha'])) {
                    echo "Senha incorreta<br>";
                    session_start();
                    session_destroy();
                    header('location:../asset/login.php?acao=loginE');
                    return;
                }
                echo "Senha correta<br>";
                session_start();
                $_SESSION['user'] = $u['idUsuario'];
                $sessionData = [
                    "userId" => $_SESSION["user"],
                    "id" => '-1',
                    "flag" => "iniciando"
                ];
                $serializedData = json_encode($sessionData);
                $filePath = '../postagem/session_data.json';
                file_put_contents($filePath, $serializedData);
                header('location:../asset/login.php?acao=loginC');
            }
            break;

        case 'logout':
            session_start();
            session_destroy();
            header('location:../asset/login.php');
            break;
    }
}
function AcoesPost($postagem, $acao, $id_post_1, $id_post_2)
{
    $resultado = "";

    switch ($acao) {
        case 'Salvar':
            $resultado = $postagem->incluir();
            if (!$resultado) {
                echo "Erro ao inserir dados!";
                return;
            }
            header("location:python.php?resultado=$resultado");
            break;

        case 'alterarNome':
            $resultado = $postagem->alterar();
            if (!$resultado) {
                echo "Erro ao inserir dados!";
                return;
            }
            header('location:../asset/hist.php');
            break;
        case 'excluir':
            $resultado = $postagem->excluir();
            if (!$resultado) {
                echo "Não foi possível excluir";
                return;
            }
            header('location:../asset/hist.php');
            break;
        case 'comparacao':

            json($id_post_1, $id_post_2);
            $outputDash = shell_exec('streamlit run ../postagem/scripts/comparacao.py');

            if ($outputDash === false) {
                echo "Erro no script";
                return;
            }

            echo $outputDash;

            break;
    }
}

function json($id_post_1 = 0, $id_post_2 = 0)
{
    $filePath = '../postagem/id_comparacao.json';
    $jsonData = file_get_contents($filePath);
    if (!$jsonData) {
        echo "Erro ao ler o arquivo JSON: $filePath";
        return;
    }
    $sessionData = json_decode($jsonData, true);

    $sessionData['id1'] = $id_post_1;
    $sessionData['id2'] = $id_post_2;

    $updatedJsonData = json_encode($sessionData, JSON_PRETTY_PRINT);

    if (!file_put_contents($filePath, $updatedJsonData)) {
        echo "Erro ao escrever no arquivo JSON: $filePath";
        return;
    }
    echo "JSON atualizado com sucesso.\n";
}
