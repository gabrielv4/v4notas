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
class AuthFunctionary extends Model
{
    /**
     * Auth constructor.
     */
    public function __construct()
    {
        parent::__construct("functionarys", ["id"], ["email", "password"]);
    }

    /**
     * @return null|Functionary
     */
    public static function functionary(): ?Functionary
    {
        $session = new Session();
        if (!$session->has("authFunctionary")) {
            return null;
        }

        return (new Functionary())->findById($session->authFunctionary);
    }

    /**
     * log-out
     */
    public static function logout(): void
    {
        $session = new Session();
        $session->unset("authFunctionary");
    }

    /**
     * @param User $user
     * @return bool
     */
    public function register(Functionary $functionary): bool
    {
        if (!$functionary->save()) {
            $this->message = $functionary->message;
            return false;
        }

        $view = new View(__DIR__ . "/../../shared/views/email");
        $message = $view->render("confirm", [
            "first_name" => $functionary->first_name,
            "confirm_link" => url("/obrigado/" . base64_encode($functionary->email))
        ]);

        (new Email())->bootstrap(
            "Ative sua conta no " . CONF_SITE_NAME,
            $message,
            $functionary->email,
            "{$functionary->first_name} {$functionary->last_name}"
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

        $functionary = (new Functionary())->findByEmail($email);
        if (!$functionary) {
            $this->message->error("O e-mail informado não está cadastrado");
            return false;
        }

        if (!passwd_verify($password, $functionary->password)) {
            $this->message->error("A senha informada não confere");
            return false;
        }


        if (passwd_rehash($functionary->password)) {
            $functionary->password = $password;
            $functionary->save();
        }

        //LOGIN
        (new Session())->set("authFunctionary", $functionary->id);
        return true;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function forget(string $email): bool
    {
        $functionary = (new Functionary())->findByEmail($email);

        if (!$functionary) {
            $this->message->warning("O e-mail informado não está cadastrado.");
            return false;
        }

        $functionary->forget = md5(uniqid(rand(), true));
        $functionary->save();

        $view = new View(__DIR__ . "/../../shared/views/email");
        $message = $view->render("forget", [
            "first_name" => $functionary->first_name,
            "forget_link" => url("/recuperar/{$functionary->email}|{$functionary->forget}")
        ]);

        (new Email())->bootstrap(
            "Recupere sua senha no " . CONF_SITE_NAME,
            $message,
            $functionary->email,
            "{$functionary->first_name} {$functionary->last_name}"
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
        $user = (new Functionary())->findByEmail($email);

        if (!$user) {
            $this->message->warning("A conta para recuperação não foi encontrada.");
            return false;
        }

        if ($user->forget != $code) {
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

        $user->password = $password;
        $user->forget = null;
        $user->save();
        return true;
    }
}