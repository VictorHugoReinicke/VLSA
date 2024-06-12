<?php
require_once(__DIR__ . '/../classes/Usuario.class.php'); //fará uma requisição das funções para utilizarmos os comandos do arquivo Pessoa.class.php
// conectar com o banco
require_once(__DIR__ . '/../classes/Database.class.php');
require_once(__DIR__ . '/../classes/Foto.class.php');
$conexao = Database::getInstance();
include(__DIR__ . '/../funcoesControll.php');
$id = isset($_GET['id']) ? $_GET['id'] : 0; // coletará o id de busca
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($id > 0) // verificará se o id é maior que 0, caso a verificação estiver correta, irá:
{
    $user = Usuario::Dados($id); //atribuirá esse novo objeto à um array, com a função de listar
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // verificará o método de requisição do servidor (POST ou GET), se corresponde a 'POST'
    $id = isset($_POST['idUsuarios']) ? $_POST['idUsuarios'] : 0; //setará a $id com o valor obtido através do campo id
    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : "";
    $senha = isset($_POST['senha']) ? $_POST['senha'] : "";
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : "";
    $rg = isset($_POST['rg']) ? $_POST['rg'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $foto = isset($_POST['foto']) ? $_POST['foto'] : "";
    $conf_senha = isset($_POST['confirmasenha']) ? $_POST['confirmasenha'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0; //setará a $acao com o valor obtido através do campo acao
    // criar o objeto Pessoa que irá persistir os dados 
    try {
        $usuario = new Usuario(
            $id,
            $nome,
            $usuario,
            $email,
            $cpf,
            $rg,
            $senha,
            $foto
        );
    } catch (Exception $e) {
        header('Location:cad.php?MSG=ERROR:' . $e->getMessage());
    }

    try {
        $foto = new Foto(
            $foto
        );
    } catch (Exception $e) {
        header('Location:cad.php?MSG=ERROR:' . $e->getMessage());
    }
    $cad = Usuario::NomeUsuario($usuario->getUsuario());


    if ($acao != "fotos")
        if ($cad === null)
            Acoes($usuario, $acao, $senha, $conf_senha, $foto, $cad);
        else
            header('location:../front/cad.php?acao=user_name');
    else
        Acoes($usuario, $acao, $senha, $conf_senha, $foto, $cad);
    
    if ($acao == "login") {
        $user = Usuario::login();
        $nome_usuario = isset($_POST['usuario']) ? $_POST['usuario'] : "";
        $senha_login = isset($_POST['senha']) ? $_POST['senha'] : "";
        if ($user !== null)
            Login($user, $nome_usuario, $senha_login);
        else
            header('location:../front/login.php?acao=loginI');
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
    if ($acao == 'logout') {
        session_start();
        session_destroy();
        header('location:../front/login.php');
    }
}
