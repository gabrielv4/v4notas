<?php

namespace Source\App;

use Cassandra\Date;
use Source\Models\Client;
use Source\Models\Nfse;
use Source\Services\NfseSend;

class Beta extends Client
{
    public function home(?array $data)
    {
        //Vefiricar nota fiscal e adicionar o link
//        $nfse = (new Nfse())->find('status = "processando_autorizacao"')->fetch(true);
//
//        if(!empty($nfse)){
//            foreach ($nfse as $item){
//
//                $nf = (new NfseSend())->setNfse((new Nfse())->findByCode($item->invoice_code));
//                $nf->getinfo();
//
//            }
//        }


    //Excluir nota fiscal
        //$code = (new Nfse())->findByCode('MjAyMi0wNS0yNSAyMjowMjo1MQ==');
//        $code ="MjAyMi0wNS0yNyAxODoyNToyMA==";
//        $nf = (new NfseSend())->setNfse((new Nfse())->findByCode($code));
//        $nf->cancelNfse($code,'Teste de cancelamento de nota');
//        $nf->getinfo();
//        var_dump($nf);;


        //Gerando nota fiscal automaticamente

//        //pega o dia
        $day = date('26');
        //busca os clientes que tem o dia do pagamento
        $client = (new Client())->findByDay($day);
        //vefica se algum existe
        if($client){
            //listar esses clientes
            foreach ($client as $item) {
                //pegando as nfse dos clientes
                $nfse = (new Nfse())->findByClient($item->id);
                    //pegando as nfse que existem dos clientes
                    if(!empty($nfse)){
                        //listandos as nfse
                        foreach ($nfse as $nf) {
                            //ignorar as notas geradas que foram canceladas
                            //verificar se o usuario já tem uma nota neste mês
                           // echo date_fmt_back_month($nf->send_at);
                            $date = date_fmt_back_month($nf->send_at);

                            if($nf->status != 'cancelada' && date_fmt_back_month($nf->send_at) != date('m')){

//                                $clientInvoice = (new Client())->findById($nf->client_id);
//                                $invoice = (new NfseSend())->setOrder($clientInvoice);
//                                $invoice->sendNfSe();
//                                echo "Gerar nota para ". $nf->name_client;
                                //echo date_fmt_back_month($nf->send_at);

                                echo $date;

//
//                                if($nf->status != 'cancelada' && date_fmt_back_month($nf->send_at) != date('m')){
//                                    $clientInvoice = (new Client())->findById($nf->client_id);
//                                    $invoice = (new NfseSend())->setOrder($clientInvoice);
//                                    $invoice->sendNfSe();
//                                }

                            }
                        }
                    }else{
                        echo "Existe um cliente que não possui notas ";
                        echo $item->company_name;
                    }



            }
        }

    }

}