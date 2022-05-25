<?php

namespace Source\App\Admin;

use Source\Models\Sales;

class Invoice extends Auth
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home(?array $data): void
    {

        $doc = (new Sales())->findById($data["id_sales"]);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Admin",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );


        echo $this->view->render("widgets/nfse/home", [
            "app" => "sales/home",
            "head" => $head,
            "doc" => $doc,
        ]);
    }

}