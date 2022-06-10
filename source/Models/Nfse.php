<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Core\View;
use Source\Support\Email;

/**
 *
 * @package Source\Models
 */
class Nfse extends Model
{
    /**
     * Admin constructor.
     */
    public function __construct()
    {
        parent::__construct("nfse", ["id"], ["client_id"]);
    }

    /**
     * @param string $client_id
     * @param string $name_client
     * @param string $send_init
     * @param string $link
     * @param string $status
     * @param string $error
     * @param string $send_at
     * @param string $code_nfse
     * @return Nfse
     */
    public function bootstrap(
        string $client_id,
        string $name_client,
        string $send_init,
        string $link,
        string $status,
        string $error,
        string $send_at,
        string $invoice_code

    ): Admin {
        $this->client_id = $client_id;
        $this->name_client = $name_client;
        $this->send_init = $send_init;
        $this->link = $link;
        $this->status = $status;
        $this->error = $error;
        $this->send_at = $send_at;
        $this->invoice_code = $invoice_code;
        return $this;
    }


    public function client(): ?Client
    {
        if ($this->client_id) {
            return (new Client())->findById($this->client_id);
        }
        return null;
    }

    /**
     * @param int $id
     * @param string $columns
     * @return null|mixed|Model
     */
    public function findByCode(string $code, string $columns = "*"): ?Model
    {
        $find = $this->find("invoice_code = :code", "code={$code}", $columns);
        return $find->fetch();
    }

    /**
     * @param int $id
     * @param string $columns
     * @return null|mixed|Model
     */
    public function findByClient(int $id, string $columns = "*"): ?array
    {
        $find = $this->find("client_id = :id", "id={$id}", $columns);
        return $find->fetch(true);
    }

    /**
     * @param int $id
     * @param string $columns
     * @return null|mixed|Model
     */
    public function findByLastlient(int $id, string $columns = "*"): ?array
    {
        $find = $this->find("client_id = :id", "id={$id}", $columns)->order("send_at DESC")->limit(1);
        return $find->fetch(true);
    }

    public function findByLastInvoiceId(int $id, string $columns = "*"): ?array
    {
        $find = $this->find("client_id = :id", "id={$id}", $columns)->order("id DESC")->limit(1);
        return $find->fetch(true);
    }



    /**
     * @param Nfse $invoice
     * @param $type
     * @return bool
     */
    public function sendEmailNfse(Nfse $invoice): bool
    {
        if(!$invoice){
            return false;
        }
        $invoice->sendEmail(
            "Emissão de NFS-e | ".CONF_SITE_NAME,
            "",
        "
            <p>Prezado(a), {$invoice->client()->financial_name} </p>
            <p>Esta mensagem refere-se à NFS-e emitida por ".CONF_SITE_NAME.", portador do CNPJ ".CONF_COMPANY_CNPJ."
            por serviços prestados a {$invoice->client()->company_name} portadora do CNPJ {$invoice->client()->cnpj}, 
            no dia ".date_fmt($invoice->send_at)."</p>
           
            <p>Para acessar a nota <a href='{$invoice->link}'>clique aqui</a>, caso não consiga abrir 
            sua nota entre em contato</p>
            <p></p>
            <p><i>Caso essa nota não pertença a você por favor desconsidere este e-mail</i></p>"

        )->queue();


        return true;

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


        return (new Email())->setUser($this->client())->bootstrap(
            ($subject ?? $title),
            $bodyMessage,
            $this->client()->financial_email,
            "{$this->name_stakeholder}",
            $this->id
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


        /** Nfse Update */
        if (!empty($this->id)) {
            $nfseId = $this->id;

            $this->update($this->safe(), "id = :id", "id={$nfseId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Nfse Create */
        if (empty($this->id)) {

            $nfseId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($nfseId))->data();
        return true;
    }
}