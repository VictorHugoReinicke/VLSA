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
            $sql = 'INSERT INTO usuarios (nome, nome_usuario, email, cpf,rg,senha,imagem) 
            VALUES (:Nome, :Nome_usuario, :Email, :CPF, :RG, :Senha, :Imagem)';

            $parametros = [':Nome' => $this->getNome(), ':Nome_usuario' => $this->getUsuario(), ':Email' => $this->getEmail(), ':CPF' => $this->getCpf(), ':RG' => $this->getRg(), ':Senha' => $this->getSenha(), ':Imagem' => $this->getImagem()];

            return Database::executar($sql, $parametros);
        }

        public function excluir()
        {
            $conexao = Database::getInstance();
            $sql = 'DELETE 
                        FROM usuarios
                        WHERE idUsuario = :id';
            $comando = $conexao->prepare($sql);
            $comando->bindValue(':id', $this->getId());
            return $comando->execute();
        }


        public function alterar()
        {
            $sql = 'UPDATE usuarios 
                        SET nome = :Nome, nome_usuario = :Nome_usuario, imagem = :Imagem, cpf = :Cpf, rg = :Rg, email = :Email, senha = :Senha
                        WHERE idUsuario = :id';

            $parametros = [':id' => $this->getId(), ':Nome' => $this->getNome(), ':Nome_usuario' => $this->getUsuario(), ':Email' => $this->getEmail(), ':CPF' => $this->getCpf(), ':RG' => $this->getRg(), ':Senha' => $this->getSenha(), ':Imagem' => $this->getImagem()];

            return Database::executar($sql, $parametros);
        }

        public static function login($usuario)
        {
            $sql = "SELECT * from usuarios WHERE nome_usuario = :usuario ";
            $parametros = [":usuario" => $usuario];
        
            $comando = Database::executar($sql, $parametros);
        
            if ($comando->rowCount() > 0) {
                return  $comando->fetchAll();
            }
            return null;
        }

        public static function listar($id)
        {
            $sql = "SELECT * FROM usuarios WHERE idUsuario = :idUsuario";

            $parametros = [':idUsuario' => $id];

            $comando = Database::executar($sql, $parametros);

            while ($registro  = $comando->fetch(PDO::FETCH_ASSOC)) {
                $usuario[] = new Usuario($registro['idUsuario'], $registro['nome'], $registro['nome_usuario'], $registro['email'], $registro['cpf'], $registro['rg'], $registro['senha'], $registro['imagem']); // Um novo objeto Pessoa é criado usando os valores dos campos id, nome e telefone do registro atual.
            }
            return $usuario;
        }


        public static function Dados($id)
        {
            $sql = "SELECT * FROM usuarios WHERE idUsuario = :id";

            $parametros = [':id' => $id];
            $comando = Database::executar($sql, $parametros);
            if ($registro  = $comando->fetch(PDO::FETCH_ASSOC)) {
                return new Usuario($registro['idUsuario'], $registro['nome'], $registro['nome_usuario'], $registro['email'], $registro['cpf'], $registro['rg'], $registro['senha'], $registro['imagem']);
            }

            return null;
        }

        public static function NomeUsuario($nome)
        {
            $sql = "SELECT * FROM usuarios WHERE nome_usuario = :nome";

            $parametros = [':nome'=> $nome];

            $comando = Database::executar($sql, $parametros);
            if ($comando->rowCount() > 0) {
                return "Já existe";
            }
            return null;
        }
    }
