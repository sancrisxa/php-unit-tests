<?php

namespace CDC\Loja\FluxoDeCaixa;

use CDC\Loja\FluxoDeCaixa\Pedido,
    CDC\Exemplos\RelogioInterface,
    CDC\Loja\Tributos\TabelaInterface;

class GeradorDeNotaFiscal
{

    private $acoes;
    private $relogios;
    private $tabela;

    public function __construct($acoes, RelogioInterface $relogio, TabelaInterface $tabela)
    {

        $this->acoes = $acoes;
        $this->relogio = $relogio;
        $this->tabela = $tabela;
    }

    public function gera(Pedido $pedido)
    {
        $valorTabela = $this->tabela->paraValor($pedido->getValortotal());
        $valorTotal = $pedido->getValorTotal() * $valorTabela;
        
        $nf = new NotaFiscal(
            
            $pedido->getCliente(), 
            $pedido->getValorTotal() * 0.94, 
            $this->relogio->hoje()
        );



        foreach($this->acoes as $acao) {

            $acao->executa($nf);
        }

        return $nf;

    }

}