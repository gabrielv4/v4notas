<?php

namespace Source\App\Admin;

use Source\Models\Admin;
use Source\Models\Client;
use Source\Services\NfseSend;

class Nfse extends  Admin
{
    /**
     * @param array $data
     */
    public function createNfse(array $data)
    {
        if (empty($data['client_id']) || !$order = (new Client())->findById($data['client_id'])) {
            $this->message->title("Erro de pedido")->warning("O pedido não foi encontrado, favor atualizar a pagina e tentar novamente")->ajax();
            return;
        }

        $nfe = (new NfseSend())->setOrder($order);

        if (!$nfe->sendNfSe()) {
            $nfe->message()->ajax();
            return;
        }

        $this->message->title("Processando NFSe")->success("A nota foi trasmitida e está sendo processada.")->flash();
        redirect('/admin/clients/home');
    }




}