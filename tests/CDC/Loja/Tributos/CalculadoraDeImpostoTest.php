<?php

namespace Loja\Tributos;

use Loja\Test\TestCase,
    Loja\FluxoDeCaixa\Pedido,
    Loja\Tributos\CalculadoraDeImposto;

use Mockery;

class CalculadoraDeImpostoTest extends TestCase
{

    public function testCalculoImpostoParaPedidosSuperiorA2000Reais()
    {
        $tabela = Mockery::mock("Loja\Tributos\Tabela");

        // ensinando o mock a devolver 0.1 caso o método
        // paraValor seja invocado com o valor 2500.0
        $tabela->shouldReceive("paraValor")->with(2500.0)->andReturn(0.1);

        $pedido = new Pedido("Andre", 2500.0, 3);
        $calculadora = new CalculadoraDeImposto($tabela);

        $valor = $calculadora->calculaImpost($pedido);
        $this->assertEquals((2500.0 * 0.1), $valor, null, 0.00001);


    }
}