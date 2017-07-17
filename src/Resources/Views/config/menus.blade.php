@extends('layouts.admin')
@section('content')
    <nav class="navbar navbar-top top_tabs">
        <div id="navbar" class="navbar-collapse collapse">
            <div class="container">
                <ul class="nav navbar-nav tabnav">
                    <li><a href="{!! url('/admin/modules/config/'.$slug.'/buildb/pages') !!}">Pages</a></li>
                    <li class="active"><a href="{!! url('/admin/modules/config/'.$slug.'/buildb/menus') !!}">Menus</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-container">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                        <div class="list-group">
                            <a href="#" class="list-group-item active text-center">
                                <h4 class="glyphicon glyphicon-plane"></h4><br/>{!! $slug  !!} Parents
                            </a>
                            <a href="#" class="list-group-item text-center">
                                <h4 class="glyphicon glyphicon-road"></h4><br/>{!! $slug  !!} Child back gears
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                        <!-- flight section -->
                        <div class="bhoechie-tab-content active">
                            <center>
                                <div class="">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="sidebar-nav">
                                                <div class="navbar navbar-default" role="navigation">
                                                    <div class="navbar-header">
                                                        <button type="button" class="navbar-toggle"
                                                                data-toggle="collapse"
                                                                data-target=".sidebar-navbar-collapse">
                                                            <span class="sr-only">Toggle navigation</span>
                                                            <span class="icon-bar"></span>
                                                            <span class="icon-bar"></span>
                                                            <span class="icon-bar"></span>
                                                        </button>
                                                        <span class="visible-xs navbar-brand">Sidebar menu</span>
                                                    </div>
                                                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                                                        <ul class="nav navbar-nav">
                                                            {{--@inject('menu','App\Modules\General\Menu')--}}

                                                            @foreach($pages as $key=>$item)
                                                                <li class="page_menu_items"
                                                                    data-href="{!! $item['url'] !!}"><a
                                                                            href="#">{!! $item['title'] !!}</a></li>

                                                            @endforeach
                                                        </ul>
                                                    </div><!--/.nav-collapse -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </center>
                        </div>
                        <!-- train section -->
                        <div class="bhoechie-tab-content">
                            <center>
                                <h1 class="glyphicon glyphicon-road" style="font-size:12em;color:#55518a"></h1>
                                <h2 style="margin-top: 0;color:#55518a">Cooming Soon</h2>
                                <h3 style="margin-top: 0;color:#55518a">Traing Solve Relations</h3>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="childs_items">
        </div>


    </div>
    </div>
    </div>
@stop
@push('css')
{!! HTML::style('resources/assets/css/admin_pages.css') !!}
<style>
    /* make sidebar nav vertical */
    @media (min-width: 768px) {
        .sidebar-nav .navbar .navbar-collapse {
            padding: 0;
            max-height: none;
        }

        .sidebar-nav .navbar ul {
            float: none;
            display: block;
        }

        .sidebar-nav .navbar li {
            float: none;
            display: block;
        }

        .sidebar-nav .navbar li a {
            padding-top: 12px;
            padding-bottom: 12px;
        }
    }

    /*  bhoechie tab */
    div.bhoechie-tab-container {
        z-index: 10;
        background-color: #ffffff;
        padding: 0 !important;
        border-radius: 4px;
        -moz-border-radius: 4px;
        border: 1px solid #ddd;
        margin-top: 20px;
        margin-left: 50px;
        -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
        box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
        -moz-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
        background-clip: padding-box;
        opacity: 0.97;
        filter: alpha(opacity=97);
    }

    div.bhoechie-tab-menu {
        padding-right: 0;
        padding-left: 0;
        padding-bottom: 0;
    }

    div.bhoechie-tab-menu div.list-group {
        margin-bottom: 0;
    }

    div.bhoechie-tab-menu div.list-group > a {
        margin-bottom: 0;
    }

    div.bhoechie-tab-menu div.list-group > a .glyphicon,
    div.bhoechie-tab-menu div.list-group > a .fa {
        color: #5A55A3;
    }

    div.bhoechie-tab-menu div.list-group > a:first-child {
        border-top-right-radius: 0;
        -moz-border-top-right-radius: 0;
    }

    div.bhoechie-tab-menu div.list-group > a:last-child {
        border-bottom-right-radius: 0;
        -moz-border-bottom-right-radius: 0;
    }

    div.bhoechie-tab-menu div.list-group > a.active,
    div.bhoechie-tab-menu div.list-group > a.active .glyphicon,
    div.bhoechie-tab-menu div.list-group > a.active .fa {
        background-color: #5A55A3;
        background-image: #5A55A3;
        color: #ffffff;
    }

    div.bhoechie-tab-menu div.list-group > a.active:after {
        content: '';
        position: absolute;
        left: 100%;
        top: 50%;
        margin-top: -13px;
        border-left: 0;
        border-bottom: 13px solid transparent;
        border-top: 13px solid transparent;
        border-left: 10px solid #5A55A3;
    }

    div.bhoechie-tab-content {
        background-color: #ffffff;
        /* border: 1px solid #eeeeee; */
        padding-left: 20px;
        padding-top: 10px;
    }

    div.bhoechie-tab div.bhoechie-tab-content:not(.active) {
        display: none;
    }
</style>
@endpush
@push('javascript')
<script>
    $(document).ready(function () {
        $("div.bhoechie-tab-menu>div.list-group>a").click(function (e) {
            e.preventDefault();
            $(this).siblings('a.active').removeClass("active");
            $(this).addClass("active");
            var index = $(this).index();
            $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
            $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
        });
        $('.page_menu_items').on('click', function () {
            var data = {'data_url': $(this).attr('data-href')};
            $('#childs_items').empty();
            $.ajax({
                url: '/admin/modules/cofig/menus/parents',
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                },
                data: data,
                success: function (data) {
                    if(!data.error){
                        $('#childs_items').html(data.html);
                    }
                },
            });

        })

    });
</script>

@endpush