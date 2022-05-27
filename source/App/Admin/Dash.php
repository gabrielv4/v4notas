<?php

namespace Source\App\Admin;

use Source\Models\AuthAdmin;
use Source\Models\Client;
use Source\Models\Nfse;
use Source\Support\Pager;

/**
 * Class Dash
 * @package Source\App\Admin
 */
class Dash extends Auth
{
    /**
     * Dash constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function dash(): void
    {
        redirect("/admin/dash/home");
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function home(?array $data)
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/dash/home/{$s}/1")]);
            return;
        }

        $search = null;
        $nfse = (new Nfse())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);

            $nfse = (new Nfse())->find("MATCH(name_client) AGAINST(:s)", "s={$search}");

            if (!$nfse->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/dash/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/dash/home/{$all}/"));
        $pager->pager($nfse->count(), 5, (!empty($data["page"]) ? $data["page"] : 1));


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Admin",
            CONF_SITE_DESC,
            url("/nfse"),
            theme("/images/image.jpg", CONF_VIEW_FUNCTIONARY),
            false
        );

        echo $this->view->render("widgets/dash/home", [
            "app" => "dash",
            "head" => $head,
            "nfse" => $nfse->limit($pager->limit())->offset($pager->offset())->order("id DESC")->fetch(true),
            "paginator" => $pager->render(),
            "search" => $search,

        ]);
    }

    public function logoff(): void
    {
        $this->message->success("Você saiu com sucesso {$this->admin->first_name}.")->flash();

        AuthAdmin::logout();
        redirect("/admin/login");
    }

}