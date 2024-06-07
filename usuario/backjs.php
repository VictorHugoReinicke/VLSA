<?php
$acao = isset($_GET['acao']) ? $_GET['acao'] : "";
switch ($acao) {
    case ('contaC'):
        $message = "Conta criada com sucesso!";
        $redirect = "login.php";
        break;
    case ('contaE'):
        $message = "Erro no cadastro!";
        $redirect = "cad.php";
        break;
    case ('loginE'):
        $message = "Erro no login!";
        $redirect = "login.php";
        break;
    case ('loginC'):
        $message = "Usuário Logado!";
        $redirect = "index.php";
        break;
}

?>
<?php if (isset($message) && isset($redirect)) : ?>

    <script>
        showSwal("<?php echo $message; ?>", "<?php echo $redirect; ?>");
    </script>
    
<?php endif; ?>