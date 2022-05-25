<?php


namespace Source\Services;


use Source\Models\Client;

use Source\Models\Nfse;
use Source\Support\Message;

/**
 * Class NfseSend
 * @package Source\Services
 */
class NfseSend
{

    /** @var string */
    protected $server;

    /**@var string */
    protected $tokenLogin;

    /** @var array */
    protected $company;

    /** @var array */
    protected $fields;

    /** @var Client */
    protected $order;

    /** @var Nfse */
    protected $nfse;

    /** @var */
    protected $endpoint;

    /** @var */
    protected $method;

    /** @var */
    protected $apiReference;

    /** @var */
    protected $response;

    /**
     * @var Message
     */
    protected $message;

    /**
     * NfseSend constructor.
     */
    public function __construct()
    {
        $this->server = CONF_NFSE_HOST;
        $this->tokenLogin = CONF_NFSE_TOKEN;
        $this->company = CONF_NFSE_COMPANY;
        $this->message = new Message();
        $this->nfse = new Nfse();
    }

    /**
     * @return Message
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * @param Client $order
     * @return $this
     */
    public function setOrder(Client $order): NfseSend
    {
        $this->order = $order;
        $this->apiReference = $order->id;
        return $this;
    }

    /**
     *
     */
    public function setNotificationWebhook()
    {
        $this->endpoint = "/v2/hooks";
        $this->fields = [
            "cnpj" => $this->order->cnpj,
            "event" => "nfse",
            "url" => CONF_NFSE_CALLBACK
        ];

        $this->dispatch();
    }

    /**
     * @param string $id
     */
    public function deleteNotificationWebhook(string $id)
    {
        $this->method = 'DELETE';
        $this->endpoint = "/v2/hooks/{$id}";

        $this->dispatch();
    }

    /**
     *
     */
    public function testNotification()
    {
        $this->method = 'POST';
        $this->endpoint = "/v2/nfse/" . $this->apiReference . "/hook";
        $this->dispatch();
    }

    /**
     * @return bool
     */
    public function sendNfSe()
    {
        if ($this->getinfo()) {
            return true;
        }

        $this->endpoint = "/v2/nfse?ref=" . $this->order->id;
        $this->fields = [
            "data_emissao" => date_fmt_app(),
            "incentivador_cultural" => "false",
            "natureza_operacao" => "1",
            "optante_simples_nacional" => "true",
            "prestador" => $this->company,

            "tomador" => array(
                "cnpj" => str_replace(['.', '-', '/'], '', $this->order->cnpj),
                "razao_social" => $this->order->company_name,
                "email" => $this->order->email_stakeholder,
                "endereco" => array(
                    "codigo_municipio" => "4106902",
                    "bairro" => $this->order->district,
                    "cep" => $this->order->cep,
                    "logradouro" => $this->order->complement,
                    "numero" => $this->order->number,
                    "uf" => $this->order->uf
                )
            ),
            "servico" => array(
                "valor_servicos" => $this->order->fee_value,
                "aliquota" => "4",
                "iss_retido" => "false",
                "item_lista_servico" => "0107",
                "discriminacao" => "Serviços prestados"
            )
        ];

        if ($this->dispatch()) {
            $this->nfse->client_id = $this->order->id;
            $this->nfse->send_init = true;
            $this->nfse->status = 'processando_autorizacao';
            $this->nfse->save();
            return true;
        }

        $this->nfse->client_id = $this->order->id;
        $this->nfse->status = 'erro_autorizacao';
        $this->nfse->error = $this->response->erros->mensagem;
        $this->nfse->save();


        $this->message->title("Erro {$this->response->erros->codigo} na API")->warning($this->response->erros->mensagem);
        return false;
    }


    /**
     * @return bool
     * @throws \Exception
     */
    public function getinfo(): bool
    {
        $this->endpoint = "/v2/nfse/" . $this->apiReference;
        if ($this->dispatch()) {

            if (!empty($this->response->status) && $this->response->status == 'autorizado') {
                $this->nfse->link = $this->response->url_danfse;
                $this->nfse->status = $this->response->status;
                $this->nfse->send_at = date_fmt_app();
                return $this->nfse->save();
            }

            if (!empty($this->response->status) && $this->response->status == 'erro_autorizacao') {
                $this->nfse->status = $this->response->status;
                $this->nfse->error = $this->response->erros->mensagem;
                return $this->nfse->save();

            }
        }
        return false;
    }

    /**
     * @return bool
     */
    private function dispatch(): bool
    {
        // Inicia o processo de envio das informações usando o cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->server . $this->endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (!empty($this->method)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
        }

        if (!empty($this->fields)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->fields));
        }

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$this->tokenLogin");

        $this->response = json_decode(curl_exec($ch));

        if (empty($this->response->erros) && empty($this->response->codigo)) {
            return true;
        } elseif (!empty($this->response->codigo)) {
            $this->response->erros = $this->response;
            return false;
        } else {
            $this->response->erros = $this->response->erros[0];
            return false;
        }
    }
}