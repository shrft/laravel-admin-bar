<?php
namespace AdminBar;

class Injector{
    protected $response;
    public function __construct($response){
        $this->response = $response;
    }
    public function inject($content){
        $original = $this->response->getContent();
        $pos = strripos($original, '</body>');
        if (false !== $pos) {
            $original = substr($original, 0, $pos) . $content . substr($original, $pos);
        } else {
            $original = $original . $content;
        }
        \Log::info($original);
        $this->response->setContent($original);
        $this->response->headers->remove('Content-Length');
        return $this->response;
    }
}

