<?php

namespace Shrft\AdminBar;

class Menu
{
    protected $menuOptions;
    protected $title;
    protected $request;
    protected $filter;

    public function __construct($request, $menuOptions = [], $filter = null, $title = null)
    {
        // dd($request);
        $this->request = $request;
        $this->menuOptions = $this->createMenuOptions($menuOptions);
        // dd('hey');
        $this->title = $title;
        $this->filter = $filter;
    }

    public function isMenu()
    {
        return true;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getOptions()
    {
        // dd($this->menuOptions);
        return $this->menuOptions;
    }

    protected function createMenuOptions($options)
    {
        $menuOptions = [];
        foreach ($options as $option) {
            // dd($option);
            if (is_array($option['path'])) {
                $menuOptions[] = new Menu($this->request, $option['path'], array_get($option, 'filter'), $option['title']);
                continue;
            }
            $menuOptions[] = new MenuOption($this->request, $option['title'], $option['path'], array_get($option, 'filter'));
            // dd($this->menuOptions);
        }

        return collect($menuOptions);
        // dd($this->menuOptions->first());
    }

    public function shouldShow()
    {
        return $this->checkFilterPasses();
    }

    protected function getFilter()
    {
        return $this->filter;
    }

    // todo: the same function exists in MenuOption. refactoring needed.
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
}
