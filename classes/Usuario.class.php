 <?php
    class Usuario
    {
        private $id;
        private $nome;
        private $nome_usuario;
        private $email;
        private $cpf;
        private $rg;

        private $senha;
        private $imagem;

        public function __construct(
            $id = 0,
            $nome = "null",
            $nome_usuario = "null",
            $email = "null",
            $cpf = "null",
            $rg = "null",
            $senha = "null",
            $imagem = "null"
        ) {
            $this->setId($id);
            $this->setNome($nome);
            $this->setUsuario($nome_usuario);
            $this->setEmail($email);
            $this->setCpf($cpf);
            $this->setRg($rg);
            $this->setSenha($senha);
            $this->setImagem($imagem);
        }

        public function setId($novoId)
        {
            if ($novoId < 0)
                echo "Erro: id inválido!";
            else
                $this->id = $novoId;
        }

        public function setNome($novoNome)
        {
            if ($novoNome == "")
                echo "Erro: nome inválido!";
            else
                $this->nome = $novoNome;
        }

        public function setUsuario($novoUsuario)
        {
            if ($novoUsuario == "")
                echo "Erro: Usuario inválido!";
            else
                $this->nome_usuario = $novoUsuario;
        }

        public function setCpf($novoCpf)
        {
            if ($novoCpf == "")
                echo "Erro: CPF inválido!";
            else
                $this->cpf = $novoCpf;
        }

        public function setRg($novoRg)
        {
            if ($novoRg == "")
                echo "Erro: RG inválido!";
            else
                $this->rg = $novoRg;
        }
        public function setEmail($novoEmail)
        {
            if ($novoEmail == "")
                echo "Erro: Email inválido!";
            else
                $this->email = $novoEmail;
        }

        public function setSenha($novoSenha)
        {
            if ($novoSenha == "")
                echo "Erro: Senha inválido!";
            else
                $this->senha = $novoSenha;
        }

        public function setImagem($novoImagem)
        {
            $this->imagem = $novoImagem;
        }

        public function getId()
        {
            return $this->id;
        }
        public function getNome()
        {
            return $this->nome;
        }
        public function getUsuario()
        {
            return $this->nome_usuario;
        }
        public function getCpf()
        {
            return $this->cpf;
        }
        public function getRg()
        {
            return $this->rg;
        }
        public function getEmail()
        {
            return $this->email;
        }

        public function getSenha()
        {
            return $this->senha;
        }

        public function getImagem()
        {
            return $this->imagem;
        }


        public function incluir()
        {
            $conexao = Database::getInstance();


            $sql = 'INSERT INTO usuarios (nome, nome_usuario, email, cpf,rg,senha,imagem) 
          VALUES (:Nome, :Nome_usuario, :Email, :CPF, :RG, :Senha, :Imagem)';



            $comando = $conexao->prepare($sql);
            $comando->bindValue(':Nome', $this->nome);
            $comando->bindValue(':Nome_usuario', $this->nome_usuario);
            $comando->bindValue(':Email', $this->email);
            $comando->bindValue(':CPF', $this->cpf);
            $comando->bindValue(':RG', $this->rg);
            $comando->bindValue(':Senha', $this->senha);
            $comando->bindValue(':Imagem', $this->imagem);

            return $comando->execute();
        }

        public function excluir()
        {
            $conexao = Database::getInstance();
            $sql = 'DELETE 
                        FROM usuarios
                        WHERE id = :id';
            $comando = $conexao->prepare($sql);
            $comando->bindValue(':id', $this->id);
            return $comando->execute();
        }


        public function alterar()
        {
            $conexao = Database::getInstance();
            $sql = 'UPDATE usuarios 
                        SET nome = :Nome, nome_usuario = :Nome_usuario, imagem = :Imagem, cpf = :Cpf, rg = :Rg, email = :Email, senha = :Senha
                        WHERE idUsuario = :id';
            $comando = $conexao->prepare($sql);
            $comando->bindValue(':id', $this->id);
            $comando->bindValue(':Nome', $this->nome);
            $comando->bindValue(':Nome_usuario', $this->nome_usuario);
            $comando->bindValue(':Email', $this->email);
            $comando->bindValue(':Cpf', $this->cpf);
            $comando->bindValue(':Rg', $this->rg);
            $comando->bindValue(':Senha', $this->senha);
            $comando->bindValue(':Imagem', $this->imagem);
            return $comando->execute();
        }

        public static function login()
        {
            $conexao = Database::getInstance();
            $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : "";
            $sql = "SELECT * from usuarios WHERE nome_usuario = :usuario ";
            $comando = $conexao->prepare($sql);
            $comando->bindValue(':usuario', $usuario);
            $comando->execute();
            if ($comando->rowCount() > 0) {
                $user = $comando->fetchAll();
                return $user;
            }
            return null;
        }


        public static function listar($id)
        {
            $conexao = Database::getInstance();
            $sql = "SELECT * FROM usuarios WHERE idUsuario = :idUsuario"; // Indica que queremos selecionar todos os campos da tabela pessoa, e a consulta deve ser nessa tebela
            $comando = $conexao->prepare($sql);
            $comando->bindValue(':idUsuario', $id);
            $comando->execute();
            $usuarios = array();

            while ($registro  = $comando->fetch()) {
                $usuario = new Usuario($registro['idUsuario'], $registro['nome'], $registro['nome_usuario'], $registro['email'], $registro['cpf'], $registro['rg'], $registro['senha'], $registro['imagem']); // Um novo objeto Pessoa é criado usando os valores dos campos id, nome e telefone do registro atual.
                array_push($usuarios, $usuario);
            }
            return $usuarios;
        }


        public static function Dados($id)
        {
            $conexao = Database::getInstance();
            $sql = "SELECT * FROM usuarios WHERE idUsuario = :id";
            $comando = $conexao->prepare($sql);
            $comando->bindValue(':id', $id);
            $comando->execute();

            if ($registro  = $comando->fetch()) {
                return new Usuario($registro['idUsuario'], $registro['nome'], $registro['nome_usuario'], $registro['email'], $registro['cpf'], $registro['rg'], $registro['senha'], $registro['imagem']);
            }

            return null;
        }

        public static function NomeUsuario($nome)
        {
            $conexao = Database::getInstance();
            $sql = "SELECT * FROM usuarios WHERE nome_usuario = :nome";
            $comando = $conexao->prepare($sql);
            $comando->bindValue(':nome', $nome);
            $comando->execute();
            if ($comando->rowCount() > 0) {
                return "Já existe";
            }
            return null;
        }
    }
