<?php

namespace AdminBar\Tests;

use AdminBar\Menu;
use \Illuminate\Http\Request;
use Mockery as m;

class MenuTest  extends TestCase{
   public function testGetOptions(){
        $config = array(
            ['title'=>'admin','path'=>'admin/top']
        );
        $request = m::mock(Request::class);
        $menu = new Menu($request, $config);
        $this->assertEquals('admin', $menu->getOptions()->first()->getTitle());
    }
    public function testGetOptionsWithChildMenu(){
        $config = array(
            ['title'=>'childmenu','path'=>[
                    ['title'=>'child1','path'=>'admin/child1'],
                                        ]
            ]
        );
        $request = m::mock(Request::class);
        $menu = new Menu($request, $config);
        // dd($menu->getOptions()->first());
        $this->assertEquals('childmenu', $menu->getOptions()->first()->getTitle());
        $this->assertEquals('child1', $menu->getOptions()->first()->getOptions()->first()->getTitle());
    }
    public function testShouldShow(){

        // todo@shira traitかabstract classに移動する?
        $request = m::mock(Request::class);

        $config = array();
        $menu = new Menu($request, $config);
        $this->assertTrue($menu->shouldShow());
    }
    public function testShouldShowIfFilterNotMatch(){
        $title = 'admin';
        $path = '/admin/top';
        $filter = '/post';
        $config = array();
     
        $request = m::mock(Request::class);
        $request->shouldReceive('is')->with($filter)->once()->andReturn(true);

        $option = new Menu($request, $config, $filter);
        $this->assertTrue($option->shouldShow());
    }

    public function testShouldNotShowIfFilterDoesNotMatch(){
        $title = 'admin';
        $path = '/admin/top';
        $filter = '/post';
        $request = m::mock(Request::class);
        $request->shouldReceive('is')->with($filter)->once()->andReturn(false);

        $option = new Menu($request, array(), $filter);
        $this->assertFalse($option->shouldShow());
    }

}
