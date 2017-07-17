@extends('layouts.admin')
@section('content')
    {!! HTML::style('/app/Modules/Resources/Resources/assets/css/new-store.css') !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row template-search">
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 template-search-box m-t-10 m-b-10">
                    <form class="form-horizontal">
                        <div class="form-group m-b-0">
                            <label for="inputEmail3" class="col-sm-2 control-label">Sort By</label>
                            <div class="col-sm-4">
                                <select class="form-control">
                                    <option>Recently Added</option>
                                </select>
                            </div>
                            <div class="col-sm-2 pull-right">
                                <a class="btn btn-default"><i class="fa fa-search f-s-15" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 template-upload-button p-l-0 p-r-0">
                    <button class="btn btn-sm  pull-right m-b-10 " type="button" data-toggle="modal"
                            data-target="#uploadfile">
                        <span class="module_upload_icon m-l-20"></span> <span class="upload_module_text">Upload</span>
                    </button>
                </div>
            </div>
            <div class="templates-list  m-t-20 m-b-10">
                <div class="row templates m-b-10">
                    {!! HTML::image('resources/assets/images/ajax-loader5.gif', 'a picture', array('class' => 'thumb img-loader hide')) !!}
                    <div class="raw tpl-list">
                        @include('modules::theme._partials.th_list')
                    </div>
                </div>
            </div>

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
                    {!! Form::open(['url'=>'/admin/modules/theme/upload','class'=>'dropzone', 'id'=>'my-awesome-dropzone']) !!}

                    {!! Form::close() !!} </div>
            </div>
        </div>
    </div>


@stop
@section('CSS')
    <style>
        .child-tpl {
            width: 95% !important;
        }

        .img-loader {
            width: 70px;
            height: 70px;
            position: absolute;
            top: 50px;
            left: 40%;
        }
    </style>
@stop
@section('JS')
    {!! HTML::script('resources/assets/js/dropzone/js/dropzone.js') !!}
    <script>
        Dropzone.options.myAwesomeDropzone = {
            init: function () {
                this.on("success", function (file) {
                    location.reload();
                });
            }
        };

        $(document).ready(function () {

            $("body").on("click", ".add-new-type", function () {
                $('#addNewType').modal();
            });

            $('body').on('click', '.del-tpl', function () {
                var slug = $(this).attr('slug');
                $.ajax({
                    url: '/admin/modules/theme/delete',
                    data: {
                        slug: slug,
                        _token: $('#token').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        location.reload();
                    },
                    type: 'POST'
                });
            });

        });
    </script>
@stop