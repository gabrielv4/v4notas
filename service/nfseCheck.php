<?php

require __DIR__.'/../vendor/autoload.php';

use Source\Services\NfseSend;
use Source\Models\Nfse;
use Source\Models\Client;

        $nfse = (new Nfse())->find('status = "processando_autorizacao"')->fetch(true);

        if(!empty($nfse)){
            foreach ($nfse as $item){
                $nf = (new NfseSend())->setNfse((new Nfse())->findByCode($item->invoice_code));
                $nf->getinfo();

                //(new Nfse())->sendEmailNfse((new Nfse())->findByCode($item->invoice_code));

            }
        }