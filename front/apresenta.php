<?php
//Classes
require_once("../classes/Usuario.class.php"); //Usuario class
require_once("../classes/Database.class.php"); //Database class
require_once("../classes/Foto.class.php"); //Foto class
require_once("../classes/Postagem.class.php"); //Postagem class
$conexao = Database::getInstance();

function apresentarPerfil($listaUsuario)
{
    $fotos = Foto::ApresentaImagem($_SESSION['user']);
    foreach ($fotos as $foto)
        foreach ($listaUsuario as $usuario)
            if ($usuario->getId() != null)
                if ($foto->getTemp() != null)
                    echo "<div class='row justify-content-center align-items-center' style='height: 50vh;'><section class='col-6 order-0'><div class='row ms-3'>
                <div class='col-6'>
                <h6>Nome de Usuário</h6>
                <p>" . $usuario->getUsuario() . "</p>
                </div>
                <div class='col-6'>
                <h6>Nome</h6>
                <p>" . $usuario->getNome() . "<p>
                </div>
                <div class='col-6'>
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
                <div>
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
                <a style=' color: #000;' href='../usuario/back.php?acao=logout' style='text-decoration:none'><i class='bi bi-box-arrow-left'></i></a>
                </div>
                <div class='col-2'>
                <p>Sair</p>
                </div>
                </div>
                </section>

                <section class='col-6 order-1'>


                <div class='row justify-content-center'>

                <form action='../usuario/back.php' method='post' enctype='multipart/form-data'>
                <div class='col-8'>

                <label class='picture' for='foto' tabIndex='0'>
                <span class='picture__image ' id='spanId'><img src='../front/" . $foto->getTemp() . "' alt='PERFIL' style='width: 300px; height: 300px; object-fit:cover ' class='img-thumbnail roudend-1 border-1 border-dark '></span>
                </label>


                </div>
                <div class='row justify-content-end me-4 mt-2'>
                <div class='col-6 mb-5'>
                <button type='submit' class='btn btn-outline-primary' name='acao' id='acao' value='fotos'>Adicionar foto</button>
                <input type='text' class='form-control inputs required' id='id' name='id' placeholder='' hidden value=" . $usuario->getId() . ">

                <input type='file' name='foto' id='foto' accept='image/*' hidden>
                </div>
                </div>   
                </form>
                </section>
                ";
                else

                    echo "
                <div class='row'>
                <section class='col-6 order-0'>
                <div class='row ms-3'>
                <div class='col-6'>
                    <h6>Nome de Usuário</h6>
                    <p>" . $usuario->getUsuario() . "</p>
                </div>
                <div class='col-6'>
                    <h6>Nome</h6>
                    <p>" . $usuario->getNome() . "</p>
                </div>
                <div class='col-6'>
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
                <div>
                <div class='row mt-3'>
                    <div class='col-6'>
                    <h6>Email</h6>
                    <p>" . $usuario->getEmail() . "</p>
                    </div>
                </div>
                <div class='row mt-4'>
                <div class='col-6'>
                <button type='submit' class='btn btn-outline-primary'>Adicionar Conta</button>
                </div>
                <div class='col-6'>
                <button type='button' class='btn btn-outline-primary'><a class='icon' style='text-decoration:none' href='cad.php?id=" . $usuario->getId() . "'>Alterar Dados</a></button>
                </div>
                </div>
                <div class='row mt-5'>
                <div class='col-1 ms-3'>
                <a  style=' color: #000;' href='../usuario/back.php?acao=logout' ><i class='bi bi-box-arrow-left'></i></a>
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
                    <span class='picture__image' id='spanId'>
                    <i class='bi bi-person-plus-fill' alt='foto de perfil' style='font-size:170px'></i>
                    </span>
                
                </label>
                
                
                    
                    </div>
                </div>
                <div class='row justify-content-end'><div class='col-6 '>
                <form action='../usuario/back.php' method='post' enctype='multipart/form-data'>

                <input type='text' class='form-control inputs required' id='id' name='id' placeholder='' hidden value=" . $usuario->getId() . ">

                <input type='file' name='foto' id='foto' accept='image/*' hidden>

                <button type='submit' class='btn btn-outline-primary' name='acao' id='acao' value='fotos'>Adicionar foto</button>
                </form></div>
                    </div>
                    </section>
                    </div>

                ";
}


if (isset($_SESSION['user'])) {
    $listaUsuario = Usuario::listar($_SESSION['user']);
    $fotos = Foto::ApresentaImagem($_SESSION['user']);
}
$busca = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : "";
if ($busca != "") {
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $lista = Postagem::listar($busca, $user);
        
    } else {
        session_start();
        $user = $_SESSION['user'];
        $lista = Postagem::listar($busca, $user);
    }
} else {
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $lista = Postagem::listarTodos($user);
    } else {
        session_start();
        $user = $_SESSION['user'];
        $lista = Postagem::listarTodos($user);
    }
}