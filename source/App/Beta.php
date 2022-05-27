<?php

namespace Source\App;

use Source\Models\Client;
use Source\Models\Nfse;
use Source\Services\NfseSend;

class Beta extends Client
{
    public function home(?array $data)
    {
        $nfse = (new Nfse())->find('status = "processando_autorizacao"')->fetch(true);

        if(!empty($nfse)){
            foreach ($nfse as $item){

                $nf = (new NfseSend())->setNfse((new Nfse())->findByCode($item->invoice_code));
                $nf->getinfo();

            }
        }

//        $code = (new Nfse())->findByCode('MjAyMi0wNS0yNSAyMjowMjo1MQ==');
//        $nf = (new NfseSend())->setNfse((new Nfse())->findByCode('MjAyMi0wNS0yNiAwODozMDowMg=='));
//        $nf->cancelNfse('MjAyMi0wNS0yNiAwODozMDowMg==','Teste de cancelamento de nota');
//        $nf->getinfo();



    }

}