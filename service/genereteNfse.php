<?php

require __DIR__.'/../vendor/autoload.php';

use Source\Models\Client;
use Source\Models\Nfse;
use Source\Services\NfseSend;

//Gerando nota fiscal automaticamente

////        //pega o dia
        $day = date('d');
        //busca os clientes que tem o dia do pagamento
        $client = (new Client())->findByDay($day);
        //vefica se algum existe
        if($client){
            //listar esses clientes
            foreach ($client as $item) {
                //pegando as nfse dos clientes
                $nfse = (new Nfse())->findByLasClient($item->id);

                    //pegando as nfse que existem dos clientes
                    if(!empty($nfse)){
                        //listandos as nfse
                        foreach ($nfse as $nf) {
                            //ignorar as notas geradas que foram canceladas pegar apenas as autorizadas
                            //verificar se a ultima nfse gerada do cliente é desse mês se for ele não faz o procedimento
                            //se não ele gera uma nova nota para o mês atual
                            //Verifica se o dia é o mesmo que o cliente pedio para imprimir a nota
                            if($nf->status != 'cancelada' && date_fmt_back_month($nf->send_at) != date('m')
                                && $item->pay_day == $day && $item->status == 'ativo'){

                                $clientInvoice = (new Client())->findById($nf->client_id);
                                $invoice = (new NfseSend())->setOrder($clientInvoice);
                                $invoice->sendNfSe();

                            //Caso ele só tenha uma nota e ela tenha sido cancelada
                            // No mês atual ele gera um nova nota
                            }else if($nf->status == 'cancelada' && date_fmt_back_month($nf->send_at) == date('m')
                                && $item->pay_day == $day && $item->status == 'ativo'){
                                $clientInvoice = (new Client())->findById($nf->client_id);
                                $invoice = (new NfseSend())->setOrder($clientInvoice);
                                $invoice->sendNfSe();
                            }
                        }
                    }else{
                        //Caso o cliente não tenha notas criadas (cliente novo)
                        //Verifica se o dia é o mesmo que o cliente pediu para imprimir a nota
                        if($item->pay_day == $day && $item->status == 'ativo'){
                            $clientInvoice = (new Client())->findById($item->id);
                            $invoice = (new NfseSend())->setOrder($clientInvoice);
                            $invoice->sendNfSe();

                        }

                    }



            }
        }