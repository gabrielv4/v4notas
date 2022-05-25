<?php

namespace Source\Models;

use Source\Core\Model;

/**
 *
 * @package Source\Models
 */
class Manuals extends Model
{
    public function __construct()
    {
        parent::__construct("manuals", ["id"], ["name", "document"]);
    }

    /**
     * @param string $name
     * @param string $documents
     * @return Manuals
     */
    public function bootstrap(
        string $name,
        string $document

    
    ): Manuals {
        $this->name = $name;
        $this->$document = $document;
        return $this;
    }

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
            $this->message->warning("Preencha todos os campos");
            return false;
        }

        /** Product Update */
        if (!empty($this->id)) {
            $manualID = $this->id;

            $this->update($this->safe(), "id = :id", "id={$manualID}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Product Create */
        if (empty($this->id)) {

            $manualID = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($manualID))->data();
        return true;
    }
}