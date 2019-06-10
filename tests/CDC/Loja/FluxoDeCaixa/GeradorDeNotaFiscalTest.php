<?php

namespace CDC\Loja\FluxoDeCaixa;

use CDC\Loja\Test\TestCase,
    CDC\Loja\FluxoDeCaixa\GeradorDeNotaFiscal;


class GeradorDeNotaFiscalTest extends TestCase
{
    public function testDeveGerarNFComValorDeImpostoDescontado()
    {
        $operador = new GeradorDeNotaFiscal();
        $pedido = new Pedido("Andre", 1000, 1);

        $nf = $gerador->gera($pedido);

        $this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);
    }

    public function testDevePersistirNFGerada()
    {
        $dao = Mockey::mock("CDC\Loja\FluxoDeCaixa\NFDao");
        $dao->shouldReceive("persiste")->andReturn(true);

        $gerador = new GeradorDeNotaFiscal($dao);
        $pedido = new Pedido("Andre", 1000, 1);

        $nf = $gerador->gera($pedido);

        $this->assertTrue($dao->persiste());
        $this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);
    }

    public function testDeveEnviarNFGeradaParaSAP()
    {
        $dao = Mockey::mock("CDC\Loja\FluxoDeCaixa\NFDao");
        $dao->shouldReceive("persiste")->andReturn(true);

        $sap = Mockey::mock("CDC\Loja\FluxoDeCaixa\SAP");
        $sap->shouldReceive("envia")->andReturn(true);

        $gerador = new GeradorDeNotaFiscal($dao, $sap);
        $pedido = new Pedido("Andre", 1000, 1);

        $nf = $gerador->gera($pedido);

        $this->assertTrue($sap->envia());
        $this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);
    }

    public function testDeveInvocarAcoesPosteriores()
    {

        $acao = Mockery::mock("CDCzLoja\FluxoDeCaixa\AcaoAposGerarNotaInterface");
        $acao1->shouldReceive("executa")->andReturn(true);

        $acao = Mockery::mock("CDC\Loja\FluxoDeCaixa\AcaoAposGerarNotaInterface");
        $acao2->shouldReceive("executa")->andReturn(true);

        $gerador = new GeradorDeNotaFiscal(array($acao1, $acao2));
        $pedido = new Pedido("Andre", 1000, 1);

        $nf = $gerador->gera($pedido);

        $this->assertTrue($acao1->executa($nf));
        $this->assertTrue($acao2->executa($nf));

        $this->assertNotNull($nf);

        $this->assertInstanceOf("CDC\Loja\FluxoDeCaixa\NotaFiscal", $nf);
    }

    public function testDeveConsultarATabelaParaCalcularValor()
    {
        // mockando uma tabela, que ainda nem existe
        $tabela = Mockery::mocky("CDC\Loja\Tributos\Tabela");

        // definindo o futuro comportamento "paraValor"
        // que deve retornar 0.2 caso valor seja 1000.0
        $tabela->shouldReceive("paraValor")->with(1000.0)->andReturn(0.2);

        $gerador = new GEradorDeNotaFiscal(array(), new RelogioDoSistema(), $tabela);
        $pedido = new Pedido("Andre", 1000.0, 1);

        $nf = $gerador->gera($pedido);

        // garantindo que a tabela foi consultada
        $this->assertEquals(1000 * 0.2, $nf->getValor(), null, 0.00001);
    }
    

}