@extends('layouts.mTabs',['index'=>'Gears'])
@section('tab')
    <div class="layout_container_11">
        <div role="tabpanel" class="m-t-10" id="main">
            <div class="row">
                <div class="col-md-12 top_div_1">
                    <a class="btn btn-info" href="{!! url('admin/frontend/gears/create-layout') !!}">Create Layout</a>
                </div>
                @foreach($active->layouts() as $key=>$layouts)
                    <div class="col-md-3 layout-box">
                        <div class="col-md-12 m-5 height-200 well">
                            <div class="text-center m-t-40">Title: {!! $layouts->title !!}</div>
                            <div class="for_image">
                            </div>
                            <div class="centered">
                                @if(isset($layouts->active))
                                    <span class="label label-success m-r-10"><i class="fa fa-check"></i> Active</span>
                                @else
                                    <a href="{!! url('/admin/theme-studio/extra-themes/make-active-layout',$key) !!}"
                                       class="label label-info m-r-10 activate-theme" style="cursor: pointer;">Activate</a>
                                    <button class="delete_layout btn label label-danger m-r-10" data-key="{!! $key !!}"
                                            data-title="{!! $layouts->title !!}"><i class="fa fa-trash"></i> Delete
                                    </button>
                                @endif
                                <a class="btn label label-warning m-r-10"
                                   href="{!! url('/admin/frontend/gears/create-layout',$key) !!}"><i
                                            class="fa fa-edit"></i> Edit</a></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('resources::assests.deleteModal',['title'=>'Delete Layout'])
@stop
@section('CSS')
    <style>
        .layout_container_11 .height-200{
            height: 322px !important;
        }
        .layout_container_11 .for_image{
            width: 150px;
            height: 150px;
            background-color: grey;
            border-radius: 50%;
            text-align: center;
            margin: 0 auto;
            background-image: url(http://developers.dev/app/Themes/Themes/assets/icon.jpg);
            background-size: cover;
            margin-top: 25px;
            border: 5px solid white;
        }
        .layout_container_11 .m-5{
            background-color: #fff;
            color: #2D2D2D;
            font-size: 15px;
            border: 2px solid #ddd;
            /*box-shadow: 0 0 7px rgba(0,0,0,0.5);*/
        }
        .layout_container_11 .m-t-40 {
            margin-top: 0 !important;
            font-size: 15px;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
            padding: 0 0 11px 0;
            width: 100%;
            margin: 0 auto;
        }
        .layout_container_11 .centered{
            text-align: center;
            margin-top: 22px;
        }
        .layout_container_11 .m-r-10{
            border: none;
            margin-right:4px !important;
        }
        .layout_container_11 .label {
            border-radius: 2px;
        }
        .layout_container_11 .centered a:focus{
            outline: 0;
        }
        .layout_container_11 .delete_layout{
            border: none;
        }
        .layout_container_11 .centered a,  .layout_container_11 .label-success{
            padding: 7px;
        }
        .layout_container_11 .delete_layout{
            padding: 8px;
        }
        .layout_container_11 .label-success{
            /*background-color: #1ab394;*/
            background-color: #fff;
            border:1px solid #ddd;
            color: #2D2D2D;
        }
        .layout_container_11 .label-success:hover{
            /*background-color: #1ab394;*/
            background-color: #fff;
            border:1px solid #2D2D2D;
            color: #2D2D2D;
        }
        .layout_container_11 .label-danger {
            background-color: #1c84c6;
        }
        .layout_container_11 .label-warning {
            background-color: #1ab394;
        }
        .label-warning[href]:focus, .label-warning[href]:hover, .layout_container_11 .top_div_1 a:hover{
            opacity: 0.8;
            background-color: #1ab394;
        }
        .layout_container_11 .top_div_1{
            margin: 23px 0 53px 0;
        }
        .layout_container_11 .top_div_1 a{
            font-weight: bold;
            margin-left: 2px;
            padding: 11px;
            background-color: #3ab79e;
            border-color: #3ab79e;
        }
        /*.layout_container_11 .label, .layout_container_11 .btn {*/
        /*display: inline;*/
        /*font-size: 75%;*/
        /*font-weight: 700;*/
        /*line-height: 1;*/
        /*color: #fff;*/
        /*text-align: center;*/
        /*white-space: nowrap;*/
        /*vertical-align: baseline;*/
        /*border-radius: .25em;*/
        /*width: 67px;*/
        /*height: 24px;*/
        /*}*/

    </style>
@stop
@section('JS')
    {!! HTML::script("/resources/assets/js/UiElements/bb_styles.js?v.5") !!}
    <script>
        $(document).ready(function () {
            $('.delete_layout').on('click', function () {
                var key = $(this).attr('data-key');
                $('.delete_modal .modal-footer a').attr('href', '{!! url('/admin/frontend/gears/layout-delete') !!}' + '/' + key);
                $('.modal-body').html("<p>atre you sure you want to delete layout <b>" + $(this).attr('data-title') + '<b> ?');
                $('.delete_modal').modal();
            });
        });
    </script>
@stop
