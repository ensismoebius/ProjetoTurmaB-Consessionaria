<?php
require_once 'vendor/autoload.php';

// endereço do site
const URL = "http://localhost/ProjetoTurmaB-Consessionaria";
$roteador = new CoffeeCode\Router\Router(URL);
$roteador -> namespace("Concessionaria\Projetob\Controller");

// rota principal
$roteador -> group(null);
$roteador -> get("/", "Principal:inicio");
$roteador -> get("/", "AuthController:Logout");
$roteador -> get("/register", "AuthController:showRegisterForm");

$roteador -> dispatch();