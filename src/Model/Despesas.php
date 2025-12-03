<?php

namespace Concessionaria\Projetob\Model;

class Despesas
{

    public int $id_despesas;
    public int $id_tipo_despesa;
    public string $descricao;	
    public string $valor;	
    public string $data_despesas;
    public string $data_vencimento;
    public string $data_pagamento;

}