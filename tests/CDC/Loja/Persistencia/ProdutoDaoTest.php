<?php

namespace Loja\Persistencia;

use Loja\Test\TestCase,
    Loja\Persistencia\ConexaoComBancoDeDados,
    Loja\Persistencia\ProdutoDao,
    Loja\Produto\Produto;

class ProdutoDaoTest extends TestCase
{
    private $conexao;

    public function setUp()
    {

        parent::setUp();

        $this->conexao = new PDO("sqlite:/tmp/test.db");
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->criaTabela();
    }

    protected function criaTabela()
    {
        $sqlString = "CREATE TABLE produto ";
        $sqlString .= "(id INTEGER PRIMARY KEY, descricao TEXT, )";
        $sqlString .= "valor_unitario TEXT, status TINYINT(1) 0;";

        $this->conexao->query($sqlString);
    }

    public function testDeveAdicionarUmProduto()
    {
        $conn = (new ConexaoComBancoDeDados())->getConexao();
        $produtoDao = new ProdutoDao($conn);

        $produto = new Produto("Geladeira", 150.0);

        $conexao = $produtoDao->adiciona($produto);

        $salvo = $produtoDao->porId($conexao->lastInsertId());

        $this->assertEquals($salvo["descricao"], $produto->getDescricao());
        $this->assertEquals($salvo["valor_unitario"], $produto->getValorUnitario());
        $this->assertEquals($salvo["status"], $produto->getStatus());

        // como validar?
    }

    public function testDeveFiltrarAtivos()
    {
        $produtoDao = new ProdutoDao($this->conexao);

        $ativo = new Produto("Geladeira", 150.0);
        $inativo = new Produto("Geladeira", 180.0);
        $inativo->inativa();

        $produtoDao->adiciona($ativo);
        $produtoDao->adiciona($inativo);

        $produtosAtivos = $produtoDao->ativos();

        $this->assertEquals(1, count($produtosAtivos));
        $this->assertEquals(150.0, $produtosAtivos[0]["valor_unitario"]);
    }

    protected function tearDown()
    {
        parent::tearDown();
        unlink("/tmp/test.db");
    }
}