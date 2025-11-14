<?php
namespace Concessionaria\Projetob\Model;
use Concessionaria\Projetob\Model\Database;
use PDO;

class Veiculos
{   
    public int $id;
    public string $imagem;
    public string $marca;
    public string $modelo;
    public ?string $descricao;
    public ?int $ano;
    public string $cor;
    private \PDO $conexao;

    public function __construct(){
        $this->conexao = Database::getConexao();
    }

    public function buscarVeiculos(string $termo): array
    {
        $stmt = $this->conexao->prepare("SELECT * FROM veiculos WHERE marca LIKE :termo OR modelo LIKE :termo OR cor LIKE :termo OR descricao LIKE :termo");
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

    // Esse trecho vai buscar as imagens que ficarão na galeria de imagens, de cada veículo. Essa galeria de imagens é formada em uma tabela separada no banco de dados, que vai ser ligada à tabela de veículos pelo id do veículo. É opcional essa parte ser usada nos detalhes do carro.
    public function galeriaImagens(int $id): array
    {
        $stmt = $this->conexao->prepare("SELECT arquivo FROM veiculos_imagens WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    //codigo abaixo é para criar e testar a tabela de galeria de imagens no banco de dados
    /* CREATE TABLE veiculos_imagens (
    id_imagem INT AUTO_INCREMENT PRIMARY KEY,
    id INT NOT NULL,
    arquivo VARCHAR(255) NOT NULL,
    FOREIGN KEY (id) REFERENCES veiculos(id)
    ); 
    */

    // codigo abaixo é para criar e testar a tabela de veiculos no banco de dados
    /* create table veiculos(
	id int primary key not null auto_increment,
    marca varchar(255) NOT NULL,
    modelo varchar(255) NOT NULL,
    ano YEAR,
    preco double(10,2),
    quilometragem int,
    descricao varchar(500),
    cor varchar(255) NOT NULL,
    imagem varchar(255));
    */
}
