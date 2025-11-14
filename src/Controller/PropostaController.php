<?php
namespace Concessionaria\Projetob\Controller;
use Concessionaria\Projetob\Model\Proposta;
use Concessionaria\Projetob\Model\PropostaModel;

class PropostaController
{
    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;

    public function __construct()
    {
        $this->carregador = new \Twig\Loader\FilesystemLoader("./src/View");

        $this->ambiente = new \Twig\Environment($this->carregador);
    }

    public function inicio()
    {
        echo $this->ambiente->render("proposta.html");
    }
    public function enviar()
    {
        $proposta = new Proposta();
        session_start();
        $proposta->veiculo = $_SESSION['veiculo'];
        $proposta->nome = $_POST['nome'];
        $proposta->email = $_POST['email'];
        $proposta->opcao = $_POST['opcao'];
        $proposta->data_proposta = $_POST['data'];

        $bd = new PropostaModel();
        $bd->salvarProposta($proposta);
        header("https://formspree.io/f/mbljrnkp");
    }
}
?>