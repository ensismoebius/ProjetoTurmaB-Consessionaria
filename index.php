<?php
require_once __DIR__ . '/vendor/autoload.php';

// endereço do site
const URL = "http://localhost/ProjetoTurmaB-Consessionaria";
$roteador = new CoffeeCode\Router\Router(URL);
$roteador->namespace("Concessionaria\Projetob\Controller");

// rota principal
$roteador->group(null);
$roteador->get("/", "Principal:inicio");
$roteador->get("/proposta", "PropostaController:inicio");
$roteador->post("/proposta", "PropostaController:enviar");
$roteador->get("/editar", "Admin\\VeiculoController:showCreateForm");

$roteador->post("/editar", "VeiculoController:showCreateForm");
// rota para detalhes do veículo
$roteador->group("/veiculos");
$roteador->get("/", "Principal:catalogo");
$roteador->get("/{id}", "VeiculosController:detalhes");
$roteador->get("/pesquisar", "VeiculosController:pesquisar");

$roteador->dispatch();
