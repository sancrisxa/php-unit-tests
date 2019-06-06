<?php

namespace CDC\Loja\RH;

use CDC\Loja\RH\RegraDeCalculo,
    CDC\Loja\RH\Funcionario;

class QuinzeOuVinteECincoPorCento extends RegraDeCalculo
{

    protected function porcentagemBase()
    {
        return 0.85;
    }

    protected function porcentagemAcimaDoLimite()
    {
        return 0.75;
    }

    protected function limite()
    {
        return 2500;
    }

    public function calcula(Funciona $funcionario)
    {
        if($funcionario->getCargo() < 2500.0) {

            return $funcionario->getSalario() * 0.85;

        }
        return $funcionario->getSalario() * 0.75;
    }
}