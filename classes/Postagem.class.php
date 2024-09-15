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

    public function incluir()
    {

        $sql = 'INSERT INTO postagens (nome_postagem, link_postagem,idUsuario,emailInstagram,senha) 
          VALUES (:Nome_postagens, :Link_postagens, :idUsuarios, :EmailInstagram, :Senha)';

        $parametros = [
            ':Nome_postagens' =>  $this->getNomePost(),
            ':Link_postagens' => $this->getLink(),
            ':idUsuarios' => $this->getIdUsu(),
            ':EmailInstagram' => $this->getEmail(),
            ':Senha' => $this->getSenha()
        ];

        Database::executar($sql, $parametros);

        return Database::$lastId;
    }

    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM postagens WHERE idPostagem = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getIdPost());
        return $comando->execute();
    }


    public function alterar()
    {
        $sql = 'UPDATE postagens SET nome_postagem = :Nome, link_postagem = :Link_postagens, idUsuario = :idUsuarios, emailInstagram = :EmailInstagram, senha = :Senha WHERE idPostagem = :id';

        $parametros = [
            ':id' => $this->getIdPost(),
            ':Nome' =>  $this->getNomePost(),
            ':Link_postagens' => $this->getLink(),
            ':idUsuarios' => $this->getIdUsu(),
            ':EmailInstagram' => $this->getEmail(),
            ':Senha' => $this->getSenha()
        ];

        return Database::executar($sql, $parametros);
    }

    public static function listar($busca = "", $user = 0)
    {
        $sql = "SELECT * FROM postagens WHERE idUsuario = :idUsuario";

        $parametros = [':idUsuario' => $user];
        if ($busca != "") {
            $sql .= " AND nome_postagem LIKE :busca";
            $parametros[':busca'] = "%{$busca}%";
        }

        $comando = Database::executar($sql, $parametros);

        $lista = array();
        while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
            $lista[] = new Postagem($row['idPostagem'], $row['nome_postagem'], $row['link_postagem'], $row['idUsuario'], $row['emailInstagram'], $row['senha'], $row['imgPost']);
        }
        return $lista;
    }

    public static function listarTodos($organizar = 0, $user)
    {
        $sql = "SELECT * FROM postagens WHERE idUsuario = :idUsuario";

        switch ($organizar) {
            case 1:
                $sql .= " ORDER BY nome_postagem ASC";
                break;
            case 2:
                $sql = "SELECT p.idPostagem, p.nome_postagem, p.link_postagem, p.idUsuario, p.emailInstagram, p.senha, p.imgPost,
                        COUNT(c.idComentario) AS num_comentarios
                        FROM postagens p
                        LEFT JOIN comentarios c ON p.idPostagem = c.idPostagem
                        WHERE p.idUsuario = :idUsuario
                        GROUP BY p.idPostagem, p.nome_postagem, p.link_postagem, p.idUsuario, p.emailInstagram, p.senha, p.imgPost
                        ORDER BY num_comentarios DESC";
                break;
            case 3:
                $sql = "SELECT p.idPostagem, p.nome_postagem, p.link_postagem, p.idUsuario, p.emailInstagram, p.senha, p.imgPost,
                        SUM(CASE WHEN c.polaridade LIKE '%positivo%' THEN 1 ELSE 0 END) AS total_positivo
                        FROM postagens p
                        LEFT JOIN comentarios c ON p.idPostagem = c.idPostagem
                        WHERE p.idUsuario = :idUsuario
                        GROUP BY p.idPostagem, p.nome_postagem, p.link_postagem, p.idUsuario, p.emailInstagram, p.senha, p.imgPost
                        ORDER BY total_positivo DESC";
                break;
            case 4:
                $sql = "SELECT p.idPostagem, p.nome_postagem, p.link_postagem, p.idUsuario, p.emailInstagram, p.senha, p.imgPost,
                        SUM(CASE WHEN c.polaridade LIKE '%negativo%' THEN 1 ELSE 0 END) AS total_negativo
                        FROM postagens p
                        LEFT JOIN comentarios c ON p.idPostagem = c.idPostagem
                        WHERE p.idUsuario = :idUsuario
                        GROUP BY p.idPostagem, p.nome_postagem, p.link_postagem, p.idUsuario, p.emailInstagram, p.senha, p.imgPost
                        ORDER BY total_negativo DESC";
                break;
        }

        $parametros = [':idUsuario' => $user];

        $comando = Database::executar($sql, $parametros);

        $lista = array();
        while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
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
}
