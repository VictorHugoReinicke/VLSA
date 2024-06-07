<?php
$resultado = isset($_GET['resultado']) ? $_GET['resultado'] : "";
if ($resultado) {
    $outputTesteS = shell_exec('python.exe ../postagem//testeS.py');

    if ($outputTesteS) {
        $outputDash = shell_exec('streamlit run ../postagem//dash.py');
        if ($outputDash) {
            $comando = escapeshellcmd('python dash.py');
            $cmdResult = shell_exec($comando);
        } else {
            echo "Erro ao executar o script Dash.";
        }
    } else {
        echo "Erro ao executar o script testeS.";
    }   
} 
?>