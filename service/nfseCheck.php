<?php

require __DIR__.'/../vendor/autoload.php';

//use Source\App\Admin\Nfse;
use Source\Services\NfseSend;
use Source\Models\Nfse;

        $nfse = (new Nfse())->find('status = "processando_autorizacao"')->fetch(true);

        if(!empty($nfse)){
            foreach ($nfse as $item){

                $nf = (new NfseSend())->setNfse((new Nfse())->findByCode($item->invoice_code));
                $nf->getinfo();

            }
        }