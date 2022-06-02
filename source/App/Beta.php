<?php

namespace Source\App;

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

////        //pega o dia
//        $day = date('29');
//        //busca os clientes que tem o dia do pagamento
//        $client = (new Client())->findByDay($day);
//        //vefica se algum existe
//        if($client){
//            //listar esses clientes
//            foreach ($client as $item) {
//                //pegando as nfse dos clientes
//                $nfse = (new Nfse())->findByLasClient($item->id);
//                    //pegando as nfse que existem dos clientes
//                    if(!empty($nfse)){
//                        //listandos as nfse
//                        foreach ($nfse as $nf) {
//                            //ignorar as notas geradas que foram canceladas
//                            //verificar se a ultima nfse gerada do cliente é desse mês se for ele não faz o procedimento
//                            //se não ele gera uma nova nota para o mês atual
//                            //Verifica se o dia é o mesmo que o cliente pedio para imprimir a nota
//                            if($nf->status != 'cancelada' && date_fmt_back_month($nf->send_at) != date('m')
//                                && $item->pay_day == $day && $item->status == 'ativo'){
//
//                                $clientInvoice = (new Client())->findById($nf->client_id);
//                                $invoice = (new NfseSend())->setOrder($clientInvoice);
//                                $invoice->sendNfSe();
//
//                            }
//                        }
//                    }else{
//                        //Caso o cliente não tenha notas criadas (cliente novo)
//                        //Verifica se o dia é o mesmo que o cliente pediu para imprimir a nota
//                        if($item->pay_day == $day && $item->status == 'ativo'){
//                            $clientInvoice = (new Client())->findById($item->id);
//                            $invoice = (new NfseSend())->setOrder($clientInvoice);
//                            $invoice->sendNfSe();
//
//                        }
//
//                    }
//
//
//
//            }
//        }


        //Enviar e-mail
        $code = 'MjAyMi0wNS0yOCAyMjo1NzowNg==';
        $nfse = (new Nfse())->findByCode($code);
        $nfse->sendEmailNfse($nfse);


    }

}