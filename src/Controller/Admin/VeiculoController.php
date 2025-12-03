<?php
namespace Concessionaria\Projetob\Controller\Admin;

 use PDO;  



class VeiculoController

{
    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;
   
    public function __construct()
    {
          
          
          
          
          
          
  $this->carregador = new \Twig\Loader\FilesystemLoader(__DIR__ . "/../../View");
        $this->ambiente = new \Twig\Environment($this->carregador);
    }
   public function showCreateForm()
    {
       echo $this->ambiente->render("Admin/veiculos/form.html");

    }

 public function salvarVeiculo(array $data)
{
    $marca     = $data["marca"] ?? null;
    $modelo    = $data["modelo"] ?? null;
    $preco     = $data["preco"] ?? null;

    // novos campos
    $descricao = $data["descricao"] ?? null;
    $ano       = $data["ano"] ?? null;
    $cor       = $data["cor"] ?? null;

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

if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoFinal)) {
    $imagem = $nomeArquivo; // só o nome vai pro banco
}
    }
    // conexão
    $conexao = new PDO(
        "mysql:host=localhost;dbname=PRJ2DSB;charset=utf8",
        "root",
        ""
    );
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // INSERT atualizado
    $sql = "INSERT INTO veiculos (marca, modelo, preco, imagem, descricao, ano, cor)
            VALUES (:marca, :modelo, :preco, :imagem, :descricao, :ano, :cor)";

    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(":marca", $marca);
    $stmt->bindValue(":modelo", $modelo);
    $stmt->bindValue(":preco", $preco);
    $stmt->bindValue(":imagem", $imagem);

    // novos binds
    $stmt->bindValue(":descricao", $descricao);
    $stmt->bindValue(":ano", $ano);
    $stmt->bindValue(":cor", $cor);

    $stmt->execute();

    header("Location: /ProjetoTurmaB-Consessionaria/veiculos");
    exit;
}
public function showEditForm(int $id)
{
    
    $conexao = new PDO(
        "mysql:host=localhost;dbname=PRJ2DSB;charset=utf8",
        "root",
        ""
    );
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM veiculos WHERE id = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$veiculo) {
        echo "Veículo não encontrado!";
        return;
    }


    echo $this->ambiente->render("Admin/veiculos/form.html", [
        "veiculo" => $veiculo
    ]);
}



}
