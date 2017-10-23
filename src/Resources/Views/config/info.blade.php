@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <img src="{!! url('resources/assets/images/module.jpg') !!}" alt=""
                             class="img-rounded img-responsive"/>
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4>   {!!$module->name !!} Module </h4>
                        <small>{!!$module->author !!} </small>
                        <p>
                            <i class="glyfa fa fa-hashtag"></i>{!! $module->version !!}
                            <br/>
                            <i class="glyfa fa fa-globe"></i><a
                                    href="{!! @$module->author_site !!}"> {!! @$module->author_site !!}</a>
                            <br/>
                            <i class="glyfa fa fa-hourglass-end"></i>{!! BBgetDateFormat($module->created_at) !!}
                            <br/>
                            <i class="glyfa fa fa-pie-chart"></i>{!! @$module->description !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('CSS')
    <style>
        .glyfa {
            margin-bottom: 10px;
            margin-right: 10px;
        }

        small {
            display: block;
            line-height: 1.428571429;
            color: #999;
        }
    </style>
@stop