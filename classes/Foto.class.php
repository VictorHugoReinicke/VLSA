<?php
class Foto
{
    private $foto;
    private $nome_imagem;
    private $tipo;
    private $tamanho;
    private $temp;


    public function __construct(
        $foto = "",
        $nome_imagem = "",
        $tipo = "",
        $tamanho = "",
        $temp = "",
    ) {
        $this->setFoto($foto);
        $this->setNomeImagem($nome_imagem);
        $this->setTipo($tipo);
        $this->setTamanho($tamanho);
        $this->setTemp($temp);
    }

    public function setFoto($Newfoto)
    {
        $this->foto = $Newfoto;
    }

    public function setNomeImagem($NewNomeImagem)
    {
        $this->nome_imagem = $NewNomeImagem;
    }

    public function setTipo($NewTipo)
    {
        $this->tipo = $NewTipo;
    }

    public function setTamanho($NewTamanho)
    {
        $this->tamanho = $NewTamanho;
    }

    public function setTemp($NewTemp)
    {
        $this->temp = $NewTemp;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getNomeImagem()
    {
        return $this->nome_imagem;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getTamanho()
    {
        return $this->tamanho;
    }

    public function getTemp()
    {
        return $this->temp;
    }

    public function incluir($id)
    {
        if (isset($_FILES['foto'])) {

            $nome_imagem = $_FILES['foto']['name'];
            $tipo_imagem = $_FILES['foto']['type'];
            $tamanho_imagem = $_FILES['foto']['size'];
            $temp_imagem = $_FILES['foto']['tmp_name'];

            // Validar tipo e tamanho da imagem
            if ($tipo_imagem != 'image/jpeg' && $tipo_imagem != 'image/png') {
                echo 'Erro: Tipo de imagem inválido.';
                exit;
            }
            $nome_unico = uniqid() . '.' . pathinfo($nome_imagem, PATHINFO_EXTENSION);
            move_uploaded_file($temp_imagem, '../asset/imgs/' . $nome_unico);
            // Salvar o caminho da imagem no banco de dados
            $sql = "UPDATE usuarios SET imagem = :imagem, nome_imagem = '$nome_imagem', tipo = '$tipo_imagem', tamanho = '$tamanho_imagem', temp = 'imgs/$nome_unico' WHERE idUsuario = :idUsuario";

            $parametros = [':idUsuario' => $id, ':imagem' => $this->getFoto()];
            return Database::executar($sql, $parametros);
        }
    }

    public static function ApresentaImagem($id)
    {
        $sql = "SELECT imagem,nome_imagem,tipo,tamanho,temp FROM usuarios where idUsuario = :idUsuario";
        $parametros = [':idUsuario' => $id];
        $comando = Database::executar($sql, $parametros);
        while ($registro  = $comando->fetch(PDO::FETCH_ASSOC)) {
            $fotos[] = new Foto($registro['imagem'], $registro['nome_imagem'], $registro['tipo'], $registro['tamanho'], $registro['temp']); // Um novo objeto Pessoa é criado usando os valores dos campos id, nome e telefone do registro atual.
        }
        return $fotos;
    }
}
