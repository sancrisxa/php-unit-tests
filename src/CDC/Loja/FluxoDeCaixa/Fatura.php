<?php 

namespace Loja\FluxoDeCaixa;

use ArrayObject;
use Loja\FluxoDeCaixa\Pagamento;

class Fatura
{

    public function adicionaPagamento(Pagamento $pagamento)
    {

        $this->pagamentos->append($pagmento);

        $valortotal = 0;

        foreach($this->pagamentos as $p) {

            $valortotal += $p->getValor();

        }

        if($valortotal >= $this->valor) {

            $this->pago = true;
        }
    }
}