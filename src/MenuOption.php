<?php

namespace Shrft\AdminBar;

class MenuOption
{
    /**
     * The request.
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * The title of this option.
     *
     * @var string
     */
    protected $title;

    /**
     * The url path this option is linked to.
     *
     * @var string
     */
    protected $path;

    /**
     * The filter to determine if this option should be shown.
     *
     * @var bool|Closure
     */
    protected $filter;

    /**
     * Create a new MenuOption instance.
     *
     * @param Illuminate\Http\Request $request
     * @param string                  $title
     * @param string                  $path
     * @param mixed                   $filter
     */
    public function __construct($request, $title, $path, $filter = null)
    {
        $this->request = $request;
        $this->title = $title;
        $this->path = $path;
        $this->filter = $filter;
    }

    /**
     * Determine if this class is a menu.
     *
     * @return bool
     */
    public function isMenu()
    {
        // todo: it might be better to move this method to trait.
        return false;
    }

    /**
     * Determine if this menu should be shown.
     *
     * @return bool
     */
    public function shouldShow()
    {
        if (! $this->checkFilterPasses()) {
            return false;
        }
        if (! $this->getPath()) {
            return false;
        }

        return true;
    }

    /**
     * Get path.
     *
     * @return mixed
     */
    public function getPath()
    {
        if (is_callable($this->path)) {
            return call_user_func($this->path, $this->request);
        }

        return $this->path;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Determine if this option should be shown with filter.
     *
     * @return bool
     */
    protected function checkFilterPasses()
    {
        $filter = $this->getFilter();
        if (! $filter) {
            return true;
        }

        if (is_callable($filter)) {
            return call_user_func($filter, $this->request);
        }
        if (! $this->request->is($this->filter)) {
            return false;
        }

        return true;
    }

    /**
     * Get the filter.
     *
     * @return bool|Closure
     */
    protected function getFilter()
    {
        return $this->filter;
    }
}
