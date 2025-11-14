<?php
namespace Concessionaria\Projetob\Model;

class PropostaModel
{
    public function salvarProposta(Proposta $proposta)
    {
        $oCon = new \PDO('mysql:host=localhost; dbname=PRJ2DSB', 'Aluno2DS', 'SenhaBD2');

        $cSQL = $this->$oCon->prepare("INSERT INTO PROPOSTAS(VEICULO_ID, NOME_CLIENTE, EMAIL_CLIENTE, TIPO, DATA_PROPOSTA) VALUES(:veiculo, :nome, :email, :tipo, :data_proposta)");

        $cSQL->bindValue(":veiculo", $proposta->veiculo_id);
        $cSQL->bindValue(":nome", $proposta->nome_cliente);
        $cSQL->bindValue(":email", $proposta->email_cliente);
        $cSQL->bindValue(":tipo", $proposta->tipo);
        $cSQL->bindValue(":data", $proposta->data_proposta);

        $oCon->exec($cSQL); 
    }
}