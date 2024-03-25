 <?php
class Usuario
{
    private $id;
    private $nome;
    private $nome_usuario;
    private $cpf;
    private $rg;
    private $email;
    private $senha;

    public function __construct($id = 0, $nome = "", $nome_usuario = "",$cpf = 0, $rg = 0, $email = "", $senha = 0, $imagem = ""){
        $this->setId($id); 
        $this->setNome($nome); 
        $this->setUsuario($nome_usuario);
        $this->setCpf($cpf);
        $this->setRg($rg);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setImagem($imagem)
    }

    public function setId($novoId){
        if ($novoId < 0) // verifica se é um ID valido
            echo "Erro: id inválido!"; // mensagem de erro
        else
            $this->id = $novoId; //Se o valor for válido, o método o atribui ao atributo $id usando a palavra-chave $this.
    }
    // função que define (set) o valor de um atributo
    // Define o valor do atributo $nome
    public function setNome($novoNome){ 
        if ($novoNome == "") // verifica se a sting $novoNome é vazia
            echo "Erro: nome inválido!"; // mensagem de erro
        else
            $this->nome = $novoNome; // atribui ao atributo nome o $novoNome
    }
    //define o valor do atributo $telefone
    public function setUsuario($novoUsuario){
        if ($novoUsuario == "") // Verifica se a string $novoTelefone é vazia
            echo "Erro: Usuario inválido!"; // mensagem de erro
        else
            $this->nome_usuario = $novoUsuario; // Atribui ao atributo telefone o $novoTelefone
    }

    public function setCpf($novoCpf){
        if ($novoCPF == "") // Verifica se a string $novoTelefone é vazia
            echo "Erro: CPF inválido!"; // mensagem de erro
        else
            $this->cpf = $novoCpf; // Atribui ao atributo telefone o $novoTelefone
    }

    public function setRg($novoRg){
        if ($novoRg == "") // Verifica se a string $novoTelefone é vazia
            echo "Erro: RG inválido!"; // mensagem de erro
        else
            $this->rg = $novoRg; // Atribui ao atributo telefone o $novoTelefone
    }
    public function setEmail($novoEmail){
        if ($novoEmail == "") // Verifica se a string $novoTelefone é vazia
            echo "Erro: Email inválido!"; // mensagem de erro
        else
            $this->email = $novoEmail; // Atribui ao atributo telefone o $novoTelefone
    }

    public function setSenha($novoSenha){
        if ($novoSenha == "") // Verifica se a string $novoTelefone é vazia
            echo "Erro: Senha inválido!"; // mensagem de erro
        else
            $this->senha = $novoSenha; // Atribui ao atributo telefone o $novoTelefone
    }

    
    public function setImagem($novoImagem){
        if ($novoImagem == "") // Verifica se a string $novoTelefone é vazia
            echo "Erro: Imagem inválido!"; // mensagem de erro
        else
            $this->imagem = $novoImagem; // Atribui ao atributo telefone o $novoTelefone
    }


    // função para ler (get) o valor de um atributo da classe
    public function getId(){ 
        return $this->id; // Função retorna o valor do atributo ID
    }
    public function getNome() { 
        return $this->nome; // Função retorna o valor do atributo nome
    }
    public function getUsuario() { 
        return $this->usuario; // Função retorna o valor do atributo telefone
    }
    public function getCpf() { 
        return $this->cpf; // Função retorna o valor do atributo telefone
    }
    public function getRg() { 
        return $this->rg; // Função retorna o valor do atributo telefone
    }
    public function getEmail() { 
        return $this->email; // Função retorna o valor do atributo telefone
    }

    public function getSenha() { 
        return $this->senha; // Função retorna o valor do atributo telefone
    }

    public function getImagem()
    {
        return $this->imagem;
    }

    /***
     * Inclui uma pessoa no banco  */     
    public function incluir($conexao){

        /** Armazena a String $sql para inserir uma nova pessoa, utilizando os parâmetro utilizando 
         * parâmetros nomeados como nome e telefone 
         */
        $sql = 'INSERT INTO usuarios (Nome, Nome_usuario, , Email, Cpf, Rg, Senha) 
                     VALUES (:nome, :usuario, :cpf, :rg, )';
        $comando = $conexao->prepare($sql);  // prepara o comando para executar no banco de dados
        $comando->bindValue(':nome',$this->nome); // vincula o valor do atributo nome do objeto atual ao parâmetro :nome
        $comando->bindValue(':telefone',$this->telefone); // vincula o valor do atributo telefone do objeto atual ao parâmetro :telefone
        return $comando->execute(); // executa o comando
    }    
    /** Método para excluir uma pessoa do banco de dados */
    public function excluir($conexao){ 
        // especifica qual pessoa quer excluir e armazena na var $sql
        $sql = 'DELETE 
                FROM pessoa
                WHERE id = :id';
        $comando = $conexao->prepare($sql); // prepara o comando
        $comando->bindValue(':id',$this->id); // vincula o valor do atributo id do objeto atual ao parâmetro :id
        return $comando->execute(); // retorna o comando execute como true, se a pessoa foi excluída
    }  

    /**
     * Essa função altera os dados de uma pessoa no banco de dados
     */
    public function alterar($conexao){
        // Define a sting SQL para atualizar os dados de uma pessoa e armazena na var $sql 
        $sql = 'UPDATE pessoa 
                SET nome = :nome, telefone = :telefone
                WHERE id = :id';
        $comando = $conexao->prepare($sql); //prepara o comando SQL para execução
        $comando->bindValue(':id',$this->id); // Vincula o valor do atributo ID com o atual parâmetro do comando SQL
        $comando->bindValue(':nome',$this->nome); // Vincula o valor do atributo Nome com o atual parâmetro do comando SQL
        $comando->bindValue(':telefone',$this->telefone); // Vincula o valor do atributo telefone com o atual parâmetro do comando SQL
        return $comando->execute(); // retorna o comando execute como true, se a pessoa foi alterada
    } 

    // Esta função lista as pessoas no banco de acordo com o tipo de filtro
    public function listar($conexao, $tipo = 0, $busca = "" ){
        // montar consulta
        $sql = "SELECT * FROM pessoa"; // Indica que queremos selecionar todos os campos da tabela pessoa, e a consulta deve ser nessa tebela
        if ($tipo > 0 ) // verifica se o tipo de ID é válido
            switch($tipo){
                case 1: $sql .= " WHERE id = :busca"; break; // tipo do filtro, se for 1 é pelo ID
                case 2: $sql .= " WHERE nome like :busca"; $busca = "%{$busca}%"; break; // tipo do filtro, se for 2 é pelo Nome
                case 3: $sql .= " WHERE telefone like :busca";  $busca = "%{$busca}%";  break; // tipo do filtro, se for 3 é pelo Telefone
            }

        // prepara o comando
        $comando = $conexao->prepare($sql); // preparar comando
        // vincular os parâmetros
        if ($tipo > 0 )
            $comando->bindValue(':busca',$busca); // Vincula o valor do atributo busca com o parâmetro :busca

        // executar consulta
        $comando->execute(); // executar comando
        $pessoas = array(); // Define que $pessoas é um array()
        
        // listar o resultado da consulta         
        while($registro  = $comando->fetch()){ // Este método recupera o próximo registro da consulta SQL e retorna false quando não há mais registros.
            $pessoa = new Pessoa($registro['id'],$registro['nome'],$registro['telefone'] ); // Um novo objeto Pessoa é criado usando os valores dos campos id, nome e telefone do registro atual.
            array_push($pessoas,$pessoa); // array_push colocaa pessoa criada no array pessoas
        }
        return $pessoas;  // retorna o array $pessoas
    }    
} 