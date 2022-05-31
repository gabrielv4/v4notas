<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Core\View;
use Source\Support\Email;


/**
 *
 * @package Source\Models
 */
class Client extends Model
{
    /**
     * Client constructor.
     */
    public function __construct()
    {
        parent::__construct("clients", ["id"], [
            "name_project",
            "name_stakeholder",
            "phone_stakeholder",
            "email_stakeholder",
            "company_name",
            "cnpj",
            "managing_partner",
            "cep",
            "city",
            "uf",
            "district",
            "street",
            "number",
            "complement",
            "start_project",
            "first_payment",
            "contract_duration",
            "pay_day",
            "fee_value",
            "advisor",
            "origin",
            "status"
        ]);
    }

    /**
     * @return Client
     */
    public function bootstrap(
        string $name_project,
        string $name_stakeholder,
        string $phone_stakeholder,
        string $email_stakeholder,
        string $financial_name,
        string $financial_email,
        string $company_name,
        string $cnpj,
        string $managing_partner,
        string $cep,
        string $city,
        string $uf,
        string $district,
        string $street,
        string $number,
        string $complement,
        string $start_project,
        string $first_payment,
        string $contract_duration,
        string $pay_day,
        string $fee_value,
        string $advisor,
        string $origin,
        string $status

    ): Client {
        $this->name_project = $name_project;
        $this->name_stakeholder = $name_stakeholder;
        $this->phone_stakeholder = $phone_stakeholder;
        $this->email_stakeholder = $email_stakeholder;
        $this->financial_name = $financial_name;
        $this->financial_email = $financial_email;
        $this->company_name = $company_name;
        $this->cnpj = $cnpj;
        $this->managing_partner = $managing_partner;
        $this->cep = $cep;
        $this->city = $city;
        $this->uf = $uf;
        $this->district = $district;
        $this->street = $street;
        $this->number = $number;
        $this->complement = $complement;
        $this->start_project = $start_project;
        $this->first_payment = $first_payment;
        $this->contract_duration = $contract_duration;
        $this->pay_day = $pay_day;
        $this->fee_value = $fee_value;
        $this->advisor = $advisor;
        $this->origin = $origin;
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $email
     * @param string $columns
     * @return null|Client
     */
    public function findByEmail(string $email, string $columns = "*"): ?Client
    {
        $find = $this->find("email = :email", "email={$email}", $columns);
        return $find->fetch();
    }

    public function findByName(string $name, string $columns = "*"): ?Client
    {
        $find = $this->find("company_name = :company_name ", "company_name={$name}", $columns);
        return $find->fetch();
    }

    public function findByDay(int $day, string $columns = "*"): ?array
    {
        $find = $this->find("pay_day = :day ", "day={$day}", $columns);
        return $find->fetch(true);
    }


    /**
     * @param string $title
     * @param string $subtitle
     * @param string $message
     * @param string|null $link
     * @param string|null $linkTitle
     * @param string|null $subject
     *
     * @return Email
     */
    public function sendEmail(
        string $title,
        string $subtitle,
        string $message,
        ?string $link = null,
        ?string $linkTitle = null,
        ?string $subject = null
    ): Email {
        $view = new View(__DIR__.'/../../shared/views/email');
        $bodyMessage = $view->render("default", [
            "subject" => ($subject ?? $title),
            "title" => $title,
            "subtitle" => $subtitle,
            "user" => $this,
            "message" => $message,
            "link" => $link,
            "linkTitle" => $linkTitle
        ]);


        return (new Email())->setUser($this)->bootstrap(
            ($subject ?? $title),
            $bodyMessage,
            $this->financial_email,
            "{$this->name_stakeholder}"
        );
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

        /** Client Update */
        if (!empty($this->id)) {
            $clientId = $this->id;

            $this->update($this->safe(), "id = :id", "id={$clientId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Client Create */
        if (empty($this->id)) {

            $clientId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($clientId))->data();
        return true;
    }
}