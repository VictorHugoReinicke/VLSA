<?php
require_once(__DIR__ . '/../classes/Usuario.class.php'); //fará uma requisição das funções para utilizarmos os comandos do arquivo Pessoa.class.php
require_once(__DIR__ . '/../classes/Database.class.php');
require_once(__DIR__ . '/../classes/Foto.class.php');
include(__DIR__ . '/../funcoesControll.php');
$conexao = Database::getInstance();
$id = isset($_GET['id']) ? $_GET['id'] : 0; // coletará o id de busca
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($id > 0) // verificará se o id é maior que 0, caso a verificação estiver correta, irá:
    $user = Usuario::Dados($id); //atribuirá esse novo objeto à um array, com a função de listar

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
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;
    if($acao == "Criar Conta")
    $senha = password_hash($senha,PASSWORD_DEFAULT);

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
        $foto = new Foto(
            $foto
        );
        $cad = Usuario::NomeUsuario($usuario->getUsuario());
        Acoes($usuario, $cad, $conf_senha, $acao, $foto);
    } catch (Exception $e) {
        header('Location:cad.php?MSG=ERROR:' . $e->getMessage());
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
    Acoes(null, null, null, $acao, null);
}
