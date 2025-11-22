<?php
require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// endereço do site
$url = $_ENV['APP_URL'];
$roteador = new CoffeeCode\Router\Router($url);
$roteador->namespace("Concessionaria\Projetob\Controller");

// rota principal
$roteador->group(null);
$roteador->get("/", "Principal:inicio");
$roteador->get("/proposta", "PropostaController:inicio");
$roteador->post("/proposta", "PropostaController:enviar");
<<<<<<< Updated upstream
// rotas de autenticação
$roteador->get("/login", "AuthController:showLoginForm");
$roteador->post("/login", "AuthController:login");
$roteador->get("/register", "AuthController:showRegisterForm");
$roteador->post("/register", "AuthController:register");
$roteador->post("/logout", "AuthController:logout");
=======
$roteador->get("/editar", "Admin\\VeiculoController:showCreateForm");
$roteador->post("/editar", "Admin\\VeiculoController:salvarVeiculo");
<<<<<<< Updated upstream


>>>>>>> Stashed changes
=======


>>>>>>> Stashed changes
// rota para detalhes do veículo
$roteador->group("/veiculos");
$roteador->get("/", "Principal:catalogo");
$roteador->get("/{id}", "VeiculosController:detalhes");
$roteador->get("/pesquisar", "VeiculosController:pesquisar");

$roteador->dispatch();

/*
 * ERRORS
 */
if ($roteador->error()) {
    $roteador->redirect("/ops/{$roteador->error()}");
}
