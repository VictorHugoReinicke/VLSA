<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    include "usuario_acao.php";
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $dados = array();
    if ($id != 0)
        $dados = carregar($id);
    ?>
</head>

<body>
    <form action="usuario_acao.php" method="post" enctype="multipart/form-data">


        <input type="text" class="form-control inputs required" id="id" name="id" placeholder="" hidden value="<?php if ($id != 0)
                                                                                                            echo $dados['id']; ?>">

        <input type="file" name="foto" id="foto" accept="image/*">
        <br>
        <input type="submit" class="btn btn-outline-primary" name="acao" id="acao" value="fotos">
    </form>
</body>

</html>