<?php

namespace Concessionaria\Projetob\Model;

use PDO;

class VeiculosRepository
{
    private PDO $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function buscarVeiculos(string $termo): array
    {
        $stmt = $this->conexao->prepare("SELECT * FROM VEICULOS WHERE marca LIKE :termo OR modelo LIKE :termo OR cor LIKE :termo OR descricao LIKE :termo OR ano LIKE :termo");
        $stmt->bindValue(':termo', "%$termo%");
        $stmt->execute();

        $listaVeiculos = [];
        while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $veiculo = new Veiculos();
            $veiculo->id = $item['id_veiculos'];
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
        $stmt = $this->conexao->query("SELECT * FROM VEICULOS");
        $listaVeiculos = [];

        while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $veiculo = new Veiculos();
            $veiculo->id = $item["id_veiculos"];
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
        $stmt = $this->conexao->prepare("SELECT * FROM VEICULOS WHERE id_veiculos = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        $veiculo = new Veiculos();
        $veiculo->id = $dados["id_veiculos"];
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

    public function galeriaImagens(int $id): array
    {
        $stmt = $this->conexao->prepare("SELECT arquivo FROM VEICULOS_IMAGENS WHERE veiculoimg_id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function paginarVeiculo(int $pagina, int $limite): array
    {
        $offset = ($pagina - 1) * $limite;

        $stmt = $this->conexao->prepare("SELECT * FROM VEICULOS LIMIT :offset, :limite");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute(); 

        $listaVeiculos = [];
        while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $veiculo = new Veiculos();
            $veiculo->id = $item['id_veiculos'];
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
}
