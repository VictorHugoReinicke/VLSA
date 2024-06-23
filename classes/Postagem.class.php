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

        $sql = 'INSERT INTO postagens (nome_postagem, link_postagem,idUsuario,emailInstagram,senha) 
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

        $sql = 'DELETE FROM postagens WHERE idPostagem = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->idPostagens);
        return $comando->execute();
    }


    public function alterar($conexao)
    {
        $sql = 'UPDATE postagens SET nome_postagem = :Nome, link_postagem = :Link_postagens, idUsuario = :idUsuarios, emailInstagram = :EmailInstagram, senha = :Senha WHERE idPostagem = :id';
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
        $sql = "SELECT * FROM postagens WHERE idUsuario = :idUsuario";

        if ($busca != "") {
            $sql .= " AND nome_postagem like :busca";
            $busca = "%{$busca}%";
        }
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':idUsuario', $user);
        $comando->bindValue(':busca', $busca);
        $comando->execute();


        $lista = array();
        while ($row = $comando->fetch()) {
            $lista[] = new Postagem($row['idPostagem'], $row['nome_postagem'], $row['link_postagem'], $row['idUsuario'], $row['emailInstagram'], $row['senha'], $row['imgPost']);
        }
        return $lista;
    }

    public static function listarTodos($user)
    {
        $conexao = Database::getInstance();

        $sql = "SELECT * FROM postagens WHERE idUsuario = :idUsuario";

        $comando = $conexao->prepare($sql);
        $comando->bindValue(':idUsuario', $user);
        $comando->execute();
        $lista = array();
        while ($row = $comando->fetch()) {
            $lista[] = new Postagem($row['idPostagem'], $row['nome_postagem'], $row['link_postagem'], $row['idUsuario'], $row['emailInstagram'], $row['senha'], $row['imgPost']);
        }

        return $lista;
    }

    public function ValoresPython()
    {
        $conexao = Database::getInstance();

        $sql = "SELECT * FROM postagens WHERE idUsuario = :idUsuario";

        $comando = $conexao->prepare($sql);
        $comando->bindValue(':idUsuario', $_SESSION['user']);
        $comando->execute();
        $lista = array();
        while ($row = $comando->fetch()) {
            $lista[] = new Postagem($row['link_postagens'], $row['emailInstagram'], $row['senha']);
        }

        return $lista;
    }

    public static function Dados($id)
    {
        $conexao = Database::getInstance();
        $sql = "SELECT * FROM postagens WHERE idPostagem = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $id);
        $comando->execute();

        if ($registro  = $comando->fetch()) {
            return new Postagem($registro['idPostagem'], $registro['nome_postagem'], $registro['link_postagem'], $registro['idUsuario'], $registro['emailInstagram'], $registro['senha'], $registro['imgPost']);
        }

        return null;
    }

    public function adicionarConta($conexao)
    {
        $sql = 'INSERT INTO postagens (idUsuario,emailInstagram) 
        VALUES (:idUsuario,:EmailInstagram)';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':idUsuario', $this->idUsuario);
        $comando->bindValue(':EmailInstagram', $this->Email);

        return $comando->execute();
    }
}
