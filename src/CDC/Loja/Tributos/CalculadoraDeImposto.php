<?php

namespace Loja\Tributos;

use Loja\FluxoDeCaixa\Pedido;
use Loja\Tributos\Tabela;

class CalculadoraDeImposto
{

    protected $tabela;

    public function __construct(Tabela $tabela)
    {
        $this->tabela = $tabela;
    }

    public function calculaImposto(Pedido $pedido)
    {

        $taxa = $this->tabela->paraValor($pedido->getValor());

        return $pedido->getValorTotal() * $taxa;

    }

}