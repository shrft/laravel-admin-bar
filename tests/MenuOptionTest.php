<?php

namespace Shrft\AdminBar\Tests;
use Shrft\AdminBar\MenuOption;
use \Illuminate\Http\Request;
use Mockery as m;

class MenuOptionTest  extends TestCase{
    public function testShouldShowOption(){
        $title = 'admin';
        $path = '/admin/top';
        $filter = null;
        $request = m::mock(Request::class);
        // $request->shouldReceive('path')->once()->andReturn('/');

        $option = new MenuOption($request, $title, $path, $filter);
        $this->assertTrue($option->shouldShow());
    }
    public function testShouldShowIfFilterDoesNotMatch(){
        $title = 'admin';
        $path = '/admin/top';
        $filter = '/post';
        $request = m::mock(Request::class);
        $request->shouldReceive('is')->with($filter)->once()->andReturn(true);

        $option = new MenuOption($request, $title, $path, $filter);
        $this->assertTrue($option->shouldShow());
    }

    public function testShouldNotShowIfFilterDoesNotMatch(){
        $title = 'admin';
        $path = '/admin/top';
        $filter = '/post';
        $request = m::mock(Request::class);
        $request->shouldReceive('is')->with($filter)->once()->andReturn(false);

        $option = new MenuOption($request, $title, $path, $filter);
        $this->assertFalse($option->shouldShow());
    }
    public function testShouldNotShowIfPathIsEmpty(){
        $title = 'admin';
        $path = null;
        $filter = null;
        $request = m::mock(Request::class);

        $option = new MenuOption($request, $title, $path, $filter);
        $this->assertFalse($option->shouldShow());
    }
    public function testShouldShowWithCallableFilter(){
        $title = 'admin';
        $path = '/admin/top';
        $filter = function(){
            return true;
        };
        $request = m::mock(Request::class);
        $option = new MenuOption($request, $title, $path, $filter);
        $this->assertTrue($option->shouldShow());

    }
    public function testGetPath(){
        $title = 'admin';
        $path = '/admin/top';
        $filter = null;
        $request = m::mock(Request::class);
        $option = new MenuOption($request, $title, $path, $filter);
        $this->assertEquals($path, $option->getPath());
    }
    public function testGetPathFromCallback(){
        $title = 'admin';
        $path = function(){ return '/admin/top';};
        $filter = null;
        $request = m::mock(Request::class);
        $option = new MenuOption($request, $title, $path, $filter);
        $this->assertEquals('/admin/top', $option->getPath());
    }
    public function testGetPathFromCallbackWithParameter(){
        $title = 'admin';
        $path = function($request){ 
            return '/post/' . $request->route('id');
        };
        $filter = null;
        $request = m::mock(Request::class);
        $request->shouldReceive('route')->with('id')->once()->andReturn('post_id');
        $option = new MenuOption($request, $title, $path, $filter);
        $this->assertEquals('/post/post_id', $option->getPath());
    }
    public function testGetTitle(){
        $title = 'admin';
        $path = '/admin/top';
        $filter = null;
        $request = m::mock(Request::class);
        $option = new MenuOption($request, $title, $path, $filter);
        $this->assertEquals('admin', $option->getTitle());
    }
    // route aliasも使えた方がいい
    
}
