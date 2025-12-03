<?php
namespace Concessionaria\Projetob\Controller;
use Concessionaria\Projetob\Model\Proposta;
use Concessionaria\Projetob\Model\PropostaModel;
use Concessionaria\Projetob\Model\Database;

class PropostaController
{
    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;
    private \PDO $conexao;


    public function __construct($router)
    {
        $this->carregador = new \Twig\Loader\FilesystemLoader("./src/View/propostas");

        $this->ambiente = new \Twig\Environment($this->carregador);

        $this->conexao = Database::getConexao();
    }

    public function inicio()
    {
        echo $this->ambiente->render("proposta.html");
    }
    public function enviar()
    {
        $proposta = new Proposta();
        session_start();
        $proposta->nome = $_POST['nome'];
        $proposta->email = $_POST['email'];

        $bd = new PropostaModel($this->conexao);

        $bd->salvarProposta($proposta);

        $req = curl_init();
        curl_setopt($req,  CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($req,  CURLOPT_URL, 'https://formspree.io/f/mbljrnkp');
    }
}
?>