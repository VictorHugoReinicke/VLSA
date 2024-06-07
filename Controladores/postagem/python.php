<?php
$resultado = isset($_GET['resultado']) ? $_GET['resultado'] : "";
if ($resultado) {
    $outputTesteS = shell_exec('python.exe ../postagem/scripts//testeS.py');

    if ($outputTesteS) {
        $outputDash = shell_exec('streamlit run ../postagem/scripts//dash.py');
        if ($outputDash) {
            $comando = escapeshellcmd('python ../postagem/scripts//dash.py');
            $cmdResult = shell_exec($comando);
        } else {
            echo "Erro ao executar o script Dash.";
        }
    } else {
        echo "Erro ao executar o script testeS.";
    }   
} 
?>