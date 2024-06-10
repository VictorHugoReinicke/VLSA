<?php
require_once(__DIR__ . '/../config/config.inc.php');


class Database
{
    // private $conexao;

    public static function getInstance()
    {
        try{
            return new PDO(DSN, USUARIO, SENHA);
        }catch(PDOException $e)
        {
        echo "Erro ao conectar ao banco de dados". $e->getMessage();
        }
    }

}
