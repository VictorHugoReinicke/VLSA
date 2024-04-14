<?php

require_once("../classes/Usuario.class.php"); //fará uma requisição das funções para utilizarmos os comandos do arquivo Pessoa.class.php
// conectar com o banco
require_once("../classes/Database.class.php");

require_once("../classes/Foto.class.php");
$conexao = Database::getInstance();

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

    $resultado = "";
    switch ($acao) {
        case 'Criar Conta':
            if ($senha == $conf_senha) {
                $resultado = $usuario->incluir();
            }
            break;

        case 'excluir':
            $resultado = $usuario->excluir();
            break;

        case 'Salvar':
            if ($senha == $conf_senha) {
                $resultado = $usuario->alterar();
            }
            break;

        case 'fotos':
            if (!isset($_SESSION['user'])) {
                session_start();
            }
            $resultado = $foto->incluir($_SESSION['user']);
            break;
    }


    if ($resultado)
        header('Location: index.php');
    else
        echo "erro ao inserir dados!";



    if ($acao == "login") {
        $user = Usuario::login();
        $nome_usuario = isset($_POST['usuario']) ? $_POST['usuario'] : "";
        $senha_login = isset($_POST['senha']) ? $_POST['senha'] : "";
        if ($user['Nome_usuario'] != $nome_usuario || $senha_login != $user['Senha']) {
            session_start();
            session_destroy();
            header('Location: login.php');
        } else {
            session_start();
            $_SESSION['user'] = $user['idUsuarios'];
            header('Location: index.php');
        }
    }
}
if (!isset($_SESSION['user'])) 
    session_start();
    $lista = Usuario::listar($_SESSION['user']);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
    if ($acao == 'logout') {
        session_destroy();
        header('location:login.php');
    }
}

function apresentarPerfil($lista)
{
    $fotos = Foto::ApresentaImagem($_SESSION['user']);
    foreach ($fotos as $foto)
        foreach ($lista as $usuario) {
            $imagem_style = ($foto->getTemp() != null) ? 'style="width: 100%; height: auto; object-fit: cover;"' : 'style="font-size: 170px;"';
            $btn_style = ($foto->getTemp() != null) ? 'col-6' : 'col-6 offset-3';

            echo "
                <div class='row justify-content-center align-items-center' style='height: 50vh;'>
                    <section class='col-6 order-0'>
                        <!-- Se a foto existir -->
                        <div class='row ms-3'>
                            <div class='col-6'>
                                <h6>Nome de Usuário</h6>
                                <p>" . $usuario->getUsuario() . "</p>
                            </div>
                            <div class='col-6'>
                                <h6>Nome</h6>
                                <p>" . $usuario->getNome() . "<p>
                            </div>
                        </div> 
                        <div class='row mt-3 ms-3'>
                            <div class='col-6'>
                                <h6>CPF</h6>
                                <p>" . $usuario->getCpf() . "</p>
                            </div>
                            <div class='col-6'>
                                <h6>RG</h6>
                                <p>" . $usuario->getRg() . "</p>
                            </div>
                        </div>
                        <div class='row mt-3'>
                            <div class='col-6'>
                                <h6>Email</h6>
                                <p>" . $usuario->getEmail() . "</p>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-6'>
                                <button type='submit' class='btn btn-outline-primary'>Adicionar Conta</button>
                            </div>
                            <div class='col-6'>
                                <button type='button' class='btn btn-outline-primary'><a class='icon' style='text-decoration:none' href='cad.php?id=" . $usuario->getId() . "'>Alterar Dados</a></button>
                            </div>
                        </div>
                        <div class='row mt-5'>
                            <div class='col-1 ms-3'>
                                <a style=' color: #000;' href='back.php?acao=logout'><i class='bi bi-box-arrow-left'></i></a>
                            </div>
                            <div class='col-2'>
                                <p>Sair</p>
                            </div>
                        </div>
                    </section>

                    <section class='col-6 order-1'>
                        <div class='row justify-content-center'>
                            <div class='col-8'>
                                <label class='picture' for='foto' tabIndex='0'>
                                    <span class='picture__image'>
                                        <img src='../" . $foto->getTemp() . "' alt='PERFIL' $imagem_style class='img-thumbnail rounded-1 border-1 border-dark'>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class='row justify-content-end me-4 mt-2'>
                            <div class='$btn_style mb-5'>
                                <form action='back.php' method='post' enctype='multipart/form-data'>
                                    <button type='submit' class='btn btn-outline-primary' name='acao' id='acao' value='fotos'>Adicionar foto</button>
                                    <input type='text' class='form-control inputs required' id='id' name='id' placeholder='' hidden value=" . $usuario->getId() . ">
                                    <input type='file' name='foto' id='foto' accept='image/*' hidden>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            ";
        }
}
