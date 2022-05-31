<?php

namespace Source\App\Admin;

use Source\Models\Client;
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
            $clients = (new Client())->find("MATCH(company_name) AGAINST(:s)", "s={$search}");
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
            "clients" => $clients->limit($pager->limit())->offset($pager->offset())->fetch(true),
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
            $clientCreate->fee_value = settingPrice($data["fee_value"]);
            $clientCreate->advisor = $data["advisor"];
            $clientCreate->origin = $data["origin"];
            $clientCreate->status = 'ativo';



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
                $clientUpdate->fee_value = $data["fee_value"];
                $clientUpdate->advisor = $data["advisor"];
                $clientUpdate->origin = $data["origin"];



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
            $clientStatus->status = 'desativo';
        }

        if (!$clientStatus->save()) {
            $json["message"] = $clientStatus->message()->render();
            echo json_encode($json);
            return;
        }

    }

}