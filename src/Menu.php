<?php

namespace Shrft\AdminBar;

use Illuminate\Support\Arr;

class Menu
{
    /**
     * The menu options.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $menuOptions;

    /**
     * The title of this menu.
     *
     * @var string
     */
    protected $title;

    /**
     * The request.
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * The filter to determine if this menu should be shown.
     *
     * @var bool|Closure
     */
    protected $filter;

    /**
     * Create a new Menu instance.
     *
     * @param Illuminate\Http\Request $request
     * @param array                   $menuOptions
     * @param bool|Closure            $filter
     */
    public function __construct($request, $menuOptions = [], $filter = null, $title = null)
    {
        $this->request = $request;
        $this->menuOptions = $this->createMenuOptions($menuOptions);
        $this->title = $title;
        $this->filter = $filter;
    }

    /**
     * Determine if this class is a menu.
     *
     * @return bool
     */
    public function isMenu()
    {
        return true;
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get menu options.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getOptions()
    {
        return $this->menuOptions;
    }

    /**
     * Create menu options collection from options array.
     *
     * @var array
     *
     * @return \Illuminate\Support\Collection
     */
    protected function createMenuOptions($options)
    {
        $menuOptions = [];

        foreach ($options as $option) {
            if (is_array($option['path'])) {
                $menuOptions[] = new Menu($this->request, $option['path'], Arr::get($option, 'filter'), $option['title']);

                continue;
            }

            $menuOptions[] = new MenuOption($this->request, $option['title'], $option['path'], Arr::get($option, 'filter'));
        }

        return collect($menuOptions);
    }

    /**
     * Determine if this menu should be shown.
     *
     * @return bool
     */
    public function shouldShow()
    {
        return $this->checkFilterPasses();
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

    /**
     * Determine if this menu should be shown with filter.
     *
     * @return bool
     */
    protected function checkFilterPasses()
    {
        // todo: the same function exists in MenuOption. refactoring needed.
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
}
