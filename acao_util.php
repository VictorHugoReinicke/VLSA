<?php

function carregar($id)
{
    $json = ler_json(ARQUIVO_JSON);

    foreach ($json as $key) {
        if ($key->id === $id)
            return (array) $key;
    }
}

function alterar()
{
    $novo = altera();

    $json = ler_json(ARQUIVO_JSON);

    for ($x = 0; $x < count($json); $x++) {
        if ($json[$x]->id === $novo['id']) {
            array2json($novo, $json[$x]);
        }
    }

    salvar_json(json_encode($json), ARQUIVO_JSON);

    header("location:perfil.php");
}
function excluir()
{
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    $json = ler_json(ARQUIVO_JSON);
    if ($json == null)
        $json = array();

    $novo = array();
    for ($x = 0; $x < count($json); $x++) {
        var_dump($json[$x]);
        if ($json[$x]->id != $id)

            array_push($novo, $json[$x]);
    }
    salvar_json(json_encode($novo), ARQUIVO_JSON);

    header("location:" . DESTINO);
}
/*
 * Método salva alterações feitas em um registro
 * @return void
 */
function salvar()
{

    $json = NULL;
    $pessoa = tela2array();
    $cad = valcad();
    $json = ler_json(ARQUIVO_JSON);

    if ($json == NULL) {
        $json = array();
    }

    array_push($json, $pessoa);

    salvar_json(json_encode($json), ARQUIVO_JSON);
    if ($cad['senha'] === $cad['confirmasenha'])

        header("location:" . DESTINO);
    else
        header("location:cad.php");
}

function login()
{
    $login = vallogin();
    $json = ler_json(ARQUIVO_JSON);
    foreach ($json as $key) {
        if ($key->usuario === $login['usuario'] && $key->senha === $login['senha']) {
            session_start();
            $_SESSION['user'] = $key->id;
            header('Location: link.php');
            break;
        } else
            header('location:login.php');
    }
}

function logout()
{
    session_start();
    session_destroy();
    header('Location:login.php');
}



function fotos()
{
    $novo = tela2array();
    $json = ler_json(ARQUIVO_JSON);
    for ($x = 0; $x < count($json); $x++) {

        if ($json[$x]->id === $novo['id']) {
            $json[$x]->foto = $novo['foto'];
            echo "novo";
            echo $json[$x]->foto;
        }
    }

    salvar_json(json_encode($json), ARQUIVO_JSON);

    header("location:perfil.php");
}

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

