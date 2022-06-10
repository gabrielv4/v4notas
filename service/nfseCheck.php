<?php

require __DIR__.'/../vendor/autoload.php';

use Source\Services\NfseSend;
use Source\Models\Nfse;
use Source\Models\Client;

        $nfse = (new Nfse())->find('status = "processando_autorizacao"')->fetch(true);

        if(!empty($nfse)){
            foreach ($nfse as $item){
                $nf = (new NfseSend())->setNfse((new Nfse())->findByCode($item->invoice_code));
                $clint = (new Client())->findById($item->client_id);
                $nf->getinfo();

                //enviar email pela propria API
                //(new NfseSend())->sendNfseEmail($item->invoice_code, $clint->financial_email);

                //Enviar e-mail pelo servidor
                //(new Nfse())->sendEmailNfse((new Nfse())->findByCode($item->invoice_code));

            }
        }