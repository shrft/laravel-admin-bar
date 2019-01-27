<?php
namespace AdminBar;

class AdminBar{
    protected $request;
    protected $exclude_path;
    protected $is_admin;
    public function __construct($request, $exclude_path, $is_admin){
        $this->request = $request;
        $this->exclude_path = $exclude_path;
        $this->is_admin = $is_admin;
    }
    public function shouldShow(){
        if(!$this->is_admin()){
            return false;
        }
        if($this->exclude_path && $this->request->is($this->exclude_path)){
            return false;
        }


        return true;
    }
    public function injectAdminBar($response, $menu){
        if(!$this->is_html($response)){
            return $response;
        }
        // todo@shira: constructorから渡せば、他のMenuオブジェクトに後から変更できる
        $menu = new Menu($this->request, $menu);

        $renderedContent = view('adminbar::bar')->with(['menus'=>$menu])->render();

        $injector = new Injector($response);
        return $injector->inject($renderedContent);
    }
    protected function is_admin(){
        if(is_callable($this->is_admin)){
            return call_user_func($this->is_admin);
        }
        return $this->is_admin;
    }
    protected function is_html($response){
            return $response->headers->has('Content-Type') &&
                strpos($response->headers->get('Content-Type'), 'html') !== false;
            // todo@shira: ここもうちょっとちゃんとかんがえたほうがいいかも。
            // || $this->request->getRequestFormat() === 'html';
            // || $this->response->getContent() !== false;
    }
}
