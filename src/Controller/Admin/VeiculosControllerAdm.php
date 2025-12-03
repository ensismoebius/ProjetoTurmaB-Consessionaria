<?php
namespace Concessionaria\Projetob\Controller\Admin;

use PDO;
use Concessionaria\Projetob\Model\Database;

class VeiculosControllerAdm
{

    private \PDO $conexao;
    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;

    public function __construct()
    {
        $this->carregador = new \Twig\Loader\FilesystemLoader(__DIR__ . "/../../View");
        $this->ambiente = new \Twig\Environment($this->carregador);
        $this->conexao = Database::getConexao();
    }

    public function gerenciamento_de_veiculos()
    { 
        
        session_start();
        if(!isset($_SESSION['role']) !== 1){
            echo "Acesso negado. Você não tem permissão para acessar esta página.";
            return;
        }

        $stmt = $this->conexao->query("SELECT id_veiculos, marca, modelo, preco, ano FROM VEICULOS ORDER BY id_veiculos DESC");
        $veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo $this->ambiente->render("Admin/veiculos\gerenciamento_de_veiculos.html", ['veiculos' => $veiculos]);
    }
    public function showCreateForm()
    {

        session_start();
        if(!isset($_SESSION['role']) !== 1){
            echo "Acesso negado. Você não tem permissão para acessar esta página.";
            return;
        }

        echo $this->ambiente->render("Admin/veiculos/form.html");
    }

    public function salvarVeiculo(array $data)
    {
        $marca = $data["marca"] ?? null;
        $modelo = $data["modelo"] ?? null;
        $preco = $data["preco"] ?? null;
        $quilometragem = $data["quilometragem"] ?? null;
        $descricao = $data["descricao"] ?? null;
        $ano = $data["ano"] ?? null;
        $cor = $data["cor"] ?? null;

        if (!$marca || !$modelo || !$preco) {
            echo "Campos obrigatórios não enviados!";
            return;
        }

        // upload da imagem
        $imagem = null;

        if (!empty($_FILES["imagem"]["name"])) {

            $pasta = $_SERVER["DOCUMENT_ROOT"] . "/ProjetoTurmaB-Consessionaria/public/assets/img/";

            if (!is_dir($pasta)) {
                mkdir($pasta, 0777, true);
            }

            $nomeArquivo = uniqid() . "_" . basename($_FILES["imagem"]["name"]);
            $caminhoFinal = $pasta . $nomeArquivo;
            // Verificar campos obrigatórios
            if (!$marca || !$modelo || !$preco || !$quilometragem) {
                echo "Campos obrigatórios não enviados!";
                return;
            }

            // upload da imagem
            $imagem = null;

            if (!empty($_FILES["imagem"]["name"])) {
                $pasta = $_SERVER["DOCUMENT_ROOT"] . "/ProjetoTurmaB-Consessionaria/public/assets/img/";

                if (!is_dir($pasta)) {
                    mkdir($pasta, 0777, true);
                }

                $nomeArquivo = uniqid() . "_" . basename($_FILES["imagem"]["name"]);
                $caminhoFinal = $pasta . $nomeArquivo;

                if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoFinal)) {
                    $imagem = $nomeArquivo;
                }
            }

            $sql = "INSERT INTO VEICULOS(marca, modelo, preco, imagem, quilometragem, descricao, ano, cor)
                VALUES (:marca, :modelo, :preco, :imagem, :quilometragem, :descricao, :ano, :cor)";

            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(":marca", $marca);
            $stmt->bindValue(":modelo", $modelo);
            $stmt->bindValue(":preco", $preco);
            $stmt->bindValue(":imagem", $imagem);
            $stmt->bindValue(":quilometragem", $quilometragem);
            // continue com os outros bindValue normalmente
            if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoFinal)) {
                $imagem = $nomeArquivo;
            }
        }
        
        $sql = "INSERT INTO VEICULOS(marca, modelo, preco, imagem, quilometragem, descricao, ano, cor)
            VALUES (:marca, :modelo, :preco, :imagem, :quilometragem, :descricao, :ano, :cor)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(":marca", $marca);
        $stmt->bindValue(":modelo", $modelo);
        $stmt->bindValue(":preco", $preco);
        $stmt->bindValue(":imagem", $imagem);
        $stmt->bindValue(":quilometragem", $quilometragem);
        $stmt->bindValue(":descricao", $descricao);
        $stmt->bindValue(":ano", $ano);
        $stmt->bindValue(":cor", $cor);

        $stmt->execute();

        header("Location: /ProjetoTurmaB-Consessionaria/veiculos");
        exit;
    }

    public function formEditar(array $data)
    {

        session_start();
        if(!isset($_SESSION['role']) !== 1){
            echo "Acesso negado. Você não tem permissão para acessar esta página.";
            return;
        }

        $id = (int) ($data['id_veiculos'] ?? 0); //consulta o id, se existe ou nao
        if ($id <= 0) {
            echo "Id inválido";
            return;
        }

        $stmt = $this->conexao->prepare("SELECT * FROM VEICULOS WHERE id_veiculos = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$veiculo) { //se nao tiver veiculo da msg de erro
            echo "Veículo não encontrado";
            return;
        }

        echo $this->ambiente->render("Admin/veiculos/form.html", ['veiculo' => $veiculo]);
    }

    public function atualizarVeiculo(array $data)
    {

        session_start();
        if(!isset($_SESSION['role']) !== 1){
            echo "Acesso negado. Você não tem permissão para acessar esta página.";
            return;
        }

        $id = (int) ($data['id_veiculos'] ?? 0);
        if ($id <= 0) {
            echo "Id inválido";
            return;
        }

        $marca = $data['marca'] ?? null;
        $modelo = $data['modelo'] ?? null;
        $preco = $data['preco'] ?? null;
        $descricao = $data['descricao'] ?? null;
        $quilometragem = $data['quilometragem'] ?? null;
        $ano = $data['ano'] ?? null;
        $cor = $data['cor'] ?? null;

        $pasta = $_SERVER["DOCUMENT_ROOT"] . "/ProjetoTurmaB-Consessionaria/public/assets/img/"; //vai pra pasta de imgs
        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $imagem = null;
        if (!empty($_FILES['imagem']['name'])) {
            $nomeArquivo = uniqid() . "_" . basename($_FILES['imagem']['name']);
            $caminhoFinal = $pasta . $nomeArquivo;
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoFinal)) {
                $imagem = $nomeArquivo;
            }
        }
        

        $sql = "UPDATE VEICULOS SET marca = :marca, modelo = :modelo, preco = :preco, descricao = :descricao, quilometragem = :quilometragem, ano = :ano, cor = :cor";
        if ($imagem) {
            $sql .= ", imagem = :imagem";
        }
        $sql .= " WHERE id_veiculos = :id";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':marca', $marca);
        $stmt->bindValue(':modelo', $modelo);
        $stmt->bindValue(':preco', $preco);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(":quilometragem", $quilometragem);
        $stmt->bindValue(':ano', $ano);
        $stmt->bindValue(':cor', $cor);
        if ($imagem) {
            $stmt->bindValue(':imagem', $imagem);
        }
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        header("Location: /ProjetoTurmaB-Consessionaria/admin/veiculos");
        exit;
    }

    public function removerVeiculo(array $data)
    {

        session_start();
        if(!isset($_SESSION['role']) !== 1){
            echo "Acesso negado. Você não tem permissão para acessar esta página.";
            return;
        }

        $id = (int) ($data['id_veiculos'] ?? $data['id_veiculos'] ?? 0);
        if ($id <= 0) {
            echo "Id inválido";
            return;
        }
    
        $stmt = $this->conexao->prepare("DELETE FROM VEICULOS WHERE id_veiculos = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: /ProjetoTurmaB-Consessionaria/admin/veiculos");
        exit;
    }
}
