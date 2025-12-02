<?php
namespace Concessionaria\Projetob\Model;

use Concessionaria\Projetob\Model\Database;
use PDO;

class Veiculos
{
    public int $id;
    public ?string $imagem;
    public string $marca;
    public string $modelo;
    public ?string $descricao;
    public ?int $ano;
    public ?string $cor;
    public ?float $preco;
    public ?int $quilometragem;
    public ?string $status;
    public ?int $criado_em;
}
