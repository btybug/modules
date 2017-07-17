@extends('layouts.admin')
@section('content')
    {!! HTML::style('app/Modules/Modules/Resources/assets/css/new-store.css') !!}
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cms_module_list">
            <h3 class="menuText f-s-17"><span class="module_icon_main"></span> <span class="module_icon_main_text"> Modules</span>
            </h3>
            <hr>
            <ul class="list-unstyled menuList" id="components-list">
                @if(count($modules))
                    @foreach($modules as $m)
                        <li class=" @if($m->slug == $module->slug) active @endif">
                            <a href="{!! url('admin/modules/extra/'. $m->slug) !!}">
                                <span class="module_icon"></span>
                                {!! $m->name or $m->namespace !!}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">

            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <button class="btn btn-sm  pull-right m-b-10 upload_module" type="button"
                                    data-toggle="modal" data-target="#uploadfile">
                                <span class="module_upload_icon"></span> <span class="upload_module_text">Upload</span>
                            </button>

                            <button class="btn btn-sm  pull-right m-b-10" type="button"
                                    data-toggle="modal">
                                <i class="fa fa-plus"></i> <a href="{!! url('admin/modules/generate') !!}" class="upload_module_text">Create New</a>
                            </button>
                        </div>
                    </div>
                    @if($module)
                    <div class="row module_detail">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <img src="{!! url('public/img/no_image.jpg')!!}" class="img-responsive"/>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="module-title">{!! $module->name or $module->namespace !!}</div>
                            <div class="module-desc">
                                {!! $module->description or "No Description" !!}
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 pull-right text-right m-t-20">
                            @if(isset($module->have_setting) && $module->have_setting == 1)
                                <a href="{!! url('admin/plugins/setting',$module->slug) !!}"
                                   class="btn  btn-sm  m-b-5 p-l-20 p-r-20 width-150 text-left settings"><i
                                            class="fa fa-pencil f-s-14 m-r-10"></i> Settings</a>
                            @endif
                            @if($module->enabled)
                                <a href="#" namespace="{!! $module->namespace !!}" data-action="disable"
                                   class="btn  btn-sm  m-b-5 p-l-20 p-r-20 width-150 text-left enb-disb deactivate"><i
                                            class="fa fa-power-off f-s-14 m-r-10"></i> Deactivate</a>
                            @else
                                <a href="#" namespace="{!! $module->namespace !!}" data-action="enable" style="background: #7fff00;color: #000000"
                                   class="btn  btn-sm  m-b-5 p-l-20 p-r-20 width-150 text-left  enb-disb"><i
                                            class="fa fa-plug f-s-14 m-r-10"></i>Activate</a>
                            @endif
                            <a href="#" namespace="{!! $module->namespace !!}"
                               class="btn  btn-sm  m-b-5 p-l-20 p-r-20 width-150 text-left delete del-module"><i
                                        class="fa fa-trash-o f-s-14 m-r-10"></i> Delete</a>


                        </div>
                    </div>

                    <div class="row module_detail_link">
                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 m-t-10 m-b-10">
                            <a href="{!! @$module->author_site!!}"
                               class="module_detail_author_link">{!! @$module->author_site !!}</a>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 module_author_detail m-t-10 m-b-10">
                            <div class="pull-left">
                                <i class="fa fa-bars f-s-15" aria-hidden="true"></i>
                                Version {!! $module->version !!}
                            </div>
                            <div class="pull-right">
                                <i class="fa fa-user f-s-15" aria-hidden="true"></i>
                                {!! $module->author !!}, 20/07/16
                                {{--{!! BBgetDateFormat() !!}--}}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
            @if($module)
                <div class="row">
                <div class="m-t-15 col-xs-12">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#installed_add_ons"
                                                                  aria-controls="installed_add_ons" role="tab"
                                                                  data-toggle="tab">Installed Add-Ons</a></li>
                        <li role="presentation"><a href="#related_add_ons" aria-controls="related_add_ons" role="tab"
                                                   data-toggle="tab">Related Add-Ons</a></li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content m-t-15">
                        <div role="tabpanel" class="tab-pane active" id="installed_add_ons">
                            @if(!empty($addons))
                                <div class="col-xs-12">
                                    @foreach($addons as $addon)
                                        <div class="col-xs-12 addon-item">
                                            <div class="col-xs-8">
                                <span class="addon-name">
                                    {!! $addon->name !!}
                                </span>
                                            </div>
                                            <div class="col-xs-4 pull-right">
                                                @if( $addon->have_setting==1)
                                                    <p>
                                                        <a href="{!! url('admin/plugins/setting',$addon->slug) !!}"
                                                           class="btn btn-default">&nbsp;<i
                                                                    class="fa fa-cog"></i>&nbsp;</a>
                                                    </p>
                                                @endif
                                                <p>
                                                    @if($addon->enabled)
                                                        <a href="#" namespace="{!! $addon->namespace !!}" data-action="disable"
                                                           class="btn  btn-sm  m-b-5 p-l-20 p-r-20 width-150 text-left enb-disb deactivate"><i
                                                                    class="fa fa-power-off f-s-14 m-r-10"></i> Deactivate</a>
                                                    @else
                                                        <a href="#" namespace="{!! $addon->namespace !!}" data-action="enable" style="background: #7fff00;color: #000000"
                                                           class="btn  btn-sm  m-b-5 p-l-20 p-r-20 width-150 text-left  enb-disb"><i
                                                                    class="fa fa-plug f-s-14 m-r-10"></i>Activate</a>
                                                    @endif
                                                </p>

                                                    <a href="#" namespace="{!! $addon->namespace !!}"
                                                       class="btn  btn-sm  m-b-5 p-l-20 p-r-20 width-150 text-left delete del-module"><i
                                                                class="fa fa-trash-o f-s-14 m-r-10"></i> Delete</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div role="tabpanel" class="tab-pane" id="related_add_ons">...cc</div>
                    </div>

                </div>
            </div>
            @else
                <div class="row">
                    Extra Modules are empty
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="uploadfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Upload</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url'=>'/admin/modules/upload','class'=>'dropzone', 'id'=>'my-awesome-dropzone']) !!}

                    {!! Form::close() !!} </div>
            </div>
        </div>
    </div>
@stop
@section('CSS')
    {!! HTML::style('/public/libs/bootstrap-switch/css/bootstrap-switch.min.css') !!}
    {!! HTML::style('app/Modules/Modules/Resources/assets/css/store.css') !!}
@stop
@section('JS')
    {!! HTML::script('public/libs/dropzone/js/dropzone.js') !!}
    <script>

        Dropzone.options.myAwesomeDropzone = {

            init: function () {

                this.on("error", function(file, progress) {
                    alert('An Error occurred in Plugin, It can\'t be installed !');
                    location.reload();
                });

                this.on("success", function (file,progress) {
                    if(progress.error){
                        alert(progress.message);
                    }
                    location.reload();

                });

            }

        };

        $(document).ready(function () {
            $('body').on('click', '.del-module', function () {
                var namespace = $(this).attr('namespace');
                $.ajax({
                    url: '/admin/modules/delete',
                    data: {
                        namespace: namespace,
                        _token: $('#token').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (!data.error) {
                            location.reload();
                        } else {
                            $('#message-modal .modal-body').html(data.message);
                            $('#message-modal').modal();
                        }
                    },
                    type: 'POST'
                });
            });
            $('body').on('click', '.enb-disb', function () {
                var namespace = $(this).attr('namespace');
                var action=$(this).attr('data-action');
                $.ajax({
                    url: '/admin/modules/'+action,
                    data: {
                        namespace: namespace,
                        _token: $('#token').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (!data.error) {
                            location.reload();
                        } else {
                            $('#message-modal .modal-body').html(data.message);
                            $('#message-modal').modal();
                        }
                    },
                    type: 'POST'
                });
            });
        });

    </script>
@stop

