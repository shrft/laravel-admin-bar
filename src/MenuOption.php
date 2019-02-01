<?php
namespace Shrft\AdminBar;

class MenuOption{
    protected $request;
    protected $title;
    protected $path;
    protected $filter;
    public function __construct($request, $title, $path, $filter=null){
        $this->request = $request;
        $this->title = $title;
        $this->path = $path;
        $this->filter = $filter;
    }
    // todo: it might be better to move this method to trait.
    public function isMenu(){
        return false;
    }
    public function shouldShow(){
        if(!$this->checkFilterPasses()){
            return false;
        }
        if(!$this->getPath()){
            return false;
        }
        return true;
    }
    public function getPath(){
        if(is_callable($this->path)){
            return call_user_func($this->path, $this->request);
        }
        return $this->path;
    }
    public function getTitle(){
        return $this->title;
    }
    protected function checkFilterPasses(){
        $filter = $this->getFilter();
        if(!$filter) return true;

        if(is_callable($filter)){
            return call_user_func($filter, $this->request);
        }
        if(!$this->request->is($this->filter)){
            return false;
        }
        return true;
    }
    protected function getFilter(){
        return $this->filter;
    }
}