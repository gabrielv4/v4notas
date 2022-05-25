<?php

namespace Source\App\Admin;

use Source\Models\Sales as SalesModel;
use Source\Support\Pager;

class Sales extends Auth 
{
    public function home(?array $data): void
    {

        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/sales/home/{$s}/1")]);
            return;
        }

        $search = null;
        $sales = (new SalesModel())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $sales = (new SalesModel())->find("MATCH(name_client, code) AGAINST(:s)", "s={$search}");
            if (!$sales->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/sales/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/sales/home/{$all}/"));
        $pager->pager($sales->count(), 8, (!empty($data["page"]) ? $data["page"] : 1));


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Vendas",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/sales/home", [
            "app" => "sales/home",
            "head" => $head,
            "sales" => $sales->limit($pager->limit())->offset($pager->offset())->order("id DESC")->fetch(true),
            "paginator" => $pager->render(),
            "search" => $search,
        ]);
    }
}