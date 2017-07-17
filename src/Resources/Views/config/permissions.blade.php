@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12 p-0">
            <table class="table table-bordered" id="tpl-table">
                <thead>
                <tr class="bg-black-darker text-white">
                    <th></th>
                    @foreach($roles as $k=>$role)
                        <th>{!! $k !!}</th>
                @endforeach
                </thead>
                <tbody>

                <tr>
                    <th>View {!! $menu['title']!!} Module</th>
                    @foreach($roles as $k=>$role)
                        <td>{!! Form::checkbox($role) !!}</td>
                    @endforeach
                </tr>
                @foreach($menu['children'] as $menu)
                    <tr>
                        <td>{!! $menu['title'] !!}</td>
                        @foreach($roles as $k=>$role)
                            <td>{!! Form::checkbox($role) !!}</td>
                        @endforeach
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>


        <div class="col-md-12 p-0">
            <table class="table table-bordered" id="tpl-table">

                <tbody>
                <tr>
                    <th>Function 1</th>
                    @foreach($roles as $k=>$role)
                        <td>{!! Form::checkbox($role) !!}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Create</td>
                    @foreach($roles as $k=>$role)
                        <td>{!! Form::checkbox($role) !!}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Edit</td>
                    @foreach($roles as $k=>$role)
                        <td>{!! Form::checkbox($role) !!}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>delete</td>
                    @foreach($roles as $k=>$role)
                        <td>{!! Form::checkbox($role) !!}</td>
                    @endforeach
                </tr>

                </tbody>
            </table>
        </div>

        <div class="col-md-12 p-0">
            @if(count($files))
                @foreach($files as $key => $file)
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 panels_wrapper">
                        <div class="panel panel-default panels accordion_panels">
                            <div class="panel-heading bg-black-darker text-white"  role="tab" id="headingLink{{ $key }}">
                                <span  class="panel_title">{{ $file->getBasename('.blade.php') }}</span>
                                <a role="button" class="panelcollapsed collapsed" data-toggle="collapse"
                                   data-parent="#accordion" href="#collapseLink{{ $key }}" aria-expanded="true" aria-controls="collapseLink{{ $key }}">
                                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                </a>
                                <ul class="list-inline panel-actions">
                                    <li><a href="#" panel-fullscreen="true" role="button" title="Toggle fullscreen"><i class="glyphicon glyphicon-resize-full"></i></a></li>
                                </ul>
                            </div>
                            <div id="collapseLink{{ $key }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingLink">
                                <div class="panel-body panel_body panel_1 show">

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>
@stop
@push('css')
{!! HTML::style('resources/assets/css/admin_pages.css') !!}
@endpush