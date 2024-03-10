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


function carregar($id)
{
    $conexao  = new PDO(DSN, USUARIO, SENHA);
    $sql = "SELECT * from usuarios WHERE idUsuarios = :idUsuarios";
    $comando = $conexao->prepare($sql);
    $comando->bindValue(':idUsuarios', $id);

    $comando->execute();

    $resultado = $comando->fetch(PDO::FETCH_ASSOC);
    if ($resultado) {
        return $resultado;
    } else {
        return null;
    }
}



function alterar()
{
    $conexao = new PDO(DSN, USUARIO, SENHA);
    $user = isset($_POST['idUsuarios']) ? $_POST['idUsuarios'] : 0;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : "";
    $rg = isset($_POST['rg']) ? $_POST['rg'] : "";
    $senha = isset($_POST['senha']) ? $_POST['senha'] : "";
    $confSenha = isset($_POST['confirmasenha']) ? $_POST['confirmasenha'] : "";
    $foto = isset($_POST['foto']) ? $_POST['foto'] : "";

    if ($senha == $confSenha) {
        $sql = "UPDATE usuarios SET Nome = :nome, Nome_usuario = :usuario, Email = :email, CPF = :cpf, RG = :rg, Senha = :senha, Imagem = :foto WHERE idUsuarios = :id";

        $comando = $conexao->prepare($sql);
        $comando->bindValue(':nome', $nome);
        $comando->bindValue(':usuario', $usuario);
        $comando->bindValue(':email', $email);
        $comando->bindValue(':cpf', $cpf);
        $comando->bindValue(':rg', $rg);
        $comando->bindValue(':senha', $senha);
        $comando->bindValue(':foto', $foto);
        $comando->bindValue(':id', $user);

        $comando->execute();
        header('Location: perfil.php ');
    }


    // $novo = altera();

    // $json = ler_json(ARQUIVO_JSON);

    // for ($x = 0; $x < count($json); $x++) {
    //     if ($json[$x]->id === $novo['id']) {
    //         array2json($novo, $json[$x]);
    //     }
    // }

    // salvar_json(json_encode($json), ARQUIVO_JSON);

}
function excluir()
{
    $conexao  = new PDO(DSN, USUARIO, SENHA);
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    $sql = 'DELETE from usuarios WHERE id = :id';
    $comando = $conexao->prepare($sql); //preparar comando
    $comando->bindValue(':id', $id);
    header("location: login.php");
}
// /*
//  * Método salva alterações feitas em um registro
//  * @return void
//  */
function salvar()
{
    $conexao  = new PDO(DSN, USUARIO, SENHA);
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
    else
    header('Location:cad.php');
}

function login()
{
    $login = vallogin();
    $conexao  = new PDO(DSN, USUARIO, SENHA);
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

function fotos()
{
    $conexao = new PDO(DSN, USUARIO, SENHA);
    $user = isset($_POST['idUsuarios']) ? $_POST['idUsuarios'] : 0;

    // Obter informações da foto
    $foto = $_FILES['foto'];
    $nomeFoto = $foto['name'];
    $tipoFoto = $foto['type'];
    $tamanhoFoto = $foto['size'];
    $conteudoFoto = file_get_contents($foto['tmp_name']);

    // Montar a query SQL
    $sql = "UPDATE usuarios SET 
              Imagem = :foto, 
              Nome_imagem = :nome, 
              Tipo = :tipo, 
              Tamanho = :tamanho 
            WHERE idUsuarios = :id";

    // Preparar o comando e vincular os parâmetros
    $comando = $conexao->prepare($sql);
    $comando->bindValue(':foto', $conteudoFoto, PDO::PARAM_LOB);
    $comando->bindValue(':nome', $nomeFoto);
    $comando->bindValue(':tipo', $tipoFoto);
    $comando->bindValue(':tamanho', $tamanhoFoto);
    $comando->bindValue(':id', $user);

    // Executar o comando e redirecionar para o perfil
    $comando->execute();
    header("location:perfil.php");
}



function linkurl()
{
    $conexao  = new PDO(DSN, USUARIO, SENHA);
    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
    $link = isset($_POST['link']) ? $_POST['link'] : "";
    $idusuario = isset($_POST['idusu']) ? $_POST['idusu'] : "";

    $sql = 'INSERT INTO postagens (Nome_postagens,Link_postagens,idUsuarios) VALUES (:nome, :link, :idusu)';
    $comando = $conexao->prepare($sql);
    $comando->bindValue(':nome', $nome);
    $comando->bindValue(':link', $link);
    $comando->bindValue(':idusu', $idusuario);
    $comando->execute();

    header("location: index.php");
}
