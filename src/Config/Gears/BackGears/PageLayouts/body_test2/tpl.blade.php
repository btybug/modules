<div class="row">
    <div class="col-md-12 menu_placeholder">
        <nav class="navbar navbar-top {!! $settings['navstyle'] or null !!}">
            <div id="navbar" class="navbar-collapse collapse">
                <div class="container-fluid">
                    <ul class="nav navbar-nav tabnav {!! $settings['menustyle'] or null !!}">

                        @if(isset($settings['menu']))
                            @foreach($settings['menu'] as $key=>$item)
                                <li class=@if(!$key)"active"@endif><a
                                            href="{!! $item['url'] !!}">{!! $item['title'] !!}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="col-md-12 container_placeholder">
        @yield('page')
    </div>
</div>
<style>
    .navbar {
        background: rgba(157, 200, 0, 1);
        /* ms ( IE 10.0+ ) */
        background: -ms-linear-gradient(180deg, rgba(157, 200, 0, 1) 0.14%, rgba(113, 150, 0, 1) 99.75%);
        /* WebKit (Chrome 10.0+, safari 5.1+ )*/
        background: -webkit-linear-gradient(180deg, rgba(157, 200, 0, 1) 0.14%, rgba(113, 150, 0, 1) 99.75%);
        /* Moz ( Moz 3.6+ )*/
        background: -moz-linear-gradient(180deg, rgba(157, 200, 0, 1) 0.14%, rgba(113, 150, 0, 1) 99.75%);
        /* Opera ( opera 11.6+ )*/
        background: -o-linear-gradient(180deg, rgba(157, 200, 0, 1) 0.14%, rgba(113, 150, 0, 1) 99.75%);
        /* W3C Markup */
        background: linear-gradient(180deg, rgba(157, 200, 0, 1) 0.14%, rgba(113, 150, 0, 1) 99.75%);
        border: none;
        border-radius: 0;
        border-bottom: solid 2px #efefef;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);

    }

    .navbarroundblue {
        background: #1b98db;
        /* ms ( IE 10.0+ ) */
        background: -ms-linear-gradient(180deg, #1b98db 0.14%, #0785dc 99.75%);
        /* WebKit (Chrome 10.0+, safari 5.1+ )*/
        background: -webkit-linear-gradient(180deg, #1b98db 0.14%, #0785dc 99.75%);
        /* Moz ( Moz 3.6+ )*/
        background: -moz-linear-gradient(180deg, #1b98db 0.14%, #0785dc 99.75%);
        /* Opera ( opera 11.6+ )*/
        background: -o-linear-gradient(180deg, #1b98db 0.14%, #0785dc 99.75%);
        /* W3C Markup */
        background: linear-gradient(180deg, #1b98db 0.14%, #0785dc 99.75%);
        border: none;
        border-radius: 100px;
        border-bottom: solid 2px #efefef;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);

    }

    .tabnav > li > a, .dropdown-menu > li > a:focus, .dropdown-menu > li > a:hover, .dropdown-menu > li > a, .dropdown-menu > li {
        color: #FFF;
        font-weight: bold;

    }

    .tabnav > li > a:focus, .tabnav > li.active > a, .nav > li > a:hover, .nav .open > a, .nav .open > a:focus, .nav .open > a:hover, .dropdown-menu > li > a:focus, .dropdown-menu > li > a:hover {

        background: #efefef;
        color: rgba(157, 200, 0, 1);
        box-shadow: 2px -2px 2px rgba(0, 0, 0, 0.2), -2px -2px 2px rgba(0, 0, 0, 0.1);
    }

    .navbar a, .dropdown-menu > li > a, .dropdown-menu > li > a:focus, .dropdown-menu > li > a:hover, .navbar-toggle {

    }

    .dropdown-menu {
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .menuround > li {
        padding: 5px;
    }

    .menuround > li > a {
        border-radius: 50px;
        padding: 10px 15px;
    }

    .navbar-toggle .icon-bar {
        color: #fff;
        background: #fff;
    }</style>
