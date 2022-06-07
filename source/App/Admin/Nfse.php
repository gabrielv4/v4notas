<?php

namespace Source\App\Admin;

use Source\Models\Admin;
use Source\Models\Client;
use Source\Services\NfseSend;
use Source\Models\Nfse as NfseModel;


class Nfse extends  Admin
{
    /**
     * @param array $data
     */
    public function createNfse(?array $data)
    {
        if (empty($data['client_id']) || !$order = (new Client())->findById($data['client_id'])) {
            $this->message->title("Erro de pedido")->warning("O pedido não foi encontrado, favor atualizar a pagina e tentar novamente")->flash();
            redirect('/admin/clients/home');
            return;
        }

        if($order->status != 'ativo'){
            $this->message->warning("O cliente está com o status inativo, ative para gerar a nota")->flash();
            redirect('/admin/clients/home');
            return;
        }

        $nfe = (new NfseSend())->setOrder($order);
        $nfe->service($data['service']);
        if (!$nfe->sendNfSe()) {
            $this->message->title("Processando NFSe")->error("Erro ao cadastrar a nota verifique os dados")->flash();
            redirect('/admin/dash/home');
            return;
        }

        $this->message->title("Processando NFSe")->success("Nota enviada com sucesso")->flash();
        $json["redirect"] = url("/admin/dash/home");

        echo json_encode($json);
        return;
    }



   public function deleteNfse(array $data)
   {
       $code = (new \Source\Models\Nfse())->findByCode($data['invoice_code']);

       if(empty($code)){
           $this->message->title("Processando NFSe")->error("A Nfse que você tentou cancelar não existe")->flash();
           redirect('/admin/dash/home');
           return;
       }

       $nf = (new NfseSend())->setNfse($code);
       $nf->cancelNfse($data['invoice_code'], $data['justification']);
       $nf->getinfo();

       $this->message->success("Nota cancelada com sucesso!")->flash();
       echo json_encode(["reload" => true]);
       return;

   }




}