<?php

namespace Source\App\Admin;

use Source\Models\Manuals as ModelsManuals;
use Source\Support\Thumb;
use Source\Support\Upload;

class Manuals extends Auth
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home(?array $data): void
    {

        $doc = (new ModelsManuals())->find();

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Admin",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );


        echo $this->view->render("widgets/manuals/home", [
            "app" => "manuals/home",
            "head" => $head,
            "doc" => $doc->fetch(true),
        ]);
    }

    public function addManuals(?array $data)
    {   

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data);

            $manualsCreate = new ModelsManuals();
            $upload = new Upload();
            $manualsCreate->name = $data["name"];
          
        if (!empty($_FILES["document"])) {
        
            $files = $_FILES["document"];
            $upload = new Upload();
            if($files["type"] == "application/pdf"){
                $doc = $upload->file($files, md5(uniqid(time())));
            }else{
                $doc = $upload->image($files, md5(uniqid(time())), 600);
            }
          

            if (!$doc) {
                $json["message"] = $upload->message()->render();
                echo json_encode($json);
                return;
            }

            $manualsCreate->document = $doc;
        }

            if (!$manualsCreate->save()) {
                $json["message"] = $manualsCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Manual cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/admin/manuals/home");

            echo json_encode($json);
            return;
        }

  

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Admin",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/manuals/addManuals", [
            "app" => "manuals/home",
            "head" => $head,
            "manuals" => "",
        ]);

    }

    public function editManuals(?array $data)
    {   
        $manualUpdate = (new ModelsManuals())->findById($data["id_manual"]);

        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $manualUpdate->name = $data["name"];

             //upload document
             if (!empty($_FILES["document"])) {
                if ($manualUpdate->document && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$manualUpdate->document}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$manualUpdate->document}");
                    if(substr($manualUpdate->document, -3) != "pdf"){
                        (new Thumb())->flush($manualUpdate->document);
                    }
                   
                }
                $files = $_FILES["document"];
                $upload = new Upload();
                if($files["type"] == "application/pdf"){
                    $doc = $upload->file($files, md5(uniqid(time())));
                }else{
                    $doc = $upload->image($files, md5(uniqid(time())), 600);
                }

                $manualUpdate->document = $doc;
            }

            if (!$manualUpdate->save()) {
                $json["message"] = $manualUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Manual atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }
       

        

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Admin",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/manuals/editManuals", [
            "app" => "manuals/home",
            "head" => $head,
            "manual" => $manualUpdate,
        ]);

    }

    public function deleteManuals(?array $data)
    {
           //delete
           if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $manualDelete = (new ModelsManuals())->findById($data["id_manual"]);

            if (!$manualDelete) {
                $this->message->error("Você tentnou deletar um manual que não existe")->flash();
                $json["redirect"] = url("/admin/manuals/home");
                return;
            }

            if ($manualDelete->document && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$manualDelete->document}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$manualDelete->document}");
                if(substr($manualDelete->document, -3) != "pdf"){
                    (new Thumb())->flush($manualDelete->document);
                }
            }

            $manualDelete->destroy();

            $this->message->success("Manual excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("admin/manuals/home")]);

            return;
        }
    }
}