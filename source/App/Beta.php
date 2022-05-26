<?php

namespace Source\App;

use Source\Models\Client;
use Source\Models\Nfse;
use Source\Services\NfseSend;

class Beta extends Client
{
    public function home(?array $data)
    {
//        $nfse = (new Nfse())->find('status = "processando_autorizacao"')->fetch(true);
//
//        if(!empty($nfse)){
//            foreach ($nfse as $item){
//                $nf = (new NfseSend())->setOrder((new Client())->findById($item->client_id));
//
//                $findNfse = (new Nfse())->findById($item->id);
//                $nf->getinfo();
//                $findNfse->link = $nf->response()->url_danfse;
//                $findNfse->status = $nf->response()->status;
//                $findNfse->send_at = date_fmt_app();
//                if(!$findNfse->save()){
//                    echo "Algo deu errado";
//                    echo $findNfse->message->render();
//                }else{
//                    echo "Funcionou!!!!";
//                }
//                return;
//            }
//        }

        $code = (new Nfse())->findByCode('MjAyMi0wNS0yNSAyMjowMjo1MQ==');
        $nf = (new NfseSend())->setOrder((new Client())->findById($code->client_id));
        $nf->cancelNfse('MjAyMi0wNS0yNSAyMjowMjo1MQ==','Teste de cancelamento de nota');

        //$nfse = (new NfseSend())->cancelNfse('MjAyMi0wNS0yNSAyMjowMjo1MQ==','Teste de cancelamento de nota');


    }

}