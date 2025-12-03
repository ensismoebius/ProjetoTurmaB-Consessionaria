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
    public ?string $cor;       // versão sua (aceita nulo)
    public float $preco;       // versão sua (não nulo)
    public ?int $quilometragem; // ambos concordam

    private \PDO $conexao;

    public function __construct() {
        $this->conexao = Database::getConexao();
    }

    public function buscarVeiculos(string $termo): array
    {
        $stmt = $this->conexao->prepare(
            "SELECT * FROM veiculos WHERE marca LIKE :termo OR modelo LIKE :termo OR cor LIKE :termo OR descricao LIKE :termo"
        );
        $stmt->bindValue(':termo', "%$termo%");
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $listaVeiculos = [];

        foreach ($dados as $item) {
            $veiculo = new Veiculos();
            $veiculo->id = $item['id'];
            $veiculo->imagem = $item['imagem'];
            $veiculo->marca = $item['marca'];
            $veiculo->modelo = $item['modelo'];
            $veiculo->descricao = $item['descricao'];
            $veiculo->ano = $item['ano'];
            $veiculo->cor = $item['cor'];
            $veiculo->preco = $item["preco"];
            $veiculo->quilometragem = $item["quilometragem"];

            $listaVeiculos[] = $veiculo;
        }

        return $listaVeiculos;
    }

    public function veiculosSelectAll(): array
    {
        $stmt = $this->conexao->query("SELECT * FROM veiculos");
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $listaVeiculos = [];

        foreach ($dados as $item) {
            $veiculo = new Veiculos();
            $veiculo->id = $item["id"];
            $veiculo->imagem = $item["imagem"];
            $veiculo->marca = $item["marca"];
            $veiculo->modelo = $item["modelo"];
            $veiculo->descricao = $item["descricao"];
            $veiculo->ano = $item["ano"];
            $veiculo->cor = $item["cor"];
            $veiculo->preco = $item["preco"];
            $veiculo->quilometragem = $item["quilometragem"];

            $listaVeiculos[] = $veiculo;
        }
        return $listaVeiculos;
    }

    public function veiculosDetalhes(int $id): ?Veiculos
    {
        $stmt = $this->conexao->prepare("SELECT * FROM veiculos WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetch();

        if (!$dados) {
            return null;
        }

        $veiculo = new Veiculos();
        $veiculo->id = $dados["id"];
        $veiculo->imagem = $dados["imagem"];
        $veiculo->marca = $dados["marca"];
        $veiculo->modelo = $dados["modelo"];
        $veiculo->descricao = $dados["descricao"];
        $veiculo->ano = $dados["ano"];
        $veiculo->cor = $dados["cor"];
        $veiculo->preco = $dados["preco"];
        $veiculo->quilometragem = $dados["quilometragem"];

        return $veiculo;
    }

    // Galeria de imagens opcional
    public function galeriaImagens(int $id): array
    {
        $stmt = $this->conexao->prepare("SELECT arquivo FROM veiculos_imagens WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /*
    CREATE TABLE veiculos_imagens (
        id_imagem INT AUTO_INCREMENT PRIMARY KEY,
        id INT NOT NULL,
        arquivo VARCHAR(255) NOT NULL,
        FOREIGN KEY (id) REFERENCES veiculos(id)
    );

    CREATE TABLE veiculos(
        id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
        marca VARCHAR(255) NOT NULL,
        modelo VARCHAR(255) NOT NULL,
        ano YEAR,
        preco DOUBLE(10,2),
        quilometragem INT,
        descricao VARCHAR(500),
        cor VARCHAR(255) NOT NULL,
        imagem VARCHAR(255)
    );
    */
}
