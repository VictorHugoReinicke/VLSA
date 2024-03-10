<?php

function desenhar_tabela_link()
{

    $conexao  = new PDO(DSN, USUARIO, SENHA);
    $sql = 'SELECT * from postagens';
    $post = $conexao->query($sql);

    // $dados = json_decode(file_get_contents('link.json'), true);

    $links = array();
    if ($post->rowCount() > 0) {
      while ($row = $post->fetch(PDO::FETCH_ASSOC)) {
        $links[] = $row;
      }
    }
    $row = "";
    $counter = 0;
        if (isset($_SESSION['user']))
            $links = array_filter($links, function ($item) {
                return $item['idUsuarios'] == $_SESSION['user'];
            });


        foreach ($links as $item) {

            $itemName = $item['Nome_postagens'];
            $itemLink = $item['Link_postagens'];


            $row .= "<div class='col-2'>
                    <div class='card' style='width: 18rem;'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$itemName}</h5>
                            <a href='{$itemLink}' class='card-link'>Link</a>
                        </div>
                    </div>
                </div><div class='col-2'></div>";

            $counter++;
            if ($counter == 3) {
                echo "<div class='row mt-4'>{$row}</div>";
                $row = "";
                $counter = 0;
            }
        }


        if ($counter > 0) {
            echo "<div class='row mt-4'>{$row}</div>";
        }
    }

