<?php
session_start();

$sessionData = [
    "userId" => $_SESSION["user"],
];

$serializedData = json_encode($sessionData);

$filePath = 'session_data.json';
file_put_contents($filePath, $serializedData);

// Executa o script dash.py após a execução do testeS.py
$comando = escapeshellcmd('python dash.py');
$cmdResult = shell_exec($comando);

// Redireciona para a página desejada após a execução dos scripts Python
header('location:../usuario/index.php');
