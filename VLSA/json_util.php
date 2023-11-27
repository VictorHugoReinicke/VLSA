<?php

function salvar_json($dados, $arquivo)
{
    $fp = fopen($arquivo, "w");
    fwrite($fp, $dados);
    fclose($fp);
}

function ler_json($arquivo)
{
    $arquivo = file_get_contents($arquivo);
    $json = json_decode($arquivo);
    return $json;
}
?>