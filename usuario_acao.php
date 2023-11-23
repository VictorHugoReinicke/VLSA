    <?php
    include "json_util.php";
    define("DESTINO", "login.php");
    define("ARQUIVO_JSON", "usu.json");
    include "acao_util.php";

    $acao = "";
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
            break;
        case 'POST':
            $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
            break;
    }

    switch ($acao) {
        case 'Criar Conta':
            salvar();
            break;
        case 'Alterar':
            alterar();
            break;
        case 'excluir':
            excluir();
            break;
        case 'login':
            login();
            break;
        case 'logout':
            logout();
            break;
        case 'fotos':
            fotos();
            break;
    }

    function tela2array()
    {
        if (isset($_FILES['foto'])) {
            $ext = strtolower(substr($_FILES['foto']['name'], -4)); //Pegando extensão do arquivo
            $new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
            $dir = './imgs/'; //Diretório para uploads 
            move_uploaded_file($_FILES['foto']['tmp_name'], $dir . $new_name); //Fazer upload do arquivo
    
        }   
        
        $novo = array(
            'id' => isset($_POST['id']) ? $_POST['id'] : date("YmdHis"),
            'nome' => isset($_POST['nome']) ? $_POST['nome'] : "",
            'usuario' => isset($_POST['usuario']) ? $_POST['usuario'] : "",
            'senha' => isset($_POST['senha']) ? $_POST['senha'] : "",
            'cpf' => isset($_POST['cpf']) ? $_POST['cpf'] : "",
            'rg' => isset($_POST['rg']) ? $_POST['rg'] : "",
            'email' => isset($_POST['email']) ? $_POST['email'] : "",
            'foto' => $new_name
        );

        if ($novo['id'] == "0") {
            $novo['id'] = date("YmdHis");
        }
        $conf_senha = isset($_POST['confirmasenha']) ? $_POST['confirmasenha'] : "";
        if ($novo['senha'] === $conf_senha)
            return $novo;
    }

    function array2json($array_dados, $json_dados)
    {
        $json_dados->id = $array_dados['id'];
        $json_dados->nome = $array_dados['nome'];
        $json_dados->senha = $array_dados['senha'];
        $json_dados->usuario = $array_dados['usuario'];
        $json_dados->cpf = $array_dados['cpf'];
        $json_dados->rg = $array_dados['rg'];
        $json_dados->email = $array_dados['email'];
        $json_dados->foto = $array_dados['foto'];

        return $json_dados;
    }

    function vallogin()
    {

        $login = [
            'usuario' => isset($_POST['usuario']) ? $_POST['usuario'] : "",
            'senha' => isset($_POST['senha']) ? $_POST['senha'] : ""
        ];



        return $login;
    }


    function valcad()
    {

        $cad = [
            'confirmasenha' => isset($_POST['confirmasenha']) ? $_POST['confirmasenha'] : "",
            'senha' => isset($_POST['senha']) ? $_POST['senha'] : ""
        ];

        return $cad;
    }

    function foto()
    {
        if (isset($_FILES['foto'])) {
            $ext = strtolower(substr($_FILES['foto']['name'], -4)); //Pegando extensão do arquivo
            $new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
            $dir = './imgs/'; //Diretório para uploads 
            move_uploaded_file($_FILES['foto']['tmp_name'], $dir . $new_name); //Fazer upload do arquivo
    
        }

        $novo = array(
            'id' => isset($_POST['id']) ? $_POST['id'] : date("YmdHis"),
            'foto' => $new_name
        );

        if ($novo['id'] == "0") {
            $novo['id'] = date("YmdHis");
        }
            return $novo;
    }

    function altera()
    {
        
        $novo = array(
            'id' => isset($_POST['id']) ? $_POST['id'] : date("YmdHis"),
            'nome' => isset($_POST['nome']) ? $_POST['nome'] : "",
            'usuario' => isset($_POST['usuario']) ? $_POST['usuario'] : "",
            'senha' => isset($_POST['senha']) ? $_POST['senha'] : "",
            'cpf' => isset($_POST['cpf']) ? $_POST['cpf'] : "",
            'rg' => isset($_POST['rg']) ? $_POST['rg'] : "",
            'email' => isset($_POST['email']) ? $_POST['email'] : "",
            'foto' => isset($_POST['foto']) ? $_POST['foto'] : ""
        );

        if ($novo['id'] == "0") {
            $novo['id'] = date("YmdHis");
        }
        $conf_senha = isset($_POST['confirmasenha']) ? $_POST['confirmasenha'] : "";
        if ($novo['senha'] === $conf_senha)
            return $novo;
    }