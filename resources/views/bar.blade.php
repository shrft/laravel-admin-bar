<link rel='stylesheet' type='text/css' property='stylesheet' href="{{asset('vendor/adminbar/app.css')}}">
<script src="{{asset('vendor/adminbar/app.js')}}" async></script>
<div id="shrft-adminbar-minimized"><img src="{{asset('vendor/adminbar/mini-icon.png')}}"></div>
<header id="shrft-adminbar-header">
    <div id="shrft-adminbar-container">
        <ul class="horizontal">
            @foreach($menus->getOptions() as $option)
                @if($option->shouldShow())
            <li>
                @if($option->isMenu())
                <div class="dropdown">
                    <a class="dropbtn">
                        {{$option->getTitle()}}
                        <span class="dropdown-caret mt-1"></span>
                    </a>
                        <div class="dropdown-content">
                            <ul class="vertical">
                                @foreach($option->getOptions() as $option)
                                    <li><a href="{{$option->getPath()}}">{{$option->getTitle()}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                </div>
                @else
                        <a href="{{$option->getPath()}}">{{$option->getTitle()}}</a>
                @endif

            </li>
            @endif
            @endforeach
        </ul>
        <span id="shrft-adminbar-header-close">×</span>
    </div>
</header>