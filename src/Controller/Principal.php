<?php
namespace Concessionaria\Projetob\Controller;
use Concessionaria\Projetob\Model\Veiculos;

class Principal
{
    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;
    private Veiculos $veiculosDados;

     public function __construct()
     {
        $this->carregador = new \Twig\Loader\FilesystemLoader("./src/View");
        $this->ambiente = new \Twig\Environment($this->carregador);
        
        $this->veiculosDados = new Veiculos();
     }  

     public function inicio()
    {
        echo $this->ambiente->render("inicio.html");
    }

     public function catalogo()
    {
        $listaVeiculos = $this->veiculosDados->veiculosSelectAll();

        echo $this->ambiente->render("veiculos/catalogo.html", ['veiculos' => $listaVeiculos]);
    }
    public function login()
    {
        echo $this->ambiente->render("teste.html");
        
    }
    public function loginDuo()
    {
        echo $this->ambiente->render("teste.html");
    }
}
?>