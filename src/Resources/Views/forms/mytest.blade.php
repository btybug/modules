@extends('layouts.admin')
@section('content')

    <div class="main_container">
        <div class="for-button">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-fullscreen">
                Open the modal
            </button>

            <div class="modal modal-fullscreen fade" id="modal-fullscreen" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span
                                        aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <img src="{!! url('Btybug\Modules\Models\Resources\assets\img\form-lyout-popup.png')!!}"
                                 alt="image">
                            <h4 class="modal-title" id="myModalLabel">Form Layout</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row general_div">
                                {{--left part--}}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 left_side">
                                    <p>Select layout</p>
                                    <div class="layout_01 layouts active_layout">
                                        <div class="top_part">
                                            <div class="main_div">
                                                <div>
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                        <div class="bottom_part"><span>Layout 0001</span></div>
                                    </div>

                                    <div class="layout_02 layouts">
                                        <div class="top_part row">
                                            <div class="main_div">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 ">
                                                    <div class="left">
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                    <div class="right">
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bottom_part"><span>Layout 0002</span></div>
                                    </div>
                                </div>
                                {{--right part--}}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 right_side">
                                    <p>Select variation</p>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="layout_01 layouts">
                                                <div class="top_part">
                                                    <div class="main_div">
                                                        <div>
                                                            <div></div>
                                                            <div></div>
                                                            <div></div>
                                                        </div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                                <div class="bottom_part"><span>Layout 0001</span><i class="fa fa-pencil"
                                                                                                    aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="layout_03 layouts">
                                                <div class="top_part">
                                                    <div class="main_div">
                                                        <div>
                                                            <div></div>
                                                            <div></div>
                                                            <div></div>
                                                        </div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                                <div class="bottom_part"><span>Layout 0001</span><i class="fa fa-pencil"
                                                                                                    aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="layout_04 layouts">
                                                <div class="top_part">
                                                    <div class="main_div">
                                                        <div>
                                                            <div></div>
                                                            <div></div>
                                                            <div></div>
                                                        </div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                                <div class="bottom_part"><span>Layout 0001</span><i class="fa fa-pencil"
                                                                                                    aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="layout_05 layouts">
                                                <div class="top_part">
                                                    <div class="main_div">
                                                        <div>
                                                            <div></div>
                                                            <div></div>
                                                            <div></div>
                                                        </div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                                <div class="bottom_part"><span>Layout 0001</span><i class="fa fa-pencil"
                                                                                                    aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal fullscreen -->

    </div>


@section('CSS')
    {!! HTML::style('js/bootstrap-select/css/bootstrap-select.min.css') !!}
    {!! HTML::style('js/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') !!}
    {!! HTML::style('js/animate/css/animate.css') !!}
    {!! HTML::style('css/form-builder.css?v=4.97') !!}
    {!! HTML::style('Btybug\Modules\Models\Resources\assets\css\modal_style.css') !!}
@stop

@section('JS')
    {!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
    <script>
        // .modal-backdrop classes
        $(window).resize(function () {
            var scrollTop = $(window).scrollTop();
            var myWidth = $(document).width();
            if (myWidth > 1200) {
                $('body').find('.left_side').css({
                    'height': (scrollTop < 63 ? $(window).height() - (63 - scrollTop) - 10 : $(window).height()),
//                "top": (scrollTop < 182 ? 0 : scrollTop - 182 + 10)
                });
                $('body').find('.right_side').css({
                    'height': (scrollTop < 63 ? $(window).height() - (63 - scrollTop) - 10 : $(window).height()),
//                "top": (scrollTop < 182 ? 0 : scrollTop - 182 + 10)
                });
            }
            else if (myWidth < 1200) {
                $('body').find('.left_side').css({
                    'height': '100%'
//                        (scrollTop < 225 ? $(window).height() - (225 - scrollTop) - 10 : $(window).height() - 20),
                });
                $('body').find('.right_side').css({
                    'height': '100%'
//                        (scrollTop < 225 ? $(window).height() - (225 - scrollTop) - 10 : $(window).height() - 20),
                });
            }
        });
        $(document).ready(function () {
            $(".modal-transparent").on('show.bs.modal', function () {
                setTimeout(function () {
                    $(".modal-backdrop").addClass("modal-backdrop-transparent");
                }, 0);
            });
            $(".modal-transparent").on('hidden.bs.modal', function () {
                $(".modal-backdrop").addClass("modal-backdrop-transparent");
            });

            $(".modal-fullscreen").on('show.bs.modal', function () {
                setTimeout(function () {
                    $(".modal-backdrop").addClass("modal-backdrop-fullscreen");
                }, 0);
            });
            $(".modal-fullscreen").on('hidden.bs.modal', function () {
                $(".modal-backdrop").addClass("modal-backdrop-fullscreen");
            });

            var scrollTop = $(window).scrollTop();
            var myWidth = $(document).width();
            if (myWidth > 1200) {
                $('body').find('.left_side').css({
                    'height': (scrollTop < 63 ? $(window).height() - (63 - scrollTop) - 10 : $(window).height()),
//                "top": (scrollTop < 182 ? 0 : scrollTop - 182 + 10)
                });
                $('body').find('.right_side').css({
                    'height': (scrollTop < 63 ? $(window).height() - (63 - scrollTop) - 10 : $(window).height() ),
//                "top": (scrollTop < 182 ? 0 : scrollTop - 182 + 10)
                });
            }
            else if (myWidth < 1200) {
                $('body').find('.left_side').css({
                    'height': '100%'
//                        (scrollTop < 225 ? $(window).height() - (225 - scrollTop) - 10 : $(window).height() - 20),
                });
                $('body').find('.right_side').css({
                    'height': '100%'
//                        (scrollTop < 225 ? $(window).height() - (225 - scrollTop) - 10 : $(window).height() - 20),
                });
            }
        });


    </script>
@stop

@stop

