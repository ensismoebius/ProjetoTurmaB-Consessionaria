<?php
namespace Concessionaria\Projetob\Controller;
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
        // $bd = new PropostaModel();
        // $bd->salvarProposta();

        // Define os dados a serem enviados (MUDANÇA MÍNIMA: Apenas 2 linhas de dados)
        $dados_post = http_build_query([
            'email'   => 'contato@exemplo.com',
            'message' => 'Post de teste via PHP!',
        ]);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://formspree.io/f/mbljrnkp");

        // OPÇÕES DE POST (MUDANÇA MÍNIMA: 2 linhas de curl_setopt)
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dados_post);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Não joga a resposta na tela, armazena para a variável
        $resposta = curl_exec($curl);

        // Adicionado: Verificação de erro, caso o Formspree te ignore
        if (curl_errno($curl)) {
            echo 'Erro cURL: ' . curl_error($curl);
        }

        curl_close($curl);
    }
}
?>