<?php

namespace Source\Models;

use Source\Core\Model;

/**
 *
 * @package Source\Models
 */
class Sales extends Model
{
    public function __construct()
    {
        parent::__construct("sales", ["id"], ["id_product", "name_client", "code"]);
    }

    /**
     * @param string $id_product
     * @param string $name_client
     * @param string $packing_list
     * @param string $escalation_manual
     * @param string $code
     * @return Sales
     */
    public function bootstrap(
        string $id_product,
        string $name_client,
        string $packing_list,
        string $invoice,
        string $installation_manual,
        string $technical_bulletin,
        string $production_drawing,
        string $driver_cpf,
        string $driver_cnh,
        string $vehicle_plate,
        string $boarding_photos,
        string $code
       

    
    ): Sales {
        $this->name_client = $name_client;
        $this->id_product = $id_product;
        $this->packing_list = $packing_list;
        $this->invoice = $invoice;
        $this->installation_manual = $installation_manual;
        $this->technical_bulletin = $technical_bulletin;
        $this->production_drawing = $production_drawing;
        $this->driver_cpf = $driver_cpf;
        $this->driver_cnh = $driver_cnh;
        $this->vehicle_plate = $vehicle_plate;
        $this->boarding_photos = $boarding_photos;
        $this->code = $code;
        
        return $this;
    }

    /**
     * @param string $columns
     * @return null|Sales
     */
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

    public function product(): ?Product
    {
        if ($this->id_product) {
            return (new Product())->findById($this->id_product);
        }
        return null;
    }

   /**
     * @param string $email
     * @param string $columns
     * @return null|Sales
     */
    public function findByCode(string $code, string $columns = "*"): ?Sales
    {
        $find = $this->find("code = :code", "code={$code}", $columns);
        return $find->fetch();
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
            $salesId = $this->id;

            $this->update($this->safe(), "id = :id", "id={$salesId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Product Create */
        if (empty($this->id)) {

            $salesId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($salesId))->data();
        return true;
    }
}