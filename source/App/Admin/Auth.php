<?php

namespace Source\App\Admin;

use Source\Core\Controller;
use Source\Models\AuthAdmin;

/**
 * Class Admin
 * @package Source\App\Admin
 */
class Auth extends Controller
{
    /**
     * @var \Source\Models\Admin|null
     */
    protected $admin;

    /**
     * Admin constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN . "/");

        $this->admin = AuthAdmin::admin();

        if (!$this->admin) {
            $this->message->error("Para acessar é preciso logar-se")->flash();
            redirect("/admin/login");
        }
    }
}