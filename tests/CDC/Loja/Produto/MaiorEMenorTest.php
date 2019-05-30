<?php

namespace CDC\Loja\Produto;

require "./vendor/autoload.php";

use CDC\Loja\Carrinho\CarrinhoDeCompras,
    CDC\Loja\Produto\Produto,
    CDC\Loja\Produto\MaiorEMenor;
use PHPUnit_Framework_TestCase as PHPUnit;

class MaiorEMenorTest extends \PHPUnit_Framework_TestCase{

    public function testOrdemDecrescente()
    {
        $carrinho = new CarrinhoDeCompras();
        $carrinho->adiciona(
                new Produto("Geladeira", 450.00, 1));
        $carrinho->adiciona(
                new Produto("Liquidificador", 250.00, 1));
        $carrinho->adiciona(
                new Produto("Jogo de pratos", 70.00, 1));
        $maiorEMenor = new MaiorEMenor();
        $maiorEMenor->encontra($carrinho);
        $this->assertEquals("Jogo de pratos", $maiorEMenor->getMenor()->getNome());
        $this->assertEquals("Geladeira", $maiorEMenor->getMaior()->getNome());

        
    }

    public function testApenasUmProduto()
    {
            $carrinho = new CarrinhoDeCompras();

            $carrinho->adiciona(new Produto("Geladeira", 450.00));

            $maiorEMenor = new MaiorEMenor();
            $maiorEMenor->encontra($carrinho);

            $this->assertEquals("Geladeira", $maiorEMenor->getMenor()->getNome());
            $this->assertEquals("Geladeira", $maiorEMenor->getMaior()->getNome());
    }

}