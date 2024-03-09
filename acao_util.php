<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>

<body>

</body>

</html>


<?php

define('USUARIO', 'root');
define('SENHA', '');
define('HOST', 'localhost');
define('PORT', '3306');
define('DB', 'vlsa');
define('DSN', 'mysql:host=' . HOST . ';port=' . PORT . ';dbname=' . DB . ';charset=UTF8');

$conexao  = new PDO(DSN, USUARIO, SENHA);

// function carregar($id)
// {
//     $json = ler_json(ARQUIVO_JSON);

//     foreach ($json as $key) {
//         if ($key->id === $id)
//             return (array) $key;
//     }
// }

// function alterar()
// {
//     $novo = altera();

//     $json = ler_json(ARQUIVO_JSON);

//     for ($x = 0; $x < count($json); $x++) {
//         if ($json[$x]->id === $novo['id']) {
//             array2json($novo, $json[$x]);
//         }
//     }

//     salvar_json(json_encode($json), ARQUIVO_JSON);

//     header("location:perfil.php");
// }
function excluir()
{
    $conexao  = new PDO(DSN, USUARIO, SENHA);
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    $sql = 'DELETE from pessoa WHERE id = :id';
    $comando = $conexao->prepare($sql); //preparar comando
    $comando->bindValue(':id', $id);
    header("location: login.php");
}
// /*
//  * Método salva alterações feitas em um registro
//  * @return void
//  */
function salvar($conexao)
{

    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : "";
    $senha = isset($_POST['senha']) ? $_POST['senha'] : "";
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : "";
    $rg = isset($_POST['rg']) ? $_POST['rg'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $foto = isset($_POST['foto']) ? $_POST['foto'] : "";
    $conf_senha = isset($_POST['confirmasenha']) ? $_POST['confirmasenha'] : "";

    $sql = 'INSERT INTO usuarios (Nome,Nome_usuario,Email,CPF,RG,Senha,Imagem) VALUES (:nome, :usuario, :email, :cpf, :rg, :senha, :foto)';
    $comando = $conexao->prepare($sql);
    $comando->bindValue(':nome', $nome);
    $comando->bindValue(':usuario', $usuario);
    $comando->bindValue(':email', $email);
    $comando->bindValue(':cpf', $cpf);
    $comando->bindValue(':rg', $rg);
    $comando->bindValue(':senha', $senha);
    $comando->bindValue(':foto', $foto);
    if ($senha == $conf_senha) {
        $comando->execute();
        header('Location: login.php');
    }
}

function login($conexao)
{
    $login = vallogin();


    $sql = "SELECT * from usuarios WHERE Nome_usuario = :usuario ";
    $comando = $conexao->prepare($sql); //preparar comando
    $comando->bindValue(':usuario', $login['usuario']);
    $comando->execute();

    $user = $comando->fetch();

    if ($user['Nome_usuario'] != $login['usuario'] || $login['senha'] != $user['Senha']) {
        header('Location: login.php');
    }
    session_start();
    $_SESSION['user'] = $user['idUsuarios'];
    header('Location: index.php');
}

function logout()
{
    session_start();
    session_destroy();
    header('Location:login.php');
}



// function fotos()
// {
//     $novo = tela2array();
//     $json = ler_json(ARQUIVO_JSON);
//     for ($x = 0; $x < count($json); $x++) {

//         if ($json[$x]->id === $novo['id']) {
//             $json[$x]->foto = $novo['foto'];
//             echo "novo";
//             echo $json[$x]->foto;
//         }
//     }

//     salvar_json(json_encode($json), ARQUIVO_JSON);

//     header("location:perfil.php");
// }

function linkurl()
{

    $json = NULL;
    $links = linksarray();
    $json = ler_json(ARQUIVO_JSON);

    if ($json == NULL) {
        $json = array();
    }

    array_push($json, $links);

    salvar_json(json_encode($json), ARQUIVO_JSON);
    header("location:" . DESTINO);
}
