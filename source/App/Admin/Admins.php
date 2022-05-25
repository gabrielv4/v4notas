<?php

namespace Source\App\Admin;

use Source\Models\Admin;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;

/**
 * Class Users
 * @package Source\App\Admin
 */
class Admins extends Auth
{
    /**
     * Users constructor.
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
            echo json_encode(["redirect" => url("/admin/admins/home/{$s}/1")]);
            return;
        }

        $search = null;
        $admins = (new Admin())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $admins = (new Admin())->find("MATCH(first_name, last_name, email) AGAINST(:s)", "s={$search}");
            if (!$admins->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/admins/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/admins/home/{$all}/"));
        $pager->pager($admins->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Admins",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );

        echo $this->view->render("widgets/admins/home", [
            "app" => "admins/home",
            "head" => $head,
            "admins" => $admins->limit($pager->limit())->offset($pager->offset())->order("id DESC")->fetch(true),
            "paginator" => $pager->render(),
            "search" => $search
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function areaAdmin(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $adminCreate = new Admin();
            $adminCreate->first_name = $data["first_name"];
            $adminCreate->last_name = $data["last_name"];
            $adminCreate->email = $data["email"];
            $adminCreate->password = $data["password"];

            //upload photo
            if (!empty($_FILES["photo"])) {
                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, rand(uniqid()), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $adminCreate->photo = $image;
            }

            if (!$adminCreate->save()) {
                $json["message"] = $adminCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Admin cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/admin/admins/home");

            echo json_encode($json);
            return;
        }

        /* UPDATE DO Admin */

        if (!empty($data['action']) && $data['action'] == 'update') {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $adminUpdate = (new Admin())->findById($data["admin_id"]);

            if (!$adminUpdate) {
                $this->message->error("Você tentou gerenciar um admin que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/admins/home")]);
                return;
            }

            $adminUpdate->first_name = $data["first_name"];
            $adminUpdate->last_name = $data["last_name"];
            $adminUpdate->email = $data["email"];
            $adminUpdate->password = (!empty($data["password"]) ? $data["password"] : $adminUpdate->password);
            //upload photo
            if (!empty($_FILES["photo"])) {
                if ($adminUpdate->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$adminUpdate->photo}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$adminUpdate->photo}");
                    (new Thumb())->flush($adminUpdate->photo);
                }

                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, md5(uniqid(time())), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $adminUpdate->photo = $image;
            }

            if (!$adminUpdate->save()) {
                $json["message"] = $adminUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Admin atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $adminDelete = (new Admin())->findById($data["admin_id"]);

            if (!$adminDelete) {
                $this->message->error("Você tentnou deletar um admin que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/admins/home")]);
                return;
            }

            if ($adminDelete->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$adminDelete->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$adminDelete->photo}");
                (new Thumb())->flush($adminDelete->photo);
            }

            $adminDelete->destroy();

            $this->message->success("O admin foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/admins/home")]);

            return;
        }

        $adminEdit = null;
        if (!empty($data["admin_id"])) {
            $adminId = filter_var($data["admin_id"], FILTER_VALIDATE_INT);
            $adminEdit = (new Admin())->findById($adminId);
        }


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Admin",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/admins/areaAdmin", [
            "app" => "admins/areaAdmin",
            "head" => $head,
            "admin" => $adminEdit
        ]);
    }


}
