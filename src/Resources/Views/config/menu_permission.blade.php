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
    </div>
@stop
@push('css')
    {!! HTML::style('css/admin_pages.css') !!}
@endpush