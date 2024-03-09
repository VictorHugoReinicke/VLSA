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
            salvar($conexao);
            break;
            // case 'Alterar':
            //     alterar();
            //     break;
            // case 'excluir':
            //     excluir();
            //     break;
        case 'login':
            login($conexao);
            break;
            // case 'logout':
            //     logout();
            //     break;
            // case 'fotos':
            //     fotos();
            //     break;
    }

    function tela2array()
    {
        // if (isset($_FILES['foto'])) {
        //     $ext = strtolower(substr($_FILES['foto']['name'], -4)); //Pegando extensão do arquivo
        //     $new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
        //     $dir = './imgs/'; //Diretório para uploads 
        //     move_uploaded_file($_FILES['foto']['tmp_name'], $dir . $new_name); //Fazer upload do arquivo

        // }   

        // $novo = array(
        //     'nome' => isset($_POST['nome']) ? $_POST['nome'] : "",
        //     'usuario' => isset($_POST['usuario']) ? $_POST['usuario'] : "",
        //     'senha' => isset($_POST['senha']) ? $_POST['senha'] : "",
        //     'cpf' => isset($_POST['cpf']) ? $_POST['cpf'] : "",
        //     'rg' => isset($_POST['rg']) ? $_POST['rg'] : "",
        //     'email' => isset($_POST['email']) ? $_POST['email'] : "",
        //     'foto' => $new_name
        // );

        // if ($novo['id'] == "0") {
        //     $novo['id'] = date("YmdHis");
        // }
        // $conf_senha = isset($_POST['confirmasenha']) ? $_POST['confirmasenha'] : "";
        // if ($novo['senha'] === $conf_senha)
        //     return $novo;
    }


    function vallogin()
    {

        $login = [
            'usuario' => isset($_POST['usuario']) ? $_POST['usuario'] : "",
            'senha' => isset($_POST['senha']) ? $_POST['senha'] : ""
        ];

        return $login;
    }



    // function foto()
    // {
    //     if (isset($_FILES['foto'])) {
    //         $ext = strtolower(substr($_FILES['foto']['name'], -4)); //Pegando extensão do arquivo
    //         $new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
    //         $dir = './imgs/'; //Diretório para uploads 
    //         move_uploaded_file($_FILES['foto']['tmp_name'], $dir . $new_name); //Fazer upload do arquivo
    
    //     }

    //     $novo = array(
    //         'id' => isset($_POST['id']) ? $_POST['id'] : date("YmdHis"),
    //         'foto' => $new_name
    //     );

    //     if ($novo['id'] == "0") {
    //         $novo['id'] = date("YmdHis");
    //     }
    //         return $novo;

    //     }

    // function altera()
    // {
        
    //     $novo = array(
    //         'id' => isset($_POST['id']) ? $_POST['id'] : date("YmdHis"),
    //         'nome' => isset($_POST['nome']) ? $_POST['nome'] : "",
    //         'usuario' => isset($_POST['usuario']) ? $_POST['usuario'] : "",
    //         'senha' => isset($_POST['senha']) ? $_POST['senha'] : "",
    //         'cpf' => isset($_POST['cpf']) ? $_POST['cpf'] : "",
    //         'rg' => isset($_POST['rg']) ? $_POST['rg'] : "",
    //         'email' => isset($_POST['email']) ? $_POST['email'] : "",
    //         'foto' => isset($_POST['foto']) ? $_POST['foto'] : ""
    //     );

    //     if ($novo['id'] == "0") {
    //         $novo['id'] = date("YmdHis");
    //     }
    //     $conf_senha = isset($_POST['confirmasenha']) ? $_POST['confirmasenha'] : "";
    //     if ($novo['senha'] === $conf_senha)
    //         return $novo;
    // }