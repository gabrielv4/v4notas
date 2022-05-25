<?php
/**
 * Copyright (c) 2019.  V8 Design Soluções para Web
 * @author Vinícios Oliveira <vinicios@v8design.com.br>
 */

namespace Source\Support;


/**
 * Class Response
 * return json for use in front (jquery, vue, etc)
 * @package Source\Support
 */
class Response
{
    /** @var array|null */
    protected $response;


    public function setMessage(Message $message)
    {
        $this->call("message", $message->render());
        return $this;
    }


    /**
     * @param string $key
     * @param $value
     *
     * @return Response
     */
    public function call(string $key, $value): Response
    {
        $this->response[$key] = $value;
        return $this;
    }


    /**
     * @param bool       $endOutput
     * @param array|null $response
     */
    public function send(bool $endOutput = true, ?array $response = null): void
    {
        if (!empty($response)) {
            $this->response = (!empty($this->response) ? array_merge($this->response, $response) : $response);
        }

        header('Content-Type: application/json');
        echo json_encode($this->response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($endOutput) {
            exit;
        }
    }
}