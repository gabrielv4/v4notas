<?php

namespace Source\Core;

use Source\Support\Message;
use Source\Support\Response;
use Source\Support\Seo;

/**
 * FSPHP | Class Controller
 *
 * @author Robson V. Leite <cursos@upinside.com.br>
 * @package Source\Core
 */
class Controller
{
    /** @var View */
    protected $view;

    /** @var Seo */
    protected $seo;

    /** @var Message */
    protected $message;

    /** @var Response */
    protected $response;

    /** @var */
    protected $httpMethod;

    /** @var array */
    protected $defaultData;

    /** @var mixed */
    protected $link;

    /** @var string */
    protected $path;

    /**
     * Controller constructor.
     * @param string|null $pathToViews
     */
    public function __construct(string $pathToViews = null)
    {
        $this->view = new View($pathToViews);
        $this->seo = new Seo();
        $this->message = new Message();
        $this->response = new Response();

        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->link = filter_var($_SERVER['HTTP_HOST'], FILTER_SANITIZE_STRIPPED);
        $this->path = $this->setPath($_SERVER['REQUEST_URI'], "v4notas");

        //controller router www
        if (CONF_FORCE_WWW && !is_localhost() && !preg_match('/www/', $this->link)) {
            redirect(url($this->path));
        }

        $this->defaultData = [

        ];
    }


    /**
     * @param string $title
     * @param string $description
     * @param string $url
     * @param string $image
     * @param string $templateName
     * @param array $dataPage
     * @param bool $follow
     * @return string
     */
    protected function render(
        string $title,
        string $description,
        string $url,
        string $image,
        string $templateName,
        array $dataPage = [],
        ?bool $follow = true,
        ?bool $enableCache = false
    ) {
        $dataPage['head'] = $this->seo->render($title, $description, $url, $image, $follow);
        $data = array_merge($this->defaultData, $dataPage);

        return $this->view->render($templateName, $data);
    }

    /**
     * @param string $request_uri
     * @param string|null $dirLocalHost
     * @param string|null $dirRemoteHost
     *
     * @return null|string
     */
    private function setPath(string $request_uri, ?string $dirLocalHost = null, ?string $dirRemoteHost = null): ?string
    {
        $path = substr(filter_var($request_uri, FILTER_SANITIZE_STRIPPED), 1);

        if (is_localhost() && !is_null($dirLocalHost)) {
            $path = str_replace($dirLocalHost, "", $path);
            return ($path[0] == "/" ? substr($path, 1) : $path);
        }

        if (!is_localhost() && !is_null($dirRemoteHost)) {
            $path = str_replace($dirRemoteHost, "", $path);
            return ($path[0] == "/" ? substr($path, 1) : $path);
        }

        return (!empty($path[0]) && $path[0] == "/" ? substr($path, 1) : $path);
    }
}