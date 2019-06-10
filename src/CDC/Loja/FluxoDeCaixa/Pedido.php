<?php

namespace CDC\Loja\FluxoDeCaixa;

class Pedido
{
    private $cliente;
    private $valorTotal;
    private $quantidadeDeItens;

    public function __construct($cliente, $valorTotal, $quantidadeDeItens)
    {
        $this->cliente = $cliente;
        $this->valorTotal = $valorTotal;
        $this->quantidadeDeItens = $quantidadeDeItens;

    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    public function getQuantidadeItens()
    {
        return $this->quantidadeDeItens;
    }
}