@extends('layouts.admin')
@section('content')

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 right">
        <article>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <div id="styles" class="panel_bd_styles">
                    {!! hierarchyAdminPagesListWithModuleNameTest($pageGrouped,$module) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 buttons">
                <div class="pull-right">
                    <button class="save_btn"><i class="fa fa-check" aria-hidden="true"></i>Save</button>
                </div>
            </div>
            {!! Form::model($page) !!}
            <div class="col-xs-12 col-sm-12 col-md-9  col-lg-9 col-xl-9 create">

                <div class="published_1">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 left_sd verticalcontainer">

                            <div class="vertical-text">
                                <span><i class="fa fa-check-circle icon_pbl" aria-hidden="true"></i>Published</span>
                            </div>

                            <div class="row left_part_publ">
                                <div>
                                    <div class="row rows">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 row_inputs">
                                            <i class="fa fa-file-text" aria-hidden="true"></i><span class="labls">Page Name</span>
                                            {!! Form::text('title',null,['class' => 'page_name']) !!}
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 row_inputs">
                                            <i class="fa fa-file-text" aria-hidden="true"></i><span class="labls">Page URL</span>
                                            <div class="page_address page_labels">{!! url($page->url) !!}</div>
                                        </div>
                                    </div>
                                    <div class="row rows">
                                    </div>
                                    <div class="row rows">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 row_inputs">
                                            <i class="fa fa-file-o" aria-hidden="true"></i><span class="labls">Children Pages</span>
                                            {!! Form::select('child_status',Sahakavatar\Modules\Models\Models\AdminPages::$child_statuses,null,[]) !!}
                                        </div>
                                    </div>
                                    <div class="row rows">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 row_inputs ">
                                            <i class="fa fa-file-o" aria-hidden="true"></i><span class="labls">Allow ole to page</span>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 row_inputs tagitinout">
                                            <input name="tags" class="hide tagitext" data-allwotag="admin,user"
                                                   value="">
                                            <ul id="tagits" class="tagInputList" data-allwotag="admin,user"
                                                class="m-b-0 tagit ui-widget ui-widget-content ui-corner-all">
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row rows">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 row_inputs ">
                                            <i class="fa fa-file-o" aria-hidden="true"></i><span class="labls">redirect to</span>
                                            <input type="text" name="redirectto" id="redirectto" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 right_part_publ">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 author_name_div">
                                    <div class="name_btn_div"><span class="author_name labls">Author Name</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 user_photo">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    {{--<i class="fa fa-user" aria-hidden="true"></i>--}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 design_panel">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row panel_head">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 checkbox_ttl">
                                <h4 class="title_h">
                                    <img src="{!!  url('\resources\assets\images\brash.png') !!}" alt="image">
                                    Page Design
                                </h4>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 body_layout">
                                {{--<label class="bd_layout"><span class="labls">Body Layout</span></label>--}}

                                {{--<button class="refresh_button"><span class="labls">Layout 001</span><i class="fa fa-refresh" aria-hidden="true"></i></button>--}}
                                <a target="_blank"
                                   href="{!! url('/admin/modules/config/page-preview/'.$page->id.'?pl='.$page->layout_id) !!}"
                                   class="apply apply_contents">Apply Contents</a>
                                <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
                            </div>

                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7">
                                <img src="{!!  url('\resources\assets\images\create-pages.png') !!}" alt="image"
                                     class="header_image">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
                                <div class="block">
                                    <h5>Leodis Events</h5>
                                    <h3>Forum no - 4</h3>
                                    <h5>25.02.15</h5>
                                    <h2>Lambert's yard</h2>
                                    <p class="text_par">
                                        It is a long established fact that a reader will be distracted by the readable
                                        content of a page when looking at its layout.
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    </p>
                                    <h3><i class="fa fa-long-arrow-right" aria-hidden="true"></i></h3>
                                    <p>
                                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    </p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </article>
    </div>
@stop
{{--@include('tools::common_inc')--}}
@section('CSS')
    {!! HTML::style('css/create_pages.css') !!}
    {!! HTML::style('css/menu.css?v=0.16') !!}
    {!! HTML::style('css/tool-css.css?v=0.23') !!}
    {!! HTML::style('css/page.css?v=0.15') !!}
    {!! HTML::style('css/admin_pages.css') !!}
    {!! HTML::style('js/tag-it/css/jquery.tagit.css') !!}
    <style>
        .page_labels {
            overflow: hidden;
            text-overflow: ellipsis;
            margin: 10px 0 2px 15px;
            background: #e8e7e7;
            padding: 4px 13px;
            border: 1px solid #d6d2d2;
            font-size: 15px;
        }
    </style>
@stop

@section('JS')
    {!! HTML::script('js/create_pages.js') !!}
    {!! HTML::script("/resources/assets/js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script('js/admin_pages.js') !!}
    {!! HTML::script('js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
    {!! HTML::script('js/bootbox/js/bootbox.min.js') !!}
    {!! HTML::script('js/icon-plugin.js?v=0.4') !!}
    {!! HTML::script('js/tag-it/js/tag-it.js') !!}
    <script>

        $(document).ready(function () {

            if ($('#tagits').length > 0) {
                var getExt = $('#tagits').data('allwotag').split(',')

                $('#tagits').tagit({
                    availableTags: getExt,
                    // This will make Tag-it submit a single form value, as a comma-delimited field.
                    autocomplete: {delay: 0, minLength: 0},
                    singleField: true,
                    singleFieldNode: $('.tagitext'),
                    beforeTagAdded: function (event, ui) {
                        if (!ui.duringInitialization) {
                            var exis = getExt.indexOf(ui.tagLabel);
                            if (exis < 0) {
                                $('.tagit-new input').val('');
                                //alert('PLease add allow at tag')
                                return false;
                            }
                        }

                    }
                })
            }
            fixbar()

            function fixbar() {
                var targetselector = $('.vertical-text');
                if (targetselector.length > 0) {
                    var getwith = targetselector.width()
                    var left = 0 - getwith / 2 - 15;
                    targetselector.css({'left': left, 'top': getwith / 2})
                }
            }

            var id;
            $("body").on('click', '[data-pagecolid]', function () {
                id = $(this).data('pagecolid');
                $.ajax({
                    url: '/admin/modules/gears/admin-pages-layout',
                    data: {id: id},
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (!data.error) {
                            $('.page_layout').val(data.value);
                            $('.page_name').val(data.page_name);
                            $('.page_address').html(data.page_url);
                            $('.page-date').html(data.page_date);
                            //apply content
                            var applyC = $(".apply_contents").attr('href');
                            var res = applyC.split('/');

                            res[res.length - 1] = data.page_id + "?pl=" + data.value;
                            res = res.join('/');

                            $(".apply_contents").attr('href', res);
                        }
                    },

                });
            });
            $("body").on('click', '.save_btn', function () {
                $.ajax({
                    url: '/admin/backend/build/admin-pages/change-layout',
                    data: {id: id, layout_id: $('.page_layout').val()},
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (!data.error) {

                        }
                    },

                });
            });

            $("body").on('change', '.page_layout', function () {
                var layoutID = $(this).val();
                var applyC = $(".apply_contents").attr('href');
                var res = applyC.split('/');
                var last = res[res.length - 1];

                var page = last.substring(-1, last.indexOf('?'));

                res[res.length - 1] = page + "?pl=" + layoutID;
                res = res.join('/');

                $(".apply_contents").attr('href', res);
            });

            $("body").on('click', '.add-new-adminpage', function () {
                $('#adminpage').modal();
            });

            $("body").on('click', '.module-info', function () {
                var id = $(this).attr('data-module');
                var item = $(this).find("i");
                $.ajax({
                    url: '/admin/backend/build/admin-pages/module-data',
                    data: {id: id},
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('.module-info-panel').html('');
                        item.removeClass('fa-info-circle');
                        item.addClass('fa-refresh');
                        item.addClass('fa-spin');
                    },
                    success: function (data) {
                        item.removeClass('fa-refresh');
                        item.removeClass('fa-spin');
                        item.addClass('fa-info-circle');
                        if (!data.error) {
                            $('.module-info-panel').html(data.html);
                        }
                    },
                    type: 'POST'
                });
            });

            $("body").on('click', '.view-url', function () {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/admin/backend/build/admin-pages/pages-data',
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('.module-info-panel').html('');
                    },
                    success: function (data) {
                        if (!data.error) {
                            $('.module-info-panel').html(data.html);
                        }
                    },
                    type: 'POST'
                });
            });
        });
    </script>
@stop