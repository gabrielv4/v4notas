<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Core\Session;
use Source\Core\View;
use Source\Support\Email;

/**
 * Class Auth
 * @package Source\Models
 */
class AuthAdmin extends Model
{
    /**
     * Auth constructor.
     */
    public function __construct()
    {
        parent::__construct("admins", ["id"], ["email", "password"]);
    }

    /**
     * @return null|Admin
     */
    public static function admin(): ?Admin
    {
        $session = new Session();
        if (!$session->has("authAdmin")) {
            return null;
        }

        return (new Admin())->findById($session->authAdmin);
    }

    /**
     * log-out
     */
    public static function logout(): void
    {
        $session = new Session();
        $session->unset("authAdmin");
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function register(Admin $admin): bool
    {
        if (!$admin->save()) {
            $this->message = $admin->message;
            return false;
        }

        $view = new View(__DIR__ . "/../../shared/views/email");
        $message = $view->render("confirm", [
            "first_name" => $admin->first_name,
            "confirm_link" => url("/obrigado/" . base64_encode($admin->email))
        ]);

        (new Email())->bootstrap(
            "Ative sua conta no " . CONF_SITE_NAME,
            $message,
            $admin->email,
            "{$admin->first_name} {$admin->last_name}"
        )->send();

        return true;
    }

    /**
     * @param string $email
     * @param string $password
     * @param bool $save
     * @return bool
     */
    public function login(string $email, string $password, bool $save = false): bool
    {
        if (!is_email($email)) {
            $this->message->warning("O e-mail informado não é válido");
            return false;
        }

        if ($save) {
            setcookie("authEmail", $email, time() + 604800, "/");
        } else {
            setcookie("authEmail", null, time() - 3600, "/");
        }

        if (!is_passwd($password)) {
            $this->message->warning("A senha informada não é válida");
            return false;
        }

        $admin = (new Admin())->findByEmail($email);
        if (!$admin) {
            $this->message->error("O e-mail informado não está cadastrado");
            return false;
        }

        if (!passwd_verify($password, $admin->password)) {
            $this->message->error("A senha informada não confere");
            return false;
        }

        if (passwd_rehash($admin->password)) {
            $admin->password = $password;
            $admin->save();
        }

        //LOGIN
        (new Session())->set("authAdmin", $admin->id);
        return true;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function forget(string $email): bool
    {
        $admin = (new Admin())->findByEmail($email);

        if (!$admin) {
            $this->message->warning("O e-mail informado não está cadastrado.");
            return false;
        }

        $admin->forget = md5(uniqid(rand(), true));
        $admin->save();

        $view = new View(__DIR__ . "/../../shared/views/email");
        $message = $view->render("forget", [
            "first_name" => $admin->first_name,
            "forget_link" => url("/recuperar/{$admin->email}|{$admin->forget}")
        ]);

        (new Email())->bootstrap(
            "Recupere sua senha no " . CONF_SITE_NAME,
            $message,
            $admin->email,
            "{$admin->first_name} {$admin->last_name}"
        )->send();

        return true;
    }

    /**
     * @param string $email
     * @param string $code
     * @param string $password
     * @param string $passwordRe
     * @return bool
     */
    public function reset(string $email, string $code, string $password, string $passwordRe): bool
    {
        $admin = (new Admin())->findByEmail($email);

        if (!$admin) {
            $this->message->warning("A conta para recuperação não foi encontrada.");
            return false;
        }

        if ($admin->forget != $code) {
            $this->message->error("Desculpe, mas o código de verificação não é válido.");
            return false;
        }

        if (!is_passwd($password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->info("Sua senha deve ter entre {$min} e {$max} caracteres.");
            return false;
        }

        if ($password != $passwordRe) {
            $this->message->warning("Você informou duas senhas diferentes.");
            return false;
        }

        $admin->password = $password;
        $admin->forget = null;
        $admin->save();
        return true;
    }
}