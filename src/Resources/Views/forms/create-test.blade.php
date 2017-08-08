@extends('layouts.admin')
@section('content')
    @inject('dbhelper', 'Sahakavatar\Cms\Helpers\helpers')
    @include('resources::assests.magicModal')
    <div class="site_wrap_23">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Form name</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" class="form-control form_name" placeholder="Form name">
                        </div>
                        <button  type="button" class="btn btn-default setting_button"><i class="fa fa-cog" aria-hidden="true"></i>Setting</button>
                        <button class="btn btn-default edit_button"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                    </form>

                    <form class="nav navbar-nav navbar-right">
                        <button type="button" class="btn btn-default first_button"><i class="fa fa-trash-o" aria-hidden="true"></i>Discard</button>
                        <button type="button" class="btn btn-default second_button"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="bottom_div">
           <div class="for_margin forwidth">
               <div class="col-xs-12 col-sm-12 col-md-3 left_section">
               <div class="for_dropdown_and_fields">
                   <form action="" method="post">
                       <p>
                           <select>
                               <option value="selecttable" selected>Select table</option>
                               <option value="general">General</option>
                               <option value="user">Users</option>
                           </select>
                       </p>

                   </form>
               <div>
                   <ul class="fields">
                       <li><a href="#">Link</a></li>
                       <li><a href="#">Link</a></li>
                       <li><a href="#">Link</a></li>
                       <li><a href="#">Link</a></li>
                       <li><a href="#">Link</a></li>
                   </ul>
               </div>
           </div>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-9 right_section" >
                <div class="forwidth">
                    <div class="radio_bt_div">
                        <input type="radio" name="column" value="columns_1" class="radio_bt" id="radiobt_2" checked="checked"><span class="choose_cols">Columns - 1</span>
                        <input type="radio" name="column" value="columns_2" class="radio_bt"  id="radiobt_1"><span class="choose_cols">Columns - 2</span>
{{--                        <div class="style_options">{!! BBbutton('styles','containerstyle_1','Select style',['class'=>'form-control input-md','data-type'=>'container']) !!}</div>--}}
                        <div class="style_options_for_left_side">{!! BBbutton('styles','containerstyle_2','Column - 1 Style',['class'=>'form-control input-md','data-type'=>'container']) !!}</div>
                        <div class="style_options_for_right_side">{!! BBbutton('styles','containerstyle_3','Column - 2 Style',['class'=>'form-control input-md','data-type'=>'container']) !!}</div>

                    </div>

                    {{--<div class="div_for_cols placholder-boxes" data-style-old="placholder-boxes" data-bbplace="containerstyle_1">--}}
                    <div class="div_for_cols">
                        <div class="left_part" data-style-old="left_part" data-bbplace="containerstyle_2" id="left_side">

                        </div>
                        <div class="right_part" data-style-old="right_part" data-bbplace="containerstyle_3" id="right_side"></div>
                    </div>

                </div>
            </div>
        </div>

        </div>
        <div class="div_modal" style="display: none">
            <div class="for_close_icon"><a href="#"> <i class="fa fa-times" aria-hidden="true"></i></a></div>
            <ul class="nav nav-tabs col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
                <li class="active"><a data-toggle="tab" href="#home"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br/>Menu 1</a></li>
                <li><a data-toggle="tab" href="#menu1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br/>Menu 2</a></li>
                <li><a data-toggle="tab" href="#menu2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br/>Menu 3</a></li>
                <li><a data-toggle="tab" href="#menu3"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br/>Menu 4</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <h3>Menu 1</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <h3>Menu 2</h3>
                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <h3>Menu 3</h3>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                </div>
                <div id="menu3" class="tab-pane fade">
                    <h3>Menu 4</h3>
                    <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                </div>
            </div>
        </div>
            </div>

        </div>
    </div>
    @section('CSS')
    {!! HTML::style('js/bootstrap-select/css/bootstrap-select.min.css') !!}
    {!! HTML::style('js/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') !!}
    {!! HTML::style('js/animate/css/animate.css') !!}
    {!! HTML::style('css/form-builder.css?v=4.97') !!}
    {!! HTML::style('css/fields-style.css') !!}

    <style data-css="savedcss">


        #left_side{
            width: 100%;
        }

        #right_side{
            width: 0;
        }
         /*modal*/
         .site_wrap_23 .nav-tabs li{
             float: none;
             text-align: center;
         }
         .site_wrap_23 .nav-tabs {
              border:none;
         }
         .site_wrap_23 .nav-tabs  a{
             color: #5c789c;
             font-size: 16px;
             font-weight: bold;
             padding: 17px;
         }
         .site_wrap_23 .nav-tabs  li.active a{
             background-color: #ad4d5e;
             color: #ffffff;
         }
         .site_wrap_23 .nav-tabs  a:hover{
             background-color: #e3e6ec;
             color: #5c789c;
         }

        .site_wrap_23 .div_modal{
            position: absolute;
            background-color: #ffffff;
            width: 100%;
            height: 1000px;
            top: 83px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            padding: 18px;
        }

        .site_wrap_23 .div_modal .for_close_icon{
            position: absolute;
            right: 19px;
            top: 10px;
        }
        .site_wrap_23 .div_modal .for_close_icon i{
            font-size: 26px;
            color: #d6d9e0;
        }
        .site_wrap_23 button:focus, .site_wrap_23 button:hover, .site_wrap_23 input:hover, .site_wrap_23 input:focus, .site_wrap_23 .navbar-left button:focus, .site_wrap_23 .navbar-right button:focus {
            outline: none;
        }
        .site_wrap_23{
            position: relative;
            background-color: #2c2c2c;

        }
        .site_wrap_23 .navbar-header, .site_wrap_23 .navbar-collapse {
            padding: 12px 12px 7px 12px;
        }
        .site_wrap_23 .navbar.navbar-default, .site_wrap_23 .navbar-default .navbar-brand{
            background-color: #2c2c2c;
        }
        .site_wrap_23 .navbar{
            border: none;
             margin-bottom:0;
        }
        .site_wrap_23 .navbar-right{
            padding: 9px;
        }
        .site_wrap_23 .navbar-right button{
            margin-left: 12px;
            min-width:100px;
            border-color: transparent;;
            font-weight: bold;
            color:#ffffff;

        }
        .site_wrap_23 .navbar-left button {
            min-width:100px;
            border-color: transparent;
            font-weight: bold;
        }
        .site_wrap_23 .navbar-left .setting_button{
            background-color: #767474;
            color:#ffffff;
        }
        .site_wrap_23 button:hover{
            opacity: 0.8;
        }
        .site_wrap_23 .for_dropdown_and_fields ul li:hover, .site_wrap_23 .left_section select:hover{
            opacity: 0.9;
        }
        .site_wrap_23 .navbar-left .edit_button {
            background-color: #ffffff;
            color: #5c789c;
        }
        .site_wrap_23 .navbar-right .first_button{
            background-color: #767474;
        }
        .site_wrap_23 .navbar-right .second_button{
            background-color: #ad4d5e;
        }
        .site_wrap_23 .navbar-left button{
            margin-left: 12px;
        }

        .site_wrap_23 .form_name{
            width: 300px;
        }

        .site_wrap_23 .left_section form{
            color: #ffffff;
        }
        .site_wrap_23 .left_section form:focus{
            outline: none;
        }
        .site_wrap_23 .left_section select{
            background-color: #5c789c;
            border-color:transparent;
            width: 100%;
            padding: 12px;
            font-weight: bold;
            position: relative;
            font-size: 16px;
            border-radius: 5px;
        }

        .site_wrap_23  select:active, .site_wrap_23 select:hover {
            outline: none
        }
        .site_wrap_23 .left_section select:focus > option:checked, .site_wrap_23 .left_section select:focus > option:hover {
            color: #ffffff;
        }
        .site_wrap_23 .left_section select:focus > option{
            background: #d6d9e0;
            padding: 10px !important;
            color: #000000;
            font-size: 16px;
        }
        .site_wrap_23 .right_section .choose_cols{
            color: #ffffff;
            font-weight: bold;
            font-size: 15px;
        }
        .site_wrap_23 .right_section .radio_bt_div{
            padding: 7px 12px 7px 0;
            background-color: #5c789c;
            border-radius: 5px;
            display: inline-block;
            width: 100%;
        }
        .site_wrap_23 .right_section .radio_bt{
            margin: 0 6px 0 21px;
        }
        .site_wrap_23 .right_section{
            padding-left: 0!important;
            padding-right: 0!important;
        }
       .site_wrap_23 .forwidth{
           width: 100%;
       }
         .left_part {
            background-color: #d6d9e0;
            min-height: 700px;
        }
         .right_part{
            background-color: #e3e6ec;
            min-height: 700px;
            transition: right 0.4s;
            transition: left 0.4s;
        }
        .site_wrap_23 .div_for_cols{
            width: 100%;
            position: absolute;
            top:63px;
        }
        .site_wrap_23 .for_margin{
            margin-top: 38px;
        }
        .site_wrap_23 .for_dropdown_and_fields{
            width: 80%;
        }
        .site_wrap_23 .fields{
            margin-top: 15px;
        }
        .site_wrap_23 .fields li{
            background-color: #ad4d5e;
            padding:12px;
            border: 1px solid #ffffff;
            border-radius: 5px;
            list-style-type: none;
        }
        .site_wrap_23 .fields li:hover{
            cursor: pointer;
        }
        .site_wrap_23 .fields li a{
            color: #ffffff;
            font-weight: bold;
        }
        .site_wrap_23 .fields li a:hover{
            text-decoration: none;
        }
        /*.site_wrap_23 .style_options{*/
            /*display: inline-block;*/
            /*margin-left: 50px;*/
        /*}*/
         .site_wrap_23 .style_options_for_left_side, .site_wrap_23 .style_options_for_right_side{
             display: inline-block;
             margin-left: 50px;

         }
        .site_wrap_23 .style_options_for_left_side button, .site_wrap_23 .style_options_for_right_side button{
            background-color: #ffffff;
            color: #5c789c;
            border: none;
            padding: 6px 26px;
            font-weight: bold;
        }
        .site_wrap_23 .navbar-left button i, .site_wrap_23 .navbar-right button i{
            margin-right: 5px;
        }



    </style>
    @stop

@section('JS')
    {!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
    <script>

        $(document).ready(function() {
            $('input:radio[name=column]').change(function() {
                var left_content = $( "#left_side" ).html();

                if (this.value == 'columns_2') {
                    $("#left_side").css({ opacity:1, left: 0, width: '50%', position:'absolute'});
                    $("#right_side").css({ left: '50%', width: '50%', position:'absolute'});
                }
                else if (this.value == 'columns_1') {
                    $("#right_side").css({ left: 0, width: '100%', position:'absolute'});
                    $("#left_side").css({ opacity:0, width: 0, position:'absolute'});
                    $( "#right_side" ).append( left_content );
                }
            });


            $(".setting_button").click(function(){
                $(".div_modal").slideToggle( "slow");
            });
            $(".for_close_icon").click(function(){
                $(".div_modal").slideToggle( "slow");
            });
            $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
                $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
            });


        });

    </script>
@stop
@stop
