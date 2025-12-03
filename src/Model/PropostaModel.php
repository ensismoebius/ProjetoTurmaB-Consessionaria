<?php
namespace Concessionaria\Projetob\Model;
use PDO;
use Concessionaria\Projetob\Model\Database;

class PropostaModel
{       
    private PDO $conexao;
    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }
    public function salvarProposta(Proposta $proposta)
    {
        $cSQL = $this->conexao->prepare("INSERT INTO PROPOSTAS(NOME_CLIENTE, EMAIL_CLIENTE) VALUES(:nome, :email)");

        $cSQL->bindValue(":nome", $proposta->nome);
        $cSQL->bindValue(":email", $proposta->email);

        $cSQL->execute();
    }
}