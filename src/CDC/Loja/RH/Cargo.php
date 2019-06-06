<?php
namespace CDC\Loja\RH;

class Cargo
{

    private $cargos = array(

        "desenvolvedor" => "CDC\Loja\RH\DezOuVintePorCento",
        "dba" => "CDC\Loja\RH\QuinzeOuVinteECincoPorCento",
        "testador" => "CDC\Loja\RH\QuinzeOuVinteECincoPorCento",

    );

    private $regra;

    public function __construct($regra)
    {
        if(array_key_exists($regra, $this->cargo)) {

            $this->regra = $this->cargos[$regra];
        } else {
            throw new \RuntimeException("Cargo Inválido");
        }
    }

    public function getRegra()
    {
        return new $this->regra();
    }
}