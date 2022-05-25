<?php

namespace Source\App\Admin;

use Source\App\Admin\Auth;
use Source\Support\Upload;
use Source\Models\Admin;
use Source\Support\Thumb;

class Settings extends Auth
{
    public function home()
    {

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Meus dados",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/settings/home", [
            "app" => "settings/home",
            "head" => $head,
        ]);
    }

    public function password()
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Atualizar senha",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/settings/password", [
            "app" => "settings/home",
            "head" => $head,
            "admin" => ""
        ]);
    }

    public function photo()
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Atualizar foto",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/settings/photo", [
            "app" => "settings/home",
            "head" => $head,
            "admin" => ""
        ]);
    }

    public function updateAccount(?array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $adminUpdate = (new Admin())->findById($data["admin_id"]);

        if (!$adminUpdate) {
            $this->message->error("Você tentou gerenciar uma conta que não existe")->flash();
            echo json_encode(["redirect" => url("/admin/dash/home")]);
            return;
        }
        $adminUpdate->first_name = $data["first_name"];
        $adminUpdate->last_name = $data["last_name"];
        $adminUpdate->email = $data["email"];
        $adminUpdate->password = (!empty($data["password"]) ? $data["password"] : $adminUpdate->password);

        if($data['password'] != $data['confirm_pass']){
            $this->message->error("As senhas não conferem!")->flash();
            echo json_encode(["reload" => true]);
            return;
        }
        if (!$adminUpdate->save()) {
            $json["message"] = $adminUpdate->message()->render();
            echo json_encode($json);
            return;
        }

        $this->message->success("Sua conta foi atualizada com sucesso!")->flash();
        echo json_encode(["reload" => true]);
        return;
    }


    public function updatePhoto(?array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $adminPhoto = (new Admin())->findById($data["admin_id"]);
        //upload photo
        if (!empty($_FILES["photo"])) {
            if ($adminPhoto->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$adminPhoto->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$adminPhoto->photo}");
                (new Thumb())->flush($adminPhoto->photo);
            }

            $files = $_FILES["photo"];
            $upload = new Upload();
            $image = $upload->image($files, md5(uniqid(time())), 600);

            if (!$image) {
                $json["message"] = $upload->message()->render();
                echo json_encode($json);
                return;
            }

            $adminPhoto->photo = $image;
        }

        if (!$adminPhoto->save()) {
            $json["message"] = $adminPhoto->message()->render();
            echo json_encode($json);
            return;
        }

        $this->message->success("Sua foto foi atualizada com sucesso!")->flash();
        echo json_encode(["redirect" => url("/admin/settings/photo")]);
        return;
    }

    public function deletePhoto(?array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $adminPhoto = (new Admin())->findById($data["admin_id"]);
        $adminPhoto->photo = $data['photo'];

        if ($adminPhoto->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$adminPhoto->photo}")) {
            unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$adminPhoto->photo}");
            (new Thumb())->flush($adminPhoto->photo);
        }

        if (!$adminPhoto->save()) {
            $json["message"] = $adminPhoto->message()->render();
            echo json_encode($json);
            return;
        }

        $this->message->success("Foto retirada com sucesso")->flash();
        echo json_encode(["redirect" => url("/admin/settings/photo")]);
        return;
    }
}
