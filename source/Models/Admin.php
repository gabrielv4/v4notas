<?php

namespace Source\Models;

use Source\Core\Model;

/**
 *
 * @package Source\Models
 */
class Admin extends Model
{
    /**
     * Admin constructor.
     */
    public function __construct()
    {
        parent::__construct("admins", ["id"], ["first_name", "last_name", "email", "password"]);
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param string $photo
     * @return Admin
     */
    public function bootstrap(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $photo
    
    ): Admin {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->photo = $photo;
        return $this;
    }

    /**
     * @param string $email
     * @param string $columns
     * @return null|Admin
     */
    public function findByEmail(string $email, string $columns = "*"): ?Admin
    {
        $find = $this->find("email = :email", "email={$email}", $columns);
        return $find->fetch();
    }

    /**
     * @return string
     */
    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * @return string|null
     */
    public function photo(): ?string
    {
        if ($this->photo && file_exists(__DIR__ . "/../../" . CONF_UPLOAD_DIR . "/{$this->photo}")) {
            return $this->photo;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->message->warning("Nome, sobrenome, email e senha são obrigatórios");
            return false;
        }

        if (!is_email($this->email)) {
            $this->message->warning("O e-mail informado não tem um formato válido");
            return false;
        }

        if (!is_passwd($this->password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->warning("A senha deve ter entre {$min} e {$max} caracteres");
            return false;
        } else {
            $this->password = passwd($this->password);
        }

        /** Admin Update */
        if (!empty($this->id)) {
            $adminId = $this->id;

            if ($this->find("email = :e AND id != :i", "e={$this->email}&i={$adminId}", "id")->fetch()) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$adminId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Admin Create */
        if (empty($this->id)) {
            if ($this->findByEmail($this->email, "id")) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            $adminId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($adminId))->data();
        return true;
    }
}