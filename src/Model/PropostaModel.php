<?php
namespace Concessionaria\Projetob\Model;

class PropostaModel
{
    public function salvarProposta()
    {
    $oCon = new \PDO('mysql:host=localhost; dbname=PRJ2DSB', 'Aluno2DS', 'SenhaBD2');

// id é um placeholder e deve ser alterado para pegar o id do usuario
    $id = 1;
    $data = date("d/m/Y");
// valor é um placeholder e deve ser alterado para pegar o valor do item do carrinho
    $valor = 100;
// id do item do carrinho, placeholder dnv
    $id_item = 1;

    $cSQL = "INSERT INTO PEDIDOS(id_pedido, id_cliente, data_venda, valor_pedido, id_itpd) VALUES(1, $id, $data, $valor, $id_item)";
    $oCon->exec($cSQL);
    
    }
}