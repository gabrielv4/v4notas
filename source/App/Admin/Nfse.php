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
    public function createNfse(array $data)
    {
        $invoice = (new NfseModel())->find("client_id = :id", "id={$data['client_id']}")->order("send_at DESC")->limit(1)->fetch();;

        if (empty($data['client_id']) || !$client = (new Client())->findById($data['client_id'])) {
            $this->message->title("Erro de pedido")->warning("O pedido não foi encontrado, favor atualizar a pagina e tentar novamente")->flash();
            redirect('/admin/clients/home');
            return;
        }

        //Verificando o status do cliente
        if($client->status != 'ativo'){
            $this->message->warning("O cliente está com o status inativo, ative para gerar a nota")->flash();
            redirect('/admin/clients/home');
            return;
        }

        //Verificando se o contrato está vencido
        if($client->contract_duration < date('Y-m-d')){
            $this->message->warning("O contrato desse cliente já venceu")->flash();
            $json["redirect"] = url("/admin/clients/home");
            echo json_encode($json);
            return;

        }

        //verifica se ele possui alguma nota
        if($invoice){
            //Se possui verifica se a ultima nota gerada é do mês atual se for ele não gera uma nova
            if($invoice->status != 'cancelada' && date_fmt_back_month($invoice->send_at) == date('m')){
                $this->message->warning("O cliente já possui uma nota do mês ". date_fmt_back_month($invoice->send_at))->flash();
                $json["redirect"] = url("/admin/clients/home");
                echo json_encode($json);
                return;
            }
        }


        $nfe = (new NfseSend())->setOrder($client);
        $nfe->service($data['service']);
        $nfe->dateNfse($data['invoice_date']);
        $nfe->valueNfse(str_price_back($data['invoice_value']));
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



   public function deleteNfse(?array $data)
   {
       $code = (new NfseModel())->findByCode($data['invoice_code']);

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

    /**
     * @param array $data
     * @throws \Exception
     */
    public function returnNfse(array $data)
    {
        $json = file_get_contents('php://input');
        $response = json_decode($json);
        $errors = (!empty($response->erros) ? $response->erros[0] : null);


        $orderId = (int)$response->ref;
        $order = (new \Source\Models\Nfse())->findById($orderId);

        if ($response->status == 'autorizado' && $order) {
            $order->nfe_link = $response->url_danfse;
            $order->nfe_status = $response->status;
            $order->nfe_send_at = date_fmt_app();
            $order->save();
        }

        if ($response->status == 'erro_autorizacao' && $order) {
            $order->nfe_status = $response->status;
            $order->nfe_error = $errors->mensagem;
            $order->save();
        }
    }

    public function findNfse(array $data)
    {
        $invoice = (new NfseModel())->find("invoice_code = :code", "code={$data['invoice_code']}")->limit(1)->fetch();

        $template = '<p><strong>Nome: </strong> <span>'.$invoice->name_client.'</span></p>
                    <p><strong>CNPJ: </strong> <span>'.$invoice->client()->cnpj.'</span></p>
                    <p><strong>Emissão: </strong> <span>'.date_fmt($invoice->send_at).'</span></p>
                   
                    ';

        echo $template;
    }

    public function errorNfse(array $data)
    {
        $invoice = (new NfseModel())->findById($data['invoice_code']);

        $template = '<p>'.$invoice->error.'</p>';

        echo $template;
    }




}