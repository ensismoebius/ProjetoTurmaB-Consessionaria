<?php
namespace Concessionaria\Projetob\Controller;

class Veiculos
{
    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;

    public function __construct()
    {
        $this->carregador = new \Twig\Loader\FilesystemLoader("./src/View");
        $this->ambiente = new \Twig\Environment($this->carregador);
    }

    /**
     * Renderiza a página de detalhes do veículo.
     * Recebe o parâmetro 'id' via rota: /veiculos/{id}
     */
    public function detalhes($data): void
    {
        // extrai o id se necessário (não usamos para não mexer no front-end/BD)
        $id = null;
        if (is_array($data) && array_key_exists('id', $data)) {
            $id = $data['id'];
        }

        // Renderiza a view estática de detalhes (sem tocar no HTML)
        echo $this->ambiente->render('veiculos/show.html');
    }
}
