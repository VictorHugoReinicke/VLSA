<?php
function desenhar_tabela_link()
{

    $dados = json_decode(file_get_contents('link.json'), true);
    $row = "";
    $counter = 0;
    if (isset($_SESSION['user']))
    $links = array_filter($dados, function ($item) {
        return $item['idusu'] == $_SESSION['user'];
    });
        foreach ($links as $item) {

            $itemName = $item['nome'];
            $itemLink = $item['link'];


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
