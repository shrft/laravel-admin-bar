<?php

namespace Shrft\AdminBar\Tests;

use Shrft\AdminBar\Menu;
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
    public function testChildOptionFilter(){

        $config = ['title'=>'Sub Menu', 'path'=>[
                             ['title'=>'Option1', 'path'=>'/path/to/option1', 'filter'=>function(){ return false; }],
                            ]
                        ];

        $request = m::mock(Request::class);
        $option = new Menu($request, [$config]);
        $this->assertFalse(
            $option->getOptions()->first()->getOptions()->first()->shouldShow()
        );
 

    }
}
