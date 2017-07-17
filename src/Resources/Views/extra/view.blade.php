@extends('layouts.admin')
@section('content')
    <div class="col-xs-12">
        <div class="col-xs-3">
            @foreach($modules as $m)
                <a href="{!! url('admin/modules/extra-view/'.$m['slug']) !!}">
                    <div class="module-item @if($m['slug'] == $module['slug']) active @endif">
                        {!! $m['name'] or $m['namespace'] !!}
                    </div>
                </a>
            @endforeach
        </div>
        <div class="col-xs-9">
            <div class="col-xs-12 module-preview m-b-30">
                <div class="col-xs-3 module-data">
                    <span class="m-title">{!! $module['name'] or $module['namespace'] !!}</span>
                </div>
                <div class="col-xs-6 module-data">
                    <div class="col-xs-12 m-desc">
                        {!! $module['description'] or "No Description" !!}
                    </div>
                    <div class="col-xs-6 h-50 m-desc-bottom">
                        {!! $module['author_site'] or "No author site" !!}
                    </div>
                    <div class="col-xs-6 h-50 m-desc-bottom">
                        {!! $module['version'] or "No Version" !!}
                    </div>
                </div>
                <div class="col-xs-2 module-data">
                    @if(isset($module['have_setting']) && $module['have_setting'] == 1)
                        <a href="{!! url('admin/plugins/setting',$module['slug']) !!}" class="btn btn-default btn-lg">&nbsp;<i
                                    class="fa fa-cog"></i>&nbsp;</a>
                    @endif
                </div>

            </div>
            @if(!empty($addons))
                <div class="col-xs-12">
                    @foreach($addons as $addon)
                        <div class="col-xs-12 addon-item">
                            <div class="col-xs-8">
                                <span class="addon-name">
                                    {!! $addon['name'] or $addon['namespace'] !!}
                                </span>
                            </div>
                            <div class="col-xs-4 pull-right">
                                @if(isset($addon['have_setting']) && $addon['have_setting']==1)
                                    <p>
                                        <a href="{!! url('admin/plugins/setting',$addon['slug']) !!}" class="btn btn-default">&nbsp;<i
                                                    class="fa fa-cog"></i>&nbsp;</a>
                                    </p>
                                @endif
                                <p> <a class="btn btn-warning">Deactivate</a> </p>
                                <p> <a  namespace="{!! $addon['namespace'] !!}" class="btn btn-danger del-module">Delete</a> </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@stop
@section('CSS')
    <style>
        .module-item {
            text-align: center;
            line-height: 40px;
            font-size: 20px;
            border-radius: 15px;
            background-color: #00abf5;
            color: white;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .active {
            background-color: #fed63b;
        }

        .module-preview {
            min-height: 200px;
            border: 1px solid;
            border-radius: 15px;
            background-color: #00abf5;
        }

        .module-data {
            border: 1px solid black;
            min-height: 150px;
            margin-top: 23px;
            margin-right: 2%;
            border-radius: 10px;
            text-align: center;
            background: #fed63b;
            color: white;
        }

        .m-title {
            line-height: 150px;
            font-size: 20px;
            font-weight: bold;
        }

        .m-desc {
            font-size: 17px;
            min-height: 110px;
        }
        .m-desc-bottom{
            border: 1px solid black;
            border-radius: 10px;
            min-height: 25px;
        }
        .addon-item{
            border-bottom: 3px solid black;
        }
        .addon-name{
            min-height: 100px;
            line-height: 90px;
            font-size: 20px;
            font-weight: bold;
            background-color: #bbd0ca;
            padding: 30px;
            border-radius: 15px;
        }
    </style>
@stop
@section('JS')
    <script>
        $(document).ready(function(){
            $('body').on('click','.del-module',function(){
                var namespace = $(this).attr('namespace');
                $.ajax({
                    url: '/admin/modules/delete',
                    data: {
                        namespace: namespace,
                        _token: $('#token').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        if(! data.error){
                            location.reload();
                        }else{
                            $('#message-modal .modal-body').html(data.message);
                            $('#message-modal').modal();
                        }
                    },
                    type: 'POST'
                });
            });
        });

@stop

