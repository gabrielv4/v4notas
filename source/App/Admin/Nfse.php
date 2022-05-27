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

   public function deleteNfse(?array $data)
   {
       $code = (new \Source\Models\Nfse())->findByCode($data['invoice_code']);

       if(!empty($code)){
           $nf = (new NfseSend())->setNfse((new \Source\Models\Nfse())->findByCode($data['invoice_code']));
           $nf->getinfo();
           if($nf->cancelNfse($data['invoice_code'], $data['justification'])){
               $this->message->title("Processando NFSe")->success("A nota fiscal foi cancelada com sucesso!")->flash();
               redirect('/admin/clients/home');
           }
           $this->message->title("Processando NFSe")->error("Erro ao cancelar a nota tente novamente mais tarde")->flash();
           redirect('/admin/clients/home');

       }else{
           $this->message->title("Processando NFSe")->error("A Nfse que você tentou cancelar não existe")->flash();
           redirect('/admin/clients/home');
       }

   }





}