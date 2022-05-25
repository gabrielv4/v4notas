<?php

namespace Source\App\Admin;


use Source\Models\Functionary as Functionarys;
use Source\Support\Pager;
use Source\Support\Upload;
use Source\Support\Thumb;

/**
 * Class Functionary
 * @package Source\App\Admin
 */
class Functionary extends Auth
{
    /**
     * Functionary constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array|null $data
     */
    public function home(?array $data): void
    {

        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/functionarys/home/{$s}/1")]);
            return;
        }

        $search = null;
        $functionarys = (new Functionarys())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $functionarys = (new Functionarys())->find("MATCH(first_name, last_name, email) AGAINST(:s)", "s={$search}");
            if (!$functionarys->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/functionarys/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/functionarys/home/{$all}/"));
        $pager->pager($functionarys->count(), 10, (!empty($data["page"]) ? $data["page"] : 1));


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Funcionário",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/functionarys/home", [
            "app" => "functionarys/home",
            "head" => $head,
            "functionarys" => $functionarys->limit($pager->limit())->offset($pager->offset())->order("id DESC")->fetch(true),
            "paginator" => $pager->render(),
            "search" => $search,
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */

    public function areaFunctionary(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data);

            $functionaryCreate = new Functionarys();
            $functionaryCreate->first_name = $data["first_name"];
            $functionaryCreate->last_name = $data["last_name"];
            $functionaryCreate->email = $data["email"];
            $functionaryCreate->password = $data["password"];

            if (!$functionaryCreate->save()) {
                $json["message"] = $functionaryCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Funcionário cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/admin/functionarys/home");

            echo json_encode($json);
            return;
        }

        /* UPDATE DO FUNCIONARIO */

        if (!empty($data['action']) && $data['action'] == 'update') {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $functionaryUpdate = (new Functionarys())->findById($data["functionary_id"]);

            if (!$functionaryUpdate) {
                $this->message->error("Você tentou gerenciar um funcionário que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/functionarys/home")]);
                return;
            }

            $functionaryUpdate->first_name = $data["first_name"];
            $functionaryUpdate->last_name = $data["last_name"];
            $functionaryUpdate->email = $data["email"];
            $functionaryUpdate->password = (!empty($data["password"]) ? $data["password"] : $functionaryUpdate->password);
         

            if (!$functionaryUpdate->save()) {
                $json["message"] = $functionaryUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Funcionário atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $functionaryDelete = (new Functionarys())->findById($data["functionary_id"]);

            if (!$functionaryDelete) {
                $this->message->error("Você tentou deletar um funcionário que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/functionarys/home")]);
                return;
            }

            if ($functionaryDelete->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$functionaryDelete->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$functionaryDelete->photo}");
                (new Thumb())->flush($functionaryDelete->photo);
            }

            $functionaryDelete->destroy();

            $this->message->success("O funcionário foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/functionarys/home")]);

            return;
        }

        $functionaryEdit = null;
        if (!empty($data["functionary_id"])) {
            $functionaryId = filter_var($data["functionary_id"], FILTER_VALIDATE_INT);
            $functionaryEdit = (new Functionarys())->findById($functionaryId);
        }


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Funcionário",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/functionarys/areaFunctionary", [
            "app" => "functionarys/areaFunctionary",
            "head" => $head,
            "functionary" => $functionaryEdit
        ]);
    }
}
