<?php

namespace Source\Models;

use Source\Core\Model;

/**
 *
 * @package Source\Models
 */
class Functionary extends Model
{
    public function __construct()
    {
        parent::__construct("functionarys", ["id"], ["first_name", "last_name", "email", "password"]);
    }

    /**
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $password
     * @param string $photo
     * @return Functionary
     */
    public function bootstrap(
        string $first_name,
        string $last_name,
        string $email,
        string $password,
        string $photo

    
    ): Functionary {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->photo = $photo;
        return $this;
    }

    /**
     * @param string $email
     * @param string $columns
     * @return null|Functionary
     */
    public function findByEmail(string $email, string $columns = "*"): ?Functionary
    {
        $find = $this->find("email = :email", "email={$email}", $columns);
        return $find->fetch();
    }

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

        /** Functionary Update */
        if (!empty($this->id)) {
            $functionaryId = $this->id;

            if ($this->find("email = :e AND id != :i", "e={$this->email}&i={$functionaryId}", "id")->fetch()) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$functionaryId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Functionary Create */
        if (empty($this->id)) {
            if ($this->findByEmail($this->email, "id")) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            $functionaryId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($functionaryId))->data();
        return true;
    }
}