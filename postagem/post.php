<?php
if (isset($_GET['acao']) && $_GET['acao'] == "view" && isset($_GET['id'])) {
    // Read existing JSON data
    $filePath = '../postagem/session_data.json';
    $jsonData = file_get_contents($filePath);
    if ($jsonData) {
        $sessionData = json_decode($jsonData, true);
    } else {
        echo "Erro ao ler o arquivo JSON: $filePath";
        exit;
    }

    $sessionData['id'] = $_GET['id'];
    $updatedJsonData = json_encode($sessionData);

    file_put_contents($filePath, $updatedJsonData);
    $outputDash = shell_exec('streamlit run ../postagem//post.py');

    if ($outputDash === false) {
        echo "An error occurred while running the analysis script.";
        exit;
    }
}