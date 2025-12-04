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
$roteador->get("/editar", "Admin\\VeiculoController:showCreateForm");
$roteador->post("/editar", "Admin\\VeiculoController:salvarVeiculo");
$roteador->post("/logout", "AuthController:logout");
// rota de Novos
$roteador->get('/novos', 'Principal:novos');
// rota Sobre Nós
$roteador->get("/sobrenos", "Principal:sobrenos");
// rota Serviços
$roteador->get("/servicos", "Principal:servicos");
// rotas de autenticação
$roteador->get("/login", "AuthController:showLoginForm");
$roteador->post("/login", "AuthController:login");
$roteador->get("/register", "AuthController:showRegisterForm");
$roteador->post("/register", "AuthController:register");

// rota para detalhes do veículo
$roteador->group("/veiculos");
$roteador->get("/", "Principal:catalogo");
$roteador->get("/{id}", "VeiculosController:detalhes");
$roteador->get("/pesquisar", "VeiculosController:pesquisar");

// rotas adm para gerenciamento de veículos
$roteador->group("/admin/veiculos");
$roteador->get("/", "Admin\\VeiculosControllerAdm:gerenciamento_de_veiculos");
$roteador->get("/create", "Admin\\VeiculosControllerAdm:showCreateForm");
$roteador->post("/store", "Admin\\VeiculosControllerAdm:salvarVeiculo");
$roteador->get("/{id_veiculos}/edit", "Admin\\VeiculosControllerAdm:formEditar");
$roteador->post("/{id_veiculos}/update", "Admin\\VeiculosControllerAdm:atualizarVeiculo");
$roteador->post("/{id_veiculos}/delete", "Admin\\VeiculosControllerAdm:removerVeiculo");

$roteador->dispatch();

/*
 * ERRORS
 */
if ($roteador->error()) {
    $roteador->redirect("/ops/{$roteador->error()}");
}
