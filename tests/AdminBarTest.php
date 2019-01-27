<?php

namespace Shrft\AdminBar\Tests;

use \Illuminate\Http\Request;
use Mockery as m;
use Shrft\AdminBar\AdminBar;

class AdminBarTest  extends TestCase{
    public function testShouldShowIfAdmin(){
        $isAdmin = false;
        $exclude_path = null;
        $request = m::mock(Request::class);
        // $request->shouldReceive('is')->with('admin/*')->once()->andReturn(true);

        $bar = new AdminBar($request, $exclude_path, $isAdmin);
        $this->assertFalse($bar->shouldShow());

        $isAdmin = true;
        $bar = new AdminBar($request, $exclude_path, $isAdmin);
        $this->assertTrue($bar->shouldShow());

        $isAdmin = function(){ return true; };
        $bar = new AdminBar($request, $exclude_path, $isAdmin);
        $this->assertTrue($bar->shouldShow());

        $isAdmin = function(){ return false; };
        $bar = new AdminBar($request, $exclude_path, $isAdmin);
        $this->assertFalse($bar->shouldShow());
    }
    public function testShouldNotShowIfExcludePathMatch(){
        $isAdmin = true;
        $exclude_path = 'admin/*';
        $request = m::mock(Request::class);
        $request->shouldReceive('is')->with('admin/*')->once()->andReturn(true);

        $bar = new AdminBar($request, $exclude_path, $isAdmin);
        $this->assertFalse($bar->shouldShow());
    }
    // todo@shira: exclude pathは複数指定できるようにしたほうがいい
    // todo@shira: is_htmlもテスト追加する
}
