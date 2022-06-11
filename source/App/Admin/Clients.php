<?php

namespace Source\App\Admin;

use Source\Models\Client;
use Source\Models\Nfse;
use Source\Models\Nfse as NfseModel;
use Source\Support\Pager;

class Clients extends Auth 
{
    public function home(?array $data): void
    {

        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/clients/home/{$s}/1")]);
            return;
        }

        $search = null;
        $clients = (new Client())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $clients = (new Client())->find("(company_name LIKE '%' :s '%')", "s={$search}");
            if (!$clients->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/clients/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/clients/home/{$all}/"));
        $pager->pager($clients->count(), 8, (!empty($data["page"]) ? $data["page"] : 1));


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Clientes",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/clients/home", [
            "app" => "clients/home",
            "head" => $head,
            "clients" => $clients->limit($pager->limit())->offset($pager->offset())->order('id DESC')->fetch(true),
            "paginator" => $pager->render(),
            "search" => $search,
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */

    public function areaClient(?array $data): void
    {
        //create

        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data);

            $clientCreate = new Client();
            $clientCreate->name_project = $data["name_project"];
            $clientCreate->name_stakeholder = $data["name_stakeholder"];
            $clientCreate->phone_stakeholder = $data["phone_stakeholder"];
            $clientCreate->email_stakeholder = $data["email_stakeholder"];
            $clientCreate->financial_name = $data["financial_name"];
            $clientCreate->financial_email = $data["financial_email"];
            $clientCreate->company_name = $data["company_name"];
            $clientCreate->cnpj = $data["cnpj"];
            $clientCreate->managing_partner = $data["managing_partner"];

            $clientCreate->cep = $data["cep"];
            $clientCreate->city = $data["city"];
            $clientCreate->uf = $data["uf"];
            $clientCreate->district = $data["district"];
            $clientCreate->street = $data["street"];
            $clientCreate->number = $data["number"];
            $clientCreate->complement = $data["complement"];

            $clientCreate->start_project = $data["start_project"];
            $clientCreate->first_payment = $data["first_payment"];
            $clientCreate->contract_duration = $data["contract_duration"];
            $clientCreate->pay_day = $data["pay_day"];
            $clientCreate->invoice_day = $data["invoice_day"];
            $clientCreate->fee_value = settingPrice($data["fee_value"]);
            $clientCreate->invoice_description = settingPrice($data["invoice_description"]);
            $clientCreate->advisor = $data["advisor"];
            $clientCreate->origin = $data["origin"];
            $clientCreate->status = 'ativo';
            $clientCreate->generate_invoice = isset($data['generate_invoice']) ? 'ativo' : 'inativo' ;



            if (!$clientCreate->save()) {
                $json["message"] = $clientCreate->message()->render();
                echo json_encode($data);
                return;
            }

            $this->message->success("Cliente cadastrado com sucesso!!")->flash();
            $json["redirect"] = url("/admin/clients/home");

            echo json_encode($json);
            return;
        }

        /* UPDATE DO FUNCIONARIO */

        if (!empty($data['action']) && $data['action'] == 'update') {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $clientUpdate = (new Client())->findById($data["client_id"]);

            if (!$clientUpdate) {
                $this->message->error("Você tentou gerenciar um cliente que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/clients/home")]);
                return;
            }

                $clientUpdate->name_project = $data["name_project"];
                $clientUpdate->name_stakeholder = $data["name_stakeholder"];
                $clientUpdate->phone_stakeholder = $data["phone_stakeholder"];
                $clientUpdate->email_stakeholder = $data["email_stakeholder"];
                $clientUpdate->financial_name = $data["financial_name"];
                $clientUpdate->financial_email = $data["financial_email"];
                $clientUpdate->company_name = $data["company_name"];
                $clientUpdate->cnpj = $data["cnpj"];
                $clientUpdate->managing_partner = $data["managing_partner"];

                $clientUpdate->cep = $data["cep"];
                $clientUpdate->city = $data["city"];
                $clientUpdate->uf = $data["uf"];
                $clientUpdate->district = $data["district"];
                $clientUpdate->street = $data["street"];
                $clientUpdate->number = $data["number"];
                $clientUpdate->complement = $data["complement"];

                $clientUpdate->start_project = $data["start_project"];
                $clientUpdate->first_payment = $data["first_payment"];
                $clientUpdate->contract_duration = $data["contract_duration"];
                $clientUpdate->pay_day = $data["pay_day"];
                $clientUpdate->invoice_day = $data["invoice_day"];
                $clientUpdate->fee_value = $data["fee_value"];
                $clientUpdate->invoice_description = $data["invoice_description"];
                $clientUpdate->advisor = $data["advisor"];
                $clientUpdate->origin = $data["origin"];
                $clientUpdate->generate_invoice = isset($data['generate_invoice']) ? 'ativo' : 'inativo' ;



            if (!$clientUpdate->save()) {
                $json["message"] = $clientUpdate->message()->render();
                echo json_encode($json);
                echo json_encode($data);
                return;
            }

            $this->message->success("Cliente atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $clientDelete = (new Client())->findById($data["client_id"]);

            if (!$clientDelete) {
                $this->message->error("Você tentou deletar um cliente que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/functionarys/home")]);
                return;
            }


            $clientDelete->destroy();

            $this->message->success("O cliente foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/clients/home")]);

            return;
        }

        $clientEdit = null;
        if (!empty($data["client_id"])) {
            $clientEdit = filter_var($data["client_id"], FILTER_VALIDATE_INT);
            $clientEdit = (new Client())->findById($clientEdit);
        }


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Cliente",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/clients/areaClient", [
            "app" => "clients/home",
            "head" => $head,
            "client" => $clientEdit
        ]);
    }

    public function settingStatusCompany(array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $clientStatus = (new Client())->findById($data["client_id"]);

        if (!$clientStatus) {
            $this->message->error("Você tentou gerenciar um cliente que não existe")->flash();
            echo json_encode(["redirect" => url("/admin/clients/home")]);
            return;
        }

        if($data['status'] == 'true'){
            $clientStatus->status = 'ativo';
        }else{
            $clientStatus->status = 'inativo';
        }

        if (!$clientStatus->save()) {
            $json["message"] = $clientStatus->message()->render();
            echo json_encode($json);
            return;
        }

    }

    public function settingStatusInvoice(array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $clientStatus = (new Client())->findById($data["client_id"]);

        if (!$clientStatus) {
            $this->message->error("Você tentou gerenciar um cliente que não existe")->flash();
            echo json_encode(["redirect" => url("/admin/clients/home")]);
            return;
        }

        if($data['status'] == 'true'){
            $clientStatus->generate_invoice = 'ativo';
        }else{
            $clientStatus->generate_invoice = 'inativo';
        }

        if (!$clientStatus->save()) {
            $json["message"] = $clientStatus->message()->render();
            echo json_encode($json);
            return;
        }

    }


    public function nfseClient(?array $data)
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/clients/home/{$s}/1")]);
            return;
        }

        $search = null;
        $nfse = (new NfseModel())->find("client_id = :id", "id={$data['client_id']}");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);

            $nfse = (new Nfse())->find("(invoice_number LIKE '%' :s '%' OR name_client LIKE '%' :s '%' )", "s={$search}");


            if (!$nfse->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/dash/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/clients/nfse/{$data['client_id']}/{$all}/"));
        $pager->pager($nfse->count(), 8, (!empty($data["page"]) ? $data["page"] : 1));



        $head = $this->seo->render(
            CONF_SITE_NAME . " | Nfse do Cliente",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/dash/home", [
            "app" => "clients/nfseClient",
            "head" => $head,
            "nfse" => $nfse->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render(),
            "search" => $search,
        ]);
    }


    public function findClient(array $data)
    {
        $client = (new Client())->find("id = :id", "id={$data['client_id']}")->limit(1)->fetch();

        $template = '<p><strong>Nome: </strong> <span>'.$client->company_name.'</span></p>
                    <p><strong>CNPJ: </strong> <span>'.$client->cnpj.'</span></p>
                    <p><strong>Status: </strong> <span>'.$client->status.'</span></p>
                   
                    ';

        echo $template;
    }

    public function allDataClient(array $data)
    {
        $client = (new Client())->find("id = :id", "id={$data['client_id']}")->limit(1)->fetch();

        $template = '
                        <p><h2 class="titleDataView">Projeto - '.$client->name_project.'</h2></p>
                        
                          <div class="listDataView">
                            <p><b>Nome do StackHolder:</b><br/> '.$client->name_stakeholder.' </p>
                            <p><b>Telefone StackHolder:</b><br/> '.$client->name_project.'</p>
                            <p><b>Email StackHolder:</b><br/> '.$client->name_project.'</p>
                        </div>
                
                        <div class="linha"> <hr></div>
                
                        <div class="listDataView">
                            <p><b>Razão Social:</b><br/> '.$client->company_name.'</p>
                            <p><b>CNPJ:</b><br/> '.$client->cnpj.'</p>
                            <p><b>Socio Gerente:</b><br/> '.$client->managing_partner.'</p>
                        </div>
                
                        <div class="linha"> <hr></div>
                
                        <div class="listDataView">
                            <p><b>Representante financeiro:</b><br/> '.$client->financial_name.'</p>
                            <p><b>Email do financeiro:</b><br/> '.$client->financial_email.'</p>
                        </div>
                        <div class="linha"> <hr></div>
                
                        <div class="listDataView">
                            <p><b>CEP:</b><br/> '.$client->cep.'</p>
                            <p><b>Cidade:</b><br/> '.$client->ciry.'</p>
                            <p><b>UF:</b><br/> '.$client->uf.'</p>
                        </div>
                
                        <div class="linha"> <hr></div>
                
                        <div class="listDataView">
                            <p><b>Bairro</b>:<br/> '.$client->district.'</p>
                            <p><b>Rua</b>:</br> '.$client->street.'</p>
                            <p><b>Numero:</b></br> '.$client->number.'</p>
                            <p><b>Complemento</b>:</br> '.$client->complement.'</p>
                        </div>
                
                        <div class="linha"> <hr></div>
                
                        <div class="listDataView">
                            <p><b>Inicio do Projeto:</b><br/> '.date_fmt_back_br($client->start_project).'</p>
                            <p><b>Primeiro Pagamento:</b></br> '.date_fmt_back_br($client->first_payment).'</p>
                            <p><b>Duração do Contrato:</b><br/> '.date_fmt_back_br($client->first_payment).'</p>
                        </div>
                
                        <div class="linha"> <hr></div>
                
                        <div class="listDataView">
                            <p><b>Dia do pagamento:</b></br> '.$client->pay_day.'</p>
                            <p><b>Dia para receber a nota:</b></br> '.$client->invoice_day.'</p>
                            <p><b>Valor do Fee:</b><br/> '.str_price($client->fee_value).'</p>
                        </div>
                
                        <div class="linha"> <hr></div>
                
                        <div class="listDataView">
                            <p><b>Assessor:</b><br/> '.$client->advisor.'</p>
                            <p><b>Origem:</b><br/> '.$client->origin.'</p>
                            <p><b>Status do Cliente:</b><br/> '.$client->status.'</p>
                            <p><b>Status da Nota:</b><br/> '.$client->generate_invoice.'</p>
                        </div>
                
                        <div class="linha"> <hr></div>
                
                        <div class="listDataView">
                            <p><b>Descrição da Nota:</b><br/> '.$client->invoice_description.'</p>
                        </div>
                                   
                    ';

        echo $template;
    }



}