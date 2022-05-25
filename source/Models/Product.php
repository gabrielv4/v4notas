<?php

namespace Source\Models;

use Source\Core\Model;

/**
 *
 * @package Source\Models
 */
class Product extends Model
{
    public function __construct()
    {
        parent::__construct("products", ["id"], ["name", "model","oc","number_serie","tag","p_max"]);
    }

    /**
     * @param string $name
     * @param string $price
     * @param string $model
     * @param string $oc
     * @param string $n_serie
     * @param string $tag
     * @param string $p_max
     * @return Product
     */
    public function bootstrap(
        string $name,
        string $model,
        string $oc,
        string $number_serie,
        string $tag,
        string $p_max

    
    ): Product {
        $this->name = $name;
        $this->model = $model;
        $this->oc = $oc;
        $this->number_serie = $number_serie;
        $this->tag = $tag;
        $this->p_max = $p_max;
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
            $productId = $this->id;

            $this->update($this->safe(), "id = :id", "id={$productId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Product Create */
        if (empty($this->id)) {

            $productId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($productId))->data();
        return true;
    }
}