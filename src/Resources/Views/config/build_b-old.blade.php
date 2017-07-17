@extends('layouts.admin')
@section('content')
    <nav class="navbar navbar-top top_tabs">
        <div id="navbar" class="navbar-collapse collapse">
            <div class="container">
                <ul class="nav navbar-nav tabnav">
                    <li class="active"><a href="{!! url('/admin/modules/config/'.$slug.'/buildb/pages') !!}">Pages</a></li>
                    <li><a href="{!! url('/admin/modules/config/'.$slug.'/buildb/menus') !!}">Menus</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 up">
            <button class="add-new-adminpage btn btn-primary pull-left"><i class="fa fa-plus" aria-hidden="true"></i>Create New</button>
        </div>

        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 adminpage_left">
            <div role="tabpanel" class="m-t-10" id="admin_pages">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-t-10 panel_head">
                        {!! hierarchyAdminPagesListWithModuleName($pageGrouped,$module) !!}
                    </div>
                </div>
            </div>
            {!! \Eventy::filter('admin_pages.widgets') !!}
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 adminpage_right">
            <div class="panel panel-darkblack panels accordion_panels">
                {!! Form::open(['url'=>'/admin/backend/build/admin-pages/general','class' => 'form-horizontal']) !!}
                <div class="panel-heading bg-black-darker text-white accordion" role="tab" id="headingLink">
                    General Settings
                    <a role="button" class="panelcollapsed collapsed" data-toggle="collapse"
                       data-parent="#accordion" href="#collapseLink_general" aria-expanded="true" aria-controls="collapseLink_general">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </a>
                    <ul class="list-inline panel-actions">
                        <li><a href="#" panel-fullscreen="true" role="button" title="Toggle fullscreen"><i class="glyphicon glyphicon-resize-full"></i></a></li>
                    </ul>
                </div>
                <div id="collapseLink_general" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingLink">
                <div class="panel-body panel_body panel_1 show">
                    <p class="change_layout"><strong> Change all Pages Layout :</strong> {!! Form::select('layout_id',['' => 'Select Layout'] + $layouts,null,['class' => 'form-control input-md']) !!}</p>
                    <p class="save_changes"> {!! Form::submit('save',['class' => 'btn btn-info']) !!}</p>
                </div>
                {!! Form::close() !!}
            </div>
                </div>
            <div class="module-info-panel"></div>
        </div>
    </div>


    <div class="modal fade" id="adminpage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Create new </h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url'=>'/admin/backend/build/admin-pages/create','class' =>'form-horizontal']) !!}
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
                                {!! Form::select('layout_id',['' => 'Select Layout'] + $layouts,null,['class' => 'form-control input-md']) !!}
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
    </div>

@stop
{{--@include('tools::common_inc')--}}

@push('css')
{!! HTML::style('resources/assets/css/page.css?v=0.13') !!}
{!! HTML::style('/resources/assets/css/menu.css?v=0.16') !!}
{!! HTML::style('resources/assets/css/admin_pages.css') !!}
{!! HTML::style('/resources/assets/css/tool-css.css?v=0.23') !!}
@endpush
@push('javascript')
{!! HTML::script("/resources/assets/js/UiElements/bb_styles.js?v.5") !!}
{!! HTML::script('resources/assets/js/admin_pages.js') !!}
{!! HTML::script('/resources/assets/js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
{!! HTML::script('/resources/assets/js/bootbox/js/bootbox.min.js') !!}
{!! HTML::script('/resources/assets/js/icon-plugin.js?v=0.4') !!}
<script>
    $(document).ready(function(){
       $("body").on('click','.add-new-adminpage',function(){
            $('#adminpage').modal();
       });

       $("body").on('click','.module-info',function(){
           var id = $(this).attr('data-module');
            var item = $(this).find("i");
           $.ajax({
               url: '/admin/backend/build/admin-pages/module-data',
               data: { id: id},
               headers: {
                   'X-CSRF-TOKEN':$("input[name='_token']").val()
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

        $("body").on('click','.view-url',function(){
           var id = $(this).attr('data-id');
           $.ajax({
               url: '/admin/backend/build/admin-pages/pages-data',
               data: {
                   id: id
               },
               headers: {
                   'X-CSRF-TOKEN':$("input[name='_token']").val()
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