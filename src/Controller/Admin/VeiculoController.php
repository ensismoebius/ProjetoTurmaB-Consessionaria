<?php
namespace Concessionaria\Projetob\Controller\Admin;




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


}