<?php

namespace Shrft\AdminBar;

class AdminBar
{
    /**
     * The incoming request.
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * The path pattern which you don't wanna show admin bar.
     *
     * @var string
     */
    protected $exclude_path;

    /**
     * True if a logged in user is admin.
     *
     * @var bool|Closure
     */
    protected $is_admin;

    /**
     * Create a new AdminBar instance.
     *
     * @param Illuminate\Http\Request $request
     * @param string                  $exclude_path
     * @param bool|Closure            $is_admin
     */
    public function __construct($request, $exclude_path, $is_admin)
    {
        $this->request = $request;
        $this->exclude_path = $exclude_path;
        $this->is_admin = $is_admin;
    }

    /**
     * Determine if Admin Bar should be shown.
     *
     * @return bool
     */
    public function shouldShow()
    {
        if (! $this->is_admin()) {
            return false;
        }
        if ($this->exclude_path && $this->request->is($this->exclude_path)) {
            return false;
        }

        return true;
    }

    /**
     * Inject AdminBar to response.
     *
     * @param mixed $response
     * @param array $menu
     */
    public function injectAdminBar($response, $menu)
    {
        if (! $this->is_html($response) || '200' == ! $response->getStatusCode()) {
            return $response;
        }
        $menu = new Menu($this->request, $menu);

        $renderedContent = view('adminbar::bar')->with(['menus'=>$menu])->render();

        $injector = new Injector($response);

        return $injector->inject($renderedContent);
    }

    /**
     * Determine if a user is admin.
     *
     * @return bool
     */
    protected function is_admin()
    {
        if (is_callable($this->is_admin)) {
            return call_user_func($this->is_admin);
        }

        return $this->is_admin;
    }

    /**
     * Determine if response is html document.
     *
     * @param mixed $response
     *
     * @return bool
     */
    protected function is_html($response)
    {
        return $response->headers->has('Content-Type') &&
                false !== strpos($response->headers->get('Content-Type'), 'html');
    }
}
