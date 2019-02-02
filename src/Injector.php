<?php

namespace Shrft\AdminBar;

class Injector
{
    /**
     * @var mixed
     */
    protected $response;

    /**
     * Create Injector instance.
     *
     * @var mixed
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * Inject content to response.
     *
     * @var string
     */
    public function inject($content)
    {
        $original = $this->response->getContent();
        $pos = strripos($original, '</body>');
        if (false !== $pos) {
            $original = substr($original, 0, $pos).$content.substr($original, $pos);
        } else {
            $original = $original.$content;
        }

        $this->response->setContent($original);
        $this->response->headers->remove('Content-Length');

        return $this->response;
    }
}
