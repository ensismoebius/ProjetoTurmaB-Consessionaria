<?php
require_once 'vendor/autoload.php';

// endereço do site
const URL = "http://localhost/ProjetoTurmaB-Consessionaria";
$roteador = new CoffeeCode\Router\Router(URL);
$roteador -> namespace("Concessionaria\Projetob\Controller");

// rota principal
$roteador -> group(null);
$roteador -> get("/", "Principal:inicio");
// rota de detalhes do veículo (aponta para src/Controller/Veiculos::detalhes)
$roteador -> get("/veiculos/{id}", "Veiculos:show");

$roteador -> dispatch();