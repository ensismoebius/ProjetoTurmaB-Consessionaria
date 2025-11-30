<?php
namespace Concessionaria\Projetob\Controller;
use Concessionaria\Projetob\Model\VeiculosRepository;
use Concessionaria\Projetob\Model\Database;
use Concessionaria\Projetob\Model\UserRepository;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Principal
{
    private Environment $ambiente;
    private FilesystemLoader $carregador;
    private VeiculosRepository $veiculosRepository;

    public function __construct()
    {
        $this->carregador = new FilesystemLoader($_ENV['TWIG_VIEW_PATH']);
        $this->ambiente = new Environment($this->carregador);

        $this->veiculosRepository = new VeiculosRepository(Database::getConexao());
    }

    public function inicio()
    {
        session_start();
        $usuario = null;

        if (isset($_SESSION["user_id"])) {
            $userRepository = new UserRepository(Database::getConexao());
            $usuario = $userRepository->loadUserById($_SESSION["user_id"]);
        }
        $pagina = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        if ($pagina < 1)
            $pagina = 1;

        $limite = 20;
        $veiculos = $this->veiculosRepository->paginarVeiculo($pagina, $limite);

        $tipo_msg = $_SESSION['tipo_msg'] ?? null;
        $msg = $_SESSION['msg'] ?? null;
        unset($_SESSION['tipo_msg'], $_SESSION['msg']);

        echo $this->ambiente->render("inicio.html", [
            'usuario' => $usuario,
            'veiculos' => $veiculos,
            'pagina' => $pagina,
            'tipo_msg' => $tipo_msg,
            'msg' => $msg,
        ]);
    }

    public function catalogo()
    {
        $listaVeiculos = $this->veiculosRepository->veiculosSelectAll();
        echo $this->ambiente->render("veiculos/catalogo.html", ['veiculos' => $listaVeiculos]);
    }
}
?>