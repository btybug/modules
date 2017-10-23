<div class="row">
    <div class="col-md-10 menu_placeholder">
        @if(isset($settings['menus']) and $settings['menus']==1)
            <nav class="navbar navbar-top">
                <div id="navbar" class="navbar-collapse collapse">
                    @inject('menu','App\Modules\General\Menu')
                    <div class="container">
                        <ul class="nav navbar-nav tabnav">
                            @foreach($menu->menu() as $key=>$item)
                                <li class=@if(!$key)"active"@endif><a
                                            href="{!! $item['url'] !!}">{!! $item['title'] !!}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </nav>
        @endif
        @if(isset($settings['menus']) and $settings['menus']==2)
            <nav class="navbar navbar-top">
                <div id="navbar" class="navbar-collapse collapse">
                    <div class="container">
                        <ul class="nav navbar-nav tabnav">
                            <li class="active"><a href="#">Item 1</a></li>
                            <li><a href="#">Item 2</a></li>
                            <li><a href="#">Item 3</a></li>
                            <li><a href="#">Item 4</a></li>
                            <li><a href="#">Item 5</a></li>
                            <li><a href="#">Item 6</a></li>
                            <li><a href="#">Item 7</a></li>
                            <li><a href="#">Item 8</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        @endif
    </div>

    <div class="col-md-10 container_placeholder">
    </div>
</div>
