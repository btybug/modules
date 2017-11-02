@extends('btybug::layouts.mTabs',['index'=>'developers_structure'])
@section('tab')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 up">
            <button class="add-new-adminpage btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i>Create New
            </button>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 adminpage_left">
            <div role="tabpanel" class="m-t-10" id="admin_pages">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-t-10 panel_head">
                        {!! hierarchyAdminPagesListWithModuleName($pageGrouped) !!}
                    </div>
                </div>
            </div>
            {!! \Eventy::filter('admin_pages.widgets') !!}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 adminpage_right">
            <div class="module-info-panel"></div>
            {!! \Eventy::filter('admin_pages.widgets',2) !!}
        </div>
    </div>


    <div class="modal fade" id="adminpage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Create new </h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url'=>'/admin/modules/pages/create','class' =>'form-horizontal']) !!}
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Page title</label>
                        <div class="col-md-4">
                            {!! Form::text('title',null,['class' => 'form-control input-md','required' => true ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Page Slug</label>
                        <div class="col-md-4">
                            {!! Form::text('slug',null,['class' => 'form-control input-md','required' => true]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Page URL</label>
                        <div class="col-md-4">
                            {!! Form::text('url',null,['class' => 'form-control input-md','required' => true]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Page Layout</label>
                        <div class="col-md-4">
                            {!! Form::select('layout_id',['0' => 'select layout'],null,['class' => 'form-control input-md']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Module</label>
                        <div class="col-md-4">
                            {!! Form::select('module_id',['0' => 'select layout'] + $modulesList,null,['class' => 'form-control input-md']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Parent Page</label>
                        <div class="col-md-4">
                            {!! Form::select('parent_id',['0' => 'select parent'] + $pages,null,['class' => 'form-control input-md']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput"></label>
                        <div class="col-md-4">
                            {!! Form::submit('Create',['class' => 'btn btn-success']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!} </div>
            </div>
        </div>
    </div>

@stop
{{--@include('tools::common_inc')--}}

@push('css')
    {!! HTML::style('css/page.css?v=0.13') !!}
    {!! HTML::style('css/admin_pages.css') !!}
@endpush
@push('javascript')
    {!! HTML::script('js/admin_pages.js') !!}
    <script>
        $(document).ready(function () {
            $("body").on('click', '.add-new-adminpage', function () {
                $('#adminpage').modal();
            });

            $("body").on('click', '.module-info', function () {
                var id = $(this).attr('data-module');
                var item = $(this).find("i");
                $.ajax({
                    url: '/admin/modules/pages/module-data',
                    data: {
                        id: id,
                        _token: $('#token').val()
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
                    url: '/admin/modules/pages/pages-data',
                    data: {
                        id: id,
                        _token: $('#token').val()
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
@endpush 