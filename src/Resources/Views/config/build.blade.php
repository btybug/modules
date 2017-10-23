@extends('layouts.admin')
@section('content')

    <div class="row all_pages">
        <div class="col-md-12">
            <div class="row">

                <!-- Item template used by JS -->
                <script type="template" id="item-template">
                    <li data-details='[serialized_data]'>
                        <div class="drag-handle">
                            [title]
                            <div class="item-actions">
                                <a href="javascript:;" data-action="addOption">
                                    <i class="fa fa-plus"></i> Add Option
                                </a>
                                <a href="javascript:;" data-action="addChild">
                                    <i class="fa fa-plus"></i> Add Child
                                </a>
                                <a href="/admin/create/front-pages/update/[id]">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="javascript:;" data-action="delete"><i class="fa fa-trash-o"></i> Remove</a>
                                <a href="/preview/[view_url]" target="_blank" class="view-url">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </div>
                        </div>
                        <ol></ol>
                    </li>
                </script>
                <!-- END Item template -->

                <input type="hidden" id="baseUrl" value=""/>
                <div class="col-md-7  p-l-0">
                    <div class="panel panel-default panels accordion_panels">
                        <div class="panel-heading bg-black-darker text-white" role="tab" id="headingLink">
                            <span class="panel_title">All Pages</span>
                            <a role="button" class="panelcollapsed collapsed" data-toggle="collapse"
                               data-parent="#accordion" href="#collapseLink_all_pages" aria-expanded="true"
                               aria-controls="collapseLink_all_pages">
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </a>
                            <ul class="list-inline panel-actions">
                                <li><a href="#" panel-fullscreen="true" role="button" title="Toggle fullscreen"><i
                                                class="glyphicon glyphicon-resize-full"></i></a></li>
                            </ul>
                        </div>
                        <div id="collapseLink_all_pages" class="panel-collapse collapse in" role="tabpanel"
                             aria-labelledby="headingLink">
                            <div class="panel-body panel_body panel_1 show">
                                {{--@if($type == 'custom')--}}
                                <a href="javascript:;" data-action="newPage" class="btn btn-primary add_new_page">
                                    Add New Page
                                </a>
                                {{--@endif--}}
                                {!! hierarchyList($pages, true, $type) !!}
                            </div>
                        </div>
                    </div>

                    <!--Right BAR-->
                    <div class="col-md-5 p-r-0">
                        <div class=" p-r-0 hide" id="page-details">
                            <div class="panel panel-default panels accordion_panels">
                                <div class="panel-heading bg-black-darker text-white" role="tab" id="headingLink">
                                    <span class="panel_title">Page Quick View</span>
                                    <a role="button" class="panelcollapsed collapsed" data-toggle="collapse"
                                       data-parent="#accordion" href="#collapseLink_quick_view" aria-expanded="true"
                                       aria-controls="collapseLink_quick_view">
                                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                    </a>
                                    <ul class="list-inline panel-actions">
                                        <li><a href="#" panel-fullscreen="true" role="button" title="Toggle fullscreen"><i
                                                        class="glyphicon glyphicon-resize-full"></i></a></li>
                                    </ul>
                                </div>
                                <div id="collapseLink_quick_view" class="panel-collapse collapse in" role="tabpanel"
                                     aria-labelledby="headingLink">
                                    <div class="panel-body form-horizontal panel_body panel_1 show">
                                        <ul class="quick-view-list">
                                            <li><strong>Page Title:</strong> <span id="pg-detail-title"></span></li>
                                            <li><strong>Page Url:</strong> <span id="pg-detail-url"></span></li>
                                            <li><strong>Page Status:</strong> <span id="pg-detail-status"></span></li>
                                            <li><strong>Page Visibility:</strong> <span
                                                        id="pg-detail-visibility"></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class=" p-r-0 hide" id="page-layout-options">
                                <div class="panel panel-default panels accordion_panels">
                                    <div class="panel-heading bg-black-darker text-white" role="tab" id="headingLink">
                                        <span class="panel_title">Options</span>
                                        <a role="button" class="panelcollapsed collapsed" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapseLink_options" aria-expanded="true"
                                           aria-controls="collapseLink_options">
                                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                        </a>
                                        <ul class="list-inline panel-actions">
                                            <li><a href="#" panel-fullscreen="true" role="button"
                                                   title="Toggle fullscreen"><i
                                                            class="glyphicon glyphicon-resize-full"></i></a></li>
                                        </ul>
                                    </div>
                                    <div id="collapseLink_options" class="panel-collapse collapse in" role="tabpanel"
                                         aria-labelledby="headingLink">
                                        <div class="panel-body form-horizontal panel_body panel_1 show">
                                            {!! Form::open(array('url' => ['/admin/create/front-pages/addLayoutOption'], 'method' => 'POST','class' => 'form')) !!}
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select class="form-control" name="layout_option">
                                                        <option value="layout_except_body">All child pages will Inherit
                                                            same parent layout except body
                                                        </option>
                                                        <option value="layout_except_body_extra">All child pages will
                                                            Inherit same parent layout except body and extra
                                                        </option>
                                                        <option value="layout_except_sidebar">All child pages will
                                                            Inherit same parent layout except body and side bars
                                                        </option>
                                                        <option vlaue="free">All child pages will be free</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <p class="text-right">
                                                <button type="submit" class="btn btn-success btn-block">Save</button>
                                            </p>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>


                                @if (count($errors) > 0)
                                    <div id="new-child-page">
                                        @else
                                            <div class="hide" id="new-child-page">
                                                @endif

                                                {!! Form::open(array('url' => ['/admin/create/front-pages/addchild'], 'method' => 'POST','class' => 'form')) !!}

                                                <input type="hidden" name="parent_id" value=""/>
                                                <!-- <input type="text" name="parent_id" value="" /> -->
                                                <input type="hidden" name="page_type" value="{{$type}}"/>
                                                <div class="panel panel-default panels accordion_panels">
                                                    <div class="panel-heading bg-black-darker text-white" role="tab"
                                                         id="headingLink">
                                                        <span class="panel_title">Add Page</span>
                                                        <a role="button" class="panelcollapsed collapsed"
                                                           data-toggle="collapse"
                                                           data-parent="#accordion" href="#collapseLink_add_page"
                                                           aria-expanded="true" aria-controls="collapseLink_add_page">
                                                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                                        </a>
                                                        <ul class="list-inline panel-actions">
                                                            <li><a href="#" panel-fullscreen="true" role="button"
                                                                   title="Toggle fullscreen"><i
                                                                            class="glyphicon glyphicon-resize-full"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div id="collapseLink_add_page" class="panel-collapse collapse in"
                                                         role="tabpanel" aria-labelledby="headingLink">
                                                        <div class="panel-body form-horizontal panel_body panel_1 show">
                                                            <!-- Error Message -->
                                                            <div class="message bg-danger hide"></div>

                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    {!! Form::text('title',null,['class'=>'form-control input-md','placeholder'=>'Page Title']) !!}
                                                                </div>
                                                            </div>

                                                            <div class="form-group">

                                                                <div class="col-md-12">
                                                                    <span id="parent-url" data-baseurl="/"></span>
                                                                    {!! Form::text('view_url',null,['class'=>'form-control input-md','placeholder'=>'Page Url']) !!}
                                                                </div>
                                                            </div>

                                                            <div class="form-group">

                                                                <div class="col-md-12">
                                                                    <select class="form-control" name="status">
                                                                        <option value="">Status</option>
                                                                        <option value="draft">Draft</option>
                                                                        <option value="published">Published</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">

                                                                <div class="col-md-12">
                                                                    <select class="form-control" name="visibility">
                                                                        <option value="">Visibility</option>
                                                                        <option value="yes">Yes</option>
                                                                        <option value="no">No</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <p class="text-right">
                                                                <button type="submit" class="btn btn-success btn-block">
                                                                    Save
                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>

                                    </div>
                            </div>
                        </div>
                    </div>
                @stop

                @section('CSS')
                    {!! HTML::style('css/themes-settings.css?v=0.23') !!}
                    {!! HTML::style('css/menu.css?v=0.9') !!}
                    {!! HTML::style('css/page.css?v=0.13') !!}
                    {!! HTML::style('css/admin_pages.css') !!}
                @stop

                <!--JS-->
                    @section('JS')

                        {!! HTML::script('js/bootbox/js/bootbox.min.js') !!}
                        {!! HTML::script('js/jquery.nestable/js/jquery.nestable.js') !!}

                        {!! HTML::script('js/jqueryui/js/jquery-ui.min.js') !!}
                        {!! HTML::script('js/nestedSortable/jquery.mjs.nestedSortable.js') !!}

                        {!! HTML::script('js/page.js?v=0.62') !!}
                        {!! HTML::script('js/admin_pages.js') !!}

                        <script>
                            $(function () {

                                if (localStorage.activetoolspages) {
                                    $('[data-tab-action="tabs"]').find('a[href="' + localStorage.activetoolspages + '"]').click();

                                } else {
                                    $('[data-tab-action="tabs"] li:first-child').find('a').click();
                                }

                                $('[data-tab-action="tabs"] a').click(function () {
                                    localStorage.activetoolspages = $(this).attr('href');
                                    thisname = $(this).data('name')
                                });

                            });
                        </script>

@stop
