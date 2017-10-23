@extends('layouts.admin')
@section('content')
    <div class="col-xs-12">
        <span class="menuText">Core Modules</span>

        <button class="btn btn-sm btn-primary pull-right m-b-10" type="button" data-toggle="modal"
                data-target="#uploadfile">
            <i class="fa fa-upload"></i>
            &nbsp; Upload Module or Add on
        </button>

        <ul class="list-unstyled menuList" id="components-list">
            @foreach($modules as $module)
                <li>
                    <a href="javascript:void(0);" title="{!! $module->title !!}" class="createNew">
                    <span class="createNewCircle">
                        <em class="fa fa-share-square iconCreateNew"></em>
                    </span>
                        <span>{!! $module->title !!}</span>
                    </a>

                    <ul class="list-unstyled editIcons">
                        <li><a href="javascript:void(0);" class="blueCircle"><em class="icon iconPen"></em></a></li>
                        <li><a href="{!! url('admin/modules/view/'.$module->slug) !!}"
                               class="greenCircle preview-button"><em class="icon iconEye"></em></a></li>
                    </ul>
                </li>
            @endforeach
        </ul>
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
    {!! HTML::style('js/bootstrap-switch/css/bootstrap-switch.min.css') !!}
    {!! HTML::style('css/store.css') !!}
    <style>
        .createNewCircle {
            line-height: 207px;
        }

        .iconCreateNew {
            color: #19caff;
            font-size: 70px;
        }
    </style>
@stop
@section('JS')
    {!! HTML::script('js/dropzone/js/dropzone.js') !!}
    <script>

        Dropzone.options.myAwesomeDropzone = {

            init: function () {

                this.on("success", function (file) {

                    location.reload();

                });

            }

        };

    </script>
@stop

