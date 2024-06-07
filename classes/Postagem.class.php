<?php
class Postagem
{

    private $idPostagens;
    private $Nome_postagens;
    private $Link_postagens;
    private $idUsuario;
    private $Email;
    private $Senha;
    private $imgPost;

    public function __construct(
        $idPostagens = 0,
        $Nome_postagens = "null",
        $Link_postagens = "null",
        $idUsuario = "null",
        $Email = "null",
        $Senha = "null",
        $imgPost = "null"

    ) {
        $this->setIdPostagem($idPostagens);
        $this->setNomePostagem($Nome_postagens);
        $this->setLinkPostagem($Link_postagens);
        $this->setIdUsuario($idUsuario);
        $this->setEmail($Email);
        $this->setSenha($Senha);
        $this->setimgPost($imgPost);
    }

    public function setIdPostagem($novoId)
    {
        if ($novoId < 0)
            echo "Erro: id inválido!";
        else
            $this->idPostagens = $novoId;
    }

    public function setNomePostagem($novoNome)
    {
        if ($novoNome == "")
            echo "Erro: nome inválido!";
        else
            $this->Nome_postagens = $novoNome;
    }

    public function setLinkPostagem($novoPostagem)
    {
        if ($novoPostagem == "")
            echo "Erro: Link inválido!";
        else
            $this->Link_postagens = $novoPostagem;
    }

    public function setIdUsuario($novoIdUsu)
    {
        if ($novoIdUsu == "")
            echo "Erro: ID inválido!";
        else
            $this->idUsuario = $novoIdUsu;
    }

    public function setEmail($novoEmail)
    {
        if ($novoEmail == "")
            echo "Erro: Email inválido!";
        else
            $this->Email = $novoEmail;
    }


    public function setSenha($novoSenha)
    {
        if ($novoSenha == "")
            echo "Erro: Senha inválida!";
        else
            $this->Senha = $novoSenha;
    }

    public function setimgPost($novoimgPost)
    {
        $this->imgPost = $novoimgPost;
    }

    public function getIdPost()
    {
        return $this->idPostagens;
    }

    public function getNomePost()
    {
        return $this->Nome_postagens;
    }

    public function getLink()
    {
        return $this->Link_postagens;
    }

    public function getIdUsu()
    {
        return $this->idUsuario;
    }

    public function getEmail()
    {
        return $this->Email;
    }

    public function getSenha()
    {
        return $this->Senha;
    }

    public function getImgPost()
    {
        return $this->imgPost;
    }

    public function incluir($conexao)
    {

        $sql = 'INSERT INTO postagens (Nome_postagens, Link_postagens,idUsuarios,EmailInstagram,Senha) 
          VALUES (:Nome_postagens, :Link_postagens, :idUsuarios, :EmailInstagram, :Senha)';



        $comando = $conexao->prepare($sql);
        $comando->bindValue(':Nome_postagens', $this->Nome_postagens);
        $comando->bindValue(':Link_postagens', $this->Link_postagens);
        $comando->bindValue(':idUsuarios', $this->idUsuario);
        $comando->bindValue(':EmailInstagram', $this->Email);
        $comando->bindValue(':Senha', $this->Senha);

        return $comando->execute();
    }

    public function excluir($conexao)
    {

        $sql = 'DELETE FROM postagens WHERE idPostagens = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->idPostagens);
        return $comando->execute();
    }


    public function alterar($conexao)
    {
        $sql = 'UPDATE postagens SET Nome_postagens = :Nome, Link_postagens = :Link_postagens, idUsuarios = :idUsuarios, EmailInstagram = :EmailInstagram, Senha = :Senha WHERE idPostagens = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->idPostagens);
        $comando->bindValue(':Nome', $this->Nome_postagens);
        $comando->bindValue(':Link_postagens', $this->Link_postagens);
        $comando->bindValue(':idUsuarios', $this->idUsuario);
        $comando->bindValue(':EmailInstagram', $this->Email);
        $comando->bindValue(':Senha', $this->Senha);
        return $comando->execute();
    }

    public static function listar($busca = "", $user = 0)
    {
        $conexao = Database::getInstance();
        $sql = "SELECT * FROM postagens WHERE idUsuarios = :idUsuario";

        if ($busca != "") {
            $sql .= " AND Nome_postagens like :busca";
            $busca = "%{$busca}%";
        }
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':idUsuario', $user);
        $comando->bindValue(':busca', $busca);
        $comando->execute();


        $lista = array();
        while ($row = $comando->fetch()) {
            $lista[] = new Postagem($row['idPostagens'], $row['Nome_postagens'], $row['Link_postagens'], "null", "null", "null", $row['imgPost']);
        }
        return $lista;
    }

    public static function listarTodos($user)
    {
        $conexao = Database::getInstance();

        $sql = "SELECT * FROM postagens WHERE idUsuarios = :idUsuario";

        $comando = $conexao->prepare($sql);
        $comando->bindValue(':idUsuario', $user);
        $comando->execute();
        $lista = array();
        while ($row = $comando->fetch()) {
            $lista[] = new Postagem($row['idPostagens'], $row['Nome_postagens'], $row['Link_postagens'], "null", "null", "null", $row['imgPost']);
        }

        return $lista;
    }

    public function ValoresPython()
    {
        $conexao = Database::getInstance();

        $sql = "SELECT * FROM postagens WHERE idUsuarios = :idUsuario";

        $comando = $conexao->prepare($sql);
        $comando->bindValue(':idUsuario', $_SESSION['user']);
        $comando->execute();
        $lista = array();
        while ($row = $comando->fetch()) {
            $lista[] = new Postagem($row['Link_postagens'], $row['EmailInstagram'], $row['Senha']);
        }

        return $lista;
    }

    public static function Dados($id)
    {
        $conexao = Database::getInstance();
        $sql = "SELECT * FROM postagens WHERE idPostagens = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $id);
        $comando->execute();

        if ($registro  = $comando->fetch()) {
            return new Postagem($registro['idPostagens'], $registro['Nome_postagens'], $registro['Link_postagens'], $registro['idUsuarios'], $registro['EmailInstagram'], $registro['Senha'], $registro['imgPost']);
        }

        return null;
    }
}
